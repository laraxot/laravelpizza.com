# User Module - PHPStan Error Resolution Roadmap

This document outlines the steps to resolve the PHPStan errors found in the User module.

## Error Summary

The errors in the User module are related to undefined methods, incorrect PHPDoc annotations, and type mismatches.

1.  **`BaseUser.php`**:
    *   Undefined method `passportTokenCan`.
    *   `tokenCan` should return `bool` but returns `mixed`.
    *   Undefined method `passportCreateToken`.
    *   `createToken` should return `Laravel\Passport\PersonalAccessTokenResult` but returns `mixed`.
    *   Undefined method `passportWithAccessToken`.
    *   `is_string` check on `mixed` will always be false.
2.  **`Role.php`**:
    *   PHPDoc for `created_at` and `updated_at` contains unknown class `Modules\User\Models\Carbon`.
    *   PHPDoc for `permissions` contains unknown class `Modules\User\Models\Collection`.
    *   PHPDoc for `users` contains unknown class `Modules\User\Models\EloquentCollection`.
    *   PHPDoc for `users` contains unknown class `Modules\User\Models\UserContract`.
3.  **`Traits/HasTeams.php`**:
    *   Unnecessary nullsafe operator `?->`.
    *   Call to `pluck` on an unknown class `Modules\User\Models\Collection`.
    *   Calls to `toArray` and `values` on `mixed`.
    *   `array_merge` expects array, `mixed` given.
    *   `teamPermissions` should return `array<int, string>` but returns `list`.
    *   `array_unique` expects array, `mixed` given.
    *   `switchTeam` expects `Modules\User\Contracts\TeamContract|null`, `mixed` given.

## Resolution Plan

I will address these errors by correcting the code and type hints in each file.

1.  **`BaseUser.php`**:
    *   It seems the `Laravel\Passport\HasApiTokens` trait is not correctly used or recognized. I will ensure it is properly imported and used. This should resolve the undefined method calls.
    *   I will investigate the `is_string` check and correct the logic.
2.  **`Role.php`**:
    *   I will correct the PHPDoc annotations to use the fully qualified class names (`Illuminate\Support\Carbon`, `Illuminate\Database\Eloquent\Collection`, etc.).
3.  **`Traits/HasTeams.php`**:
    *   I will remove the unnecessary nullsafe operator.
    *   I will fix the type hints to ensure the methods are called on the correct types. This will involve adding appropriate type hints for variables and properties.

After each fix, I will run `phpstan analyse Modules/User` to ensure the error is resolved.
