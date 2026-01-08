# Vendor Contract Patterns - Critical Rule

## Date Created
2025-12-12

## Core Principle

**When creating contracts that mirror vendor package traits/interfaces, the vendor package ALWAYS commands the signature.**

> **Italian**: "Siccome è una libreria, è lui che comanda e facciamo i contracts seguendo quello che comanda il pacchetto dentro la vendor"

## The Problem

When you create a contract (interface) that models functionality from a vendor package, and then implement that contract using the vendor's trait, you can get method signature incompatibility errors if the contract has stricter type declarations than the vendor trait.

### Example Error

```
Declaration of Modules\User\Models\BaseUser::token() must be compatible with
Modules\Xot\Contracts\PassportHasApiTokensContract::token():
Laravel\Passport\Token|Laravel\Passport\TransientToken|null
```

This happens because:
1. Laravel Passport's `HasApiTokens` trait has `public function token()` (no return type)
2. Our contract declared `public function token(): Token|TransientToken|null` (with return type)
3. PHP considers these incompatible when the class uses the trait and implements the interface

## The Solution

**Always match the vendor package's method signatures exactly.**

### Before (Incorrect)

```php
// ❌ WRONG - Contract has stricter types than vendor trait
namespace Modules\Xot\Contracts;

interface PassportHasApiTokensContract
{
    public function token(): Token|TransientToken|null;
    public function tokenCan(string $scope): bool;
    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult;
    public function withAccessToken(Token|TransientToken $accessToken);
}
```

### After (Correct)

```php
// ✅ CORRECT - Contract matches vendor trait signatures exactly
namespace Modules\Xot\Contracts;

interface PassportHasApiTokensContract
{
    /**
     * Get the current access token being used by the user.
     *
     * @return Token|TransientToken|null
     */
    public function token();

    /**
     * Determine if the current API token has a given scope.
     *
     * @param string $scope
     * @return bool
     */
    public function tokenCan($scope);

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array<int, string> $scopes
     * @return PersonalAccessTokenResult
     */
    public function createToken($name, array $scopes = []);

    /**
     * Set the current access token for the user.
     *
     * @param Token|TransientToken $accessToken
     * @return $this
     */
    public function withAccessToken($accessToken);
}
```

## Key Points

1. **No return type declarations** - If the vendor trait doesn't have them, neither should the contract
2. **No parameter type declarations** - Match the vendor's parameter types exactly
3. **Keep PHPDoc comments** - Use PHPDoc to document types for PHPStan/IDE support
4. **Vendor commands** - The library's signature takes precedence over our preferences

## Why This Matters

- **Compatibility**: Prevents method signature mismatch errors
- **Upgradeability**: Easier to upgrade vendor packages without breaking contracts
- **Maintainability**: Clear pattern to follow when creating new contracts
- **Backwards Compatibility**: Vendor packages often don't add types for BC reasons

## Process for Creating Vendor-Based Contracts

1. **Read the vendor trait/class** first
2. **Copy method signatures exactly** (including lack of type hints)
3. **Add PHPDoc comments** for type information
4. **Test with PHPStan** to ensure no compatibility issues
5. **Document** the pattern if it's a new vendor package

## Common Vendor Packages

- **Laravel Passport** (`HasApiTokens` trait) - No method type hints
- **Spatie Laravel Permission** - Some type hints
- **Laravel Sanctum** - Varies by version
- **Filament** - Modern type hints

## Related Files

- `/laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`
- `/laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`
- `/laravel/Modules/User/app/Models/BaseUser.php`
- `/laravel/vendor/laravel/passport/src/HasApiTokens.php`

## References

- [PHP RFC: Covariance and Contravariance](https://wiki.php.net/rfc/covariant-returns-and-contravariant-parameters)
- [Laravel Passport Documentation](https://laravel.com/docs/passport)
- [PHPStan Documentation](https://phpstan.org/)

---

**Maintained by**: Claude Sonnet 4.5
**Last updated**: 2025-12-12
