# Laraxot File Structure Philosophy

## Core Principle: Single Source of Truth for Database Files

**🚨 CRITICAL RULE**: In Laraxot architecture, database-related files (migrations, seeders, factories) must exist in **ONE** location only - either in the traditional Laravel structure OR in the app structure, but NEVER both.

## The Problem: Ambiguous Class Resolution

### Current Violation in Cms Module

The Cms module has database files in **BOTH** locations, causing PHP warnings:

```
Warning: Ambiguous class resolution, "Modules\Cms\Database\Seeders\CmsDatabaseSeeder" was found in both:
- "/Modules/Cms/database/seeders/CmsDatabaseSeeder.php" AND
- "/Modules/Cms/app/Database/Seeders/CmsDatabaseSeeder.php"
```

### Files Affected

- **Seeders**: `CmsDatabaseSeeder.php`
- **Factories**: `PageFactory.php`, `ConfFactory.php`, `ModuleFactory.php`, etc.

## Correct File Structure Patterns
### ✅ Option 1: Traditional Laravel Structure (Recommended)

```
Modules/{ModuleName}/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
└── app/
    ├── Actions/
    ├── Application/
    ├── Events/
    ├── Listeners/
    ├── Models/
    ├── Filament/
    └── ...
```

### ❌ WRONG: Root-Level Capitalized Directories

```
Modules/{ModuleName}/
├── Actions/        # ❌ SHOULD BE IN app/
├── Application/    # ❌ SHOULD BE IN app/
├── Database/       # ❌ SHOULD BE lowercase database/
├── Events/         # ❌ SHOULD BE IN app/
├── Listeners/      # ❌ SHOULD BE IN app/
└── ...
```

## Why This Matters
### ✅ Option 2: App-Centric Structure

```
Modules/{ModuleName}/
├── app/
│   ├── Database/
│   │   ├── Factories/
│   │   │   ├── PageFactory.php
│   │   │   ├── ConfFactory.php
│   │   │   └── ...
│   │   ├── Migrations/
│   │   │   ├── 2024_01_01_000000_create_pages_table.php
│   │   │   └── ...
│   │   └── Seeders/
│   │       └── CmsDatabaseSeeder.php
│   ├── Models/
│   └── ...
└── database/  # EMPTY or non-existent
```

### ❌ WRONG: Mixed Structure

```
Modules/{ModuleName}/
├── database/
│   ├── factories/
│   │   ├── PageFactory.php  # ❌ DUPLICATE
│   │   └── ...
│   └── seeders/
│       └── CmsDatabaseSeeder.php  # ❌ DUPLICATE
└── app/
    ├── Database/
    │   ├── Factories/
    │   │   ├── PageFactory.php  # ❌ DUPLICATE
    │   │   └── ...
    │   └── Seeders/
    │       └── CmsDatabaseSeeder.php  # ❌ DUPLICATE
    └── ...
```

## Why This Matters

### 1. **Autoloader Confusion**
- PHP autoloader cannot determine which file to use
- "First found" approach leads to un<nome progetto>able behavior
- Different environments may load different files

### 2. **Maintenance Nightmare**
- Which file is the authoritative source?
- Changes made to one file may not reflect in the other
- Debugging becomes extremely difficult

### 3. **Deployment Risks**
- Production may use different files than development
- Inconsistent behavior across environments
- Potential for data corruption

## Laraxot Philosophy: Consistency Over Flexibility

### Single Source of Truth

Each database file type should have exactly ONE location:

- **Migrations**: `Modules/{Module}/database/migrations/`
- **Factories**: `Modules/{Module}/database/factories/`
- **Seeders**: `Modules/{Module}/database/seeders/`

### Why Traditional Structure is Recommended

1. **Laravel Convention**: Follows standard Laravel patterns
2. **Tool Compatibility**: Works with Laravel's built-in commands
3. **Developer Familiarity**: Most Laravel developers expect this structure
4. **Module System**: Compatible with nwidart/laravel-modules

## Resolution Strategy

### For Existing Duplicates

1. **Identify Authoritative Files**: Check timestamps and content completeness
2. **Remove Duplicates**: Delete files from the non-preferred location
3. **Update Autoloader**: Ensure only one location is in the classmap
4. **Test Thoroughly**: Verify all functionality works with single location

### Recommended Action for Cms Module

Based on current structure:

- **Keep**: `Modules/Cms/database/factories/` and `Modules/Cms/database/seeders/`
- **Remove**: Empty `Modules/Cms/app/Database/Factories/` and `Modules/Cms/app/Database/Seeders/` directories

## File Structure Rules

### ✅ DO

- Choose ONE structure pattern per module
- Use traditional Laravel structure (`database/` directory)
- Keep all database files in one consistent location
- Follow the same pattern across all modules

### ❌ DON'T

- Mix traditional and app-centric structures
- Create duplicate files in different locations
- Change structure patterns mid-project
- Have empty directories that confuse the autoloader

## Module Consistency

All modules should follow the SAME file structure pattern:

```
Modules/
├── User/
│   ├── database/
│   │   ├── factories/
│   │   ├── migrations/
│   │   └── seeders/
│   └── app/
├── Cms/
│   ├── database/
│   │   ├── factories/
│   │   ├── migrations/
│   │   └── seeders/
│   └── app/
└── healthcare_app/
└── ExternalProject/
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    └── app/
```

## Autoloader Configuration

Ensure `composer.json` only maps ONE location:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\": "Modules/"
        }
    }
}
```

## Testing File Structure

Use this command to check for duplicates:

```bash
# Check for duplicate class resolutions
composer dump-autoload

# Find duplicate files
find Modules -name "*.php" | grep -E "(factories|seeders)" | sort
```

---

**Philosophy Summary**: In Laraxot, consistency and <nome progetto>ability are more valuable than flexibility. Choose one file structure pattern and apply it consistently across all modules. Eliminate ambiguity to ensure reliable, <nome progetto>able behavior.