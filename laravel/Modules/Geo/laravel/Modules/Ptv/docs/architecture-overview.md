---
title: "Ptv Module Architecture Overview"
module: "Ptv"
tags: [architecture, domain-model, action-pattern, filament]
related:
  - "./phpstan-analysis-2026-06-15.md"
  - "../README.md"
---

# Ptv Module — Architecture Overview

## Module Purpose

**Ptv** (Piano Triennale di Valutazione / Three-Year Evaluation Plan) manages:
- Evaluation cycles and annual plans
- Budget allocation and tracking
- Evaluator assignments and scorecards
- Exclusion criteria and calculations
- Multi-language reporting (IT/EN)

## Core Domain Model

### Central Entity: BaseScheda
```
BaseScheda (main evaluation record)
├── Budget Management
│   ├── budgetImportato (imported budget)
│   ├── budgetAssegnato (assigned budget)
│   └── quotaTeorioca (quota calculation)
├── Relationships
│   ├── hasMany(Valutatore) [evaluators]
│   ├── belongsToMany(Criteri) [exclusion criteria]
│   └── belongsTo(Anno) [year]
└── Status Tracking
    └── evaluation_year, status flags
```

### Supporting Models
- **Valutatore**: Evaluator/Appraiser (has User, calculates rest/position)
- **Criteri***: Business rule evaluators (Noposiz, Nodisci, Noposfun, etc.)
- **User**: Extended with Spatie roles (valutatore, admin, super-admin)

## Contratti e Composizione Interface

`SchedaContract` è il contratto composito che unifica i sub-contratti Sigma:

```php
// Modules/Ptv/app/Models/Contracts/SchedaContract.php
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}

// BaseScheda implementa SOLO il composito
abstract class BaseScheda extends BaseModel implements SchedaContract
```

**Regola**: MAI elencare multipli contratti su una classe se esiste un composito.
I sub-contratti sono definiti in `Modules\Sigma\Models\Contracts\`.

## Action-Based Architecture

### Pattern: Command Pattern via Actions

**Directory Structure:**
```
app/Actions/
├── Scheda/                    # Budget & quota calculations
│   ├── UpdateBudgetAssegnatoAction.php
│   ├── UpdateQuotaTeoricaAction.php
│   ├── UpdateRestiPondByValutatoreIdAction.php
│   ├── Check*.php             # Pre-calculation checks
│   └── [41+ total errors]
├── Check/                     # Validation actions
│   ├── NopropoList.php        # Valutatore positioning checks
│   └── [11 errors]
├── CriteriEsclusione/         # Exclusion logic
│   ├── Nodisci*.php           # Discipline checks
│   ├── Noposiz*.php           # Position checks
│   └── [5 errors]
└── PopulateByYearAction.php   # Bulk year operations
```

**Typical Action Signature:**
```php
class UpdateBudgetAssegnatoAction
{
    public function execute(BaseScheda $scheda, float $amount): void
    {
        // Business logic
        $scheda->budgetAssegnato = $amount;
        // Cascading calculations...
    }
}
```

### Type System Challenges (PHPStan Errors)

**Issue 1: Nullable Model Properties**
```php
// Ptv/app/Models/BaseScheda.php line 85
$budgetImportato?->importo  // Unsafe chaining

// Fix:
if (null !== $budgetImportato = $scheda->budgetImportato) {
    $amount = $budgetImportato->importo;
}
```

**Issue 2: Spatie Macro Type Hints**
```php
// Ptv/app/Models/User.php line 110
/** @method Builder permission() */
// PHPStan can't resolve Modules\Ptv\Models\Builder

// Fix: Use explicit type assertion
assert($builder instanceof Builder);
```

**Issue 3: String → class-string Conversions**
```php
// Ptv/app/Models/Valutatore.php line 138
$this->hasMany($relationshipClass)  // String vs class-string

