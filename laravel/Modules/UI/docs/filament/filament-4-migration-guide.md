# Filament 4 Migration Guide

## Overview

This document outlines the migration from Filament 3 to Filament 4, highlighting breaking changes, new patterns, and required updates for the UI module.

## Version Information

- **Current Filament Version**: 4.0.19
- **Laravel Version**: 12.30.1  
- **PHP Version**: 8.3.25

## Major Changes from Filament 3 to 4

### 1. Schema System Introduction

Filament 4 introduces a unified schema system that consolidates forms, tables, and other components under a single architecture.

#### New Interfaces and Traits
- `HasSchemas` interface replaces component-specific interfaces
- `InteractsWithSchemas` trait consolidates functionality
- `Schema` class provides unified configuration

### 2. Custom Table Columns

#### Filament 3 Pattern (Deprecated)
```php
class CustomColumn extends Column
{
    public static function mount(string $name): static
    {
        return parent::mount($name);
    }
}
```

#### Filament 4 Pattern (Current)
```php
class CustomColumn extends Column
{
    protected function setUp(): void
    {
        parent::setUp();
        // Configuration logic here
    }
    
    public function table(?Table $table): static
    {
        parent::table($table);
        // Handle table assignment
        return $this;
    }
}
```

### 3. Component Setup Methods

- `mount()` method has been removed from table columns
- Use `setUp()` method for component initialization
- Use `table()` method for table-specific configuration

### 4. Livewire Component Integration

#### Form Components
```php
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class CreatePost extends Component implements HasSchemas
{
    use InteractsWithSchemas;
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([...])
            ->statePath('data');
    }
}
```

#### Table Components
```php
use Filament\Tables\Contracts\HasTable;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListProducts extends Component implements HasTable, HasSchemas
{
    use InteractsWithTable;
    use InteractsWithSchemas;
    
    public function table(Table $table): Table
    {
        return $table->query(Product::query());
    }
}
```

## Breaking Changes Identified

### 1. GroupColumn Issues
- `Column::mount()` method no longer exists
- Need to use `setUp()` for initialization
- Parent-child table assignment requires manual handling

### 2. LocationSelector Issues  
- Namespace imports need updating
- Dependency on missing `Comune` model
- Schema structure needs alignment with Filament 4

## Migration Checklist

### Custom Components
- [ ] Remove `mount()` method calls
- [ ] Implement `setUp()` method
- [ ] Update namespace imports
- [ ] Verify model dependencies
- [ ] Test component functionality

### Livewire Integration
- [ ] Implement `HasSchemas` interface
- [ ] Use `InteractsWithSchemas` trait
- [ ] Update form/table method signatures
- [ ] Add schema configuration

### Testing
- [ ] Update component tests
- [ ] Verify PHPStan compliance
- [ ] Test UI functionality
- [ ] Validate accessibility

## Best Practices

### 1. Component Development
- Always extend from appropriate base classes
- Use `setUp()` for initialization logic
- Implement proper parent-child relationships
- Handle null states gracefully

### 2. Error Handling
- Add try-catch blocks for model queries
- Provide fallback values
- Log errors appropriately
- Use PHPStan ignore comments when necessary

### 3. Type Safety
- Use strict types declaration
- Implement proper return types
- Add PHPDoc annotations
- Handle nullable values explicitly

## Resources

- [Filament 4 Documentation](https://filamentphp.com/docs/4.x)
- [Migration Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Schema System](https://filamentphp.com/docs/4.x/schemas)
- [Custom Components](https://filamentphp.com/docs/4.x/custom-components)

## Next Steps

1. Fix PHPStan errors in existing components
2. Update component implementations
3. Test all functionality
4. Update documentation
5. Create comprehensive tests