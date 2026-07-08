# Common Error Patterns and Corrections in Laraxot

This document outlines the most common error patterns identified in the Laraxot codebase and their correction strategies, following DRY + KISS + SOLID + Robust principles.

## 1. Duplicate Import Statements

### Pattern
```php
use Filament\Support\Components\Component;
use Filament\Support\Components\Component; // Duplicate!
```

### Examples Found
- `Modules/Geo/app/Filament/Resources/LocationResource.php`
- `Modules/Cms/app/Filament/Resources/SectionResource.php`
- `Modules/Geo/app/Models/County.php`
- `Modules/Geo/app/Models/PlaceType.php`
- `Modules/Geo/app/Models/GeoNamesCap.php`
- `Modules/Geo/app/Models/State.php`
- `Modules/UI/tests/Unit/Widgets/MockCalendarWidget.php`

### Correction Strategy
Remove duplicate import statements, keeping only one instance per import.

## 2. Incorrect Trait Usage

### Pattern
```php
// Incorrect - referencing local namespace when trait is in another module
use Traits\HasXotFactory;
use Traits\RelationX;

// Correct - using fully qualified namespace
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
```

### Examples Found
- `Modules/User/app/Models/BaseUser.php` - traits from Xot module incorrectly referenced

### Correction Strategy
- Identify which traits exist in the local module vs. Xot module
- Use fully qualified namespaces for traits from other modules
- Keep local module traits with relative references

## 3. Property Access on Mixed Types

### Pattern
```php
// Incorrect - property_exists() doesn't work with Eloquent magic attributes
if (property_exists($model, 'attribute')) {
    $value = $model->attribute;
}

// Correct - use isset() for magic attributes
if (isset($model->attribute)) {
    $value = $model->attribute;
}
```

### Correction Strategy
- Use `isset()` for Eloquent magic attributes
- Use `hasAttribute()` if available
- Use `isFillable()` for fillable attributes
- Use `Schema::hasColumn()` for database columns

## 4. Array Helper Return Type Narrowing

### Pattern
```php
// Incorrect - Arr::only() returns untyped array
$toArray = $addressData->toArray();
$up = Arr::only($toArray, ['latitude', 'longitude']);
$address->update($up); // Error: expects array<string, mixed>

// Correct - add type narrowing with PHPDoc
$toArray = $addressData->toArray();
$up = Arr::only($toArray, ['latitude', 'longitude']);
/** @var array<string, mixed> $up */
$address->update($up);
```

### Correction Strategy
- Add PHPDoc for type narrowing after array helper functions
- Use when the result is passed to methods expecting specific array types

## 5. External Package Builder Method Type Issues

### Pattern
```php
// Incorrect - external package methods like isLeaf() break type inference
$collection = Model::query()
    ->isLeaf()  // Method from staudenmeir/laravel-adjacency-list
    ->get();
return $collection->sortBy(...); // Error: Cannot call method on mixed

// Correct - add type narrowing after get()
$collection = Model::query()
    ->isLeaf()
    ->get();

/** @var Collection<int, Model> $collection */
return $collection->sortBy(...);
```

### Correction Strategy
- Add PHPDoc after `->get()` when using external package methods
- Specify the correct Collection type for proper method inference

## 6. Filament Class Extension Rules

### Pattern
```php
// Incorrect - extending Filament classes directly
use Filament\Resources\Resource;
class MyResource extends Resource { ... }

// Correct - extending XotBase classes
use Modules\Xot\Filament\Resources\XotBaseResource;
class MyResource extends XotBaseResource { ... }
```

### Correction Strategy
- Always extend XotBase classes instead of Filament classes directly
- Follow the mapping: Resource → XotBaseResource, Page → XotBasePage, Widget → XotBaseWidget, etc.

## 7. Form Schema Array Structure

### Pattern
```php
// Incorrect - indexed array instead of associative with string keys
public function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
    ]; // Returns array<int, Component>
}

// Correct - associative array with string keys
public function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => TextInput::make('email')->email()->required(),
    ]; // Returns array<string, mixed>
}
```

