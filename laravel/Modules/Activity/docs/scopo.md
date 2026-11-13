---
title: "Activity — scopo, confini e come servirlo meglio"
type: concept
module: Activity
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, audit, activitylog, event-sourcing, migrazioni, dipendenze]
qmd: "scopo activity audit trail spatie activitylog event sourcing migrazione unica confini dipendenze"
---

# Activity — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Activity non scrive un audit trail: **possiede l'integrazione di due pacchetti Spatie
che lo scrivono**, e possiede lo schema su cui atterrano. La differenza è tutta nei
modelli, che estendono le classi del pacchetto invece di riscriverle.

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| `class Activity extends SpatieActivity` | `app/Models/Activity.php:108` (alias di `Spatie\Activitylog\Models\Activity`, riga 13) | il log leggibile è quello del pacchetto, non una copia |
| `class StoredEvent extends SpatieStoredEvent`, `class Snapshot extends SpatieSnapshot` | `app/Models/StoredEvent.php:64`, `app/Models/Snapshot.php:41` | il secondo pacchetto wrappato è `spatie/laravel-event-sourcing` |
| `require`: `spatie/laravel-activitylog`, `spatie/laravel-event-sourcing`, `php ^8.3` | `composer.json` | tre righe: non c'è nessun'altra dipendenza terza da mantenere |
| `protected $connection = 'activity'` | `app/Models/BaseModel.php:23`, `Activity.php:113`, `StoredEvent.php:69`, `Snapshot.php:46` | l'audit ha una connessione propria, separabile dal dato applicativo |
| 18 file in `app/Actions/`, di cui 6 sotto `Actions/Query/` | `find Modules/Activity/app/Actions -name '*.php'` | scrittura e lettura del log passano da Action, non da facade sparse |

La connessione `activity` non è dichiarata in `config/local/ptvx/database.php`: esiste
perché `TenantServiceProvider::mergeModuleConnections()`
(`Modules/Tenant/app/Providers/TenantServiceProvider.php:138-159`) crea per ogni modulo
una connessione con lo snake name, copiando la default quando il tenant non la
dichiara. Su `config/localhost/database.php:280` invece `activity` è dichiarata
esplicitamente. È un giunto reale: oggi punta al database applicativo, domani può
puntare altrove senza toccare una riga di modello.

> **Activity è il proprietario dell'audit trail: possiede i due pacchetti Spatie che
> lo producono, la connessione su cui vive e le tre tabelle che lo contengono. Non
> decide cosa vada loggato — quello lo decide chi genera l'evento.**

Sei moduli lo consumano — Incentivi, IndennitaResponsabilita, Performance,
Progressioni, Ptv, User — e Activity ne conosce solo due: 36 file toccano `Modules\Xot`,
10 toccano `Modules\User`, zero toccano qualunque modulo di dominio. La direzione delle
dipendenze, per una volta, è corretta.

## I confini, e dove oggi sono rotti

### `activity_log` ha due migrazioni, con schemi incompatibili

Il contratto è scritto nero su bianco nel commento in testa alla migrazione del modulo
(`database/migrations/2026_06_10_141000_create_activity_table.php`, righe 8-13): *«Owner
Activity — UNICA migrazione per `activity_log`»*. Ne esiste una seconda, fuori dal
modulo:

| File | Base | `subject_id` |
|---|---|---|
| `Modules/Activity/database/migrations/2026_06_10_141000_create_activity_table.php` | `XotBaseMigration` | `nullableUuidMorphs` → `string(36)` |
| `laravel/database/migrations/2026_08_26_151044_create_activity_log_table.php` | `Illuminate\...\Migration` nuda | `nullableMorphs` → `unsignedBigInteger` |

Non sono due versioni della stessa cosa: sono due tipi di colonna diversi per la stessa
chiave polimorfa. La seconda è anche l'unica delle due che non passa da
`XotBaseMigration`, quindi non è idempotente — `Schema::create` su una tabella già
esistente esplode invece di aggiornare. Lo stesso vale per `stored_events` e
`snapshots`, duplicati in `laravel/database/migrations/2026_08_26_151044_create_stored_events_table.php`
e `..._151045_create_snapshots_table.php` accanto ai due file del modulo.

