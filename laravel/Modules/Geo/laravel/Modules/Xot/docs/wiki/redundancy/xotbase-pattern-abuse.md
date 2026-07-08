---
title: "XotBase* Pattern Abuse – Copy Instead of Extend"
type: redundancy
owner: Modules/Xot
severity: high
created: 2026-05-21
---

# XotBase* Pattern Abuse (Copy-Paste Instead of Inheritance)

## Problem
Many modules copy entire `XotBase*` classes (Resource, Form, Table, Infolist, Action, etc.) into their own namespace and then customize them, instead of properly extending the central ones provided by `Modules/Xot`.

This was observed particularly strongly in:
- Geo module (multiple copied base classes)
- Cms module (multiple form/table copies)
- Several other modules showing the same anti-pattern

## Impact
- When the central XotBase* classes evolve (bug fixes, new features, Filament v5 changes), the copied versions become stale.
- Massive technical debt and merge conflicts during upgrades.
- Violates the whole purpose of having a strong `Xot` core module.

## Recommended Fix
1. Forbid (via Rector / PHPStan / review) the practice of copying `XotBase*` classes.
2. Force extension + override of only the needed methods.
3. Gradually replace all existing copies with proper inheritance.
4. Add a dedicated rule in the redundancy wiki + automated check.

## Related
- Issue #90
- Central Xot documentation
