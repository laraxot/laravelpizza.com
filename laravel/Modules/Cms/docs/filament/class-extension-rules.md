# Filament Class Extension Rules

## Base Class Extension Rules

### Always Extend XotBase Classes

| Standard Filament Class | XotBase Class to Extend |
|-------------------------|--------------------------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |

## Resource Rules

### Do Not Override These Methods in XotBaseResource

Classes extending `XotBaseResource` should NOT implement these methods as they are already provided by the base class:

- `getTableColumns()`
- `getTableActions()`
- `getTableBulkActions()`

These methods return arrays with string keys by default in the base class.

## Page Rules

### DO NOT Define These Properties in XotBasePage

```php
// ❌ WRONG - These should NOT be defined in XotBasePage children
protected static ?string $navigationIcon;
protected static ?string $title;
protected static ?string $navigationLabel;
```

## Form Component Rules

### Use Section Instead of Card

```php
// ✅ CORRECT
use Filament\Forms\Components\Section;

Section::make('Section Title')
    ->schema([...])

// ❌ DEPRECATED - Do not use
use Filament\Forms\Components\Card;

Card::make()
    ->schema([...])
```

## Example Implementation

✅ **Correct**

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateProduct extends XotBaseCreateRecord
{
    protected static string $resource = ProductResource::class;
}
```

❌ **Incorrect**

```php
use Filament\Resources\Pages\CreateRecord; // Wrong base class

class CreateProduct extends CreateRecord // Should extend XotBaseCreateRecord
{
    protected static string $resource = ProductResource::class;
    
    // These should not be defined in XotBasePage children
    protected static ?string $navigationIcon = 'heroicon-o-plus';
    protected static ?string $title = 'Create Product';
}
```

## Validation Rules

1. Always extend XotBase* classes from `Modules\Xot\Filament\Resources\Pages\`
2. Never use direct Filament page classes as parents
3. For forms, always use `Section` instead of the deprecated `Card` component
4. When defining form schemas, always use string keys for array elements
5. Do not override table-related methods in resources unless absolutely necessary
6. Keep form field definitions organized within properly named sections
7. Check for and remove any direct Filament class extensions during code reviews
8. Run static analysis to detect direct Filament class extensions
