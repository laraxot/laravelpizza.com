---
title: "Correggere gli hook tabella della lista snapshot"
status: done
module: Activity (owner), Xot
created: 2026-11-04
updated: 2026-11-04
type: story
qmd: "Activity ListSnapshots XotBaseListRecords final getTableColumns SnapshotsTable hooks bootstrap Pest"
related:
  - ../../../Xot/docs/bmad/stories/setting-page-tutti-i-moduli.story.md
---

# Correggere gli hook tabella della lista snapshot

## Contesto

La verifica Pest della story SettingPage è bloccata dal caricamento delle pagine List:
`ListSnapshots` e `ListStoredEvents` dichiarano hook tabella `final` su `XotBaseListRecords`.
Le tabelle sono delegate alle classi `*Table.php` tramite il contratto Xot.

## Claim

| Agente | File | Stato |
|---|---|---|
| `/root/activity_table_fix` | SnapshotResource Pages/Table, StoredEventResource Pages/Table | done: PHPStan e Pest mirati verdi |

## Acceptance criteria

- [x] Le pagine Snapshot e StoredEvent non ridichiarano hook tabella final/deprecati.
- [x] Colonne e filtri personalizzati vivono nelle rispettive classi `*Table`; le azioni
      standard sono fornite da `HasXotTable`, che applica le policy delle Resource.
- [x] Il bootstrap Pest non si arresta più sul fatal `Cannot override final method`.
- [x] PHPStan e Pest mirato verificati.

## File

- `app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php`
- `app/Filament/Resources/SnapshotResource/Tables/SnapshotsTable.php`
- `app/Filament/Resources/StoredEventResource/Pages/ListStoredEvents.php`
- `app/Filament/Resources/StoredEventResource/Tables/StoredEventsTable.php`

## Verifica finale

- `rg` sulle pagine List di Activity: nessun hook `getTableColumns`, `getTableFilters`,
  `getTableActions`, `getTableBulkActions` sovrascritto.
- `php -l`: 4/4 file OK.
- Pint: 4/4 file OK.
- PHPStan level max mirato: 0 errori sui 4 file.
- Pest `EveryModuleHasSettingPageTest`: 72 test passati, 108 assertion.
- Pest `ListPageHasTableClassTest`: 1 test passato, 1 assertion.
