# 🗺️ MASTER INDEX - PTVX Documentation 2025

**Last Updated**: 2025-01-02  
**Status**: ✅ COMPLETE & CURRENT  
**Purpose**: Single Source of Truth - Navigation Hub

---

## 🚀 Quick Start Paths

### For New Developers

1. [📖 Root README](./README.md) - Start here
2. [🏗️ Architecture Rules](./claude/architecture-rules.md) - **CRITICAL** - Must read
3. [📝 Conventions](./claude/conventions.md) - Coding standards
4. [🚫 Common Pitfalls](./claude/common-pitfalls.md) - Avoid these

### For Code Review

1. [✅ Best Practices](./best-practices/README.md)
2. [🔍 Code Quality](./claude/code-quality.md)
3. [⚠️ Critical Issues](./claude/eloquent-properties.md)
4. [🧬 Schemaless Attributes](./claude/schemaless-attributes-final.md)

### For Refactoring

1. [📊 IndennitaResponsabilita Analysis](../laravel/Modules/IndennitaResponsabilita/docs/analysis-summary.md)
2. [📋 Refactoring Action Plan](../laravel/Modules/IndennitaResponsabilita/docs/refactoring-action-plan.md)
3. [✅ Quality Verification](./code-quality-verification.md)

---

## 📊 Recent Analysis (2025-01-02)

### Comprehensive Code Quality Analysis

- ✅ **41 violations** identified across IndennitaResponsabilita
- ✅ **2 critical fixes** implemented (PHPStan Level 10 verified)
- ✅ **15 documents** created (~6,000 lines)
- ✅ **PHPMD** confirms analysis accuracy (95%+)

**Master Summary**: [Analysis Complete](./ANALYSIS-COMPLETE.md)

---

## 🗂️ Documentation Structure

### Root Level (`docs/`)

```
docs/
├── README.md ⭐ Main hub
├── MASTER-INDEX.md (This file)
├── ANALYSIS-COMPLETE.md ⭐ Recent work
├── analysis-corrections.md
├── code-quality-verification.md
├── claude/ ⭐ AI guidelines
│   ├── README.md
│   ├── architecture-rules.md ⚠️ CRITICAL
│   ├── schemaless-attributes-final.md ⚠️ CRITICAL
│   ├── eloquent-properties.md ⚠️ CRITICAL
│   ├── conventions.md
│   ├── code-quality.md
│   ├── common-pitfalls.md
│   └── ... (12 total docs)
├── architecture/
├── best-practices/
├── testing/
└── ... (100+ other docs)
```

### Module Level

```
laravel/Modules/
├── IndennitaResponsabilita/docs/ ⭐ ANALYZED
│   ├── README.md (Updated)
│   ├── analysis-summary.md ⭐ Start here
│   ├── code-quality-analysis.md (~800 lines)
│   ├── refactoring-action-plan.md (~1000 lines)
│   ├── best-practices.md (~600 lines)
│   ├── trait-responsibility-violation.md (~400 lines)
│   └── ... (13 total docs)
├── Rating/docs/ ⭐ FIXED
│   ├── README.md (Created)
│   ├── schemaless-scope-fix.md ⭐
│   ├── trait-consolidation-plan.md
│   └── ... (18 total docs)
├── Xot/docs/ (Core framework)
└── ... (50+ modules)
```

### Theme Level

```
laravel/Themes/
├── One/docs/
│   └── theme-analysis.md ⭐ Guidelines
└── Zero/docs/
```

---

## 🚨 Critical Topics

### 1. Schemaless Attributes ⚠️

**Issue**: Scope implementation was incorrect  
**Fixed**: 2025-01-02  
**Status**: ✅ VERIFIED

**Documentation**:
- [Final Correct Guide](./claude/schemaless-attributes-final.md)
- [Rating Scope Fix](../laravel/Modules/Rating/docs/schemaless-scope-fix.md)

**Quick Rule**:
```php
// ✅ CORRECT (both work)
Rating::withExtraAttributes('anno', 2024)->get()
Rating::where('extra_attributes->anno', 2024)->get()
```

### 2. Eloquent property_exists() ⚠️

**Issue**: NEVER use `property_exists()` with Eloquent models  
**Impact**: Always returns false for DB fields  
**Status**: 🔴 CRITICAL

**Documentation**: [Eloquent Properties](./claude/eloquent-properties.md)

