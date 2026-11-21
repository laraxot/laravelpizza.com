---
title: "migrations"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "migrations"
issues: []
discussions: []
---

# Media Module Migrations

## Overview

The Media module manages file storage, conversion, and temporary uploads. All migrations follow the `XotBaseMigration` pattern with explicit model-to-migration parity.

## Models and Migrations Parity

| Model | Migration File | Status | Purpose |
|-------|----------------|--------|---------|
| `Media` | `2022_01_01_000011_create_medias_table.php` | ✅ Active | Media file metadata and Spatie integration |
| `MediaConvert` | `2022_01_01_000000_create_media_converts_table.php` | ✅ Active | Conversion jobs and optimization metadata |
| `TemporaryUpload` | `2023_01_01_000000_create_temporary_uploads_table.php` | ✅ Active | Session-based temporary file uploads |

**Parity**: 3 models, 3 migrations (100% coverage).

## Migration Pattern: XotBaseMigration

All migrations in this module extend `XotBaseMigration` with an explicit `$model_class` property:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Media\Models\ModelName;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = ModelName::class;

    public function up(): void
    {
        // Create table
        $this->tableCreate(function (Blueprint $table): void {
            $table->id(); // or $table->uuid('id')->primary();
            $table->string('name');
        });

        // Add audit columns (created_at, updated_at, created_by, updated_by, deleted_at, deleted_by)
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, $softDeletes = false);
        });
    }
};
```

## Key Methods

| Method | Purpose |
|--------|---------|
| `$this->tableCreate($closure)` | Create table (idempotent, derives table name + connection from model) |
| `$this->tableUpdate($closure)` | Modify table (safe for retry, checks column existence before adding) |
| `$this->hasColumn($name)` | Check if column exists (use before adding) |
| `$this->updateTimestamps($table, $softDeletes = false)` | Add audit columns: `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at` (if soft deletes), `deleted_by` |
| `$this->getTable()` | Get table name (derived from model) |
| `$this->getConn()` | Get connection (derived from model) |

## Migration Lifecycle

### Adding a New Model

1. **Create model** in `app/Models/ModelName.php` extending `BaseModel` or `SpatieMedia`
2. **Create migration** with naming: `YYYY_MM_DD_HHMMSS_create_<table>_table.php`
3. **Set model class**: `protected ?string $model_class = ModelName::class;`
4. **Define schema** in `tableCreate()` closure
5. **Add audit columns** via `tableUpdate()` + `$this->updateTimestamps()`
6. **Verify**:
   ```bash
   phpstan analyse Modules/Media/database/migrations/ --level=10
   tools/phpmd.sh Modules/Media/database/migrations/
   ```
7. **Run migration**: `php artisan migrate`

### Modifying Existing Schema

For adding/altering columns after initial creation:

```php
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('new_column')) {
        $table->string('new_column')->nullable();
    }
    
    if ($this->hasColumn('old_column')) {
        $table->dropColumn('old_column');
    }
});
```

Always use `$this->hasColumn()` to ensure idempotency.

## Quality Checklist

Before committing a migration:

- [ ] Extends `XotBaseMigration` (not `Migration`)
- [ ] Has `protected ?string $model_class = ModelClass::class;`
- [ ] Uses `$this->tableCreate()` for creating tables
- [ ] Uses `$this->tableUpdate()` for modifying tables
- [ ] Column existence checks with `$this->hasColumn()` where needed
- [ ] Audit columns added via `$this->updateTimestamps()`
- [ ] No hard-coded table names or connection strings
- [ ] File naming: `YYYY_MM_DD_HHMMSS_create_<table>_table.php`
- [ ] PHPStan L10: `phpstan analyse Modules/Media/database/migrations/ --level=10`
- [ ] PHPMD: `tools/phpmd.sh Modules/Media/database/migrations/`

## Common Patterns

### Soft Deletes

If the model uses `SoftDeletes` trait:

```php
$this->tableUpdate(function (Blueprint $table): void {
    // Pass true for soft deletes
    $this->updateTimestamps($table, true); // Adds deleted_at, deleted_by
});
```

### UUID Primary Keys

For models using UUID instead of auto-increment:

```php
$this->tableCreate(function (Blueprint $table): void {
    $table->uuid('id')->primary();
    $table->string('name');
});
```

### Foreign Keys

```php
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
    $table->string('title');
});
```

## References

- **XotBaseMigration class**: `laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`
- **Pattern documentation**: `docs/wiki/patterns/migration-xot-base-pattern.md`
- **Naming standard**: `bashscripts/ai/.agents/rules/migration-naming-standard.md`
- **Migration standard**: `bashscripts/ai/.agents/rules/migration-xot-base-standard.md`

## Status

**Last Updated**: 2026-07-15  
**Compliance**: 100% (3/3 models have migrations)  
**PHPStan L10**: ✅ Pass
