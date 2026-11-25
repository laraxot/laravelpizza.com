---
title: "Activity: catalogo delle Action e contratti sintetici"
type: reference
status: active
module: Activity
created: 2026-11-25
updated: 2026-11-25
qmd: "activity actions catalogo contratti sintetici LogActivityAction ActivityMaintenanceAction RedactModelAttributesAction RestoreActivityAction Query Schema Log viewer input output invarianti errori non fa"
related:
  - ./activity-logging.md
  - ./log-viewer.md
  - ./contracts/README.md
---

# Catalogo delle Action

Tutte in `app/Actions`, tutte con `Spatie\QueueableAction\QueueableAction` e metodo `execute()` (tranne `ActivityLogger`, che ha metodi propri). Per ogni Action: cosa riceve, cosa restituisce, cosa garantisce, cosa tocca, quando fallisce, cosa non fa. Fatti letti dal codice il 2026-11-25.

I contratti completi, uno per file, esistono in [contracts/](./contracts/README.md) per le sei Action piu' esposte (`LogActivityAction`, `LogModelUpdatedAction`, `RestoreActivityAction`, `AuthorizeLogAccessAction`, `DownloadLogFileAction`, `GetLogFilePathAction`). Per le altre vale questa pagina, che e' il bersaglio dei loro tag `@see` e `@contract`.

## Scrittura

### `LogActivityAction`
- **Input**: costruttore `(string $type, ?Model $user, ?Model $subject, ?array $properties, ?string $description)`, poi `execute()`.
- **Output**: `Models\Activity` salvata.
- **Invarianti**: `log_name` = `event` = `type`; `causer_type` valorizzato solo se `user` e' passato; `user` deve essere `UserContract`.
- **Effetti**: una `INSERT` su `activity_log` (connessione `activity`).
- **Errori**: `InvalidArgumentException` per `type` vuoto o `user` non `UserContract`.
- **Non fa**: non redige le properties (lo fanno le Action `LogModel*`), non risolve il causer da `Auth` quando `user` e' nullo oltre a `causer_id`.

### `LogModelCreatedAction`, `LogModelUpdatedAction`, `LogModelDeletedAction`
- **Input**: `(?Model $model, ?Model $user)` nel costruttore, oppure `execute(?Model $model)`.
- **Output**: `Activity` con `event` `created` / `updated` / `deleted` e description `<Classe> created|updated|deleted`.
- **Invarianti**: properties redatte con `RedactModelAttributesAction` (`attributes`; per `updated` `old`, `new`, `changes`).
- **Effetti**: delegano a `LogActivityAction`.
- **Errori**: `InvalidArgumentException('A model is required')` senza modello.
- **Non fa**: non si aggancia agli eventi Eloquent da sola: va chiamata.

### `LogUserLoginAction`, `LogUserLogoutAction`
- **Input**: `UserContract` (che sia anche `Model`) nel costruttore o in `execute()`.
- **Output**: `Activity` `login` / `logout`, subject = causer = utente.
- **Errori**: `InvalidArgumentException` se non e' un `Model`.
- **Non fa**: non e' collegata a `Login`/`Logout`: il listener di logout scrive per conto suo, quello di login e' vuoto ([activity-logging.md](./activity-logging.md)).

### `RecordSubjectActivityAction`
- **Input**: `execute(string $subjectType, int|string $subjectId, string $event, ?array $properties, ?string $description)`.
- **Output**: `Activity` con `log_name` `default`, description di default `<ClasseBase> <event>`.
- **Non fa**: non imposta causer, non verifica che il subject esista.

### `RedactModelAttributesAction`
- **Input**: `execute(array $attributes)`; **Output**: lo stesso array senza `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes` (`Arr::except`).
- **Non fa**: nessun altro campo sensibile; nessuna redazione ricorsiva.

### `RestoreActivityAction`
- **Input**: `execute(Model $record, array $oldProperties)`; **Output**: `void`.
- **Invarianti**: `$oldProperties` non vuoto (`Assert::notEmpty`); applica `$record->update($oldProperties)`.
- **Effetti**: `UPDATE` del record di dominio, non dell'`Activity`.
- **Errori**: rilancia ogni eccezione come `Exception('Restore failed: ...')` con la precedente.
- **Non fa**: non controlla permessi (li controlla la pagina, vedi [filament-admin.md](./filament-admin.md)).

### `ActivityMaintenanceAction`
- **Input**: `execute(int $days = 90)`; **Output**: `int` righe cancellate.
- **Effetti**: `DELETE` a blocchi di 1000 delle attivita' con `created_at` anteriore a `now() - $days`; log di debug con il conteggio.
- **Errori**: `InvalidArgumentException` se `$days <= 0`.
- **Non fa**: non e' schedulata; non legge `clean_after_days`.

