---
title: "Duplicated ProfileForm and OAuth Forms in User Module"
type: redundancy
owner: Modules/User
severity: high
created: 2026-05-21
---

# Duplicated ProfileForm and OAuth Forms (User Module)

## Problem
The User module contains multiple near-identical Filament form schemas:

- `ProfileForm.php` (appears 4 times across different contexts)
- Multiple OAuth-related forms duplicated between `User/` and `User/Clusters/Passport/` and `User/Clusters/Socialite/`:
  - `SocialProviderForm.php`
  - `SsoProviderForm.php`
  - `SocialiteUserForm.php`
  - All OAuth token/client forms (`Oauth*Form.php`)

These forms are almost byte-for-byte copies with only minor field differences.

## Impact
- Maintenance nightmare (change in one place, forget the others)
- Inconsistent UX and validation rules across similar resources
- Violates DRY and the "one canonical schema" principle

## Recommended Fix
1. Create reusable schema classes/traits inside `Modules/User/app/Filament/Forms/Schemas/`
   - `ProfileSchema.php`
   - `OAuthProviderSchema.php`
   - `OAuthTokenSchema.php`
2. Refactor all resources to use the shared schemas.
3. Remove the duplicated files.

## Related
- Central redundancy tracker: [Issue #90](https://github.com/laraxot/base_fixcity_fila5/issues/90)
- Similar pattern observed in other modules (see Media `HasMediaForm` duplication report)
