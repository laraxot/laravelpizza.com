# Merge Conflicts Inventory

**Date**: 2025-11-12
**Total Files with Conflicts**: 77
**Status**: In Progress

## Summary

This document catalogs all files containing merge conflict markers found throughout the codebase. The conflicts span multiple modules and file types, including PHP files, Blade templates, documentation files, and configuration files.

## File Categories

### PHP Files (Application Code)
- **Total**: 33 files
- **Modules Affected**: Xot, UI, Notify
- **Criticality**: HIGH - These affect application functionality

### Documentation Files (.md)
- **Total**: 25 files
- **Modules Affected**: Xot, UI, Notify, Sigma
- **Criticality**: MEDIUM - Documentation conflicts

### Blade Template Files
- **Total**: 2 files
- **Modules Affected**: Notify
- **Criticality**: MEDIUM - Email template conflicts

### Configuration Files
- **Total**: 1 file
- **Modules Affected**: UI
- **Criticality**: HIGH - Configuration conflicts

### SVG Files
- **Total**: 2 files
- **Modules Affected**: Media, Job
- **Criticality**: LOW - Logo conflicts

### Script Files (.sh)
- **Total**: 4 files
- **Modules Affected**: Xot
- **Criticality**: MEDIUM - Git conflict resolution scripts

### Other Files
- **Total**: 10 files
- **Criticality**: VARIES

## Detailed File List

### Module: Xot (Core Framework)

#### PHP Files (High Priority)
1. `app/Actions/Filament/GetModulesNavigationItems.php`
2. `app/Datas/PdfData.php`
3. `app/States/XotBaseState.php`
4. `app/Models/InformationSchemaTable.php`
5. `app/Filament/Widgets/XotBaseWidget.php`
6. `app/Filament/Widgets/EnvWidget.php`
7. `app/Filament/Actions/Form/FieldRefreshAction.php`
8. `app/Filament/Forms/Components/XotBaseField.php`
9. `app/Filament/Forms/Components/XotBaseFormComponent.php`
10. `app/Filament/Blocks/XotBaseBlock.php`
11. `app/Filament/Resources/SessionResource.php`
12. `app/Filament/Resources/ModuleResource.php`
13. `app/Filament/Resources/LogResource/Pages/ViewLog.php`
14. `app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
15. `app/Filament/Resources/CacheResource.php`
16. `app/Filament/Pages/Dashboard.php`
17. `app/Filament/Pages/MetatagPage.php`
18. `app/Filament/Pages/XotBasePage.php`

#### Documentation Files
1. `docs/best-practices.md`
2. `docs/architecture/struttura-percorsi.md`
3. `docs/testing-best-practices-uppercase.md`
4. `docs/naming-conventions.md`
5. `docs/SCRIPT_RISOLUZIONE_CONFLITTI.md`
6. `docs/git-conflicts-resolution-strategy.md`
7. `docs/architecture-violations-and-fixes.md`
8. `docs/testing.md`
9. `docs/testing/real-data-vs-mock-testing-strategy.md`
10. `docs/prompts.md`
11. `docs/conflict_resolution_report.md`
12. `docs/view-composer-loop-infinite-fix.md`
13. `docs/development-guidelines.md`
14. `docs/filament/resources/architecture/forbidden-methods.md`
15. `docs/filament/README.md`
16. `docs/code-quality.md`
17. `docs/README.md`
18. `docs/filament-best-practices.md`
19. `docs/namespace_conventions.md`
20. `docs/filament-resource-rules.md`
21. `docs/providers/xotbaseserviceprovider.md`
22. `docs/index.md`
23. `docs/migration-standards.md`
24. `docs/bugfix/git-conflicts-resolution-massive.md`

#### Test Files
1. `tests/pest.php`
2. `tests/Unit/metatagdatatest.php`

#### Script Files
1. `bashscripts/git/resolve_merge_conflicts_v1.sh`
2. `bashscripts/git/fix_conflicts_now.sh`
3. `bashscripts/git/resolve_merge_conflicts_v2.sh`
4. `bashscripts/git/resolve_merge_conflicts_incoming.sh`
5. `bashscripts/git/README.md`

### Module: UI

#### PHP Files (High Priority)
1. `app/Filament/Forms/Components/RadioBadge.php`
2. `app/Filament/Forms/Components/InlineDatePicker.php`
3. `app/Filament/Forms/Components/RadioCollection.php`
4. `app/Filament/Forms/Components/SelectState.php`
5. `app/Filament/Forms/Components/RadioIcon.php`
6. `app/Filament/Forms/Components/PasswordStrengthField.php`
7. `app/Filament/Forms/Components/IconPicker.php`
8. `app/Filament/Forms/Components/ParentSelect.php`
9. `app/Filament/Forms/Components/Children.php`
10. `app/Filament/Forms/Components/RadioImage.php`
11. `app/Filament/Forms/Components/TreeField.php`
12. `app/Filament/Blocks/VideoSpatie.php`
13. `app/Filament/Blocks/Slider.php`

#### Configuration File
1. `Config/config.php`

#### Documentation Files
1. `docs/filament/no-label-rule.md`
2. `docs/enum-transclass-implementation.md`
3. `docs/never_use_label_rule.md`

### Module: Notify

#### PHP Files
1. `tests/Feature/JsonComponentsTest.php`

#### Blade Templates
1. `resources/views/emails/templates/sunny/contentEnd.blade.php`
2. `resources/views/emails/templates/minty/contentEnd.blade.php`

#### Documentation Files
1. `docs/README.md`
2. `docs/index.md`

### Module: Media

#### SVG Files
1. `resources/svg/logo.svg`

### Module: Job

#### SVG Files
1. `resources/svg/logo.svg`

### Module: Sigma

#### Documentation Files
1. `docs/README.md`

### Root Level Files

#### Configuration
1. `.claude/settings.local.json`

#### Node Modules (Low Priority)
1. `node_modules/esbuild/bin/esbuild`
2. `node_modules/@esbuild/linux-x64/bin/esbuild`

## Resolution Strategy

### Priority Order
1. **Critical PHP Files** - Core framework components and UI components
2. **Configuration Files** - System configuration
3. **Blade Templates** - Email templates
4. **Documentation Files** - Documentation conflicts
5. **SVG Files** - Logo conflicts
6. **Script Files** - Git conflict resolution scripts

### Resolution Approach
- Analyze each conflict contextually
- Preserve intended functionality from both branches
- Apply Laraxot architecture rules
- Run PHPStan Level 10 validation after fixes
- Document resolution decisions

## Next Steps

1. Begin with critical PHP files in Xot module
2. Move to UI module form components
3. Address configuration files
4. Resolve documentation conflicts
5. Finalize with non-critical files

---
*This inventory will be updated as conflicts are resolved.*