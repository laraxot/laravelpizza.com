---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 403 file oltre target 100.

### `actions/generic-ui-building-blocks.md` — Generic UI Building Blocks: Category, Collection, FieldOption


# Generic UI Building Blocks: Category, Collection, FieldOption

## Scopo

Tre modelli generici, indipendenti dal dominio, pensati per essere riutilizzati da qualsiasi
modulo che abbia bisogno di tassonomie (`Category`), raggruppamenti eterogenei (`Collection`)
o opzioni per campi dinamici (`FieldOption`), senza dover reinventare la stessa tabella in
ogni modulo. Introdotti il 2026-07-15 (vedi `database/migrations/2026_07_15_1000{00,01,02}_*`).
Estendono `Modules\Xot\Models\BaseModel` (non `FormBuilder`, che non è disponibile in questo
contesto — annotato nei PHPDoc dei tre modelli).

## Stato attuale (2026-07-20)

- Nessuna risorsa Filament esiste ancora per questi modelli (`app/Filament/Resources/` è vuota,
  solo `.gitkeep`). Sono solo modelli + migrazioni, pronti per essere esposti in

### `advanced-form-components.md` — Componenti Form Avanzati


# Componenti Form Avanzati

## 📝 Input Avanzati

### Input con Icona
```html
<div class="input-group">
  <span class="input-group-text">
    <i class="fas fa-user"></i>
  </span>
  <input type="text" class="form-control" placeholder="Username">
</div>
```

### Input con Validazione
```html
<div class="form-group">
  <label for="email">Email</label>
  <input

### `algolia-docsearch-1.md` — Algolia DocSearch {#algolia-docsearch}


# Algolia DocSearch {#algolia-docsearch}

This starter template includes support for [DocSearch](https://community.algolia.com/docsearch/), a documentation indexing and search tool provided by Algolia for free. To configure this tool, you’ll need to sign up with Algolia and set your API Key and index name in `config.php`. Algolia will then crawl your documentation regularly, and index all your content.

[Get your DocSearch credentials here.](https://community.algolia.com/docsearch/#join-docsearch-program)

```php
// config.php
return [
    'docsearchApiKey' => '',
    'docsearchIndexName' => '',
];
```

Once the `docsearchApiKey` and `docsearchIndexName` values are set in `config.php`, the search field at the top of the page is ready to use.

<img class="block m-auto" src="/assets/img/doc

### `architecture-2.md` — $MOD Architecture


# $MOD Architecture

Core components and design decisions.

## Structure

- `app/Models/` — Eloquent models
- `app/Actions/` — Business logic (QueueableAction)
- `app/Filament/Resources/` — Admin resources
- `app/Filament/Pages/` — Admin pages
- `config/` — Configuration
- `database/migrations/` — Database schema
- `lang/` — Translations

See README.md for overview. See CONTRIBUTING.md for development workflow.
---
title: "ARCHITECTURE"
type: note
tags: [documentation]

### `architecture-3.md` — UI Module - Architecture Guide (2025)


# UI Module - Architecture Guide (2025)

> **Last Updated:** 2025-11-19
> **PHPStan Level:** 10
> **Status:** Shared UI Components & Filament Customizations

## Table of Contents

1. [Module Overview](#module-overview)
2. [Key Components](#key-components)
3. [Architecture](#architecture)
4. [Integration Guide](#integration-guide)
5. [Code Quality](#code-quality)

---

## Module Overview

### Primary Purpose

### `architecture-archive-1.md` — UI Module - Architecture Guide (2025)


# UI Module - Architecture Guide (2025)

> **Last Updated:** 2025-11-19
> **PHPStan Level:** 10
> **Status:** Shared UI Components & Filament Customizations

## Table of Contents

1. [Module Overview](#module-overview)
2. [Key Components](#key-components)
3. [Architecture](#architecture)
4. [Integration Guide](#integration-guide)
5. [Code Quality](#code-quality)

---

## Module Overview

### Primary Purpose

### `architecture-patterns.md` — Architecture Patterns — UI Module


# Architecture Patterns — UI Module

> **Component Library & Design System.** Reusable Blade components, design tokens, and frontend patterns for consistent UI across Laraxot applications.

## Overview

The UI module provides:
- **Blade Components** (5+ core components)
- **Design System** (Bootstrap Italia / Design Comuni integration)
- **Datas/DTOs** (Type-safe configuration objects)
- **Contracts** (Interface definitions for theming)
- **Services** (Component rendering and theming)
- **Livewire Integration** (Dynamic component updates)
- **Icons & Branding** (SVG icons, brand assets)

## Architettura Principale

### 1. Component Architecture


### `architecture.md` — UI Module - Architecture Guide (2025)


# UI Module - Architecture Guide (2025)

> **
> **PHPStan Level:** 10
> **Status:** Shared UI Components & Filament Customizations

## Table of Contents

1. [Module Overview](#module-overview)
2. [Key Components](#key-components)
3. [Architecture](#architecture)
4. [Integration Guide](#integration-guide)
5. [Code Quality](#code-quality)

---

## Module Overview

### Primary Purpose

### `audit-columns-laraxot-compliance.md` — Audit e Correzione Colonne Filament - Modulo UI


# Audit e Correzione Colonne Filament - Modulo UI

**Status**: ✅ COMPLETATO

## Analisi Completa

Verificati tutti i file nella cartella `Modules/UI/app/Filament/Tables/Columns` per conformità alla filosofia Laraxot.

## File Analizzati

### ✅ File Corretti (già conformi)

1. **IconColumn.php** - Estende `XotBaseIconColumn` ✅
2. **IconStateColumn.php** - Estende `XotBaseIconColumn` ✅
3. **GroupColumn.php** - Estende `XotBaseColumn` ✅
4. **IconStateGroupColumn.php** - Estende `XotBaseColumnGroup` ✅

### ❌ File Corretti (violazioni risolte)


### `audits/quality-gates.md` — UI quality gate audit


# UI quality gate audit

Conditional tenant-default tests use PHPUnit's supported skip API and remain
explicit about why the fixture cannot be observed in a tenant-configured run.

### `best-practices-1.md` — Best Practices UI


# Best Practices UI

## Principi Generali

### 1. Consistenza
- Utilizzare componenti standard
- Mantenere uno stile uniforme
- Seguire le convenzioni di naming
- Riutilizzare pattern comuni

### 2. Accessibilità
- Supportare la navigazione da tastiera
- Utilizzare attributi ARIA
- Mantenere contrasto adeguato
- Fornire testi alternativi

### 3. Performance
- Ottimizzare il caricamento
- Minimizzare le dipendenze

### `binary-assets.md` — Asset binari


# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.

### `blade-data-handling-1.md` — Data Handling in Blade Components


# Data Handling in Blade Components

This document outlines best practices for data handling in Blade components, particularly in theme blocks used for content sections.

## Core Principles

### 1. Explicit Props Definition

All Blade components should explicitly define their expected properties using the `@props` directive:

```blade
@props([
    'title' => null,
    'description' => null,
    'url' => null,
    'items' => [],
    // Additional props with sensible defaults
])
```

### `blocks-system-1.md` — Sistema di Blocchi


# Sistema di Blocchi

## Introduzione
Il sistema di blocchi di il progetto è un'architettura modulare che permette di costruire pagine e componenti attraverso blocchi riutilizzabili. Ogni blocco è un componente Filament che genera una struttura JSON standardizzata e viene renderizzato attraverso un componente Blade dedicato.

## Architettura

### Struttura Base
```
laravel/Modules/Cms/
├── app/
│   └── Filament/
│       └── Blocks/           # Definizioni Filament dei blocchi
├── Resources/
│   └── views/
│       └── components/
│           └── blocks/       # Componenti Blade per il rendering
└── docs/
    └── blocks/              # Documentazione dei blocchi

### `bmad/advanced-form-components.md` — Componenti Form Avanzati


# Componenti Form Avanzati

## 📝 Input Avanzati

### Input con Icona
```html
<div class="input-group">
  <span class="input-group-text">
    <i class="fas fa-user"></i>
  </span>
  <input type="text" class="form-control" placeholder="Username">
</div>
```

