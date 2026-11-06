---
title: "User - Filosofia Completa: Logica, Religione, Politica, Zen"
type: concept
tags: [philosophy]
created: 2026-07-14
updated: 2026-07-14
qmd: "philosophy user - filosofia completa: logica, religione, politica, zen"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# User - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: [DATE]
**Status**: Documentazione Filosofica Completa
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)

### Principio Fondamentale

**User è il foundation layer per authentication, authorization e multi-tenancy. Gestisce identità, ruoli, permessi, team, tenant.**

### Dominio di Business

Il modulo fornisce **gestione completa utenti** per:
- Autenticazione multi-metodo (email/password, OAuth, 2FA)
- Autorizzazione RBAC (Spatie permissions)
- Single Table Inheritance (STI) per tipi utente (Doctor, Patient, Admin)
- Multi-tenancy con isolamento dati
- Team-based collaboration
- Device tracking per sicurezza

### Entità Core

```
BaseUser (Base - Single Table)
├── User (Estensione applicazione)
├── Doctor (STI - Tipo utente medico)
├── Patient (STI - Tipo utente paziente)
├── Admin (STI - Tipo utente admin)
│
├── Roles (Ruoli Spatie)
├── Permissions (Permessi Spatie)
├── Teams (Collaborazione)
├── Tenants (Multi-tenancy)
└── Profile (Dati estesi)
```

### Business Workflow Principale

1. **Authentication**
   - Login email/password
   - OAuth social (Google, Facebook, etc.)
   - 2FA per sicurezza avanzata
   - Session management

2. **Authorization**
   - Assegnazione ruoli (admin, doctor, patient)
   - Permessi granulari (create, read, update, delete)
   - Policy-based access control
   - Tenant scoping per dottori

3. **Identity Management**
   - Profili estesi (Profile model)
   - Media (avatar, documenti)
   - Preferences utente
   - Activity tracking

### Manifestazione nel Codice

```php
// BaseUser con tutti i trait
class BaseUser extends Authenticatable
{
    use HasApiTokens;      // Passport
    use MustVerifyEmail;
    use HasFactory;
    use Notifiable;
    use HasRoles;          // Spatie
    use HasPermissions;    // Spatie
    use HasTeams;          // Custom
    use HasMedia;          // Spatie
    use HasTenants;        // Filament
}

// STI con Parental
class Doctor extends User
{
    use HasParent;
    // Type-specific logic
# User Module: Philosophy, Architecture & Zen

> **Identity & Authorization**: Who you are, what you can do, which tenant you belong to. User module is the backbone of Laraxot's security and multi-tenancy.

---

## 1. Philosophy & Zen

### Canonical Purpose

User module provides:
- **Authentication** (Passport OAuth, email/password, Socialite multi-provider)
- **Authorization** (Roles, Permissions via Spatie, Policies)
- **Identity** (User profile, device tracking, session management)
- **Multi-tenancy** (User → Teams → Tenants isolation)
- **Security** (2FA-ready, device verification, rate limiting)

**Why**: Every module depends on User for `auth()` context, authorization checks, tenant scoping.

### Zen

**"Identity is the anchor. Everything else hangs from it."**

User is not just a table; it's a security perimeter. Decisions here (auth flow, role structure, device trust) cascade through the entire system.

---

## 2. Architecture

### Core Models (50+ total)

| Model | Purpose |
|-------|---------|
| **BaseUser** | Foundation user (Passport, Spatie Permission, Teams, Tenants) |
| **User** | Concrete user (tenant-specific, extends BaseUser) |
| **BaseTeam** | Team (ownership, membership) |
| **BaseProfile** | User profile (bio, avatar, extra attributes) |
| **Device** | Device tracking (IP, user agent, last seen) |
| **DeviceVerification** | 2FA-ready device verification |
| **Authentication** | Auth session record (immutable log) |
| **AuthenticationLog** | Failed attempt log |
| **OauthClient**, **OauthToken** | Passport OAuth (API tokens) |
| **SocialiteUser** | OAuth provider links (Auth0, Microsoft, Google) |
| **Role**, **Permission** | Spatie RBAC (authorization) |
| **BaseUuidModel** | Variant base model using UUID instead of int ID |

### Auth Flow

```
Request
  ↓
Passport/Sanctum (guard)
  ↓
