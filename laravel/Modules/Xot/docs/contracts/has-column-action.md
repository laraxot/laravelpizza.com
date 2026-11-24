---
title: "HasColumnAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\HasColumnAction"
qmd: "HasColumnAction colonna esiste tabella modello hasColumn schema senza cache"
---

# HasColumnAction

Verifica se la tabella del modello ha una colonna, leggendo lo schema a ogni chiamata. Codice: `app/Actions/Model/HasColumnAction.php`.

## Input

- `Model $model`: il modello (connessione e tabella).
- `string $column`: nome colonna.

## Output

- `bool`.

## Invarianti

- `HAS-COLUMN-INV-1` — Il risultato è `hasColumn(tabella, colonna)` sulla connessione del modello (`null` = connessione di default). Prova: `execute()`. Test: `tests/Unit/Actions/Model/HasColumnActionTest.php`.

## Effetti collaterali

Una query allo schema per chiamata. Nessuna cache.

## Errori

- Le eccezioni del database si propagano.

## Non fa

- Non cachea: per il caso con cache per processo vedi `ModelHasColumnAction`.
