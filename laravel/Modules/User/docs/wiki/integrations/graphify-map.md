---
title: "User Module: Mappa Graphify"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "user module   mappa graphify user"
---

# User Module: Mappa Graphify

**Versione:** 2.0.0 | **Modulo:** User | **Data:** 2026-08-02 | **Autore:** @marco76tv

---

## 📌 Cosa fa il modulo User

Il modulo **User** è il **cuore dell'autenticazione e autorizzazione** del sistema Laraxot. Gestisce:

- **Gestione Utenti:** Registrazione, login, profili, account management (`User`, `Profile`)
- **Ruoli e Permessi:** Spatie Permission integration per RBAC (`Role`, `Permission`, `ModelHasRole`, `ModelHasPermission`)
- **Teams/Organizzazioni:** Multi-team support per utente (`Team`, `TeamUser`, `TeamInvitation`, `TeamPermission`)
- **Autenticazione:** Sessioni, dispositivi, device tracking, 2FA (`AuthenticationLog`, `Device`, `DeviceUser`, `DeviceProfile`)
- **OAuth & Passport:** Client management, token lifecycle, SSO (`OauthClient`, `OauthAccessToken`, `OauthAuthCode`, `OauthRefreshToken`, `PersonalAccessToken`)
- **Social Login:** Socialite integration, multi-provider support (`SocialiteUser`, `SocialProvider`, `SsoProvider`)
- **Multi-Tenancy:** Tenant isolation per utente (`Tenant`, `TenantUser`, `BaseInteractsWithTenant`)
- **Admin Panel:** Filament resources per gestione utenti, ruoli, permessi, team, device, oauth client

---

## 🏗️ Architettura Essenziale

### Entry Points: Models (Database Layer)

#### Core Identity
| Classe | Path | Scopo |
|--------|------|-------|
| `User` | `app/Models/User.php` | User principale (extends `BaseUser`, Spatie traits) |
| `Profile` | `app/Models/Profile.php` | Extended profile info (media, preferences, schemaless extras) |
| `Tenant` | `app/Models/Tenant.php` | Tenant container per isolation |
| `TenantUser` | `app/Models/TenantUser.php` | Pivot tenant-user relazionale |

#### Teams & Organization
| Classe | Path | Scopo |
|--------|------|-------|
| `Team` | `app/Models/Team.php` | Team/Organization entity (extends `BaseTeam`) |
| `TeamUser` | `app/Models/TeamUser.php` | Pivot team-user relazionale |
| `TeamInvitation` | `app/Models/TeamInvitation.php` | Invite workflow |
| `TeamPermission` | `app/Models/TeamPermission.php` | Team-scoped permission override |
| `ProfileTeam` | `app/Models/ProfileTeam.php` | Pivot profile-team |

#### RBAC (Roles & Permissions)
| Classe | Path | Scopo |
|--------|------|-------|
| `Role` | `app/Models/Role.php` | Spatie Role |
| `Permission` | `app/Models/Permission.php` | Spatie Permission |
| `ModelHasRole` | `app/Models/ModelHasRole.php` | Pivot model-role (morphable) |
| `ModelHasPermission` | `app/Models/ModelHasPermission.php` | Pivot model-permission (morphable) |
| `RoleHasPermission` | `app/Models/RoleHasPermission.php` | Pivot role-permission |
| `PermissionRole` | `app/Models/PermissionRole.php` | Explicit permission-role join |
| `PermissionUser` | `app/Models/PermissionUser.php` | Direct user-permission assign |

#### Authentication & Sessions
| Classe | Path | Scopo |
|--------|------|-------|
| `AuthenticationLog` | `app/Models/AuthenticationLog.php` | Login history per device/session |
| `Device` | `app/Models/Device.php` | Trusted device tracking (2FA bypass) |
| `DeviceUser` | `app/Models/DeviceUser.php` | Pivot device-user |
| `DeviceProfile` | `app/Models/DeviceProfile.php` | Pivot device-profile |
| `Notification` | `app/Models/Notification.php` | Laravel notifications |