// Fix:
assert(class_exists($relationshipClass));
$this->hasMany($relationshipClass);
```

## Filament Integration

### Resources with Type Issues
```
app/Filament/Resources/
├── SinPage.php        # ← 4+ argument.type errors
├── CycleResource.php  # ← 3+ argument.type errors
└── ValutatorResource.php  # ← 2+ argument.type errors
```

**Pattern: Filament Resource → Form + Table**
```php
class SinPageResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Filament schema components
        ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table->columns([
            // Table columns
        ]);
    }
}
```

## Language & Translation Strategy

### Translation Files
```
lang/
├── it/actions.php     ← ✅ Cleaned (12 duplicates removed)
├── en/actions.php     ← ✅ Cleaned (12 duplicates removed)
└── [additional files]
```

**Key Translation Groups:**
- `actions.compila` — Form filling actions
- `actions.showing_records` — Table display messages
- `actions.delete_cessati` — Record deletion flows
- `actions.import` / `actions.export` — Data operations

## Data Flow Patterns

### Budget Calculation Pipeline
```
ImportedBudget
    ↓ UpdateBudgetAssegnatoAction
AssignedBudget
    ↓ UpdateQuotaTeoricaAction
QuotaTeorioca
    ↓ UpdateRestiPondAction
RestiPond (weighted remainder)
    ↓ CriteriaCheck Actions (Nodisci, Noposiz, etc.)
FinalEvaluation
```

### Evaluator Assignment Flow
```
Valutatore
    ├── Role Check (Spatie)
    ├── Position Validation (Noposiz criteria)
    ├── Rest Calculation (UpdateRestiPondByValutatoreId)
    └── Exclusion Checks (CriteriEsclusione)
```

## Technical Debt / Known Issues

### 1. **Unsafe Property Access** (method.nonObject errors)
- Many actions assume non-null relationships
- Missing null guards on optional properties
- Should add defensive checks or use strict DTOs

### 2. **Type Inference Gaps** (argument.type errors)
- Spatie Permission macros not fully typed
- Laravel magic methods (belongsToMany, hasMany) type challenges
- Model properties sometimes used as mixed types

### 3. **Translation Key Duplication** ✅ Fixed
- Duplicate keys in translation arrays (now cleaned)
- Pattern: old definition → new improved definition

### 4. **Missing Documentation**
- Action contracts not documented
- Model property purposes unclear
- Business rule logic encoded in methods without comments

## Improvement Recommendations

### Short-term (PHPStan Compliance)
1. Add null checks in high-error Actions
2. Use type assertions for Spatie methods
3. Create type stubs if needed for macros
4. Document action interfaces

### Medium-term (Architecture)
1. Extract magic strings to enums (Criteri types, statuses)
2. Create DTOs for action parameters
3. Document calculation algorithms in BaseScheda
4. Add integration tests for action chains

### Long-term (Refactoring)
1. Consider Query Builder pattern for evaluator checks
2. Separate read/write concerns in actions
3. Formalize contract interfaces for actions
4. Create dedicated test fixtures for edge cases

## Usage Patterns

### From Controllers/APIs
```php
// Typical usage
$action = app(UpdateBudgetAssegnatoAction::class);
$action->execute($scheda, $newAmount);

// Batch operations
foreach ($schede as $scheda) {
    app(PopulateByYearAction::class)->execute($scheda, $year);
}
```

### From Filament Resources
```php
// In SinPageResource or similar
public static function table(Table $table): Table
{
    return $table->columns([
        // Uses data from actions above
    ])->actions([
        // Action buttons that trigger actions
    ]);
}
```

## Testing Strategy

- **Unit Tests:** Action classes in isolation
- **Integration Tests:** Multi-action calculation flows
- **Type Tests:** PHPStan compliance verification
- **Feature Tests:** Filament resource operations

## References

- **Main Model:** `app/Models/BaseScheda.php`
- **Action Hub:** `app/Actions/Scheda/`, `Check/`, `CriteriEsclusione/`
- **Config:** `config/ptv.php` (if exists)
- **Migrations:** `database/migrations/ptv_*`

---

**Last Updated:** 2026-06-15  
**PHPStan Status:** 133 errors (in progress)  
**Coverage:** Actions, Models, Filament Resources, Languages
