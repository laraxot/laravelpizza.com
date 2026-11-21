---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "xotbaseresourcetable dead code followup job.story"
issues: []
discussions: []
id: story-job-xotbaseresourcetable-dead-code-followup
slug: xotbaseresourcetable-dead-code-followup-job
status: done
priority: medium
title: "Follow-up — Table class dead code + $model bug (JobBatchResource, JobsWaitingResource)"
created_at: 2026-09-11
updated_at: 2026-09-11
bmad_phase: dev
module: Job
owned_scope:
  - app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php (deleted)
  - app/Filament/Resources/JobsWaitingResource.php
  - app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php
  - app/Filament/Resources/JobsWaitingResource/Tables/JobsTable.php (deleted)
  - tests/Unit/Filament/Resources/JobsWaitingResourceModelTest.php (new)
  - docs/coverage.md
github_issue: null
github_discussion: null
related:
  - "../../../../docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md"
  - "./xotbaseresourcetable-model-audit-job-batch-a.story.md"
---

# Follow-up — Table class dead code + `$model` bug (`JobBatchResource`, `JobsWaitingResource`)

## Contesto

Task assegnato dall'orchestratore per risolvere, nel modulo Job, i 2 item
segnalati (non ancora agiti) dalla story root
`xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`, che a
sua volta deriva dall'epic `xotbaseresourcetable-model-property-and-column-audit`.
La story di modulo `xotbaseresourcetable-model-audit-job-batch-a.story.md`
(status `done`, stessa data) aveva già documentato entrambi i casi come dead code
ma esplicitamente **non** li aveva risolti ("non è un errore da correggere in
questo batch, la Resource è la fonte autorevole, per istruzioni task" — task
diverso, solo audit). Questo follow-up chiude quel lavoro lasciato in sospeso.

## Item 1 — `JobBatchResource/Tables/JobBatchsTable.php` (typo di pluralizzazione)

**Verifica prima di cancellare** (`git log --follow`):
`JobBatchsTable.php` e `JobBatchesTable.php` sono stati creati **nello stesso
commit** (`a1d95ea2`, 2026-09-10), non in commit separati — quindi non è un
refactor a metà con un file "vecchio" e uno "nuovo": sono stati generati insieme,
uno come sottoinsieme dell'altro (`JobBatchsTable` non ha mai avuto
`getTableHeaderActions()`/`getTableBulkActions()`, `JobBatchesTable` sì fin
dall'inizio). `XotBaseResource::getTableClass()` su `JobBatchResource` risolve
`Str::plural('JobBatch')` = `'JobBatches'` → **`JobBatchesTable`**, mai
`JobBatchsTable` (typo, manca la "e"). `grep -rn JobBatchsTable` sull'intero
repo: zero riferimenti in codice, solo in documentazione (che descrive il dead
code, non lo usa).

**Azione**: cancellato `app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php`
(`git rm`).

## Item 2 — `JobsWaitingResource` usa `Job::class` invece di `JobsWaiting::class`

**Diagnosi**: è un bug reale, non un caso di "model non più esistente". Evidenze:

