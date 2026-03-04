# Laraxot: Complete Architecture Documentation

## Table of Contents
1. [Core Philosophy](#core-philosophy)
2. [Module System](#module-system)
3. [BaseModel Pattern](#baseModel-pattern)
4. [Action Pattern](#action-pattern)
5. [Service Provider Architecture](#service-provider-architecture)
6. [Filament Integration](#filament-integration)
7. [Theme System](#theme-system)
8. [Best Practices](#best-practices)

## Core Philosophy

Laraxot is built on the **DRY (Don't Repeat Yourself)** and **KISS (Keep It Simple, Stupid)** principles with a strong emphasis on:

- **Modularity**: Everything is organized into independent modules
- **Inheritance Chain**: Clear, predictable inheritance patterns
- **Convention over Configuration**: Predefined patterns that reduce decision-making
- **Separation of Concerns**: Clear boundaries between different system components

### The "Vestito" Philosophy
Themes are like clothes - they provide visual presentation but don't change the core functionality. Business logic remains in modules, presentation in themes.

## Module System

### Core Architecture
- Uses `nwidart/laravel-modules` for modular architecture
- Each module is self-contained with its own models, resources, actions, etc.
- Modules can be enabled/disabled via `modules_statuses.json`

### Module Structure
```
Modules/[ModuleName]/
├── app/
│   ├── Models/
│   ├── Providers/
│   ├── Filament/
│   ├── Actions/
│   └── Http/
├── config/
├── database/
├── resources/
├── routes/
├── tests/
└── docs/
```

## BaseModel Pattern

### Sacred Inheritance Chain
```
Model → Module BaseModel → XotBaseModel → Laravel Model
```

### Critical Rules
1. **Never extend XotBaseModel directly** - Always use module-specific BaseModel
2. Module BaseModel provides module-specific functionality
3. Concrete models extend their module's BaseModel

```php
// Correct pattern
abstract class BaseModel extends XotBaseModel { /* module-specific */ }
class MyModel extends BaseModel { /* concrete implementation */ }
```

## Action Pattern

### Core Principle
Every business operation is encapsulated in a single-purpose action class.

### Action Structure
- Located in `Modules/Xot/app/Actions/[Category]/`
- Use `QueueableAction` trait for performance
- Single responsibility - each action does one thing
- Organized by functionality (Model, File, Export, etc.)

```php
class MyAction
{
    use QueueableAction;

    public function execute($parameter) { /* business logic */ }
}
```

### Usage
```php
// Direct execution
$result = app(MyAction::class)->execute($param);

// Queued execution
$result = app(MyAction::class)->onQueue()->execute($param);
```

## Service Provider Architecture

### Sacred Inheritance Chain
```
ServiceProvider → XotBaseServiceProvider → Module ServiceProvider
```

### XotBaseServiceProvider Features
- Auto-registration of views, translations, components
- Auto-discovery of Blade and Livewire components
- Automatic registration of routes and event providers
- Blade icon auto-registration

```php
abstract class ModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName';  // Required!
}
```

## Filament Integration

### Resource Architecture
All Filament resources extend `XotBaseResource`:

```
Filament Resource → XotBaseResource → FilamentResource
```

### Required Implementation
```php
abstract public static function getFormSchema(): array
```

### Page Generation
XotBaseResource automatically generates standard pages (index, create, edit).

### Key Rules
- Never use hardcoded labels (`->label()`) - use translation system
- All resources extend XotBaseResource
- Follow standard method names for consistency

## Theme System

### "Vestito" Philosophy
- Themes provide only visual presentation
- Business logic remains in modules
- Themes can be changed without affecting functionality
- Clear separation of presentation and business logic

### View Resolution Order
1. Current Theme Views
2. Module Views
3. Laravel Defaults

## Best Practices

### 1. Never use `property_exists()` on Eloquent models
Use `hasAttribute()`, `isFillable()`, or `Schema::hasColumn()` instead.

### 2. Migration Philosophy
- One migration per table per module
- Use `tableUpdate()` for subsequent changes
- Check for column existence before adding

### 3. Action Usage
- Single responsibility per action
- Use QueueableAction for performance
- Organize by functionality

### 4. Service Provider Rules
- Always extend XotBaseServiceProvider
- Set module name property
- Don't override core registration methods without calling parent

### 5. Filament Integration
- Always extend XotBaseResource
- Use translation system instead of hardcoded labels
- Follow standard method naming conventions

## The Laraxot Way

Laraxot is not just a framework but a **way of thinking** about application development:

- **Consistency over Flexibility**: Strict conventions ensure consistency
- **Modularity over Monolith**: Everything is a module
- **Actions over Controllers**: Business logic in actions, not controllers
- **Inheritance over Composition**: Clear inheritance chains for maintainability
- **Type Safety over Speed**: Strong typing for long-term maintainability

This architecture creates a harmonious system where all components work together in a predictable, maintainable way that supports the DRY and KISS principles while providing the flexibility needed for complex applications.
