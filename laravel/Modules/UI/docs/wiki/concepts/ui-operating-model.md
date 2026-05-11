---
title: "UI Operating Model"
module: "UI"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T07:22:00Z"
related:
  - "[[Theme Integration]]"
  - "[[UI Architecture Sources]]"
---

# UI Operating Model

> Stable summary of what the UI module is for and how to reason about its architecture.

## Role

The UI module is the shared abstraction layer for interface primitives across the repository:

- Blade components
- Filament custom form fields and columns
- dashboard and layout widgets
- block-based content composition
- reusable layout behaviors such as table view switching

## Architectural Guardrails

- Reusable interface primitives belong in `UI`, not scattered across feature modules.
- UI abstractions should centralize shared admin-panel behavior instead of letting modules reimplement common patterns.
- Integration with Filament should still respect Xot architectural rules.
- Documentation drift is a real risk because the raw docs mix architecture, product, bugs, migration notes, and duplicated filename variants.

## Retrieval Heuristic

Use the UI wiki first when a task involves:

- component placement
- Filament UI extension patterns
- block system decisions
- theme integration boundaries

Then open only the raw docs cluster directly tied to the component or interaction being changed.

## UI-local Second Brain Loop

When a task concerns shared interface behavior:

1. Start from UI wiki concepts to clarify user-facing intent and reuse boundaries.
2. Inspect only raw docs directly related to the component under change.
3. Distill the outcome into one canonical UI rule/page to avoid duplication.
4. Update local `log.md` with the architectural rationale.
5. Escalate cross-module conventions to root `docs/wiki/` when they become global.

## Risks Seen in Raw Docs

- repeated files across kebab, snake, archive, and suffixed variants
- multiple architecture summaries with overlapping scope
- a very large raw corpus that is expensive to query repeatedly without local summaries

## References

- [[UI Architecture Sources]]
- `../../README.md`
- `../../ARCHITECTURE.md`
- `../../PRODUCT_STRATEGY.md`
- `../../architecture/structure.md`
