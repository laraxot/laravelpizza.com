# Common Anti-Patterns - Xot Module

## 🚨 Anti-Patterns to Avoid

This document identifies common anti-patterns found in modules that extend Xot base classes and provides guidance on how to avoid them.

## 🔄 DRY Violations

### 1. Duplicate Interface Implementations
**Problem**: Classes extending XotBasePage implementing HasForms again
```php
// ❌ ANTI-PATTERN
class MyPage extends XotBasePage implements HasForms
{
    use InteractsWithForms; // Duplicate!
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyPage extends XotBasePage
{
    // XotBasePage already implements HasForms and uses InteractsWithForms
}
```

### 2. Duplicate Trait Usage
**Problem**: Using traits that are already included in base classes
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    use InteractsWithForms; // Already in XotBaseWidget
    use InteractsWithActions; // Already in XotBaseWidget
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    // No need to redeclare traits already in base class
}
```

### 3. Duplicate Method Implementations
**Problem**: Implementing methods that are already provided by base classes
```php
// ❌ ANTI-PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        // Same implementation as base class
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable(),
        ];
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyResource extends XotBaseResource
{
    // Only override if you need different behavior
    public function getTableColumns(): array
    {
        return array_merge(parent::getTableColumns(), [
            TextColumn::make('custom_field'),
        ]);
    }
}
```

## 🏗️ SOLID Violations

### 1. Single Responsibility Principle Violations
**Problem**: Classes doing too many things
```php
// ❌ ANTI-PATTERN
class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Form schema logic
    }

    public function processPayment($amount): bool
    {
        // Payment processing logic - different responsibility
    }

    public function sendEmail($user): void
    {
        // Email sending logic - different responsibility
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Only form schema logic
    }
}

class PaymentService
{
    public function processPayment($amount): bool
    {
        // Payment processing logic
    }
}

class EmailService
{
    public function sendEmail($user): void
    {
        // Email sending logic
    }
}
```

### 2. Open/Closed Principle Violations
**Problem**: Modifying base classes instead of extending them
```php
// ❌ ANTI-PATTERN
// Modifying XotBaseWidget directly
class XotBaseWidget extends FilamentWidget
{
    public function getFormSchema(): array
    {
        if ($this instanceof UserWidget) {
            // User-specific logic
        } elseif ($this instanceof ProductWidget) {
            // Product-specific logic
        }
        // ... more conditions
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
abstract class XotBaseWidget extends FilamentWidget
{
    abstract public function getFormSchema(): array;
}

class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // User-specific logic
    }
}

class ProductWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Product-specific logic
    }
}
```

### 3. Dependency Inversion Principle Violations
**Problem**: Depending on concrete classes instead of abstractions
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    public function processData(): void
    {
        $cache = new RedisCache(); // Concrete dependency
        $logger = new FileLogger(); // Concrete dependency
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    public function __construct(
        private CacheInterface $cache,
        private LoggerInterface $logger
    ) {}

    public function processData(): void
    {
        // Use injected dependencies
    }
}
```

## 🎯 KISS Violations

### 1. Overly Complex Methods
**Problem**: Methods doing too many things
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    $fields = [];

    if ($this->user->hasRole('admin')) {
        if ($this->user->hasPermission('manage_users')) {
            if ($this->user->isActive()) {
                if ($this->user->getTenantId() === $this->currentTenantId) {
                    $fields[] = TextInput::make('admin_field');
                }
            }
        }
    }

    if ($this->user->hasRole('user')) {
        if ($this->user->hasPermission('view_profile')) {
            if ($this->user->isActive()) {
                if ($this->user->getTenantId() === $this->currentTenantId) {
                    $fields[] = TextInput::make('user_field');
                }
            }
        }
    }

    // ... more complex logic

    return $fields;
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getFormSchema(): array
{
    return $this->buildFormSchema();
}

private function buildFormSchema(): array
{
    $fields = [];

    if ($this->canShowAdminFields()) {
        $fields = array_merge($fields, $this->getAdminFields());
    }

    if ($this->canShowUserFields()) {
        $fields = array_merge($fields, $this->getUserFields());
    }

    return $fields;
}

