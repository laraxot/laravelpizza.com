---
title: "Job: architettura verificata sul codice"
type: architecture
module: Job
status: active
qmd: "Job architettura modelli resource action widget policy connessione job worker check allowlist artisan livewire legacy scheduler"
related:
  - ./README.md
  - ./audit.md
  - ./adr/index.md
  - ./contracts/index.md
---

# Job: architettura

Documento verificato sul codice (2026-11-25). Dove un'affermazione della documentazione storica contraddiceva il
codice, qui vince il codice e la differenza e' segnalata. Cio' che non funziona ancora e' in [audit.md](audit.md).

## Provider e pannello

- `Providers/JobServiceProvider` estende `XotBaseServiceProvider` (`$name = 'Job'`). Nel `boot()` chiama
  `Import::polymorphicUserRelationship()` ed `Export::polymorphicUserRelationship()` sui modelli di Filament e
  `registerQueue()`; **`registerQueue()` e `registerSchedule()` sono interamente commentati**: il modulo non
  aggancia ne' gli eventi della coda (`Queue::before/after/failing`) ne' lo scheduler su DB.
- `Providers/Filament/AdminPanelProvider` estende `XotBasePanelProvider` (`$module = 'Job'`): il modulo ha un
  pannello Filament proprio.
- Priorita' modulo 20 (`module.json`).

## Dati

