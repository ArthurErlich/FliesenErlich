# WCAG 2.2 AA + BFSG compliance — primary-source reference

Research note for FliesenErlich (German commercial Fliesen-/Natursteinleger site,
Astro + Tailwind). Every claim below is sourced to a primary document — W3C WCAG 2.2
spec/quickref, WAI-ARIA APG, MDN, or gesetze-im-internet.de. No secondary/blog
summaries were used. Contrast ratios are computed by hand from the site's own hex
values using the WCAG relative-luminance/contrast formula (method shown below), not
guessed or pulled from a tool whose working can't be shown here.

This is a content/requirements reference, distinct from
`docs/research/wcag-german-law-skill.md` (which evaluates third-party _Claude Skills_
for accessibility/legal tooling, not the actual WCAG/BFSG requirements).

## 1. New in WCAG 2.2 (vs 2.1)

Per the W3C spec's own "New Features in WCAG 2.2" section, exactly **9 success
criteria** were added in 2.2 — none existed in 2.1:
<https://www.w3.org/TR/WCAG22/#new-features-in-wcag-2-2>

| SC     | Name                                 | Level |
| ------ | ------------------------------------ | ----- |
| 2.4.11 | Focus Not Obscured (Minimum)         | AA    |
| 2.4.12 | Focus Not Obscured (Enhanced)        | AAA   |
| 2.4.13 | Focus Appearance                     | AAA   |
| 2.5.7  | Dragging Movements                   | AA    |
| 2.5.8  | Target Size (Minimum)                | AA    |
| 3.2.6  | Consistent Help                      | A     |
| 3.3.7  | Redundant Entry                      | A     |
| 3.3.8  | Accessible Authentication (Minimum)  | AA    |
| 3.3.9  | Accessible Authentication (Enhanced) | AAA   |

Normative text, quickref: <https://www.w3.org/WAI/WCAG22/quickref/?versions=2.2&levels=aa>

- **2.4.11 Focus Not Obscured (Minimum) — AA**: "When a user interface component
  receives keyboard focus, the component is not entirely hidden by author-created
  content." Relevant if this site ever adds a sticky header/cookie-banner that could
  cover a focused element.
- **2.5.7 Dragging Movements — AA**: "All functionality that uses a dragging movement
  for operation can be operated by a single pointer without dragging, unless dragging
  is essential." No drag interactions currently exist on this site (marketing
  pages + a form) — note only if a gallery/slider with drag is added later.
- **2.5.8 Target Size (Minimum) — AA**: "The size of the target for pointer input is
  at least 24 by 24 CSS pixels" except where an equivalent same-size control exists
  elsewhere, the target is inline text, size is user-agent-controlled, or a specific
  size is essential. Applies to nav links, buttons, form controls, and any icon
  links (e.g. the external-link icon in `public/media/icons/ExternalLink.svg`).
- **3.2.6 Consistent Help — A**: if a help mechanism (contact link, help text) repeats
  across pages, it must occur in the same relative order/position on each page.
  Relevant once the Kontakt link/CTA appears across templates — keep its
  header/footer position consistent.
- **3.3.7 Redundant Entry — A**: "Information previously entered by the user is
  either auto-populated or available for selection, except when re-entering the
  information is essential or a security measure is necessary." Low relevance for a
  single-step contact form (no multi-step flow re-asking the same data yet).
- **3.3.8 Accessible Authentication (Minimum) — AA**: "A cognitive function test is
  not required for any step in an authentication process unless" an alternative
  method or an assistive mechanism is provided. **Directly relevant to the planned
  Cap.js CAPTCHA** on the contact form (see §3 below) — a CAPTCHA that demands a
  cognitive test (e.g. reading distorted text) without an accessible alternative can
  fail this criterion; Cap.js's proof-of-work approach (no puzzle-solving by the user)
  is inherently friendlier to this SC than image/text CAPTCHAs, but the actual
  widget's keyboard/screen-reader behavior still needs verification once built.

## 2. Core AA criteria most relevant to this site

All quotes: W3C WCAG 2.2 quickref, filtered to AA:
<https://www.w3.org/WAI/WCAG22/quickref/?versions=2.2&levels=aa>

- **1.4.3 Contrast (Minimum) — AA**: "The visual presentation of text and images of
  text has a contrast ratio of at least 4.5:1" (3:1 for large text ≥18pt or ≥14pt
  bold), with exceptions for incidental/decorative text and logotypes.
