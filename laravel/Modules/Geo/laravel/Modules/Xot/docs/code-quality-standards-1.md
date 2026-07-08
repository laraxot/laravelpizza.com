# Code Quality Standards - Xot Module

## 🎯 Purpose

This document establishes code quality standards and best practices for the Xot module, which serves as the foundation for all other modules in the platform. Xot provides base classes, traits, and utilities that other modules extend and use.

## 🏗️ Laraxot Architecture Rules

### 1. **MAI estendere direttamente classi Filament**
```php
// ❌ SBAGLIATO - Mai estendere direttamente
class MyPage extends ViewRecord
class MyPage extends CreateRecord  
class MyPage extends EditRecord
class MyPage extends ListRecords
class MyPage extends Page
class MyWidget extends Widget
class MyResource extends Resource

// ✅ CORRETTO - Sempre estendere XotBase
class MyPage extends XotBaseViewRecord
class MyPage extends XotBaseCreateRecord
class MyPage extends XotBaseEditRecord
class MyPage extends XotBaseListRecords
class MyPage extends XotBasePage
class MyWidget extends XotBaseWidget
class MyResource extends XotBaseResource
```

### 2. **Regole per XotBaseResource**
- **NON** includere `getTableColumns()` - usare TableWidget separato
- **NON** includere proprietà di navigazione
- Implementare solo `getFormSchema(): array`

### 3. **Regole per XotBasePage**
- **NON** includere `$navigationIcon`, `$title`, `$navigationLabel`
- Implementare `getFormSchema(): array`

### 4. **Sistema di Traduzioni**
- **MAI** usare `->label()`, `->placeholder()`, `->tooltip()` espliciti
- Usare file di traduzione gestiti da LangServiceProvider

### 5. **Componenti Deprecated**
- **MAI** usare `BadgeColumn` - usare `TextColumn` con `->badge()`

### 6. **Actions invece di Services**
- Usare Spatie Queueable Actions invece di services tradizionali

## 🏗️ Architecture Principles

### 1. Base Class Design
Xot provides base classes that other modules extend. These base classes should:
- Implement common interfaces (HasForms, HasActions, etc.)
- Provide default implementations of common methods
- Be easily extensible without modification
- Follow SOLID principles

### 2. Trait Design
Xot provides traits for common functionality:
- Should be focused on single responsibilities
- Should not have dependencies on specific modules
- Should be composable and reusable
- Should follow DRY principles

### 3. Interface Design
Xot provides interfaces that define contracts:
- Should be stable and rarely change
- Should define clear, minimal contracts
- Should be implementable by any module
- Should follow Interface Segregation Principle

## 🔧 Filament 4 Compliance

### 1. Base Widget Class
```php
// ✅ CORRECT - XotBaseWidget
abstract class XotBaseWidget extends FilamentWidget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    
    // Common functionality for all widgets
}
```

### 2. Base Page Class
```php
// ✅ CORRECT - XotBasePage
abstract class XotBasePage extends FilamentPage implements HasForms
{
    use InteractsWithForms;
    
    // Common functionality for all pages
}
```

### 3. Base Resource Class
```php
// ✅ CORRECT - XotBaseResource
abstract class XotBaseResource extends Resource
{
    // Common functionality for all resources
}
```

## 📋 DRY Principles Implementation

### 1. Common Table Columns
```php
// ✅ REUSABLE TRAIT
trait HasStandardTableColumns
{
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }
}
```

### 2. Common Form Fields
```php
// ✅ REUSABLE FORM COMPONENTS
class StandardFormFields
{
    public static function basicFields(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required(),
            TextInput::make('phone')->tel(),
        ];
    }

    public static function timestamps(): array
    {
        return [
            DateTimePicker::make('created_at')->disabled(),
            DateTimePicker::make('updated_at')->disabled(),
        ];
    }
}
```

### 3. Common Actions
```php
// ✅ REUSABLE ACTIONS
class StandardActions
{
    public static function editAction(): Action
    {
        return Action::make('edit')
            ->icon('heroicon-o-pencil')
            ->url(fn ($record) => static::getResource()::getUrl('edit', ['record' => $record]));
    }

    public static function deleteAction(): Action
    {
        return Action::make('delete')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation();
    }
}
```

## 🎯 SOLID Principles Implementation

### 1. Single Responsibility Principle (SRP)
Each class in Xot should have a single, well-defined responsibility:

```php
// ✅ GOOD - Single responsibility
class TranslationService
{
    public function translate(string $key, array $parameters = []): string
    {
        // Only handles translation
    }
}

// ❌ BAD - Multiple responsibilities
class TranslationAndValidationService
{
    public function translate(string $key): string
    {
        // Translation logic
    }
    
    public function validate(array $data): bool
    {
        // Validation logic - different responsibility
    }
}
```

### 2. Open/Closed Principle (OCP)
Xot classes should be open for extension but closed for modification:

```php
// ✅ GOOD - Open for extension
abstract class XotBaseWidget
{
    protected function getFormSchema(): array
    {
        return $this->buildFormSchema();
    }
    
    abstract protected function buildFormSchema(): array;
}

// Child classes can extend without modifying base class
class CustomWidget extends XotBaseWidget
{
    protected function buildFormSchema(): array
    {
        return [
            TextInput::make('custom_field'),
        ];
    }
}
```

