# Email security and SMTP sending for the contact form API

Question: when we wire up real mail delivery in `public/api/src/Handlers/ContactHandler.php`
(currently it only `error_log()`s the submission — see [Gap] below), what do we
need to get right on (1) input/header injection safety, (2) how to actually
send SMTP mail from PHP, and (3) is the existing request pipeline
(`SameOriginGuard` → `CapVerifier` → handler) sound enough to build on?

## Summary / recommendation

- **Use PHPMailer (`phpmailer/phpmailer`) via SMTP, not raw `mail()`.** This
  repo's Composer setup (PSR-4 autoloading only, zero deps today, PHP 8.1+,
  static-tar+scp deploy) needs one straightforward transactional send with no
  templating engine and no framework container. PHPMailer's SMTP mode
  (`isSMTP()`, `SMTPAuth`, `Host`/`Port`/`SMTPSecure`) is a ~10-line, no-config
  solution to exactly that. Symfony Mailer is equally capable and equally
  well maintained, but its natural idiom (DSN via framework config, Twig
  `BodyRenderer` for HTML bodies) assumes more scaffolding than a single
  contact form needs — see the decision table in §2.
- **Never build headers by hand.** Whichever library is used, let it own
  header construction (`From`/`To`/`Subject`/body). The vulnerability this
  guards against is CRLF/header injection, and it's a solved problem once you
  stop concatenating user input into raw header strings — see §1.
- **Validate server-side regardless of the client and regardless of
  CAPTCHA.** `SameOriginGuard` (Origin-header check) and `CapVerifier` (Cap
  CAPTCHA) in `public/api/index.php` run *before* `ContactHandler::handle()`
  and are good, real defenses — but they answer "is this a legitimate
  same-origin, non-bot POST?", not "is this specific field a valid email
  address / free of control characters?". `ContactHandler` must still run
  `filter_var($email, FILTER_VALIDATE_EMAIL)` and reject/strip `\r`/`\n`
  itself. This is OWASP's defense-in-depth principle, not redundancy — see §1
  and §3.
- **Credentials go in real environment variables, not committed `.env`
  files, and no secrets manager is needed at this scale.** This matches the
  framing already written into `public/api/index.php`'s own comment: the
  `.env` loader there is a dev/local convenience one level above the web
  root, and "real server env vars still work as a fallback in production."
  That's exactly the split the Twelve-Factor App's Config factor and
  phpdotenv's own README describe — see §2.
- **The existing pipeline order is sound and matches recognized practice**:
  Origin check → CAPTCHA → per-field validation, all server-side, is a
  correct defense-in-depth stack for a form with no session/cookie auth. The
  one gap worth flagging (not fixing now): no rate limiting beyond CAPTCHA.
  Treat that as a "consider later" item, not a blocker — see §3.

