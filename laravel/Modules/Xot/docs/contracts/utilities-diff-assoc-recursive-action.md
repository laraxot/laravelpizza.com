---
title: "DiffAssocRecursiveAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Utilities\\DiffAssocRecursiveAction"
qmd: "DiffAssocRecursiveAction differenza array fixType sotto-array confronto lasco in_array chiavi conservate"
---

# DiffAssocRecursiveAction

Restituisce gli elementi di primo livello di `$arr_1` che non compaiono in `$arr_2`. Codice: `app/Actions/Arr/DiffAssocRecursiveAction.php`.

## Input

- `array<int|string, mixed> $arr_1`: array da filtrare (`execute()`).
- `array<int|string, mixed> $arr_2`: array di confronto (`execute()`).

## Output

- `array<int|string, array<int|string, mixed>>`: sotto-array di `$arr_1` non presenti in `$arr_2`, con le chiavi originali (`execute()`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-DIFF-INV-1` | `fixType()` (statico, pubblico) richiede che ogni elemento di primo livello sia un array, altrimenti lancia `\Exception`; gli elementi numerici sono castati con `*= 1`. | `execute()` | `tests/Unit/Actions/ArrayArrActionsTest.php:28,43` |
| `ARR-DIFF-INV-2` | Il filtro usa `in_array` con confronto lasco (non strict) sui sotto-array interi di `$arr_2`. | `execute()` | `tests/Unit/Actions/ArrayArrActionsTest.php` |
| `ARR-DIFF-INV-3` | Il confronto avviene tra sotto-array interi: non c'è differenza per chiave né ricorsione. | `execute()` | Test: nessuno |

## Effetti collaterali

Nessuno. Calcolo in memoria; nessuna scrittura né servizio esterno.

## Errori

- `\Exception` da `fixType()` quando un elemento di primo livello non è un array (`execute()`).
- Il `catch` in `execute()` rilancia l'eccezione senza modificarla (`execute()`): no-op.

## Non fa

- Non esegue un diff ricorsivo per chiave, nonostante il nome `AssocRecursive`: il nome non corrisponde al comportamento.
- Il docblock della classe è il segnaposto `---.`: nessuna descrizione funzionale nel codice.

