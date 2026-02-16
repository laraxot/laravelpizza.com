# Case Sensitivity Rules - User Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da User Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

### Entire Database Directory Structure
```
✗ Removed: Database/ (entire directory with all subdirectories)
✓ Kept:    database/

Questo include la rimozione completa di:
- Database/factories/ (tutti i factory files)
- Database/Migrations/ (tutti i migration files)
- Database/seeders/ (tutti i seeder files)
```

## Convenzioni

### Directory Structure
- **Formato**: lowercase per tutte le directory database-related
- **Esempi corretti**:
  - `database/factories/`
  - `database/migrations/`
  - `database/seeders/`
- ❌ **Errato**:
  - `Database/` (qualsiasi variante uppercase)
  - `Database/Factories/`
  - `Database/Migrations/`
  - `Database/Seeders/`

### File Structure
- **Factory files**: PascalCase (es. `UserFactory.php`)
- **Migration files**: snake_case per timestamp + descrizione
- **Seeder files**: PascalCase (es. `UserSeeder.php`, `UserDatabaseSeeder.php`)

## Motivazione

Il modulo User aveva la struttura più complessa di duplicati:
1. Directory `Database/` completamente duplicata con `database/`
2. Tutti i file erano duplicati (factories, migrations, seeders)
3. Potenziale fonte di gravi conflitti in produzione

### Perché Laravel usa `database/` (lowercase)

1. **Standard PSR**: Directory lowercase per organizzazione
2. **Artisan Commands**: Tutti i comandi Laravel puntano a `database/`
3. **Composer Autoload**: PSR-4 mapping richiede consistenza
4. **Framework Convention**: Documentazione ufficiale usa lowercase
5. **Unix/Linux**: Standard filesystem conventions

## Lista Completa File Rimossi

### Factories (29 files)
- AuthenticationFactory.php
- AuthenticationLogFactory.php
- DeviceFactory.php
- DeviceProfileFactory.php
- DeviceUserFactory.php
- ExtraFactory.php
- FeatureFactory.php
- MembershipFactory.php
- ModelHasPermissionFactory.php
- ModelHasRoleFactory.php
- NotificationFactory.php
- OauthAccessTokenFactory.php
- OauthAuthCodeFactory.php
- OauthClientFactory.php
- OauthPersonalAccessClientFactory.php
- OauthRefreshTokenFactory.php
- PasswordResetFactory.php
- PermissionFactory.php
- PermissionRoleFactory.php
- PermissionUserFactory.php
- ProfileFactory.php
- ProfileTeamFactory.php
- RoleFactory.php
- RoleHasPermissionFactory.php
- SocialiteUserFactory.php
- SocialProviderFactory.php
- TeamFactory.php
- TeamInvitationFactory.php
- TeamPermissionFactory.php
- TeamUserFactory.php
- TenantFactory.php
- TenantUserFactory.php
- UserFactory.php

### Migrations (23 files)
- 2014_10_12_100002_create_password_resets_table.php
- 2020_01_01_000003_create_oauth_refresh_tokens_table.php
- 2023_01_01_000000_create_devices_table.php
- 2023_01_01_000000_create_oauth_auth_codes_table.php
- 2023_01_01_000002_create_team_invitations_table.php
- 2023_01_01_000003_create_oauth_access_tokens_table.php
- 2023_01_01_000003_create_socialite_user_table.php
- 2023_01_01_000003_create_tenant_user_table.php
- 2023_01_01_000004_create_device_user_table.php
- 2023_01_01_000004_create_oauth_clients_table.php
- 2023_01_01_000004_create_team_user_table.php
- 2023_01_01_000005_create_model_has_permissions_table.php
- 2023_01_01_000005_create_oauth_personal_access_clients_table.php
- 2023_01_01_000006_create_teams_table.php
- 2023_01_01_000010_create_role_has_permissions_table.php
- 2023_01_01_000011_create_roles_table.php
- 2023_01_01_093340_create_permission_table.php
- 2023_01_22_000007_create_permissions_table.php
- 2024_01_01_000001_create_authentication_log_table.php
- 2024_01_01_000001_create_users_table.php
- 2024_01_01_000002_create_users_table.php
- 2024_01_01_000011_create_permission_role_table.php
- 2024_01_01_000015_create_user_extra_table.php
- 2024_03_27_000000_create_authentications_table.php
- 2024_09_26_100442_create_features_table.php
- 2024_12_05_000034_create_model_has_roles_table.php
- 2024_12_05_000035_create_model_has_roles_table.php
- 2025_05_16_221811_add_owner_id_to_teams_table.php
- 2025_09_18_000000_create_roles_table.php

### Seeders (5 files)
- PermissionsSeeder.php
- RolesSeeder.php
- UserDatabaseSeeder.php
- UserMassSeeder.php
- UserSeeder.php

**Totale: 57 file eliminati dalla directory Database/**

## Impatto e Verifica

### Verifica Integrità

Dopo la rimozione, verificare che:
1. ✅ Tutti i file esistano in `database/` (lowercase)
2. ✅ Artisan commands funzionino correttamente
3. ✅ Migrations si eseguano senza errori
4. ✅ Tests passino con i factory corretti
5. ✅ No git conflicts durante checkout

### Comandi di Verifica

```bash
# Verifica struttura database
ls -la database/factories/ database/migrations/ database/seeders/

# Verifica migrations
php artisan migrate:status

# Verifica factories (in test)
php artisan test

# Verifica nessun riferimento a Database/ uppercase
grep -r "Database/factories" .
grep -r "Database/Migrations" .
grep -r "Database/seeders" .
```

## Update Log

- **2025-11-04**: Major cleanup - Removed entire `Database/` directory
  - 29 factory files
  - 23 migration files
  - 5 seeder files
  - Total: 57 duplicate files eliminated
