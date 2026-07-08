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
- [Xot](../../xot/docs/readme.md) - Base framework e Trait `HasMedia`.
- [CloudStorage](../../cloudstorage/docs/readme.md) - Astrazione per provider cloud.
- [Cms](../../cms/docs/readme.md) - Integrazione media nei blocchi di contenuto.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
