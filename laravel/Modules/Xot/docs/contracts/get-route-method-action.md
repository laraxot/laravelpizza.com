---
title: "GetRouteMethodAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\GetRouteMethodAction"
qmd: "GetRouteMethodAction metodi HTTP route get post default array wrap"
---

# GetRouteMethodAction

Restituisce i metodi HTTP per una definizione di route dinamica. Codice: `app/Actions/Route/GetRouteMethodAction.php`.

## Input

- `array $v`: definizione; può contenere `method`.
- `?string $namespace`: non usato.

## Output

- `array<string>`: `Arr::wrap($v['method'])` se presente; altrimenti `['get', 'post']`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-METHOD-INV-1` | Con `method` impostato restituisce quel valore in array. | `tests/Unit/Actions/Route/GetRouteMethodActionTest.php` (riferisce la classe) |
| `ROUTE-METHOD-INV-2` | Senza `method` restituisce `['get', 'post']`. | `tests/Unit/Actions/Route/GetRouteMethodActionTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non valida i nomi dei metodi HTTP.
- Il parametro `$namespace` non è usato.
