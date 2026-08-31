# Running the PHP API under `astro dev` / `astro preview`

Question: can we make `public/api/index.php` actually execute during local dev,
instead of being served as a static file (or 404'd), without a developer
manually running a second `php -S` process?

## Summary / recommendation

- **`astro dev`**: solvable with zero new dependencies. Add Vite's built-in
  `server.proxy` under the `vite:` key in `astro.config.mjs`, pointing
  `/api` at a `php -S` process. This is stock Vite config — Astro passes
  `vite:` straight through to Vite (confirmed below) — so it costs nothing
  but a few lines of config.
- **`astro preview`**: **not solvable the same way.** `astro preview` for a
  fully static site (no adapter, which is this repo's setup) is a plain
  static-file server, not Vite — it does not read `server.proxy` and exposes
  no middleware/proxy hook at all. There is no first-party mechanism to make
  it run PHP.
- **Net recommendation for this repo**: don't chase a preview-time fix.
  `astro preview` exists to sanity-check the built static output, and this
  repo's PHP API is deployed separately in production anyway (real
  PHP-capable host, not through Astro's preview server). Wire up
  `vite.server.proxy` for `astro dev` only (this is where day-to-day form
  work happens), and add one `bun run` script (or a one-line note in
  CLAUDE.md) that starts `php -S 127.0.0.1:8000 -t public/api` alongside
  `astro dev`. Skip third-party Vite PHP plugins — they either just wrap
  `server.proxy` (no benefit) or, per `vite-plugin-php` below, solve a
  different problem (PHP-as-templating-language compiled through Vite's
  pipeline), not "run a standing JSON API server." Skip building a custom
  `astro:server:setup` integration too — it only fires in dev anyway, so it
  buys nothing over the config-only approach, at the cost of writing and
  maintaining a bespoke child-process manager.

---

## 1. Astro's own capabilities

- Astro's `vite` top-level config option passes its value straight to Vite:
    > "Pass additional configuration options to Vite. Useful when Astro
    > doesn't support some advanced configuration that you may need."
    > ([Astro Configuration Reference — `vite`](https://docs.astro.build/en/reference/configuration-reference/#vite))
    > This repo already uses this key (`vite: { plugins: [tailwindcss()] }` in
    > `astro.config.mjs`), so adding `vite: { server: { proxy: {...} } }` is
    > additive, not a new pattern.
- Astro's own `server` config option (`server.port`, `server.host`, etc.)
  explicitly states it configures "the Astro dev server, **used by both**
  `astro dev` and `astro preview`" — but this is Astro's _own_ thin
  wrapper options (port/host/headers/allowedHosts), not Vite's proxy
  machinery. There is no Astro-native `server.proxy` option; proxying is a
  Vite concern reached only via the `vite:` passthrough.
  ([Astro Configuration Reference — Server Options](https://docs.astro.build/en/reference/configuration-reference/#server-options))

## 2. Vite's `server.proxy` and whether it reaches `astro preview`

- Vite's dev server supports `server.proxy: { '/api': { target: 'http://localhost:8000', changeOrigin: true } }` (string or regex keys), with options extending [`http-proxy-3`](https://github.com/sagemathinc/http-proxy-3#options) (`target`, `changeOrigin`, `rewrite`, `ws`, `configure`, etc.).
  ([Vite — Server Options](https://vite.dev/config/server-options.html#server-proxy))
- Vite's docs state explicitly: **"Unless noted, the options in this section are only applied to dev."** `server.proxy` is under "Server Options" with no such note, so it is dev-server-only — it does **not** apply to `vite preview` (Vite's own preview command), and by extension not to any static server built on top of it.
  ([Vite — Server Options](https://vite.dev/config/server-options.html))
- Astro's `astro dev` runs on top of Vite's dev server, so `vite.server.proxy` set via `astro.config.mjs`'s `vite:` key works for `astro dev`.
- Astro's `astro preview` for a project with **no SSR adapter** (this repo: static output, no adapter configured) is described as:
    > "Starts a local server to serve the contents of your static directory (`dist/` by default) created by running `astro build`."
    > ([Astro CLI Reference — `astro preview`](https://docs.astro.build/en/reference/cli-reference/#astro-preview))
    > And from the programmatic API docs:
    > "If no adapter is set in the configuration, the preview server will only serve the built static files. If an adapter is set in the configuration, the preview server is provided by the adapter."
    > ([Astro Programmatic API — `preview()`](https://docs.astro.build/en/reference/programmatic-reference/#preview))
    > This confirms: no adapter → no Vite involvement in `astro preview` at all → `server.proxy` is silently ignored.

## 3. Vite's own built-in PHP support

None. Vite is a JS/TS/ESM bundler and dev server; nothing in its docs, config reference, or plugin API mentions PHP or any non-JS runtime execution. (Negative claim — there is no doc page to cite for "doesn't exist"; confirmed by absence across Vite's official docs and by the fact that all PHP support comes from third-party plugins, see below.)

## 4. Third-party Vite plugins for PHP

- **`vite-plugin-php`** (npm, `donnikitos/vite-plugin-php`) — real, active, not abandoned:
    - Latest version `3.0.0`, published ~1 month before this research (per `npm view vite-plugin-php time.modified` → `2026-07-10`); package created 2023.
    - GitHub: 78 stars, 3 forks, 3 open issues, MIT license — small but maintained.
    - **What it actually does**: it is a PHP-as-templating preprocessor integrated into Vite's transform pipeline — it treats `.php` files as Vite _entry points_ (like `.html` files), runs them through the system `php` binary, writes output to a temp dir (`.php-tmp` by default), and lets Vite process the surrounding HTML/JS/CSS. Config includes `entry` (glob of PHP page files), `rewriteUrl`, `binary` (path to a PHP binary), and `php.host`.
    - Its own docs list explicit limitations: PHP variables aren't available inside inline `<script type="module">` blocks (Vite extracts these to separate files), Vite can't process asset paths computed by PHP, and PHP-wrapped `<script>`/`<link>` tags can get relocated by Vite's processing.
    - **Verdict for this use case**: wrong shape of tool. It's built for PHP-templated _pages_ rendered through Vite's asset pipeline (each `.php` file is a page/entry with its own build output), not for standing up a persistent backend process that answers arbitrary `POST /api` JSON requests. Routing this repo's single dispatcher-style `index.php` (all form submissions POST to one endpoint, dispatched by a `key` field — see `public/api/index.php`) through it would fight the plugin's page-oriented model for no benefit over plain `server.proxy`.
    - It is generic Vite, not Astro-specific — nothing indicates Astro compatibility has been tested, and Astro's own file-based routing/build pipeline would likely conflict with the plugin also wanting to treat `.php` files as entries.
- Other Vite "proxy" plugins found (`vite-plugin-proxy`, `vite-plugin-proxy-middleware`, `pearofducks/vite-proxy`) are thin convenience wrappers that either replicate `server.proxy` or work around specific proxy/HTTP2 edge cases — none add PHP-process-spawning behavior beyond what `server.proxy` already does for free. No `@vituum/vite-plugin-php` package exists on the npm registry (checked directly — 404).
- **Conclusion**: no third-party plugin does "spawn `php -S` + proxy to it as a generic backend" better than hand-rolling `server.proxy` + a manually- or script-started `php -S`. Any plugin adds a dependency and (for `vite-plugin-php` specifically) a mismatched execution model.

## 5. `astro:server:setup` integration hook

- Astro's Integration API `astro:server:setup` hook:
    > **When:** "Just after the Vite server is created in 'dev' mode, but before the `listen()` event is fired."
    > **Why:** "To update Vite server options and middleware, or enable support for refreshing the content layer."
    > It hands you `{ server: ViteDevServer, logger, toolbar, refreshContent }`, and the docs' own example is Astro's Partytown integration calling `server.middlewares.use(...)` to inject a Connect middleware.
    > ([Astro Integration API — `astro:server:setup`](https://docs.astro.build/en/reference/integrations-reference/#astroserversetup))
- This confirms the hook **only fires for `astro dev`** ("just after the Vite server is created in dev mode") — there is no equivalent hook for `astro preview` in the Integration API hook list (`astro:build:*` hooks cover the build; nothing fires during `astro preview`'s static server startup for a non-adapter project).
- A hand-written integration using this hook (spawn `php -S` on `astro:server:setup`, wire `server.middlewares.use()` to proxy to it, tear it down on `astro:server:done`) is **possible** and gives programmatic control (e.g. auto-picking a free port, streaming PHP's stderr into Astro's logger). But it buys nothing over `vite.server.proxy` for `astro dev` specifically, since `server.proxy` already does the proxying declaratively — the only gain would be scripting the `php -S` process lifecycle instead of running it in a second terminal, which a one-line concurrently-style script achieves more simply (see §7).

## 6. How `astro preview` actually works, and its ceiling

- Confirmed above (§2): for a project with no adapter (this repo — static output, no `output`/adapter configured in `astro.config.mjs`), `astro preview` serves only the contents of `dist/` as static files. It is not Vite-based.
- Adapters _can_ supply their own preview server (e.g. the Cloudflare adapter's `astro preview` runs under `workerd` to mirror the Workers runtime — see [`@astrojs/cloudflare` docs](https://docs.astro.build/en/guides/integrations-guide/cloudflare/#new-astro-preview-support)), via the Adapter API's `previewEntrypoint`/`CreatePreviewServer` mechanism ([Astro Adapter API — Building a preview entrypoint](https://docs.astro.build/en/reference/adapter-reference/#building-a-preview-entrypoint)). That's adapter-authored Node code with full control over the server — theoretically a custom adapter could add PHP proxying to its preview server. That is far more machinery than this problem justifies for a static site with no adapter.
- **Conclusion**: for this repo (static output, no adapter), `astro preview` cannot be made to run or proxy to PHP through any first-party Astro mechanism. The only way to get PHP behind `astro preview` is an external wrapper: run `php -S` and `astro preview` as two processes and put something in front of them (a tiny Node/Caddy/nginx reverse proxy), since `astro preview`'s own process exposes no hook to attach middleware to.

## 7. Fallback pattern: two processes + a proxy in front (or none)

- The standard, tooling-agnostic pattern for polyglot dev setups (documented informally across many Node+PHP/Node+Rails/Node+Django project READMEs, not any single canonical source) is: run both servers and use `concurrently` or `npm-run-all` to start them from one script, with the frontend dev server's own proxy config (Vite's `server.proxy`, webpack-dev-server's `devServer.proxy`, etc.) forwarding API paths to the backend port. This is exactly what `server.proxy` already gives us for `astro dev` — no extra process-orchestration tool is needed for a single PHP command.
- For `astro preview`, since there's no proxy hook at all, the equivalent fallback is heavier: a small standalone reverse proxy (e.g., a 15-line Node `http`/`http-proxy` script, or Caddy/nginx) sitting in front of both `astro preview` and `php -S`, OR simply accepting that `astro preview` only proves the static HTML/CSS/JS output and PHP is checked separately by curling `php -S` directly. No maintained project was found that packages this specific two-process pattern for Astro; it would be a few lines of custom glue if ever wanted.

---

## Comparison table

| Option                                                                                                                   | Works in `astro dev`?                                                                                                             | Works in `astro preview`?                                 | New deps?                                            | Setup complexity                                                                        | Maintenance risk                                                                                             |
| ------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------- | ---------------------------------------------------- | --------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| `vite.server.proxy` in `astro.config.mjs` (stock Vite config, run `php -S` manually or via a `bun run` script alongside) | Yes                                                                                                                               | No (Vite config, ignored by static preview server)        | None                                                 | Very low — few lines of config + one CLI command                                        | Very low — it's Vite/Astro core config                                                                       |
| Third-party Vite PHP plugin (`vite-plugin-php`)                                                                          | Partially — wrong execution model (page-templating, not backend proxy); would need reshaping the API to fit its entry-point model | No (preview doesn't run Vite)                             | 1 (small, maintained, but niche — 78★, 1 maintainer) | Medium-high — fighting its page/entry model for a single dispatcher endpoint            | Medium — small single-maintainer package                                                                     |
| Custom `astro:server:setup` integration (spawn `php -S`, wire `server.middlewares`)                                      | Yes                                                                                                                               | No (`astro:server:setup` is dev-only per docs)            | None (uses Node child_process + Astro's own API)     | Medium — bespoke integration code to write and keep working across Astro major versions | Medium — you own this code; Astro Integration API changes across majors (v6 changed several hook signatures) |
| External process manager + reverse proxy in front of both `astro preview` and `php -S`                                   | N/A (not needed for dev)                                                                                                          | Yes, but via a third proxy process, not Astro/Vite itself | 0–1 (a proxy tool, or a ~15-line Node script)        | Medium — a real (if small) piece of infra to write/maintain                             | Low-medium — simple once written, but is genuinely new surface area                                          |

## Recommendation for this repo

Given: single small PHP API, Bun toolchain with zero extra Node deps today, and a real PHP-capable production host (so dev-time routing fidelity doesn't need to be perfect):

1. Add `vite: { server: { proxy: { '/api': 'http://127.0.0.1:8000' } } }` to `astro.config.mjs` (merging with the existing `vite.plugins` key) — solves `astro dev` with no new dependency.
2. Document (e.g. in CLAUDE.md's Development section) that `astro dev` expects `php -S 127.0.0.1:8000 -t public/api` running alongside it, per the PHP manual's built-in server docs (`php -S <host>:<port> -t <docroot> [router.php]`) — [PHP Manual: Built-in web server](https://www.php.net/manual/en/features.commandline.webserver.php). No router script is needed here since there's only one entry (`index.php`) and PHP's built-in server already falls back to `index.php` for a directory request.
3. Don't chase `astro preview` — it's a static-output check by design; verify the PHP API separately (`curl` against `php -S`, or in CI/staging against the real deploy target) rather than building a reverse-proxy wrapper for a case that doesn't come up in this repo's actual workflow.
4. Skip `vite-plugin-php` and skip writing a custom `astro:server:setup` integration — both cost more (a dependency in one case, bespoke maintained code in the other) than the config-only route, for the same `astro dev`-only coverage.
