# Inventario migration User

Percorso attivo: `database/migrations/`. ~~Copia legacy `Database/Migrations/`~~ rimossa 2026-06-18.

Pattern dominante: `XotBaseMigration` con blocco **create** (`tableCreate`) + **update** (`tableUpdate`) nello stesso file.

## Legenda ruoli

| Ruolo | Significato |
|-------|-------------|
| create+update | Tabella nuova + colonne/idempotenza su DB esistente |
| create | Solo creazione tabella |
| update | Solo alter (es. colonna `lang` su `users`) |
| altro | Schema builder diretto o file non standard |
| non attivo | Suffisso `.fortify`, `.wip`, `.old` — Laravel non li carica |

## Duplicati noti (non archiviati)

Più file per la stessa tabella; da consolidare in futuro nella migration con timestamp più recente.

| Tabella | File (ordine cronologico) | Nota |
|---------|---------------------------|------|
| users | `2024_01_01_000001`, `000002`, `000006`, `000007`, `2026_02_13_172136` | `172135` = solo update `lang` (ridondante vs `000007`) |
| profiles | `2022_01_01_000000`, `2026_01_01_000000`, `2026_03_12_172000`, `2026_04_28_120000` | UUID / ownership in evoluzione |
| devices | `2023_01_01_000000`, `000001` | |
| oauth_clients | `2023_01_01_000004`, `000005`, `2026_03_01_000003` | |
| team_user | `2023_01_01_000004`, `000006`, `2025_01_22_120000`, `2026_01_12_114416` | |
| teams | `2023_01_01_000006`, `000007`, `2025_05_16_221811` | `add_owner_id` = update teams |
| tenants | `2023_01_01_000008`, `2026_01_01_000001` | |
| roles | `2023_01_01_000011`, `000012`, `2024_01_01_000011`, `2025_09_18` (solo update) | |
| permissions | `2023_01_22_000007`, `000008` | |
| model_has_roles | `2024_12_05_000034`, `000035`, `2026_01_01_000035` | |
| authentication_log | `2024_01_01_000001`, `000002` | |
| device_user | `2023_01_01_000004`, `2024_01_01_000004` | |

## Elenco `database/migrations/`

