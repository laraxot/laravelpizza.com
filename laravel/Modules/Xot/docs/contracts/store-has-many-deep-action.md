---
title: "HasManyDeepAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\HasManyDeepAction"
qmd: "Store HasManyDeepAction non implementato LogicException stub relazione deep"
---

# HasManyDeepAction

Stub per la creazione di una `hasManyDeep`: non implementato. Codice: `app/Actions/Model/Store/HasManyDeepAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `Model $_model`, `RelationDTO $_relationDTO`: non usati.

## Output

- Nessuno: lancia sempre.

## Invarianti

- `STORE-HMD-INV-1` — Lancia sempre `\LogicException('Store\HasManyDeepAction not implemented')`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- `\LogicException` sempre.

## Non fa

- Non scrive. Se `StoreAction` incontra questa relazione, il padre è già salvato quando l'eccezione arriva (nessuna transazione).
