---
title: "SafeEloquentCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeEloquentCastAction"
qmd: "SafeEloquentCastAction modello Eloquent attributo fallback cast tipato condizione getAttribute"
---

# SafeEloquentCastAction

Versione Eloquent dei getter tipati, con fallback su un secondo attributo. Codice: `app/Actions/Cast/SafeEloquentCastAction.php`.

## Input

- `Model $model`, `string $attribute` (o `$primaryAttribute` e `$fallbackAttribute`), `string $type` in `string|int|float|bool|array`, `$default`.

## Output

- Come `SafeAttributeCastAction`, con default propri (`''`, `0`, `0.0`, `false`) invece di null.
- `getAttributeWithFallback`: usa l'attributo primario se non è null, altrimenti il fallback. La stringa vuota non viene considerata assente.
- `hasAttributeCondition`: applica la callable al valore non null.
- Statici: `get`, `has`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-ELOQ-INV-1` | `getAttributeWithFallback` usa il fallback solo se il primario è null. | `tests/Unit/Actions/Cast/SafeEloquentCastActionTest.php` (riferisce la classe) |
| `CAST-ELOQ-INV-2` | Il valore null di un getter tipato produce il default del tipo (`''`, `0`, `0.0`, `false`). | `tests/Unit/Actions/Cast/SafeObjectEloquentCastActionsTest.php` (riferisce la classe) |
| `CAST-ELOQ-INV-3` | `hasAttributeCondition` è `false` per valore null senza chiamare la callable. | Test: nessuno |

## Effetti collaterali

Nessuno. Legge con `getAttribute`.

## Errori

- `Webmozart\Assert` e `\InvalidArgumentException` come in `SafeAttributeCastAction`.

## Non fa

- Duplica `SafeAttributeCastAction`: da unificare in una sola classe (segnalazione, non modificata).
