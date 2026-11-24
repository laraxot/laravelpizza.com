---
title: "GetCurrentRouteControllerNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetCurrentRouteControllerNameAction"
qmd: "GetCurrentRouteControllerNameAction nome controller route corrente Http Controllers"
---

# GetCurrentRouteControllerNameAction

Restituisce il nome del controller della route corrente, senza namespace fino a `Http\Controllers\` e senza suffisso `Controller`. Codice: `app/Actions/Route/GetCurrentRouteControllerNameAction.php`.

## Input

- Nessuno.

## Output

- `string`: testo tra `Http\Controllers\` e l'ultimo `Controller`, es. `PageController@index` → `Page`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-CUR-CTRL-INV-1` | Il risultato è il testo fra i marker `Http\Controllers\` e `Controller`. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- `RuntimeException` se la route non ha controller.

## Non fa

- Se i marker mancano, `Str::between` restituisce l'intero handler (comportamento di `Str::between`).
