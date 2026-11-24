---
qmd: "ui stories phpstan cleanup ui story md"
title: "[STORY] PHPStan cleanup — UI"
type: story
module: UI
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, ui]
---

# [STORY] PHPStan cleanup — UI

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo UI. Errori di partenza: 6 `constantTypeCoverage` (colonne Filament), 1 `assign.redundant` (InlineDatePicker), 1 `variable.unused` (GroupColumnTest).

## Analysis

**Scopo del codice.** UI contiene componenti Filament/Blade di presentazione. Le sei colonne (`AddressColumn`, `EventColumn`, `OpeningHoursColumn`,
`OrganizationColumn`, `PersonColumn`, `SortableIdColumn`) hanno `DEFAULT_NAME`, il nome di default della colonna quando si usa `::make()` senza argomenti:
configurazione, non un insieme di valori => `protected const string DEFAULT_NAME`.

**`InlineDatePicker::generateCalendarData()`** costruisce la griglia mensile e segna il giorno selezionato. Per ognuno dei ~42 giorni risolveva lo stato del campo
con `getState()` in un `try/catch` e inizializzava `$isSelected = false` due volte (la seconda, nel `catch`, era la ridondanza segnalata).
Ora la data selezionata si risolve **una volta** (`getSelectedDate(): ?Carbon`, errori di stato/parse -> nessun giorno selezionato, stesso comportamento) e il giorno
e' selezionato con `$selectedDate?->isSameDay($currentDay) ?? false`.

**`GroupColumnTest`** (`renders direct attribute values`): `$fields` (le colonne figlie) non era usato e il test verificava solo `data_get()` su un oggetto.
Ora ogni campo risolve il proprio valore dal record tramite `getName()`, che e' quello che fa il template `group.blade.php`.

## Acceptance Criteria

- [x] `DEFAULT_NAME` tipizzato in tutte le colonne segnalate
- [x] `InlineDatePicker` senza assegnazione ridondante e con una sola lettura dello stato per render
- [x] `GroupColumnTest` usa i campi dichiarati
- [x] PHPStan: 0 errori sul modulo UI (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-ui.dev.md](./2026-10-06-phpstan-cleanup-ui.dev.md)
