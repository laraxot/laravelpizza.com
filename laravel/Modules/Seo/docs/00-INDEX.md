---
title: "00 INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "00 INDEX"
issues: []
discussions: []
status: superseded
superseded_by: index.md
---

> Superseded dal 2026-10-08: l'indice canonico e' [index.md](./index.md). Contenuto conservato per storia.

# 📚 Indice Documentazione Modulo Seo

**Status**: 🟡 In Progress
**Module Version**: 1.0.0

## Audit over-engineering

| Documento | Scopo |
|-----------|--------|
| [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md) | Findings Ponytail Seo (`node_modules`, interface) |
| [Hub repo](../../../../docs/audit/ponytail-audit.md) | Audit repo-wide |

## 🎯 Lettura Essenziale
1. [README.md](./README.md) - Panoramica del modulo SEO.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: AI Content Optimization & Schema.org.

## 🏗️ Core Features
- 🏷️ **Meta Tag Management** - Tag dinamici, canonical URLs, meta descriptions.
- 🗺️ **Sitemap Generation** - XML sitemap con multi-sitemap e ping automatico.
- 📱 **OpenGraph & Social** - Tags OpenGraph, Twitter Cards, social previews.
- 📊 **Schema.org Markup** - JSON-LD strutturato (Event, LocalBusiness, Article, Product).
- 📈 **SEO Analytics** - Score calculation, keyword analysis, recommendations.

## 🔗 Integration Cross-Module
- **[Schema.org Event Tasks](./task-schema-org-eventi.md)** - Task per implementazione Schema.org per eventi.
- **[Meetup: Event Series Actions](../../meetup/docs/tasks-schema-org-event-series-actions.md)** - Schema.org EventSeries.
- **[Geo: Place & GeoCircle](../../geo/docs/tasks-schema-org-place-geocircle.md)** - Schema.org Place.

## 🧪 Qualità e Testing
- ⚠️ Test suite da implementare (Pest)
- ⚠️ PHPStan Level 10 da completare

## 📦 Pacchetti Composer
- [Riferimento](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - Nessuna dipendenza diretta; usa Xot

## 🔗 Moduli Correlati
- [Xot](../../Xot/docs/readme.md) - Core framework e base classes.
- [Meetup](../../meetup/docs/readme.md) - Schema.org Event integration.
- [Geo](../../Geo/docs/README.md) - Schema.org Place integration.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
