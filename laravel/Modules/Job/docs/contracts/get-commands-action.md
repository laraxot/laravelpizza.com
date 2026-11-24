---
title: "Contratto — GetCommandsAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Command\\GetCommandsAction"
qmd: "GetCommandsAction elenco comandi Artisan CommandData DataCollection kernel options withValue JOB-CMDLIST"
---

# GetCommandsAction

Costruisce l'elenco dei comandi Artisan come `CommandData`, per il form di schedulazione. Codice: `app/Actions/Command/GetCommandsAction.php:16-78`.

## Input

- Nessun argomento. Legge `Illuminate\Contracts\Console\Kernel::all()`.

## Output

- `DataCollection<int, CommandData>`: una voce per comando, con `name`, `description`, `signature` (uguale al nome), `full_name` (`nome - descrizione`), `arguments` e `options`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDLIST-INV-1` | Una `CommandData` per ogni comando restituito da `kernel->all()`, indici rinumerati. | `tests/Unit/Actions/Command/GetCommandsActionTest.php:59` ("has execute method returning DataCollection"): solo tipo di ritorno. |
| `JOB-CMDLIST-INV-2` | `options.withValue` contiene **tutte** le opzioni del comando, flag inclusi (il filtro `acceptValue()` non c'e'; righe 70-72). Il nome della chiave e' fuorviante. | Test: nessuno. |
| `JOB-CMDLIST-INV-3` | `signature` e' uguale a `name`: non include argomenti ne' opzioni. | Test: nessuno. |

## Effetti collaterali

- Nessuno: sola lettura del Kernel.

## Errori

- Nessuna eccezione propria. I cast `(string)` e `(bool)` non lanciano su valori tipici.

## Non fa

- Non ordina ne' filtra i comandi (per l'ordine vedi `get-task-commands-action`).
- Chiamanti verificati: `Filament/Resources/ScheduleResource/Schemas/ScheduleForm.php` e `Filament/Resources/ScheduleResource.php`.
- Nota: `options.withValue` non rispetta il nome: vedi INV-2. Chi consuma il dato deve saperlo.