1. `Modules\Job\Models\JobsWaiting extends Job {}` esiste, è un model concreto
   (stessa tabella di `Job`, nessun override — coerente con "vista dedicata sullo
   stesso storage").
2. Ha una `JobsWaitingFactory` dedicata (`database/factories/JobsWaitingFactory.php`)
   e una `JobsWaitingPolicy` dedicata (`app/Models/Policies/JobsWaitingPolicy.php`,
   estende `JobBasePolicy`) — infrastruttura costruita apposta, mai raggiunta.
3. Verificato via tinker **prima del fix**: `Gate::getPolicyFor(JobsWaiting::class)`
   risolve comunque `JobsWaitingPolicy` (binding per classe target, indipendente dal
   bug), ma la Resource, usando `Job::class` come `$model`, autorizzava le sue azioni
   con `JobPolicy` (quella di `Job`, non quella di `JobsWaiting`) — la policy
   dedicata restava scritta ma inerte rispetto a questa Resource.
4. `JobResource` esiste già e possiede legittimamente `Job::class` con CRUD
   completo (`BoardJobs`, `CreateJob`, `EditJob`, `ListJobs`,
   `JobStatsOverview`). Far puntare anche `JobsWaitingResource` a `Job::class`
   la rendeva un doppione accidentale di `JobResource`, non una vista filtrata
   sulle sole "waiting jobs".
5. Le 4 Pages di `JobsWaitingResource` (`CreateJobsWaiting`, `EditJobsWaiting`,
   `ListJobsWaiting`, `ListJobsWaitings`) sono già nominate per `JobsWaiting`, non
   per `Job` — ulteriore segnale che l'intento originale era `JobsWaiting::class`.

**Fix applicato**: `JobsWaitingResource::$model = JobsWaiting::class` (era
`Job::class`).

**Conseguenza verificata via tinker** (prima/dopo):

| | Prima | Dopo |
|---|---|---|
| `JobsWaitingResource::getModel()` | `Job` | `JobsWaiting` |
| `JobsWaitingResource::getTableClass()` | `JobsWaitingResource\Tables\JobsTable` | `JobsWaitingResource\Tables\JobsWaitingsTable` |
| `Gate::getPolicyFor()` per la Resource | `JobPolicy` | `JobsWaitingPolicy` |

Il fix rende **vivo** `JobsWaitingsTable.php` (prima dead code) e rende
**morto** `JobsWaitingResource/Tables/JobsTable.php` — verificato con
`git log --follow` che è stato creato nello stesso commit di
`JobsWaitingsTable.php` (`a1d95ea2`), contenuto byte-identico a parte il nome
della classe e byte-identico anche a `JobResource/Tables/JobsTable.php`
(namespace diverso, nessuna collisione PHP, ma stesso identico scopo — puro
doppione, non un refactor in corso). Nessun riferimento nel codice
(`grep -rn "JobsWaitingResource\\\\Tables\\\\JobsTable"`: zero). **Cancellato**
insieme al fix, stessa logica dell'Item 1.

Aggiornato anche `JobsWaitingsTable::$model` da `Job::class` a
`JobsWaiting::class` (proprietà non letta da `XotBaseResourceTable` — verificato
`grep -n model` sulla classe base, zero occorrenze — ma lasciata sbagliata
sarebbe stata fuorviante ora che la classe è quella effettivamente risolta).

## Guard test

`tests/Unit/Filament/Resources/JobsWaitingResourceModelTest.php` (nuovo, 4
assert, gruppo `no-job-db`): fissa `getModel()`/`getTableClass()` per entrambe
le Resource, per lo stesso motivo documentato in memoria di progetto
("guard-test-beats-code-reading-multiagent" — questa classe di bug, `$model`
sbagliato che rompe la risoluzione per convenzione, si è già vista ripetersi in
altri moduli durante l'audit `xotbaseresourcetable-model-property-and-column-audit`).

## Verifica

- `cd laravel && vendor/bin/phpstan analyse Modules/Job --no-progress`: **[OK] No errors**.
- `cd laravel/Modules/Job && bash ../../tools/phpmd.sh <file> text ../../../docs/phpmd.ruleset.xml`
  sui 4 file toccati: **0 violazioni** (unico finding, pre-esistente e non
  toccato da questo diff: `JobsWaitingResource.php:24 LongVariable
  $shouldRegisterNavigation`, proprietà standard Filament).
- `cd laravel && XDEBUG_MODE=coverage vendor/bin/pest Modules/Job`: **323
  passed, 27 failed** (976 assertions, 180.23s). I 27 fallimenti sono
  pre-esistenti, non toccati da questo diff — dettaglio completo in
  `docs/coverage.md` (2026-09-11): incompatibilità Mockery in un helper
  condiviso (`JobExecuteCoverage50Test.php:70`) + un bug indipendente
  (chiamata statica a un metodo non statico) + asserzioni su `Task`/`Status`
  scollegate da `JobBatch`/`JobsWaiting`. Il nuovo guard test (4/4) e i test
  preesistenti che toccano `JobBatch`/le Table (`JobBatchBusinessLogicTest` —
  12/13 passano, l'unico fallimento è un'asserzione su dati DB condivisi non
  collegata al codice toccato) non mostrano regressioni introdotte da questo
  fix.

## GitHub

Nessuna issue aperta oggi in `laraxot/module_job_fila5` per questo audit
(`gh issue list --search "model-audit" --state all`: nessun risultato). Non
inventato un numero — nessun commento postato, come da istruzione esplicita
del task.
