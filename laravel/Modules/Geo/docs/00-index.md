# 📚 **Indice Documentazione Modulo Geo**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa, Multi-API e Comuni Italiani.
2. [roadmap.md](./roadmap.md) - Obiettivi 2026 e miglioramenti geocoding.
3. [philosophy.md](./philosophy.md) - Visione architetturale dei dati geografici.

## 🏗️ **Geocoding & Indirizzi**
- 🏠 **[Address Implementation](./address-implementation.md)** - Guida al modello Address e ai trait.
- 🎯 **[Geocoding Services](./geocoding-services-integration.md)** - Google Maps, Mapbox, Here.
- 🚚 **[Bulk Actions](./bulk-coordinate-updates.md)** - Aggiornamento massivo di coordinate.

## 🇮🇹 **Dati Italiani (Anpr/Sushi)**
- 🍕 **[Comuni Sushi](./comune-sushi-analysis.md)** - Gestione database comuni italiani in-memory.
- 🗺️ **[Polygon Data](./polygon-integration.md)** - Gestione coordinate poligonali e MySQL Spatial.

## 🎨 **Filament & UI Components**
- 📍 **[Location Selector](./location-select.md)** - Componenti di selezione visiva della mappa.
- 🛠️ **[Address Field](./address-field.md)** - Form field personalizzati per indirizzi.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Level 10](./phpstan-level10-compliance.md)** - Conformità e fix specifici per Geo.
- 🔬 **[Testing Guidelines](./testing-guidelines.md)** - Strategie di test geografico.
- 🧹 **[PHPMD & Complexity](./cyclomatic-complexity-report.md)** - Analisi della pulizia del codice.

## 📦 **Pacchetti Composer**
- [Riferimento](../../../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../../../docs/architecture/composer-packages-full-inventory.md) - Nessuna dipendenza diretta; usa Xot, Sushi (via Xot)

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Core framework e Base Models.
- [UI](../../ui/docs/readme.md) - Componenti grafici e widget mappa.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)

## Regola Operativa Obbligatoria

- Prima di modificare codice: ragionare, studiare i docs del modulo/tema, aggiornare docs/rules/memory/skills.
- Riferimento globale: [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- Memory: [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- Skill: [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)

## Docs Governance

- [Docs Health](./docs-health.md) - Stato qualità docs, checklist di confidenza e prossime azioni di manutenzione.
