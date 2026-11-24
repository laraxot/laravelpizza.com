---
title: "GetModelFieldsByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetModelFieldsByModelAction"
qmd: "GetModelFieldsByModelAction colonne tabella modello getColumnListing schema"
---

# GetModelFieldsByModelAction

Restituisce i nomi delle colonne della tabella del modello. Codice: `app/Actions/Model/GetModelFieldsByModelAction.php`.

## Input

- `Model $model`: il modello di cui leggere la tabella.

## Output

- `list<string>`: nomi delle colonne, come ritornati dallo schema builder.

## Invarianti

- `GET-MODEL-FIELDS-INV-1` — La lista è quella di `getColumnListing()` sulla tabella del modello, usando la connessione dell'istanza. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Una query allo schema del database a ogni chiamata, senza cache.

## Errori

- Le eccezioni del database si propagano. Il comportamento su tabella inesistente dipende dal driver: non verificato.

## Non fa

- Non filtra colonne (es. `id`, `deleted_at`) e non include gli attributi calcolati.
