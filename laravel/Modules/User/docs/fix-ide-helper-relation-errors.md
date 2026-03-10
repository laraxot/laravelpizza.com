# Fix IDE Helper Relation Errors

## Problem Statement

The `php artisan ide-helper:models -W` command was reporting errors in the `User` module:

- `Error resolving relation model of Modules\User\Models\OauthAccessToken:user() : Attempt to read property "provider" on null`.
- `Error resolving relation model of Modules\User\Models\OauthToken:user() : Attempt to read property "provider" on null`.

This happened because Passport's default `user()` relation attempts to access guard configuration that may not be available during static analysis.

## Solution

### 1. Canonical token model alignment

The stable model for Passport Eloquent token consumers is `Modules\User\Models\OauthToken`, which extends `Laravel\Passport\Token` directly.

`Modules\User\Models\OauthAccessToken` must not be treated as the primary Passport Eloquent token source when that would force the codebase toward non-Eloquent vendor classes.

### 2. No ad-hoc fallback relations

The previous workaround based on custom fallback logic inside `user()` relations is no longer the preferred pattern.

The current preferred rule is:

- keep `OauthToken` aligned with the real Passport Eloquent model;
- delegate to Passport where the parent model is correct;
- fix ide-helper/PHPStan drift by aligning wrappers, PHPDoc generics, and consumer code instead of inventing synthetic fallback relations.

## Verification

- Re-run `php artisan ide-helper:models -W` from `laravel/` after docs-first preparation.
- Then validate the generated model PHPDoc against:
  - `./vendor/bin/phpstan analyse Modules/User --error-format=raw`
  - `./vendor/bin/phpstan analyse Modules`

## Operational Note (2026-03-10)

- Future `ide-helper:models -W` runs must be handled as a tracked wave:
  - update docs first (global + module/theme),
  - update GitHub issue/discussion progress,
  - then execute command and close all findings with forward-only patches.
