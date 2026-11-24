---
title: "Contratto — LogModelUpdatedAction"
type: contract
action: "Modules\Activity\Actions\LogModelUpdatedAction"
tags: [contract, action, activity, gdpr]
created: 2026-11-24
updated: 2026-11-24
qmd: "contratto log model updated action activity redact password token gdpr"
---

# LogModelUpdatedAction

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
