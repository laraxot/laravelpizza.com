---
title: "Contratto — TransCollectionAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\TransCollectionAction"
qmd: "TransCollectionAction traduzione collection transKey underscore export Xot LANG-TRANSCOL"
---

# TransCollectionAction

Versione su `Collection` di `trans-array-action`. Codice: `app/Actions/TransCollectionAction.php:14-76`.

## Input

- `Collection $collection`.
- `?string $transKey`: `null` gestito come in `trans-array-action`.

## Output

- `Collection<int|string, string>`, chiavi conservate (`map`).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-TRANSCOL-INV-1` | Prova in ordine `<transKey>.<item>` (senza `.label`), poi la forma con `_`, altrimenti l'originale (righe 54-74). | `tests/Unit/Actions/TransCollectionActionTest.php:44` (traduce se esiste), `:52` (originale se manca). |
| `LANG-TRANSCOL-INV-2` | Elemento vuoto o `'0'` resta invariato. | Test: nessuno. |

## Effetti collaterali

- Imposta `$this->transKey` ad ogni chiamata, come la versione array.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non filtra i non-stringa come fa la versione array: il cast a stringa avviene per elemento.
- Chiamanti verificati: `Xot/app/Exports/QueryExport.php`, `Xot/app/Exports/LazyCollectionExport.php`.