User Model (auth context)
  ↓
Policy/Gate (authorization)
  ↓
Tenant Scope (data isolation)
  ↓
Action (with user context)
```

### Multi-Tenancy Pattern

```
User
  ├─ currentTeam (active context)
  ├─ ownedTeams (user manages)
  ├─ membershipTeams (user belongs to)
  └─ tenants (via teams)

Team
  ├─ users (members)
  ├─ pivot TeamsUser (role within team)
  └─ tenant (owner)

Tenant (from Tenant module)
  ├─ users (all users with access)
  ├─ domain, database config
  └─ data isolation boundary
```

### Traits (Composition)

| Trait | What |
|-------|------|
| **HasApiTokens** | Passport tokens (OAuth) |
| **HasXotFactory** | Factory generation |
| **HasUuids** | Use UUID instead of int ID |
| **Notifiable** | Send notifications |
| **HasAuthentications** | Track auth events |
| **HasAuthenticationLogTrait** | Failed login tracking |
| **HasDevices** | Device management |
| **HasSocialite** | OAuth provider links |
| **HasSpatiePermission** | Roles & permissions |
| **HasTeams** | Team membership |
| **HasModules** | Module-level permissions |
| **InteractsWithMedia** | Avatar, media library |
| **HasChildren** | Polymorphic User inheritance |

### OAuth & Socialite

**Passport** (native Laravel OAuth):
- User → OauthClient (API credentials)
- OauthToken (refresh + access token)
- Use: API authentication, SPA backends

**Socialite** (social login):
- SocialiteUser (provider + provider ID)
- Providers: Auth0, Microsoft, Google, GitHub, Facebook
- Use: "Login with..." flows, SSO integration

### Roles & Permissions

**Spatie Permission**:
- Role (admin, editor, viewer, custom)
- Permission (create_post, delete_comment, etc.)
- User.hasRole('admin') / hasPermission('edit_post')
- Team-level roles (team-specific permissions)

**Policies**:
- Laravel Gate/Policy for fine-grained checks
- Tied to User + Resource (e.g., "Can user edit this post?")

---

## 3. Best/Bad Practices

### Best

1. **Passport + Sanctum hybrid**
   - Passport for long-lived API tokens (desktop apps, integrations)
   - Sanctum for SPA (short-lived, CSRF-protected)
   ```php
   $user->createToken('api', ['*'])->plainTextToken;
   ```

2. **Tenant scoping via user context**
   - Every query within action runs in user's current tenant
   - Query scope applied at middleware/ServiceProvider level
   - No manual `where('tenant_id', ...)` needed

3. **Device verification + 2FA ready**
   - DeviceVerification model (extends app to add MFA)
   - Device::track() logs all auth, can rate-limit per device
   ```php
   Device::where('user_id', $user->id)->where('ip', request()->ip())->update(['last_seen' => now()]);
   ```

4. **Profile extraction**
   - BaseProfile keeps user table lean (no nullable columns for avatar, bio)
   - 1:1 relationship, loaded eagerly where needed

5. **Immutable authentication log**
   - AuthenticationLog::create() records every auth event (success + failure)
   - Never deleted (compliance, forensics)

### Bad

1. **Storing OAuth tokens in cookies**
   ```php
   // ❌ WRONG
   cookie('oauth_token', $token->access_token)->httpOnly(false);
   
   // ✅ RIGHT
   // Use Passport guard, token stored server-side
   ```

2. **Bypassing Spatie Permission with custom policy**
   ```php
   // ❌ WRONG
   if ($user->id === 1) return true; // Hardcoded super-admin
   
   // ✅ RIGHT
   $user->hasRole('admin') && $user->hasPermission('action');
   ```

3. **Multi-team without scoping**
   ```php
   // ❌ WRONG
   User::all()->teams(); // Leaks all teams
   
   // ✅ RIGHT
   auth()->user()->currentTeam->users();
   ```

4. **Device verification optional**
   - If added later, existing sessions unverified
   - Approach: Gradual rollout with feature flag

### False Friends

1. **auth()->user() vs auth('api')->user()**
   - First: session guard (web)
   - Second: API guard (Passport token)
   - **Trap**: Switching guards in middleware breaks context

2. **Role vs Permission ambiguity**
   - Role: container of permissions (one user = multiple roles)
   - Permission: atomic action (one permission = many roles)
   - **Trap**: Assigning permissions directly to user (works, but unmaintainable)

3. **currentTeam() magic**
   ```php
   // ⚠️ currentTeam is context, not loaded by default
   auth()->user()->currentTeam; // May be null if not set
   auth()->user()->load('currentTeam')->currentTeam; // Safe
   ```

4. **Device.user_id vs Device.ip**
   - user_id: owner of the device
   - ip: client IP at last login (not unique, VPN/proxy spoofs it)
   - **Trap**: Using IP alone for 2FA (unreliable)

---

## 4. Integration

### Who Uses User

**Every module**:
- Auth context in policies
- Tenant scoping
- Audit trail (created_by, updated_by)
- Notifications (send to users)

### Reverse Dependencies

- **Tenant module** (scoping context)
- **Notify module** (send notifications to users)
- **Activity module** (track who changed what)
- **Geo module** (user location/address)
- **Media module** (user avatar)

---

## 5. Security Audit

### Built-In

✓ Passport rate limiting (OAuth guard)
✓ Authentication log (immutable)
✓ Device tracking (IP, user agent)
✓ Spatie Permission (fine-grained ACL)
✓ Tenant isolation (currentTeam scope)

### Gaps (to address)

- [ ] 2FA implementation (DeviceVerification ready, not implemented)
- [ ] Rate limiting on login attempts (AuthenticationLog tracked, not enforced)
- [ ] Cross-tenant CSRF token validation
- [ ] Session hijacking detection (compare user agent / IP change)

---

## 6. Roadmap

1. **Multi-Factor Authentication (MFA)**
   - TOTP (Google Authenticator) + SMS backup codes
   - Leverage DeviceVerification model

2. **Single Sign-On (SSO)**
   - SAML/OpenID Connect support
   - Extend SocialiteUser model

3. **Passwordless Auth**
   - Magic link / email-based login
   - 2FA-aware

4. **Session Management UI**
   - User sees active devices
   - Revoke sessions remotely

5. **Audit Trail Dashboard**
   - Authentication log visualization
   - Failed login alerts

---

## 7. Installation & Setup

```bash
# Already in monorepo
cd laravel/
composer install

