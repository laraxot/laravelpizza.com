---
title: "Job: widget ClockWidget e QueueListenWidget, doppione con processo bloccante"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Job
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente: ritirare, unificare o ripristinare (vedi Decisioni aperte)"]
related: [./debug-calls-removal-job.story.md, ./job-livewire-ritiro-con-widget-gemelli.story.md, ./12.1.retire-job-http-livewire.story.md, ../roadmap-miglioramenti.md]
tags: [bmad, job, widget, filament, queue-listen, process, livewire-stream]
---

# Job: widget ClockWidget e QueueListenWidget, doppione con processo bloccante

Fase BMAD: Analisi e decisione (nessun PHP toccato; i due file hanno modifiche non committate dalla story [debug-calls-removal-job](./debug-calls-removal-job.story.md)).

## Richiesta

Come operatore voglio vedere dalla pagina di Filament che cosa fa la coda, cosi' che un lavoro bloccato si noti senza aprire un terminale; come maintainer voglio che per farlo non serva occupare un worker PHP per sempre a ogni clic.
Il perche': i due widget sono copie quasi identiche, uno e' montato in due pagine, l'altro in nessuna, e il metodo che li fa funzionare avvia un processo che non termina mai.

## Scopo

`Filament/Widgets/ClockWidget.php` e `QueueListenWidget.php` mostrano in una sezione l'output di `php artisan queue:listen` mentre scorre (`wire:stream="count"`), a partire da un pulsante "Start/Stop". Sono per chi amministra il pannello Job e per chi guarda le conversioni media. Lo scopo e' osservare la coda. Il nome "Clock" e' un residuo: il testo "Time:" mostra l'output del listener, non l'ora.

## Stato misurato

Misure del 2026-10-20 13:50 UTC, da `laravel/`.
- Duplicazione: `cmp Modules/Job/resources/views/filament/widgets/clock-widget.blade.php Modules/Job/resources/views/filament/widgets/queue-listen.blade.php` stampa `IDENTICAL`. `diff` dei due PHP (58 righe ciascuno) differisce in 8 righe di diff, cioe' 4 coppie: nome classe, nome della vista, riga 32 (`queue:listen --timeout=0` contro `queue:listen`) e il messaggio di `beginStream`.
- Chiamanti, due metodi concordi. `git grep -nwE "ClockWidget|QueueListenWidget" -- Modules Themes ':!*.md' ':!coverage.xml'` e `rg -n -P "\b(ClockWidget|QueueListenWidget)\b"` (stessa esclusione) danno 4 righe fuori dai file dei widget: `Job/app/Filament/Pages/JobStatus.php:8,20` (`getHeaderWidgets`) e `Media/app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php:7,21` (`getHeaderWidgets`). `QueueListenWidget`: 0 chiamanti.
- Il pannello Job scopre i widget (`XotBasePanelProvider.php:138` `discoverWidgets`) ma `XotBaseDashboard::getWidgets()` torna `[]`: nessuno dei due appare da solo in dashboard; compaiono solo dove montati.
- `beginStream()`: `git grep -nw beginStream -- Modules ':!*.md'` trova solo le due definizioni (`ClockWidget.php:54`, `QueueListenWidget.php:54`), ora `LogicException`.
- Processo: `git grep -n "Process::" -- Modules/Job/app` stampa 2 righe (`ClockWidget.php:32`, `QueueListenWidget.php:32`). Il ciclo `while ($process->running())` con `sleep(3)` (righe 33-45) non esce finche' `queue:listen` vive, cioe' mai. `queue:listen` non osserva soltanto: lancia `queue:work` per ogni job, quindi un clic avvia un secondo consumatore in concorrenza col worker vero. Non esiste "Stop": il pulsante richiama `begin()`. `$time` e' una proprieta' pubblica Livewire che accumula tutto l'output e viaggia nello snapshot a ogni risposta.
- Lo `stream()` invia `$this->time` prima di accodare `latestOutput()`: ogni emissione e' in ritardo di un ciclo (righe 35-44).
- Collaterale: `resources/views/filament/pages/job-status.blade.php:25` ha `wire:click="zibibbo()"` e `git grep -n "function zibibbo" -- Modules | wc -l` stampa `0`: il pulsante, nella pagina che monta `ClockWidget`, lancia un errore.
- Test: `git grep -nlE "ClockWidget|QueueListenWidget" -- 'Modules/*/tests' | wc -l` stampa `0`. Controprova: lo stesso comando con `ScheduleStatusWidget` trova `Modules/Job/tests/Unit/Filament/ScheduleStatusWidgetTest.php`.
- Non misurato: cosa succede al processo figlio quando PHP interrompe la richiesta per `max_execution_time`. Da provare in staging con `pgrep -af queue:listen` prima e dopo.

