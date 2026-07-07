---
title: "Massive Duplication of BaseModel.php (16 occurrences)"
type: redundancy
owner: Modules/Xot
severity: critical
created: 2026-05-21
---

# Massive Duplication of BaseModel.php (16 copies)

## Problem
`BaseModel.php` exists in **16 different locations** across the monorepo.

This is the single highest duplication count found in the entire audit so far.

## Impact
- The most foundational class of the entire ORM layer is duplicated 16 times.
- Any improvement, bugfix, or new feature in the base model (soft deletes, timestamps, auditing, tenant scoping, etc.) must be applied in 16 places.
- Extremely high risk of divergence and technical debt.
- Completely defeats the purpose of having a strong central `Xot` module.

## Root Cause Hypothesis
Most modules copied `BaseModel.php` from Xot (or from an older version of Xot) instead of simply extending `Modules\Xot\Models\BaseModel`.

## Recommended Fix
1. Enforce that **every** model in the monorepo must extend `Modules\Xot\Models\BaseModel`.
2. Delete all 15 duplicate copies.
3. Add a static analysis / Rector rule that forbids local `BaseModel` definitions.
4. Provide extension points (traits, abstract methods, config) in the central `BaseModel` so modules don't feel the need to copy it.

## Related
- Issue #90 (main redundancy tracker)
- Similar (but smaller) duplication seen in `BasePivot.php` (8 copies) and `BaseMorphPivot.php` (11 copies)
- Strong correlation with the "XotBase* pattern abuse" report
