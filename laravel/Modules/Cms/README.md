---
id: module-cms-readme
title: "CMS — Content Management e Pagine Componibili"
type: module-readme
category: module-documentation
module: Cms
status: active
tags: [cms, cms, pages, builder, folio, content]
created: 2026-09-14
updated: 2026-09-14
qmd: "cms pages builder blocks folio content localization module documentation"
issues:
  - "https://github.com/laraxot/module_cms_fila5/issues/53"
discussions:
  - "https://github.com/laraxot/module_cms_fila5/discussions/54"
related:
  - "./docs/"
sources: []
---

# 🧱 CMS

> **Content management e pagine componibili.**

Gestisce pagine, Builder Blocks, localizzazione e rendering Folio/Blade.

## Cosa offre

- **Pagine pubblicabili** – CRUD per contenuti
- **Builder Blocks** – componenti riutilizzabili
- **Contenuti JSON** – dati strutturati
- **Folio e temi** – tematiche e layout

## Confini architetturali

This module publishes contracts usable by other modules. Logic resides in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Cms
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Maintain `declare(strict_types=1);` in PHP, adhere to project PHPStan config, and update docs when contracts change.

---

**Modulo** `cms` · **Laraxot ecosystem** · **Project-agnostic**
