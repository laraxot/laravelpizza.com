---
id: module-activity-readme
title: "Activity — Audit Trail e Tracciabilità Operativa"
type: module-readme
category: module-documentation
module: Activity
status: active
tags: [activity, audit, events, traceability]
created: 2026-09-14
updated: 2026-09-14
qmd: "activity audit trail events operator history module documentation"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/50"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/51"
related:
  - "./docs/"
sources: []
---

# 📊 Activity

> **Audit trail e tracciabilità operativa.**

Gestisce l'audit trail degli eventi, la tracciabilità degli operatori e la visibilità degli stati.

## Cosa offre

- **Eventi e audit trail** – registrazione completa di ogni azione
- **Modelli e relazioni** – strutture dati per tracciare flussi
- **Filtri Filament** – query parametrizzate
- **Utenti e domini** – associazione contesto

## Confini architetturali

This module owns event logging, audit trails, and relationship modeling. Its logic lives in `Actions`; admin interfaces follow Laraxot/XotBase contracts. Dependencies must be explicit and stable.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Activity
```

Check test coverage and operational conventions in the local docs.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project‑wide PHPStan config, and update technical docs whenever contracts evolve.

---

**Modulo** `activity` · **Laraxot ecosystem** · **Project-agnostic**
