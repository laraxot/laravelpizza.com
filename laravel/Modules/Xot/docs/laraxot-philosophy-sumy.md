# Laraxot Philosophy - Complete Summary

## Core Principles

### 1. **Single Source of Truth**

**Every entity has exactly ONE authoritative definition:**

- **Tables**: One `create_table` migration per table per module
- **Files**: One location for database files (migrations, seeders, factories)
- **Models**: One base class inheritance chain
- **Resources**: One Filament base resource class

### 2. **Consistency Over Flexibility**

**<nome progetto>able behavior is more valuable than unlimited options:**

- Same file structure across all modules
- Same inheritance patterns for all models
- Same migration philosophy for all tables
- Same autoloader behavior in all environments

### 3. **DRY/KISS Compliance**

**Eliminate redundancy and keep it simple:**

- No duplicate migrations for the same table
- No duplicate file locations for the same classes
- No redundant method overrides in models
- No unnecessary configuration complexity

## Specific Rules

### Migration Philosophy

**🚨 ONE TABLE, ONE MIGRATION**

- Each table gets exactly ONE `create_table` migration
- Schema changes use separate migration files
- NEVER create multiple `create_table` migrations for the same table
- Use `XotBaseMigration` for auto-discovery and idempotent operations

### File Structure Philosophy

**🚨 ONE LOCATION, ONE FILE**

- Database files exist in ONE location only
- Traditional Laravel structure (`database/` directory) recommended
- NEVER mix traditional and app-centric structures
- Empty directories confuse autoloader and must be removed

### Model Architecture Philosophy

**🚨 ONE INHERITANCE CHAIN**

- All models extend module-specific base classes
- Base classes extend `XotBaseModel`
- NEVER extend Laravel Model directly
- Connection auto-discovery from namespace

### Filament Philosophy

**🚨 ONE BASE RESOURCE CLASS**

- All Filament resources extend `XotBaseResource`
- Auto-discovery of models and pages
- Translation-first approach for labels
- Consistent form and infolist schemas

## Why These Rules Matter

### Technical Benefits

1. **<nome progetto>able Autoloading**: No ambiguous class resolution
2. **Consistent Behavior**: Same results in all environments
3. **Easy Maintenance**: Clear, unambiguous code structure
4. **Fast Debugging**: Obvious source of truth for each entity

### Business Benefits

1. **Reduced Development Time**: Less time spent on configuration
2. **Fewer Bugs**: Eliminates whole categories of errors
3. **Easier Onboarding**: Clear patterns for new developers
4. **Scalable Architecture**: Consistent patterns scale well

## Violation Examples

### ❌ Migration Violation

```
Modules/User/database/migrations/
├── 2023_01_01_000011_create_roles_table.php  # ❌ DUPLICATE
├── 2023_01_01_000012_create_roles_table.php  # ❌ DUPLICATE
└── 2024_01_01_000011_create_roles_table.php  # ✅ AUTHORITATIVE
```

### ❌ File Structure Violation

```
Modules/Cms/
├── database/                    # ❌ HAS FILES
│   └── factories/PageFactory.php
└── app/
    ├── Database/                # ❌ EMPTY DIRECTORIES
    │   └── Factories/           # (confuses autoloader)
    └── ...
```

### ❌ Model Violation

```php
// ❌ WRONG - Direct Model extension
class User extends Model { }

// ✅ CORRECT - Module base class
class User extends BaseUser { }
```

## Implementation Checklist

### For New Modules

- [ ] Use traditional `database/` structure
- [ ] Create ONE `create_table` migration per table
- [ ] Extend module-specific base models
- [ ] Extend `XotBaseResource` for Filament
- [ ] Follow translation-first approach

### For Existing Modules

- [ ] Consolidate duplicate migrations
- [ ] Remove empty/duplicate directories
- [ ] Verify inheritance chains
- [ ] Test autoloader behavior

## Documentation References

- **Migration Philosophy**: `Modules/Xot/docs/migration-philosophy.md`
- **File Structure**: `Modules/Xot/docs/file-structure-philosophy.md`
- **Model Architecture**: `Modules/Xot/docs/models/MODEL_ARCHITECTURE.md`
- **Filament Resources**: `CLAUDE.md` Filament section

## Testing Philosophy Compliance

```bash
# Check for duplicate migrations
find Modules -name "*create_*_table.php" | sort

# Check for duplicate file locations
find Modules -name "*.php" | grep -E "(factories|seeders)" | sort

# Check model inheritance
grep -r "extends Model" Modules/*/app/Models/

# Test autoloader
composer dump-autoload
```

---

**Philosophy Summary**: Laraxot values simplicity, consistency, and <nome progetto>ability above all else. Follow these principles to build maintainable, scalable applications with minimal technical debt.
