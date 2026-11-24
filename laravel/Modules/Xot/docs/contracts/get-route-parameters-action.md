---
title: "GetRouteParametersAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetRouteParametersAction"
qmd: "GetRouteParametersAction parametri route corrente console runningInConsole chiavi stringa"
---

# GetRouteParametersAction

Restituisce i parametri della route corrente come array associativo. Codice: `app/Actions/Route/GetRouteParametersAction.php`.

## Input

- Nessuno.

## Output

- `array`: parametri della route con chiavi stringa; array vuoto in console o senza route corrente.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-PARAMS-INV-1` | In console il risultato è `[]`. | Test: nessuno |
| `ROUTE-PARAMS-INV-2` | Senza route corrente il risultato è `[]`. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non filtra i parametri: restituisce tutti quelli della route.
