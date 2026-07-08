# Third-Party Model Integration - Quick Reference

## 🚨 CRITICAL RULES

### 1. **Extend Package Models Directly**
- ✅ DO: `class Permission extends SpatiePermission`
- ❌ DON'T: `class Permission extends BaseModel`

### 2. **Use Proper Aliases**
- ✅ DO: `use Spatie\Permission\Models\Permission as SpatiePermission`
- ❌ DON'T: `use Spatie\Permission\Models\Permission`

### 3. **Add Laraxot Features via Traits**
- ✅ DO: `use RelationX`, `use HasXotFactory`
- ❌ DON'T: Replicate package functionality

## 📋 Current Third-Party Models

### Spatie Package Models

| Module | Model | Package | Connection |
|--------|-------|---------|------------|
| **User** | `Permission` | `spatie/laravel-permission` | `user` |
| **User** | `Role` | `spatie/laravel-permission` | `user` |
| **Activity** | `Activity` | `spatie/laravel-activitylog` | `activity` |
| **Activity** | `StoredEvent` | `spatie/laravel-event-sourcing` | `activity` |
| **Activity** | `Snapshot` | `spatie/laravel-event-sourcing` | `activity` |
| **Media** | `Media` | `spatie/laravel-medialibrary` | `media` |
| **Notify** | `MailTemplate` | `spatie/laravel-mail-templates` | `notify` |
| **Xot** | `BaseActivity` | `spatie/laravel-activitylog` | `activity` |

## 🔧 Implementation Pattern

### Standard Template

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Models;

use {Package}\Models\{Model} as {Package}{Model};
use Modules\Xot\Models\Traits\RelationX;

class {Model} extends {Package}{Model}
{
    use RelationX;

    /** @var string */
    protected $connection = '{module}';

    /** @var list<string> */
    protected $fillable = [
        // Package fields
        'package_field_1',
        'package_field_2',
        // Laraxot extensions
        'laraxot_field_1',
        'laraxot_field_2',
    ];

    // Laraxot-specific methods
    public function customMethod(): void
    {
        // Implementation
    }
}
```

## 🎯 Why This Matters

### Benefits
- ✅ Full package functionality access
- ✅ Automatic package updates
- ✅ Package security patches
- ✅ Battle-tested package code
- ✅ Community support

### Problems Solved
- ❌ Package compatibility issues
- ❌ Manual package feature replication
- ❌ Update breaking changes
- ❌ Security vulnerabilities
- ❌ Maintenance overhead

## 📚 Documentation

### Core Philosophy
- **[third-party-model-inheritance-philosophy.md](third-party-model-inheritance-philosophy.md)** - Complete philosophy guide

### Module-Specific Patterns
- **[User Module](../User/docs/third-party-model-patterns.md)** - Permission & Role integration
- **[Activity Module](../Activity/docs/third-party-model-patterns.md)** - ActivityLog & EventSourcing

### Related Documentation
- **[Model Architecture](models/MODEL_ARCHITECTURE.md)** - Laraxot model patterns
- **[Migration Philosophy](migration-philosophy.md)** - Database migration patterns

## 🔍 Verification Commands

```bash
# Find all Spatie-extended models
find Modules -name "*.php" -type f | xargs grep -l "extends.*Spatie" 2>/dev/null | grep -v "Test" | grep -v "Factory" | grep -v "views"

# Check for proper aliases
find Modules -name "*.php" -type f | xargs grep -h "use.*Spatie.*as" 2>/dev/null

# Verify connection configuration
find Modules -name "*.php" -type f | xargs grep -h "protected.*connection" 2>/dev/null | grep -i spatie
```

## 📋 Code Review Checklist

### ✅ For Third-Party Models
- [ ] Extends package model directly
- [ ] Uses proper package alias
- [ ] Sets module-specific connection
- [ ] Adds Laraxot traits appropriately
- [ ] Maintains package compatibility
- [ ] Documents package integration

### ❌ Common Violations
- [ ] Double inheritance chains
- [ ] Package functionality replication
- [ ] Missing package aliases
- [ ] Wrong connection configuration
- [ ] Breaking package updates

## 🚀 Quick Start

### Adding New Third-Party Model

1. **Research Package**: Understand package architecture
2. **Create Model**: Extend package model directly
3. **Configure**: Set connection and add traits
4. **Test**: Verify package functionality works
5. **Document**: Document integration approach

### Example: New Package Integration

```php
// 1. Research package model
use Vendor\Package\Models\Feature as PackageFeature;

// 2. Create Laraxot model
class Feature extends PackageFeature
{
    use RelationX;
    protected $connection = 'feature';
}
```

---

**Remember**: Respect package architecture, extend directly, enhance with Laraxot features.
