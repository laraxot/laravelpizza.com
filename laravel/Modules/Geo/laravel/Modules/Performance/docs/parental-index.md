# Parental STI Pattern - Documentation Index

Complete documentation for using Tighten/Parental package for Single Table Inheritance in the Performance module.

## Quick Start

**Using Parental? Read this first:**
1. [`parental-research-complete.md`](parental-research-complete.md) - Complete research & implementation guide
2. [`parental-sti-filtering.md`](parental-sti-filtering.md) - Practical implementation guide
3. [`bugfix-individuale-regionale-parental-scope.md`](bugfix-individuale-regionale-parental-scope.md) - Bug fix case study

---

## Core Documentation

### Research & Architecture

| Document | Purpose | When to Read |
|----------|---------|--------------|
| [`parental-research-complete.md`](parental-research-complete.md) | Complete research on Parental patterns, alternatives, and best practices | Starting new STI implementation |
| [`parental-sti-filtering.md`](parental-sti-filtering.md) | Practical guide for implementing global scopes | Implementing child models |
| [`bugfix-individuale-regionale-parental-scope.md`](bugfix-individuale-regionale-parental-scope.md) | Case study: fixing missing global scope | Debugging filtering issues |

### Model-Specific Docs

| Model | Documentation | Type Value |
|-------|--------------|------------|
| `Individuale` (Parent) | [`models/individuale.md`](models/individuale.md) | N/A |
| `IndividualeRegionale` | [`models/individuale-regionale.md`](models/individuale-regionale.md) | `'regionale'` |
| `IndividualeDip` | [`models/individuale-dip.md`](models/individuale-dip.md) | `'dip'` |
| `IndividualePo` | [`models/individuale-po.md`](models/individuale-po.md) | `'po'` |
| `IndividualeDirigente` | [`models/individuale-dirigente.md`](models/individuale-dirigente.md) | `'dirigente'` |

---

## Key Concepts

### What is Parental?

Parental is a Tighten package that enables **Single Table Inheritance (STI)** in Laravel Eloquent models.

### How It Works

```
┌─────────────────────────────────────────┐
│      performance_individuale table      │
│  id | type        | matr | ...         │
│  ───┼─────────────┼──────┼────         │
│   1  | dip         |  123 | ...        │
│   2  | po          |  456 | ...        │
│   3  | regionale   |  789 | ...        │
│   4  | dirigente   |  321 | ...        │
└─────────────────────────────────────────┘
                    │
                    │ type column
                    ▼
    ┌───────────────────────────────┐
    │  Individuale (Parent Model)   │
    │  - use HasChildren            │
    │  - $childColumn = 'type'      │
    │  - $childTypes = [...]        │
    └───────────────────────────────┘
                    │
        ┌───────────┼───────────┐
        │           │           │
        ▼           ▼           ▼
┌──────────────┐ ┌────────┐ ┌──────────┐
│IndividualeDip│ │Indiv.Po│ │Ind.Reg.  │
│ use HasParent│ │use ... │ │use ...   │
│ +boot()      │ │+boot() │ │+boot()   │
│where type=dip│ │where...│ │where...  │
└──────────────┘ └────────┘ └──────────┘
```

### Critical Rules

1. **Parent Model** must use `HasChildren` trait
2. **Child Models** must use `HasParent` trait
3. **ALL Child Models** MUST have `boot()` method with global scope
4. Global scope must filter by the exact type value from `$childTypes`

---

## Implementation Pattern

### Parent Model Configuration

```php
namespace Modules\Performance\Models;

use Parental\HasChildren;

class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    protected string $childColumn = 'type';

    protected array $childTypes = [
        'dip' => IndividualeDip::class,
        'po' => IndividualePo::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];
}
```

### Child Model Configuration (REQUIRED)

