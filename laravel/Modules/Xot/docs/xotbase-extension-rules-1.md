# XotBase Extension Rules - Comprehensive Guide

## 🚨 Critical Architectural Rule

**NEVER extend Filament classes directly. ALWAYS extend the corresponding XotBase abstract class.**

## 📋 Extension Pattern Table

| Filament Original Class | XotBase Class to Extend |
|-------------------------|-------------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

## ✅ Correct Implementation Examples

### Resource Example
```php
// CORRECT: Extend XotBaseResource
namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    // Implementation here
}

// WRONG: Direct Filament extension
class MyResource extends \Filament\Resources\Resource
{
    // This will cause architecture violations
}
```

### Widget Example
```php
// CORRECT: Extend XotBaseWidget
namespace Modules\MyModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [
            // Form components here
        ];
    }
}

// WRONG: Direct Filament extension
class MyWidget extends \Filament\Widgets\Widget
{
    // Missing required methods and architecture violations
}
```

## ⚠️ Common Errors and Solutions

### Error: "Class contains 1 abstract method and must therefore be declared abstract"
**Cause**: Extending XotBaseWidget without implementing required abstract methods like `getFormSchema()`
**Solution**: Always implement ALL abstract methods from XotBase classes

### Error: "Access level must be public (as in class XotBaseWidget)"
**Cause**: Using `protected` instead of `public` for methods that are `public` in parent class
**Solution**: Match the exact access level from the parent abstract class

### Error: "Cannot override final method"
**Cause**: Trying to override methods marked as `final` in XotBase classes
**Solution**: Use the provided hook methods instead of overriding final methods

## 🔧 Required Method Implementations

### For XotBaseWidget
```php
public function getFormSchema(): array
{
    return [
        // Must return array of Filament form components
        // NEVER return empty array []
        \Filament\Forms\Components\TextInput::make('field_name')
            ->label(__('module::translation.key'))
            ->required(),
    ];
}
```

### For XotBaseResource
```php
// XotBaseResource provides default implementations
// Override only when necessary using the correct patterns
```

## 📁 Namespace Structure Rules

1. **Maintain Filament's namespace structure** but within your module
2. **Never include 'app' in namespace** for Filament components
3. **Use correct translation patterns** with module prefix

**Correct:**
```php
namespace Modules\MyModule\Filament\Resources;
namespace Modules\MyModule\Filament\Widgets;
```

**Wrong:**
```php
namespace Modules\MyModule\App\Filament\Resources; // Contains 'App'
namespace Modules\MyModule\Filament\App\Widgets;   // Wrong structure
```

## 🛡️ Validation Checklist

Before committing any Filament-related code, verify:

1. [ ] Extends XotBase class, not direct Filament class
2. [ ] All abstract methods are implemented with correct signatures
3. [ ] Method access levels match parent class (public/protected)
4. [ ] Namespace follows correct pattern without 'app' segment
5. [ ] No final methods are being overridden
6. [ ] Form schemas return proper Filament components, not empty arrays
7. [ ] Translation keys use module prefix (module::key.path)
8. [ ] **Array methods return `array<string, mixed>`** - Never use numeric keys for:
   - `getTableColumns()` → `array<string, Column>`
   - `getFormSchema()` → `array<string, Component>`
   - `getTableActions()` → `array<string, Action>`
   - `getTableBulkActions()` → `array<string, BulkAction>`
   - `getTableFilters()` → `array<string, Filter>`
   - `getHeaderActions()` → `array<string, Action>`
9. [ ] **Never use `property_exists()` with Eloquent models** - Use `isset()` for magic attributes
10. [ ] **Avoid `mixed` types** - Use specific types or `array<string, mixed>` when necessary

## 🔍 Common Pitfalls

### Empty Form Schemas
**Wrong:**
```php
public function getFormSchema(): array
{
    return []; // NEVER return empty array
}
```

**Correct:**
```php
public function getFormSchema(): array
{
    return [
        'name' => \Filament\Forms\Components\TextInput::make('name')
            ->label(__('module::fields.name')),
    ];
}
```

### Array with Numeric Keys
**Wrong:**
```php
public function getTableActions(): array
{
    return [
        EditAction::make(),
        DeleteAction::make(),
    ]; // ❌ Numeric keys (0, 1)
}
```

**Correct:**
```php
/**
 * @return array<string, Action>
 */
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ]; // ✅ String keys
}
```

### Property Exists with Models
**Wrong:**
```php
if (property_exists($model, 'attribute')) {
    $value = $model->attribute; // ❌ Doesn't work with magic attributes
}
```

**Correct:**
```php
if (isset($model->attribute)) {
    $value = $model->attribute; // ✅ Works with magic attributes
}
```

### Wrong Access Levels
**Wrong:**
```php
protected function getFormSchema(): array // Should be public
{
    return [/*...*/];
}
```

**Correct:**
```php
public function getFormSchema(): array // Must be public
{
    return [/*...*/];
}
```

## 📚 Related Documentation

- [Filament Extension Pattern](../filament_extension_pattern.md)
- [XotBaseWidget Documentation](./filament/widgets/xot-base-widget.md)
- [Namespace Rules](../namespace-rules.md)
- [Architecture Best Practices](../architecture-best-practices.md)

## 🚨 Emergency Fix Procedure

If you encounter architecture violations:

1. **Identify the incorrectly extended class**
2. **Change extends to correct XotBase class**
3. **Implement all required abstract methods**
4. **Verify method signatures match parent**
5. **Run PHPStan to validate fixes**

## 🔗 Integration with Development Workflow

This rule is enforced by:
- PHPStan architecture rules
- Code review processes
- Automated quality checks

Always run `php artisan optimize:clear && ./vendor/bin/phpstan analyse` after making changes to verify compliance.

---

*Last Updated: 2025-01-10*
*Architecture Version: XotBase 2.1*
