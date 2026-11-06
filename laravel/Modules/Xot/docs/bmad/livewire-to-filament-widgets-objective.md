---
title: "Obiettivo: eliminazione dei custom Livewire UI"
type: objective
module: Xot
status: approved-ready-for-dev
created: 2026-10-20
updated: 2026-10-20
related:
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./livewire-to-filament-widgets-architecture.md
  - ./livewire-to-filament-widgets-filament-blueprint.md
  - ./livewire-widget-advantages.md
  - ./livewire-widget-decision-log.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
  - ../../../../../bashscripts/docs/prompts/05-livewire-to-filament-widgets.md
tags: [docs, xot, bmad]
qmd: "obiettivo xot"
---

# Obiettivo

Ritirare i componenti Livewire custom usati come UI applicativa e sostituirli
con widget Filament coerenti con `XotBase*`, mantenendo invariati scopo,
autorizzazioni, tenancy, traduzioni, stato utile e comportamento osservabile.

## Confine semantico

“Niente più Livewire” significa niente nuovi componenti applicativi custom sotto
`app/Http/Livewire` e niente alias Livewire per UI che dovrebbe appartenere al
panel. Non significa rimuovere Livewire dal runtime: ogni Filament Widget è
comunque un componente Livewire e Filament continua a usare Livewire
internamente.

## Risultato misurabile

- ogni classe custom è inventariata con caller, scopo e destinazione;
- ogni candidato panel/dashboard diventa `XotBaseWidget` o una sua variante;
- ogni responsabilità CRUD resta a Resource/Page/Action;
- ogni UI front-office viene portata a widget solo se il suo contratto è
  realmente quello di un widget, altrimenti segue il confine Folio/Volt/Blade
  stabilito dal modulo;
- nessun componente o test viene cancellato senza prova di assenza dei caller;
- PHPStan, Pint, test mirati e smoke UI sono gate per ogni wave.

## Fuori scope

Non inventare KPI, non convertire automaticamente View Components, non
riscrivere Filament/Livewire vendor, non aggiungere dipendenze e non fare uno
spostamento massivo dei docs dei moduli o dei temi.
