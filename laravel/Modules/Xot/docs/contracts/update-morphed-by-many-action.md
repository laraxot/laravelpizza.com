---
title: "MorphedByManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\MorphedByManyAction"
qmd: "Update MorphedByManyAction morphedByMany non implementato LogicException stub"
---

# MorphedByManyAction

Stub per l'aggiornamento di una `morphedByMany`: non implementato. Codice: `app/Actions/Model/Update/MorphedByManyAction.php` (classe a riga 15, `execute()` a riga 18).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `UPDATE-MORPHED-BY-INV-1` — Lancia sempre `\LogicException('Update\MorphedByManyAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive.
