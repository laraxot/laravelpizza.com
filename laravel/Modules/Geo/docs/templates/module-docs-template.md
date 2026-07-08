# {ModuleName} Module

> **Filament Version**: This module targets **Filament v5** (see `docs/filament-version.md` and the Second Brain memory `docs/wiki/memories/filament-version-policy.md`).

## Overview

{Brief description of the module's purpose and responsibilities}

## Architecture

- **Models**: `Modules/{ModuleName}/app/Models/`
- **Filament Resources**: `Modules/{ModuleName}/app/Filament/Resources/`
- **Actions**: `Modules/{ModuleName}/app/Actions/`
- **Translations**: `Modules/{ModuleName}/lang/{locale}/`

## Key Models

| Model | Table | Purpose |
|-------|-------|---------|
| {ModelName} | {table_name} | {purpose} |

## Filament Resources

| Resource | Model | Pages |
|----------|-------|-------|
| {ResourceName} | {Model} | List, Create, Edit, View |

## Dependencies

- **Core**: Xot, User, Tenant
- **Specific**: {list other module dependencies}

## Development Workflow

### GSD (Get Shit Done)

For feature development in this module, use the GSD workflow:

1. **Discuss**: `GSD discuss phase N` — Clarify requirements specific to this module
2. **Plan**: `GSD plan phase N` — Create atomic XML task plans
3. **Execute**: `GSD execute phase N` — Wave execution with atomic commits
4. **Verify**: `GSD verify N` — Test deliverables against requirements

For quick fixes: `GSD quick "{ModuleName}: description"`

### Quality Gates

After every change:
- [ ] `./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10`
- [ ] `./vendor/bin/pint Modules/{ModuleName}`
- [ ] No `->label()` in Filament components
- [ ] `declare(strict_types=1)` in all PHP files
- [ ] Translations updated (it/en/de)

### Conventions

- Models extend `Modules\{ModuleName}\Models\BaseModel`
- Filament classes extend `XotBase*` wrappers
- Actions use `app(ActionClass::class)->execute()` pattern
- No `property_exists()` — use `??` operator
- Migrations: anonymous classes extending `XotBaseMigration`, no `down()` method

## Documentation

- [GSD Methodology](../../docs/project/gsd-methodology.md)
- [Laraxot Conventions](../../docs/laraxot-conventions.md)
- [AGENTS.md](../../AGENTS.md)

## Roadmap

See `.planning/ROADMAP.md` for phases that affect this module.

## Changelog

See git history: `git log --oneline laravel/Modules/{ModuleName}/`
