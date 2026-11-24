---
title: "BuildNestedRouteNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\BuildNestedRouteNameAction"
qmd: "BuildNestedRouteNameAction nome route annidato container admin profondità azione punto"
---

# BuildNestedRouteNameAction

Costruisce il nome di una route annidata: `[admin.]container0...containerN.azione`. Codice: `app/Actions/Route/BuildNestedRouteNameAction.php`.

## Input

- `array $params`: `n` (profondità, numerica, default 0), `act` (default `show`), e i dati letti dalla funzione globale `inAdmin($params)`.

## Output

- `string`: nome route con segmenti separati da `.`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-NESTED-INV-1` | Con `n = 0` i container sono `container0`. | `tests/Unit/Actions/Route/RouteActionsTest.php` (riferisce la classe) |
| `ROUTE-NESTED-INV-2` | In admin il primo segmento è `admin`. | `tests/Unit/Actions/Route/RouteActionsTest.php` (riferisce la classe) |
| `ROUTE-NESTED-INV-3` | Il nome termina sempre con l'azione. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Con `n` negativo il ciclo non produce container: il nome contiene solo l'azione. Il caso non è gestito esplicitamente.
- Dipende dalla funzione globale `inAdmin()`, definita fuori da questo modulo.
