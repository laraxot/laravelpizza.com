---
title: "GetExportFileNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\GetExportFileNameAction"
qmd: "GetExportFileNameAction nome file export lista Pagina filtri tableFilters ListRecords ExportXlsAction XotBaseExportAction"
---

# GetExportFileNameAction

Costruisce il nome file (senza estensione) di un export da lista: nome della pagina più i valori scalari dei filtri.

Codice: `app/Actions/Export/GetExportFileNameAction.php:19-32`.

## Input

- `ListRecords $livewire`: la pagina lista; si leggono `tableFilters`.

## Output

`string`: `{class_basename(pagina)}-{valori filtri scalari appiattiti, uniti da -}`.

## Invarianti

- `EXP-NAME-INV-1`: i valori dei filtri sono appiattiti con `Arr::flatten`; i valori non scalari diventano stringa vuota (righe 25-28). Test: tests/Unit/Exports/GetExportFileNameActionTest.php:14.
- `EXP-NAME-INV-2`: con filtri assenti o nulli il nome è `{Pagina}-` (il separatore finale resta, perché `implode` su lista vuota dà stringa vuota) (riga 30, `tableFilters ?? []`). Test: tests/Unit/Exports/GetExportFileNameActionTest.php:29.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- Non aggiunge estensione: la aggiunge il chiamante.
- Non sanifica il nome: spazi, slash o caratteri speciali nei valori dei filtri finiscono nel nome file.
- Il docblock dichiara che è l'unico punto per i due canali export; la coerenza tra canali non è verificata da questo contract.
