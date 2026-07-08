---
title: "HasMedia Logic Implemented Outside the Canonical Media Module"
type: redundancy
owner: Modules/Media
severity: high
created: 2026-05-21
---

# HasMedia Logic Scattered Across the Codebase

## Problem
Multiple modules (Cms, User, Notify, Blog, Rating, etc.) directly use Spatie MediaLibrary traits, relations, or custom media handling instead of going through the central `Modules/Media` package.

Evidence from static scan:
- Many models in other modules declare `HasMedia` or custom media collections
- Custom upload logic, collections, and conversion definitions duplicated
- Tests and Filament resources re-implement media attachment instead of using `MediaRelationManager` or the canonical `HasMediaResource`

## Impact
- Inconsistent media behavior between modules
- Security / permission rules can diverge
- Very hard to evolve the media system (e.g. new storage driver, new conversion pipeline)
- Violates the "Media as a cross-cutting module" architecture decision

## Recommended Fix
1. Forbid direct `HasMedia` usage outside the Media module (add PHPStan rule or Rector).
2. Force all other modules to use the official `HasMediaRelation` / `MediaRelationManager` / helper actions provided by `Modules/Media`.
3. Move any remaining custom media logic into the Media module as reusable components.

## Related
- Issue #90
- Central Media documentation in `Modules/Media/docs/wiki/redundancy/`