Tutti i modelli estendono `Models/BaseModel` (`XotBaseModel`) e usano la connessione dedicata **`job`**
(`$connection = 'job'`; `Export` lo dichiara a parte perche' estende il modello di Filament). Tabelle
(14 migration, una per tabella): `jobs`, `job_batches`, `failed_jobs`, `job_manager`, `imports`, `exports`,
`failed_import_rows`, `schedule`, `schedule_histories`, `tasks`, `frequencies`, `parameters`, `results`,
`task_comments`.

| Livello | Model |
|---|---|
| Esecuzione (coda di Laravel) | `Job`, `JobsWaiting` (estende `Job`: stessa tabella `jobs`, job in attesa), `JobBatch`, `FailedJob` |
| Monitoraggio | `JobManager` (tracciamento esecuzioni), `Result`, `ScheduleHistory` |
| Import/Export (Filament) | `Import`, `Export`, `FailedImportRow` |
| Pianificazione | `Schedule`, `Task`, `Frequency`, `Parameter`, `TaskComment` |

Lo stato di `Schedule` e' l'enum `Enums/Status` (decisione D-0, vedi [audit.md](audit.md#decisioni)); `Schedule`
ha `Observers/ScheduleObserver`, che a ogni creazione/modifica/cancellazione svuota la cache delle schedulazioni
attive (`Actions/Schedule/ClearScheduleCacheAction`) e alla cancellazione marca `Status::Trashed`. Non ho trovato
dove venga registrato (nessun `ObservedBy`/`observe()` nel modulo, nessuno in `Xot/app/Providers`): lo esercita
solo `tests/Unit/JobExecuteCoverage50Test.php`.

### Policy

16 file in `Models/Policies`. Tredici estendono `JobBasePolicy` senza metodi propri: deny-by-default con bypass
per super-admin e `job::admin` (`JobBasePolicy::before`). **Non sono codice morto**: Laravel risolve la policy per
convenzione di nome (`Export` -> `ExportPolicy`), quindi `class ExportPolicy extends JobBasePolicy {}` e' il
binding modello-gerarchia. Una volta sono state cancellate come "YAGNI" e ripristinate: non cancellarle, non
fonderle in un file (guardia: `bashscripts/tools/guard-model-policy-delete.sh`). `JobPolicy`, `FailedJobPolicy`
e `JobBatchPolicy` ora estendono anch'esse `JobBasePolicy` con `create()` = false (story 0005).

## Filament

- 9 Resource (`Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`, `FailedJob`,
  `FailedImportRow`), ciascuna con sottocartelle `Pages/`, `Schemas/`, `Tables/` e, dove serve, `Widgets/`; tutte
  sopra `XotBase*`. `JobResource` non ha `CreateJob`/`EditJob`: la tabella `jobs` e' scritta dalla coda, non da una
  persona (D-3). Non esiste una `TaskResource`: l'unico CRUD della pianificazione e' `ScheduleResource`.
- Pagine: `JobStatus` (super-admin, pulsanti per i comandi Artisan ammessi), `JobMonitor`, `Dashboard`,
  `SettingPage` (flag del worker per tenant).
- Widget in `Filament/Widgets`: `JobStatusWidget` (super-admin, scrive `QUEUE_CONNECTION` validato contro
  `config('queue.connections')`), `ScheduleStatusWidget`, `ScheduleCrudWidget`, `ClockWidget`,
  `QueueListenWidget`. Altri widget statistici stanno dentro le Resource (`JobStatsOverview`,
  `JobsWaitingOverview`) e usano il trait `Traits/FormatSeconds` (probe PHPStan in `app/Phpstan/`).
- Ogni Resource popola le colonne della sua tabella con campi reali del modello: import/export con `file_name` e
  conteggi righe, job in attesa con coda e tentativi, import falliti con `validation_error`, schedulazioni con
  comando/espressione/stato; `available_at` e `reserved_at` di `jobs` sono timestamp UNIX interi.

## Action (nessun Service, nessun Support)

La logica nuova vive in Spatie Queueable Action (`use QueueableAction`, un solo `execute()`), 16 classi:

| Cartella | Action | Funzione |
|---|---|---|
| radice | `BuildQueueWorkerCommandAction` | costruisce la riga `queue:work` di `worker:check` con i flag interi del tenant |
| radice | `GetTaskCommandsAction`, `GetTaskFrequenciesAction` | elenco comandi e frequenze per i form di `Task`/`Schedule` |
| radice | `ExecuteTaskAction` | **stub**: lancia sempre `BadMethodCallException` (vedi audit P0-2) |
| radice | `DummyAction` | stampa `hello`, serve al widget di stato per generare carico |
| radice | `GetActiveSchedulesAction`, `ClearScheduleCacheAction` | **duplicati piatti, marcati SUPERSEDED/`@deprecated`**; quelle usate sono in `Schedule/` |
| `Schedule/` | `GetActiveSchedulesAction` | schedulazioni attive, con cache `rememberForever` se abilitata |
| `Schedule/` | `ClearScheduleCacheAction` | `Cache::store()->forget()` della chiave delle schedulazioni; chiamata da `ScheduleObserver` e da `schedule:clear-cache` |
| `Command/` | `GetCommandsAction`, `GetCommandArgumentsActions`, `GetCommandOptionsActions` | scoperta dei comandi Artisan e dei loro argomenti/opzioni |
| `Console/` | `AssertAllowedArtisanCommandAction` | ammette un comando solo se identico (strict) a una voce dell'allowlist |
| `Console/` | `GetJobStatusCommandsAction`, `GetQueueSubcommandsAction`, `GetScheduleStatusCommandsAction` | le allowlist dei pulsanti dei pannelli |

Il comportamento promesso da ciascuna e' nel suo [contratto](contracts/index.md); `AssertAllowedArtisanCommandAction`
e' la decisione di [ADR 0001](adr/0001-artisan-commands-from-ui-exact-match-allowlist.md).

Caso `ScheduleService`: la documentazione storica diceva "rimosso, sostituito da due Action". Il codice dice che
`app/Services/ScheduleService.php` (e un `.bak`) esiste ancora; non ha chiamanti di produzione, solo
`tests/Unit/Services/ScheduleServiceTest.php`, ed e' elencato come debito in `tests/Arch/debt.php`.

### Worker della coda

`Console/Commands/WorkerCheck` (`worker:check`, lanciabile anche dal pulsante di `JobStatus`) avvia il worker con
una riga di shell `queue:work ... > /dev/null & echo $!` e tiene il PID in `queue.pid` sul disco `cache`. I flag
(`max_attempts` 3, `timeout_seconds` 60, `sleep_seconds` 5) vengono da `Datas/JobConfigData`, solo come `int`, e
si cambiano da `SettingPage` per tenant: [ADR 0003](adr/0003-queue-worker-flags-from-tenant-settings.md).
`timeout_seconds` deve restare sotto `retry_after` della connessione di coda; nessun controllo lo impone.

### Sicurezza dei comandi Artisan da UI

Pattern unico (D-1): `SuperAdminOnlyTrait` + allowlist a match esatto + autorizzazione ripetuta dentro il metodo
Livewire (`canAccess()` protegge l'apertura della pagina, non le chiamate gia' montate). Oggi lo applicano
`JobStatus` e `JobStatusWidget`; gli altri widget operativi no (audit P1-2).

### Niente `Support`

`app/Support/` non esiste piu': `AllowedArtisanCommands` e' stato sostituito dalle quattro Action di `Console/`
perche' l'allowlist e' una policy di sicurezza, non un helper statico, e le Action si testano e si auditano in modo
uniforme. Business logic nuova: Action, mai `app/Services`.

## Livewire legacy

`app/Http/Livewire/` contiene ancora quattro classi: `Broad` (con un `dd('fine')`), `Job/Status`,
`Schedule/Status`, `Schedule/Crud`, piu' `_components.json` con i quattro alias. Sono i predecessori dei widget
Filament e **non sono stati ritirati**, contrariamente a quanto dicevano inventario e story 12.1: dettagli e
fix in [audit.md](audit.md#p1-1). Verdetto dell'inventario Livewire->Filament (2026-09): nessun componente era
in uno slot widget del chrome (zero candidati alla conversione diretta); `Job\Status` e' montato solo nel corpo di
`JobMonitor` ed e' gemello della pagina `JobStatus`; `Schedule\Status` e `Schedule\Crud` sono montati solo in
viste `admin/**` irraggiungibili. Regola per il futuro: se si vuole di nuovo un monitor della coda, e' una pagina
Filament con autenticazione super-admin, non un widget KPI, e non si copiano `putenv`/`queue:clear` in un widget
visibile in dashboard.

## Eventi e notifiche

`Events/` (`Executing`, `Executed`, `TaskEvent`, `BroadcastingEvent`, `PublicEvent`, `PrivateEvent`, `Event`) e
`Notifications/TaskCompleted` (`ShouldQueue`) esistono ma, finche' `registerSchedule` e' commentato, nessuno li
emette.

## Come si ragiona su questo modulo

Il modulo ha 17 model perche' le responsabilita' sono a strati: dominio della pianificazione (`Task`, `Schedule`,
`Frequency`, `Parameter`, `TaskComment`), esecuzione (`Job`, `JobBatch`, `FailedJob`, `JobsWaiting`) e osservabilita'
(`JobManager`, `Result`, `ScheduleHistory`, import/export). Il valore e' tenere la UI veloce spostando il lavoro
pesante fuori dal ciclo richiesta-risposta e rendere tutto osservabile: stato, fallimenti, ritentativi.
