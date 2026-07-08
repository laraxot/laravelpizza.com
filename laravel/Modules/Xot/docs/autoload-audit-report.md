# Autoload Configuration Audit Report

## Standard Configuration
Each module's composer.json should have:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\<ModuleName>\\": "app/",
            "Modules\\<ModuleName>\\Database\\Factories\\": "database/factories/",
            "Modules\\<ModuleName>\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\<ModuleName>\\Tests\\": "tests/"
        }
    }
}
```

## Findings

### Modules with CORRECT configuration:
- User ✓
- Quaeris ✓
- UI ✓
- Tenant ✓
- Limesurvey ✓

### Modules with INCORRECT configuration (FIXED):

#### Cms Module
- Issue: Tests namespace was in `autoload` instead of `autoload-dev`
- Fixed: Moved `"Modules\\Cms\\Tests\\": "tests/"` to `autoload-dev` section

#### Xot Module
- Issue: Tests namespace was in `autoload` instead of `autoload-dev`
- Fixed: Moved `"Modules\\Xot\\Tests\\": "tests/"` to `autoload-dev` section

#### Activity Module
- Issue: Tests namespace was in both `autoload` and `autoload-dev` (duplicate)
- Fixed: Removed Tests namespace from `autoload` section, kept in `autoload-dev`

## Summary
All modules now follow the correct autoload configuration standard. The main deviations that were found have been corrected:
- Tests namespace was incorrectly placed in the main autoload section instead of autoload-dev
- Some modules had duplicate entries in both sections

## Recommendations
- Continue to validate that all new modules follow the standard configuration
- Implement automated checks to prevent this type of configuration issue
