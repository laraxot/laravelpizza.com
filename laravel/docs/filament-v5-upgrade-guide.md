# Filament v5 Upgrade Guide

## Overview

Filament v5 was released on January 16, 2026. The main change is support for **Livewire v4**, which requires Laravel v11.28+ and PHP 8.2+.

**Key Changes:**
- Livewire v4.0+ integration
- Laravel v11.28+ requirement
- PHP 8.2+ requirement
- Tailwind CSS v4.0+ requirement

## 🔑 Critical Information

**Filament 5 = Filament 4 + Livewire 4**

- **NO functional breaking changes** between Filament 4 and 5
- **All Filament APIs remain compatible**
- **The only reason for upgrade is Livewire 4**
- **Upgrade is low risk**

### What DOESN'T Change

- **XotBaseResource**: Works without modifications
- **XotBasePages**: `XotBaseListRecords`, `XotBaseEditRecord`, etc. remain compatible
- **XotBaseWidgets**: All widget classes remain valid
- **XotBaseActions**: Actions, TableActions, BulkActions don't need changes
- **Schemas**: Form, Table, Infolist continue to work
- **Resources**: All existing patterns remain valid

### What Changes (Livewire 4 Only)

All changes are related to Livewire 4 migration:

1. **Livewire config** needs updates
2. **Livewire routing** needs updates
3. **wire:model behavior** needs verification (`.deep` modifier)
4. **Component tags** must be closed
5. **wire:transition** without modifiers
6. **JavaScript hooks** deprecated

## 📚 Complete Documentation

For complete and detailed documentation on all breaking changes and upgrade procedures, see:
**[Xot Module: Complete Guide](../Modules/Xot/docs/filament-5-livewire-4-complete-guide.md)**

## Prerequisites Check

### Current System Status
- **PHP Version**: 8.3.6 ✅ (Need 8.2+)
- **Laravel Version**: Need to check
- **Filament Version**: 4.6.3 ❌ (Need v5)
- **Livewire Version**: 3.7.6 ❌ (Need v4)
- **Tailwind CSS Version**: Need to check

## Prerequisites Check

### Current System Status
- **PHP Version**: 8.3.6 ❌ (Need 8.2+)
- **Laravel Version**: Need to check
- **Filament Version**: 4.x ❌ (Need v5)
- **Tailwind CSS Version**: Need to check

## Step-by-Step Upgrade Process

### Step 1: Pre-Upgrade Preparation

1. **Backup your project**
   ```bash
   cp -r /var/www/_bases/base_laravelpizza/laravel /var/www/_bases/base_laravelpizza_backup_$(date +%Y%m%d)
   ```

2. **Update composer to allow Filament v5**
   ```bash
   composer require filament/upgrade:"^5.0" -W --dev
   ```

3. **Check compatibility**
   - Review all plugins used in your project
   - Check if all plugins support v5

### Step 2: Run Upgrade Script

1. **Execute upgrade script**
   ```bash
   cd /var/www/_bases/base_laravelpizza/laravel
   vendor/bin/filament-v5
   ```

2. **Review output**
   - The script will output specific commands for your project
   - Follow all recommendations provided

3. **Apply specific commands**
   ```bash
   # Example commands (will vary based on script output):
   composer require filament/filament:"^5.0" -W --no-update
   composer update
   ```

### Step 3: Post-Upgrade Tasks

1. **Update Tailwind CSS configuration**
   - If you use custom Tailwind themes
   - Update `tailwind.config.js` to `tailwind.config.ts` for v4
   - Update Vite configuration to use `@tailwindcss/vite` plugin

2. **Run Livewire upgrade commands**
   ```bash
   # Check Livewire config updates needed
   php artisan livewire:publish --config
   
   # Clear caches
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Clean up and test**
   ```bash
   composer remove filament/upgrade --dev
   npm run build
   npm run dev
   ```

### Step 4: Module Updates

1. **Update namespace conflicts**
   - Fix any `use Filament\Actions\Action` conflicts
   - Update resource classes to use new base classes

2. **Update module documentation**
   - Add v5 upgrade notes to each module's `docs/` folder
   - Document any breaking changes specific to your modules

### Common Issues and Solutions

#### Issue: Namespace Conflicts
- **Problem**: `Cannot use Filament\Actions\Action as Action because the name is already in use`
- **Solution**: 
  ```php
  // Use alias imports
  use Filament\Actions\Action as BaseAction;
  use Filament\Actions\CreateAction as CreateAction;
  // Or remove conflicting use statements
  ```

#### Issue: Composer Dependencies Conflicts
- **Problem**: Package version conflicts between v4 and v5
- **Solution**: 
  ```bash
  composer update --no-write
  composer install
  ```

#### Issue: Tailwind CSS v4 Migration
- **Problem**: CSS build failures after Tailwind upgrade
- **Solution**: 
  1. Update import statements
  2. Use new CSS configuration format
  3. Clear Vite cache: `npm run clean --force`
  ```

## Verification Checklist

- [ ] Backup created
- [ ] Laravel version updated to v11.28+
- [ ] PHP version confirmed as 8.2+
- [ ] Filament v5 installed successfully
- [ ] Livewire v4 integrated
- [ ] Tailwind CSS v4 configured
- [ ] All modules functioning correctly
- [ ] Frontend assets compiled
- [ ] No critical errors in logs

## Rollback Plan

If issues arise:
1. Restore from backup: `cp -r /var/www/_bases/base_laravelpizza_backup_* /var/www/_bases/base_laravelpizza`
2. Revert composer changes: `git checkout HEAD~1` and restore composer.lock
3. Clear caches and rebuild

## Resources

- [Official upgrade guide](https://filamentphp.com/docs/5.x/upgrade-guide/)
- [Livewire v4 upgrade guide](https://livewire.laravel.com/docs/4.x/upgrading)
- [Tailwind CSS v4 guide](https://tailwindcss.com/docs/v4.0/upgrading)

## Support

For issues during upgrade:
1. Check [Filament Discord](https://discord.com/invite/filament)
2. Review [GitHub discussions](https://github.com/filamentphp/filament/discussions)
3. Check [Laravel news](https://laravel-news.com) for compatibility announcements

---

*