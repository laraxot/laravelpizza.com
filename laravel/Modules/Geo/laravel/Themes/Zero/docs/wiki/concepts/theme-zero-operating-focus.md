---
title: "Theme Zero Operating Focus"
module: "Zero"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T07:22:00Z"
related:
  - "[[Theme Zero Product and Roadmap Docs]]"
---

# Theme Zero Operating Focus

> Stable summary of Theme Zero as the baseline visual system for the repository.

## Positioning

Theme Zero is documented as the default and foundational theme. Its primary value is not visual novelty, but providing a reusable, coherent frontoffice base that other themes and modules can rely on.

## Guardrails

- Keep Theme Zero minimal, reusable, and truthful to the actual implementation.
- Prioritize foundation, scope clarity, and docs-code alignment over cosmetic expansion.
- Reuse UI and Xot abstractions rather than introducing parallel frontend patterns.
- Treat docs as an agent handoff layer, not only as product collateral.

## Current Documentation Reality

Theme Zero has a richer raw documentation layer than Theme One and already carries governance, strategy, architecture, and chart/PDF integration material. That makes it strategically important, but also increases the chance of drift.

## Retrieval Heuristic

Start from this page, then use the product and roadmap summary page. Open raw docs only for the specific frontend capability being touched, such as layout, charts, documentation workflow, or PHPStan quality gates.

## Theme Zero-local Second Brain Loop

For frontoffice and baseline UX tasks:

1. Start from Theme Zero wiki pages to validate scope and baseline responsibilities.
2. Open only the raw docs needed by the current UI decision.
3. Distill the result into one concise page update focused on why the decision exists.
4. Record the operation in local `log.md` and keep `index.md` discoverable.
5. Promote shared design/system rules to root `docs/wiki/` when they impact other themes or modules.

## References

- [[Theme Zero Product and Roadmap Docs]]
- `../../README.md`
- `../../product-strategy.md`
- `../../roadmap.md`
