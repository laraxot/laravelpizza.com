---
title: "[STORY] Rimozione delle chiamate di debug dal codice di produzione (Job)"
type: story
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Job
tags: [bmad, debug, dddx, filament, widget, livewire, queue, quality]
qmd: "job dddx ClockWidget QueueListenWidget beginStream beginProcess queue:listen wire:stream LogicException"
related:
  - ../roadmap-miglioramenti.md
  - ./12.1.retire-job-http-livewire.story.md
  - ../../../User/docs/stories/debug-calls-removal-user.story.md
---

# Rimozione delle chiamate di debug dal codice di produzione (Job)

## Fase BMAD

Fase di implementazione e verifica (quality gate), parte della wave sulle chiamate che fermano la richiesta (`dddx()` termina
con `dd()`).

## Siti: `Filament/Widgets/ClockWidget.php` e `QueueListenWidget.php`, metodo `beginStream()`

**Scopo capito.** I due widget mostrano in tempo reale, dentro Filament, l'output di `php artisan queue:listen` con `wire:stream`.
Il percorso che funziona e' `begin()` -> `beginProcess()` (`Process::start` piu' ciclo che inoltra `latestOutput()`): le viste
(`clock-widget.blade.php`, `queue-listen.blade.php`) chiamano solo `begin`. `beginStream()` e' un esperimento precedente, preso dal
blog citato nel docblock (`StreamOutput` su `php://stdout` e `Artisan::call('route:list')`): faceva `dddx($output)` e il ciclo che
avrebbe dovuto trasmettere era tutto commentato. Non e' mai stato funzionante. Nessun chiamante: due ricerche
(`rg -P` e `git grep -w`) trovano solo le definizioni. Resta pero' un metodo pubblico Livewire, quindi invocabile dal client da chi
vede il widget.

`ClockWidget` e' montato da `Pages\JobStatus` e da `Media\...\ListMediaConverts`; `QueueListenWidget` non e' referenziato altrove
(salvo auto-discovery del panel).

**Cosa ho fatto.** Il corpo di `beginStream()` e' ora `throw new \LogicException('<Widget>::beginStream() non implementato')`
(classe e metodo restano: nessun chiamante, quindi si segnala). Tolto il codice sperimentale non funzionante e i quattro `use` che
non servivano piu' (`Exception`, `Artisan`, `StreamOutput`, `Safe\fopen`). La proprieta' pubblica `$run`, ora orfana, e' rimasta
(stato Livewire: toglierla puo' dare errore a una pagina gia' aperta durante un deploy).

**Codice riattivato.** Nessuno: dopo il `dddx` c'era solo codice commentato.

**Rischio.** Nullo per l'utente (la UI usa `begin`). Una richiesta forgiata verso `beginStream` ora genera un'eccezione registrata
invece di un dump.

## Non toccato

`Http/Livewire/Broad.php:41` (`dd('fine')`): appartiene alla wave di ritiro Livewire verso widget, di un'altra sessione.

## Decisioni aperte

1. **Cancellare `beginStream()` e `$run`** quando nessuna pagina aperta li usa.
2. **I due widget sono doppioni** (cambia solo la vista e `--timeout=0` in `ClockWidget`): estrarre una base comune, come gia'
   suggerito in [roadmap-miglioramenti.md](../roadmap-miglioramenti.md) sezione 1.
3. **Rischio operativo osservato, non toccato.** `beginProcess()` avvia `queue:listen` (non termina mai) e resta in un ciclo con
   `sleep(3)` finche' il processo vive: ogni clic su "Start/Stop" occupa un worker PHP e lascia un processo figlio. Va ripensato
   (job in coda piu' broadcast, o solo lettura del log).

## Verifica

- Tokenizer su `Modules/Job/app`: resta solo `Http/Livewire/Broad.php:41` (fuori perimetro, altra sessione).
- `php -l` sui due file: nessun errore.
- PHPStan gated su `Modules/Job` intero: exit 0, nessun errore.
