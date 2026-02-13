# 📚 **Indice Documentazione Modulo Xot (Core Engine)**

**Last Update**: 5 Febbraio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 3.0.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica del framework Laraxot.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Laravel 12 & Stability.
3. [super-mucca-methodology.md](./super-mucca-methodology.md) - La filosofia di sviluppo del progetto.

## 🏛️ **Architettura Core**
- 📐 **[Architecture Complete Guide](./architecture-complete.md)** - Deep dive nel sistema modulare.
- 🧬 **[Base Classes (XotBase)](./xot-base-classes.md)** - Regole per estendere Resource, Page e Widget.
- ⚙️ **[Action Architecture](./action-service-provider-architecture.md)** - Pattern per Actions atomiche e testabili.
- 🧩 **[Service Providers](./service-provider-architecture.md)** - Ciclo di vita e boot dei moduli.

## 🏷️ **Naming & Quality Standards**
- 📜 **[PHPStan Code Quality Guide](./phpstan-code-quality-guide.md)** - La bibbia del Livello 10.
- 🚫 **[No Services Rule](./critical-no-services-rule.md)** - Perché usiamo Actions invece dei Service.
- 🗂️ **[Filament Class Extension Rules](./filament-class-extension-rules.md)** - Regole obbligatorie per Filament.

## 🛠️ **Utility & Trait**
- 🧬 **[Trait Patterns](./traits-complete-guide.md)** - HasTeams, HasXotTable e altri trait core.
- 🔧 **[HasXotTable Fixes](./phpstan-hasxottable-trait-fixes-february-2026.md)** - Correzioni type safety per trait multi-contesto.
- 🐚 **[Bashscripts Organization](./bashscripts-organization.md)** - Strumenti CLI per la manutenzione.
- 🚀 **[Safe Casting Actions](./safe-casting-actions.md)** - Gestione type-safe dei dati.

## 🧪 **Qualità e Testing**
- ✅ **[PHPStan Level 10 Status](./phpstan-level10-xot-fixes.md)** - Conformità e report.
- 🔬 **[Pest Testing Philosophy](./testing-philosophy-unified.md)** - Approccio al testing del core.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./cleanup-action-plan.md)** - Strategia per gestire i 780+ documenti accumulati.

## 🔗 **Moduli Dipendenti**
- Tutti i moduli del sistema dipendono da **Xot**.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*