**Quick Rule**:
```php
// ❌ WRONG
if (property_exists($model, 'email')) { }

// ✅ CORRECT
if (isset($model->email)) { }
```

### 3. XotBase Extension ⚠️

**Rule**: ALWAYS extend Xot base classes  
**Status**: 🔴 CRITICAL

**Quick Rule**:
```php
// ❌ WRONG
class MyPage extends Filament\Pages\Page { }

// ✅ CORRECT
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage { }
```

### 4. No Hardcoded Labels ⚠️

**Rule**: NEVER use `->label()`, `->placeholder()`, `->helperText()`  
**Status**: 🔴 CRITICAL

**Quick Rule**:
```php
// ❌ WRONG
TextInput::make('name')->label('Nome')

// ✅ CORRECT
TextInput::make('name') // Auto-translated
```

---

## 📚 Documentation by Topic

### Architecture

- [Overview](./architecture/README.md)
- [Module System](./claude/module-structure.md)
- [Design Patterns](./architecture/patterns.md)
- [SOLID Principles](./architecture/solid-principles.md)

### Development

- [Coding Standards](./claude/conventions.md)
- [Common Tasks](./development/common-tasks.md)
- [Testing Guide](./testing/README.md)
- [Best Practices](./best-practices/README.md)

### Quality Assurance

- [PHPStan Guide](./claude/code-quality.md)
- [Testing Strategies](./testing/README.md)
- [Code Review Process](./development/code-review.md)

### Specific Modules

- [IndennitaResponsabilita](../laravel/Modules/IndennitaResponsabilita/docs/README.md)
- [Rating](../laravel/Modules/Rating/docs/README.md)
- [Xot](../laravel/Modules/Xot/docs/README.md)
- [User](../laravel/Modules/User/docs/README.md)
- [All Modules List](./claude/module-list.md)

---

## 🎯 Top 10 Must-Read Documents

1. **[Root README](./README.md)** - Navigation hub
2. **[Claude Architecture Rules](./claude/architecture-rules.md)** - ⚠️ CRITICAL rules
3. **[Analysis Complete 2025](./ANALYSIS-COMPLETE.md)** - Recent analysis summary
4. **[Schemaless Final](./claude/schemaless-attributes-final.md)** - Correct schemaless usage
5. **[Eloquent Properties](./claude/eloquent-properties.md)** - property_exists issue
6. **[IndennitaResponsabilita Analysis](../laravel/Modules/IndennitaResponsabilita/docs/analysis-summary.md)** - Module analysis
7. **[Refactoring Plan](../laravel/Modules/IndennitaResponsabilita/docs/refactoring-action-plan.md)** - Action items
8. **[Rating Module](../laravel/Modules/Rating/docs/README.md)** - Fixed module
9. **[Common Pitfalls](./claude/common-pitfalls.md)** - Avoid these
10. **[Code Quality](./claude/code-quality.md)** - Quality tools

---

## 📊 Project Health Dashboard

### Code Quality

| Metric | Current | Target | Trend |
|--------|---------|--------|-------|
| PHPStan Level | Mixed (6-10) | 10 | ⬆️ Improving |
| Test Coverage | ~40% | 85% | ➡️ Stable |
| Code Duplication | ~15% | <3% | ➡️ Stable |
| Complexity (avg) | High | Low | ⬆️ Plan ready |
| Documentation | ~70% | 90% | ⬆️ Major update |

### Recent Improvements

- ✅ Rating scope fixed (2025-01-02)
- ✅ 15 comprehensive docs created
- ✅ 41 violations documented
- ✅ Refactoring plan ready

---

## 🔄 Maintenance Schedule

### Daily

- Code review with documentation reference
- PHPStan checks on modified files

### Weekly

- PHPMD scans
- Complexity monitoring
- Documentation updates

### Monthly

- Full module PHPStan scan
- Test coverage review
- Architecture review

### Quarterly

- Major refactoring sprints
- Performance optimization
- Security audit
- Dependency updates

---

## 🛠️ Quick Commands

### Analysis

```bash
# PHPStan Level 10
./vendor/bin/phpstan analyze Modules/ModuleName --level=10

# PHPMD
./vendor/bin/phpmd Modules/ModuleName text cleancode,codesize,design,naming

# PHPInsights
php artisan insights Modules/ModuleName --min-quality=85
```