## Lavoro

1. Decisione (utente). Raccomandata A: ritirare entrambi.
2. Ritiro (A): in `Job`, cancellare `ClockWidget.php`, `QueueListenWidget.php` e le due viste; togliere `getHeaderWidgets()` da `Pages/JobStatus.php` (righe 17-22) e il bottone `zibibbo` da `job-status.blade.php`; in `Media`, togliere `getHeaderWidgets()` da `ListMediaConverts.php` (file di un altro modulo: farlo con l'agente Media, un solo agente per modulo). La visibilita' dello stato della coda resta a `JobStatusWidget` (`queue:monitor`, `worker:check`, conteggi di `Job`, `FailedJob`, `JobBatch`).
3. Alternativa B, unificare in sola lettura: un solo `QueueActivityWidget` con `wire:poll.5s` che legge le ultime righe di `JobManager` (colonne `started_at`, `finished_at`) tramite una Action `GetQueueActivityAction`; nessun `Process::`. Costo: una Action, una vista, chiavi in `lang/`, un test.
4. Alternativa C, ripristinare lo streaming: avviare il listener in un job in coda con `--max-time`, scrivere l'output su cache, pulsante Stop che ferma il pid. Costo alto e un compromesso operativo (chi puo' avviare worker dal web) che spetta all'utente; sconsigliata.
Rischio: A elimina la sola vista live, che pero' non consegna output affidabile (ritardo di un ciclo, nessuno Stop).

## Acceptance criteria

- [ ] A: `git grep -nwE "ClockWidget|QueueListenWidget" -- Modules Themes ':!*.md' ':!coverage.xml'` stampa 0 righe.
- [ ] `git grep -n "Process::" -- Modules/Job/app` stampa 0 righe.
- [ ] `git grep -nw beginStream -- Modules ':!*.md'` stampa 0 righe.
- [ ] `git grep -n zibibbo -- Modules/Job` stampa 0 righe.
- [ ] `ls Modules/Job/resources/views/filament/widgets/clock-widget.blade.php Modules/Job/resources/views/filament/widgets/queue-listen.blade.php` fallisce con due "No such file".
- [ ] `Media` ListMediaConverts non referenzia piu' Job `ClockWidget`; PHPStan gated su `Modules/Job` e sui file Media toccati: exit 0.

## Verifica

- I quattro `git grep` degli AC; controprova di ciascuno 0 con `rg -P -e` e, per i `Process::`, una riga di prova incollata temporaneamente (deve comparire e poi sparire).
- `php -l` sui file toccati; PHPStan col gate dei Vincoli.
- Stato dopo la modifica: `JobStatus` e `ListMediaConverts` restano raggiungibili (lettura del codice; niente browser oggi).

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: niente processi figli avviati da una richiesta web; non toccare `$run` finche' una pagina aperta durante il deploy potrebbe averlo nello snapshot (vedi [debug-calls-removal-job](./debug-calls-removal-job.story.md)).

## Decisioni aperte

1. Ritirare (A), unificare in sola lettura (B) o ripristinare lo streaming (C). Raccomando A ora e B solo se qualcuno chiede la vista live.
2. Se la modifica a `Media/.../ListMediaConverts.php` va fatta in questa story o in una lane Media separata. Raccomando una riga di coordinamento con l'agente Media, stessa sessione.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && git grep -nwE "ClockWidget|QueueListenWidget" -- Modules Themes ':!*.md' ':!coverage.xml'` per rimisurare i chiamanti; leggere `Job/app/Filament/Pages/JobStatus.php`.
2. Dopo la risposta dell'utente alla decisione 1, eseguire il ritiro nell'ordine: Media (togliere il montaggio), Job pagina, widget e viste.
3. `git grep` degli AC, `php -l`, PHPStan col gate; aggiornare questa story con lo stato e `debug-calls-removal-job` con il collegamento.
