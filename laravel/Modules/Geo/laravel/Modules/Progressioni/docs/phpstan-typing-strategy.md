# PHPStan Typing Strategy - Progressioni Module

## Overview

This document outlines the comprehensive strategy for resolving 170 PHPStan level 10 errors in the Progressioni module. The module manages economic and career progressions with complex data models, actions, and Filament resources.

## Error Analysis

### Error Distribution
- **getFormSchema() Return Types**: 20+ errors
- **Mixed Type Issues**: 50+ errors (Actions, Models, Services)
- **Binary Operations**: 40+ errors (mixed operands)
- **Property Assignment**: 30+ errors (mixed to typed properties)
- **Method/Property Access**: 30+ errors (access on mixed)

### Root Causes
1. **Legacy Code**: Pre-PHPStan era code without strict typing
2. **Complex Models**: Models with 100+ properties and complex relationships
3. **Dynamic Data Processing**: Actions working with mixed data sources
4. **Filament Integration**: Resources without proper return type annotations

## Module Architecture

### Core Models
```php
// Primary entities requiring comprehensive typing
Progressioni    // Main progression model (150+ properties)
Schede         // Evaluation schedules (complex calculations)
SchedaCriteri  // Evaluation criteria
Valutatore     // Evaluators
```

### Key Actions
```php
// Queueable actions requiring parameter/return typing
RefreshByYearAction     // Batch processing
TrovaEsclusiAction      // Exclusion calculations
RefreshHaDirittoAction  // Rights validation
```

### Filament Resources
```php
// Resources with form schema typing issues
ProgressioniResource    // Main resource
SchedeResource         // Schedule management
10+ other resources     // Various entities
```

## Typing Strategy

### Phase 1: Documentation & Foundation (Current)
- [x] Error analysis and categorization
- [x] Architecture documentation
- [ ] Type foundation patterns
- [ ] Fix strategy documentation

### Phase 2: Quick Wins (getFormSchema fixes)
**Target**: 20+ return type errors
**Impact**: Immediate error count reduction
**Risk**: Low (isolated changes)

```php
// Before
public function getFormSchema(): array
{
    return [/* components */];
}

// After  
public function getFormSchema(): array<string, \Filament\Forms\Components\Component>
{
    return [/* components */];
}
```

### Phase 3: Core Model Typing
**Target**: Progressioni and Schede models
**Impact**: Foundation for all other fixes
**Risk**: Medium (affects dependent code)

#### Progressioni Model Strategy
```php
/**
 * @property int $id
 * @property string $post_type
 * @property string|null $scheda_type
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $anno
 * @property int|null $ha_diritto
 * @property string|null $motivo
 * @property float|null $perf_ind_media
 * @property int|null $excellences_count_last_3_years
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\SchedaCriteri> $schedaCriteris
 */
class Progressioni extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'post_type', 'scheda_type', 'ente', 'matr', 
        'cognome', 'nome', 'email', 'anno', 'ha_diritto', 'motivo'
    ];
    
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'perf_ind_media' => 'float',
            'ha_diritto' => 'integer',
            'excellences_count_last_3_years' => 'integer',
        ];
    }
}
```

### Phase 4: Action Typing
**Target**: Queueable actions with mixed parameters
**Impact**: Resolves core business logic typing
**Risk**: Medium-High (business logic critical)

#### RefreshByYearAction Strategy
```php
class RefreshByYearAction
{
    use QueueableAction;

    /**
     * Execute refresh by year.
     *
     * @param class-string<\Illuminate\Database\Eloquent\Model> $modelClass
     * @param string $fieldname
     * @param int|string $year
     */
    public function execute(string $modelClass, string $fieldname, int|string $year): void
    {
        $query = $modelClass::where($fieldname, $year)
            ->where(function (\Illuminate\Database\Eloquent\Builder $query): void {
                $query->whereDate('refreshed_at', '<', Carbon::now()->subDays(1))
                    ->orWhereNull('refreshed_at');
            });

        /** @var \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Progressioni> $rows */
        $rows = $query->inRandomOrder()->get();

        foreach ($rows as $row) {
            app(RefreshHaDirittoAction::class)
                ->onQueue()
                ->execute($row);
            $row->update(['refreshed_at' => now()]);
        }
    }
}
```

