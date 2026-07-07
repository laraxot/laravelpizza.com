# Project Overview

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Tech Stack

Laravel 12.x monorepo with nwidart/laravel-modules, Filament 5 admin panel, Livewire 4/Volt, TailwindCSS + Vite. Implements the "Laraxot" architectural pattern where the Xot module is the core engine.

Key technologies:
- Backend: Laravel 12.x
- Admin panel: Filament 5.x
- Frontend: Livewire 4.x, Volt 1.10.x, Flux
- Modules: nwidart/laravel-modules
- Static analysis: PHPStan Level 10

## Key Modules

| Module | Purpose |
|--------|---------|
| Xot | Core engine: base classes, utilities, 50+ base classes |
| User | Authentication, roles, permissions, teams, social login |
| Cms | Content management, pages, menus, blocks |
| Media | File uploads, conversions |
| Notify | Notifications, mail templates |
| Geo | Location, addresses, map integrations |
| Gdpr | Consent, profiles, treatments |
| Activity | Event sourcing (stored events, snapshots) |
| Job | Queue management and monitoring |
| Chart | Chart generation |
| Lang | Translation file management |
| UI | Shared UI components |
| Tenant | Multi-tenancy support |
| Limesurvey | External system integration |

## Module Structure

```
Modules/{ModuleName}/
├── app/
│   ├── Models/
│   ├── Providers/
│   ├── Filament/Resources/{Model}Resource.php
│   │                      Pages/
│   │                      RelationManagers/
│   ├── Actions/
│   └── Http/
├── config/
├── database/migrations/, factories/, seeders/
├── resources/views/, lang/
├── routes/
├── tests/Feature/, tests/Unit/
├── docs/
└── composer.json
```

---
[Back to index](../index.md) | [Guidelines](guidelines.md) | [Links](links.md)