### Input con Validazione
```html
<div class="form-group">
  <label for="email">Email</label>
  <input

### `bmad/architecture/module-boundary.md` — UI — architettura

# UI — architettura

## Scopo osservato

Componenti UI riutilizzabili e design system. Scheda derivata da `module.json`, struttura `app/` e conteggi del repository; non sostituisce decisioni architetturali non ancora approvate.

## Inventario verificato

- PHP in `app/`: 121 file.
- Test PHP in `tests/`: 77 file.
- Aree applicative: `Enums`, `Forms`, `Http`, `Filament`, `Services`, `Contracts`, `Models`, `Console`, `Data`, `Actions`, `Traits`, `Providers`, `View`, `Rules`, `Datas`, `Livewire`, `Adapters`.
- Persistenza: `database/factories`, `database/migrations`, `database/seeders` presenti.

## Confini

Il modulo espone risorse, azioni e contratti verso i consumatori; la logica di dominio deve restare nelle Action e nei modelli del modulo. Le dipendenze verso Xot, User, Tenant e UI vanno

### `bmad/architecture.md` — UI — Architettura


# UI — Architettura

## Scopo
Componenti UI / Tema.

## Componenti
- `UI/Filament/` — interfacce Filament 5 (se applicabile)
- `UI/Actions/` — azioni (Spatie Queueable se richiesto)
- `UI/Models/` — estende XotBase (se applicabile)

## Qualità
- PHPStan: OK (0 errori)
- Conflicts: 0
- Lock: 0 attivi

## Milestones Domani
1. Verificare conformità con XotBase
2. Aggiornare `docs/bmad/stories/continuazione-domani.md` se chiuso
3. Indicare stato concluso in `docs/sprint-status.yaml`

### `bmad/audit.md` — Audit BMAD — UI


# Audit BMAD — UI

SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md) · scopo: [../wiki/purpose.md](../wiki/purpose.md)

**In una frase:** UI è il vocabolario visivo condiviso (componenti, widget, colonne, layout tabella): fa sì che la stessa cosa abbia lo stesso aspetto e lo stesso comportamento in tutti i moduli che lo consumano.

## Inventario misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 133 |
| Test PHP | 87 |
| Models | 4 |
| Policy (`return true`) | 1 (2) |
| Resource | 0 |
| Widget | 12 |
| Actions | 6 in `app/Actions/*.php` (11 file PHP con `Action` nel percorso) |
| Services | 5 |
| Migration | 3 |

### `bmad/audits/ui-audit.md` — Audit approfondito — UI


# Audit approfondito — UI

## Scopo (il perché)

UI è il **vocabolario visivo condiviso**: la stessa cosa ha lo stesso aspetto e comportamento
in tutti i moduli (colonne, widget, layout tabella, blocchi, icone). Non ha dominio HR e non
ha Resource proprie: è una libreria consumata da Xot, User, Incentivi, Indennita*
([purpose.md](../../wiki/purpose.md)). Il rischio qui è la **deriva**: componenti demo, dati finti e
stringhe letterali che si propagano a tutti i consumatori.

## Metodo

Source-first, 2026-11-16: `find`/`grep` su `app/`, `tests/`, `database/`; lettura di
`Filament/Pages/Dashboard.php`, `Models/Policies/UiBasePolicy.php`, `Filament/Components/Schema/PersonForm.php`,
`Services/*`, 3 test di modello; PHPStan sul solo modulo. Nessuna UI inventata, nessun DB toccato.

## Inventar

### `bmad/bmad-dossier.md` — UI — BMAD dossier

# UI — BMAD dossier
## Product brief / PRD
Provide one accessible shared UI vocabulary instead of module-specific forks.
## Architecture / UX / security
UI supplies presentation contracts/options; themes compose them and domain modules retain meaning/validation.
## Epics and stories
Component contract; accessibility states; deprecation/duplication cleanup.
## Gaps / release
Complete inventory, keyboard/focus/contrast states and version/deprecation policy need a verified catalog.

### `bmad/brainstorming/module-opportunities.md` — UI — brainstorming

# UI — brainstorming

## Punto di partenza

Componenti UI riutilizzabili e design system. L'inventario corrente misura 121 file applicativi e 77 file di test.

## Domande ad alto valore

- Quale problema utente risolve il modulo e quale comportamento è vincolante?
- Quali dati sono autorevoli e quali sono proiezioni o cache?
- Quali ruoli possono leggere, creare, modificare o approvare?
- Quale errore deve essere osservabile senza esporre dati sensibili?
- Quale parte è riusabile e quale è specifica del dominio PTVX?

## Ipotesi da validare

- Le Action sono il punto di orchestrazione del caso d'uso.
- Le Resource Filament sono adattatori, non il luogo della regola di business.
- I test esistenti sono evidenza parziale e vanno confrontati con i flussi esposti.


### `bmad/brainstorming.md` — UI — Brainstorming

title: "UI - Brainstorming"
type: note
tags: [bmad, ui, brainstorming, decisioni]
created: 2026-09-28
bmad_status: active
qmd: "UI brainstorming duplicazioni trait enum Map fallback dati config decisioni aperte"
module: UI
related:
  - ./brainstorming/module-opportunities.md
  - ./architecture.md
  - ./architecture/module-boundary.md
  - ./epics/epic-1-design-system-components.md
  - ./stories/story-ui-table-layout-enum-translations.md
---

# UI — Brainstorming
scope: ui-docs
updated: 2026-10-07
---


### `bmad/decision-log.md` — Decision log — UI


# Decision log — UI

## Audit source-first 2026-11-16

Decisioni proposte dall'audit. Formato: ADR breve (stato, impatto, decisione, perché, evidenza).

### ADR-UI-01 — Dashboard UI senza dati finti

- **Data:** 2026-11-16
- **Stato:** PROPOSTA (da approvare dal titolare del modulo; nessun codice cambiato dall'audit)
- **Impatto:** Medio
- **Decisione:** La dashboard del pannello `ui::admin` mostra solo widget reali; `TestWidget`/`TestChartWidget` passano a `tests/Fixtures`.
- **Perché:** Un admin non deve leggere metriche inventate; UI è il vocabolario condiviso, non una vetrina.
- **Evidenza:** [audits/ui-audit.md](./audits/ui-audit.md)

### ADR-UI-02 — Nessun test per modelli inesistenti

- **Data:** 2026-11-16
- **Stato:** PROPOSTA (da approvare dal titolare del modulo; nessun codice 

### `bmad/epics/epic-1-design-system-components.md` — Epic 1 — Consolidamento primitive Form/Table


# Epic 1 — Consolidamento primitive Form/Table
  - ../../../../Xot/docs/bmad-method.md
---

# Epic 1 - Consolidamento primitive Form/Table

> **SUMMARY**: epic che porta le primitive del design system UI a una sola sorgente per layout tabella, enum layout, fallback Map/Geocoding e data object, e allinea la copertura Pest. Scope limitato a `app/Traits`, `app/Filament/Actions/Table`, `app/Enums`, `app/Services/Map`, `app/Adapters/Map`, `app/Data`, `app/Datas`, `config/`.

## Numero e nome

Epic 1 — "UI primitives: un SSoT per layout, enum, fallback e data".

## Perché ora

Le duplicazioni rilevate in [../brainstorming.md](../brainstorming.md) sono tutte all'interno del modulo e hanno effetti osservabili: due trait con gli stessi metodi, due enum con scopi diversi, due fallback Map identici,

### `bmad/epics/module-roadmap.md` — UI — epic roadmap

# UI — epic roadmap

## Epic A — Contratto e architettura

Documentare API pubbliche, dipendenze, confini e invarianti del modulo.

## Epic B — Qualità verificabile

Ridurre finding PHPStan, mantenere test Pest eseguibili e registrare evidence ripetibile.

## Epic C — UX e integrazione

Verificare parità Form/Table, traduzioni, autorizzazioni, error handling e integrazioni dichiarate.

## Epic D — Documentazione viva

Collegare ogni decisione a story BMAD, mantenere il second brain e chiudere i duplicati senza cancellare storia.

## Definition of Done


### `bmad/epics.md` — Epic e story — UI


# Epic e story — UI

Scopo del modulo: vocabolario visivo condiviso (componenti, widget, colonne, layout tabella) consumato da tutti i moduli ([../wiki/purpose.md](../wiki/purpose.md)).

## Epic da audit 2026-11-16

Ogni story nasce da un finding di [audits/ui-audit.md](./audits/ui-audit.md); prima del fix:
lock (`bashscripts/lock/lock.sh`), Pest rosso, PHPStan max, poi `unlock.sh`. Nessun `migrate:fresh`, solo migrate additivo.

### Epic UI-A — Rimuovere demo e dati finti (P1)

| Story (da creare) | Cosa | Criterio di accettazione |
|---|---|---|
| `ui-dashboard-real-widgets` | Dashboard con soli widget reali o vuota | nessun valore letterale in `Dashboard.php`; `TestWidget` solo in tests |
| `ui-remove-phantom-model-tests` | Eliminare Asset/Component/ThemeModelTest | 0 `@phpstan-ignore` in `tests/Uni

### `bmad/livewire-inventory.md` — Inventario UI: Livewire HTTP → Filament widget


# Inventario UI: Livewire HTTP → Filament widget

Questo file è la SSoT per il modulo UI sul tema "conversione Livewire → widget Filament". Story **12.1 implementata**: ritirato l'HTTP `DarkModeSwitcher`; `Toast` resta. Gli altri documenti in `docs/bmad/` che trattano lo stesso argomento vanno letti come satelliti di questo, non come fonti alternative (vedi la sezione "Correzione" più sotto).

Questo file è la SSoT per il modulo UI sul tema "conversione Livewire → widget Filament". Story **12.1 implementata**: ritirato l'HTTP `DarkModeSwitcher`; `Toast` resta. Allineamento fleet **W0 ✓** (2026-10-20): [inventario Xot](../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md) · [fleet story](../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md): panel-first **REUSE*

### `bmad/philosophy.md` — UI Module: Philosophy, Purpose, and Design Principles


# UI Module: Philosophy, Purpose, and Design Principles

**Date:** December 23, 2025

## 🎯 Purpose and Core Responsibilities

The `UI` module is the dedicated component responsible for managing and standardizing the application's User Interface (UI) elements, components, and overall presentation logic. Its core purpose is to provide a consistent, reusable, and efficient foundation for frontend development across all other modules. Given the minimalist nature of its `ServiceProvider`, the module is designed to:

1.  **Modular UI Component Discovery:** Serve as the central mechanism for discovering and registering modular Blade components, Livewire components, and other UI-related assets that can be reused throughout the application. The `getComponentViewPath()` method, leveraging `GetModul

### `bmad/piano-miglioramento.md` — Piano di miglioramento — UI


# Piano di miglioramento — UI

Derivato dall'[audit](./audits/ui-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 2) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (5) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 87 test / 133 app PHP).
3. Allineare Filament (resources=0) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2


### `bmad/quick-reference.md` — UI — BMAD Quick Reference


# UI — BMAD Quick Reference

type: note
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   bmad quick reference ui"

# UI: BMAD Quick Reference

## Comandi Rapidi

### Workflow UI

```bash
# Phase 1
bmad-domain-research      # Studio design system
bmad-technical-research   # Valutazione stack


### `bmad/readme-en.md` — 🎨 UI — English presentation


# 🎨 UI — English presentation

[![Domain-UI](https://img.shields.io/badge/Domain-UI%20Kit-7B1FA2.svg)](#)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Laravel 13](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/b

### `bmad/setup-guide.md` — UI — BMAD Setup Guide


# UI — BMAD Setup Guide

type: note
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   bmad setup guide ui"

# UI: BMAD Setup Guide

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo UI.

## Struttura Directory (Canonical)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati
- **`docs/bmad/`**: questa documentazione

### `bmad/status.md` — status


BMAD STATUS — UI
- Inventario docs: docs/, docs/wiki/, docs/prd.json, docs/Config.bak/
- PHPStan: 0 errori (OK)
- Wiki aggiornata: docs/wiki/scope.md (scopo: componenti visivi riusabili, contratti blocchi/temi)

### `bmad/stories/0001-phpstan-ui-fixes.story.md` — Story: Fix PHPStan Level 10 Errors in UI Module

# Story: Fix PHPStan Level 10 Errors in UI Module

## Context and Problem Statement

UI module has test file errors referencing non-existent Ptv module.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0002-adr-numbered-madr-template.story.md` — UI ADR — prefisso NNNN + template MADR harness


# UI ADR — prefisso NNNN + template MADR harness

## Context and Problem Statement

Regola utente: ogni `docs/adr` segue il template harness e il basename
`NNNN-slug.md` (eccezioni: README, INDEX/index, 0000-template). Il contenuto
canonico IDColumn viveva in `id-column-mandatory-on-tables.md` senza prefisso.
Come allineare gli ADR UI a `NNNN-slug.md` + sezioni MADR inglesi senza
toccare PHP?

## Decision Drivers

- Basename obbligatorio `NNNN-` (nessun ADR kebab-only non numerato, salvo stub
  superseded / eccezioni naming).
- SSoT content: contenuto canonico IDColumn → `0002-idcolumn-mandatory-on-tables.md`.
- No PHP: solo docs ADR + story + sprint-status.
- Template harness + sezioni MADR inglesi in README / `0000-template.md`.

## Considered Options

### `bmad/stories/0005-cluster3-phpstan-swarm-2.story.md` — UI — swarm cluster3 PHPStan 2026-10-06

# UI — swarm cluster3 PHPStan 2026-10-06

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0006-cluster3-phpstan-swarm-3.story.md` — UI — swarm cluster3 PHPStan 2026-10-06

# UI — swarm cluster3 PHPStan 2026-10-06

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0007-continuazione-domani.story.md` — Continuazione domani

# Continuazione domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0008-docs-zen-conventions.story.md` — UI — bonifica docs `.md`

# UI — bonifica docs `.md`

## Context and Problem Statement

Lane C dello swarm `laravel/Modules/Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md`: copie esatte
(`wiki/ui/UI-*.md` vs `ui-*.md`, `_archive/` vs `archive/`), nomi `_1`/underscore/UPPERCASE, template generici.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

### `bmad/stories/0009-ensures-ui-database-schema-trait-unused.story.md` — ensures-ui-database-schema-trait-unused

# ensures-ui-database-schema-trait-unused

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0010-filament-layout-directives.story.md` — Direttive Filament nel layout UI

# Direttive Filament nel layout UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0011-git-status-fleet-merge-markers-ui.story.md` — git-status-fleet-merge-markers-ui

# git-status-fleet-merge-markers-ui

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0013-module-bmad-audit.story.md` — Story — UI: baseline BMAD

# Story — UI: baseline BMAD

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0017-phpstan-modules-zero.story.md` — Story: PHPStan Modules/UI → 0

# Story: PHPStan Modules/UI → 0

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0023-ui-guest-header-ux-3.story.md` — Story

# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/continuazione-domani.md` — UI — Continuazione Domani

# UI — Continuazione Domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/story-ui-table-layout-enum-translations.md` — Problema

# Problema

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `brands-icons-integration.md` — 🎨 UI Brands Icons - Integration Guide


# 🎨 UI Brands Icons - Integration Guide

**Data**: 2026-03-30  
**Stato**: ✅ **INTEGRATO**

## 📦 Icons Created

### Social Media Brands (6)

1. ✅ **facebook.svg** - Facebook brand icon
2. ✅ **twitter.svg** - Twitter/X brand icon
3. ✅ **youtube.svg** - YouTube brand icon
4. ✅ **telegram.svg** - Telegram brand icon
5. ✅ **whatsapp.svg** - WhatsApp brand icon
6. ✅ **rss.svg** - RSS feed brand icon

**Path**: `laravel/Modules/UI/resources/svg/brands/`

## 🔧 Integration

### `brands-icons.md` — UI Brands Icons - Documentazione


# UI Brands Icons - Documentazione

## Panoramica

Il modulo UI fornisce un set di icone SVG per i brand social media, registrate automaticamente con il prefisso `ui-brands`.

## Icone Disponibili

Le icone sono posizionate in `Modules/UI/resources/svg/brands/`:

- `facebook.svg` → `<x-icon name="ui-brands.facebook" />`
- `twitter.svg` → `<x-icon name="ui-brands.twitter" />`
- `instagram.svg` → `<x-icon name="ui-brands.instagram" />`
- `linkedin.svg` → `<x-icon name="ui-brands.linkedin" />`
- `youtube.svg` → `<x-icon name="ui-brands.youtube" />`
- `telegram.svg` → `<x-icon name="ui-brands.telegram" />`
- `whatsapp.svg` → `<x-icon name="ui-brands.whatsapp" />`
- `rss.svg` → `<x-icon name="ui-brands.rss" />`

### `bugfix/groupcolumn-architectural-violations.md` — Bugfix: GroupColumn Architectural Violations


# Bugfix: GroupColumn Architectural Violations

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**Multiple Violazioni Regole Architetturali Laraxot** nel file `GroupColumn.php` e relativa view.

## 🔴 Violazioni Critiche

### 1. Reference Diretta a Classe Filament

```php
// ❌ PRIMA - Linea 28
return $item instanceof \Filament\Tables\Columns\Column;
```

**Violazione**: MAI referenziare classi Filament direttamente

### `bugfix/groupcolumn-iconcolumn-shows-raw-state.md` — Bugfix — IconColumn in GroupColumn → `"1"`


# Bugfix — IconColumn in GroupColumn → `"1"`

## Sintomo

`IconColumn::make('ha_diritto')->boolean()` dentro `GroupColumn` mostrava il testo `1` (o `Ha diritto: 1`), non l’icona Heroicon. Lo stesso IconColumn standalone funzionava.

## Causa

`ui::filament.tables.columns.group` concatenava lo **state grezzo** e lo stampava con `{{ }}`. Non chiamava `toEmbeddedHtml()`. `ha_diritto` in DB è int `0|1` → dump letterale `"1"`.

## Fix

1. `GroupColumn::table()` / `schema()` propagano la Table alle child
2. View: `$field->table($getTable())` + `record()` + `clearCachedState()`
3. Visual → `{!! $field->toEmbeddedHtml() !!}`; Text → path testo storico

## Regressione correlata

Dopo `toEmbeddedHtml()`, senza mount Table → `LogicException: The column [id] is not mounted to a table` (lista schede).

### `bugfix/iconcolumn-extends-filament-column.md` — Bugfix: IconColumn Estende Direttamente Filament Column


# Bugfix: IconColumn Estende Direttamente Filament Column

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**Violazione Regola Architetturale Laraxot**:

Il file `Modules/UI/app/Filament/Tables/Columns/IconColumn.php` estendeva direttamente `Filament\Tables\Columns\Column`, violando il principio fondamentale:

> **MAI estendere classi Filament direttamente - utilizzare sempre classi XotBase**

## Causa Radice

**Mancanza di Classe Base XotBase per Colonne**:

1. Non esisteva `XotBaseColumn` per le colonne delle tabelle
2. `IconColumn` del modulo UI estendeva direttamente `Column` di Filament

### `bugfix/iconcolumn-view-path-fix.md` — Bugfix: IconColumn View Path Mismatch


# Bugfix: IconColumn View Path Mismatch

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**View Path Non Corrispondente**:

Il file `IconColumn.php` referenziava una view che non esisteva:

```php
protected string $view = 'ui::filament.tables.columns.icon-column';
// Cercava: icon-column.blade.php
// Esisteva: icon.blade.php
```

**Impatto**: Errore 404 quando la colonna veniva renderizzata.


### `bugfix-address-field-hydration.md` — Bug Fix: AddressField non idratava lo stato + cleanup phpmd


# Bug Fix: AddressField non idratava lo stato + cleanup phpmd

## Problema

`Modules/UI/app/Filament/Forms/Components/AddressField.php` costruiva l'array
`$data` (dai valori di default o dalla relazione caricata) dentro
`afterStateHydrated()` ma non chiamava mai `$component->state($data)`.
Il risultato veniva scartato: il campo indirizzo non veniva mai idratato con i
valori esistenti del record (bug funzionale, non solo un warning phpmd
`UnusedLocalVariable`).

## Fix

- Aggiunta la chiamata `$component->state($data)` in entrambi i rami (record
  assente e record con/senza relazione caricata), seguendo lo stesso pattern
  già usato in `Modules/Geo/app/Filament/Forms/Components/AddressInput.php`.
- Rinominato il parametro `$_component` in `$component` dato che ora viene
  utilizzato.


### `bugfix-icons-missing.md` — bugfix-icons-missing


See canonical documentation: ../../../Themes/docs/shared-components/bugfix-icons-missing.md

### `bugfix-table-layout-action.md` — Bug Fix: TableLayoutToggleTableAction Access Level Error - 27 Gennaio 2025


# Bug Fix: TableLayoutToggleTableAction Access Level Error - 27 Gennaio 2025

## Problema Identificato

**Errore**: `Symfony\Component\ErrorHandler\Error\FatalError - Internal Server Error`
**Messaggio**: `Access level to Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction::getCurrentLayout() must be public (as in class Modules\UI\Filament\Actions\Table\HasTableLayout)`

## Causa Radice

La classe `TableLayoutToggleTableAction` aveva due problemi principali:

1. **Import del trait sbagliato**: Stava importando `Modules\UI\Traits\TableLayoutTrait` invece di `Modules\UI\Filament\Actions\Table\TableLayoutTrait`
2. **Classe base errata**: Estendeva `Filament\Actions\Action` invece di `Filament\Tables\Actions\Action`

## Soluzioni Implementate

### 1. Correzione Import Trait

**Prim

### `bugfix-table-layout-toggle-not-working.md` — Bug: «Cambia layout» non alterna lista/griglia


# Bug: «Cambia layout» non alterna lista/griglia

## Scopo del bottone (business)

Il bottone **Cambia layout** (`TableLayoutToggleTableAction`) è un controllo **solo UX** sulle liste Filament: consente all’operatore di passare tra due presentazioni degli **stessi record**, senza modificare query, filtri o dati.

| Layout | Esperienza utente | Caso d’uso |
|--------|-------------------|------------|
| **Lista** | Tabella classica righe/colonne | Confronto denso di molti campi (es. ASZ in Progressioni) |
| **Griglia** | Card responsive | Scansione visiva con meno colonne per card |

È registrato automaticamente da `HasXotTable::getTableHeaderActions()` su tutte le `XotBaseListRecords`.

## Sintomo

- Il bottone è visibile in header tabella (es. `/progressioni/admin/asz00fs`).
- Dopo il cli

### `case-conflicts.md` — Case-Insensitive File Conflicts


# Case-Insensitive File Conflicts

File duplicati rilevati nel modulo `UI`:

- `Modules/UI/.github`: `CONTRIBUTING.md`, `contributing.md`
- `Modules/UI/.github`: `SECURITY.md`, `security.md`
- `Modules/UI/docs`: `README.md`, `readme.md`
- `Modules/UI/docs/filament`: `ListRecords.md`, `listrecords.md`

- `Modules/UI/.github`: `CONTRIBUTING.md`, `CONTRIBUTING.md`
- `Modules/UI/.github`: `SECURITY.md`, `SECURITY.md`
- `Modules/UI/docs`: `README.md`, `README.md`
- `Modules/UI/docs/filament`: `listrecords.md`, `listrecords.md`

Uniformare ciascuna coppia scegliendo un'unica versione (in genere `README.md`, `CONTRIBUTING.md`, ecc.) e rimuovere i duplicati.

### `chart-components-1.md` — Componenti Chart


# Componenti Chart

## Introduzione
I componenti chart forniscono visualizzazioni grafiche dei dati, utilizzando Chart.js come motore di rendering. Supportano vari tipi di grafici e sono altamente personalizzabili.

## Componenti Disponibili

### LineChart
```blade
<x-ui::line-chart
    :title="'Andamento Utenti'"
    :labels="['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu']"
    :datasets="[
        [
            'label' => 'Nuovi Utenti',
            'data' => [65, 59, 80, 81, 56, 55],
            'borderColor' => '#4CAF50',
            'tension' => 0.1
        ]

### `charts/chartjs-datalabels-multiple-labels-complete-guide.md` — Guida Completa: Multiple Labels con chartjs-plugin-datalabels in Filament 5.x (Modulo UI)


# Guida Completa: Multiple Labels con chartjs-plugin-datalabels in Filament 5.x (Modulo UI)

**Versione:** 1.0
**Data:** Gennaio 2026
**Target:** Filament 5.x, Laravel 12.x, Modulo UI
**Livello:** Guida "a prova di stupido" - passo dopo passo

> **Riferimento Ufficiale:** [chartjs-plugin-datalabels - Multiple Labels Sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)
> **Guida Generale:** [Guida Completa Chart Module](chartjs-datalabels-multiple-labels-complete-guide.md)

---

## 📋 Indice

1. [Introduzione](#introduzione)
2. [Prerequisiti Modulo UI](#prerequisiti-modulo-ui)
3. [Installazione nel Modulo UI](#installazione-nel-modulo-ui)
4. [Configurazione Widget UI](#configurazione-widget-ui)
5. [Esempi Specifici UI](#esempi-specifici-ui)

### `charts/chartjs-plugin-datalabels-filament5.md` — chartjs-plugin-datalabels with Filament 5 ChartWidget (multiple labels)


# chartjs-plugin-datalabels with Filament 5 ChartWidget (multiple labels)

## Goal

Use `chartjs-plugin-datalabels` to render **multiple labels per slice/bar** in a Filament v5 `ChartWidget`, following the project standards:

- Filament v5 plugin registration via `window.filamentChartJsPlugins`
- Asset build via Vite
- Asset registration via `FilamentAsset`
- Chart configuration via `getOptions()` (use `RawJs` when you need JavaScript callbacks)

This guide is based on the official sample:

- [chartjs-plugin-datalabels – multiple labels sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html "chartjs-plugin-datalabels – multiple labels sample")

## What “multiple labels” means in chartjs-plugin-datalabels

`chartjs-plugin-datalabels` supports multiple l

### `charts/export-strategy.md` — Chart Export Strategy (PNG/SVG)


# Chart Export Strategy (PNG/SVG)

> **Goal**: Allow users to download Filament charts as images (PNG) or vectors (SVG) for reports.

## 1. Primary Strategy: PNG via Client-Side JS

This is the most robust and simplest method. It uses the browser's ability to convert the HTML5 Canvas to an image.

### How Implementing

You need to interact with the underlying Chart.js instance.

#### A. The JavaScript Helper

Create a helper function in your JS asset:

```javascript
// resources/js/chart-export.js


### `charts/filament-chart-js-guide.md` — Filament Chart.js Guide


# Filament Chart.js Guide

> **Why this guide?**: To standardize how we use Chart.js in Filament, especially regarding advanced features like plugins (Zoom, Annotations) which are not enabled by default.

## 1. Basic Usage (Filament Standard)

Filament wraps Chart.js. Always use `XotBaseWidget` if available, or standard Filament `ChartWidget`.

```php
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [

### `charts/server-side-actions.md` — Server-Side Chart Generation Actions


# Server-Side Chart Generation Actions

> **Purpose**: Generate chart images (PNG/SVG) in background jobs (Queueable Actions) for email attachments or PDF reports.

## 📋 Prerequisites

Since PHP cannot execute JavaScript (required for Chart.js), we use **Standard Headless Browser** approach.

```bash
composer require spatie/browsershot
npm install puppeteer
```

---

## 📸 Action 1: Generate PNG (Best for Email/PDF)

This action renders the chart widget in a headless browser and takes a screenshot.


### `charts/shared-hosting-strategy.md` — Shared Hosting Chart Strategy (No NPM/Node)


# Shared Hosting Chart Strategy (No NPM/Node)

> **Purpose**: Generate chart images in background jobs on **Shared Hosting environments** where you cannot install Node.js/Puppeteer (`browsershot` is not an option).

## ⚠️ Privacy Warning
This method uses an external API (**QuickChart.io**).
-   **Your data leaves the server.**
-   Do **NOT** use this for strictly confidential data (PII, financial secrets) unless you host your own QuickChart instance or trust the service.
-   The Community Edition of QuickChart is open source and can be self-hosted on a cheap VPS or Docker container if needed.

## 🛠️ The Solution: Remote Rendering API

Instead of rendering the chart locally with Headless Chrome, we send the chart configuration (JSON) to a remote service which returns the image.

### Depend

### `chunk.md` — chunk


https://github.com/owainjones74/filament-chunked-file-uploads/tree/main

### `clean-code/wizard-schema-aration.md` — Separazione dello Schema dagli Step nei Wizard Filament


# Separazione dello Schema dagli Step nei Wizard Filament

## Regola Fondamentale

Quando si implementano gli step di un wizard Filament, è necessario **separare la definizione dello schema dalla definizione dello step stesso**. Questo è un'applicazione del principio di Responsabilità Singola (SRP) del Clean Code.

## Implementazione Corretta

```php
// ✅ CORRETTO: Schema definito in un metodo separato
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema(self::getPrivacyStepSchema());
}

protected static function getPrivacyStepSchema(): array
{
    return [

### `cms-link-1.md` — Collegamenti al Modulo Cms


# Collegamenti al Modulo Cms

Questo documento fornisce collegamenti bidirezionali tra il modulo UI e il modulo Cms.

## Integrazione UI e Frontend

Secondo le regole di organizzazione della documentazione:
- La documentazione dei componenti UI va nel modulo UI
- La documentazione del frontend va nel modulo Cms

## Collegamenti Principali

- [Documentazione Frontend](../../Cms/docs/frontoffice.md) - Documentazione completa sul frontend
- [Componenti Blade](../../Cms/docs/components.md) - Documentazione sui componenti Blade nel frontend
- [Blocchi di Contenuto](../../Cms/docs/blocks.md) - Documentazione sui blocchi di contenuto
- [Filament Integration](../../Cms/docs/filament.md) - Integrazione con Filament

## Utilizzo dei Componenti UI nel Frontend


### `cms-themes-link.md` — Collegamenti ai Temi nel Modulo Cms


# Collegamenti ai Temi nel Modulo Cms

Questo documento fornisce collegamenti bidirezionali tra il modulo UI e il modulo Cms per quanto riguarda i temi.

## Documentazione dei Temi

Secondo le regole di organizzazione della documentazione:
- La documentazione dei componenti UI va nel modulo UI
- La documentazione del frontend va nel modulo Cms
- La documentazione dei temi è distribuita tra entrambi i moduli

## Collegamenti ai Temi nel Modulo Cms

- [Compilazione dei Temi](../../Cms/docs/theme_compilation.md) - Processo di compilazione e pubblicazione dei temi
- [Processo di Build del Tema](../../Cms/docs/theme-build-process.md) - Dettagli sul processo di build
- [Struttura dei Temi](../../Cms/docs/themes/structure.md) - Organizzazione dei file nei temi
- [Frontoffice](../../Cms/docs/fron

### `code-quality-analysis.md` — Analisi Qualità Codice - Modulo UI


# Analisi Qualità Codice - Modulo UI

## Data
[DATE]

## Strumenti Utilizzati

### PHPStan Livello 10
- **Status**: ✅ Eseguito
- **Errori trovati**: 1 errore
- **Livello**: 10 (massimo)

### Rector
- **Status**: ✅ Configurazione presente (`rector.php`)
- **Versione**: 2.2.8

### PHPInsights
- **Status**: ⚠️ Configurazione non presente


### `code-redundancy-audit.md` — Code redundancy audit — UI


# Code redundancy audit — UI

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 410 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 20 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 7 |
| File PHP con marker Git | 0 |

## Evidenze

### `components/address-field.md` — AddressField Component


# AddressField Component

## Panoramica
Il componente AddressField è un campo Filament personalizzato per la gestione degli indirizzi. Integra funzionalità di geocoding e validazione degli indirizzi.

## Caratteristiche
- Autocompletamento degli indirizzi
- Validazione dei campi dell'indirizzo
- Integrazione con servizi di geocoding
- Supporto per formati di indirizzo internazionali

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Gestione null-safe degli oggetti Address
3. Validazione dei dati di input
4. Correzione dei type hints per le proprietà
5. Implementazione delle interfacce corrette

### `components/archive/full-calendar.md` — FullCalendar Component for Filament


# FullCalendar Component for Filament

## Introduction
This document describes the implementation and usage of Saade's FullCalendar component for Filament within the UI modules of Laraxot PTVX. This component offers complete integration of the popular FullCalendar JavaScript plugin with Filament, allowing users to view and manage events in an intuitive calendar interface.

## Installation

To install the component:

```bash
composer require saade/filament-fullcalendar:^3.0
```

## Configuration in UI Module

### 1. Plugin Registration

In the UI module service provider (`Modules/UI/Providers/UIServiceProvider.php`), register the FullCalendar plugin:


### `components/filament.md` — Filament Components


# Filament Components

## Resources

### Signature Pad

- [filament-signature-pad](https://github.com/savannabits/filament-signature-pad)

### Exception Handling

- [filament-exceptions](https://github.com/bezhanSalleh/filament-exceptions)

### Health Check

- [filament-spatie-laravel-health](https://github.com/shuvroroy/filament-spatie-laravel-health)

### Select Tree Components

- [filament-adjacency-list](https://filamentphp.com/plugins/saade-adjacency-list)

### `components/legacy/full-calendar.md` — FullCalendar Component for Filament


# FullCalendar Component for Filament

## Introduction
This document describes the implementation and usage of Saade's FullCalendar component for Filament within the UI modules of Laraxot PTVX. This component offers complete integration of the popular FullCalendar JavaScript plugin with Filament, allowing users to view and manage events in an intuitive calendar interface.

## Installation

To install the component:

```bash
composer require saade/filament-fullcalendar:^3.0
```

## Configuration in UI Module

### 1. Plugin Registration

In the UI module service provider (`Modules/UI/Providers/UIServiceProvider.php`), register the FullCalendar plugin:


### `components/radio-collection-fix-sumy.md` — RadioCollection: Riassunto Correzione & Risultati FINALI


# RadioCollection: Riassunto Correzione & Risultati FINALI

## 🎯 Problema Identificato

Il componente RadioCollection aveva un errore critico `Undefined variable $optionValue` che causava:

1. **Crash dell'applicazione**: Internal Server Error 500
2. **Variabili Non Definite**: Riferimenti a `$optionValue` e `selectedValue` non esistenti
3. **Template Corrotto**: Duplicazioni e inconsistenze nel codice Blade
4. **Alpine.js Disallineato**: Logica JavaScript non sincronizzata con Blade

## 🔧 Correzioni Implementate

### 1. **Definizione Variabili PHP** ✅
```php
// AGGIUNTO: Blocco PHP per definire variabili necessarie
@php
    $optionValue = data_get($option, $getValueKey());
    $isSelected = $getState() == $optionValue;

### `concepts/xotbase-never-extend-filament.md` — Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`


# Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe in `Modules/UI` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel modulo.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.

### `confidence-guidelines.md` — Massimizzare il livello di confidenza


# Massimizzare il livello di confidenza

1. **Test automatizzati**: copertura >90%, includi test unitari, integrazione, e fine‑to‑end.
2. **CI/CD**: esegui tutti i test su ogni commit, blocca merge se falliscono.
3. **Analisi statica**: PHPStan, Psalm e Laravel Pint al livello massimo.
4. **Revisione del codice**: code‑review obbligatoria con checklist di qualità.
5. **Monitoraggio in produzione**: New Relic / Sentry per errori e performance.
6. **Documentazione**: mantieni aggiornati doc e changelog.
7. **Rollback rapido**: feature flags e versioni per tornare indietro.

### `conflict-resolution.md` — Conflict Resolution — Module UI


# Conflict Resolution — Module UI

## Summary
- **Files resolved**: 48
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## PHP Files
- app/View/Components/Render/Block.php

## Documentation Files
- docs/algolia_docsearch.md
- docs/architecture.md
- docs/best_practices.md
- docs/blade_data_handling.md
- docs/blocks_system.md
- docs/bugfix-table-layout-action.md
- docs/chart_components.md
- docs/cms_link.md

### `conflitti-merge-risolti.md` — Conflitti di Merge Risolti nel Modulo UI


# Conflitti di Merge Risolti nel Modulo UI

## Conflitti Risolti (2025-05-13)

### 1. UIServiceProvider.php

**Problema:** Conflitto tra la versione HEAD che conteneva documentazione e commenti dettagliati sulla registrazione dei Blade components modulari, e la versione del branch che li aveva rimossi.

**Soluzione:** Mantenuta la versione HEAD con i commenti e la documentazione completa, poiché forniscono informazioni cruciali sul funzionamento del sistema di componenti Blade modulari e sulla corretta risoluzione dei path secondo la struttura dei moduli.

**Motivazione:** La documentazione nel codice è fondamentale per la manutenibilità e la comprensione del sistema, specialmente per quanto riguarda la gestione dei componenti UI che è un aspetto critico dell'architettura modulare.

### 2

### `consolidation-plan.md` — Piano Consolidamento Documentazione - Modulo UI


# Piano Consolidamento Documentazione - Modulo UI

## Obiettivo

Consolidare la documentazione rimuovendo duplicati e file obsoleti, mantenendo una sola fonte di verità per ogni argomento.

## Regole di Consolidamento

1. **Convenzione naming**: Usare sempre trattini (`-`) invece di underscore (`_`)
2. **Nomi file**: Maiuscole solo per `README.md`, tutto il resto minuscolo
3. **Date nei nomi**: Rimuovere date dai nomi file (spostare in archive se necessario)
4. **Versione da mantenere**: Mantenere sempre la versione più completa e aggiornata

## File Duplicati da Consolidare

### 1. Advanced Form Components
- ❌ `advanced-form-components.md` → Eliminare
- ✅ `advanced-form-components.md` → Mantenere


### `consolidation-script.md` — Script Consolidamento Documentazione UI


# Script Consolidamento Documentazione UI

## File Vuoti da Eliminare

Questi file sono vuoti (0 bytes) e possono essere eliminati:

```bash
cd laravel/Modules/UI/docs

# File vuoti con underscore
rm -f advanced-form-components.md
rm -f blade_data_handling.md
rm -f naming_conventions.md
rm -f phpstan_fixes_2025.md
```

## File Duplicati da Eliminare

Questi file hanno versioni con trattini che devono essere mantenute:

### `contracts/apply-calendar-to-panel-action.md` — ApplyCalendarToPanelAction


# ApplyCalendarToPanelAction

Dovrebbe applicare un calendario al panel Filament; oggi è uno stub che restituisce il panel invariato. Codice: `app/Actions/Panel/ApplyCalendarToPanelAction.php:23-34`.

## Input

- `Panel $panel`: il panel Filament.
- `string $calendarClass`: non usato.

## Output

- `Panel`: lo stesso panel ricevuto, senza modifiche.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-CAL-INV-1` | Il panel restituito è quello ricevuto, senza modifiche. | riga 33 | Test: nessuno |


### `contracts/get-all-blocks-action.md` — GetAllBlocksAction


# GetAllBlocksAction

Sorgente: `app/Actions/Block/GetAllBlocksAction.php`. Perché è fatta così:
[ADR scoperta dei blocchi per cartella](../adr/0001-block-discovery-by-filament-blocks-folder.md).
Chiamanti: `Modules/Cms/app/Filament/Fields/PageContent.php`, `PageContentBuilder.php`.

## Input

- Nessun parametro. Legge `config('modules.paths.generator.model.path')` e il filesystem di `base_path('Modules')`.

## Output

- `DataCollection<int, Modules\Xot\Datas\ComponentFileData>` con `name`, `class`, `module`, `path` (percorso reale)
  per ogni file `Modules/*/app/Filament/Blocks/*.php`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|

### `contracts/get-all-icons-action.md` — GetAllIconsAction


# GetAllIconsAction

Elenca le icone SVG di tutti i set registrati in BladeUI Icons. Codice: `app/Actions/Icon/GetAllIconsAction.php:24-94`.

## Input

- `string $_context = 'form'`: non usato; il risultato non cambia con il contesto.

## Output

- `array<string, array<string, mixed>>`: per ogni set, i suoi dati (incluso `name`) più `icons`, l'elenco dei nomi `prefisso-nome`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-ICONS-INV-1` | Se la lettura del set via reflection fallisce, restituisce `[]`. | righe 29-37 | Test: nessuno sul ramo di errore |
| `UI-ICONS-INV-2` | Sono contati solo i file con estensione `svg`. | riga 73 | `tests/Unit/GetAllIconsActionTest.php:71` |
| `UI-ICONS-INV-3` | Il nome è `prefisso-nome`, con le sottocartelle trasformate in

### `contracts/get-days-mapping-action.md` — GetDaysMappingAction


# GetDaysMappingAction

Mappa i giorni feriali-lavorativi (lunedì–sabato) da chiave inglese a etichetta localizzata. Codice: `app/Actions/Datetime/GetDaysMappingAction.php:23-67`.

## Input

- Nessun parametro. Usa `Carbon::now()` come punto di riferimento per la settimana.

## Output

- `array<string, string>`: chiave `monday`…`saturday` (minuscola, in inglese) => etichetta da `isoFormat('dddd')` con la capitalizzazione iniziale.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-DAYS-INV-1` | Il risultato ha sei chiavi, da lunedì a sabato; la domenica è assente. | righe 41-52, 25-31 | `tests/Unit/OpeningHoursRuleTest.php:47` (solo "non vuoto") |
| `UI-DAYS-INV-2` | La chiave è il nome inglese minuscolo del giorno (`format('l')`). | riga 63 | Test: nessuno 

### `contracts/get-localized-block-data-action.md` — GetLocalizedBlockDataAction (UI)


# GetLocalizedBlockDataAction (UI)

Sorgente: `app/Actions/Block/GetLocalizedBlockDataAction.php`. Perché è fatta così:
[ADR delega opzionale a Cms](../adr/0004-optional-cms-delegation-for-block-data.md). Chiamante: `View/Components/Render/Block.php::render()`.

## Input

- `array<string, mixed> $viewParams`: il `data` del blocco, già con chiavi stringa.

## Output

- `array<string, mixed>`: i dati risolti da `Modules\Cms\Actions\ResolveLocalizedBlockDataAction::execute()`, oppure
  `$viewParams` invariato se Cms non c'è, se il resolver non ha `execute()` o se non ritorna un array.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-BLOCKDATA-INV-1 | Con il resolver di Cms disponibile, l'output è il suo risultato (UI non aggiunge né toglie chiavi). | `UI-BLOCKDATA-INV-1` |

### `contracts/get-user-data-action.md` — GetUserDataAction


# GetUserDataAction

Sorgente: `app/Actions/GetUserDataAction.php`. Espone dati personali dell'utente autenticato (nome, email, avatar,
ruolo, permessi, `profile.extra`) come `Modules\UI\Datas\UserData`. Nel checkout attuale non ha chiamanti in
produzione, solo test: chi lo collega a una vista o a un'API legge prima «Non fa».

## Input

- Nessun parametro. Legge `Auth::user()` (guard di default).

## Output

- `UserData|null`: `null` se nessuno è autenticato o se l'autenticato non implementa `Modules\Xot\Contracts\UserContract`.
- Altrimenti `id`, `name`, `email` (`getAttribute`, `''` se non stringa), `avatar` (URL del profilo caricato, poi
  `profile_photo_path`, poi `null`), `role` (il **primo** nome di ruolo, `null` se non ne ha), `permissions` (nomi di
  tutti i permessi, anche via ruolo), `settings` (`profile.extra` se array, altrimenti `[]`).

### `contracts/resolve-localized-block-data-action.md` — ResolveLocalizedBlockDataAction (UI)


# ResolveLocalizedBlockDataAction (UI)

Sorgente: `app/Actions/Block/ResolveLocalizedBlockDataAction.php`. Perché è fatta così:
[ADR delega opzionale a Cms](../adr/optional-cms-delegation-for-block-data.md). Chiamante: `View/Components/Render/Block.php::render()`.

## Input

- `array<string, mixed> $viewParams`: il `data` del blocco, già con chiavi stringa.

## Output

- `array<string, mixed>`: i dati risolti da `Modules\Cms\Actions\ResolveLocalizedBlockDataAction::execute()`, oppure
  `$viewParams` invariato se Cms non c'è, se il resolver non ha `execute()` o se non ritorna un array.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-BLOCKDATA-INV-1 | Con il resolver di Cms disponibile, l'output è il suo risultato (UI non aggiunge né toglie chiavi). | `UI-BLOCKDATA-INV-1` |

### `contracts/template.md` — <operazione> — contratto comportamentale


# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `<MODULE>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |


### `contracts-naming.md` — Contracts Naming & Placement in UI


# Contracts Naming & Placement in UI

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/ExampleContract.php`
- ❌ `app/Interfaces/ExampleInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Verification

```bash

### `convenzioni-naming-campi-1.md` — Convenzioni di Naming dei Campi


# Convenzioni di Naming dei Campi

## Collegamenti Bidirezionali
- [Best Practices UI](../best-practices.md)
- [Errori Comuni UI](../filament-components-errors.md)
- [Implementazione Corretta](../examples/correct-implementation.md)

## Campi Nome e Cognome

### ❌ NON FARE
```php
TextInput::make('name')  // ❌ Ambiguo: potrebbe essere solo nome o nome completo
TextInput::make('surname')
```

### ✅ FARE - Caso 1: Campi Separati
```php
TextInput::make('first_name')  // ✅ Chiaro: solo nome
TextInput::make('last_name')   // ✅ Chiaro: solo cognome

### `copilot-redundancy-audit.md` — copilot-redundancy-audit


Copilot Redundancy Audit — 2026-05-25

Sintesi
- Componenti UI e snippet CSS/Blade ripetuti tra temi e moduli; duplicazioni possono essere DRYed in pattern library.

Raccomandazioni
- Estrarre componenti riutilizzabili e documentarli nella theme/module shared library.
- Aggiornare "second brain" indicando dove trovare il componente canonico e come usarlo.

Autore: Copilot CLI

### `cosa-migliorare.md` — Cosa migliorare — modulo UI


# Cosa migliorare — modulo UI

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 67 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Architecture | 92.9 % |
| PHPInsights — Style | 91.4 % |
| File PHP | 693 |
| Casi di test | 290 |
| Casi di test per file | 0.42 |
| Coverage di riga | **mai misurata** |

### `coverage.md` — Code Coverage: UI


# Code Coverage: UI

**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
endor/laravel/framework/src/Illuminate/Container/Container.php:1415
    1411▕         } else {
    1412▕             $message = "Target [$concrete] is not instantiable.";
    1413▕         }
    1414▕ 
  ➜ 1415▕         throw new BindingResolutionException($message);
    1416▕     }
    1417▕ 
    1418▕     /**
    1419▕      * Throw an exception for an unresolvable primitive.


### `custom-404-page-1.md` — Custom 404 Page {#custom-404-page}


# Custom 404 Page {#custom-404-page}

This starter template includes a custom __404 Not Found__ error page, located at `/source/404.blade.php`. [To preview the 404 page](/404), you can visit `/404` in your browser.

```html
<!-- source/404.blade.php -->
@extends('_layouts.master')

@section('body')
<div class="flex flex-col items-center mt-32 text-gray-700">
    <h1 class="text-6xl leading-none mb-2">404</h1>
    <h2 class="text-3xl">Page not found</h2>

    <hr class="block w-full max-w-lg mx-auto my-8 border">

    <p class="text-xl">Need to update this page? See the <a title="404 Page Documentation" href="/docs/404"> documentation here</a>.</p>
</div>
@endsection
```

### `customizing-your-site-1.md` — Customizing Your Site {#customizing}

# Customizing Your Site {#customizing}

## Styles

This starter template comes pre-loaded with [Tailwind CSS](https://tailwindcss.com), a utility CSS framework that allows you to customize and build complex designs without touching a line of CSS. There are also a few base Sass files in the `/source/_assets/sass` folder, set up with the expectation that you can add any custom CSS into `_documentation.scss`.

> You can re-work the architecture of the Sass includes any way you’d like; just make sure to keep the `@tailwind` references in your final files.

```scss
// source/_assets/sass/main.scss

@tailwind preflight;
@tailwind components;

// Code syntax highlighting,
// powered by https://highlightjs.org
@import '~highlight.js/styles/a11y-light.css';

@import 'base';
@import 'navigation';

### `cyclomatic-complexity-report.md` — Cyclomatic Complexity Report - Module: UI


# Cyclomatic Complexity Report - Module: UI

**Analyzer:** Super Mucca 🐮

---

## 📊 Summary Statistics

| Metric | Value |
|--------|-------|
| Total PHP Files | 529 |
| Total Lines of Code | 33395 |
| Total Classes/Traits/Interfaces | 120 |
| Total Methods | 497 |
| High Complexity Methods (>10) | 0 |

---

## 🎯 Cyclomatic Complexity Overview

### `datas-not-dtos-convention.md` — Datas, non DTOs


# Datas, non DTOs

Il progetto usa moduli nwidart. La root `laravel/app/` è solo skeleton — non deve
contenere logica di dominio (`app/DTOs/`, `app/Traits/`, ecc.).

## Regola

- Nessun `*Dto.php` / cartella `DTOs/`. Ogni classe dati è `Modules\<M>\Datas\<Nome>Data`
  ed estende `Spatie\LaravelData\Data` (https://github.com/spatie/laravel-data).
- Namespace `Datas` (plurale), non `Data` o `DTOs`.
- Constructor promotion con `public readonly` (vedi `Modules\Geo\Datas\AddressData`),
  non getter privati manuali.

## Storia

`laravel/app/DTOs/ThemeMetadataDto.php` (root, non modulare, classe DTO custom,
zero utilizzatori) è stato convertito e spostato in
`Modules\UI\Datas\ThemeMetadataData` (estende `Data`, stesso comportamento).


### `decision-log.md` — Decision Log — UI


# Decision Log — UI

A threaded, append-only record of decisions made across BMAD planning workflows.
Every later skill (brief, PRD, architecture, stories) appends here so the reasoning
behind the plan stays visible and consistent.

**How to use:** add a new entry at the top of the log (newest first). Never rewrite
or delete past entries — supersede them with a new entry that references the old one.

### 2026-10-08: Ripristino GetUserDataAction regredita dal re-import del 07/10
- **Choose**: Ripristinare `Actions/GetUserDataAction.php` dallo stato del monorepo al 06/10.
- **Over**: Tenere la versione del commit `c83cb5a03` (07/10 13:09, senza genitori, 3102 file).
- **Because**: Re-import da una copia vecchia; nessun commit successivo tocca il file. Criterio: contenuto attuale identico by

### `dependencies.md` — Dependencies (Module UI)


# Dependencies (Module UI)

Canonical dependency map:

- [../../../../docs/dependencies.md](../../../../docs/dependencies.md)

Module/theme specific notes:

- (add notes here when a dependency is directly used by this module/theme)

Installed packages index:

- [../../../../docs/packages/index.md](../../../../docs/packages/index.md)

### `dependency-intelligence.md` — Dependency Intelligence - Module UI


# Dependency Intelligence - Module UI

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| `owenvoke/blade-fontawesome` | `*` | `v2.9.1` | `application-support` |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- Nessun pacchetto mancante nel lock corrente.

### `dependency-rules.md` — Regole di Dipendenza — Modulo UI


# Regole di Dipendenza — Modulo UI

> **Creato**: 2026-07-06
> **Stato**: ATTIVO — regola vincolante

---

## Principio Fondamentale

Il modulo **UI è una dipendenza condivisa** di tutti gli altri moduli. Il suo scopo è fornire componenti UI generici (Filament, Blade, Livewire) senza conoscere il dominio applicativo di nessun modulo specifico.

```
Xot ← UI ← (tutti gli altri moduli: Geo, User, Tenant, Activity, ecc.)
```

**La freccia indica "dipende da".**

---


### `design-comuni-faq-components.md` — Design Comuni - Componenti UI per FAQ


# Design Comuni - Componenti UI per FAQ

## Panoramica

Componenti UI del modulo UI utilizzati per implementare la pagina FAQ del progetto Design Comuni Italia.

- **Modulo**: UI
- **Tema**: Sixteen
- **Pagina**: `/it/tests/domande-frequenti`
- **Stato**: ✅ 90% Completato

## Componenti Blade Implementati

### 1. Accordion Component

**File**: `Themes/Sixteen/resources/views/components/blocks/accordion/default.blade.php`

**Responsabilità**: Visualizzare lista FAQ espandibili


### `design-comuni-implementation.md` — 🎨 Design Comuni Implementation Guide


# 🎨 Design Comuni Implementation Guide

**Module**: UI (User Interface)  
**Date**: 2026-03-30  
**Status**: ✅ Components Ready

---

## 📋 Overview

This module implements Design Comuni (Italian Municipalities Design System) components using Tailwind CSS with @apply directive.

**Reference**: https://italia.github.io/design-comuni-pagine-statiche/

---

## 🧩 Components Created (12)

### Layout Components

### `design-system-1.md` — Design System


# Design System

## Panoramica
Il design system definisce gli standard visivi e di interazione per garantire coerenza in tutta l'applicazione.

## Componenti Base

### 1. Tipografia
```css
/* Font Family */
--app-font-sans: 'Inter', sans-serif;
--app-font-serif: 'Merriweather', serif;
--app-font-mono: 'JetBrains Mono', monospace;

