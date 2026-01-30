# Migration Patterns for Lang Module

## Overview

This document outlines the correct migration patterns to follow when creating database migrations for the Lang module and all other modules in the TechPlanner project.

## Critical Rule: Use XotBaseMigration

**ALL module migrations MUST extend `XotBaseMigration` instead of the standard Laravel `Migration` class.**

### Correct Pattern

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Translation::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('group')->index()->comment('Translation group');
                $table->string('key')->comment('Translation key');
                $table->json('text')->comment('Translation text in JSON format');
                $table->string('locale')->index()->comment('Language locale');
                $table->unique(['group', 'key', 'locale'], 'language_lines_unique');
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table, true);
            }
        );
    }
};
```

### Key Components

1. **Extend XotBaseMigration**: Always use `XotBaseMigration` instead of Laravel's `Migration`
2. **Model Class Reference**: Set `$model_class` property to reference the corresponding model
3. **tableCreate Method**: Use `$this->tableCreate()` for creating table structure
4. **tableUpdate Method**: Use `$this->tableUpdate()` for adding timestamps and other updates
5. **updateTimestamps**: Use `$this->updateTimestamps($table, true)` to add standard timestamp fields

### Benefits of XotBaseMigration

- **Consistent Structure**: Ensures all migrations follow the same pattern
- **Automatic Timestamps**: Handles created_at, updated_at, created_by, updated_by fields
- **Soft Deletes Support**: Automatically adds deleted_at and deleted_by when needed
- **Connection Management**: Proper database connection handling
- **Model Integration**: Seamless integration with Eloquent models

### Incorrect Pattern (DO NOT USE)

```php
// ❌ WRONG - Do not use standard Laravel Migration
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table): void {
            // Direct schema creation
        });
    }
}
```

## Migration Naming Convention

- Follow Laravel's standard naming: `YYYY_MM_DD_HHMMSS_create_table_name_table.php`
- Use descriptive table names that match the model
- Ensure chronological ordering with proper timestamps

## Documentation Updates

This migration pattern has been applied to:
- ✅ `2025_03_20_000001_create_language_lines_table.php` - Corrected to use XotBaseMigration

## Related Documentation

- See other module migrations for additional examples
- Refer to XotBaseMigration class for available methods
- Check module-specific model classes for proper references
