---
title: "ADR — I modelli di Activity usano la connessione 'activity', mai quella di default"
type: decision
status: accepted
module: Activity
tags: [adr, activity, database, connection, multi-tenant, testing]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Models/BaseModel.php
  - ../../app/Models/Activity.php
  - ../../../Tenant/app/Providers/TenantServiceProvider.php
  - ../../tests/Unit/BaseModelTest.php
  - ../basemodel-connection-why-activity-not-null.md
---

# ADR: i modelli di Activity usano la connessione `activity`

## Contesto

- Ogni modulo ha una connessione col proprio nome: `TenantServiceProvider::aliasModuleConnectionsToDefault()` registra
  `DB::extend('<modulo>')`, che è un alias della connessione di default finché la configurazione è la stessa e apre un
  database separato quando il progetto lo configura.
- Il log delle attività cresce più di ogni altra tabella (una riga per create/update/delete, login, logout) e contiene
  dati personali: un progetto può volerlo in un database a parte.
- I test transazionali annullano solo le connessioni elencate: `tests/TestCase.php` ha
  `$connectionsToTransact = ['sqlite', 'activity', 'user']`.
- Un agente che "semplifica" vede `protected $connection = 'activity'` come ridondante e lo toglie o lo mette a `null`
  (documentato in [basemodel-connection-why-activity-not-null](../basemodel-connection-why-activity-not-null.md)).

Domanda: su quale connessione stanno `Activity`, `Snapshot`, `StoredEvent` e i modelli del modulo?

## Decisione

- `app/Models/BaseModel.php`, `Activity.php`, `Snapshot.php`, `StoredEvent.php` dichiarano `protected $connection = 'activity'`.
- Nessun modello del modulo usa `null` (= default): un modello nuovo estende `BaseModel` ed eredita la connessione.

## Alternative scartate

- `$connection = null`: tutto sulla default; si perde la possibilità di separare il log e, nei test, le scritture su
  una connessione non transatta restano nel database.
- Connessione letta da config (`activitylog.database_connection`): è la via di Spatie, ma vale solo per i suoi modelli e
  il default (`ACTIVITY_LOGGER_DB_CONNECTION` vuoto) è la connessione di default, non quella del modulo.

## Conseguenze

- Pro: separare il log in un altro database è solo configurazione; rollback dei test coerente.
- Contro: due vie di scrittura possono divergere. `config/activitylog.php` del progetto ha
  `activity_model = Spatie\Activitylog\Models\Activity` e `database_connection` da env (vuoto = default): il trait
  `LogsActivity` e l'helper `activity()` (usato per esempio nella registrazione utente) scrivono sulla connessione di
  default con il modello di Spatie, mentre il pannello legge con `Modules\Activity\Models\Activity` su `activity`. Finché
  `activity` è un alias della default è la stessa tabella; con un database separato non lo è più.
- Debito: `IsActivityLogSchemaWritableAction` controlla la connessione di `activitylog.database_connection`, non `activity`.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/BaseModelTest.php` (test «base model uses activity
  connection») e `Modules/Activity/tests/Unit/Actions/RedactModelAttributesActionTest.php` (test «Activity espone
  connection…» e «modelli event-sourcing usano…»): falliscono se la connessione cambia.
- Solo revisione: l'allineamento tra `config/activitylog.php` e la connessione `activity` (nessun test).
