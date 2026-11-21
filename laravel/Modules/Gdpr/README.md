---
id: module-gdpr-readme
title: "GDPR — Consensi e Privacy Applicativa"
type: module-readme
category: module-documentation
module: Gdpr
status: active
tags: [gdpr, privacy, consent, revocation]
created: 2026-09-14
updated: 2026-09-14
qmd: "gdpr consent privacy policy revocation module documentation"
issues:
  - "https://github.com/laraxot/module_gdpr_fila5/issues/39"
discussions:
  - "https://github.com/laraxot/module_gdpr_fila5/discussions/40"
related:
  - "./docs/"
sources: []
---

# 🔒 GDPR

> **Consensi e privacy applicativa.**

Centralizza consensi, revoche e tracciabilità delle preferenze.

## Cosa offre

- **Consensi** – gestione dinamica del consenso utente
- **Policy utente** – regole di trattamento dei dati
- **Audit** – tracciabilità delle operazioni
- **Pannello Filament** – dashboard compliance

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Gdpr
```

Refer to local docs for implementation details.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project PHPStan config, and update docs when contracts evolve.

---

**Modulo** `gdpr` · **Laraxot ecosystem** · **Project-agnostic**
