---
title: "Audit approfondito modulo Activity"
type: audit
status: review
updated: 2026-11-16
module: Activity
qmd: "audit approfondito Activity audit trail activity_log stored events snapshots policy LoginListener PII redazione test vuoti PHPStan Pest"
related:
  - ../audit.md
  - ../piano-miglioramento.md
  - ../purpose.md
  - ../architecture.md
  - ../epics.md
  - ../../ecc/activity-ecc-audit.md
  - ../stories/module-bmad-audit.story.md
---

# Audit approfondito — Activity

## Metodo

Source-first, 2026-11-16: inventario filesystem, `rg -n` con `path:line`, lettura dei file
critici (listener, policy, Resource, Action di logging), `git log` sui test svuotati,
PHPStan sul modulo, Pest sullo scratch DB del repo. La documentazione è stata trattata come
ipotesi e verificata sul codice. Nessuna UI o screenshot inventati.

Limiti dichiarati: nessun test runtime del pannello Filament (nessun `Livewire::test` nel
modulo, vedi P1-5); l'esito Pest è nella sezione [Gate](#gate).

## Scopo (perché esiste)

Activity risponde a "chi ha cambiato cosa, quando e com'era prima". In una PA è un obbligo
di accountability, non una curiosità. Vedi [purpose.md](../purpose.md). Conseguenza
progettuale che l'audit usa come criterio: **il registro deve essere append-only, non deve
contenere segreti e deve registrare davvero gli eventi che dichiara di registrare.**

## Inventario misurato

| Area | Conteggio | Come |
|---|---:|---|
| PHP in `app/` | 92 | `find app -name '*.php'` |
| PHP in `tests/` / file `*Test.php` | 152 / 100 | di cui 11 file in `tests/graphify-out` (4 tracciati) |
| Casi Pest (`test(`/`it(`) | 486 (+5 `function test`) | `rg -o '^\s*(test\|it)\('` |
| Models top-level | 5 | `Activity`, `BaseModel`, `Snapshot`, `StoredEvent`, `TestModel` |
| Policy | 4 file (3 effettive) | `app/Models/Policies` |
| Filament Resource | 3 | `ActivityResource`, `SnapshotResource`, `StoredEventResource` |
| Pagine standalone / pagine di Resource | 5 / 10 | `Dashboard`, `ListLogActivities`, `LogViewer`, `SettingPage`, concern |
| Widget | 0 | |
| Actions (`app/Actions`) | 30 | |
| Services | 0 | giustificato: logica in Actions Queueable |
| Migration top-level / in `_bak/` | 9 / 7 | `database/migrations` |
| Lang IT | 19 file | 20 locale in `lang/` |
| Marker conflitto | 0 | `rg '^(<<<<<<<\|>>>>>>>) '` |
| `return true` in Policy | 2 | solo `before()` (`ActivityBasePolicy.php:17,22`) |
| `strict_types` mancante | 0 | |
| Label Filament hardcoded | 0 | `rg` su `->label/title/heading/...('` |
| `RefreshDatabase` / `migrate:fresh` | 0 usi | 3 file lo citano solo nei commenti |
| `@phpstan-ignore` | 1 | `Traits/HasSnapshots.php:7` (`trait.unused`, senza motivazione) |
| Doc `.md` in `docs/` | 782 | 331 senza frontmatter, 17 con nome non conforme |

## Quadro per area

| Area | Evidenza | Sev |
|---|---|---|
| Login non registrato dal listener | `LoginListener::handle()` vuoto | **P1** |
| Registro mutabile da UI | `EditActivity` con `DeleteAction`; Create/Edit su Activity, Snapshot, StoredEvent | **P1** |
| PII/segreti nel log | `LogModelUpdatedAction` salva attributi interi; redazione mai chiamata | **P1** |
| Test svuotati e saltati | 8 file senza casi, 19 punti di skip | **P1** |
| Copertura UI/autorizzazione | 0 file `Livewire::test`, `actingAs` in 3 file | **P1** |
| Bypass `activity::admin` non applicato | policy estendono `UserBasePolicy`, non `ActivityBasePolicy` | P2 |
| Duplicazioni | due `ActivityRecorderContract`, due `ActivityLogger` | P2 |
| Tabella di test in produzione | `TestModel` + migration `create_test_models_table` | P2 |
| Migrazioni vs contratto | 5 `create_activity_table` + `fix_causer_id_to_uuid` | P2 |
| Igiene root/docs | 8 `.md` e 4 `.code-workspace` fuori da `docs/` | P2 |

## Finding

### P1-1 — `LoginListener` è un segnaposto registrato