### 3. Liskov Substitution Principle (LSP)
Subclasses should be substitutable for their base classes:

```php
// ✅ GOOD - LSP compliant
abstract class XotBasePage
{
    public function getTitle(): string
    {
        return $this->buildTitle();
    }
    
    abstract protected function buildTitle(): string;
}

// All subclasses can be used interchangeably
class UserPage extends XotBasePage
{
    protected function buildTitle(): string
    {
        return 'Users';
    }
}
```

### 4. Interface Segregation Principle (ISP)
Interfaces should be focused and not force classes to implement unused methods:

```php
// ✅ GOOD - Focused interfaces
interface HasTableColumns
{
    public function getTableColumns(): array;
}

interface HasFormSchema
{
    public function getFormSchema(): array;
}

// ❌ BAD - Fat interface
interface HasEverything
{
    public function getTableColumns(): array;
    public function getFormSchema(): array;
    public function getActions(): array;
    public function getFilters(): array;
    // ... many more methods
}
```

### 5. Dependency Inversion Principle (DIP)
Depend on abstractions, not concretions:

```php
// ✅ GOOD - Depend on interface
class WidgetService
{
    public function __construct(
        private CacheInterface $cache,
        private LoggerInterface $logger
    ) {}
}

// ❌ BAD - Depend on concrete classes
class WidgetService
{
    public function __construct(
        private RedisCache $cache,
        private FileLogger $logger
    ) {}
}
```

## 🎯 KISS Principles Implementation

### 1. Simple Methods
Keep methods simple and focused:

```php
// ✅ GOOD - Simple and clear
public function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
    ];
}

// ❌ BAD - Complex and unclear
public function getFormSchema(): array
{
    $fields = [];
    if ($this->shouldShowNameField()) {
        $fields[] = TextInput::make('name')->required();
        if ($this->shouldValidateName()) {
            $fields[0]->rules(['min:2', 'max:50']);
        }
    }
    if ($this->shouldShowEmailField()) {
        $fields[] = TextInput::make('email')->email()->required();
        if ($this->shouldValidateEmail()) {
            $fields[1]->rules(['email:rfc,dns']);
        }
    }
    return $fields;
}
```

### 2. Clear Naming
Use clear, descriptive names:

```php
// ✅ GOOD - Clear names
public function getTableColumns(): array
public function getFormSchema(): array
public function getTableActions(): array

// ❌ BAD - Unclear names
public function getCols(): array
public function getForm(): array
public function getActs(): array
```

### 3. Avoid Deep Nesting
Use early returns and guard clauses:

```php
// ✅ GOOD - Early returns
public function canAccess($user): bool
{
    if (!$user) {
        return false;
    }
    
    if (!$user->isActive()) {
        return false;
    }
    
    return $user->hasPermission('access');
}

// ❌ BAD - Deep nesting
public function canAccess($user): bool
{
    if ($user) {
        if ($user->isActive()) {
            if ($user->hasPermission('access')) {
                return true;
            }
        }
    }
    return false;
}
```

## 🔧 Laravel 12 Compliance

### 1. Type Declarations
Use proper type hints and return types:

```php
// ✅ GOOD - Proper types
public function getTableColumns(): array
{
    return [
        TextColumn::make('id')->sortable(),
    ];
}

public function processData(array $data): ProcessedData
{
    // Processing logic
}
```

### 2. Modern PHP Features
Use PHP 8.3 features appropriately:

```php
// ✅ GOOD - Modern PHP
public function __construct(
    private CacheInterface $cache,
    private LoggerInterface $logger
) {}

// ✅ GOOD - Enums
enum WidgetType: string
{
    case CHART = 'chart';
    case TABLE = 'table';
    case STATS = 'stats';
}
```

### 3. Eloquent Relationships
Use proper Eloquent relationships:

```php
// ✅ GOOD - Proper relationships
public function widgets(): HasMany
{
    return $this->hasMany(Widget::class);
}

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

## 📊 Code Quality Metrics

### Target Metrics
- **PHPStan Level**: 10
- **Test Coverage**: > 90%
- **Cyclomatic Complexity**: < 10
- **Method Length**: < 20 lines
- **Class Length**: < 200 lines
- **File Length**: < 500 lines

### Monitoring
- Use PHPStan for static analysis
- Use Pest for testing
- Use Laravel Pint for code formatting
- Use PHP CS Fixer for code style

## 🚀 Implementation Guidelines

### 1. When Creating Base Classes
- Implement common interfaces
- Provide default implementations
- Make methods easily overridable
- Follow naming conventions

### 2. When Creating Traits
- Focus on single responsibility
- Avoid dependencies on specific modules
- Use descriptive names
- Document usage clearly

### 3. When Creating Interfaces
- Define minimal, stable contracts
- Use descriptive names
- Group related methods
- Avoid breaking changes

### 4. When Creating Services
- Use dependency injection
- Follow SOLID principles
- Keep methods simple
- Add comprehensive tests

## 📚 Related Documentation

- [Filament Best Practices](./filament-best-practices.md)
- [Testing Guidelines](./testing-guidelines.md)
- [Performance Optimization](./performance-optimization.md)
- [Security Guidelines](./security-guidelines.md)

This document provides the foundation for maintaining high code quality standards across the Xot module and serves as a reference for other modules that extend Xot functionality.
