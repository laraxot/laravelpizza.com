# Safe Casting Actions - DRY & KISS Implementation

## Overview

The Safe Casting Actions provide a centralized, robust solution for handling PHPStan "Cannot cast mixed to X" errors throughout the codebase. These actions follow DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles.

## Available Actions

### SafeFloatCastAction

Located: `Modules\Xot\Actions\Cast\SafeFloatCastAction`

#### Basic Usage

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

// Basic casting
$value = SafeFloatCastAction::cast($mixedValue);

// With custom default
$value = SafeFloatCastAction::cast($mixedValue, 10.5);

// With precision control
$value = SafeFloatCastAction::castWithPrecision($mixedValue, 2); // 2 decimal places

// With range validation
$percentage = SafeFloatCastAction::castWithRange($mixedValue, 0.0, 100.0);

// As percentage (0-100)
$percentage = SafeFloatCastAction::castAsPercentage($mixedValue);

// As currency (positive, 2 decimals)
$amount = SafeFloatCastAction::castAsCurrency($mixedValue);
```

#### Replacing PHPStan Errors

**Before (PHPStan Error):**
```php
// ❌ Cannot cast mixed to float
$data[$key] = number_format((float) $item, 2, '.', '');
```

**After (PHPStan Compliant):**
```php
// ✅ Safe casting
$numericValue = SafeFloatCastAction::cast($item, 0.0);
$data[$key] = number_format($numericValue, 2, '.', '');
```

### SafeIntCastAction

Located: `Modules\Xot\Actions\Cast\SafeIntCastAction`

#### Basic Usage

```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Basic casting
$value = SafeIntCastAction::cast($mixedValue);

// With custom default
$value = SafeIntCastAction::cast($mixedValue, 1);

// With range validation
$count = SafeIntCastAction::castWithRange($mixedValue, 0, 100);

// As positive ID
$id = SafeIntCastAction::castAsId($mixedValue); // Always >= 1
```

#### Replacing PHPStan Errors

**Before (PHPStan Error):**
```php
// ❌ Cannot cast mixed to int
$this->tries = (int) $config['tries'];
```

**After (PHPStan Compliant):**
```php
// ✅ Safe casting
$this->tries = SafeIntCastAction::cast($config['tries'], 3);
```

### SafeStringCastAction

Located: `Modules\Xot\Actions\Cast\SafeStringCastAction` (existing)

## Common Use Cases

### 1. Chart Data Processing

```php
// Before
foreach ($data as $key => $item) {
    $data[$key] = number_format((float) $item, 2, '.', ''); // PHPStan error
}

// After
foreach ($data as $key => $item) {
    $numericValue = SafeFloatCastAction::castWithPrecision($item, 2, 0.0);
    $data[$key] = number_format($numericValue, 2, '.', '');
}
```

### 2. Configuration Values

```php
// Before
$timeout = (int) config('app.timeout'); // PHPStan error

// After
$timeout = SafeIntCastAction::cast(config('app.timeout'), 30);
```

### 3. API Response Processing

```php
// Before
$elevation = (float) $response['elevation']; // PHPStan error

// After
$elevation = SafeFloatCastAction::cast($response['elevation'], 0.0);
```

### 4. Coordinate Handling

```php
// Before
$latitude = (float) $data['lat']; // PHPStan error
$longitude = (float) $data['lng']; // PHPStan error

// After
$latitude = SafeFloatCastAction::castWithRange($data['lat'], -90.0, 90.0, 0.0);
$longitude = SafeFloatCastAction::castWithRange($data['lng'], -180.0, 180.0, 0.0);
```

### 5. Percentage Calculations

```php
// Before
$percentage = ((float) $completed / (float) $total) * 100; // PHPStan errors

// After
$completed = SafeFloatCastAction::cast($completed, 0.0);
$total = SafeFloatCastAction::cast($total, 1.0);
$percentage = SafeFloatCastAction::castAsPercentage(($completed / $total) * 100);
```

## Benefits

### DRY (Don't Repeat Yourself)
- Centralized casting logic
- No duplication of type checking code
- Consistent behavior across the entire codebase

### KISS (Keep It Simple, Stupid)
- Simple, intuitive API
- Clear method names
- Minimal cognitive overhead

### Robustness
- Handles all edge cases (null, empty strings, objects, arrays)
- Prevents infinite/NaN values
- Graceful fallbacks with sensible defaults

### PHPStan Compliance
- Eliminates "Cannot cast mixed to X" errors
- Maintains strict type safety
- Improves static analysis confidence

## Migration Strategy

1. **Identify PHPStan Errors**: Look for "Cannot cast mixed to float/int" errors
2. **Replace Direct Casts**: Replace `(float)` and `(int)` casts with safe actions
3. **Add Imports**: Import the appropriate casting action
4. **Set Defaults**: Choose appropriate default values for your use case
5. **Test**: Verify the behavior matches expectations

## Performance Considerations

- Actions are lightweight and fast
- Minimal overhead compared to manual type checking
- Can be queued for heavy processing if needed (implements QueueableAction)
- Static methods provide direct access without container resolution

## Future Enhancements

- `SafeBoolCastAction` for boolean casting
- `SafeArrayCastAction` for array casting
- Additional utility methods based on common use cases
- Integration with Laravel validation rules

## Related Documentation

- [PHPStan Level 10 Guidelines](phpstan_level10_guidelines.md)
- [Type Safety Best Practices](type_safety_best_practices.md)
- [Laraxot Coding Standards](../../../project_docs/coding_standards.md)
