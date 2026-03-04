# Laraxot Architecture: Philosophy, Religion, Politics, and Zen

## Core Philosophy (Filosofia)

Laraxot is built on the **DRY (Don't Repeat Yourself)** and **KISS (Keep It Simple, Stupid)** principles. The architecture emphasizes:

1. **Modularity**: Everything is organized into modules using the `nwidart/laravel-modules` package
2. **Inheritance Chain**: Clear inheritance pattern that maintains consistency across the application
3. **Convention over Configuration**: Predefined patterns and structures that reduce decision-making
4. **Single Responsibility**: Each component has a single, well-defined purpose

## Religion (Religione)

The architectural religion of Laraxot follows these sacred principles:

### 1. BaseModel Pattern (Sacred Inheritance Chain)
```
Model → Module BaseModel → XotBaseModel → Laravel Model
```
- Every module must have its own `BaseModel` that extends `XotBaseModel`
- Never extend `XotBaseModel` directly from a module model
- This pattern ensures consistent behavior while allowing module-specific customizations

### 2. Action Pattern (Sacred Business Logic Container)
- All business logic is encapsulated in single-purpose action classes
- Actions are located in `Modules/{ModuleName}/app/Actions/`
- Actions use the queueable pattern when needed
- Example: `GetModelTypeByModelAction`, `GeneratePdfAction`

### 3. Filament Integration (Sacred Admin Framework)
- All admin panels use Filament PHP
- Resources extend `XotBaseResource`
- Pages extend appropriate Xot base classes
- Widgets extend `XotBaseWidget`

## Politics (Politica)

### Module System Governance
- Each module is independent with its own namespace, routes, and services
- Modules can be enabled/disabled via `modules_statuses.json`
- Module ServiceProviders must extend `XotBaseServiceProvider`
- Module structure follows strict conventions

### Security and Access Control
- Authentication handled by the User module
- Authorization via Spatie permissions
- Multi-tenancy support built into the architecture
- Passport API tokens for API access

## Zen (Zen)

### The "Vestito" Philosophy (Theme as Clothing)
- Themes are like clothes ("vestito" in Italian) - they cover the application but don't change its core functionality
- Themes provide only visual presentation
- Business logic remains in modules
- Themes can be changed without affecting core functionality

### The Action-Oriented Mindset
- Every operation is an action
- Actions are pure and testable
- Actions can be queued for performance
- Actions maintain separation of concerns

## Architecture Patterns

### 1. BaseModel Inheritance Chain
```php
// Xot module provides the foundation
abstract class XotBaseModel extends Model { ... }

// Each module extends with its own base
abstract class BaseModel extends XotBaseModel {
    // Module-specific functionality
}

// Actual models extend the module's base
class SurveyPdf extends BaseModel { ... }
```

### 2. Service Provider Architecture
```php
// Base service provider handles common registration
abstract class XotBaseServiceProvider extends ServiceProvider { ... }

// Module service providers extend the base
class ModuleServiceProvider extends XotBaseServiceProvider { ... }
```

### 3. Filament Resource Pattern
```php
// Base resource with common functionality
abstract class XotBaseResource extends FilamentResource { ... }

// Module resources extend the base
class SurveyPdfResource extends XotBaseResource { ... }
```

## Core Components

### Xot Module - The Engine
- **50+ base classes** providing foundational functionality
- **20+ service providers** managing system components
- **15+ traits** offering reusable behavior patterns

### Actions System
- Located in `Modules/Xot/app/Actions/`
- Organized by functionality (Model, File, Export, etc.)
- Queueable for performance optimization
- Single responsibility principle implementation

### Service Provider Chain
1. `XotBaseServiceProvider` - Core registration logic
2. Module-specific provider - Extends base with module needs
3. Auto-registration of views, translations, components

### Model Contract System
- Interface-based contracts ensure consistency
- `ModelContract` defines common model behavior
- Type safety through contracts and interfaces

## Critical Rules and Restrictions

1. **Never use `property_exists()` on Eloquent models** - Use `hasAttribute()`, `isFillable()`, or `Schema::hasColumn()`
2. **Always extend module-specific BaseModel** - Never extend XotBaseModel directly
3. **Use Actions for business logic** - No business logic in controllers or models
4. **Theme as "Vestito"** - Themes only for presentation, not business logic
5. **Filament-first approach** - Admin functionality through Filament, not custom controllers

## Migration Philosophy
- One migration per table per module
- Use `tableUpdate()` for subsequent changes
- Check for column existence before adding (`hasColumn()`, `hasIndex()`)
- Multiple migrations for same table in same module is violation

## The Laraxot Way of Thinking

Laraxot is not just a framework but a **way of thinking** about application development:

- **Consistency over Flexibility**: Strict conventions ensure consistency
- **Modularity over Monolith**: Everything is a module
- **Actions over Controllers**: Business logic in actions, not controllers
- **Inheritance over Composition**: Clear inheritance chains for maintainability
- **Type Safety over Speed**: Strong typing for long-term maintainability

This architecture creates a harmonious system where all components work together in a predictable, maintainable way.