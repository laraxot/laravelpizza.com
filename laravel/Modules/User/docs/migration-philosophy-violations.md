# Migration Philosophy Violations in User Module

## Overview
The User module has multiple migrations violating the Laraxot philosophy of "ONE migration per table". This document identifies the violations and provides a plan for resolution.

## Laraxot Migration Philosophy
In a module, for each table there must be only ONE migration responsible for its creation. Multiple migrations for the same table in the same module is a violation of Laraxot philosophy. Subsequent migrations should extend existing tables using tableUpdate() rather than recreating them with tableCreate(). Always use hasColumn(), hasTable(), hasIndex() for safe checks.

## Identified Violations

### 1. teams_table.php
- **Files**: 2023_01_01_000006_create_teams_table.php, 2023_01_01_000007_create_teams_table.php, 2025_05_16_221811_create_teams_table.php
- **Issue**: Multiple tableCreate() calls for the same table
- **Resolution**: Keep the most complete version (2025_05_16_221811_create_teams_table.php) and remove duplicates

### 2. roles_table.php
- **Files**: 2023_01_01_000011_create_role_has_permissions_table.php, 2023_01_01_000012_create_roles_table.php, 2024_01_01_000011_create_permission_role_table.php, 2024_01_01_000011_create_roles_table.php, 2025_09_18_000000_create_roles_table.php
- **Issue**: Multiple migrations creating roles table
- **Resolution**: Consolidate to one proper migration

### 3. permissions_table.php
- **Files**: 2023_01_22_000007_create_permissions_table.php, 2023_01_22_000008_create_permissions_table.php
- **Issue**: Two nearly identical migrations for permissions table

### 4. users_table.php
- **Files**: 2024_01_01_000002_create_users_table.php, 2024_01_01_000006_create_users_table.php
- **Issue**: Two migrations creating users table

### 5. authentication_log_table.php
- **Files**: 2024_01_01_000001_create_authentication_log_table.php, 2024_01_01_000002_create_authentication_log_table.php
- **Issue**: Duplicate migrations for authentication log

### 6. team_user_table.php
- **Files**: 2023_01_01_000004_create_team_user_table.php, 2023_01_01_000006_create_team_user_table.php, 2025_01_22_120000_create_team_user_table.php
- **Issue**: Three migrations creating the same table

### 7. device_user_table.php
- **Files**: 2023_01_01_000004_create_device_user_table.php, 2024_01_01_000004_create_device_user_table.php
- **Issue**: Two migrations creating same table

### 8. model_has_roles_table.php
- **Files**: 2024_12_05_000034_create_model_has_roles_table.php, 2024_12_05_000035_create_model_has_roles_table.php
- **Issue**: Duplicate migrations for model_has_roles

### 9. devices_table.php
- **Files**: 2023_01_01_000000_create_devices_table.php, 2023_01_01_000001_create_devices_table.php
- **Issue**: Two migrations creating devices table

## Resolution Strategy

### Phase 1: Identify Primary Migrations
For each table, identify the most complete and up-to-date migration that should serve as the single source of truth.

### Phase 2: Consolidate Schema Definitions
Move any unique schema elements from duplicate migrations into the primary migration using tableUpdate() method.

### Phase 3: Remove Duplicate Migrations
Delete the redundant migration files that violate the one-migration-per-table rule.

### Phase 4: Ensure Safe Updates
Use hasColumn(), hasTable(), hasIndex() checks to ensure updates don't conflict with existing schema.

## Proper Migration Pattern
```php
return new class extends XotBaseMigration {
    protected string $table_name = 'table_name';

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            // Initial schema definition
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Additions and modifications to existing schema
            if (! $this->hasColumn('new_column')) {
                $table->string('new_column')->nullable();
            }
        });
    }
};
```

## Benefits of Following Philosophy
- Reduces migration complexity and confusion
- Eliminates potential conflicts when running migrations
- Maintains single source of truth for table schemas
- Follows DRY principles
- Improves maintainability