private function canShowAdminFields(): bool
{
    return $this->user->hasRole('admin')
        && $this->user->hasPermission('manage_users')
        && $this->user->isActive()
        && $this->user->getTenantId() === $this->currentTenantId;
}

private function getAdminFields(): array
{
    return [
        TextInput::make('admin_field'),
    ];
}
```

### 2. Complex Conditional Logic
**Problem**: Nested if-else statements
```php
// ❌ ANTI-PATTERN
public function canAccess($user): bool
{
    if ($user) {
        if ($user->isActive()) {
            if ($user->hasPermission('access')) {
                if ($user->getTenantId() === $this->currentTenantId) {
                    return true;
                }
            }
        }
    }
    return false;
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function canAccess($user): bool
{
    if (!$user) {
        return false;
    }

    if (!$user->isActive()) {
        return false;
    }

    if (!$user->hasPermission('access')) {
        return false;
    }

    return $user->getTenantId() === $this->currentTenantId;
}
```

## 🔧 Filament 4 Compliance Issues

### 1. Static Method Violations
**Problem**: Making non-static methods static
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    public static function getFormSchema(): array
    {
        // Filament methods should not be static
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Non-static method
    }
}
```

### 2. Missing Type Hints
**Problem**: Inconsistent type declarations
```php
// ❌ ANTI-PATTERN
public function getTableColumns()
{
    return [
        TextColumn::make('id'),
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
    ];
}
```

### 3. Incorrect Method Overrides
**Problem**: Changing method signatures when overriding
```php
// ❌ ANTI-PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns($filters = []): array
    {
        // Changed method signature
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        // Same signature as parent
    }
}
```

## 📊 Performance Anti-Patterns

### 1. N+1 Query Problems
**Problem**: Loading relationships inefficiently
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // N+1 query
        TextColumn::make('user.email'), // Another N+1 query
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // Will use eager loading
        TextColumn::make('user.email'), // Will use eager loading
    ];
}

// Ensure eager loading in the query
public function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('user');
}
```

### 2. Memory Inefficient Operations
**Problem**: Loading large datasets into memory
```php
// ❌ ANTI-PATTERN
public function processData(): void
{
    $allRecords = Model::all(); // Loads everything into memory
    foreach ($allRecords as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function processData(): void
{
    Model::chunk(1000, function ($records) {
        foreach ($records as $record) {
            $this->processRecord($record);
        }
    });
}
```

## 🛡️ Security Anti-Patterns

### 1. Direct Database Queries
**Problem**: Bypassing Eloquent security features
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    return DB::table('users')->get(); // Bypasses model security
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getData(): Collection
{
    return User::query()->get(); // Uses Eloquent security features
}
```

### 2. Missing Authorization
**Problem**: Not checking permissions
```php
// ❌ ANTI-PATTERN
public function getTableActions(): array
{
    return [
        Action::make('delete')
            ->action(fn ($record) => $record->delete()),
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableActions(): array
{
    return [
        Action::make('delete')
            ->action(fn ($record) => $record->delete())
            ->requiresConfirmation()
            ->visible(fn ($record) => auth()->user()->can('delete', $record)),
    ];
}
```

## 📚 Best Practices Summary

### Do's
- ✅ Extend base classes without duplicating interfaces/traits
- ✅ Override methods only when necessary
- ✅ Use dependency injection
- ✅ Follow SOLID principles
- ✅ Keep methods simple and focused
- ✅ Use proper type hints
- ✅ Implement proper authorization
- ✅ Use Eloquent relationships efficiently

### Don'ts
- ❌ Don't duplicate interfaces/traits from base classes
- ❌ Don't modify base classes directly
- ❌ Don't depend on concrete classes
- ❌ Don't make methods overly complex
- ❌ Don't change method signatures when overriding
- ❌ Don't bypass Eloquent security features
- ❌ Don't load large datasets into memory
- ❌ Don't create N+1 query problems

This document serves as a reference for avoiding common anti-patterns when extending Xot base classes and building modules on top of the Xot foundation.
# Common Anti-Patterns - Xot Module

## 🚨 Anti-Patterns to Avoid

This document identifies common anti-patterns found in modules that extend Xot base classes and provides guidance on how to avoid them.

## 🔄 DRY Violations

### 1. Duplicate Interface Implementations
**Problem**: Classes extending XotBasePage implementing HasForms again
```php
// ❌ ANTI-PATTERN
class MyPage extends XotBasePage implements HasForms
{
    use InteractsWithForms; // Duplicate!
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyPage extends XotBasePage
{
    // XotBasePage already implements HasForms and uses InteractsWithForms
}
```

### 2. Duplicate Trait Usage
**Problem**: Using traits that are already included in base classes
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    use InteractsWithForms; // Already in XotBaseWidget
    use InteractsWithActions; // Already in XotBaseWidget
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    // No need to redeclare traits already in base class
}
```

### 3. Duplicate Method Implementations
**Problem**: Implementing methods that are already provided by base classes
```php
// ❌ ANTI-PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        // Same implementation as base class
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable(),
        ];
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyResource extends XotBaseResource
{
    // Only override if you need different behavior
    public function getTableColumns(): array
    {
        return array_merge(parent::getTableColumns(), [
            TextColumn::make('custom_field'),
        ]);
    }
}
```

## 🏗️ SOLID Violations

### 1. Single Responsibility Principle Violations
**Problem**: Classes doing too many things
```php
// ❌ ANTI-PATTERN
class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Form schema logic
    }

    public function processPayment($amount): bool
    {
        // Payment processing logic - different responsibility
    }

    public function sendEmail($user): void
    {
        // Email sending logic - different responsibility
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Only form schema logic
    }
}

