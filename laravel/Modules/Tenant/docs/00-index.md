# 📚 **Indice Documentazione Modulo Tenant**

**
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.8.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica del sistema Multi-tenancy.
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

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./duplicate-files-to-remove.md)** - Eliminazione dei file duplicati e obsoleti.

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Base framework per i Service Provider.
- [User](../../user/docs/readme.md) - Associazione Utente-Tenant e permessi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Regola Operativa Obbligatoria

- Prima di modificare codice: ragionare, studiare i docs del modulo/tema, aggiornare docs/rules/memory/skills.
- Riferimento globale: [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- Memory: [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- Skill: [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)

## Coverage 100 Program

- Regola: [Coverage 100% Full-Project Rule](../../../../docs/rules/coverage-100-full-project-rule.md)
- Memory: [Coverage 100% Full-Project Memory](../../../../docs/memory/coverage-100-full-project-memory.md)
- Skill: [Coverage 100% Full-Project Skill](../../../../docs/skills/coverage-100-full-project-skill.md)
- Reference: [Pest coverage/type coverage + Laravel Modules tests](../../../../docs/testing/pest-coverage-type-coverage-laravel-modules-reference-2026-03-04.md)
