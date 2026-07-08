# Architecture Rules

> **⚠️ CRITICAL**: These are the most important rules that must always be followed.

## 🚨 Critical Architecture Rules

### 1. NEVER Extend Filament Classes Directly

```php
// ❌ WRONG
class MyPage extends Filament\Pages\Page

// ✅ CORRECT
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

### 2. NEVER Use Hardcoded Labels

```php
// ❌ WRONG
TextInput::make('name')->label('Nome')

// ✅ CORRECT
TextInput::make('name') // Translation handled automatically
```

### 3. NEVER Use Services Directly - Always Use Actions

```php
// ❌ WRONG
class UserService { ... }

// ✅ CORRECT
class CreateUserAction { use QueueableAction; ... }
```

### 4. NEVER Use property_exists() with Eloquent Models

```php
// ❌ WRONG
if (property_exists($model, 'email')) { ... }

// ✅ CORRECT
if (isset($model->email)) { ... }
```

## 🔧 Module Architecture

### Namespace Structure

```php
// ✅ CORRECT - Module namespaces
namespace Modules\User\Models;
namespace Modules\Ptv\Filament\Resources;

// ❌ WRONG - Namespace with 'app' segment
namespace Modules\User\App\Models;
```

### Required Extensions

```php
// ✅ CORRECT - Service Provider
class UserServiceProvider extends XotBaseServiceProvider

// ✅ CORRECT - Migrations
return new class extends XotBaseMigration

// ✅ CORRECT - Models
class User extends BaseModel  // BaseModel from the specific module

// ✅ CORRECT - Filament Resources
class UserResource extends XotBaseResource
```

## 📋 Critical Checklist

Before every commit, verify:
- [ ] Code extends XotBase classes appropriately
- [ ] No hardcoded labels, placeholders, or helper text
- [ ] Strict typing with `declare(strict_types=1);`
- [ ] Explicit return types for all methods
- [ ] No usage of `property_exists()` with Eloquent models
- [ ] Translation files properly structured

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: architecture-rules.md - Critical architecture rules