---
title: "User Module Timestamps Rule"
type: rule
tags: [timestamps, dry-kiss, migration, user-module]
created: 2026-06-05
updated: 2026-06-05
qmd: "user module timestamps rule updateTimestamps"
related:
  - XOTBASEMIGRATION_TIMESTAMPS_RULE.md
  - ../wiki/rules/module-congruence-rule.md
---

# User Module Timestamps Rule

## Quick Reference

**Pattern canonico per migrazioni User:**

```php
// In User migrations, always do:
$this->updateTimestamps(table: $table, hasSoftDeletes: true|false);
```

Eliminare qualsiasi uso combinato di:
- `$table->timestamps()`
- `$table->softDeletes()`
- `$table->foreignIdFor($userClass, 'created_by')` (manuale)
- `$table->foreignIdFor($userClass, 'updated_by')` (manuale)
- `$table->foreignIdFor($userClass, 'deleted_by')` (manuale)

## Rationale

| Aspect | Reason |
|--------|--------|
| **DRY** | Centralize timestamp + audit column logic in `updateTimestamps()` only. |
| **Audit Trail** | `created_by`, `updated_by`, `deleted_by` must be foreign keys to User model (handled automatically). |
| **Safety** | Idempotent; safe on existing and new installations via `hasColumn()` guards. |

## Migration Files to Review

| File | Status | Note |
|------|--------|------|
| `2025_01_22_120001_create_team_permissions_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2026_01_01_000001_create_tenants_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2023_01_01_000003_create_socialite_user_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2025_10_15_153835_create_sso_providers_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2023_01_01_000005_create_model_has_permissions_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2024_01_01_000008_create_profile_team_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2023_01_01_000004_create_oauth_clients_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2023_01_01_000005_create_oauth_personal_access_clients_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2023_01_01_000004_create_team_user_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2026_03_01_000003_create_oauth_clients_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2024_01_01_000002_create_authentication_log_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2026_02_13_172136_create_users_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2026_01_12_114416_create_team_user_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2024_12_05_000034_create_model_has_roles_table.php` | ✅ Uses `updateTimestamps` | Confirmed correct |
| `2014_10_12_100002_create_password_resets_table.php` | ⚠️ Uses `$this->timestamps()` | **NEEDS REFACTOR** |

## Refactoring Checklist

- [ ] Replace `$this->timestamps($table)` with `$this->updateTimestamps(table: $table)` in `create_password_resets_table.php`.
- [ ] Verify all migration timestamps are idempotent (guard on `hasColumn`).
- [ ] Run `php artisan migrate --pretend` to validate syntax & schema.

## Enforcement

This rule is enforced via:

```yaml
# .phpmd/ruleset.xml
<rule ref="rules/strict/migration-timestamps-uses-update">
    <description>Ensures timestamps are handled by updateTimestamps only</description>
</rule>
```

---

*Rule authored by Claude (`claude-opus-4-8`), 2026-06-05*