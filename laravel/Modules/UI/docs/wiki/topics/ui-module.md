---
title: "Topic ui-module"
type: digest
status: active
qmd: "digest ceiling 100 ui-module"
---

# Topic ui-module

Sintesi automatica di 3 documenti (chiave `ui-module`).

## Analisi Qualità - Modulo UI

_Fonte: `quality-analysis/ui-module-quality-report.md`_

# Analisi Qualità - Modulo UI

**Data Analisi**: 2025-01-22
**Analista**: AI Assistant
**Status**: In Progress

## 📊 Risultati Strumenti Qualità

### PHPStan Livello 10 ✅
- **Errori**: **0** ✅
- **Status**: Perfetto
- **Note**: Tutti i file passano PHPStan livello 10

### PHPMD ⚠️
- **Violations**: ~15 (StaticAccess warnings)
- **Categorie**: cleancode, codesize, design
- **Status**: Accettabile (warnings su Facades Laravel, accettati)

**Violations Identificate**:
1. `GetAllBlocksAction.php` - StaticAccess a `Assert`, `File`, `Arr`, `Str`, `ComponentFileData` (7)
2. `GetDaysMappingAction.php` - StaticAccess a `Carbon` (1)
3. `GetUserDataAction.php` - StaticAccess a `Auth` (1)
4. `GetAllIconsAction.php` - StaticAccess a `App`, `File` (2)
5. `ApplyCalendarToPanelAction.php` - StaticAccess a `Log` (1)
6. `TableLayoutTrait.php` - StaticAccess a `Session` (3)
7. `Hero.php` - StaticAccess a `TextInput` (1)

**Analisi**: Le violazioni sono principalmente su Facades Laravel (`File`, `Auth`, `App`, `Log`, `Session`, `Str`, `Arr`) e classi static (`Assert`, `Carbon`, `TextInput`). Per Laravel, l'uso di Facades è accettato e documentato.

## UI Module Documentation

_Fonte: `ui-module.md`_

# UI Module Documentation

## Overview

The UI module provides common Filament components, themes, and utilities used across all PTVX modules.

## Core Components

### GroupColumn
**Location:** `app/Filament/Tables/Columns/GroupColumn.php`  
**View:** `resources/views/filament/tables/columns/group.blade.php`  
**Documentation:** `docs/GroupColumn.md`

A flexible table column that groups multiple fields in a single cell with support for:
- Dot notation relationships (`valutatore.nome_diri`)
- Automatic label translation
- Empty value handling
- Search capabilities

### Theme System
**Location:** `resources/views/themes/`

The UI module provides centralized theming for:
- Table layouts
- Form components  
- Navigation elements
- Responsive design patterns

## Translation System

## UI Module — Overview

_Fonte: `wiki/overviews/ui-module.md`_

# UI Module — Overview

> **Ruolo**: Layer di presentazione centralizzato — componenti Blade/Filament riutilizzabili, design system, governance UI per tutti i moduli.

## Responsabilità del Modulo

Il modulo UI è il **fornitore di componenti UI** per l'intera applicazione:

- Registra e scopre componenti Blade e Livewire riutilizzabili via `GetModulePathByGeneratorAction`
- Fornisce il design system condiviso (tipografia, colori, spaziatura)
- Gestisce il pannello Filament Admin (`AdminPanelProvider`)
- Separa la logica di presentazione dalla business logic dei moduli
- Dipende da: **User, Tenant, Xot**

## Philosophy

> _"Zen": un'interfaccia armoniosa dove gli utenti interagiscono senza sforzo, e i developer costruiscono con fiducia su componenti consistenti._

Principi guida:
- **Component-driven**: ogni elemento UI è un componente riutilizzabile e indipendente
- **Separation of concerns**: logica UI separata dalla business logic
- **Xot alignment**: estende `XotBaseServiceProvider`, eredita i pattern fondamentali
- **UI standardization**: governa e impone consistenza visiva in tutti i moduli

## Componenti Blade Principali

### Layout e Struttura

```blade
