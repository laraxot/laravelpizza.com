---
title: "GenerateTableColumnsByFileAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GenerateTableColumnsByFileAction"
qmd: "GenerateTableColumnsByFileAction riscrive file Resource colonne schema TODO filtro anno distruttivo GetYearFilter WIP"
---

# GenerateTableColumnsByFileAction

Riscrive il sorgente di una Resource Filament: sostituisce il contenuto di `columns()` e `schema()` con segnaposto `TODO` e, se il modello ha `anno`, inserisce un filtro anno. Marcata WIP.

Codice: `app/Actions/Filament/GenerateTableColumnsByFileAction.php:22-108`.

## Input

- `SplFileInfo $file`: file della Resource (`.php`).

## Output

`void`. Effetto principale: riscrittura del file.

## Invarianti

- `FIL-GENTABLE-INV-1`: un file non esistente o non `.php` non viene toccato (righe 38-43). Test: tests/Unit/XotCommandsActionsHundredCoverageTest.php:26-34.
- `FIL-GENTABLE-INV-2`: il file della Resource è riscritto due volte: il contenuto di `->columns(...)` in `table()` e di `->schema(...)` in `form()` è sostituito da segnaposto `// TODO` (righe 74-86, 88-89 con i `LaravelFile::put` alle righe 79 e 86). Test: tests/Unit/XotExecuteCoverage50Test.php:937 (copertura del percorso; il contenuto riscritto non è verificato).
- `FIL-GENTABLE-INV-3`: se il modello ha `anno` in fillable, `->filters(...)` in `table()` è sostituito con `GetYearFilter` dal 3° anno precedente all'anno corrente, con `persistFiltersInSession` (righe 94-104). Test: Nessun test dedicato.

## Effetti collaterali

DISTRUTTIVO: scrive il file della Resource senza backup. Il contenuto preesistente di colonne, schema e filtri è sostituito dai segnaposto. Il docblock e il nome non lo segnalano.

## Errori

Eccezioni di `Assert` e di lettura file si propagano.

## Non fa

- Non genera colonne né schema: produce segnaposto.
- Il range di anni è relativo alla data di esecuzione.
- Il trait `CanReadModelSchemas` è importato ma non usato per la scrittura.
- Da non eseguire su Resource reali senza backup. Segnalato come rischio nel report.
