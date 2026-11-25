---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 10 documenti (chiave `livewire-widget`).

## Architecture Lang

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Lang

```
UI components/headernav/simple.blade.php:60 → <livewire:lang.change> (HTTP, ancora attivo)
Http/Livewire/Lang/Switcher → file ritirato (21/09), alias stale in _components.json
Http/Livewire/Lang/Change → ancora presente: swap tag → poi delete (ordine in story 12.1)
Filament/Widgets/LanguageSwitcherWidget → pronto (LaravelLocalization, righe 70-128), non montato
View\Components\LanguageSwitcher → wrapper inerte (registrazione commentata, LangServiceProvider.php:42)
```

ADR: non creare `LangChangeWidget`. Dettaglio e citazioni: [livewire-inventory.md](./livewire-inventory.md) — stato volatile, rieseguire i grep prima di agire.

## Brainstorming

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming

Change e Switcher erano copy-paste (stesso `mount()`, stessa vista `lang::livewire.lang.change`). Tenerne uno HTTP sarebbe comunque un gemello del widget.

**Stato (21/09, verificato):** `Switcher.php` ritirato; `Change.php` ancora montato in `UI headernav:60`; `LanguageSwitcherWidget` corretto ma senza consumatori. Ritiro di `Change` subordinato allo swap del tag — ordine e AC in story 12.1 (`blocked`).

## Lang — canone

_Fonte: `bmad/livewire-widget-conversion.md`_

# Lang — canone

SSoT: [livewire-inventory.md](./livewire-inventory.md). Story 12.1 `blocked`: `Switcher` ritirato, `Change` ancora montato via `<livewire:lang.change>` in `Modules/UI/.../headernav/simple.blade.php:60`. SSoT futuro: `LanguageSwitcherWidget` (già allineato a `LaravelLocalization`, non ancora montato). Non creare un terzo switcher.

## Decision log

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log

## [2026-09-21] Widget SSoT, HTTP duplicati fuori

Docs only.

## [2026-09-21] Stato intermedio verificato: story 12.1 a metà (`blocked`)

Una campagna concorrente ha: cancellato `Switcher.php`, riscritto `LanguageSwitcherWidget` su `LaravelLocalization` (righe 70-128), tipizzato i docblock di `Change.php`. Non fatto: swap del tag in `UI headernav:60` (ancora `<livewire:lang.change>`), delete di `Change.php`, pulizia `_components.json` (voce `lang.switcher` stale su classe mancante), migrazione dei 3 test che importano `Switcher` (ora rotti). Verdetto invariato (ritiro su gemello), esecuzione parziale. Citazioni: [livewire-inventory.md](./livewire-inventory.md) + story 12.1.

## Epic 12

_Fonte: `bmad/livewire-widget-epics.md`_

# Epic 12

| ID | Intent | Status |
|----|--------|--------|
| 12.1 | Ritiro Change+Switcher HTTP su widget | **blocked** — Switcher ritirato, Change ancora montato (`UI headernav:60`), widget pronto ma non agganciato; residui e ordine in [livewire-inventory.md](./livewire-inventory.md) |

## PRD Lang

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Lang

### FR-L001 [MUST] HTTP Switcher e Change assenti. — **parziale**: `Switcher.php` cancellato (alias `lang.switcher` stale in `_components.json`); `Change.php` presente e montato (`UI headernav:60`).
### FR-L002 [MUST] Widget + Blade wrapper restano. Nessuna terza classe. — soddisfatto; wrapper inerte (registrazione commentata).
### FR-L003 [SHOULD] Parità URL localizzati. — **chiuso nel codice**: widget usa `LaravelLocalization::getSupportedLocales()`/`getLocalizedURL()` (righe 73, 118) + redirect 303. Manca solo lo swap del mount.

## Brief

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief

`LanguageSwitcherWidget` unico (obiettivo). Stato 21/09: `Switcher` ritirato; `Change` ancora vivo in `UI headernav:60`; widget pronto (`LaravelLocalization`) ma non montato. Metrica: `app/Http/Livewire` vuoto quando `Change.php` esce e `_components.json` è `[]`.

## Context Lang

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Lang

Un selettore lingua. Destinazione: `LanguageSwitcherWidget` (`$isDiscovered = false`, `LaravelLocalization`). Oggi il mount vivo è ancora l'HTTP `lang.change` in `UI headernav:60`; `Switcher` è già uscito (alias stale da ripulire). Copie Jet in ritiro.

## Tech spec Lang

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Lang

Stato verificato 21/09 (story 12.1 `blocked`, ordine obbligato):

1. Swap `Modules/UI/.../headernav/simple.blade.php:60`: `<livewire:lang.change>` → `@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)`.
2. Delete `app/Http/Livewire/Lang/Change.php` (+ vista orfana `livewire/lang/change.blade.php` a valle).
3. `_components.json` → `[]` (oggi elenca `lang.change` + `lang.switcher` stale su classe cancellata).
4. Migrare i test che importano `Switcher` (`LangHundredPercentCoverageTest`, `LangFinalGapsTest`, `LangCoverageGaps`) — oggi rotti per class-not-found.

Parità già nel codice widget: `getSupportedLocales()` riga 73, `getLocalizedURL()` riga 118, redirect 303 righe 101-108. Grep di verifica: `grep -rn "lang\.change\|lang\.switcher\|livewire:lang" .` deve dare zero hit attivi.

## UX

_Fonte: `bmad/livewire-widget-ux.md`_

# UX

Stesso dropdown, stesso punto dell'header FO (`headernav/simple.blade.php:60`): lo swap da `<livewire:lang.change>` al widget FQCN non deve cambiare markup né interazione. Nessun secondo controllo nel panel.
