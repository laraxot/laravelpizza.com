---
title: "MorphOneAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\MorphOneAction"
qmd: "Update MorphOneAction morphOne aggiorna crea lang locale filtra null"
---

# MorphOneAction

Aggiorna o crea il figlio di una `morphOne`, impostando `lang` e scartando i valori `null`. Codice: `app/Actions/Model/Update/MorphOneAction.php` (classe a riga 21, `execute()` a riga 32).

## Input

- `Model $model`: il padre.
- `RelationDTO $relationDTO`: `name` è il nome della relazione, `data` gli attributi.

## Output

- `void`.

## Invarianti

- `UPDATE-MORPH-ONE-INV-1` — `lang` mancante è impostato alla locale corrente. Test: nessuno.
- `UPDATE-MORPH-ONE-INV-2` — I valori `null` sono rimossi dai dati prima della scrittura: non è possibile azzerare un campo a `null` con questo percorso. Test: nessuno.
- `UPDATE-MORPH-ONE-INV-3` — Se il figlio esiste: `update()`; altrimenti `create()`. Test: nessuno.

## Effetti collaterali

`UPDATE` o `INSERT` del figlio. Nessuna transazione.

## Errori

- `InvalidArgumentException` se la relazione non è `MorphOne`.

## Non fa

- Non cancella il figlio.