- `app/Listeners/LoginListener.php:12` — `handle(): void` senza parametro né corpo.
- `app/Providers/EventServiceProvider.php:22` — registrato su `Illuminate\Auth\Events\Login`.
- `tests/Unit/Listeners/LoginListenerTest.php:49-55` — 7 test `->skip('LoginListener::handle() logging not implemented')`.
- Il simmetrico `LogoutListener` invece registra (`app/Listeners/LogoutListener.php`).
- `LogUserLoginAction` esiste ma nessun codice di produzione la invoca (solo `Adapters/ActivityLogger.php:78`, a sua volta senza caller).
- Nota: il modulo User ha un proprio `LoginListener` che usa `RecordAuthenticationLogAction`; il login è quindi tracciato altrove. Il problema è la **promessa non mantenuta** di Activity (e la simmetria rotta login/logout), non l'assenza totale di traccia.

**Fix:** decisione in [decision-log](../decision-log.md) (D-3): o `handle(Login $event)` delega a `LogUserLoginAction`, o il listener e i 7 test skip vengono rimossi.

### P1-2 — Il registro si può modificare e cancellare da UI

- `app/Filament/Resources/ActivityResource/Pages/EditActivity.php:18` — `'delete' => DeleteAction::make()`.
- Esistono `CreateActivity`, `EditActivity`, `CreateSnapshot`, `EditSnapshot`, `CreateStoredEvent`, `EditStoredEvent` (`rg --files app/Filament/Resources`).
- Le policy (`ActivityPolicy.php`, `SnapshotPolicy.php`, `StoredEventPolicy.php`) sono per permesso (`activity.update`, `activity.delete`, …): corrette come meccanismo, ma nulla impone che il registro sia **append-only**. Chi ha `activity.update` può riscrivere la storia; per `StoredEvent` si rompe anche la coerenza dell'event sourcing.

**Fix:** Resource in sola lettura (`canCreate/canEdit/canDelete` = false, niente `Create*`/`Edit*`); la cancellazione solo tramite `ActivityMaintenanceAction` (retention) con permesso dedicato.

### P1-3 — I segreti non vengono redatti prima del log

- `app/Actions/LogModelUpdatedAction.php:43-44` — `'old' => $model->getOriginal()`, `'new' => $model->getAttributes()`.
- `app/Actions/LogModelCreatedAction.php:42` — `getAttributes()` completo.
- `app/Actions/RedactModelAttributesAction.php:19-24` toglie `password`, `remember_token`, `two_factor_*` ma **nessun file di produzione la chiama** (`rg RedactModelAttributesAction` → solo definizione e test).
<<<<<<< .merge_file_A0p2RL
<<<<<<< .merge_file_5MGVXY
<<<<<<< .merge_file_BeGqO3
<<<<<<< .merge_file_EeHy79
- Mitigazione reale: il percorso `Adapters\ActivityLogger` / `LogModel*Action` non ha caller fuori da Activity (`rg` su tutti i moduli, escluso `tests`/`docs`): gli altri moduli usano il helper `activity()` di Spatie (es. `User/app/Actions/Activity/LogRegistrationAction.php:21`). Il rischio è quindi **latente**: scatta appena qualcuno adotta l'API del modulo.
=======
=======
>>>>>>> .merge_file_6GVmJy
=======
>>>>>>> .merge_file_BbtTVJ
=======
>>>>>>> .merge_file_dvtsnR
<<<<<<< HEAD
<<<<<<< HEAD
- Mitigazione reale: il percorso `Adapters\ActivityLogger` / `LogModel*Action` non ha caller fuori da Activity (`rg` su tutti i moduli, escluso `tests`/`docs`): gli altri moduli usano il helper `activity()` di Spatie (es. `User/app/Actions/Activity/LogRegistrationAction.php:21`). Il rischio è quindi **latente**: scatta appena qualcuno adotta l'API del modulo.
=======
=======
=======
<<<<<<< HEAD
- Mitigazione reale: il percorso `Adapters\ActivityLogger` / `LogModel*Action` non ha caller fuori da Activity (`rg` su tutti i moduli, escluso `tests`/`docs`): gli altri moduli usano il helper `activity()` di Spatie (es. `User/app/Actions/Activity/LogRegistrationAction.php:21`). Il rischio è quindi **latente**: scatta appena qualcuno adotta l'API del modulo.
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_dOEWD9
- Mitigazione reale: il percorso `Adapters\ActivityLogger` / `LogModel*Action` non ha caller fuori da Activity (`rg` su tutti i moduli, escluso `tests`/`docs`): gli altri moduli usano il helper `activity()` di Spatie (es. `Ptv/app/Actions/Scheda/LogEmailSentAction.php:45`). Il rischio è quindi **latente**: scatta appena qualcuno adotta l'API del modulo.
=======
- Mitigazione reale: il percorso `Adapters\ActivityLogger` / `LogModel*Action` non ha caller fuori da Activity (`rg` su tutti i moduli, escluso `tests`/`docs`): gli altri moduli usano il helper `activity()` di Spatie (es. `User/app/Actions/Activity/LogRegistrationAction.php:21`). Il rischio è quindi **latente**: scatta appena qualcuno adotta l'API del modulo.
>>>>>>> .merge_file_VQiM7M
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_A0p2RL
<<<<<<< .merge_file_5MGVXY
<<<<<<< .merge_file_BeGqO3
>>>>>>> .merge_file_fKMiRS
=======
>>>>>>> .merge_file_6GVmJy
=======
>>>>>>> .merge_file_BbtTVJ
=======
>>>>>>> .merge_file_dvtsnR

