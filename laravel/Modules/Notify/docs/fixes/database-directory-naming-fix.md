---
title: "Database Directory Naming Convention Fix"
type: concept
tags: [database, directory, naming, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "database-directory-naming-fix database directory naming convention fix"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./critical-bug-sync-script-deleted.md"
  - "./database-naming-fix-summary.md"
  - "./database-naming-verification-report.md"
  - "./sqlite-permission-fix.md"
---

# Database Directory Naming Convention Fix

**Date**: 2026-03-13  
**Issue**: #4  
**Status**: Completed

## Summary

Fixed incorrect directory naming conventions across all Laravel modules to follow standard Laravel conventions (lowercase directory names).

## Problem

Multiple modules had incorrectly capitalized database directories:
- `database/Factories` ❌
- `database/Migrations` ❌
- `database/Seeders` ❌
- `Database/Migrations` ❌

**Correct naming** (Laravel standard):
- `database/factories` ✅
- `database/migrations` ✅
- `database/seeders` ✅

## Affected Modules

| Module | Old Path(s) | New Path(s) |
|--------|-------------|-------------|
| Blog | `database/Factories`, `database/Migrations`, `database/Seeders` | `database/factories`, `database/migrations`, `database/seeders` |
| Cms | `database/Factories`, `database/Migrations`, `database/Seeders` | `database/factories`, `database/migrations`, `database/seeders` |
| Comment | `database/Factories`, `database/Migrations`, `database/Seeders` | `database/factories`, `database/migrations`, `database/seeders` |
| Tenant | `database/Factories`, `database/Seeders` | `database/factories`, `database/seeders` |
| Lang | `database/Migrations` | `database/migrations` |
| User | `Database/Migrations` | `database/migrations` |
| Xot | `app/Database/Migrations` | `database/migrations` |

## Changes Made

### 1. File Migration
All PHP files were copied from incorrect directories to correct ones:
```bash
# Example for Blog module
database/Factories/*.php    → database/factories/
database/Migrations/*.php   → database/migrations/
database/Seeders/*.php      → database/seeders/
```

### 2. Directory Cleanup
Old incorrect directories were removed after file migration:
```bash
rm -rf database/Factories
rm -rf database/Migrations
rm -rf database/Seeders
```

### 3. Autoload Verification
All `composer.json` files already had correct lowercase paths:
```json
{
  "autoload": {
    "psr-4": {
      "Modules\\Blog\\Database\\Factories\\": "database/factories/",
      "Modules\\Blog\\Database\\Seeders\\": "database/seeders/"
    }
  }
}
```

## Why This Matters

### 1. Laravel Convention
Official Laravel documentation and framework use lowercase directory names:
- Laravel core: `database/factories`, `database/migrations`, `database/seeders`
- Package conventions follow the same pattern

### 2. PSR-4 Compliance
Consistent with PSR-4 autoloading standards where directory names typically use lowercase.

### 3. Case Sensitivity
Avoids issues on case-sensitive file systems (Linux, some macOS configurations):
- Git may track both `Factories` and `factories` as different directories
- Autoloaders expect consistent casing

### 4. Consistency
All modules now follow the same naming pattern, making the codebase more maintainable.

## Verification

### Check Current Structure
```bash
# Should return no results (no capitalized directories)
find laravel/Modules -type d -path "*/database/*" | grep -E "(Factories|Migrations|Seeders|Database)"

# Should show correct structure
find laravel/Modules -type d -path "*/database/*" | grep -E "(factories|migrations|seeders)"
```

### Test Autoload
```bash
cd laravel/Modules/Blog
composer dump-autoload
```

### Run Tests
```bash
php artisan test
```

## Documentation Updates

### Updated Files
- ✅ `AGENTS.md` - Already had correct naming
- ✅ `.windsurfrules` - No changes needed (didn't mention directory names)
- ✅ Skills - No skills referenced incorrect paths
- ✅ `composer.json` files - Already correct

### GitHub Artifacts
- ✅ Issue created: #4
- ✅ Discussion (not available via CLI)

## Related

- **GitHub Issue**: https://github.com/laraxot/base_fixcity_fila5/issues/4
- **GitHub Issue**: https://github.com/laraxot/platform/issues/4
- **Laravel Directory Structure**: https://laravel.com/docs/structure

## Checklist

- [x] Files moved from `Factories` to `factories`
- [x] Files moved from `Migrations` to `migrations`
- [x] Files moved from `Seeders` to `seeders`
- [x] Old directories removed
- [x] Composer autoload configurations verified
- [x] No references to old paths in documentation
- [x] GitHub issue created
- [x] Tests passing

## Notes

### Special Cases

#### User Module
Had `Database/Migrations` (capital D) instead of `database/Migrations`.
Fixed: All files moved to `database/migrations`.

#### Xot Module
Had `app/Database/Migrations` structure.
Fixed: All files moved to `database/migrations`.

#### Notify Module
Has `app/Factories` and `tests/Unit/Factories` - these are **action factories**, not database factories, so they remain unchanged.

## Performance Impact

None - this is a structural change only. No runtime impact.

## Backwards Compatibility

**Breaking Change**: If any custom code referenced the old capitalized paths directly, those references need to be updated.

Example fix:
```php
// WRONG (old)
require_once base_path('laravel/Modules/Blog/database/Factories/ArticleFactory.php');

// CORRECT (new)
require_once base_path('laravel/Modules/Blog/database/factories/ArticleFactory.php');
```

However, if using proper PSR-4 autoloading (which all modules do), no changes are needed.
