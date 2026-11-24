---
title: "NormalizeDriverNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\String\\NormalizeDriverNameAction"
qmd: "NormalizeDriverNameAction normalizza nome driver alfanumerico minuscolo rimuove caratteri speciali"
---

# NormalizeDriverNameAction

Riduce il nome di un driver a soli caratteri `[a-z0-9]` in minuscolo. Codice: `app/Actions/String/NormalizeDriverNameAction.php`.

## Input

- `string $driver`: nome grezzo del driver (es. `360dialog`, `Mail-Gun`).

## Output

- `string`: solo caratteri `a-z` e `0-9`, in minuscolo.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `STR-DRIVER-INV-1` | Il risultato contiene solo caratteri `[a-z0-9]`. | `tests/Unit/Actions/String/NormalizeDriverNameActionTest.php` (riferisce la classe) |
| `STR-DRIVER-INV-2` | Il risultato è sempre in minuscolo. | `tests/Unit/Actions/String/NormalizeDriverNameActionTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno dall'Action.

## Non fa

- Non applica alias: il docblock dice di gestire "casi speciali/alias", ma nel codice non esiste alcuna mappa di alias. Incoerenza tra docblock e codice.