#### OAuth & Token Management
| Classe | Path | Scopo |
|--------|------|-------|
| `OauthClient` | `app/Models/OauthClient.php` | Passport client registry |
| `OauthAccessToken` | `app/Models/OauthAccessToken.php` | Active access token |
| `OauthAuthCode` | `app/Models/OauthAuthCode.php` | OAuth2 auth code (temp) |
| `OauthRefreshToken` | `app/Models/OauthRefreshToken.php` | OAuth2 refresh token |
| `OauthToken` | `app/Models/OauthToken.php` | Generic token wrapper |
| `OauthPersonalAccessClient` | `app/Models/OauthPersonalAccessClient.php` | Personal access token client |
| `PersonalAccessToken` | `app/Models/PersonalAccessToken.php` | Sanctum token alternative |

#### Social & SSO
| Classe | Path | Scopo |
|--------|------|-------|
| `SocialiteUser` | `app/Models/SocialiteUser.php` | Socialite login tracking |
| `SocialProvider` | `app/Models/SocialProvider.php` | Social provider config (Google, GitHub, etc.) |
| `SsoProvider` | `app/Models/SsoProvider.php` | Enterprise SSO provider |

#### Password & Recovery
| Classe | Path | Scopo |
|--------|------|-------|
| `PasswordReset` | `app/Models/PasswordReset.php` | Password reset token trail |

#### Misc & Utility
| Classe | Path | Scopo |
|--------|------|-------|
| `Extra` | `app/Models/Extra.php` | Schemaless key-value storage |
| `Membership` | `app/Models/Membership.php` | User membership status |
| `Feature` | `app/Models/Feature.php` | Feature flag per user/tenant |
| `OauthDeviceCode` | `app/Models/OauthDeviceCode.php` | Device code flow (OAuth2) |

#### Base Classes & Traits
| Classe | Path | Scopo |
|--------|------|-------|
| `BaseUser` | `app/Models/BaseUser.php` | Abstract base con Spatie traits |
| `BaseProfile` | `app/Models/BaseProfile.php` | Abstract profile base |
| `BaseTeam` | `app/Models/BaseTeam.php` | Abstract team base |
| `BaseTeamUser` | `app/Models/BaseTeamUser.php` | Abstract pivot team-user |
| `BaseTenant` | `app/Models/BaseTenant.php` | Abstract tenant base |
| `BaseModel` | `app/Models/BaseModel.php` | Custom eloquent base |
| `BaseUuidModel` | `app/Models/BaseUuidModel.php` | UUID primary key base |
| `BasePivot` | `app/Models/BasePivot.php` | Custom pivot base |
| `BaseMorphPivot` | `app/Models/BaseMorphPivot.php` | Morphable pivot base |
| `BaseInteractsWithTenant` | `app/Models/BaseInteractsWithTenant.php` | Tenant isolation trait |
| `BaseInteractsWithExtra` | `app/Models/BaseInteractsWithExtra.php` | Schemaless extras trait |
| `BaseIsTenant` | `app/Models/BaseIsTenant.php` | Tenant container trait |

### Entry Points: Actions (Business Logic)

| Classe | Path | Scopo |
|--------|------|-------|
| `CreateUserAction` | `app/Actions/CreateUserAction.php` | User registration orchestrator |
| `GetPermissionModelAction` | `app/Actions/GetPermissionModelAction.php` | Query model-level permissions |
| `GetCurrentDeviceAction` | `app/Actions/GetCurrentDeviceAction.php` | Detect current device from request |

### Entry Points: Events (Observer Pattern)

