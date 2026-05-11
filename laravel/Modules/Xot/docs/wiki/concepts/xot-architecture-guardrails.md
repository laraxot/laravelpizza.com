---
title: "Xot Architecture Guardrails"
module: "Xot"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T07:22:00Z"
related:
  - "[[Actions Over Services]]"
  - "[[XotBaseResource]]"
  - "[[Architecture]]"
---

# Xot Architecture Guardrails

> Stable rules extracted from Xot raw docs that should be treated as architectural constraints, not optional style advice.

## Why This Matters

Xot is the foundational module for the rest of the repository. When its architectural rules drift, every downstream module inherits the confusion.

The raw docs consistently point to one central idea: Xot base classes are the contract surface for the project.

## Core Rules

- Do not extend Laravel or Filament base classes directly when an Xot base wrapper exists.
- Treat Xot base classes as architectural contracts, not convenience helpers.
- Prefer actions over services for business logic execution.
- Keep directory layouts DRY and avoid duplicated nested structures such as `lang/lang/`.
- Keep translation behavior convention-driven instead of hardcoding labels and placeholders in components.

## Implementation Consequences

- Filament resources, pages, and widgets should inherit from the relevant `XotBase*` class.
- Shared behavior belongs in Xot abstractions and traits, not repeatedly in feature modules.
- Module-level code should only provide business-specific logic on top of Xot contracts.
- Directory structure fixes should remove duplication at the source instead of documenting exceptions around it.

## Documentation Risks Found in Raw Docs

- The raw `docs/` tree contains overlapping architecture, quality, and integration notes.
- File naming is mixed across uppercase, lowercase, underscored, dashed, and duplicated variants.
- Multiple integration subtrees suggest historical accumulation without a single curated summary layer.

These conditions make `docs/wiki/` necessary as the retrieval layer for durable guidance.

## Recommended Query Order

1. Start from this page for foundational Xot constraints.
2. Open raw docs only for the specific topic being implemented.
3. Persist any new stable rule back into the Xot wiki and, if cross-cutting, into the root project wiki.

## Xot-local Second Brain Loop

When the task touches cross-module contracts or base abstractions:

1. Start from this page and from `index.md` to frame the architectural purpose first.
2. Open only the minimum raw docs needed to validate a rule.
3. Distill the decision into one concise, reusable rule in Xot wiki pages.
4. Update local `log.md` for traceability.
5. If the rule affects multiple modules, also persist it in `docs/wiki/` at project root.

## References

- [[Actions Over Services]]
- [[XotBaseResource]]
- [[Architecture]]
- `../../README.md`
- `../../LARAXOT_ARCHITECTURE_RULES.md`
- `../../XOTBASE_ARCHITECTURE_PHILOSOPHY.md`
- `../../DIRECTORY_STRUCTURE_RULES.md`
