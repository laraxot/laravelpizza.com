# Filament v3 to v4 Upgrade Guide

## Overview

This document outlines the upgrade process from Filament v3 to v4 for the PTV Laravel project. This upgrade brings significant improvements including better performance, enhanced developer experience, and new features.

## Prerequisites

Before starting the upgrade, ensure the following requirements are met:

### System Requirements
- **PHP**: 8.2+ (currently using 8.4.10 ✓)
- **Laravel**: v11.28+ (currently using v11 ✓)
- **Tailwind CSS**: v4.0+ (currently using v3 - NEEDS UPGRADE)

## Breaking Changes Summary

### 1. Namespace Changes
- All Filament classes maintain their v3 namespaces
- Panel configuration remains in same location

### 2. Component Changes
- Form component properties may need adjustment
- Table column methods updated
- Action configurations enhanced

### 3. Panel Configuration
- Plugin system updated
- Theme customization improved
- Navigation enhancements

### 4. Resource Changes
- Page generation updated
- Relationship handling improved
- Bulk actions enhanced

## Upgrade Steps

### Phase 1: Dependencies Update
```bash
# Update Filament to v4
composer require "filament/filament:^4.0" --with-all-dependencies

# Update Tailwind CSS
npm install tailwindcss@^4.0

# Clear caches
php artisan optimize:clear
php artisan view:clear
```

### Phase 2: Configuration Updates

#### Panel Providers
- Check `app/Providers/Filament/AdminPanelProvider.php`
- Update plugin configurations
- Verify theme settings

#### Resource Updates
- Review all Resource classes in `app/Filament/Resources/`
- Update form schemas
- Update table schemas
- Check page classes

### Phase 3: Module-Specific Updates

#### Core Modules Requiring Updates
1. **Gdpr Module** - Complex Filament resources
2. **Setting Module** - Database management interfaces
3. **Ptv Module** - CriteriEsclusione resources
4. **Progressioni Module** - Extended Ptv functionality
5. **User Module** - Authentication interfaces

#### For Each Module:
1. Update Filament Resources in `app/Filament/Resources/`
2. Update Pages in `Resources/[Resource]/Pages/`
3. Check custom Actions
4. Verify Widgets
5. Test Forms and Tables

### Phase 4: Testing and Validation

#### Pre-upgrade Testing
- Run existing test suites
- Document current functionality
- Create test scenarios

#### Post-upgrade Testing
- Test all Filament panels
- Verify CRUD operations
- Check relationship handling
- Test custom actions
- Validate form submissions

### Phase 5: PHPStan Compliance

After upgrade completion:
```bash
./vendor/bin/phpstan analyse Modules
```

All errors must be resolved without modifying `phpstan.neon`.

## Common Issues and Solutions

### 1. Form Component Updates
**Issue**: Form fields not rendering correctly
**Solution**: Update component methods and properties

### 2. Table Column Changes
**Issue**: Table columns missing or incorrectly formatted
**Solution**: Review column definitions and update methods

### 3. Action Configuration
**Issue**: Actions not working as expected
**Solution**: Update action configurations and modal handling

### 4. Navigation Issues
**Issue**: Panel navigation not displaying correctly
**Solution**: Check navigation configuration in panel providers

## Module-Specific Considerations

### Gdpr Module
- Complex consent management forms
- Privacy-sensitive data handling
- Multi-language support

### Setting Module
- Database connection management
- System configuration interfaces
- Backup functionality

### Ptv Module
- CriteriEsclusione business logic
- Complex relationship handling
- Performance-critical operations

### Progressioni Module
- Extended Ptv functionality
- Contract implementations
- Database-specific connections

## Rollback Plan

In case issues arise:

1. **Immediate Rollback**:
   ```bash
   git checkout [previous-stable-commit]
   composer install
   npm install
   ```

2. **Selective Rollback**:
   - Restore specific module configurations
   - Revert problematic changes only
   - Maintain working functionality

## Success Criteria

Upgrade is considered complete when:

1. ✅ All Filament panels load correctly
2. ✅ CRUD operations work as expected
3. ✅ All tests pass
4. ✅ PHPStan analysis shows no errors
5. ✅ Performance matches or exceeds v3
6. ✅ All modules function correctly

## Documentation Updates

After successful upgrade:

1. Update README files in each module
2. Update API documentation
3. Create migration notes for developers
4. Update deployment procedures

## Support Resources

- [Official Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Filament Examples Tutorial](https://filamentexamples.com/tutorial/filament-v3-v4-upgrade)
- [Filament v4 Resources Overview](https://filamentphp.com/docs/4.x/resources/overview)

---

**Note**: This upgrade is critical for maintaining compatibility and accessing new features. All team members should review this guide before implementation.