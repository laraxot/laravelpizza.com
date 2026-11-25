---
title: "Contratto — GetScheduleStatusCommandsAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Console\\GetScheduleStatusCommandsAction"
qmd: "GetScheduleStatusCommandsAction comandi schedule list run work clear-cache monitor JOB-CONSOLE"
---

# GetScheduleStatusCommandsAction

Lista fissa dei comandi di schedulazione mostrabili nel pannello. Codice: `app/Actions/Console/GetScheduleStatusCommandsAction.php:9-29`.

## Input

- Nessuno.

## Output

- `list<string>`: `job:schedule-list`, `schedule:clear-cache`, `schedule:list`, `schedule:run`, `schedule:test`, `schedule:work`, `schedule-monitor:sync`, `schedule-monitor:list`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-3` | L'output e' la lista letterale sopra, nell'ordine dato. | Test: nessuno. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non verifica che i comandi esistano (es. `schedule-monitor:*` dipende dal pacchetto).
- Non e' la whitelist di esecuzione: quella e' di `assert-allowed-artisan-command-action`. Da verificare se questa lista alimenta quella whitelist.