**Fix:** chiamare `RedactModelAttributesAction` dentro `LogModelCreated/Updated/DeletedAction`; allargare la lista (token API, `*_secret`, codice fiscale se non necessario); test con modello `User`.

### P1-4 — Test svuotati e saltati

- 8 file `*Test.php` con zero casi (solo `use`): `Unit/Actions/ActivityActionsUnitTest.php` (14 righe), `Unit/Actions/QueryAndValidationTest.php`, `Unit/Actions/Log/ListLogFilesActionTest.php`, `Unit/CanPaginateUnitTest.php`, `Unit/Filament/ListLogActivitiesDeepCoverageTest.php`, `Unit/Filament/ListLogActivitiesRemainingCoverageTest.php`, `Unit/Listeners/LogoutListenerTest.php`, `Unit/Models/SnapshotBusinessLogicTest.php`.
- Causa verificata: `git log` — `ActivityActionsUnitTest.php` passa da **104 righe (`7cf6bc58`) a 14 (`35dbbfe8`)**; il corpo è recuperabile da `7cf6bc58`.
- 19 punti di skip: 7 in `LoginListenerTest.php:49-55`, 7 in `Feature/Actions/ListLogActivitiesActionTest.php:49-55`, 2 in `Feature/Filament/Actions/ListLogActivitiesActionTest.php:50-51`, 3 `markTestSkipped` condizionali (`Unit/Models/ActivityTest.php:17`, `Unit/Actions/Log/ResolveLogFilePathActionTest.php:79,91`).
- Esito: i test svuotati risultano "verdi" senza verificare nulla.

**Fix:** ripristinare i corpi da `7cf6bc58`, riallinearli al codice attuale; per gli skip dichiarati "non implementati" decidere se implementare (P1-1) o cancellare.

### P1-5 — Autorizzazione e UI senza test end-to-end

- `rg -l 'Livewire::test' tests` → 0 file; `actingAs` in 3 file; 26 file usano `ReflectionClass` (verificano la forma delle classi, non il comportamento).
- Superfici sensibili senza test di pannello: `LogViewer::canAccess` (`LogViewer.php:58`, delega a `AuthorizeLogAccessAction`), `ListLogActivities::restoreActivity` (gate `canRestoreActivity`, record-scoped), le 3 Resource.

**Fix:** Pest Feature con `actingAs` per ruoli `super-admin`, `activity::admin`, utente senza permesso (403) su LogViewer, restore e Resource.

### P2 — debito

- **Bypass admin non applicato.** `ActivityPolicy.php:10`, `SnapshotPolicy.php:10`, `StoredEventPolicy.php:10` estendono `UserBasePolicy`, che non ha `before()` (`rg 'function before' User/app/Models/Policies/UserBasePolicy.php` → vuoto). `ActivityBasePolicy` (con bypass `super-admin` e `activity::admin`, `:14-25`) non ha sottoclassi né caller. Il ruolo `activity::admin` quindi non ottiene il bypass dichiarato dall'ADR Xot; l'accesso dipende dai permessi.
- **Duplicati.** `app/Contracts/ActivityRecorderContract.php` e `app/Models/Contracts/ActivityRecorderContract.php` (stesso nome, due namespace); `app/Adapters/ActivityLogger.php` (134 righe) vs `app/Actions/ActivityLogger.php` (287 righe); l'intero set `Adapters/*` + `LogModel*Action` + `LogUser*Action` non ha caller di produzione.
- **`TestModel` in produzione.** `app/Models/TestModel.php` + `database/migrations/2026_03_05_000001_create_test_models_table.php` creano `test_models` nel DB reale.
- **Migrazioni.** 5 file `*_create_activity_table.php` + `2026_02_13_171410_fix_causer_id_to_uuid.php` nonostante il contratto in `2026_06_10_141000_create_activity_table.php:9-13` ("UNICA migrazione"); `database/migrations/_bak/` contiene 7 file, uno con `dropColumn('attribute_changes')` (`_bak/2026_07_01_000000_update_activity_log_schema.php:36`). Mai cancellare migrazioni già applicate: verificare la tabella `migrations` prima di consolidare.
- **Igiene.** `../../documentation-3.md`, `../../filament-3.md`, `test.md`, `test02.md`, `test03.md`, `test04.md`, `test2222.md`, `test444.md` e 4 `*.code-workspace` alla root del modulo; `docs/` con 331/782 file senza frontmatter e 17 nomi non conformi.
- **`@phpstan-ignore trait.unused`** senza motivazione (`Traits/HasSnapshots.php:7`).

