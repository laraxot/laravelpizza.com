---
title: "Laraxot - Overview"
type: shard
confidence: high
created: 2026-05-11
parent: laraxot.md
lines: 50
tokens: ~65K
related:
  - ./INDEX.md
  - ./02-architecture.md
---

# Laraxot Overview

Laraxot = Laravel + XOT (eXtensible Operations Toolkit)

## What It Is
- Modular framework on top of Laravel
- Scalable web application foundation
- Opinionated architecture with conventions

## Core Philosophy
1. **Modularity**: Independent, well-defined modules
2. **Type Safety**: Strict typing, PHP 8.x features
3. **Best Practices**: Patterns over configuration
4. **Documentation**: Living docs, auto-maintained

## Quick Start
```bash
# Module structure
Modules/YourModule/
├── Actions/          # Single-responsibility actions
├── Data/             # DTOs with Spatie Laravel Data
├── Filament/         # Admin panels
├── Http/Controllers/ # Web layer
├── Models/           # Eloquent + business logic
└── Providers/        # Service providers
```

## Key Conventions
| Convention | Rule |
|------------|------|
| Base classes | Extend XotBase*, never Laravel directly |
| Namespaces | `Modules\{Name}\...` never include 'App' |
| Type hints | Always declare, never `mixed` if avoidable |
| Docs | Keep in module `docs/`, index in root |

## References
- Full architecture: [02-architecture](./02-architecture.md)
- Data management: [03-data-management](./03-data-management.md)
- Shard index: [INDEX](./INDEX.md)

---
*Shard 1/18 of laraxot.md | Load next: 02-architecture.md*
