---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 11 file oltre target 100.

### `actions.md` — Catalogo delle Action


# Catalogo delle Action

Tutte in `app/Actions`, tutte con `Spatie\QueueableAction\QueueableAction` e metodo `execute()` (tranne `ActivityLogger`, che ha metodi propri). Per ogni Action: cosa riceve, cosa restituisce, cosa garantisce, cosa tocca, quando fallisce, cosa non fa. Fatti letti dal codice il 2026-11-25.

I contratti completi, uno per file, esistono in [contracts/](./contracts/README.md) per le sei Action piu' esposte (`LogActivityAction`, `LogModelUpdatedAction`, `RestoreActivityAction`, `AuthorizeLogAccessAction`, `DownloadLogFileAction`, `GetLogFilePathAction`). Per le altre vale questa pagina, che e' il bersaglio dei loro tag `@see` e `@contract`.

## Scrittura

### `LogActivityAction`
- **Input**: costruttore `(string $type, ?Model $user, ?Model $subject, ?array $properties,

### `activity-logging.md` — Registrare e leggere le attivita'


# Registrare e leggere le attivita'

Fatti verificati sul codice il 2026-11-25.

## Due strade per scrivere nel registro

1. **Helper Spatie `activity()`**: e' quello che usano di fatto gli altri moduli (per esempio `User\Actions\Activity\LogRegistrationAction`, `User\Filament\Widgets\Auth\RegisterWidget`). Scrive su `Modules\Activity\Models\Activity` perche' `activitylog.activity_model` punta li'.
2. **Action del modulo**: `LogActivityAction` e le Action derivate. Nessun chiamante fuori dal modulo (vedi [architecture.md](./architecture.md)).

```php
use Modules\Activity\Actions\LogActivityAction;

// type, user (causer), subject, properties, description
(new LogActivityAction(
    'priority_changed',
    subject: $ticket,
    properties: ['from' => $previous, 'to' => $priority],
))->exec

### `architecture.md` — Activity: architettura


# Activity: architettura

Fatti verificati sul codice il 2026-11-25. Dove una cosa non e' provata e' scritto "non verificato".

## Livelli

| Livello | Dove | Cosa |
|---|---|---|
| Modelli | `app/Models` | `Activity` (estende `Spatie\Activitylog\Models\Activity`, connessione `activity`, tabella `activity_log`), `StoredEvent` (estende `EloquentStoredEvent`, `stored_events`), `Snapshot` (estende `EloquentSnapshot`, `snapshots`), `BaseModel` (astratto, su `XotBaseModel`), `TestModel` |
| Logica | `app/Actions` (30 file) | Spatie Queueable Action; catalogo e contratti sintetici in [actions.md](./actions.md). Nessun `Service` |
| DTO | `app/Datas` | Spatie Data: `ActivityConfigData`, `Log*Data` del log viewer |
| Adapter e contratti | `app/Adapters`, `app/Contracts`, `app/Models/Contracts` | 

### `contracts/authorize-log-access-action.md` — AuthorizeLogAccessAction


# AuthorizeLogAccessAction

Chi puo' consultare e scaricare i file di log. Regola unica usata da `LogViewer::canAccess()`, dall'azione di download della pagina e dalla pagina Folio `pages/api/log-download`.

## Input

- `?Authenticatable $user`.

## Output

- `bool`: `true` se l'utente ha il ruolo `super-admin` o il permesso `log.viewAny`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGACCESS-INV-1 | Accesso solo al ruolo `super-admin` o a chi ha il permesso `log.viewAny`. | `ACTIVITY-LOGACCESS-INV-1` |
| ACTIVITY-LOGACCESS-INV-2 | Ospiti (`null`), utenti senza ruolo ne' permesso e utenti che non implementano `UserContract` sono respinti. | `ACTIVITY-LOGACCESS-INV-2` |
| ACTIVITY-LOGACCESS-INV-3 | Se il permesso `log.viewAny` non esiste nel database l'accesso e' 

### `contracts/download-log-file-action.md` — DownloadLogFileAction


# DownloadLogFileAction

Risposta HTTP di download per un file di log scelto dall'utente. Il percorso passa da `GetLogFilePathAction`.

## Input

- `string $file`: percorso relativo alla cartella dei log (`storage/logs`).

## Output

