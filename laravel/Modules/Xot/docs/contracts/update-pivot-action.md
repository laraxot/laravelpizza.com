---
title: "PivotAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\PivotAction"
qmd: "Update PivotAction pivot non implementato LogicException stub"
---

# PivotAction

Stub per l'aggiornamento dei dati pivot: non implementato. Codice: `app/Actions/Model/Update/PivotAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `UPDATE-PIVOT-INV-1` — Lancia sempre `\LogicException('Update\PivotAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive.
