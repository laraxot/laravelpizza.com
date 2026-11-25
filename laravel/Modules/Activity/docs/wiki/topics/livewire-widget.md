---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 10 documenti (chiave `livewire-widget`).

## Architecture Activity

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Activity

Nessun flusso HTTP → widget: zero classi `Http\Livewire`, zero `Filament/Widgets` nel modulo. Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming Activity

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming Activity

Scartato: inventare HTTP o widget “per completezza”. Tenuto: inventory come gate. Verdetto zero candidati: [livewire-inventory.md](./livewire-inventory.md).

## Decision log Activity

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log Activity

## [2026-09-21] Nessun candidato conversione

Docs only. Inventario chiuso. Http/Livewire solo `.gitkeep` + `_components.json` vuoto. Audit log ≠ widget KPI. Zero conversione. Canone: [livewire-inventory.md](./livewire-inventory.md).

## Epics Activity

_Fonte: `bmad/livewire-widget-epics.md`_

# Epics Activity

Nessun epic di conversione. L’inventory è il gate: [livewire-inventory.md](./livewire-inventory.md). Story User 9–10 e foglia 12.x vivono nei moduli con HTTP reale.

## PRD Activity

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Activity

### FR-Z001 [MUST] Non creare classi `Http\Livewire` nuove.
### FR-Z002 [MUST] Non inventare widget KPI per “avere un widget”.
### FR-Z003 [MUST] Se nasce chrome panel: FQCN, `XotBaseWidget`, `$isDiscovered = false`.

Verdetto zero candidati: [livewire-inventory.md](./livewire-inventory.md).

## Brief Activity

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief Activity

Nessuna UI HTTP da portare nel panel. Http/Livewire solo `.gitkeep` + `_components.json` vuoto. Audit log ≠ widget KPI. Zero conversione: [livewire-inventory.md](./livewire-inventory.md).

## Context Activity

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Activity

Costituzione piattaforma: [Xot](../../Xot/docs/bmad/livewire-widget-project-context.md). Activity non riscrive i vincoli: estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto; chrome con `$isDiscovered = false` + FQCN; FO/legal ≠ widget forzato. Zero candidati verificati: [livewire-inventory.md](./livewire-inventory.md).

## Tech spec Activity

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Activity

Gate: `find app/Http/Livewire -name '*.php'` = 0 (esclusi `.gitkeep` / `_components.json`) e `find app/Filament -iname '*widget*'` = 0. Nessun PHP ora. Canone: [livewire-inventory.md](./livewire-inventory.md).

## UX Activity

_Fonte: `bmad/livewire-widget-ux.md`_

# UX Activity

Nessuna superficie chrome da migrare. Non cambiare layout panel. Verdetto: [livewire-inventory.md](./livewire-inventory.md).

## Topic livewire-widget

_Fonte: `wiki/topics/livewire-widget.md`_

# Topic livewire-widget

Sintesi automatica di 9 documenti (chiave `livewire-widget`).

## Architecture Activity

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Activity

Nessun flusso HTTP → widget: zero classi `Http\Livewire`, zero `Filament/Widgets` nel modulo. Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming Activity

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming Activity

Scartato: inventare HTTP o widget “per completezza”. Tenuto: inventory come gate. Verdetto zero candidati: [livewire-inventory.md](./livewire-inventory.md).

## Decision log Activity

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log Activity

## [2026-09-21] Nessun candidato conversione

Docs only. Inventario chiuso. Http/Livewire solo `.gitkeep` + `_components.json` vuoto. Audit log ≠ widget KPI. Zero conversione. Canone: [livewire-inventory.md](./livewire-inventory.md).
