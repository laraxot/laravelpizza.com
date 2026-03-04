# Migration Patterns & Best Practices

**Project**: PTVX Fila5 Mono  
**Context**: Migration standards and patterns  
**Date**: [DATE]  
**Status**: Updated for all agents

---

## 📋 Migration Standards

### 1. XotBaseMigration Pattern

All project migrations must extend `XotBaseMigration`:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\YourModule\Models\YourModel;

return new class extends XotBaseMigration
{
    protected ?string $model_class = YourModel::class;

    public function up(): void
    {
        // -- UPDATE for existing tables --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Column additions/modifications
            }
        );
        
        // -- CREATE for new tables --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                // Other columns
            }
        );
    }

    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('column_name')) {
                    $table->dropColumn('column_name');
                }
            }
        );
    }
};
```

### 2. Schemaless Attributes Pattern

For dynamic data storage, use `schemalessAttributes()`:

```php
// ✅ CORRECT
$table->schemalessAttributes('extra_attributes');

// ❌ WRONG - Use schemalessAttributes instead
$table->json('extra_attributes');
```

### 3. Common Fields Pattern

Use built-in methods for common fields:

```php
public function up(): void
{
    $this->tableUpdate(
        function (Blueprint $table): void {
            // Your custom columns
            $table->string('custom_field')->nullable();
            
            // Add common fields (timestamps, user tracking)
            $this->updateTimestamps($table);
            $this->updateUser($table);
        }
    );
}
```

---

## 🔧 Available XotBaseMigration Methods

### Table Operations

```php
// Check if table exists
$tableExists = $this->tableExists('table_name');

// Check if column exists
$hasColumn = $this->hasColumn('column_name');

// Get column type
$type = $this->getColumnType('column_name');

// Check column type
$isJson = $this->isColumnType('column_name', 'json');
```

### Table Creation/Update

```php
// Create new table
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('title');
    // ...
});

// Update existing table
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('new_field')) {
        $table->string('new_field')->nullable();
    }
});
```

### Common Field Helpers

```php
// Add timestamp fields + user tracking
$this->updateTimestamps($table, $hasSoftDeletes = false);

// Add user fields + update model_id if needed
$this->updateUser($table);

// Add timestamps only (no user fields)
$this->updateTimestamps($table);

// Add user fields only
$this->updateUser($table);
```

---

## 📊 Column Types & Patterns

### Schemaless Attributes

```php
// ✅ For dynamic data storage
$table->schemalessAttributes('extra_attributes');

// Usage in model:
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

protected function casts(): array
{
    return [
        'extra_attributes' => SchemalessAttributes::class,
    ];
}
```

### Standard Columns

```php
// Basic types
$table->id();                                    // Primary key
$table->string('name', 255)->nullable();          // String with length
$table->text('description')->nullable();             // Long text
$table->integer('count')->nullable();               // Integer
$table->decimal('amount', 8, 2)->nullable();      // Decimal
$table->boolean('is_active')->default(false);       // Boolean
$table->date('start_date')->nullable();              // Date
$table->dateTime('created_at')->nullable();         // DateTime
$table->json('metadata')->nullable();               // JSON (use schemalessAttributes instead)

// Special types
$table->uuid('uuid')->nullable();                   // UUID
$table->foreignId('user_id')->nullable();           // Foreign key
```

### Indexes & Constraints

```php
// Add indexes
$table->string('slug')->nullable()->index();          // Simple index
$table->unsignedInteger('order_column')->nullable()->index(); // Integer index

// Foreign keys
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```

---

## 🎯 Migration File Naming

### Convention Pattern

```
{YYYY}_{MM}_{DD}_{HHMM}_{description}_{table}.php

