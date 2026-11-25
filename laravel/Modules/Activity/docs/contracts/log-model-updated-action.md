---
title: "Contratto: LogModelUpdatedAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\LogModelUpdatedAction"
qmd: "contract LogModelUpdatedAction activity evento updated modello old new changes redazione segreti"
related:
  - ../actions.md
  - ../../app/Actions/LogModelUpdatedAction.php
  - ../../tests/Unit/Actions/LogModelUpdatedActionTest.php
  - ../../tests/Unit/Actions/LogModelActionsRedactSecretsTest.php
---

# LogModelUpdatedAction

Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati. Le sorelle `LogModelCreatedAction` e `LogModelDeletedAction` seguono la stessa regola sui segreti.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<ClasseBase> updated'`, `properties = ['old' => ..., 'new' => ..., 'changes' => ...]` (da `getOriginal()`, `getAttributes()`, `getChanges()`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-MODEL-LOG-INV-1 | `old`, `new` e `changes` passano da `RedactModelAttributesAction`: mai `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`. Vale anche per created e deleted. | `ACTIVITY-MODEL-LOG-INV-1` |
| ACTIVITY-MODEL-LOG-INV-2 | Senza modello lancia `InvalidArgumentException('A model is required')`. | `LogModelUpdatedActionTest.php`, senza group |
| ACTIVITY-MODEL-LOG-INV-3 | `changes` e' quello che il modello espone al momento della chiamata: l'Action e' valida se chiamata dopo il `save()`. | nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`. Il modello non viene modificato.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non decide quando viene chiamata ne' quali modelli loggare: lo fa chi la invoca (observer, listener).
- Non toglie altri dati personali oltre ai segreti elencati (email e nome restano); per aggiungerne si estende `RedactModelAttributesAction`.
