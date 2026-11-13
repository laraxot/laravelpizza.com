---
title: "SendTestMail in app/Console su produzione: causa e prevenzione"
type: story
bmad: true
status: complete
created: 2026-11-12
owner: module:Notify
module: Notify
related: [modular-architecture, console-commands, production-hotfix]
tags: [console, commands, architecture, production]
---

# SendTestMail in app/Console su produzione: causa e prevenzione

## Contesto

Su produzione (`/home/ploi/fixcity.eu/laravel/app/Console/Commands/SendTestMail.php`)
era stato trovato un comando artisan fuori dal modulo owner. Nel checkout
analizzato il file originario sotto `laravel/app/Console/Commands/` non faceva
parte del baseline del repository: risultava invece presente come modifica
locale staged/untracked (`AD` nel worktree). È stato quindi trasferito,
senza revert, nella posizione modulare canonica:
`laravel/Modules/Notify/app/Console/Commands/SendTestMail.php`.

Il dominio del comando (invio email di test) appartiene al modulo **Notify**, che
gia' espone comandi propri auto-registrati:

- `Modules/Notify/app/Console/Commands/SendMailCommand.php` (`notify:send-mail`)
- `CleanupNotificationLogsCommand`, `MigrateNotifyThemesToMailTemplateCommand`,
  `TelegramWebhook`, `AnalyzeTranslationFiles`

Registrazione: `XotBaseServiceProvider::registerCommands()` scansiona
`Modules/<M>/app/Console/Commands` e namespace `Modules\<M>\Console\Commands`.

## Perche' e' successo (root cause)

1. **Origine fuori dal modulo**: il comando era stato creato/portato sotto
   `app/Console/Commands` (in produzione e poi nella modifica locale), invece di
   essere assegnato fin dall'inizio a Notify.
2. **`app/Console/Commands` e' una convenzione Laravel "silenziosa"**: se la
   cartella esiste, i comandi vengono auto-scopati — funziona, quindi l'errore
   non produce sintomi evidenti, ma bypassa git, i test e i confini modulari.
3. **Nessun gate** che impedisse file PHP nuovi sotto `app/` fuori dai moduli.

## Fix

- **Produzione**: rimuovere il file stray
  `/home/ploi/fixcity.eu/laravel/app/Console/Commands/SendTestMail.php`
  (e la cartella se resta vuota), poi `php artisan optimize:clear`.
- **Repo**: il comando è stato spostato nella posizione canonica
  `Modules/Notify/app/Console/Commands/SendTestMail.php`, con namespace
  `Modules\Notify\Console\Commands` e firma `mail:test`.
- Per il test email interattivo resta disponibile `php artisan notify:send-mail`;
  `mail:test` è il comando Mailtrap non interattivo equivalente al file rinvenuto.

## Prevenzione — non deve succedere piu'

Gate architetturale in `Modules/Xot/tests/Architecture/ModulesArchitectureTest.php`:
test che fallisce se esistono classi PHP sotto `laravel/app/Console/` (o se
`app/Console/Commands` contiene file). Qualunque comando artisan deve vivere in
`Modules/<Modulo>/app/Console/Commands` con namespace `Modules\<Modulo>\Console\Commands`.

In piu': regola documentata qui e in `docs/wiki` — i comandi di modulo si
scansiono via `XotBaseServiceProvider`, non si crea nulla in `app/Console`.

## File toccati

- `Modules/Xot/tests/Architecture/ModulesArchitectureTest.php` — nuovo test di gate
- `Modules/Notify/app/Console/Commands/SendTestMail.php` — comando trasferito e ora canonico
- `Modules/Notify/tests/Unit/Console/Commands/SendTestMailOwnershipTest.php` — test di ownership
- `Modules/Notify/docs/command-ownership.md` — regola persistente
- `Modules/Notify/docs/stories/send-test-mail-wrong-location.story.md` — questa story

## Verifica

- `php artisan test Modules/Notify/tests/Unit/Console/Commands/SendTestMailOwnershipTest.php`
  passa.
- Nel run congiunto, il gate `has no PHP classes under app/Console` passa.
- La suite completa `Modules/Xot/tests/Architecture/ModulesArchitectureTest.php`
  resta non verde per difetti preesistenti/non correlati (`RouteService.php` sotto
  `Modules/Xot/app/Services` e ciclo `Tenant<->User`); non va attribuito al move.
