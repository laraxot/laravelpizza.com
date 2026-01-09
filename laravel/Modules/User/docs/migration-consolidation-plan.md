# Migration Consolidation Plan - User Module

## Philosophy & Approach

Following the Laraxot philosophy: **ONE TABLE, ONE MIGRATION, ONE MODULE**

This plan will consolidate duplicate migrations while preserving data integrity and following DRY+KISS principles.

## Consolidation Strategy

### Phase 1: Critical Tables (High Impact)
1. **Users Table** - Core application functionality
2. **Tenants Table** - Multi-tenancy foundation
3. **Roles/Permissions Tables** - Authorization system

### Phase 2: Important Tables (Medium Impact)
3. **Teams Table** - Team management
4. **Authentication Log Table** - Security monitoring
5. **Devices Table** - Device management

### Phase 3: Support Tables (Low Impact)
6. Various OAuth, social, and auxiliary tables

## Detailed Consolidation Plan

### 1. Users Table Consolidation
**Duplicates:**
- `2024_01_01_000002_create_users_table.php` (3098 bytes)
- `2024_01_01_000006_create_users_table.php` (2976 bytes)

**Action:** Compare both files, keep the most complete schema, remove the duplicate.

### 2. Tenants Table Consolidation
**Duplicates:**
- `2023_01_01_000008_create_tenants_table.php` (864 bytes)
- `2023_01_01_000008_create_tenants_table.php.old` (1237 bytes)

**Action:** Keep the newer complete schema, remove .old file.

### 3. Teams Table Consolidation
**Duplicates:**
- `2023_01_01_000006_create_teams_table.php` (1709 bytes)
- `2023_01_01_000007_create_teams_table.php` (1594 bytes)
- `2025_05_16_221811_create_teams_table.php` (1686 bytes) + separate owner_id migration

**Action:** Keep the most recent with all fields, consolidate the add_owner_id migration.

### 4. Roles Table Consolidation
**Duplicates:**
- `2023_01_01_000011_create_roles_table.php` (967 bytes)
- `2023_01_01_000012_create_roles_table.php` (967 bytes)
- `2024_01_01_000011_create_roles_table.php` (967 bytes)
- `2025_09_18_000000_create_roles_table.php` (941 bytes)

**Action:** Keep the most complete schema, remove duplicates.

### 5. Permissions Table Consolidation
**Duplicates:**
- `2023_01_22_000007_create_permissions_table.php` (1867 bytes)
- `2023_01_22_000008_create_permissions_table.php` (928 bytes)

**Action:** Keep the complete schema, remove duplicate.

### 6. Team User Table Consolidation
**Duplicates:**
- `2023_01_01_000004_create_team_user_table.php` (1126 bytes)
- `2023_01_01_000006_create_team_user_table.php` (998 bytes)
- `2025_01_22_120000_create_team_user_table.php` (3276 bytes)

**Action:** Keep the most complete schema with all required fields.

### 7. Authentication Log Table Consolidation
**Duplicates:**
- `2024_01_01_000001_create_authentication_log_table.php` (1177 bytes)
- `2024_01_01_000002_create_authentication_log_table.php` (1177 bytes)

**Action:** Both are identical size, compare content and keep one.

### 8. Device Tables Consolidation
**Devices Table:**
- `2023_01_01_000000_create_devices_table.php` (1477 bytes)
- `2023_01_01_000001_create_devices_table.php` (1477 bytes)

**Device User Table:**
- `2023_01_01_000005_create_device_user_table.php` (1585 bytes)
- `2024_01_01_000004_create_device_user_table.php` (1585 bytes)

**Action:** Compare and keep most complete schemas.

### 9. Model Has Roles Table Consolidation
**Duplicates:**
- `2024_12_05_000034_create_model_has_roles_table.php` (1341 bytes)
- `2024_12_05_000035_create_model_has_roles_table.php` (1341 bytes)

**Action:** Remove duplicate.

## Implementation Steps

### Step 1: Content Analysis
1. Compare each set of duplicate files
2. Identify which file has the complete schema
3. Document any differences between files

### Step 2: Migration File Cleanup
1. Remove duplicate migration files
2. Ensure no dependencies on removed files
3. Test migration status to confirm integrity

### Step 3: Schema Verification
1. Verify that the remaining migration creates the correct table structure
2. Check that all expected columns exist
3. Ensure foreign key relationships are maintained

### Step 4: Testing
1. Test migration rollback and re-migration
2. Verify existing data remains intact
3. Confirm application functionality is preserved

## DRY+KISS Implementation Notes

### DRY (Don't Repeat Yourself)
- Remove redundant migration definitions
- Maintain single source of truth for each table schema
- Eliminate duplicate schema definitions

### KISS (Keep It Simple, Stupid)
- Simple, clear migration files
- One table, one creation migration
- Straightforward schema evolution through update migrations

## Risk Mitigation

### Pre-Migration Checks
1. Backup database before changes
2. Verify migration status before cleanup
3. Test in development environment first

### Post-Migration Validation
1. Confirm all tables exist with correct schema
2. Verify application functionality
3. Test fresh installation from scratch

## Success Criteria

### ✅ Completed
- [ ] All duplicate table creation migrations removed
- [ ] One authoritative migration per table maintained
- [ ] Data integrity preserved
- [ ] Application functionality confirmed
- [ ] Fresh installation tested

### ✅ Compliance
- [ ] 100% compliance with "ONE TABLE, ONE MIGRATION" rule
- [ ] No remaining duplicate creation migrations
- [ ] Proper schema evolution through update migrations

## Philosophical Alignment

This consolidation plan aligns with Laraxot philosophy:
- ✅ Single source of truth for each table
- ✅ Predictable migration order
- ✅ DRY principle compliance
- ✅ Maintained simplicity
- ✅ Clear schema definition

The plan ensures that every table in the User module will have exactly one authoritative creation migration, supporting the fundamental Laraxot principle: **ONE TABLE, ONE MIGRATION, ONE MODULE**.
