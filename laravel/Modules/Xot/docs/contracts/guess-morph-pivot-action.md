---
title: "GuessMorphPivotAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\GuessMorphPivotAction"
qmd: "GuessMorphPivotAction pivot morph MorphPivot risoluzione classe convenzione nome"
---

# GuessMorphPivotAction

Individua e istanzia la classe pivot morph per una relazione, con nome `{Related}Morph`. Codice: `app/Actions/ModelClass/GuessMorphPivotAction.php`.

## Input

- `string $related`: FQCN del modello correlato.
- `string $class`: FQCN del modello che dichiara la relazione.

## Output

- `MorphPivot`: istanza della classe pivot trovata.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-MORPH-PIVOT-INV-1` | Il nome cercato è `class_basename($related).'Morph'`. | Test: nessuno |
| `MODEL-MORPH-PIVOT-INV-2` | Il risultato è sempre un `MorphPivot`, altrimenti lancia. | Test: nessuno |

## Effetti collaterali

- Istanzia la classe pivot tramite il container (`app()`).

## Errori

- `Assert::isInstanceOf` se la classe trovata non è `MorphPivot`.
- Errori del container se la classe non esiste (il fallback di `GuessPivotFullClassAction` non verifica l'esistenza).

## Non fa

- Non cerca il pivot in base al nome della classe che dichiara la relazione, solo nel namespace.
