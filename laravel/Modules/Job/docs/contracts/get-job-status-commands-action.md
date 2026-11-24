---
title: "Contratto — GetJobStatusCommandsAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Console\\GetJobStatusCommandsAction"
qmd: "GetJobStatusCommandsAction whitelist comandi pannello job status queue worker route JOB-CONSOLE"
---

# GetJobStatusCommandsAction

Lista fissa dei comandi Artisan che il pannello di stato dei job puo' eseguire. Codice: `app/Actions/Console/GetJobStatusCommandsAction.php:9-29`.

## Input

- Nessuno.

## Output

- `list<string>`: `queue:clear`, `queue:failed`, `queue:flush`, `queue:prune-batches`, `queue:prune-failed`, `queue:restart`, `queue:retry`, `worker:check`, `route:list`, in questo ordine.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-1` | L'output e' la lista letterale sopra: nessuna scoperta dinamica dei comandi, nessun filtro. | Test: nessuno diretto. `tests/Unit/Filament/JobStatusAuthorizationTest.php:144` ("derives the allowlist from the page buttons") copre la derivazione dal pannello, non questa lista in isolamento. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non verifica che i comandi esistano nell'applicazione.
- Nota: la lista contiene comandi distruttivi (`queue:flush`, `queue:clear`, `queue:prune-failed`). Il titolo del test a riga 144 dice che i distruttivi del framework sono esclusi; la lista li include. Da chiarire con il proprietario.
- Chiamanti non trovati per nome fuori dai test: il pannello usa la sua `getAllowedCommands()`.