class PaymentService
{
    public function processPayment($amount): bool
    {
        // Payment processing logic
    }
}

class EmailService
{
    public function sendEmail($user): void
    {
        // Email sending logic
    }
}
```

### 2. Open/Closed Principle Violations
**Problem**: Modifying base classes instead of extending them
```php
// ❌ ANTI-PATTERN
// Modifying XotBaseWidget directly
class XotBaseWidget extends FilamentWidget
{
    public function getFormSchema(): array
    {
        if ($this instanceof UserWidget) {
            // User-specific logic
        } elseif ($this instanceof ProductWidget) {
            // Product-specific logic
        }
        // ... more conditions
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
abstract class XotBaseWidget extends FilamentWidget
{
    abstract public function getFormSchema(): array;
}

class UserWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // User-specific logic
    }
}

class ProductWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Product-specific logic
    }
}
```

### 3. Dependency Inversion Principle Violations
**Problem**: Depending on concrete classes instead of abstractions
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    public function processData(): void
    {
        $cache = new RedisCache(); // Concrete dependency
        $logger = new FileLogger(); // Concrete dependency
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    public function __construct(
        private CacheInterface $cache,
        private LoggerInterface $logger
    ) {}

    public function processData(): void
    {
        // Use injected dependencies
    }
}
```

## 🎯 KISS Violations

### 1. Overly Complex Methods
**Problem**: Methods doing too many things
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    $fields = [];

    if ($this->user->hasRole('admin')) {
        if ($this->user->hasPermission('manage_users')) {
            if ($this->user->isActive()) {
                if ($this->user->getTenantId() === $this->currentTenantId) {
                    $fields[] = TextInput::make('admin_field');
                }
            }
        }
    }

    if ($this->user->hasRole('user')) {
        if ($this->user->hasPermission('view_profile')) {
            if ($this->user->isActive()) {
                if ($this->user->getTenantId() === $this->currentTenantId) {
                    $fields[] = TextInput::make('user_field');
                }
            }
        }
    }

    // ... more complex logic

    return $fields;
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getFormSchema(): array
{
    return $this->buildFormSchema();
}

private function buildFormSchema(): array
{
    $fields = [];

    if ($this->canShowAdminFields()) {
        $fields = array_merge($fields, $this->getAdminFields());
    }

    if ($this->canShowUserFields()) {
        $fields = array_merge($fields, $this->getUserFields());
    }

    return $fields;
}

