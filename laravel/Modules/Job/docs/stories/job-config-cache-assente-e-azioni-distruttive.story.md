---
title: "Job: config cache assente, azioni distruttive senza guardia, SQL su date"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Job
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente sulla cache dello scheduler (ritirare o ripristinare)", "guardia DB dentro (solo per i test Pest)"]
related: [./services-to-actions-job.story.md, ./02.Job-merge-conflict-resolution.story.md, ./job-livewire-ritiro-con-widget-gemelli.story.md, ../scopo.md, ../../../Xot/docs/stories/test-database-guard.story.md]
tags: [bmad, job, config, cache, failed-jobs, truncate, sql, timestampdiff]
---

# Job: config cache assente, azioni distruttive senza guardia, SQL su date

Fase BMAD: Analisi e specifica (pronta per lo sviluppo; nessun PHP toccato).

## Richiesta

Come maintainer del modulo Job voglio che la cache dello scheduler sia o reale o rimossa, che "cancella tutti i job falliti" passi da una Action autorizzata e tracciata, e che le statistiche dei job usino un calcolo di durata corretto, cosi' che nessun pulsante lanci eccezioni, nessun clic cancelli dati senza traccia e nessun numero sia sbagliato in silenzio.
Il perche': la prima parte e' gia' nota come "decisione W3" ([services-to-actions-job](./services-to-actions-job.story.md) righe 66-68, [02.Job-merge-conflict-resolution](./02.Job-merge-conflict-resolution.story.md) followup 1, [scopo](../scopo.md)) ma nessuno l'ha decisa; il resto e' nuovo.

## Scopo

- `schedule:clear-cache` (modulo) doveva svuotare la cache dei `Schedule` letti dal DB, come nel pacchetto `husam-tariq/filament-database-schedule` da cui e' copiato. Serve all'operatore che modifica uno schedule e vuole vederlo attivo subito.
- `delete_all` nella pagina dei job falliti serve all'operatore per ripulire la coda dopo aver risolto un guasto.
- `JobStatsOverview` e `JobsWaitingOverview` mostrano all'operatore tempo totale e medio di esecuzione dei job.

## Stato misurato

