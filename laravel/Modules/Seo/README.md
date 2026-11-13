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

[![Stars](https://img.shields.io/github/stars/laraxot/module_seo_fila5?style=plastic&color=yellow)]()
[![Forks](https://img.shields.io/github/forks/laraxot/module_seo_fila5?style=plastic&color=green)]()
[![Issues](https://img.shields.io/github/issues/laraxot/module_seo_fila5?style=plastic&color=red)]()
[![License](https://img.shields.io/github/license/laraxot/module_seo_fila5?style=plastic&color=blue)]()
[![Last Commit](https://img.shields.io/github/last-commit/laraxot/module_seo_fila5?style=plastic&color=purple)]()
[![Release](https://img.shields.io/github/v/release/laraxot/module_seo_fila5?style=plastic&color=orange&display_name=release)]()
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://php.net/)
[![Filament](https://img.shields.io/badge/Filament-5-ffab00?style=for-the-badge)](https://filamentphp.com/)
[![Laravel](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge)](https://laravel.com/)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-purple?style=plastic)]()
]()

> **SEO integrato, sempre aggiornato**  
> SEO meta, sitemap, canonical e strumenti per il posizionamento.

## 🎯 La Visione

Crediamo che il software debba essere **chiaro, modulare e potente**. Ogni modulo è stato pensato per risolvere problemi reali con soluzioni eleganti.

## Perché esiste questo modulo?

**SEO meta, sitemap, canonical e strumenti per il posizionamento.**

In un mondo dove la complessità è l'avere, abbiamo scritto codice semplice. Questo modulo non è solo una libreria: è una **promessa di qualità** mantenuta.

## 🧘 I Principi Zen (e la nostra filosofia)

1. **Semplicità vince sulla complessità** - Il codice chiaro è più potente di mille righe di commenti.
2. **Modulare è dare vita** - Ogni pezzo può vivere da solo, ma insieme diventa un universo.
3. **Documentare è onniscienza** - La mancanza di documentazione è la paura del futuro.
4. **Testare è fidarsi** - Non fidarsi del proprio codice è fidarsi del caos.
5. **Rifattorizzare è crescere** - Lentamente, incrementalmente, diventiamo migliori.

## 💎 Le sue Superpoteri

- **Architettura modulare** - Separazione netta tra logica di business e presentazione
- **PHPStan Level 10** - Massima sicurezza tipizzazione
- **PSR-12** - Codice che parla lo stesso linguaggio del mondo
- **Filament 5** - Admin panel d'eccellenza
- **XotBase** - Pattern consolidati che funzionano

## 📖 Documentazione

| Lingua | Link |
|--------|------|
| 🇮🇹 Presentazione | Questo file (`README.md`) |
| 🇬🇧 Business card | [docs/readme-en.md](./docs/readme-en.md) |
| 📚 Wiki tecnica | [./docs/wiki/](./docs/) |
| 🎯 Esempi | [docs/examples/](./docs/examples/) |

## 🔧 Tecnologie chiave

**Stack principale:** Laravel 13, Filament 5, XotBase

**Keywords:** SEO, Metadata, Sitemap

## 🚀 Pronte all'uso

Importa, installa, configura. Il resto ci penseremo noi.

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
