---
title: "Glossario di dominio Activity"
type: glossary
owner: Activity
updated: 2026-11-24
qmd: "activity glossario dominio audit attivita causer subject log name event stored event snapshot log viewer"
---

# Glossario di dominio Activity

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.
Percorsi relativi a `laravel/Modules/Activity/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Attivita' (Activity) | Riga di audit: cosa e' successo (`description`, `event`), a quale record (`subject_*`), chi l'ha causato (`causer_*`), con `properties`. | `app/Models/Activity.php`, risorsa `app/Filament/Resources/ActivityResource.php` |
| Subject | Record Eloquent su cui e' avvenuta l'attivita'. | colonne `subject_type`, `subject_id` di `Activity` |
| Causer | Utente che ha causato l'attivita'; se non indicato si usa `Auth::id()`. | colonne `causer_type`, `causer_id`, `LogActivityAction::execute()` |
| Log name / tipo | Etichetta con cui l'attivita' e' registrata; `LogActivityAction` la usa sia come `log_name` sia come `event`. | `Activity::$log_name`, `LogActivityAction::$type` |
| Properties | Dati dell'attivita' (es. valori vecchi e nuovi) in JSON. | `Activity::$properties` |
| Batch | Raggruppamento di attivita' con lo stesso `batch_uuid`. | `Activity::$batch_uuid` |
| Eventi del ciclo di vita | `created`, `updated`, `deleted`, `login`, `logout` registrati dal logger. | `app/Actions/ActivityLogger.php` (`created()`, `updated()`, `deleted()`, `login()`), `app/Listeners/LoginListener.php`, `LogoutListener.php` |
| Recorder | Contratto per chi registra attivita'. | `app/Contracts/ActivityRecorderContract.php` |
| Ripristino da attivita' | Riporta un record ai valori vecchi salvati in una attivita'. | `app/Actions/RestoreActivityAction.php`, `ListLogActivities::restoreActivity()` |
| Pulizia attivita' | Cancellazione delle attivita' piu' vecchie di N giorni (default 90). | `app/Actions/ActivityMaintenanceAction.php` |
| Redazione attributi | Rimozione di `password`, `remember_token`, `two_factor_*` prima della persistenza (nessun chiamante in `app/`). | `app/Actions/RedactModelAttributesAction.php` |
| Stored event | Evento dell'event sourcing con `aggregate_uuid`, `event_class`, `event_properties`. | `app/Models/StoredEvent.php` |
| Snapshot | Stato di un aggregato a una versione (`aggregate_uuid`, `aggregate_version`, `state`). | `app/Models/Snapshot.php`, risorsa `app/Filament/Resources/SnapshotResource.php` |
| Visualizzatore di log | Pagina che legge i file `.log` dentro `storage/logs`. | `app/Filament/Pages/LogViewer.php` |
| Accesso ai log | Consentito ai `super-admin` e a chi ha il permesso `log.viewAny`. | `app/Actions/Log/AuthorizeLogAccessAction.php` |
| Livello di log | Gravita' di una riga di log: EMERGENCY, ALERT, CRITICAL, ERROR, WARNING, NOTICE, INFO, DEBUG. | `app/Enums/LogLevelEnum.php` |
| Percorso di log risolto | Percorso reale e relativo di un file `.log`, garantito dentro la cartella dei log. | `app/Actions/Log/ResolveLogFilePathAction.php`, `app/Datas/ResolvedLogFileData.php` |
# Glossario di dominio Activity

<!-- Le parole del dominio e dove stanno nel codice. Topology di AGENTS.md punta qui.
     Un termine per riga; se glossario e codice non coincidono, vale il codice e si corregge il glossario. -->

| Termine | Significato | Nel codice |
|---|---|---|
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
