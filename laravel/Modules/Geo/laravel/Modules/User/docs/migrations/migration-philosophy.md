# Migration philosophy

This document captures the four critical architectural rules governing database migrations in Laraxot. These rules emerged from real production experience and must be followed without exception.

---

## Rule 1: One migration per table

### The philosophy

In Laraxot, every database table has exactly one migration file. That file describes the complete, authoritative schema for the table. When the schema needs to change (add columns, change types, add indexes), you find that single file, modify it, and update the date in the filename.

You never create a second migration for the same table.

### Why this rule exists

Multiple migrations for the same table create debt:

- You lose track of what the table actually looks like without reading every file
- Migration order becomes fragile across environments
- Rollbacks become impossible to reason about
- DRY is violated: the schema truth is scattered across multiple files

### Correct naming convention

```
YYYY_MM_DD_HHMMSS_create_{table}_table.php
```

Examples of correct names:

```
2026_03_12_143000_create_profiles_table.php
2026_03_12_143500_create_users_table.php
2024_01_01_000011_create_roles_table.php
```

### Forbidden naming patterns

These names indicate a violation. They should never exist:

```
# WRONG - describes a patch, not a canonical state
add_uuid_to_profiles_table.php
repair_profiles_id_and_uuid_contract.php
update_profiles_table.php
alter_profiles_add_columns.php
fix_profiles_missing_uuid.php
```

The word "repair", "add", "alter", "update", or "fix" in a migration name is a red flag. It means someone created a second migration instead of modifying the single authoritative one.

### How to modify a table schema

1. Find the single `create_{table}_table.php` for that table
2. Open it and add or modify the column definitions in the `tableUpdate` section
3. Change the date in the filename to today: `2026_03_12_HHMMSS_create_{table}_table.php`
4. If duplicate/patch migrations exist for this table: delete them from the filesystem AND remove their entries from the `migrations` database table
5. Run `php artisan migrate` (never `migrate:fresh`)

---

## Rule 2: The id + uuid contract

### The philosophy

Every Laraxot table must have two identifiers:

| Column | Type | Purpose |
|--------|------|---------|
| `id` | bigint unsigned AUTO_INCREMENT PRIMARY KEY | Internal database references, JOIN performance |
| `uuid` | char(36) nullable, indexed | External references, API, public URLs |

`id` is never exposed in API responses or public URLs. `uuid` is used for all external references.

### Why this rule exists

- `id` integer is fast for internal foreign key joins
- `uuid` prevents enumeration attacks in public APIs (you cannot guess the next record by incrementing an integer)
- `XotBaseModel::casts()` handles both automatically - you do not need to redeclare them

### Correct migration pattern

```php
Schema::create('profiles', function (Blueprint $table) {
    $table->id();                            // bigint unsigned auto_increment PK
    $table->uuid('uuid')->nullable()->index(); // external reference
    // ... other columns
});
```

### What is forbidden

```php
// WRONG - uuid as primary key breaks int FK efficiency
$table->uuid('id')->primary();

// WRONG - missing uuid entirely
$table->id();
// (no uuid column)
```

---

## Rule 3: Never destroy data

### The absolute rule

These commands are forbidden:

```bash
# ABSOLUTELY FORBIDDEN
php artisan migrate:fresh
php artisan migrate:rollback
php artisan migrate --force   # forbidden except in managed, explicit deploys
```

And in tests:

```php
// ABSOLUTELY FORBIDDEN in test files
use Illuminate\Foundation\Testing\RefreshDatabase;
```

### Why this rule exists

Real data is sacred. The `down()` method exists for documentation purposes only - it is never executed. `XotBaseMigration` is designed for additive, idempotent changes using `tableCreate()` (creates only if the table does not exist) and `tableUpdate()` (modifies idempotently without destroying existing data or rows).

Running `migrate:fresh` destroys the entire database and rebuilds from scratch. This is never acceptable.

### The safe migration pattern

`XotBaseMigration` provides two methods:

- `tableCreate()`: Creates the table only if it does not already exist. Safe to run multiple times.
- `tableUpdate()`: Modifies an existing table, adding missing columns without touching existing ones. Safe to run on a live database with real data.

```php
public function up(): void
{
    $this->tableCreate(function (Blueprint $table): void {
        $table->id();
        $table->uuid('uuid')->nullable()->index();
        // initial columns
    });

    $this->tableUpdate(function (Blueprint $table): void {
        // columns added in later revisions of this single file
        if (! Schema::hasColumn($this->tableName, 'some_new_column')) {
            $table->string('some_new_column')->nullable();
        }
    });
}
```

### What to do instead of migrate:fresh

To evolve a schema safely:

1. Modify the single `create_{table}_table.php` for the affected table
2. Add new columns inside `tableUpdate()` with existence checks
3. Update the date in the filename
4. Run `php artisan migrate`

---

## Rule 4: Semantic naming and single-file discipline

### The naming rule

Migration filenames must be:

- Format: `YYYY_MM_DD_HHMMSS_create_{table}_table.php`
- Lowercase snake_case for the table name
- The word `create` and the suffix `table` are mandatory
- No other words describing the change (no "add", "repair", "fix", "update", "alter")

### When a violation is discovered

If you find migrations like these for a table that already has a `create_` migration:

```
# These are violations - they must be removed
2024_06_15_143000_add_uuid_to_profiles_table.php
2025_01_10_090000_repair_profiles_id_and_uuid_contract.php
```

The procedure is:

1. Read both files and identify what columns they add
2. Open the single authoritative `create_profiles_table.php`
3. Add all missing columns to its `tableUpdate()` section with existence checks
4. Update the date in the filename to today
5. Delete the violation files from the filesystem
6. Delete their rows from the `migrations` database table
7. Run `php artisan migrate`

### Why "repair" in a filename is always wrong

A name like `repair_profiles_id_and_uuid_contract.php` signals:

1. Someone treated the migration as a patch rather than updating the canonical file
2. There are now two files describing the same table's schema
3. Future developers cannot determine the authoritative schema without reading both

---

## Summary table

| Rule | Pattern | Violation |
|------|---------|-----------|
| One file per table | `create_{table}_table.php` | Any second migration for the same table |
| Naming | `YYYY_MM_DD_HHMMSS_create_{table}_table.php` | add_, repair_, fix_, alter_, update_ prefixes |
| id+uuid contract | `$table->id()` + `$table->uuid('uuid')->nullable()->index()` | uuid as PK, missing uuid, missing id |
| Never destroy | `php artisan migrate` only | migrate:fresh, rollback, RefreshDatabase, --force |
