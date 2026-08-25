## Agent skills

### Issue tracker

Self-hosted Gitea (`git.arthurerlich.de`), via the `tea` CLI. See `docs/agents/issue-tracker.md`.

### Domain docs

Single-context — one `CONTEXT.md` + `docs/adr/` at the repo root. See `docs/agents/domain.md`.

## Development

Package manager: **Bun** (not npm) — install deps with `bun install`, run scripts with `bun run <script>` (e.g. `bun run build`). See [Bun skill](.claude/skills/bun/SKILL.md) for the full command mapping. CI (`.gitea/workflows/deploy.yml`) uses `oven-sh/setup-bun` + `bun install --frozen-lockfile`.

When starting the dev server, use background mode:

```
astro dev --background
```

Manage the background server with `astro dev stop`, `astro dev status`, and `astro dev logs`.

## Site domain

Root domain: `erlich-fliesen.de`, configured as `site` in `astro.config.mjs` (overridable via `SITE_URL` env var). Components that need to tell internal from external links (e.g. `src/components/Link.astro`) should compare against `Astro.site`, not hardcode the domain.

## Legal & accessibility compliance

This is a public-facing commercial site for a German company (Fliesen-/Natursteinleger), so it must meet German/EU accessibility and web-law requirements, not just design/UX goals.

**Accessibility ("Barrierefreiheit")**

- Target **WCAG 2.2 level AA**: https://www.w3.org/TR/WCAG22/ (German quick-reference: https://www.w3.org/WAI/WCAG22/quickref/)
- `BFSG` (Barrierefreiheitsstärkungsgesetz) — the German law implementing the EU Accessibility Act, in force since 2025-06-28, applies to commercial B2C digital services/e-commerce: https://www.gesetze-im-internet.de/bfsg/
- `src/pages/barrierefreiheitserklärung.astro` publishes the accessibility statement, modeled on the public-sector BITV 2.0 template: https://www.gesetze-im-internet.de/bitv_2_0/

**Legal pages — implemented, real content**

- `src/pages/impressum.astro` — Impressum under `DDG` §5, entity data sourced from `src/consts.ts` (`contact`). https://www.gesetze-im-internet.de/ddg/
- `src/pages/datenschutz.astro` — Datenschutzerklärung under `DSGVO`/GDPR Art. 13, covers Cloudflare, Plausible, and a provisional Sentry section (flag for review once Sentry actually ships). https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX%3A32016R0679
- `src/pages/barrierefreiheitserklärung.astro` — accessibility statement (see above).
- Source text for Impressum/Datenschutz was generated via e-recht24.de and is archived in `docs/legal/`.

**Cookie/tracking consent — not yet implemented**

- Plausible (`src/components/Plausible.astro`) is cookieless and needs no consent gate itself.
- A planned Google Maps embed and the Kontakt form's cookie-setting backend (see [Contact form](#contact-form) below) will need consent per `TTDSG` §25 once built: https://www.gesetze-im-internet.de/ttdsg/. No `orestbida/cookieconsent` banner exists in `src/` yet — treat this as open scope, not done.

