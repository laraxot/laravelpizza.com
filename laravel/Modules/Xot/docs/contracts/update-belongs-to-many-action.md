---
title: "BelongsToManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\BelongsToManyAction"
qmd: "Update BelongsToManyAction molti a molti sync syncWithoutDetaching aggiorna correlati to from"
---

# BelongsToManyAction

Aggiorna una `belongsToMany`: con `to`/`from` sincronizza gli id; altrimenti aggiorna ogni correlato per chiave e ne collega gli id senza staccare gli altri. Codice: `app/Actions/Model/Update/BelongsToManyAction.php` (classe a riga 19, `execute()` a riga 19).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` è `BelongsToMany`; `data` è un array di `to`/`from` oppure una lista di array con la chiave primaria.

## Output

- `void`.

## Invarianti

- `UPDATE-BTM-INV-1` — Con `to` o `from`: `sync()` sugli id di `to` (valori scalari verificati), flash `status`. Test: nessuno.
- `UPDATE-BTM-INV-2` — Altrimenti: ogni elemento deve essere un array con la chiave primaria; viene aggiornato con `UpdateAction` e il suo id raccolto. Un elemento senza chiave lancia `RuntimeException`. Test: nessuno.
- `UPDATE-BTM-INV-3` — Gli id raccolti sono collegati con `syncWithoutDetaching()`: i collegamenti esistenti restano. Test: nessuno.

## Effetti collaterali

`sync` o `syncWithoutDetaching` sulla pivot; `UPDATE` o `INSERT` dei correlati tramite `UpdateAction`; flash in sessione nel primo ramo. Nessuna transazione: un errore a metà lascia scritture parziali.

## Errori

- `RuntimeException` per elementi senza chiave o per errori di `syncWithoutDetaching` (ricavato con `catch` generico).
- `InvalidArgumentException` per asserzioni su tipi.

## Non fa

- Non rimuove collegamenti nel ramo senza `to`/`from`.
