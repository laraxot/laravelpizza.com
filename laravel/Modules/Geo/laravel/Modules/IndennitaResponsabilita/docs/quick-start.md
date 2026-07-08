# Quick Start - IndennitaResponsabilita Module

**For**: New developers joining the module  
**Time**: 15 minutes read  
**Updated**: 2025-01-02

---

## 📚 Essential Reading (30 minutes)

### 1. [Analysis Summary](./analysis-summary.md) (10 min)

**Why**: Understand current state and issues  
**Key Points**:
- 41 violations identified
- Critical fixes completed
- Refactoring planned

### 2. [Best Practices](./best-practices.md) (15 min)

**Why**: Learn correct patterns  
**Key Points**:
- DO/DON'T examples
- Quick checklist
- Common mistakes

### 3. [Module README](./README.md) (5 min)

**Why**: Module overview  
**Key Points**:
- Features
- Structure
- Integration

---

## 🚨 Critical Rules

### 1. Schemaless Attributes

```php
// ✅ CORRECT
$ratings = Rating::withExtraAttributes('anno', 2024)->get();

// ✅ ALSO CORRECT
$ratings = Rating::where('extra_attributes->anno', 2024)->get();
```

**Doc**: [Schemaless Final](../../../docs/claude/schemaless-attributes-final.md)

### 2. No Hardcoded Strings

```php
// ❌ WRONG
<td><b>Lavoratore:</b></td>

// ✅ CORRECT
<td><b>{{ __('indennitaresponsabilita::fields.lavoratore.label') }}</b></td>
```

### 3. PHPStan Level 10

```bash
# Always run before commit
./vendor/bin/phpstan analyze Modules/IndennitaResponsabilita --level=10
```

---

## 🛠️ Development Workflow

### 1. Setup

```bash
cd laravel
composer install
npm install
```

### 2. Before Coding

- Read relevant docs
- Check [Refactoring Plan](./refactoring-action-plan.md) for priorities
- Create feature branch

### 3. While Coding

- Follow [Best Practices](./best-practices.md)
- Write tests alongside code
- Run PHPStan frequently

### 4. Before Commit

```bash
# Check with PHPStan
./vendor/bin/phpstan analyze Modules/IndennitaResponsabilita --level=10

# Format code
./vendor/bin/pint Modules/IndennitaResponsabilita

# Run tests
php artisan test Modules/IndennitaResponsabilita/Tests
```

---

## 🎯 Current Priorities

### Week 1 (CRITICAL)

1. Remove `dddx()` from view
2. Complete translations
3. Create Service Layer

### Week 2-3 (HIGH)

4. Refactor CompilaIndennitaResponsabilita
5. Refactor Blade view
6. Consolidate traits

---

## 🔗 Quick Links

- [Code Quality Analysis](./code-quality-analysis.md) - Detailed analysis
- [Refactoring Action Plan](./refactoring-action-plan.md) - What to do
- [Best Practices](./best-practices.md) - How to do it
- [Trait Responsibility](./trait-responsibility-violation.md) - DRY fix

**Root**: [Master Index](../../../docs/MASTER-INDEX.md)

---

**Time to productivity**: ~1 hour  
**Support**: #dev-indennita-responsabilita



