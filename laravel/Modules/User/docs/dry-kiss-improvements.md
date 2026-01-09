# User Module - DRY + KISS Improvements

## Current State Analysis

### ✅ Strengths
- **XotBaseMigration**: Most migrations follow the pattern correctly
- **Documentation**: Comprehensive migration philosophy documentation
- **PHPStan Compliance**: Level 10 achieved
- **Good Practices**: Well-documented examples and patterns

### ❌ Issues Identified
- 100+ repetitive hasColumn() checks across migrations
- Some legacy migrations still use `Schema::create()`
- 10+ migrations extend `Migration` instead of `XotBaseMigration`
- Inconsistent helper method usage

## Specific Improvements Needed

### 1. Critical Migration Violations

**Files Requiring Immediate Fix**:
- `2024_03_27_000000_create_authentications_table.php`
- `2023_01_01_000008_create_tenants_table.php`
- `2014_10_12_200000_add_two_factor_columns_to_users_table.fortify`

**Pattern to Fix**:
```php
// ❌ CURRENT VIOLATION
return new class extends Migration {
    public function up(): void
    {
        Schema::create('authentications', function (Blueprint $table): void {
            // ...
        });
    }
};

// ✅ REQUIRED PATTERN
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

### 2. Repetitive hasColumn() Patterns

**Most Common Repetitions** (100+ instances):
```php
// Repeated pattern across migrations
if (!$this->hasColumn('first_name')) {
    $table->string('first_name')->nullable();
}
if (!$this->hasColumn('last_name')) {
    $table->string('last_name')->nullable();
}
if (!$this->hasColumn('is_active')) {
    $table->boolean('is_active')->default(true);
}
if (!$this->hasColumn('lang')) {
    $table->string('lang', 3)->nullable();
}
```

### 3. User-Specific Helper Opportunities

**Common User Fields**:
- Personal names (first_name, last_name)
- Profile fields (avatar, bio)
- Authentication fields (2FA, password expiry)
- Localization (lang, timezone)
- Status fields (is_active, is_verified)

## Proposed Improvements

### 1. Create UserMigrationHelpers Trait

```php
<?php

namespace Modules\User\Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

trait UserMigrationHelpers
{
    /**
     * Safely add column with existence check
     */
    protected function safeAddColumn(Blueprint $table, string $column, callable $definition): void
    {
        if (!$this->hasColumn($column)) {
            $definition($table);
        }
    }

    /**
     * Add standard user profile fields
     */
    protected function addUserProfileColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'first_name', fn($t) => $t->string()->nullable());
        $this->safeAddColumn($table, 'last_name', fn($t) => $t->string()->nullable());
        $this->safeAddColumn($table, 'avatar', fn($t) => $t->string()->nullable());
        $this->safeAddColumn($table, 'bio', fn($t) => $t->text()->nullable());
    }

    /**
     * Add user authentication fields
     */
    protected function addAuthColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'two_factor_secret', fn($t) => $t->string()->nullable());
        $this->safeAddColumn($table, 'two_factor_recovery_codes', fn($t) => $t->text()->nullable());
        $this->safeAddColumn($table, 'two_factor_confirmed_at', fn($t) => $t->timestamp()->nullable());
        $this->safeAddColumn($table, 'password_expires_at', fn($t) => $t->timestamp()->nullable());
    }

    /**
     * Add localization fields
     */
    protected function addLocalizationColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'lang', fn($t) => $t->string(3)->nullable());
        $this->safeAddColumn($table, 'timezone', fn($t) => $t->string()->nullable());
    }

    /**
     * Add status fields
     */
    protected function addStatusColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'is_active', fn($t) => $t->boolean()->default(true));
        $this->safeAddColumn($table, 'is_verified', fn($t) => $t->boolean()->default(false));
        $this->safeAddColumn($table, 'email_verified_at', fn($t) => $t->timestamp()->nullable());
    }

    /**
     * Add UUID support with backward compatibility
     */
    protected function addUuidSupport(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'uuid', fn($t) => $t->string(36)->nullable());

        // Handle existing integer IDs
        if ($this->hasColumn('id') && $this->getColumnType('id') === 'bigint') {
            $table->string('id', 36)->change();
        }
    }
}
```

### 2. Create UserBaseMigration Class

```php
<?php

namespace Modules\User\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Database\Migrations\Traits\UserMigrationHelpers;
use Modules\Xot\Database\Migrations\XotBaseMigration;

