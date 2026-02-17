# Analisi Approfondita del Modulo User

> **Generato**: 2025-12-24
> **Scopo**: Documentare la filosofia, logica, business logic e architettura del modulo User

---

## 1. LOGICA - Come Funziona il Sistema

### Sistema di Autenticazione

**Laravel Passport Integration**
- Token OAuth2 per API authentication
- Token expiration: 1 giorno (access), 30 giorni (refresh), 6 mesi (personal access)
- Scopes definiti: `view-user`, `core-technicians`
- Modelli OAuth: `OauthAccessToken`, `OauthClient`, `OauthRefreshToken`, `OauthAuthCode`, `OauthPersonalAccessClient`

**Multi-Guard Authentication**
- Guard principale: `web` (coerente con Spatie Permission)
- Support per Socialite (OAuth sociale: Google, Facebook, GitHub, Auth0)
- Authentication Logs tracking con `AuthenticationLog` model

**Social Authentication (Socialite)**
- Provider configurabili tramite `SocialProvider` (Sushi model con dati in PHP arrays)
- Collegamento account con `SocialiteUser` (provider_id, token, refresh_token)
- Actions per il flusso: `RegisterSocialiteUserAction`, `CreateSocialiteUserAction`, `LoginUserAction`

### Sistema di Autorizzazione (Spatie Permission)

**Architettura RBAC (Role-Based Access Control)**

```
User (BaseUser)
├── HasRoles (Spatie) - Assegnazione ruoli multipli
├── HasPermissions (Spatie) - Permessi diretti
└── Custom override hasRole() - Cached permission checks

Role (extends SpatieRole)
├── BelongsToMany<Permission> - Permessi del ruolo
├── BelongsToMany<User> - Utenti con questo ruolo
└── BelongsTo<Team> - Team-scoped roles

Permission (extends SpatiePermission)
├── BelongsToMany<Role> - Ruoli con questo permesso
└── BelongsToMany<User> - Assegnazioni dirette utente
```

**Tabelle Pivot Custom**
- `model_has_roles` - User-Role (polymorphic, UUID primary key)
- `model_has_permissions` - User-Permission diretti
- `role_has_permissions` - Role-Permission
- Supporto UUID come primary key nelle pivot

**Permission Check Strategy**
```php
// BaseUser::hasRole() override con caching
hasRole('admin') →
  1. Check cached roles relation
  2. Query once() memoization
  3. exists() check su roles relationship
```

---

## 2. FILOSOFIA - Principi di Sicurezza

### Security Dogmas

**Password Security Policy** (`config/password.php`)
- Lunghezza minima: 6 caratteri (configurabile)
- Opzionale: mixed case, lettere, numeri, simboli
- Compromised password check (haveibeenpwned integration)
- Scadenza password: 30 giorni (trait `HasPasswordExpiry`)
- Auto-hash delle password nel setter con detection lunghezza

**One-Time Password (OTP)**
- Campo `is_otp` su User per password temporanee
- OTP expiration: 15 minuti
- OTP length: 6 caratteri
- Action: `SendOtpByUserAction`

**Authentication Logging** (trait `HasAuthenticationLogTrait`)
- Tracking IP, User Agent, login/logout timestamps
- Geolocation storage
- Login success/failure tracking
- Consecutive days login counter
- Previous login detection per security alerts

**Device Management** (trait `HasDevices`)
- Device fingerprinting
- Trusted devices
- Device-User relationship tracking
- Action: `GetCurrentDeviceAction`

### Email Verification
- Laravel MustVerifyEmail implementation
- Custom email template via Spatie Email (`verify-email`)
- Reset password via `reset-password` template

---

## 3. BUSINESS LOGIC - Gestione Utenti e Organizzazione

### User Management

**BaseUser Model** (545 linee - Core Foundation)

Proprietà chiave:
- `id` - UUID (HasUuids trait)
- `email`, `password`, `name`, `first_name`, `last_name`
- `lang` - Internazionalizzazione
- `is_active` - Stato attivazione
- `is_otp` - Flag password temporanea
- `password_expires_at` - Scadenza password
- `current_team_id` - Team corrente
- `type` - STI (Single Table Inheritance) con Parental\HasChildren

**Traits Utilizzati**
```php
BaseUser uses:
  - HasApiTokens (Passport)
  - HasAuthenticationLogTrait
  - HasChildren (Parental - STI)
  - HasPermissions (Spatie)
  - HasRoles (Spatie)
  - HasTeams (Custom)
  - HasUuids (Laravel)
  - HasXotFactory (Xot)
  - InteractsWithMedia (Spatie Media)
  - Notifiable (Laravel)
  - RelationX (Xot)
  - HasTenants (Custom)
```

