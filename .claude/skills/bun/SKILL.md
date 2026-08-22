---
name: bun
description: Use Bun instead of npm for this repo — install, run scripts, and CI. Use whenever installing dependencies, running package.json scripts, or editing the deploy workflow.
---

This repo uses **Bun** as its package manager and JS runtime, migrated from npm. `bun.lock` is the lockfile of record — `package-lock.json` is gone.

## Command mapping

| npm                  | Bun                    |
| :------------------- | :--------------------- |
| `npm install`        | `bun install`          |
| `npm ci`              | `bun install --frozen-lockfile` |
| `npm run <script>`   | `bun run <script>` (or just `bun <script>` if it doesn't collide with a Bun subcommand) |
| `npx <bin>`          | `bunx <bin>`           |
| `npm install <pkg>`  | `bun add <pkg>`        |
| `npm install -D <pkg>` | `bun add -d <pkg>`   |

Astro's own CLI is unaffected — `bun run dev`, `bun run build`, `bun run preview`, `bun run astro ...` all still call the scripts in `package.json`.

## Gotchas for this repo

- `bun install` reads `.npmrc` and auto-converts an existing `package-lock.json` into `bun.lock` the first time it runs — after that, delete `package-lock.json` so it doesn't drift out of sync.
- CI (`.gitea/workflows/deploy.yml`) uses `oven-sh/setup-bun@v2` + `bun install --frozen-lockfile`, not `actions/setup-node`. If a step needs Node itself (not just Bun), Bun ships a Node-compatible runtime, so `node` binaries invoked via scripts keep working.
- `package.json`'s `engines.node` field is left as-is (informational); Bun doesn't require it.
- Bun blocks dependency postinstall scripts by default and uses `trustedDependencies` (array of package names) instead of npm-style `allowScripts` — `esbuild` is listed there so its native-binary postinstall still runs.
- `bun.lock` (Bun ≥1.1.39, the default now) is a text-based JSONC lockfile — it diffs cleanly in git with no `.gitattributes`/`textconv` setup. That workaround is only needed for the legacy binary `bun.lockb` format, which this repo doesn't use.
- Renovate: `renovate.json`'s `enabledManagers` includes `"bun"` (in addition to `"npm"`) so it manages `bun.lock`, not just `package.json`.
