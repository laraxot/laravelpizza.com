---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

# 🔍 Seo

[![Domain-SEO](https://img.shields.io/badge/Domain-SEO-827717.svg)](#)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![FixCity Platform](https://img.shields.io/badge/Platform-FixCity-008758.svg)](#)

> **Trovabile su Google, accessibile a tutti.** Meta, sitemap, structured data — visibilità istituzionale.

---

## Perché esiste

I servizi comunali devono essere discoverable.

## Superpoteri

- Meta tag e Open Graph
- Sitemap e robots
- Integrazione Folio/CMS
- Filament configurazione

## Certificazioni

| Certificazione | Stato |
|----------------|-------|
| PHPStan livello 10 | Target progetto |
| `declare(strict_types=1)` | Su nuovo codice PHP |
| Filament 5 + XotBase | Admin enterprise |
| Test PHPUnit / Pest | Suite modulo |
| Documentazione wiki | Cartella `docs/` |

## Vuoi entrare nel team?

Se non si trova, **non esiste** — SEO matters.

Stack frontoffice: **Tailwind · Alpine · Lit · DaisyUI · Flowbite · Filament v5** — vedi [STORY-133](../../../docs/stories/STORY-133-frontend-stack-religion-tailwind-alpine-lit.md).

---

## Documentazione

| Lingua | Link |
|--------|------|
| 🇮🇹 Presentazione | Questo file (`README.md`) |
| 🇬🇧 Business card | [docs/readme-en.md](./docs/readme-en.md) |
| 📚 Wiki tecnica | [./docs/wiki/](./docs/) |

---

title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
**Modulo** `Seo` · **Laraxot** · PHPStan 10 · Filament 5
---
---
id: module-seo-readme
title: "SEO — Metadati, Sitemap e Dati Strutturati"
type: module-readme
category: module-documentation
module: Seo
status: active
tags: [seo, metadata, sitemap, opengraph, schema]
created: 2026-09-14
updated: 2026-09-14
qmd: "seo metadata sitemap opengraph schema structured data module documentation"
issues:
  - "https://github.com/laraxot/module_seo_fila5/issues/13"
discussions:
  - "https://github.com/laraxot/module_seo_fila5/discussions/14"
related:
  - "./docs/"
sources: []
---

# 🔍 SEO

> **Metadati, sitemap e dati strutturati.**

Pagine pubbliche trovabili, condivisibili e semanticamente leggibili.

## Cosa offre

- **Meta/canonical** – ottimizzazione SEO
- **Open Graph** – social sharing
- **Sitemap/robots** – crawling efficiency
- **Schema.org/CMS** – structured data

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Seo
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Maintain `declare(strict_types=1);` in PHP, adhere to project PHPStan config, and update docs when contracts evolve.

---

**Modulo** `seo` · **Laraxot ecosystem** · **Project-agnostic**