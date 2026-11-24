---
title: "TableExistsByModelClassActions — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\TableExistsByModelClassActions"
qmd: "TableExistsByModelClassActions tabella esiste modello Sushi hasTable connessione"
---

# TableExistsByModelClassActions

Dice se esiste la tabella di un modello. I modelli Sushi sono considerati sempre con tabella. Codice: `app/Actions/Model/TableExistsByModelClassActions.php` (classe a riga 15, `execute()` a riga 13). Il nome della classe termina con `Actions` (plurale): è l'identificatore reale, da non correggere in questo passaggio.

## Input

- `string $modelClass`: FQCN.

## Output

- `bool`.

## Invarianti

- `TABLE-EXISTS-INV-1` — Classe inesistente: `false`. Test: nessuno diretto.
- `TABLE-EXISTS-INV-2` — Modelli che usano `Sushi\Sushi` o hanno `sushiRows()`: `true` senza interrogare il database. Test: nessuno diretto.
- `TABLE-EXISTS-INV-3` — Negli altri casi: `hasTable()` sulla connessione del modello. Test: `tests/Unit/HasXotTableTest.php` (menzione).

## Effetti collaterali

Istanzia il modello con `app()`. Una query allo schema nel caso non Sushi.

## Errori

- `InvalidArgumentException` se `app()` non restituisce un Eloquent `Model`.

## Non fa

- Non crea la tabella.
