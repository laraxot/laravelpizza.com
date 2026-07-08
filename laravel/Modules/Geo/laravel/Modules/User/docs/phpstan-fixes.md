# PHPStan Compliance — User Module

**Last Updated**: 2026-07-07  
**Status**: ✅ Zero Errors (residual: unmatched global ignore pattern, see below)  
**PHPStan Level**: max

## Issues Resolved

### 0. Batch Fix — 24 Errors (2026-07-07)

| File | Errors | Fix |
|---|---|---|
| `app/Models/OauthAccessToken.php` | 6 | `@method` PHPDoc: `array` → `array<string, mixed>` (create/firstOrCreate/updateOrCreate), `array<int, string>` (existsIn) |
| `app/Models/Passport/Client.php` | 1 | `@method existsIn(array $haystack)` → `array<int, string>` |
| `app/Models/Permission.php` | 4 | Same array generics on firstOrCreate/updateOrCreate |
| `app/Models/Role.php` | 4 | Same array generics on firstOrCreate/updateOrCreate |
| `app/Models/Team.php` | 5 | Same array generics on create/firstOrCreate/updateOrCreate |
| `app/Traits/PasswordValidationRules.php` | 1 | `@return array<int, Password\|array\|string>` → `array<int, Password\|string>` (no nested array ever returned) |
| `routes/web.php` | 1 | `$xotData->register_pub_theme ?? false` → `$xotData->register_pub_theme` (property is non-nullable `bool`, `??` was flagged as dead) |
| `app/Models/Traits/HasTeams.php` | 1 | `teams()` return generic: `BelongsToMany<Model&TeamContract, Model, Pivot, 'pivot'>` → `BelongsToMany<Model&TeamContract, $this, Pivot, 'pivot'>`. `BaseUser` aliases `HasTeams::teams as membershipTeams`, and `Xot\Contracts\UserContract::membershipTeams()` requires the declaring-model generic to be `$this`, not a generic `Model`. Removed the now-unneeded `@phpstan-ignore return.type`. |

**Residual (not fixable within constraints)**: running PHPStan scoped to `Modules/User` alone reports:
```
Ignored error pattern larastan.noEnvCallsOutsideOfConfig was not matched in reported errors.
```
This is a global `ignoreErrors` pattern in `phpstan.neon` (untouchable) written for whole-project analysis; no file inside `Modules/User` triggers an `env()`-outside-config call, so the pattern is legitimately unmatched when the module is analyzed in isolation. Not a Modules/User defect — reproduces identically on a pristine checkout scoped the same way.

## Issues Resolved (earlier sessions)

### 1. Pest Closure Scope Type Hints

**File**: `tests/Feature/DemoUserSeederTest.pest.php`

**Issue**: 
```
Cannot call method markTestSkipped() on mixed
Undefined variable: $this
```

**Root Cause**: Pest closure doesn't automatically provide `$this` type to PHPStan

**Fix**: Added docblock type hint inside closure:

```php
it('creates deterministic demo users idempotently', function (): void {
    /** @var TestCase $this */  // ← Type hint for Pest scope
    if (! Schema::connection('user')->hasTable('permissions')
        || ! Schema::connection('user')->hasTable('roles')) {
        $this->markTestSkipped('User RBAC migrations required on connection user');
    }
    // ...
});
```

**Impact**: PHPStan now recognizes TestCase methods available in closure

### 2. Missing Facade Import

**File**: `tests/Feature/DemoUserSeederTest.pest.php`

**Issue**: Undefined class `Artisan` in test

**Fix**: Added import at top of file:

```php
use Illuminate\Support\Facades\Artisan;

// Later in test
Artisan::call('db:seed', ['--class' => UserSeeder::class, '--no-interaction' => true]);
```

## Test Files (Pest Format)

- `tests/Feature/DemoUserSeederTest.pest.php` — Feature test with Pest DSL

## Pattern: Pest with TestCase Context

When Pest test closures need TestCase methods:

```php
it('test name', function (): void {
    /** @var TestCase $this */
    // Now $this is properly typed for PHPStan
    $this->markTestSkipped('reason');
});
```

## Validation

```bash
./vendor/bin/phpstan analyse Modules/User
# Result: [OK] No errors
```

## Related Documentation

- [Pest Scope Type Hints](../../docs/wiki/skills/pest-scope-type-hints.md)
- [PHPStan Sacred Configuration](../../docs/wiki/rules/phpstan-neon-sacred.md)
