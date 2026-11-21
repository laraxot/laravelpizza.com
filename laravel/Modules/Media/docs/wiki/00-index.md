---
title: "📚 **Indice Documentazione Modulo Media**"
module: "Media"
type: concept
tags: [00, index]
created: 2026-07-14
updated: 2026-07-14
qmd: "00 index"
related:
  - "./webm.md"
---
# 📚 **Indice Documentazione Modulo Media**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](README.md) - Panoramica completa, Upload e Processing.
2. [roadmap.md](./roadmap.md) - Obiettivi di trasformazione e AI 2026.
3. [philosophy.md](./philosophy.md) - "Il file come entità": la nostra visione del media.

## 🎞️ **Video & Image Processing**
- 🎥 **[FFmpeg Integration](./ffmpeg-integration.md)** - Guida alla gestione video e codec.
- 🖼️ **[Image Optimization](./file-management-architecture.md)** - Architettura di trasformazione immagini.
- 🔄 **[Auto Conversions](./conversione-media.md)** - Logic per preview e watermark.

## ☁️ **Cloud & Storage**
- ☁️ **[S3 Integration](./s3test-corrections.md)** - Guida alla configurazione AWS S3/Minio.
- 📁 **[File Management](./file-management.md)** - Organizzazione directory e disk strategy.
- 📄 **[Responsive Images](./webm.md)** - Gestione formati moderni (WebP, AVIF).

## 🎨 **Filament & UI**
- 🖼️ **[Media Library](./filament.md)** - La libreria media in Filament.
- 🛠️ **[Table Actions](./filament-table-actions.md)** - Azioni di massa su file e directory.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Level 10](./phpstan-level10-fixes.md)** - Report di conformità totale.
- 🔬 **[Testing Guidelines](./testing.md)** - Strategie per testare upload e stream.
- 🧹 **[PHPMD Analysis](./cyclomatic-complexity-report.md)** - Pulizia degli algoritmi di conversione.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- `pbmedia/laravel-ffmpeg` - Elaborazione video
- `intervention/image` - Elaborazione immagini

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/README.md) - Base framework e Trait `HasMedia`.
- [CloudStorage](../../cloudstorage/docs/README.md) - Astrazione per provider cloud.
- [Cms](../../cms/docs/README.md) - Integrazione media nei blocchi di contenuto.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)

---

<!-- Merged from 00-index.md, which collided with this file on case-insensitive filesystems. -->

# 📚 MEDIA Module - Documentation Index

**Path**: `laravel/Modules/Media/docs/`  
**Modulo**: @Modules/Media

## 📄 Documenti

### Product
| File | Scopo |
|------|-------|
| PRD.md | Product Requirements |
| product_roadmap.md | Roadmap |
| product_strategy.md | Strategy |
| product_launch_plan.md | Launch Plan |

### Development
| File | Scopo |
|------|-------|
| gsd_workflow.md | GSD Workflow |
| sprint_planning.md | Sprint Planning |
| user_research.md | User Research |

## 🔗 Riferimenti

- [Xot Module](../Xot/docs/00-index.md) - Base classes
- [AGENTS.md](../../../../AGENTS.md) - Project guidelines

---

**Ultimo Aggiornamento**: 2026-03-24