| File | Tabella | Ruolo | Note |
|------|---------|-------|------|
| `2014_10_12_100002_create_password_resets_table.php` | password_resets | create+update | |
| `2019_12_14_000001_create_personal_access_tokens_table.php` | personal_access_tokens | create+update | Sanctum |
| `2020_01_01_000003_create_oauth_refresh_tokens_table.php` | oauth_refresh_tokens | create+update | Passport |
| `2022_01_01_000000_create_profiles_table.php` | profiles | create+update | |
| `2023_01_01_000000_create_devices_table.php` | devices | create+update | |
| `2023_01_01_000000_create_oauth_auth_codes_table.php` | oauth_auth_codes | create+update | |
| `2023_01_01_000001_create_devices_table.php` | devices | create+update | Duplicato devices |
| `2023_01_01_000002_create_team_invitations_table.php` | team_invitations | create+update | Jetstream |
| `2023_01_01_000003_create_oauth_access_tokens_table.php` | oauth_access_tokens | create+update | |
| `2023_01_01_000003_create_socialite_user_table.php` | socialite_user | create+update | |
| `2023_01_01_000003_create_tenant_user_table.php` | tenant_user | create+update | |
| `2023_01_01_000004_create_device_user_table.php` | device_user | create+update | |
| `2023_01_01_000004_create_oauth_clients_table.php` | oauth_clients | create+update | |
| `2023_01_01_000004_create_team_user_table.php` | team_user | create+update | |
| `2023_01_01_000005_create_model_has_permissions_table.php` | model_has_permissions | create+update | Spatie |
| `2023_01_01_000005_create_oauth_clients_table.php` | oauth_clients | create+update | Duplicato |
| `2023_01_01_000005_create_oauth_personal_access_clients_table.php` | oauth_personal_access_clients | create+update | |
| `2023_01_01_000006_create_team_user_table.php` | team_user | create+update | Duplicato |
| `2023_01_01_000006_create_teams_table.php` | teams | create+update | |
| `2023_01_01_000007_create_teams_table.php` | teams | create+update | Duplicato |
| `2023_01_01_000008_create_tenants_table.php` | tenants | create+update | |
| `2023_01_01_000010_create_role_has_permissions_table.php` | role_has_permissions | create+update | |
| `2023_01_01_000011_create_roles_table.php` | roles | create+update | |
| `2023_01_01_000012_create_roles_table.php` | roles | create+update | Duplicato |
| `2023_01_01_093340_create_permission_table.php` | permission | altro | Legacy naming |
| `2023_01_22_000007_create_permissions_table.php` | permissions | create+update | |
| `2023_01_22_000008_create_permissions_table.php` | permissions | create+update | Duplicato |
| `2024_01_01_000001_create_authentication_log_table.php` | authentication_log | create+update | |
| `2024_01_01_000001_create_users_table.php` | users | create+update | |
| `2024_01_01_000002_create_authentication_log_table.php` | authentication_log | create+update | Duplicato |
| `2024_01_01_000002_create_users_table.php` | users | create+update | Duplicato |
| `2024_01_01_000004_create_device_user_table.php` | device_user | create+update | |
| `2024_01_01_000006_create_users_table.php` | users | create+update | |
| `2024_01_01_000007_create_users_table.php` | users | create+update | Riferimento per colonna `lang` |
| `2024_01_01_000008_create_profile_team_table.php` | profile_team | create+update | |
| `2024_01_01_000011_create_permission_role_table.php` | permission_role | create+update | |
| `2024_01_01_000011_create_roles_table.php` | roles | create+update | |
| `2024_01_01_000015_create_user_extra_table.php` | user_extra | create+update | |
| `2024_03_27_000000_create_authentications_table.php` | authentications | create | |
| `2024_09_26_100442_create_features_table.php` | features | create | Pennant |
| `2024_12_05_000034_create_model_has_roles_table.php` | model_has_roles | create+update | |
| `2024_12_05_000035_create_model_has_roles_table.php` | model_has_roles | create+update | Duplicato |
| `2025_01_22_120000_create_team_user_table.php` | team_user | create+update | |
| `2025_01_22_120001_create_team_permissions_table.php` | team_permissions | create+update | |
| `2025_05_16_221811_add_owner_id_to_teams_table.php` | teams | update | Aggiunge `owner_id` |
| `2025_05_16_221811_create_teams_table.php` | teams | altro | Verificare prima di archiviare |
| `2025_09_18_000000_create_roles_table.php` | roles | update | |
| `2025_10_15_153835_create_sso_providers_table.php` | sso_providers | create+update | |
| `2026_01_01_000000_create_profiles_table.php` | profiles | create+update | |
| `2026_01_01_000001_create_tenants_table.php` | tenants | create+update | |
| `2026_01_01_000002_create_tenant_user_table.php` | tenant_user | create+update | |
| `2026_01_01_000035_create_model_has_roles_table.php` | model_has_roles | create+update | |
| `2026_01_12_114416_create_team_user_table.php` | team_user | create+update | |
| `2026_02_13_172135_create_users_table.php` | users | update | Ridondante (`lang`) |
| `2026_02_13_172136_create_users_table.php` | users | create+update | Commento: overlap con `000007` |
| `2026_03_01_000003_create_oauth_clients_table.php` | oauth_clients | create+update | |
| `2026_03_12_172000_create_profiles_table.php` | profiles | create+update | |
| `2026_04_28_120000_create_profiles_table.php` | profiles | create+update | |

## File non eseguiti (suffisso)

| File | Ruolo |
|------|-------|
| `2014_10_12_200000_add_two_factor_columns_to_users_table.fortify` | update Fortify |
| `2024_03_27_000001_create_user_authentications_table.wip` | WIP |
| `2026_01_01_000001_create_tenants_table.php.old` | backup |
| `2023_01_01_000008_create_tenants_table.php.LARAXOT_CORRECT` | variante manuale |

## `Database/Migrations/` (legacy)

~~Rimossa 2026-06-18.~~ Canon: solo `database/migrations/` (minuscolo). Vedi [architecture-module-directory-structure.md](../../../../../../docs/wiki/bmad/architecture-module-directory-structure.md).

## Collegamenti

- [profile-migration-uuid-contract.md](./profile-migration-uuid-contract.md)
- [mariadb-create-table-after-rule.md](./mariadb-create-table-after-rule.md)
