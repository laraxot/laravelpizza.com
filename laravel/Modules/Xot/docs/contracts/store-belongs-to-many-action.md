---
title: "BelongsToManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\BelongsToManyAction"
qmd: "Store BelongsToManyAction molti a molti sync pivot to from collegati"
---

# BelongsToManyAction

Collega il modello ai correlati di una `belongsToMany` con `sync()`. Codice: `app/Actions/Model/Store/BelongsToManyAction.php` (classe a riga 19, `execute()` a riga 19).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` deve essere `BelongsToMany`; `data` è una lista di id oppure un array con chiave `to`/`from`.

## Output

- `void`.

## Invarianti

- `STORE-BTM-INV-1` — Se `data` ha `to` o `from`, si sincronizza `data['to']` (default `[]`) con cast a stringa, si imposta il flash `status` con gli id e si esce. Il valore di `from` non è usato. Test: nessuno.
- `STORE-BTM-INV-2` — Altrimenti si sincronizza direttamente `data`. Test: nessuno.

## Effetti collaterali

`sync()` sulla tabella pivot: rimuove le righe non presenti nel payload e inserisce le nuove. Flash in sessione nel primo ramo.

## Errori

- `InvalidArgumentException` se `rows` non è `BelongsToMany` o se `to` non è un array.

## Non fa

- Non gestisce attributi pivot nel ramo `to`/`from`.
- Il `from` è ignorato.
