---
title: "SafeFloatCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeFloatCastAction"
qmd: "SafeFloatCastAction cast float sicuro virgola decimale stringa intervallo percentuale valuta arrotondamento"
---

# SafeFloatCastAction

Converte un valore `mixed` in `float` con default, con helper per intervallo, precisione, percentuale e valuta. Codice: `app/Actions/Cast/SafeFloatCastAction.php`.

## Input

- `mixed $value`, `?float $default = 0.0`.

## Output

- `float`. Regole: float finito invariato; non finito → default; int → float; null → default; stringa → `parseStringToFloat`; bool → `1.0`/`0.0`; array con un solo elemento → ricorsione sull'elemento; oggetto con `__toString` → parse; altro → default.
- `executeWithRange`: clamp tra min e max. `executeWithPrecision`: `round` con precisione minima 0. `executeAsPercentage`: clamp 0–100. `executeAsCurrency`: valore assoluto arrotondato a 2 decimali.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-FLOAT-INV-1` | Una stringa numerica con virgola decimale europea (`"3,5"`) è letta come `3.5`. | `tests/Unit/Actions/Cast/SafeFloatCastActionTest.php` (riferisce la classe) |
| `CAST-FLOAT-INV-2` | Il risultato è sempre finito. | `tests/Unit/Actions/Cast/SafeFloatCastActionTest.php` (riferisce la classe) |
| `CAST-FLOAT-INV-3` | La stringa `"0"` con default diverso da zero deve restituire `0.0`. Il codice restituisce il default (riga 219 circa, `empty("0")`). Bug. | Test: nessuno |
| `CAST-FLOAT-INV-4` | `executeAsCurrency` restituisce sempre un valore non negativo. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione. Input non parsabili producono il default.

## Non fa

- Bug `CAST-FLOAT-INV-3`: `empty("0")` è vero, quindi `"0"` diventa il default. Stesso difetto in `SafeIntCastAction` e `SafeBooleanCastAction`.
- Con separatori misti (`1.234,5`) la pulizia produce `1.234.5`, che non è numerico: restituisce il default.
- `executeAsCurrency` prende il valore assoluto: un importo negativo diventa positivo.
