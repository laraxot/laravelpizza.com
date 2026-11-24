---
title: "GetModuleNameByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Module\\GetModuleNameByModelAction"
qmd: "GetModuleNameByModelAction nome modulo da istanza modello Eloquent delega classe"
---

# GetModuleNameByModelAction

Dato un modello Eloquent, restituisce il nome del modulo a cui appartiene la sua classe. Codice: `app/Actions/Module/GetModuleNameByModelAction.php:10-17`.

## Input

- `Model $model`: istanza Eloquent (`execute`, riga 14).

## Output

- `string`: nome del modulo (riga 16).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `MODULE-NAME-MODEL-INV-1` | Delega a `GetModuleNameByModelClassAction` con `$model::class`. | riga 16 | `tests/Unit/Actions/Module/GetModuleNameActionsTest.php:6,38` |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non valida che la classe sia in `Modules\`: il risultato dipende da `GetModuleNameByModelClassAction`.
- Marker `@contract` aggiunto nel docblock della classe.
