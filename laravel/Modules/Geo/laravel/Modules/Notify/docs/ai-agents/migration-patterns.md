# Migration patterns

> Source: [AGENT_MEMORY.md](../../AGENT_MEMORY.md) | [IFLOW.md](../../bashscripts/ai/IFLOW.md)
> Back: [index](index.md) | [laraxot-philosophy.md](laraxot-philosophy.md)

## XotBaseMigration standard

All migrations MUST extend `XotBaseMigration`:

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\ModuleName\Models\ModelName;

return new class extends XotBaseMigration
{
    protected ?string $model_class = ModelName::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // Use schemalessAttributes for dynamic data
            $table->schemalessAttributes('extra_attributes');

            // Add common fields
            $this->updateTimestamps($table);
            $this->updateUser($table);
        });
    }
};
```

## NEVER extend Migration directly

```php
// WRONG
use Illuminate\Database\Migrations\Migration;

// CORRECT
use Modules\Xot\Database\Migrations\XotBaseMigration;
```

## Schemaless vs JSON

For dynamic/flexible data, use `schemalessAttributes()` not `json()`:

```php
// CORRECT
$table->schemalessAttributes('extra_attributes');

// WRONG
$table->json('extra_attributes');
```

## Common fields pattern

```php
// Adds timestamps + created_by, updated_by
$this->updateTimestamps($table);

// Adds user tracking fields
$this->updateUser($table);
```

## Create vs update migrations

```php
// CREATE (new table)
public function up(): void
{
    $this->tableCreate(function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $this->updateTimestamps($table);
    });
}

// UPDATE (add column to existing table)
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        $table->string('new_field')->nullable();
        $this->updateTimestamps($table);
    });
}
```

## One migration per table (CRITICAL)

NEVER create multiple `create_table` migrations for the same table. For schema changes, create a new `add_column_to_table.php` migration.

See [laraxot-philosophy.md](laraxot-philosophy.md) for the full philosophy.

## Migration folder naming (CRITICAL)

The migrations folder MUST be **lowercase**: `database/migrations/`

```
Modules/{ModuleName}/database/
├── factories/     ← minuscolo
├── migrations/    ← CORRETTO (minuscolo)
└── seeders/       ← minuscolo
```

**WRONG**: `database/Migrations/` (maiuscola) — Linux filesystem is case-sensitive!
- Both `Migrations/` and `migrations/` can coexist silently
- Laravel/nwidart loads ONLY `database/migrations/` (lowercase)
- Files in `database/Migrations/` (uppercase) are **silently ignored**
- Always verify with `ls -la database/` before placing migration files

Issue: https://github.com/provtv/base_ptv_fila5_mono/issues/71

## Cross-module impact

When modifying migrations, always consider impact on other modules:
- Xot changes affect ALL modules
- Rating changes affect Performance, Progressioni
- Schemaless patterns must be consistent across modules
