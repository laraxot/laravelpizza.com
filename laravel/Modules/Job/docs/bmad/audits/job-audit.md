---
title: "Audit approfondito modulo Job"
type: audit
status: review
updated: 2026-11-16
module: Job
qmd: "audit approfondito Job code scheduler jobs failed_jobs policy create payload JobServiceProvider registerSchedule ExecuteTaskAction Livewire legacy widget senza guard PHPStan Pest"
related:
  - ../audit.md
  - ../piano-miglioramento.md
  - ../purpose.md
  - ../architecture.md
  - ../epics.md
  - ../../ecc/job-ecc-audit.md
  - ../stories/module-bmad-audit.story.md
---

# Audit approfondito — Job

## Metodo

<<<<<<< .merge_file_m1MW3r
Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 176 |
| Test PHP | 84 |
| Models (`app/Models/*.php`) | 17 |
| Policy files (approx) | 32 |
| Resource Filament | 9 |
| Actions | 16 |
| Services | 1 |
| Migration | 14 |
| Lang IT files | 114 |
| Marker conflitto | 0 |
| Occorrenze `return true` in Policy | 5 |
| Ratio test/app | 0.48 |

## Scopo (da docs esistenti / codice)

## Lo scopo in una frase **Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP: code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro

## Finding preliminari (da inventario)

- **P1** `1` file sotto `app/Services/`: verificare migrazione ad Actions Queueable (convenzione PTVX).

## Finding approfonditi (codice)

- **P0** `create()` → `return true` su Job/FailedJob/JobBatch policy (pattern Jetstream/Team).
- **P0/P1** Import concreti `Modules\User\Models\User` / Team da modelli Job.
- **P1** `ScheduleService` duplica `GetActiveSchedulesAction` (anti-pattern Service).
- **P2** `echo` in `DummyAction`; `exec()` in `WorkerCheck`.

