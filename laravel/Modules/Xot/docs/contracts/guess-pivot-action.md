---
title: "GuessPivotAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\GuessPivotAction"
qmd: "GuessPivotAction pivot tabella intermedia nome ordinato alfabetico classi basename Pivot"
---

# GuessPivotAction

Individua e istanzia la classe pivot di una relazione many-to-many, con nome formato dai basename dei due modelli in ordine alfabetico. Codice: `app/Actions/ModelClass/GuessPivotAction.php`.

## Input

- `string $related`: FQCN del modello correlato.
- `string $class`: FQCN del modello che dichiara la relazione.

## Output

- `Pivot`: istanza della classe pivot trovata.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-PIVOT-INV-1` | Il nome è la concatenazione dei due basename ordinati con `sort()`. | Test: nessuno |
| `MODEL-PIVOT-INV-2` | Il risultato è sempre un `Pivot`, altrimenti lancia. | Test: nessuno |

## Effetti collaterali

- Istanzia la classe pivot tramite il container.

## Errori

- `Assert::isInstanceOf` se la classe non è un `Pivot`.

## Non fa

- L'ordinamento è quello di `sort()` (alfabetico, case-sensitive).
