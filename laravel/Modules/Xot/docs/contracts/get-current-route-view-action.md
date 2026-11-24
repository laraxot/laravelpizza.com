---
title: "GetCurrentRouteViewAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetCurrentRouteViewAction"
qmd: "GetCurrentRouteViewAction vista punto notazione controller parametri route container Module Item"
---

# GetCurrentRouteViewAction

Costruisce un nome di vista in notazione puntata dal controller della route corrente, sostituendo i segmenti con i parametri della route. Codice: `app/Actions/Route/GetCurrentRouteViewAction.php`.

## Input

- Nessuno. Legge handler e parametri della route corrente.

## Output

- `string`: segmenti del controller in snake_case separati da `.`, senza `Module` e `Item`; un segmento è sostituito dal valore del parametro di route omonimo, se scalare.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-VIEW-INV-1` | I segmenti `Module` e `Item` non compaiono nel risultato. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |
| `ROUTE-VIEW-INV-2` | Un segmento con parametro di route omonimo prende il valore del parametro. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |
| `ROUTE-VIEW-INV-3` | Il valore `containers` è la concatenazione dei parametri `container*`; è usato solo se un segmento si chiama `containers`. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- `RuntimeException` se la route non ha controller.

## Non fa

- Non verifica che la vista esista.