- **1.4.11 Non-text Contrast — AA**: "Visual presentation of user interface
  components and graphical objects have a contrast ratio of at least 3:1 against
  adjacent colors" (excludes inactive/disabled controls and purely decorative
  graphics). Applies to input borders, focus outlines, icons, button boundaries.
- **2.1.1 Keyboard — A** (not AA, but foundational and explicitly requested): "All
  functionality of the content is operable through a keyboard interface without
  requiring specific timings for individual keystrokes," except where the underlying
  function requires path-dependent input (e.g. freehand drawing).
- **2.4.7 Focus Visible — AA**: "Any keyboard operable user interface component has
  an operating mode where the keyboard focus indicator is visible." W3C's own
  sufficient-technique guidance: rely on browser default focus rings, or replace them
  with a custom style that remains visibly distinguishable — **never `outline: none`
  with no visible replacement.** Source: quickref entry for 2.4.7,
  <https://www.w3.org/WAI/WCAG22/quickref/#focus-visible>.
- **4.1.2 Name, Role, Value — Level A** (core, not AA — included per request; note
  the level correction: this SC is A, not AA): "For all user interface components
  ... the name and role can be programmatically determined; states, properties, and
  values that can be set by the user can be programmatically set; and notification of
  changes to these items is available to user agents, including assistive
  technologies." Directly governs custom form widgets (e.g. any styled
  checkbox/select replacing a native control) and the CAPTCHA widget needing an
  accessible name. Source: <https://www.w3.org/WAI/WCAG22/quickref/#name-role-value>.
- **3.3.1 Error Identification — A**: "If an input error is detected, the item that
  is in error is identified and the error is described to the user in text."
- **3.3.3 Error Suggestion — AA**: "If an input error is detected and suggestions for
  correction are known, then the suggestions are provided to the user, unless it
  would jeopardize the security or purpose of the content" (the security exception is
  relevant to honeypot/anti-spam fields — don't reveal _why_ a submission was
  rejected if it would help a bot/spammer probe the honeypot).
- **1.3.1 Info and Relationships — A**: "Information, structure, and relationships
  conveyed through presentation can be programmatically determined or are available
  in text" — governs using real `<label>`, `<fieldset>/<legend>`, heading tags, and
  landmark elements rather than styled `<div>`s that only _look_ structured.
- **2.4.6 Headings and Labels — A**: "Headings and labels describe topic or purpose."

## 3. Semantic HTML / structure checklist (APG + MDN)

**Landmarks** — WAI-ARIA APG, Landmark Regions pattern:
<https://www.w3.org/WAI/ARIA/apg/practices/landmark-regions/>

- One `banner` landmark per page — native `<header>` as a direct child of `<body>`
  gets this role automatically; typically holds the logo/site identity and top-level
  nav.
- One `main` landmark per page via `<main>` — the primary page content.
- `navigation` landmarks (`<nav>`) for link groups; if more than one exists (e.g. a
  header nav and a footer nav), each needs a distinct accessible name (e.g.
  `aria-label="Hauptnavigation"` vs `aria-label="Footer"`) so assistive tech can tell
  them apart.
- One `contentinfo` landmark via `<footer>` as a direct child of `<body>` — holds
  copyright, and per the APG description explicitly "links to privacy and
  accessibility statements," which maps directly onto this site's Impressum/
  Datenschutz/Barrierefreiheitserklärung footer links.
- Prefer native HTML landmark elements over explicit ARIA roles — APG's own guidance:
  "native HTML preferred... over ARIA when possible."

**Skip link** — W3C sufficient technique G1, which satisfies SC 2.4.1 Bypass Blocks:
<https://www.w3.org/WAI/WCAG22/Techniques/general/G1>

- Add a link as the first focusable element on each page that jumps straight to the
  `<main>` content, visible at least on keyboard focus. This site's `Layout.astro`
  (used by every page) is the right place to add this once, rather than per-page.

**Form labeling** — MDN, Text labels and names:
<https://developer.mozilla.org/en-US/docs/Web/Accessibility/Guides/Understanding_WCAG/Text_labels_and_names>

- Every input/textarea/select needs a real, visible `<label>`, associated either by
  wrapping the input or via `for`/`id` — MDN's explicit warning: **don't rely on
  `placeholder` as a label substitute** — it disappears once the user types and isn't
  reliably exposed to assistive tech.
- Group related controls (e.g. a radio set for "type of quote requested," if the
  Kontakt form has one) in `<fieldset>` + `<legend>`, not just visual proximity.
