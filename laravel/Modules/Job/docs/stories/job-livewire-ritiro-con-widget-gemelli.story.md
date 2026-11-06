---
title: "Job: ritiro dei 4 componenti Livewire con i widget gemelli"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Job
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente su saveEnv, dummyAction e comandi Artisan (sezione Decisioni aperte)", "guardia DB dentro (solo per i test Pest)"]
related: [./12.1.retire-job-http-livewire.story.md, ./debug-calls-removal-job.story.md, ./job-widget-clock-queuelisten-e-processo-bloccante.story.md, ./job-config-cache-assente-e-azioni-distruttive.story.md, ../../../Xot/docs/stories/livewire-widgets-w1-job.story.md, ../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md, ../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md, ../../../Xot/docs/bmad/livewire-widget-parallelization-plan.md]
tags: [bmad, job, livewire, filament-widgets, retire, allowlist, env, artisan]
---

# Job: ritiro dei 4 componenti Livewire con i widget gemelli

Fase BMAD: Specifica (gli esiti per componente sono pronti; la sola parte da decidere e' la sicurezza delle capacita' pericolose).

## Richiesta

Come maintainer voglio che nel modulo Job non resti nessun componente Livewire custom e che ogni capacita' pericolosa (scrittura di `.env`, esecuzione di comandi Artisan, accodare 1000 job) abbia una lista consentita e un'autorizzazione, cosi' che il ritiro non sposti un buco di sicurezza da un file all'altro.
Il perche': l'utente ha ordinato "non usiamo piu' componenti Livewire ma Filament widget". Il piano panel-first e' della wave W1/W2 dell'altra sessione ([fleet](../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md), [lane W1 Job](../../../Xot/docs/stories/livewire-widgets-w1-job.story.md)): qui c'e' il dettaglio del solo modulo Job.

## Scopo

I quattro componenti erano il pannello operativo del modulo: stato della coda e scelta della connessione (`Job\Status`), stato e comandi dello scheduler (`Schedule\Status`), elenco dei `Task` con "esegui ora" (`Schedule\Crud`), prova di broadcasting (`Broad`). Servono a chi amministra code e schedulazioni. Tre hanno gia' un gemello widget; `Broad` era una prova.

## Stato misurato

Misure del 2026-10-20 13:52 UTC, da `laravel/`.
- Componenti: `/usr/bin/find Modules/Job \( -path '*/Http/Livewire/*.php' -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'` stampa 4 file (45, 189, 118, 101 righe): `Http/Livewire/Broad.php`, `Job/Status.php`, `Schedule/Crud.php`, `Schedule/Status.php`. Dato dell'altra sessione confermato. Cartelle `app/Http/Livewire` presenti: 1 (piu' 2 sottocartelle); `app/Livewire`: 0. File tracciati in `resources/views/livewire`: `git ls-files Modules/Job/resources/views/livewire | wc -l` stampa `6`, piu' `app/Http/Livewire/.gitkeep` e `_components.json` (contenuto `[]`).
- Chiamanti di produzione: 0. Due metodi concordi: `git grep -nE "livewire:(job\.status|schedule\.(status|crud)|broad)|@livewire\(.(job\.status|schedule\.|broad)" -- Modules Themes app resources routes config ':!*.md'` e `rg -n -P` equivalente trovano solo 5 righe di docblock nei tre widget (`JobStatusWidget.php:21,25`, `ScheduleCrudWidget.php:18,21`, `ScheduleStatusWidget.php:11`) e 4 righe di `JobExecuteCoverage50Test.php:299-302`. Controprova: `git grep -nE "<livewire:" -- Modules Themes ':!*.md' | wc -l` stampa `22` (il pattern vede i tag altrove).
- Il gate della story 12.1 (tag `<livewire:job.status>` in `JobMonitor`) e' caduto: `resources/views/filament/pages/job-monitor.blade.php:6` monta `JobStatusWidget`.
- Il test `JobExecuteCoverage50Test.php:292-303` pretende che `Modules/Job/app/Http/Livewire` e `resources/views/livewire` NON esistano: oggi esistono, quindi (per lettura, non eseguito) e' rosso. La guardia `Modules/Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php` (glob `Modules/*/app/Http/Livewire`) idem.
- Debug: `php /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/3de8699e-5bcc-449f-9536-52a802b62a6b/scratchpad/dbg.php Modules/Job/app` stampa solo `Modules/Job/app/Http/Livewire/Broad.php:41 dd`. Non toccato apposta (vedi [debug-calls-removal-job](./debug-calls-removal-job.story.md)).

