---
title: "Topic chaos-monkey"
type: digest
status: active
qmd: "digest ceiling 100 chaos-monkey"
---

# Topic chaos-monkey

Sintesi automatica di 3 documenti (chiave `chaos-monkey`).

## Chaos monkey checklist (cms)

_Fonte: `chaos-monkey-checklist.md`_

# Chaos monkey checklist (cms)

## Scopo

Checklist operativa per ripristinare rapidamente il frontoffice quando un “chaos monkey” introduce rotture casuali nel sistema Folio + Theme + CMS JSON blocks.

Questa checklist è basata sul runtime attuale (fail-fast su view mancanti, JSON tenant-driven via Sushi).

## Pipeline minima (source-of-truth)

1. Folio risolve la pagina da `Themes/<pub_theme>/resources/views/pages/*`

2. La pagina Folio/Volt renderizza `<x-layouts.app>` e delega a `<x-page ...>`

3. `<x-page>` carica `PageModel::getBlocksBySlug($slug, $side)`

4. `Page` usa `SushiToJsons` e legge JSON tenant da `database/content/pages/*.json`

5. `HasBlocks::getBlocks()` istanzia `new BlockData(...)` per ogni blocco

6. `cms::components.page` esegue `@include($block->view, $block->data)`

## Regole di stabilità (da non violare)

- `pub_theme::` deve restare risolvibile per views e translations.
- `BlockData` è **fail-fast** se la view non esiste (non assumere fallback silenziosi).
- Evitare `{{ route(...) }}` nei JSON dei blocchi: preferire URL stringa.

## Incident playbook (ordine consigliato)

## Chaos Monkey - Deep Dive Tecnico

_Fonte: `chaos-monkey-deep-dive.md`_

# Chaos Monkey - Deep Dive Tecnico

Analisi approfondita della catena di rendering per debugging sistematico.

## 1. Risoluzione Tenant e Path

### GetTenantNameAction

- **Input**: `$_SERVER['SERVER_NAME']` o `config('app.url')`
- **Output**: es. `local/laravelpizza` (config_path deve esistere)
- **Fallback**: `localhost` se nessun config trovato
- **Test**: `isRunningTestBench()` → path diverso (`Config/`)

### GetTenantFilePathAction

- **Path**: `base_path('config/'.$tenantName.'/'.$filename)`
- **Esempio**: `database/content/pages` → `config/local/laravelpizza/database/content/pages`
- **SushiToJsons**: `filePath('database/content/pages')` = directory, poi `File::glob($path.'/*.json')`

### Config xra.php

- **Path**: `config/local/laravelpizza/xra.php`
- **Chiavi critiche**: `pub_theme`, `register_pub_theme`, `primary_lang`
- **Se mancante**: XotData::make() può fallire

## 2. SushiToJsons - Caricamento JSON

### Flusso Page

## Chaos Monkey Recovery Playbook (CMS)

_Fonte: `chaos-monkey-recovery-playbook.md`_

# Chaos Monkey Recovery Playbook (CMS)

## Goal

Restore frontoffice rendering quickly when random failures hit template/theme/CMS boundaries.

## System Boundary

- Routing: Folio pages in active theme
- Rendering: `<x-page>` component (`Modules\\Cms\\View\\Components\\Page`)
- Content source: tenant JSON files via `SushiToJsons`
- Block hydration: `BlockData` + `ResolveBlockQueryAction`
- Theme namespace: `pub_theme::`

## Fast Triage (3 minutes)

1. Confirm active theme from tenant config (`xra.pub_theme`).
2. Confirm failing URL maps to Folio page (`index`, `[slug]`, `[container0]`, `[container0]/[slug0]`).
3. Confirm target page slug exists in JSON pages.
4. Confirm every block has valid `data.view`.
5. Confirm view namespace resolves (`pub_theme::...`).

## Canonical Runtime Chain

Request -> Folio page -> `PageSlugMiddleware` -> `<x-layouts.app>` -> `<x-page>` -> `Page::getBlocksBySlug()` -> `HasBlocks::compile()` -> `new BlockData(...)` -> `@include($block->view, $block->data)`.

If this chain breaks, prioritize fixing the earliest broken node.

## High-Probability Failure Modes
