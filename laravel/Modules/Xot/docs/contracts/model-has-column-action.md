---
title: "ModelHasColumnAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\ModelHasColumnAction"
qmd: "ModelHasColumnAction colonna cache statica processo connessione tabella Filament HasXotTable"
---

# ModelHasColumnAction

Dice se la tabella di un modello ha una colonna, con cache statica per processo. Codice: `app/Actions/Model/ModelHasColumnAction.php`.

## Input

- `Model|string|null $model`: istanza, FQCN o `null`.
- `string $column`: nome colonna.

## Output

- `bool`.

## Invarianti

- `MODEL-HAS-COLUMN-INV-1` — `null` o un valore che non è un `Model` (anche per FQCN non Eloquent) danno `false`, senza eccezione. Prova: `execute()`. Test: `tests/Unit/Actions/ModelHasColumnActionTest.php`.
- `MODEL-HAS-COLUMN-INV-2` — La chiave di cache è `connessione.tabella.colonna`; il risultato è memorizzato alla prima lettura e riusato per tutta la vita del processo. Prova: `execute()`. Test: `tests/Unit/Actions/ModelHasColumnActionTest.php`.
- `MODEL-HAS-COLUMN-INV-3` — Con una stringa FQCN il modello è istanziato con `new` (costruttore incluso, nessuna query). Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Al primo accesso per chiave, una query allo schema. Scrittura nella cache statica del processo. Nessun'altra scrittura.

## Errori

- Le eccezioni del database si propagano.

## Non fa

- Non invalida la cache dopo una migrazione: in processi di lunga durata (worker di coda, Octane) un valore può restare stale fino al riavvio. Dubbio da verificare sull'uso reale.