**[Gap noticed while reading the code]:** `ContactHandler::handle()`
currently has no mail transport at all — it validates required fields, then
`error_log()`s the submission and returns `[]`. The `ponytail:` comment on
line 22 says as much ("no mail transport wired up yet, just logs — add
mail()/SMTP once the real contact form UI and delivery requirements exist").
So this doc is forward-looking research for that not-yet-written code, not a
review of an existing mail-sending implementation.

**[Gap noticed in CI]:** `.gitea/workflows/deploy.yml` already has a
`composer install --no-dev --no-interaction --optimize-autoloader` step
(`working-directory: public/api`), running *before* `bun run build`. Astro
copies `public/` into `dist/` verbatim during build, so `vendor/` installed
at that point is already included in `dist.tar.gz` by the time it's
archived. **Adding a first real Composer dependency requires no new CI
step** — the pipeline already installs and ships whatever `composer.json`
declares.

---

## 1. Email/text field injection risks in PHP, and mitigations

### Header injection ("CRLF injection") via PHP's `mail()`

PHP's own `mail()` manual page documents the exact failure mode in the
`$additional_headers` parameter description:

> "Multiple extra headers should be separated with a CRLF (`\r\n`). If
> outside data are used to compose this header, the data should be sanitized
> so that no unwanted headers could be injected."
([PHP Manual — `mail()`](https://www.php.net/manual/en/function.mail.php))

A well-known user-contributed note on the same page adds the mechanically
important detail: `mail()` itself scrubs `\r`/`\n` out of the `$to` and
`$subject` parameters (converting them to spaces), but it does **not** touch
`$additional_headers` — that string is passed through verbatim. Concretely,
code like:

```php
$headers = "From: " . $_POST['email'] . "\r\n";
mail($to, $subject, $body, $headers);
```

lets an attacker submit an email value of
`victim@example.com\r\nBcc: attacker@evil.com` and inject an arbitrary extra
header (`Bcc`, additional `To`, even a second `Subject` that overrides the
real one) — turning a contact form into an open spam relay. This exact
attack class — injecting protocol control sequences into a field destined
for a mail header — is documented by OWASP's Web Security Testing Guide as
["Testing for IMAP/SMTP Injection"](https://github.com/OWASP/wstg/blob/master/document/4-Web_Application_Security_Testing/07-Input_Validation_Testing/10-Testing_for_IMAP_SMTP_Injection.md),
which frames it as: input data used to build mail server commands/headers
that isn't sanitized lets an attacker inject arbitrary IMAP/SMTP protocol
content.

**Mitigations, in order of how much they buy you:**

1. **Strict format validation on the email field**: `filter_var($email,
   FILTER_VALIDATE_EMAIL)` ([PHP Manual —
   `filter_var()`](https://www.php.net/manual/en/function.filter-var.php),
   [PHP Manual — Validate
   filters](https://www.php.net/manual/en/filter.filters.validate.php)). A
   syntactically valid email address per this filter cannot contain
   `\r`/`\n` (they're never valid `addr-spec` characters), so this alone
   closes the header-injection door for the email field specifically. Note
   PHP's own manual page carries user notes that `FILTER_VALIDATE_EMAIL`
   is stricter/looser than the various email RFCs in a few edge cases
   (rejects some technically-legal quoted/comment forms, e.g.
   `"this is v@lid!"@example.com`) — acceptable for a public contact form,
   where the cost of a false rejection (ask the user to retype) is far lower
   than the cost of not validating.
2. **Reject or strip `\r`/`\n` from any field that could ever end up in a
   header context** (name, subject if user-suppliable) — belt-and-suspenders
   even where format validation already implies it, since a future code
   change could feed the field into a header without knowing that.
3. **Don't build headers/messages by hand at all.** The modern, actually
   recommended answer (see §2) is to use a mail library (PHPMailer, Symfony
   Mailer) that builds the MIME message and headers internally through typed
   setters (`$mail->addAddress($email)`, `->setFrom(...)`) rather than string
   concatenation — the library owns CRLF-safety for you and this class of
   bug stops being something the application code can get wrong.

### XSS / script injection if fields are ever redisplayed

If `name` or `message` are ever echoed back — an admin-facing view of
submissions, a "we received your message" confirmation page, or an **HTML**
notification email body — unescaped user input becomes a stored/reflected
XSS vector. OWASP's Cross-Site Scripting Prevention Cheat Sheet's core rule:
"any variable that does not go through this [validate, then contextually
encode/escape] process is a potential weakness," with context-specific
encoding required for each sink (HTML body → HTML entity encoding, HTML
attribute → attribute encoding, etc.), and explicitly notes output encoding
is necessary but not sufficient in some "dangerous contexts" (raw
`<script>`, inline event handlers). ([OWASP Cheat Sheet Series — XSS
Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html))

**The HTML-body vs plain-text-body distinction matters concretely here.**
Both major PHP mail libraries model a message as having a separate plain
text part and an optional HTML part:

- PHPMailer: `$mail->Body` is the HTML body when `$mail->isHTML(true)` is
  set; `$mail->AltBody` is the plain-text fallback rendered for clients that
  don't render HTML — PHPMailer's own README examples set both explicitly
  when sending HTML mail.
- Symfony Mailer: `Email::html()` sets the HTML part, `Email::text()` sets
  the plain-text part — both documented directly in its [mailer
  guide](https://symfony.com/doc/current/mailer.html), which shows a minimal
  send using `->text(...)->html(...)` together.

If the contact-form notification email is composed as **plain text only**
(`->text($message)` / `AltBody`-only, no `isHTML(true)` / no `->html(...)`
call), then interpolating the raw `message` field into that body carries no
HTML-injection risk at all — a mail client rendering a `text/plain` part
does not interpret `<script>` or `<img onerror=...>` as markup. The risk
only exists if/when a field is placed into an **HTML** body or an **HTML
page** (admin view, confirmation page) without escaping. For this repo's
contact form, sending a plain-text notification email sidesteps the whole
class of risk for the email body specifically — only a future HTML admin
view or HTML confirmation page would need the OWASP HTML-encoding rule
applied.

### General input validation

PHP's `filter_var()`/`filter_input()` family (cited above) is the standard
built-in mechanism for validating scalar input against a named filter
(`FILTER_VALIDATE_EMAIL`, `FILTER_VALIDATE_INT`, etc.) rather than hand-rolled
regexes. OWASP's Input Validation Cheat Sheet states the same allow-list
principle used throughout this doc:

> "Allowlist validation involves defining exactly what IS authorized, and by
> definition, everything else is not authorized" — deny-listing ("block
> known-bad characters") is explicitly called out as easy to bypass and
> prone to false positives (e.g. rejecting a legitimate surname like
> "O'Brian").

It also states plainly that server-side validation is non-negotiable: client
validation "can be circumvented by an attacker who disables JavaScript or
uses a web proxy" — client-side checks are a UX convenience layered on top,
never the security boundary. ([OWASP Cheat Sheet Series — Input
Validation](https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html))

### Confirming this repo's layering is defense-in-depth, not redundancy

Reading `public/api/index.php`'s actual dispatch order: `SameOriginGuard`
runs first (rejects non-same-origin requests before the body is even
parsed for form data), then `CapVerifier::verify()` runs against
`$data['cap-token']` (rejects non-human submissions), and only then does
`Dispatcher::dispatch()` hand `$data` to `ContactHandler::handle()`. Today,
`ContactHandler` checks only that `name`/`email`/`message` are non-empty
after `trim()` — it does **not** call `filter_var($email,
FILTER_VALIDATE_EMAIL)` or reject `\r`/`\n`. That's a real gap to close when
mail sending is added: Origin-checking and CAPTCHA answer "is this a
same-origin, non-bot request?" — neither one inspects whether the `email`
field is a syntactically valid address free of control characters. This is
exactly OWASP's defense-in-depth framing: multiple independent layers, each
answering a different question, none of them a substitute for the others.

---

## 2. SMTP sending from PHP — best practices

### Raw `mail()` vs a real SMTP library

`public/api/composer.json` currently declares zero `require` entries beyond
`php: >=8.1` — adding a mail library is this repo's first real Composer
dependency, worth deciding deliberately rather than defaulting to
`mail()` because it needs no dependency.

**Why raw `mail()` is a poor fit for this deploy target specifically:**
PHP's own `mail.configuration` manual page documents the `SMTP` and
`smtp_port` `php.ini` directives ("Windows only") that let `mail()` relay
through an SMTP server on Windows; on Unix/Linux, `mail()` instead shells
out to a local MTA via the `sendmail_path` directive (default
`/usr/sbin/sendmail -t -i`). ([PHP Manual — Mail
configuration](https://www.php.net/manual/en/mail.configuration.php)) In
other words, `mail()`'s ini-level "just point it at an SMTP server" knob
**does not exist on Linux** — the only way to get `mail()` to relay through
an authenticated remote SMTP server (needed for any real deliverability —
SPF/DKIM-aligned sending, a mail provider requiring auth) on a Linux host is
to have a local MTA (Postfix/Exim/sendmail) installed and configured to
relay outbound, which is infrastructure this repo's static-tar+scp deploy
model has no mechanism to provision or configure. A PHP-level SMTP client
library needs no local MTA and no host-level mail configuration at all —
it opens the SMTP connection itself.

### PHPMailer

[`PHPMailer/PHPMailer`](https://github.com/PHPMailer/PHPMailer) is actively
maintained: latest release `v7.1.1`, published 2026-05-18 (per the GitHub
Releases API). Install:

```
composer require phpmailer/phpmailer
```

(current major is `^7.0`, per its own README's Composer instructions).
Minimal SMTP-with-auth send, per PHPMailer's own README/docs pattern:

```php
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.example.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'user@example.com';
$mail->Password   = 'secret';
$mail->Port       = 465;
$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;

$mail->setFrom('noreply@erlich-fliesen.de');
$mail->addAddress('office@erlich-fliesen.de');
$mail->Subject = 'Contact form submission';
$mail->Body    = $message; // plain text, or ->isHTML(true) + AltBody, see §1
$mail->send();
```

### Symfony Mailer

[`symfony/mailer`](https://symfony.com/doc/current/mailer.html) is equally
current and actively maintained as part of the Symfony components. Install:

```
composer require symfony/mailer
```

Symfony's own docs confirm standalone use outside a full Symfony
application — the Components docs page states the transport can be built
directly via `Transport::fromDsn()` with no framework/container involved
([Symfony Components —
Mailer](https://symfony.com/doc/current/components/mailer.html)):

```php
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

$transport = Transport::fromDsn('smtp://user:pass@smtp.example.com:587');
$email = (new Email())
    ->from('noreply@erlich-fliesen.de')
    ->to('office@erlich-fliesen.de')
    ->subject('Contact form submission')
    ->text($message);
$transport->send($email);
```

This is genuinely comparable in size to the PHPMailer example — the
difference is architectural, not line-count: Symfony Mailer's natural home
is DSN-string config wired through a framework container
(`framework.mailer.dsn` + `%env(MAILER_DSN)%`), and its HTML-body story
(`BodyRenderer` + Twig, per the main mailer guide) assumes a templating
engine this repo doesn't have and doesn't need for one notification email.
Using it standalone means opting out of most of what makes it "Symfony
Mailer" rather than "a DSN-parsing SMTP client."

### CI: does adding a Composer dependency need a new CI step?

No. `.gitea/workflows/deploy.yml`'s `build` job already runs:

```yaml
- name: Install API dependencies
  run: composer install --no-dev --no-interaction --optimize-autoloader
  working-directory: public/api
```

This runs before `bun run build`, and Astro's build copies `public/`
verbatim into `dist/` — so `public/api/vendor/` (installed by that existing
step) is already present in `dist/api/vendor/` by the time `tar -czf
dist.tar.gz dist/` runs. Adding `phpmailer/phpmailer` (or `symfony/mailer`)
to `public/api/composer.json` is picked up by the existing `composer
install` step with zero workflow changes.

### Recommendation: PHPMailer

For "one straightforward SMTP send, no queueing, no templating system
needed," on PHP 8.1+, with Composer already present purely for PSR-4
autoloading, and deploy via static tar+scp: **PHPMailer fits better.** It's
purpose-built as a standalone mail-sending library — `new PHPMailer()`,
configure SMTP properties, `send()` — with no framework-shaped configuration
surface to opt out of. Symfony Mailer is not worse engineering, but its
idiomatic usage (DSN pulled from framework config, HTML rendering via Twig
`BodyRenderer`) is scaffolding this task doesn't need; using it standalone
means fighting its own docs' primary usage pattern to get the same handful
of lines PHPMailer gives you natively.

### Decision table

| | Maintenance status | Composer install | TLS/auth support | Minimal-code fit for one contact form | Verdict |
|---|---|---|---|---|---|
| **PHPMailer** | Active — v7.1.1, 2026-05-18 ([releases](https://github.com/PHPMailer/PHPMailer/releases)) | `composer require phpmailer/phpmailer` | Native `SMTPSecure` (STARTTLS/SMTPS) + `SMTPAuth`/`Username`/`Password` | Excellent — ~10 lines, no config framework needed | **Recommended** |
| **Symfony Mailer** | Active — core Symfony component, same release cadence as Symfony itself | `composer require symfony/mailer` | Native via DSN scheme (`smtp://`), auth embedded in DSN | Good, but idiom assumes framework config + Twig for HTML bodies; standalone use fights the grain | Solid alternative if this repo later adopts more Symfony components |
| **Raw `mail()`** | N/A (PHP core) | None | None at the language level — `SMTP`/`smtp_port` ini directives are **Windows-only**; Linux path requires a configured local MTA | Trivial code, but wrong deploy fit (no local MTA in this deploy model) and requires hand-rolled CRLF-safe header building | **Not recommended** for this deploy target |

### Credential storage

The Twelve-Factor App's Config factor is unambiguous: config that varies
across deploys — including credentials — belongs in environment variables,
not in code or checked into version control, because "a codebase with
embedded credentials cannot safely be made open source" and because env
vars are "language- and OS-agnostic" (no framework-specific config file
format to keep in sync). ([12factor.net —
Config](https://12factor.net/config))

`vlucas/phpdotenv`'s own README doesn't draw a hard "never in production"
line, but its own pitch is explicitly about **local development
convenience** — "NO editing virtual hosts in Apache or Nginx; NO adding
`php_value` flags to `.htaccess` files; EASY portability and sharing of
required ENV values" — i.e., it exists to avoid needing real server-level
env var configuration *during development*, which only makes sense as a
statement if real env vars are the assumed production mechanism.
([`vlucas/phpdotenv` README](https://github.com/vlucas/phpdotenv))

This matches, almost verbatim, the comment already written into
`public/api/index.php`:

```php
// Loads KEY=VALUE lines from a .env file that must live outside public/
// ...No-op if the file doesn't exist, so real server env
// vars still work as a fallback in production.
```

i.e., this repo's own `.env` loader is already scoped as a dev/local
convenience with production env vars as the real mechanism — no change
needed here, just confirmation the planned approach (`CAP_SECRET_KEY` today,
SMTP credentials tomorrow, both via `getenv()`) is correct as designed.

**Is a secrets manager (Vault, cloud KMS, etc.) overkill here? Yes.** A
single small commercial site's SMTP password, set as a real environment
variable on the one deploy host via the process manager / systemd unit /
web server vhost config (the same mechanism `CAP_SECRET_KEY` already
presumably uses in production), meets the Twelve-Factor bar already: it's
out of code, out of VCS, and not shared across unrelated deploys. A secrets
manager earns its cost when you have multiple services/environments needing
centralized rotation, audit trails, or dynamic short-lived credentials —
none of which apply to one PHP script's static SMTP password on one host.

---

## 3. Verify the overall architecture is sound

### Client-side validation is UX, not a boundary

OWASP's Input Validation Cheat Sheet (cited in §1) states this directly:
client-side (JavaScript) validation "can be circumvented by an attacker who
disables JavaScript or uses a web proxy" — the server is unconditionally the
authority. Any client-side checks this site's contact form has (required
fields, email pattern) are convenience only; the real validation is whatever
runs in PHP.

### Does the existing pipeline match recognized best practice?

Reading `public/api/index.php` top to bottom, the actual order is:

1. `.env` loaded (dev convenience, no-op in prod if absent) →
2. `SameOriginGuard::isSameOrigin()` — reject anything without a matching
   `Origin` header, before the request body is even parsed for handler
   data →
3. Body JSON-decoded, `CapVerifier::verify()` checked against
   `$data['cap-token']` — reject non-human submissions, fail closed if
   `CAP_SECRET_KEY` isn't configured (per the `ponytail:` comment in
   `CapVerifier.php`) →
4. `Dispatcher::dispatch($key, $data)` → `ContactHandler::handle($data)` —
   per-field validation happens here (today: non-empty checks; should grow
   to include `FILTER_VALIDATE_EMAIL` + CRLF rejection per §1 once mail
   sending is wired up).

This is all server-side PHP, and each stage answers a distinct question
(origin legitimacy → humanness → data shape) rather than one stage doing
everyone's job. That is exactly OWASP's defense-in-depth pattern and matches
recognized practice — **no architectural gap in the ordering itself.** The
one concrete gap (§1) is that step 4 doesn't yet do the field-level
validation the architecture already has a home for.

### Is Origin-header checking an accepted CSRF-adjacent mitigation?

Yes, with the limitations OWASP itself names. The CSRF Prevention Cheat
Sheet lists Origin/Referer verification under "Defense in Depth Techniques"
(not the primary recommended mitigation, which is token-based) — server
compares the `Origin` (or `Referer`) header against the expected target
origin, accepting on match and rejecting otherwise, but flags real
limitations: `Origin` can be legitimately absent/`null` in some privacy
contexts, and `Referer` is frequently stripped by browsers/proxies/privacy
tools. ([OWASP Cheat Sheet Series — Cross-Site Request Forgery
Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html))

`SameOriginGuard`'s own code comment is aware of exactly this nuance and
resolves it in the strict direction: it rejects a request with **no**
`Origin` header at all, reasoning that a same-origin `fetch()` POST always
carries one (per the Fetch spec), so a missing header means "not a browser
fetch from this site" rather than a legitimate edge case to allow through.
That's a defensible, deliberately strict reading — the cheat sheet's
"`Origin` can legitimately be null" caveat is about *some* cross-origin or
privacy-mode requests still needing to be let through for other kinds of
apps; a same-origin-only JSON API with no legitimate cross-origin caller has
no reason to accept a missing `Origin`.

**Why this matters more here, not less, given there's no session/cookie
auth:** the classic CSRF threat model is "attacker's page makes the victim's
browser send an authenticated request using the victim's session cookie,"
and the standard modern mitigation for that is the `SameSite` cookie
attribute. This form has **no session, no cookie, no ambient
authentication** — a cross-site request to this endpoint carries no
credential worth forging on the victim's behalf, so the traditional
"CSRF" framing (steal the victim's authority) doesn't strictly apply.
What Origin-checking is actually defending against here is closer to
**unauthorized cross-origin use of the endpoint** (someone else's page
silently submitting to this site's contact-form API, e.g. to abuse it as a
spam relay or scrape a rate-limited resource) — a real concern for a public
POST endpoint, just not literally "CSRF" in the session-riding sense. Origin
checking is the right tool for that concern regardless of what it's called.

### Rate limiting / anti-spam beyond CAPTCHA

Not found as a hard requirement in the primary sources consulted for this
doc (OWASP's CSRF and Input Validation cheat sheets don't mandate it for
non-authenticated public forms specifically) — flagging this only as a
**consider-later** item, not a gap to fix now: a public contact-form
endpoint protected by CAPTCHA is already resistant to the most common abuse
(scripted bulk spam), and adding IP- or token-based rate limiting on top is
reasonable defense-in-depth if abuse is observed in practice, not something
to build speculatively ahead of evidence it's needed.
