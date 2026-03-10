# Fix IDE Helper Relation Errors

## Problem Statement
The `php artisan ide-helper:models -W` command was reporting errors in the `User` module:
- `Error resolving relation model of Modules\User\Models\OauthAccessToken:user() : Attempt to read property "provider" on null`.
- `Error resolving relation model of Modules\User\Models\OauthToken:user() : Attempt to read property "provider" on null`.
This happened because Passport's default `user()` relation attempts to access guard configuration that may not be available during static analysis.

## Solution
### 1. Overridden Passport Relations
Explicitly defined the `user()` relation in `OauthAccessToken` and `OauthToken` models:
- Resolved the user model directly from `config('auth.providers.users.model')`.
- Added safety checks to return an empty relation if the configuration is missing.
- This bypasses Passport's internal dynamic resolution that fails during `ide-helper` runs.

## Verification
- Ran `php artisan ide-helper:models -W` and confirmed that the "Attempt to read property 'provider' on null" errors are resolved.