## Gate

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Job/tests --no-coverage
```

PHPStan `Modules` (2026-11-16): **0 errori** sul tree completo.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md)
- [ECC](../../ecc/job-ecc-audit.md)
- [Story](../stories/module-bmad-audit.story.md)
=======
>>>>>>> .merge_file_ex7bAW
Source-first, 2026-11-16: inventario filesystem, `rg -n` con `path:line`, lettura dei file
critici (policy, `JobServiceProvider`, widget, componenti Livewire legacy, `ExecuteTaskAction`),
`git log` sulle storie "done", PHPStan sul modulo, Pest sullo scratch DB del repo. La
documentazione è stata trattata come ipotesi: **dove codice e docs divergono vince il codice.**
Nessuna UI o screenshot inventati.

Limiti: l'esposizione runtime dei P0/P1 sull'autorizzazione **non** è stata provata in un
browser; è dedotta dal codice (policy + route Filament) e va chiusa con Pest (vedi epics).
Un altro agente ha modificato `tests/` durante l'audit (`ScheduleBusinessLogicTest.php`): il
conteggio test è quello delle 17:30 UTC del 2026-11-16.

## Scopo (perché esiste)

Job rende visibile e governabile ciò che accade fuori dalla richiesta HTTP: code, import,
export, lavori pianificati — e soprattutto i loro **fallimenti** ([purpose.md](../purpose.md)).
Criteri usati: (1) chi non è amministratore non deve poter inserire o far girare lavori;
(2) ciò che è pianificato deve davvero girare; (3) un lavoro che smette di partire deve farsi notare.

## Inventario misurato

| Area | Conteggio | Come |
|---|---:|---|
| PHP in `app/` | 176 | `find app -name '*.php'` |
| PHP in `tests/` / `*Test.php` / casi Pest | 55 / 49 / 369 | |
| Models top-level | 17 | + 2 file `.aaa` morti + 1 `.backup-…` in `app/Models` |
| Policy | 16 file | 3 su `UserBasePolicy` (Job, FailedJob, JobBatch), 13 su `JobBasePolicy` |
| Filament Resource | 9 | `Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`, `FailedJob`, `FailedImportRow` |
| Pagine standalone / pagine di Resource | 4 / 26 | `Dashboard`, `JobMonitor`, `JobStatus`, `SettingPage` |
| Widget | 8 | 5 in `Filament/Widgets` + 3 dentro Resource |
| Actions (`app/Actions`) | 16 | 2 coppie duplicate (vedi P2) |
| Services | **1** | `app/Services/ScheduleService.php`, nessun caller di produzione |
| Migration | 14 | tutte top-level |
| Lang IT | 57 file | |
| Marker conflitto | 0 | |
| `return true` in Policy | 5 | 2 in `JobBasePolicy::before()` (`:17,:22`) + 3 `create()` (vedi P0-1) |
| `strict_types` mancante | 0 | |
| `RefreshDatabase` | 0 | `migrate:fresh` citato solo in test negativi (vedi P1-3) |
| `dd()` / `echo` in `app/` | 2 | `Http/Livewire/Broad.php:41`, `Actions/DummyAction.php:19` |
| Doc `.md` in `docs/` | 625 | 101 senza frontmatter, 53 con nome non conforme |

## Quadro per area

| Area | Evidenza | Sev |
|---|---|---|
| Policy `Job`/`FailedJob`/`JobBatch` | boilerplate Team, `create()` = true per chiunque; `JobResource` espone `CreateJob` con campo `payload` | **P0** |
| Scheduler su DB | `registerSchedule` e hook di coda commentati; `ExecuteTaskAction` lancia eccezione | **P0** |
| `Http/Livewire` legacy | `Artisan::call($cmd)` senza allowlist né auth; scrive `.env`; `dd()` in `Broad`; story 12.1 "done" smentita | **P1** |
| Widget senza guard | `ScheduleStatusWidget`, `ScheduleCrudWidget`, `ClockWidget`, `QueueListenWidget` | **P1** |
| Test pericolosi / debolezze | `migrate:fresh` invocato su widget reale; 0 `Livewire::test` | **P1** |
| Docs vs codice | architettura circolare, purpose troncato, inventario Livewire obsoleto | **P1** |
| Service morto, duplicati, junk | `ScheduleService`, 2 coppie di Action, file `.aaa`/`.pid`/`.backup` | P2 |
| i18n | notifiche e flash con testo letterale | P2 |

## Finding

### P0-1 — Un utente qualsiasi può creare righe nella tabella `jobs`

- `app/Models/Policies/JobPolicy.php:11` — `class JobPolicy extends UserBasePolicy` (non `JobBasePolicy`): niente bypass `job::admin`; contenuto copiato dalla policy Team di Jetstream (`view(UserContract $user, Team $team)`, `addTeamMember`, …).
- `JobPolicy.php:32`, `FailedJobPolicy.php:32`, `JobBatchPolicy.php:32` — `create(UserContract $_user): bool { return true; }`; `viewAny`/`update` ritornano `false` (`JobPolicy.php:18,44`).
- `app/Filament/Resources/JobResource.php:31` registra `'create' => CreateJob::route('/create')`; `JobResource/Schemas/JobForm.php:26` espone `'payload' => TextInput::make('payload')->required()`.
- Effetto atteso: la lista è nascosta (`viewAny` false) ma la pagina di creazione si apre con `canCreate()` = true; chi la raggiunge può scrivere un `payload` arbitrario nella tabella che il worker consuma (payload serializzato → superficie di deserializzazione). Per l'amministratore `job::admin` l'effetto opposto: `viewAny` false e nessun bypass, quindi **non** vede le stesse risorse.
- **Non provato a runtime.** Prerequisito: l'utente deve poter entrare nel pannello `Job`.

**Fix:** `JobPolicy`, `FailedJobPolicy`, `JobBatchPolicy` → `JobBasePolicy` (deny-by-default + bypass admin), rimuovere i metodi Team; `JobResource` senza `CreateJob`/`EditJob`/`JobForm` (la tabella `jobs` non si compila a mano); Pest `actingAs` utente senza ruolo → 403 su `/create`.

### P0-2 — Lo scheduler su DB non esegue nulla

- `app/Providers/JobServiceProvider.php:38` — `$this->registerSchedule($schedule)` commentato nel `boot()`; il metodo `registerSchedule` (`:70-…`) è tutto dentro un blocco commento; `registerQueue()` (`:48-66`) ha `Queue::before/after/failing/exceptionOccurred` commentati.
- `app/Actions/GetActiveSchedulesAction.php` e `app/Actions/Schedule/GetActiveSchedulesAction.php`: nessun caller fuori da `tests/` (`rg` su tutti i moduli).
- `app/Actions/ExecuteTaskAction.php:18` — `throw new BadMethodCallException('… not implemented yet. See ROADMAP-2026.md')`.
- `app/Filament/Widgets/ScheduleCrudWidget.php:90` — `executeTask()` chiama l'Action e poi imposta il flash `'task [..] executed at ..'`: il pulsante "esegui ora" produce un errore, non l'esecuzione.
- Conseguenza sullo scopo: `Schedule`/`Task`/`Frequency`/`Parameter` si possono compilare da UI ma **non producono esecuzioni**; `ScheduleHistory`, `Result`, `JobManager` non vengono popolati dal modulo; il "job che smette di partire" ([purpose § 4](../purpose.md)) è indistinguibile dal "job che non è mai partito". Nessuna `TaskResource` (`rg 'TaskResource' app/Filament` → vuoto): l'unico CRUD è `ScheduleResource`.

**Fix (scelta in D-2):** o cablare `registerSchedule` + hook di coda (con Pest su un `Schedule` fittizio) e implementare `ExecuteTaskAction`; oppure dichiarare il modulo "solo monitor" e togliere dalla UI Schedule/Task/"esegui ora" per non promettere ciò che non fa.

### P1-1 — Componenti `Http/Livewire` legacy ancora presenti, registrati e senza guard

- `app/Http/Livewire/Job/Status.php:173-176` — `artisan(string $cmd)`: `Artisan::call('queue:'.$cmd)` senza allowlist né autorizzazione; `:154-170` `saveEnv()` riscrive `.env` (`File::put :169`) senza controllo né validazione del valore (il gemello Filament `JobStatusWidget::saveEnv` valida e richiede super-admin).
- `app/Http/Livewire/Schedule/Status.php:76` — `Artisan::call($cmd)` con **comando arbitrario**.
- `app/Http/Livewire/Broad.php:41` — `dd('fine')`; `resources/views/livewire/broad.blade.php` presente; `app/Http/Livewire/_components.json` elenca 4 alias (`broad`, `job.status`, `schedule.crud`, `schedule.status`).
- Story [12.1](../../stories/12.1.retire-job-http-livewire.story.md) è `status: done` e [livewire-inventory.md](../livewire-inventory.md) dichiara "Broad ritirato, `dd(` zero": **il codice dice il contrario** (`git log` mostra solo commit `.` su questi file). Esposizione: nessun `<livewire:job.status>` nei Blade del repo (`rg`), quindi montaggio oggi non raggiungibile da una vista; la registrazione effettiva degli alias non è stata verificata a runtime (`XotBaseServiceProvider` consuma `GetComponentsAction` per i comandi e i componenti Blade; per Livewire non trovata una chiamata `Livewire::component` in `Xot/app`).

**Fix:** cancellare le 4 classi, le viste e `_components.json` (i widget Filament le hanno già sostituite) e riaprire 12.1 con un Pest che fallisce se `Http/Livewire/*.php` esiste.

### P1-2 — Widget con effetti operativi senza autorizzazione

- Solo `JobStatusWidget` e la pagina `JobStatus` usano `SuperAdminOnlyTrait` (`rg SuperAdminOnlyTrait app/Filament`).
- `ScheduleStatusWidget.php:24-43` — allowlist di comandi **inclusi `schedule:run` e `schedule:clear-cache`**, eseguibile da chiunque veda il widget.
- `ClockWidget.php:32` e `QueueListenWidget.php:32` — `Process::path(base_path())->start('php artisan queue:listen …')` in un loop con `sleep(3)` (`:41`) senza autorizzazione, senza timeout, nella richiesta Livewire. `JobStatus::getHeaderWidgets()` monta `ClockWidget` (`JobStatus.php:26`) ma la pagina è super-admin; il widget no.
- `ScheduleCrudWidget` (lista Task + "esegui ora") senza guard.

**Fix:** `SuperAdminOnlyTrait` (o permesso dedicato) su tutti e quattro; sostituire il loop `sleep` con un job in coda o rimuovere i due widget `queue:listen`.

### P1-3 — Test che invoca `migrate:fresh` su un widget reale

- `tests/Unit/Filament/ScheduleStatusWidgetTest.php:14` — `$widget->artisan('migrate:fresh')` senza mock del kernel Artisan: passa finché l'allowlist regge; una regressione eseguirebbe `migrate:fresh` sul DB di test. Gli altri usi (`JobStatusAuthorizationTest.php:119,120,144,154`, `JobStatusWidgetEnvWriteTest.php:204`) sono negativi e corretti (`shouldReceive('call')->never()`).
- `tests/Unit/ScratchA9TmpTest.php` è un file temporaneo nel repo.
- 0 file `Livewire::test`; 24 file solo `ReflectionClass`.

**Fix:** mock del kernel (`->never()`) come in `JobStatusAuthorizationTest`; rimuovere lo scratch.

### P1-4 — Documentazione che contraddice il codice

- `docs/architecture.md` (`status: superseded`, `superseded_by: bmad/architecture.md`) ma `docs/bmad/architecture.md` **non esisteva**, e `docs/bmad/architecture/job-module.md` rimandava indietro a `docs/architecture.md`: riferimento circolare. Ora [architecture.md](../architecture.md) è la SSoT.
- `docs/bmad/purpose.md` era troncato a metà frase (14 righe); `epics.md`, `decision-log.md`, `brainstorming.md` mancavano. Sistemati in questo giro.
- `livewire-inventory.md`/story 12.1: vedi P1-1.

### P2 — debito

- **Service morto.** `app/Services/ScheduleService.php` è referenziato solo da `tests/Unit/Services/ScheduleServiceTest.php`; esiste la story `docs/stories/2026-10-08-services-to-actions-job.story.md`: chiuderla (Action o cancellazione).
- **Duplicati.** `app/Actions/GetActiveSchedulesAction.php` ≈ `app/Actions/Schedule/GetActiveSchedulesAction.php`; `app/Actions/ClearScheduleCacheAction.php` ≈ `app/Actions/Schedule/ClearScheduleCacheAction.php`; `Config/` e `config/`; `Entities/` e `entities/` vuote.
- **Junk.** `app/Models/BaseModel.php.backup-20251015-092511`, `app/Models/MonitoredScheduledTask*.aaa`, `app/Console/Commands/queue.pid`, `resources/views/livewire/job/status.blade.php.backup_20251210_092150`, `Untitled`, `config.php`, `webpack.mix.js`, `psalm.xml` alla root, `tests/feature` e `tests/unit` minuscoli accanto a `Feature`/`Unit`.
- **i18n.** Titoli letterali: `FailedJobResource/Tables/FailedJobsTable.php:54,64`, `JobBatchResource/Tables/JobBatchesTable.php:48`, `JobBatchResource/Pages/ListJobBatches.php:34`, flash in `ScheduleCrudWidget.php:92`; placeholder cron `'* * * * *'` in `ScheduleResource.php:127`, `ScheduleForm.php:107` (esempio di formato, non testo da tradurre: tollerato).
- **`DummyAction`** con `echo` (`Actions/DummyAction.php:19`), usata dal widget di stato per generare carico.
- **Modello utente concreto.** `app/Models/TaskComment.php:11` e `app/Models/Traits/TaskCommentRelations.php:9` importano `Modules\User\Models\User`: il modulo deve passare da `XotData`/`UserContract`, non dalla classe concreta.
- **`exec()` in `Console/Commands/WorkerCheck.php:62,123`**: il comando arriva da `BuildQueueWorkerCommandAction`, non da input utente; da tenere sotto osservazione.

## Verificato e non è un finding

- `JobStatus` (pagina) e `JobStatusWidget`: super-admin, allowlist a match esatto (`AssertAllowedArtisanCommandAction`), valore `QUEUE_CONNECTION` validato contro `config('queue.connections')` (`JobStatusWidget.php:108-128`), `old_value` `#[Locked]`; coperti da `JobStatusAuthorizationTest` e `JobStatusWidgetEnvWriteTest`.
- 13 policy su `JobBasePolicy` senza abilità proprie: deny-by-default + bypass `super-admin`/`job::admin` (`JobBasePolicy.php:14-25`).
- `DB::raw` (`Result.php:71`, `JobsWaitingOverview.php:28-39`, `JobStatsOverview.php:25-27` ×2): espressioni costanti, nessun input.
- 100% `strict_types`, 0 marker, 0 `RefreshDatabase`, 0 `property_exists`.

## Gate

| Gate | Esito |
|---|---|
| PHPStan `Modules/Job` (`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job --no-progress`) | **0 errori** (exit 0) |
| Pest `Modules/Job/tests` (scratch DB, host 127.0.0.1) | **parziale**: `tests/Unit/Filament/JobStatusAuthorizationTest.php` 17 pass (34 assert.); suite completa non eseguita per carico macchina (load ≈ 50) |

Nessun `migrate:fresh`, nessun `--force`, nessun `RefreshDatabase` lanciati dall'audit. Pest si esegue solo fuori dalla produzione e con DB di test raggiungibile.

Una revisione precedente di questo audit (inventario automatico) riportava 84 test, 32 policy e 114 file di lingua IT: conteggi approssimati, non confermati dal filesystem (ricontrollo 2026-11-19: 56 PHP in `tests/`, 16 policy, 57 file in `lang/it`).

## Piano

[piano-miglioramento.md](../piano-miglioramento.md) · [epics.md](../epics.md) · [decision-log.md](../decision-log.md).

## Riferimenti

[Sintesi](../audit.md) · [ECC](../../ecc/job-ecc-audit.md) · [Story](../stories/module-bmad-audit.story.md) · [Brainstorming](../brainstorming.md)
