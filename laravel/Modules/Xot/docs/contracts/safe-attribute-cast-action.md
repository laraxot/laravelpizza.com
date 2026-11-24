---
title: "SafeAttributeCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeAttributeCastAction"
qmd: "SafeAttributeCastAction attributo modello getAttribute cast tipato default null validator"
---

# SafeAttributeCastAction

Legge gli attributi di un modello Eloquent con cast tipati e default. Codice: `app/Actions/Cast/SafeAttributeCastAction.php`.

## Input

- `Model $model`, `string $attribute` (non vuoto), e per i getter tipati il `$default`.
- `getTypedAttribute`: `$type` in `string|int|float|bool|array`.

## Output

- `hasAttribute` / `hasNonEmptyAttribute` / `hasAttributeValue`: `bool`.
- `getStringAttribute`, `getIntAttribute`, `getFloatAttribute`, `getBooleanAttribute`, `getArrayAttribute`: valore tipato; null produce il default.
- `getTypedAttribute`: valore del tipo richiesto.
- `getValidatedAttribute`: valore tipato, o `$default` se il validator restituisce falso.
- Statici: `hasNonEmpty`, `getString`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-ATTR-INV-1` | Un attributo null produce il default del getter. | `tests/Unit/Actions/Cast/SafeAttributeCastActionTest.php` (riferisce la classe) |
| `CAST-ATTR-INV-2` | `hasAttribute` è `true` solo se il valore non è null; `hasNonEmptyAttribute` esclude anche la stringa vuota. | `tests/Unit/Actions/Cast/SafeAttributeCastActionTest.php` (riferisce la classe) |
| `CAST-ATTR-INV-3` | Un tipo fuori da `string|int|float|bool|array` lancia eccezione. | Test: nessuno |
| `CAST-ATTR-INV-4` | Il nome attributo vuoto lancia eccezione da `Assert`. | Test: nessuno |

## Effetti collaterali

Nessuno. Legge con `getAttribute` (che attiva accessor e cast del modello).

## Errori

- `Webmozart\Assert` lancia per nome attributo vuoto o tipo non ammesso.
- `\InvalidArgumentException` per tipo non supportato.

## Non fa

- Non verifica che la colonna esista.
- Quasi identica a `SafeEloquentCastAction`: duplicazione da unificare (segnalazione, non modificata).
