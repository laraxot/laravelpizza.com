# Laravel 11+ Casts Pattern - CRITICAL UPDATE

## ⚠️ DEPRECATED: `protected $casts` Property

**As of Laravel 11**, the `protected $casts` property is **DEPRECATED** and should be replaced with the `protected function casts(): array` method.

## ✅ New Pattern (Laravel 11+)

### Correct Implementation

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'settings' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### Benefits of `casts()` Method

1. **Enhanced Flexibility**: Allows use of static methods on built-in casters
   ```php
   protected function casts(): array
   {
       return [
           'options' => AsEnumCollection::of(UserOption::class),
           'status' => UserStatus::class,
       ];
   }
   ```

2. **Better Type Safety**: Method return type ensures correct array structure

3. **Improved Readability**: More explicit and maintainable

4. **Future-Proof**: Recommended approach in Laravel 11+

## ❌ Old Pattern (DEPRECATED)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var array<string, string>
     * @deprecated Use casts() method instead
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

## 🔄 Migration Guide

### Step 1: Identify All Occurrences
```bash
# Find all models using old pattern
grep -r "protected \$casts\s*=" --include="*.php" Modules/
```

### Step 2: Convert to Method
```php
// Before
protected $casts = [
    'is_active' => 'boolean',
    'settings' => 'array',
];

// After
protected function casts(): array
{
    return [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];
}
```

### Step 3: Remove PHPDoc if Present
```php
// Remove this
/**
 * @var array<string, string>
 */
protected $casts = [...];

// Keep this (optional but recommended)
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [...];
}
```

## 📋 Backward Compatibility

- The `protected $casts` property **still works** in Laravel 11 for backward compatibility
- If both property and method exist, the method takes precedence
- Framework merges both, with method definitions overriding property definitions

## 🎯 Project-Wide Migration

### Priority Order
1. **Base Models** (Xot, User base classes) - HIGHEST
2. **Frequently Used Models** (User, Team, etc.)
3. **Module Models** (alphabetically)
4. **Test Models** - LOWEST

### Verification
After migration, verify with:
```bash
# Should return 0 results (except in vendor/)
grep -r "protected \$casts\s*=" --include="*.php" Modules/ | wc -l
```

## 📚 Official Documentation

- [Laravel 11 Eloquent Casts](https://laravel.com/docs/11.x/eloquent-mutators#attribute-casting)
- [Laravel News: Model Casts Improvements](https://laravel-news.com/laravel-11-model-casts-improvements)

## ✅ Checklist

Before committing any model:
- [ ] Uses `protected function casts(): array` instead of `protected $casts`
- [ ] Has proper return type hint: `array`
- [ ] Has PHPDoc with `@return array<string, string>` (optional but recommended)
- [ ] No `@deprecated` tag on old property

---

**CRITICAL**: Always use `protected function casts(): array` in new code and migrate old code when touching files.


**Laravel Version**: 11+  
**Status**: MANDATORY for all new code
