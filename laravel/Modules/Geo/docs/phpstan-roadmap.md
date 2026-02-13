# PHPStan Roadmap - Geo Module

> **Created**: 2026-01-21  
> **Updated**: 2026-01-21
> **Status**: ✅ Fully Compliant (Level 10)  
> **Errors**: 0  
> **Priority**: N/A (Resolved)

## Resolution Summary (2026-01-21)
All 7 PHPStan Level 10 compliance issues have been successfully resolved.

### Applied Fixes

#### 1. Fixed Factory State Method Signatures
**Files**: 
- `Geo/database/factories/ComuneFactory.php`
- `Geo/database/factories/ProvinceFactory.php` 
- `Geo/database/factories/RegionFactory.php`

**Problem**: PHPStan expected `array<string, mixed>|callable` but received `Closure(array): non-empty-array`

**Solution**: Restructured factory state methods with proper callable structure:

```php
// Before
return $this->state(function (array $attributes, ?Model $model = null): array {
    // implementation
});

// After
return $this->state(
    /** @param array<string, mixed> $attributes */
    /** @return array<string, mixed> */
    function (array $attributes, ?Model $model = null): array {
        // implementation
    }
);
```

**Pattern Applied**:
1. Convert `state()` calls to use proper callable structure
2. Add explicit `@param` and `@return` annotations
3. Ensure `array<string, mixed>` return type for PHPStan compliance
4. Maintain Laravel factory compatibility

#### 2. Methods Fixed
- **ComuneFactory**: `emiliaRomagna()` method
- **ProvinceFactory**: `northern()`, `central()`, `southern()` methods  
- **RegionFactory**: Multiple factory state methods

## Verification Results
- ✅ PHPStan analysis returns 0 errors for entire Geo module
- ✅ All factory functionality preserved
- ✅ Factory state methods work correctly
- ✅ Model creation and relationships intact
- ✅ Seeding functionality maintained

## Technical Notes
- **No breaking changes**: All existing factory method signatures preserved
- **Backward compatibility**: Factory usage patterns unchanged
- **Type safety**: Enhanced PHPStan compliance without runtime impact
- **Code quality**: Cleaner, more documented factory methods

## Maintenance Strategy
1.  **Strict Typing**: Ensure all new code uses strict types (`declare(strict_types=1);`).
2.  **Regular Checks**: Run PHPStan before every commit.
3.  **Documentation**: Keep PHPDocs up-to-date for complex types.
4.  **Factory Patterns**: Apply consistent callable structure for all new state methods.

## Future Goals
- Maintain 0 errors.
- Apply same pattern to any new factory methods.
- Monitor Laravel factory best practices.

---

**Status**: ✅ Fully Compliant (Level 10)
**Next**: Monitor for any future regressions
