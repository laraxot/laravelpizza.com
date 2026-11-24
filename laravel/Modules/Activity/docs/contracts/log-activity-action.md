---
title: "Contratto — LogActivityAction"
type: contract
action: "Modules\Activity\Actions\LogActivityAction"
tags: [contract, action, activity-log, audit]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/activity-models-on-dedicated-connection.md
  - ../../app/Actions/LogActivityAction.php
  - ../../tests/Unit/Actions/LogActivityActionConstructorTest.php
  - ../../tests/Unit/Actions/LogActivityActionExecuteValidationTest.php
---

# LogActivityAction

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
