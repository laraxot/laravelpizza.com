# IndividualeRegionale Model

Performance evaluation model for regional workers using Single Table Inheritance (STI) via Tighten/Parental.

## Overview

`IndividualeRegionale` represents a regional performance evaluation record. It extends the `Individuale` parent model and filters records where `type = 'regionale'`.

## File Location

```
laravel/Modules/Performance/app/Models/IndividualeRegionale.php
```

## Inheritance

```
BaseIndividualeModel (abstract)
    ↑
Individuale (parent with HasChildren)
    ↑
IndividualeRegionale (child with HasParent + global scope)
```

## Configuration

### Traits Used

- `HasParent` - Enables STI, uses parent's table
- (Inherited traits from `Individuale` and `BaseIndividualeModel`)

### Global Scope

**CRITICAL:** This model MUST have a `boot()` method with global scope:

```php
protected static function boot(): void
{
    parent::boot();

    static::addGlobalScope(function (Builder $query) {
        $query->where('type', 'regionale');
    });
}
```

**Without this**, querying `IndividualeRegionale::all()` returns ALL records instead of just regional ones!

### Type Value

In database: `'regionale'`

In parent's `$childTypes`:
```php
protected array $childTypes = [
    'regionale' => IndividualeRegionale::class,
    // ...
];
```

## Usage

### Creating Records

```php
// Type is automatically set to 'regionale'
$regionale = IndividualeRegionale::create([
    'matr' => 123,
    'ente' => 90,
    'anno' => 2025,
    // ... other fields
]);

// SQL: INSERT INTO performance_individuale (type, matr, ente, anno, ...)
//      VALUES ('regionale', 123, 90, 2025, ...)
```

### Querying Records

```php
// Returns ONLY regionale records
$regionali = IndividualeRegionale::all();

// Returns ONLY regionale records for specific year
$regionali2025 = IndividualeRegionale::where('anno', 2025)->get();

// Join with other tables
$regionali = IndividualeRegionale::with('anag', 'stabiDirigente')
    ->where('ha_diritto', 1)
    ->get();
```

### What NOT to Do

```php
// ❌ DON'T manually set type
$regionale->type = 'regionale';  // Redundant, Parental handles it

// ❌ DON'T query without global scope (unless really needed)
IndividualeRegionale::withoutGlobalScopes()->get();  // Returns ALL types!

// ❌ DON'T extend from wrong parent
class IndividualeRegionale extends BaseModel  // WRONG!
class IndividualeRegionale extends Individuale  // CORRECT ✓
```

## Relationships

All relationships inherited from `Individuale` parent:

- `anag()` - Anagrafica worker
- `stabiDirigente()` - Valutatore
- `criteriValutazione()` - Valuation criteria
- `criteriOptions()` - Option criteria
- `performanceIndividuale()` - Performance records
- (see `Individuale` model for complete list)

## Accessors & Mutators

Inherited from parent models. Notable:

### Type Accessor

```php
public function getTypeAttribute(?string $value): ?\Modules\Ptv\Enums\WorkerType
{
    return $value ? \Modules\Ptv\Enums\WorkerType::tryFrom($value) : null;
}
```

Returns `WorkerType::Regionale` enum instance.

## Testing

### Factory

```php
// In database/factories/IndividualeRegionaleFactory.php
IndividualeRegionale::factory()->create([
    'anno' => 2025,
    'ente' => 90,
]);
```

### Test Examples

```php
public function test_regionale_model_filters_by_type(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    
    $result = IndividualeRegionale::all();
    
    expect($result)->toHaveCount(1);
    expect($result->first()->type)->toBe('regionale');
    expect($result->first())->toBeInstanceOf(IndividualeRegionale::class);
}

public function test_regionale_creation_sets_type_automatically(): void
{
    $regionale = IndividualeRegionale::factory()->create();
    
    expect($regionale->type)->toBe('regionale');
    expect($regionale->type)->toEqual(\Modules\Ptv\Enums\WorkerType::Regionale);
}
```

## Filament Resource

Managed by: `Modules/Performance/Filament/Resources/IndividualeRegionaleResource.php`

Routes:
- `/performance/admin/individuale-regionales` - List
- `/performance/admin/individuale-regionales/{record}/compila` - Fill form
- `/performance/admin/individuale-regionales/{record}/edit` - Edit

## Database Schema

Table: `performance_individuale`

Key columns:
- `id` - Primary key
- `type` - STI discriminator (`'regionale'`)
- `ente` - Entity ID
- `matr` - Worker matricola
- `anno` - Year
- `ha_diritto` - Has right flag
- `totale_punteggio` - Total score
- (see migration for complete schema)

## Common Issues

### Issue: Returns all records instead of just regionali

**Cause:** Missing or incorrect `boot()` method

**Solution:**
```php
protected static function boot(): void
{
    parent::boot();
    static::addGlobalScope(fn ($q) => $q->where('type', 'regionale'));
}
```

### Issue: Type is NULL after save

**Cause:** Not using `HasParent` trait

**Solution:** Ensure trait is present:
```php
use HasParent;  // ✓
```

## Related Documentation

- [`../parental-index.md`](../parental-index.md) - Parental STI pattern overview
- [`../parental-sti-filtering.md`](../parental-sti-filtering.md) - Global scope implementation
- [`individuale.md`](individuale.md) - Parent model
- [`individuale-dip.md`](individuale-dip.md) - Sister model (dip)
- [`individuale-po.md`](individuale-po.md) - Sister model (po)
- [`individuale-dirigente.md`](individuale-dirigente.md) - Sister model (dirigente)

## Changelog

### 2025-04-01

- ✅ Added `boot()` method with global scope for proper type filtering
- ✅ Fixed bug: model was returning all records instead of just regionali
- ✅ Documented global scope requirement

### Previous

- Initial implementation with `HasParent` trait
- Configured for STI with `Individuale` parent

---

**Last Updated:** 2025-04-01  
**Status:** ✅ Complete with global scope  
**Verified:** PHPStan Level 10, Laravel Pint
