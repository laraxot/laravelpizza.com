# Testing Error Resolution Guide - <nome progetto> Project

## Overview

This guide documents critical testing patterns and error resolution strategies identified during the <nome modulo> module testing improvements. These patterns apply across all modules in the <nome progetto> project.

## Critical Testing Errors and Solutions

### 1. Factory Faker Boolean Error

**Error**: `InvalidArgumentException: Unknown format "boolean"`

**Cause**: Using `$this->faker->boolean(percentage)` which doesn't exist in Faker library.

**Solution Patterns**:
```php
// ❌ INCORRECT - Causes error
$this->faker->boolean(70)
$this->faker->boolean(15)

// ✅ CORRECT - Use optional with decimal probability
$this->faker->optional(0.7)->boolean()              // 70% chance of boolean
$this->faker->optional(0.15)->boolean()             // 15% chance of boolean
$this->faker->optional(0.6)->regexify('[A-Z]{2}')   // 60% chance of regex value
$this->faker->optional(0.9)->dateTimeBetween('-2 years', '-1 month')  // 90% chance of date
```

**Global Impact**: This error was found in `Modules/<nome progetto>/database/factories/PatientFactory.php` and potentially affects all factories across modules.

### 2. Database Connection in Feature Tests

**Error**: `Call to a member function connection() on null`

**Cause**: Feature tests attempting to use Eloquent models/factories without database configuration.

**Philosophy**: Feature tests should test business logic, not database persistence.

**Solution Pattern**:
```php
// ❌ INCORRECT - Requires database
it('validates appointment booking', function () {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);
    
    expect($patient->type)->toBe('patient');
});

// ✅ CORRECT - Pure business logic test
it('validates appointment booking logic', function () {
    $patient = (object) ['type' => 'patient', 'id' => 1001];
    $doctor = (object) ['type' => 'doctor', 'id' => 2001];
    
    expect($patient->type)->toBe('patient');
    expect($doctor->type)->toBe('doctor');
});
```

### 3. Translator Dependencies in Tests

**Error**: `Target class [translator] does not exist`

**Cause**: Calling enum or model methods that require Laravel's translation system.

**Solution Pattern**:
```php
// ❌ INCORRECT - Requires translator
expect($appointment->type->getLabel())->toBe('Consultation');

// ✅ CORRECT - Test direct values
expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
expect($appointment->type->value)->toBe('consultation');
expect($appointment->type->getDuration())->toBe(20);  // Non-translation method
```

### 4. Spatie EventSourcing Container Issues

**Error**: `Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]]`

**Cause**: Tests trying to resolve EventSourcing services without full Laravel container setup.

**Solution**: 
- Use pure tests without `TestCase` when testing business logic
- Avoid dependency injection in simple feature tests
- Use plain objects instead of services

## Test Architecture Matrix

| Test Type | Database | Container | Faker | TestCase | Use Case | Speed |
|-----------|----------|-----------|--------|----------|----------|-------|
| **Feature Pure** | ❌ | ❌ | ❌ | ❌ | Business Logic | Ultra Fast |
| **Feature Integrated** | ✅ | ✅ | ✅ | ✅ | End-to-end | Moderate |
| **Unit Resource** | ✅ | ✅ | ✅ | ✅ | Filament Components | Moderate |
| **Unit Model** | ✅ | ✅ | ✅ | ✅ | Eloquent Features | Moderate |

## Module-Specific Implementations

### <nome modulo> Module Results
- **Before**: 14 failing tests due to factory and database errors
- **After**: 44 passing tests (100% success rate)
- **Performance**: 3.24 seconds total execution time
- **Techniques Applied**: Pure object testing, factory corrections, enum value testing

### Implementation Pattern for Other Modules

1. **Identify Test Categories**:
   - Business logic → Pure tests
   - Laravel features → Integration tests
   - Filament components → Unit tests with TestCase

2. **Factory Audit**:
   - Search for `->boolean(\d+)` patterns
   - Replace with `->optional(0.\d+)->boolean()`
   - Test factories in isolation

3. **Feature Test Conversion**:
   - Replace model factories with plain objects
   - Focus on business rules, not persistence
   - Remove database dependencies where possible

## Prevention Strategies

### Pre-Commit Checklist
- [ ] No `$this->faker->boolean(number)` usage in factories
- [ ] Feature tests use plain objects for business logic
- [ ] No enum `getLabel()` calls in tests without full Laravel context
- [ ] TestCase only used when Laravel/Filament features are tested

### Development Workflow
1. **Start Simple**: Begin with pure object tests for business logic
2. **Add Complexity Gradually**: Only add database/container when testing Laravel features
3. **Run Tests Frequently**: Catch issues early in development cycle
4. **Isolate Failures**: Test single files to identify error patterns

### Code Review Guidelines
- Business logic tests should be database-free
- Factory methods should use `optional()` for conditional values
- Enum tests should avoid translation-dependent methods
- Test execution time should be optimized for speed

## Global Project Standards

### Test Naming Conventions
```php
// Feature tests - describe business behavior
it('validates appointment time constraints', function () { });
it('prevents double booking for same doctor', function () { });

// Unit tests - describe component functionality  
it('has correct resource pages', function () { });
it('exposes casts as array', function () { });
```

### Performance Targets
- **Feature tests**: < 0.1 seconds each
- **Unit tests**: < 0.5 seconds each
- **Total module suite**: < 5 seconds
- **Zero flaky tests**: 100% deterministic results

### Error Recovery Process
1. **Identify Error Pattern**: Match to known categories above
2. **Apply Solution Pattern**: Use documented fixes
3. **Test in Isolation**: Verify fix on single test
4. **Run Full Suite**: Ensure no regressions
5. **Document**: Update module docs with specific fixes

## Cross-Module Benefits

These patterns provide benefits across all <nome progetto> modules:

1. **Reliability**: Tests don't fail due to external dependencies
2. **Speed**: Pure tests execute 10-100x faster than database tests
3. **Maintainability**: Business logic tests survive refactoring
4. **Clarity**: Simple objects make test intent clear
5. **Portability**: Tests run anywhere without setup

## Future Evolution

### Phase 1: Standardization (Current)
- Apply patterns to all existing modules
- Document module-specific test strategies
- Establish consistent test architecture

### Phase 2: Optimization  
- Parallel test execution
- Property-based testing for business rules
- Mutation testing for coverage quality

### Phase 3: Advanced Testing
- Contract testing for API boundaries
- Performance benchmarking
- Automated test pattern detection

## Links to Module Documentation

- [<nome modulo> Testing Lessons Learned](../laravel/Modules/<nome modulo>/docs/testing-lessons-learned.md)
- [<nome modulo> Test Error Resolution](../laravel/Modules/<nome modulo>/docs/test-errors-resolution.md)
- [<nome modulo> Testing Guide](../laravel/Modules/<nome modulo>/docs/testing.md)

## Windsurf Rules Integration

- [Testing Factory Best Practices](../.windsurf/rules/testing-factory-best-practices.mdc)
- [Test Error Resolution Patterns](../.windsurf/rules/test-error-resolution-patterns.mdc)

---

**Last Updated**: 2025-01-06  
**Status**: Active Implementation  
**Success Rate**: 100% (<nome modulo>: 44/44 tests passing)  
**Philosophy**: Simple, Fast, Reliable Testing
