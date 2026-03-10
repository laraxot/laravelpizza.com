# Xot Module Documentation Index

> **Core Framework Module** - Provides base classes and shared functionality for all modules

## Roadmap

- [Roadmap Xot](roadmap/00-index.md) - Visione, fasi, qualità

## 📚 Documentation Sections

### Core Architecture
- [XotBase Classes & Inheritance Patterns](./xotbase-extension.md)
- [Service Provider Architecture](./service-provider-architecture.md)
- [Module Dependency Management](./composer-module-dependency-management.md)
- [Composer Packages Reference](../../../../docs/composer-packages-reference.md) - Mappatura pacchetti per modulo
- [Inventario completo 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - Tutti i pacchetti con versione e descrizione
- [Composer Packages Deep Study (2026-03-02)](./composer-packages-deep-study-2026-03-02.md)
- [Composer Packages Full Catalog (2026-03-02)](./composer-packages-full-catalog-2026-03-02.md) - Studio completo package-by-package da `composer show`
- [Database Connection Configuration](./database-configuration-critical-rules.md)

### Development Standards
- [PHPStan Level 10 Compliance Guide](./phpstan-level10.md)
- [Code Quality Workflow](./code-quality-tools-guide.md)
- [TDD Laravel Pest Complete Guide](./tdd-laravel-pestd-complete-guide.md) ⭐ NEW
- [Testing Best Practices](./testing-best-practices.md)

### Memory & Performance
- [Filament Memory Optimization](./memory-optimization.md)
- [Optimize Filament Memory Command](./memory-optimization-dashboard-fixes.md)
- [Performance Analysis Guide](./performance-guidelines.md)

### Filament
- [HasXotForm form() DEVE essere final](./hasxotform-form-final.md) — Regola: form() final, usare getFormSchema()

### PHPStan
- [phpstan.neon immutabile](./phpstan-neon-immutable.md) — laravel/phpstan.neon è l'unico config, NON modificare, NON creare altri

### Error Prevention & Fixes
- [Common PHPStan Errors & Solutions](./analisi-phpstan.md)
- [Model Casting Migration Guide](./model-casting-rules.md)
- [Git Conflict Resolution Workflow](./git-conflicts-resolution-strategy.md)
- [Chaos Monkey Operability Rules](./chaos-monkey-operability-rules.md)

### Utilities & Helpers
- [Safe Cast Actions](./safe-casting-actions.md)
- [Translation Management](./translation-system-standardization.md)

## 🚀 Quick Start

1. **Understand XotBase Pattern**: All modules must extend XotBase classes
2. **Follow TDD**: Use Red-Green-Refactor cycle with Pest (see TDD guide)
3. **Maintain Quality**: Run PHPStan Level 10 after every change
4. **Document Everything**: Update docs before and after implementation

## 📖 Recently Updated

- ✅ **2026-02-23**: Added complete TDD guide with Pest integration
- ✅ **2026-02-23**: Updated OAuth testing patterns
- ✅ **2026-02-23**: Added QueueableAction testing standards

## 🔗 Related Modules

- [User Module](../../User/docs/00-index.md) - Authentication & Authorization
- [Activity Module](../../Activity/docs/00-index.md) - Event logging & tracking
- [Tenant Module](../../Tenant/docs/00-index.md) - Multi-tenant isolation

---

**Module Version**: 1.0  
**Laravel Version**: 12.x  
**PHP Version**: 8.2+  
**Last Updated**: 2026-03-02

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
