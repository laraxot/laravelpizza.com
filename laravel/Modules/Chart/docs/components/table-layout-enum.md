# TableLayoutEnum - UI Component

## Overview

The `TableLayoutEnum` is a core UI component in the Laraxot framework that provides standardized layout options for Filament tables and data grids. It enables users to toggle between list and grid views with appropriate styling and column configurations.

## Key Features

- **Type Safety**: Complete PHPDoc documentation and explicit parameter types
- **Translation Support**: Multilingual labels via translation files (IT, EN, DE)
- **Responsive Design**: Enhanced grid configuration with multiple breakpoints
- **Clean API**: Removed deprecated debug_backtrace approach
- **Extensible**: Additional utility methods for layout management

## Recent Improvements (2025-08-04)

### CRITICAL RULE: TransTrait Usage

**ALWAYS use TransTrait and transClass() for enum translations, NEVER implement match() manually**

The `TableLayoutEnum` now correctly implements the Laraxot framework standard:

```php
use Modules\Xot\Filament\Traits\TransTrait;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }
    
    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }
}
```

### Git Conflicts Resolution

- Resolved Git merge conflicts with proper syntax for PHPStan comments
- Cleaned up conflicting code markers 
- Standardized on modern PHPStan ignore syntax
- Implemented correct TransTrait usage pattern

### Breaking Changes
The `getTableColumns()` method now requires explicit parameters:

```php
// OLD (deprecated)
$columns = $this->layout->getTableColumns();

// NEW (required)
$columns = $this->layout->getTableColumns($listColumns, $gridColumns);
```

### New Methods Added
- `isListLayout()`: Check if current layout is LIST
- `getOptions()`: Get all layout options as array
- `getContainerClasses()`: Get CSS classes for styling

### Enhanced Grid Configuration
Improved responsive breakpoints:

```php
[
    'sm' => 1,   // 1 column on small screens
    'md' => 2,   // 2 columns on medium screens  
    'lg' => 3,   // 3 columns on large screens
    'xl' => 4,   // 4 columns on extra large screens
    '2xl' => 5,  // 5 columns on 2xl screens
]
```

## Translation Files

Complete multilingual support through structured translation files:

- **Italian**: `Modules/UI/lang/it/table-layout.php`
- **English**: `Modules/UI/lang/en/table-layout.php`
- **German**: `Modules/UI/lang/de/table-layout.php`

All translation files follow the expanded structure with `label`, `description`, `tooltip`, and `helper_text` keys.

## Usage Example

```php
use Modules\UI\Enums\TableLayoutEnum;

class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout;
    
    public function mount(): void
    {
        $this->layout = TableLayoutEnum::LIST;
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->extraAttributes([
                'class' => $this->layout->getContainerClasses(),
            ]);
    }
    
    protected function getColumnsForLayout(): array
    {
        $listColumns = [/* list columns */];
        $gridColumns = [/* grid columns */];
        
        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }
}
```

## Architecture Compliance

The improved `TableLayoutEnum` follows Laraxot best practices:

- **PSR-12 Compliance**: Proper code formatting and structure
- **PHPStan Level 9+**: Complete type safety and documentation
- **Clean Code**: Removed obvious comments, kept meaningful documentation
- **Translation Standards**: Expanded structure for all user-facing text
- **Modular Design**: Self-contained with clear responsibilities

## Related Documentation

### Module Documentation
- [Complete Usage Guide](../laravel/Modules/UI/docs/table-layout-enum-usage.md)
- [UI Module Architecture](../laravel/Modules/UI/docs/architecture_rules.md)
- [Filament Components](../laravel/Modules/UI/docs/components.md)

### Framework Documentation
- [UI Components Standards](ui-components.md)
- [Translation Management](translations/translation-management.md)
- [Filament Best Practices](filament/filament-best-practices.md)

## Migration Guide

### For Existing Implementations

1. **Update Method Calls**: Replace single-parameter `getTableColumns()` calls
2. **Define Column Arrays**: Create separate arrays for list and grid layouts
3. **Add Container Classes**: Use `getContainerClasses()` for styling
4. **Update Toggle Actions**: Implement proper toggle with new methods

### Testing Your Implementation

```php
// Test layout toggle
$layout = TableLayoutEnum::LIST;
$toggled = $layout->toggle();
assert($toggled === TableLayoutEnum::GRID);

// Test grid configuration
$gridConfig = TableLayoutEnum::GRID->getTableContentGrid();
assert($gridConfig['md'] === 2);

// Test container classes
$classes = TableLayoutEnum::LIST->getContainerClasses();
assert($classes === 'table-layout-list');
```

## Performance Considerations

- **No Debug Backtrace**: Eliminated performance overhead
- **Explicit Parameters**: Better caching and optimization
- **Responsive Grid**: Optimized for different screen sizes
- **Translation Caching**: Efficient multilingual support

## Future Enhancements

- Additional layout types (e.g., CARD, KANBAN)
- Custom grid configurations per component
- Theme-specific styling options
- Advanced responsive breakpoints

---

*Last updated: August 4, 2025*
*Module: UI*
*Component: TableLayoutEnum*
