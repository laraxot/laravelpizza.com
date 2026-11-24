---
title: "HasManyThroughAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\HasManyThroughAction"
qmd: "Update HasManyThroughAction non implementato LogicException stub hasManyThrough"
---

# HasManyThroughAction

Stub per l'aggiornamento di una `hasManyThrough`: non implementato. Codice: `app/Actions/Model/Update/HasManyThroughAction.php` (classe a riga 15, `execute()` a riga 18).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `UPDATE-HMT-INV-1` — Lancia sempre `\LogicException('Update\HasManyThroughAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive.
