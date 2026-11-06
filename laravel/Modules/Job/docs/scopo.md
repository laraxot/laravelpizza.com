---
issues: []
discussions: []
title: "Job: scopo, confini e come servirlo meglio"
type: concept
module: Job
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, code, queue, schedule, filament, services, dipendenze]
qmd: "scopo job code queue schedule pannello filament no services config namespace confini dipendenze"
---

# Job: scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Job non è una libreria di job. È **il pannello di controllo delle code**: possiede le
tabelle operative che Laravel e i suoi pacchetti scrivono, e le Resource Filament con
cui un amministratore le guarda, le filtra e le rilancia. Il rapporto fra le parti lo
dice meglio di qualunque descrizione.

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| 82 file Filament contro 15 Action e 17 modelli | `find Modules/Job/app/Filament -name '*.php' \| wc -l` | il baricentro è l'interfaccia di amministrazione, non l'esecuzione |
| `require` contiene solo `php: ^8.3` | `composer.json` | Job non wrappa nessun pacchetto terzo: sta sopra `illuminate/queue`, che è già nel core |
| 9 Resource: Job, JobBatch, FailedJob, JobsWaiting, JobManager, Import, Export, FailedImportRow, Schedule | `ls Modules/Job/app/Filament/Resources` | ogni tabella operativa ha la sua vista |
| `protected $connection = 'job'` | `app/Models/BaseModel.php:34`, `BaseMorphPivot.php:30`, `Export.php:60` | le tabelle di servizio sono isolabili su una connessione propria |
| 112 file toccano `Modules\Xot`, 4 toccano `Modules\User`, **0 qualunque altro modulo** | `grep -rl 'Modules\\<X>\\' Modules/Job/app` | Job non conosce nessun dominio |
| **1 solo file** in tutto il monorepo importa da `Modules\Job` | `Modules/Media/app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php:9` (importa `ClockWidget`) | Job non è una dipendenza di nessuno: è un pannello, si usa dal browser |

La connessione `job` non è dichiarata in nessun file di config tenant: né in
`config/local/ptvx/database.php` (che costruisce 21 connessioni da una mappa esplicita,
righe 25-46), né in `config/localhost/database.php` (che ne dichiara 19, fra cui
`rating` e `activity` ma non `job`). Funziona lo stesso perché
`TenantServiceProvider::mergeModuleConnections()`
(`Modules/Tenant/app/Providers/TenantServiceProvider.php:138-159`) crea per ogni modulo
attivo una connessione con lo snake name copiando quella di default. È un fallback, non
una scelta: oggi le tabelle di Job stanno nel database applicativo.

> **Job è la superficie di amministrazione delle code Laravel: possiede 14 tabelle
> operative e 9 Resource Filament per osservarle e rilanciarle. Non contiene la logica
> dei job altrui e nessun modulo lo importa.**

## I confini, e dove oggi sono rotti

### Una conversione storica, non un'API corrente

Il precedente `app/Services/ScheduleService.php` violava la policy no-services del progetto ed è stato rimosso.
Il punto non è stilistico: le sue due funzioni esistono già come Action, **in doppia
copia**.

| Cosa fa | Dove sta, oggi |
|---|---|
| leggere gli schedule attivi (con cache) | `Services/ScheduleService::getActives()` · `Actions/GetActiveSchedulesAction.php` · `Actions/Schedule/GetActiveSchedulesAction.php` |
| invalidare la cache degli schedule | `Services/ScheduleService::clearCache()` · `Actions/ClearScheduleCacheAction.php` · `Actions/Schedule/ClearScheduleCacheAction.php` |

Le due copie di `GetActiveSchedulesAction` differiscono solo per come risolvono il
modello: la versione in `Actions/` lo risolve nel costruttore e lo tiene in una
proprietà, quella in `Actions/Schedule/` lo risolve a ogni chiamata in un
`getModel()` privato. Le due `ClearScheduleCacheAction` differiscono **solo per il
namespace**. Del Service, in tutto il repo, esistono riferimenti unicamente in
`tests/Unit/Services/ScheduleServiceTest.php`, e sono tutti `ReflectionClass`: nessuno
lo istanzia, nessuno lo invoca. È codice tenuto in vita da un test che verifica che
esista.

### Venti chiamate a un namespace di config che non esiste

`ScheduleService` e le quattro Action leggono `config('job::model')`,
`config('job::cache.enabled')`, `config('job::cache.store')`, `config('job::cache.key')`,
`config('job::history_collapsed')`: venti occorrenze in `app/`. Il namespace `job::`
non è registrato da `JobServiceProvider` (nessuna riga vi fa riferimento), e i due file
che potrebbero definirlo non lo definiscono: `Modules/Job/config/config.php` contiene
`name` e `icon`, `laravel/config/job.php` contiene solo `name`. Ogni chiave restituisce
`null`, e ogni `Assert::string(...)` che la avvolge lancia. Un cache layer che non può
girare non è un'ottimizzazione: è una via morta con tre implementazioni.