When building pages/forms/components, prefer solutions that are accessible by default (semantic HTML, native form controls, visible focus states, sufficient color contrast per the [Design tokens](#design-tokens) above) rather than retrofitting compliance later.

## Contact form

`src/pages/kontakt.astro` renders the quote-request form as a static Astro component. It submits (client-side `fetch()`) to a standalone Node/Express microservice — hosted separately on the VPS, not as Astro SSR — that checks a honeypot field and a self-hosted Cap.js proof-of-work CAPTCHA before emailing the submission to a configured address. That microservice is not yet built; `CAP_SECRET_KEY` in `.env.example` is a placeholder for it, unused anywhere in `src/` today.

## Analytics & error tracking

- **Plausible** (`@plausible-analytics/tracker`) — self-hosted at `plausible.arthurerlch.de` (currently offline), wired via `src/components/Plausible.astro` using `init({ domain, endpoint })`. Domain is derived at build time from `SITE_URL` (see [Deployment](#deployment) below), so prod/staging track separately and local `astro dev` sends nothing.
- **Sentry** (`@sentry/astro`) — integration is installed and registered in `astro.config.mjs`; treat its Datenschutz coverage as provisional until it's actually configured and shipping events.

## Deployment

CI is `.gitea/workflows/deploy.yml` (Gitea Actions): on push to `main` or `staging`, builds with `bun run build` (site URL from the `PROD_URL`/`STAGING_URL` repo **variable**, selected by branch), tars `dist/`, and ships it via SCP+SSH to the path in the `PROD_DEPLOY_PATH`/`STAGING_DEPLOY_PATH` repo variable — refusing to deploy rather than wiping the target if that path variable is empty. SSH access itself (`SSH_PRIVATE_KEY`/`SSH_HOST`/`SSH_USER`) is stored as Gitea repo **secrets**, not variables — secrets are masked in logs and unreadable again after saving, which is the point; don't move credentials to variables for retrievability, keep your own copy of a generated key instead. Deploy status badges for both branches are in `README.MD`.

## AI tooling

`.mcp.json` (project-level, shared by any session working this repo) registers two MCP servers: `astro-docs` (streamable HTTP, no auth, `https://mcp.docs.astro.build/mcp`) for live Astro documentation lookups, and `codebase-memory-mcp` for graph-based code search.

## Documentation

Full documentation: https://docs.astro.build

Consult these guides before working on related tasks:

- [Adding pages, dynamic routes, or middleware](https://docs.astro.build/en/guides/routing/)
- [Working with Astro components](https://docs.astro.build/en/basics/astro-components/)
- [Using React, Vue, Svelte, or other framework components](https://docs.astro.build/en/guides/framework-components/)
- [Adding or managing content](https://docs.astro.build/en/guides/content-collections/)
- [Adding styles or using Tailwind](https://docs.astro.build/en/guides/styling/)
- [Supporting multiple languages](https://docs.astro.build/en/guides/internationalization/)

## Design system: `.design/`

`src/styles/global.css` is the source of truth for color tokens. `.design/style.md` documents layout, typography, elevation, and component rules, and its color tokens are kept in sync with `global.css` (referenced by CSS variable name, not by separate hex values).

- `.design/style.md` — full design spec ("The Architectural Craftsman"): color tokens (mapped to `global.css`), typography (Yeseva One wordmark, Noto Serif headings, Inter body — see [Design tokens](#design-tokens) below), elevation via tonal layering (no drop shadows, no rounded corners, no border lines), and per-component rules (buttons, cards, nav, inputs). Read this before styling anything.
- `.design/styles.fig` — Figma source file backing the spec (binary, not directly readable — open in Figma for exact layout/spacing reference).

## Migrating from `.old/`

`.old/` contains the previous Symfony/Twig implementation of this site (unfinished) — use it only as a reference for page/component **structure** (nav, footer, hero markup) and copy, not for colors/design (see `.design/` above) or as running code.

Site language is German (`lang="de"`, set in `src/layouts/Layout.astro`) — all user-facing content must be German.

Reference locations in `.old/`:

- Design tokens: `.old/web/assets/styles/app.css` (Tailwind v4 CSS-first `@theme` block)
- Page templates: `.old/web/templates/pages/` (`index`, `imprint`, `style_guide`)
- Layout: `.old/web/templates/layout/` (`base`, `header`, `footer` — footer is an empty placeholder)
- Components: `.old/web/src/Component/` + `.old/web/templates/components/` (HeadLogo, Navigation, TopBar, MainNavigation, NavLink)
- Assets: `.old/web/public/media/` (logo, favicon, hero placeholder, icons)

## Design tokens

`src/styles/global.css` is authoritative:

- `--color-default: #822c2a` (primary red)
- `--color-light: #a13a35` (hover red)
- `--color-light-gray: #e6e6e6`
- `--color-erlich-white: #f2f2f2` (tinted background)
- `--color-black: #000000`
- `--color-accent: #8b6e55` (copper-gold, AA-contrast adjusted)
- `--color-accent-hover: #c7a481`

Fonts (Yeseva One display/wordmark, Noto Serif headings, Inter body) are declared in `astro.config.mjs` via `fonts: [...]` (Fontsource provider, `--font-yeseva-one`/`--font-noto-serif`/`--font-inter` CSS variables), then mapped to `--font-display`/`--font-serif`/`--font-sans` in the `@theme` block of `src/styles/global.css`.

## Tailwind setup status

**Activated.** `@tailwindcss/vite` is registered as a Vite plugin in `astro.config.mjs`, and `src/styles/global.css` (`@import 'tailwindcss';` + the `@theme` token block above) is imported by `src/layouts/Layout.astro`, the shared layout every page uses.

## Asset pipeline: `src/assets/` vs `public/`

Logos and content images live in `src/assets/` (e.g. `src/assets/coperated/`, `src/assets/images/`) so they go through `astro:assets` (`<Image>`/`import`); favicon and small icon SVGs stay in `public/media/`. **Known drift to fix, not carry over:**

- `src/components/Header.astro` still hardcodes `src="/media/coperated/logo-erlich-dunkel.png"` (a `public/` path) even though the real file now lives at `src/assets/coperated/logo-erlich-dunkel.png` — the image 404s in production. Needs an `astro:assets` import.
- The hero image's typo'd filename (`src/assets/images/hero/15.41.26_temp-hreo.jpg`) was decided to be renamed during the `src/assets/` move (#6 on the wayfinder map) but wasn't — still carries the typo.
- Favicon (`media/favicon/erlich-fliesen-favicon.svg`) and icon (`media/icons/ExternalLink.svg`) are usable as-is.
