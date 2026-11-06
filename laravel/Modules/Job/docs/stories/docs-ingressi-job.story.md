---
title: "Ingressi della cartella docs di Job rivisti sul codice"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Job
tags: [docs, organizzazione, indice, bmad, verifica-codice]
qmd: "job docs ingressi README 00-INDEX index.md stale scheduler non collegato ScheduleService eliminato famiglie radice DOC-010 DOC-002"
related:
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
  - ./services-to-actions-job.story.md
---

# Ingressi della cartella docs di Job rivisti sul codice

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Ordine del 2026-10-14: studiare il modulo vero, confrontare ogni affermazione degli ingressi (`README.md`, `00-INDEX.md`,
`index.md`, wiki di primo livello) con il codice, correggere solo con fatti verificati, dichiarare directory canoniche,
evidence e legacy, senza spostare, rinominare o cancellare file. Contratto: `bmad-output/docs-architecture/module-theme-docs-contract.md`.

## Analisi (cosa fa davvero il modulo)

`Modules/Job` (pacchetto `laraxot/module_job_fila5`) e' una vista Filament sulle tabelle delle code Laravel piu' un archivio
di schedule su DB. Verificato il 2026-10-14 con `ls`/`grep` su `laravel/Modules/Job`:

- 13 Actions, 9 Resource Filament, 3 pagine, 5 widget, 4 comandi artisan, 14 migrazioni, 47 file PHP in `tests/` (43 `*Test.php`).
- `routes/web.php` vuoto e `routes/api.php` interamente commentato: nessuna rotta HTTP propria.
- `config/config.php` contiene solo `name` e `icon`; il codice legge pero' `job::model`, `job::cache.*`, `job::history_collapsed`,
  `jobs.pruning.*`, mai definite nel modulo.
- Lo scheduler su DB non e' collegato: `JobServiceProvider::registerSchedule()` e `registerQueue()` sono interamente
  commentati, `Executing`/`Executed` sono dispatchati solo li', `ScheduleObserver` non e' registrato, `GetActiveSchedulesAction`
  non ha chiamanti di produzione. L'esecuzione manuale passa da `ScheduleCrudWidget` (e dal vecchio `Http/Livewire/Schedule/Crud`).
- `app/Services/` non esiste: `ScheduleService` fu eliminato l'8 ottobre (story `2026-10-08-services-to-actions-job`), mentre
  `README.md` della cartella lo dava come "unico service rimasto".

## Cosa dicevano i docs di falso o di non verificato

| File | Affermazione | Esito |
|---|---|---|
| `README.md` | "unico service rimasto: ScheduleService" | falso, eliminato |
| `README.md` | `JobsWaiting`: "vista sulla stessa tabella" | impreciso: sottoclasse vuota di `Job` |
| `README.md` | "Scheduler su DB" come funzione attiva | non collegato (vedi sopra) |
| `00-INDEX.md` | "Module version 2.3.0" | nessuna fonte (`composer.json`, `module.json`, `CHANGELOG.md`) |
| `00-INDEX.md` | `queueable-action.md` = guida a code e worker | e' una regola con segnaposto `<nome progetto>` |
| `00-INDEX.md` | `schedule.md`, `filament.md`, `soketi.md` = configurazione/dashboard/real-time | tre elenchi di URL esterni |
| `00-INDEX.md` | `analysis.md` = batch processing | analisi generica con albero di cartelle |
| `00-INDEX.md` | `roadmap.md` = obiettivi 2026 | modello 2025 con segnaposto e "0% COMPLETATO" |
| `00-INDEX.md` | `README.md` = `./readme.md` | sono due file distinti (badge business card vs README cartella) |
| `index.md` | JobService, JobScheduler, JobMonitor (servizio), JobDispatcher, FailureHandler, JobSchedule, JobScheduleResource | nessuna esiste; `JobMonitor` e' solo una Page Filament |

## Modifiche

