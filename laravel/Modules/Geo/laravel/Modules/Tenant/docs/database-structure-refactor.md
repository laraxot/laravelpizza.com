---
title: "Database Structure Refactor — Lowercase Folder Compliance"
type: refactor-log
date: 2026-07-01
updated: 2026-07-01
status: completed
tags: [database, folder-structure, naming-convention, cleanup]
---

# Database Structure Refactor — Tenant Module

**Date**: 2026-07-01  
**Status**: ✅ COMPLETED

---

## Changes Made

### Deleted Folders (Violations)

| Folder | Reason | Date Deleted | Files |
|--------|--------|--------------|-------|
| `database/Factories/` | CamelCase violation | 2026-07-01 | 3 files (DomainFactory, TenantFactory, TestSushiModelFactory) |
| `database/Factories_/` | OLD with underscore, stale since 2025-12-23 | 2026-07-01 | 1 file (DomainFactory.php) |
| `database/Seeders/` | CamelCase violation | 2026-07-01 | 2 files (DomainsSeeder, TestSushiSeeder) |

### Canonical Folders (Kept)

✅ **database/factories/** — Lowercase, contains 9 files (authoritative)  
✅ **database/seeders/** — Lowercase, contains 8 files (authoritative)  
✅ **database/migrations/** — Lowercase (unchanged)

---

## Rule Applied

**Database Folder Lowercase Rule**: All subdirectories inside `database/` must use lowercase naming (factories, seeders, migrations). No CamelCase, no underscores.

See: `bashscripts/ai/wiki/concepts/database-folder-lowercase-rule.md`

---

## Reason for Change

1. **Laravel Convention**: Framework uses lowercase in standard database paths
2. **PSR-4 Autoloading**: Class namespaces expect lowercase folders
3. **Consistency**: Module-level structure mirrors root-level convention
4. **Consolidation**: Removed duplicate/old versions, kept canonical lowercase versions

---

## Impact on Code

**NO BREAKING CHANGES**: All factories and seeders are still loaded via PSR-4 autoloading. The canonical folders (`factories/`, `seeders/`) contain the current, correct versions.

| Item | Old Namespace | New Namespace | Status |
|------|---------------|---------------|--------|
| Factories | `Modules\Tenant\Database\Factories\*` | `Modules\Tenant\Database\Factories\*` | ✅ Unchanged (folder path change only) |
| Seeders | `Modules\Tenant\Database\Seeders\*` | `Modules\Tenant\Database\Seeders\*` | ✅ Unchanged (folder path change only) |

---

## Verification

```bash
# All folders are now lowercase
ls -la laravel/Modules/Tenant/database/
# Expected output:
# factories/  seeders/  migrations/
```

---

## Next Steps

- Monitor for any runtime errors related to factory/seeder loading
- If issues arise, verify Laravel's factory/seeder registration in module config
- No manual migrations or seeders changes required

