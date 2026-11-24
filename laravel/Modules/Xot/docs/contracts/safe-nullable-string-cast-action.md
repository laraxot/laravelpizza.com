---
title: "SafeNullableStringCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeNullableStringCastAction"
qmd: "SafeNullableStringCastAction stringa nullable stringa vuota null cast sicuro"
---

# SafeNullableStringCastAction

Converte un valore in `?string`: la stringa vuota diventa null. Codice: `app/Actions/Cast/SafeNullableStringCastAction.php`.

## Input

- `mixed $value`.

## Output

- `?string`: null se la stringa prodotta da `SafeStringCastAction` è vuota; altrimenti la stringa.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-NSTR-INV-1` | Null o stringa vuota producono null. | `tests/Unit/Actions/Cast/SafeNullableStringCastActionTest.php` (riferisce la classe) |
| `CAST-NSTR-INV-2` | Il valore `false` produce `'0'`, non null. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non tratta `'0'` come assente.
