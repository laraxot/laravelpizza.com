# Parental STI Pattern - Documentation Index

## 📚 Overview

This index provides centralized access to all documentation about the **Parental STI (Single Table Inheritance)** pattern used in Laraxot.

## 🔍 Quick Navigation

| Document | Location | Purpose |
|----------|----------|---------|
| **Pattern Guide** | `Modules/Performance/docs/parental-sti-pattern.md` | Complete implementation guide |
| **Rules** | `docs/rules/parental-sti-pattern-rules.md` | DO/DON'T checklist and best practices |
| **Bug Investigation** | `Modules/Performance/docs/bugfix-individuale-regionale-parental-scope.md` | Deep dive investigation report |

## 📖 Document Summaries

### 1. Pattern Guide (Comprehensive)

**Location**: `Modules/Performance/docs/parental-sti-pattern.md`

**Contents**:
- Architecture overview
- Parent and child model implementation
- How Parental handles filtering automatically
- Best practices and examples
- Filament integration
- Testing strategies
- Troubleshooting guide

**When to Use**: 
- Learning the pattern for the first time
- Understanding how Parental works
- Implementing new child models

### 2. Rules (Quick Reference)

**Location**: `docs/rules/parental-sti-pattern-rules.md`

**Contents**:
- ✅ DO checklist
- ❌ DON'T examples
- Common mistakes and fixes
- Troubleshooting steps
- Testing examples

**When to Use**:
- Quick reference during development
- Code review checklist
- Debugging issues

### 3. Bug Investigation (Case Study)

**Location**: `Modules/Performance/docs/bugfix-individuale-regionale-parental-scope.md`

**Contents**:
- Real-world bug investigation
- Parental package deep analysis
- Why we add redundant global scopes
- Model verification steps
- Recommendations

**When to Use**:
- Understanding why a bug might occur
- Learning from real examples
- Debugging filtering issues

## 🎯 Key Concepts

### What is Parental?

**Parental** is a package by Tighten that enables **Single Table Inheritance (STI)** in Laravel Eloquent models.

**How it works**:
1. One table stores all records (e.g., `performance_individuale`)
2. A `type` column distinguishes model types
3. Parent model uses `HasChildren` trait
4. Child models use `HasParent` trait
5. Automatic filtering and instantiation based on type

### Key Discovery

The `HasParent` trait **automatically adds a global scope** that filters by type!

```php
// From HasParent trait
static::addGlobalScope(function ($query) {
    $instance = new static;
    if ($instance->parentHasHasChildrenTrait()) {
        $query->where(
            $query->getModel()->getTable() . '.' . $instance->getInheritanceColumn(),
            $instance->classToAlias(get_class($instance))
        );
    }
});
```

### Why We Add Redundant Filtering

Even though Parental handles filtering automatically, we **explicitly add a global scope** in each child model:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();  // Calls bootHasParent() from trait

        // Redundant but recommended for clarity
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**Reasons**:
- ✅ Self-documenting code
- ✅ Defensive programming
- ✅ Easier debugging
- ✅ Team clarity

## 📁 File Locations

### Models

| Model | Type | File |
|-------|------|------|
| `Individuale` | Parent | `Modules/Performance/app/Models/Individuale.php` |
| `IndividualeDip` | Child (`'dip'`) | `Modules/Performance/app/Models/IndividualeDip.php` |
| `IndividualePo` | Child (`'po'`) | `Modules/Performance/app/Models/IndividualePo.php` |
| `IndividualeRegionale` | Child (`'regionale'`) | `Modules/Performance/app/Models/IndividualeRegionale.php` |
| `IndividualeDirigente` | Child (`'dirigente'`) | `Modules/Performance/app/Models/IndividualeDirigente.php` |

### Documentation

| Type | Location |
|------|----------|
| Pattern Guide | `Modules/Performance/docs/parental-sti-pattern.md` |
| Rules | `docs/rules/parental-sti-pattern-rules.md` |
| Bug Report | `Modules/Performance/docs/bugfix-individuale-regionale-parental-scope.md` |
| This Index | `docs/index/parental-sti-index.md` |

### Vendor (Reference)

| File | Purpose |
|------|---------|
| `vendor/tightenco/parental/src/HasParent.php` | Child model trait |
| `vendor/tightenco/parental/src/HasChildren.php` | Parent model trait |

## 🛠️ Implementation Checklist

When creating a new child model:

### Parent Model

- [ ] Add `use HasChildren;` trait
- [ ] Define `$childColumn = 'type';` (or custom name)
- [ ] Define `$childTypes` array with all children
- [ ] Include `'type'` in `$fillable`

### Child Model

- [ ] Extend parent model
- [ ] Add `use HasParent;` trait
- [ ] Define `boot()` method
- [ ] Call `parent::boot()` first
- [ ] Add global scope with `static::addGlobalScope()`
- [ ] Use `static::` not `self::`
- [ ] Match type value to parent's `$childTypes` key

### Database

- [ ] Add `type` column to table
- [ ] Make column nullable: `$table->string('type')->nullable()`
- [ ] Include in migration

### Testing

- [ ] Test filtering works correctly
- [ ] Test type auto-fill on create
- [ ] Test Filament resource displays correct records

## 🔍 Troubleshooting Quick Guide

### Issue: Shows All Types

**Check**:
1. Model uses `HasParent` trait? ✅
2. `boot()` calls `parent::boot()`? ✅
3. Clear caches: `php artisan cache:clear` ✅
4. Restart PHP-FPM/Apache for OpCache ✅

### Issue: Type Not Auto-Filled

**Check**:
1. `'type'` in parent's `$fillable`? ✅
2. Parent uses `HasChildren` trait? ✅
3. `bootHasParent()` running? ✅

### Issue: Wrong Type Value

**Check**:
1. Type value matches parent's `$childTypes` key? ✅
2. Using `static::` not `self::`? ✅
3. `classToAlias()` returns correct value? ✅

## 📚 External Resources

- [Tighten Parental GitHub](https://github.com/tighten/parental)
- [Laravel STI Documentation](https://laravel.com/docs/eloquent#single-table-inheritance)
- [Parental Package Documentation](https://github.com/tighten/parental#readme)

## 🎓 Learning Path

### Beginner

1. Read **Pattern Guide** section "Panoramica"
2. Study parent model example (`Individuale.php`)
3. Study one child model example (`IndividualeRegionale.php`)
4. Read **Rules** section "✅ CORRETTO"

### Intermediate

1. Read complete **Pattern Guide**
2. Implement a new child model following checklist
3. Write tests for filtering
4. Read **Bug Investigation** for troubleshooting

### Advanced

1. Study `HasParent.php` and `HasChildren.php` source code
2. Understand boot order and global scope stacking
3. Contribute to pattern improvements
4. Mentor others on Parental STI

## 📊 Pattern Status

| Aspect | Status | Notes |
|--------|--------|-------|
| **Implementation** | ✅ Complete | All 4 child models implemented |
| **Documentation** | ✅ Complete | Comprehensive guides available |
| **Testing** | ⚠️ Partial | Manual testing done, automated tests needed |
| **Team Knowledge** | ✅ Documented | All knowledge captured in docs |

## 🔄 Update History

| Date | Change | Author |
|------|--------|--------|
| 2026-04-01 | Initial comprehensive documentation | AI Agent Team |
| 2026-04-01 | Deep investigation report | AI Agent Team |
| 2026-04-01 | Rules and best practices | AI Agent Team |
| 2026-04-01 | This index created | AI Agent Team |

---

**Last Updated**: 2026-04-01  
**Maintained By**: AI Agent Team  
**Status**: ✅ Active & Verified
