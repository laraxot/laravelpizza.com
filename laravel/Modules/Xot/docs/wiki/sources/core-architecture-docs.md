---
title: "Xot Core Architecture Docs"
module: "Xot"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[Xot Architecture Guardrails]]"
  - "[[Architecture]]"
---

# Xot Core Architecture Docs

> Source summary for the highest-signal architecture documents in `Modules/Xot/docs/`.

## Source Cluster

- `README.md`
- `LARAXOT_ARCHITECTURE_RULES.md`
- `XOTBASE_ARCHITECTURE_PHILOSOPHY.md`
- `DIRECTORY_STRUCTURE_RULES.md`

## Main Signals

- Xot defines the repository's wrapper-based extension model.
- Xot base classes are presented as the safe path for Filament and shared Laravel integration.
- Actions-over-services is reinforced as a project-wide business-logic rule.
- Directory duplication is treated as both a code smell and a documentation smell.

## Main Risks

- Raw docs contain strong rules but are spread across many files and styles.
- The surrounding raw documentation tree appears historically layered and partially duplicated.
- Retrieval cost is high unless agents start from wiki pages first.

## Recommended Use

Use this source summary when the task involves:

- base class inheritance decisions
- Filament extension patterns
- Xot architectural governance
- documentation cleanup priorities for the Xot module

## References

- [[Xot Architecture Guardrails]]
- [[Architecture]]