- `BinaryFileResponse`: nome file = percorso relativo con `/` sostituito da `_` (`reports/daily.log` diventa `reports_daily.log`), `Content-Type: text/plain; charset=UTF-8`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGDOWNLOAD-INV-1 | Il file completo arriva come `BinaryFileResponse` (letto a blocchi dal disco, non in memoria ne' in base64), `text/plain`, con nome senza barre. | `ACTIVITY-LOGDOWNLOAD-INV-1` |
| ACTIVITY-LOGDOWNLOAD-INV-2 | Il percorso passa da `GetLogFilePathAction`: file fuori dalla cartella dei log, inesistenti,

### `contracts/get-log-file-path-action.md` — GetLogFilePathAction


# GetLogFilePathAction

Unico punto in cui l'input dell'utente del visualizzatore di log (`LogViewer`) diventa un percorso su disco; lettura (`BuildLogViewerStateAction`) e download (`DownloadLogFileAction`) passano da qui. Si chiamava `ResolveLogFilePathAction`, rinominata per la regola "get, non resolve" (ADR Xot 0016). Perche' uno solo: [ADR 0003](../adr/0003-log-viewer-single-path-resolver.md).

## Input

- `string $relativePath`: percorso relativo scelto dall'utente.
- `?string $baseDirectory`: cartella dei log; se `null` e' `storage/logs` (`GetLogDirectoryAction`, che applica `realpath`).

## Output

- `ResolvedLogFileData(absolutePath, relativePath)`: percorso reale e percorso relativo normalizzato con `/`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGFI

### `contracts/log-activity-action.md` — LogActivityAction


# LogActivityAction

Scrive una riga in `activity_log` (modello `Modules\Activity\Models\Activity`, connessione `activity`). E' il mattone di `LogModel*Action`, `LogUser*Action` e dell'adapter `ActivityLogger`. Si costruisce con `new`, non con `app()`.

## Input

- Costruttore: `string $type` (non vuoto), `?Model $user` (il causer, deve essere `UserContract`), `?Model $subject`, `?array $properties`, `?string $description`.
- `execute()`: nessun argomento.

## Output

- L'`Activity` creata.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOG-INV-1 | `$type` vuoto lancia `InvalidArgumentException('Type cannot be empty')` nel costruttore. | `ACTIVITY-LOG-INV-1` |
| ACTIVITY-LOG-INV-2 | Un `$user` non nullo che non e' `UserContract` lancia `InvalidArgumentException('Use

### `contracts/log-model-updated-action.md` — LogModelUpdatedAction


# LogModelUpdatedAction

Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati. Le sorelle `LogModelCreatedAction` e `LogModelDeletedAction` seguono la stessa regola sui segreti.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<ClasseBase> updated'`, `properties = ['old' => ..., 'new' => ..., 'changes' => ...]` (da `getOriginal()`, `getAttributes()`, `getChanges()`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-MODEL-LOG-INV-1 | `old`, `new` e `changes` passano da `RedactModelAttributesAction`: mai `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`. Vale

### `contracts/restore-activity-action.md` — RestoreActivityAction


# RestoreActivityAction

Riporta un record ai valori che aveva prima di una modifica, presi dalle `properties.old` di un'attivita'. Chiamata dalla pagina `ListLogActivities` (azione di ripristino sulla cronologia di un record).

## Input

- `Model $record`: il record da aggiornare.
- `array<string, mixed> $oldProperties`: i valori da riportare, non vuoto.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-RESTORE-INV-1 | Il record riceve un solo `update()` con esattamente i valori passati: valgono `$fillable` e `$guarded` del modello. | `ACTIVITY-RESTORE-INV-1` |
| ACTIVITY-RESTORE-INV-2 | Valori vuoti: eccezione prima di toccare il record (`Assert::notEmpty`). | `ACTIVITY-RESTORE-INV-2` |

### `log-viewer.md` — Lettura dei log dal pannello


# Lettura dei log dal pannello

Serve a leggere `storage/logs` da dentro il pannello, dove non c'e' accesso SSH o FTP. E' **sola lettura**: nessuna Action scrive, rinomina o cancella un file. Fatti verificati sul codice il 2026-11-25.

## La catena

| Chi | Che cosa fa |
|---|---|
| `Filament\Pages\LogViewer` | tiene solo la scelta dell'utente: file, livello, ricerca, finestra, cartelle aperte |
| `AuthorizeLogAccessAction` | **chi** puo' leggere |
| `ListLogFilesAction` | elenca i `.log` sotto la cartella base, ricorsivo, massimo 1000 |
| `BuildLogFileTreeAction` | ne costruisce l'albero per la colonna di sinistra |
| `GetLogDirectoryAction` | percorso reale della cartella base (`storage/logs` salvo diversa indicazione) |
| `GetLogFilePathAction` | **quale** file: la sola traduzione da i

### `stories/phpstan-log-tests-false-positives.story.md` — 227.1 Activity — 183 segnalazioni PHPStan, zero difetti


# 227.1 Activity — 183 segnalazioni PHPStan, zero difetti

## Il numero

| Momento | Activity | Job | Configurazione |
|---------|----------|-----|----------------|
| Rilevazione iniziale | 183 | 85 | `phpstan.neon` con gli `includes` manuali, `GeneratedConfig.php` vuoto |
| Dopo la correzione della configurazione | 0 | 0 | `phpstan.neon` senza gli `includes` manuali, extension-installer attivo |

Misurato da `laravel/` con cache fredda:

```bash
COMPOSER_ALLOW_SUPERUSER=1 ./vendor/bin/phpstan analyse Modules/Activity Modules/Job \
    --memory-limit=-1 --no-progress
```

## La causa

Pest dichiara nelle proprie `Functions.php`:
