---
title: "ADR — Comandi Artisan dalla UI: solo super-admin, allowlist a match esatto, autorizzazione ripetuta nel metodo"
type: decision
status: accepted
created: 2026-11-16
updated: 2026-11-24
module: Job
tags: [adr, artisan, filament, livewire, security, super-admin]
related:
  - ../bmad/decision-log.md
  - ../contracts/assert-allowed-artisan-command-action.md
qmd: "artisan commands from ui exact match"
---

# ADR: comandi Artisan dalla UI con allowlist a match esatto

## Contesto

Job espone pulsanti che lanciano comandi Artisan dal pannello: `Filament/Pages/JobStatus.php::artisan(string $cmd)`
(`Artisan::call($cmd)`), `Filament/Widgets/JobStatusWidget.php::artisan()` (`Artisan::call('queue:'.$cmd)`) e
`saveEnv()` che riscrive la riga `QUEUE_CONNECTION` di `.env`. Il nome del comando arriva dal client Livewire:
un metodo pubblico di un componente è richiamabile anche se la vista non mostra il pulsante, e `canAccess()`
protegge solo l'apertura della pagina, non le chiamate su un componente già montato. Senza filtro, chi apre la
pagina può chiedere `migrate:fresh --force` o `db:wipe`. Il decision log (`../bmad/decision-log.md`, D-1) registra
questo come pattern da estendere a tutti i widget. Come si lancia un comando Artisan scelto da un pulsante senza
trasformare la pagina in una shell remota?

## Driver della decisione

- Il nome del comando arriva dal client Livewire: un metodo pubblico di un componente è richiamabile anche se la vista non mostra
  il pulsante.
- `canAccess()` protegge solo l'apertura della pagina, non le chiamate su un componente già montato.
- Senza filtro, chi apre la pagina può chiedere comandi distruttivi (`migrate:fresh --force`, `db:wipe`): la pagina diventerebbe una
  shell remota.
- Ogni pacchetto installato aggiunge comandi, quindi l'insieme dei comandi pericolosi non si può elencare in modo completo.
- Nessun pulsante esistente richiede argomenti o opzioni liberi.
- Il decision log (`../bmad/decision-log.md`, D-1) chiede di estendere lo stesso schema a tutti i widget.

## Decisione

- La pagina o il widget usa `Modules\Xot\Filament\Traits\SuperAdminOnlyTrait` (`canAccess()` = ruolo `super-admin`).
- Ogni metodo pubblico che esegue o scrive **ripete** il controllo: `JobStatus::artisan()` lancia
  `AuthorizationException` se `! static::canAccess()`; `JobStatusWidget::authorizeSuperAdmin()` fa lo stesso per
  `artisan()`, `saveEnv()` e `dummyAction()`.
- Il comando passa solo se è **identico** (`in_array(..., true)`) a una voce dell'elenco dei pulsanti: per
  `JobStatus` l'elenco è derivato da `getActs()` (`getAllowedCommands()`), e il controllo è
  `Actions/Console/AssertAllowedArtisanCommandAction`. Niente argomenti né opzioni liberi: `queue:flush --force`
  non è `queue:flush`.
- `saveEnv()` accetta solo chiavi di `config('queue.connections')` fatte di `[A-Za-z0-9_-]` e sostituisce solo la
  riga `QUEUE_CONNECTION=<vecchio>`.

## Alternative scartate

- **Solo `canAccess()`**: non copre le chiamate Livewire dirette su un componente montato (vedi docblock di
  `JobStatus::artisan()`).
- **Blocklist dei comandi pericolosi** (`migrate:fresh`, `db:wipe`…): incompleta per costruzione, ogni pacchetto
  installato aggiunge comandi.
- **Match per prefisso o con parsing degli argomenti**: `route:list --json` o `queue:flush --force` passerebbero;
  il guadagno (parametri dalla UI) non serve a nessun pulsante esistente.
- **Policy Laravel per pagina**: le pagine non hanno un model; il trait condiviso di Xot è già lo standard.

## Conseguenze

- Buono: aggiungere un comando = aggiungere un pulsante in `getActs()`; non esiste un secondo elenco da allineare.
- Cattivo: i comandi che vogliono parametri (`queue:forget <id>`, `queue:retry-batch`) restano fuori (commentati in
  `getActs()`).
- Debito: `Filament/Widgets/ScheduleStatusWidget.php` ha l'allowlist a match esatto ma **non** usa
  `SuperAdminOnlyTrait` né ripete l'autorizzazione in `artisan()`; `JobStatusWidget` ha un elenco proprio invece
  di `AssertAllowedArtisanCommandAction`. Chi li tocca li allinea a questo ADR.

## Conferma

La decisione è rispettata finché i due test sotto restano verdi: coprono l'autorizzazione ripetuta nel metodo, il match esatto
dell'allowlist e la scrittura limitata di `saveEnv()`. Punti di applicazione:
`Modules/Job/app/Filament/Pages/JobStatus.php`, `Modules/Job/app/Filament/Widgets/JobStatusWidget.php` e
`Modules/Job/app/Actions/Console/AssertAllowedArtisanCommandAction.php`. Fuori dalla conferma automatica resta il debito di
`ScheduleStatusWidget` indicato in Conseguenze: finché non è allineato, chi lo tocca lo controlla a mano.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Job/tests/Unit/Filament/JobStatusAuthorizationTest.php`: fallisce se un non
  super-admin esegue un comando, se `migrate:fresh --force`, `queue:flush --force`, `QUEUE:CLEAR` o ` queue:clear`
  raggiungono `Kernel::call`, o se l'allowlist contiene `migrate`, `db:wipe`, `tinker`.
- `cd laravel && vendor/bin/pest Modules/Job/tests/Unit/Filament/JobStatusWidgetEnvWriteTest.php`: fallisce se
  `saveEnv()` scrive per un non super-admin, accetta un nome con a capo o `=`, o tocca righe diverse da
  `QUEUE_CONNECTION`.
- `--group=JOB-ARTISAN-INV-1` (contratto di `AssertAllowedArtisanCommandAction`).