Matrice per componente (righe di codice reali):

| Componente | Gemello | Chiamanti widget | Differenze rilevanti | Rischio |
|---|---|---|---|---|
| `Job\Status` (189) | `Widgets/JobStatusWidget` (126) | `Pages/JobMonitor` vista riga 6; `views/admin/home.blade.php:8` | il widget ha la lista consentita (7 comandi `queue:`), il Livewire accetta qualunque `queue:<x>` (`Status.php:173-179`); il widget escapa l'output con `e()`; le etichette dei comandi sono perse | medio |
| `Schedule\Status` (101) | `Widgets/ScheduleStatusWidget` (49) | `views/admin/home.blade.php:11`, `admin/acts/schedule_manager.blade.php:8`, `admin/acts/schedule_status.blade.php:8` | il Livewire esegue QUALUNQUE comando (`Status.php:73-79`, per es. `migrate:fresh`); il widget ha 7 comandi, senza `schedule:work`; `getScheduledJobs()` non e' ripreso e nessuna vista lo usa | basso |
| `Schedule\Crud` (118) | `Widgets/ScheduleCrudWidget` (96) | `views/admin/home/acts/task.blade.php:7` | il widget aggiunge `getTasks()` e `getCommands()` (tutti i comandi, senza filtro: il filtro `totem.artisan.*` del Livewire era codice morto); `executeTask` chiama `ExecuteTaskAction::execute()` che lancia `BadMethodCallException` (`Actions/ExecuteTaskAction.php`, "not implemented"); `taskCreate` emette `modal.open` che nessuno ascolta | basso (stesso difetto nei due) |
| `Broad` (45) | nessuno | nessuno | `dd('fine')` alla riga 41; `PublicEvent` (`ShouldBroadcast`) resta con il suo test | basso |

Capacita' pericolose e gate attuale:

| Capacita' | Dove | Gate oggi |
|---|---|---|
| Scrivere `.env` (`QUEUE_CONNECTION`) | `Job\Status::saveEnv` righe 154-171; `JobStatusWidget::saveEnv` righe 80-97 | nessuna validazione: `form_data` e `old_value` sono proprieta' pubbliche modificabili dal client; la vista offre solo `sync` e `database` (`job-status.blade.php:13-16`) ma il valore non e' controllato; un valore con a capo scrive altre righe in `.env` |
| Comandi Artisan | Livewire sopra; `Pages/JobStatus.php:24-29` (`Artisan::call($cmd)` senza lista); widget con lista | i widget si; la pagina `JobStatus` e i due Livewire no |
| Distruttivi dei pulsanti | `queue:clear`, `queue:flush`, `queue:prune-*`, `queue:restart` nella lista di `JobStatusWidget.php:114-125` | un clic, nessuna conferma (`job-status.blade.php:25`), nessuna traccia |
| Accodare 1000 job | `dummyAction` in `JobStatusWidget.php:99-106` | nessuno |

Esiste `Xot/app/Actions/ExecuteArtisanCommandAction.php` con una lista privata (Passport, `migrate`, `queue:restart`): non copre i comandi Job e usa `Process`; non e' riusabile cosi' com'e'.

## Lavoro

