# Laraxot Philosophy - Quick Reference

## 🚨 CRITICAL RULES

### 1. **One Table, One Migration**
- Each table gets exactly ONE `create_table` migration
- NEVER create multiple migrations for the same table
- Use `XotBaseMigration` for auto-discovery

### 2. **One Location, One File Type**
- Database files: `Modules/{Module}/database/`
- Test files: `Modules/{Module}/tests/`
- NEVER mix traditional and app-centric structures

### 3. **One Inheritance Chain**
- Models extend module-specific base classes
- NEVER extend Laravel Model directly
- Filament resources extend `XotBaseResource`

## 📁 File Structure

### ✅ CORRECT Structure

```
Modules/{Module}/
├── database/                    # Migrations, Factories, Seeders
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── tests/                       # All test files
│   ├── Feature/
│   └── Unit/
└── app/                        # Application code
    ├── Models/
    ├── Filament/
    ├── Actions/
    └── Providers/
```

### ❌ WRONG Structures

- Mixed database file locations
- Mixed test file locations
- Direct Model extensions
- Multiple `create_table` migrations per table

## 🔧 Commands to Check

```bash
# Check migrations
find Modules -name "*create_*_table.php" | sort

# Check file structure
find Modules -name "*.php" | grep -E "(factories|seeders|tests)" | sort

# Check model inheritance
grep -r "extends Model" Modules/*/app/Models/

# Test autoloader
composer dump-autoload
```

## 📚 Documentation

### Core Philosophy
- `Modules/Xot/docs/laraxot-consistency-philosophy.md`
- `Modules/Xot/docs/laraxot-philosophy-summary.md`

### Specific Areas
- **Migrations**: `Modules/Xot/docs/migration-philosophy.md`
- **File Structure**: `Modules/Xot/docs/file-structure-philosophy.md`
- **Test Structure**: `Modules/Xot/docs/test-structure-philosophy.md`
- **Model Architecture**: `Modules/Xot/docs/models/MODEL_ARCHITECTURE.md`

### Module Cleanup
- **Cms**: `Modules/Cms/docs/file-structure-cleanup.md`
- **UI**: `Modules/UI/docs/test-structure-cleanup.md`
- **User**: `Modules/User/docs/migration-philosophy.md`

## 🎯 Why This Matters

### Benefits
- ✅ Predictable autoloading
- ✅ Reliable test execution
- ✅ Easy maintenance
- ✅ Fast debugging
- ✅ Scalable architecture

### Problems Solved
- ❌ Ambiguous class resolution
- ❌ Unreliable test discovery
- ❌ Maintenance complexity
- ❌ Technical debt accumulation

## 📋 Implementation Checklist

### For New Code
- [ ] Use traditional `database/` structure
- [ ] Use traditional `tests/` structure
- [ ] One migration per table
- [ ] Extend module base classes
- [ ] Extend `XotBaseResource`

### For Existing Code
- [ ] Consolidate duplicate migrations
- [ ] Remove empty directories
- [ ] Move files to consistent locations
- [ ] Test autoloader behavior

---

**Remember**: In Laraxot, consistency enables maintainability. Follow these patterns for reliable, scalable applications.