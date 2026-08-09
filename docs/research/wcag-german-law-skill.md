# WCAG 2.2 AA + German-law compliance skills — sourcing research

Research for issue #4 (child of #1, map). Investigates what Claude Skills exist to
help with (a) WCAG 2.2 AA accessibility review and (b) German commercial/DSGVO-law
compliance (Impressum, Datenschutzerklärung) for this site.

## (a) WCAG 2.2 AA accessibility

| Option | Source | WCAG version | License | Trust signal | Verdict |
|---|---|---|---|---|---|
| `accessibility-review` | `anthropics/knowledge-work-plugins` (design plugin) | **WCAG 2.1 AA** — not 2.2 | Apache-2.0 | Official Anthropic repo, 23.4k★, active (599 commits) | Solid engine, wrong version target |
| `accessibility` skill | [`addyosmani/web-quality-skills`](https://github.com/addyosmani/web-quality-skills) | **WCAG 2.2**, all 4 POUR categories, "40+ rules" | MIT | Author is a well-known, credible web-perf/DX engineer (ex-Google Chrome team); 2.6k★, 238 forks, 31 commits | **Best fit** |
| Various `mcpmarket.com` / `claudemarketplaces.com` listings ("WCAG 2.2 Accessibility Compliance", "WCAG Audit Patterns", etc.) | third-party skill marketplaces | claim WCAG 2.2 | unverified | No verifiable authorship, no repo history checked, marketplace listings not primary sources | Not recommended — unvetted |

**Recommendation:** install/vendor `addyosmani/web-quality-skills`'s `accessibility`
skill — it's the only option found that (1) explicitly targets WCAG 2.2 (matching
the requirement, not 2.1), (2) has a named, credible author instead of an anonymous
marketplace listing, and (3) is MIT-licensed with real stars/forks/commit activity.
Anthropic's own `accessibility-review` skill is trustworthy but audits WCAG 2.1 AA,
one version behind what this project needs — use it only as a secondary cross-check,
not as the primary tool, or wait/ask upstream if a 2.2 update lands.

Either way: no skill substitutes for reading the actual normative source.
**W3C WCAG 2.2 quick reference (w3.org/WAI/WCAG22/quickref/)** and the spec itself
(w3.org/TR/WCAG22/) remain the ground truth for any AA claim made about this site,
skill-assisted or not.

## (b) German commercial/DSGVO-law compliance (Impressum, Datenschutzerklärung)

### `borghei/AI-Skills-German-Law` — evaluated per the ticket

- **Scope:** 58 legal practice areas / 258 skills, incl. Datenschutz/DSGVO, EU
  frameworks (KI-VO, NIS2, LkSG, DORA), deterministic calculators (Fristen,
  Verjährung, RVG-Gebühren). Dual-licensed **Apache-2.0 / MIT**.
- **Author:** solo individual (`borghei.me`), **no stated legal credentials**
  (not a law firm, not a bar-registered Rechtsanwalt as far as the repo discloses).
  README states content was "built with the assistance of AI tools (Claude, GPT,
  Gemini)."
- **Maintenance/activity:** 35 commits total, latest commit **2026-07-21** (recent,
  ~3 weeks before this research). 17 stars, 2 forks, 0 watchers, 0 open issues,
  0 PRs — very low external engagement/scrutiny for a "legal" resource.
- **Self-disclosed reliability limits (from its own README/verification log):**
  - *"This is not legal advice."* Output is explicitly framed as a draft requiring
    review by a licensed Rechtsanwalt under **§ 43a BRAO / § 2 BORA**.
  - *"AI-generated content ... may contain errors."* Users are told to verify
    case-law citations independently via Beck-Online/juris/openjur.net.
  - Case-law verification is only complete for **12 of 58 areas**, with a
    self-reported **~10% measured error rate** on what has been checked.
  - Explicit liability disclaimer: *"The author accepts no liability. Use at your
    own risk."*
- **Verdict:** This is a hobby/solo project, openly honest about its own
  unreliability, not a vetted legal resource. It should **not** be used to generate
  or wordsmith the actual Impressum or Datenschutzerklärung text that ships on the
  live site — a ~10% verified error rate and single-author, near-zero-review
  activity is disqualifying for a legally binding statutory notice.

### Better-fit alternative found: `waldo-van-der-code/deutsches-recht-mit-claude`

Surfaced via `awesome-claude-code` issue #2060 (validation-passed, resource-submission
labels). Three purpose-built skills, MIT-licensed:

- `/legal-audit` — audits code/URLs for DSGVO/GDPR compliance, detects third-party
  processors (Stripe, Google Analytics, Resend, etc.), flags missing legal bases,
  drafts Datenschutzerklärung sections.
- `/bfsg-check` — generates BFSG (Barrierefreiheitsstärkungsgesetz, mandatory since
  2025-06-28) accessibility declarations — directly relevant to this site's
  accessibility obligations too, not just DSGVO.
- `/widerruf-check` — reviews consent/withdrawal UX against German/EU law.

Key differentiator: these skills fetch **live statutory text from
`rechtsinformationen.bund.de` via an MCP server** at run time instead of relying on
frozen training data — meaningful given how often German statutes are amended. This
is a materially stronger trust posture than a static, unverified citation set. Still
a single-author project, so treat outputs the same way: draft-only, not final legal
text.

### Recommendation for (b)

- Do **not** vendor `borghei/AI-Skills-German-Law` for producing the site's
  Impressum/Datenschutzerklärung — self-disclosed ~10% error rate, unverified
  authorship, minimal external review.
- Optionally trial `waldo-van-der-code/deutsches-recht-mit-claude`'s `/legal-audit`
  and `/bfsg-check` as a **first-pass drafting aid** (live-sourced citations, MIT),
  but gate every output the same way its own ecosystem tells you to: draft only.
- For the text that actually ships: **treat this as a manual/legal task, not a
  Claude Skill task.** Either engage an actual lawyer, or use a vetted, purpose-built
  generator — **e-recht24.de** (Impressum-Generator, Datenschutz-Generator) is the
  standard German industry tool for this and is what should back the real Impressum
  (§ 5 TMG/DDG) and Datenschutzerklärung (DSGVO Art. 13) content for this repo.

## Summary / action items for #4

1. **Accessibility:** install `addyosmani/web-quality-skills` (`accessibility`
   skill, WCAG 2.2, MIT) as the working skill; use W3C's WCAG 2.2 quick reference
   directly for anything the skill is unsure about.
2. **German law:** no skill is trustworthy enough to author the live
   Impressum/Datenschutzerklärung. Gap must be covered manually — via
   e-recht24.de's generators and/or actual legal review — before launch. A skill
   (`deutsches-recht-mit-claude`) may assist as a drafting aid/first pass only.
