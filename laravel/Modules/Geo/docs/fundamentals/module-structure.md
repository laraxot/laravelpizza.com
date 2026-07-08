# Module Structure and Organization

## 🏗️ Project Architecture

The PTVX project follows a modular architecture where everything is organized into independent modules.

### Root Structure

```
/var/www/html/ptvx/
├── laravel/                 # Main Laravel application
│   ├── Modules/            # Modular architecture (core)
│   ├── Themes/             # Frontend themes
│   └── docs/               # Laravel-specific docs
├── docs/                   # AI guidelines and project docs
└── bashscripts/            # Automation scripts
```

### Module Organization

Modules are the fundamental building blocks of the application.

```
Modules/ModuleName/
├── app/                    # Application logic
│   ├── Actions/           # Business logic (Spatie QueueableAction)
│   ├── Data/              # DTOs (Spatie Laravel Data)
│   ├── Exceptions/        # Custom exceptions
│   ├── Filament/          # Admin components
│   │   ├── Resources/     # CRUD interfaces
│   │   ├── Pages/         # Custom pages
│   │   └── Widgets/       # Dashboard widgets
│   ├── Http/              # HTTP layer
│   │   ├── Controllers/   # Web controllers
│   │   ├── Livewire/      # Livewire components
│   │   └── Requests/      # Form validation
│   ├── Models/            # Eloquent models
│   ├── Policies/          # Authorization
│   ├── Providers/         # Service providers
│   └── Traits/            # Reusable traits
├── config/                # Module configuration
├── database/              # Database layer
│   ├── factories/         # Test data factories
│   ├── migrations/        # Schema changes
│   └── seeders/           # Initial data
├── docs/                  # Module documentation
├── resources/             # Assets and templates
│   ├── lang/              # Translations
│   ├── views/             # Blade templates
│   └── assets/            # CSS, JS, images
└── routes/                # Route definitions
```

## 🔧 Module Creation Standards

### Required Components

Every module **MUST** include:

- [ ] **Service Provider** extending `XotBaseServiceProvider`
- [ ] **Base Model** extending `XotBaseModel` (specific to module)
- [ ] **Repository Pattern** for data access
- [ ] **Actions** for business logic (not Services)
- [ ] **Data Objects** for data transfer
- [ ] **Translation Files** in proper structure
- [ ] **Documentation** in module `docs/` folder

### Namespace Conventions

```php
// ✅ CORRECT - Clean module namespaces
namespace Modules\User\Models;
namespace Modules\Performance\Actions;
namespace Modules\Xot\Filament\Resources;

// ❌ WRONG - Avoid 'app' segment
namespace Modules\User\App\Models;
```

### Base Class Extensions

```php
// ✅ CORRECT - Always extend appropriate base classes
class UserServiceProvider extends XotBaseServiceProvider
class UserResource extends XotBaseResource
class User extends BaseModel  // From Modules\User\Models\BaseModel
class CreateUserAction { use QueueableAction; }
```

## 📋 Quality Checklist

### Pre-Creation Verification
- [ ] **Purpose Clear**: Module has a single, well-defined responsibility
- [ ] **Dependencies Mapped**: Cross-module dependencies identified
- [ ] **Resources Planned**: Required models, actions, and UI components listed
- [ ] **Testing Strategy**: Test approach defined

### Post-Creation Validation
- [ ] **Structure Complete**: All required directories exist
- [ ] **Base Classes**: All classes extend appropriate XotBase classes
- [ ] **Namespace Clean**: No 'app' segments in namespaces
- [ ] **Translations**: All user-facing text in translation files
- [ ] **Documentation**: README.md and API docs complete
- [ ] **Tests**: Basic test structure in place

## 🔗 Integration Points

### Cross-Module Communication

- **Actions**: Preferred for inter-module communication
- **Events**: For decoupled module interactions
- **Contracts**: Interfaces for module boundaries
- **Data Objects**: For safe data transfer between modules

### Shared Components

- **Base Classes**: In `Modules/Xot/` for common functionality
- **Traits**: For reusable behavior across modules
- **Contracts**: For defining module interfaces
- **Enums**: For shared constants and options

## 📚 Documentation Requirements

### Module Documentation Structure

```
Modules/ModuleName/docs/
├── README.md              # Module overview and usage
├── api.md                 # API endpoints and contracts
├── models.md              # Model relationships and business logic
├── filament.md            # Admin interface documentation
└── examples.md            # Usage examples and code samples
```

### Root Documentation Updates

When creating a new module, update:
- [ ] `docs/README.md` - Add module to module list
- [ ] `docs/fundamentals/module-list.md` - Add detailed module description
- [ ] Cross-references in related documentation

## 🚀 Best Practices

### Module Size Guidelines
- **Small Modules**: 3-5 classes, single responsibility
- **Medium Modules**: 10-15 classes, related functionality
- **Large Modules**: 20+ classes, complex business domains

### Dependency Management
- **Minimize Coupling**: Prefer events over direct calls
- **Clear Contracts**: Use interfaces for module boundaries
- **Version Compatibility**: Document breaking changes

### Testing Strategy
- **Unit Tests**: All actions and data objects
- **Feature Tests**: Critical user workflows
- **Integration Tests**: Cross-module interactions

---

**Related**: [Architecture Rules](architecture-rules.md) | [Code Conventions](../development/conventions.md) | [Module List](module-list.md)