| Evento | Path | Trigger |
|--------|------|---------|
| `Login` | `app/Events/Login.php` | User login successful |
| `Registered` | `app/Events/Registered.php` | New user registered |
| `UserRegistered` | `app/Events/UserRegistered.php` | User account created |
| `TeamCreated` | `app/Events/TeamCreated.php` | New team created |
| `TeamUpdated` | `app/Events/TeamUpdated.php` | Team modified |
| `TeamDeleted` | `app/Events/TeamDeleted.php` | Team removed |
| `TeamSwitched` | `app/Events/TeamSwitched.php` | User switched active team |
| `TeamMemberAdded` | `app/Events/TeamMemberAdded.php` | User added to team |
| `TeamMemberRemoved` | `app/Events/TeamMemberRemoved.php` | User removed from team |
| `TeamMemberUpdated` | `app/Events/TeamMemberUpdated.php` | Team member role changed |
| `TwoFactorAuthenticationEnabled` | `app/Events/TwoFactorAuthenticationEnabled.php` | 2FA enabled |
| `TwoFactorAuthenticationDisabled` | `app/Events/TwoFactorAuthenticationDisabled.php` | 2FA disabled |
| `SocialiteUserConnected` | `app/Events/SocialiteUserConnected.php` | Social login linked |
| `RecoveryCodesGenerated` | `app/Events/RecoveryCodesGenerated.php` | 2FA recovery codes issued |

### Entry Points: Enums

| Enum | Path | Valori |
|------|------|--------|
| `SystemRole` | `app/Enums/SystemRole.php` | Sistema roles (admin, user, guest, etc.) |
| `UserType` | `app/Enums/UserType.php` | User categories (individual, organization, bot, etc.) |
| `SocialProviderEnum` | `app/Enums/SocialProviderEnum.php` | Social platforms (google, github, microsoft, etc.) |
| `LanguageEnum` | `app/Enums/LanguageEnum.php` | Supported languages (it, en, de, etc.) |

### Entry Points: Data Classes (DTOs)

| Data Class | Path | Scopo |
|------------|------|-------|
| `CreateUserData` | `app/Datas/CreateUserData.php` | Registration form DTO |
| `FilamentUserData` | `app/Datas/FilamentUserData.php` | Filament user edit DTO |
| `PermissionData` | `app/Datas/PermissionData.php` | Permission structure DTO |
| `PermissionCacheData` | `app/Datas/PermissionCacheData.php` | Permission cache state DTO |
| `PermissionColumnNamesData` | `app/Datas/PermissionColumnNamesData.php` | Permission DB schema DTO |
| `PermissionModelsData` | `app/Datas/PermissionModelsData.php` | Morphable models list DTO |
| `PermissionTableNamesData` | `app/Datas/PermissionTableNamesData.php` | Permission table names DTO |
| `FilamentShieldData` | `app/Datas/FilamentShieldData.php` | Filament Shield config DTO |
| `DeviceData` | `app/Datas/DeviceData.php` | Device fingerprint DTO |
| `PasswordData` | `app/Datas/PasswordData.php` | Password change DTO |

### Entry Points: Filament Resources (Admin UI)

**Core Entities:**
- `UserResource`: User management
- `ProfileResource`: User profiles
- `TeamResource`: Teams/organizations
- `TeamUserResource`: Team members
- `TeamInvitationResource`: Invites
- `TenantResource`: Tenant management
- `TenantUserResource`: Tenant members

**RBAC & Security:**
- `RoleResource`: Roles management
- `PermissionResource`: Permission management
- `ModelHasRoleResource`: Model-role assignments (polymorphic)

**Authentication & Tracking:**
- `AuthenticationLogResource`: Login history
- `DeviceResource`: Trusted device management
- `PersonalAccessTokenResource`: API tokens

**OAuth & Social:**
- `ClientResource` (OauthClientResource): Passport clients
- `OauthAccessTokenResource`: Active tokens
- `OauthAuthCodeResource`: Auth codes
- `OauthRefreshTokenResource`: Refresh tokens
- `OauthPersonalAccessClientResource`: PAC clients
- `SocialiteUserResource`: Social logins
- `SocialProviderResource`: Social config
- `SsoProviderResource`: SSO config

**Misc:**
- `BaseUserResource`, `BaseProfileResource`: Base classes
- `FeatureResource`: Feature flags
- `PasswordResetResource`: Reset tokens

### Entry Points: Controllers