### Phase 5: Complex Calculations (Schede Model)
**Target**: Binary operation errors in calculations
**Impact**: Resolves mathematical computation typing
**Risk**: High (complex business logic)

#### Schede Model Calculation Strategy
```php
/**
 * Calculate converted value.
 *
 * @return float|int|null
 */
public function convertedIn(): float|int|null
{
    $base = (float) ($this->perf_ind_media ?? 0);
    $converted = $base * 2.5;
    
    return is_numeric($converted) ? $converted : null;
}

/**
 * Calculate weighted score.
 *
 * @return float
 */
public function calculateWeightedScore(): float
{
    $score = (float) ($this->totale_pond ?? 0);
    $weight = (float) ($this->peso_esperienza_acquisita ?? 1);
    
    return $score * $weight;
}
```

## Type Patterns

### Pattern riusabili emersi da PHPStan modulo Progressioni

- Per passare collection a servizi Ptv tipizzati su contratti, costruire una nuova `Collection<int, Contract>` tramite helper privato con `@return` esplicito. Evitare oggetti anonimi e array shape quando il servizio richiede modelli/contratti reali.
- Per override di relazioni Eloquent ereditate da classi Ptv, rispettare la generic PHPDoc del metodo base. Se il metodo base risolve gia' il model del modulo tramite namespace, preferire l'ereditarieta' invece di ridefinire la relazione concreta.
- Per `pluck('value', 'name')->all()` dichiarato `array<string, mixed>`, filtrare le chiavi non stringa con `mapWithKeys()` prima di restituire l'array.
- Per metodi che promettono union strette (`int|string|array<int,string>|Carbon|null`), normalizzare il valore prima del return e convertire gli array in liste di stringhe.
- Per filtri Filament, il PHPDoc deve descrivere il tipo realmente restituito (`SelectFilter` se l'array contiene solo `SelectFilter`), senza allargare a classi base non compatibili con le generic invarianti.

### Collection Typing
```php
// Use proper generics
/** @return \Illuminate\Database\Eloquent\Collection<int, Progressioni> */
public function getProgressioni(): Collection
{
    return $this->hasMany(Progressioni::class)->get();
}
```

### Union Types for Mixed
```php
// Replace mixed with specific unions
public function processValue(string|int|float|null $value): string
{
    return (string) $value;
}
```

### Closure Typing
```php
// Type closures properly
->where(function (\Illuminate\Database\Eloquent\Builder $query): void {
    $query->where('active', true);
})
```

## Validation Strategy

### After Each File Fix
```bash
cd laravel
./vendor/bin/phpstan analyze Modules/Progressioni/app/Actions/RefreshByYearAction.php --level=10
```

### Progress Tracking
- Phase 2: Target 20 errors → 0 errors (getFormSchema)
- Phase 3: Target 50 errors → 30 errors (Core Models)  
- Phase 4: Target 30 errors → 15 errors (Actions)
- Phase 5: Target 70 errors → 0 errors (Complex Logic)

## Risk Mitigation

### File Locking Protocol
1. Create `{filename}.lock` before editing
2. Verify no existing lock
3. Edit file
4. Remove lock after validation

### Rollback Strategy
- Git commits after each phase
- PHPStan baseline for temporary exceptions
- Feature branch for isolated testing

## Documentation Updates

### Required Documentation
- [ ] `models-typing.md` - Model type annotations
- [ ] `actions-typing.md` - Action parameter/return types
- [ ] `calculation-patterns.md` - Mathematical operation typing
- [ ] Update main README.md with typing guidelines

## Timeline Estimation

- **Phase 2**: 2-3 hours (getFormSchema fixes)
- **Phase 3**: 4-6 hours (Core model typing)
- **Phase 4**: 6-8 hours (Action typing)
- **Phase 5**: 8-12 hours (Complex calculations)
- **Total**: 20-29 hours spread across multiple sessions

## Success Criteria

1. **Zero PHPStan errors** at level 10
2. **Comprehensive type coverage** for all public methods
3. **Updated documentation** with typing patterns
4. **No regression** in functionality
5. **Improved IDE support** with proper type hints

---

**Created**: 2025-11-18  
**Author**: Cascade AI Assistant  
**Status**: 📋 Planning Phase  
**Next Step**: Begin Phase 2 - getFormSchema return type fixes
