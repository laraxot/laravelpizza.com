---
title: "MorphToManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\MorphToManyAction"
qmd: "Store MorphToManyAction morphToMany sync pivot associativo non implementato"
---

# MorphToManyAction

Sincronizza la relazione `morphToMany` con una lista di id. Codice: `app/Actions/Model/Store/MorphToManyAction.php` (classe a riga 18, `execute()` a riga 18).

## Input

- `Model $model`: non usato nel corpo.
- `RelationDTO $relationDTO`: `rows` deve essere `MorphToMany`; `data` è una lista di id, oppure un array con `to`/`from`.

## Output

- `void`.

## Invarianti

- `STORE-MORPH-TO-MANY-INV-1` — Se `data` ha `to` o `from`, si usa `data['to']` (default `[]`). Test: nessuno.
- `STORE-MORPH-TO-MANY-INV-2` — Se il risultato non è associativo, si chiama `sync()`. Test: nessuno.
- `STORE-MORPH-TO-MANY-INV-3` — Se è associativo (dati pivot), lancia `\LogicException`: il ramo non è implementato. Test: nessuno.

## Effetti collaterali

`sync()` sulla tabella pivot: rimuove le righe non presenti.

## Errori

- `\LogicException` per i dati pivot associativi.
- `InvalidArgumentException` se `rows` non è `MorphToMany` o il dato non è un array.

## Non fa

- Non gestisce attributi pivot. Dubbio: con soli `from` il risultato è `sync([])`, cioè svuota la relazione. Non verificato.
