# Deep Dive: `php artisan migrate --env=testing` (2026-03-06)

## Scope

Analisi tecnica eseguita dalla root `laravel/` con focus su:

```bash
php artisan migrate --env=testing
```

Nessuna modifica codice in questo step: solo analisi e documentazione.

## Riproduzione Errori

### 1) Errore primario (config corrente `.env.testing`)

Comando:

```bash
php artisan migrate --env=testing
```

Esito:
- `SQLSTATE[HY000] [2002] Unknown error while connecting`
- connessione `mysql` su `127.0.0.1:3306`
<<<<<<< .merge_file_sZf36w
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- database target `<nome progetto>_data_test`
=======
- database target `laravelpizza_data_test`
>>>>>>> a038b0f2 (.)
=======
- database target `<nome progetto>_data_test`
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- database target `laravelpizza_data_test`
>>>>>>> a038b0f2 (.)
=======
- database target `<nome progetto>_data_test`
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- database target `laravelpizza_data_test`
>>>>>>> a038b0f2 (.)
=======
- database target `<nome progetto>_data_test`
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- database target `<nome progetto>_data_test` (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)- database target `<nome progetto>_data_test`
>>>>>>> e3956292 (.)
=======
- database target `<nome progetto>_data_test` (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)- database target `<nome progetto>_data_test`
>>>>>>> .merge_file_Uqe00k

Conclusione:
- blocco infrastrutturale: MySQL testing non raggiungibile nell'ambiente attuale.

### 2) Errore secondario (forzando sqlite con path assoluto)

Comando:

```bash
<<<<<<< .merge_file_sZf36w
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_<nome progetto>/laravel/database/testing.sqlite php artisan migrate --env=testing
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_laravelpizza/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> a038b0f2 (.)
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_<nome progetto>/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_laravelpizza/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> a038b0f2 (.)
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_<nome progetto>/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_laravelpizza/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> a038b0f2 (.)
=======
DB_CONNECTION=sqlite DB_DATABASE=/var/www/_bases/base_<nome progetto>/laravel/database/testing.sqlite php artisan migrate --env=testing
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_CONNECTION=sqlite DB_DATABASE=../../../database/testing.sqlite php artisan migrate --env=testing (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)DB_CONNECTION=sqlite DB_DATABASE=../../../database/testing.sqlite php artisan migrate --env=testing
>>>>>>> e3956292 (.)
=======
DB_CONNECTION=sqlite DB_DATABASE=../../../database/testing.sqlite php artisan migrate --env=testing (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)DB_CONNECTION=sqlite DB_DATABASE=../../../database/testing.sqlite php artisan migrate --env=testing
>>>>>>> .merge_file_Uqe00k
```

Esito:
- path sqlite corrotto: `.../database/var/www/.../testing.sqlite.sqlite`

Conclusione:
- concatenazione path/estensione non robusta nella config tenant locale.

### 3) Errore terziario (forzando sqlite con basename)

Comando:

```bash
DB_CONNECTION=sqlite DB_DATABASE=testing php artisan migrate --env=testing --no-interaction
```

Esito:
- migrazioni avviate, poi failure su `2025_01_01_000008_create_event_user_table`
- `duplicate column name: user_id`

Conclusione:
- failure strutturale migration Meetup indipendente dalla sola connettività.

## Root Cause Chain

1. **Infra**: ambiente locale non espone MySQL testing raggiungibile.
2. **Config tenant sqlite**: costruzione `database_path(...'.sqlite')` non tollera input già path/già `.sqlite`.
3. **Migrazione Meetup**: `event_user.user_id` dichiarata due volte (colonna esplicita + helper timestamps con `user_id`).

## Riferimenti Tecnici

<<<<<<< .merge_file_sZf36w
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
=======
- `config/local/laravelpizza/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> a038b0f2 (.)
=======
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- `config/local/laravelpizza/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> a038b0f2 (.)
=======
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- `config/local/laravelpizza/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> a038b0f2 (.)
=======
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`) (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> e3956292 (.)
=======
- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`) (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)- `config/local/<nome progetto>/database.php` (sqlite usa `database_path(env('DB_DATABASE', 'db_data').'.sqlite')`)
>>>>>>> .merge_file_Uqe00k
- `Modules/Xot/app/Database/Migrations/XotBaseMigration.php` (`timestamps()` aggiunge anche `user_id`, `updated_by`, `created_by`)
- `Modules/Meetup/database/migrations/2025_01_01_000008_create_event_user_table.php` (definisce già `user_id` prima di `timestamps()`)

## Direzione Solutiva (proposta)

1. Decidere policy ufficiale per testing CLI:
   - `mysql` obbligatorio e servizio sempre attivo, **oppure**
   - fallback sqlite ufficialmente supportato anche per `artisan migrate`.
2. Normalizzare strategia sqlite:
   - `DB_DATABASE` come basename senza `.sqlite`, **oppure**
   - config che accetta path assoluto senza doppia trasformazione.
3. Correggere migration Meetup `event_user` per eliminare la duplicazione di `user_id`.

## Risoluzione (2026-03-06)

### Fix 1: event_user duplicate user_id

**File:** `Modules/Meetup/database/migrations/2025_01_01_000008_create_event_user_table.php`
**Problema:** Colonna `user_id` definita esplicitamente PRIMA di `timestamps()`, che aggiunge `user_id` tramite `foreignIdFor()`.
**Soluzione:** Rimosso `$table->string('user_id', 36)->index()` esplicito - ora `timestamps()` aggiunge automaticamente `user_id`.

### Fix 2: add_organizer_id migration

**File:** `Modules/Meetup/database/migrations/2026_03_04_000001_add_organizer_id_to_events_table.php`
**Problema:** Migrazione assume `user_id` esista giá ma non lo verifica prima di aggiungere `organizer_id after user_id`.
**Soluzione:** Aggiunta logica che verifica/crea `user_id` PRIMA di aggiungere `organizer_id`.

### Fix 3: Centralizzazione DatabaseTransactions

**File:** `Modules/Xot/tests/XotBaseTestCase.php`
- Aggiunto trait `DatabaseTransactions`
- Aggiunto `$connectionsToTransact = ['mysql']`
- Aggiunto metodo `ensureTestDatabasesExist()` per creare database test automaticamente
- Aggiunta chiamata `module:migrate` in `createApplication()`

## Nota Multi-Agent

Le evidenze raccolte sono coerenti con commenti recenti in Issue #208 e Discussion #207:
- blocchi DB in ambiente test;
- rumore infrastrutturale su coverage quando la base migrate/config non è stabile.

