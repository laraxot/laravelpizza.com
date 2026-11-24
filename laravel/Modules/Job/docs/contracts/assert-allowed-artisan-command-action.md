---
title: "Contratto — AssertAllowedArtisanCommandAction"
type: contract
action: "Modules\Job\Actions\Console\AssertAllowedArtisanCommandAction"
tags: [contract, action, artisan, security]
created: 2026-11-24
updated: 2026-11-24
---

# AssertAllowedArtisanCommandAction

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
