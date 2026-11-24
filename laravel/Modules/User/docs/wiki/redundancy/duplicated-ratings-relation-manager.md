---
title: "Duplicated RatingsRelationManager (3 occurrences)"
type: redundancy
owner: Modules/User
severity: medium
created: 2026-05-21
related:
  - "./duplicated-auth-widgets.md"
  - "./duplicated-profile-form.md"
  - "./duplicated-users-relation-manager.md"
  - "./oauth-dual-resource-trees.md"
---

# Duplicated RatingsRelationManager

## Problem
`RatingsRelationManager.php` appears in at least 3 different places.

## Impact
- Same rating attachment logic duplicated
- Risk of inconsistent rating behavior across different entities
- Maintenance burden

## Recommended Fix
- Centralize in `Modules/Rating` (or a shared place) and make other modules consume it via relation manager or reusable component.

## Related
- Issue #90
