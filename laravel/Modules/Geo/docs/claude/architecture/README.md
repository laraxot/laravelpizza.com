# Critical Architecture Rules

These rules are **MANDATORY** and violations will break the system.

## 1. NEVER Extend Filament Classes Directly

```php
// ❌ WRONG
class MyPage extends Filament\Pages\Page

// ✅ CORRECT
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

**Always extend from Xot base classes:**
- Pages → `XotBasePage`
- Resources → `XotBaseResource`
- Create pages → `XotBaseCreateRecord`
- Edit pages → `XotBaseEditRecord`
- List pages → `XotBaseListRecords`
- Models → Module-specific `BaseModel`
- Migrations → `XotBaseMigration`
- Service Providers → `XotBaseServiceProvider`

## 2. NEVER Use Hardcoded Labels/Translations

```php
// ❌ WRONG
TextInput::make('name')->label('Nome')
TextInput::make('name')->placeholder('Inserisci nome')
Action::make('edit')->label('Modifica')

// ✅ CORRECT - Auto-translated by LangServiceProvider
TextInput::make('name')
Action::make('edit')
```

**Why:** The `LangServiceProvider` automatically translates all Filament components using translation files. Hardcoded labels break this system.

## 3. NEVER Use property_exists() with Eloquent Models

```php
// ❌ WRONG
if (property_exists($model, 'email')) { ... }

// ✅ CORRECT
if (isset($model->email)) { ... }

// ✅ BETTER - Use null coalescing
$value = $model->email ?? 'default@example.com';
```

**Why:** Eloquent uses magic methods (`__get`/`__set`) and `property_exists()` doesn't detect dynamic properties, causing un<nome progetto>able bugs.

## 4. NEVER Use Services - Always Use Actions

```php
// ❌ WRONG
class UserService
{
    public function createUser($data) { ... }
}

// ✅ CORRECT - Use Spatie QueueableAction
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function execute(UserData $data): User
    {
        // Implementation
    }
}
```

**Why:** Actions provide single responsibility, easy testing, and queueable execution.

## 5. Models Must Extend Module BaseModel

```php
// ❌ WRONG
namespace Modules\User\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model { ... }

// ✅ CORRECT
namespace Modules\User\Models;

class User extends BaseModel { ... }
```

**Structure:**
```
Model (Eloquent)
  ↓
XotBaseModel (Modules\Xot\Models\XotBaseModel)
  ↓
Module BaseModel (Modules\User\Models\BaseModel)
  ↓
Domain Models (User, Post, etc.)
```

## 6. Migration Rules

```php
// ✅ CORRECT Migration Structure
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Always check if table exists
        if ($this->hasTable('table_name')) {
            return;
        }

        Schema::create('table_name', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        $this->tableComment('table_name', 'Table description');
    }

    // ❌ NEVER implement down() method
};
```

**Rules:**
- Use anonymous classes extending `XotBaseMigration`
- NEVER implement `down()` method
- NEVER create separate migrations to add columns (update the original instead)
- Always use `hasTable()` and `hasColumn()` checks
- Migrations must be idempotent

## 7. Namespace Structure

```php
// ✅ CORRECT - No 'app' segment in namespace
namespace Modules\User\Models;
namespace Modules\Ptv\Filament\Resources;
namespace Modules\User\Datas;

// ❌ WRONG - Never include 'app' in namespace
namespace Modules\User\App\Models;
namespace Modules\User\App\Datas;
```

## 8. Strict Typing Required

```php
// ✅ CORRECT - Every PHP file must start with
<?php

declare(strict_types=1);

namespace Modules\ModuleName\...;

class ExampleClass
{
    // Always specify return types
    public function getName(): string
    {
        return $this->name;
    }

    // Always type hint parameters
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
```

## 9. PTVX Architecture Pattern - Module Extension

I moduli specifici (es. IndennitaResponsabilita) devono estendere le classi corrispondenti del modulo PTV quando esistono:

```php
// ✅ CORRECT - IndennitaResponsabilita extends PTV
class ListMyLogs extends PtvListMyLogs
{
    protected static string $resource = MyLogResource::class;
    // Eredita tutta la logica comune da PTV
}

// ❌ WRONG - Non duplicare la logica
class ListMyLogs extends XotBaseListRecords
{
    // Codice duplicato che esiste già in PTV
}
```

Questo pattern si applica a:
1. Le classi Pages dei Resources
2. Le classi Resources con logica comune
3. Le classi di business logic riutilizzabile

Il modulo PTV funziona come base/core da cui altri moduli specifici ereditano funzionalità comuni.

---

## 📚 Documentation Structure

### 🛡️ Critical Rules
- **[Filament Extension Rules](rules/critical-filament-rules.md)** - ABSOLUTELY FORBIDDEN direct Filament extensions
- Module inheritance and extension patterns
- Override attribute usage rules

### 🏗️ Patterns
- Resource vs Page class separation
- Base class extension patterns
- Dependency injection guidelines

### 🎯 Principles
- SOLID principles application
- DRY/KISS practical implementation
- Architectural boundaries and isolation