# Run migrations (74 total)
php artisan migrate --path="Modules/User/database/migrations"

# Seed default roles/permissions
php artisan db:seed UserSeeder

# Publish config
php artisan vendor:publish --provider="Modules\User\Providers\UserServiceProvider"
```

### Quick Start: Protect a Route

```php
// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardAction::class);
});

// Filament resource (auto-protected)
class UserResource extends XotBaseResource {
    // ...
}
```

---

## 📜 Religione (Religion)

### Comandamenti Sacri

1. **Single Table Inheritance (STI) è Sacra** - User, Doctor, Patient, Admin sono TUTTI nella tabella `users` con `type`
2. **Parental è Obbligatorio** - Utilizzare sempre `HasParent` trait per STI
3. **Spatie Permissions è la Base** - Ruoli e permessi sempre via Spatie
4. **Multi-Tenancy per Dottori** - I dottori sono sempre scoped a tenant (studio)
5. **Profile Separato** - Dati estesi in Profile model, non in User
6. **Activity Tracking** - Tutte le azioni utente devono essere loggate

### Best Practices

- **STI Pattern**: User base, Doctor/Patient/Admin estendono User con HasParent
- **Enum UserType**: Utilizzare enum per type safety invece di string
- **Policy-Based**: Access control sempre via policies, non logica inline
- **Tenant Scoping**: Dottori sempre filtrati per tenant corrente
- **Role Hierarchy**: Ruoli organizzati gerarchicamente (super_admin > admin > doctor > patient)

### Integrazione Moduli

Il modulo User **è utilizzato da** tutti i moduli business:
- **TechPlanner**: Workers sono User, appointments hanno causer User
- **Employee**: Employee relaziona User per autenticazione
- **Activity**: Causer di tutte le activities
- **Notify**: Destinatari notifiche

**Filosofia**: User è il "centro dell'universo identità" - tutto parte da qui.

---

## 🏛️ Politica (Politics)

### Decisioni Architetturali

1. **STI over Multiple Tables** - Unificazione utenti in una tabella con type
2. **Spatie Permissions** - RBAC standardizzato e testato
3. **Filament Multi-Tenancy** - Utilizzo nativo Filament per tenant management
4. **OAuth Integration** - Supporto social login per UX migliorata

### Governance del Modulo

- **Type Safety**: Enum per user types previene errori
- **Role Hierarchy**: Ruoli organizzati con permessi ereditati
- **Tenant Isolation**: Dati dottori isolati per tenant (studio)
- **Profile Separation**: Dati estesi separati per performance e modularità

### Pattern Implementativi

```php
// Pattern: STI con Parental
class Doctor extends User
{
    use HasParent;

