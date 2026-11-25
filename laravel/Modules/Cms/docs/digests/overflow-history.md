---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 14 file oltre target 100.

### `wiki/content-architecture-2.md` — Documento unificato


# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [content-architecture.md](./content-architecture.md).

### `wiki/resource-table-columns.md` — Resource table columns


# Resource table columns

## BMAD story and evidence

As an administrator I need identifiable records and operational state without oversized technical columns. Acceptance: string-keyed `array<string, Column>`, fields backed by models and migrations (or Sushi schemas), sortable dates, optional technical details.

Page, Section, PageContent and Attachment use Sushi JSON schemas; preserve translatable fields and make slugs searchable. Menu parent relation is declared by recursive relationship trait.

Sources: `app/Models`, `database/migrations`, existing resource `Pages/List*.php` and `Tables/*Table.php`. QMD query attempted before editing: unavailable because better-sqlite3 ABI 127 differs from Node ABI 147; direct source inspection used.

### `wiki/topics/best-practices.md` — Topic best-practices


# Topic best-practices

Sintesi automatica di 3 documenti (chiave `best-practices`).

## Best Practices – Cms

_Fonte: `best-practices-2.md`_

# Best Practices – Cms

## Principi DRY/KISS
- **DRY**: Centralizza parsing pagine in `CmsService`. Usa cache per output renderizzato.
- **KISS**: Mantieni template semplici; evita logica complessa nelle view.
- **Clean Code**: Segui struttura `Model -> Repository -> Controller`.

## Componenti
- Usa `PageRepository` per query ricorrenti.
- Usa `BlockRenderer` per componenti modulari.


### `wiki/topics/business-logic.md` — Topic business-logic


# Topic business-logic

Sintesi automatica di 3 documenti (chiave `business-logic`).

## Cms Module - Business Logic Overview

_Fonte: `business-logic-overview.md`_

# Cms Module - Business Logic Overview

## Core Business Logic Components

### 1. Content Management System Architecture
The Cms module implements a comprehensive content management system for web applications with multi-language support and dynamic content rendering.

#### Key Models
- **Page**: Core page management with hierarchical structure and SEO optimization
- **Section**: Modular content sections with flexible block-based architecture
- **Menu**: Dynamic navigation system with role-based visibility

### `wiki/topics/content-blocks.md` — Topic content-blocks


# Topic content-blocks

Sintesi automatica di 9 documenti (chiave `content-blocks`).

## Blocchi di Contenuto

_Fonte: `blocks/content-blocks.md`_

# Blocchi di Contenuto

## Panoramica
I blocchi sono componenti riutilizzabili che permettono di costruire qualsiasi sezione di una pagina in modo modulare. Ogni blocco è progettato per essere indipendente dal contesto in cui viene utilizzato (header, content, footer, sidebar) e completamente personalizzabile.

## Principi di Design

1. **Indipendenza dal Contesto**
   - I blocchi non devono assumere una posizione specifica nella pagina
   - Lo stesso blocco può essere usato in header, content, footer o sidebar
   - La posizione è determinata da dove viene inserito, non dalla sua implementazione

### `wiki/topics/filament-blade.md` — Topic filament-blade


# Topic filament-blade

Sintesi automatica di 4 documenti (chiave `filament-blade`).

## Filament Blade Components Usage (CMS)

_Fonte: `filament-blade-components-1-2.md`_

# Filament Blade Components Usage (CMS)

## Collegamenti
- [Documentazione Root](../../../../docs/collegamenti-documentazione.md) - Indice centrale dei collegamenti
- [Documentazione in Themes/One](../../../../Themes/One/docs/filament-blade-components.md) - Contesto del tema principale

