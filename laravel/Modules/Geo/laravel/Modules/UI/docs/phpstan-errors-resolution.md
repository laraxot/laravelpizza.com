# PHPStan Errors Resolution Guide — UI Module

**Date**: 2026-07-08  
**PHPStan Level**: 10  
**Status**: 2 errors identified, 1 actionable

## Error Summary

### 1. HasTableLayoutPage Trait — False Positive (Not Actionable)

**Error**: 
```
Trait Modules\UI\Filament\Traits\HasTableLayoutPage is used zero times and is not analysed.
🪪 trait.unused
```

**File**: `app/Filament/Traits/HasTableLayoutPage.php` (line 17)

**Analysis**:
- PHPStan limitation: trait usage detection across module boundaries doesn't work reliably
- HasTableLayoutPage is actually used by Xot module (confirmed via code review)
- This is a false positive known limitation in PHPStan trait analysis

**Resolution**: 
- **Do NOT delete or @phpstan-ignore** — trait is actively used
- This is a PHPStan analysis limitation, not a code issue
- Trait serves its intended purpose (page layout configuration)

**Related**: See [PHPStan Bootstrap Learnings](../../docs/wiki/phpstan/bootstrap-learnings.md) for trait analysis limitations.

---

### 2. Ignored Error Pattern — Configuration Issue

**Error**:
```
Ignored error pattern #Cannot cast mixed to (string|float|double|int|bool|boolean).# 
was not matched in reported errors.
```

**File**: Configuration in `phpstan.neon` (user-controlled)

**Analysis**:
- Rule configured in phpstan.neon that suppresses an error
- That specific error no longer appears in UI module
- phpstan.neon rule is now obsolete/unnecessary

**Resolution**:
- **Action**: User should remove obsolete suppression rule from phpstan.neon
- Command: Search for `Cannot cast mixed to` pattern in `laravel/phpstan.neon`
- Remove line if it's specific to UI module only
- If used by other modules, keep in place

---

## PHPStan Configuration Notes

### Current PHPStan.neon Settings
- **Level**: 10 (strictest)
- **Path**: `laravel/phpstan.neon` (immutable — only user can modify)
- **Bootstrap**: Uses larastan plugin for Laravel-specific analysis

### Trait Analysis Limitations
PHPStan has known limitations analyzing traits:
- Cannot reliably detect cross-module trait usage
- Marks traits as "unused" even when actively used
- Affects Xot module traits extensively

**Workaround**: Code review confirms actual usage; PHPStan error is false positive.

---

## Resolution Status

| Error | Type | Status | Action |
|-------|------|--------|--------|
| HasTableLayoutPage unused | False positive | ✅ Verified | No action — trait is used |
| Cast pattern ignored | Config issue | ⚠️ Pending | User reviews phpstan.neon |

---

## Cross-Module Dependencies

UI module has minimal direct PHPStan violations:
- InteractiveMap: Resolved via Geo module stubs
- Filament resources: All static methods correct
- Type hints: All parameters properly annotated

### Related Modules
- **Geo** (dependency): Map and geocoding services
- **Xot** (framework): Base resource table, trait definitions
- **Lang** (dependency): Localization support

---

## Next Steps

1. User reviews `laravel/phpstan.neon` for obsolete suppression rules
2. If rule is UI-specific, remove it
3. Re-run `./vendor/bin/phpstan analyse Modules/UI` to verify
4. Expected result: 1 error (trait.unused false positive) or 0 errors

---

**See Also**:
- `/docs/wiki/phpstan/bootstrap-learnings.md` — general PHPStan patterns
- `/Modules/UI/docs/geo-boundary.md` — geographic service integration
- Root `.gitignore` — build artifacts and cache files
