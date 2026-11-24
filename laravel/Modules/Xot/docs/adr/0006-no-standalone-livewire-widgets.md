---
title: "ADR — Nessun Livewire standalone: usare Filament Widget"
type: decision
status: superseded by 0008-filament-widgets-over-standalone-livewire.md
module: Xot
created: 2026-11-23
updated: 2026-11-24
superseded_by: 0008-filament-widgets-over-standalone-livewire.md
---

> Superseded da [0008-filament-widgets-over-standalone-livewire.md](0008-filament-widgets-over-standalone-livewire.md): stessa decisione (nessun Livewire standalone, usare Filament Widget), consolidata nel canonico 0008. Nessuna decisione nuova: il canonico prevale, questo file non va esteso.

# Nessun Livewire standalone: usare Filament Widget

## Contesto

Filament utilizza Livewire internamente, ma un componente Livewire autonomo nei
moduli crea una seconda superficie di autodiscovery e di gestione dello stato.
Questo porta a duplicazione di form, validazione, autorizzazione e lifecycle.

## Driver della decisione

- una sola superficie interattiva governata da Filament;
- integrazione nativa con schema, Policy, pannelli e test Pest;
- basi Xot riusabili per mantenere coerenti tutti i moduli;
- codice nuovo più semplice da scoprire e mantenere.

## Decisione

Il codice nuovo e le migrazioni dei componenti interattivi usano i Filament
Widget, preferibilmente `XotBaseWidget`, `XotBaseSchemaWidget` o le altre basi
Filament di Xot. Non si introducono componenti Livewire standalone in
`Modules/*/app/Http/Livewire` o equivalenti come superficie primaria.

La decisione non elimina la dipendenza tecnica da Livewire: un Filament Widget
è un componente Livewire sotto il cofano. Viene vietata la superficie autonoma,
non il runtime necessario a Filament.

## Alternative scartate

- Un componente Livewire dedicato per ogni interazione: duplica il lifecycle e
  frammenta autorizzazione e test.
- Blade con stato JavaScript ad hoc: perde integrazione con form e Policy.
- Rimozione completa di Livewire: incompatibile con il modello interattivo di
  Filament.

## Conseguenze

- Il codice nuovo vive in `Filament/Widgets` del modulo owner.
- I residui legacy senza consumer restano debito esplicito e si ritirano con
  una story BMAD, senza creare nuovi gemelli.
- I test verificano il Widget e il suo schema, non un componente Livewire
  autonomo.

## Conferma

- [Story di migrazione Livewire → Filament Widget](../stories/adr-0006-no-standalone-livewire-widgets.story.md)
- `Modules/Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php`
- `Modules/User/tests/Unit/Filament/Widgets/Auth/AuthSchemaDelegationContractTest.php`
