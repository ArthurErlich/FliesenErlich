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

## Documentation

Full documentation: https://docs.astro.build

Consult these guides before working on related tasks:

- [Adding pages, dynamic routes, or middleware](https://docs.astro.build/en/guides/routing/)
- [Working with Astro components](https://docs.astro.build/en/basics/astro-components/)
- [Using React, Vue, Svelte, or other framework components](https://docs.astro.build/en/guides/framework-components/)
- [Adding or managing content](https://docs.astro.build/en/guides/content-collections/)
- [Adding styles or using Tailwind](https://docs.astro.build/en/guides/styling/)
- [Supporting multiple languages](https://docs.astro.build/en/guides/internationalization/)

## Migrating from `.old/`

`.old/` contains the previous Symfony/Twig implementation of this site (unfinished) — use it as the source of truth for design/structure, not as running code.

Site language is German (`lang="de"`) — all user-facing content must be German. Current `src/pages/index.astro` still has starter `lang="en"` boilerplate that needs correcting during real migration.

Reference locations in `.old/`:

- Design tokens: `.old/web/assets/styles/app.css` (Tailwind v4 CSS-first `@theme` block)
- Page templates: `.old/web/templates/pages/` (`index`, `imprint`, `style_guide`)
- Layout: `.old/web/templates/layout/` (`base`, `header`, `footer` — footer is an empty placeholder)
- Components: `.old/web/src/Component/` + `.old/web/templates/components/` (HeadLogo, Navigation, TopBar, MainNavigation, NavLink)
- Assets: `.old/web/public/media/` (logo, favicon, hero placeholder, icons)

## Design tokens (from `.old/`, not yet ported)

- `--color-default: #822c2a` (primary red)
- `--color-light: #a13a35` (hover red)
- `--color-light-gray: #e6e6e6`
- `--color-erlich-white: #f2f2f2` (tinted background)
- `--color-black: #000000`
- `--color-accent: #8b6e55` (copper-gold, AA-contrast adjusted)
- `--color-accent-hover: #c7a481`

No custom font family was ever defined in `.old` (still on Tailwind defaults, marked `TODO: add missing fonts`).

## Tailwind setup status

`tailwindcss` and `@tailwindcss/vite` are installed in `package.json`, but **not yet activated**.

To use it: add the `tailwindcss()` Vite plugin in `astro.config.mjs`, then import a Tailwind stylesheet (`@import "tailwindcss";` + the `@theme` tokens above) in a shared layout, per Astro's Tailwind (Vite plugin) guide.

No `src/layouts/` exists yet — this stylesheet import needs a layout to live in once one is created.

## Known asset gaps in `.old/` (carry over as-is when migrating)

- Logo filename mismatch: templates reference `logo-erlich-dunkel.png`, but `public/media/coperated/` only has `logo-erlich.png` and `logo-erlich-mobile.png` — carry over the existing files as-is and resolve the mismatch when doing the real migration, not now.
- Hero image is a placeholder with a typo in its filename (`15.41.26_temp-hreo.jpg`) — carry over as-is, replace later.
- Favicon (`media/favicon/erlich-fliesen-favicon.svg`) and icon (`media/icons/ExternalLink.svg`) are usable as-is.
