---
title: "Migrazioni del modulo User: una tabella, una migrazione"
type: guide
module: User
tags: [migration, consolidation, xotbasemigration, schema, profiles, teams]
qmd: "user migrazioni consolidamento una tabella una migrazione XotBaseMigration tableCreate tableUpdate profiles uuid teams owner_id team_user"
related:
  - "./database-and-relations.md"
---

# Migrazioni del modulo User

Questa pagina e' il riferimento unico sulle migrazioni di `Modules/User/database/migrations` (la regola e il piano di
consolidamento, piu' le correzioni di schema gia' decise). Per relazioni tra database e pivot vedi
[database-and-relations.md](database-and-relations.md).

## Regole

1. **Una tabella, una migrazione.** Per ogni tabella esiste un solo file `create_<tabella>_table.php` autorevole. Una modifica di
   schema entra in quel file, non in un `add_<colonna>_to_<tabella>.php` separato.
2. **`XotBaseMigration` sempre**, con `tableCreate()` (schema completo, gira solo se la tabella non esiste) e `tableUpdate()`
   (controlli idempotenti per ogni colonna). Dentro la migrazione si usano `$this->hasColumn()` e `$this->hasTable()`, mai `Schema::`.
3. **Nome del file derivato dal modello**, non dalla tabella fisica: `XotBaseMigration::getModelClass()` lo risolve dal nome file
   (`{timestamp}_create_{modello_snake_plurale}_table.php`).
4. **Dati sacri.** Mai `migrate:fresh`, `migrate:refresh`, `migrate --force` deciso da un agente, mai `RefreshDatabase` nei test,
   mai `down()` con drop, mai rimozione di colonne: solo aggiunte idempotenti. Per applicare una modifica: modificare il file
   canonico, alzare il timestamp nel nome ed eseguire solo la migrazione della tabella interessata.
5. **Nessun `$connection` nella migrazione**: la connessione arriva dal modello (connessione modulare `user`).
6. Per i riferimenti all'utente non si cita `User::class` ma `XotData::make()->getUserClass()`.

## Perche' consolidare

Piu' file per la stessa tabella rendono incerto lo schema autorevole, creano ordini di esecuzione dipendenti dal timestamp tra
ambienti diversi e violano DRY. La via standard di Laravel (file incrementali) e' stata scartata: con `tableCreate`/`tableUpdate`
un solo file descrive lo schema finale e resta sicuro su qualunque stato del database.

## Piano

1. Raggruppare i file per tabella.
2. Scegliere il piu' vecchio come **ancora**.
3. Fondere nell'ancora tutte le definizioni di colonna: `tableCreate` con lo schema completo per una installazione nuova,
   `tableUpdate` con i controlli per le colonne introdotte dai duplicati.
4. Eliminare i duplicati e verificare con la sola migrazione della tabella.

### Mappa ancora -> duplicati

