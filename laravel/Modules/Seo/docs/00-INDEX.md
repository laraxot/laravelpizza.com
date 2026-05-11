# 📚 Seo Module - Documentation Index

**Path**: `laravel/Modules/Seo/docs/`  
**Modulo**: @Modules/Seo

## 🎯 Scopo

Enterprise-grade Search Engine Optimization: meta tag management, sitemap generation, structured data (JSON-LD), OpenGraph/social sharing, analytics integration.

## 📦 Struttura

```
docs/
├── 00-INDEX.md          # Questo indice
├── README.md            # Panoramica modulo
├── 00-index.md          # Indice precedente (legacy)
└── [categoria]/         # Sottocartelle tematiche
```

## 📄 Documenti

### Product
| File | Scopo |
|------|-------|
| README.md | Panoramica modulo |
| roadmap.md | Development roadmap |

### Core Features
| File | Scopo |
|------|-------|
| meta-tag-management.md | Gestione meta tag |
| sitemap-generation.md | Generazione sitemap XML |
| structured-data.md | Schema.org JSON-LD |
| social-sharing.md | OpenGraph e condivisione social |

### Integration
| File | Scopo |
|------|-------|
| analytics-integration.md | Integrazione analytics |
| performance-tracking.md | Tracking performance SEO |

## 🔗 Riferimenti

- [Xot Module](../Xot/docs/00-INDEX.md) - Base classes
- [AGENTS.md](../../../../AGENTS.md) - Project guidelines

## 🚀 Quick Start

```bash
php artisan module:enable Seo
php artisan seo:generate-sitemap
```

---

**Ultimo Aggiornamento**: 2026-03-24
