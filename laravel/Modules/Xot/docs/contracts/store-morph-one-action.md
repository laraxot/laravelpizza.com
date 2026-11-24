---
title: "MorphOneAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\MorphOneAction"
qmd: "Store MorphOneAction morphOne update create figlio esiste"
---

# MorphOneAction

Crea o aggiorna il figlio di una `morphOne`. Codice: `app/Actions/Model/Store/MorphOneAction.php` (classe a riga 19, `execute()` a riga 19).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` deve essere `MorphOne`; `data` sono gli attributi.

## Output

- `void`.

## Invarianti

- `STORE-MORPH-ONE-INV-1` — Se la relazione ha già un figlio, si chiama `update(data)`; altrimenti `create(data)`. Test: nessuno.

## Effetti collaterali

Un `UPDATE` o un `INSERT` del figlio. Nessuna transazione.

## Errori

- `InvalidArgumentException` se `rows` non è `MorphOne`.

## Non fa

- Non imposta `lang` (a differenza di `Update/MorphOneAction`).
- Non filtra i valori `null`.
