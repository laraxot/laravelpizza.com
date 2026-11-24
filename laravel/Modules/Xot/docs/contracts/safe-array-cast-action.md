---
title: "SafeArrayCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeArrayCastAction"
qmd: "SafeArrayCastAction cast sicuro mixed array default toArray stdClass scalare chiavi required filter"
---

# SafeArrayCastAction

Converte un valore `mixed` in array, con default per i casi non gestiti. Codice: `app/Actions/Cast/SafeArrayCastAction.php`.

## Input

- `mixed $value`: valore da convertire.
- `?array $default = []`: restituito per null e per i tipi non gestiti.

## Output

- `array`. Regole in ordine: array → chiavi normalizzate; null → default; oggetto con `toArray()` → il suo risultato se è array; `stdClass` → cast; oggetto con `__toArray()`; altri oggetti → proprietà pubbliche (`get_object_vars` dalla classe Action); scalare → `[valore]`; altro → default.
- Helper: `executeWithKeys` restituisce default se manca una chiave richiesta; `executeWithFilter` tiene solo le chiavi ammesse; `executeWithValueType` converte i valori con i cast scalari (`string`, `int`, `float`, `bool`); tipo sconosciuto → array invariato.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-ARR-INV-1` | Un array in input è restituito come array. | `tests/Unit/Actions/Cast/SafeArrayCastActionTest.php` (riferisce la classe) |
| `CAST-ARR-INV-2` | Null produce `$default ?? []`. | `tests/Unit/Actions/Cast/SafeCastActionsTest.php` (riferisce la classe) |
| `CAST-ARR-INV-3` | Uno scalare diventa un array a un elemento con chiave `0`. | `tests/Unit/Actions/Cast/SafeCastActionsTest.php` (riferisce la classe) |
| `CAST-ARR-INV-4` | `executeWithKeys` restituisce il default se una chiave richiesta manca. | `tests/Unit/Actions/Cast/SafeArrayCastActionTest.php` (riferisce la classe) |
| `CAST-ARR-INV-5` | Le conversioni non lanciano eccezioni per tipi non gestiti. | Test: nessuno esplicito |

## Effetti collaterali

Nessuno. Chiama `toArray()` o `__toArray()` su oggetti, se presenti.

## Errori

- Nessuno dall'Action. Eccezioni lanciate da `toArray()` o `__toArray()` si propagano.

## Non fa

- `normalizeArray` converte le chiavi in stringa, ma PHP riconverte le chiavi numeriche in `int`: di fatto non cambia le chiavi.
- Non normalizza ricorsivamente gli array annidati.
- Per oggetti usa solo le proprietà pubbliche.
