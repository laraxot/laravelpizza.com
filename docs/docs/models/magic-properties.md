# Magic Properties in Laravel Eloquent Models

## Overview

Laravel/Eloquent models implement magic properties using PHP's `__get()` and `__set()` magic methods. This means that model attributes are **not** actual PHP class properties but are accessed dynamically.

## Critical Rule: Never Use `property_exists()`

### ❌ The Problem

The PHP function `property_exists()` only checks for **explicitly declared class properties**, not magic properties:

```php
class User extends Model
{
    // No properties declared here
}

$user = User::find(1); // Has 'email' from database
property_exists($user, 'email'); // Returns FALSE! ❌
```

### ✅ The Solution

Use one of these approaches instead:

#### 1. Use `isset()` - Best for Most Cases

```php
if (isset($model->email)) {
    // Property exists and is not null
    $email = $model->email;
}
```

**Note**: `isset()` returns `false` if the property is `null`, so it checks both existence AND non-null value.

#### 2. Use `getAttribute()` - For Explicit Null Checks

```php
if ($model->getAttribute('email') !== null) {
    // Property exists and is not null
    $email = $model->email;
}

// Or check if attribute exists at all (even if null)
if ($model->hasAttribute('email')) {
    $email = $model->email;
}
```

#### 3. Use `array_key_exists()` - For Checking Loaded Attributes

```php
if (array_key_exists('email', $model->getAttributes())) {
    // Attribute was loaded from database
    $email = $model->email;
}
```

#### 4. Use Null Coalescing - For Default Values

```php
$email = $model->email ?? 'default@example.com';
```

## Comparison Table

| Method | Checks Existence | Works with NULL | Works with Magic Properties |
|--------|------------------|-----------------|----------------------------|
| `property_exists()` | ✅ | ✅ | ❌ **NEVER USE WITH MODELS** |
| `isset()` | ✅ | ❌ (returns false for null) | ✅ |
| `getAttribute()` | ✅ | ✅ | ✅ |
| `hasAttribute()` | ✅ | ✅ | ✅ |
| `array_key_exists()` | ✅ | ✅ | ✅ |
| `??` operator | ✅ | ❌ (uses null) | ✅ |

## Common Patterns

### Pattern 1: Check and Use

```php
// ❌ WRONG
if (property_exists($model, 'status')) {
    $status = $model->status;
}

// ✅ CORRECT
if (isset($model->status)) {
    $status = $model->status;
}
```

### Pattern 2: Dynamic Property Access

```php
$propertyName = 'email';

// ❌ WRONG
if (property_exists($model, $propertyName)) {
    $value = $model->{$propertyName};
}

// ✅ CORRECT - Using isset()
if (isset($model->{$propertyName})) {
    $value = $model->{$propertyName};
}

// ✅ CORRECT - Using getAttribute()
if ($model->getAttribute($propertyName) !== null) {
    $value = $model->getAttribute($propertyName);
}
```

### Pattern 3: Check Multiple Attributes

```php
// ❌ WRONG
$required = ['email', 'name', 'phone'];
foreach ($required as $field) {
    if (!property_exists($model, $field)) {
        throw new Exception("Missing field: $field");
    }
}

// ✅ CORRECT
$required = ['email', 'name', 'phone'];
foreach ($required as $field) {
    if (!isset($model->{$field})) {
        throw new Exception("Missing field: $field");
    }
}
```

### Pattern 4: PHPStan Compatibility

When PHPStan complains about `isset()` with magic properties, use this pattern:

```php
if (is_object($state) && is_string($name)) {
    // isset() works with magic properties
    if (isset($state->{$name})) {
        $value = $state->{$name};
    }
}
```

## Why This Matters

1. **Runtime Errors**: Using `property_exists()` will return `false` for valid model attributes, causing logic errors
2. **PHPStan Level 10**: At high strictness levels, PHPStan needs proper handling of magic properties
3. **Code Reliability**: Using the wrong check function can cause unexpected behavior in production

## Real-World Example from Codebase

From `UI/app/Filament/Tables/Columns/SelectStateColumn.php`:

```php
// ✅ CORRECT - This is how it's done in the codebase
if (is_object($state) && is_string($name)) {
    // PHPStan L10: isset() invece di property_exists() - funziona per magic properties
    if (isset($state->{$name})) {
        $stateValue = $state->{$name};
        if (is_array($stateValue)) {
            $states = array_merge($stateValue, $states);
        }
    }
}
```

## Related Documentation

- [Laravel Eloquent Documentation](https://laravel.com/docs/12.x/eloquent)
- [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)
- [PHPStan Magic Properties](https://phpstan.org/writing-php-code/phpdoc-types#magic-properties)

## Last Updated

2025-06-11 (Aggiornato dopo PHPStan fixes)
