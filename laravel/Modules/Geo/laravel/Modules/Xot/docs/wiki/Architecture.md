---
module: Xot
concept: Architecture
last_updated: 2026-04-15
---

# Xot Module Architecture

The **Xot** module serves as the core foundation for the Laraxot ecosystem. It implements a multi-layered architectural pattern based on DRY, KISS, and SOLID principles.

## 1. Core Layers

The system is organized into four distinct levels of abstraction:

- **Level 0: Laravel Framework**: The base engine (Eloquent, Service Container, Events).
- **Level 1: Xot Base Layer**: Provides universal base classes (`XotBaseModel`, `XotBaseResource`, `XotBaseServiceProvider`).
- **Level 2: Business Modules**: Domain-specific modules (e.g., `Incentivi`, `Rating`) that extend Level 1 components.
- **Level 3: Application Layer**: The final integration (Controllers, Routes, Views).

## 2. Key Base Components

### [[BaseModel]]
Abstract class that all domain models must extend.
- **Responsibilities**: Automatic `extra` field management, standard casts, and common traits.
- **Traits used**: `HasXotTable`, `HasExtra`.

### [[XotBaseResource]]
Base class for Filament resources.
- **Responsibilities**: Automatic translation handling, standardized table/form patterns.
- **Contract**: Requires implementation of `getFormSchemaImplementation()`.

### [[XotBaseServiceProvider]]
The bootstrap engine for every module.
- **Responsibilities**: Automatic discovery of Views, Translations, Migrations, and Routes.

## 3. Dependency Management

Xot enforces strict dependency rules via `composer.json`:
- **Version Constraints**: Use `^` or `~`, never `*`.
- **Path Repositories**: Supports local module development within the monorepo.
- **Quality Scripts**: Standardized commands for `analyse`, `test`, and `format`.

## 4. Execution Flow

1. **Laravel Boot**: Basic framework initialization.
2. **Xot Discovery**: Scanning `Modules/` directory and loading service providers.
3. **Resource Loading**: Dynamic loading of views and translations.
4. **Component Registration**: Final registration of Filament and Livewire components.

## 5. Architectural Patterns

The module promotes several design patterns:
- **Repository Pattern**: Abstracting data access.
- **Service Layer**: Decoupling business logic from controllers (Note: PTVX prefers [[Actions]] over Services).
- **Observer Pattern**: Handling model events centrally.

## 6. Verification

Architectural integrity is verified via:
- **PHPStan Level 10**: Strict static analysis.
- **Pest Architectural Tests**: Ensuring all models extend `BaseModel`.

---
**Related Pages:**
- [[Actions Over Services]]
- [[Filament Integration Guide]]
- [[BaseModel]]
