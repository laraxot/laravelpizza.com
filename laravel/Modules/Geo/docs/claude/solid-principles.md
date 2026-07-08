# SOLID Principles in Laraxot

## Single Responsibility Principle (SRP)

### ❌ Violation: Business Logic in Relations

```php
// ❌ WRONG - Relation method doing too much
public function importi(): HasOne
{
    $row = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
        ->where('anno', $this->anno);
    
    if (0 === $row->count()) {
        // Creating records, echoing HTML, complex logic
        echo '<h3>Error message</h3>'; // ❌ NEVER echo in models
        $newRow = $oldRow->replicate();
        $newRow->save();
    }
    
    return $row;
}
```

```php
// ✅ CORRECT - Relation only defines relationship
public function importi(): HasOne
{
    return $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
        ->where('anno', $this->anno);
}

// Business logic in Action
class EnsureImportiExistsAction
{
    use QueueableAction;
    
    public function execute(Model $model): ImportiCategoria
    {
        return $model->importi ?? $this->createFromPreviousYear($model);
    }
}
```

### ❌ Violation: Page Doing Calculations

```php
// ❌ WRONG - Page with 100+ lines of business logic
protected function getViewData(): array
{
    $tot = $rows->reduce(...);
    $imp_mese_calcolato = $tot * 10; // Magic number
    $imp_anno_attribuito = $imp_mese_attribuito * 12 * $perc;
    // ... 50+ more lines of calculations
}
```

```php
// ✅ CORRECT - Delegate to Action
protected function getViewData(): array
{
    return app(CalculateIndennitaAction::class)
        ->execute($this->getRecord(), $this->form_data);
}
```

## Open/Closed Principle (OCP)

### ❌ Violation: Hardcoded Constants

```php
// ❌ WRONG - Magic numbers in code
$imp_mese_calcolato = $tot * 10;
$imp_anno = $imp_mese * 12 * $perc;
```

```php
// ✅ CORRECT - Configurable constants
class IndennitaConfig
{
    public const MONTHLY_MULTIPLIER = 10;
    public const MONTHS_PER_YEAR = 12;
}

$imp_mese_calcolato = $tot * IndennitaConfig::MONTHLY_MULTIPLIER;
```

## Liskov Substitution Principle (LSP)

### ❌ Violation: Inconsistent Relationship Types

```php
// BaseScheda defines:
public function anag(): HasOne { ... }

// Child model overrides with different type:
public function anag(): BelongsTo { ... } // ❌ LSP violation
```

```php
// ✅ CORRECT - Use consistent types or separate methods
public function anag(): BelongsTo { ... }      // For child models
public function anagRecord(): HasOne { ... }  // For parent models
```

## Interface Segregation Principle (ISP)

### ❌ Violation: Fat Traits

```php
// ❌ WRONG - Trait with unrelated methods
trait RelationshipTrait
{
    public function mails() { ... }
    public function ratings() { ... }
    public function importi() { ... }
    public function anag() { ... }
    // 10+ more methods
}
```

```php
// ✅ CORRECT - Focused traits
trait HasMailsTrait
{
    public function mails(): HasMany { ... }
}

trait HasRatingsTrait
{
    public function ratings(): MorphToMany { ... }
}

trait HasAnagTrait
{
    public function anag(): BelongsTo { ... }
}
```

## Dependency Inversion Principle (DIP)

### ❌ Violation: Direct Request Access

```php
// ❌ WRONG - Direct dependency on request
public function mails(): HasMany
{
    $stabi = request()->input('stabi', '');
    $repar = request()->input('repar', '');
    return $this->hasMany(...)->where('stabi', $stabi);
}
```

```php
// ✅ CORRECT - Pass dependencies explicitly
public function mailsForStabi(int $stabi, int $repar): HasMany
{
    return $this->hasMany(...)->where('stabi', $stabi)->where('repar', $repar);
}

// Or use scope
public function scopeForStabi(Builder $query, int $stabi, int $repar): Builder
{
    return $query->where('stabi', $stabi)->where('repar', $repar);
}
```

## Common Violations in Laraxot

| Violation | Location | Fix |
|-----------|----------|-----|
| Echo in models | `RelationshipTrait::importi()` | Use exceptions or logging |
| Request in models | `RelationshipTrait::mails()` | Pass parameters explicitly |
| Magic numbers | `CompilaPage::getViewData()` | Use constants or config |
| Fat Pages | `CompilaPage` | Extract to Actions |
| Commented code | Multiple files | Remove, use Git history |

## Checklist for SOLID Compliance

- [ ] Relations only define relationships (no business logic)
- [ ] Actions handle all business logic
- [ ] No magic numbers (use constants)
- [ ] No direct request access in models
- [ ] Focused traits (one responsibility each)
- [ ] Consistent relationship types in inheritance
- [ ] No echo/print in models or traits
- [ ] Dependencies injected, not fetched

---

**Version**: 1.0  
**File**: solid-principles.md - SOLID principles and common violations