### `ActivityLogger` (in `Actions/` e in `Adapters/`)
Facciata con metodi `log`, `created`, `updated`, `deleted`, `login`, `logout`, `custom` e di lettura. La versione in `Actions/` scrive con `Activity::create` (`log_name` `default`, `event` = tipo) e interroga direttamente; quella in `Adapters/` delega alle Action di questa pagina. Vedi [architecture.md](./architecture.md).

## Lettura (`Actions/Query`)

| Action | Input | Output | Note |
|---|---|---|---|
| `GetUserActivitiesAction` | `UserContract` (Model), `limit` 50 | `Collection<Activity>` | filtra `causer_id` e `causer_type`; `limit <= 0` lancia |
| `GetModelActivitiesAction` | `Model`, `limit` 50 | `Collection<Activity>` | filtra `subject_type` e `subject_id`; eager load `causer` |
| `GetActivitiesByTypeAction` | `string $type`, `limit` 50 | `Collection<Activity>` | filtra `event`; `type` vuoto o `limit <= 0` lancia |
| `GetRecentActivitiesAction` | `limit` 50 | `Collection<Activity>` | `latest()`; `limit <= 0` lancia |
| `GetSubjectActivityLogAction` | `class`, `id`, `limit` 500 | `list<array>` | ogni `Activity` come array (`toArray`) |
| `GetActivityStatisticsAction` | `?UserContract` | array `total`, `by_type`, `today`, `this_week` | cache 5 minuti, chiave `activity.statistics.<id|global>` |

Nessuna scrive. Tutte passano da `Activity::typedQuery()` / `typedGet()`.

## Schema e configurazione

- `CheckActivityLogWritableAction`, `IsActivityLogSchemaWritableAction`: `execute(): bool`; `false` se `activitylog.enabled` e' falso o se manca la tabella o la colonna `attribute_changes`. Sola lettura sullo schema (`hasTable`, `hasColumn`).
- `ApplyActivityConfigAction`: `execute(): void`; copia in `config('activitylog.*')` le chiavi salvate dal tenant; non fa nulla se la config del tenant e' vuota.

## Log viewer (`Actions/Log`)

Catena e garanzie di sicurezza in [log-viewer.md](./log-viewer.md). Contratti di una riga:

| Action | Input -> output | Invarianti e limiti |
|---|---|---|
| `AuthorizeLogAccessAction` | `?Authenticatable` -> `bool` | `true` solo per `UserContract` con ruolo `super-admin` o permesso `log.viewAny`; permesso inesistente = `false` |
| `GetLogDirectoryAction` | `?string $directory` -> percorso reale | default `storage/logs`; `InvalidLogFileException::baseDirectoryMissing()` se non e' una cartella |
| `GetLogFilePathAction` | percorso relativo, base -> `ResolvedLogFileData` (`absolutePath`, `relativePath`) | unico punto che traduce input utente in percorso su disco: vuoto o byte nullo, estensione `.log` (su input e su risolto), `realpath` dentro la base |
| `ListLogFilesAction` | base, `limit` 1000 -> `list<LogFileData>` | solo `*.log`, ricorsivo, ordinati per modifica decrescente, contenimento ricontrollato su ogni `realPath` |
| `BuildLogFileTreeAction` | `list<LogFileData>` -> `LogTreeData` | albero cartelle/file, cartelle in ordine naturale |
| `ReadLogTailAction` | percorso assoluto, byte -> `LogTailData` (`content`, `size`, `bytesRead`, `truncated`) | legge solo la coda: default 256 KiB, minimo 1 KiB, massimo 4 MiB; scarta la prima riga se troncato; UTF-8 ripulito; `RuntimeException` se illeggibile |
| `ParseLogEntriesAction` | testo -> `list<LogEntryData>` | riconosce righe `[data] ambiente.LIVELLO: messaggio`; le righe senza intestazione si accodano alla voce aperta |
| `FilterLogEntriesAction` | voci, livello, ricerca, limite 200 -> `FilteredLogEntriesData` | filtro per livello esatto e testo (case-insensitive nel body); le piu' recenti prima |
| `BuildLogViewerStateAction` | file, livello, ricerca, finestra KB -> `LogViewerStateData` | finestre ammesse 128, 256, 512, 1024, 2048, 4096 KB (default 256); errore generico che non riporta il percorso |
| `DownloadLogFileAction` | percorso relativo -> `BinaryFileResponse` | risolve con `GetLogFilePathAction`; nome file con `/` sostituito da `_`; `text/plain; charset=UTF-8` |

Le Action del viewer si chiamavano `ResolveLogDirectoryAction` e `ResolveLogFilePathAction`: rinominate `Get*` (regola "get, non resolve", ADR Xot 0016). Il contratto [resolve-log-file-path-action.md](./contracts/resolve-log-file-path-action.md) ha tenuto il vecchio nome file perche' i docblock lo citano.
