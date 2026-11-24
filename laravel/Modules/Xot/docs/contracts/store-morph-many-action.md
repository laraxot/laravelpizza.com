---
title: "MorphManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\MorphManyAction"
qmd: "Store MorphManyAction morphMany non implementato LogicException stub"
---

# MorphManyAction

Stub per la creazione di una `morphMany`: non implementato. Codice: `app/Actions/Model/Store/MorphManyAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `STORE-MORPH-MANY-INV-1` — Lancia sempre `\LogicException('Store\MorphManyAction not implemented')`. Test: nessuno diretto.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive. La versione di aggiornamento è in `Update/MorphManyAction`, che è implementata.
