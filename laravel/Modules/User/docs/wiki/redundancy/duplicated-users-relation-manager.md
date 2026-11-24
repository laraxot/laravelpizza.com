---
title: "Duplicated UsersRelationManager (x6 occurrences)"
type: redundancy
owner: Modules/User
severity: high
created: 2026-05-21
related:
  - "./duplicated-auth-widgets.md"
  - "./duplicated-profile-form.md"
  - "./duplicated-ratings-relation-manager.md"
  - "./oauth-dual-resource-trees.md"
---

# Duplicated UsersRelationManager

## Problem
`UsersRelationManager.php` appears **6 times** across the codebase.

This is the highest duplication count found for any RelationManager.

## Locations (from static scan)
- Multiple clusters inside `Modules/User` (Passport, Socialite, main User)
- Possibly re-used or copied in other modules that have user relationships

## Impact
- Same user-relation logic maintained in 6 places
- High risk of divergence when user model or Filament API changes
- Violates the principle of having canonical relation managers in the User module

## Recommended Fix
1. Keep only **one** canonical `UsersRelationManager` in `Modules/User/app/Filament/RelationManagers/`
2. Make all other places import / use the canonical one via namespace or published stub
3. Remove the 5 duplicate copies

## Related
- Issue #90 (main redundancy tracker)
- Similar pattern seen with MediaRelationManager (3 copies)
