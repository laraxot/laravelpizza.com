---
qmd: "MODULE STRUCTURE"
issues: []
discussions: []
title: "Notify Module — Structure & Discipline"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
---

# Notify Module — Structure & Discipline

## Module Root (PascalCase)

```
Modules/Notify/
├── app/              # Domain logic (notifications, jobs, channels)
├── config/           # Laravel config (lowercase)
├── database/         # Migrations, seeders (lowercase)
├── resources/        # Templates, lang files (lowercase)
├── routes/           # Routes (lowercase)
├── tests/            # Test files (lowercase)
├── docs/             # Module documentation (THIS FOLDER)
└── composer.json     # Module metadata
```

## ✅ What Belongs Here

- **Notification Classes** — Laravel Notifications
- **Channels** — Custom notification channels (email, SMS, Slack, etc.)
- **Jobs** — Async notification dispatching
- **Listeners** — Event-based notification triggers

## What Does NOT Belong Here

### ❌ rector.php

**Rector is a global tool**, configured only in `laravel/rector.php` at project root.

If Notify needs special refactoring:
1. Add conditional logic to project-level `laravel/rector.php`
2. Document the requirement here
3. Never create `Notify/rector.php`

### ❌ phpstan.neon, ci.yml, config files

Configuration tools operate project-wide. Module-level overrides:
- Scatter responsibility
- Break PHPStan's class resolution
- Create inconsistency

## Internal Naming

- **Files**: `SendNotificationJob.php`, `EmailChannel.php` (PascalCase)
- **Directories**: `jobs/`, `channels/`, `listeners/`, `actions/` (lowercase)
- **Namespaces**: `Modules\Notify\...` (PascalCase at root only)

## Documentation Structure

```
docs/
├── MODULE_STRUCTURE.md      # This file
├── CHANNELS.md              # Custom notification channels
├── QUICKSTART.md            # Usage examples
└── DECISIONS.md             # Why we chose X over Y
```

## See Also

- [Project Module Discipline](../../../docs/rules/module-root-configuration-discipline.md)
- `laravel/rector.php` — Global refactoring rules
- `laravel/phpstan.neon` — Global type-checking configuration
