---
title: "SafeObjectCastAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Cast\\SafeObjectCastAction"
qmd: "SafeObjectCastAction proprietà oggetto isset getter tipati metodo callMethodSafely default"
---

# SafeObjectCastAction

Legge proprietà di un oggetto generico con controllo `isset` e default; chiama metodi in modo protetto. Codice: `app/Actions/Cast/SafeObjectCastAction.php`.

## Input

- `object $object`, `string $property` (o `string $method`, `array $parameters`).

## Output

- `hasProperty`, `hasNonNullProperty`, `hasNonEmptyProperty`, `hasPropertyValue`, `hasMethod`: `bool`.
- Getter tipati (`getStringProperty`, `getIntProperty`, `getFloatProperty`, `getBooleanProperty`, `getArrayProperty`, `getTypedProperty`, `getValidatedProperty`): valore tipato, default se la proprietà non è impostata o è null.
- `callMethodSafely`: risultato del metodo, oppure `$default`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `CAST-OBJ-INV-1` | Una proprietà non impostata o null è trattata come assente (`isset`). | `tests/Unit/Actions/Cast/SafeObjectCastActionTest.php` (riferisce la classe) |
| `CAST-OBJ-INV-2` | `callMethodSafely` restituisce `$default` se il metodo non esiste. | `tests/Unit/Actions/Cast/SafeObjectCastActionTest.php` (riferisce la classe) |
| `CAST-OBJ-INV-3` | `callMethodSafely` restituisce `$default` anche quando il metodo lancia `\Throwable`. | `tests/Unit/Actions/Cast/SafeObjectCastActionTest.php` (riferisce la classe) |
| `CAST-OBJ-INV-4` | Un tipo fuori da `string|int|float|bool|array` lancia eccezione. | Test: nessuno |

## Effetti collaterali

- `callMethodSafely` esegue il metodo: eventuali effetti del metodo avvengono comunque.

## Errori

- `callMethodSafely` cattura `\Throwable` senza log: il fallimento è silenzioso, contro la regola di gestione errori del progetto.
- `Webmozart\Assert` lancia per nomi vuoti.

## Non fa

- `hasNonNullProperty` contiene un `Assert::true` ridondante (verifica una condizione sempre vera).
- Non vede proprietà private o protette: `isset` da fuori classe le ignora.
