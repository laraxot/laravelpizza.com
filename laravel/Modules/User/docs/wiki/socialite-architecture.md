---
title: "Socialite Authentication Architecture"
type: concept
tags: [socialite, architecture]
created: 2026-07-14
updated: 2026-07-14
qmd: "socialite-architecture socialite authentication architecture"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
<<<<<<< .merge_file_uC0Ftj
<<<<<<< HEAD
  - "./agents-2.md"
=======
<<<<<<< HEAD
  - "./agents.md"
<<<<<<< .merge_file_Y4Q7li
=======
=======
  - "./agents-2.md"
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_NFekXM
=======
  - "./agents.md"
>>>>>>> .merge_file_29NT3m
  - "./architecture.md"
  - "./auth-patterns.md"
  - "./bmad-method.md"
  - "./context-compression.md"
  - "./index.md"
  - "./log.md"
  - "./overview.md"
---

# Socialite Authentication Architecture

## Core Rule
- Never add provider IDs to `users` table
- Use `SocialiteUser` model (socialite_users table)

## Architecture
```php
users.id → foreign key in socialite_users
provider_id → unique provider identifier
token, name, email, avatar
```

## Why
- Zero DB bloat from multiple provider columns
- Supports unlimited providers
- Standardized OAuth handling

## Forms Action
```php
// Example action
app(CreateSocialiteUserAction::class)->execute($provider, $oauthUser, $user);
```

## References
- `laravel/Modules/User/docs/wiki/concepts/socialite-architecture.md`
- 8-27 story fix