| Controller | Path | Routes |
|------------|------|--------|
| `Controller` | `app/Http/Controllers/Controller.php` | Base controller |
| `UpgradeController` | `app/Http/Controllers/UpgradeController.php` | Upgrade/migration endpoints |

### Entry Points: Contracts & Interfaces

| Interface | Path | Scopo |
|-----------|------|-------|
| `UserContract` | `app/Contracts/UserContract.php` | User type contract |
| `UpdatesUserProfileInformation` | `app/Contracts/UpdatesUserProfileInformation.php` | Profile update contract |

---

## 🔗 Dependencies (Incoming)

Tutti i moduli dipendono da **User** per:

```
Activity → User (audit logging per User login)
Media → User (profile photos via MediaLibrary)
Xot → User (core ProfileContract interface)
Notify → User (send email to users)
[Qualsiasi modulo] → User (Spatie authorization, isAdmin check, etc.)
```

### Dipendenze Specifiche Incoming

```bash
graphify query "modules depending on User"
```

---

## 🔗 Dependencies (Outgoing)

Il modulo **User** dipende da:

```
User → Xot (ProfileContract, XotBase framework)
User → Media (Spatie MediaLibrary per avatar/profile photo)
User → Notify (email notifications: welcome, password reset, 2FA)
User → Spatie/laravel-permission (RBAC)
User → Laravel/Passport (OAuth2)
User → Laravel/Sanctum (token auth, optional)
User → Spatie/laravel-activitylog (optional audit logging)
```

### Dipendenze Specifiche Outgoing

```bash
graphify query "User module dependencies external"
```

---

## 🔗 Relazioni Dati (Schema Logico)

### Grafo Relazionale Core

```
┌─────────────┐
│    User     │◄──────────────┐
│  (auth)     │               │
└──────┬──────┘               │
       │ 1:1                  │ belongsToMany
       │                      │
       ▼                      │
  ┌──────────┐         ┌─────────────┐
  │ Profile  │         │    Team     │
  │ (info)   │         │  (org)      │
  └─────────┬┘         └────────┬────┘
            │                   │
            │ hasMany           │ 1:N
            │                   │
            ▼                   ▼
       ┌──────────┐      ┌─────────────┐
       │ Device   │      │ TeamUser    │
       │ (2FA)    │      │ (member)    │
       └──────────┘      └─────────────┘
                              │ 1:1
                              ▼
                        ┌──────────────┐
                        │ TeamPerm     │
                        │ (override)   │
                        └──────────────┘

┌─────────────────────────────┐
│  Role ◄─hasMany─ Permission │
│ (Spatie)                    │
└────────┬────────────────────┘
         │ morphMany
         │
         ▼
  ┌──────────────────┐
  │ ModelHasRole     │
  │ (polymorphic)    │
  └──────────────────┘
         │ morphMany
         │
         ▼
  ┌──────────────────┐
  │ ModelHasPermis   │
  │ (morphic)        │
  └──────────────────┘

┌──────────────────────────────────────┐
│  OAuth & Token Management            │
│                                      │
│  OauthClient ◄─ hasMany ─ Tokens    │
│  (client_id)    (access_token)      │
│                 (auth_code)         │
│                 (refresh_token)     │
└──────────────────────────────────────┘

┌──────────────────────────────────────┐
│  Social & SSO                        │
│                                      │
│  User ◄─ hasMany ─ SocialiteUser    │
│           (provider_id)              │
│                                      │
│  SocialProvider ─ config data        │
│  SsoProvider ─ enterprise SSO        │
└──────────────────────────────────────┘

┌──────────────────────────────────────┐
│  Multi-Tenancy                       │
│                                      │
│  Tenant ◄─ 1:N ─ TenantUser ─ User  │
│  (isolation)     (ownership)         │
└──────────────────────────────────────┘
```

### Tabelle Principali

