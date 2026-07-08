# PHPStan Best Practices - Sigma Module

## 🎯 Overview

The Sigma module currently passes PHPStan level 10 analysis, demonstrating high code quality and type safety. This document outlines the practices that maintain this standard.

## ✅ Current Status

- **PHPStan Level**: 10 (maximum strictness) ✅ 
- **Status**: SchedaTrait passes without errors ✅
- **Files**: 638 files analyzed with no errors ✅

## 🧼 Clean Code Practices

### 1. Strict Typing
```php
// ✅ CORRECT
public function calculateGgAnno(array $attributes): int
{
    return (int) ($attributes['presenza'] - $attributes['assenza']);
}

// ❌ AVOID
public function calculateGgAnno($attributes)  // No type hints
{
    return $attributes['presenza'] - $attributes['assenza'];  // No return type
}
```

### 2. Explicit Return Types
```php
// ✅ CORRECT
public function getPerfIndMedia(): float
{
    return $this->calculateAverage($this->getPerformanceYears());
}

// ❌ AVOID
public function getPerfIndMedia()  // Unclear return type
{
    return $this->calculateAverage($this->getPerformanceYears());
}
```

### 3. Array Shape Documentation
```php
// ✅ CORRECT
/**
 * @param array{presenza: int, assenza: int, permessi: int} $data
 * @return array{totale: int, percentuale: float}
 */
public function calculateDays(array $data): array
{
    // Implementation
}

// ❌ AVOID
public function calculateDays(array $data)  // No structure defined
{
    // Implementation
}
```

## 🚫 Common Issues Avoided

### 1. Mixed Return Types
```php
// ✅ CORRECT
public function getCalculatedValue(): ?float
{
    if (!$this->hasValidData()) {
        return null;
    }
    return $this->performCalculation();
}

// ❌ AVOID
public function getCalculatedValue()  // Mixed return type
{
    if (!$this->hasValidData()) {
        return false;  // Different type
    }
    return $this->performCalculation();  // numeric type
}
```

### 2. Undefined Array Keys
```php
// ✅ CORRECT
public function getAttributeSafely(array $attributes, string $key): mixed
{
    return $attributes[$key] ?? null;
}

// ❌ AVOID
public function getAttributeSafely(array $attributes, string $key)
{
    return $attributes[$key];  // May throw error if key doesn't exist
}
```

### 3. Property Existence Checks
```php
// ✅ CORRECT - For Eloquent models
public function hasAttributeValue($model, string $attribute): bool
{
    return isset($model->$attribute);
}

// ❌ AVOID - For Eloquent models
public function hasAttributeValue($model, string $attribute): bool
{
    return property_exists($model, $attribute);  // Always false for attributes
}
```

## 🧩 Complex Type Definitions

### Collections and Relationships
```php
// ✅ CORRECT
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Sigma\Models\RelatedModel>
 */
public function relatedModels()
{
    return $this->hasMany(RelatedModel::class);
}

// ❌ AVOID
public function relatedModels()  // No type information
{
    return $this->hasMany(RelatedModel::class);
}
```

### Generic Collections
```php
// ✅ CORRECT
/**
 * @return \Illuminate\Support\Collection<int, \Modules\Sigma\Models\Scheda>
 */
public function getActiveSchede(): Collection
{
    return Scheda::where('active', true)->get();
}

// ❌ AVOID
public function getActiveSchede()  // No generic type
{
    return Scheda::where('active', true)->get();
}
```

## 🔍 PHPStan Configuration

### Level 10 Settings
The following configuration maintains maximum strictness:

```neon
parameters:
    level: 10
    paths:
        - Modules/Sigma/
    excludePaths:
        - */tests/*
    checkMissingIterableValueType: false
```

### Custom Rules
```neon
# For business-specific rules
rules:
    - 
```

## 🧪 Testing with PHPStan

### 1. Run Analysis
```bash
# Full module analysis
./vendor/bin/phpstan analyse Modules/Sigma --level=10

# Specific directory
./vendor/bin/phpstan analyse Modules/Sigma/app/Models --level=10

# With specific configuration
./vendor/bin/phpstan analyse Modules/Sigma --level=10 --configuration=Modules/Sigma/phpstan.neon.dist
```

### 2. Common Fixes Applied in Sigma

#### Undefined variable issues
```php
// Before
public function calculateWithLoop(): array
{
    foreach ($this->items as $item) {
        $result[] = $this->processItem($item);  // $result might be undefined
    }
    return $result;
}

// After
public function calculateWithLoop(): array
{
    $result = [];  // Initialize before use
    foreach ($this->items as $item) {
        $result[] = $this->processItem($item);
    }
    return $result;
}
```

#### Nullable return handling
```php
// Before
public function getCalculatedValue(): float
{
    $value = $this->performCalculation();  // May return null
    return $value * 100;
}

// After
public function getCalculatedValue(): float
{
    $value = $this->performCalculation();
    return ($value ?? 0) * 100;
}
```

## 📋 PHPStan Checklist for Sigma

Before committing to Sigma module:

- [ ] All new methods have explicit return types
- [ ] All parameters have type hints
- [ ] Array shapes documented with `@param`
- [ ] Collections use generic types in PHPDoc
- [ ] No `property_exists()` used with Eloquent models
- [ ] All variables initialized before use
- [ ] Nullable returns handled properly
- [ ] PHPStan analysis passes at level 10

---

**Version**: 2.0.0  
**Status**: Maintained at Level 10 compliance