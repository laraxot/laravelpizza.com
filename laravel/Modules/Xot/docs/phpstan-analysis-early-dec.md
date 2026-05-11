# PHPStan Analysis Report - All Modules

**Date**: 2025-12-16
**PHPStan Level**: 10 (Maximum Strictness)
**Total Files Analyzed**: 3,738
**Total Errors Found**: 169

---

## Executive Summary

PHPStan level 10 analysis revealed **169 errors** across the module codebase. Errors are concentrated in specific files and follow identifiable patterns, making them addressable through systematic fixes.

### Error Distribution by Module

| Module | Errors | Severity | Priority |
|--------|--------|----------|----------|
| **Geo** | ~50+ | 🔴 Critical | P0 - Immediate |
| **Cms** | ~15 | 🔴 Critical | P0 - Immediate |
| **Activity** | 2 | 🟡 Medium | P2 - Soon |
| **Xot** | ~10 | 🟡 Medium | P2 - Soon |
| **Other** | ~92 | 🟢 Low | P3 - Later |

### Error Categories

| Category | Count | Example |
|----------|-------|---------|
| Undefined constants | ~30+ | `Access to undefined constant ::PHONE` |
| Mixed type issues | ~25+ | `Cannot access property on mixed` |
| Missing return types | ~20+ | `Method has no return type specified` |
| Wrong class references | ~15+ | `Class App\Models\User not found` |
| Method not found | ~10+ | `Call to undefined method` |
| Type mismatches | ~20+ | `expects string, mixed given` |
| Other | ~49 | Various |

---

## Critical Errors (Priority 0 - Fix Immediately)

### 1. Geo Module - AddressItemEnum.php (~50+ errors)

**File**: `Modules/Geo/app/Enums/AddressItemEnum.php`

**Problem**: Enum cases accessed as undefined constants, causing cascade of type errors.

**Impact**:
- Breaks type safety for address-related functionality
- Affects all features using address fields

**Error Pattern:**
```
Access to undefined constant ::PHONE, ::NAME, ::DESCRIPTION, etc.
Cannot access property $value on mixed
Possibly invalid array key type mixed
```

**Fix Complexity**: ⭐⭐ (Medium - Requires enum refactoring)

**See**: `Modules/Geo/docs/phpstan-errors-2025-12-16.md`

---

### 2. Cms Module - Multiple Files (~15 errors)

**Files Affected:**
- `app/Models/Traits/HasBlocks.php` (4 errors)
- `app/View/Components/Section.php` (2 errors)
- `app/Http/Volt/VerifyComponent.php` (2 errors)
- `app/Http/View/Composers/XotComposer.php` (1 error)
- `app/Models/Conf.php` (1 error)

**Problems:**
1. `DataCollection::make()` called incorrectly (should use `BlockData::collection()`)
2. Wrong BlockData namespace import (View\Components vs Datas)
3. Missing methods on UserContract interface
4. Wrong User class reference (App\Models\User vs module User)

**Impact**:
- Blocks system (core CMS feature) has type safety issues
- Email verification may fail
- User profile access issues

**Fix Complexity**: ⭐⭐ (Medium - Requires namespace fixes and interface updates)

**See**: `Modules/Cms/docs/phpstan-errors-2025-12-16.md`

---

## Medium Priority Errors (Priority 2 - Fix Soon)

### 3. Activity Module - HasEvents.php (2 errors)

**File**: `Modules/Activity/app/Traits/HasEvents.php`

**Problem**: Missing return type declarations on relationship methods

**Errors:**
```php
public function storedEvents() // ❌ No return type
public function snapshots()    // ❌ No return type
```

**Impact**:
- Affects type safety for event-sourced models
- Degrades IDE support

**Fix Complexity**: ⭐ (Very Easy - Just add `: HasMany` return types)

**See**: `Modules/Activity/docs/phpstan-errors-2025-12-16.md`

---

### 4. Xot Module - TransTrait.php (~10 errors)

**File**: `Modules/Xot/app/Filament/Traits/TransTrait.php`

**Problem**: Calls `static::getModuleName()` which is undefined in some using classes

**Errors:**
```php
// Line 223
$moduleNameLow = Str::lower(static::getModuleName()); // ❌ Method not found
// Error 1: Call to undefined static method ::getModuleName()
// Error 2: Parameter #1 expects string, mixed given
```

**Affected Classes:**
- `XotBaseBlock` - Uses TransTrait but missing getModuleName()
- `XotBaseCluster` - Uses NavigationLabelTrait → TransTrait
- `EnvPage` - Extends XotBasePage

**Root Cause:**
- TransTrait assumes all using classes have `getModuleName()` method
- Only XotBasePage and XotBaseResource define this method
- XotBaseBlock and XotBaseCluster don't have it

**Impact**: Translation functionality fails for blocks and clusters

**Fix Complexity**: ⭐⭐ (Medium - Add method to 2 base classes)

**Recommended Fix**: Add `getModuleName()` to XotBaseBlock and XotBaseCluster
```php
public static function getModuleName(): string
{
    $class = static::class;
    $parts = explode('\\', $class);
    // Extract from: Modules\{ModuleName}\Filament\...
    return isset($parts[1]) && $parts[0] === 'Modules' ? $parts[1] : 'Xot';
}
```