**Filament Integration**
- Implements `Filament\Models\Contracts\HasName` → `getFilamentName()`
- Implements `Filament\Models\Contracts\HasTenants` → multi-tenancy
- `canAccessPanel()` - Panel access control basato su ruoli
- `canAccessFilament()` - Always true (customizable)

### Team Management (`HasTeams` Trait)

**Struttura Team**
```
BaseTeam
├── owner (BelongsTo User)
├── users (BelongsToMany User via team_user)
├── members() - alias di users()
└── teamInvitations (HasMany TeamInvitation)
```

**Team Capabilities**
- Personal teams (1 per user, flag `personal_team`)
- Owned teams (`ownedTeams()` relationship)
- Team membership (`teams()` relationship via `Membership` pivot)
- Team switching con `switchTeam(Team)`
- Current team tracking (`current_team_id`)

**Team Permissions**
```php
// Permission checks
user->ownsTeam(team)
user->belongsToTeam(team)
user->hasTeamPermission(team, 'permission')
user->hasTeamRole(team, 'role')
user->canAddTeamMember(team)
user->canRemoveTeamMember(team, user)
user->canManageTeam(team)
```

**Team Roles via Pivot**
- `Membership` model (pivot) con `role_id`
- `teamRole(Team)` - Ottiene ruolo utente nel team
- `teamPermissions(Team)` - Array permessi nel team

**Team Invitation System**
- `TeamInvitation` model
- Email-based invitations
- Token generation e validation

### Multi-Tenancy (`HasTenants` Trait)

**Tenant Architecture**
```
BaseTenant
├── users (BelongsToMany via tenant_user)
└── Filament panel-level tenancy

User implements HasTenants
├── tenants() - BelongsToMany Tenant
├── canAccessTenant(tenant)
└── getTenants(Panel) - Filament integration
```

**Tenant Isolation**
- Tenant-scoped queries (TenantScope)
- Domain-based tenant resolution
- Database per tenant (opzionale)
- Filament tenant selector integration

---

## 4. POLITICA - Regole di Autorizzazione

### Policy System

**BaseUserPolicy** - Template per RBAC
```php
viewAny() → hasRole(['super-admin', 'admin', 'hr-manager'])
view() → hasRole(['super-admin', 'admin', 'hr-manager']) || user owns record
create() → hasRole(['super-admin', 'admin', 'hr-manager'])
update() → hasRole(['super-admin', 'admin', 'hr-manager']) || user owns record
delete() → hasRole(['super-admin', 'admin']) && !self-delete
restore() → hasRole('super-admin')
forceDelete() → hasRole('super-admin') && !self-delete
```

**Policy Files** (37+ policies)
- Ogni modello ha la sua Policy
- `UserBasePolicy` - Base class per permission abstraction
- `UserPermissionBasePolicy` - Permission-based policy
- Policies extend `Modules\Xot\Models\Policies\XotBasePolicy`

**RolePolicy**
- Permissive (tutti i metodi return true per testing)
- Team management methods: `addTeamMember()`, `updateTeamMember()`, `removeTeamMember()`

**PermissionPolicy**
- `viewAny()` → false (solo admin)
- Altri metodi permissivi per testing

### Gates

**Pulse Monitoring**
```php
Gate::define('viewPulse', fn(User $user) => $user->hasRole('super-admin'));
```

---

## 5. RELIGIONE - Dogmi Architetturali

### Estensione di Spatie

**MAI estendere direttamente Spatie Permission**
```php
// ✅ CORRETTO
class Role extends SpatieRole {
    use HasXotFactory;
    use RelationX; // Enhanced relationships

    protected $connection = 'user';
    protected $keyType = 'string'; // UUID support
}

class Permission extends SpatiePermission {
    use HasXotFactory;
    use RelationX;

    protected $connection = 'user';
}
```

**Custom Override**
```php
// BaseUser::hasRole() override con memoization
public function hasRole($roles, ?string $guard = null): bool
{
    if (is_string($roles)) {
        return once(fn() => $this->roles()->where('name', $roles)->exists());
    }
    // ... fallback per array/Collection/SpatieRole
}
```

### Connection Separation

**Dedicated User Connection**
- Tutti i modelli User usano `protected $connection = 'user'`
- Permette database separation per sicurezza
- Multi-database support per microservices

### UUID Primary Keys

**Universally Unique Identifiers**
```php
BaseUser:
  - uses HasUuids
  - $incrementing = false
  - $primaryKey = 'id'
  - $keyType = 'string'

Pivot tables supportano UUID
```

### Single Table Inheritance (STI)

**Parental Package Integration**
```php
BaseUser:
  - uses HasChildren
  - $childColumn = 'type'
  - $childTypes = [] // Array di mapping type → class
```

---

## 6. SCOPO - Obiettivi del Modulo

### Fornire Sistema Auth Completo

