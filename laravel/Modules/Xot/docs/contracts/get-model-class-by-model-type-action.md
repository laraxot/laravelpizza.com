---
title: "GetModelClassByModelTypeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetModelClassByModelTypeAction"
qmd: "GetModelClassByModelTypeAction morph_map tipo modello classe config risoluzione"
---

# GetModelClassByModelTypeAction

Risolve il FQCN da un tipo morph leggendo `config('morph_map')`. Codice: `app/Actions/GetModelClassByModelTypeAction.php` (classe a riga 17, `execute()` a riga 20).

## Input

- `string $model_type`.

## Output

- `string`: FQCN.

## Invarianti

- `GET-MODEL-CLASS-TYPE-INV-1` — `morph_map` deve essere un array, altrimenti `\Exception`. Test: `tests/Unit/Actions/GetModelActionsTest.php`, `tests/Unit/Actions/ModelTypeActionsTest.php`.
- `GET-MODEL-CLASS-TYPE-INV-2` — Il tipo deve essere presente nel `morph_map` e il valore una stringa. Test: come sopra.

## Effetti collaterali

Nessuno.

## Errori

- `\Exception` se `morph_map` non è array; `Webmozart` se il tipo manca.

## Non fa

- Non ha fallback di scansione dei moduli, a differenza di `Model/GetModelClassByModelNameAction`.
