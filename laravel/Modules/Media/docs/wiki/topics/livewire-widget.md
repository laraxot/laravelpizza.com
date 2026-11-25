---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 10 documenti (chiave `livewire-widget`).

## Architecture Media

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Media

Clip era componente card + modal (`dispatch('showModal', ['editClip', $data])`). **Orfano verificato** (zero montaggi repo-wide, vista `card.video.clip.edit` inesistente) → **rimosso** il 21/09/2026 come dead code; `_components.json` ora `[]`. Nessun widget creato.

Dettaglio e citazioni: [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming

Scartato: widget dashboard clip. Motivo: `Clip` era **orfano puro** — nessun blade, hook, rotta o vista di supporto lo raggiungeva ([livewire-inventory.md](./livewire-inventory.md)). Esito: file rimosso il 21/09/2026 come dead code, nessuna conversione.

## Media — canone

_Fonte: `bmad/livewire-widget-conversion.md`_

# Media — canone

SSoT: [livewire-inventory.md](./livewire-inventory.md). `Card/Video/Clip` era **codice orfano** (zero punti di montaggio verificati repo-wide, vista di render mancante) ed è stato rimosso il 21/09/2026 come dead code. Nessuna conversione, nessun widget.

## Contenuto fuso da `livewire-widget-conversion.md`

# Media module — Livewire → Filament widget (superato)

**Canone:** [livewire-inventory.md](./livewire-inventory.md).

Questo documento (2026-08-25) proponeva di convertire `Clip` (`Modules/Media/app/Http/Livewire/Card/Video/Clip.php`) in un `MediaVideoWidget` sotto `Media/Filament/Widgets/Videos/`, sulla base dell'unica considerazione "il componente gestisce la riproduzione di video nel modulo Media", senza verificare se e dove Clip fosse effettivamente montato.

Verifica successiva (21/09/2026, vedi [livewire-inventory.md](./livewire-inventory.md)): zero hook nel panel provider Filament del modulo (`Modules/Media/app/Providers/Filament/AdminPanelProvider.php`, 20 righe, nessun `renderHook`), zero `@livewire('card.video.clip')` o `<livewire:...>` in tutto il repository, zero rotta dedicata, zero vista di supporto per il `render()` del componente (che cercherebbe una vista `.../card.video.clip.edit` inesistente). `Clip` è codice orfano, non un componente da convertire in widget: costruire un widget nuovo per codice senza consumatori avrebbe aggiunto superficie invece di ridurla.

Non è stato scritto nessun `MediaVideoWidget`. Non seguire più i checkbox di

## Decision log

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log

## [2026-09-21] Clip is FO card

Docs only.

## [2026-09-21] Correzione diagnosi: Clip era orfano, non "FO in uso"

La verifica repo-wide ([livewire-inventory.md](./livewire-inventory.md)) non trovava alcun montaggio di `card.video.clip` — né hook Filament, né tag/direttiva blade, né rotta; mancava anche la vista che `render()` avrebbe risolto.

## [2026-09-21] Clip rimosso come dead code

`Modules/Media/app/Http/Livewire/Card/Video/Clip.php` cancellato (file mai tracciato in git; task `12.1-retire-media-clip-livewire`). `_components.json` ora `[]`. Il modulo non ha più classi Livewire HTTP. Nessun widget creato — il verdetto "non convertire" resta il riferimento.

## Epic 12

_Fonte: `bmad/livewire-widget-epics.md`_

# Epic 12

Verdetto: non convertire. Story 12.1 è il lock di scope. `Clip` è stato rimosso come dead code il 21/09/2026 (zero consumatori — verifica in [livewire-inventory.md](./livewire-inventory.md)).

## PRD Media

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Media

### FR-M001 [MUST] Clip non diventa XotBaseWidget KPI. — soddisfatto; Clip rimosso (dead code), non convertito.
### FR-M002 [MUST] Nessun widget nuovo per codice senza consumatori ([livewire-inventory.md](./livewire-inventory.md)).

## Brief

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief

Clip era orfano (nessun montaggio repo-wide, vista mancante) ed è stato rimosso il 21/09/2026. Zero `ClipWidget`/`MediaVideoWidget`: creare un widget per dead code avrebbe aggiunto superficie senza ridurla. Metrica: `app/Http/Livewire` senza classi.

## Context Media

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Media

Media serve file e card. Clip era UI di contenuto (edit inline title/subtitle via modale), non chrome admin — e non era montato da nessuna parte: rimosso come dead code il 21/09/2026 (verifica in [livewire-inventory.md](./livewire-inventory.md)).

## Tech spec Media

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Media

Nessun PHP in questa campagna. Verifica eseguita prima della rimozione (citazioni in [livewire-inventory.md](./livewire-inventory.md)):

```bash
grep -rn "card\.video\.clip\|Card\\\\Video\\\\Clip" --include="*.php" --include="*.blade.php" .   # 0 hit attivi
cat Modules/Media/app/Providers/Filament/AdminPanelProvider.php                                 # 20 righe, 0 renderHook
find Modules/Media/resources/views -path "*card/video/clip*"                                    # vista assente
```

Esito: `Clip.php` rimosso il 21/09/2026 (file untracked), `_components.json` → `[]`, directory `Card/Video/` eliminata. Modulo senza classi Livewire HTTP.

## UX

_Fonte: `bmad/livewire-widget-ux.md`_

# UX

Nessun impatto: Clip non era montato in nessuna interfaccia viva (verifica in [livewire-inventory.md](./livewire-inventory.md)); la rimozione del file non cambia nulla per l'utente.