**1. Authentication Stack**
- Local authentication (email/password)
- Social authentication (OAuth providers multipli)
- API authentication (Passport OAuth2)
- Two-factor authentication (preparato)
- Email verification
- Password reset

**2. Authorization Framework**
- Role-Based Access Control (RBAC)
- Permission-based access
- Policy-driven authorization
- Team-based permissions
- Tenant-based isolation

**3. User Management**
- CRUD operations con Filament
- Profile management
- Avatar/media support (Spatie Media)
- Audit trail (authentication logs)
- Device tracking

**4. Organization Structure**
- Teams (collaborative groups)
- Tenants (multi-tenancy)
- Hierarchical roles
- Permission inheritance

### Integration Points

**Con Altri Moduli**
```
User Module
├→ Tenant Module (multi-tenancy scopes)
├→ UI Module (Filament resources)
├→ Xot Module (base classes, contracts)
├→ Notify Module (email notifications)
└→ Activity Module (audit logging)
```

---

## 7. ZEN - L'Essenza del Sistema

### Il Cuore del Sistema di Sicurezza

**Tre Pilastri Fondamentali:**

1. **Identity Trust** - Chi sei?
   - UUID-based identity
   - Multi-provider authentication
   - Email verification
   - Device fingerprinting

2. **Permission Clarity** - Cosa puoi fare?
   - Spatie Permission foundation
   - Cached permission checks
   - Team-scoped permissions
   - Context-aware authorization

3. **Organizational Context** - Dove operi?
   - Team membership
   - Tenant isolation
   - Panel-based access control
   - Hierarchical roles

### Patterns Filosofici

**Defensive Programming**
```php
// Sempre null-safe
$fullName = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));

// Fallback intelligenti
return !empty($fullName) ? $fullName : ($this->email ?? 'User');

// Type narrowing rigoroso (PHPStan Level 10)
if (!is_string($state) || empty($state)) {
    return null;
}
```

**Once Memoization**
```php
// Performance-critical permission checks
public function hasRole(string $role): bool
{
    return once(fn() => $this->roles()->where('name', $role)->exists());
}
```

**Contract-Based Design**
```php
BaseUser implements:
  - UserContract (Xot)
  - PassportHasApiTokensContract (Xot)
  - ProfileContract (Xot)
  - HasMedia (Spatie)
  - HasName (Filament)
  - HasTenants (Filament)
  - MustVerifyEmail (Laravel)
```

### Sicurezza Come Cultura

**Non Fidarsi Mai, Verificare Sempre**
- Self-delete prevention nelle policies
- IP/device tracking
- Authentication logging
- Password expiration
- Permission caching con invalidation

**Progressive Enhancement**
- Base: email/password
- Layer 1: Email verification
- Layer 2: Social auth
- Layer 3: OTP support
- Layer 4: 2FA (preparato)
- Layer 5: Device trust

---

## STATISTICHE MODULO

- **Modelli**: 40+ (User, Role, Permission, Team, Tenant, Device, SocialProvider, AuthenticationLog, etc.)
- **Policies**: 37+ (complete authorization coverage)
- **Traits**: 10+ (HasTeams, HasTenants, HasRoles, HasAuthenticationLogTrait, etc.)
- **Actions**: 25+ (Socialite integration, OTP, User management)
- **Migrations**: 30+ (completa struttura database)
- **Tests**: 3000+ linee (feature + unit tests con Pest)
- **Filament Resources**: UserResource, RoleResource, PermissionResource, TeamResource, TenantResource, DeviceResource
- **Widgets**: UserOverview, RegistrationWidget, RecentLoginsWidget

## DIPENDENZE CHIAVE

```json
{
  "laravel/passport": "*",
  "spatie/laravel-permission": "*",
  "spatie/laravel-media-library": "*",
  "jenssegers/agent": "*",
  "socialiteproviders/auth0": "*",
  "spatie/laravel-personal-data-export": "*",
  "flowframe/laravel-trend": "*"
}
```

## CONFIGURAZIONI

- `config/password.php` - Password policies
- `config/social-providers.php` - Social auth providers
- `config/socialite.php` - Socialite configuration
- Spatie Permission config (merged)

---

**CONCLUSIONE**: Il modulo User è il **foundation layer** dell'applicazione, fornendo un sistema di autenticazione/autorizzazione enterprise-grade con multi-tenancy, team management, social auth e tracking completo. Segue rigorosamente Spatie Permission patterns, estendendoli con team/tenant scoping e Filament v4 integration.

---

## Collegamenti Utili

- [Spatie Permission Documentation](https://spatie.be/docs/laravel-permission)
- [Laravel Passport Documentation](https://laravel.com/docs/passport)
- [BUSINESS_LOGIC_DEEP_DIVE.md](./BUSINESS_LOGIC_DEEP_DIVE.md)
- [docs/_integration/spatie-permissions.md](./_integration/spatie-permissions.md)
