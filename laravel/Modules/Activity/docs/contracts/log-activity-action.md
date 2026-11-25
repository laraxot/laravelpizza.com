---
title: "Contratto — LogActivityAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogActivityAction"
qmd: "contract LogActivityAction activity scrittura singola attivita causer subject properties log_name Auth fallback ACT-LOGACT"
tags: [contract, action, activity-log, audit]
created: 2026-11-24
related:
  - ../adr/activity-models-on-dedicated-connection.md
  - ../../app/Actions/LogActivityAction.php
  - ../../tests/Unit/Actions/LogActivityActionConstructorTest.php
  - ../../tests/Unit/Actions/LogActivityActionExecuteValidationTest.php
---

# LogActivityAction

Scrive una riga in `activity_log`. È il punto comune usato da `LogModel*Action`, `LogUser*Action`.

## Input

- Costruttore: `string $type` (non vuoto), `?Model $user`, `?Model $subject`, `?array $properties`, `?string $description`.
- `execute()`: nessun argomento.

## Output

- `Activity`: la riga creata.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGACT-INV-1` | `$type` vuoto lancia `InvalidArgumentException('Type cannot be empty')` al costruttore. | `LogActivityActionConstructorTest.php` |
| `ACT-LOGACT-INV-2` | Un `$user` non null che non è `UserContract` lancia `InvalidArgumentException('User must implement UserContract')` in `execute()`. | `LogActivityActionExecuteValidationTest.php` |
| `ACT-LOGACT-INV-3` | `causer_id` è l'id dell'utente passato; senza utente è `Auth::id()` solo se int o stringa. `causer_type` è la classe dell'utente passato, altrimenti `null`. | Test: nessuno sul caso senza utente |
| `ACT-LOGACT-INV-4` | `description` di default è `Activity: <type>`; `log_name` è il tipo; `event` è il tipo. | Test: nessuno |

## Effetti collaterali

- `INSERT` in `activity_log` tramite `Activity::typedQuery()->create()`. Nessuna transazione esplicita, nessun evento dispatchato dall'Action.

## Errori

- `InvalidArgumentException` (INV-1, INV-2). Errori di database si propagano.

## Non fa

- Non redige `properties`.
- Non verifica che la classe del soggetto esista.
- Incoerenze da segnalare:
  - `causer_id` può valorizzarsi da `Auth::id()` con `causer_type = null` (INV-3): l'attività non compare in `GetUserActivitiesAction`.
  - `log_name` vale il tipo qui, mentre `ActivityLogger::log()` e `RecordSubjectActivityAction` usano `'default'`.

Scrive una riga di `activity_log` (modello `Modules\Activity\Models\Activity`, connessione `activity`). È il mattone
delle Action `LogModelCreated/Updated/Deleted` e `LogUserLogin/Logout` e dell'adapter `Adapters/ActivityLogger`.
Sorgente: `app/Actions/LogActivityAction.php`. Si costruisce con `new` (parametri nel costruttore), non con `app()`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/LogActivityActionConstructorTest.php Modules/Activity/tests/Unit/Actions/LogActivityActionExecuteValidationTest.php`.

## Input

| Parametro (costruttore) | Tipo | Note |
|---|---|---|
| `$type` | `string` | non vuoto; diventa `log_name` ed `event` |
| `$user` | `?Model` | il causante; deve implementare `UserContract` |
| `$subject` | `?Model` | il record su cui si agisce |
| `$properties` | `?array` | dati liberi (per gli update: `old`, `new`, `changes`) |
| `$description` | `?string` | default `Activity: <type>` |

## Output

- Il modello `Activity` creato.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOG-INV-1 | `$type` vuoto è rifiutato già nel costruttore. | `ACTIVITY-LOG-INV-1` |
| ACTIVITY-LOG-INV-2 | Un causante che non implementa `UserContract` è rifiutato prima di scrivere. | `ACTIVITY-LOG-INV-2` |
| ACTIVITY-LOG-INV-3 | Senza `$user`, il causante è `Auth::id()` (se int o string), altrimenti nessuno. | — |
| ACTIVITY-LOG-INV-4 | Una sola riga creata, con `log_name = event = $type`. | — |

## Effetti collaterali

- `INSERT` in `activity_log` sulla connessione `activity`.

## Errori

- `InvalidArgumentException('Type cannot be empty')`, `InvalidArgumentException('User must implement UserContract')`.
- Errori del DB (tabella mancante, colonna `attribute_changes` assente con Spatie v4+) escono: chi scrive in un
  contesto che non deve fallire (registrazione utente) verifica prima con `IsActivityLogSchemaWritableAction`.

## Non fa

- Non toglie dati sensibili dalle `properties`: `LogModelUpdatedAction` passa `getOriginal()` e `getAttributes()`
  interi (password e token compresi). `RedactModelAttributesAction` esiste ma oggi non la chiama nessuno: debito.
- Non controlla `activitylog.enabled`.
- Non accoda: scrive in modo sincrono nella richiesta corrente.
