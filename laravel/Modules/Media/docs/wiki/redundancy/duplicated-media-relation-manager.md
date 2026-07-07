---
title: "Duplicated MediaRelationManager (3 occurrences)"
type: redundancy
owner: Modules/Media
severity: medium-high
created: 2026-05-21
---

# Duplicated MediaRelationManager

## Problem
`MediaRelationManager.php` is duplicated in at least 3 places.

This is a core cross-cutting component that should be canonical.

## Impact
- Inconsistent media attachment behavior across modules
- Risk of different configurations (collections, conversions, permissions)
- Maintenance burden when Spatie MediaLibrary or Filament changes

## Recommended Fix
- Have only **one** `MediaRelationManager` in `Modules/Media/app/Filament/RelationManagers/`
- All other modules should reference it instead of copying the file
- Provide extension points (hooks, config, traits) instead of duplication

## Related
- See also the broader "HasMedia logic scattered" report in the same folder
- Central redundancy tracker: #90
