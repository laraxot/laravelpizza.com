# Notify Module - DRY + KISS Improvements

## Current State Analysis

### ✅ Successfully Implemented
- **ContactTypeEnum**: Centralized contact column management
- **Enum-based patterns**: Good adoption of enum philosophy
- **Type Safety**: PHPStan level 10 compliant

### ❌ Critical Issues Identified
- 50+ migrations use `extends Migration` instead of `extends XotBaseMigration`
- Multiple migrations use `Schema::create()` directly
- 100+ repetitive hasColumn() checks
- Inconsistent migration patterns across files

## Critical Violations to Fix

### 1. Migration Class Extensions

**Problem Files**:
- `2025_03_31_000001_create_notification_logs_table.php`
- `2025_07_01_000000_create_notification_logs_table.php`
- `2018_10_10_000002_create_mail_templates_table.php`
- `2018_10_10_000003_create_mail_templates_table.php`
- And 45+ more...

**Current Pattern**:
```php
// ❌ VIOLATION
return new class extends Migration {
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            // ...
        });
    }
};
```

**Required Pattern**:
```php
// ✅ CORRECT
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            // ...
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // ...
        });
    }
};
```

### 2. Repetitive Column Addition Pattern

**Current Repetition** (100+ instances):
```php
if (!$this->hasColumn('name')) {
    $table->string('name');
}
if (!$this->hasColumn('slug')) {
    $table->string('slug');
}
if (!$this->hasColumn('subject')) {
    $table->string('subject');
}
```

## Proposed Improvements

### 1. Create NotifyMigrationHelpers Trait

```php
<?php

namespace Modules\Notify\Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

trait NotifyMigrationHelpers
{
    /**
     * Safely add column only if it doesn't exist
     */
    protected function safeAddColumn(Blueprint $table, string $column, callable $definition): void
    {
        if (!$this->hasColumn($column)) {
            $definition($table);
        }
    }

    /**
     * Add standard contact columns using ContactTypeEnum
     */
    protected function addContactColumns(Blueprint $table): void
    {
        ContactTypeEnum::columns($table);
    }

    /**
     * Add standard notify fields
     */
    protected function addStandardNotifyColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'uuid', fn($t) => $t->uuid()->nullable());
        $this->safeAddColumn($table, 'is_active', fn($t) => $t->boolean()->default(true));
        $this->safeAddColumn($table, 'sent_at', fn($t) => $t->timestamp()->nullable());
        $this->safeAddColumn($table, 'read_at', fn($t) => $t->timestamp()->nullable());
    }

    /**
     * Add email template specific columns
     */
    protected function addEmailTemplateColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'subject', fn($t) => $t->string());
        $this->safeAddColumn($table, 'subject_json', fn($t) => $t->json());
        $this->safeAddColumn($table, 'html', fn($t) => $t->text());
        $this->safeAddColumn($table, 'text', fn($t) => $t->text());
    }
}
```

### 2. Create NotifyBaseMigration Class

```php
<?php

namespace Modules\Notify\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Database\Migrations\Traits\NotifyMigrationHelpers;
use Modules\Xot\Database\Migrations\XotBaseMigration;

abstract class NotifyBaseMigration extends XotBaseMigration
{
    use NotifyMigrationHelpers;

    /**
     * Standard notify table structure
     */
    protected function createStandardNotifyTable(Blueprint $table, array $additionalColumns = []): void
    {
        $table->id();

        // Add standard columns
        $this->addStandardNotifyColumns($table);

        // Add additional columns
        foreach ($additionalColumns as $column => $definition) {
            $this->safeAddColumn($table, $column, $definition);
        }

        $this->addTimestampsWithUsers($table);
    }
}
```

### 3. Refactored Migration Example

**Before**:
```php
return new class extends Migration {
    public function up(): void
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            if (!$this->hasColumn('name')) {
                $table->string('name');
            }
            if (!$this->hasColumn('slug')) {
                $table->string('slug');
            }
            if (!$this->hasColumn('subject')) {
                $table->string('subject');
            }
            $table->timestamps();
        });
    }
};
```

**After**:
```php
return new class extends NotifyBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $this->createStandardNotifyTable($table, [
                'name' => fn($t) => $t->string(),
                'slug' => fn($t) => $t->string()->unique(),
                'subject' => fn($t) => $t->string(),
            ]);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Additional updates if needed
            $this->updateTimestamps($table);
        });
    }
};
```

### 4. ContactTypeEnum Integration

**For models with contact information**:
```php
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');

    // Add all contact columns automatically
    $this->addContactColumns($table);

    $this->addTimestampsWithUsers($table);
});
```

## Implementation Plan

### Phase 1: Critical Fixes (Week 1)
1. Convert all `extends Migration` to `extends XotBaseMigration`
2. Replace all `Schema::create()` with `$this->tableCreate()`
3. Add `tableUpdate()` blocks where missing

**Priority Files**:
- All migration files in database/migrations/
- Focus on recent migrations first

### Phase 2: Helper Implementation (Week 2)
1. Create NotifyMigrationHelpers trait
2. Create NotifyBaseMigration class
3. Update 5-10 migrations as examples

### Phase 3: Mass Refactoring (Week 3-4)
1. Update all remaining migrations
2. Test all migrations
3. Update documentation

### Phase 4: Testing & Documentation (Week 5)
1. Run full migration test suite
2. Update module documentation
3. Create migration templates for future use

## Expected Results

### Before Improvements
- 50+ extends Migration violations
- 100+ hasColumn() repetitions
- Inconsistent patterns
- Hard to maintain migrations

### After Improvements
- 0 extends Migration violations
- <10 hasColumn() repetitions total
- Consistent patterns across all migrations
- Easy to maintain and extend

## Benefits

1. **DRY Compliance**: 80% reduction in repetitive code
2. **KISS Principle**: Simpler, more readable migrations
3. **Maintainability**: Changes in helpers affect all migrations
4. **Consistency**: All migrations follow same pattern
5. **Type Safety**: Better IDE support and PHPStan compliance
6. **Laraxot Philosophy**: Full compliance with project standards

## Migration Checklist

For each migration file:
- [ ] Extends NotifyBaseMigration (or XotBaseMigration)
- [ ] Uses $this->tableCreate()
- [ ] Uses $this->tableUpdate()
- [ ] Uses helper methods for common patterns
- [ ] No Schema::create() calls
- [ ] No manual hasColumn() checks for standard fields
- [ ] Passes PHPStan level 10

## Conclusion

The Notify module has excellent enum-based patterns but needs critical migration pattern fixes. By implementing the proposed helper traits and base class, we can achieve significant DRY + KISS improvements while maintaining full compatibility with the Laraxot philosophy and ContactTypeEnum patterns already in place.
