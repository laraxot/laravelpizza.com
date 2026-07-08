# Performance Module Models

Documentation for all Eloquent models in the Performance module.

## Model Categories

### Parent Models (STI)

| Model | Description | Documentation |
|-------|-------------|---------------|
| `Individuale` | Base parent model for individual performance evaluations | [`individuale.md`](individuale.md) |
| `BaseIndividualeModel` | Abstract base with core functionality | [`base-individuale-model.md`](base-individuale-model.md) |

### Child Models (STI - Single Table Inheritance)

All child models extend `Individuale` and use `HasParent` trait with global scope filtering.

| Model | Type Value | Description | Documentation |
|-------|-----------|-------------|---------------|
| `IndividualeDip` | `'dip'` | Employee performance evaluations | [`individuale-dip.md`](individuale-dip.md) |
| `IndividualePo` | `'po'` | PO (Punto Organizzativo) evaluations | [`individuale-po.md`](individuale-po.md) |
| `IndividualeRegionale` | `'regionale'` | Regional performance evaluations | [`individuale-regionale.md`](individuale-regionale.md) |
| `IndividualeDirigente` | `'dirigente'` | Manager evaluations | [`individuale-dirigente.md`](individuale-dirigente.md) |

### Related Models

| Model | Description | Documentation |
|-------|-------------|---------------|
| `IndividualePesi` | Weights for individual evaluations | [`individuale-pesi.md`](individuale-pesi.md) |
| `IndividualeTotStabi` | Totals by stabilization | [`individuale-tot-stabi.md`](individuale-tot-stabi.md) |
| `Organizzativa` | Organizational performance evaluations | [`organizzativa.md`](organizzativa.md) |
| `PerformanceFondo` | Performance fund management | [`performance-fondo.md`](performance-fondo.md) |

### Criteria & Options Models

| Model | Description | Documentation |
|-------|-------------|---------------|
| `CriteriEsclusione` | Exclusion criteria | [`criteri-esclusione.md`](criteri-esclusione.md) |
| `CriteriMaggiorazione` | Bonus criteria | [`criteri-maggiorazione.md`](criteri-maggiorazione.md) |
| `CriteriOption` | Option criteria | [`criteri-option.md`](criteri-option.md) |
| `CriteriValutazione` | Evaluation criteria | [`criteri-valutazione.md`](criteri-valutazione.md) |

### Supporting Models

| Model | Description | Documentation |
|-------|-------------|---------------|
| `CategoriaPropro` | Professional categories | [`categoria-propro.md`](categoria-propro.md) |
| `StabiDirigente` | Stabilization managers | [`stabi-dirigente.md`](stabi-dirigente.md) |
| `MyLog` | Logging system | [`my-log.md`](my-log.md) |
| `Option` | Configuration options | [`option.md`](option.md) |

---

## Single Table Inheritance (STI) Pattern

This module uses **Tighten/Parental** for Single Table Inheritance.

### Architecture

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
                    ▼
        ┌───────────────────────┐
        │   Individuale         │
        │   (Parent Model)      │
        │   use HasChildren     │
        └───────────────────────┘
                    │
        ┌───────────┼───────────┐
        │           │           │
        ▼           ▼           ▼
┌──────────────┐ ┌────────┐ ┌──────────┐
│IndividualeDip│ │Indiv.Po│ │Ind.Reg.  │
│ type='dip'   │ │type=po │ │type=reg. │
└──────────────┘ └────────┘ └──────────┘
```

### Key Requirements

**Parent Model (`Individuale`):**
- Use `HasChildren` trait
- Define `$childColumn = 'type'`
- Define `$childTypes` array mapping type values to child classes

**Child Models (ALL must have):**
- Use `HasParent` trait
- Extend from parent model (`Individuale`)
- **CRITICAL:** Add `boot()` method with global scope filtering by type

### Example Child Model

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

### Why Global Scope is Required

**Without global scope:**
```php
IndividualeRegionale::all();
// ❌ Returns ALL records (dip, po, regionale, dirigente)
```

**With global scope:**
```php
IndividualeRegionale::all();
// ✅ Returns ONLY type='regionale' records
```

---

## Model Conventions

### Naming

- Models use PascalCase: `IndividualeRegionale`
- Tables use snake_case: `performance_individuale`
- Type values use lowercase: `'regionale'`

### Base Classes

- All models extend `BaseModel` (from Xot module)
- STI models extend `Individuale` (parent)
- Use `XotBase*` wrappers for Filament resources

### Traits

Common traits used across models:

- `HasFactory` - Factory support
- `Updater` - Created/updated by tracking
- `LogsActivity` - Activity logging (Spatie)
- `HasChildren` / `HasParent` - STI support (Parental)

### Casts

Standard casts used:

```php
protected function casts(): array
{
    return [
        'type' => WorkerType::class.':nullable',
        'ente' => 'integer',
        'matr' => 'integer',
        'anno' => 'integer',
        'ha_diritto' => 'integer',
        'totale_punteggio' => 'float',
        'excellence' => 'bool',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

---

## Testing Models

### Factory Pattern

```php
IndividualeRegionale::factory()
    ->count(5)
    ->create(['anno' => 2025, 'ente' => 90]);
```

### Testing STI Filtering

```php
public function test_child_model_filters_correctly(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    
    expect(IndividualeRegionale::count())->toBe(1);
    expect(Individuale::count())->toBe(2);
}
```

### Testing Type Assignment

```php
public function test_type_is_auto_assigned(): void
{
    $regionale = IndividualeRegionale::factory()->create();
    expect($regionale->type)->toBe('regionale');
}
```

---

## Related Documentation

### Within Module

- [`../parental-index.md`](../parental-index.md) - Complete Parental STI guide
- [`../parental-sti-filtering.md`](../parental-sti-filtering.md) - Global scope implementation
- [`../parental-research-complete.md`](../parental-research-complete.md) - Research & alternatives
- [`../README.md`](../README.md) - Module overview

### Cross-Module

- `Modules/Ptv/docs/worker-type-enum.md` - WorkerType enum
- `Modules/Xot/docs/eloquent-models.md` - Base model patterns
- `Modules/Xot/docs/model-conventions.md` - Model naming & structure

### External

- [Tighten Parental](https://github.com/tighten/parental)
- [Laravel Eloquent Models](https://laravel.com/docs/eloquent)
- [Single Table Inheritance](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)

---

## Maintenance

### Adding New Child Models

1. Create model extending `Individuale`
2. Add `HasParent` trait
3. Add `boot()` method with global scope
4. Add to parent's `$childTypes` array
5. Create factory
6. Create documentation
7. Add tests

### Checklist

- [ ] Model extends correct parent
- [ ] Uses `HasParent` trait
- [ ] Has `boot()` method with global scope
- [ ] Type value matches `$childTypes` key
- [ ] Factory created
- [ ] Documentation added
- [ ] Tests passing
- [ ] PHPStan Level 10 clean
- [ ] Laravel Pint clean

---

**Last Updated:** 2025-04-01  
**Maintained By:** Performance Module Team  
**Status:** ✅ All models documented
