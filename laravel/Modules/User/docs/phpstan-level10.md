# User Module - PHPStan Level 10 Analysis

## 📊 Current Status

**Analysis Date**: 2026-01-13  
**PHPStan Level**: 10  
**Total Errors**: **5**  
**Files with Errors**: 4  
**Command**: `./vendor/bin/phpstan analyse Modules/User --level=10`

## 🎯 Summary

Excellent result! Only **5 errors** in the User module after fixing critical Passport contract issues. All errors are minor and easily fixable.

## 📈 Error Breakdown

### By Type
1. **function.alreadyNarrowedType**: 1 error (20%) - Unnecessary type check
2. **return.type**: 3 errors (60%) - Generic type mismatches
3. **argument.type**: 1 error (20%) - Array type mismatch

### By File
1. `ClientResource.php` - 1 error (unnecessary type check)
2. `OauthClient.php` - 1 error (MorphTo return type)
3. `HasTeams.php` - 2 errors (BelongsToMany return type)
4. `PassportServiceProvider.php` - 1 error (array type)

## 🔍 Detailed Error Analysis

### Error 1: Unnecessary Type Check (TRIVIAL)
**File**: `app/Filament/Resources/ClientResource.php:71`  
**Type**: `function.alreadyNarrowedType`

```php
// Line 71
Call to function is_string() with string will always evaluate to true.
```

**Cause**: Variable is already typed as `string`, so `is_string()` check is redundant

**Fix**: Remove unnecessary `is_string()` check

**Priority**: 🟢 Low (code cleanup)  
**Complexity**: ⭐ Trivial  
**Time**: 2 minutes

---

### Error 2: MorphTo Generic Type (MINOR)
**File**: `app/Models/OauthClient.php:180`  
**Type**: `return.type`

```php
Method Modules\User\Models\OauthClient::owner() should return 
MorphTo<Illuminate\Foundation\Auth\User, ...> but returns 
MorphTo<Illuminate\Database\Eloquent\Model, ...>
```

**Cause**: `morphTo()` returns generic `Model` type, but we expect `User` type

**Fix**: Add PHPDoc annotation to specify correct generic type

```php
/**
 * @return MorphTo<\Illuminate\Foundation\Auth\User, $this>
 */
public function owner(): MorphTo
{
    return $this->morphTo();
}
```

**Priority**: 🟡 Medium (type safety)  
**Complexity**: ⭐⭐ Simple  
**Time**: 5 minutes

---

### Error 3 & 4: BelongsToMany Generic Type (MINOR)
**File**: `app/Models/Traits/HasTeams.php:473, 476`  
**Type**: `return.type`

```php
Method teams() should return BelongsToMany<..., Pivot, 'pivot'> 
but returns BelongsToMany<..., TeamUser, 'pivot'>
```

**Cause**: Using custom pivot model `TeamUser` instead of generic `Pivot`

**Issue**: Template type `TPivotModel` is not covariant (see PHPStan blog)

**Fix Options**:
1. **Option A** (Recommended): Update PHPDoc to match actual return type
2. **Option B**: Use generic `Pivot` class (loses custom pivot functionality)

**Recommended Fix**:
```php
/**
 * @return BelongsToMany<Model&TeamContract, $this, TeamUser, 'pivot'>
 */
public function teams(): BelongsToMany
{
    return $this->belongsToManyX(Team::class, 'team_user')
        ->using(TeamUser::class)
        ->withPivot(['role', 'permissions']);
}
```

**Priority**: 🟡 Medium (type safety)  
**Complexity**: ⭐⭐ Simple  
**Time**: 10 minutes

---

### Error 5: Array Type Mismatch (MINOR)
**File**: `app/Providers/PassportServiceProvider.php:158`  
**Type**: `argument.type`

```php
Parameter #1 $scopes of static method Passport::tokensCan() 
expects array<string, string>, array given.
```

**Cause**: Array doesn't have explicit `<string, string>` type annotation

**Fix**: Add explicit type annotation or cast

```php
/** @var array<string, string> $scopes */
$scopes = [
    'view-user' => 'View user information',
    'manage-users' => 'Manage users',
];
Passport::tokensCan($scopes);
```

**Priority**: 🟡 Medium (type safety)  
**Complexity**: ⭐ Trivial  
**Time**: 5 minutes

---

## 🗺️ Fix Roadmap

### Phase 1: Quick Wins (15 minutes)
1. ✅ **ClientResource.php** - Remove unnecessary `is_string()` check
2. ✅ **PassportServiceProvider.php** - Add array type annotation
3. ✅ **OauthClient.php** - Add PHPDoc for `owner()` method

### Phase 2: Relationship Types (10 minutes)
4. ✅ **HasTeams.php** - Update PHPDoc for `teams()` method (both occurrences)

### Total Estimated Time: **25 minutes**

---

## 🔧 Implementation Plan

### Step 1: ClientResource.php
```php
// Before (Line 71)
if (is_string($value)) {
    return $value;
}

// After
return $value; // Already typed as string
```

### Step 2: PassportServiceProvider.php
```php
// Before (Line ~158)
$scopes = [...];
Passport::tokensCan($scopes);

// After
/** @var array<string, string> $scopes */
$scopes = [...];
Passport::tokensCan($scopes);
```

### Step 3: OauthClient.php
```php
// Add PHPDoc before owner() method
/**
 * Get the owner of the OAuth client.
 *
 * @return MorphTo<\Illuminate\Foundation\Auth\User, $this>
 */
public function owner(): MorphTo
{
    return $this->morphTo();
}
```

### Step 4: HasTeams.php
```php
// Update PHPDoc for teams() method
/**
 * Get all teams the user belongs to.
 *
 * @return BelongsToMany<Model&TeamContract, $this, TeamUser, 'pivot'>
 */
public function teams(): BelongsToMany
{
    // ... existing implementation
}
```

---

## ✅ Verification Plan

After implementing fixes:

```bash
# Re-run PHPStan
./vendor/bin/phpstan analyse Modules/User --level=10

# Expected: 0 errors

# Run PHPMD
./vendor/bin/phpmd Modules/User text cleancode,codesize,controversial,design,naming,unusedcode

# Run PHPInsights
php artisan insights Modules/User --no-interaction
```

---

## 📝 Notes

### Why So Few Errors?
1. **Passport fixes cascade**: Fixing `PassportHasApiTokensContract` in Xot resolved many User module errors
2. **Good code quality**: User module already follows best practices
3. **Strong typing**: Most methods already have proper type hints

### Impact on Other Modules
These fixes are **local to User module** and won't affect other modules.

---

## 🔗 Related Files

- [BaseUser.php](file:///var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/app/Models/BaseUser.php) - Already fixed
- [PassportHasApiTokensContract.php](file:///var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php) - Fixed in Xot
- [Passport Documentation](file:///var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/docs/passport.md)

---

**Status**: 📋 Ready for Implementation  
**Estimated Time**: 25 minutes  
**Complexity**: ⭐⭐ Simple  
**Priority**: 🟡 Medium
