---
issues: []
discussions: []
title: "Indice Documentazione Modulo Media (superseded)"
module: "Media"
type: concept
tags: [00, index]
created: 2026-07-14
updated: 2026-10-23
qmd: "00 index"
related:
  - "./webm.md"
status: superseded
superseded_by: README.md
---

> Superseded il 2026-10-14 come copia per sola differenza di maiuscole di `00-INDEX.md`. Quel file e' stato rimosso il 2026-10-22 (commit e2282c1b) e il suo contenuto (tra cui la mappa delle directory) non e' stato riportato qui: l'ingresso verificato sul codice e' [README.md](./README.md). Contenuto conservato per storia. Le voci "non presente" puntavano a file che non esistono (verificato 2026-10-14).
# 📚 **Indice Documentazione Modulo Media**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa, Upload e Processing.
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
- 🖼️ **Media Library (`filament.md` non presente)** - La libreria media in Filament.
- 🛠️ **[Table Actions](./filament-table-actions.md)** - Azioni di massa su file e directory.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Level 10](./phpstan-level10-fixes.md)** - Report di conformità totale.
- 🔬 **[Testing Guidelines](./testing.md)** - Strategie per testare upload e stream.
- 🧹 **[PHPMD Analysis](./cyclomatic-complexity-report.md)** - Pulizia degli algoritmi di conversione.

## 📦 **Pacchetti Composer**
- Riferimento completo (`composer-packages-reference.md` non presente) | Inventario 312 pacchetti (`composer-packages-full-inventory.md` non presente)
- `pbmedia/laravel-ffmpeg` - Elaborazione video
- `intervention/image` - Elaborazione immagini

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Base framework e Trait `HasMedia`.
- CloudStorage (`readme.md` non presente) - Astrazione per provider cloud.
- [Cms](../../Cms/docs/README.md) - Integrazione media nei blocchi di contenuto.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)

---

<!-- Merged from 00-INDEX.md, which collided with this file on case-insensitive filesystems. -->

# 📚 MEDIA Module - Documentation Index

**Path**: `laravel/Modules/Media/docs/`  
**Modulo**: @Modules/Media

## 📄 Documenti

### Product
| File | Scopo |
|------|-------|
| PRD.md | Product Requirements |
| PRODUCT_ROADMAP.md | Roadmap |
| PRODUCT_STRATEGY.md | Strategy |
| PRODUCT_LAUNCH_PLAN.md | Launch Plan |

### Development
| File | Scopo |
|------|-------|
| GSD_WORKFLOW.md | GSD Workflow |
| SPRINT_PLANNING.md | Sprint Planning |
| USER_RESEARCH.md | User Research |

## 🔗 Riferimenti

- [Xot Module](../../Xot/docs/00-index.md) - Base classes
- [AGENTS.md](../../../../AGENTS.md) - Project guidelines

---

**Ultimo Aggiornamento**: 2026-03-24

## Impostazioni del modulo (SettingPage)

`/media/admin/setting`, solo super-admin, file `config/{tenant}/media.php`: dimensione massima e tipi MIME degli allegati delle Resource (prima 10 MB, pdf/doc/docx in `GetAttachmentsSchemaAction`).
Decisione e modulo per modulo: [../../Xot/docs/stories/module-setting-pages.epic.md](../../Xot/docs/stories/module-setting-pages.epic.md).
