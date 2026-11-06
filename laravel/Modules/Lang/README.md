---
id: module-lang-readme
title: "Lang — Localizzazione e Traduzioni Modulari"
type: module-readme
category: module-documentation
module: Lang
status: active
tags: [lang, i18n, localization, translations]
created: 2026-09-14
updated: 2026-09-14
qmd: "lang localization translations editor synchronization fallback module documentation"
issues:
  - "https://github.com/laraxot/module_lang_fila5/issues/54"
discussions:
  - "https://github.com/laraxot/module_lang_fila5/discussions/55"
related:
  - "./docs/"
sources: []
---

# 🌐 Lang

> **Localizzazione e traduzioni modulari.**

Editor traduzioni, sincronizzazione chiavi, fallback runtime e contenuti multilingua.

## Cosa offre

- **Editor traduzioni** – intervallo di testo gestito
- **Sincronizzazione chiavi** – propagazione automatica
- **Fallback runtime** – traduzioni alternative
- **Contenuti multilingua** – supporto per più lingue

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Lang
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project PHPStan config, and update docs when contracts evolve.

---

**Modulo** `lang` · **Laraxot ecosystem** · **Project-agnostic**
