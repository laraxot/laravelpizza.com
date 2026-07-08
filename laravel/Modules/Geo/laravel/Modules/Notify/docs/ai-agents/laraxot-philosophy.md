# Laraxot single source of truth philosophy

> Source: [IFLOW.md](../../bashscripts/ai/IFLOW.md)
> Back: [index](index.md) | [critical-rules.md](critical-rules.md)

## Core principle

In Laraxot architecture, every category of file (database files, test files, migrations) must exist in ONE location only. Never both.

---

## File structure philosophy

Database-related files (migrations, seeders, factories) must be in the traditional Laravel structure, never duplicated in `app/`.

```
CORRECT
Modules/{ModuleName}/
├── database/                    # SINGLE SOURCE OF TRUTH
│   ├── factories/
│   ├── migrations/
│   └── seeders/
└── app/
    ├── Models/
    └── Filament/

WRONG - mixed structure
Modules/Cms/
├── database/factories/          # has files
└── app/Database/Factories/      # empty dirs causing autoloader confusion
```

---

## Test structure philosophy

Test files must be in ONE consistent directory per module.

```
CORRECT
Modules/{ModuleName}/
├── tests/
│   ├── Feature/
│   └── Unit/
└── app/
    ├── Models/
    └── Filament/

WRONG - mixed test structure
Modules/UI/
├── tests/Unit/Widgets/          # has files
└── app/Tests/Unit/Filament/     # also has files
```

---

## Migration philosophy

NEVER create multiple migration files for the same table within the same module.

```
CORRECT - one create_table per table
Modules/User/database/migrations/
├── 2024_01_01_000001_create_users_table.php
├── 2024_01_01_000011_create_roles_table.php
└── 2024_06_15_143000_add_team_id_to_roles.php   # schema evolution OK

WRONG - multiple create_table for same table
├── 2023_01_01_000011_create_roles_table.php  # duplicate
├── 2023_01_01_000012_create_roles_table.php  # duplicate
└── 2024_01_01_000011_create_roles_table.php  # authoritative
```

When to create a new migration:
- New table → new migration file
- Schema change → new `add_column_to_table.php` migration
- Same table → NEVER create new `create_table` migration, modify existing

### XotBaseMigration benefits

- Auto-discovers model class and connection from namespace
- `tableCreate()` and `tableUpdate()` methods handle existing tables gracefully
- Built-in checks for column existence before modification

---

## Third-party model inheritance philosophy

When working with third-party packages that provide Eloquent models, extend those package models directly, NOT module BaseModel classes.

Rationale:
- Package functionality requires direct inheritance
- Automatic package updates and security patches
- Full compatibility with package features

See [laraxot-model-rules.md](laraxot-model-rules.md) for implementation details.

---

## Why these rules matter

1. **Autoloader clarity**: PHP autoloader cannot resolve duplicate files
2. **Maintenance simplicity**: one authoritative location per file type
3. **Predictable behavior**: consistent loading across environments
4. **DRY compliance**: eliminates redundant file locations
5. **Test discovery**: Pest/PHPUnit rely on consistent directory structures
