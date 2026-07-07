## 🏛️ Architettura Core
- 📐 [Architecture Complete Guide](./architecture-complete.md) - Deep dive nel sistema modulare.
- 🧬 [Base Classes (XotBase)](./xot-base-classes.md) - Regole per estendere Resource, Page e Widget.
- ⚙️ [Action Architecture](./action-service-provider-architecture.md) - Pattern per Actions atomiche e testabili.
- 🧩 [Service Providers](./service-provider-architecture.md) - Ciclo di vita e boot dei moduli.
- 🔢 [EnumTrait Pattern](./enum-trait-pattern.md) - Standard per Enums con traduzioni e UI Filament.

## 🏷️ Naming & Quality Standards
- 📜 [PHPStan Code Quality Guide](./phpstan-code-quality-guide.md) - La bibbia del Livello 10.
- 🚫 [No Services Rule](./critical-no-services-rule.md) - Perché usiamo Actions invece dei Service.
- 🗂️ [Filament Class Extension Rules](./filament-class-extension-rules.md) - Regole obbligatorie per Filament.

## 🛠️ Utility & Trait
- 🧬 [Trait Patterns](./traits-complete-guide.md) - HasTeams, HasXotTable e altri trait core.
- 🐚 [Bashscripts Organization](./bashscripts-organization.md) - Strumenti CLI per la manutenzione.
- 🚀 [Safe Casting Actions](./safe-casting-actions.md) - Gestione type-safe dei dati.

## 🧪 Qualità e Testing
- ✅ [PHPStan Level 10 Status](./phpstan-level10-xot-fixes.md) - Conformità e report.
- 🔬 [Pest Testing Philosophy](./testing-philosophy-unified.md) - Approccio al testing del core.

## 🧹 Manutenzione
- 🗑️ [Cleanup Plan](./cleanup-action-plan.md) - Strategia per consolidare documenti accumulati.
- 🪮 [Ponytail audit over-engineering](./ponytail-audit-over-engineering.md) - GetFactoryAction, contracts, vincoli MetatagData/XotData.
- 🔁 [Migrazione Services -> QueueableAction](./wiki/decisions/services-to-actions-migration.md) - UrlService/ThemeService/HtmlService migrati ad Actions; ConfigService/XotService/ArrayService/ProfileTest archiviati in .bak (codice morto); ArtisanService/RouteService/ModuleService/Translators/Trend lasciati intatti per sessione dedicata.

## 🔗 Moduli Dipendenti
- Tutti i moduli del sistema dipendono da **Xot**.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
# Xot Module Documentation Index

> **Core Framework Module** - Provides base classes and shared functionality for all modules

## Roadmap

- [Roadmap Xot](roadmap/00-index.md) - Visione, fasi, qualità

## 📚 Documentation Sections

### Core Architecture
- [XotBase Classes & Inheritance Patterns](./xotbase-extension.md)
- [Service Provider Architecture](./service-provider-architecture.md)
## Composer / dipendenze

- [composer-root-skeleton-modular](./wiki/concepts/composer-root-skeleton-modular.md) — root skeleton + merge solo moduli
- [theme-psr4-autoload-without-merge](./wiki/concepts/theme-psr4-autoload-without-merge.md) — autoload temi senza merge root
- [Module Dependency Management](./composer-module-dependency-management.md)
- [Composer Packages Reference](../../../../docs/composer-packages-reference.md) - Mappatura pacchetti per modulo
- [Inventario completo 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - Tutti i pacchetti con versione e descrizione
- [Composer Packages Deep Study (2026-03-02)](./composer-packages-deep-study.md)
- [Composer Packages Full Catalog (2026-03-02)](./composer-packages-full-catalog.md) - Studio completo package-by-package da `composer show`
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