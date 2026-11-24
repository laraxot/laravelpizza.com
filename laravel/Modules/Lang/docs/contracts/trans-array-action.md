---
title: "Contratto — TransArrayAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\TransArrayAction"
qmd: "TransArrayAction traduzione elementi array transKey label underscore export Xot LANG-TRANSARR"
---

# TransArrayAction

Traduce gli elementi di un array con una chiave base, con ripiego sul valore originale. Codice: `app/Actions/TransArrayAction.php:14-97`.

## Input

- `array $array`: elementi da tradurre (le chiavi restano).
- `?string $transKey`: chiave base. `null`: solo cast a stringa.

## Output

- `array<int|string, string>`: stessa chiave di ingresso, valore stringa. Valori non stringa diventano `''`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-TRANSARR-INV-1` | Per ogni elemento prova, in ordine: `<transKey>.<item>.label`, poi `<transKey>.<item con . sostituiti da _>`, altrimenti l'elemento originale (righe 74-95). | `tests/Unit/Actions/TransArrayActionTest.php:41` (traduce se esiste), `:48` (originale se manca). |
| `LANG-TRANSARR-INV-2` | Elemento vuoto o `'0'` resta invariato, senza ricerca. | Test: nessuno. |
| `LANG-TRANSARR-INV-3` | Le chiavi dell'array in ingresso sono conservate. | `TransArrayActionTest.php:26`. |

## Effetti collaterali

- Imposta la proprieta' pubblica `$this->transKey` ad ogni chiamata: stato condiviso se l'istanza e' un singleton.

## Errori

- Nessuna eccezione propria.

## Non fa

- Differenza rispetto a `trans-collection-action`: qui la prima ricerca usa il suffisso `.label`; la versione Collection cerca la chiave diretta.
- Chiamanti verificati: `Xot/app/Exports/XotBaseExporter.php`, `Xot/app/Exports/CollectionExport.php`.