**See**: `Modules/Xot/docs/phpstan-transtrait-errors-2025-12-16.md`

---

## Fix Roadmap

### Phase 1: Critical Fixes (Week 1)

**Target**: Reduce errors from 169 to <100

1. **Geo/AddressItemEnum.php**
   - Verify all enum cases are defined
   - Add proper type hints
   - Refactor `getColumnDefinitions()` method
   - **Expected reduction**: ~50 errors

2. **Cms/HasBlocks.php**
   - Replace `DataCollection::make()` with `BlockData::collection()`
   - Fix PHPDoc types
   - **Expected reduction**: ~4 errors

3. **Cms/Section.php**
   - Fix BlockData import namespace
   - Add proper type hint to $blocks property
   - **Expected reduction**: ~2 errors

### Phase 2: Important Fixes (Week 2)

**Target**: Reduce errors to <50

4. **Cms/VerifyComponent.php**
   - Add methods to UserContract OR use Laravel's MustVerifyEmail
   - **Expected reduction**: ~2 errors

5. **Activity/HasEvents.php**
   - Add return types to relationship methods
   - **Expected reduction**: ~2 errors

6. **Cms/XotComposer.php** & **Cms/Conf.php**
   - Fix class references
   - Verify method existence
   - **Expected reduction**: ~2 errors

### Phase 3: Cleanup (Week 3)

**Target**: Achieve 0 errors

7. **Xot/TransTrait.php** and remaining files
8. **Other modules** - Address remaining ~92 errors

---

## Testing Strategy

### After Each Fix

```bash
# Test specific module
./vendor/bin/phpstan analyse Modules/{ModuleName}

# Test all modules
./vendor/bin/phpstan analyse Modules

# Generate baseline if needed (avoid this if possible)
./vendor/bin/phpstan analyse --generate-baseline
```

### Continuous Integration

Add PHPStan to CI pipeline:

```yaml
# .github/workflows/phpstan.yml
name: PHPStan

on: [push, pull_request]

jobs:
  phpstan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse Modules --error-format=github
```

---

## Success Metrics

| Metric | Current | Target (Week 1) | Target (Week 3) |
|--------|---------|-----------------|-----------------|
| Total Errors | 169 | <100 | 0 |
| Critical Files | 5 | 0 | 0 |
| Modules with 0 errors | 0 | 3 | All |

---

## Resources

### Module-Specific Documentation

- [Geo Module Errors](../../Geo/docs/phpstan-errors-2025-12-16.md)
- [Cms Module Errors](../../Cms/docs/phpstan-errors-2025-12-16.md)
- [Activity Module Errors](../../Activity/docs/phpstan-errors-2025-12-16.md)
- [Xot Module TransTrait Errors](phpstan-transtrait-errors-2025-12-16.md)

### PHPStan Documentation

- [PHPStan Level 10](https://phpstan.org/user-guide/rule-levels)
- [Type Inference](https://phpstan.org/writing-php-code/phpdoc-types)
- [Baseline Files](https://phpstan.org/user-guide/baseline)

### Laravel Best Practices

- [Type Declarations](https://laravel.com/docs/11.x/eloquent-relationships#relationship-methods)
- [Service Containers](https://laravel.com/docs/11.x/container#automatic-injection)

---

## Action Items

### Immediate (This Week)

- [x] Run PHPStan analysis
- [x] Document all errors by module
- [ ] Assign module owners to fix their errors
- [ ] Create GitHub issues for critical errors
- [ ] Start Phase 1 fixes

### Short-term (Next 2 Weeks)

- [ ] Complete Phase 1 fixes
- [ ] Complete Phase 2 fixes
- [ ] Add PHPStan to CI pipeline
- [ ] Train team on type safety best practices

### Long-term (Month 1)

- [ ] Achieve 0 PHPStan errors
- [ ] Maintain 0 errors policy
- [ ] Document type safety guidelines
- [ ] Share learnings with team

---

## Notes

### Why PHPStan Level 10?

- **Maximum type safety**: Catches most type-related bugs before runtime
- **Better IDE support**: Improves auto-completion and refactoring
- **Documentation**: Types serve as inline documentation
- **Confidence**: Refactoring is safer with strong typing

### Common Pitfalls to Avoid

1. **Don't ignore errors with `@phpstan-ignore-next-line`** unless absolutely necessary
2. **Don't use baseline** as permanent solution - it hides problems
3. **Don't use `mixed` type** unless truly needed
4. **Do add return types** to all methods
5. **Do use strict types** (`declare(strict_types=1);`) in all PHP files

---

**Status**: 🔴 **169 errors** requiring systematic fixes
**Next Review**: 2025-12-23 (1 week)
**Owner**: Tech Lead + Module Owners
**Last Updated**: 2025-12-16

---

## Appendix: Full Error List

Run this command to see all 169 errors in detail:

```bash
cd ./laravel
./vendor/bin/phpstan analyse Modules --error-format=table > phpstan-full-report.txt
```

Or in JSON format for programmatic processing:

```bash
./vendor/bin/phpstan analyse Modules --error-format=json > phpstan-report.json
```
