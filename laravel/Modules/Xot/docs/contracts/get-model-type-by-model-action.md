---
title: "GetModelTypeByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetModelTypeByModelAction"
qmd: "GetModelTypeByModelAction tipo modello snake class_basename morph tipo"
---

# GetModelTypeByModelAction

Restituisce il tipo di un modello come nome snake del basename della classe. Codice: `app/Actions/GetModelTypeByModelAction.php` (classe a riga 18, `execute()` a riga 21).

## Input

- `ModelContract $modelContract`: un'istanza del modello.

## Output

- `string`: per esempio `user_profile`.

## Invarianti

- `GET-MODEL-TYPE-INV-1` — Il risultato è `Str::snake(class_basename($modelContract))`. Test: `tests/Unit/Actions/GetModelActionsTest.php`, `tests/Unit/Actions/ModelTypeActionsTest.php`.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non legge il `morph_map`: il tipo restituito può non coincidere con l'alias morph dichiarato. Dubbio da verificare sui chiamanti.