Examples:
2025_01_01_000001_create_users_table.php
2026_02_10_140733_add_extra_attributes_to_posts_table.php
2026_02_11_091234_create_ratings_table.php
```

### Descriptive Names

- `create_*_table.php` - New tables
- `add_*_to_*_table.php` - Adding columns
- `update_*_table.php` - Modifying columns
- `drop_*_from_*_table.php` - Removing columns

---

## 📚 Documentation Requirements

### 1. PHPDoc Comments

```php
/**
 * Migration for adding extra_attributes to posts table.
 * Uses Schemaless Attributes pattern for dynamic data storage.
 * 
 * @see https://github.com/spatie/laravel-schemaless-attributes
 * @see /Modules/YourModule/docs/schemaless-attributes.md
 */
return new class extends XotBaseMigration
```

### 2. Inline Comments

```php
public function up(): void
{
    $this->tableUpdate(
        function (Blueprint $table): void {
            // ✅ CORRECT: Use schemalessAttributes
            $table->schemalessAttributes('extra_attributes');
            
            // Add user tracking
            $this->updateUser($table);
            
            // Add custom validation fields
            $table->string('validation_status')->nullable();
        }
    );
}
```

---

## ⚡ Performance Considerations

### 1. Use Schemaless Attributes Sparingly

```php
// ✅ GOOD: For truly dynamic data
$table->schemalessAttributes('extra_attributes');

// ❌ AVOID: For structured data
$table->json('structured_data');
// Better: Create proper columns instead
$table->string('field1')->nullable();
$table->integer('field2')->nullable();
```

### 2. Add Indexes Appropriately

```php
// Add indexes for frequently queried columns
$table->string('slug')->nullable()->index();

// Add composite indexes for complex queries
$table->index(['user_id', 'created_at']);
```

### 3. Use Proper Data Types

```php
// ✅ CORRECT: Use appropriate types
$table->decimal('price', 8, 2);  // Money
$table->boolean('is_active');          // Flags
$table->date('birth_date');           // Dates only

// ❌ AVOID: Using string for everything
$table->string('price');             // Should be decimal
$table->string('is_active');        // Should be boolean
```

---

## 🧪 Testing Migrations

### 1. Up/Down Testing

```php
// Test migration runs both ways
php artisan migrate --path=Modules/YourModule/database/migrations/2026_02_11_091234_test_migration.php

// Test rollback
php artisan migrate:rollback --step=1
```

### 2. Database Inspection

```php
// Check table structure after migration
php artisan tinker
> Schema::getColumnListing('table_name');
> \Schema::hasColumn('table_name', 'column_name');
```

---

## 🔍 Common Issues & Solutions

### Issue: Using Laravel Migration instead of XotBaseMigration

```php
// ❌ WRONG
use Illuminate\Database\Migrations\Migration;
return new class extends Migration

// ✅ CORRECT
use Modules\Xot\Database\Migrations\XotBaseMigration;
return new class extends XotBaseMigration
```

### Issue: Forgetting Schemaless Attributes

```php
// ❌ WRONG - Won't work with Spatie package
$table->json('extra_attributes');

// ✅ CORRECT - Uses proper Spatie integration
$table->schemalessAttributes('extra_attributes');
```

### Issue: Missing Common Fields

```php
// ❌ INCOMPLETE
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        $table->string('custom_field')->nullable();
    });
}

// ✅ COMPLETE
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        $table->string('custom_field')->nullable();
        $this->updateTimestamps($table);
        $this->updateUser($table);
    });
}
```

---

## ✅ Migration Checklist

Before creating a migration:

- [ ] Extend XotBaseMigration (not Laravel Migration)
- [ ] Set model_class property
- [ ] Use proper naming convention
- [ ] Add PHPDoc documentation
- [ ] Use schemalessAttributes() for dynamic data
- [ ] Add common fields with updateTimestamps/updateUser
- [ ] Include proper down() method
- [ ] Test both up and down
- [ ] Add relevant cross-references in docs

---

**Author**: Development Team  

**Status**: Updated with all project patterns  
**For**: All AI agents and developers