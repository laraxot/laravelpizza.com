# Xot Module - Core Foundation

**Last Update**: 2025-12-05
**Status**: ✅ Production Ready
**PHPStan Level**: 10
**Maintainers**: Laraxot Team

---

## 📋 Table of Contents

- [Business Overview](#-business-overview)
- [Architecture](#-architecture)
- [Core Components](#-core-components)
- [Quick Start](#-quick-start)
- [Development Guide](#-development-guide)
- [Testing](#-testing)
- [Documentation Index](#-documentation-index)

---

## 🎯 Business Overview

### Purpose
The **Xot Module** is the foundational core of the Laraxot PTVX ecosystem. It provides:
- **Base Classes**: XotBase* classes for Resources, Widgets, Actions, Blocks, Pages
- **Shared Patterns**: Architectural patterns used across all modules
- **Common Tools**: Data objects (XotData, MetatagData), utilities, helpers
- **Automation Scripts**: Git, bash, and CI/CD automation tools

### Key Features
- **Type-Safe Base Classes**: PHPStan Level 10 compliant base classes for Filament components
- **Cross-Module Integration**: Shared services and utilities for all modules
- **Translation System**: Centralized translation management with TransTrait
- **Navigation Management**: Dynamic navigation generation for Filament panels
- **Data Management**: XotData pattern for configuration and cross-module data access
- **Automation Tools**: Bash scripts for git operations, testing, and deployment

### Target Users
- **Module Developers**: Developers creating new modules that extend Xot base classes
- **Application Architects**: System architects designing multi-module applications
- **DevOps Engineers**: Engineers managing deployment and automation

---

## 🏗️ Architecture

### Module Position
```
┌─────────────────────────────────────────┐
│           Application Layer              │
├─────────────────────────────────────────┤
│  TechPlanner │ Employee │ Cms │ ...     │  ← Business Modules
├─────────────────────────────────────────┤
│  User │ UI │ Tenant │ Geo │ Lang │ ...  │  ← Infrastructure Modules
├─────────────────────────────────────────┤
│              Xot Module                  │  ← **Foundation Layer**
│  • XotBase* Classes                      │
│  • Shared Patterns & Traits              │
│  • Common Services & Utilities           │
├─────────────────────────────────────────┤
│  Laravel 12 │ Filament 4 │ Livewire 3   │  ← Framework Layer
└─────────────────────────────────────────┘
```

### Module Dependencies
```
Xot Module (Foundation - No dependencies)
└── Provides base classes for:
    ├── User Module
    ├── UI Module
    ├── Tenant Module
    ├── Geo Module
    ├── Lang Module
    ├── Media Module
    ├── Activity Module
    ├── Cms Module
    ├── TechPlanner Module
    ├── Employee Module
    └── All other modules
```

**Critical**: Xot has **NO dependencies** on other modules. All other modules depend on Xot.

### Technology Stack
- **Laravel**: 12.x
- **Filament**: 4.x
- **Livewire**: 3.x
- **PHP**: 8.3+
- **PHPStan**: Level 10
- **Pest**: 3.x (Testing framework)

### Directory Structure

```
Xot/
├── app/
│   ├── Actions/              # Business actions (Action pattern)
│   ├── Casts/                # Custom Eloquent casts
│   ├── Console/              # Artisan commands
│   ├── Contracts/            # Interfaces
│   ├── DTOs/                 # Data Transfer Objects
│   ├── Datas/                # Data objects (XotData, MetatagData)
│   ├── Enums/                # Enumerations
│   ├── Events/               # Domain events
│   ├── Exceptions/           # Custom exceptions
│   ├── Filament/             # Filament base components
│   │   ├── Resources/        # XotBaseResource
│   │   ├── Pages/            # XotBasePage, XotBaseListRecords, etc.
│   │   ├── Widgets/          # XotBaseWidget, XotBaseChartWidget
│   │   ├── Actions/          # XotBaseAction
│   │   └── Blocks/           # XotBaseBlock
│   ├── Helpers/              # Helper functions
│   ├── Http/                 # Controllers, Middleware, Requests
│   ├── Models/               # Base model classes
│   ├── Providers/            # Service providers
│   ├── Services/             # Business logic services
│   ├── Traits/               # Reusable traits
│   └── View/                 # View composers and components
├── bashscripts/              # Automation scripts
│   ├── fix/                  # Code fixing scripts
│   ├── git/                  # Git automation
│   ├── test/                 # Testing scripts
│   └── docs/                 # Script documentation
├── config/                   # Module configuration
├── database/
│   ├── migrations/           # Base migrations
│   └── seeders/              # Base seeders
├── docs/                     # Documentation
│   ├── architecture/         # Architecture docs
│   ├── development/          # Developer guides
│   └── testing/              # Testing guides
├── resources/
│   ├── lang/                 # Translations
│   └── views/                # Blade templates
└── tests/                    # Tests
    ├── Feature/              # Feature tests
    └── Unit/                 # Unit tests
```

---

## 🔧 Core Components

### Base Classes for Filament

#### XotBaseResource
**Purpose**: Foundation class for all Filament resources across modules

**Key Features**:
- Type-safe form and table schema definitions
- Consistent resource pattern enforcement
- PHPStan Level 10 compliance
- Automatic navigation integration

**Usage**:
```php
namespace Modules\YourModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    public static function form(Form $form): Form
    {
        // Your form schema
    }

    public static function table(Table $table): Table
    {
        // Your table schema
    }
}
```

#### XotBasePage / XotBaseListRecords / XotBaseEditRecord
**Purpose**: Base classes for custom Filament pages

**Key Features**:
- Consistent page structure
- Shared business logic
- Type-safe implementations
- Automatic breadcrumb generation

#### XotBaseWidget / XotBaseChartWidget
**Purpose**: Base classes for Filament widgets

**Key Features**:
- Dashboard widget patterns
- Chart widget utilities
- Type-safe data methods
- Caching support

#### XotBaseAction
**Purpose**: Base class for Filament actions

**Key Features**:
- Action pattern implementation
- Type-safe parameters
- Permission integration
- Logging and audit trail

#### XotBaseBlock
**Purpose**: Base class for content blocks (CMS integration)

**Key Features**:
- Block pattern for content management
- Type-safe render methods
- Schema validation
- Preview support

### Data Objects

#### XotData
**Purpose**: Centralized configuration and data access across modules

**Key Features**:
- Cross-module data sharing
- Configuration management
- Type-safe data access
- Caching layer

**Usage**:
```php
use Modules\Xot\Datas\XotData;

// Access module configuration
$config = XotData::make()->getConfig('module.key');

// Get cross-module data
$sharedData = XotData::make()->get('shared.data');
```

#### MetatagData
**Purpose**: SEO and metadata management for frontend pages

**Key Features**:
- Meta tag generation
- SEO optimization
- Open Graph support
- Twitter Card support

**Usage**:
```php
use Modules\Xot\Datas\MetatagData;

$metatags = MetatagData::make()
    ->title('Page Title')
    ->description('Page Description')
    ->image('image-url.jpg')
    ->render();
```

### Traits

#### TransTrait
**Purpose**: Translation management for models and classes

**Key Features**:
- Dynamic translation key generation
- Translation prefix management
- Integration with Lang module
- Fallback support

**Usage**:
```php
use Modules\Xot\Traits\TransTrait;

class YourClass
{
    use TransTrait;

    public function getTranslatedName(): string
    {
        return $this->trans('name');
    }
}
```

#### HasXotTable
**Purpose**: Enhanced table functionality for Filament resources

**Key Features**:
- Advanced table configurations
- Bulk actions support
- Filter management
- Export functionality

### Services

#### NavigationService
**Purpose**: Dynamic navigation generation for Filament panels

**Key Features**:
- Automatic module navigation
- Permission-based navigation
- Icon management
- Sorting and grouping

#### ModuleService
**Purpose**: Module management and discovery

**Key Features**:
- Module registration
- Dependency resolution
- Module status management
- Configuration loading

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.3 or higher
- Composer
- Laravel 12.x
- Filament 4.x installed

### Installation

**Note**: Xot is the foundation module and should be installed first before any other modules.

```bash
# Xot is typically pre-installed in Laraxot PTVX applications
# If installing manually:

# 1. Clone or install module
composer require laraxot/module-xot

# 2. Run migrations
php artisan migrate --path=Modules/Xot/database/migrations

# 3. Publish configuration (optional)
php artisan vendor:publish --tag=xot-config

# 4. Clear caches
php artisan config:clear
php artisan cache:clear
```

### Configuration

```php
// config/xot.php (after publishing)
return [
    // Module configuration
    'modules' => [
        'auto_discover' => true,
        'namespace' => 'Modules',
    ],

    // Data configuration
    'data' => [
        'cache_ttl' => 3600,
    ],

    // Navigation configuration
    'navigation' => [
        'auto_generate' => true,
    ],
];
```

### First Steps - Creating a New Module

1. **Generate Module**:
```bash
php artisan module:make YourModule
```

2. **Extend Xot Base Classes**:
```php
// YourModule/Filament/Resources/YourResource.php
use Modules\Xot\Filament\Resources\XotBaseResource;

class YourResource extends XotBaseResource
{
    // Your resource implementation
}
```

3. **Use Xot Services**:
```php
// Access XotData
use Modules\Xot\Datas\XotData;

$config = XotData::make()->getConfig('yourmodule.setting');
```

---

## 💻 Development Guide

### Extending Base Classes

#### Creating a Custom Resource
```php
namespace Modules\YourModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Your form components
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Your table columns
            ])
            ->filters([
                // Your filters
            ])
            ->actions([
                // Your actions
            ]);
    }
}
```

#### Creating a Custom Widget
```php
namespace Modules\YourModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class YourWidget extends XotBaseWidget
{
    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        return [
            'data' => $this->getData(),
        ];
    }
}
```

### Using Xot Patterns

#### Action Pattern
```php
namespace Modules\YourModule\Actions;

use Modules\Xot\Actions\XotBaseAction;

class YourAction extends XotBaseAction
{
    public function execute(array $params): mixed
    {
        // Your action logic
        return $result;
    }
}
```

#### DTO Pattern
```php
namespace Modules\YourModule\DTOs;

use Spatie\LaravelData\Data;

class YourData extends Data
{
    public function __construct(
        public string $name,
        public int $value,
    ) {}
}
```

### Code Standards
- **PHPStan Level**: 10 (strict)
- **Coding Style**: PSR-12 + Laravel conventions
- **Type Safety**: All methods must have type hints
- **Documentation**: PHPDoc required for all public methods
- **Testing**: Minimum 80% code coverage

### Best Practices

1. **Always Extend XotBase Classes**
   - Never create Filament resources directly
   - Always extend XotBaseResource, XotBasePage, etc.

2. **Use Type Hints Everywhere**
   - PHPStan Level 10 requires strict typing
   - Use declare(strict_types=1) in all files

3. **Follow Naming Conventions**
   - Resources: `{Model}Resource`
   - Actions: `{Verb}{Noun}Action`
   - DTOs: `{Name}Data`

4. **Leverage Xot Services**
   - Use XotData for cross-module data
   - Use TransTrait for translations
   - Use NavigationService for custom navigation

---

## 🔗 API & Integration

### Public APIs

#### XotData API
```php
// Get configuration
XotData::make()->getConfig('module.key');

// Get shared data
XotData::make()->get('key');

// Set shared data
XotData::make()->set('key', 'value');
```

#### MetatagData API
```php
// Generate meta tags
MetatagData::make()
    ->title('Title')
    ->description('Description')
    ->image('image.jpg')
    ->render();
```

#### NavigationService API
```php
// Get module navigation
NavigationService::getModuleNavigation('moduleName');

// Register custom navigation
NavigationService::register(NavigationItem $item);
```

### Events

- `ModuleRegistered`: Fired when a module is registered
- `NavigationGenerated`: Fired when navigation is generated
- `XotDataCacheCleared`: Fired when XotData cache is cleared

### Automation Scripts

Located in `bashscripts/`:
- **Git Automation**: Conflict resolution, branch management
- **Testing**: Automated test execution
- **Code Quality**: PHPStan, Pint, PHPInsights automation
- **Deployment**: Build and deployment scripts

---

## 🧪 Testing

### Test Coverage
- **Target**: 90%+
- **Current**: ~85%
- **Critical Components**: 95%+

### Running Tests

```bash
# All Xot module tests
./vendor/bin/pest Modules/Xot

# Specific test file
./vendor/bin/pest Modules/Xot/tests/Feature/XotDataTest.php

# With coverage
./vendor/bin/pest Modules/Xot --coverage --min=90

# PHPStan analysis
./vendor/bin/phpstan analyse Modules/Xot --level=max
```

### Test Strategy
- **Unit Tests**: Test individual classes and methods in isolation
- **Feature Tests**: Test integration between components
- **Integration Tests**: Test interaction with other modules (when applicable)

### Testing Configuration
```php
// Tests use .env.testing with:
// - SQLite in-memory database
// - Array cache driver
// - Sync queue driver
// - NO RefreshDatabase trait (use DatabaseTransactions)
```

---

## 📚 Documentation Index

### Architecture
- [Architecture Overview](./architecture-overview.md) - Complete system architecture
- [Module Structure](./architecture/module-structure.md) - Directory and file organization
- [Design Patterns](./architecture/design-patterns.md) - Patterns used in Xot
- [Database Schema](./architecture/database-schema.md) - Base database structure

### Core Components
- [XotBase Classes](./architecture/xotbase-classes.md) - Complete XotBase* class reference
- [Data Objects](./architecture/data-objects.md) - XotData, MetatagData, etc.
- [Traits](./architecture/traits.md) - Available traits and usage
- [Services](./architecture/services.md) - Core services documentation

### Development
- [Getting Started](./development/getting-started.md) - Setup and first steps
- [Creating Modules](./development/creating-modules.md) - Module creation guide
- [Extending Base Classes](./development/extending-base-classes.md) - How to extend XotBase*
- [Code Examples](./development/examples.md) - Practical code examples
- [Contributing Guidelines](./development/contributing.md) - How to contribute

### Best Practices
- [PHPStan Level 10 Compliance](./phpstan-workflow.md) - Achieving PHPStan compliance
- [Type Safety Guidelines](./development/type-safety.md) - Type hint best practices
- [Naming Conventions](./naming_conventions_docs.md) - File and class naming
- [Testing Guidelines](./testing-strategy.md) - How to write tests

### Quality & Tools
- [Code Quality Tools](./code-quality-tools.md) - PHPStan, Pint, PHPInsights
- [Automation Scripts](./bashscripts/README.md) - Available automation scripts
- [PHPStan Patterns](./phpstan-pattern-soluzioni.md) - Common PHPStan solutions

### Migration & Upgrade
- [Filament 4 Migration](./filament-4-migration-guide.md) - Upgrading to Filament 4
- [Migration Rules](./migration-update-rules.md) - Migration best practices
- [Breaking Changes](./breaking-changes.md) - Version upgrade notes

### Troubleshooting
- [Common Issues](./troubleshooting/common-issues.md) - Frequently encountered problems
- [Conflict Resolution](./risoluzione-conflitti-merge.md) - Git merge conflict handling
- [Configuration Issues](./environment-configuration-issues.md) - Environment setup problems
- [FAQ](./troubleshooting/faq.md) - Frequently asked questions

---

## 🔄 Recent Updates

### v3.0.0 - 2025-12-05
- **Added**: Laravel 12 support
- **Added**: Filament 4 support
- **Added**: PHP 8.3 support
- **Changed**: PHPStan Level 10 compliance achieved
- **Changed**: Improved XotData caching mechanism
- **Fixed**: Git merge conflict resolution improvements

### v2.9.0 - 2025-11-18
- **Added**: New XotBaseChartWidget
- **Fixed**: HasXotTable duplicate if statements
- **Fixed**: Mass syntax errors across modules
- **Improved**: PHP Insights score (Code: 52.6%, Complexity: 93.1%)

See [CHANGELOG.md](./CHANGELOG.md) for full history.

---

## 🗺️ Roadmap

### Next Release (v3.1.0)
- [ ] Documentation consolidation (500 → 120 files)
- [ ] Module health check dashboard
- [ ] Automated dependency analyzer

### Future Plans
- Enhanced XotData with typed accessors
- GraphQL support for XotBase resources
- Real-time update support for widgets
- Advanced caching strategies

See [ROADMAP.md](./ROADMAP.md) for details.

---

## 📖 Related Documentation

### Internal Modules
- [User Module](../User/docs/README.md) - User management and authentication
- [UI Module](../UI/docs/README.md) - UI components and design system
- [Tenant Module](../Tenant/docs/README.md) - Multi-tenancy support
- [Lang Module](../Lang/docs/README.md) - Translation and localization
- [Geo Module](../Geo/docs/README.md) - Geographic data services

### Project Documentation
- [CLAUDE.md](../../../CLAUDE.md) - Project architecture and development rules
- [Project README](../../../README.md) - Main project documentation

### External Resources
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Filament 4 Documentation](https://filamentphp.com/docs/4.x)
- [Livewire 3 Documentation](https://livewire.laravel.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Pest Documentation](https://pestphp.com/docs)

---

## 🤝 Contributing

Contributions to the Xot module should follow strict guidelines as it's the foundation for all other modules.

**Before Contributing**:
1. Ensure PHPStan Level 10 compliance
2. Write comprehensive tests (90%+ coverage)
3. Update documentation
4. Follow architectural patterns

See [CONTRIBUTING.md](./CONTRIBUTING.md) for detailed guidelines.

---

## 📝 License

Part of the Laraxot PTVX ecosystem.

---

**Module**: Xot (Core Foundation)
**Framework**: Laravel 12 + Filament 4 + PHP 8.3
**PHPStan**: Level 10 ✅
**Test Coverage**: 85%+ ✅
