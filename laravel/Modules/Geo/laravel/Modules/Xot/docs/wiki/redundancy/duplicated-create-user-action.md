---
title: "Duplicated CreateUserAction (4 occurrences)"
type: redundancy
owner: Modules/Xot
severity: high
created: 2026-05-21
---

# Duplicated CreateUserAction

## Problem
`CreateUserAction.php` appears **4 times** in the codebase:

| Path | Namespace |
|------|-----------|
| `User/app/Actions/CreateUserAction.php` | `Modules\User\Actions` |
| `User/Actions/CreateUserAction.php` | `Modules\User\Actions` (**fuori PSR-4** — `composer.json` autoload solo `app/`) |
| `User/app/Actions/User/CreateUserAction.php` | `Modules\User\Actions\User` (**canonico** — usato dai test) |
| `User/app/Actions/Socialite/CreateUserAction.php` | `Modules\User\Actions\Socialite` |

This is business logic duplication at the action level (the most dangerous kind).

## Impact
- Same user creation logic (validation, password handling, notifications, tenant scoping, etc.) maintained in 4 places
- High risk of security or business rule divergence
- Extremely hard to evolve (e.g. adding email verification, 2FA, consent, etc.)

## Recommended Fix
1. Have a single canonical `CreateUserAction` (probably in `Modules/User` or a shared `UserActions` package).
2. All other occurrences should delegate to or extend the canonical one.
3. Remove the duplicates.

## Related
- Issue #90
- Similar duplication seen in many other `Save*ArrayAction`, `Morph*Action`, etc.