- MDN ties this to WCAG SC 2.4.4 (Link Purpose) and 1.1.1 (Non-text Content) for any
  icon-only control (e.g. a submit button rendered as an icon).

**Heading hierarchy** — governed by 1.3.1 Info and Relationships and 2.4.6 Headings
and Labels (§2 above): one `<h1>` per page, no skipped levels, headings describing
the section that follows rather than styled for visual size alone.

**Astro-specific note**: Astro's own docs do not currently publish a dedicated
general accessibility guide (checked via the official Astro MCP docs search and
`docs.astro.build/en/guides/accessibility/`, which 404s). The one accessibility
feature Astro ships and documents is in View Transitions — route announcement via
`aria-live="assertive"` on navigation and automatic `prefers-reduced-motion` handling
in `<ClientRouter />` — not applicable unless this site adopts client-side routing.
Source: <https://docs.astro.build/en/guides/view-transitions/#accessibility>. For
everything else (landmarks, labels, focus), this site is on standard HTML/WCAG
guidance, not an Astro-specific abstraction.

## 4. Contact form checklist (`src/pages/kontakt.astro`)

Per CLAUDE.md, this form is static Astro markup with a client-side `fetch()` to an
external microservice that isn't built yet, gated by a honeypot field and a Cap.js
proof-of-work CAPTCHA. Concrete implications:

- **Labels (1.3.1, MDN)**: every field (name, email, message, whatever fields it
  collects) needs a real associated `<label>`, not placeholder-only text.
- **Errors (3.3.1 Error Identification, A)**: client-side validation failures (e.g.
  invalid email) must identify _which_ field failed and describe the problem in text
  — not just a color change or an icon with no text alternative.