- `README.md`: frontmatter (`status: active`, `qmd`, `updated`), ownership, mappa del codice con path veri, limiti verificati,
  quick start, nota sul README di modulo (`../README.md` elenca `Services` e `Phpstan` fra le aree di `app/`: non esistono; fuori perimetro, non toccato).
- `00-INDEX.md`: `status: active`, descrizioni corrette, followups aggiornati (ScheduleService eliminato, Http/Livewire ancora presente,
  `getFormSchemaOld()` di istanza chiamato in modo statico a `tests/Unit/JobExecuteCoverage50Test.php:120`), tabella
  canoniche/evidence/legacy con conteggi, famiglie dei 250 file della radice classificate per nome file, sezione duplicati.
- `index.md`: `docs-organizer stale --fix` (status `stale` + nota), link a Xot corretto (`../xot/docs/index.md` -> `../../Xot/docs/README.md`).
- `wiki/00-index.md`: `stale` (copia parziale di `../00-INDEX.md`), 5 link `./x.md` -> `../x.md`.
- `wiki/index.md` e `wiki/INDEX.md` (due file distinti con lo stesso testo): link ad `ai-harness-module-discipline` portato a
  `../../../Fixcity/docs/wiki/concepts/ai-harness-module-discipline.md` (esiste), rimando a `../00-INDEX.md`.
- `wiki/log.md`: voce 2026-10-14; il link a `llm-wiki.txt` (file inesistente) reso testo.
- Nessun file cancellato, spostato o rinominato.

## Verifica

Misura con `python3 bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Job/docs --by-name`
(dry-run, eventi `unresolved`), solo sui file toccati:

| File | prima | dopo |
|---|---|---|
| `index.md` | 1 | 0 |
| `wiki/00-index.md` | 6 | 1 (`./phpstan-fixes-archive-2.md`, inesistente, dichiarato nella nota) |
| `wiki/INDEX.md` | 2 | 0 |
| `wiki/index.md` | 2 | 0 |
| `wiki/log.md` | 1 | 0 |
| `README.md`, `00-INDEX.md` | 0 | 0 |

Totale sui file toccati: 12 -> 1. Il totale del modulo era 593 eventi `unresolved` alle 07:40 (10 se misurato con il filtro di
default alle 07:38, vedi Decisioni). Ogni file linkato dall'indice e' stato verificato con `ls`.
PHPStan e Pest NON sono stati rieseguiti: l'ultimo esito noto (PHPStan exit 0, 2026-10-07) e' riportato come tale.

## Decisioni

- Non si crea un indice alternativo: `00-INDEX.md` resta il solo indice; `index.md`, `INDEX.md`, `wiki/00-index.md` sono dichiarati non canonici.
- Nessun `dups --fix`, nessun trasferimento: i 250 file della radice restano dove sono (DOC-004/006 richiedono revisione umana).
- Difetto di `docs-organizer.py`: `links`, `frontmatter` e `dups` scartano in silenzio i file con mtime < 10 minuti
  (riga `files = [p for p in md_files(docs) if not is_busy(p)]`, senza evento): subito dopo una passata `--fix` la misura
  vede una frazione del perimetro (Job: 10 eventi alle 07:38, 593 alle 07:40). Per misurare: `--busy-minutes 0` (sola lettura).

## Aperto

- Collegare lo scheduler (o dichiarare formalmente il modulo come solo archivio) e definire le chiavi di config mancanti: decisione di prodotto, non di docs.
- Ritirare `app/Http/Livewire` (4 file) e `resources/views/livewire`.
- `../README.md` del modulo (fuori da `docs/`): aggiornare la scheda tecnica (`Services`, `Phpstan` non esistono piu'; test 47 file, non 49).
- Link ancora non risolti nel resto di `docs/` (582 dopo questa story): a bersagli in `Themes/docs/shared-components/`, `Sigma` (modulo inesistente), `COMPONENTS.md`: da annotare o riscrivere file per file.
- Frontmatter spurio a meta' di `wiki/log.md` (blocco `module: "Job"`): lo tratta `docs-organizer frontmatter`.
