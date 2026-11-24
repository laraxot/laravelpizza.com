---
title: "Story: No standalone Livewire, usare Filament widget"
type: story
status: accepted
created: 2026-11-23
updated: 2026-11-23
epic: "Xot UI governance"
issues: []
discussions: []
related:
  - docs/wiki/rules/no-standalone-livewire-classes.md
---

# Story: No standalone Livewire, usare Filament widget

## Descrizione

Aggiungere un ADR che vieta l'uso di componenti Livewire standalone in tutti i moduli Xot e verticale, costringendo ogni nuova superficie UI a essere implementata con le basi Filament di Xot (`XotBaseWidget`, `XotBaseWizardWidget`, `XotBaseSection`, ecc.).

## Obiettivo

- Centralizzare le regole UI in Xot;
- Rendere verificabile l'assenza di Livewire standalone tramite audit;
- Allineare il tema Sixteen e le pagine Folio al pattern thin-shell.

## Scope

- In scope: nuovo codice UI in tutti i moduli; ADR 0008 in `laravel/Modules/Xot/docs/adr/`.
- Out of scope: migrazione dei widget Livewire esistenti (debt tecnico separato).

## Conferma

- ADR 0008 creato e linkato nell'indice `README.md` del modulo Xot;
- Regola esistente `docs/wiki/rules/no-standalone-livewire-classes.md` confermata e non in conflitto;
- Revisione del codice per assenza di `class extends Livewire\Component` fuori dai moduli autorizzati;
- Test architetturali del modulo verificano l'assenza di nuove classi Livewire standalone.

## GitHub (tracciamento)

- Issue: DA CREARE sul repo `laraxot/module_xot_fila5`
- Comando: `gh issue create --title "ADR 0008: No standalone Livewire, usare Filament widget" --body "Vedi ADR in laravel/Modules/Xot/docs/adr/filament-widgets-over-standalone-livewire.md"`
