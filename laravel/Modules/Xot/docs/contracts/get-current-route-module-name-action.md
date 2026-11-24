---
title: "GetCurrentRouteModuleNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetCurrentRouteModuleNameAction"
qmd: "GetCurrentRouteModuleNameAction nome modulo route corrente Modules Http"
---

# GetCurrentRouteModuleNameAction

Restituisce il nome del modulo a cui appartiene il controller della route corrente. Codice: `app/Actions/Route/GetCurrentRouteModuleNameAction.php`.

## Input

- Nessuno.

## Output

- `string`: testo tra `Modules\` e `\Http`, es. `Modules\Cms\Http\...` → `Cms`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-CUR-MOD-INV-1` | Il risultato è il segmento modulo fra `Modules\` e `\Http`. | `tests/Unit/Actions/Route/CurrentRouteActionsTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- `RuntimeException` se la route non ha controller.

## Non fa

- Se i marker mancano, restituisce l'intero handler. Dipende dalla convenzione di namespace dei moduli.