### Testing

```bash
# All tests
php artisan test

# Module specific
php artisan test Modules/ModuleName/Tests

# With coverage
php artisan test --coverage --min=85
```

### Formatting

```bash
# Check
./vendor/bin/pint --test

# Fix
./vendor/bin/pint Modules/ModuleName
```

---

## 📞 Getting Help

### Documentation Not Clear?

1. Check [Root README](./README.md) for navigation
2. Search this MASTER-INDEX for topic
3. Consult module-specific docs
4. Ask team in Slack #dev-help

### Found a Bug in Docs?

1. Create issue with reference to document
2. Suggest correction
3. PR with fix

### Need New Documentation?

1. Check if topic already covered
2. Identify appropriate location (module vs root)
3. Follow [Documentation Policy](./claude/documentation-policy.md)
4. Create and link properly

---

## 🏆 Quality Standards

### Code Must

- [ ] Pass PHPStan Level 10
- [ ] Have >85% test coverage
- [ ] Follow PSR-12 (Pint)
- [ ] Have no hardcoded strings
- [ ] Use Service/Action pattern
- [ ] Extend Xot base classes
- [ ] Have complete PHPDoc

### Documentation Must

- [ ] Be in correct location (module vs root)
- [ ] Use kebab-case naming
- [ ] Have bidirectional links
- [ ] Be accurate and tested
- [ ] Include examples
- [ ] Be maintained

---

## 🎓 Learning Resources

### Internal

- [Architecture Guides](./architecture/README.md)
- [Development Guides](./development/README.md)
- [Testing Guides](./testing/README.md)
- [Module Examples](./claude/module-list.md)

### External

- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Filament 4 Docs](https://filamentphp.com/docs/4.x)
- [Spatie Packages](https://spatie.be/open-source)
- [PHPStan Docs](https://phpstan.org)

---

## 🌟 Recent Achievements

### 2025-01-02 ✅

- Complete code quality analysis (41 violations)
- Schemaless scope fix (PHPStan Level 10 passed)
- 15 comprehensive documents created
- Master documentation index updated
- Memories and rules corrected

### 2024-Q4 ✅

- Filament 4 upgrade completed
- Documentation consolidation
- PHPStan baseline created
- Module structure standardized

---

## 🔮 Upcoming Priorities

### Q1 2025

- [ ] Complete IndennitaResponsabilita refactoring
- [ ] Achieve 85%+ test coverage
- [ ] PHPStan Level 10 all modules
- [ ] Trait consolidation

### Q2 2025

- [ ] Performance optimization
- [ ] API v2 implementation
- [ ] Advanced testing strategies
- [ ] Security hardening

---

## 📱 Quick Reference

### Critical Rules

| Rule | Link |
|------|------|
| Eloquent property_exists | [Eloquent Properties](./claude/eloquent-properties.md) |
| Schemaless Attributes | [Schemaless Final](./claude/schemaless-attributes-final.md) |
| XotBase Extension | [Architecture Rules](./claude/architecture-rules.md) |
| No Hardcoded Labels | [Architecture Rules](./claude/architecture-rules.md) |
| Use Actions not Services | [Conventions](./claude/conventions.md) |

### Module Docs

| Module | README | Key Docs |
|--------|--------|----------|
| IndennitaResponsabilita | [README](../laravel/Modules/IndennitaResponsabilita/docs/README.md) | [Analysis](../laravel/Modules/IndennitaResponsabilita/docs/analysis-summary.md), [Plan](../laravel/Modules/IndennitaResponsabilita/docs/refactoring-action-plan.md) |
| Rating | [README](../laravel/Modules/Rating/docs/README.md) | [Scope Fix](../laravel/Modules/Rating/docs/schemaless-scope-fix.md), [Consolidation](../laravel/Modules/Rating/docs/trait-consolidation-plan.md) |
| Xot | [README](../laravel/Modules/Xot/docs/README.md) | Core framework |
| User | [README](../laravel/Modules/User/docs/README.md) | Auth & users |

---

## 📞 Support

**Slack**: #dev-general, #dev-help  
**Issues**: GitHub/JIRA with doc references  
**Questions**: Check docs first, then ask team

---

**Maintained By**: Development Team  
**Current Version**: 2025.1  
**Next Major Update**: Q1 2025 End



