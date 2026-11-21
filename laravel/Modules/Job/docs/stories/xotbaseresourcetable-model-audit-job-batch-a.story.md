---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "xotbaseresourcetable model audit job batch a.story"
issues: []
discussions: []
id: story-job-xotbaseresourcetable-model-audit-batch-a
slug: xotbaseresourcetable-model-audit-job-batch-a
status: done
priority: medium
title: "Audit $model + colonne + UX — XotBaseResourceTable del modulo Job"
created_at: 2026-09-11
updated_at: 2026-09-11
bmad_phase: dev
module: Job
owned_scope:
  - app/Filament/Resources/ExportResource/Tables/ExportsTable.php
  - app/Filament/Resources/FailedImportRowResource/Tables/FailedImportRowsTable.php
  - app/Filament/Resources/FailedJobResource/Tables/FailedJobsTable.php
  - app/Filament/Resources/ImportResource/Tables/ImportsTable.php
  - app/Filament/Resources/JobBatchResource/Tables/JobBatchesTable.php
  - app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php
  - app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php
  - app/Filament/Resources/JobResource/Tables/JobsTable.php
  - app/Filament/Resources/JobsWaitingResource/Tables/JobsTable.php
  - app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php
  - app/Filament/Resources/ScheduleResource/Tables/SchedulesTable.php
github_issue: null
github_discussion: null
---

# Modulo Job — audit `$model` + colonne reali + UX sulle XotBaseResourceTable

## Contesto

Batch di audit coordinato su tutte le classi `*Table extends XotBaseResourceTable`
del modulo Job (11 file), come da task orchestratore
`xotbaseresourcetable-model-audit`. Nessuna issue/discussion GitHub dedicata è stata
richiesta per questo batch: il coordinamento è avvenuto solo via lock file
(`bashscripts/lock/lock.sh`) sul singolo file toccato, coerente con la convenzione
locale "story a mano, niente skill bmad-*" già in memoria di progetto.

## Task 1 — `protected static string $model`

