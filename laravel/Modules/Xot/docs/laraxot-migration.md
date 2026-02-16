# Laraxot Migration Philosophy - Core Principles

## The Fundamental Rule

**🚨 ONE TABLE, ONE MIGRATION, ONE MODULE**

In Laraxot architecture, we **NEVER** create multiple `create_table` migration files for the same table within the same module.

## Why This Philosophy Matters

### 1. **Single Source of Truth**
- Each table has exactly ONE authoritative schema definition
- No ambiguity about which migration defines the "real" table structure
- Clear, linear evolution of database schema

### 2. **Predictable Migration Order**
- No confusion about which migration runs first
- Consistent behavior across all environments (local, staging, production)
- Eliminates race conditions in migration execution

### 3. **Maintenance Simplicity**
- One file to modify for each table's base schema
- Easy to track schema changes over time
- No need to reconcile multiple conflicting definitions

### 4. **DRY Principle Compliance**
- Eliminates redundant schema definitions
- Reduces code duplication across the codebase
- Follows "Don't Repeat Yourself" philosophy

## The XotBaseMigration Advantage

Laraxot provides `XotBaseMigration` with powerful features:

### Auto-Discovery
```php
// Automatically detects:
// - Model class from migration name
// - Connection from module namespace
// - Table name from model
```

### Idempotent Operations
```php
// Safe table creation - only creates if doesn't exist
$this->tableCreate(...);

// Safe table updates - only adds missing columns
$this->tableUpdate(...);
```

## Correct vs Incorrect Patterns

### ✅ CORRECT
```
Modules/User/database/migrations/
├── 2024_01_01_000001_create_users_table.php
├── 2024_01_01_000011_create_roles_table.php      # Single authoritative
├── 2024_01_01_000021_create_permissions_table.php
└── 2024_06_15_143000_add_team_id_to_roles.php    # Schema evolution
```

### ❌ WRONG
```
Modules/User/database/migrations/
├── 2023_01_01_000011_create_roles_table.php  # Duplicate
├── 2023_01_01_000012_create_roles_table.php  # Duplicate
└── 2024_01_01_000011_create_roles_table.php  # Authoritative
```

## When to Create New Migrations

### ✅ CREATE NEW MIGRATION
- **New Table**: `create_{table}_table.php`
- **Schema Changes**: `add_{column}_to_{table}.php`
- **Data Migrations**: `migrate_{purpose}.php`

### ❌ NEVER CREATE NEW MIGRATION
- **Same Table**: Never create multiple `create_{table}_table.php` files
- **Minor Changes**: Use existing migration or create schema evolution migration

## Migration Types

### 1. Table Creation Migrations
- **Pattern**: `{timestamp}_create_{table}_table.php`
- **Purpose**: Define base table schema
- **Rule**: Exactly ONE per table per module

### 2. Schema Evolution Migrations
- **Pattern**: `{timestamp}_{action}_{table}.php`
- **Purpose**: Modify existing table schema
- **Examples**: `add_column`, `remove_column`, `change_column`

### 3. Data Migration Migrations
- **Pattern**: `{timestamp}_migrate_{purpose}.php`
- **Purpose**: Transform or seed data
- **Examples**: `migrate_user_roles`, `seed_default_permissions`

## Violation Consequences

### Immediate Issues
- **Database Inconsistency**: Different environments may have different schemas
- **Development Confusion**: Developers unsure which migration is authoritative
- **Deployment Risks**: Potential for migration conflicts during deployment

### Long-term Problems
- **Maintenance Overhead**: Multiple files to track and update
- **Technical Debt**: Accumulation of duplicate migrations
- **Debugging Complexity**: Hard to trace schema evolution history

## Cleanup Protocol

When duplicate migrations are discovered:

1. **Identify Authoritative File**: Most complete/current schema definition
2. **Remove Duplicates**: Delete older `create_table` migrations
3. **Verify Dependencies**: Ensure no other migrations depend on duplicates
4. **Test Rollback**: Confirm clean rollback and re-migration
5. **Update Documentation**: Document the consolidation

## Philosophical Foundation

### Laraxot Core Values
- **Simplicity**: One table, one migration, no exceptions
- **Clarity**: Clear, unambiguous schema definitions
- **Predictability**: Consistent migration behavior across environments
- **Maintainability**: Easy to understand and modify schema evolution

### Why This Matters
In Laraxot, migrations are the definitive history of your database schema. Keep that history clean, linear, and unambiguous. The database schema should tell a clear story of evolution, not a confusing tale of duplication and conflict.

---

**Remember**: In Laraxot philosophy, simplicity and clarity trump flexibility. One table, one migration, no exceptions.
