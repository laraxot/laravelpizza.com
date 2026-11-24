---
title: "MorphedByManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\MorphedByManyAction"
qmd: "Store MorphedByManyAction morphedByMany non implementato LogicException stub"
---

# MorphedByManyAction

Stub per la creazione di una `morphedByMany`: non implementato. Codice: `app/Actions/Model/Store/MorphedByManyAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `STORE-MORPHED-BY-INV-1` — Lancia sempre `\LogicException('Store\MorphedByManyAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive.