/* Font Sizes */
--app-text-xs: 0.75rem;
--app-text-sm: 0.875rem;
--app-text-base: 1rem;
--app-text-lg: 1.125rem;

### `development-workflow-rules.md` — Development Workflow Rules - UI Module


# Development Workflow Rules - UI Module

**Date**: [DATE]
**Status**: Active
**Purpose**: Document the mandatory development workflow for UI module

## 🚨 Mandatory Workflow Rules

### Rule 1: Code Quality Check Cycle
**AFTER EVERY FILE MODIFICATION**, you MUST:

1. **PHPStan Analysis**
   ```bash
   ./vendor/bin/phpstan analyse path/to/modified/file.php --level=max
   ```

2. **PHPMD Analysis**
   ```bash
   ./vendor/bin/phpmd path/to/modified/file.php text cleancode,codesize,design,naming,unusedcode

### `disabled-components.md` — Disabled/Stale Components in UI Module


# Disabled/Stale Components in UI Module

**Status**: Documentation of unavailable dependencies  
**Date**: 2026-06-18

## Overview

UI module contains several components that depend on modules not installed in this project.
These are documented here for reference and future restoration if those modules are added.

## Disabled Components

### 1. InteractiveMap.php (Livewire Component)

**Location**: `app/Livewire/Components/Map/InteractiveMap.php.old`  
**Status**: ❌ Disabled (renamed to .old)  
**Reason**: Depends on `Modules\Geo\Services` which is not installed

#### Dependencies

### `docs-health.md` — Docs Health - UI


# Docs Health - UI

## Snapshot

- Scope directory: laravel/Modules/UI/docs
- Markdown files (top-level in this docs folder): 317
- Has canonical index 00-index.md: yes
- Has README.md: yes

## Confidence Checklist

- [ ] 00-index links only canonical docs (no obsolete duplicates)
- [ ] README and 00-index are coherent and do not diverge
- [ ] New docs use stable names (no dates in filename)
- [ ] Deprecated docs are explicitly marked and linked to canonical replacements
- [ ] Every technical decision has one canonical reference doc

## Canonical Rules


### `dry-kiss-analysis-conflict.md` — DRY & KISS Analysis - Modulo UI


# DRY & KISS Analysis - Modulo UI

**Data:** 15 Ottobre 2025
**DRY Score:** 🥇 **99%** - CAMPIONE!
**KISS Score:** 🥇 **98%** - CAMPIONE!

## 🏆 Hall of Fame

### BaseModel PERFETTO
```php
abstract class BaseModel extends XotBaseModel
{
    // COMPLETAMENTE VUOTO!
    // Tutto ereditato da XotBaseModel
}
```

**Righe:** 4 (solo dichiarazione classe)
**DRY Level:** 🥇 **99% - IL MIGLIORE!**

### `dry-kiss-analysis.md` — DRY & KISS Analysis - Modulo UI


# DRY & KISS Analysis - Modulo UI

**Data:** 15 Ottobre 2025  
**DRY Score:** 🥇 **99%** - CAMPIONE!  
**KISS Score:** 🥇 **98%** - CAMPIONE!

## 🏆 Hall of Fame

### BaseModel PERFETTO
```php
abstract class BaseModel extends XotBaseModel
{
    // COMPLETAMENTE VUOTO!
    // Tutto ereditato da XotBaseModel
}
```

**Righe:** 4 (solo dichiarazione classe)  
**DRY Level:** 🥇 **99% - IL MIGLIORE!**  

### `duplicate-methods-analysis.md` — Analisi Metodi Duplicati - Modulo UI


# Analisi Metodi Duplicati - Modulo UI

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **UI** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 0 |
| **Interface** | 2 |
| **Altro** | 0 |

## Dettaglio Metodi Duplicati


### `duplicate-methods.md` — Metodi duplicati — UI


# Metodi duplicati — UI

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **412**
- Metodi duplicati trovati: **34**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `__construct` | 15 | candidato a trait/helper |
| `getFormSchema` | 15 | candidato a trait/helper |
| `render` | 15 | candidato a trait/helper |
| `setUp` | 15 | candidato a trait/helper |
| `make` | 13 | candidato a trait/helper |
| `execute` | 6 | candidato a trait/helper |
| `definition` | 4 | candidato a trait/helper |
| `getColor` | 4 | candidato a trait/helper |

### `eav.md` — eav


https://github.com/yemenpoint/filament-custom-fields


### `eloquent-isset-vs-property-exists.md` — Eloquent: isset() vs property_exists()


# Eloquent: isset() vs property_exists()

## Regola Fondamentale

**MAI usare `property_exists()` con Eloquent Model**

**SEMPRE usare `isset()` per magic properties**

## Perché

Eloquent Model usa `__get()` e `__isset()` magic methods per accedere agli attributi del database.

Gli attributi NON sono proprietà PHP reali dichiarate nella classe.

## Pattern Corretti nel Modulo UI

### IconStateColumn.php

```php

### `eloquent-properties-isset-vs-property-exists.md` — Eloquent Properties: isset() vs property_exists() - Guida Completa


# Eloquent Properties: isset() vs property_exists() - Guida Completa

## 🚨 Regola Critica

**MAI usare `property_exists()` con i modelli Eloquent**. Utilizzare SEMPRE `isset()` perché gli attributi Eloquent sono magici.

## Perché property_exists() non funziona

I modelli Eloquent utilizzano il pattern delle proprietà magiche:
- I campi del database sono accessibili tramite `__get()` e `__set()`
- NON sono proprietà PHP reali della classe
- `property_exists()` controlla solo le proprietà reali della classe, NON gli attributi magici
- `property_exists()` restituisce sempre `false` per i campi del database

## Soluzione Corretta: isset()

`isset()` rispetta il magic method `__isset()` implementato da Eloquent, quindi funziona correttamente con gli attributi magici.

## Esempi Pratici

### `epics/ui-epics-and-stories.md` — UI Epics and User Stories

# UI Epics and User Stories

## Epic 1: Core Functionality
As a User, I want to use UI features so that I can accomplish my tasks.

### Story 1.1: Basic Operations
**Acceptance Criteria**:
- [ ] Create UI records
- [ ] Read UI data
- [ ] Update UI records
- [ ] Delete UI records

## Technical Specifications
- Standard CRUD implementation
- Validation and error handling
- Integration with Laraxot patterns

---
## Story Template
```

### `filament/listrecords.md` — List Records in Filament


# List Records in Filament

## Estensione Corretta

```php
// ❌ ERRATO: Non estendere ListRecords
use Filament\Resources\Pages\ListRecords;

class ListMyRecords extends ListRecords
{
    // ...
}

