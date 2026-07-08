# Critical Architecture Rules

> **⚠️ CRITICAL**: These are the most important rules that must always be followed.

## 🚨 Never Break These Rules

### 1. NEVER Extend Filament Classes Directly

```php
// ❌ WRONG
class MyPage extends Filament\Pages\Page
class MyResource extends Filament\Resources\Resource

// ✅ CORRECT
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
```

### 2. NEVER Use Hardcoded Labels

```php
// ❌ WRONG
TextInput::make('name')->label('Nome')->placeholder('Inserisci nome')

// ✅ CORRECT
TextInput::make('name') // Translation handled automatically via lang files
```

### 3. NEVER Use Services Directly - Always Use Actions

```php
// ❌ WRONG
class UserService {
    public function create(array $data) { /* logic */ }
}

// ✅ CORRECT
class CreateUserAction {
    use QueueableAction;

    public function execute(UserData $data): User { /* logic */ }
}
```

### 4. NEVER Use property_exists() with Eloquent Models

```php
// ❌ WRONG
if (property_exists($model, 'email')) {
    return $model->email;
}

// ✅ CORRECT
if (isset($model->email)) {
    return $model->email;
}
```

## 🏗️ Module Architecture Requirements

### Namespace Structure

```php
// ✅ CORRECT - Clean module namespaces
namespace Modules\User\Models;
namespace Modules\Ptv\Filament\Resources;

// ❌ WRONG - Avoid 'app' segment
namespace Modules\User\App\Models;
```

### Required Base Classes

```php
// ✅ CORRECT - Always extend XotBase classes
class UserServiceProvider extends XotBaseServiceProvider
class UserResource extends XotBaseResource
class User extends BaseModel  // From specific module

// ✅ CORRECT - Migrations
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
}

// ✅ CORRECT - Actions over Services
class ProcessUserDataAction {
    use QueueableAction;
}
```

## 📋 Pre-Commit Critical Checklist

**MANDATORY** - Check these before every commit:

- [ ] **Base Classes**: All classes extend appropriate XotBase classes
- [ ] **No Hardcoded Text**: No labels, placeholders, or help text in components
- [ ] **Strict Types**: `declare(strict_types=1);` at top of every PHP file
- [ ] **Type Hints**: All parameters and return values have explicit types
- [ ] **No property_exists()**: Never use with Eloquent models
- [ ] **Translation Structure**: Lang files follow proper hierarchical structure
- [ ] **Actions not Services**: Business logic in Actions, not Services

## 🔗 Related Documentation

- [Module Structure](module-structure.md) - How modules should be organized
- [Code Conventions](../development/conventions.md) - Detailed coding standards
- [Common Pitfalls](../development/pitfalls.md) - Mistakes to avoid
- [Eloquent Properties](../framework/eloquent-properties.md) - Model best practices

---

**Priority**: 🔴 Critical (Read First)  
**Version**: 3.0 (DRY + KISS Refactor)
