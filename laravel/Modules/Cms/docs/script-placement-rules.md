# Script Placement Rules

## Rule: Standalone Operational Scripts Location

**CRITICAL**: Standalone operational scripts MUST NOT be placed inside `Modules/*/` directories.

### Correct Location
All standalone operational scripts (test data generators, database populators, utility scripts) belong under:

```
bashscripts/{module_name}/
```

### Examples

| Script Type | WRONG Location | CORRECT Location |
|-------------|----------------|------------------|
| Test data generator | `Modules/Cms/generate_test_data.php` | `bashscripts/cms/generate_test_data.php` |
| Database populator | `Modules/Cms/populate_database_comprehensive.php` | `bashscripts/cms/populate_database_comprehensive.php` |
| Module utility | `Modules/Predict/utility.php` | `bashscripts/predict/utility.php` |

### Why This Rule Exists

1. **PHPStan Compliance**: Scripts in Modules are analyzed and cause type errors
2. **Clean Architecture**: Modules should contain only application code
3. **Separation of Concerns**: Operational scripts are dev/ops tools, not app code
4. **phpstan.neon excludePaths**: The `excludePaths` in `phpstan.neon` already excludes `bashscripts/`

### Files Affected by This Rule

- `generate_test_data.php` → moved to `bashscripts/cms/`
- `populate_database_comprehensive.php` → moved to `bashscripts/cms/`
- `tinker_commands.php` → should be in `bashscripts/cms/`
- Any `*.php` scripts at module root level (not in app/, database/, etc.)

### Module Structure

Modules should follow this structure:
```
ModuleName/
├── app/
├── config/
├── database/
├── docs/
├── resources/
├── routes/
├── tests/
├── module.json
└── composer.json
```

**NO** `.php` files should exist at the module root level unless they are:
- `module.json`
- `composer.json`
- Configuration files that belong there

### Reference Projects

- `base_laravelpizza`: Fully PHPStan compliant (0 errors)
- `base_quaeris_fila5_mono`: Follows same pattern

### Update History

- 2026-03-12: Rule established after discovering misplaced scripts causing PHPStan errors
- Files moved: `generate_test_data.php`, `populate_database_comprehensive.php`