## Verificato e non è un finding

- `return true` solo in `before()` per `super-admin` e `activity::admin` (`ActivityBasePolicy.php:17,22`); le abilità delle 3 policy sono per permesso (`hasPermissionTo('activity.*')`).
- `selectRaw('event, COUNT(*) as count')` (`Actions/Query/GetActivityStatisticsAction.php:85`, `Actions/ActivityLogger.php:258`): stringa costante, nessun input.
- Log file viewer: accesso a `super-admin` o `log.viewAny` (`AuthorizeLogAccessAction.php:21-27`), usato sia dalla pagina sia dal download.
- Restore: limitato al record corrente (`ListLogActivities::resolveActivity`, `:288-302`) e gate `canRestore` della Resource.
- 0 Services, 0 label hardcoded, 100% `strict_types`, 0 `RefreshDatabase`, 0 marker.

## Gate

| Gate | Esito |
|---|---|
| PHPStan `Modules/Activity` (`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Activity --no-progress`) | **0 errori** (`[OK] No errors`, 2026-11-16) |
| Pest `Modules/Activity/tests` (via `bashscripts/tools/pest-scratch-db.sh`, DB scratch, host 127.0.0.1) | **parziale**: suite completa non terminata (timeout 900 s, load ≈ 50; 16 pass e 40 ⨯ allo stop, non riproducibili in isolamento: `BaseModelBusinessLogicTest` 21 pass, `ActivityManagementTest` 4 pass); causa dei ⨯ non determinata |
<<<<<<< .merge_file_A0p2RL
<<<<<<< .merge_file_5MGVXY
<<<<<<< .merge_file_BeGqO3
<<<<<<< .merge_file_EeHy79
| Pest `Modules/Activity/tests/Feature` (stesso script, run separata dopo i fix della [story](../stories/module-bmad-audit.story.md)) | **0 failed / 181 passed / 9 skipped** (~660 s) |
=======
=======
>>>>>>> .merge_file_6GVmJy
=======
>>>>>>> .merge_file_BbtTVJ
=======
>>>>>>> .merge_file_dvtsnR
<<<<<<< HEAD
<<<<<<< HEAD
| Pest `Modules/Activity/tests/Feature` (stesso script, run separata dopo i fix della [story](../stories/module-bmad-audit.story.md)) | **0 failed / 181 passed / 9 skipped** (~660 s) |
=======
=======
=======
<<<<<<< HEAD
| Pest `Modules/Activity/tests/Feature` (stesso script, run separata dopo i fix della [story](../stories/module-bmad-audit.story.md)) | **0 failed / 181 passed / 9 skipped** (~660 s) |
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_dOEWD9
=======
| Pest `Modules/Activity/tests/Feature` (stesso script, run separata dopo i fix della [story](../stories/module-bmad-audit.story.md)) | **0 failed / 181 passed / 9 skipped** (~660 s) |
>>>>>>> .merge_file_VQiM7M
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_A0p2RL
<<<<<<< .merge_file_5MGVXY
<<<<<<< .merge_file_BeGqO3
>>>>>>> .merge_file_fKMiRS
=======
>>>>>>> .merge_file_6GVmJy
=======
>>>>>>> .merge_file_BbtTVJ
=======
>>>>>>> .merge_file_dvtsnR

Pest non è stato lanciato con il DB di test condiviso (`10.100.200.53`): è stato usato lo script
di scratch DB del repo, che crea e distrugge database usa-e-getta con sola struttura. Nessun
`migrate:fresh`, nessun `--force`, nessun `RefreshDatabase`.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md) e le epic in [epics.md](../epics.md).

## Riferimenti

- [Sintesi e gate](../audit.md) · [ECC](../../ecc/activity-ecc-audit.md) · [Story](../stories/module-bmad-audit.story.md)
- [Architettura](../architecture.md) · [Decision log](../decision-log.md) · [Brainstorming](../brainstorming.md)