### File che non sono codice, dentro il codice

| File | Cos'è |
|---|---|
| `Modules/Job/Untitled` | 1 byte, dal 1 settembre 2026 |
| `Modules/Job/config.php` | una riga: `require __DIR__."/../config.php";`: risolve a `Modules/config.php`, che non esiste |
| `Modules/Job/app/Console/Commands/queue.pid` | 5 byte, artefatto di runtime committato |
| `Modules/Job/app/Models/MonitoredScheduledTask.aaa` e `MonitoredScheduledTaskLogItem.aaa` | due modelli disattivati rinominando l'estensione |

### Due nomi per lo stesso contratto

`app/Contracts/TaskContract.php` e `app/Contracts/TaskInterface.php` dichiarano gli
stessi otto metodi con le stesse firme e gli stessi PHPDoc: l'unica differenza fra i due
file è il nome dell'interfaccia. La convenzione del progetto è `*Contract`.

### Migrazioni duplicate fuori dal modulo

`imports`, `exports` e `failed_import_rows` hanno una migrazione nel modulo
(`2024_01_01_000002`, `2024_03_12_082158` ×2) e una in `laravel/database/migrations/`
(`2026_08_26_151042`, `..._151043`, `..._151044`). Le seconde non passano da
`XotBaseMigration` e non sono idempotenti.

### Colonne definite due volte, e due tabelle che nessuno risolve

`XotBaseResource::getTableClass()`
(`Modules/Xot/app/Filament/Resources/XotBaseResource.php:179-186`) risolve
`{Resource}\Tables\{Plurale del modello}Table`. Su 11 classi `Tables/`, due non sono
raggiungibili da nessuna Resource e non hanno un solo riferimento nel repo:

- `JobBatchResource/Tables/JobBatchsTable.php`: la Resource risolve `JobBatchesTable`
- `JobsWaitingResource/Tables/JobsWaitingsTable.php`: `JobsWaitingResource` dichiara
  `protected static ?string $model = Job::class` (riga 22), quindi risolve
  `JobsWaitingResource\Tables\JobsTable`

In parallelo, 10 List pages implementano ancora `getTableColumns()`, un metodo che
`XotBaseListRecords` non chiama più: alla riga 64 la dichiarazione astratta è
commentata, e le righe 23-24 rimandano a `XotBaseResource::table()`. Sono dieci liste di
colonne che nessuna pagina renderizza, accanto a undici che invece contano. Lo stesso
`JobsWaitingResource` ha due List pages, `ListJobsWaiting.php` e `ListJobsWaitings.php`,
entrambe con `protected static string $resource = JobsWaitingResource::class`.

## Come servire meglio lo scopo

### 1. Un solo modo di leggere gli schedule

Cancellare `app/Services/ScheduleService.php`, `app/Actions/GetActiveSchedulesAction.php`
e `app/Actions/ClearScheduleCacheAction.php`; tenere le due sotto `app/Actions/Schedule/`,
che risolvono il modello per chiamata e non lo congelano nel costruttore. Riscrivere
`tests/Unit/Services/ScheduleServiceTest.php` sulle Action superstiti: o cancellarlo,
visto che oggi verifica solo che una classe esista.

```bash
cd laravel && ls Modules/Job/app/Services 2>/dev/null | wc -l   # obiettivo: 0
cd laravel && ls Modules/Job/app/Actions/GetActiveSchedulesAction.php \
                 Modules/Job/app/Actions/ClearScheduleCacheAction.php 2>/dev/null | wc -l   # oggi 2, obiettivo 0
```

### 2. Decidere se `job::` deve esistere

Due strade, entrambe legittime, nessuna delle due è «lasciare com'è». O
`JobServiceProvider` registra il namespace e `Modules/Job/config/config.php` guadagna le
chiavi `model`, `cache.enabled`, `cache.store`, `cache.key`, `history_collapsed`; oppure
le venti chiamate passano a `config('job.…')` e le chiavi vanno in
`laravel/config/job.php`. Finché nessuna delle due è fatta, il ramo cache delle Action è
irraggiungibile e le `Assert::string` sono bombe a orologeria.

```bash
cd laravel && grep -rho "config('job::[a-z._]*'" Modules/Job/app | sort -u | wc -l   # oggi 5 chiavi distinte, 20 occorrenze
```

### 3. Pulire il perimetro fisico del modulo

Rimuovere `Untitled`, `config.php`, `app/Console/Commands/queue.pid`, i due
`app/Models/*.aaa`. Nessuno di questi file è codice; tre su cinque sono residui di
sessioni altrui, uno è un `require` che punta fuori dal modulo. Un `.aaa` dentro
`app/Models/` è un modello cancellato male: o serve e torna `.php`, o non serve e va via
dal repo (la cronologia lo conserva comunque).