### Correction Strategy
- Use string keys for all Filament schema arrays
- This enables proper Livewire binding and state management

## 8. Laravel 11+ Cast Method Usage

### Pattern
```php
// Incorrect - deprecated property
class User extends Model
{
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

// Correct - Laravel 11+ method
class User extends Model
{
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
```

### Correction Strategy
- Replace `$casts` property with `casts()` method in Laravel 11+
- Ensure all properties used in code are defined in casts()

## 9. Notification via() Method Return Type

### Pattern
```php
// Incorrect - returning list<string>
public function via($notifiable): array
{
    return ['mail', 'nexmo'];
}

// Correct - returning array<string, mixed>
/** @return array<string, mixed> */
public function via($notifiable): array
{
    return [
        'mail' => 'mail',
        'nexmo' => 'nexmo',
    ];
}
```

### Correction Strategy
- Use associative array structure for notification channels
- Include proper PHPDoc return type annotation

## 10. Carbon createFromFormat Return Type

### Pattern
```php
// Incorrect - expecting Carbon always
$targetMonth = Carbon::createFromFormat('Y-m', $month);
$value = $targetMonth->startOfMonth(); // Error if $targetMonth is null

// Correct - handle nullable return
$targetMonth = Carbon::createFromFormat('Y-m', $month);
if ($targetMonth === null) {
    $targetMonth = now()->startOfMonth();
} else {
    $targetMonth = $targetMonth->startOfMonth();
}
```

### Correction Strategy
- Always check for null return from Carbon::createFromFormat
- Provide fallback behavior when format is invalid

---

## 10. High Complexity Methods - Pattern 10

**Problem**: Methods with high cyclomatic complexity (>10) that are difficult to understand and maintain.

**Solution**: Extract smaller, focused methods using the Single Responsibility Principle.

```php
// ❌ BEFORE - Complex method with multiple responsibilities
public function execute(QuestionChart $q, ?string $group_by = null, ?string $sort_by = null, ?AnswersFilterData $filter = null, ?Builder $responses = null): AnswersChartData
{
    // 300+ lines of code handling multiple concerns
    $field_name = $q->field_name;
    if (null === $filter) {
        $dateFrom = $q->date_from;
        $dateTo = $q->date_to;
    } else {
        // ... more complex logic
    }
    // ... hundreds of lines of complex logic
}

// ✅ AFTER - Extracted methods with single responsibilities
public function execute(QuestionChart $q, ?string $group_by = null, ?string $sort_by = null, ?AnswersFilterData $filter = null, ?Builder $responses = null): AnswersChartData
{
    // Handle custom question types first
    if (Str::startsWith((string) $q->question, 'custom:')) {
        return $this->handleCustomQuestionType($q, $group_by, $sort_by, $filter);
    }

    // Prepare initial parameters
    $field_name = $q->field_name;
    $dates = $this->getDates($q, $filter);
    $dateFrom = $dates['dateFrom'];
    $dateTo = $dates['dateTo'];

    // Get group and sort by parameters
    $groupBy = $this->getGroupBy($q, $group_by);
    $sortBy = $this->getSortBy($q, $sort_by);

    // ... other extracted method calls
}
```

**Benefits**:
- Reduces cyclomatic complexity from 39 to <10 per method
- Improves readability and maintainability
- Makes testing easier with focused methods
- Follows Single Responsibility Principle

## 11. Class Complexity Management - Pattern 11

**Problem**: Classes with overall complexity above threshold (typically 50) due to multiple responsibilities.

**Solution**:
1. Extract smaller methods with single responsibilities
2. Consider creating separate service classes for distinct concerns
3. Use composition over large monolithic classes

**Example Refactoring Process**:
- Identify methods with high complexity (cyclomatic complexity > 10)
- Extract helper methods for specific tasks
- Use method chaining or parameter objects to simplify interfaces
- Distribute complexity across multiple focused methods

---

These patterns were identified during comprehensive code analysis and represent the most common issues that cause PHPStan errors in the Laraxot codebase. Following these correction strategies will significantly improve code quality and reduce type-related errors.
