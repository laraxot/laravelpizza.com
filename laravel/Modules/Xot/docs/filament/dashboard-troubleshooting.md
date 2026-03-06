# Dashboard Troubleshooting

## Livewire Attribute Error

When encountering "Can't get the value of a non-property attribute" error in Dashboard pages:

### Problem
The `HasFiltersForm` trait uses Livewire `#[Url]` attribute which can cause compatibility issues.

### Solution
Remove the `HasFiltersForm` trait from `XotBaseDashboard` and simplify the implementation:

```php
// ❌ Before - Causes attribute error
use FilamentDashboard\Concerns\HasFiltersForm;

abstract class XotBaseDashboard extends FilamentDashboard
{
    use FilamentDashboard\Concerns\HasFiltersForm;
    // ...
}

// ✅ After - Fixed
abstract class XotBaseDashboard extends FilamentDashboard
{
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            // Override if needed
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
```

## Method Signature Compatibility

### Problem
"Declaration of XotBaseDashboard::getColumns(): array|string|int must be compatible with Filament\Pages\Dashboard::getColumns(): array|int"

### Solution
Ensure method signatures match the parent class exactly:

```php
// ❌ Wrong return type
public function getColumns(): int|string|array

// ✅ Correct return type - matches parent
public function getColumns(): int|array
```

## #[Override] Attribute Error

### Problem
"Dashboard::getFiltersFormSchema() has #[\Override] attribute, but no matching parent method exists"

### Solution
Remove the `#[Override]` attribute and the method itself from child dashboards when the parent method no longer exists:

```php
// ❌ Before - Causes error
use Override;

class Dashboard extends XotBaseDashboard
{
    #[Override]
    public function getFiltersFormSchema(): array
    {
        return [
            DatePicker::make('startDate')->native(false),
            DatePicker::make('endDate')->native(false),
        ];
    }
}

// ✅ After - Fixed
class Dashboard extends XotBaseDashboard
{
    // Method removed since parent no longer has it
}
```

## Key Points

1. **Never use HasFiltersForm trait** - causes Livewire attribute errors
2. **Match parent method signatures exactly** - PHP strict typing requires compatibility
3. **Remove #[Override] attributes** when parent methods are removed
4. **Keep dashboard implementation simple** - avoid complex trait dependencies
5. **Test after changes** - ensure dashboard loads without errors

## Related Files

- `Modules/Xot/app/Filament/Pages/XotBaseDashboard.php`
- `Modules/<nome progetto>/app/Filament/Pages/Dashboard.php`
- `Modules/Activity/app/Filament/Pages/Dashboard.php`
- `Modules/User/app/Filament/Pages/Dashboard.php`