```
users (PK: id)
├── id (UUID)
├── email (unique)
├── password (hashed)
├── current_team_id → teams.id
├── is_active, is_otp
├── password_expires_at
├── lang (LanguageEnum)
├── created_by, updated_by, deleted_by (audit)
└── timestamps + soft_delete

profiles (PK: id)
├── id (UUID)
├── user_id → users.id (unique)
├── first_name, last_name, user_name
├── email, phone
├── avatar, timezone, locale
├── preferences (JSON)
├── status
├── extra (schemaless JSON)
└── timestamps

teams (PK: id)
├── id (UUID)
├── name, description
├── user_id → users.id (owner)
├── personal_team (bool)
└── timestamps

team_users (PK: team_id + user_id)
├── team_id → teams.id
├── user_id → users.id
├── role (nullable)
└── timestamps

roles (PK: id)
├── id (UUID)
├── name (unique)
├── guard_name (default: 'web')
├── description
└── timestamps

permissions (PK: id)
├── id (UUID)
├── name (unique)
├── guard_name
├── description
└── timestamps

role_has_permissions (PK: role_id + permission_id)
├── role_id → roles.id
├── permission_id → permissions.id

devices (PK: id)
├── id (UUID)
├── user_id → users.id
├── name
├── user_agent
├── ip_address
├── last_seen_at
└── timestamps

oauth_clients (PK: id)
├── id (UUID)
├── user_id → users.id (nullable)
├── name
├── secret
├── redirect (URI)
├── personal_access_client (bool)
├── password_client (bool)
└── revoked

oauth_access_tokens (PK: id)
├── id (UUID)
├── client_id → oauth_clients.id
├── user_id → users.id (nullable)
├── name
├── scopes (JSON)
├── revoked
└── expires_at

authentication_logs (PK: id)
├── id (UUID)
├── user_id → users.id
├── device_id → devices.id (nullable)
├── ip_address
├── user_agent
├── login_at
└── timestamps

tenants (PK: id)
├── id (UUID)
├── name
├── slug (unique)
└── timestamps

tenant_users (PK: tenant_id + user_id)
├── tenant_id → tenants.id
├── user_id → users.id
├── role
└── timestamps
```

---

## 📊 Grafo Locale (Query Rapide)

### Scoprire Architettura Core

```bash
# Tutti i models nel modulo
graphify query "User module all models"

# Entry points principali
graphify query "User module User Profile Team models"

# Actions e business logic
graphify query "User module Actions"

# Filament resources per admin
graphify query "User module Filament Resources"

# Events trigger nel modulo
graphify query "User module Events"
```

### Tracciare Flussi Principali

```bash
# Flusso di registrazione
graphify path --from "CreateUserAction" --to "User"

# Flusso di autenticazione
graphify path --from "AuthenticationLog" --to "User"

# Flusso di team
graphify path --from "TeamInvitation" --to "Team"

# Flusso OAuth
graphify path --from "OauthClient" --to "OauthAccessToken"
```

### Trovare Dipendenze

```bash
# Dipendenze incoming (chi dipende da User)
graphify query "User dependencies incoming"

# Dipendenze outgoing (User dipende da)
graphify query "User dependencies outgoing"

# Spatie Permission integration
graphify query "User Spatie Permission Role"

# OAuth Passport integration
graphify query "User OAuth Passport Client Token"
```

### Trovare Complessità

```bash
# Alta complessità nei models
graphify query "User module high complexity"

# Cyclomatic complexity in Actions
graphify query "User module Actions cyclomatic"

# Database queries N+1 risk
graphify query "User module eager loading"
```

---

## 🎯 Task Comuni + Graphify

### Task 1: Aggiungere Ruolo Customizzato per un Modulo Esterno

**Scenario:** Un modulo esterno (es. Activity) vuole aggiungere il ruolo `auditor`.

**Domanda Graphify:**
```bash
graphify query "User Spatie Permission Role add new role"
```

**Workflow:**
1. Crea migration in User module: `database/migrations/add_auditor_role.php`
   ```php
   Role::create(['name' => 'auditor', 'guard_name' => 'web', 'description' => 'Audit logs viewer']);
   ```
2. Assegna permessi al ruolo:
   ```php
   $auditorRole->givePermissionTo(['view-logs', 'view-audit']);
   ```