    // Type-specific methods
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}

// Pattern: Tenant Scoping
class DoctorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === UserTypeEnum::DOCTOR
            && Filament::getTenant() !== null;
    }
}
```

---

## 🧘 Zen (Zen)

### Il Vuoto dell'Identità

Apprezziamo il concetto zen del **"vuoto che contiene tutte le identità"**:

- **Single Table Unity**: Una tabella contiene tutte le identità (User, Doctor, Patient, Admin)
- **Type Polymorphism**: Il type definisce comportamento, non struttura dati
- **Profile Extension**: Dati estesi in Profile, User rimane snello
- **Role Fluidity**: Ruoli possono cambiare, identità rimane

### Flusso Naturale

La gestione utenti deve essere **trasparente e flessibile**:

1. Registrazione → Sistema crea User base → Assegna ruolo default
2. Login → Sistema autentica → Imposta tenant (se doctor) → Carica permessi
3. Azione → Sistema verifica permessi → Esegue azione → Logga activity
4. Cambio ruolo → Sistema aggiorna permessi → Notifica utente

### Semplicità nella Complessità Identity

Il modulo gestisce complessità (STI, multi-tenancy, RBAC) ma:
- **Simple Creation**: `User::create()` funziona per tutti i tipi
- **Type Discovery**: `$user->type` rivela il tipo, casting automatico
- **Role Clarity**: Ruoli definiti chiaramente, permessi ereditati
- **Tenant Transparency**: Tenant gestito automaticamente per dottori

---

## 🎯 Manifestazioni Pratiche

### 1. BaseUser - Foundation Identity

```php
class BaseUser extends Authenticatable
{
    // STI Type
    public UserTypeEnum $type;  // DOCTOR, PATIENT, ADMIN

    // Core relationships
    public function roles(): BelongsToMany  // Spatie
    public function permissions(): BelongsToMany  // Spatie
    public function teams(): BelongsToMany  // Custom
    public function tenants(): BelongsToMany  // Filament
    public function profile(): HasOne  // Extended data
}
```

### 2. STI Pattern - Type Polymorphism

```php
// Doctor è User con type=DOCTOR
class Doctor extends User
{
    use HasParent;

    // Doctor-specific relationships
    public function appointments(): HasMany
    public function patients(): HasMany
    public function studio(): BelongsTo  // Tenant
}
```

### 3. Multi-Tenancy Pattern - Tenant Scoping

```php
// Dottori sempre scoped a tenant
class DoctorScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Filament::getTenant()) {
            $builder->where('studio_id', Filament::getTenant()->id);
        }
    }
}
```

---

## 🔗 Collegamenti

- [Business Logic Deep Dive](./business-logic-deep-dive.md)
- [Architecture README](./architecture/readme.md)
- [Xot Module Foundation](../../xot/docs/philosophy-complete.md)
- [Tenant Module Integration](../../tenant/docs/philosophy.md)

---

**Filosofia**: STI Unity, RBAC Standard, Multi-Tenant Isolation, Identity Foundation
## 8. Summary Card

```
┌──────────────────────────────────────────────┐
│ MODULE: User (Identity & Authorization)      │
├──────────────────────────────────────────────┤
│ Purpose: Auth, roles, teams, multi-tenancy   │
│ Owner: laravel/Modules/User/                 │
│ Status: Stable (production)                  │
│ PHPStan: Level 10 target                     │
│ Models: 50+ (104 files total)                │
│ Migrations: 74                               │
│ Dependencies: Xot, Tenant, UI                │
│ Reverse Deps: All other modules              │
│ Complexity: High (security-critical)         │
└──────────────────────────────────────────────┘
```

