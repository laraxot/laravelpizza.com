---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 9 documenti (chiave `livewire-widget`).

## Architecture Tenant

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Tenant

Nessun flusso HTTP → widget. Superficie Filament = `DomainResource` + `Pages/Dashboard`; `Filament/Widgets` assente. Il team switcher del chrome è `User\Filament\Widgets\Team\TeamChangeWidget` (User `AdminPanelProvider.php:49-52`), non di Tenant. Verdetto: [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming Tenant

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming Tenant

Scartato: inventare HTTP o widget "per completezza"; scartato un secondo team switcher (quello reale è di User). Tenuto: inventory come gate — [livewire-inventory.md](./livewire-inventory.md).

## Decision log Tenant

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log Tenant

## [2026-09-21] Nessun candidato conversione

Docs only. Inventario chiuso.

## [audit] Verifica completata

`app/Http/Livewire` contiene solo `_components.json` (`[]`). Zero `@livewire`/`<livewire:` nelle viste, provider senza hook (`AdminPanelProvider.php:18` fa solo `parent::panel`), `Filament/Widgets` assente. Team switcher chrome = User `TeamChangeWidget`, Epic 10.1 — Tenant non duplica. Dettagli: [livewire-inventory.md](./livewire-inventory.md).

## Epics Tenant

_Fonte: `bmad/livewire-widget-epics.md`_

# Epics Tenant

Nessun epic di conversione: zero candidati A/B/C verificati in [livewire-inventory.md](./livewire-inventory.md). Per il team switcher vedi User 10.1.

## PRD Tenant

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Tenant

### FR-T001 [MUST] Nessun FR HTTP→widget.
### FR-T002 [MUST] Non creare un secondo team switcher: quello del chrome è `User\Filament\Widgets\Team\TeamChangeWidget`.

Verdetto: [livewire-inventory.md](./livewire-inventory.md).

## Brief Tenant

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief Tenant

Nessuna UI HTTP da portare nel panel. `Http/Livewire` vuoto (solo `_components.json` `[]`); `Filament/Widgets` assente. Team switcher chrome è User 10.1 — Tenant non duplica. Verdetto: [livewire-inventory.md](./livewire-inventory.md).

## Context Tenant

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Tenant

Costituzione piattaforma: [Xot](livewire-widget-project-context.md). Tenant non riscrive i vincoli: estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto; chrome con `$isDiscovered = false` + FQCN; FO/legal ≠ widget forzato.

Stato verificato: zero `Http\Livewire`, zero widget — [livewire-inventory.md](./livewire-inventory.md).

## Tech spec Tenant

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Tenant

Gate verificato: `find Modules/Tenant/app/Http/Livewire -name '*.php'` = 0 file (solo `_components.json` `[]`). Nessun PHP ora. Dettagli audit: [livewire-inventory.md](./livewire-inventory.md).

## UX Tenant

_Fonte: `bmad/livewire-widget-ux.md`_

# UX Tenant

Nessuna superficie chrome da migrare. Non cambiare layout panel. Vedi [livewire-inventory.md](./livewire-inventory.md).