abstract class UserBaseMigration extends XotBaseMigration
{
    use UserMigrationHelpers;

    /**
     * Standard user table structure
     */
    protected function createStandardUserTable(Blueprint $table, array $additionalColumns = []): void
    {
        $table->id();

        // Add standard user columns
        $this->addUserProfileColumns($table);
        $this->addLocalizationColumns($table);
        $this->addStatusColumns($table);

        // Add additional columns
        foreach ($additionalColumns as $column => $definition) {
            $this->safeAddColumn($table, $column, $definition);
        }

        $this->addTimestampsWithUsers($table);
    }

    /**
     * Enhanced user table with authentication
     */
    protected function createAuthUserTable(Blueprint $table, array $additionalColumns = []): void
    {
        $this->createStandardUserTable($table, array_merge([
            'email' => fn($t) => $t->string()->unique(),
            'email_verified_at' => fn($t) => $t->timestamp()->nullable(),
        ], $additionalColumns));

        $this->addAuthColumns($table);
    }
}
```

### 3. Refactored Migration Examples

**Before (Current Pattern)**:
```php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            if (!$this->hasColumn('first_name')) {
                $table->string('first_name')->nullable();
            }
            if (!$this->hasColumn('last_name')) {
                $table->string('last_name')->nullable();
            }
            if (!$this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!$this->hasColumn('lang')) {
                $table->string('lang', 3)->nullable();
            }

            $table->timestamps();
        });
    }
};
```

**After (Improved Pattern)**:
```php
return new class extends UserBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $this->createStandardUserTable($table, [
                'name' => fn($t) => $t->string(),
                'email' => fn($t) => $t->string()->unique(),
                'email_verified_at' => fn($t) => $t->timestamp()->nullable(),
            ]);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Additional updates if needed
            $this->updateTimestamps($table);
        });
    }
};
```

### 4. Complex Example with Multiple Feature Sets

```php
return new class extends UserBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('username')->unique();

            // Basic profile
            $this->addUserProfileColumns($table);

            // Authentication
            $table->string('password');
            $this->addAuthColumns($table);

            // Localization and status
            $this->addLocalizationColumns($table);
            $this->addStatusColumns($table);

            // Additional fields
            $this->addUuidSupport($table);

            $this->addTimestampsWithUsers($table);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Update logic
        });
    }
};
```

## Implementation Strategy

### Phase 1: Critical Fixes (Week 1)
1. Fix all `extends Migration` violations
2. Replace remaining `Schema::create()` calls
3. Create UserMigrationHelpers trait

### Phase 2: Helper Implementation (Week 2)
1. Create UserBaseMigration class
2. Refactor 5-10 complex migrations as examples
3. Test helper methods

### Phase 3: Mass Refactoring (Week 3-4)
1. Update all migrations using helpers
2. Focus on migrations with most hasColumn() repetitions
3. Ensure consistent patterns

### Phase 4: Testing & Documentation (Week 5)
1. Run comprehensive migration tests
2. Update documentation
3. Create migration templates

## Success Metrics

### Before Improvements
- 100+ hasColumn() repetitions
- 10+ extends Migration violations
- Inconsistent patterns across migrations
- Code duplication in common user fields

### After Improvements
- <10 hasColumn() repetitions total
- 0 extends Migration violations
- Consistent patterns across all migrations
- 90% reduction in code duplication

## Benefits

1. **DRY Compliance**: Massive reduction in repetitive code
2. **KISS Principle**: Simpler, more readable migrations
3. **Maintainability**: Centralized field definitions
4. **Consistency**: All migrations follow same patterns
5. **Type Safety**: Better IDE support and refactoring
6. **Laraxot Compliance**: Full adherence to project philosophy

## Migration Conversion Checklist

For each migration file:
- [ ] Extends UserBaseMigration or XotBaseMigration
- [ ] Uses $this->tableCreate()
- [ ] Uses $this->tableUpdate()
- [ ] Replaces repetitive hasColumn() with helpers
- [ ] No Schema::create() calls
- [ ] Follows consistent field naming
- [ ] Passes PHPStan level 10

## Conclusion

The User module has good documentation and mostly follows XotBaseMigration patterns but suffers from extensive code duplication in field definitions. By implementing the proposed helper traits and base class, we can achieve dramatic DRY + KISS improvements while maintaining the high quality standards already in place. The modular approach allows for easy extension and maintenance of user-related migrations.
