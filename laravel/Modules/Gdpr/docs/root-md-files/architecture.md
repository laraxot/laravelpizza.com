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
