# Autoload Configuration Standard

## Overview
This document outlines the standard autoload configuration that should be present in all module composer.json files within the Laraxot framework.

## Required Autoload Structure

Each module's `composer.json` file must contain the following autoload configuration:

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

### Components Explained

1. **Main Application Namespace**: `Modules\\<ModuleName>\\` maps to the `app/` directory
2. **Database Factories**: `Modules\\<ModuleName>\\Database\\Factories\\` maps to `database/factories/`
3. **Database Seeders**: `Modules\\<ModuleName>\\Database\\Seeders\\` maps to `database/seeders/`
4. **Test Namespace**: `Modules\\<ModuleName>\\Tests\\` maps to `tests/` in autoload-dev

## Purpose

This configuration ensures:
- PSR-4 autoloading standards compliance
- Consistent namespace structure across all modules
- Proper separation of application code, factories, seeders, and tests
- Framework compatibility with Laravel Modules package

## Compliance Check

All modules should be verified to ensure they follow this exact autoload structure to maintain consistency across the application.