```php
namespace Modules\Performance\Models;

use Parental\HasParent;
use Illuminate\Database\Eloquent\Builder;

class IndividualeRegionale extends Individuale
{
    use HasParent;

    /**
     * Boot the model and add global scope to filter by type.
     *
     * CRITICAL: Without this, querying IndividualeRegionale::all()
     * returns ALL records instead of just type='regionale'
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function (Builder $query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**Repeat for each child model:**
- `IndividualeDip` → `where('type', 'dip')`
- `IndividualePo` → `where('type', 'po')`
- `IndividualeDirigente` → `where('type', 'dirigente')`

---

## Common Issues & Solutions

### Issue: Child model returns all records

**Symptom:** `IndividualeRegionale::all()` returns records with type='dip', 'po', etc.

**Cause:** Missing `boot()` method with global scope

**Solution:** Add `boot()` method:
```php
protected static function boot(): void
{
    parent::boot();
    static::addGlobalScope(fn ($q) => $q->where('type', 'regionale'));
}
```

**See:** [`bugfix-individuale-regionale-parental-scope.md`](bugfix-individuale-regionale-parental-scope.md)

### Issue: Type column not populated on save

**Symptom:** New records have `type = NULL`

**Cause:** Child model not using `HasParent` trait correctly

**Solution:** Ensure child extends parent and uses `HasParent`:
```php
class IndividualeRegionale extends Individuale  // ✓
{
    use HasParent;  // ✓
}
```

### Issue: Wrong type value in global scope

**Symptom:** Global scope uses wrong value

**Wrong:**
```php
$query->where('type', IndividualeRegionale::class);  // ❌
```

**Correct:**
```php
$query->where('type', 'regionale');  // ✓ (matches $childTypes key)
```

---

## Testing

### Test Child Model Filtering

```php
public function test_child_model_filters_by_type(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    
    $result = IndividualeRegionale::all();
    
    expect($result)->toHaveCount(1);
    expect($result->first()->type)->toBe('regionale');
}
```

### Test Parent Model Returns All Children

```php
public function test_parent_model_returns_all_children(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    
    $result = Individuale::all();
    
    expect($result)->toHaveCount(2);
    expect($result->where('type', 'regionale')->first())
        ->toBeInstanceOf(IndividualeRegionale::class);
}
```

---

## Performance Considerations

| Approach | Records Fetched | Memory | Performance |
|----------|----------------|--------|-------------|
| ❌ No global scope | 1000 (all types) | ~5 MB | Slow |
| ✅ With global scope | 200 (filtered) | ~1 MB | Fast |

**Always use global scopes!**

---

## Advanced Patterns

### Removing Global Scope When Needed

```php
// Get ALL records (ignoring global scope)
IndividualeRegionale::withoutGlobalScopes()->get();

// Remove specific scope
IndividualeRegionale::withoutGlobalScope('type')->get();
```

### Multiple Scopes

```php
protected static function boot(): void
{
    parent::boot();

    static::addGlobalScope('type', function ($query) {
        $query->where('type', 'regionale');
    });

    static::addGlobalScope('active', function ($query) {
        $query->where('ha_diritto', 1);
    });
}
```

---

## Related Documentation

### Within Performance Module

- [`../README.md`](../README.md) - Module overview
- [`models/`](models/) - All model documentation
- [`testing/`](testing/) - Testing guides

### Cross-Module References

- `Modules/Ptv/docs/worker-type-enum.md` - WorkerType enum used in type column
- `Modules/Xot/docs/eloquent-patterns.md` - General Eloquent patterns
- `docs/rules/parental-sti-pattern.md` - Project-wide rules (if exists)

### External References

- [Tighten Parental GitHub Repository](https://github.com/tighten/parental)
- [Laravel Global Scopes Documentation](https://laravel.com/docs/eloquent#global-scopes)
- [Single Table Inheritance Pattern (Martin Fowler)](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)

---

## Changelog

### 2025-04-01

- ✅ Added global scope to all child models (IndividualeRegionale, IndividualeDip, IndividualePo, IndividualeDirigente)
- ✅ Created comprehensive documentation (parental-research-complete.md, parental-sti-filtering.md)
- ✅ Updated QWEN.md with Parental STI pattern rule
- ✅ Fixed bug: child models showing all records instead of filtered by type

### Previous

- Initial Parental implementation with HasChildren/HasParent traits
- Configured $childTypes mapping in Individuale parent model

---

## Maintenance Checklist

When adding new child models:

- [ ] Extend from parent model (`Individuale`)
- [ ] Use `HasParent` trait
- [ ] Add `boot()` method with global scope
- [ ] Filter by correct type value (must match `$childTypes` key)
- [ ] Add to parent's `$childTypes` array
- [ ] Create model documentation
- [ ] Add tests for filtering
- [ ] Update this index

---

**Last Updated:** 2025-04-01  
**Maintained By:** Performance Module Team  
**Status:** ✅ Complete & Verified
