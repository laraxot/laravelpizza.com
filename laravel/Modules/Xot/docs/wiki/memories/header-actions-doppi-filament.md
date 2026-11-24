---
title: "Doppi header actions in ogni List page Xot"
type: memory
module: Xot
created: 2026-09-29
updated: 2026-09-29
tags: [filament, ui, ux, list-page, header-actions, difetto]
qmd: "doppio create action list page filament header actions page header table header"
issues: []
discussions: []
related:
  - "./tabella-appartiene-alla-resource-non-alla-pagina.md"
---

# Doppi header actions in ogni List page Xot

> **SUMMARY** — `getHeaderActions()` (page header) e `getTableHeaderActions()` (table header)
> sono **due barre distinte** ed entrambe renderizzate. In Xot entrambe mettono un
> `CreateAction`, quindi ogni schermata di lista mostra **due pulsanti "Crea"**. Difetto
> **preesistente**, trovato il 2026-09-29 durante la story 5.254, **non ancora risolto**.

## Le due barre sono distinte

| | Page header | Table header |
|---|---|---|
| Metodo | `getHeaderActions()` (protected) | `getTableHeaderActions()` (**public**) |
| Trait | `InteractsWithHeaderActions` — `vendor/filament/filament/src/Pages/Concerns/InteractsWithHeaderActions.php` | `HasXotTable` — `Modules/Xot/app/Filament/Traits/HasXotTable.php:87` |
| Chi lo chiama | `cacheInteractsWithHeaderActions()` → `getCachedHeaderActions()` | `HasXotTable::table()` riga 253: `->headerActions($this->getTableHeaderActions())` |
| Dove si vede | barra in alto della pagina | `vendor/filament/tables/resources/views/index.blade.php:315-319` |

`getTableHeaderActions()` **deve essere public**: lo chiama Filament/Livewire dall'esterno
(`Modules/Xot/docs/filament/widget-method-visibility-rules.md`).

## I due `CreateAction` di default

- `XotBaseListRecords::getHeaderActions()` (`Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php:70`)
  → `['create' => CreateAction::make()->icon('heroicon-o-plus')]`
- `HasXotTable::getTableHeaderActions()` riga 101 → `$actions = [CreateAction::make()]`

Risultato: **due pulsanti Crea** in ogni schermata di lista. Su
`CriteriEsclusioneResource` e `CriteriOptionResource` si aggiunge **anche**
`CopyFromLastYearAction` due volte, perché sia `BaseListCriteriEsclusiones::getHeaderActions()`
/ `BaseListCriteriOptions::getHeaderActions()` sia
`BaseCriteriEsclusionesTable::getTableHeaderActions()` / `CriteriOptionsTable::getTableHeaderActions()`
lo dichiarano.

## Perché non l'ho risolto dentro la story 5.254

La scelta "quale dei due header sopravvive" è una **decisione di design** che riguarda
**tutte** le List page di tutti i moduli, non le 6 di Ptv. Rimuovere `getHeaderActions()` dal
trait cambierebbe il layout di ogni schermata; rimuovere `getTableHeaderActions()` farebbe
perdere l'`AssociateAction`/`AttachAction`/`TableLayoutToggleTableAction` che il trait aggiunge
alle righe 104-107. Serve discussione, non una rimozione silenziosa.

La candidate naturale: **il table header** (`getTableHeaderActions()`), perché è lì che vivono
`AssociateAction`, `AttachAction` e il toggle di layout, ed è il posto dove Filament 5 si aspetta
le azioni di contesto della tabella. Ma va deciso con l'utenza aperta.

## Cosa NON fare

- **NON** rimuovere `getHeaderActions()` senza togliere anche quello del trait: si sposta solo
  il duplicato.
- **NON** assumere che `getTableHeaderActions()` sia "quello vecchio": è public per un motivo
  preciso documentato nel docblock del trait.