Alla presa in carico di questo batch, **tutti gli 11 file avevano già** la property
`protected static string $model = X::class;` impostata correttamente (probabilmente
un'altra sessione/batch aveva già eseguito questo stesso task in parallelo — i file
risultavano `M` in `git status` fin dall'inizio). Verifica di autorevolezza fatta
comunque leggendo ogni Resource sorella e/o il fallback `XotBaseResource::getModel()`:

| Table file | Model autorevole | Fonte |
|---|---|---|
| `ExportResource/Tables/ExportsTable.php` | `Export::class` | `ExportResource::$model` esplicito |
| `FailedImportRowResource/Tables/FailedImportRowsTable.php` | `FailedImportRow::class` | `FailedImportRowResource::$model` esplicito |
| `FailedJobResource/Tables/FailedJobsTable.php` | `FailedJob::class` | `FailedJobResource::$model` esplicito |
| `ImportResource/Tables/ImportsTable.php` | `Import::class` | `ImportResource::$model` esplicito |
| `JobBatchResource/Tables/JobBatchesTable.php` | `JobBatch::class` | `JobBatchResource::$model` è **commentato** (`// protected static ?string $model = JobBatch::class;`); risolto da `XotBaseResource::getModel()` per convenzione `Modules\Job\Models\JobBatch` (verificato: la classe esiste ed estende `Model`) |
| `JobBatchResource/Tables/JobBatchsTable.php` | `JobBatch::class` | idem sopra — vedi nota dead-code |
| `JobManagerResource/Tables/JobManagersTable.php` | `JobManager::class` | `JobManagerResource::$model` esplicito |
| `JobResource/Tables/JobsTable.php` | `Job::class` | `JobResource::$model` esplicito |
| `JobsWaitingResource/Tables/JobsTable.php` | `Job::class` | `JobsWaitingResource::$model` esplicito — **non** `JobsWaiting::class`, vedi nota sotto |
| `JobsWaitingResource/Tables/JobsWaitingsTable.php` | `Job::class` | idem sopra — vedi nota dead-code |
| `ScheduleResource/Tables/SchedulesTable.php` | `Schedule::class` | `ScheduleResource::$model` esplicito |

### Nota — `JobsWaitingResource` usa `Job::class`, non `JobsWaiting::class`

Esiste un model dedicato `Modules\Job\Models\JobsWaiting extends Job` (stessa tabella,
nessun override), ma `JobsWaitingResource` dichiara esplicitamente
`protected static ?string $model = Job::class;`. Non è un errore da correggere in
questo batch (la Resource è la fonte autorevole, per istruzioni task): segnalato qui
perché spiega anche il dead code sotto.

### Dead code rilevato (non toccato, solo segnalato — regola disciplina §7)

`XotBaseResource::getTableClass()` costruisce il nome della classe Table come
`Str::plural(class_basename(getModel())) . 'Table'`, quindi la Table realmente
usata a runtime dipende dal `$model` della Resource, non dal nome del file:

- `JobBatchResource`: `getModel()` risolve a `JobBatch` → `Str::plural('JobBatch')`
  = `JobBatches` (verificato via tinker) → classe attesa `JobBatchesTable`.
  **`JobBatchesTable.php` è quella referenziata a runtime.**
  `JobBatchsTable.php` (senza "e", typo di pluralizzazione) **non è mai referenziata
  da `getTableClass()`** — contenuto quasi identico a `JobBatchesTable.php` (stesse
  colonne, stesso `$model`) ma senza `getTableHeaderActions()`/`getTableBulkActions()`.
  Dead code, non cancellato.
- `JobsWaitingResource`: `getModel()` = `Job::class` → `Str::plural('Job')` = `Jobs`
  (verificato via tinker) → classe attesa `JobsTable`.
  **`JobsWaitingResource/Tables/JobsTable.php` è quella referenziata a runtime.**
  `JobsWaitingsTable.php` (che pluralizza `JobsWaiting`, coerente con un vecchio
  `$model = JobsWaiting::class` mai committato o già rimosso) **non è mai
  referenziata**. Contenuto identico a `JobsTable.php` dello stesso namespace.
  Dead code, non cancellato.

Entrambi i casi sono coerenti con un refactor storico (rinominazione plurale o
cambio di `$model`) che ha lasciato il vecchio file orfano. Nessuna Resource li
referenzia con `getTableClass()`; verificato leggendo la funzione in
`Modules/Xot/app/Filament/Resources/XotBaseResource.php` e confermando la
pluralizzazione via `php artisan tinker`.

## Task 2 — verifica colonne reali

Colonne reali ottenute in sola lettura via
`Schema::connection($conn)->getColumnListing($table)` (connessione `job` per tutti
i model di questo modulo). Per ognuna delle 11 classi, tutte le chiavi dirette
(senza punto) di `getTableColumns()` esistono nella tabella reale. Nessuna colonna
sospetta/rinominata/rimossa trovata — verifica: `ok` per tutti gli 11 file.

Dettaglio (colonne dirette usate vs colonne reali, sottoinsieme sempre verificato):

- `Export` (tabella `exports`): `file_name, processed_rows, total_rows,
  successful_rows, completed_at, created_at` — tutte presenti. OK.
- `FailedImportRow` (tabella `failed_import_rows`): `import_id, validation_error,
  created_at` — tutte presenti. OK.
- `FailedJob` (tabella `failed_jobs`): `id, connection, queue, exception,
  failed_at` — tutte presenti. OK. Rilevata inoltre colonna reale `uuid`
  (identificatore usato da `php artisan queue:retry {uuid}`) mai mostrata in
  tabella — vedi Task 3.
- `Import` (tabella `imports`): stesse chiavi di `Export`. OK.
- `JobBatch` (tabella `job_batches`): `name, total_jobs, pending_jobs,
  failed_jobs, created_at, finished_at, cancelled_at, id` — tutte presenti. OK
  (in entrambi i file, vivo e dead-code).
- `JobManager` (tabella `job_managers`): `name, queue, failed, attempt, progress,
  started_at, finished_at` — tutte presenti. OK.
- `Job` (tabella `jobs`, config `queue.connections.database.table`): `id, queue,
  attempts, available_at, reserved_at, created_at` — tutte presenti. OK (in
  entrambi i namespace `JobResource` e `JobsWaitingResource`, e nel dead-code
  `JobsWaitingsTable`).
- `Schedule` (tabella `schedules`): `command, expression, status, command_custom,
  created_at, updated_at` — tutte presenti. OK.

Nessun `git log -S` necessario: zero chiavi sospette da investigare.

## Task 3 — miglioria UX (unica, mirata, basso rischio)

Unica modifica applicata: `FailedJobResource/Tables/FailedJobsTable.php`.

1. Aggiunta colonna `uuid` (`TextColumn::make('uuid')->searchable()->copyable()
   ->toggleable(isToggledHiddenByDefault: true)`): la tabella reale `failed_jobs`
   ha `id` auto-increment (`$table->id()`) e `uuid` come identificatore stabile
   — è il valore che serve per `php artisan queue:retry {uuid}`. Prima di questa
   modifica non era mai mostrato in tabella. Aggiunta additiva, nessuna colonna
   rimossa, `toggleable` nascosta di default per non alterare la vista corrente.
2. Aggiunto `->searchable()` alla colonna `exception` (prima solo `wrap()->limit(120)`):
   permette di cercare i job falliti per messaggio d'errore, colonna testuale
   ovviamente cercabile e non ancora coperta.

Nessun'altra Table del batch ha ricevuto modifiche: tutte le altre avevano già
`searchable()`/`sortable()`/`dateTime()`/`badge()` applicati in modo coerente sulle
colonne di testo/data/enum pertinenti (probabile esito di un batch precedente sullo
stesso task, dato che tutti gli 11 file risultavano già `M` in git status all'avvio
di questa sessione). Non è stata creata nessuna nuova classe Column condivisa;
dove esisteva un candidato a colonna aggregata "persona" (`Export`/`Import` hanno
`user_id`/`user_type`, `Export` eredita anche una relation `user()` da
`Filament\Actions\Exports\Models\Export`) si è scelto di **non** aggiungerla in
questo batch per rischio di collisione con altri batch paralleli sugli stessi file
e per restare nel perimetro "basso rischio" richiesto.

## Verifica

- `php -l` su `FailedJobsTable.php`: nessun errore di sintassi.
- `vendor/bin/phpstan analyse <11 file elencati in owned_scope> --no-progress` da
  `/var/www/_bases/base_quaeris_fila5/laravel`: **`[OK] No errors`**.
  Un primo tentativo è fallito con un errore di bootstrap Filament
  (`syntax error, unexpected token "<<"`) causato da un file di un altro modulo in
  edit concorrente da un'altra sessione (pattern noto, vedi memoria
  "misurare mentre un altro scrive"); il retry pochi secondi dopo è passato pulito
  — non era un problema di questi 11 file (confermato anche da `php -l` isolato,
  passato subito).

## File toccati in questo batch

Solo `app/Filament/Resources/FailedJobResource/Tables/FailedJobsTable.php` ha
ricevuto un diff da questa sessione. Gli altri 10 file dell'`owned_scope` erano già
modificati nel working tree prima dell'avvio di questa sessione (property `$model`
già presente, colonne già verificate come corrette, UX già coerente) — inclusi qui
solo a scopo di tracciamento/verifica, non ri-editati.
