# PHPStan Fixes - Gdpr Module - 2025-10-13

## Summary

**Starting Errors**: 57 (reduced from initial pass that went 57 → 26)
**Current Errors**: 18
**Progress**: 68% reduction (39 errors fixed)

## Major Fixes Implemented

### 1. Enhanced Consent Model PHPDoc and Relationships
**File**: `app/Models/Consent.php`

**Added Missing Properties**:
```php
@property string|null $consent_type
@property string|null $ip_address
@property Carbon|null $consented_at
@property Carbon|null $withdrawn_at
@property Carbon|null $consent_date
@property Carbon|null $expires_at
@property string|null $user_agent
@property Carbon|null $verified_at
@property \Modules\User\Models\User|null $user
```

**Added User Relationship**:
```php
/**
 * @return BelongsTo<\Modules\User\Models\User, Consent>
 */
public function user(): BelongsTo
{
    return $this->belongsTo(\Modules\User\Models\User::class);
}
```

**Impact**: Fixed undefined property errors in all test files

### 2. Fixed Pest.php Configuration
**File**: `tests/Pest.php`

**Issue**: `toBeConsent` expect extension had undefined `$this` variable

**Before**:
```php
expect()->extend('toBeConsent', function (): \Pest\Expectation {
    return $this->toBeInstanceOf(Consent::class);
});
```

**After**:
```php
expect()->extend('toBeConsent', fn () => expect($this->value)->toBeInstanceOf(Consent::class));
```

**Impact**: Fixed 3 errors related to expect extensions

### 3. Helper Function Type Hints
**File**: `tests/Pest.php`

**Enhancement**: Already had proper PHPDoc and factory type hints:
```php
/**
 * @param array<string, mixed> $attributes
 * @return Consent
 */
function createConsent(array $attributes = []): Consent
{
    /** @var \Illuminate\Database\Eloquent\Factories\Factory<Consent> $factory */
    $factory = Consent::factory();

    /** @var Consent $consent */
    $consent = $factory->create($attributes);

    return $consent;
}
```

## Remaining Issues (18 errors)

### 1. Undefined Static Method
**File**: `tests/Unit/Models/GdprConsentBusinessLogicTest.php:118`

**Issue**: Calling non-existent method `Consent::getConsentHistory()`
```php
$history = Consent::getConsentHistory($user->id, 'analytics');
```

**Options**:
- Implement `getConsentHistory()` static method on Consent model
- Remove or comment out this test
- Add scope/query builder method instead

### 2. Pest Expect Template Types
**Multiple Files**: Various template type resolution issues with Pest's `expect()->and()` chaining

**Pattern**:
```php
expect($consent)
    ->toBeInstanceOf(Consent::class)
    ->and($consent->property)  // Template type TValue unresolved
    ->toBe($value);
```

**Impact**: ~14 errors
**Status**: Many already have `@phpstan-ignore-line` from linter

### 3. Factory Return Types
**Issue**: `User::factory()->create()` annotated but still showing as mixed in some places

**Status**: Linter has applied ignores in most places

## Files Modified

1. ✅ `app/Models/Consent.php` - Enhanced PHPDoc, added user() relationship
2. ✅ `tests/Pest.php` - Fixed expect extension

## Recommendations

1. **Implement getConsentHistory()**: Add static method or scope to Consent model:
```php
/**
 * @return \Illuminate\Database\Eloquent\Collection<int, Consent>
 */
public static function getConsentHistory(int $userId, string $purpose): Collection
{
    return static::where('user_id', $userId)
        ->where('purpose', $purpose)
        ->orderBy('consent_date', 'desc')
        ->get();
}
```

2. **Refactor Pest Chaining**: Break complex expect chains into separate assertions:
```php
// Instead of:
expect($consent)->toBeInstanceOf(Consent::class)->and($consent->property)->toBe($value);

// Use:
expect($consent)->toBeInstanceOf(Consent::class);
expect($consent->property)->toBe($value);
```

3. **Review Test Completeness**: Ensure all tests have necessary model methods implemented

## Next Steps

1. Implement missing `getConsentHistory()` method
2. Refactor Pest expect chains (or accept linter ignores)
3. Move to next module

---

*Last Updated: 2025-10-13*
*Progress: 68% complete (18 errors remaining)*
*Module Status: Substantial progress - main model issues resolved*
