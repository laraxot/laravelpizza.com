# Laraxot Migration Philosophy - Single Source of Truth

## The Sacred Rule

**ONE MIGRATION PER TABLE. NEVER CREATE REPAIR/FIX/ADD/ALTER MIGRATIONS.**

## The Philosophy

### Why This Exists

1. **Single Source of Truth**: Each table has ONE authoritative migration file
2. **No Confusion**: No guessing which file defines the current schema
3. **Idempotent Evolution**: `tableCreate()` + `tableUpdate()` handle both new and existing installations
4. **DRY/KISS**: One file to read, one file to modify, one file to understand

### The Pattern

```
✅ CORRECT - Single migration file
Modules/User/database/migrations/
└── 2026_03_12_170000_create_profiles_table.php  # THE ONLY FILE

❌ WRONG - Multiple migration files for same table
Modules/User/database/migrations/
├── 2024_01_01_000000_create_profiles_table.php
├── 2024_06_15_143000_add_uuid_to_profiles.php      # FORBIDDEN
├── 2025_01_20_093000_repair_profiles_id.php       # FORBIDDEN
└── 2026_03_12_162500_fix_profiles_contract.php    # FORBIDDEN
```

## How to Evolve Schema

### Step 1: Find the EXISTING migration
```bash
find Modules -name "*create_{table}_table.php"
```

### Step 2: Modify the existing file
- Add new columns to `tableCreate()` section
- Add same columns to `tableUpdate()` with `if (! $this->hasColumn('column'))` guard

### Step 3: Update the timestamp in filename
```bash
# Old: 2026_03_12_170000_create_profiles_table.php
# New: 2026_03_12_171000_create_profiles_table.php  (updated time)
```

### Step 4: Run migration
```bash
php artisan migrate --path=Modules/User/database/migrations/2026_03_12_171000_create_profiles_table.php
```

## XotBaseMigration Structure

```php
return new class extends XotBaseMigration {
    protected ?string $model_class = Profile::class;

    public function up(): void
    {
        // -- CREATE (new installations) --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('uuid', 36)->index()->nullable();
            // ... all columns
        });

        // -- UPDATE (existing installations: additive, idempotent) --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('new_column')) {
                $table->string('new_column')->nullable();
            }
        });
    }
};
```

## Forbidden Patterns

| Pattern | Reason | Correct Approach |
|---------|--------|------------------|
| `add_*_to_table.php` | Violates single source | Modify existing `create_table.php` |
| `fix_*_table.php` | Violates single source | Modify existing `create_table.php` |
| `repair_*_table.php` | Violates single source | Modify existing `create_table.php` |
| `alter_*_table.php` | Violates single source | Modify existing `create_table.php` |
| Multiple `create_*_table.php` | Confusion | Keep only ONE, delete duplicates |

## The ID+UUID Contract

Every table MUST have:
- `id` - bigint unsigned AUTO_INCREMENT PRIMARY KEY (internal DB reference)
- `uuid` - char(36) nullable indexed (external/public reference)

The `id` is NEVER exposed in APIs or URLs; `uuid` is used for all external references.

## Current Issue: profiles table missing uuid

**Problem**: `profiles` table exists without `uuid` column
**WRONG Solution**: Create `2026_03_12_162500_repair_profiles_id_and_uuid_contract.php`
**CORRECT Solution**: 
1. The existing migration `2026_03_12_170000_create_profiles_table.php` ALREADY has uuid logic
2. Update timestamp to `2026_03_12_171000_create_profiles_table.php`
3. Run migration

## Forbidden Commands - DATA DESTRUCTION

**NEVER USE THESE COMMANDS - THEY DESTROY DATA:**

| Command | Why Forbidden |
|---------|---------------|
| `php artisan migrate:fresh` | Drops ALL tables, loses ALL data |
| `php artisan migrate --force` | Forces migrations in production, dangerous |
| `php artisan migrate:refresh` | Rolls back ALL migrations, loses ALL data |
| `RefreshDatabase` trait in tests | Only for isolated test databases |

### Why These Are Forbidden

1. **Production Data Loss**: These commands destroy real user data
2. **Irreversible**: No rollback possible after fresh/refresh
3. **Violates Trust**: Users expect their data to persist
4. **Breaks Multi-tenant**: Other tenants' data destroyed

### The Correct Approach

Migrations must be:
- **Additive**: Only add columns/tables, never remove
- **Idempotent**: Safe to run multiple times via `hasColumn()` checks
- **Non-destructive**: Preserve existing data at all costs

```php
// ✅ CORRECT - Idempotent, non-destructive
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('new_field')) {
        $table->string('new_field')->nullable();
    }
});

// ❌ WRONG - Destructive
Schema::dropIfExists('profiles');  // NEVER DO THIS
$table->dropColumn('old_field');   // NEVER DO THIS
```

### If You Need to Run Migrations

```bash
# ✅ CORRECT - Safe, additive only
php artisan migrate

# ✅ CORRECT - Specific migration file
php artisan migrate --path=Modules/User/database/migrations/2026_03_12_171000_create_profiles_table.php
```

## Update History

- 2026-03-12: Added forbidden commands section after user correction
- 2026-03-12: Documented after user correction on migration naming
