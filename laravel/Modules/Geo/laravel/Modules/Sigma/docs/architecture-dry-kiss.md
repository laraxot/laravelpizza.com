# Sigma Architecture - DRY/KISS Focused

## 🏗️ Core Architecture

### Model Layer Design
```
┌─────────────────┐    ┌──────────────────┐
│   Scheda.php    │────│  SchedaTrait.php │
│ (Base Model)     │    │ (83 Accessors)  │
└─────────────────┘    └──────────────────┘
                              │
                   ┌──────────────────┐
                   │ SchedaHelper.php │
                   │ (Pure Functions) │
                   └──────────────────┘
```

**Key Principle**: Separation of concerns with denormalized values for performance.

### Trait Categories

| Trait Type | Purpose | Examples |
|------------|---------|----------|
| **Accessors** | Calculated values | `getGgAnno()`, `getPerfIndMedia()` |
| **Helpers** | Pure functions | `calculateDays()`, `computeAverage()` |
| **Scopes** | Query builders | `active()`, `byYear()` |
| **Mutators** | Value setters | `setDateAttribute()` |

## 🔧 Technical Patterns

### 1. Delegation Cascade Pattern
```php
// Accessor → Helper → Calculation
public function getGgAnnoAttribute()
{
    return $this->getGgAnno(); // Pure method
}

public function getGgAnno()
{
    return $this->calculateGgAnno($this->attributes); // Helper
}
```

### 2. Cache-First Approach
```php
public function getPerfIndMediaAttribute()
{
    if ($this->relationLoaded('perf_ind_media')) {
        return $this->getOriginal('perf_ind_media');
    }
    
    $value = $this->calculatePerfIndMedia();
    $this->setAttribute('perf_ind_media', $value);
    return $value;
}
```

### 3. Guard Pattern for PK
```php
public function setGgAnnoAttribute($value)
{
    if (!$this->getKey()) {
        $this->attributes['gg_anno'] = $value;
        return;
    }
    
    $this->update(['gg_anno' => $value]);
}
```

## 🚀 Performance Optimizations

### 1. Denormalization Strategy
- Calculated values stored in database
- Reduces complex queries by 95%
- Pre-calculated metrics for reporting

### 2. Smart Caching
- Accessor results cached automatically
- `?refresh=1` parameter forces recalculation
- Eager loading for related data

### 3. Query Optimization
- Composite indexes on key fields
- Minimal joins through denormalization
- Batch operations for data import

## 🧪 Testing Strategy

### Unit Testing (Pure Functions)
```php
// Test business logic in isolation
test('calculatePerfIndMedia excludes zero values', function () {
    $result = calculatePerfIndMedia([100, 0, 80]);
    expect($result)->toBe(90); // Average of non-zero values
});
```

### Integration Testing (Accessors)
```php
// Test with real model and database
test('perf_ind_media accessor persists value', function () {
    $scheda = Scheda::factory()->create();
    $value = $scheda->perf_ind_media;
    
    expect($value)->toBeNumeric();
    expect($scheda->getOriginal('perf_ind_media'))->toBe($value);
});
```

## 🔄 Data Flow

```
External Data → ImportJsonAction → Scheda Model → [Accessors → Helpers] → Result
     ↓              ↓                    ↓            ↓           ↓         ↓
   JSON File    Validation         Denormalized   Calculated  Cached   Available
```

## 🛡️ Safety Mechanisms

### 1. Duplicate Entry Prevention
```php
// Guard pattern prevents duplicate calculations
if ($this->shouldSkipCalculation()) {
    return $this->getOriginal('calculated_field');
}
```

### 2. Regulatory Compliance
- CCNL Article 16 & 19 compliance built-in
- Audit trail for all changes
- Validation of calculation rules

### 3. Error Recovery
- Graceful degradation when calculations fail
- Fallback values for missing data
- Comprehensive logging

---

**Version**: 2.0.0  
**Focus**: DRY (no repetition) + KISS (simple architecture)