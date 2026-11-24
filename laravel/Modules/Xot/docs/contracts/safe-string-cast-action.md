---
title: "SafeStringCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeStringCastAction"
qmd: "SafeStringCastAction cast stringa sicuro null bool scalare array oggetto stringa vuota"
---

# SafeStringCastAction

Converte un valore `mixed` in `string` senza eccezioni. Codice: `app/Actions/Cast/SafeStringCastAction.php`.

## Input

- `mixed $value`.

## Output

- `string`. Regole: stringa invariata; null → `''`; bool → `'1'`/`'0'`; scalare → cast a stringa; array o oggetto → `''`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-STR-INV-1` | Null e array/oggetti producono `''`. | `tests/Unit/Actions/Cast/SafeStringCastActionTest.php` (riferisce la classe) |
| `CAST-STR-INV-2` | `true` produce `'1'`, `false` produce `'0'`. | `tests/Unit/Actions/Cast/SafeStringCastActionTest.php` (riferisce la classe) |
| `CAST-STR-INV-3` | Non lancia eccezioni per nessun tipo. | Test: nessuno esplicito |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Ignora oggetti con `__toString`: restituisce `''`.
- Il blocco commentato sui `BackedEnum` non è attivo.
