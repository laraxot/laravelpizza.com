---
title: ListSnapshots, tabella nella Table class e non nella List page
status: done
module: Activity (owner)
created: 2026-11-04
related:
  - ../../../Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md
---

# ListSnapshots, tabella nella Table class e non nella List page

## Fase BMAD

Bugfix (blocca Pest e PHPStan di tutta la suite). Claim: sessione `setting-page-tutti-i-moduli`,
2026-11-04. Chi lavora su `Activity/app/Filament/Resources/SnapshotResource` sospenda le modifiche
a questi file fino a `status: done`.

## Problema

`ListSnapshots extends XotBaseListRecords` dichiarava `getTableColumns()`, `getTableFilters()`,
`getTableActions()`, `getTableBulkActions()`. La base li dichiara `final` (vedi
`Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`). Risultato: `PHP Fatal error: Cannot override
final method` al caricamento della classe, che blocca ogni run di Pest e PHPStan sul monorepo.

## Regola (gia' nel progetto)

La tabella si costruisce nella `*Table` class (`XotBaseResourceTable`). La List page non dichiara
metodi di tabella. Esempio: `Activity/.../ActivityResource/Tables/ActivitiesTable.php` e
`Xot/.../ExtraResource/Tables/ExtrasTable.php`.

## Intervento

- `SnapshotsTable`: aggiunti `getTableFilters()` (SelectFilter `aggregate_type`),
  `getTableActions()` (view, edit, delete), `getTableBulkActions()` (delete). Colonne gia' presenti.
- `ListSnapshots`: rimossi i quattro override. Resta `$resource` e la classe base.

## Verifica

- Guardie gia' in Xot: `tests/Unit/ListPageHasTableClassTest.php`.
- Pest della suite, PHPStan livello 10 sui file toccati, Pint.

## Esteso 2026-11-04: StoredEvents

Stessa violazione in `StoredEventResource/Pages/ListStoredEvents.php` (override `final` di
`getTableColumns()`). Colonne spostate in `StoredEventsTable`, con `event_properties` come
`ViewColumn` (vista `activity::filament.tables.columns.event-properties`, attributo reale del
modello). La colonna `properties` della Table non corrispondeva a nessun attributo: rimossa.

## Esito

- `ListPageHasTableClassTest` (Xot): verde.
- `EveryModuleHasSettingPageTest` + test di convenzione: 76 passati.
