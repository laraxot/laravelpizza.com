---
title: "Contratto — DummyAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\DummyAction"
qmd: "DummyAction job segnaposto queue hello stdout JOB-DUMMY"
---

# DummyAction

Action di prova per verificare che una Action parta in coda. Codice: `app/Actions/DummyAction.php:9-20`.

## Input

- Nessun argomento.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-DUMMY-INV-1` | `execute()` scrive `hello` seguito da `PHP_EOL` su stdout e non fa altro. | Test: nessuno comportamentale. `tests/Unit/Actions/DummyActionTest.php:18-53` verifica solo struttura. |

## Effetti collaterali

- Output su stdout (`echo`). Nessuna scrittura su DB, cache o file.
- Chiamanti: `app/Http/Livewire/Job/Status.php:204` e `app/Filament/Widgets/JobStatusWidget.php:175`, entrambi `->onQueue()->execute()`: l'effetto reale avviene nel worker.

## Errori

- Nessuno.

## Non fa

- Non contiene logica di business: il commento nel corpo e' il segnaposto del template. Da sostituire o dismettere, non da estendere.