| Tabella | Ancora | Duplicati da eliminare |
|---|---|---|
| `teams` | `2023_01_01_000006_create_teams_table.php` | `2023_01_01_000007`, `2025_01_22_115959`, `2025_05_16_221811` (create e add_owner_id), `2026_*` |
| `team_user` | `2023_01_01_000004_create_team_user_table.php` | `2023_01_01_000006`, `2025_01_22_120000`, `2026_01_12_114416` |
| `roles` | `2023_01_01_000011_create_roles_table.php` | `2023_01_01_000012`, `2024_01_01_000011`, `2025_09_18_000000`, `2026_09_01_150111` |
| `permissions` | `2023_01_22_000007_create_permissions_table.php` | `2023_01_22_000008`, `2023_01_01_093340_create_permission_table`, `2026_09_01_150112` |
| `users` | `2026_11_12_120000_create_users_table.php` (ancora fissata da `UserMigrationSyntaxTest`: `updateTimestamps(..., hasSoftDeletes: true)`, niente `softDeletes()`) | `2024_01_01_000001/2/6/7`, `2026_02_13_*`, `2026_11_17_114812`; le riparazioni `2026_10_22_000001_repair_users_type_state_columns` e `2026_11_11_000001_add_digital_identity_columns_to_users_table` e `repair_users_deleted_at_column` devono confluire nell'ancora (il test ne pretende l'assenza) |
| `socialite_users` | `2026_11_12_120002_create_socialite_users_table.php` (modello `SocialiteUser`, connessione `user`) | `2023_01_01_000003_create_socialite_user_table.php` (gia' in `_legacy`) |
| `devices` | `2023_01_01_000000_create_devices_table.php` | `2023_01_01_000001`, `2026_01_01_000001` |
| `authentication_log` | `2024_01_01_000001_create_authentication_log_table.php` | `2024_01_01_000002` |
| `model_has_roles` | `2024_12_05_000034_create_model_has_roles_table.php` | `2024_12_05_000035`, `2026_*` |

### Stato osservato

Il consolidamento **non e' completo**: la cartella contiene ancora 84 file `.php` (piu' sottocartelle `_legacy` e `_bak`) con
duplicati per `create_users_table` (8), `create_teams_table` (7), `create_profiles_table` (6), `create_roles_table` (5),
`create_team_user_table` (4), `create_model_has_roles_table` (4), `create_tenants_table`, `create_permissions_table`,
`create_oauth_clients_table`, `create_devices_table` (3 ciascuna) e altre coppie. Consolidare richiede una verifica su una copia
del database, non un taglio a vista: nessun duplicato va tolto senza controllare che l'ancora contenga tutte le sue colonne.

## Correzioni di schema gia' decise

| Argomento | Regola |
|---|---|
| `profiles` | `id` bigint auto-increment (join e indici) piu' `uuid` char(36) univoco separato (identificatore esterno per API, import, sync tra database); `BaseProfile` genera `uuid` in `booted()`. Riparazione di installazioni vecchie: se `id` e' UUID/stringa lo si conserva in `uuid` e si ricrea `id` bigint; se `id` e' gia' intero si aggiunge `uuid` se manca; si riempie `uuid` dove e' nullo. Migrazione correttiva: `2026_10_16_000001_fix_profiles_id_autoincrement.php`. Vedi [user-vs-profile.md](user-vs-profile.md) |
| `teams.owner_id` | colonna dentro `tableCreate()` e, idempotente, in `tableUpdate()`, con `foreignIdFor(XotData::make()->getUserClass(), 'owner_id')->nullable()->index()` (il vecchio `add_owner_id` puntava per errore a `Team::class`) |
| `team_user` | il modello pivot `Membership` usa `id` intero auto-increment (`$keyType = 'int'`): con un `id` UUID senza generazione, `AttachAction` di Filament falliva con `Duplicate entry '' for key 'PRIMARY'`. Il pivot ha anche `role`, `permissions` (JSON) e `joined_at` |
| `users.lang` | `string(5)` default `it`, aggiunta solo se manca (`hasColumn('lang')`) |
| `users.type`/`state`, colonne di identita' digitale, `deleted_at` | vanno nella migrazione ancora `2026_11_12_120000_create_users_table.php`; i file di riparazione separati sono da eliminare dopo il consolidamento |
| colonne 2FA | `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at` nella migrazione `users`; il file separato `add_two_factor_columns` e' disattivato (estensioni `.old`/`.fortify`) |
| `tenants` | un solo `create_tenants_table`; le varianti `.LARAXOT_CORRECT` e `_bak` non sono migrazioni attive |

## Verifica

- `tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php`: fissa le due ancore (`users`, `socialite_users`), pretende l'assenza dei
  file di riparazione elencati sopra e controlla che nessuna migrazione contenga marcatori di conflitto. Il test asserisce quell'assenza, quindi
  non puo' passare finche' i file di riparazione restano in `database/migrations`: e' il promemoria del consolidamento in corso
  (non eseguibile qui: Pest non gira in questa sessione).
- `tests/Feature/MigrateDbTest.php` e `tests/Unit/Database/` per lo schema.
