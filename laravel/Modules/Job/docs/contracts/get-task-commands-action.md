---
title: "Contratto — GetTaskCommandsAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\GetTaskCommandsAction"
qmd: "GetTaskCommandsAction comandi Artisan ordinati Artisan::all comandi senza due punti JOB-TASKCMD"
---

# GetTaskCommandsAction

Restituisce tutti i comandi Artisan con un ordine stabile. Codice: `app/Actions/GetTaskCommandsAction.php:13-40`.

## Input

- Nessun argomento. Legge `Artisan::all()`.

## Output

- `Collection<int, Symfony\Component\Console\Command\Command>`, ordinata e rinumerata con `values()`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-TASKCMD-INV-1` | Un comando senza `:` nel nome viene prima di tutti quelli con `:` (chiave di ordinamento `':'.$name`), salvo nomi che iniziano con una cifra. Dentro ciascun gruppo l'ordine e' alfabetico. | Test: nessuno. `tests/Unit/Actions/GetTaskCommandsActionTest.php:19-59` verifica firma, container e struttura. |
| `JOB-TASKCMD-INV-2` | Ogni elemento deve essere un `Command` con nome stringa, altrimenti asserzione fallita. | Test: nessuno. |

## Effetti collaterali

- Nessuno: sola lettura di `Artisan::all()`.

## Errori

- `Webmozart\Assert\InvalidArgumentException` (righe 26, 28) se un elemento non e' `Command` o il nome non e' stringa.

## Non fa

- Non filtra i comandi nascosti.
- Non esegue i comandi.
- Nessun chiamante di produzione trovato fuori dai test (verifica per nome).
