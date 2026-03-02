# 📚 **Indice Documentazione Modulo Tenant**

**Last Update**: 31 Gennaio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.8.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica del sistema Multi-tenancy.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Dinamismo estremo e performance.
3. [philosophy.md](./philosophy.md) - "Ognuno nel suo spazio": filosofia dell'isolamento.

## 🏗️ **Architettura & Logica**
- 🏛️ **[Modular Monolith](./modular-monolith-architecture.md)** - Come il Tenant abilita la modularità.
- ⚙️ **[Configuration Logic](./configuration-logic-analysis.md)** - Risoluzione gerarchica della configurazione.
- 📂 **[Database Population](./database-population.md)** - Strategie per il seeding e la migrazione dei Tenant.

## 🛠️ **Implementazione Tecnica**
- 🧬 **[Tenant Config Path](./tenant-config-path-philosophy-debate.md)** - Filosofia della gestione dei path configurazione.
- 🐚 **[Console Integration](./resolve-tenant-config-console-debate.md)** - Risoluzione del tenant nei comandi CLI.
- 🍣 **[Sushi to JSON](./sushi-traits-phpstan-fixes.md)** - Gestione dei dati statici e semi-statici dei Tenant.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level10-fixes.md)** - Report di conformità Level 10.
- 🔬 **[Testing Guidelines](./testing.md)** - Verifica dell'isolamento dei dati tra tenant.
- 🧹 **[PHPMD Fixes](./cyclomatic-complexity-report.md)** - Analisi della complessità della logica di routing.
- 🐒 **[Chaos Monkey Tenant Isolation Checklist](./chaos-monkey-tenant-isolation-checklist.md)** - Checklist operativa per fault su multi-tenant/database.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./duplicate-files-to-remove.md)** - Eliminazione dei file duplicati e obsoleti.

## 📦 **Pacchetti Composer**
- [Riferimento](../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../docs/architecture/composer-packages-full-inventory.md) - Nessuna dipendenza diretta; usa Xot
- [Package Dependency Chaos Map](./package-dependency-chaos-map.md)

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Base framework per i Service Provider.
- [User](../../User/docs/README.md) - Associazione Utente-Tenant e permessi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
