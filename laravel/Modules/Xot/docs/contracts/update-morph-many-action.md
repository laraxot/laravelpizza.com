---
title: "MorphManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\MorphManyAction"
qmd: "Update MorphManyAction morphMany figli aggiorna saveMany morph type id non staccati"
---

# MorphManyAction

Aggiorna i figli di una `morphMany` e li riassocia al padre con `saveMany()`. Codice: `app/Actions/Model/Update/MorphManyAction.php` (classe a riga 17, `execute()` a riga 23).

## Input

- `Model $model`: il padre.
- `RelationDTO $relationDTO`: `data` è `[]` oppure una lista di figli, ciascuno con la chiave primaria.

## Output

- `void`.

## Invarianti

- `UPDATE-MORPH-MANY-INV-1` — Con `data` vuoto: `saveMany([])` sulla relazione, nessuna scrittura utile. Test: `tests/Unit/Actions/Model/Update/MorphManyActionTest.php`.
- `UPDATE-MORPH-MANY-INV-2` — Ogni figlio con chiave è aggiornato con `UpdateAction`; poi `saveMany($models)` scrive tipo e id morph sui figli. Test: `tests/Unit/Actions/Model/Update/MorphManyActionTest.php`.
- `UPDATE-MORPH-MANY-INV-3` — Un figlio senza chiave lancia `LogicException`, dopo aver già aggiornato i precedenti. Test: non verificato.

## Effetti collaterali

`UPDATE` dei figli tramite `UpdateAction`, poi `UPDATE` di tipo e id morph. Nessuna transazione.

## Errori

- `LogicException` per figli senza chiave.
- `InvalidArgumentException` se un elemento non è un array.

## Non fa

- Non stacca né cancella i figli non presenti nel payload.
