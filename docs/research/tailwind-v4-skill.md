# Research: Covering Tailwind CSS v4 conventions as a Claude Code Skill

Date: 2026-08-09

## Question

What's the best way to cover Tailwind v4 usage conventions (CSS-first `@theme`
config, no `tailwind.config.js`, v4 utility/breaking changes vs v3) as a
Claude Code Skill for this repo?

## 1. Does an official Anthropic skill already cover this?

**No.** Confirmed by listing the actual contents of `anthropics/skills` on
GitHub (`gh api repos/anthropics/skills/contents/skills`):

```
algorithmic-art, brand-guidelines, canvas-design, claude-api,
doc-coauthoring, docx, frontend-design, internal-comms, mcp-builder,
pdf, pptx, skill-creator, slack-gif-creator, theme-factory,
web-artifacts-builder, webapp-testing, xlsx
```

None of these is a Tailwind or CSS-tooling skill. Two skills merely *use*
Tailwind as an implementation detail:

- `web-artifacts-builder` — builds React/Tailwind/shadcn artifacts for
  claude.ai, not a Tailwind reference.
- `frontend-design` — general anti-"AI slop" design guidance, happens to use
  Tailwind/React as its example stack, not a config/migration reference.

Source: https://github.com/anthropics/skills (folder listing verified via `gh api`).

## 2. Does a community skill already fit?

Several third-party Tailwind v4 skills exist (found via web search, not
independently vetted for quality/trust):

- `jezweb/claude-skills` and `secondsky/claude-skills` — "Tailwind v4" skill
  bundled inside broader Cloudflare/React full-stack kits.
- `firedev/tailwind-skill` — standalone "production-grade Tailwind CSS UI" skill.
- `blencorp/claude-code-kit` — `cli/kits/tailwindcss/skills/tailwindcss/SKILL.md`.
- Marketplace listings (mcpmarket.com, tessl.io, awesomeskills.dev,
  claudemarketplaces.com) repackaging similar content.

These are unofficial, third-party repos of unknown provenance/maintenance —
installing one means trusting arbitrary instructions pulled into every future
session. None is scoped to *this repo's* actual tokens (`--color-default`,
`--color-accent`, etc.) or its specific stack (Astro + `@tailwindcss/vite`).
A minimal, repo-authored skill is both safer and more precisely useful than
adopting a generic third-party one.

Source: WebSearch results for "claude code skill tailwind v4" (2026-08-09).

## 3. Primary-source facts to bake into a skill

### 3.1 CSS-first config, confirmed from this repo

Already active and grounded in real files:

- `/home/haylan/Documents/GitHub/FliesenErlich/astro.config.mjs` — imports
  `tailwindcss` from `@tailwindcss/vite` and registers it as a Vite plugin
  (`vite: { plugins: [tailwindcss()] } }`). No `tailwind.config.js`,
  no PostCSS config file in this repo.
- `/home/haylan/Documents/GitHub/FliesenErlich/src/styles/global.css` — the
  entire config is `@import 'tailwindcss';` followed by one `@theme { ... }`
  block defining the repo's 7 color tokens (`--color-default`,
  `--color-light`, `--color-light-gray`, `--color-erlich-white`,
  `--color-black`, `--color-accent`, `--color-accent-hover`).

This is the canonical usage pattern for the skill to teach: **no JS config
file, one `@theme` block in the global stylesheet, Vite plugin not
PostCSS plugin.**

### 3.2 `@theme` directive syntax (tailwindcss.com/docs/theme)

- `@theme { --color-x: … }` both defines a CSS var *and* generates matching
  utility classes (`bg-x`, `text-x`, `border-x`, …) — this is why it differs
  from a plain `:root` block.
- Namespaces map to utility groups: `--color-*`, `--font-*`, `--text-*`,
  `--font-weight-*`, `--spacing-*`, `--radius-*`, `--shadow-*`,
  `--breakpoint-*`, `--animate-*`.
- Extend defaults: just add a new var. Override a default: redefine the same
  var name (e.g. `--breakpoint-sm: 30rem;`).
