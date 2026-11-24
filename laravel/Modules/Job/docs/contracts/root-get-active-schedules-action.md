---
title: "Contratto — GetActiveSchedulesAction (root, superseded)"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\GetActiveSchedulesAction"
qmd: "GetActiveSchedulesAction root superseded deprecated duplicato schedule attivi job::model default Schedule"
---

# GetActiveSchedulesAction (root, superseded)

Duplicato flat, `@deprecated` (`app/Actions/GetActiveSchedulesAction.php:13-17`). Il contratto da usare e' [get-active-schedules-action](get-active-schedules-action.md).

## Input

- Nessun argomento. Il modello e' risolto nel **costruttore** da `config('job::model', Schedule::class)`: qui il default esiste (riga 26).

## Output

- `Collection<int, Schedule>`, come la versione Schedule.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-SCHED-ROOT-INV-1` | Il modello e' risolto nel costruttore; senza `job::model` usa `Schedule::class` e non lancia. | Test: `tests/Unit/Actions/GetActiveSchedulesActionTest.php:42` (solo "has model property", struttura). |
| `JOB-SCHED-ROOT-INV-2` | Con cache disabilitata restituisce `active()->get()`; con cache abilitata usa `rememberForever` come la versione Schedule. | Test: nessuno comportamentale. |

## Effetti collaterali

- Come `get-active-schedules-action`: lettura DB, scrittura cache solo se abilitata.

## Errori

- `InvalidArgumentException` dal costruttore se `job::model` non e' stringa o non risolve a `Schedule`; in `getFromCache()` per store/key non stringhe.

## Non fa

- Non e' da usare: `@deprecated`. Nessun chiamante trovato fuori dai test. Il file non viene cancellato (l'autorizzazione manca).