private function canShowAdminFields(): bool
{
    return $this->user->hasRole('admin')
        && $this->user->hasPermission('manage_users')
        && $this->user->isActive()
        && $this->user->getTenantId() === $this->currentTenantId;
}

private function getAdminFields(): array
{
    return [
        TextInput::make('admin_field'),
    ];
}
```

### 2. Complex Conditional Logic
**Problem**: Nested if-else statements
```php
// ❌ ANTI-PATTERN
public function canAccess($user): bool
{
    if ($user) {
        if ($user->isActive()) {
            if ($user->hasPermission('access')) {
                if ($user->getTenantId() === $this->currentTenantId) {
                    return true;
                }
            }
        }
    }
    return false;
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function canAccess($user): bool
{
    if (!$user) {
        return false;
    }

    if (!$user->isActive()) {
        return false;
    }

    if (!$user->hasPermission('access')) {
        return false;
    }

    return $user->getTenantId() === $this->currentTenantId;
}
```

## 🔧 Filament 4 Compliance Issues

### 1. Static Method Violations
**Problem**: Making non-static methods static
```php
// ❌ ANTI-PATTERN
class MyWidget extends XotBaseWidget
{
    public static function getFormSchema(): array
    {
        // Filament methods should not be static
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        // Non-static method
    }
}
```

### 2. Missing Type Hints
**Problem**: Inconsistent type declarations
```php
// ❌ ANTI-PATTERN
public function getTableColumns()
{
    return [
        TextColumn::make('id'),
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
    ];
}
```

### 3. Incorrect Method Overrides
**Problem**: Changing method signatures when overriding
```php
// ❌ ANTI-PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns($filters = []): array
    {
        // Changed method signature
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        // Same signature as parent
    }
}
```

## 📊 Performance Anti-Patterns

### 1. N+1 Query Problems
**Problem**: Loading relationships inefficiently
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // N+1 query
        TextColumn::make('user.email'), // Another N+1 query
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // Will use eager loading
        TextColumn::make('user.email'), // Will use eager loading
    ];
}

// Ensure eager loading in the query
public function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('user');
}
```

### 2. Memory Inefficient Operations
**Problem**: Loading large datasets into memory
```php
// ❌ ANTI-PATTERN
public function processData(): void
{
    $allRecords = Model::all(); // Loads everything into memory
    foreach ($allRecords as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function processData(): void
{
    Model::chunk(1000, function ($records) {
        foreach ($records as $record) {
            $this->processRecord($record);
        }
    });
}
```

## 🛡️ Security Anti-Patterns

### 1. Direct Database Queries
**Problem**: Bypassing Eloquent security features
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    return DB::table('users')->get(); // Bypasses model security
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getData(): Collection
{
    return User::query()->get(); // Uses Eloquent security features
}
```

### 2. Missing Authorization
**Problem**: Not checking permissions
```php
// ❌ ANTI-PATTERN
public function getTableActions(): array
{
    return [
        Action::make('delete')
            ->action(fn ($record) => $record->delete()),
    ];
}
```

**Solution**:
```php
// ✅ CORRECT PATTERN
public function getTableActions(): array
{
    return [
        Action::make('delete')
            ->action(fn ($record) => $record->delete())
            ->requiresConfirmation()
            ->visible(fn ($record) => auth()->user()->can('delete', $record)),
    ];
}
```

## 📚 Best Practices Summary

### Do's
- ✅ Extend base classes without duplicating interfaces/traits
- ✅ Override methods only when necessary
- ✅ Use dependency injection
- ✅ Follow SOLID principles
- ✅ Keep methods simple and focused
- ✅ Use proper type hints
- ✅ Implement proper authorization
- ✅ Use Eloquent relationships efficiently

### Don'ts
- ❌ Don't duplicate interfaces/traits from base classes
- ❌ Don't modify base classes directly
- ❌ Don't depend on concrete classes
- ❌ Don't make methods overly complex
- ❌ Don't change method signatures when overriding
- ❌ Don't bypass Eloquent security features
- ❌ Don't load large datasets into memory
- ❌ Don't create N+1 query problems

This document serves as a reference for avoiding common anti-patterns when extending Xot base classes and building modules on top of the Xot foundation.
