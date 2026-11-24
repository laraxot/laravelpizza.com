---
title: "Contratto — AssertAllowedArtisanCommandAction"
type: contract
<<<<<<< .merge_file_s2jo1J
<<<<<<< .merge_file_vP7bDi
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\Console\\AssertAllowedArtisanCommandAction"
qmd: "AssertAllowedArtisanCommandAction job whitelist artisan JobStatus JOB-CMD-INV contract"
=======
=======
>>>>>>> .merge_file_5HsHPm
action: "Modules\Job\Actions\Console\AssertAllowedArtisanCommandAction"
tags: [contract, action, artisan, security]
created: 2026-11-24
updated: 2026-11-24
<<<<<<< .merge_file_s2jo1J
>>>>>>> .merge_file_IXcDgM
=======
>>>>>>> .merge_file_5HsHPm
---

# AssertAllowedArtisanCommandAction

<<<<<<< .merge_file_s2jo1J
<<<<<<< .merge_file_vP7bDi
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
=======
=======
>>>>>>> .merge_file_5HsHPm
Sorgente: `app/Actions/Console/AssertAllowedArtisanCommandAction.php`. Perché esiste:
[ADR allowlist a match esatto](../adr/artisan-commands-from-ui-exact-match-allowlist.md).
Unico chiamante in produzione: `Filament/Pages/JobStatus.php::artisan()`.

## Input

- `string $command`: la stringa ricevuta dal client Livewire, così com'è.
- `list<string> $allowed`: l'elenco dei comandi ammessi (per `JobStatus`: `getAllowedCommands()`, derivato dai pulsanti).

## Output

- `void`. Il ritorno senza eccezione significa "comando ammesso".

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| JOB-ARTISAN-INV-1 | Ammesso solo se identico a una voce di `$allowed` (`in_array` stretto): niente prefissi, opzioni aggiunte, maiuscole o spazi diversi. | `JOB-ARTISAN-INV-1` |
| JOB-ARTISAN-INV-2 | Un comando rifiutato produce sempre `InvalidArgumentException`, mai un ritorno silenzioso. | `JOB-ARTISAN-INV-2` |

## Effetti collaterali

- Nessuno: non esegue il comando, non scrive log. L'esecuzione (`Artisan::call`) resta al chiamante, dopo il controllo.

## Errori

- `InvalidArgumentException('Artisan command [<cmd>] is not allowed.')` se il comando non è in elenco.
  `JobStatus::artisan()` la cattura e non esegue nulla (`$out` resta vuoto).

## Non fa

- Non controlla chi chiama: l'autorizzazione super-admin è in `JobStatus::artisan()` (`SuperAdminOnlyTrait`), e va
  ripetuta lì anche se questa Action passa.
- Non costruisce l'elenco: non aggiungere qui comandi "di default"; l'elenco viene dai pulsanti della pagina.
- Non accetta argomenti separati né li valida: un comando con parametri non è supportato dal pattern.
- Non è usata da `JobStatusWidget` né da `ScheduleStatusWidget`, che hanno un `in_array` proprio (debito nell'ADR).
<<<<<<< .merge_file_s2jo1J
>>>>>>> .merge_file_IXcDgM
=======
>>>>>>> .merge_file_5HsHPm