// ✅ CORRETTO: Estendere XotBaseListRecords
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyRecords extends XotBaseListRecords
{
    protected static string $resource = MyResource::class;

### `filament-4x-upgrade-report.md` — Rapporto Aggiornamento Filament 4.x - Modulo UI


# Rapporto Aggiornamento Filament 4.x - Modulo UI

**Status**: ✅ COMPLETATO
**Versione Filament**: 4.0.17

## 🔧 Correzioni Implementate

### 1. Widget FullCalendar Disabilitato
**Problema**: Dipendenza da `saade/filament-fullcalendar` non compatibile con Filament 4.x
**Soluzione**: Disabilitazione temporanea del widget

**File disabilitato**:
- `UserCalendarWidget.php` - esteso `FullCalendarWidget` da `saade/filament-fullcalendar`

**Modifiche applicate**:
```php
// PRIMA (errore)
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
class UserCalendarWidget extends FullCalendarWidget

### `filament-4x-upgrade.md` — Filament 4.x Upgrade - Modulo UI


# Filament 4.x Upgrade - Modulo UI

**Status**: ✅ COMPLETATO
**Versione Filament**: 4.0.20

## 🎯 Panoramica

Il modulo UI è stato aggiornato con successo a Filament 4.x. Le modifiche principali riguardano il `UserCalendarWidget`.

## 🔧 Modifiche Applicate

### UserCalendarWidget

**File**: `Modules/UI/app/Filament/Widgets/UserCalendarWidget.php`

**Problema**: Dipendenza da `saade/filament-fullcalendar` non compatibile con Filament 4.x

**Soluzione**: Disabilitazione temporanea del widget calendario


### `filament-5x-compatibility.md` — Filament 5.x compatibility - modulo UI


# Filament 5.x compatibility - modulo UI

**Versione Filament:** v5.2.1

## Stato compatibilità

Il modulo UI è **compatibile** con Filament 5.x. Nessun breaking change funzionale.

## Note specifiche modulo

- I temi Filament devono essere aggiornati per Tailwind CSS v4.1+
- Verificare che i componenti Blade e le variabili CSS custom siano compatibili con la nuova configurazione Tailwind

## Regole architetturali

Tutte le classi Filament **devono** estendere le classi `XotBase*` (vedi [regole Xot](../../Xot/docs/filament-5-laraxot-rules.md)).


## Inclusione nei Blade View

### `filament-blade-components-usage-1.md` — Utilizzo dei Componenti Blade di Filament


# Utilizzo dei Componenti Blade di Filament

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Utilizzo delle Icone](#utilizzo-delle-icone)
- [Migrazione da Componenti Personalizzati](#migrazione-da-componenti-personalizzati)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti Blade nativi di Filament , con particolare attenzione alla sostituzione dei componenti personalizzati con quelli forniti da Filament.

## Componenti Disponibili

Filament fornisce una serie di componenti Blade pronti all'uso che dovrebbero essere utilizzati al posto dei componenti personalizzati quando possibile:

### Componenti UI Principali


### `filament-custom-columns-relationship-resolution.md` — Filament Custom Columns - Relationship Resolution Ultimate Guide


# Filament Custom Columns - Relationship Resolution Ultimate Guide

## Executive Summary

**Problem**: `TextColumn::make('valutatore.nome_diri')` works in standard Filament tables but fails in custom columns like `GroupColumn`.

**Root Cause**: Custom columns don't inherit Filament's relationship resolution mechanism.

**Solution**: Use closures, model accessors, or implement proper relationship resolution.

---

## Understanding the Problem

### How Standard Filament TextColumn Works

When you use `TextColumn::make('valutatore.nome_diri')` in a standard Filament table:

```php

### `filament-dropdown-avatar-usage-1.md` — Utilizzo dei Componenti Filament Dropdown e Avatar


# Utilizzo dei Componenti Filament Dropdown e Avatar

## Collegamenti correlati
- [README modulo UI](/laravel/Modules/UI/docs/README.md)
- [Utilizzo Componenti Filament](/laravel/Modules/UI/docs/FILAMENT_COMPONENTS_USAGE.md)
- [Architettura Modulare](/docs/architettura-modulare.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive l'implementazione e l'utilizzo dei componenti dropdown e avatar di Filament , con particolare attenzione alla gestione degli utenti e alle azioni correlate.

## Componente Avatar

Il componente `x-filament::avatar` è utilizzato per visualizzare l'immagine del profilo dell'utente. Questo componente accetta diverse proprietà per personalizzare l'aspetto dell'avatar.

### Esempio di Utilizzo dell'Avatar


### `filament-fileupload-1.md` — FileUpload Component in Filament


# FileUpload Component in Filament

## Metodi Disponibili

### Configurazione Base
```php
FileUpload::make('document')
    // Non usare ->label() - Le label sono gestite dal LangServiceProvider
    ->disk('public')
    ->directory('documents')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(10240)
```

### UI/UX
```php
FileUpload::make('document')
    ->downloadable()
    ->previewable()

### `filament-fileupload-components-1.md` — Componenti FileUpload in Filament


# Componenti FileUpload in Filament

## Errore Comune: prefixIcon
Il metodo `prefixIcon()` non esiste nel componente FileUpload di Filament. Questo è un errore comune quando si confondono i componenti TextInput (che hanno il metodo prefixIcon) con i componenti FileUpload.

### ❌ Errato
```php
Forms\Components\FileUpload::make('certifications')
    ->prefixIcon('heroicon-o-document-text') // Questo metodo non esiste!
    ->label('Certificazioni');
```

### ✅ Corretto
```php
Forms\Components\FileUpload::make('certifications')
    ->label('Certificazioni')
    ->icon('heroicon-o-document-text') // Usare icon() invece di prefixIcon()
    ->buttonLabel('Carica certificazioni')
    ->disk('public')

### `filament-groupcolumn-and-custom-columns.md` — Guida all'utilizzo di GroupColumn e Colonne Custom


# Guida all'utilizzo di GroupColumn e Colonne Custom

> **REGOLA IMPORTANTE**: Quando esiste una colonna personalizzata come `WorkerColumn`, `ValutatoreColumn`, ecc., USARLA invece di creare TextColumns separati. Le colonne personalizzate encapsulano la logica e mantengono DRY.

## Esempio: Usare WorkerColumn

```php
// ❌ SBAGLIATO - Non usare TextColumns separati
TextColumn::make('matr')->searchable(),
TextColumn::make('cognome')->searchable(),
TextColumn::make('nome')->searchable(),

// ✅ CORRETTO - Usare WorkerColumn quando disponibile
WorkerColumn::make('lavoratore'),
```

Le colonne personalizzate come `WorkerColumn` sono pre-configurate con:
- Schema dei campi (matr, cognome, nome, email)
- Searchable a livello di gruppo

### `filament-resources-structure-1.md` — Struttura delle Filament Resources


# Struttura delle Filament Resources

## Panoramica
Questo documento descrive la struttura e l'organizzazione delle Filament Resources nel progetto il progetto, con particolare attenzione all'integrazione con il modulo Xot.

## Struttura Base
Le Filament Resources seguono una struttura gerarchica standardizzata:

```
laravel/
└── Modules/
    ├── Xot/
    │   └── app/
    │       └── Filament/
    │           └── Resources/
    │               └── Pages/
    │                   ├── XotBaseListRecords.php
    │                   ├── XotBaseCreateRecord.php
    │                   └── XotBaseEditRecord.php

### `filament-table-architecture.md` — La tabella si configura nella Table class, non nella pagina


# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\UI\Filament\Resources\FooResource\Tables;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FoosTable extends XotBaseResourceTable

### `filament-v4-theme-upgrade.md` — Filament v4 Theme Upgrade Guide - Modulo UI


# Filament v4 Theme Upgrade Guide - Modulo UI
**Modulo**: UI (Theme Components)
**Versione**: 4.0
**Stato**: Ready for Implementation

## 🎨 TAILWIND CSS V4 MIGRATION

### 1. 🚨 CRITICAL: Custom Theme CSS Changes

#### Problema
Filament v4 richiede Tailwind CSS v4 con sintassi completamente diversa.

#### File da Aggiornare
- [ ] `resources/css/filament/theme.css`
- [ ] `tailwind.config.js` → NON PIÙ UTILIZZATO
- [ ] Componenti custom UI

#### ✅ Nuova Sintassi Tailwind v4
```css

### `filament-version.md` — Filament Version Declaration — UI


# Filament Version Declaration — UI

**Current Version**: Filament v5 (Livewire v4 + Schemas)

This module/theme is developed against **Filament v5**.

All resources, forms, tables, infolists, widgets and actions must follow the v5 + XotBase patterns documented in:

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md`

**Legacy v4 documents** in this folder (if any) are historical only and must not be used as current reference.

**Last verified**: 2026-05-21

**Firmato:** Cursor Agent (Composer) — template propagato ai package `docs/`

### `filament-vscode-1.md` — Filament VSCode Extension


# Filament VSCode Extension

## Panoramica

L'estensione VSCode per Filament fornisce un set completo di strumenti per sviluppare applicazioni Filament in modo più efficiente.

## Caratteristiche

### 1. Snippets

#### Form Components
- `fil-text` → TextInput
- `fil-select` → Select
- `fil-textarea` → Textarea
- `fil-checkbox` → Checkbox
- `fil-toggle` → Toggle
- `fil-date` → DatePicker
- `fil-time` → TimePicker
- `fil-file` → FileUpload

### `filamentropdown-avatar-usage.md` — Utilizzo dei Componenti Filament Dropdown e Avatar


# Utilizzo dei Componenti Filament Dropdown e Avatar

## Collegamenti correlati
- [README modulo UI](/laravel/modules/ui/docs/readme.md)

- [README modulo UI](/laravel/Modules/UI/docs/README.md)
- [Utilizzo Componenti Filament](/laravel/modules/ui/docs/filament_components_usage.md)
- [Architettura Modulare](/docs/architettura-modulare.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive l'implementazione e l'utilizzo dei componenti dropdown e avatar di Filament , con particolare attenzione alla gestione degli utenti e alle azioni correlate.

## Componente Avatar

Il componente `x-filament::avatar` è utilizzato per visualizzare l'immagine del profilo dell'utente. Questo componente accetta diverse proprietà per personalizzare l'

### `filosofia-modulo-ui.md` — Analisi Approfondita del Modulo UI


# Analisi Approfondita del Modulo UI

> **Generato**: [DATE]
> **Scopo**: Documentare la filosofia, logica, business logic e architettura del modulo UI

---

## 1. LOGICA - Come Funziona il Modulo UI

### Architettura Componenti Custom Filament

Il modulo UI è **il layer di estensione e personalizzazione di Filament v4**, strutturato su tre pilastri:

**A) Custom Filament Components (56 file PHP)**
```
app/Filament/
├── Tables/Columns/        # 8 colonne custom (IconStateColumn, GroupColumn, etc.)
├── Forms/Components/      # 15 form fields custom (InlineDatePicker, RadioBadge, LocationSelector)
├── Widgets/              # 11 widgets (StatsOverviewWidget, UserCalendarWidget, DarkModeSwitcherWidget)

### `flags-components-1.md` — Componenti SVG Bandiere nel Modulo UI


# Componenti SVG Bandiere nel Modulo UI

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Documentazione UI](/laravel/Modules/UI/docs/README.md)
- [Documentazione sezioni](/docs/sections.md)
- [Header: Lingua e Utente](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)
- [Implementazione CMS](/laravel/Modules/Cms/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

Il modulo UI di <nome progetto> include una vasta collezione di SVG di bandiere nazionali che possono essere utilizzati come componenti Blade. Questi componenti sono autoregistrati e possono essere facilmente integrati in qualsiasi parte dell'applicazione, incluso il selettore di lingue nell'header.

## Str

### `folio-volt-best-practices.md` — Laravel Folio + Volt - Best Practices and Patterns Analysis


# Laravel Folio + Volt - Best Practices and Patterns Analysis

## Overview

Based on research of multiple Laravel Folio + Volt repositories and official documentation, this document outlines the best practices and patterns for implementing Folio + Volt in applications.

## Key Patterns Identified

### 1. File Structure
- **Pages Directory**: Folio automatically maps files in `resources/views/pages/` to routes
  - Example: `resources/views/pages/events.blade.php` → `/events`
  - Example: `resources/views/pages/events/[event].blade.php` → `/events/{event}`
- **Subdirectories**: Organize related pages in subdirectories (e.g., `resources/views/pages/auth/`)
- **Blade Components**: Store reusable UI components in `resources/views/components/`

### 2. Volt Component Structure
- Volt components 

### `form-column-parity.md` — Parita' Forms/Components <-> Tables/Columns in UI


# Parita' Forms/Components <-> Tables/Columns in UI

SSoT della regola: [`Modules/Ptv/docs/form-column-parity.md`](../../Ptv/docs/form-column-parity.md).
Questo file registra solo l'applicazione della regola dentro UI.

## Misura del 2026-09-01 (da Ptv/form-column-parity.md, tabella "altri moduli")

Su 15 componenti in `Modules/UI/app/Filament/Forms/Components/`, 2 avevano gemello
(`SelectState`, `TreeField`), 13 no. Applicando il discriminante della regola (raccoglie
piu' campi del model / e' un fatto di dominio → gemello; e' un modo di inserire un
valore → nessun gemello), solo **2 erano legittimi da creare**:

- `AddressField` (5 campi: country, street, city, state, zip, via relazione) → nessun gemello
- `OpeningHoursField` (orari settimanali per fascia) → nessun gemello

Gli altri 11 

### `form-components-1.md` — Componenti Form


# Componenti Form

## Introduzione

I componenti form forniscono elementi di input e validazione per la creazione di form complessi e interattivi.

## Componenti Disponibili

### InlineDatePicker

Un componente avanzato per la selezione di date che mostra un calendario inline con la possibilità di abilitare/disabilitare date specifiche.

```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21', '2025-06-25'])
    ->calendarConfig([
        'locale' => 'it',

### `form-filament-widgets.md` — Utilizzo dei Widget Filament per i Form in il progetto


# Utilizzo dei Widget Filament per i Form in il progetto

## Indice
- [Introduzione](#introduzione)
- [Perché Filament per i Form](#perché-filament-per-i-form)
- [Vantaggi nell'Ecosistema il progetto](#vantaggi-nellecosistema-<nome progetto>)
- [Esempi di Implementazione](#esempi-di-implementazione)
- [Documentazione Dettagliata](#documentazione-dettagliata)

## Introduzione

il progetto utilizza esclusivamente i widget Filament per la creazione e gestione dei form in tutta l'applicazione. Questa scelta architetturale non è casuale, ma il risultato di una valutazione attenta dei vantaggi che questo approccio offre in termini di sviluppo, manutenibilità e coerenza dell'interfaccia utente.

## Perché Filament per i Form

La scelta di utilizzare i widget Filament per tutti i form di il proge

### `frameworks.md` — UI — Framework Integration Notes


# UI — Framework Integration Notes

Integration guidelines for caveman, graphify, bmad-method, headroom, ponytail.

**Status:** Awaiting Phase 3 framework research results

## Code Review (caveman)

Surgical editing patterns:
- Single-file edits encouraged
- Multi-file refactors discouraged
- Mechanical renames via caveman agent

## Architecture (graphify)

Dependency analysis:
- Module dependencies: [TBD — graphify analysis]
- Circular deps: [TBD]
- Cross-theme usage: [TBD]

### `geo-boundary.md` — Confine UI e Geo


# Confine UI e Geo

## Regola

Il modulo `UI` non deve dipendere dal modulo `Geo`.

`UI` fornisce componenti visuali generici e riusabili. La logica geografica, mappe interattive, geocoding, marker, export GeoJSON/KML e integrazioni GIS appartengono al dominio `Geo`.

## Dipendenze consentite

- `Geo` puo' dipendere da `UI` per usare primitive visuali.
- `UI` non deve importare namespace `Modules\Geo\*`.
- `UI` non deve contenere service geografici, geocoder o map service.
- Componenti con dominio geografico vanno spostati o disattivati fuori dall'autoload PHP.

## Caso LocationSelector

`LocationSelector` (cascading regione/provincia/CAP via `Modules\Geo\Models\Comune`)
**non appartiene a UI**. In questo tree `Modules/Geo` non esiste: il file si

### `geo-dependency-violation-interactive-map.md` — Rimosso InteractiveMap — violava regola "UI non importa Geo"


# Rimosso InteractiveMap — violava regola "UI non importa Geo"

## Problema

`Modules/UI/app/Livewire/Components/Map/InteractiveMap.php` importava 5 classi di `Modules\Geo\Actions\{Map,Geocoding}\*` che **non esistevano** (`class.notFound` in PHPStan), e violava comunque la regola architetturale non negoziabile: `Modules/UI` non deve dipendere da `Modules/Geo` (la direzione corretta è Geo → UI).

## Analisi prima di intervenire

- Nessun file nel monorepo referenzia `InteractiveMap` (né tag Livewire, né route/page, né altro componente): `grep -rln "InteractiveMap" Modules` non trova nulla fuori dal componente stesso.
- Le 5 Action Geo richieste (`GetMapMarkersAction`, `GetMapStatsAction`, `ExportMapDataAction`, `GeocodeAddressAction`, `GetGeocodingSuggestionsAction`) non esistono in `Modu

### `getting-started-1.md` — Getting Started {#getting-started}


# Getting Started {#getting-started}

This is a starter template for creating a beautiful, customizable documentation site for your project with minimal effort. You’ll only have to change a few settings and you’re ready to go.

## Configuration {#getting-started-configuration}

As with all Jigsaw sites, configuration settings can be found in `config.php`; you can update the variables in that file with settings specific to your project. You can also add new configuration variables there to use across your site; take a look at the [Jigsaw documentation](http://jigsaw.tighten.co/docs/site-variables/) to learn more.

```php
// config.php
return [
    'baseUrl' => 'https://my-awesome-jigsaw-site.com/',
    'production' => false,
    'siteName' => 'My Site',
    'siteDescription' => 'Give your 

### `getting-started.md` — Getting Started with $MOD

# Getting Started with $MOD

## Installation

$MOD is a Laravel module. Enable it:

```bash
php artisan module:enable $MOD
php artisan migrate
```

## Configuration

Configuration is in `config/$MOD.php`. Adjust as needed.

## Basic Usage

See README.md for features and examples.

## Troubleshooting

### `git-conflicts-inventory.md` — Inventario Conflitti Git - UI Module


# Inventario Conflitti Git - UI Module

## File con conflitti di merge non risolti

### File PHP
- `Config/config.php`
- `app/Filament/Forms/Components/RadioBadge.php`
- `app/Filament/Forms/Components/InlineDatePicker.php`
- `app/Filament/Forms/Components/RadioCollection.php`
- `app/Filament/Forms/Components/SelectState.php`
- `app/Filament/Forms/Components/RadioIcon.php`
- `app/Filament/Forms/Components/PasswordStrengthField.php`
- `app/Filament/Forms/Components/IconPicker.php`
- `app/Filament/Forms/Components/ParentSelect.php`
- `app/Filament/Forms/Components/Children.php`
- `app/Filament/Forms/Components/RadioImage.php`
- `app/Filament/Forms/Components/TreeField.php`
- `app/Filament/Blocks/VideoSpatie.php`
- `app/Filament/Blocks/Slider.php`

### `git-multi-org-sync-handoff.md` — Handoff — multi-org sync (STORY-003)


# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_ui_fila5/issues/20 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Discussion | https://github.com/provtv/<nome repository>/discussions/204 |

### `global-search-2.md` — Global search — risorse esterne


# Global search — risorse esterne

> Fonti raccolte durante lo studio dell'argomento. Una fonte vale quando la si
> collega a un punto del codice: leggila, poi trova dove è già applicata.

## Riferimenti

- <https://github.com/spatie/laravel-searchable>

### `global-search.md` — global-search


https://github.com/spatie/laravel-searchable


### `glossary.md` — Glossario di dominio UI


# Glossario di dominio UI

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/UI/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Blocco | Componente di contenuto riusabile (hero, heading, immagine, slider, navigazione, ...) scelto nel builder Filament. | `app/Filament/Blocks/` |
| Elenco blocchi | Scoperta dei blocchi dei moduli: nome snake dalla classe, modulo dal namespace. | `app/Actions/Block/GetAllBlocksAction.php` |
| Blocco localizzato | Dati del blocco risolti dal CMS se il modulo Cms esiste, altrimenti parametri invariati. | `app/Actions/Block/GetLocalizedBlockDataAction.php` |
| Slider | Dati di una slide (miniature desktop e mobile, link, titolo, descrizioni) e relativa collezione. | `app/Datas/SliderData.php`, `app/Datas/SliderDataC

### `group-column-fix.md` — GroupColumn Fix - Risoluzione Errore "Column not mounted to table"


# GroupColumn Fix - Risoluzione Errore "Column not mounted to table"

## Problema
L'errore `LogicException - The column [matr] is not mounted to a table` si verificava quando il componente `GroupColumn` veniva utilizzato in una tabella Filament. Il problema era che le colonne figlio non erano correttamente montate alla tabella padre.

## Causa
Il metodo `table()` del `GroupColumn` non assicurava che tutte le colonne figlio fossero correttamente montate alla stessa tabella, causando l'errore quando Filament tentava di accedere alle proprietà delle colonne figlio.

## Soluzione Implementata

### 1. Miglioramento del metodo `table()`
```php
public function table(?Table $table): static
{
    parent::table($table);

    if ($table !== null) {
        foreach ($this->schema as $child) {
       

### `groupcolumn-child-rendering.md` — GroupColumn — rendering delle colonne figlie


# GroupColumn — rendering delle colonne figlie

## Sintomo

Una `IconColumn::make('ha_diritto')->boolean()` dentro un `GroupColumn` mostrava
`1` invece dell'icona. La stessa colonna, usata come colonna top-level, funzionava.

## Causa

La view `ui::filament.tables.columns.group` **stringificava lo state**:

```php
$value = $field->getState();          // boolean -> 1
$displayText = $labelText . ': ' . $value;
{{ $displayText }}
```

Il `->boolean()` di `IconColumn` agisce nel **suo** rendering
(`IconColumn::toEmbeddedHtml()`), che non veniva mai invocato. Lo stesso valeva

### `groupcolumn-relationship-resolution-analysis.md` — GroupColumn Relationship Resolution - Analisi Tecnica Dettagliata


# GroupColumn Relationship Resolution - Analisi Tecnica Dettagliata

## Problema Identificato

Il `TextColumn::make('valutatore.nome_diri')` funziona correttamente in `ListCondizioniLavoroAdms` ma non quando usato all'interno di `GroupColumn` del modulo UI.

## Analisi del Codice Sorgente

### 1. TextColumn Standard - Come Funziona

Il `TextColumn` di Filament utilizza il trait `HasCellState` che implementa il metodo `getStateFromRecord()`:

```php
// Da vendor/filament/support/src/Concerns/HasCellState.php:107-164
public function getStateFromRecord(): mixed
{
    $record = $this->getRecord();

    if ($record instanceof Model) {

### `groupcolumn.md` — GroupColumn Documentation


# GroupColumn Documentation

## Overview

The `GroupColumn` is a custom Filament table column component that allows you to group multiple fields together in a single table cell. It's particularly useful for displaying related information compactly.

## Key Features

### 1. **Dot Notation Support** ✅
The GroupColumn now supports Laravel's dot notation for accessing relationship data:
```php
TextColumn::make('valutatore.nome_diri')  // Works correctly!
TextColumn::make('user.profile.name')     // Works correctly!
```

### 2. **Automatic Label Translation**
Labels are automatically resolved using:
- Explicit label set on the column
- Translation files (`ui::table.columns.{field_name}.label`)

### `icons/icon-system.md` — UI Module Icon System


# UI Module Icon System

## How It Works

`XotBaseServiceProvider::registerBladeIcons()` automatically registers each module's SVG directory with BladeUI/Icons using the module's lowercase alias as prefix.

```php
// XotBaseServiceProvider.php (line 65-76)
public function registerBladeIcons(): void
{
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
        $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
        $svgPath = $assetsPath.'/../svg';
        if (File::exists($svgPath)) {
            $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
        }
    });
}
```

### `iconstatesplitcolumn-implementation-1.md` — IconStateSplitColumn Implementation


# IconStateSplitColumn Implementation

## Overview

The `IconStateSplitColumn` is a custom Filament table column component designed to display state transition icons in a compact, responsive grid layout. It extends Filament's `Column` component to provide an optimized user experience for state management in tables.

## Key Features

### 🎯 **Space Optimization**
- **Compact Design**: Minimizes table space usage while maintaining full functionality
- **Responsive Grid**: Adapts column count based on screen size
- **Efficient Layout**: Icons are arranged in a grid to maximize space utilization

### 📱 **Responsive Design**
- **Mobile**: 2 columns for touch-friendly interaction
- **Small screens**: 3 columns for better visibility
- **Medium screens**: 4 columns for optimal balance
- **Large sc

### `id-column-record-anchor.md` — IDColumn: colonna id e ancora della riga


# IDColumn: colonna id e ancora della riga

> Fact-gate: aggiorna stesso file; link da ADR [0002-idcolumn-mandatory-on-tables](adr/0002-idcolumn-mandatory-on-tables.md).
> User: «colonna id di tipo IDColumn … migliorare con anchor link … docs/adr».

## Cosa fa

`Modules\UI\Filament\Tables\Columns\IDColumn` e' la colonna **obbligatoria** per la
chiave primaria: ordinabile, `copyable()` sullo stato grezzo, cella = self-link
ancora della riga. ADR: [0002-idcolumn-mandatory-on-tables](adr/0002-idcolumn-mandatory-on-tables.md).

```php
use Modules\UI\Filament\Tables\Columns\IDColumn;

'id' => IDColumn::make(),
```

Rende:

```html
<span id="record-1875" class="scroll-mt-24">1875</span>
```

### `ignore-suppressions-audit.md` — Audit `@phpstan-ignore` su Modules/UI


# Audit `@phpstan-ignore` su Modules/UI

48 soppressioni concentrate in 3 file: `tests/Unit/Models/ThemeModelTest.php`,
`AssetModelTest.php`, `ComponentModelTest.php`. Tutti e tre testavano
`Modules\UI\Models\Theme`, `Asset`, `Component` — tre classi mai esistite in questo
repo: nessun `app/Models/{Theme,Asset,Component}.php`, nessuna factory, nessuna
migration, nessun altro file del modulo le referenzia (verificato con `grep -r` su
tutto `Modules/UI`, zero hit fuori dai tre test).

## Decisione: cancellati, non creati i modelli

I test contenevano un blocco di commento che citava
`docs/wiki/rules/no-phpstan-probe-models.md` come giustificazione del pattern
"modello opzionale, test annotato invece di creare un probe model". **Quel file non
esiste nel repo** — verificato con `find` su tutt

### `infolist-schema-guidelines.md` — Linee Guida per l'Implementazione di getInfolistSchema


# Linee Guida per l'Implementazione di getInfolistSchema

## Requisiti Fondamentali

La funzione `getInfolistSchema()` deve **sempre** restituire un array con chiavi di tipo stringa. Questo documento fornisce le linee guida per garantire un'implementazione corretta e coerente in tutto il progetto.

## Implementazione Corretta

### Struttura Base

L'unico approccio corretto per implementare `getInfolistSchema()` è utilizzare array associativi con chiavi di tipo stringa:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array

### `inline-date-picker.md` — InlineDatePicker Component


# InlineDatePicker Component

A customizable inline date picker component for Filament forms with month navigation and enabled/disabled date support.

## Features

- **Month Navigation**: Navigate between months with previous/next buttons
- **Enabled/Disabled Dates**: Specify which dates are selectable
- **Localization**: Built-in support for multiple languages
- **Keyboard Navigation**: Full keyboard accessibility
- **Customizable Styling**: Easily customize the appearance
- **Week Numbers**: Optional week number display
- **First Day of Week**: Configure which day starts the week

## Installation

This component is part of the UI module and is available out of the box.

## Basic Usage

### `inlineate-picker.md` — InlineDatePicker Component


# InlineDatePicker Component

A customizable inline date picker component for Filament forms with month navigation and enabled/disabled date support.

## Features

- **Month Navigation**: Navigate between months with previous/next buttons
- **Enabled/Disabled Dates**: Specify which dates are selectable
- **Localization**: Built-in support for multiple languages
- **Keyboard Navigation**: Full keyboard accessibility
- **Customizable Styling**: Easily customize the appearance
- **Week Numbers**: Optional week number display
- **First Day of Week**: Configure which day starts the week

## Installation

This component is part of the UI module and is available out of the box.

## Basic Usage

### `internal-debate-psr4-resolution.md` — Internal Debate: PSR-4 Autoloading Resolution Strategy


# Internal Debate: PSR-4 Autoloading Resolution Strategy

**Date**: [DATE]
**Context**: Resolving `composer dumpautoload -o` PSR-4 compliance errors
**Debate Format**: Pro/Con analysis of different approaches

## 🎭 The Debate: Me vs Myself

### **Side A: The Purist (Strict Standards Adherent)**
> "We must follow PSR-4 exactly! One class per file, correct namespaces, no exceptions!"

### **Side B: The Pragmatist (Practical Problem Solver)**
> "We need a working solution that maintains functionality while fixing standards compliance."

## 💭 Thought Process

### Issue 1: Test File with Multiple Classes

**Side A (Purist)**:

### `investigation/ui-investigation.md` — Investigation: UI Component System

# Investigation: UI Component System

## Problem Statement
Il modulo UI ha 33 stories ma manca un'investigation che analizzi le feature mancanti e proponga miglioramenti architetturali.

## Current State
- Stories: 33 (phpstan cleanup, component refactoring, Filament integration)
- Architettura: Actions, Filament, Livewire, Components, Forms, Models, Providers, Rules, Services, Traits
- Decision-log: presente (threaded record)

## Feature Missing
1. **Design System Tokens** - Token mapping per tutti i componenti (colori, spacing, radius, elevation)
2. **Component Library** - Documentazione componenti riutilizzabili con API pubblica
3. **Accessibility Audit** - Verifica APCA contrast, stati focus-visible, prefers-reduced-motion
4. **Visual Regression** - Baseline screenshots per componenti 

### `keting-components-implementation.md` — Marketing Components Implementation - UI Module


# Marketing Components Implementation - UI Module

**Date**: February 6, 2026
**Status**: Planning Phase
**Priority**: High

---

## Overview

This document outlines the marketing components that need to be implemented in the UI Module to support SEO, lead generation, and monetization features.

---

## Component Architecture

### Component Hierarchy

```

### `lang-link-1.md` — Collegamento alle Traduzioni del Modulo UI


# Collegamento alle Traduzioni del Modulo UI

Questo modulo utilizza le traduzioni centralizzate nella cartella [Lang](../../Lang/docs/).

Consulta la documentazione delle traduzioni:
- [Introduzione alle Traduzioni](../../Lang/docs/introduction.md)
- [Struttura delle Traduzioni](../../Lang/docs/structure.md)
- [Gestione dei File di Lingua](../../Lang/docs/module_lang.md)

## Collegamento Bidirezionale

Per ogni risorsa o campo localizzato, vedi anche il file corrispondente in questo modulo e la relativa sezione in [Lang](../../Lang/docs/).

> Aggiorna entrambi i riferimenti se aggiungi nuove chiavi di traduzione o modifichi la struttura.

## Collegamenti tra versioni di lang-link.md
* [lang-link.md](../../../Chart/docs/lang-link.md)
* [lang-link.md](../../../Reporting/docs/lang-link.md)


### `laravel-13-upgrade.md` — Upgrade Laravel 13 - UI 🐄✨


# Upgrade Laravel 13 - UI 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **UI** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `nwidart/

### `launch-plan.md` — Product Launch Plan: UI Module v1.0


# Product Launch Plan: UI Module v1.0

## 🚀 Launch Overview
- **Launch Date:** March 2026
- **Launch Lead:** @CoreTeam

## 🎯 Launch Goals
- Deploy the "Super Mucca" Design System across the entire ecosystem.
- Achieve full WCAG 2.1 AA compliance for core components.

## 📣 Messaging & Positioning
- **Value Proposition:** Beautiful, accessible, and consistent interfaces for complex data.
- **Key Pillars:** Component-Based, Accessible, Filament-Ready.

## 📈 Post-Launch Tracking
Monitor user satisfaction scores and frontend bundle performance.

### `layouts-and-themes-1.md` — Versione HEAD


# Struttura dei Temi

## Posizionamento Corretto dei Temi

Nel progetto, è fondamentale mantenere una chiara separazione tra moduli funzionali e temi. I temi devono essere posizionati nella directory `Themes`, non nella directory `Modules`.

### Struttura Corretta

```
/laravel/
├── Modules/        # Contiene i moduli funzionali
│   ├── Xot/
│   ├── User/
│   ├── Patient/
│   └── ...
└── Themes/         # Contiene i temi dell'applicazione
    ├── One/        # Tema principale

### `lessons-learned/reusable-filament-components-pattern.md` — Il componente riutilizzabile porta la sua logica (case study: OrderColumn)


# Il componente riutilizzabile porta la sua logica (case study: OrderColumn)

## L'errore che si è ripetuto

Prima di introdurre `OrderColumn`, la colonna "order" veniva ricostruita inline in ogni
Table class che ne aveva bisogno (`TextColumn::make('order_column')->sortable()->...`),
duplicando styling e comportamento (toggleable, tooltip, label) in ogni Resource.

## Perché è sbagliato

Logica di visualizzazione ripetuta in più Resource significa: se cambia lo stile del badge
o il comportamento delle frecce, va aggiornato in ogni punto dove è stato copiato. Il
componente diventa un "concetto" solo nella testa dello sviluppatore, non nel codice.

## Come si fa correttamente

Componenti custom dedicati, uno per contesto (Table e Form sono contesti diversi):

```php

### `manuale-uso-attori.md` — Manuale d'uso per attori — UI

# Manuale d'uso per attori — UI

## Scopo e perimetro

UI fornisce componenti Blade, tema/chrome Filament, tabelle, blocchi, icone,
widget e dati di presentazione. Legge alcuni dati dell'utente autenticato e
preferenze UI, ma non è il modulo che decide identità, ruoli o autorizzazioni.

## Attori e capacità effettive

| Attore | Capacità nel modulo UI |
|---|---|
| Ospite | Può ricevere la resa UI pubblica. `GetUserDataAction` restituisce `null` in assenza di autenticazione; non viene quindi attribuito un profilo UI autenticato. |
| Utente autenticato | La UI può mostrare nome, email, avatar, primo ruolo e permessi restituiti dall'azione dati utente. Può usare le preferenze esposte dal tema, come il cambio modalità scura quando abilitato. |
| Utente in gruppo/ruolo | N/A come capacità di d

### `manuals/manuale-utente.md` — Manuale d'uso per attori — UI


> Screenshot reale del front office FixCity, verificato il 23 novembre 2026. Per questo modulo è una superficie condivisa: il manuale non attribuisce al modulo una UI propria se non documentata dalle fonti.

![Screenshot reale del front office](assets/front-office-home.png)

# Manuale d'uso per attori — UI

## Scopo e perimetro

UI fornisce componenti Blade, tema/chrome Filament, tabelle, blocchi, icone,
widget e dati di presentazione. Legge alcuni dati dell'utente autenticato e
preferenze UI, ma non è il modulo che decide identità, ruoli o autorizzazioni.

## Attori e capacità effettive

| Attore | Capacità nel modulo UI |
|---|---|
| Ospite | Può ricevere la resa UI pubblica. `GetUserDataAction` restituisce `null` in assenza di autenticazione; non viene quindi attribuito un profilo UI a

### `manuals/user-manual.md` — Manuale utente UI


# Manuale utente UI

Integra il [manuale actor-oriented](../manuale-uso-attori.md). UI fornisce componenti riusabili, non autorizzazioni.

## Attori e uso

| Attore | Uso verificato |
|---|---|
| Utente normale/gruppo | Usa componenti esposti dal modulo funzionale. |
| Admin/super-admin | Usa widget, form e tabelle secondo policy owner. |
| Sviluppatore/integratore | Riusa componenti senza duplicare markup o sicurezza. |

La UI non sostituisce policy, query o ownership.

## Evidenza visuale reale

![Schermata reale documentata dei componenti UI](../../screenshots/event-detail-page.png)

Screenshot reale presente nella documentazione del modulo.

### `map-integration-guide.md` — 🗺️ GUIDA INTEGRAZIONE MAPPA INTERATTIVA


# 🗺️ GUIDA INTEGRAZIONE MAPPA INTERATTIVA

**Modulo**: UI (User Interface)
**Versione**: 1.0
**Stato**: 🚧 IN SVILUPPO

---

## 🎯 PANORAMICA

Questa guida descrive l'integrazione di funzionalità mappa interattiva nel modulo UI, ispirate al progetto [farmshops.eu](https://farmshops.eu/). L'obiettivo è fornire componenti riutilizzabili per visualizzazioni geografiche in tutta l'applicazione FixCity.

---

## 🏗️ ARCHITETTURA COMPONENTI

### 📦 Struttura Modulo UI Estesa

```

### `marketing-components-implementation.md` — Marketing Components Implementation - UI Module


# Marketing Components Implementation - UI Module

**Date**: February 6, 2026
**Status**: Planning Phase
**Priority**: High

---

## Overview

This document outlines the marketing components that need to be implemented in the UI Module to support SEO, lead generation, and monetization features.

---

## Component Architecture

### Component Hierarchy

```

### `mcp-configuration.md` — MCP Server Configuration - UI Module


# MCP Server Configuration - UI Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The UI module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Task and project management
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Direct file access
- **Database** - SQLite queries for data inspection

---


### `mcp-ui-ux.md` — MCP Servers per UI/UX - Modulo UI


# MCP Servers per UI/UX - Modulo UI


## Scopo

Questo documento descrive quali MCP server sono configurati per migliorare la qualità della UI/UX nel progetto e come usarli nel contesto del modulo UI.

## MCP Attivi per UI/UX

| MCP Server | Scopo | Comando |
| --- | --- | --- |
| flowbite | Componenti Tailwind CSS, Figma-to-code, theming | `npx -y flowbite-mcp` |
| shadcn | Registry componenti, installazione via prompt | `npx shadcn@latest mcp` |
| daisyui | Blueprint MCP, generazione UI 10x | `npx -y daisyui@latest mcp` |
| mui-mcp | Docs Material UI accurate | `npx -y @mui/mcp@latest` |

## Integrazione con il Modulo UI

Il modulo UI fornisce componenti Blade condivisi in `resources/views/components/ui/`. Quando si generano componenti via MCP:

### `merge-conflict-markers-committed.md` — Marker di merge committati nel modulo UI


# Marker di merge committati nel modulo UI

> `phpstan analyse Modules` si fermava a **6 errori `phpstan.parse`** senza analizzare
> nulla: `Syntax error, unexpected T_SL`. `T_SL` è l'operatore `<<`, cioè l'inizio di
> `<<<<<<< HEAD`. Nove file del modulo `UI` erano stati committati con i marker di
> conflitto dentro.
## Come si riconosce
Un errore `phpstan.parse` **non è ignorabile** e blocca il resto dell'analisi. Se il
messaggio cita `T_SL` o `unexpected EOF`, cerca i marker prima di qualsiasi altra ipotesi:
```bash
cd laravel && git grep -ln '^<<<<<<< ' -- 'Modules/**/*.php'
```
## I nove file e il criterio applicato
| File | Le due varianti | Criterio |
|---|---|---|
| `Blocks/Navigation.php`, `Blocks/Page.php`, `Blocks/Slider.php` | `getFormSchema` vs `getFormSchemaOld` | **`getForm

### `metodi-duplicati-analisi.md` — 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION


# 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

**Powered by**: Super Mucca AI 🐄✨
**Versione**: 2.0 ULTIMATE
**Confidenza**: 99.9% (Dati Reali dal Codice)

---

## 🎯 Executive Summary

Analisi **REALE e APPROFONDITA** di **18 moduli** + **2 temi** del framework Laraxot/Filament.

### Dati Chiave (VERIFICATI)

| Metrica | Valore | Fonte |
|---------|--------|-------|
| **Moduli Analizzati** | 18 | Directory scan |
| **Temi Analizzati** | 2 (Sixteen, TwentyOne) | Directory scan |
| **BaseModel Totali** | 10 | File count |

### `module-analysis.md` — UI Module - Comprehensive Analysis


# UI Module - Comprehensive Analysis

## Module Overview
**Module Name**: UI
**Type**: User Interface & Component Library Module
**Status**: ✅ Active
**Framework**: Laravel 12.x + Filament 4.x + Tailwind CSS
**Component Library**: Custom UI components and styles
**Language**: Multi-language (IT/EN/DE)

## Purpose
The UI module provides comprehensive user interface components and styling:

- Pre-built UI components (buttons, modals, forms, etc.)
- Consistent design system and styling
- Responsive design with mobile-first approach
- Customizable themes (light/dark/custom branding)
- Accessibility support for inclusive design
- Component library for consistent UI

### `module-ui.md` — Modulo UI


# Modulo UI

## Informazioni Generali
- **Nome**: `laraxot/module_ui_fila3`
- **Descrizione**: Modulo per la gestione dell'interfaccia utente
- **Namespace**: `Modules\UI`
- **Repository**: https://github.com/laraxot/module_ui_fila5.git

- **Repository**: https://github.com/laraxot/module_ui_fila3.git

- **Nome**: `laraxot/module_ui_fila5`
- **Descrizione**: Modulo per la gestione dell'interfaccia utente
- **Namespace**: `Modules\UI`
- **Repository**: https://github.com/laraxot/module_ui_fila5.git

## Service Providers
1. `Modules\UI\Providers\UIServiceProvider`
2. `Modules\UI\Providers\Filament\AdminPanelProvider`


### `module.md` — UI Module — Doctrine


# UI Module — Doctrine

## Scope (Scopo)

UI è il sistema di design e componenti riutilizzabili del monorepo. Fornisce componenti Filament/Folio/Volt condivisi, temi, pattern di layout, e convenzioni di stile che garantiscono coerenza visiva su tutti i moduli. Ogni modulo Filament usa i componenti UI invece di implementare i propri.

## Religion (Religione)

**"Una libreria di componenti, usi infiniti. Filament per admin, Folio+Volt per pubblico, DRY ovunque."** UI non duplica mai: un componente scritto una volta è usato da tutti i moduli. Il design system è la Bibbia visuale: ogni colore, ogni spacing, ogni tipografia è definito una sola volta.

## Philosophy (Filosofia)

- **Xot-first components**: ogni componente UI estende un componente XotBase, mai Filament diretto
- **Theme-aware st

### `multi-org-sync-laraxot-provtv.md` — Sincronizzazione multi-organizzazione (laraxot + provtv)


# Sincronizzazione multi-organizzazione (laraxot + provtv)

## Cosa è stato fatto

Questo repository è tracciato da due remote GitHub (`laraxot` = org upstream canonica,
`provtv` = org operativa del progetto ptvx). Il 2026-07-21 è stata eseguita una
sincronizzazione completa seguendo `bashscripts/tools/prompts/02-gitmodules-sync.md`:
fetch di tutti i remote, quality gates (PHPStan L10, PHPMD), risincronizzazione dopo ogni modifica.

## Problemi riscontrati e risolti

- **Clone shallow**: il repo era stato clonato con storia troncata, causando push
  respinti (`did not receive expected object`). Fix: `git fetch --unshallow` su tutti i remote.
- **Storie scollegate ("unrelated histories")**: alcuni repo avevano un branch `dev`
  remoto rigenerato senza antenato comune con la storia locale. 

### `naming-conventions-1.md` — Collegamenti tra versioni di naming-conventions.md


## Collegamenti tra versioni di naming-conventions.md
* [naming-conventions.md](../../../../docs/naming-conventions.md)
* [naming-conventions.md](../../Xot/docs/naming-conventions.md)
* [naming-conventions.md](../../Patient/docs/naming-conventions.md)

### `naming-rules-1.md` — Regole di Naming nei Moduli


# Regole di Naming nei Moduli

## Regola: No Nomi Specifici dell'Applicazione

### Motivazione
I moduli devono essere generici e riutilizzabili. L'uso di nomi specifici dell'applicazione (come "il progetto") nella documentazione dei moduli:
1. Riduce la riutilizzabilità del modulo
2. Crea accoppiamento stretto con l'applicazione specifica
3. Rende più difficile il riutilizzo in altri progetti
4. Viola il principio di modularità

### Esempi

❌ **Non Corretto**:
```md
# Design System il progetto
Il design system di il progetto definisce...
```


### `navigation-components-1.md` — Componenti di Navigazione


# Componenti di Navigazione

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Gestione dell'Autenticazione](#gestione-dellautenticazione)
- [Localizzazione](#localizzazione)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti di navigazione , con particolare attenzione alla gestione condizionale dell'autenticazione e alla localizzazione.

## Componenti Disponibili

### Componenti di Navigazione Principali

- `<x-blocks.navigation.user-dropdown>` - Dropdown utente (visualizzato solo per utenti autenticati)
- `<x-blocks.navigation.login-buttons>` - Pulsanti di login/registrazione (visualizzati solo per utenti non autenticati)

### `nestedset-migration-best-practices.md` — NestedSet Migration Best Practices - UI Module


# NestedSet Migration Best Practices - UI Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo UI utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Temi

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\ThemeCategory::class;


### `no-git-lfs.md` — Git LFS non si usa in questo progetto


# Git LFS non si usa in questo progetto

Vale per il repo root, per `bashscripts/` e per ogni modulo e tema. Questo modulo non fa
eccezione.

## La regola

I binari — immagini, font, PDF, archivi — si versionano come **blob git normali**.

Vietato:

- aggiungere `filter=lfs diff=lfs merge=lfs` in un qualunque `.gitattributes`;
- eseguire `git lfs install` o `git lfs track` dentro questo repo;
- committare come contenuto di un file il testo `version https://git-lfs.github.com/spec/v1`.

## Perche'

Non e' una preferenza di stile, e' il risultato di incidenti ripetuti.


### `no-svg-hardcoded-in-blade.md` — Regola: No SVG Hardcoded nelle Blade


# Regola: No SVG Hardcoded nelle Blade

## Scopo

Gli SVG **non devono** essere scritti inline nelle view Blade. Vanno creati come file in `Modules/UI/resources/svg/` e richiamati tramite `@svg()` o `<x-filament::icon>`.

## Motivazione

1. **DRY**: Logo e icone riutilizzabili (Google, GitHub, Microsoft, Facebook) in un unico punto
2. **Manutenibilità**: Modifiche al logo in un solo file
3. **Filament way**: Preferire `<x-filament::icon>` per coerenza con l'ecosistema
4. **Consistenza**: Tutte le icone seguono lo stesso pattern di registrazione

## Dove Creare gli SVG

### Icone riutilizzabili (brand, utility)

```
laravel/Modules/UI/resources/svg/

### `notify-quality-gate-resolution.md` — Notify Module Quality Gate Resolution


# Notify Module Quality Gate Resolution

## Overview

**Objective:** Make laravel/Modules/Notify pass PHPStan L10, PHPMD, and PHP Insights quality gates.

**Status:** 🔧 IN PROGRESS

**Errors Found:** 89 PHPStan errors (mostly Safe\ namespace and type issues)

---

## Error Categories

### 1. Safe\ Functions Not Found (56 errors)

**Identifier:** `function.notFound`

**Files Affected:**

### `notify-user-git-push-resolution.md` — Notify & User Git Push Resolution


# Notify & User Git Push Resolution

## Problema User: Git LFS Missing Objects

**Sintomo:**
```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects:
remote: Try to push them with 'git lfs push --all'.
To github.com:provtv/module_user_fila5.git
 ! [remote rejected] dev -> dev (pre-receive hook declined)
```

**Causa:**
I file LFS erano stati modificati localmente ma gli oggetti LFS non erano stati caricati al server remoto.

**Risoluzione:**
```bash
cd laravel/Modules/User
git lfs push --all provtv dev  # Push LFS objects al remote

### `on-demand-pattern.md` — On-Demand Pattern — Module **UI**


# On-Demand Pattern — Module **UI**

**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)

## Principio

Questo module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
- ✅ **Caricati on-demand** — via trigger map o `qmd search`
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

### `overview-extended.md` — 🎨 **UI Module** - Sistema Avanzato Componenti Interfaccia


# 🎨 **UI Module** - Sistema Avanzato Componenti Interfaccia

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
# 🎨 **UI Module** - Sistema Avanzato Componenti Interfaccia

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 4.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](htt

### `paths-and-assets-1.md` — AVVISO IMPORTANTE (2025-05-13)


# AVVISO IMPORTANTE (2025-05-13)

> **ATTENZIONE:** Tutti i componenti UI condivisi (come `logo.blade.php`) devono essere SEMPRE posizionati in `Modules/UI/resources/views/components/ui/` e MAI in `resources/views/components/`. Qualsiasi violazione di questa regola causa errori di rendering, override errati, problemi di modularità e manutenzione.
>
> **Errore riscontrato:** Il componente `logo.blade.php` era stato posizionato erroneamente in `resources/views/components/ui/` invece che in `Modules/UI/resources/views/components/ui/`.
>
> **Causa:** Dimenticanza della regola di modularità Laraxot: tutti i componenti Blade UI condivisi devono essere sempre nel modulo UI, mai nella root Laravel.
>
> **Soluzione:** Seguire SEMPRE la regola documentata qui sotto e aggiornata anche in README.md e

### `patterns.md` — UI — Decisioni Architetturali e Patterns


# UI — Decisioni Architetturali e Patterns

> **Scopo**: Raccogliere decisioni architetturali, workflow core, e anti-pattern da evitare nel modulo UI.

## 🎯 Decisioni Architetturali Fondamentali

### 1. Blade Components con Prefisso x-ui::ui.

**Decisione**: Tutti i Blade components devono usare il prefisso `x-ui::ui.` per distinguerli da componenti Filament e package third-party.

**Motivo**:
- Evita collisioni di naming con Filament native components
- Rende evidente l'origine del componente (UI module)
- Facilita namespace organization e discovery

**Implementazione**:

```blade
<!-- ✅ CORRETTO: Prefisso x-ui::ui. -->

### `performance-optimization.md` — Performance Optimization — Module **UI**


# Performance Optimization — Module **UI**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

\`\`\`diff
- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand
\`\`\`

### 2. Cache Esterna al Repo

\`\`\`diff
- .cache/ (8KB nel repo)
+ ~/.cache/qmd-cache/ (fuori da git)

### `philosophy-dev-rules.md` — UI Module Philosophy


# UI Module Philosophy

Reusable components, design system, and patterns for Filament, Folio, and Volt across all 47 modules.

## First Principle

> **One component library, infinite uses. Filament for admin, Folio+Volt for public, DRY everywhere.**

UI components are shared, not reinvented per module. Patterns are consistent. Base classes from Xot are extended, not bypassed.

## The Rules

### 1. Xot-First Components, Never Filament Direct

All UI components extend Xot base classes:
```php
// Resources
class MyResource extends XotBaseResource { }


### `philosophy.md` — UI Module Philosophy


# UI Module Philosophy

A design system is not a collection of components. It is a covenant about how an interface thinks.

This document captures the philosophical and technical foundations of the UI module. It is not a tutorial; it is the reasoning behind the constraints.

---

## Religione: The Non-Negotiable Dogmas

### 1. UI is Vocabulary, Not Clothing

The UI module defines **what exists** in the interface. The theme defines **how it appears**.

**The distinction is not academic.**

A component born in UI is portable: it can migrate to another project in the ecosystem. A component born in a theme is poisoned: it carries style assumptions that other projects do not share.

**The boundary is reusability, not convenience of the moment.**

### `phpmd-improvements.md` — Miglioramenti PHPMD e PHP Insights - Modulo UI - Aggiornamento Finale


# Miglioramenti PHPMD e PHP Insights - Modulo UI - Aggiornamento Finale

## Riepilogo Correzioni Completate

### Problemi Critici Risolti

#### 1. CyclomaticComplexity Ridotta

**IconStateColumn::configureIconCallbacks()**: Da 10 → <10
- Estratta logica in metodi separati:
  - `getIconFromState()`
  - `getColorFromState()`
  - `getLabelFromState()`

**GetAllIconsAction::execute()**: Da 10 → <10
- Estratta logica in metodi separati:
  - `extractIconsFromFactory()`
  - `processIconSets()`
  - `extractIconsFromSet()`

### `phpstan-error-analysis-strategy.md` — Strategia Correzione Errori PHPStan - RadioBadge.php


# Strategia Correzione Errori PHPStan - RadioBadge.php

**File**: `app/Filament/Forms/Components/RadioBadge.php`
**Errori**: 3

## 🔍 Analisi Approfondita Errori

### Errore #1: PHPDoc Parse Error (Line 24)

**Messaggio PHPStan**:
```
PHPDoc tag @return has invalid value
(BackedEnum&HasColor&HasIcon|null): Unexpected token "|", expected TOKEN_OTHER at offset 94
```

**Codice Attuale**:
```php
/**
 * Get enum value from string value.

### `phpstan-error-analysis.md` — Analisi Errori PHPStan - Modulo UI


# Analisi Errori PHPStan - Modulo UI

**Modulo**: UI
**Livello PHPStan**: max
**Status**: ✅ Corretto (0 errori)

## 📊 Risultati PHPStan

**Comando eseguito**: `./vendor/bin/phpstan analyse Modules/UI --memory-limit=-1`
**Livello**: max
**File con errori**: `app/Filament/Forms/Components/RadioBadge.php`
**Errori totali**: 0 (dopo correzione)

## 🔍 Errori Risolti

### Errore #1: PHPDoc Parse Error (Line 24) ✅

**Problema**: Sintassi PHPDoc non valida `BackedEnum&HasColor&HasIcon|null`


### `phpstan-level-10-cleanup.md` — PHPStan Level 10 Cleanup Session - [DATE]


# PHPStan Level 10 Cleanup Session - [DATE]

## Executive Summary

- Session precedente ([DATE]): ✅ zero errori PHPStan Level 10.
- Nuova esecuzione ([DATE]): ⚠️ rilevato 1 parse error in `UI/app/Filament/Blocks/Title.php` (`unexpected EOF`).
- Obiettivo attuale: ripristinare il blocco Title seguendo le specifiche documentate in `./index.md` e `./core/architecture.md`, quindi rilanciare `phpstan`.

**Metriche aggiornate**:
- **Starting errors (nuova run)**: 1 parse error
- **Final errors**: da risolvere
- **Files impattati**: `Blocks/Title.php`
- **Azioni richieste**: ricostruire blocco, aggiungere test snapshot

### Bloccante attuale

- **File**: `UI/app/Filament/Blocks/Title.php`
- **Errore**: `Syntax error, unexpected EOF on line 23`
- **Contesto**: blocco utilizzato nei layout descrit

### `phpstan-level-10-compliance.md` — PHPStan Level 10 Compliance - UI Module


# PHPStan Level 10 Compliance - UI Module

**Ultimo aggiornamento**: [DATE]
**Status**: ✅ Completamente conforme a PHPStan Level 10

## 📊 Stato Corrente
- **Errori PHPStan**: 0
- **Livello analisi**: Level 10 (massimo)
- **Data ultima verifica**: [DATE]

## 🔧 Correzioni Applicate

### 1. Instanceof Sempre Vero
**Problema**: Controllo instanceof tra stessa classe sempre vero
- **File corretto**: `app/Filament/Tables/Columns/SelectStateColumn.php`
- **Errore**: `instanceof.alwaysTrue`
- **Soluzione**: Rimosso controllo ridondante

```php

### `phpstan-level10-bugfixes-comprehensive.md` — PHPStan Level 10 Comprehensive Bugfixes


# PHPStan Level 10 Comprehensive Bugfixes

## Problema Generale
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, , UI, Xot.
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, <nome progetto>, UI, Xot.
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, , UI, Xot.
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, <nome progetto>, UI, Xot.
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, , UI, Xot.
Errori PHPStan Level 9+ rilevati durante la scansione multi-modulo: Media, <nome progetto>, <nome progetto>, UI, Xot.

## Moduli Interessati e Correzioni

### 🟢 **Media Module** - S3 Actions

### `phpstan-namespace-correction.md` — Correzione Namespace nel Modulo UI


# Correzione Namespace nel Modulo UI

## Problema Identificato
L'analisi PHPStan ha rilevato un errore nel namespace del modulo UI. Il namespace attuale è:
```php
namespace Modules\UI\app\Actions;
```

Mentre dovrebbe essere:
```php
namespace Modules\UI\Actions;
```

## Analisi dell'Errore

### Struttura Corretta dei Namespace
In un'applicazione Laravel modulare, la struttura dei namespace dovrebbe seguire questa convenzione:
```
Modules\{NomeModulo}\{TipoComponente}

### `phpstan-patterns.md` — PHPStan Level 10 - Pattern Riutilizzabili


# PHPStan Level 10 - Pattern Riutilizzabili

> **Modulo**: UI
> **Scopo**: Pattern pratici per raggiungere PHPStan Level 10 senza compromessi
> **Filosofia**: DRY + KISS - Pattern semplici, riutilizzabili, focalizzati sul PERCHÉ

---

## 🎯 Perché Questi Pattern

### Business Logic

**Type Safety = Meno Bug in Production**

Ogni `@phpstan-ignore` è un potenziale bug nascosto. PHPStan Level 10 garantisce che:
- Il codice fa ciò che dichiara di fare
- Gli errori sono catturati a compile-time, non a runtime
- Il refactoring è sicuro e affidabile
- L'IDE fornisce autocompletion accurato

### `phpstan-property-exists-elimination.md` — PHPStan Property Exists Elimination - UI Module


# PHPStan Property Exists Elimination - UI Module

## Overview
Documentazione della correzione dell'anti-pattern `property_exists()` nel modulo UI.

## Critical Rule Applied

### ❌ ANTI-PATTERN: property_exists()
```php
// SBAGLIATO - Non funziona con Eloquent magic properties
if (property_exists($model, 'attribute')) {
    $value = $model->attribute; // $value sarà sempre null/undefined
}
```

### ✅ CORRECT: isset() per Eloquent
```php
// CORRETTO - Rispetta __isset() magic method
if (isset($model->attribute)) {

### `phpstan-radio-badge-fix-1.md` — Correzione Errori PHPStan - RadioBadge.php


# Correzione Errori PHPStan - RadioBadge.php

## Data Aggiornamento
2025-01-27

## File Modificato
`Modules/UI/app/Filament/Forms/Components/RadioBadge.php`

## Errori PHPStan Risolti

### 1. **PHPDoc tag @return con sintassi non valida**
- **Errore**: `PHPDoc tag @return has invalid value (null|BackedEnum&HasColor): Unexpected token "&"`
- **Causa**: Sintassi non corretta per l'intersezione di tipi in PHPDoc
- **Soluzione**: Corretta la sintassi PHPDoc per includere entrambe le interfacce

### 2. **Metodo senza tipo di ritorno**
- **Errore**: `Method getEnumValue() has no return type specified`
- **Causa**: Metodo `getEnumValue()` mancava del tipo di ritorno
- **Soluzione**: Aggiunto tipo di ritorno `?BackedEnum`

### `phpstan-radio-badge-fix.md` — Correzione Errori PHPStan - RadioBadge.php


# Correzione Errori PHPStan - RadioBadge.php

## Data Aggiornamento
[DATE]

## File Modificato
`Modules/UI/app/Filament/Forms/Components/RadioBadge.php`

## Errori PHPStan Risolti

### 1. **PHPDoc tag @return con sintassi non valida**
- **Errore**: `PHPDoc tag @return has invalid value (null|BackedEnum&HasColor): Unexpected token "&"`
- **Causa**: Sintassi non corretta per l'intersezione di tipi in PHPDoc
- **Soluzione**: Corretta la sintassi PHPDoc per includere entrambe le interfacce

### 2. **Metodo senza tipo di ritorno**
- **Errore**: `Method getEnumValue() has no return type specified`
- **Causa**: Metodo `getEnumValue()` mancava del tipo di ritorno
- **Soluzione**: Aggiunto tipo di ritorno `?BackedEnum`

### `phpstan-roadmap.md` — PHPStan Roadmap - UI Module


# PHPStan Roadmap - UI Module

> **Date**: [DATE]
> **Status**: ✅ Fully Compliant (Level 10)
> **Errors**: 0

## Current Status
The **UI** module is fully compliant with PHPStan Level 10. No errors were reported in the latest analysis.

## Maintenance Strategy
1.  **Strict Typing**: Ensure all new code uses strict types (`declare(strict_types=1);`).
2.  **Regular Checks**: Run PHPStan before every commit.
3.  **Documentation**: Keep PHPDocs up-to-date for complex types.

## Future Goals
- Maintain 0 errors.
- Periodic review of ignored errors (if any exist in `phpstan.neon`, though none should).

### `phpstan-status.md` — PHPStan Status — UI Module


# PHPStan Status — UI Module

## Current Status: PASSED

- **Level**: max (root `laravel/phpstan.neon`)
- **Errors**: **0**
- **Last Checked**: 2026-11-16
- **Story**: [bmad/stories/phpstan-modules-zero.story.md](bmad/stories/0017-phpstan-modules-zero.story.md)

## Measure

```bash
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI
# [OK] No errors
```

Inventario di partenza swarm: 112 `file_errors` → 0.

## Perché

### `ponytail-audit-over-engineering.md` — Ponytail audit — UI (over-engineering)


# Ponytail audit — UI (over-engineering)

**Ultimo run:** 2026-07-01  
**Modulo:** design system, componenti Filament/Blade condivisi.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Findings

| # | Tag | Cosa | Sostituzione | Path | Stato |
|---|-----|------|--------------|------|-------|
| UI0 | `delete` | Layer Map/Geocoding speculativo (contratto + `N

### `prd.md` — PRD: UI Module


# PRD: UI Module

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Approved
- **Target Release:** 1.0.0

## ❓ Problem Statement
Inconsistent UI across 30+ modules leads to poor user experience, high maintenance costs, and accessibility violations.

## 🎯 Goals & Success Metrics
- **Goal 1:** Visual Consistency -> **Metric:** 100% of modules use UI-kit components.
- **Goal 2:** Performance -> **Metric:** < 100kb shared CSS/JS bundle size.
- **Goal 3:** Accessibility -> **Metric:** Zero critical WCAG 2.1 issues.

## 👤 User Stories
- As a **User**, I want a familiar interface across all modules so I don't have to relearn the UI.
- As a **Developer**, I want a library of pre-built Blade components so I can build pages faster.


### `product-launch-plan-2.md` — UI Module - Product Launch Plan


# UI Module - Product Launch Plan

**Module:** UI  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Launch Objectives

1. **Product:** Deploy core component library
2. **Adoption:** 50% of features using components
3. **Quality:** Zero accessibility violations
4. **Performance:** <3s page load times

---

## Pre-Launch Checklist

### `product-launch-plan.md` — UI - Product Launch Plan


# UI - Product Launch Plan

> Piano di lancio. Modulo.
> Launch readiness stimata: 71%.

## Obiettivo del lancio

Rilasciare **UI** in modo controllato, misurabile e coerente con il suo ruolo: design system e componenti UI riusabili.

## Audience interna

- owner di modulo o tema
- admin/operatori
- sviluppatori che dipendono dal componente

## Criteri di readiness

- PRD e roadmap aggiornati
- test critici verdi

### `product-requirements.md` — Product Requirements Document (PRD)


# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **
| **Owner** | Frontend Team |
| **Module** | UI |
| **Repository** | laraxot/module_ui_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo UI fornisce **componenti UI condivisi e layout** per l'ecosistema Laraxot. Include componenti Blade riutilizzabili, layout comuni e integrazione Filament.

### `product-roadmap-2.md` — UI Module - Product Roadmap


# UI Module - Product Roadmap

**Module:** UI  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team  
**Status:** In Development

---

## Vision Statement

To create a **unified, beautiful, and accessible design system** that ensures consistent, high-quality user experiences across the entire platform while enabling rapid development and brand coherence.

### Vision Pillars

1. **Consistency:** Unified design language
2. **Accessibility:** WCAG 2.1 AA compliance
3. **Performance:** Fast, responsive interfaces

### `product-roadmap.md` — UI - Product Roadmap


# UI - Product Roadmap

> Documento vivente. Modulo.
> Maturita' stimata: 71% implementato, 29% gap residuo.

## Visione di avanzamento

Questo roadmap traduce il PRD in sequenza di rilascio per **UI**, che nel progetto copre: design system e componenti UI riusabili.

## Orizzonte 0-30 giorni

- chiudere i gap P0 descritti in [PRD](prd.md)
- riallineare codice, test e documentazione
- rimuovere le ambiguita' tra stato reale e stato percepito

## Orizzonte 30-90 giorni

- consolidare test, osservabilita' e metriche
- completare le superfici utente o admin critiche

### `product-strategy-2.md` — UI Module - Product Strategy


# UI Module - Product Strategy

**Module:** UI  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Executive Summary

The UI module provides a comprehensive design system and component library, enabling consistent, accessible, and beautiful user interfaces across the entire platform.

---

## Market Analysis

### TAM / SAM / SOM


### `product-strategy.md` — UI - Product Strategy


# UI - Product Strategy

> Strategia prodotto. Modulo.
> Allineamento strategico stimato: 71%.

## Missione

Portare **UI** a uno stato in cui il progetto ottiene un vantaggio netto e misurabile su questa area: design system e componenti UI riusabili.

## Problema da risolvere

- chiarire il ruolo del componente nel sistema
- evitare sovrapposizioni con altri moduli o temi
- rendere il valore del componente esplicito e verificabile

## Principi strategici

- DRY: riuso prima di duplicare
- KISS: superfici semplici e veritiere

### `project-structure.md` — Project Structure — Module **UI**


# Project Structure — Module **UI**

## Directory Structure

\`\`\`
./laravel/Modules/UI/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-INDEX.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `prompt-rules-link.md` — Regole per i Prompt


# Regole per i Prompt

Per le regole sui prompt, fare riferimento a [Regole Prompt nel modulo Xot](../../Xot/docs/PROMPT_RULES.md)

## Collegamenti tra versioni di PROMPT_RULES_LINK.md
* [PROMPT_RULES_LINK.md](../../../UI/docs/PROMPT_RULES_LINK.md)
* [PROMPT_RULES_LINK.md](../../../Lang/docs/PROMPT_RULES_LINK.md)
* [PROMPT_RULES_LINK.md](../../../Cms/docs/PROMPT_RULES_LINK.md)


## Collegamenti tra versioni di prompt_rules_link.md
* [prompt_rules_link.md](../../Lang/docs/prompt_rules_link.md)
* [prompt_rules_link.md](../../Cms/docs/prompt_rules_link.md)


### `prompts/geo-map-widget.md` — geo-map-widget


bmad-create-story Devi creare un Filament v5 widget chiamato GeoMapWidget all’interno del modulo Geo dell’applicazione Laravel, rispettando rigorosamente l’architettura a moduli e senza inserire codice fuori dal dominio GEO. Il widget deve replicare e migliorare profondamente il comportamento del progetto open source https://github.com/CodeforKarlsruhe/farmshops.eu
 che deve essere studiato a fondo prima di scrivere qualsiasi codice, analizzando in particolare la logica del file direktvermarkter.js e l’intero sistema di gestione dati e mappa. È obbligatorio non inventare funzionalità o librerie inesistenti e non assumere comportamenti non verificati, ma basarsi su standard reali come Leaflet e GeoJSON e verificare sempre le librerie su npm o documentazione ufficiale. Il widget deve mostra

### `prompts/map-picker.md` — map-picker


bmad-create-story Devi creare un campo personalizzato per Filament v5 chiamato MapPicker da usare nelle Resource che
   gestisce una mappa interattiva basata su Leaflet incapsulata in un Web Component Lit riutilizzabile. Il campo deve
   integrarsi con Livewire e Alpine già presenti nel progetto Laravel e deve lavorare con due colonne reali del
   database chiamate latitude e longitude senza usare JSON. Il componente deve mostrare una mappa con marker draggable
   e aggiornare in tempo reale i valori di latitudine e longitudine sia negli input visibili sia nei campi Livewire
   tramite entangle separato per latitude e longitude. Se i valori iniziali di latitude e longitude sono null il
   componente deve automaticamente usare la geolocalizzazione del browser per centrare la mappa e posizi

### `prompts/notifications-no-auth-wrap.md` — Anti-pattern: `@auth` + notifications


# Anti-pattern: `@auth` + notifications

**Sbagliato:**

```blade
@auth
    @livewire('notifications')
@endauth
```

**Corretto** (Filament 5 configuring-your-layout):

```blade
@livewire('notifications')
```

Perché: toast/session-expired devono montare sempre; `@auth` spegne il canale per ospiti e dopo logout mid-page.

In PTVX: layout UI/User (Cms assente). Nei sibling FO: `Cms/.../foot.blade.php`.

### `psr4-autoloading-error-analysis.md` — PSR-4 Autoloading Error Analysis and Resolution Plan


# PSR-4 Autoloading Error Analysis and Resolution Plan

**Date**: [DATE]
**Status**: Analysis Complete, Implementation Pending
**Related Errors**: `composer dumpautoload -o` PSR-4 compliance warnings

## 🚨 Error Analysis

### Error Messages Summary
```
Class Modules\UI\Tests\Unit\Widgets\MockCalendarWidget located in ./Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php does not comply with psr-4 autoloading standard (rule: Modules\UI\Tests\ => ./Modules/UI/tests). Skipping.
Class Modules\UI\Tests\Unit\Widgets\MockEventModel located in ./Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php does not comply with psr-4 autoloading standard (rule: Modules\UI\Tests\ => ./Modules/UI/tests). Skipping.
Class Modules\Notify\Filament\Forms\Components\ParentSelect located in ./Modules/UI/ap

### `psr4-fix-implementation-plan.md` — 🔧 PSR-4 Fix Implementation Plan - UI Module


# 🔧 PSR-4 Fix Implementation Plan - UI Module

**Modulo**: UI
**Tipo Fix**: Namespace correction (Modules\Notify → Modules\UI)

---

## 📊 Analisi Completa File Affetti

### File UI con Namespace Errato (11 totali)

Tutti in `Modules/UI/app/Filament/Forms/Components/`:

| # | File | Riga | Namespace Attuale (ERRATO) | Namespace Corretto |
|---|------|------|----------------------------|-------------------|
| 1 | `Children.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 2 | `IconPicker.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 3 | `InlineDatePicker.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 4 | `ParentSelect.php` | 10 | `Modul

### `psr4-namespace-violations.md` — 🚨 PSR-4 Namespace Violations - UI Module


# 🚨 PSR-4 Namespace Violations - UI Module

**Data Scoperta**: Dicembre 15, 2025
**Severity**: CRITICA
**Impact**: Autoload fallito, classi non caricabili
**Status**: 🔴 Da risolvere

---

## 📋 Problema Rilevato

Durante `composer dumpautoload -o`, rilevate **11 classi** nel modulo UI con **namespace errato**:

```
Class Modules\Notify\Filament\Forms\Components\ParentSelect
  located in ./Modules/UI/app/Filament/Forms/Components/ParentSelect.php
  does not comply with psr-4 autoloading standard
  (rule: Modules\UI\ => ./Modules/UI/app). Skipping.
```

### `public-resources-management-1.md` — Gestione delle Risorse Pubbliche


# Gestione delle Risorse Pubbliche

## Indice
- [Panoramica](#panoramica)
- [Struttura delle Cartelle](#struttura-delle-cartelle)
- [Tipi di Risorse](#tipi-di-risorse)
- [Best Practices](#best-practices)
- [Esempi di Utilizzo](#esempi-di-utilizzo)

## Panoramica

Questo documento descrive la corretta gestione delle risorse pubbliche (immagini, CSS, JavaScript, ecc.) , con particolare attenzione alla struttura delle cartelle e alle best practices da seguire.

## Struttura delle Cartelle

La struttura corretta per le risorse pubbliche  è la seguente:

```
/var/www/html/saluteora/
```


### `purpose.md` — UI: scopo del modulo


# UI: scopo del modulo

## Lo scopo in una frase **UI e' il vocabolario visivo condiviso: fa si' che la stessa cosa abbia lo stesso aspetto e lo stesso comportamento in tutti i moduli, senza che nessuno debba

## Confini

Verificare sul codice: dipendenze verso Xot/User/Ptv/Sigma secondo la regola
«i verticali dipendono da base e framework, la base non dipende dai verticali».

## Riferimenti

- [Audit BMAD](./bmad/audit.md)
- [Piano di miglioramento](./bmad/piano-miglioramento.md)
- [ECC](./ecc/ui-ecc-audit.md)

### `qmd-setup.md` — QMD Setup per Module **UI**


# QMD Setup per Module **UI**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c ui
# Cerca solo in ./laravel/Modules/UI/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `quality-audit.md` — Audit di qualita — modulo UI


# Audit di qualita — modulo UI

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 689 |
| Righe di codice | 45971 |
| File di test `*Test.php` | 38 |
| Casi di test | 279 |
| Casi di test per file PHP | 0.40 |
| `@phpstan-ignore` nel codice | 0 |
| Rilievi PHPMD su `app/` | 67 |
| PHPInsights — Code | 92.9 % |
| PHPInsights — Complexity | 100.0 % |

### `quality-report-2.md` — Quality Report — UI


# Quality Report — UI

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh UI`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 105 |
| LOC app/ | 6143 |
| File test | 65 |
| LOC test | 5746 |
| Test/App LOC ratio | 93.5% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/UI/tests \
  --coverage-text --colors=never

### `quality-report.md` — UI Module - Quality Report


# UI Module - Quality Report

**Generated**: 2026-06-18  
**Status**: ✅ **PASSED - No Critical Issues**

---

## 1. PHPStan Analysis

### Configuration
- **Level**: max (10)
- **Files Analyzed**: 112+ PHP files

### Results
```
✅ [OK] No errors detected
```

### Errors Fixed (2026-06-18)

### `readme-en.md` — 🎨 UI — English presentation


# 🎨 UI — English presentation

[![Domain-UI](https://img.shields.io/badge/Domain-UI%20Kit-7B1FA2.svg)](#)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![FixCity Platform](https://img.shields.io/b

### `redundancy-audit.md` — UI redundancy audit 2026-05-21


# UI redundancy audit 2026-05-21

High-risk findings:
- Config files exist in both `Config/` and `config/`, including `config.php`, `laravel-localization.php`, and `laravellocalization.php`.
- Many UI components are byte-identical with `Modules/User`, including `button`, `modal`, `input`, `checkbox`, `badge`, `link`, `nav-link`, `text-link`, `placeholder`, and marketing/layout components.
- Block stats are duplicated under both `archived/` and `superseded/`.
- Docs have case-only duplicates such as `ARCHITECTURE.md` and `architecture.md`, plus duplicate index variants.

Risk:
- UI should be the shared owner. Duplicating primitives in User makes fixes diverge.
- `Config/` vs `c

### `redundancy-report.md` — Redundancy Report — Modulo UI


# Redundancy Report — Modulo UI

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🟠 AddressField — Duplicato con Geo

**File**: `app/Filament/Forms/Components/AddressField.php`

Esiste anche in:
- `Modules/Geo/app/Filament/Forms/Components/AddressField.php`
- `Modules/Geo/app/Filament/Fields/AddressField.php`

La versione UI estende `XotBaseField` (conforme), mentre le versioni Geo estendono `Section`. Hanno logiche differenti:
- **UI**: usa `Select` con relazioni `HasOne`/`MorphOne`, campo generico per indirizzi
- **Geo**: usa `AddressResource` o `TextInput` direttamente, specializzata per dati geografici

**Azione suggerita**: Geo è il modulo canonico per i componenti geografici. Se UI ha bisogno di un AddressField, dovrebbe importare e wrappare quello 

### `release-marketing-standard.md` — Release e README marketing — UI


# Release e README marketing — UI

## Scopo

Ogni modulo/tema deve essere pubblicabile, comprensibile e desiderabile: workflow release, changelog automatico e README vetrina.

## File canonici locali

- `../README.md`
- `../.github/workflows/semantic-release.yml`
- `../.releaserc.json`
- `../CHANGELOG.md`

## Confidenza

La configurazione usa semantic-release con Conventional Commits, changelog, GitHub release e commit automatico del changelog.

### `risoluzione-conflitti-tablelayouttrait.md` — Risoluzione Conflitti in TableLayoutTrait


# Risoluzione Conflitti in TableLayoutTrait

## Stato attuale

Nel modulo ci sono **due** trait con lo stesso nome corto:

| Trait | Sessione | Default | Chi lo usa |
|---|---|---|---|
| `Modules\UI\Filament\Actions\Table\TableLayoutTrait` | `table_layout_{id}` | LIST | `HasTableLayoutPage` (e quindi `HasXotTable`), `TableLayoutToggleTableAction`, e i test `UiGapCloser100Test` / `UiHighestMissCoverageTest` |
| `Modules\UI\Traits\TableLayoutTrait` (ritirato) | `table_layout` | GRID | nessuno: parcheggiato in `docs/parcheggio/app/Traits/TableLayoutTrait.php.zero_used` |

Il secondo era la versione legacy per i componenti Livewire (aveva anche `refreshTable()` e `resetTable()`) ed e' stato ritirato il 2026-11-24. PHPStan lo segnalava `trait.unused` e aveva ragione: non era un falso positivo.

### `roadmap/00-overview.md` — Roadmap overview (Module UI)


# Roadmap overview (Module UI)

## Scope

## Goals

## Non-goals

### `roadmap/01-now.md` — Now (Module UI)


# Now (Module UI)

## Stabilization

## Bugfixes

## Quality gates

### `roadmap/02-next.md` — Next (Module UI)


# Next (Module UI)

## Features

## Refactors

### `roadmap/03-later.md` — Later (Module UI)


# Later (Module UI)

## Longer-term ideas

### `roadmap/04-risks.md` — Risks and dependencies (Module UI)


# Risks and dependencies (Module UI)

## Risks

## Dependencies

### `roadmap/05-risks.md` — Risks - UI


# Risks - UI

## Top Risks

1. Drift tra documentazione e comportamento runtime.
2. Regressioni introdotte da fix rapidi non verificati.
3. Dipendenze incrociate non documentate.

## Mitigations

1. Aggiornare docs insieme ai fix di codice.
2. Usare checklist pre-merge e post-fix.
3. Mantenere un set di file canonici per diagnosi rapida.

### `roadmap/archive/component-system.md` — Sistema Componenti UI


# Sistema Componenti UI

## 📊 Stato Implementazione
Completamento: 35%

## 🎯 Obiettivi
1. Creare un sistema di componenti tipizzato e riutilizzabile
2. Garantire consistenza visiva e comportamentale
3. Migliorare la developer experience
4. Ottimizzare le performance di rendering

## 🤔 Sfide di Design

### 1. Tipizzazione Componenti
- Necessità di mantenere type safety tra props e rendering
- Gestione stati complessi nei componenti dinamici
- Validazione props a runtime

### 2. Theming System

### `roadmap/archive/form-component.md` — Form Component


# Form Component

## 📊 Stato Implementazione
Completamento: 45%

## 🎯 Obiettivi
1. Creare un form builder tipizzato e flessibile
2. Integrare validazione lato client e server
3. Supportare form dinamici e nested
4. Ottimizzare la UX con feedback immediato

## 🤔 Sfide di Design

### 1. Type Safety
- Validazione input tipizzata
- Gestione form nidificati
- Type inference per campi dinamici

### 2. Validazione

### `roadmap/archive/theme-system.md` — Sistema di Theming


# Sistema di Theming

## 📊 Stato Implementazione
Completamento: 40%

## 🎯 Obiettivi
1. Sistema di theming flessibile e tipizzato
2. Supporto per temi multi-tenant
3. Dark/Light mode automatico
4. Customizzazione component-level

## 🤔 Sfide di Design

### 1. Theme Configuration
- Gestione gerarchica dei temi
- Override per tenant specifici
- Tipizzazione configurazioni

### 2. Runtime Theming

### `roadmap/current-state.md` — Current State - UI


# Current State - UI

## Baseline

- Stato attuale documentato nei file `docs/` del Modulo.
- Presenza di roadmap strutturata in sotto-file.
- Necessita verifica periodica di coerenza tra codice e documentazione.

## Immediate checks

1. Coerenza tra regole architetturali e implementazione runtime.
2. Coerenza tra naming, namespace e percorsi view/traduzioni.
3. Copertura test minima per i flussi critici.

### `roadmap/goals.md` — Goals - UI


# Goals - UI

## Short Term

1. Allineare documentazione e stato reale del codice.
2. Ridurre i punti di fragilita piu frequenti.
3. Consolidare checklist operative per incident response.

## Medium Term

1. Aumentare test di regressione sui flussi critici.
2. Migliorare osservabilita e diagnosi errori.
3. Ridurre duplicazioni tra documenti e tra componenti.

## Long Term

1. Stabilita sotto fault randomizzati (chaos testing).
2. Manutenibilita alta con onboarding rapido.

### `roadmap/later.md` — Later (Module UI)


# Later (Module UI)

## Longer-term ideas

### `roadmap/milestones.md` — Milestones - UI


# Milestones - UI

## M1 Documentation Baseline

- `roadmap.md` allineato e `docs/roadmap/` completo.
- Link relativi verificati.

## M2 Operational Readiness

- Checklist incident response disponibile.
- Procedure di recovery validate sui casi principali.

## M3 Regression Safety

- Test minimi sui flussi critici in esecuzione regolare.
- Riduzione regressioni ricorrenti.

### `roadmap/next.md` — Next (Module UI)


# Next (Module UI)

## Features

## Refactors

### `roadmap/now.md` — Now (Module UI)


# Now (Module UI)

## Stabilization

## Bugfixes

## Quality gates

### `roadmap/overview.md` — Roadmap overview (Module UI)


# Roadmap overview (Module UI)

## Scope

## Goals

## Non-goals

### `roadmap/phases.md` — Fasi di sviluppo - UI Module


# Fasi di sviluppo - UI Module

## Fase 1: Modernization (In Progress)

- [x] PHPStan Level 10 Compliance
- [ ] Completamento migrazione a Tailwind CSS v4
- [ ] Implementazione di Flux UI per i componenti interattivi di base
- [ ] Rimozione definitiva dei 280+ file obsoleti

## Fase 2: Component Studio (Planned)

- [ ] Creazione di una Gallery live per testare i componenti UI isolati
- [ ] Sistema di Design Tokens centralizzato esportabile in vari formati
- [ ] Nuovi componenti avanzati per Data Visualization (integrazione Chart)

## Fase 3: AI Design (Future)

- [ ] AI Theme Generator: generazione automatica di palette colori accessibili da immagine di brand
- [ ] Dynamic Layout Optimization: AI suggerisce layout migliori in base al tipo di contenuto

### `roadmap/q4-roadmap.md` — UI Module Roadmap (2025 Q4)


# UI Module Roadmap (2025 Q4)

## Vision & Scope
- Provide reusable UI components and Filament integrations aligned with Laraxot rules and design system.

## Key Outcomes
- PHPStan 0 errors in `Modules/UI/`
- Filament v4 migration complete (forms, tables, widgets)
- Theme integration clear: assets, Blade components, translations

## Milestones
- [ ] Audit Filament v4 changes in components/pages
- [ ] Replace labels with translations (expanded structure)
- [ ] Optimize icons/assets; document in `docs/paths_and_assets.md`
- [ ] Strengthen tests for critical widgets

## Acceptance Criteria
- No direct Filament base class extensions
- `getFormSchema()` used consistently

### `roadmap/quality.md` — Checklist qualità - UI Module


# Checklist qualità - UI Module

- [x] PHPStan Level 10
- [ ] Accessibilità WCAG 2.1 (AA) verificata su tutti i componenti core
- [ ] Performance Lighthouse > 90 su pagine UI intensive

### `roadmap/risks.md` — Risks and dependencies (Module UI)


# Risks and dependencies (Module UI)

## Risks

## Dependencies

### `roadmap/roadmap.md` — UI Module Roadmap (2025 Q4)


# UI Module Roadmap (2025 Q4)

## Vision & Scope
- Provide reusable UI components and Filament integrations aligned with Laraxot rules and design system.

## Key Outcomes
- PHPStan 0 errors in `Modules/UI/`
- Filament v4 migration complete (forms, tables, widgets)
- Theme integration clear: assets, Blade components, translations

## Milestones
- [ ] Audit Filament v4 changes in components/pages
- [ ] Replace labels with translations (expanded structure)
- [ ] Optimize icons/assets; document in `docs/paths_and_assets.md`
- [ ] Strengthen tests for critical widgets

## Acceptance Criteria
- No direct Filament base class extensions
- `getFormSchema()` used consistently

### `roadmap/vision.md` — Visione - UI Module


# Visione - UI Module

Creare un ecosistema UI Headless-first:

- Cambio radicale look-and-feel per tenant tramite configurazioni JSON
- Tailwind CSS v4 e animazioni native del browser
- Componenti interattivi con Flux UI

### `roadmap/workstreams.md` — Workstreams - UI


# Workstreams - UI

## WS1 Architecture

- Verifica confini e responsabilita dei componenti.
- Aggiornamento pattern e guardrail.

## WS2 Reliability

- Hardening dei flussi principali.
- Miglioramento fallback e recovery path.

## WS3 Documentation

- Consolidamento documenti canonici.
- Eliminazione drift documentale.

## WS4 Testing


### `roadmap-and-issues.md` — UI Module - Roadmap, Issues & Optimization


# UI Module - Roadmap, Issues & Optimization

**Modulo**: UI (User Interface Components)
**Data Analisi**: 1 Ottobre 2025
**Maintainer**: Laraxot Core Team
**Status PHPStan**: ✅ 0 errori (level 10)

---

## 📊 STATO ATTUALE

### Completezza Funzionale: 95%

| Area | Completezza | Note |
|------|-------------|------|
| Blade Components | 100% | 50+ componenti |
| Filament Widgets | 100% | Dashboard widgets |
| Form Components | 95% | Custom inputs |
| Layouts | 100% | Multiple layouts |

### `roadmap-archive.md` — 🎨 UI MODULE - ROADMAP 2025


# 🎨 UI MODULE - ROADMAP 2025

**Modulo**: UI (User Interface Components & Design System)  
**Status**: 85% COMPLETATO  
**Priority**: HIGH  
**PHPStan**: ✅ level 10 (0 errori)  
**Filament**: ✅ 4.x Compatibile  

---

## 🎯 MODULE OVERVIEW

Il modulo **UI** è il sistema di componenti e design system della piattaforma FixCity, fornendo una libreria completa di componenti riutilizzabili, conformi alle linee guida AGID e compatibili con Filament 4.x.

### 🏗️ Architettura Modulo
```
UI Module
├── 🎨 Design System (Core)
│   ├── AGID Components

### `roadmap-conflict.md` — 🎨 UI MODULE - ROADMAP 2025


# 🎨 UI MODULE - ROADMAP 2025

**Modulo**: UI (User Interface Components & Design System)
**Status**: 85% COMPLETATO
**Priority**: HIGH
**PHPStan**: ✅ level 10 (0 errori)
**Filament**: ✅ 4.x Compatibile

---

## 🎯 MODULE OVERVIEW

Il modulo **UI** è il sistema di componenti e design system della piattaforma FixCity, fornendo una libreria completa di componenti riutilizzabili, conformi alle linee guida AGID e compatibili con Filament 4.x.

### 🏗️ Architettura Modulo
```
UI Module
├── 🎨 Design System (Core)
│   ├── AGID Components

### `roadmap-miglioramenti.md` — UI — cosa migliorerei se questo modulo fosse mio per un mese


# UI — cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **67**,
> Code 91.8, Arch 92.9, 290 casi test. Questo file non rimisura: legge quei
> numeri e ci mette sopra la lente.

107 file in `app/`, due dipendenze runtime (icone: FontAwesome, Heroicons),
`require-dev` completamente vuoto e **nessun `phpstan.neon` proprio**. UI è
il modulo "solo presentazione" per definizione architetturale del progetto
(vedi la memoria "componente nel modulo del suo dominio" — se un componente
UI serve solo un dominio specifico, non appartiene qui). Eppure ha 8
`dd()`/`dddx()` e 4 `@phpstan-ignore` per 107 file: una densità di debito
per-file più alta di

### `roadmap.md` — UI Module - Complete Roadmap 2026


# UI Module - Complete Roadmap 2026

**Generated**: 2026-01-02
**Status**: Component Library & Design System
**Methodology**: Super Mucca (DRY + KISS + Deep Understanding)
**PHPStan Level**: 10 ✅ (0 errors)

---

## 🎯 **MODULE IDENTITY**

### **Domain**: Component Library & Design System
### **Purpose**: Unified UI/UX layer for all modules through Filament extensions
### **Philosophy**: "Extend without replacing, reuse without duplicating"

**Core Mission**: Provide a comprehensive, reusable component library that extends Filament v4 capabilities while maintaining consistency, accessibility, and developer happiness across all 17 modules.

---


### `root-file-policy.md` — Root file policy


# Root file policy

Updated: 2026-07-08

Root hygiene for this owner follows the project rule: no root .txt files, at most four root .md files, and at most one root .code-workspace named after the module or theme.

Archived root files live in:

- docs/root-txt-files/ (0 files)
- docs/root-md-files/ (28 files)
- docs/root-code-workspace-files/ (1 files)

Current root counts after normalization: 2 markdown files, 0 workspace files.

### `root-files-hygiene.md` — Root files hygiene


# Root files hygiene

## 2026-07-08 16:51

- created `UI.code-workspace` as the single canonical root workspace file.

### `schema.md` — UI Module Schema


# UI Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** UI
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/UI/`
- **Docs:** `laravel/Modules/UI/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable — AI reads but never modifies or deletes
- ✅ Drop liberally — articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules

### `scopo.md` — UI — scopo, confini e come servirlo meglio


# UI — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

UI non ha modelli di dominio, non ha migrazioni proprie che il resto del progetto
consumi, non ha un utente finale. Ha componenti: 16 classi in
`app/Filament/Forms/Components/` (15 nella root più `Field/QrReader`), 11 in
`app/Filament/Tables/Columns/`, 11 in `app/View/Components/`, 243 file Blade in
`resources/views/components/`. È l'unico
modulo del monorepo la cui ragione d'essere è **essere importato**.

Tre fatti misurati il 2026-09-02 lo dimostrano:

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| Dipendenze uscenti: 73 file verso `Modules\Xot`, **1** verso `Modules\User` | `grep -rl 'Modules\\<M>\\' Modules/UI/app` | la regola di dipendenza dichiarata nel README regge: UI guarda solo la piat

### `selectstatecolumn-confirmation-modal.md` — SelectStateColumn - Aggiunta Modal di Conferma


# SelectStateColumn - Aggiunta Modal di Conferma

## Panoramica
Questo documento descrive l'implementazione di una modale di conferma con textarea per il componente `SelectStateColumn`. La modale richiederà all'utente di confermare la transizione di stato e fornire un messaggio opzionale.

## Requisiti
- Aggiungere una modale di conferma prima della transizione di stato
- Includere una textarea per inserire un messaggio
- Passare il messaggio al metodo `transitionTo`
- Mantenere la compatibilità con il funzionamento esistente

## Specifiche Tecniche

### Flusso Utente
1. L'utente seleziona un nuovo stato dal menu a discesa
2. Viene visualizzata una modale di conferma con una textarea
3. L'utente può inserire un messaggio opzionale
4. Alla conferma, viene eseguita la transizione con il mes

### `spatie-media-library-migration-1.md` — Migrazione da FileUpload a Spatie Media Library


# Migrazione da FileUpload a Spatie Media Library

## 🌍 Analisi Multidimensionale della Migrazione

### **Filosofia & Spiritualità**
- **Evoluzione Paradigmatica**: Passaggio da gestione **atomistica** (FileUpload singoli) a gestione **sistemica** (Media Library ecosystem)
- **Humilitas Technologica**: Riconoscere la superiorità di soluzioni specializzate mature
- **Zen del Non-Agire**: Wu wei - non combattere contro l'ecosistema, fluire con esso

### **Economia & Sostenibilità**
- **ROI Esponenziale**: Riduzione drammatica dei costi di manutenzione
- **Debito Tecnico**: Eliminazione di custom implementations fragili
- **Economia Circolare**: Riuso di componenti testati e ottimizzati
- **Efficienza Energetica**: Codice più performante = minor consumo server

### **Biologia & Chimica del C

### `standards/auth-form-standards.md` — Standard Form di Autenticazione


# Standard Form di Autenticazione

## Principi di Design

### Layout
- I form di autenticazione devono essere centrati sia orizzontalmente che verticalmente
- Utilizzare una larghezza massima appropriata per garantire leggibilità
- Mantenere una gerarchia visiva chiara con spaziatura consistente

### Container
```html
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Logo o intestazione -->
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <!-- Form -->

### `standards/form-standards.md` — Standard Form nei Temi


# Standard Form nei Temi

## Principi Generali

### Layout e Allineamento
- I form devono essere centrati nella pagina con margini appropriati
- Utilizzare una larghezza massima per garantire leggibilità
- Mantenere una spaziatura consistente tra gli elementi

```html
<div class="container mx-auto max-w-4xl px-4 py-8">
  <form class="w-full space-y-6">
    <!-- Contenuto del form -->
  </form>
</div>
```

### Grid System
- Utilizzare il grid system di Tailwind per layout responsivi

### `stories/0002-ui-phpstan-fix-2.story.md` — Story: UI PHPStan fix

# Story: UI PHPStan fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0003-retire-ui-http-livewire.story.md` — 12.1 Ritiro HTTP UI

# 12.1 Ritiro HTTP UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0004-1-drift-sync-tier1.story.md` — Drift Sync Tier 1 — laraxot/dev fetch e merge moduli critica

# Drift Sync Tier 1 — laraxot/dev fetch e merge moduli critica

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0005-ui-merge-conflict-resolution.story.md` — 19.UI: risoluzione dei marker del merge HEAD vs laraxot/dev

# 19.UI: risoluzione dei marker del merge HEAD vs laraxot/dev

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0006-ui-merge-conflict-resolution-2.story.md` — 19.UI: risoluzione dei marker del merge HEAD vs laraxot/dev

# 19.UI: risoluzione dei marker del merge HEAD vs laraxot/dev

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0007-ui-sync-marker-repair.story.md` — 20.UI: marker del sync `laraxot/dev` nei nove file PHP di `app/`

# 20.UI: marker del sync `laraxot/dev` nei nove file PHP di `app/`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0008-merge-markers-regressione-c89696dc.story.md` — 5.12: Regressione dei marker di conflitto nel modulo UI

# 5.12: Regressione dei marker di conflitto nel modulo UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0009-merge-conflict-markers-cleanup.story.md` — 5.8: Rimuovere i marker di conflitto git committati nel modulo UI

# 5.8: Rimuovere i marker di conflitto git committati nel modulo UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0013-phpstan-concurrent-tail-contracts.story.md` — Story UI-7.12: contratti tail dopo remediation concorrente

# Story UI-7.12: contratti tail dopo remediation concorrente

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0014-mixed-type-reduction.story.md` — Story UI-7.13: riduzione uso di mixed dove il tipo e' noto

# Story UI-7.13: riduzione uso di mixed dove il tipo e' noto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0015-phpstan-locationselector-geo-boundary-cleanup.story.md` — Story UI-7.14: fix phpstan report (40 errori, 3 file)

# Story UI-7.14: fix phpstan report (40 errori, 3 file)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0016-interactivemap-geo-boundary-violation.story.md` — 7.15 — `InteractiveMap.php`: stessa violazione di confine di `LocationSelector.php`

# 7.15 — `InteractiveMap.php`: stessa violazione di confine di `LocationSelector.php`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0018-phpstan-shared-fixture-contracts.story.md` — Story UI-7.3: contratti fixture condivise coverage

# Story UI-7.3: contratti fixture condivise coverage

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0025-audit-qualita.story.md` — Audit qualita' — modulo UI

# Audit qualita' — modulo UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0028-continuation-3.story.md` — UI Module — Continuation Task

# UI Module — Continuation Task

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0029-cookiebar-visual-audit.story.md` — Cookiebar Visual Audit

# Cookiebar Visual Audit

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0030-docs-index-audit.story.md` — Audit indice documentazione modulo UI

# Audit indice documentazione modulo UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0031-id-timestamp-columns-extraction.story.md` — Story: SortableIdColumn / TimestampColumn

# Story: SortableIdColumn / TimestampColumn

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0032-person-column-schema-org-aggregate.story.md` — Story: PersonColumn — aggregato riutilizzabile anagrafica + contatto

# Story: PersonColumn — aggregato riutilizzabile anagrafica + contatto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0033-person-column-schema-org-identity-group.story.md` — STORY — PersonColumn

# STORY — PersonColumn

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0034-phpstan-cleanup-ui.story.md` — [STORY] PHPStan cleanup — UI

# [STORY] PHPStan cleanup — UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0035-phpstan-ui-setlocale-duplicate-guard.story.md` — PHPStan UI: guardia duplicata in SetLocale

# PHPStan UI: guardia duplicata in SetLocale

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0036-placeholder-translations-cleanup.story.md` — Via le traduzioni segnaposto dai file di lingua

# Via le traduzioni segnaposto dai file di lingua

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0037-quality-gate-ui.story.md` — Quality gate closure — Modules/UI

# Quality gate closure — Modules/UI

## Context and Problem Statement

PHPStan on `Modules/UI` was already verified at 0 errors earlier the same day (documented
in `docs/coverage.md`'s "Mixed type reduction" entry). Scope for this pass: phpmd, pest,
coverage, git — with a phpstan baseline re-check.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome


### `stories/0038-services-to-actions-ui.story.md` — Services -> Actions nel modulo UI

# Services -> Actions nel modulo UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0039-ui-module-bmad-setup.story.md` — UI Module BMAD Setup

# UI Module BMAD Setup

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0040-ui-readme-architecture-conflict-cleanup.story.md` — Risolve conflitti README + consolida docs/architecture case-dupes

# Risolve conflitti README + consolida docs/architecture case-dupes

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0041-ui-root-md-file-limit-audit.story.md` — Audit igiene root — limite 6 file .md in Modules/UI

# Audit igiene root — limite 6 file .md in Modules/UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0042-ui-services-to-actions.story.md` — Convert app/Services to QueueableAction (no-services-rule)

# Convert app/Services to QueueableAction (no-services-rule)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/phpstan-cleanup-ui.dev.md` — [DEV] PHPStan cleanup — UI

# [DEV] PHPStan cleanup — UI

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

### `strategy.md` — Product Strategy: UI Module


# Product Strategy: UI Module

## 🌍 Market Context
PA users require clear, unambiguous interfaces that work well on varying hardware.

## 💎 Unique Value Proposition
"UI" isn't just a theme; it's a governed design system that ensures every Laraxot module looks and feels like it belongs to the same family.

## 🏛️ Strategic Pillars
1. **Utility-First:** Leverage Tailwind CSS for rapid, consistent styling.
2. **Component Governance:** New components must be reviewed for accessibility.
3. **Seamless Integration:** Native support for Filament's layout system.

## 🗺️ Strategic Roadmap (1-2 Years)
Development of a standalone UI Component Explorer (similar to Storybook) for the Laraxot ecosystem.

### `studio-card-selector-implementation-1.md` — StudioCardSelector Component - Modulo UI


# StudioCardSelector Component - Modulo UI

## 🎯 **Panoramica**
Componente Filament Form altamente riutilizzabile per la selezione di studi medici/odontoiatrici attraverso un'interfaccia card visuale moderna e responsive.

## 🏗️ **Architettura Component**

### Classe PHP
```php
// Modules/UI/app/Forms/Components/StudioCardSelector.php
<?php

declare(strict_types=1);

namespace Modules\UI\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Collection;
use Closure;

### `svg-icons-automatic-registration.md` — ✅ SVG Icons - Automatic Registration


# ✅ SVG Icons - Automatic Registration

**Data**: 2026-03-30  
**Stato**: ✅ **CORRETTO**

## 🎯 Concetto Chiave

**Gli SVG vengono registrati AUTOMATICAMENTE da Laravel!**

Non serve:
- ❌ Service Provider personalizzati
- ❌ Registrazione manuale con FilamentAsset
- ❌ Blade::anonymousComponentPath()

Basta:
- ✅ Mettere i file SVG in `resources/svg/`
- ✅ Usare `<x-svg name="folder.icon-name" />`

## 📁 Directory Structure

### `svg-icons-complete.md` — ✅ SVG Icons - Automatic Registration COMPLETE


# ✅ SVG Icons - Automatic Registration COMPLETE

**Data**: 2026-03-30  
**Stato**: ✅ **COMPLETATO**

## 🎯 Concetto Chiave

**Gli SVG vengono registrati AUTOMATICAMENTE da Filament!**

## 📁 SVG Files Created (6)

**Path**: `laravel/Modules/UI/resources/svg/brands/`

| File | Icon Name | Usage |
|------|-----------|-------|
| `facebook.svg` | `ui-brands.facebook` | `<x-filament::icon icon="ui-brands.facebook" />` |
| `twitter.svg` | `ui-brands.twitter` | `<x-filament::icon icon="ui-brands.twitter" />` |
| `youtube.svg` | `ui-brands.youtube` | `<x-filament::icon icon="ui-brands.youtube" />` |
| `telegram.svg` | `ui-brands.telegram` | `<x-filament::icon icon="ui-brands.telegram" />` |

### `table-components-1.md` — Componenti Table


# Componenti Table

## Introduzione
I componenti table forniscono una gestione efficiente e personalizzabile dei dati tabulari, con funzionalità avanzate di ordinamento, filtro e paginazione.

## Componenti Disponibili

### DataTable
```blade
<x-ui::datatable
    :columns="[
        ['name' => 'id', 'label' => 'ID', 'sortable' => true],
        ['name' => 'name', 'label' => 'Nome', 'sortable' => true],
        ['name' => 'email', 'label' => 'Email', 'sortable' => true],
        ['name' => 'created_at', 'label' => 'Data Creazione', 'sortable' => true],
    ]"
    :data="$users"
    :per-page="10"
    :searchable="true"

### `task-consolidare-documentazione.md` — Task: Consolidare Documentazione - UI


# Task: Consolidare Documentazione - UI

**Modulo**: UI
**Priorita'**: Bassa
**Completamento**: 15%

---

## Criteri di Completamento

- [ ] Rimossi file duplicati da 272 docs
- [ ] Naming conventions rispettate
- [ ] README.md con indice aggiornato

### `task-location-selector.md` — Task: Migliorare LocationSelector Type Safety - UI


# Task: Migliorare LocationSelector Type Safety - UI

**Modulo**: UI
**Priorita'**: Media
**Completamento**: 30%

---

## Descrizione

LocationSelector e InteractiveMap hanno 24 suppressioni combinate. Questi componenti gestiscono dati geografici con tipi mixed.

## Azioni

- [ ] Definire LocationData DTO per coordinate
- [ ] Tipizzare parametri lat/lng come float
- [ ] Usare Geo module DTOs per consistenza
- [ ] Rifattorizzare InteractiveMap con tipi espliciti


### `task-ridurre-phpstan-suppressioni.md` — Task: Ridurre Suppressioni PHPStan Inline - UI


# Task: Ridurre Suppressioni PHPStan Inline - UI

**Modulo**: UI
**Priorita'**: Alta
**Completamento**: 0%

---

## File Coinvolti (28 suppressioni)

| File | Suppressioni |
|------|-------------|
| `app/Filament/Forms/Components/LocationSelector.php.to_geo` | 10 |
| `app/Livewire/Components/Map/InteractiveMap.php` | 9 |
| `app/Filament/Forms/Components/LocationSelector.php` | 5 |
| `app/Filament/Forms/Components/InlineDatePicker.php` | 3 |
| `app/Rules/OpeningHoursRule.php` | 1 |

## Criteri di Completamento

### `task-test-livewire-components.md` — Task: Test Componenti Livewire - UI


# Task: Test Componenti Livewire - UI

**Modulo**: UI
**Priorita'**: Media
**Completamento**: 20%

---

## Descrizione

21 file test per 100 file PHP. I componenti Livewire (mappe, form) necessitano test dedicati.

## Criteri di Completamento

- [ ] Test per InteractiveMap (render, marker, zoom)
- [ ] Test per InlineDatePicker (date selection, validation)
- [ ] Test per OpeningHoursRule (valid/invalid hours)
- [ ] 10+ nuovi test

### `tasks/cleanup-redundant-files.md` — Task: Cleanup Redundant Files (UI Module)


# Task: Cleanup Redundant Files (UI Module)

## 📋 Obiettivo
Ripulire il modulo UI da file di backup, duplicati e file temporanei che creano rumore e potenziali conflitti.

## 🚨 Problemi Identificati
- File con estensione `.bak`, `.old`, `.disabled`, `.to_geo`.
- File che differiscono solo per il case (es. `TimeclockWidget.php` vs `TimeClockWidget.php`).
- Documentazione duplicata o obsoleta in `docs/archived/`.

## ✅ Checklist
- [ ] Identificare tutti i file `.bak`, `.old`, `.disabled`, `.to_geo` nel modulo UI.
- [ ] Verificare se il contenuto di questi file è già presente nelle versioni attive.
- [ ] Rimuovere i file ridondanti.
- [ ] Identificare conflitti di naming case-sensitive tramite script.
- [ ] Risolvere i conflitti mantenendo le versioni conformi a PascalCase.
- [ ] Verificare 

### `tasks/design-system-components.md` — Task 001: Implement Design System and Reusable Components


# Task 001: Implement Design System and Reusable Components

## Description
Create comprehensive design system with reusable UI components, design tokens, theme support, and accessibility features.

## Context
The UI module needs a robust design system with consistent components, theming capabilities, and accessibility support for building cohesive user interfaces.

## Requirements

### Functional Requirements
- Component library (buttons, forms, cards, modals, etc.)
- Design tokens (colors, typography, spacing, shadows)
- Theme system (light/dark, custom themes)
- Responsive components
- Accessibility (WCAG 2.1 AA)
- Icon system
- Animation utilities
- Form validation components

### `tasks/filament-v5-alignment.md` — Task: Filament v5 Alignment (UI Module)


# Task: Filament v5 Alignment (UI Module)

## 📋 Obiettivo
Verificare e aggiornare tutti i componenti custom del modulo UI per garantire la piena compatibilità e sfruttare le nuove funzionalità di Filament v5.

## 🚨 Azioni Richieste
- Verificare i cambiamenti nelle classi base di Filament (Forms, Tables, Widgets).
- Aggiornare i componenti che usano metodi deprecati o rimossi in v5.
- Sfruttare le nuove API di v5 (es. nuove modalità di rendering, miglioramenti nelle azioni).
- Verificare il sistema di temi e asset con il nuovo sistema di build di v5.

## ✅ Checklist
- [ ] Audit dei 56 componenti Filament vs v5 docs.
    - [ ] Columns
    - [ ] Form Components
    - [ ] Widgets
    - [ ] Actions
- [ ] Aggiornamento di `TableLayoutEnum` per integrazione ottimale con v5.
- [ ] Verifica compat

### `tasks/increase-test-coverage.md` — Task: Incremento Test Coverage (Pest) - UI


# Task: Incremento Test Coverage (Pest) - UI

**Modulo**: UI  
**Fase**: 3 - Testing & Docs  
**Priorità**: Alta

## Obiettivo

Aumentare la copertura test sui componenti UI con Pest: suite di test per ogni componente core.

## Sottotask

- [ ] Creazione suite test Pest per componenti core (Tables, Forms, Widgets)
- [ ] Test IconStateColumn, GroupColumn, TreeColumn
- [ ] Test form components (InlineDatePicker, RadioBadge, ecc.)
- [ ] Test widget (StatsOverviewWidget, UserCalendarWidget)
- [ ] Obiettivo copertura > 80%
- [ ] Documentazione


### `tasks/refactor-complex-components.md` — Task: Refactoring Componenti Complessi - UI


# Task: Refactoring Componenti Complessi - UI

**Modulo**: UI  
**Fase**: 2 - Filament v5 & Refactoring  
**Priorità**: Media

## Obiettivo

Refactoring di componenti che superano 100/200 righe (es. OpeningHoursField): scomporre in sub-componenti rispettando KISS.

## Sottotask

- [ ] Refactoring OpeningHoursField in sub-componenti
- [ ] Identificare altri componenti da scomporre
- [ ] Mantenere API pubblica invariata dove possibile
- [ ] Test regressione
- [ ] Documentazione

## Dipendenze

### `tasks/tasks-index.md` — Indice task - Modulo UI


# Indice task - Modulo UI

Lista dei task del modulo con link ai file .md separati. Ogni task è un file nella cartella `tasks/`. Dettagli dalla [roadmap](../roadmap.md).

## Fase 1: Qualità e Pulizia

| Task | File | Priorità |
|------|------|----------|
| Pulizia files backup e duplicati | [cleanup-redundant-files.md](cleanup-redundant-files.md) | Alta |

## Fase 2: Filament v5 & Refactoring

| Task | File | Priorità |
|------|------|----------|
| Allineamento Filament v5 | [filament-v5-alignment.md](filament-v5-alignment.md) | Alta |
| Refactoring componenti complessi | [refactor-complex-components.md](refactor-complex-components.md) | Media |

## Fase 3: Testing & Docs


### `tasks/ui-cleanup-docs.md` — Task: UI Docs Cleanup


# Task: UI Docs Cleanup

## 📋 Obiettivo
Riorganizzare la mastodontica cartella docs del modulo UI (280+ file) per renderla utile agli sviluppatori.

## 🚨 Problemi Identificati
- File duplicati con nomi simili (`algolia-docsearch-1.md` vs `algolia-docsearch.md`).
- Guide obsolete per Filament v3 mescolate con v4/v5.
- File di log della ridenominazione e archivi non strutturati.

## ✅ Checklist
- [ ] Rimozione sistematica dei file duplicati (mantenendo la versione più recente).
- [ ] Separazione chiara tra documentazione `Blade` e `Filament`.
- [ ] Consolidamento delle guide sull'architettura dei componenti.
- [ ] Eliminazione di file frammentari come `altro.md` (11 byte) o `chunk.txt`.

## 🔗 Riferimenti
- [Index Documentazione](../00-index.md)

### `tasks/ui-filament-v5.md` — Task: UI Filament v5 \u0026 Tailwind v4 Alignment


# Task: UI Filament v5 \u0026 Tailwind v4 Alignment

## 📋 Obiettivo
Aggiornare il pacchetto UI per sfruttare appieno le potenzialità di Filament v5 e la nuova engine di Tailwind CSS v4.

## ✅ Checklist
- [ ] Verifica compatibilità di tutti i componenti custom `XotBaseColumn` con Filament v5.
- [ ] Migrazione dei file CSS globali alla sintassi Tailwind v4.
- [ ] Refactoring dei componenti che usano `@apply` obsoleti.
- [ ] Implementazione dei nuovi **Theme Clusters** per la gestione separata dei temi Frontend e Admin.

## 🔗 Riferimenti
- [Roadmap UI](../roadmap.md)

### `tech-spec-2.md` — Technical Specification - UI Module

# Technical Specification - UI Module

## Overview
Technical implementation details for the UI module.

## Core Components
- Models in app/Models/
- Actions in app/Actions/
- Filament resources in app/Filament/
- Providers in app/Providers/

## Quality Gates
- PHPStan Level 10: 0 errors
- Pint: PSR-12 compliant
- Pest: 90%+ test coverage
- PHPMD: 0 violations

## Dependencies
- Laravel 12.x
- Laravel 13.x

### `tech-spec.md` — Technical Specification - UI Module

# Technical Specification - UI Module

## Overview
Technical implementation details for the UI module.

## Core Components
- Models in app/Models/
- Actions in app/Actions/
- Filament resources in app/Filament/
- Providers in app/Providers/

## Quality Gates
- PHPStan Level 10: 0 errors
- Pint: PSR-12 compliant
- Pest: 90%+ test coverage
- PHPMD: 0 violations

## Dependencies
- Laravel 13.x
- Filament 5.x

### `test-conflicts-resolution.md` — Test di Risoluzione Conflitti nel Modulo UI


# Test di Risoluzione Conflitti nel Modulo UI

## Descrizione

Questo documento descrive i test automatici creati per verificare la corretta risoluzione dei conflitti git nei file del modulo UI.

## Test Implementati

### TableLayoutToggleTest

Il test `TableLayoutToggleTest` verifica che il componente `TableLayoutToggleTableAction` sia stato correttamente risolto e funzioni come previsto:

- `test_table_layout_toggle_action_exists()`: Verifica che la classe e l'interfaccia `HasTableLayout` esistano.
- `test_table_layout_toggle_action_make()`: Verifica che il metodo `make()` costruisca correttamente l'istanza.

### AddressFieldTest

Il test `AddressFieldTest` verifica che il componente `AddressField` sia stato correttamente risolto e funzioni come previsto:


### `test-fix-philosophy.md` — Test Fix Philosophy: Fix Tests, Not Production Code


# Test Fix Philosophy: Fix Tests, Not Production Code

**Date**: [DATE]
**Context**: Understanding the correct approach to fixing test failures

## 🎯 Core Principle

> **If tests fail because they reference non-existent elements, FIX THE TESTS, NOT CREATE THE ELEMENTS.**

## 📋 Rules for Test Fixing

### Rule 1: Tests Reference Reality
- Tests should reflect ACTUAL production code
- If test references `BaseCalendarWidget` that doesn't exist → FIX TEST
- Do NOT create `BaseCalendarWidget` just to make tests pass
- Tests must validate REAL functionality, not imaginary constructs

### Rule 2: Test Quality Standards
- Tests must also pass PHPStan, PHPMD, PHPInsights

### `test-structure-cleanup.md` — UI Module Test Structure Cleanup


# UI Module Test Structure Cleanup

## Problem Identified

The UI module has PSR-4 autoloading violations due to mixed test file structures.

## Current State

### Mixed Test Structures

```
❌ WRONG - Mixed test file structure
Modules/UI/
├── tests/                    # ✅ HAS FILES (traditional)
│   └── Unit/Widgets/
│       ├── BaseCalendarWidgetTest.php
│       ├── MockCalendarWidget.php
│       └── MockEventModel.php
└── app/

### `test.md` — test



### `theme-build.md` — Theme Build & Publish Guide


# Theme Build & Publish Guide

> Gli asset dei temi arrivano in document root con un **symlink**, non con una copia.
> Canonico: [Xot theme-assets-workflow](../../../Xot/docs/theme-assets-workflow.md).
> `public_path()` = `public_html/` (mai `laravel/public`).

## Installazione dipendenze

Nella cartella del tema (es. `Themes/One`):

```bash
npm install
```

## Build e link

```bash
cd laravel/Themes/<Tema>
npm run build

### `themes/asset-management.md` — Gestione degli Asset


# Gestione degli Asset

## Struttura delle Directory

```
public_html/
└── assets/
    └── [module_name]/
        └── [asset_type]/
            └── [files]

bashscripts/
└── verify_assets.sh    # Script di verifica asset
```

## Permessi e Proprietari

1. **Proprietario**: www-data
2. **Gruppo**: www-data

### `themes/schemaless-attributes-guide.md` — Schemaless Attributes Guide for UI Themes


# Schemaless Attributes Guide for UI Themes

[![Laravel 12.47.0](https://img.shields.io/badge/Laravel-12.47.0-red.svg)](https://laravel.com/)
[![Filament 5.0.0](https://img.shields.io/badge/Filament-5.0.0-blue.svg)](https://filamentphp.com/)
[![Spatie Schemaless](https://img.shields.io/badge/Spatie-Schemaless-orange.svg)](https://github.com/spatie/laravel-schemaless-attributes)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)

> **Guida completa** per implementare e gestire attributi schemaless nei temi UI Zero e One del sistema PTVX. Best practices, patterns PHPStan Level 10, e integrazione con il sistema esistente.

---

## 🎯 Scopo della Guida

### Obiettivi

1. **Standardizzare** l'uso di schemaless attributes nei temi UI
2. *

### `translations-update-snapshot-historical.md` — Aggiornamento Traduzioni Modulo UI - Gennaio 2026


# Aggiornamento Traduzioni Modulo UI - Gennaio 2026

## Data Intervento
**2026-01-22** - Sistemazione traduzioni secondo regole DRY + KISS

## Traduzioni Aggiunte

### 1. `table_layout.actions.toggle.label`

**Problema**: La traduzione `ui::table_layout.actions.toggle.label` era mancante in alcune lingue.

**Soluzione**: Aggiunta la sezione `actions.toggle.label` mancante in tutte le lingue.

**Lingue aggiornate**:
- ✅ Italiano (it) - già presente
- ✅ Inglese (en) - già presente
- ✅ Spagnolo (es) - già presente
- ✅ Francese (fr) - già presente
- ✅ Tedesco (de) - già presente

### `translations-update.md` — Aggiornamento Traduzioni Modulo UI - Gennaio 2026


# Aggiornamento Traduzioni Modulo UI - Gennaio 2026

## Data Intervento
**2026-01-22** - Sistemazione traduzioni secondo regole DRY + KISS

## Traduzioni Aggiunte

### 1. `table_layout.actions.toggle.label`

**Problema**: La traduzione `ui::table_layout.actions.toggle.label` era mancante in alcune lingue.

**Soluzione**: Aggiunta la sezione `actions.toggle.label` mancante in tutte le lingue.

**Lingue aggiornate**:
- ✅ Italiano (it) - già presente
- ✅ Inglese (en) - già presente
- ✅ Spagnolo (es) - già presente
- ✅ Francese (fr) - già presente
- ✅ Tedesco (de) - già presente

### `translations.md` — Traduzioni del Modulo UI


# Traduzioni del Modulo UI

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

## Struttura

```
Modules/UI/
└── lang/
    ├── it/
    │   └── ui.php
    └── en/
        └── ui.php
```

## Contenuto

### `troubleshooting.md` — UI — Troubleshooting Guide


# UI — Troubleshooting Guide

> Errori comuni, cause radice, e soluzioni nel modulo UI.

## 📋 Indice Problemi

1. [Blade Components](#blade-components)
2. [Filament Widgets & Forms](#filament-widgets--forms)
3. [TableLayoutEnum](#tablelayoutenum)
4. [Charts & Visualization](#charts--visualization)
5. [Asset & Styling](#asset--styling)
6. [Testing](#testing)

---

## Blade Components

### Errore: "View [x-ui::ui.component-name] not found"


### `user-research-2.md` — UI Module - User Research


# UI Module - User Research

**Module:** UI  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Research Goals

1. Understand component needs
2. Identify accessibility requirements
3. Validate design system
4. Determine developer experience needs

---

## Research Questions

### `user-research.md` — User Research: UI Module


# User Research: UI Module

## 🔬 Research Goals
Identify usability issues in complex Filament forms and tables.

## 💡 Key Findings
- Users struggle with very long forms without clear sections or tabs.
- Mobile responsiveness is critical for field workers.

## ✅ Actionable Insights / Next Steps
- Enforce the use of `Tabs` and `Sections` in all `XotBaseResource` forms.
- Optimize table columns for narrow viewports using `WorkerColumn` patterns.

### `vscode-filament-plugin-1.md` — Plugin VSCode per Filament


# Plugin VSCode per Filament

## Overview

Il plugin VSCode per Filament fornisce funzionalità avanzate per lo sviluppo di interfacce Filament, con snippet, autocompletamento e validazione in tempo reale.

## Installazione

1. Apri VSCode
2. Vai al pannello Extensions (Ctrl+Shift+X)
3. Cerca "Filament PHP"
4. Installa il plugin di doonfrs

## Funzionalità Principali

### 1. Snippet per Form Components
```php
// Digita 'fil-text' e premi Tab
TextInput::make('field_name')

### `widget-optimization.md` — Ottimizzazioni Widget - Modulo UI


# Ottimizzazioni Widget - Modulo UI

## Panoramica
Il modulo UI contiene diversi widget che possono essere ottimizzati seguendo i principi DRY + KISS. Questo documento identifica le opportunità specifiche e propone soluzioni concrete.

## 🚨 Widget Non Standardizzati Identificati

### 1. StatsOverviewWidget - Estensione Diretta Filament

**File**: `Modules/UI/app/Filament/Widgets/StatsOverviewWidget.php`

**Problema**: Estende direttamente `Filament\Widgets\StatsOverviewWidget as BaseWidget` invece di usare XotBase.

**Codice Attuale**:
```php
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{

### `wiki/_integration/custom-theme.md` — custom_theme


# custom_theme

<!-- Contenuto migrato da _docs/custom_theme.txt -->

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss

php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')
# custom_theme

<!-- Contenuto migrato da _docs/custom_theme.txt -->

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss

php artisan make:filament-theme admin

### `wiki/_integration/effetcts.md` — effetcts


# effetcts

<!-- Contenuto migrato da _docs/effetcts.txt -->

https://mridul2820.github.io/css-js/

https://github.com/Mridul2820/css-js

https://www.mridul.tech/projects/3d-responsive-flip-card-effect

https://codepen.io/eshnil/pen/NWRwyvb

https://codebase-frontend-library.github.io/codebase-5/docs/7-alpinejs-components/animations/

Aceternity
https://ui.aceternity.com/components/typewriter-effect

Motion

### `wiki/_integration/filament.md` — filament


# filament

<!-- Contenuto migrato da _docs/filament.txt -->

https://github.com/savannabits/filament-signature-pad

https://github.com/bezhanSalleh/filament-exceptions?tab=readme-ov-file

https://github.com/shuvroroy/filament-spatie-laravel-health

--- Select Tree ---
https://filamentphp.com/plugins/saade-adjacency-list
https://filamentphp.com/plugins/codewithdennis-select-tree
https://github.com/beholdr/filament-trilist

### `wiki/_integration/megamenu.md` — megamenu


# megamenu

<!-- Contenuto migrato da _docs/megamenu.txt -->

https://www.tailwindtoolbox.com/components/megamenu

https://tw-elements.com/docs/standard/navigation/mega-menu/

https://flowbite.com/docs/components/mega-menu/

https://kopi.dev/tailwind/navbar-responsive-mega-menu-using-tailwind-ui/

https://medium.com/themesberg-blog/how-to-build-a-mega-menu-with-tailwind-css-and-flowbite-8fd7143daad2

### `wiki/_integration/ratings.md` — ratings


# ratings

<!-- Contenuto migrato da _docs/ratings.txt -->

-------------------------------------------------------------------------------------------------
Add Ratings and Reviews for Laravel's Eloquent Models
https://codebrisk.com/blog/add-ratings-and-reviews-for-laravel-s-eloquent-models
composer require mtvs/laravel-reviews
https://github.com/mtvs/eloquent-aggregate-rating
-------------------------------------------------------------------------------------------------

### `wiki/_integration/ubuntu.md` — ubuntu


# ubuntu

<!-- Contenuto migrato da _docs/ubuntu.txt -->

sudo apt-get install jpegoptim
sudo apt-get install optipng
sudo apt-get install pngquant // For PNG Image
sudo npm install -g svgo
sudo apt-get install gifsicle
sudo apt-get install webp
sudo apt-get install libavif-bin # minimum 0.9.3

### `wiki/_integration/widgets.md` — widgets


# widgets

<!-- Contenuto migrato da _docs/widgets.txt -->

https://ahmedash.dev/blog/laravel-core-bits/volt-live-users-stats/

### `wiki/actions/generic-ui-building-blocks.md` — Generic UI Building Blocks: Category, Collection, FieldOption


# Generic UI Building Blocks: Category, Collection, FieldOption

## Scopo

Tre modelli generici, indipendenti dal dominio, pensati per essere riutilizzati da qualsiasi
modulo che abbia bisogno di tassonomie (`Category`), raggruppamenti eterogenei (`Collection`)
o opzioni per campi dinamici (`FieldOption`), senza dover reinventare la stessa tabella in
ogni modulo. Introdotti il 2026-07-15 (vedi `database/migrations/2026_07_15_1000{00,01,02}_*`).
Estendono `Modules\Xot\Models\BaseModel` (non `FormBuilder`, che non è disponibile in questo
contesto — annotato nei PHPDoc dei tre modelli).

## Stato attuale (2026-07-20)

- Nessuna risorsa Filament esiste ancora per questi modelli (`app/Filament/Resources/` è vuota,
  solo `.gitkeep`). Sono solo modelli + migrazioni, pronti per essere esposti in

### `wiki/agent-confidence-discipline.md` — Disciplina agenti per massimizzare la confidenza


# Disciplina agenti per massimizzare la confidenza

Regola canonica: [../../Xot/docs/wiki/concepts/agent-confidence-discipline.md](../../Xot/docs/wiki/concepts/agent-confidence-discipline.md).

Sintesi: verificare prima di affermare; riprodurre prima di correggere; documentare prove, dubbi e rischio residuo; rispondere in italiano sintetico.

### `wiki/agent-confidence-protocol.md` — Massima confidenza agente


# Massima confidenza agente

Stub DRY. Regola canonica: [../../../../docs/wiki/rules/agent-confidence-protocol.md](../../../../docs/wiki/rules/agent-confidence-protocol.md).

Checklist locale: issue GitHub, wiki owner, file letti a chunk, gate eseguiti, log aggiornato, limiti dichiarati.

### `wiki/concepts/auth-register-focus-loss-overlay.md` — Problema


# Problema

Su `/it/auth/register` gli input perdevano il focus al click e diventavano non usabili.

# Root cause

Nel componente `Modules/UI/resources/views/components/ui/marketing/header.blade.php` il menu mobile era un container `fixed` fullscreen (`w-full h-full min-h-screen`) con `z-index` alto.
Quando chiuso, in alcune condizioni continuava a intercettare i click sopra il form auth.

# Fix applicato

- sostituita la sola logica `hidden/flex` con `x-show="mobileMenuOpen"` (+ `style="display:none"` iniziale)
- aggiunta gestione esplicita `pointer-events`:
  - `pointer-events-none` quando chiuso
  - `pointer-events-auto` quando aperto
  - desktop sempre `md:pointer-events-auto` con `md:flex`

# Esito


### `wiki/concepts/block-rendering-and-optional-services.md` — Block rendering e servizi opzionali


# Block rendering e servizi opzionali

## Scopo

Il modulo **UI** fornisce componenti Blade/Livewire riusabili per pagine marketing e admin. Due filiere distinte:

1. **Block CMS** — composizione pagina da blocchi JSON (Filament Blocks).
2. **Mappa interattiva** — widget Livewire con marker e filtri (opzionale senza modulo Geo).

## Catena di utilizzo — Block

```mermaid
flowchart LR
  A[Filament Blocks in Modules/*/Filament/Blocks] --> B[GetAllBlocksAction]
  B --> C[ComponentFileData collection]
  D[x-render.blocks v1/v2] --> E[x-render.block]
  E --> F[Render\Block]
  F --> G[GetLocalizedBlockDataAction]
  G --> H{Modulo Cms presente?}

### `wiki/concepts/claude-audit-static.md` — claude-audit static (UI)


# claude-audit static (UI)

## Comando

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh UI
```

## Fix quality (70/8 → 80/0)

| Finding | Mitigazione |
|--------|-------------|
| `lang/it/icon_state_group.php`, `opening_hours_field.php` | Split per chiave top-level + `array_merge` loader |
| Blade pricing >500 righe | `@include` partials sotto `pricing/partials/` |
| `SelectStateColumn` nesting | `applyStateTransition()` con early return |
| `TestChartWidget` nesting | Opzioni Chart in `resources/js/test-chart-y-tick-options.js` |

## `.gitignore`


### `wiki/concepts/code-redundancy-ui.md` — Ridondanza — UI


# Ridondanza — UI

## Scopo

Componenti Filament estesi (`XotBaseField`, layout tabella, icone), enum layout, asset SVG condivisi. UI **non** deve reimplementare `HasXotTable` — solo estendere.

## P1 — trait layout tabella

| Path | Namespace |
|------|-----------|
| `app/Traits/TableLayoutTrait.php` | `Modules\UI\Traits` |
| `app/Filament/Actions/Table/TableLayoutTrait.php` | `Modules\UI\Filament\Actions\Table` |
| `HasTableLayout.php` | trait aggiuntivo |

**Azione:** unificare in un trait canonico; l’altro delega o `@deprecated`.

## P2 — viste blade duplicate

- `stat-with-icon.blade.php` vs `statwithicon.blade.php`

### `wiki/concepts/duplicate-method-bodies.md` — Corpi metodo duplicati — UI


# Corpi metodo duplicati — UI

> **19** gruppi con corpo identico coinvolgono UI (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo UI)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 3 | 22 |
| `B_business_duplicate` | 8 | 88 |
| `S_trivial_stub` | 8 | 19858 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `normalizeViewData` — 2 classi · 17 righe · ~17 righe duplicate


### `wiki/concepts/enumselect-filament-api-collisions.md` — Problema


# Problema

Quando si estende `Filament\\Forms\\Components\\Select` (o `Field`) e si introducono metodi con nomi gia' usati da Filament, si rischiano **fatal error** PHP per incompatibilita' di firma o visibilita'.

Esempi reali che rompono runtime:

- Override di `make()` con firma diversa da `Field::make(?string $name = null): static`
- Override di `enum()` con firma diversa da `HasEnum::enum(string|Closure|null $enum): static`
- Definire metodi come `getLabel()` (protected/private) che collidono con `Select::getLabel()` (public)

# Best practices

- Non override-are `make()` solo per fare "default config": usa `setUp()` e setta li' `native(false)`, `options(...)`, ecc.
- Se ti serve un metodo fluent `->enum(...)` che "fa cose in piu'", non cambiare firma: **usa lo stesso nome/signature

### `wiki/concepts/filament-first-blade-canonical.md` — UI — Filament Blade canonical


# UI — Filament Blade canonical

Il modulo **UI** documenta l’uso dei componenti Blade Filament condivisi tra temi e moduli.

## Regola

Leggere prima [filament-first-rule.md](../../../../../../docs/wiki/rules/filament-first-rule.md) (Rule 019). Il file [filament-components.md](../../blade/filament-components.md) elenca mapping tag → anti-pattern.

## Filament 5

- Overview: https://filamentphp.com/docs/5.x/components/overview
- Tabs: https://filamentphp.com/docs/5.x/components/tabs

## Non duplicare

I file in `Themes/docs/shared-components/` restano storici CMS; per nuovo lavoro usare questa catena: **wiki root → UI blade → tema Sixteen**.

### `wiki/concepts/method-name-homonyms.md` — Censimento omonimi metodi — UI


# Censimento omonimi metodi — UI

> **45** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo UI)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 14 |
| `E_scheda_stack` | 3 |
| `G_module_local` | 7 |
| `H_cross_module_homonym` | 21 |

## Dettaglio

### `A_filament_framework` (14 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.


### `wiki/concepts/model-states-module-ownership.md` — Model States Module Ownership


# Model States Module Ownership

## Scopo

Fissare la regola di ownership per `spatie/laravel-model-states` nel progetto modulare Laraxot dopo l'upgrade a Laravel 13.

## Decisione

- Il package non appartiene al root `composer.json`.
- Il package non appartiene a un singolo modulo dominio.
- L'owner tecnico e' condiviso tra `Modules/UI` e `Modules/Xot`:
  - `UI` espone componenti Filament che tipizzano `HasStatesContract` e `State`;
  - `Xot` definisce i base state e le transition astratte.

## Evidenze codice

- `Modules/UI/app/Filament/Forms/Components/SelectState.php`
- `Modules/UI/app/Filament/Tables/Columns/SelectStateColumn.php`
- `Modules/UI/app/Filament/Tables/Columns/IconStateColumn.php`

### `wiki/concepts/module-filament-component-autoload-rule.md` — Module Filament Component Autoload Rule


# Module Filament Component Autoload Rule

## Regola

Nei moduli Laraxot i componenti PHP autoloadabili devono stare sotto `app/`. Per i componenti Filament del modulo UI il path corretto e':

`Modules/UI/app/Filament/Forms/Components/...`

Non usare path paralleli fuori da `app/` per classi namespaced `Modules\UI\...`.

## Perche'

L'errore recente su `EnumSelect` non era un problema del widget Fixcity ma di autoload: il file era stato creato nel path sbagliato e Laravel non trovava la classe `Modules\UI\Filament\Forms\Components\EnumSelect`.
L'errore recente su `EnumSelect` non era un problema del widget <nome progetto> ma di autoload: il file era stato creato nel path sbagliato e Laravel non trovava la classe `Modules\UI\Filament\Forms\Components\EnumSelect`.
L'errore recente su `EnumS

### `wiki/concepts/module-root-uppercase-folders.md` — Cartelle config duplicate — UI


# Cartelle config duplicate — UI

## Situazione (risolta 2026-07-01)

`Config/` (maiuscolo) e `Config.bak/` duplicavano i file già in `config/`:

- `config.php`
- `laravel-localization.php`
- `laravellocalization.php`

## Regola

Solo `config/` (minuscolo) alla root del modulo nwidart.

## Azione

Rimossi `Config/` e `Config.bak/`; nessun autoload/require li referenziava. Git history conserva le versioni precedenti.

### `wiki/concepts/no-app-support-queueable-actions.md` — no `app/Support/` — business logic in QueueableAction


# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo UI **non** esiste più `app/Support/`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Destinazione |
|-----------------------|--------------|
| `Map/NullMapService` | `app/Adapters/Map/NullMapServiceAdapter` |
| `Map/NullGeocodingService` | `app/Adapters/Map/NullGeocodingServiceAdapter` |

## Eccezione: contratti multi-metodo

I fallback mappa/geocoding **implementano** `MapServiceContract` / `GeocodingServiceContract` con più metodi pubblici. Per religione Laraxot vivono in `app/Adapters/`, non in `app/Actions/`.

Binding in `UIServiceProvider::register()`.


### `wiki/concepts/no-services-no-support-queueable-actions.md` — UI — Services/Support vietati: solo Actions


# UI — Services/Support vietati: solo Actions

## Regola

- **Mai** creare file in `app/Services/` o `app/Support/`
- **Sempre** `app/Actions/{Contexto}/FooAction.php`
- **Trait**: `use Spatie\QueueableAction\QueueableAction;`
- **Entrypoint**: unico metodo `execute(...)`
- **Chiamata**: `app(FooAction::class)->execute(...)`
- **Gruppi**: sottocartelle per attore/contesto

## Conversione

Vedi [ui-services-support-to-actions.md](ui-services-support-to-actions.md) per mapping dettagliato.

### `wiki/concepts/phpstan-dynamic-array-normalization.md` — PHPStan Dynamic Array Normalization


# PHPStan Dynamic Array Normalization

## Scopo

Quando componenti UI ricevono output dinamico da action risolte via `app()` o da
stato Livewire, PHPStan non puo' assumere che l'array abbia chiavi e valori
compatibili con il contratto del metodo chiamato.

## Regola

Normalizzare l'array nel codice, elemento per elemento, invece di usare
`@var` inline per sovrascrivere l'inferenza.

## Pattern

- Per `array<int, array<string, mixed>>`, ricostruire ogni item accettando solo
  chiavi stringa.
- Per `array<string, mixed>`, copiare solo le chiavi stringa prima di passare il
  valore a service tipizzati.

### `wiki/concepts/ponytail-audit.md` — Ponytail audit — UI


# Ponytail audit — UI

**Run:** 2026-07-01 · **Scope:** over-engineering (non bug/sicurezza).

Documento canonico: [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md)

## Chiuso (run #3 — 2026-07-01)

- `MapServiceContract`, `GeocodingServiceContract`, `NullMapService`, `NullGeocodingService` — layer senza consumer
- `Config/` maiuscolo + `Config.bak/` — duplicato di `config/`; rimosso, resta solo `config/`
- `docs/archive/` — ~144 file duplicati sessione; bonificati verso `docs/wiki/`
- stub root modulo — `*.md` / `*.txt`, `_docs/`, `docs/root-md-files/`, `docs/root-txt-files/` rimossi; link `widgets.md` → `widget-optimization.md`

## Hub

- [docs/audit/ponytail-audit.md](../../../../../../docs/audit/ponytail-audit.md)
- [ponytail-audit-remediation.md](../../..

### `wiki/concepts/second-brain-local-discipline.md` — Contratto wiki locale — stub UI


# Contratto wiki locale — stub UI

| Risorsa | Link |
|---------|------|
| **Canon** | [Xot second-brain-local-discipline.md](../../../../Xot/docs/wiki/concepts/second-brain-local-discipline.md) |
| **Harness moduli** | [ai-harness-module-discipline.md](../../../../docs/wiki/concepts/ai-harness-module-discipline.md) |
| **Tips 001–022** | [hackernoon map](../../../../../../bashscripts/ai/wiki/concepts/agents-harness-tooling.md#hackernoon-ai-coding-tips-fixcity-map) |
| **Prompt router** | [llm-wiki.txt](../../../../../../bashscripts/tools/prompts/llm-wiki.txt) |

Solo decisioni specifiche di **UI** in `docs/wiki/`; contratto generico in Xot.

### `wiki/concepts/ui-geo-boundary-contracts.md` — UI ↛ Geo — confini (senza contratti in UI)


# UI ↛ Geo — confini (senza contratti in UI)

## Perché

`Modules\UI` = design system. Geografia/mappe = dominio `Geo`.

Il pattern “contract + null-adapter in UI” era un compromesso sbagliato: spostava il **dominio** geografico dentro UI sotto forma di interfacce. Se serve mappa/location, vive in `Modules/Geo` (quando il monorepo lo include).

## Stato (2026-07-22)

**Rimossi da UI** (non ricreare):

- `app/Adapters/Location/`, `app/Adapters/Map/`
- `LocationDataProviderContract`, `MapServiceContract`, `GeocodingServiceContract`
- `LocationSelector`, `InteractiveMap`
- `bindIf` Geo in `UIServiceProvider`

### Come corretto


### `wiki/concepts/ui-operating-model.md` — UI Operating Model


# UI Operating Model

> Stable summary of what the UI module is for and how to reason about its architecture.

## Role

The UI module is the shared abstraction layer for interface primitives across the repository:

- Blade components
- Filament custom form fields and columns
- dashboard and layout widgets
- block-based content composition
- reusable layout behaviors such as table view switching

## Architectural Guardrails

- Reusable interface primitives belong in `UI`, not scattered across feature modules.
- UI abstractions should centralize shared admin-panel behavior instead of letting modules reimplement common patterns.
- Integration with Filament should still respect Xot architectural rules.

### `wiki/concepts/ui-services-support-to-actions.md` — UI Services/Support → Actions/Adapters mapping


# UI Services/Support → Actions/Adapters mapping

## Riepilogo conversione

Tutti i file in `app/Services/` e `app/Support/` del modulo UI sono stati convertiti o rimossi.
## Boy scout 2026-11-23

I cinque `app/Services/*.php` sono riapparsi da merge: ridotti a stub `@deprecated`
SUPERSEDED (no-delete senza auth). Zero caller, zero binding. Canonici invariati:
`Xot\Actions\File\AssetAction`, `Adapters/Map/Null*ServiceAdapter`.

## Riepilogo conversione

Logica migrata ad Actions/Adapters; i file `app/Services/` possono restare stub SUPERSEDED.

Revisione 2026-07-13 (reconciliation pass): gli stub `ComponentAction`, `ThemeAction` e
`UIAction` creati dalla prima migrazione sono stati **eliminati**, non mantenuti. Motivo:
i `Service` legacy corrispondenti (`ComponentService`, `ThemeService`)

### `wiki/concepts/xotbase-inheritance-audit.md` — XotBase inheritance audit


# XotBase inheritance audit

Le classi concrete UI non estendono Filament direttamente. Il parent deve essere la base astratta speculare `Modules\\Xot\\Filament\\...\\XotBase*`; gli import Filament usati come tipi, contratti o composizione non sono violazioni.

## Inventario UI

L'audit ha corretto 13 parent: due Action, cinque componenti form, quattro colonne table e tre widget. Le basi riusate sono `XotBaseAction`, `XotBaseViewField`, `XotBaseSelect`, `XotBaseTextInput`, `XotBaseRadio`, `XotBaseColumn`, `XotBaseIconColumn`, `XotBaseColumnGroup`, `XotBaseSelectColumn`, `XotBaseStatsOverviewWidget` e `XotBaseChartWidget`.

## Gate

`php -l`, PHPStan mirato e `git diff --check` sono verdi. PHPMD conserva debito preesistente nelle colonne state (complessità, method length e import); non der

### `wiki/concepts/xotbasefield-no-view-rule.md` — XotBaseField – No `$view` Property Rule


# XotBaseField – No `$view` Property Rule

## Summary
Classes extending `Modules\Xot\Filament\Forms\Components\XotBaseField` **must not** define a `protected string $view` property. The view path is resolved automatically by the base class based on the component name, ensuring consistent naming and avoiding duplication.

## Why
- **Single source of truth**: view resolution logic lives in `XotBaseField`; overriding it creates divergence.
- **Maintainability**: reduces boilerplate and prevents mismatches when component names change.
- **Convention**: aligns with the project‑wide rule that view paths are calculated, not hard‑coded.

## Affected Files (current violations)
- `laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php` – line 24 declares `$view = 'filament-schemas::compo

### `wiki/context-compression.md` — Context Compression Setup


# Context Compression Setup

## Panoramica
Il sistema di compressione del contesto ora usa il setup reale del progetto:

- `qmd` per retrieval mirato
- `@ooples/token-optimizer-mcp` per comprimere e cache-izzare output MCP e tool payload ripetitivi

Questo sostituisce la precedente nota speculativa con una configurazione effettivamente installata.

## Configurazione Reale

- config condivisa: `/.mcp.json`
- config compatibilita': `/.claude/mcp_servers.json`
- config Kilo progetto: `/.kilo/kilo.jsonc`
- ignore Kilo progetto: `/.kilocodeignore`
- cache locale: `/.claude/token-optimizer-cache`
- installazione package: `bashscripts/mcp/package.json`


### `wiki/how-to/gitmodules-sync-session.md` — Gitmodules sync session


# Gitmodules sync session

Sessione orchestrata dal prompt `bashscripts/tools/prompts/02-gitmodules-sync.md` (v5.1) e da **STORY-003**.

## Cosa fare su questo owner

1. `git remote -v` — sync **tutte** le organizzazioni (`fetch` + `pull --ff-only` + `push`, mai `--force`).
2. Quality gates da `laravel/`: phpstan → phpmd → phpinsights (`--composer=composer.lock`).
3. Marker Git: risoluzione manuale forward-only (no `git restore`).

## Canon

- Story: [../../../../../../docs/stories/STORY-003-gitmodules-sync-conflict-sweep.md](../../../../../../docs/stories/STORY-003-gitmodules-sync-conflict-sweep.md)
- Report: [../../../../../../bashscripts/ai/wiki/memories/git-sync-fleet-remotes.md#gitmodules-sync](../../../../../../bashscripts/ai/wiki/memories/git-sync-fleet-remotes.md#gitmodules-sync)


### `wiki/integrazioni-valutate.md` — Integrazioni valutate per il modulo UI


# Integrazioni valutate per il modulo UI

## Che cos'e' questo elenco

Erano **26 file `.txt` da una riga** in `docs/wiki/_integration/`, uno per
argomento, ciascuno contenente solo l'indirizzo di un pacchetto. Separati non
si trovavano e non si leggevano: nessuno apre ventisei file per sapere quali
pacchetti sono stati guardati.

Sono appunti di valutazione, non decisioni: la presenza di un pacchetto qui
**non** significa che sia installato o scelto. Per quello che il progetto usa
davvero vale `composer.json`.


| Argomento | Riferimenti |
|---|---|
| Api | `-------------------------------------------------------------------------------------------------` <br> `Render HTTP JSON Responses for API-based Projects in Laravel` <br> <https://codebrisk.com/blog/render-http-json-responses-for-ap

### `wiki/memories/lang-split-ui-claude-audit.md` — Split lang UI (claude-audit)


# Split lang UI (claude-audit)

File `icon_state_group.php` e `opening_hours_field.php` → loader + `{name}_{section}.php` per chiave top-level (`fields`, `navigation`, …).

Script: `bashscripts/tools/split-module-lang-monolith-for-audit.php UI it <fileBase>`.

### `wiki/sources/ui-architecture-sources.md` — UI Architecture Sources


# UI Architecture Sources

> Source summary for the highest-signal UI documents.

## Source Cluster

- `README.md`
- `architecture-1.md`
- `product-strategy-1.md`
- `architecture/structure.md`

## Main Signals

- UI is the central shared component and Filament customization layer.
- The module is expected to standardize developer experience and interface consistency.
- Product direction emphasizes accessibility, performance, and broad adoption across features.

## Main Risks


### `wiki/standards/auth-form-standards.md` — Standard Form di Autenticazione

# Standard Form di Autenticazione

## Principi di Design

### Layout
- I form di autenticazione devono essere centrati sia orizzontalmente che verticalmente
- Utilizzare una larghezza massima appropriata per garantire leggibilità
- Mantenere una gerarchia visiva chiara con spaziatura consistente

### Container
```html
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Logo o intestazione -->
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <!-- Form -->
    </div>

### `wiki/standards/form-standards.md` — Standard Form nei Temi

# Standard Form nei Temi

## Principi Generali

### Layout e Allineamento
- I form devono essere centrati nella pagina con margini appropriati
- Utilizzare una larghezza massima per garantire leggibilità
- Mantenere una spaziatura consistente tra gli elementi

```html
<div class="container mx-auto max-w-4xl px-4 py-8">
  <form class="w-full space-y-6">
    <!-- Contenuto del form -->
  </form>
</div>
```

### Grid System
- Utilizzare il grid system di Tailwind per layout responsivi
- Su mobile: colonna singola

### `wiki/standards/ui-standards.md` — Standard UI


# Standard UI

## 🎨 Design System

### Colori
```scss
// Palette principale
$primary: #007bff;
$secondary: #6c757d;
$success: #28a745;
$danger: #dc3545;
$warning: #ffc107;
$info: #17a2b8;

// Gradienti
$gradient-primary: linear-gradient(135deg, $primary, darken($primary, 10%));
$gradient-success: linear-gradient(135deg, $success, darken($success, 10%));
```


### `wiki/topics/advanced-form.md` — Topic advanced-form


# Topic advanced-form

Sintesi automatica di 3 documenti (chiave `advanced-form`).

## Componenti Form Avanzati

_Fonte: `advanced-form-components-2.md`_

# Componenti Form Avanzati

## 📝 Input Avanzati

### Input con Icona
```html
<div class="input-group">
  <span class="input-group-text">
    <i class="fas fa-user"></i>
  </span>
  <input type="text" class="form-control" placeholder="Username">

### `wiki/topics/brands-icons.md` — Topic brands-icons


# Topic brands-icons

Sintesi automatica di 3 documenti (chiave `brands-icons`).

## 🎨 UI Brands Icons - Integration Guide

_Fonte: `brands-icons-integration-2.md`_

# 🎨 UI Brands Icons - Integration Guide

**Data**: 2026-03-30  
**Stato**: ✅ **INTEGRATO**

## 📦 Icons Created

### Social Media Brands (6)

1. ✅ **facebook.svg** - Facebook brand icon
2. ✅ **twitter.svg** - Twitter/X brand icon

### `wiki/topics/carousel-slider.md` — Topic carousel-slider


# Topic carousel-slider

Sintesi automatica di 3 documenti (chiave `carousel-slider`).

## carousel_slider

_Fonte: `_integration/carousel-slider.md`_

# carousel_slider

<!-- Contenuto migrato da _docs/carousel_slider.txt -->

https://www.embla-carousel.com/examples/predefined/

https://tw-elements.com/docs/standard/components/carousel/

https://keen-slider.io/examples

https://thefullstack.network/u/MananTank/project/blaze-slider-the-fastest-slider-library

### `wiki/topics/custom-theme.md` — Topic custom-theme


# Topic custom-theme

Sintesi automatica di 3 documenti (chiave `custom-theme`).

## Custom theme

_Fonte: `custom-theme-2.md`_

# Custom theme

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss


php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')

### `wiki/topics/design-comuni.md` — Topic design-comuni


# Topic design-comuni

Sintesi automatica di 3 documenti (chiave `design-comuni`).

## Design Comuni - Componenti UI per FAQ

_Fonte: `design-comuni-faq-components.md`_

# Design Comuni - Componenti UI per FAQ

## Panoramica

Componenti UI del modulo UI utilizzati per implementare la pagina FAQ del progetto Design Comuni Italia.

- **Modulo**: UI
- **Tema**: Sixteen
- **Pagina**: `/it/tests/domande-frequenti`
- **Stato**: ✅ 90% Completato


### `wiki/topics/duplicate-methods.md` — Topic duplicate-methods


# Topic duplicate-methods

Sintesi automatica di 3 documenti (chiave `duplicate-methods`).

## Analisi Metodi Duplicati - Modulo UI

_Fonte: `duplicate-methods-analysis.md`_

# Analisi Metodi Duplicati - Modulo UI

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **UI** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |

### `wiki/topics/filament-components.md` — Topic filament-components


# Topic filament-components

Sintesi automatica di 4 documenti (chiave `filament-components`).

## Componenti Filament UI

_Fonte: `filament-components-1.md`_

# Componenti Filament UI

## Collegamenti Bidirezionali

### Errori Comuni
- [Errori nei Componenti Filament](./filament-components-errors.md)
- [Best Practices UI](../../best-practices.md)
- [Implementazione Corretta](../../examples/correct-implementation.md)

### Componenti Specifici
- [FileUpload](./components/file-upload.md)

### `wiki/topics/filament-error.md` — Topic filament-error


# Topic filament-error

Sintesi automatica di 3 documenti (chiave `filament-error`).

## Errore: Metodo `buttonLabel()` su FileUpload di Filament

_Fonte: `filament-error-fileupload-buttonlabel-1.md`_

# Errore: Metodo `buttonLabel()` su FileUpload di Filament

## Descrizione
Il metodo `buttonLabel()` **NON esiste** sul componente `Filament\Forms\Components\FileUpload`. L'uso di questo metodo genera un errore fatale.

## Componenti coinvolti
- `FileUpload` **(non supporta)**
- Consultare la documentazione ufficiale Filament per i metodi supportati.

## Soluzione
- **Non usare mai** `->buttonLabel()` su FileUpload.

### `wiki/topics/form-standards.md` — Topic form-standards


# Topic form-standards

Sintesi automatica di 3 documenti (chiave `form-standards`).

## Standard Form nei Temi

_Fonte: `standards/form-standards.md`_

# Standard Form nei Temi

## Principi Generali

### Layout e Allineamento
- I form devono essere centrati nella pagina con margini appropriati
- Utilizzare una larghezza massima per garantire leggibilità
- Mantenere una spaziatura consistente tra gli elementi

```html
<div class="container mx-auto max-w-4xl px-4 py-8">

### `wiki/topics/legacy-roadmap.md` — Topic legacy-roadmap


# Topic legacy-roadmap

Sintesi automatica di 3 documenti (chiave `legacy-roadmap`).

## UI Module - Roadmap, Issues & Optimization

_Fonte: `roadmap/legacy/legacy-roadmap-and-issues.md`_

# UI Module - Roadmap, Issues & Optimization

**Modulo**: UI (User Interface Components)
**Data Analisi**: 1 Ottobre 2025
**Maintainer**: Laraxot Core Team
**Status PHPStan**: ✅ 0 errori (level 10)

---

## 📊 STATO ATTUALE


### `wiki/topics/livewire-widget.md` — Topic livewire-widget


# Topic livewire-widget

Sintesi automatica di 9 documenti (chiave `livewire-widget`).

## Architecture UI

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture UI

```
Tema Blade DarkModeSwitcher → DarkModeSwitcherWidget
Http/Livewire/DarkModeSwitcher → delete
Toast HTTP → resta: montato in components/layouts/main.blade.php:28 (+ User main.blade.php:49), non è orfano
Livewire/Components/Map/InteractiveMap → orfano: fuori Http/Livewire (non auto-registrato), zero montaggi, deps Geo\Services assenti
filament/widgets/group|row → già FQCN
```

ADR: gemello esistente batte classe nuova (stesso di User SocialLogin).

### `wiki/topics/page-builder.md` — Topic page-builder


# Topic page-builder

Sintesi automatica di 3 documenti (chiave `page-builder`).

## page_builder

_Fonte: `_integration/page-builder.md`_

# page_builder

<!-- Contenuto migrato da _docs/page_builder.txt -->

https://medium.com/landing-page-tips/5-best-drag-drop-tailwind-css-page-builders-9c251758d891
# page_builder

<!-- Contenuto migrato da _docs/page_builder.txt -->

https://medium.com/landing-page-tips/5-best-drag-drop-tailwind-css-page-builders-9c251758d891


### `wiki/topics/phpstan-compliance.md` — Topic phpstan-compliance


# Topic phpstan-compliance

Sintesi automatica di 3 documenti (chiave `phpstan-compliance`).

## PHPStan Level 10 Compliance Status

_Fonte: `phpstan-compliance-status.md`_

# PHPStan Level 10 Compliance Status


**Status**: ✅ FULLY COMPLIANT (0 errors)

## Summary
The UI module is fully compliant with PHPStan Level max. Ultimo round (2026-11-17): 14 errori live `view-string` azzerati; dettaglio in [wiki/troubleshooting/phpstan-fixes.md](wiki/troubleshooting/phpstan-fixes.md).

## Fixed Issues

### 1. Instanceof Always True Error

### `wiki/topics/phpstan-corrections.md` — Topic phpstan-corrections


# Topic phpstan-corrections

Sintesi automatica di 6 documenti (chiave `phpstan-corrections`).

## Correzioni PHPStan Completate - Gennaio 2025

_Fonte: `phpstan-corrections-final.md`_

# Correzioni PHPStan Completate - Gennaio 2025

## Riepilogo Finale

✅ **Tutti gli errori PHPStan corretti** - 0 errori in tutti i moduli

## Correzioni Applicate

### 1. GetAllIconsAction.php

**Problemi risolti**:

### `wiki/topics/phpstan-errors.md` — Topic phpstan-errors


# Topic phpstan-errors

Sintesi automatica di 3 documenti (chiave `phpstan-errors`).

## PHPStan Errori LocationSelector - Analisi e Correzione

_Fonte: `phpstan-errors-locationselector.md`_

# PHPStan Errori LocationSelector - Analisi e Correzione

## Problema Identificato

Il componente `LocationSelector` presenta errori PHPStan livello 10:

1. **Classe non trovata**: `Modules\Geo\Models\Comune` non esiste
2. **Metodi su mixed**: Tutti i metodi chiamati su `Comune` risultano su `mixed` perché la classe non è trovata

## Analisi Business Logic


### `wiki/topics/phpstan-fixes.md` — Topic phpstan-fixes


# Topic phpstan-fixes

Sintesi automatica di 7 documenti (chiave `phpstan-fixes`).

## Correzioni PHPStan Livello 7 - Modulo UI

_Fonte: `phpstan-fixes-1.md`_

# Correzioni PHPStan Livello 7 - Modulo UI

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo UI e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in TableLayoutToggleTableAction.php

```
Metodo toggleLayout() ha il parametro $livewire senza type hint specificato.
Cannot call method dispatch() on class-string|object.

### `wiki/topics/phpstan-radio.md` — Topic phpstan-radio


# Topic phpstan-radio

Sintesi automatica di 3 documenti (chiave `phpstan-radio`).

## Correzione Errori PHPStan - RadioBadge.php

_Fonte: `phpstan-radio-badge-fix-1.md`_

# Correzione Errori PHPStan - RadioBadge.php

## Data Aggiornamento
2025-01-27

## File Modificato
`Modules/UI/app/Filament/Forms/Components/RadioBadge.php`

## Errori PHPStan Risolti

### 1. **PHPDoc tag @return con sintassi non valida**

### `wiki/topics/sprint-planning.md` — Topic sprint-planning


# Topic sprint-planning

Sintesi automatica di 3 documenti (chiave `sprint-planning`).

## UI Module - Sprint Planning

_Fonte: `sprint-planning-2.md`_

# UI Module - Sprint Planning

**Module:** UI  
**Sprint:** Sprint 1 (March 12-25, 2026)  
**Version:** 1.0.0

---

## Sprint Goal

Implement core design system with essential UI components.

### `wiki/topics/table-layout.md` — Topic table-layout


# Topic table-layout

Sintesi automatica di 3 documenti (chiave `table-layout`).

## TableLayoutToggleTableAction

_Fonte: `actions/table-layout-toggle.md`_

# TableLayoutToggleTableAction

## Panoramica
Azione Filament per il toggle del layout delle tabelle tra vista griglia e lista.

## Caratteristiche
- Supporto per layout griglia e lista
- Integrazione con Livewire
- Persistenza dello stato del layout
- Supporto per tooltip e icone dinamiche


### `wiki/topics/tailwind-themes.md` — Topic tailwind-themes


# Topic tailwind-themes

Sintesi automatica di 3 documenti (chiave `tailwind-themes`).

## tailwind_themes

_Fonte: `_integration/tailwind-themes.md`_

# tailwind_themes

<!-- Contenuto migrato da _docs/tailwind_themes.txt -->

https://dev.to/mariann93502220/30-free-tailwind-css-templates-to-kick-start-your-next-project-3igo

https://merakiui.com/
# tailwind_themes

<!-- Contenuto migrato da _docs/tailwind_themes.txt -->


### `wiki/troubleshooting/git-merge-conflict-inventory-2.md` — Git Conflict Inventory


# Git Conflict Inventory

- Date: 2026-04-28
- Owner: Modules/UI
- Files with conflict markers: 2

## Files

- docs/strategy.md
- docs/studio_card_selector_implementation.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.

### `wiki/troubleshooting/git-merge-conflict-inventory.md` — Git Conflict Inventory


# Git Conflict Inventory

- Owner: Modules/UI
- Ultimo sweep app+routes: 2026-11-24 (PHPStan boot lane)

## App PHP + routes risolti (prefer `laraxot/dev` se HEAD vuoto; stub routes senza `empty.php`)

- `routes/web.php` — stub vuoto (no `require` Xot/routes/empty.php)
- `routes/api.php` — stub vuoto (no `require` Xot/routes/empty.php)
- `app/Actions/GetUserDataAction.php` — docblock `@contract`
- `app/Actions/Icon/GetAllIconsAction.php` — docblock `@contract`
- `app/Actions/Datetime/GetDaysMappingAction.php` — docblock `@contract`
- `app/Actions/Panel/ApplyCalendarToPanelAction.php` — docblock `@contract`
- `app/Actions/Block/GetAllBlocksAction.php` — docblock `@contract`
- `app/Actions/Block/GetLocalizedBlockDataAction.php` — `@contract` + guard `class_exists` (Cms opzionale)
- `app/Ser

### `wiki/troubleshooting/module-theme-root-hygiene.md` — Root modulo/tema — igiene


# Root modulo/tema — igiene

## Regola

| Root `Modules/*` e `Themes/*` | Consentito |
|---------------------------------|------------|
| `*.txt` | **0** |
| `*.md` | **max 4**: `README.md`, `CHANGELOG.md`, `LICENSE.md`, `AGENTS.md` |
| Cartelle | solo **lowercase** (`app`, `config`, `docs`, …) |

## Perché

La root è la **superficie tecnica** del package (manifest nwidart, autoload, README). Appunti `.txt` e report `.md` sporcano audit, QMD e push submodule.

## Audit

```bash
# da root monorepo
bash bashscripts/tools/audit-module-root-hygiene.sh

### `wiki/ui/ui-carousel-slider.md` — ui-carousel-slider


https://www.embla-carousel.com/examples/predefined/



https://tw-elements.com/docs/standard/components/carousel/

https://keen-slider.io/examples

https://thefullstack.network/u/MananTank/project/blaze-slider-the-fastest-slider-library


### `wiki/ui/ui-custom-firm-fields.md` — ui-custom-firm-fields


https://github.com/tanthammar/filament-extras


//--- with nested ?
https://github.com/saade/filament-extra


https://laracasts.com/discuss/channels/livewire/laravel-filament-custom-field-call-function


### `wiki/ui/ui-global-search.md` — ui-global-search


https://github.com/spatie/laravel-searchable


### `wiki/ui/ui-tailwind-themes.md` — ui-tailwind-themes


https://dev.to/mariann93502220/30-free-tailwind-css-templates-to-kick-start-your-next-project-3igo

https://merakiui.com/
