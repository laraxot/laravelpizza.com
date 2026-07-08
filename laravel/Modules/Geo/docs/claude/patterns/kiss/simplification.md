# KISS Patterns - Simplification

## Method Complexity Reduction

### Problem: God Methods

```php
// ❌ VIOLATION - 150+ line method with multiple responsibilities
protected function getViewData(): array
{
    // 20 lines: Database queries for ratings
    $ratings = Rating::where('extra_attributes->anno', $this->getAnno())
        ->where('model_type', $this->getRecord()::class)
        ->where('model_id', $this->getRecord()->id)
        ->get();

    // 30 lines: Complex calculations for indemnities
    $tot = $this->calculateTot($ratings);
    $imp_mese = $this->calculateMonthlyAmount($tot);
    $tredicesima = $this->calculateThirteenthMonth($imp_mese);
    $altri = $this->calculateOtherAllowances($ratings);

    // 50 lines: Form data manipulation and population
    $this->populateFormData($ratings, [
        'tot' => $tot,
        'importo mensile calcolato' => $imp_mese,
        'tredicesima' => $tredicesima,
        'altri emolumenti' => $altri,
    ]);

    // 30 lines: Date handling and normalization
    $this->normalizeDates();

    // 20 lines: Totals and summary calculations
    $totalIndennita = $this->calculateTotalIndennita($tot, $tredicesima, $altri);

    return [];
}
```

### Solution: Delegate to Focused Methods/Actions

```php
// ✅ COMPLIANT - Single responsibility, delegates to focused units
protected function getViewData(): array
{
    $ratings = $this->fetchRatings();
    $calculations = app(CalculateIndennitaAction::class)->execute($this->getRecord());

    $this->populateFormData($ratings, $calculations);
    $this->normalizeDates();

    return [];
}

/**
 * Fetch ratings for current record and year.
 */
private function fetchRatings(): Collection
{
    return Rating::where('extra_attributes->anno', $this->getAnno())
        ->where('model_type', $this->getRecord()::class)
        ->where('model_id', $this->getRecord()->id)
        ->get();
}

/**
 * Populate form data with calculated values.
 */
private function populateFormData(Collection $ratings, array $calculations): void
{
    foreach ($calculations as $title => $value) {
        $this->setRatingValue($ratings, $title, $value);
    }
}

/**
 * Normalize date fields for consistency.
 */
private function normalizeDates(): void
{
    $anno = $this->getAnno();

    $this->getRecord()->update([
        'dal' => $this->normalizeDate('dal', $anno, '01-01'),
        'al' => $this->normalizeDate('al', $anno, '12-31'),
    ]);
}
```

## View Resolution Simplification

### Problem: Complex String Manipulation

```php
// ❌ VIOLATION - Complex string operations for view resolution
public function getView(): string
{
    $class = __CLASS__;
    $module = Str::between($class, 'Modules\\', '\Filament');
    $after = explode('\\', Str::after($class, '\Filament\\'));
    $after[1] = Str::before($after[1], 'Resource');
    $after[3] = Str::before($after[3], $after[1]);
    $after = collect($after)->map(fn($item) => Str::kebab($item))->implode('.');
    $view = Str::lower($module).'::filament.'.$after;

    // 10+ more lines of string manipulation...
    return $view;
}
```

### Solution: Explicit View Property

```php
// ✅ COMPLIANT - Simple, explicit declaration
class EditIndennitaResponsabilita extends EditRecord
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennita-responsabilita::filament.resources.indennita-responsabilita-resource.pages.edit-indennita-responsabilita';

    public function getView(): string
    {
        if (!view()->exists($this->view)) {
            throw new ViewNotFoundException("View [{$this->view}] not found");
        }

        return $this->view;
    }
}
```

## Benefits

- **Readability**: Method purpose is immediately clear
- **Maintainability**: Changes require editing one string
- **Reliability**: Runtime validation prevents broken views
- **Performance**: No complex string operations at runtime

## Dead Code Elimination

### Problem: Commented and Debug Code

```php
// ❌ VIOLATION - Commented code and debug statements
public function execute(): void
{
    // Old implementation - delete if not needed
    /*
    $data = [
        'field' => 'value',
    ];
    $this->process($data);
    */

    // dddx($debug); // Debug line left in production

    // Temporary workaround - remove when API is ready
    if (config('app.env') === 'local') {
        Log::info('Debug: executing action', ['data' => $this->data]);
    }

    $this->newImplementation();
}
```

### Solution: Clean, Production-Ready Code

```php
// ✅ COMPLIANT - Clean, maintainable code
public function execute(): void
{
    $this->validateInput();
    $this->processBusinessLogic();
    $this->sendNotifications();
    $this->logExecution();
}
```

## Simplification Principles

### 1. Single Responsibility
Each method should do one thing and do it well.

### 2. Clear Naming
Method names should clearly indicate their purpose.

### 3. Fail Fast
Validate inputs early and provide clear error messages.

### 4. Avoid Nested Logic
Use early returns to reduce nesting.

### 5. Prefer Composition over Inheritance
Delegate complex logic to dedicated classes.

## Implementation Guidelines

### Maximum Method Length
- **Controller Methods**: 20 lines maximum
- **Service Methods**: 30 lines maximum
- **Helper Methods**: 10 lines maximum

### Complexity Metrics
- **Cyclomatic Complexity**: Keep under 10
- **Nesting Depth**: Maximum 3 levels
- **Parameter Count**: Maximum 4 parameters

### When to Split Methods
- Method exceeds length limits
- Method has multiple responsibilities
- Method contains complex conditional logic
- Method is difficult to unit test

---

**Focus**: Simplification techniques for complex code
**Goal**: Readable, maintainable, testable methods