3. Nel modulo che consuma:
   ```php
   $user->assignRole('auditor');
   if ($user->hasRole('auditor')) { /* can audit */ }
   ```
4. Test: `tests/Feature/RoleTest.php`
5. Graphify verifica: `graphify query "User Role auditor references"`

---

### Task 2: Tracciare Login e Audit Trail

**Scenario:** Aggiungi tracking avanzato per ogni login con device fingerprint.

**Domanda Graphify:**
```bash
graphify query "User AuthenticationLog Device tracking"
```

**Workflow:**
1. In `app/Actions/CreateUserAction.php`, aggiorna per loggare:
   ```php
   AuthenticationLog::create([
       'user_id' => $user->id,
       'device_id' => $device->id,
       'ip_address' => request()->ip(),
       'user_agent' => request()->userAgent(),
   ]);
   ```
2. In `app/Models/AuthenticationLog.php`, aggiungi scope:
   ```php
   public function scopeRecent($query, $hours = 24) {
       return $query->where('login_at', '>=', now()->subHours($hours));
   }
   ```
3. Query Graphify per verificare:
   ```bash
   graphify query "User AuthenticationLog Device relationships"
   ```
4. Test: `tests/Feature/AuthenticationLogTest.php`

---

### Task 3: Estendere OAuth Passport per Nuovi Scopes

**Scenario:** Aggiungi scope customizzato per accesso limited API.

**Domanda Graphify:**
```bash
graphify query "User OauthClient OauthAccessToken scopes"
```

**Workflow:**
1. In `config/passport.php`, definisci scope:
   ```php
   'scopes' => [
       'read-activities' => 'Read activity logs',
       'write-reports' => 'Write reports',
   ],
   ```
2. In `app/Actions/`, aggiungi `IssueTokenAction.php`:
   ```php
   $token = $user->createToken('token-name', ['read-activities']);
   ```
3. Middleware in `app/Http/Middleware/CheckScopes.php`:
   ```php
   if (!auth('api')->check() || !auth('api')->user()->tokenCan('read-activities')) {
       abort(403);
   }
   ```
4. Test: `tests/Feature/OauthScopeTest.php`
5. Graphify: `graphify query "User OauthAccessToken scope validation"`

---

### Task 4: Implementare Multi-Tenancy

**Scenario:** Utenti su tenant diversi non vedono dati l'uno dell'altro.

**Domanda Graphify:**
```bash
graphify query "User Tenant TenantUser isolation"
```

**Workflow:**
1. Model `Tenant`, `TenantUser` già presenti
2. Usa trait `BaseInteractsWithTenant` in models:
   ```php
   class Activity extends BaseModel {
       use BaseInteractsWithTenant;
   }
   ```
3. Middleware in `app/Http/Middleware/SetTenantContext.php`:
   ```php
   auth()->user()->setCurrentTenant(request()->tenant());
   ```
4. Scope query automatico:
   ```php
   Activity::where('tenant_id', auth()->user()->current_tenant_id)->get();
   ```
5. Test: `tests/Feature/TenantIsolationTest.php`
6. Graphify: `graphify query "User TenantUser BaseInteractsWithTenant"`

---

### Task 5: Sincronizzare Permessi con Filament Shield

**Scenario:** Genera automaticamente Filament resource permissions da Spatie permissions.

**Domanda Graphify:**
```bash
graphify query "User Filament Shield Permission integration"
```

**Workflow:**
1. In `config/filament-shield.php`:
   ```php
   'resources' => [
       UserResource::class,
       ProfileResource::class,
   ],
   ```
2. Esegui: `php artisan shield:generate`
3. Questo sincronizza `Permission` con azioni Filament: `create`, `read`, `update`, `delete`, `list`
4. In Resource:
   ```php
   public static function canViewAny(): bool {
       return auth()->user()->can('view_any_users');
   }
   ```
5. Test: `tests/Feature/FilamentShieldTest.php`
6. Graphify: `graphify query "User Filament Permission sync"`

---

## 📋 Test Coverage Map