Per le best practice di **Filament** (https://filamentphp.com/docs/3.x/support/blade-components/overview), utilizziamo sempre i componenti Blade di Filament per elementi interattivi e di navigazione.

## Perché usare `<x-filament::button>`
- **Stile e coerenza**: rispetta il tema e le varianti predefinite.
- **Accessibilità e funzionali

### `wiki/topics/header-language.md` — Topic header-language


# Topic header-language

Sintesi automatica di 17 documenti (chiave `header-language`).

## Implementazione del Selettore di Lingua e Avatar Utente nell'Header

_Fonte: `sections/archive/header-language-avatar-implementation.md`_

# Implementazione del Selettore di Lingua e Avatar Utente nell'Header

## Collegamenti correlati
- [README modulo Cms](./README.md)
- [README modulo Cms](./readme.md)
- [README modulo Cms](./README.md)
- [Documentazione User](../../user/project_docs/header-language-avatar-implementation-2.md)
- [Documentazione Sezioni](./sections_structure.md)
- [Collegamenti Documentazione](/project_docs/collegamenti-documentazione.md)

## Panoramica

### `wiki/topics/legacy-roadmap.md` — Topic legacy-roadmap


# Topic legacy-roadmap

Sintesi automatica di 7 documenti (chiave `legacy-roadmap`).

## Roadmap Modulo Cms - 2026-01-30

_Fonte: `roadmap/legacy/legacy-roadmap-2.md`_

# Roadmap Modulo Cms - 2026-01-30

**Modulo**: Cms (Content Management System)
**Scopo**: Gestione contenuti dinamici con sistema blocks, pagine multi-lingua, menu gerarchici e integrazione Folio/Volt.
**Stato Generale**: 75%
**PHPStan Level 10**: 0 errori (10 suppressioni inline in app/)
**File PHP**: 111 in app/
**Test Files**: 91
**Documentazione**: 315 docs

---

### `wiki/topics/livewire-widget.md` — Topic livewire-widget


# Topic livewire-widget

Sintesi automatica di 10 documenti (chiave `livewire-widget`).

## Architecture Cms

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Cms

Show = Livewire pagina. Widget = blocks (calendar). Categorie diverse.

## Brainstorming

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming

Scartato: “tutto Livewire → widget”.

### `wiki/topics/modelli-factory.md` — Topic modelli-factory


# Topic modelli-factory

Sintesi automatica di 3 documenti (chiave `modelli-factory`).

## Analisi Modelli, Factory e Seeder - Modulo Cms

_Fonte: `modelli-factory-seeder-analisi-1.md`_

# Analisi Modelli, Factory e Seeder - Modulo Cms

## Panoramica
Questo documento analizza tutti i modelli del modulo Cms verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core CMS (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Page** | ✅ PageFactory | ✅ CmsDatabaseSeeder | Core - Pagine CMS |

### `wiki/topics/page-component.md` — Topic page-component


# Topic page-component

Sintesi automatica di 5 documenti (chiave `page-component`).

## Page Component - Data Contract

_Fonte: `components/page-component-data-contract.md`_

# Page Component - Data Contract

## Principio: $data come carrier universale

Il componente `<x-page>` usa `$data` come array generico per trasportare variabili di contesto verso i blocchi. Non conosce né dipende da specifici parametri come `container0`, `slug0`.

## API del componente

```blade
<x-page
    side="content"

### `wiki/topics/product-launch.md` — Topic product-launch


# Topic product-launch

Sintesi automatica di 3 documenti (chiave `product-launch`).

## Cms Module - Product Launch Plan

_Fonte: `product-launch-plan-2.md`_

# Cms Module - Product Launch Plan

**Module:** Cms  
**Version:** 1.0.0  
**Owner:** Product Team

---

title: "PRODUCT LAUNCH PLAN"
type: note
tags: [documentation]

### `wiki/topics/product-roadmap.md` — Topic product-roadmap


# Topic product-roadmap

Sintesi automatica di 3 documenti (chiave `product-roadmap`).

## Cms Module - Product Roadmap

_Fonte: `product-roadmap-2.md`_

# Cms Module - Product Roadmap

**Module:** Cms  
**Version:** 1.0.0  
**Owner:** Product Team  
**Status:** In Development

---

title: "PRODUCT ROADMAP"
type: note

### `wiki/topics/quality-status.md` — Topic quality-status


# Topic quality-status

Sintesi automatica di 4 documenti (chiave `quality-status`).

## Cms Module - Quality Status (November 2025)

_Fonte: `quality-status-11.md`_

# Cms Module - Quality Status (November 2025)

## 🎯 Overview

Modulo completamente compliant con PHPStan livello max (10) dopo correzione PHPDoc per UserContract.

## 📊 Static Analysis Results

### PHPStan Level MAX ✅
```bash
Status: PASSED (dopo correzione)
