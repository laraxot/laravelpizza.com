# Login FO: Unknown database 'fixcity_user'

- Stato: parziale (2026-10-07)
- Fase BMAD: Quick Flow (investigate, fix, verifica)
- Owner: Modules/User (connessione `user`), toccati Media, Rating, Fixcity (migrazioni)

## Problema

`POST /livewire/update` da `/it/auth/login`: `SQLSTATE[1049] Unknown database 'fixcity_user'`
in `LoginWidget::login()` (`Auth::attempt`).

## Causa radice

I database `fixcity_user` e `fixcity_data` non esistevano su MariaDB locale (solo `fixcity_data_test`).
Non e' un bug di codice. Lo script citato dalla wiki (`provision-local-mysql.sh`) non esiste piu'.

## Azioni

- `CREATE DATABASE IF NOT EXISTS` per `fixcity_user` e `fixcity_data` (utf8mb4_unicode_ci, come `trade_*`).
- `php artisan migrate --database=user`: su DB fresco falliva per migrazioni raw (`Schema::table`)
  che colpiscono la connessione sbagliata e duplicano migrazioni XotBase gia' corrette.
  Rimosse 4 migrazioni morte:
  - `Media/2026_01_18_152545_add_columns_to_temporary_uploads_table` (colonne gia' nel create 2023)
  - `Rating/2026_03_27_000001_add_percentage_to_rating_morph_table`
  - `Rating/2026_03_27_000002_add_percentage_to_rating_morph_table_on_rating_connection`
    (rating_morph e' creata a luglio, con `percentage` inclusa)
  - `Fixcity/2026_05_29_100000_create_exports_table` (duplicato di `Job/2024_03_12_082158`,
    creava `exports` su `user` con FK `bigint` verso `users.id` uuid)
- Droppata la tabella orfana `fixcity_user.exports` creata dal tentativo fallito.

## Verifica

- Query `User::where('email', ...)->first()` su connessione `user`: nessuna eccezione, risultato null.
- `fixcity_user`: 34 tabelle, `users` presente e vuota.

## Aperto

- `Fixcity/2026_09_27_120000_align_ticket_relation_foreign_keys`: `->change()` di `ticket_comments.user_id`
  da bigint a uuid, MariaDB risponde 4078 (cast non consentito). Bloccante per le 6 migrazioni
  successive (`align_ticket_subscribers_and_coordinates`, `profiles`, `permission_tables`, `create_mobile_tables`).
  Serve correggere i `create` dei ticket per usare uuid fin dall'inizio.
- Nessun utente FO in `users`: serve crearne uno con password nota.
