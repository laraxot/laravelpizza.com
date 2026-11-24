---
title: "SafeBooleanCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeBooleanCastAction"
qmd: "SafeBooleanCastAction cast booleano sicuro stringhe yes no si sì 0 1 default soglia valori personalizzati"
---

# SafeBooleanCastAction

Converte un valore `mixed` in `bool` con default. Codice: `app/Actions/Cast/SafeBooleanCastAction.php`.

## Input

- `mixed $value`.
- `?bool $default = false`: usato per null, stringhe non riconosciute e tipi non gestiti.

## Output

- `bool`. Regole: bool invariato; null → default; int → `!== 0`; float → `!== 0.0 && is_finite` (NaN e infiniti danno `false`); stringa → `parseStringToBool`; array non vuoto → `true`; oggetto con proprietà → `true`; altro → default.
- `parseStringToBool`: vero per `true, 1, yes, on, enabled, active, si, sì`; falso per `false, 0, no, off, disabled, inactive`; numerico diverso da zero → `true`; altro → default.
- Helper: `executeWithCustomValues` (liste personalizzate di vero/falso), `executeWithThreshold` (confronto numerico con soglia).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-BOOL-INV-1` | Null produce il default. | `tests/Unit/Actions/Cast/SafeBooleanCastActionTest.php` (riferisce la classe) |
| `CAST-BOOL-INV-2` | Le stringhe `yes`, `on`, `si`, `sì` (ecc.) sono `true`; `no`, `off` (ecc.) sono `false`. | `tests/Unit/Actions/Cast/SafeBooleanCastActionTest.php` (riferisce la classe) |
| `CAST-BOOL-INV-3` | La stringa `"0"` con default `true` deve restituire `false`. Il codice restituisce il default. Bug: `empty("0")` è `true` e la riga 231 intercetta il caso prima di `$falseValues`. | Test: nessuno (il comportamento attuale non è coperto) |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno. Non lancia eccezioni.

## Non fa

- Bug: `CAST-BOOL-INV-3`. Il controllo `empty($trimmed)` in `parseStringToBool` (riga 231 circa) cattura `"0"`, quindi `execute("0", true)` restituisce `true`. Correzione da fare con un test dedicato, non in questo lavoro.
- Non riconosce altre lingue oltre a `si`/`sì`.
