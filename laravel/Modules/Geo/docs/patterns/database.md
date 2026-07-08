# Database Patterns & Migrations

## 🏗️ Migration Standard

In Laraxot, migrations must follow a strict pattern to ensure idempotency, type safety, and automatic connection management.

### 1. File Structure
- Use `declare(strict_types=1);`.
- Use an anonymous class extending `XotBaseMigration`.
- Define `protected ?string $model_class` to link the migration to its Eloquent model.

### 2. Idempotency (Repeatability)
Migrations should be runnable multiple times without failing. 
- Use `$this->tableCreate()` instead of `Schema::create()`.
- Use `$this->tableUpdate()` instead of `Schema::table()`.
- **Always** check for column existence using `$this->hasColumn()` before adding or modifying columns.

### 3. Example Migration

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

return new class extends XotBaseMigration
{
    /**
     * Target Model Class.
     * This ensures the migration uses the correct database connection defined in the model.
     */
    protected ?string $model_class = IndennitaResponsabilita::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('calculated_data')) {
                    $table->json('calculated_data')->nullable()->after('updated_ip');
                }
            }
        );
    }
    
    /**
     * Reverse the migrations.
     * Overriding down() is important for additive migrations 
     * because the base class drops the table by default.
     */
    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('calculated_data')) {
                    $table->dropColumn('calculated_data');
                }
            }
        );
    }
};
```

### 4. Key Rules
- **Model Connection**: `XotBaseMigration` automatically reads the connection from the specified `$model_class`.
- **Schema Helper**: Use `$this->hasColumn('name')` inside the closure for safety.
- **Timestamps**: Use `$this->updateTimestamps($table)` to safely add `created_at`, `updated_at`, `created_by`, `updated_by`.

## 📌 Model Definition
Ensure the corresponding Model has the correct properties:
- `protected $connection`
- `protected $table`
- `protected $fillable`
- `protected function casts(): array`

### Cross-module inheritance (connection override)

When a domain module extends a model from another module (e.g. `Progressioni\Models\Scheda extends Ptv\Models\BaseScheda`), the parent `BaseModel` may declare a **different** connection (`ptv`). The consumer must override:

```php
protected $connection = 'progressione';
```

See [Progressioni database connection](../../laravel/Modules/Progressioni/docs/database-connection-progressione.md) and [Ptv scheda contract inheritance](../../laravel/Modules/Ptv/docs/wiki/concepts/scheda-contract-inheritance.md).