```bash
cd laravel && ls Modules/Job/Untitled Modules/Job/config.php Modules/Job/app/Console/Commands/queue.pid Modules/Job/app/Models/*.aaa 2>/dev/null | wc -l   # obiettivo: 0
```

### 4. Un contratto, un nome

Cancellare `app/Contracts/TaskInterface.php` e tenere `TaskContract`. Prima, verificare
che nessuno lo implementi: oggi la ricerca non trova implementazioni per nessuno dei due,
quindi la scelta è libera e va fatta ora, prima che qualcuno ne implementi uno a caso.

```bash
cd laravel && grep -rn 'implements .*Task\(Contract\|Interface\)' --include=*.php Modules/ | wc -l   # oggi 0
```

### 5. Colonne solo dove le legge Filament

Cancellare `JobBatchResource/Tables/JobBatchsTable.php` e
`JobsWaitingResource/Tables/JobsWaitingsTable.php`; rimuovere `getTableColumns()` dalle
10 List pages; unificare le due List page di `JobsWaitingResource`. La regola non è
"meno file": è che esista un solo posto dove guardare per sapere cosa mostra una tabella.

```bash
cd laravel && grep -rl 'public function getTableColumns' Modules/Job/app/Filament/Resources/*/Pages/ | wc -l   # oggi 10, obiettivo 0
```

## Cosa NON è compito di Job

- **Non** contiene la logica dei job degli altri moduli. Un export di schede è codice
  di Ptv messo in coda; Job lo mostra mentre gira, non sa cosa faccia.
- **Non** possiede `imports`/`exports` in quanto concetto: possiede le tabelle che i
  pacchetti di import/export scrivono. Se una migrazione di quelle tabelle esiste anche
  altrove, il conflitto va risolto togliendo l'altra, non moltiplicando la propria.
- **Non** è uno scheduler alternativo al cron di Laravel: `Schedule`, `Task`,
  `Frequency` sono la rappresentazione persistente di ciò che il kernel esegue, non un
  motore parallelo.
- **Non** ospita Service. La policy del progetto è chiara e questo modulo è l'unico dei
  tre a violarla: con una classe che nessun codice applicativo chiama.
- **Non** estende direttamente le classi Filament: oggi le 82 classi Filament passano
  tutte da `XotBase*`, ed è una proprietà da non perdere.

## Verifica

```bash
cd laravel

# 1. no-services: obiettivo 0
ls Modules/Job/app/Services 2>/dev/null | wc -l

# 2. config namespace fantasma: 6 chiavi distinte, 20 occorrenze, 0 definizioni
grep -rho "config('job::[a-z._]*'" Modules/Job/app | sort -u
grep -rn "'job'" Modules/Job/app/Providers/JobServiceProvider.php | wc -l   # oggi 0

# 3. igiene del perimetro: obiettivo 0
ls Modules/Job/Untitled Modules/Job/config.php \
   Modules/Job/app/Console/Commands/queue.pid Modules/Job/app/Models/*.aaa 2>/dev/null | wc -l

# 4. contratti duplicati: obiettivo 1 file
ls Modules/Job/app/Contracts/Task*.php | wc -l                               # oggi 2

# 5. colonne fuori dalle Tables/: obiettivo 0
grep -rl 'public function getTableColumns' Modules/Job/app/Filament/Resources/*/Pages/ | wc -l

# 6. migrazioni duplicate fuori dal modulo: obiettivo 0
grep -rl "Schema::create('imports'\|Schema::create('exports'\|Schema::create('failed_import_rows'" database/migrations | wc -l

# 7. direzione delle dipendenze (Job non deve conoscere i domini)
for m in Ptv Performance Progressioni Sigma Rating Activity; do
  echo "$m: $(grep -rl "Modules\\\\$m\\\\" Modules/Job/app | wc -l)"         # tutti 0
done

# 8. nessuna estensione diretta di Filament
grep -rn 'extends \(Resource\|Page\|ListRecords\|CreateRecord\|EditRecord\|Widget\|RelationManager\)\b' \
  --include=*.php Modules/Job/app | wc -l                                    # oggi 0, deve restare 0

# 9. analisi statica, config di progetto, nuda
./vendor/bin/phpstan analyse Modules/Job                                     # deve restare a 0 errori
```

## Collegamenti

- [no-services-rule](../../../../bashscripts/ai/wiki/rules/no-services-rule.md): perché `ScheduleService` non deve esistere
- [migration-filename-from-model-name](../../../../docs/wiki/rules/migration-filename-from-model-name.md): 1 modello = 1 migrazione
- [Sigma: scopo](../../Sigma/docs/scopo.md): lo stesso esercizio sul modulo adattatore
- [coverage.md](coverage.md): il contratto di qualità dei test di questo modulo
- [ARCHITECTURE.md](ARCHITECTURE.md): l'architettura già documentata
