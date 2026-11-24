---
title: "SafeArrayByModelCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeArrayByModelCastAction"
qmd: "SafeArrayByModelCastAction modello Eloquent array attributi sicuro attributesToArray fallback"
---

# SafeArrayByModelCastAction

Converte gli attributi di un modello in array, con fallback attributo per attributo se la conversione fallisce. Codice: `app/Actions/Cast/SafeArrayByModelCastAction.php`.

## Input

- `Model $model`: modello Eloquent.

## Output

- `array<string, mixed>`: `attributesToArray()` se non fallisce; altrimenti gli attributi leggibili uno per uno.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-MODEL-ARR-INV-1` | Se `attributesToArray()` riesce, il risultato è quell'array. | `tests/Unit/Actions/Cast/SafeArrayByModelCastActionTest.php` (riferisce la classe) |
| `CAST-MODEL-ARR-INV-2` | Se lancia `ValueError` o `Error`, gli attributi che falliscono vengono omessi e gli altri restano. | `tests/Unit/Actions/Cast/EloquentCastActionsTest.php` (fixture `BrokenAttributesModelForSafeArrayCast`) |

## Effetti collaterali

Nessuno. Sola lettura degli attributi (possono essere eseguiti accessor).

## Errori

- `ValueError` e `Error` vengono catturati senza log: il fallimento è silenzioso.
- Altre eccezioni non sono catturate.

## Non fa

- Non registra gli attributi scartati: il fallback silenzioso nasconde dati mancanti.
- Non include relazioni caricate.
