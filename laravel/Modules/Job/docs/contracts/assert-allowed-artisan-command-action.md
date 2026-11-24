---
title: "Contratto — AssertAllowedArtisanCommandAction"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Console\\AssertAllowedArtisanCommandAction"
qmd: "AssertAllowedArtisanCommandAction job whitelist artisan JobStatus JOB-CMD-INV contract"
---

# AssertAllowedArtisanCommandAction

Controlla che un comando Artisan richiesto dal pannello `JobStatus` sia nella whitelist. Codice: `app/Actions/Console/AssertAllowedArtisanCommandAction.php:10-22`. Decisione di fondo: [ADR 0001](../adr/0001-controlli-operativi-solo-super-admin-e-whitelist.md).

## Input

- `string $command`: stringa inviata dal client Livewire.
- `list<string> $allowed`: comandi ammessi. Nel pannello sono i nomi restituiti da `JobStatus::getAllowedCommands()` (`app/Filament/Pages/JobStatus.php:59`).

## Output

- `void` se il comando e' ammesso.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMD-INV-1` | Il confronto e' esatto e strict (`in_array(..., true)`): nessun prefisso, nessun argomento libero. Esempio: `migrate:fresh --force` non passa solo perche' `migrate` e' in lista. | `tests/Unit/Filament/JobStatusAuthorizationTest.php:114` (rifiuta comandi fuori lista anche per super-admin) e `:132` (esecuzione per match esatto). |
| `JOB-CMD-INV-2` | Un comando fuori lista produce `InvalidArgumentException` prima di qualunque esecuzione. | `tests/Unit/Filament/JobStatusAuthorizationTest.php:153` ("throws for commands that are not listed"); `:162` verifica il caso ammesso. |

## Effetti collaterali

- Nessuno: non esegue Artisan, non scrive su DB, cache o log. L'esecuzione e' del chiamante (`JobStatus::artisan`), che la salta se l'eccezione viene catturata (`JobStatus.php:47-51`).

## Errori

- `InvalidArgumentException`: «Artisan command [<cmd>] is not allowed.»

## Non fa

- Non verifica l'identita' dell'utente: l'autorizzazione super-admin e' `JobStatus::canAccess()`, ripetuta in `artisan()`.
- Non valida ne' normalizza gli argomenti.
- Non costruisce la whitelist.
- La classe e' `final`.