Misure del 2026-10-20 13:49 UTC, da `laravel/`.
- Config: `grep -n cache Modules/Job/config/config.php Modules/Job/config/Config/config.php; echo rc=$?` stampa solo `rc=1` (nessuna chiave). Controprova: `grep -c "'name'" Modules/Job/config/config.php` stampa `1` (il file e' leggibile e contiene `name` e `icon`).
- `git grep -n 'job::cache' -- Modules ':!*.md' ':!coverage.xml' | wc -l` stampa `4`: `ClearScheduleCacheAction.php:17,18`, `ScheduleObserver.php:64`, `tests/Unit/JobExecuteCoverage50Test.php:393`.
- Il prefisso `job::` non esiste: `Xot/app/Providers/XotBaseServiceProvider.php:187-203` (`registerConfig`) fa `Config::set('job.<nome file>', require $file)`, quindi il solo percorso valido sarebbe `job.config.cache.*`. Nessun repository di config custom (`rg -P "extends\s+Repository|singleton\(\s*['\"]config['\"]"` nel repo: 0 risultati; controprova: `rg -n "class Repository implements" vendor/laravel/framework/src/Illuminate/Config` trova 1 riga, quindi lo strumento vede le classi). `config('job::cache.store')` e' una chiave letterale mai definita: `Assert::string` lancia.
- Osservatore mai registrato: `git grep -nE "ScheduleObserver|ObservedBy|::observe\(|->observe\(" -- Modules app Themes ':!*.md' ':!coverage.xml'` trova solo la classe e il test. Quindi `ScheduleObserver` non gira in produzione, e se girasse `config('job::cache.enabled')` e' null.
- Nessuno scrive la cache: in `Modules/Job/app` l'unica riga con `Cache::` e' `ClearScheduleCacheAction.php:20` (`forget`). La registrazione degli schedule da DB e' tutta commentata (`JobServiceProvider.php:35-42` e `69-114`).
- Raggiungibile dall'interfaccia: `schedule:clear-cache` e' nelle liste di `ScheduleStatusWidget.php:41` e `Actions/Console/GetScheduleStatusCommandsAction.php:20`; `Console/Commands/ScheduleClearCacheCommand.php:18` ha la stessa firma di un comando di Laravel (`vendor/laravel/framework/src/Illuminate/Console/Scheduling/ScheduleClearCacheCommand.php`, descrizione "Delete the cached mutex files created by scheduler"). Quale dei due vinca non e' misurato (serve `artisan`).
- Distruttivi: `git grep -nE "truncate\(" -- Modules/Job/app` trova `FailedJobResource/Pages/ListFailedJobs.php:43` (`DB::table(...)->truncate()`) e `FailedJobResource/Tables/FailedJobsTable.php:56` (`FailedJob::truncate()`). Hanno `requiresConfirmation()` (il brief non lo diceva): manca autorizzazione per azione, traccia, stringhe in `lang/` (le notifiche sono in inglese hardcoded). `FailedJobPolicy` (`Models/Policies/FailedJobPolicy.php`) e' una copia di una policy Team: `viewAny` torna `false` (riga 18), `delete(UserContract, Team)` (riga 74), nessun `deleteAny`; non esiste `Gate::before`. Chi arriva davvero alla pagina non e' misurato.
- SQL: `git grep -nE "finished_at - started_at" -- Modules/Job ':!*.md'` stampa 6 righe in 3 file: `JobResource/Widgets/JobStatsOverview.php:26-27`, `JobManagerResource/Widgets/JobStatsOverview.php:26-27` (copia identica della precedente), `JobsWaitingResource/Widgets/JobsWaitingOverview.php:38-39`. Le colonne sono `timestamp` (`database/migrations/2024_01_01_000000_create_job_manager_table.php:20-21`).
- Correzione al brief: `Models/Result.php:77` e' `avg(duration)` su una colonna stringa, non una sottrazione di date; non fa parte di questo difetto.
- Collaterale nei due `JobStatsOverview`: `__('jobs::translations.*')` usa il namespace `jobs`, ma `loadTranslationsFrom(..., 'job')` (`XotBaseServiceProvider.php:109`); `translations.php` esiste in de, en, es, fr, nb_NO e non in it. Le etichette escono come chiavi grezze.

## Lavoro

1. Decisione cache (utente, vedi sotto). Raccomandata A, ritirare: cancellare `Console/Commands/ScheduleClearCacheCommand.php` (e la voce in `app/Console/Commands/_components.json`), `Actions/ClearScheduleCacheAction.php`, `ScheduleObserver::clearCache()`, `tests/Unit/Actions/ClearScheduleCacheActionTest.php`, la riga 393 del test di copertura, le voci `schedule:clear-cache` in `ScheduleStatusWidget.php:41` e `GetScheduleStatusCommandsAction.php:20`. Poi il nome resta al comando di Laravel (mutex dello scheduler), che funziona. Variante B, ripristinare: `cache => ['enabled','store','key']` in `config/config.php`, letta come `job.config.cache.*`, piu' un osservatore registrato e uno scrittore della cache; costo alto per una feature che oggi nessuno usa.
2. Failed jobs: Action `Modules\Job\Actions\FailedJob\DeleteAllFailedJobsAction` (`QueueableAction`, `execute(): int`) che chiama `app('queue.failer')->flush()` (rispetta driver e connessione di `config('queue.failed')`, a differenza di `TRUNCATE`, che in MySQL e' DDL, fa commit implicito e azzera l'auto-increment) e registra `activity()->causedBy(auth()->user())->withProperties(['deleted' => $n])` come in `Modules/User/app/Actions/Activity/LogRegistrationAction.php`. I due punti d'ingresso (Page e Table) diventano una sola `Action` Filament che chiama quella Action. Aggiungere `FailedJobPolicy::deleteAny(UserContract $user): bool` e `->visible()`/`->authorize()` su di essa. Notifiche e label in `Modules/Job/lang/*/failed_jobs.php`.
3. SQL: una sola Action `GetJobManagerStatsAction` (count, secondi totali, secondi medi) con `SUM(TIMESTAMPDIFF(SECOND, started_at, finished_at))` e `AVG(...)` su righe con `finished_at IS NOT NULL`; i tre widget la chiamano. In MySQL `finished_at - started_at` converte i `timestamp` in numeri `YYYYMMDDHHMMSS` e li sottrae: tra le 10:00:50 e le 10:01:10 da' 60 invece di 20, tra le 10:59:50 e le 11:00:10 da' 4060 (documentato, da riprovare con le query qui sotto).
4. Namespace lang: `jobs::translations` diventa `job::translations`; aggiungere `lang/it/translations.php`.
Rischio: il punto 1A cambia l'elenco dei comandi mostrati agli operatori; il 2 cambia chi puo' svuotare la coda.

## Acceptance criteria

- [ ] `git grep -n 'job::cache' -- Modules ':!*.md' ':!coverage.xml'` stampa 0 righe (variante A) oppure `config/config.php` definisce `cache` e `git grep -n "job::" -- Modules/Job/app` e' 0 (variante B).
- [ ] `git grep -nE "truncate\(" -- Modules/Job/app` stampa 0 righe.
- [ ] `DeleteAllFailedJobsAction` esiste, usa `QueueableAction`, ha test che copre utente non autorizzato (rifiutato) e autorizzato (log presente).
- [ ] `git grep -nE "finished_at - started_at" -- Modules/Job ':!*.md'` stampa 0 righe.
- [ ] `git grep -n "jobs::" -- Modules/Job/app Modules/Job/resources` stampa 0 righe.
- [ ] PHPStan gated sui file toccati: exit 0.

## Verifica

- Durata: dopo la guardia DB, `SELECT TIMESTAMPDIFF(SECOND,'2026-10-20 10:00:50','2026-10-20 10:01:10') AS a, CAST('2026-10-20 10:01:10' AS UNSIGNED)-CAST('2026-10-20 10:00:50' AS UNSIGNED) AS b;` deve dare `a=20`, `b=60`. Non usa tabelle.
- Comando: `cd laravel && php artisan help schedule:clear-cache | head -3`; la descrizione dice quale comando vince ("Clears the cache of the scheduler." e' del modulo). Dopo la variante A deve dire "Delete the cached mutex files".
- Controprova degli zeri: ripetere i `git grep` con `rg -P -e` e confrontare; ogni zero deve diventare non zero se si incolla una riga di prova nel file e si ripete.
- `php -l` sui file toccati; PHPStan con il gate dei Vincoli.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: nessun `truncate` ne' `DB::raw` nuovo; nessun accesso al DB oggi (le query di Verifica sono per domani); le Action non fanno da proxy di relazioni Eloquent.

## Decisioni aperte

1. Cache dello scheduler: ritirare (A) o ripristinare (B). Raccomando A: nessuno scrive la cache, l'osservatore non e' registrato, lo scheduling da DB e' commentato.
2. Chi puo' svuotare i job falliti: solo super-admin. Raccomando di si, con `deleteAny` esplicito.
3. Se la pagina dei job falliti deve essere raggiungibile: `viewAny` e' `false` per tutti. Va deciso insieme al punto 2.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && git grep -n 'job::cache' -- Modules ':!*.md' ':!coverage.xml'` e rileggere `Job/app/Filament/Resources/FailedJobResource/` (Pages e Tables).
2. Chiedere all'utente le tre decisioni; poi scrivere in ordine: Action di cancellazione e policy, Action delle statistiche, ritiro della cache; un file PHP alla volta, con il lock.
3. Verificare con `php -l`, PHPStan col gate sui file toccati e i `git grep` degli AC; le query SQL solo dopo la guardia DB.
