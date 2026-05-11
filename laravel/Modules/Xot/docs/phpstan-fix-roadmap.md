# PHPStan Error Resolution Roadmap - Xot Module

## Executive Summary
The Xot module serves as the core infrastructure module for the Laraxot framework. It contains critical base classes that other modules depend on, making PHPStan compliance essential for overall project stability.

## Current Status (as of [DATE])
- **PHPStan Errors**: Multiple errors across core files
- **Error Categories**:
  - Unsafe function usage: define, preg_match, glob, file_get_contents, file_put_contents, error_log
  - Collection template type resolution issues
  - Filament component typing mismatches
  - Instanceof checks with invalid types
- **Risk Level**: HIGH - Errors in core infrastructure affect all other modules
- **Target**: 0 errors at PHPStan Level 10

## Error Analysis by File

### 1. Modules/Xot/Helpers/Helper.php
- **Issues**:
  - Line 179: `define` function unsafe usage
  - Line 407: `preg_match` function unsafe usage
  - Line 445: `glob` function unsafe usage
  - Line 451: Redundant assertion
  - Line 1113: `preg_match` function unsafe usage
- **Fix Strategy**: Add Safe library imports

### 2. Modules/Xot/app/Actions/ModelClass/FakeSeederAction.php
- **Issues**:
  - Line 53: Template type resolution in Collection::map()
- **Fix Strategy**: Add proper type annotations

### 3. Modules/Xot/app/Filament/Resources/XotBaseResource.php
- **Issues**:
  - Lines 151-154: Table component typing mismatches
  - Line 271: `glob` function unsafe usage
  - Line 280: Type mismatch in foreach
  - Line 281: Redundant assertion
- **Fix Strategy**: Update component types and add Safe imports

### 4. Modules/Xot/app/Filament/Traits/HasXotTable.php
- **Issues**:
  - Lines 244, 251, 258: Method calls on mixed types
  - Line 236: Invalid instanceof checks
  - Line 237: Parameter type mismatch
- **Fix Strategy**: Add type narrowing and proper checks

### 5. Modules/Xot/app/Helpers/ResourceFormSchemaGenerator.php
- **Issues**:
  - Multiple unsafe function usage (file_get_contents, file_put_contents, preg_match, preg_replace, error_log, glob)
  - Type mismatches for string|false returns
  - Redundant assertions
- **Fix Strategy**: Add Safe imports and proper type handling

## Implementation Plan

### Phase 1: Safe Library Integration (Days 1-2)
- [ ] Add Safe library imports to Helper.php
- [ ] Replace unsafe `define` with Safe\define
- [ ] Replace unsafe `preg_match` with Safe\preg_match
- [ ] Replace unsafe `glob` with Safe\glob

### Phase 2: Type Resolution Fixes (Days 2-3)
- [ ] Fix Collection template types in FakeSeederAction
- [ ] Add proper type hints for Collection operations
- [ ] Update foreach loops with proper null checks

### Phase 3: Filament Component Typing (Days 3-4)
- [ ] Fix table column/filter/action typing in XotBaseResource
- [ ] Update Filament component return types
- [ ] Verify compatibility with Filament 5

### Phase 4: Runtime Type Safety (Days 4-5)
- [ ] Add type narrowing in HasXotTable trait
- [ ] Fix instanceof and method call issues
- [ ] Implement proper conditional checks

### Phase 5: ResourceFormSchemaGenerator Cleanup (Days 5-6)
- [ ] Add Safe library imports for all unsafe functions
- [ ] Fix type mismatches for file operations
- [ ] Verify schema generation functionality

### Phase 6: Verification (Day 6)
- [ ] Run PHPStan on Xot module
- [ ] Execute module-specific tests
- [ ] Verify all Xot base functionality works
- [ ] Test dependent modules still function

## Technical Implementation Details

### Safe Library Integration Pattern
```php
// At the top of the file
use function Safe\define;
use function Safe\preg_match;
use function Safe\glob;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\error_log;

// Then use the functions normally - they'll throw exceptions instead of returning false
```

### Collection Type Fix Pattern
```php
// Before
->map(function ($item) {
    return something;
})

// After - with proper typing
->map(function (Type $item): ReturnType {
    return something;
})
```

### Type Narrowing Pattern
```php
// Before
if ($model instanceof Model) {
    $model->method(); // May be mixed
}

// After - with proper narrowing
if ($model instanceof Model && method_exists($model, 'method')) {
    $model->method();
}
```

## Risk Mitigation
- [ ] Test Xot base functionality after each phase
- [ ] Verify other modules still work with fixed Xot
- [ ] Run full test suite after completion
- [ ] Check for any breaking changes in base classes
- [ ] Verify backward compatibility with extending classes

## Success Metrics
- [ ] 0 PHPStan errors in Xot module
- [ ] All Xot base functionality preserved
- [ ] Dependent modules continue to work
- [ ] No breaking changes introduced
- [ ] Type safety improved without performance impact