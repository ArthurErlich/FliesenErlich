## Agent skills

### Issue tracker

Self-hosted Gitea (`git.arthurerlich.de`), via the `tea` CLI. See `docs/agents/issue-tracker.md`.

### Domain docs

Single-context — one `CONTEXT.md` + `docs/adr/` at the repo root. See `docs/agents/domain.md`.

## Development

When starting the dev server, use background mode:

```
astro dev --background
```

Manage the background server with `astro dev stop`, `astro dev status`, and `astro dev logs`.

## Site domain

Root domain: `erlich-fliesen.de`, configured as `site` in `astro.config.mjs` (overridable via `SITE_URL` env var). Components that need to tell internal from external links (e.g. `src/components/Link.astro`) should compare against `Astro.site`, not hardcode the domain.

## Legal & accessibility compliance

This is a public-facing commercial site for a German company (Fliesen-/Natursteinleger), so it must meet German/EU accessibility and web-law requirements, not just design/UX goals. None of this is implemented yet — treat it as required scope, not a nice-to-have.

**Accessibility ("Barrierefreiheit")**

- Target **WCAG 2.2 level AA**: https://www.w3.org/TR/WCAG22/ (German quick-reference: https://www.w3.org/WAI/WCAG22/quickref/)
- `BFSG` (Barrierefreiheitsstärkungsgesetz) — the German law implementing the EU Accessibility Act, in force since 2025-06-28, applies to commercial B2C digital services/e-commerce: https://www.gesetze-im-internet.de/bfsg/
- If any part of the site is deemed in scope of BFSG (e.g. an online quote/contact form used as a consumer service), a public **Barrierefreiheitserklärung** (accessibility statement) is required, modeled on the public-sector template under BITV 2.0: https://www.gesetze-im-internet.de/bitv_2_0/ (schema reference: https://www.barrierefreiheit-dienstekonsolidierung.bund.de/Webs/PB/DE/instrumente/barrierefreiheitserklaerung/barrierefreiheitserklaerung_node.html)

**Required legal pages/notices**

- **Impressum** (legal notice) — mandatory for any commercial website under `DDG` §5 (Digitale-Dienste-Gesetz, replaced the TMG in 2024): https://www.gesetze-im-internet.de/ddg/. Reference structure/copy from `.old/web/templates/pages/imprint` (see [Migrating from `.old/`](#migrating-from-old)), but content must be re-verified against current `DDG` §5 requirements, not just copied.
- **Datenschutzerklärung** (privacy policy) — required under `DSGVO`/GDPR Art. 13: https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX%3A32016R0679. Must cover any forms, analytics, fonts/assets loaded from third parties, etc.
- **Cookie/tracking consent** — if any cookies, analytics, or embeds beyond strictly necessary ones are added, `TTDSG` §25 consent requirements apply: https://www.gesetze-im-internet.de/ttdsg/
- **Barrierefreiheitserklärung** — see accessibility section above; add as its own page once accessibility work is done enough to describe conformance status honestly.

When building pages/forms/components, prefer solutions that are accessible by default (semantic HTML, native form controls, visible focus states, sufficient color contrast per the [Design tokens](#design-tokens) above) rather than retrofitting compliance later.

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

- `.design/style.md` — full design spec ("The Architectural Craftsman"): color tokens (mapped to `global.css`), typography (`notoSerif` headings / `inter` body), elevation via tonal layering (no drop shadows, no rounded corners, no border lines), and per-component rules (buttons, cards, nav, inputs). Read this before styling anything.
- `.design/styles.fig` — Figma source file backing the spec (binary, not directly readable — open in Figma for exact layout/spacing reference).

## Migrating from `.old/`

`.old/` contains the previous Symfony/Twig implementation of this site (unfinished) — use it only as a reference for page/component **structure** (nav, footer, hero markup) and copy, not for colors/design (see `.design/` above) or as running code.

Site language is German (`lang="de"`) — all user-facing content must be German. Current `src/pages/index.astro` still has starter `lang="en"` boilerplate that needs correcting during real migration.

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

`.design/style.md` also specifies fonts (`notoSerif` headings, `inter` body) — `.old` never defined a font family.

## Tailwind setup status

`tailwindcss` and `@tailwindcss/vite` are installed in `package.json`, but **not yet activated**.

To use it: add the `tailwindcss()` Vite plugin in `astro.config.mjs`, then import a Tailwind stylesheet (`@import "tailwindcss";` + the `@theme` tokens above) in a shared layout, per Astro's Tailwind (Vite plugin) guide.

No `src/layouts/` exists yet — this stylesheet import needs a layout to live in once one is created.

## Known asset gaps in `.old/` (carry over as-is when migrating)

- Logo filename mismatch: templates reference `logo-erlich-dunkel.png`, but `public/media/coperated/` only has `logo-erlich.png` and `logo-erlich-mobile.png` — carry over the existing files as-is and resolve the mismatch when doing the real migration, not now.
- Hero image is a placeholder with a typo in its filename (`15.41.26_temp-hreo.jpg`) — carry over as-is, replace later.
- Favicon (`media/favicon/erlich-fliesen-favicon.svg`) and icon (`media/icons/ExternalLink.svg`) are usable as-is.