1. `Pages/JobStatus.php:24-29`: aggiungere la lista consentita (stessa forma di `ScheduleStatusWidget::artisan`) oppure ritirare la pagina; togliere `zibibbo` dalla vista. Test come `tests/Unit/Filament/ScheduleStatusWidgetTest.php`, esteso a `JobStatusWidget` e `JobStatus`.
2. `JobStatusWidget`: `#[Locked]` su `old_value`; in `saveEnv` accettare solo chiavi di `config('queue.connections')`; spostare la scrittura di `.env` in una Action (`Actions/Env/SetQueueConnectionAction`); conferma e autorizzazione (super-admin) per `clear` e `flush`; `dummyAction` dietro autorizzazione o rimossa; `mount()` legge `config('queue.default')` invece di `getenv` che puo' tornare `false` e lanciare.
3. Ritiro, a gate verde, in questo ordine: cancellare `Http/Livewire/Job/Status.php`, `Schedule/Status.php`, `Schedule/Crud.php`, `Broad.php`, `_components.json`, `.gitkeep`; cancellare i 6 file di `resources/views/livewire`; togliere le due righe di docblock che citano il tag; poi la cartella `Http/Livewire` risulta assente. `Http/Livewire` non va ricreata da `GetComponentsAction` (vedi nota nel [fleet](../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md), W5).
4. Aggiornare 12.1 e `docs/bmad/livewire-inventory.md` con "ritirati", e le righe Job della matrice dell'altra sessione.
Rischio: le viste `views/admin/*` sono montate da nessuno che io abbia trovato (nessuna route esplicita): non cancellarle in questa story.

## Acceptance criteria

- [ ] `/usr/bin/find Modules/Job -type d \( -path '*/app/Http/Livewire' -o -path '*/app/Livewire' \) | wc -l` stampa `0` (oggi `1`); controprova `/usr/bin/find Modules/Job -type d -path '*/app/Http' | wc -l` stampa `1`.
- [ ] `git ls-files Modules/Job/resources/views/livewire | wc -l` stampa `0` (oggi `6`).
- [ ] `php /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/3de8699e-5bcc-449f-9536-52a802b62a6b/scratchpad/dbg.php Modules/Job/app` non stampa piu' righe.
- [ ] `Pages/JobStatus::artisan`, `JobStatusWidget::artisan` e `ScheduleStatusWidget::artisan` hanno una lista e un test che rifiuta `migrate:fresh`.
- [ ] `JobStatusWidget` non scrive `.env` per un valore fuori da `config('queue.connections')`; `old_value` e' `#[Locked]`.
- [ ] PHPStan gated su `Modules/Job`: exit 0.

## Verifica

- I tre comandi degli AC, ciascuno con controprova indicata; `git grep` dei tag dopo la cancellazione deve restare a 0 fuori da `docs/`.
- Dopo la guardia DB: Pest sul solo `Modules/Job/tests/Unit/Filament` e su `JobExecuteCoverage50Test.php` (il test di ritiro deve passare).
- `php -l` sui file toccati e PHPStan col gate dei Vincoli.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: nessun ritiro con un chiamante vivo (rimisurare i chiamanti il giorno stesso); non ricreare cartelle Livewire; `Broad.php` si cancella, non si ripara.

## Decisioni aperte

1. Cosa fare di `saveEnv`: tenerlo con validazione (raccomando, e solo super-admin) o toglierlo e lasciare la connessione ai deploy.
2. `dummyAction` (1000 job): raccomando di rimuoverlo; era una prova.
3. "Esegui ora" e "Nuovo" del `ScheduleCrudWidget` oggi non funzionano nei due gemelli: nasconderli finche' `ExecuteTaskAction` non e' implementata (raccomando) o lasciarli.
4. Le viste `views/admin/*` (7 file) sono ancora vive? Serve una conferma dell'utente prima di toccarle.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && /usr/bin/find Modules/Job \( -path '*/Http/Livewire/*.php' -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'` e i due `git grep` dei chiamanti: devono dare ancora 4 file e 0 chiamanti.
2. Ottenere le risposte alle decisioni 1-3, poi fare i punti 1 e 2 del Lavoro (sicurezza) prima del ritiro.
3. Ritirare i file nell'ordine del punto 3, verificare gli AC, aggiornare 12.1 e l'inventario dell'altra sessione.
