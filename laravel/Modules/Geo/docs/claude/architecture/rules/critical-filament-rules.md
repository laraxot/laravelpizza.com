# CRITICAL FILAMENT EXTENSION RULES

## 🚫 ABSOLUTELY FORBIDDEN: Direct Filament Extensions

**VIOLATION OF THESE RULES = CRITICAL ARCHITECTURAL ERROR**

### Wrong (NEVER DO THIS)
```php
<?php
// ❌ CRITICAL VIOLATION
class MyResource extends Filament\Resources\Resource
class CreateRecord extends Filament\Resources\Pages\CreateRecord
class EditRecord extends Filament\Resources\Pages\EditRecord
class ListRecords extends Filament\Resources\Pages\ListRecords
class ViewRecord extends Filament\Resources\Pages\ViewRecord
class MyPage extends Filament\Resources\Pages\Page
```

### Correct (ALWAYS DO THIS)
```php
<?php
// ✅ ARCHITECTURALLY CORRECT
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
class CreateRecord extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
class EditRecord extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
class ListRecords extends Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
class ViewRecord extends Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBasePage
```

## 🚫 FORBIDDEN: Methods in XotBaseResource

Classes extending `XotBaseResource` **MUST NEVER** contain these methods:

```php
<?php
class MyResource extends XotBaseResource
{
    // ❌ CRITICAL VIOLATION - NEVER ADD THESE METHODS
    public function getTableColumns(): array { return []; }
    public function getTableFilters(): array { return []; }
    public function getTableActions(): array { return []; }
    public function getTableBulkActions(): array { return []; }

    // ✅ ALLOWED - These are OK
    public static function getFormSchema(): array { return []; }
    public static function getPages(): array { return []; }
    protected static function getEloquentQuery(): Builder { return parent::getEloquentQuery(); }
}
```

## 🚫 FORBIDDEN: Properties in XotBasePage

Classes extending `XotBasePage` **MUST NEVER** contain these properties:

```php
<?php
class MyPage extends XotBasePage
{
    // ❌ CRITICAL VIOLATION - NEVER ADD THESE PROPERTIES
    protected static ?string $navigationIcon = 'icon';
    protected static ?string $title = 'Title';
    protected static ?string $navigationLabel = 'Label';

    // ✅ ALLOWED - These are OK
    protected static string $resource = MyResource::class;
    public function getInfolistSchema(): array { return []; }
}
```

## 🚫 FORBIDDEN: Manual Translation Methods

**NEVER use manual translation methods**. LangServiceProvider handles translations automatically:

```php
<?php
// ❌ CRITICAL VIOLATION - NEVER DO THIS
TextInput::make('name')->label('Nome')
TextInput::make('email')->placeholder('Email address')
TextColumn::make('status')->tooltip('Current status')
TextInput::make('description')->helperText('Enter description')

// ✅ ARCHITECTURALLY CORRECT - ALWAYS DO THIS
TextInput::make('name')        // Translation automatic via LangServiceProvider
TextInput::make('email')       // Translation automatic via LangServiceProvider
TextColumn::make('status')     // Translation automatic via LangServiceProvider
TextInput::make('description') // Translation automatic via LangServiceProvider
```

## 🚫 FORBIDDEN: Traditional Services

**NEVER use traditional service classes**. Always use Spatie QueueableAction:

```php
<?php
// ❌ CRITICAL VIOLATION - NEVER DO THIS
class UserService
{
    public function createUser(array $data): User
    {
        // Traditional service implementation
    }
}

// ✅ ARCHITECTURALLY CORRECT - ALWAYS DO THIS
class CreateUserAction implements ShouldQueue
{
    use QueueableAction;

    public function execute(array $data): User
    {
        // Queueable action implementation
    }
}
```

## 🚫 FORBIDDEN: Deprecated Components

**NEVER use deprecated Filament components**:

```php
<?php
// ❌ CRITICAL VIOLATION - NEVER DO THIS
BadgeColumn::make('status')

// ✅ ARCHITECTURALLY CORRECT - ALWAYS DO THIS
TextColumn::make('status')->badge()
```

## 🏗️ Architectural Rationale

### Why XotBase Classes?
1. **Isolation**: Provides isolation from direct Filament dependencies
2. **Local Override**: Allows project-specific customizations
3. **Maintenance**: Single point of change for common behaviors
4. **Compliance**: Ensures Laraxot/PTVX architectural standards

### Why Automatic Translations?
1. **Consistency**: Centralized translation management
2. **Maintainability**: Changes in one place affect entire application
3. **Internationalization**: Proper i18n support
4. **Separation**: UI logic separate from presentation text

### Why QueueableAction?
1. **Testability**: Actions are easily unit tested
2. **Queue Support**: Built-in queueing capabilities
3. **Composition**: Better than inheritance for business logic
4. **Laravel Integration**: Native Laravel patterns

## 🔍 Detection and Prevention

### Pre-commit Hook
```bash
#!/bin/bash
# Check for forbidden patterns

# Direct Filament extensions
if grep -r "extends Filament\\Resources" --include="*.php" .; then
    echo "❌ CRITICAL: Direct Filament extension detected"
    exit 1
fi

# Forbidden methods in XotBaseResource
if grep -r "function getTable" --include="*Resource.php" .; then
    echo "❌ CRITICAL: Forbidden table methods in Resource"
    exit 1
fi

# Manual labels
if grep -r "->label(" --include="*.php" .; then
    echo "❌ CRITICAL: Manual label usage detected"
    exit 1
fi

# Traditional services
if grep -r "class.*Service" --include="*.php" . | grep -v "ServiceProvider"; then
    echo "❌ CRITICAL: Traditional service class detected"
    exit 1
fi
```

### PHPStan Rules
```php
// Add to phpstan.neon
parameters:
    checkMissingOverrideAttribute: true
    disallowDirectFilamentExtensions: true
    disallowManualTranslations: true
    disallowTraditionalServices: true
```

## 📋 Compliance Checklist

### For Resources
- [ ] Extends `XotBaseResource` (not `Filament\Resources\Resource`)
- [ ] No `getTable*()` methods
- [ ] Uses `getFormSchema()` instead of `form()`
- [ ] No manual `->label()`, `->placeholder()`, `->tooltip()`

### For Pages
- [ ] Extends appropriate `XotBase*Record` class
- [ ] No forbidden properties (`$navigationIcon`, `$title`, `$navigationLabel`)
- [ ] Proper resource binding

### For Actions
- [ ] Uses `QueueableAction` trait
- [ ] Implements `ShouldQueue` if needed
- [ ] No traditional service classes

### For Components
- [ ] No manual translation methods
- [ ] Uses `TextColumn::badge()` instead of `BadgeColumn`
- [ ] Follows Filament 4.x patterns

## 🚨 Emergency Corrections

If you find violations in existing code:

1. **IMMEDIATELY STOP** what you're doing
2. **CREATE A TASK** to fix the violation
3. **PRIORITY: CRITICAL** - Fix before any other work
4. **TEST THOROUGHLY** after correction
5. **DOCUMENT** the fix in commit message

## 📚 Related Documentation

- [XotBaseResource Documentation](../../Xot/docs/readme.md)
- [Filament Extension Patterns](../../Xot/docs/filament-extension-pattern.md)
- [LangServiceProvider](../../Lang/docs/service-provider.md)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)

---

**Version**: 1.0 - Critical Rules
**Enforcement**: Mandatory
**Violation Level**: Critical Architectural Error
**Last Updated**: December 2025