- Reset a whole namespace: `--color-*: initial;` then redefine only the
  colors you want (relevant here since the repo *is* effectively doing a
  partial-custom palette, though it's currently additive, not a reset).
- `@theme inline { --font-sans: var(--font-inter); }` when a theme var must
  reference another variable, so utilities resolve correctly.
- `theme()` function still works for use inside media queries where CSS vars
  can't be used; otherwise prefer `var(--color-x)` directly in custom CSS.

Source: https://tailwindcss.com/docs/theme

### 3.3 Concrete v3 → v4 breaking changes (tailwindcss.com/docs/upgrade-guide)

The most relevant ones for a repo with no legacy v3 code, but still worth the
skill knowing so it never *writes* v3-era patterns:

**Import / build**
- `@tailwind base/components/utilities` directives are gone → single
  `@import "tailwindcss";`.
- PostCSS setups now need `@tailwindcss/postcss` (not needed here — this
  repo uses `@tailwindcss/vite` instead, which is the Vite-native path and
  needs no PostCSS config at all).
- `postcss-import` and `autoprefixer` are no longer needed — built in.
- No `content` array required — automatic content detection.

**Renamed scale utilities** (verified list):

| v3 | v4 |
|----|----|
| `shadow-sm` | `shadow-xs` |
| `shadow` | `shadow-sm` |
| `drop-shadow-sm` | `drop-shadow-xs` |
| `drop-shadow` | `drop-shadow-sm` |
| `blur-sm` | `blur-xs` |
| `blur` | `blur-sm` |
| `backdrop-blur-sm` | `backdrop-blur-xs` |
| `backdrop-blur` | `backdrop-blur-sm` |
| `rounded-sm` | `rounded-xs` |
| `rounded` | `rounded-sm` |

**Removed deprecated utilities** — opacity-suffix utilities are gone in
favor of the slash-opacity modifier: `bg-opacity-*` → `bg-black/50` (same
pattern for `text-`, `border-`, `divide-`, `ring-`, `placeholder-opacity-*`).
Also `flex-shrink-*` → `shrink-*`, `flex-grow-*` → `grow-*`,
`overflow-ellipsis` → `text-ellipsis`, `decoration-slice`/`decoration-clone`
→ `box-decoration-slice`/`box-decoration-clone`.

**Default-value changes to watch for**
- `border` no longer defaults to `gray-200`, now `currentColor` — must add
  an explicit color class.
- `ring` (bare) no longer 3px `blue-500` — now `ring-3 ring-blue-500` needed
  to replicate old look; bare `ring` is 1px `currentColor`.
- `outline-none` renamed `outline-hidden`; `outline-none` now actually means
  `outline-style: none`.
- Preflight: placeholder color is current-text-color at 50% opacity (was
  `gray-400`); buttons default `cursor: default` (was `pointer`).
- `hover:` variant now gated by `@media (hover: hover)` — no longer fires on
  tap on touch devices.

**Syntax changes**
- Arbitrary CSS-var values: `bg-[--brand]` → `bg-(--brand)`.
- Custom utilities: `@layer utilities { .x {} }` → `@utility x { }`.
- `!important` modifier moves to the end of the class: `flex!` not `!flex`.
- Grid arbitrary values use underscores not commas:
  `grid-cols-[max-content_auto]`.

**Removed**
- `tailwind.config.js` auto-detection (must load explicitly via `@config` if
  keeping one at all — not relevant here, no JS config exists in this repo).
- `corePlugins`, `safelist`, `separator` options.
- `resolveConfig()` JS export.
- Sass/Less/Stylus preprocessing alongside Tailwind.

Source: https://tailwindcss.com/docs/upgrade-guide

### 3.4 `@tailwindcss/vite` setup (already correct in this repo)

Official blog confirms the pattern this repo already uses:

```js
import tailwindcss from "@tailwindcss/vite";
export default defineConfig({ plugins: [tailwindcss()] });
```

This is the first-party Vite plugin and is the recommended path over PostCSS
when the build tool is Vite (Astro's `vite:` config block, as used in
`astro.config.mjs` here) — no `postcss.config.*`, no `@tailwindcss/postcss`
needed alongside it.

Source: https://tailwindcss.com/blog/tailwindcss-v4 (npmjs.com page for the
package returned HTTP 403 to the fetch tool and could not be read directly;
the GitHub package README fetched instead only documented the `optimize`
Lightning CSS option and did not restate the basic setup, so the blog post's
code sample is the citation for the setup snippet).

## 4. Recommendation

**Author a small, repo-specific custom skill.** Rationale:

1. No official Anthropic skill exists (verified above) — nothing to reuse.
2. Third-party community skills exist but are unvetted, generic, and would
   pull in unrelated stack assumptions (Cloudflare, shadcn, React) that
   don't apply to this Astro + vanilla-CSS-tokens setup.
3. The actual footprint needed is tiny: this repo has exactly one CSS file
   with an `@theme` block and one Vite plugin line. A skill doesn't need to
   teach all of Tailwind v4 — it needs to keep an agent from reflexively
   writing v3-era patterns (`tailwind.config.js`, `@tailwind base`,
   `bg-opacity-50`, PostCSS config) into a v4 CSS-first repo, and remind it
   where the real theme tokens live (`src/styles/global.css`).

**What the skill should contain (minimal):**
- One line stating the setup: `@tailwindcss/vite` in `astro.config.mjs`, all
  theme tokens live in `src/styles/global.css`'s `@theme` block, no
  `tailwind.config.js` / no PostCSS config exists or is needed.
- The renamed-utility table (§3.3) so old-muscle-memory classes aren't used.
- The opacity-modifier reminder (`bg-black/50` not `bg-opacity-50`).
- The `@theme` extend-vs-override-vs-reset syntax (§3.2), pointing at the
  existing token block as the running example.
- A one-line pointer to `CLAUDE.md`'s "Design tokens (from `.old/`)" section,
  since those are the values that will eventually populate/extend `@theme`.

Skip: a full copy of the upgrade guide, unrelated v4 features (3D
transforms, container queries, oklch color theory) not used in this repo —
add if/when the repo actually reaches for them.