- **Error suggestions (3.3.3, AA)**: where a correction is knowable (e.g. "email must
  contain @"), say so in text — but per the SC's own security carve-out, don't do
  this for the honeypot field or in a way that tells a bot/spam script why its
  submission was rejected.
- **Honeypot field**: must be hidden from sighted _and_ assistive-tech users without
  being reachable by keyboard tab order (typically `aria-hidden="true"` plus
  `tabindex="-1"` and either `display:none`/`visibility:hidden`, or off-screen
  positioning — a bare CSS `display:none` on the field itself is standard and safe
  since it's removed from both the visual and accessibility tree; avoid `opacity:0`
  or off-screen-only techniques that leave it exposed to screen readers or focusable).
- **CAPTCHA / Accessible Authentication (3.3.8, new in 2.2, AA — see §1)**: whatever
  the Cap.js widget renders must have a programmatically determinable name/role
  (4.1.2) and be operable by keyboard (2.1.1) — verify this against the actual widget
  once the microservice and its front-end integration are built, not assumed from
  "proof-of-work CAPTCHAs are generally accessible" reasoning alone.
- **Focus-visible styling (2.4.7, AA)**: any custom `:focus` styling on the form's
  inputs/buttons must keep a visible indicator — don't ship `outline: none` without a
  replacement that meets 1.4.11's 3:1 non-text contrast against the adjacent
  background.
- **Client-side `fetch()` submission**: since the page doesn't navigate on submit,
  the success/failure result must be announced to assistive tech (e.g. an
  `aria-live="polite"` region for a success message, or the error-identification
  pattern above for failures) — a plain visual toast with no live region is invisible
  to a screen reader user.

## 5. Color contrast — computed from this site's actual tokens

Method: WCAG 2.2's own relative luminance and contrast ratio definitions —
<https://www.w3.org/TR/WCAG22/#dfn-relative-luminance> and
<https://www.w3.org/TR/WCAG22/#dfn-contrast-ratio>. For each sRGB channel `c` (0–1):
linearize as `c/12.92` if `c ≤ 0.03928`, else `((c+0.055)/1.055)^2.4`; luminance
`L = 0.2126·R + 0.7152·G + 0.0722·B`; contrast ratio `(L1+0.05)/(L2+0.05)` with L1 the
lighter color. Computed by hand below (not a black-box tool) from
`src/styles/global.css`'s documented hex values — **these numbers were derived here,
not fetched from an external contrast checker, so treat them as a first-pass
calculation to be spot-checked with a tool (e.g. browser devtools contrast checker)
before relying on them for a compliance claim.**

| Foreground                       | Background                       | Computed ratio | vs 4.5:1 (normal text)     | vs 3:1 (large text / 1.4.11 UI) |
| -------------------------------- | -------------------------------- | -------------- | -------------------------- | ------------------------------- |
| `--color-default` `#822c2a`      | white `#ffffff`                  | **≈ 8.97:1**   | Pass (AA & AAA)            | Pass                            |
| `--color-default` `#822c2a`      | `--color-light-gray` `#e6e6e6`   | **≈ 7.19:1**   | Pass                       | Pass                            |
| `--color-default` `#822c2a`      | `--color-erlich-white` `#f2f2f2` | **≈ 8.01:1**   | Pass                       | Pass                            |
| `--color-light` `#a13a35`        | white `#ffffff`                  | **≈ 6.62:1**   | Pass                       | Pass                            |
| `--color-light` `#a13a35`        | `--color-light-gray` `#e6e6e6`   | **≈ 5.31:1**   | Pass                       | Pass                            |
| `--color-light` `#a13a35`        | `--color-erlich-white` `#f2f2f2` | **≈ 5.92:1**   | Pass                       | Pass                            |
| `--color-accent` `#8b6e55`       | white `#ffffff`                  | **≈ 4.71:1**   | Pass (barely — 0.2 margin) | Pass                            |
| `--color-accent` `#8b6e55`       | `--color-light-gray` `#e6e6e6`   | **≈ 3.77:1**   | **Fail** for normal text   | Pass                            |
| `--color-accent` `#8b6e55`       | `--color-erlich-white` `#f2f2f2` | **≈ 4.20:1**   | **Fail** for normal text   | Pass                            |
| `--color-accent-hover` `#c7a481` | white `#ffffff`                  | **≈ 2.32:1**   | Fail                       | Fail                            |

Implications:

- `--color-default` and `--color-light` are safe as normal-size body/link text on
  any of the three documented light backgrounds.
- `--color-accent` (`#8b6e55`) **only clears 4.5:1 on pure white**, and fails on both
  `--color-light-gray` and `--color-erlich-white` for normal-size text — it is only
  safe on tinted backgrounds as large text (≥18pt/24px, or ≥14pt/18.7px bold) or as a
  non-text UI element/border under the 3:1 rule (1.4.11), not as small body copy on
  `#e6e6e6` or `#f2f2f2`.
- `--color-accent-hover` (`#c7a481`) fails contrast against white outright and should
  not be treated as a text color at all — its name and the design token list suggest
  it is a hover/background/decorative state, not intended for text; confirm against
  `.design/style.md`'s actual component rules for where this token gets used, since
  this note only verifies math, not intended usage.
- These are two-flat-color pairings only. Any color combination involving gradients,
  overlays, translucent layers, or the actual rendered CSS (not just the raw tokens)
  needs separate verification against the live site.

## 6. German legal framing — BFSG (primary text)

Source: gesetze-im-internet.de, the official German federal law text portal.

- **§ 3 BFSG** ("Barrierefreiheit, Verordnungsermächtigung") defines accessibility in
  the statute itself: "Produkte und Dienstleistungen sind barrierefrei, wenn sie für
  Menschen mit Behinderungen in der allgemein üblichen Weise, ohne besondere
  Erschwernis und grundsätzlich ohne fremde Hilfe auffindbar, zugänglich und nutzbar
  sind," and authorizes the Bundesministerium für Arbeit und Soziales to issue a
  Rechtsverordnung (implementing regulation) with concrete requirements per Anlage I
  of EU Directive 2019/882 (the European Accessibility Act), covering "die Gestaltung
  und Herstellung der Produkte einschließlich der Benutzerschnittstelle" and "die Art
  und Weise der Bereitstellung von Informationen." Source:
  <https://www.gesetze-im-internet.de/bfsg/__3.html>.
- **§ 4 BFSG** ("Konformitätsvermutung auf der Grundlage harmonisierter Normen")
  establishes the conformance mechanism: "Bei Produkten und Dienstleistungen, die
  harmonisierten Normen oder Teilen davon entsprechen, deren Fundstellen im
  Amtsblatt der Europäischen Union veröffentlicht worden sind, wird vermutet, dass
  sie die Anforderungen der nach § 3 Absatz 2 zu erlassenden Rechtsverordnung
  erfüllen" — i.e. conformity to a harmonized EU standard (whose reference is
  published in the EU Official Journal) creates a legal presumption of compliance
  with the implementing regulation's requirements. Source:
  <https://www.gesetze-im-internet.de/bfsg/__4.html>. **Note**: the BFSG statute text
  itself, as fetched here, does not name "EN 301 549" or "WCAG" literally — it
  references "harmonisierte Normen" generically via the Official-Journal mechanism.
  EN 301 549 (which itself incorporates WCAG 2.1 Level AA success criteria for web
  content) is the standard commonly cited as satisfying this mechanism in practice,
  but that specific standard name was not found verbatim in the BFSG sections
  fetched (§§ 3–4) — flag this as **not independently confirmed by literal statute
  text** rather than asserting it as a direct quote.
