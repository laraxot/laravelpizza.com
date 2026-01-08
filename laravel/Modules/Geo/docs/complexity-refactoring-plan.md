# Geo Module - Complexity Refactoring Plan

## Context and Philosophy

This document outlines the refactoring plan to reduce cyclomatic complexity in the Geo module while maintaining PHPStan Level 10 compliance and the defensive validation philosophy.

### Current State (PHPMD Analysis)

**Critical Complexity Violations**:
1. `GetAddressFromBingMapsAction::parseResponse()` - Complexity: 31, NPath: 497,664
2. `GeoDataValidator::checkIntegrity()` - Complexity: 20, NPath: 13,722
3. `GetCoordinatesByAddressAction` (class) - Complexity: 53

**Target**: All methods < 10 complexity, following Xot module standards (0 violations).

## Problem Analysis: parseResponse() Method

### Current Implementation Philosophy

**Logic**: The method implements **defensive validation** of Bing Maps API responses.
**Zen**: Every field must be validated for type safety before use.
**Business Purpose**: Ensure type-safe data for PHPStan Level 10 compliance.

### Root Cause of Complexity (DRY Violation)

The method repeats the same validation pattern **8 times** (lines 127-134):

```php
isset($location['address']['countryRegion']) && \is_string($location['address']['countryRegion'])
    ? $location['address']['countryRegion']
    : null
```

**Each repetition adds**:
- +2 cyclomatic complexity (isset + is_string)
- +1 for ternary operator
- Total: +3 per field × 8 fields = **+24 complexity**

### Refactoring Strategy (KISS + DRY)

**Solution**: Extract repeated logic to helper method.

**Before** (Complexity 31):
```php
'countryRegion' => isset($location['address']['countryRegion']) && \is_string($location['address']['countryRegion'])
    ? $location['address']['countryRegion'] : null,
'adminDistrict' => isset($location['address']['adminDistrict']) && \is_string($location['address']['adminDistrict'])
    ? $location['address']['adminDistrict'] : null,
// ... 6 more times
```

**After** (Estimated Complexity ~8):
```php
'countryRegion' => $this->extractStringField($location['address'], 'countryRegion'),
'adminDistrict' => $this->extractStringField($location['address'], 'adminDistrict'),
// ... clean and simple
```

**New Helper Method**:
```php
/**
 * Extract a string field from array with type safety.
 *
 * @param array<string, mixed> $data
 */
private function extractStringField(array $data, string $key): ?string
{
    return isset($data[$key]) && \is_string($data[$key]) ? $data[$key] : null;
}
```

### Expected Results

- **Complexity Reduction**: 31 → 8-10 (73% improvement)
- **NPath Reduction**: 497,664 → <200 (99.9% improvement)
- **Maintainability**: Single point of change for validation logic
- **Type Safety**: Maintained (PHPStan Level 10 compliant)

## Additional Refactorings (Lower Priority)

### 2. GeoDataValidator::checkIntegrity()

**Current**: Complexity 20, NPath 13,722
**Strategy**: Apply **Pipeline Pattern** for sequential validations
**Estimated**: Complexity → 6-8

### 3. GetCoordinatesByAddressAction (Class Complexity 53)

**Current**: Single class handles multiple geocoding providers
**Strategy**: Apply **Strategy Pattern** - one class per provider
**Estimated**: 4 classes × ~12 complexity = better separation

## Implementation Steps

1. ✅ **Document** refactoring plan (this file)
2. ⏳ **Implement** `extractStringField()` helper
3. ⏳ **Refactor** `parseResponse()` to use helper
4. ⏳ **Verify** with PHPStan Level 10 + PHPMD
5. ⏳ **Test** existing functionality (no breaking changes)
6. ⏳ **Update** this doc with results

## Success Criteria

- [ ] PHPMD: parseResponse() complexity < 10
- [ ] PHPStan: Level 10 with 0 errors (maintained)
- [ ] Tests: All existing tests pass
- [ ] No functional changes (API contract unchanged)

---

**Principle Applied**: DRY (Don't Repeat Yourself)
**Pattern Used**: Extract Method refactoring
**Reference**: Xot module (0 PHPMD violations)
