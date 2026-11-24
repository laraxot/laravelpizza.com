---
title: "Contratto — ExecuteArtisanCommandAction"
type: contract
action: "Modules\Xot\Actions\ExecuteArtisanCommandAction"
tags: [contract, action, artisan, process, security]
created: 2026-11-24
updated: 2026-11-24
---

# ExecuteArtisanCommandAction

Sorgente: `app/Actions/ExecuteArtisanCommandAction.php`. Chiamanti: `Xot/app/Filament/Pages/ArtisanCommandsManager.php`
(con `SuperAdminOnlyTrait` e `abort_unless(static::canAccess(), 403)` nel metodo) e
`User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`.

## Input

- `string $command`: il comando **senza** `php artisan`, comprese eventuali opzioni (`'passport:install --uuids'`).

## Output

- `array{command: string, output: list<string>, status: 'completed'|'failed', exitCode: int}`: le righe di stderr sono
  prefissate da `[ERROR] `.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| XOT-ARTISAN-EXEC-INV-1 | Esegue solo stringhe **identiche** a una voce di `$allowedCommands`; altrimenti nessun processo parte. | `XOT-ARTISAN-EXEC-INV-1` |
| XOT-ARTISAN-EXEC-INV-2 | Exit code 0 → `status = 'completed'`; diverso da 0 → `'failed'` con stderr in `output` prefissato `[ERROR]`. | `XOT-ARTISAN-EXEC-INV-2` |
| XOT-ARTISAN-EXEC-INV-3 | Il processo gira in `base_path()` con timeout di 300 secondi. | — |

## Effetti collaterali

- Avvia un processo `php artisan <command>` (`Illuminate\Support\Facades\Process`) e attende la fine, bloccando la
  richiesta. Gli effetti sono quelli del comando: l'elenco comprende `migrate` (schema del database),
  `config:cache`/`route:cache`/`view:cache`/`event:cache`, `queue:restart`, `passport:*` (chiavi e client OAuth).

## Errori

- `Webmozart\Assert\InvalidArgumentException` se `$command` è vuoto.
- `RuntimeException('Comando non consentito: <cmd>')` se non è in elenco.
- `RuntimeException("Errore durante l'esecuzione del comando …")` che avvolge qualsiasi eccezione del processo
  (timeout compreso). Un exit code diverso da 0 **non** è un'eccezione: è `status = 'failed'`.

## Non fa

- Non controlla chi chiama: l'autorizzazione (super-admin) è dei chiamanti, e va ripetuta nel metodo Livewire.
- Non accetta argomenti separati: un'opzione aggiuntiva rende il comando diverso e quindi rifiutato.
- Non trasmette l'output in tempo reale al browser né emette eventi (i dispatch `artisan-command.*` sono stati rimossi:
  vedi il commento in `tests/Unit/Actions/ExecuteArtisanCommandActionTest.php`).
- Non va estesa aggiungendo comandi distruttivi (`migrate:fresh`, `db:wipe`, `db:seed`) all'elenco.