- **BFSGV** (the implementing Rechtsverordnung), § 19 ("Anforderungen an
  Dienstleistungen des elektronischen Geschäftsverkehrs" — e-commerce services,
  covering this site's Kontakt/quote-request flow) requires that identification,
  electronic-signature, payment, and other interactive functions be designed
  "wahrnehmbar, bedienbar, verständlich und robust" — i.e. **perceivable, operable,
  understandable, and robust**, which is a verbatim restatement of WCAG's own four
  POUR principles directly in German statutory text, even without citing "WCAG" by
  name in that section. Source: <https://www.gesetze-im-internet.de/bfsgv/__19.html>.
- Practical reading for this repo: BFSG applies to this site as a commercial B2C
  digital service (already noted correctly in the project's own CLAUDE.md), and while
  the exact chain from BFSG → BFSGV → "which EN/WCAG version, which level" is
  procedural (via harmonized-standards references in the EU Official Journal rather
  than a single named clause), the practical, defensible target — consistent with
  both the POUR language actually in BFSGV § 19 and with how German public guidance
  and the site's own accessibility statement already frame it — is **WCAG 2.2 Level
  AA**, matching what `src/pages/barrierefreiheitserklärung.astro` and this project's
  CLAUDE.md already assume. Nothing found here contradicts that target; it just
  couldn't be traced to one literal "WCAG 2.2 AA" sentence inside BFSG/BFSGV itself.

## 7. Action list for this codebase

1. **Contact form (`src/pages/kontakt.astro`, not yet reviewed line-by-line here)** —
   once the microservice and CAPTCHA exist, explicitly verify: real `<label>`s (not
   placeholder-only), text-based error identification/suggestion (§3.3.1/3.3.3),
   honeypot hidden from AT via `aria-hidden`+`tabindex="-1"` (not just visually
   hidden), Cap.js widget keyboard-operable with a programmatic name (4.1.2, 2.1.1),
   and an `aria-live` region announcing fetch() success/failure since there's no page
   navigation to signal it otherwise.
2. **Cookie/consent banner (not yet built, per CLAUDE.md)** — when the Google Maps
   embed and/or the contact form's cookie-setting backend land, whatever consent UI
   is added must itself meet 2.1.1 (keyboard), 2.4.7 (focus visible), 4.1.2 (name/
   role/value for its accept/reject controls), and should be checked against 2.4.11
   Focus Not Obscured if it's a sticky/overlay banner that could cover a focused
   element beneath it.
3. **`--color-accent` (#8b6e55) usage audit** — confirm (in `.design/style.md` and
   actual rendered components) that this token is never used for small/normal-size
   body text directly on `--color-light-gray` or `--color-erlich-white` — the
   computed ratios in §5 put it below 4.5:1 on both. Safe uses: large text, borders/
   icons (3:1 rule), or on pure white.
4. **Skip link** — add a "skip to main content" link (APG/WCAG technique G1, §3
   above) to `src/layouts/Layout.astro` if one doesn't already exist; check current
   markup before assuming it's missing.
5. **Landmark/heading audit** — verify every page uses exactly one `<main>`, one
   `<h1>`, a labeled `<nav>` if more than one exists, and that `<footer>` (holding the
   Impressum/Datenschutz/Barrierefreiheitserklärung links per APG's own description
   of the contentinfo landmark) is a direct child of `<body>`.
6. **Accessibility statement page
   (`src/pages/barrierefreiheitserklärung.astro`)** — once the above items are
   verified or fixed, its "known barriers" section should honestly list current gaps
   (e.g. cookie-consent banner not yet built, Sentry Datenschutz coverage still
   provisional per CLAUDE.md) rather than asserting full compliance prematurely —
   this keeps the statement itself legally accurate under BFSG rather than aspirational.
7. **Provisional Sentry section (`src/pages/datenschutz.astro`)** — not an
   accessibility item, but flagged here because it's an open compliance item
   documented in CLAUDE.md; revisit once Sentry actually ships events, same "don't
   assert what isn't true yet" principle as item 6.
