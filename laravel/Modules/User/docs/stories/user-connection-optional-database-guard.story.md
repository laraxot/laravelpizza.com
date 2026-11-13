---
id: user-connection-optional-database-guard
title: "User: nessuna query sulla connection user quando il database non è configurato"
type: story
document_type: story
category: bmad-story
status: done
module: User
tags: [auth, login, laravel-log, database, guard]
created: "2026-11-10"
updated: "2026-11-10"
issues: []
discussions: []
---

# User: guard sulla connection `user` opzionale

## Scopo

La connection `user` è opzionale (`config/database.php`). Senza `DB_DATABASE_USER`
`getDatabaseName()` restituisce `NULL`, e ogni `Schema::connection('user')->hasTable()`
manda una query su `information_schema` con database vuoto: MySQL risponde
"Access denied for user ''@'localhost'" e il login fallisce con un'eccezione.

## Causa

- `LoginListener::handle()` verificava `devices`/`device_user` prima di controllare
  che la connection avesse un database.
- `RecordAuthenticationLogAction::execute()` verificava `authentication_logs` allo stesso modo.

## Fatto

- Nuova Action `Modules\User\Actions\Database\IsUserDatabaseConfiguredAction`
  (`QueueableAction`, `execute(): bool`): vero solo se il nome del database è una stringa non vuota.
- `LoginListener`: il ramo device tracking richiede anche `IsUserDatabaseConfiguredAction`.
- `RecordAuthenticationLogAction`: return anticipato con `Log::warning` quando il database non è configurato.
- Firme pubbliche invariate. Nessuna modifica a schema, dati, `.env` o `config/database.php`.

## Verifica

- Riproduzione prima della fix: `Schema::connection('user')->hasTable('devices')` lancia
  `QueryException` 1045 con `Database: ` vuoto.
- Dopo la fix: `LoginListener::handle()` con evento `Login` finto termina senza eccezioni
  (`LOGIN_LISTENER_OK`), l'Action restituisce `false`.
- Test Pest: `Modules/User/tests/Unit/Actions/Database/IsUserDatabaseConfiguredActionTest.php`, 2 passati.
- PHPStan sui 3 file PHP modificati: nessun errore. Pint applicato.
- Log: la voce `Access denied` del 09:34:25 NON è attribuita a questo percorso
  (stack: migrazione `fix_profiles_id_autoincrement`, risolta a `default` con il codice attuale)
  e resta nel log come non verificata.

## Fuori scope (aperto)

- `Modules/User/database/migrations/2026_10_16_000001_fix_profiles_id_autoincrement.php`:
  il percorso attuale è già sicuro, ma non è stato riprodotto l'evento delle 09:34.
- `Modules/Restaurant/database/migrations/2026_10_30_000003_merge_translated_duplicate_rows.php`
  usa `DB::connection('user')->getDatabaseName()` nello stesso modo: da riverificare.
