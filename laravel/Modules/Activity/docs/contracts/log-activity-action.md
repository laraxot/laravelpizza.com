---
title: "Contratto: LogActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\LogActivityAction"
qmd: "contract LogActivityAction activity activity_log causer subject properties type description"
related:
  - ../actions.md
  - ../adr/0002-activity-models-on-dedicated-connection.md
  - ../../app/Actions/LogActivityAction.php
  - ../../tests/Unit/Actions/LogActivityActionConstructorTest.php
  - ../../tests/Unit/Actions/LogActivityActionExecuteValidationTest.php
---

# LogActivityAction

Scrive una riga in `activity_log` (modello `Modules\Activity\Models\Activity`, connessione `activity`). E' il mattone di `LogModel*Action`, `LogUser*Action` e dell'adapter `ActivityLogger`. Si costruisce con `new`, non con `app()`.

## Input

- Costruttore: `string $type` (non vuoto), `?Model $user` (il causer, deve essere `UserContract`), `?Model $subject`, `?array $properties`, `?string $description`.
- `execute()`: nessun argomento.

## Output

- L'`Activity` creata.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOG-INV-1 | `$type` vuoto lancia `InvalidArgumentException('Type cannot be empty')` nel costruttore. | `ACTIVITY-LOG-INV-1` |
| ACTIVITY-LOG-INV-2 | Un `$user` non nullo che non e' `UserContract` lancia `InvalidArgumentException('User must implement UserContract')` in `execute()`. | `ACTIVITY-LOG-INV-2` |
| ACTIVITY-LOG-INV-3 | `causer_id` e' l'id dell'utente passato; senza utente e' `Auth::id()` solo se int o stringa. `causer_type` e' la classe dell'utente passato, altrimenti `null`. | nessuno (sul caso senza utente) |
| ACTIVITY-LOG-INV-4 | `description` di default `Activity: <type>`; `log_name` e `event` valgono il tipo. | nessuno |

## Effetti collaterali

- `INSERT` in `activity_log` tramite `Activity::typedQuery()->create()`. Nessuna transazione esplicita, nessun evento dispatchato dall'Action.

## Errori

- `InvalidArgumentException` (INV-1, INV-2). Gli errori di database si propagano.

## Non fa

- Non redige le `properties` (lo fanno le Action `LogModel*`).
- Non verifica che la classe del subject esista.
- Incoerenze note: `causer_id` puo' valorizzarsi da `Auth::id()` con `causer_type = null` (INV-3), e l'attivita' non compare in `GetUserActivitiesAction`; `log_name` vale il tipo qui mentre `Actions\ActivityLogger::log()` e `RecordSubjectActivityAction` usano `default`.
