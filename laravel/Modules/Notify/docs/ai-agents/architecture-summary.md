---
title: "architecture summary"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_E25nXe
<<<<<<< .merge_file_bfOQtn
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_Sb5XHg
=======
>>>>>>> .merge_file_IdZDsU
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_E25nXe
<<<<<<< .merge_file_bfOQtn
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_Sb5XHg
=======
>>>>>>> .merge_file_IdZDsU
qmd: "architecture summary"
issues: []
discussions: []
---

# PTVX Architecture Summary

> **Status**: Consolidated from Deep Study (2026-03-10)
> **Confidence Level**: High (100%)

## 1. The Laraxot Core (Engine)
The system is built on the **Laraxot** modular framework. At its center is the `Xot` module.

### Core Abstractions
- **Models**: Every model in the system follows the chain: `Model` -> `ModuleBaseModel` -> `XotBaseModel` -> `Eloquent\Model`. This ensures global traits like `HasXotFactory`, `RelationX`, and `Updater` are available everywhere.
- **Resources**: Filament resources extend `XotBaseResource`, which enforces `final` `form()` and `table()` methods, forcing developers to use `getFormSchema()` and `getTableColumns()`. This enables automatic translation key generation and consistent UI patterns.
- **Service Providers**: All module providers extend `XotBaseServiceProvider`, which handles automatic discovery of routes, views, translations, and migrations.

## 2. Module Ecosystem
PTVX is a **Modular Monolith**.

### Key Modules
- **Xot**: Infrastructure, base classes, monitoring (Pulse), sessions, cache.
- **User**: Identity management, Spatie Permissions, Passport/OAuth2 wrappers, Profile EAV system.
- **Ptv**: The main business process engine for evaluations (Schede, Valutatori). It coordinates legacy data mapping and sync logic.
- **UI**: Shared Blade components and frontend utilities.
- **Lang**: Centralized translation management.

## 3. Themes (The "Vestito")
Themes are decoupled from business logic.
- **Zero Theme**: The minimalist, high-performance foundation based on Tailwind CSS 4.0.
- **One Theme**: An alternative premium theme.
- **Philosophy**: Business logic resides in modules; themes only handle visualization and design tokens.

## 4. Engineering Standards
- **PHPStan**: 100% Level 10 compliance across all 35 modules.
- **Testing**: Pest-driven development. `DatabaseTransactions` used instead of `RefreshDatabase`. Global `XotBaseTestCase` for all tests.
- **Conventions**: No hardcoded labels; strict use of translation keys; mandatory lowercase date-free doc filenames.

## 5. Directory Mapping
- Root: `./`
- Laravel Core: `laravel/`
- Modules: `laravel/Modules/`
- Themes: `laravel/Themes/`
- Documentation: `docs/` (global) and `laravel/Modules/{Name}/docs/` (local).

<<<<<<< HEAD
<<<<<<< .merge_file_E25nXe
<<<<<<< .merge_file_bfOQtn
[Return to Documentation Index](../../agents.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_Sb5XHg
=======
>>>>>>> .merge_file_IdZDsU
=======
<<<<<<< HEAD
[Return to Documentation Index](../../agents.md)
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_E25nXe
<<<<<<< .merge_file_bfOQtn
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_Sb5XHg
=======
>>>>>>> .merge_file_IdZDsU
---
title: "architecture summary"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "architecture summary"
issues: []
discussions: []
<<<<<<< .merge_file_E25nXe
<<<<<<< .merge_file_bfOQtn
=======
>>>>>>> .merge_file_IdZDsU
[Return to Documentation Index](../../AGENTS.md)
[Return to Documentation Index](../../AGENTS.md)
<<<<<<< HEAD
=======
<<<<<<< .merge_file_E25nXe
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
[Return to Documentation Index](../../agents.md)
=======
[Return to Documentation Index](../../AGENTS.md)
[Return to Documentation Index](../../AGENTS.md)
<<<<<<< HEAD
=======
>>>>>>> .merge_file_Sb5XHg
=======
>>>>>>> .merge_file_IdZDsU
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
