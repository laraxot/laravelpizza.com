---
title: "HasManyDeepAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\HasManyDeepAction"
qmd: "Update HasManyDeepAction non implementato LogicException stub"
---

# HasManyDeepAction

Stub per l'aggiornamento di una `hasManyDeep`: non implementato. Codice: `app/Actions/Model/Update/HasManyDeepAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `UPDATE-HMD-INV-1` — Lancia sempre `\LogicException('Update\HasManyDeepAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive.
