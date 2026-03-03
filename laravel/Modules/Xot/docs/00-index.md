# Xot Module Documentation Index

> **Core Framework Module** - Provides base classes and shared functionality for all modules

## 📚 Documentation Sections

### Core Architecture
- [XotBase Classes & Inheritance Patterns](./xotbase-inheritance-patterns.md)
- [Service Provider Architecture](./service-provider-architecture.md)
- [Module Dependency Management](./composer-module-dependency-management.md)
- [Database Connection Configuration](./database-connection-configuration.md)

### Development Standards
- [PHPStan Level 10 Compliance Guide](./phpstan-level10-compliance.md)
- [Code Quality Workflow](./code-quality-workflow.md)
- [TDD Laravel Pest Complete Guide](./tdd-laravel-pestd-complete-guide.md) ⭐ NEW
- [Testing Best Practices](./testing-best-practices.md)

### Memory & Performance
- [Filament Memory Optimization](./memory-optimization-filament.md)
- [Optimize Filament Memory Command](./optimize-filament-memory-command.md)
- [Performance Analysis Guide](./performance-analysis-guide.md)

### Error Prevention & Fixes
- [Common PHPStan Errors & Solutions](./common-phpstan-errors.md)
- [Model Casting Migration Guide](./model-casting-migration.md)
- [Git Conflict Resolution Workflow](./git-conflict-resolution-workflow.md)

### Utilities & Helpers
- [Safe Cast Actions](./safe-cast-actions.md)
- [Webmozart Assert Usage](./webmozart-assert-usage.md)
- [Translation Management](./translation-management.md)

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

- [User Module](../User/docs/00-index.md) - Authentication & Authorization
- [Activity Module](../Activity/docs/00-index.md) - Event logging & tracking
- [Tenant Module](../Tenant/docs/00-index.md) - Multi-tenant isolation

---

**Module Version**: 1.0  
**Laravel Version**: 12.x  
**PHP Version**: 8.2+  
**