---
title: "HasManyThroughAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\HasManyThroughAction"
qmd: "Store HasManyThroughAction non implementato LogicException stub hasManyThrough"
---

# HasManyThroughAction

Stub per la creazione di una `hasManyThrough`: non implementato. Codice: `app/Actions/Model/Store/HasManyThroughAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `STORE-HMT-INV-1` — Lancia sempre `\LogicException('Store\HasManyThroughAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive. Come per gli altri stub di Store, il padre è già salvato quando arriva l'eccezione.
