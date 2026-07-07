# Boost Skill Installation - Solution Plan

**Date**: 2026-03-02  
**Status**: Ready for Implementation

## Executive Summary

The `boost:add-skill` command cannot execute because Laravel framework dependencies are missing from `composer.json`. Dependencies were moved to `_comment` sections, making them inactive.

## Problem Analysis

### Root Cause
The `laravel/composer.json` file has an unusual structure where:
- Production dependencies are in `require_comment` instead of `require`
- Development dependencies are in `require-dev_comment` instead of `require-dev`

This causes Composer to not install critical packages including:
- `laravel/framework: ^12.0` - Core Laravel framework
- `laravel/boost: ^1.0` - Required for `boost:add-skill` command
- All other Laravel ecosystem packages

### Why This Happened
This appears to be a deliberate configuration (possibly for development/testing purposes) that prevents full dependency installation. However, it breaks all Laravel functionality.

## Solution Strategy

### Phase 1: Restore composer.json (CRITICAL)
Move all dependencies from `_comment` sections to active sections:

**Before:**
```json
{
    "require": {
        "php": "^8.2",
        "nwidart/laravel-modules": "*"
    },
    "require_comment": {
        "laravel/framework": "^12.0",
        "filament/filament": "^5.0",
        ...
    }
}
```

**After:**
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "*",
        "filament/filament": "^5.0",
        "bacon/bacon-qr-code": "^3.0",
        "dotswan/filament-map-picker": "^2.0",
        "thecodingmachine/safe": "^3.3"
    },
    "require-dev": {
        "filament/upgrade": "^5.0",
        "laravel/boost": "^1.0",
        "friendsofphp/php-cs-fixer": "^3.88",
        "larastan/larastan": "^3.7",
        "laravel/pint": "^1.25",
        "pestphp/pest": "^3.8",
        ...
    }
}
```

### Phase 2: Install Dependencies
Run Composer to install all packages:
```bash
cd laravel
composer install
# OR if updating
composer update
```

### Phase 3: Verify Installation
Test Laravel is working:
```bash
php artisan --version
php artisan list
```

### Phase 4: Execute Original Command
Retry the boost skill installation:
```bash
php artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist
```

## Implementation Steps

1. **Backup current composer.json**
   ```bash
   cp laravel/composer.json laravel/composer.json.backup
   ```

2. **Restore dependencies in composer.json**
   - Remove `require_comment` and `require-dev_comment` sections
   - Add all commented dependencies to active sections

3. **Install dependencies**
   ```bash
   cd laravel
   composer install
   ```

4. **Verify Laravel works**
   ```bash
   php artisan --version
   ```

5. **Execute boost command**
   ```bash
   php artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist
   ```

## Documentation Updates

### Modules with Docs
The following modules have documentation folders that need updates:
- ✅ `/docs/` - Project root (completed)
- ⏳ `Modules/Xot/docs/` - Core module
- ⏳ `Modules/User/docs/` - User management
- ⏳ `Modules/AI/docs/` - AI integration
- ⏳ `Modules/Job/docs/` - Job system
- ⏳ `Modules/Media/docs/` - Media handling
- ⏳ `Modules/Notify/docs/` - Notifications
- ⏳ `Modules/Activity/docs/` - Activity tracking
- ⏳ `Modules/Seo/docs/` - SEO
- ⏳ `Modules/Fixcity/docs/` - Main app module
- ⏳ `Modules/Blog/docs/` - Blog
- ⏳ `Modules/Comment/docs/` - Comments
- ⏳ `Modules/Lang/docs/` - Language
- ⏳ `Modules/Rating/docs/` - Rating

### Documentation Structure
Each module's docs folder will receive:
1. `BOOST_SKILL_FIX_SUMMARY.md` - Summary of the fix
2. `DEPENDENCIES_MANAGEMENT.md` - Best practices for dependency management

## Risk Assessment

### Low Risk
- Restoring dependencies from comments is reversible
- Composer install is a standard operation
- No code changes required

### Medium Risk
- Large download of dependencies (first time only)
- Potential version conflicts (should be minimal with ^ version constraints)

### Mitigation
- Backup composer.json before changes
- Test in development environment first
- Version control allows rollback

## Success Criteria

1. ✅ composer.json has all dependencies in active sections
2. ✅ `composer install` completes without errors
3. ✅ `php artisan --version` returns Laravel 12.x
4. ✅ `boost:add-skill` command executes successfully
5. ✅ All module documentation updated

## Timeline Estimate

- Phase 1 (composer.json fix): 5 minutes
- Phase 2 (composer install): 10-30 minutes (depending on internet)
- Phase 3 (verification): 2 minutes
- Phase 4 (boost command): 2 minutes
- Documentation updates: 10 minutes

**Total**: ~30-50 minutes

## Dependencies

This solution requires:
- Internet connection (for Composer downloads)
- Sufficient disk space (~500MB for vendor/)
- PHP 8.2+ (already available)
- Composer (already available)

## Next Actions

1. ✅ Document issue (BOOST_SKILL_INSTALLATION_ERROR.md)
2. ✅ Create solution plan (this file)
3. ⏳ Update module documentation
4. ⏳ Implement composer.json fix
5. ⏳ Install dependencies
6. ⏳ Execute boost command
7. ⏳ Verify and validate