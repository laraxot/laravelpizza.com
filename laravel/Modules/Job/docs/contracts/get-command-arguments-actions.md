---
title: "Contratto — GetCommandArgumentsActions"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Command\\GetCommandArgumentsActions"
qmd: "GetCommandArgumentsActions argomenti comando Artisan name default required JOB-CMDARG"
---

# GetCommandArgumentsActions

Elenca gli argomenti dichiarati da un comando Artisan. Codice: `app/Actions/Command/GetCommandArgumentsActions.php:10-29`. Nome del file al plurale: la classe e' `GetCommandArgumentsActions`.

## Input

- `Symfony\Component\Console\Command\Command $command`: letto solo tramite `getDefinition()->getArguments()`.

## Output

- `array<int, array{name: string, default: mixed, required: bool}>`, nell'ordine della definizione.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDARG-INV-1` | Un elemento per ogni argomento della definizione, nello stesso ordine, con `name`, `default` (valore grezzo) e `required` (`isRequired()`). | `tests/Unit/Actions/Command/GetCommandArgumentsActionsTest.php:26` ("returns array of arguments"): il titolo dichiara l'intento, il contenuto dell'asserzione non e' stato letto. |
| `JOB-CMDARG-INV-2` | Un comando senza argomenti produce un array vuoto. | Test: nessuno dedicato. |

## Effetti collaterali

- Nessuno: nessuna scrittura, nessun I/O.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non include descrizione degli argomenti (a differenza di `get-commands-action`).
- Non risolve il comando per nome: riceve l'istanza.
