# XotBaseSection Architecture Guide

## Overview
`XotBaseSection` is the foundational class for all Section components in the Laraxot framework, following the principle that no component should directly extend Filament's base classes.

## Architecture Rules

### 1. Extension Policy
- ❌ **NEVER**: `extends Filament\Schemas\Components\Section`
- ✅ **ALWAYS**: `extends Modules\Xot\Filament\Schemas\Components\XotBaseSection`

### 2. Method Safety
Only use methods that exist in the parent Filament Section class. Common safe methods:
- `schema()`
- `columns()`
- `id()`
- `heading()`
- `description()`

### 3. Setup Pattern
```php
protected function setUp(): void
{
    parent::setUp();
    // Safe configurations only
    $this->columns(2);
}
```

## Implementation Examples

### Correct Implementation
```php
class CompanySection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema(fn (): array => $this->getFormSchema());
        $this->columns(2);
    }
}
```

### Common Pitfalls
1. **Calling non-existent methods**: Always verify method existence
2. **Assuming macro availability**: Not all Filament macros are available in all contexts
3. **Missing parent::setUp()**: Always call parent setup first

## Migration Path
When converting existing Section components:

1. Replace `use Filament\Schemas\Components\Section;`
2. Add `use Modules\Xot\Filament\Schemas\Components\XotBaseSection;`
3. Change `extends Section` to `extends XotBaseSection`
4. Verify all method calls are valid

## Testing Strategy
1. Verify syntax with `php -l`
2. Test component instantiation
3. Check form rendering
4. Validate all method calls exist

## Philosophy
This architecture ensures:
- Consistency across all Section components
- Centralized configuration capability
- Framework adherence to Laraxot principles
- Maintainable and predictable code structure
