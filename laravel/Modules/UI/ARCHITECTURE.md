---
title: "ARCHITECTURE"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ARCHITECTURE"
issues: []
discussions: []
---

# $MOD Architecture

Core components and design decisions.

## Structure

- `app/Models/` — Eloquent models
- `app/Actions/` — Business logic (QueueableAction)
- `app/Filament/Resources/` — Admin resources
- `app/Filament/Pages/` — Admin pages
- `config/` — Configuration
- `database/migrations/` — Database schema
- `lang/` — Translations

See README.md for overview. See CONTRIBUTING.md for development workflow.
---
title: "ARCHITECTURE"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ARCHITECTURE"
issues: []
discussions: []
# UI Module Architecture

## Overview
The UI module provides Filament-based admin interface components, themes, and utilities.

## Components
- **Filament Resources**: AdminPanel resources for data management
- **Widgets**: Dashboard widgets and custom controls
- **Themes**: Tailwind CSS theme system
- **Layout Components**: Navbar, blocks, page builder

## Subsystems
- **Page Builder**: Drag-and-drop content builder
- **Theme System**: Multi-theme support with Tailwind
- **Components**: Reusable Vue/Blade components
- **Admin Panel**: Filament admin interface

## Related Docs
- Wiki: `docs/wiki/ui/`
- Components: `docs/wiki/ui/UI-*.md`
- Filament: `docs/wiki/concepts/UI-filament-patterns.md`
