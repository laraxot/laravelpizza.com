# Sigma Module - DRY/KISS Documentation

> **Module Purpose**: Computational core for evaluation sheets and career progression calculations
> **Philosophy**: "Calculate once, query a thousand times" (Zen principle)

## 🎯 Core Purpose

The **Sigma (Σ)** module is the computational heart of the system, handling:

- **Evaluation Sheets**: Calculation of career progression evaluations
- **Data Aggregation**: Consolidation from Performance, Attendance, User modules
- **Performance Optimization**: Controlled denormalization (90%+ speed improvement)
- **Regulatory Compliance**: Conformance to CCNL regulations (Art. 16, 19)

### Key Metrics
- **317 models** with complex relationships
- **83 accessors** for calculated values  
- **12+ pure methods** for isolated business logic
- **Performance gains**: -95% queries, -88% edit page time

## 🏗️ Architecture Overview

### Main Components

#### 1. Scheda Model
- **Location**: `app/Models/Scheda.php`
- **Role**: Represents annual evaluation sheets with base data + denormalized values
- **Uses**: `SchedaTrait` for complex logic

#### 2. SchedaTrait
- **Location**: `app/Models/Traits/SchedaTrait.php`
- **Role**: Contains 83 accessors and 12+ pure methods
- **Pattern**: Accessor → Pure Method → Calculation

#### 3. SchedaHelper
- **Location**: `app/Models/Traits/Helpers/SchedaHelper.php`
- **Role**: Pure calculations without side effects

#### 4. ImportJsonAction
- **Location**: `app/Actions/WebService/ImportJsonAction.php`
- **Role**: Import data from JSON files

### Architecture Pattern
```
Accessor (Lifecycle) → Pure Method (Business Logic) → Result
      ↓                        ↓                      ↓
   Cache + Guard         Pure Calculation        Value
```

## 🚀 Quick Start

### Data Import
```bash
# Web interface
# Navigate to: /sigma/admin/web-service

# Via action
php artisan tinker
> use Modules\Sigma\Actions\WebService\ImportJsonAction;
> app(ImportJsonAction::class)->execute('data.json', 'local', 'anag');
```

### Sheet Calculations
```php
use Modules\Sigma\Models\Scheda;

$scheda = Scheda::find($id);

// Access calculated values (cached)
$avg_perf = $scheda->perf_ind_media; // 3-year performance average
$days = $scheda->gg_anno; // Effective annual days

// Force refresh
$scheda = Scheda::find($id);
request()->merge(['refresh' => 1]);
$avg_perf = $scheda->perf_ind_media; // Recalculates
```

## 🔗 Module Dependencies

### Used By
- **Ptv**: Progression management
- **Progressioni**: Career progression handling
- **IndennitaResponsabilita**: Allowance calculations
- **Incentivi**: Incentive calculations

### Dependencies
- **Performance**: Performance evaluations
- **PresenzeAssenze**: Time tracking
- **User**: Employee data

## ⚡ Performance Highlights

| Operation | Before | After | Improvement |
|-----------|--------|-------|-------------|
| Edit sheet | 2.5s | 0.3s | **-88%** |
| List sheets (100) | 15s | 1.2s | **-92%** |
| Performance average | 800ms | 5ms (cached) | **-99%** |

## 📋 Key Development Principles

### DO ✅
- Use pure methods for calculations
- Implement PK guard before save
- Use `update()` for surgical persistence
- Document business logic in pure methods
- Test pure methods in isolation

### DON'T ❌
- Calculate values already cached
- Save without PK guard pattern
- Use `save()` for single fields (use `update()`)
- Mix calculation and persistence logic
- Ignore refresh flag when needed

## 🧪 Testing Approach

### Pure Method Tests
```php
test('getGgAnno calculates correctly', function () {
    $scheda = new Scheda();
    $scheda->gg_presenza_anno = 365;
    $scheda->gg_assenza_anno = 15;
    
    expect($scheda->getGgAnno())->toBe(350);
});
```

### Accessor Tests
```php
test('gg_anno accessor persists calculated value', function () {
    $scheda = Scheda::factory()->create([
        'gg_presenza_anno' => 365,
        'gg_assenza_anno' => 15,
    ]);
    
    $value = $scheda->gg_anno;
    
    expect($value)->toBe(350);
    expect($scheda->getOriginal('gg_anno'))->toBe(350);
});
```

## 📚 Further Reading

- [**Architecture Details**](./architecture.md) - Deep dive into the Delegation Cascade Pattern
- [**Business Logic**](./business-logic.md) - Complete regulatory compliance rules
- [**Quality Improvements**](./quality-improvements.md) - Code quality initiatives
- [**PHPStan Strategy**](./phpstan-level10-strategy.md) - Static analysis approach

---

**Version**: 2.0.0  
**Last Updated**: November 2025  
**Status**: Production Ready