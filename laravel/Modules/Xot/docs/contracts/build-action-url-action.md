---
title: "BuildActionUrlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\BuildActionUrlAction"
qmd: "BuildActionUrlAction URL azione route corrente sostituisce ultimo segmento nome route fallback hash"
---

# BuildActionUrlAction

Costruisce l'URL di un'azione sulla route corrente, sostituendo l'ultimo segmento del nome route con l'azione richiesta. Codice: `app/Actions/Route/BuildActionUrlAction.php`.

## Input

- `array $params`: `act` (default `show`), `query` (array, default `[]`), `row` (parametro posizionale opzionale).

## Output

- `string`: URL generato, oppure `'#'.<azione>` / `'#'.<route target>` come segnaposto.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-ACTURL-INV-1` | Senza route corrente con nome restituisce `'#'.$action`. | `tests/Unit/Actions/Route/BuildActionUrlActionTest.php` (riferisce la classe) |
| `ROUTE-ACTURL-INV-2` | Se la route di destinazione non è registrata restituisce `'#'.<target>`. | `tests/Unit/Actions/Route/BuildActionUrlActionTest.php` (riferisce la classe) |
| `ROUTE-ACTURL-INV-3` | Altrimenti genera l'URL con i parametri della route corrente, la riga e la query. | `tests/Unit/XotExplicitZeroKillersTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno. Solo generazione di URL.

## Errori

- `route()` lancia `UrlGenerationException` se mancano parametri richiesti.

## Non fa

- Non fa escape dei valori della query.
- I segnaposto `#...` non sono URL validi: il chiamante deve gestirli.
