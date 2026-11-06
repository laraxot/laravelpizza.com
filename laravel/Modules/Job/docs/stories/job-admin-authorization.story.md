---
title: "[STORY] Job - autorizzazione di pagina e widget operativi (P0)"
type: story
status: review
priority: high
created: 2026-10-29
updated: 2026-10-29
module: Job
tags: [bmad, security, authorization, livewire, filament, artisan, env]
qmd: "job JobStatus JobStatusWidget super-admin SuperAdminOnlyTrait AssertAllowedArtisanCommandAction Locked old_value QUEUE_CONNECTION allowlist"
related:
  - ./12.1.retire-job-http-livewire.story.md
  - ../../../Xot/app/Filament/Traits/SuperAdminOnlyTrait.php
---

# Job - autorizzazione di pagina e widget operativi (P0)

## Scopo

Due superfici operative del pannello `job::admin` erano raggiungibili da qualunque utente con quel ruolo, non solo dal
super-admin:

- la pagina `JobStatus` esponeva un metodo Livewire che eseguiva un comando Artisan scelto dal client;
- il widget `JobStatusWidget` scriveva `QUEUE_CONNECTION` in `.env` con un valore scelto dal client, senza validarlo.

Obiettivo: solo il super-admin le usa, i comandi sono un elenco chiuso, il valore scritto in `.env` e' una connessione
queue configurata.

## Causa radice

1. Le pagine Filament senza `canAccess()` sono aperte a chiunque entri nel pannello; il ruolo `job::admin` basta.
2. Un metodo pubblico di un componente Livewire e' richiamabile dal client anche se il pulsante non lo mostra: l'elenco dei
   comandi stava solo nella vista, il server non lo ricontrollava.
3. `AssertAllowedArtisanCommandAction` esisteva ma non aveva chiamanti.
4. Le proprieta' pubbliche di un componente sono scrivibili dal client se non sono `#[Locked]`; `old_value` (usata per
   cercare la riga da sostituire) e `form_data` lo erano. Il valore finiva nel file senza controllo del contenuto.

## Cosa e' cambiato

Tutto in `laravel/Modules/Job/app/Filament/`:

| File | Modifica |
|------|----------|
| `Pages/JobStatus.php` | `use SuperAdminOnlyTrait` (accesso alla pagina solo super-admin). `artisan()` ricontrolla `canAccess()` e lancia `AuthorizationException` se negato; poi passa da `AssertAllowedArtisanCommandAction` con l'elenco dei pulsanti (`getAllowedCommands()`, match esatto); un comando fuori elenco viene scartato senza esecuzione e senza output. `getActs()` ora dichiara la forma `object{name, label}`. |
| `Widgets/JobStatusWidget.php` | `#[Locked]` su `old_value`. `saveEnv()` (chiamata anche da `updatedFormData`) ricontrolla il super-admin; accetta solo i nomi in `config('queue.connections')` fatti di `[A-Za-z0-9_-]` (`getAllowedConnections()`); un valore non ammesso viene scartato e il selettore torna al valore corrente. La scrittura usa `LOCK_EX`; `putenv` avviene dopo la scrittura del file. Il percorso del file passa da `envFilePath()` (seam per i test). Anche `artisan()` e `dummyAction()` ricontrollano il super-admin (`authorizeSuperAdmin()`), e `canView()` nasconde il widget ai non super-admin dove e' registrato in un pannello. |

Nessuna nuova costante di stato, nessuna modifica a Xot.

## Test

Pest puri (nessun database, nessun bootstrap dell'app; `Application` vuota + mock di `Filament::auth()` e del kernel Artisan):

- `tests/Unit/Filament/JobStatusAuthorizationTest.php`: `canAccess()` negato a ospiti, utenti senza ruolo e non-utenti di progetto,
  consentito al super-admin; `artisan()` rifiutato al non super-admin; comandi fuori elenco mai eseguiti dal kernel;
  comando in elenco eseguito solo con match esatto; l'Action solleva `InvalidArgumentException` fuori elenco.
- `tests/Unit/Filament/JobStatusWidgetEnvWriteTest.php`: `old_value` e' `#[Locked]`; valori con a capo, `=`, spazi o non
  configurati lasciano il file invariato; non super-admin riceve `AuthorizationException`; un valore valido modifica solo la
  riga `QUEUE_CONNECTION` (su file temporaneo, mai il vero `.env`); `canView()` falso ai non super-admin; `artisan()` e
  `dummyAction()` negati ai non super-admin; con super-admin solo le sottocomandi `queue:*` in elenco arrivano al kernel.

Stato: scritti e controllati con `php -l`; **non eseguiti** (il `.env.testing` punta a un database con dati reali).
PHPStan su `Modules/Job` (app e tests): nessun errore.

## Rischi e aperti

- I test non sono stati eseguiti: l'avvio senza `TestCase` del modulo (che apre transazioni sul DB) e il container
  minimo vanno confermati alla prima esecuzione in un ambiente senza dati reali.
- La lettura-modifica-scrittura di `.env` resta non atomica tra processi (il `LOCK_EX` copre solo la scrittura).
- Altre pagine e punti del modulo non sono coperti da questa story: il dettaglio di cio' che resta da chiudere sta nel
  report riservato dell'audit (repo `bashscripts`), non in questo repository pubblico.
- Quali comandi dell'elenco (`queue:clear`, `queue:flush`) debbano restare esposti e' una scelta di prodotto.
