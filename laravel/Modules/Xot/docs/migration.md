# Laraxot Migration Architecture Philosophy

## Core Migration Principles

### The Single Source of Truth Principle

**🚨 FUNDAMENTAL RULE**: Each database table must have exactly **ONE** authoritative `create_table` migration within its module.

### Why This Architecture Matters

1. **<nome progetto>able Schema Evolution**: Clear, linear progression of database changes
2. **Environment Consistency**: Same migration order across all environments
3. **Maintainability**: Single file to modify for each table's base schema
4. **DRY Compliance**: Eliminates redundant schema definitions
5. **XotBaseMigration Integration**: Leverages auto-discovery and idempotent operations

### The XotBaseMigration Advantage

The `XotBaseMigration` class provides sophisticated migration capabilities:

#### Auto-Discovery Features

```php
// Automatically detects model class from migration name
public function getModelClass(): string
{
    // Extracts 'Role' from 'CreateRolesTable'
    // Resolves to: Modules\User\Models\Role
}
```

#### Idempotent Operations

```php
// Safe table creation - only creates if doesn't exist
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    $table->string('name');
});

// Safe table updates - only adds missing columns
$this->tableUpdate(function (Blueprint $table) {
    if (!$this->hasColumn('team_id')) {
        $table->foreignId('team_id')->nullable()->index();
    }
});
```

### Migration Types and Their Purpose

#### 1. Table Creation Migrations
- **Pattern**: `{timestamp}_create_{table}_table.php`
- **Purpose**: Define the base table schema
- **Rule**: Exactly ONE per table per module
- **Example**: `2024_01_01_000011_create_roles_table.php`

#### 2. Schema Evolution Migrations
- **Pattern**: `{timestamp}_{action}_{table}.php`
- **Purpose**: Modify existing table schema
- **Examples**:
  - `2024_06_15_add_email_to_users.php`
  - `2024_07_20_remove_old_column_from_posts.php`

#### 3. Data Migration Migrations
- **Pattern**: `{timestamp}_migrate_{purpose}.php`
- **Purpose**: Transform or seed data
- **Examples**:
  - `2024_08_10_migrate_user_roles.php`
  - `2024_09_15_seed_default_permissions.php`

### The Duplicate Migration Anti-Pattern

#### What NOT to Do

```
❌ WRONG - Multiple create_table migrations for same table
Modules/User/database/migrations/
├── 2023_01_01_000011_create_roles_table.php  # Duplicate
├── 2023_01_01_000012_create_roles_table.php  # Duplicate
└── 2024_01_01_000011_create_roles_table.php  # Authoritative
```

#### Why This Is Problematic

1. **Migration Order Ambiguity**: Which migration runs first?
2. **Schema Conflict Risk**: Different migrations may define different schemas
3. **Rollback Complexity**: Which migration should be rolled back?
4. **Development Confusion**: Which file is the source of truth?

### Correct Migration Strategy

#### Single Authoritative Migration

```
✅ CORRECT - One create_table migration per table
Modules/User/database/migrations/
├── 2024_01_01_000001_create_users_table.php
├── 2024_01_01_000011_create_roles_table.php      # Single authoritative
├── 2024_01_01_000021_create_permissions_table.php
└── 2024_06_15_143000_add_team_id_to_roles.php    # Schema evolution
```

#### Schema Evolution Approach

When you need to modify a table:

1. **NEVER** create a new `create_table` migration
2. **ALWAYS** create a schema evolution migration
3. **USE** `XotBaseMigration::tableUpdate()` for safe modifications

### XotBaseMigration Best Practices

#### 1. Leverage Auto-Discovery

```php
class CreateRolesTable extends XotBaseMigration
{
    public function up(): void
    {
        // Connection auto-discovered as 'user'
        // Model auto-discovered as Modules\User\Models\Role

        $this->tableCreate(function (Blueprint $table) {
            // Base schema definition
        });

        $this->tableUpdate(function (Blueprint $table) {
            // Safe schema evolution
        });
    }
}
```

#### 2. Use Idempotent Methods

```php
// ✅ CORRECT - Safe for multiple runs
$this->tableCreate(...);
$this->tableUpdate(...);

// ❌ WRONG - May fail on subsequent runs
Schema::create(...);
$table->addColumn(...);
```

#### 3. Handle Connection Auto-Discovery

```php
// Connection automatically determined from:
// Modules\User\Models\Role → 'user' connection
// No need to manually set $connection
```

### Migration Cleanup Protocol

When duplicate migrations are discovered:

1. **Identify Authoritative File**: Most complete/current schema definition
2. **Remove Duplicates**: Delete older `create_table` migrations
3. **Verify Dependencies**: Ensure no other migrations depend on duplicates
4. **Test Rollback**: Confirm clean rollback and re-migration
5. **Update Documentation**: Document the consolidation

### Module-Specific Implementation

Each module should:

1. Maintain exactly one `create_table` migration per table
2. Use `XotBaseMigration` for all migrations
3. Document migration dependencies in module README
4. Follow consistent naming conventions

### Exception Cases

**The ONLY exception** to the one-migration-per-table rule:

- **Module Splitting**: When a table moves to a different module
- **Major Refactoring**: Complete schema redesign requiring new table
- In both cases, the old migration should be removed after transition

---

**Philosophy Summary**: In Laraxot, migrations are the definitive history of your database schema. Keep that history clean, linear, and unambiguous. One table, one creation story.
