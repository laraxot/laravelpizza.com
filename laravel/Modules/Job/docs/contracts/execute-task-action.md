---
title: "Contratto — ExecuteTaskAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\ExecuteTaskAction"
qmd: "ExecuteTaskAction job esecuzione task non implementata BadMethodCallException JOB-EXEC"
---

# ExecuteTaskAction

Dovrebbe eseguire un task schedulato per id. Oggi non fa nulla. Codice: `app/Actions/ExecuteTaskAction.php:10-21`.

## Input

- `string $taskId`: non letto. Non c'e' validazione.

## Output

- Nessuno. Il tipo dichiarato e' `string`, ma il metodo non restituisce mai: lancia sempre.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-EXEC-INV-1` | `execute()` lancia sempre `BadMethodCallException` con messaggio che cita `ROADMAP-2026.md`. Nessun effetto collaterale prima del lancio. | Test: nessuno comportamentale. `tests/Unit/Actions/ExecuteTaskActionTest.php:18-62` verifica firma e struttura. |

## Effetti collaterali

- Nessuno.

## Errori

- `BadMethodCallException`: «Method ExecuteTaskAction::execute() not implemented yet. See ROADMAP-2026.md».

## Non fa

- Non esegue alcun task. Non e' un contratto implementato: il comportamento atteso non e' definito qui.
- Chiamanti di produzione verificati: `app/Http/Livewire/Schedule/Crud.php:114` e `app/Filament/Widgets/ScheduleCrudWidget.php:92`. Quindi il pulsante di esecuzione lancia sempre: da segnalare.
- `ROADMAP-2026.md` non verificato nella root del repo (riferimento nel messaggio).
