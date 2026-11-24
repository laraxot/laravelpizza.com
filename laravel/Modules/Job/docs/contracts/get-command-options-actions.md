---
title: "Contratto — GetCommandOptionsActions"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Command\\GetCommandOptionsActions"
qmd: "GetCommandOptionsActions opzioni comando Artisan withValue withoutValue verbose quiet ansi JOB-CMDOPT"
---

# GetCommandOptionsActions

Separa le opzioni di un comando Artisan in quelle che accettano un valore e quelle che sono solo flag. Codice: `app/Actions/Command/GetCommandOptionsActions.php:10-43`.

## Input

- `Symfony\Component\Console\Command\Command $command`: letto tramite `getDefinition()->getOptions()`.

## Output

- `array{withValue: array<int, object>, withoutValue: array<int, string>}`.
  - `withValue`: oggetti (`stdClass`) con `name`, `default`, `required` (`isValueRequired()`).
  - `withoutValue`: nomi di flag.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDOPT-INV-1` | `withoutValue` contiene sempre, all'inizio, `verbose`, `quiet`, `ansi`, `no-ansi`, anche se il comando non le dichiara (righe 21-26). | `tests/Unit/Actions/Command/GetCommandOptionsActionsTest.php:35` ("includes default options in withoutValue"). |
| `JOB-CMDOPT-INV-2` | Un'opzione finisce in `withValue` se e' `acceptValue()`, altrimenti in `withoutValue`. | Test: nessuno esplicito; `GetCommandOptionsActionsTest.php:26` controlla solo la forma. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non deduplica: se il comando dichiara gia' una delle quattro opzioni fisse, il nome compare due volte. Dubbio: non verificato con un comando reale.
- Non filtra le opzioni globali dell'applicazione: dipende da cosa contiene la definizione del comando.
