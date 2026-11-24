---
title: "GetCurrentRouteHandlerAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetCurrentRouteHandlerAction"
qmd: "GetCurrentRouteHandlerAction handler controller@metodo route corrente eccezione closure"
---

# GetCurrentRouteHandlerAction

Restituisce la stringa `Classe@metodo` della route corrente. Codice: `app/Actions/Route/GetCurrentRouteHandlerAction.php`.

## Input

- Nessuno.

## Output

- `string`: valore dell'azione `controller` della route corrente.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-CUR-HDL-INV-1` | Il risultato è l'azione `controller` della route corrente. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |
| `ROUTE-CUR-HDL-INV-2` | Se non c'è route o l'azione non è una stringa (es. closure) lancia `RuntimeException`. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- `RuntimeException`: `The current route has no controller action.`

## Non fa

- Non distingue route con metodo HTTP diverso.