Tre tabelle di Activity, sei migrazioni. Il confine rotto non è nel modulo: è che
qualcuno ha ricreato lo schema del modulo fuori dal modulo.

### Un modello di test e la sua tabella vivono in produzione

`app/Models/TestModel.php:27` dichiara `final class TestModel extends Model` — l'unico
modello del modulo che non passa da `BaseModel`, quindi l'unico senza la connessione
`activity` — e `database/migrations/2026_03_05_000001_create_test_models_table.php`
crea davvero `test_models`. Una fixture di test che si porta dietro una migrazione
è una tabella in più su ogni ambiente, per sempre.

### Due classi con lo stesso nome fanno lo stesso mestiere

`app/Actions/ActivityLogger.php` (`use QueueableAction`) e
`app/Adapters/ActivityLogger.php` (documentato come *«Coordinator — delegates to
single-purpose QueueableActions (not an Action: multi-method API)»*) hanno lo stesso
nome in due namespace ed espongono **13 metodi pubblici a testa**. La differenza è che
l'Adapter delega alle Action a metodo singolo, mentre la versione in `Actions/` fa il
lavoro da sé: le altre sette classi di quella cartella ne hanno 2. La seconda dichiara
di esistere perché la prima non dovrebbe — un Action con tredici metodi pubblici non è
un Action. Finché convivono, chi importa `ActivityLogger` deve guardare l'`use` per
sapere quale ha preso.

### Codice Filament che nessuno chiama

`XotBaseResource::getTableClass()` (`Modules/Xot/app/Filament/Resources/XotBaseResource.php:179-186`)
risolve la tabella come `{Resource}\Tables\{Plurale del modello}Table`. Per
`ActivityResource` il plurale di `Activity` è `Activities`: `ActivitiesTable` è viva,
`ActivitysTable` no — resta in albero solo perché
`tests/Unit/Filament/ActivityFilamentExtendedTest.php:55` la istanzia. Un test che
tiene in vita un doppione non protegge niente: certifica che il doppione compila.

Nello stesso modo, `XotBaseListRecords` non chiama più `getTableColumns()` — l'unica
traccia è un `abstract public function getTableColumns(): array;` **commentato** alla
riga 64, e le righe 23-24 rimandano esplicitamente a `XotBaseResource::table()`. Le tre
List pages (`ListActivities`, `ListSnapshots`, `ListStoredEvents`) lo implementano
ancora: sono tre liste di colonne che nessuna pagina renderizza.

## Come servire meglio lo scopo

### 1. Riportare le tre tabelle sotto l'unico owner

Cancellare `laravel/database/migrations/2026_08_26_151044_create_activity_log_table.php`,
`..._151044_create_stored_events_table.php` e `..._151045_create_snapshots_table.php`.
Nessuna delle tre crea colonne che la migrazione del modulo non copra già, e nessuna
delle tre è idempotente. Le tabelle esistenti non vanno toccate: si rimuove il file,
non lo schema.

```bash
cd laravel && grep -rl 'activity_log\|stored_events\|snapshots' database/migrations | wc -l   # obiettivo: 0
```

### 2. Sfrattare `TestModel` dal codice di produzione

Spostare `app/Models/TestModel.php` in `tests/Fixtures/` (dove il modulo tiene già le
sue fixture) e rimuovere `database/migrations/2026_03_05_000001_create_test_models_table.php`.
Il tavolo su cui si prova non sta nella sala da pranzo.

```bash
cd laravel && ls Modules/Activity/app/Models/TestModel.php 2>/dev/null | wc -l   # obiettivo: 0
```

### 3. Un solo `ActivityLogger`

Tenere `app/Adapters/ActivityLogger.php` — che è già il coordinatore dichiarato e già
delega alle Action singole — e sciogliere `app/Actions/ActivityLogger.php` nelle Action
a metodo singolo che esistono di fianco (`LogActivityAction`, `LogUserLoginAction`,
`LogModelUpdatedAction`, le sei `Query/`). L'obiettivo non è ridurre i file: è che
`Modules\Activity\Actions\*` contenga solo classi con un `execute()`.

```bash
cd laravel && ls Modules/Activity/app/Actions/ActivityLogger.php 2>/dev/null | wc -l          # obiettivo: 0
cd laravel && grep -rc 'public function ' Modules/Activity/app/Actions/*.php | sort -t: -k2 -rn | head -3   # oggi il primo è ActivityLogger:13, gli altri 2
```

