# 📚 **Indice Documentazione Modulo Activity**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa e Quick Start.
2. [roadmap.md](./roadmap.md) - Visione evolutiva e task aperti.
3. [philosophy.md](./philosophy.md) - I principi dell'Audit Trail e dell'Event Sourcing.

## 🏗️ **Architettura e Pattern**
- 🧩 **[Core Structure](./structure.md)** - Organizzazione interna del modulo.
- 🎯 **[Event Sourcing](./event-sourcing.md)** - Dettagli sull'implementazione degli eventi di dominio.
- 🔧 **[Actions Calling Actions](./actions-calling-actions-pattern.md)** - Pattern per la composizione delle azioni di logging.

## 📊 **Filament & UI**
- 📈 **[Filament Resources](./filament-resources.md)** - Gestione Log e Analytics nell'Admin Panel.
- 📉 **[Analytics Widgets](./dual-label-chart-widget-implementation.md)** - Implementazione dei grafici e delle statistiche.
- 🧭 **[Nested Resources](./filament-5-nested-resources-complete-guide.md)** - Guida alle risorse nidificate in Filament v5.

## 🧪 **Qualità e Testing**
- ✅ **[PHPStan Compliance](./phpstan-analysis.md)** - Report sulla stabilità Level 10.
- 🔬 **[Testing Strategy](./testing-strategy-implementation.md)** - Approccio Pest/PHPUnit per il modulo.
- 🧹 **[PHPMD Fixes](./phpmd-fixes.md)** - Risoluzione dei problemi di complessità cicromatica.
- ⚠️ **[Testing Connection Hack](./testing/testing-connection-hack.md)** - Activity model usa default connection in test (anti-pattern documentato).

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- `spatie/laravel-activitylog` - Audit trail
- `spatie/laravel-event-sourcing` - Event sourcing, CQRS

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Core framework.
- [Tenant](../../tenant/docs/readme.md) - Isolamento dati per tenant.
- [User](../../user/docs/readme.md) - Autenticazione e causer activity.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)

## Regola Operativa Obbligatoria

- Prima di modificare codice: ragionare, studiare i docs del modulo/tema, aggiornare docs/rules/memory/skills.
- Riferimento globale: [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- Memory: [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- Skill: [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)

## Docs Governance

- [Docs Health](./docs-health.md) - Stato qualità docs, checklist di confidenza e prossime azioni di manutenzione.