```bash
# Scoprire test coverage
graphify query "User module test coverage"

# Test per ogni model
graphify query "User module Models test cases"

# Test per actions
graphify query "User Actions test feature"
```

### Checklist Copertura Essenziale

- [ ] `app/Models/User.php` → `tests/Feature/UserTest.php`
- [ ] `app/Models/Profile.php` → `tests/Feature/ProfileTest.php`
- [ ] `app/Models/Team.php` → `tests/Feature/TeamTest.php`
- [ ] `app/Models/Role.php` + `app/Models/Permission.php` → `tests/Feature/RolePermissionTest.php`
- [ ] `app/Models/AuthenticationLog.php` → `tests/Feature/AuthenticationLogTest.php`
- [ ] `app/Models/Device.php` → `tests/Feature/DeviceTest.php`
- [ ] `app/Models/OauthClient.php` → `tests/Feature/OauthClientTest.php`
- [ ] `app/Actions/CreateUserAction.php` → `tests/Feature/CreateUserActionTest.php`
- [ ] `app/Actions/GetCurrentDeviceAction.php` → `tests/Feature/GetCurrentDeviceActionTest.php`
- [ ] `app/Actions/GetPermissionModelAction.php` → `tests/Feature/GetPermissionModelActionTest.php`
- [ ] `app/Filament/Resources/UserResource.php` → `tests/Feature/Filament/UserResourceTest.php`
- [ ] `app/Filament/Resources/RoleResource.php` → `tests/Feature/Filament/RoleResourceTest.php`
- [ ] `app/Filament/Resources/TeamResource.php` → `tests/Feature/Filament/TeamResourceTest.php`
- [ ] Multi-tenancy isolation → `tests/Feature/TenantIsolationTest.php`
- [ ] OAuth scopes & token lifecycle → `tests/Feature/OauthScopeTest.php`
- [ ] Social login flow → `tests/Feature/SocialiteUserTest.php`
- [ ] 2FA enable/disable → `tests/Feature/TwoFactorAuthenticationTest.php`

---

## 🚀 Comandi Rapidi

### Esplorazione Architettura

```bash
# Intera architettura del modulo
graphify query "User module architecture"

# Models e relationships
graphify query "User module models relationships"

# Actions e business logic
graphify query "User module Actions methods"

# Events trigger
graphify query "User module Events when fired"

# Filament resources completo
graphify query "User module Filament resources"
```

### Analisi & Debugging

```bash
# Complessità ciclomatica
graphify query "User module high complexity"

# Possibili N+1 queries
graphify query "User module eager loading recommendations"

# Accoppiamento tra moduli
graphify query "User module tight coupling"

# Dependency injection issues
graphify query "User module dependency injection"
```

### Test & Quality

```bash
# Test coverage per modulo
graphify query "User module test coverage percentage"

# Test cases mancanti
graphify query "User module untested code"

# PHPStan errors
graphify query "User module PHPStan type errors"

# Code style violations
graphify query "User module Pint style violations"
```

### Performance

```bash
# Query optimization
graphify query "User model query optimization"

# Cache strategy
graphify query "User module caching strategy"

# Memory leaks risk
graphify query "User module memory usage"
```

---

## 📚 Riferimenti

- **Graphify Integration:** `docs/graphify-integration.md`
- **Module Discipline:** `docs/wiki/rules/module-naming-discipline.md`
- **Spatie Permission:** `https://spatie.be/docs/laravel-permission/v6/introduction`
- **Laravel Passport:** `https://laravel.com/docs/11.x/passport`
- **Socialite:** `https://laravel.com/docs/11.x/socialite`
- **Module Architecture:** `../ARCHITECTURE.md`
- **DATABASE Schema:** `../DATABASE-SCHEMA.md`
- **BUSINESS Logic:** `../BUSINESS_LOGIC_DEEP_DIVE.md`

---

**Responsabile:** @marco76tv  
**Versione:** 2.0.0 (Complete)  
**Last updated:** 2026-08-02  
**Status:** ✅ Ready for production use
