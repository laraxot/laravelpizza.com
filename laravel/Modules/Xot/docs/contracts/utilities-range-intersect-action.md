---
title: "RangeIntersectAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Utilities\\RangeIntersectAction"
qmd: "RangeIntersectAction intersezione intervalli interi a0 b0 a1 b1 false vuota"
---

# RangeIntersectAction

Calcola l'intersezione tra due intervalli interi `[a0, b0]` e `[a1, b1]`. Codice: `app/Actions/Arr/RangeIntersectAction.php`.

## Input

- `int $a0`, `int $b0`: primo intervallo (`execute()`).
- `int $a1`, `int $b1`: secondo intervallo (`execute()`).

## Output

- `array<int, int>|false`: `[inizio, fine]` dell'intersezione, oppure `false` se vuota (`execute()`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-RANGE-INV-1` | Ramo 1: `a1 in [a0,b0]` e `b0 <= b1` -> `[a1, b0]`. | `execute()` | `tests/Unit/Actions/Arr/RangeIntersectActionTest.php` (copertura dei rami non verificata) |
| `ARR-RANGE-INV-2` | Ramo 2: `a0 in [a1,b0]` e `b0 <= b1` -> `[a0, b0]`. | `execute()` | come sopra |
| `ARR-RANGE-INV-3` | Ramo 3: `a1 in [a0,b1]` e `b1 <= b0` -> `[a1, b1]`. | `execute()` | come sopra |
| `ARR-RANGE-INV-4` | Rami di scarto: `a0 < a1`, o `a0 > b1`, o `b1 > b0` -> `false`. | `execute()` | come sopra |
| `ARR-RANGE-INV-5` | Caso residuo: `[a0, b1]`. | `execute()` | come sopra |

## Effetti collaterali

Nessuno. Calcolo puro.

## Errori

- Nessuna eccezione.

## Non fa

- Non normalizza intervalli invertiti (`a > b`): nessun controllo su `a0 <= b0` né `a1 <= b1`.
- Dubbio: la semantica è l'intersezione di intervalli chiusi, ma il ramo residuo è raggiunto per deduzione dai rami di scarto. Da confermare con i test prima di estendere l'uso.

