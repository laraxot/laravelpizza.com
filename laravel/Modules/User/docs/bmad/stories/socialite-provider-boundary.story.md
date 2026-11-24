---
title: "Story: move Socialite config to SocialiteServiceProvider"
type: story
module: User
status: done
created: 2026-10-05
updated: 2026-10-05
related:
  - ../socialite-provider-boundary-product-brief.md
  - ../socialite-provider-boundary-prd.md
  - ../socialite-provider-boundary-architecture.md
---

# Story: move Socialite config to SocialiteServiceProvider

## Context

The User module already has a dedicated `SocialiteServiceProvider`, but `UserServiceProvider` still contains Socialite-specific configuration merge logic. This blurs provider responsibilities and makes the generic User bootstrap aware of OAuth provider details.

## Scope

Move the `services.*` → `user.social-providers.*` credential merge from `UserServiceProvider` to `SocialiteServiceProvider` without changing config keys or runtime behavior.

## Acceptance criteria

- [x] `UserServiceProvider` has no Socialite-specific provider list or credential merge method.
- [x] `SocialiteServiceProvider` loads both admin socialite config and credentials from `config/services.php`.
- [x] `php artisan package:discover --ansi` succeeds.
- [x] `php artisan --version` succeeds.

## Implementation notes

Keep existing provider registration in `module.json`. Do not add controllers or new dependencies.

## Verification

- `php -l` passes for both providers.
- `php artisan package:discover --ansi` passes.
- Targeted PHPStan for both providers passes with no errors.
