---
title: "PivotAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\PivotAction"
qmd: "Store PivotAction pivot non implementato LogicException updateExistingPivot"
---

# PivotAction

Stub per la creazione di dati pivot: non implementato. Codice: `app/Actions/Model/Store/PivotAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `STORE-PIVOT-INV-1` — Lancia sempre `\LogicException('Store\PivotAction not implemented')`. Test: nessuno (la menzione in `tests/Unit/NoDebugCallsInModuleAppCodeTest.php` non è un test di questa classe).

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive. Il codice commentato nel corpo mostra un'idea di `updateExistingPivot`, mai attivata.
