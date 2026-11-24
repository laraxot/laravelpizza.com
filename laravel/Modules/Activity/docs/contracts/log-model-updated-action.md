---
title: "Contratto — LogModelUpdatedAction"
type: contract
<<<<<<< .merge_file_OisZAG
<<<<<<< .merge_file_QAvYKW
<<<<<<< .merge_file_nD5JL9
<<<<<<< .merge_file_nkDYXv
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogModelUpdatedAction"
qmd: "contract LogModelUpdatedAction activity evento updated modello old new changes getOriginal getChanges ACT-MUPDATE"
=======
=======
>>>>>>> .merge_file_tDrQJo
=======
>>>>>>> .merge_file_1R1NMg
=======
>>>>>>> .merge_file_kCg2NU
action: "Modules\Activity\Actions\LogModelUpdatedAction"
tags: [contract, action, activity, gdpr]
created: 2026-11-24
updated: 2026-11-24
qmd: "contratto log model updated action activity redact password token gdpr"
<<<<<<< .merge_file_OisZAG
<<<<<<< .merge_file_QAvYKW
<<<<<<< .merge_file_nD5JL9
>>>>>>> .merge_file_DSZYSL
=======
>>>>>>> .merge_file_tDrQJo
=======
>>>>>>> .merge_file_1R1NMg
=======
>>>>>>> .merge_file_kCg2NU
---

# LogModelUpdatedAction

<<<<<<< .merge_file_OisZAG
<<<<<<< .merge_file_QAvYKW
<<<<<<< .merge_file_nD5JL9
<<<<<<< .merge_file_nkDYXv
Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<Basename> updated'`, `properties = ['old' => getOriginal(), 'new' => getAttributes(), 'changes' => getChanges()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MUPDATE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MUPDATE-INV-2` | Il tipo è `updated`; `properties` ha le chiavi `old`, `new`, `changes`. | Test: nessuno sulle chiavi |
| `ACT-MUPDATE-INV-3` | `changes` è quello che il modello espone al momento della chiamata: l'Action è valida se chiamata dopo il `save()`. | Test: nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`. Il modello non viene modificato.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non decide quando viene chiamata (chi la invoca, per esempio un observer, non è in questo contract).
- Non redige `old` e `new`: contengono anche password o token se presenti nel modello (vedi `redact-model-attributes-action.md`).

=======
=======
>>>>>>> .merge_file_tDrQJo
=======
>>>>>>> .merge_file_1R1NMg
=======
>>>>>>> .merge_file_kCg2NU
Registra nel log attività la modifica di un modello. Le sorelle `LogModelCreatedAction` e `LogModelDeletedAction` seguono
la stessa regola sui segreti (stesso test, stesso group). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Input

- `Model $model` (costruttore o `execute()`); senza modello: `InvalidArgumentException`.
- `?Model $user` (costruttore): il causer, facoltativo.

## Output

- L'`Activity` creata, evento `updated`, `properties` = `old`, `new`, `changes` del modello.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-MODEL-LOG-INV-1 | `properties` non contiene mai `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes` (passano da `RedactModelAttributesAction`); vale anche per created e deleted. | `ACTIVITY-MODEL-LOG-INV-1` |

## Effetti collaterali

- Una riga nella tabella delle attività (via `LogActivityAction`, connessione `activity`).

## Errori

- `InvalidArgumentException` se manca il modello.

## Non fa

- Non decide *quali* modelli loggare: lo fa chi la chiama (observer/listener).
- Non toglie altri dati personali oltre ai segreti elencati (email, nome restano): se un modello ne ha di più sensibili,
  si estende `RedactModelAttributesAction`, non si filtra qui.
<<<<<<< .merge_file_OisZAG
<<<<<<< .merge_file_QAvYKW
<<<<<<< .merge_file_nD5JL9
>>>>>>> .merge_file_DSZYSL
=======
>>>>>>> .merge_file_tDrQJo
=======
>>>>>>> .merge_file_1R1NMg
=======
>>>>>>> .merge_file_kCg2NU