### 4. Togliere le colonne dalle Pages e la Tables morta

Rimuovere `getTableColumns()` da `ActivityResource/Pages/ListActivities.php`,
`SnapshotResource/Pages/ListSnapshots.php`, `StoredEventResource/Pages/ListStoredEvents.php`;
cancellare `ActivityResource/Tables/ActivitysTable.php` e l'assert che la tiene viva in
`tests/Unit/Filament/ActivityFilamentExtendedTest.php`. Se una colonna serve, va in
`ActivitiesTable`.

```bash
cd laravel && grep -rl 'public function getTableColumns' Modules/Activity/app/Filament/Resources/*/Pages/ | wc -l   # obiettivo: 0
```

### 5. Rendere strutturale la regola dell'unica migrazione

Il commento in testa alla migrazione dice la cosa giusta ma non la fa rispettare: il
duplicato in root è nato lo stesso, tre mesi dopo. Un test di architettura che conti le
migrazioni per tabella su tutto il repo trasforma una convenzione in un gate. La regola
esiste già come skill (`activity-log-single-migration`) e come contratto
(`docs/wiki/concepts/activity-log-single-migration-contract.md`); manca solo chi la
verifica.

## Cosa NON è compito di Activity

- **Non** reimplementa `spatie/laravel-activitylog` né `spatie/laravel-event-sourcing`:
  se serve un comportamento, si estende la classe del pacchetto (come già fanno
  `Activity`, `StoredEvent`, `Snapshot`), non si riscrive.
- **Non** decide cosa loggare. La scelta di tracciare una scheda, un'indennità o una
  progressione appartiene al modulo che genera l'evento; Activity offre l'Action.
- **Non** è il logger applicativo. `Log::error()` per un errore tecnico non è audit:
  l'audit risponde a un'ispezione, il log risponde a un bug.
- **Non** corregge il passato. Non esiste una via per riscrivere una riga di
  `activity_log`: un dato sbagliato si corregge con un evento nuovo.
- **Non** possiede tabelle di altri. Le sue sono tre: `activity_log`, `stored_events`,
  `snapshots`.

## Verifica

```bash
cd laravel

# 1. una sola migrazione per ognuna delle tre tabelle di Activity
ls Modules/Activity/database/migrations/*.php | wc -l                        # oggi 4 (3 + test_models)
grep -rl 'activity_log\|stored_events\|snapshots' database/migrations | wc -l # oggi 3, obiettivo 0

# 2. nessuna fixture di test in app/
ls Modules/Activity/app/Models/TestModel.php 2>/dev/null | wc -l             # obiettivo 0

# 3. nessun Service, nessuna estensione diretta di Filament
ls Modules/Activity/app/Services 2>/dev/null | wc -l                          # oggi 0, deve restare 0
grep -rn 'extends \(Resource\|Page\|ListRecords\|CreateRecord\|EditRecord\|Widget\|RelationManager\)\b' \
  --include=*.php Modules/Activity/app | wc -l                                # oggi 0, deve restare 0

# 4. colonne solo nelle Tables/
grep -rl 'public function getTableColumns' Modules/Activity/app/Filament/Resources/*/Pages/ | wc -l  # oggi 3, obiettivo 0

# 5. direzione delle dipendenze (Activity non deve conoscere i moduli di dominio)
for m in Ptv Performance Progressioni Incentivi IndennitaResponsabilita Sigma; do
  echo "$m: $(grep -rl "Modules\\\\$m\\\\" Modules/Activity/app | wc -l)"     # tutti 0
done

# 6. analisi statica, config di progetto, nuda
./vendor/bin/phpstan analyse Modules/Activity                                 # deve restare a 0 errori
```

## Collegamenti

- [activity-log-single-migration-contract](wiki/concepts/activity-log-single-migration-contract.md) — il contratto dell'unica migrazione
- [migration-filename-from-model-name](../../../../docs/wiki/rules/migration-filename-from-model-name.md) — 1 modello = 1 migrazione, filename dal modello
- [Sigma — scopo](../../Sigma/docs/scopo.md) — lo stesso esercizio sul modulo adattatore
- [coverage.md](coverage.md) — perché la coverage di questo modulo non è misurabile col comando standard
