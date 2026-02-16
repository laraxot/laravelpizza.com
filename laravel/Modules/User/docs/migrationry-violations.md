# User Module Migration Policy - DRY Violations Report

## Issue Summary
The User module contains multiple migration violations of the Laraxot philosophy:
- Multiple migrations creating the same table (violates "ONE migration per table" rule)
- DRY principle violations with duplicate table structure definitions

## Affected Tables
The following tables have multiple creation migrations in `/Modules/User/database/migrations/`:

### 1. teams_table
- 2023_01_01_000006_create_teams_table.php
- 2023_01_01_000007_create_teams_table.php
- 2025_05_16_221811_create_teams_table.php
- 2025_05_16_221811_add_owner_id_to_teams_table.php

### 2. roles_table
- 2023_01_01_000011_create_role_has_permissions_table.php
- 2023_01_01_000012_create_roles_table.php
- 2024_01_01_000011_create_permission_role_table.php
- 2024_01_01_000011_create_roles_table.php
- 2025_09_18_000000_create_roles_table.php

### 3. permissions_table
- 2023_01_22_000007_create_permissions_table.php
- 2023_01_22_000008_create_permissions_table.php

### 4. users_table
- 2024_01_01_000002_create_users_table.php
- 2024_01_01_000006_create_users_table.php

### 5. authentication_log_table
- 2024_01_01_000001_create_authentication_log_table.php
- 2024_01_01_000002_create_authentication_log_table.php

### 6. team_user_table
- 2023_01_01_000004_create_team_user_table.php
- 2023_01_01_000006_create_team_user_table.php
- 2025_01_22_120000_create_team_user_table.php

### 7. device_user_table
- 2023_01_01_000004_create_device_user_table.php
- 2024_01_01_000004_create_device_user_table.php

### 8. model_has_roles_table
- 2024_12_05_000034_create_model_has_roles_table.php
- 2024_12_05_000035_create_model_has_roles_table.php

### 9. devices_table
- 2023_01_01_000000_create_devices_table.php
- 2023_01_01_000001_create_devices_table.php

## Corrective Actions Required
1. Keep ONE migration per table for creation (preferably the most recent/complete one)
2. Convert duplicate creation migrations to update migrations using `tableUpdate()` method
3. Use `hasColumn()`, `hasTable()`, `hasIndex()` checks for safe operations
4. Follow the pattern shown in `2025_05_16_221811_add_owner_id_to_teams_table.php`

## Laraxot Migration Philosophy
- ONE migration per table for creation
- Use `XotBaseMigration::tableCreate()` for initial table creation
- Use `XotBaseMigration::tableUpdate()` for subsequent schema changes
- Use standard Migration with `hasColumn()` checks for specific column additions
- Always check for existence before creating/modifying
