# User Module - Model Documentation

**Modulo**: User
**Connection**: `user`
**Data ultima revisione**: 2025-10-16

## Panoramica

Il modulo User gestisce l'autenticazione, l'autorizzazione, e la gestione multi-tenant dell'applicazione. Contiene modelli per utenti, team, permessi, ruoli, e autenticazione OAuth/SSO.

## Architettura Base

Tutti i modelli in questo modulo seguono la [gerarchia a tre livelli](../../../Xot/docs/models/MODEL_ARCHITECTURE.md) standard:

```
XotBaseModel (Xot)
    ↓
BaseModel (User)
    ↓
Tenant, Authentication, OauthClient, etc.
```

### ⚠️ Magic Properties - Regola Critica

**IMPORTANTE**: I modelli Laravel/Eloquent usano **magic properties** (`__get()`, `__set()`). **NON usare MAI `property_exists()` per controllare attributi dei modelli**.

```php
// ❌ SBAGLIATO
if (property_exists($user, 'email')) { ... }

// ✅ CORRETTO
if (isset($user->email)) { ... }
```

Vedi [Magic Properties Documentation](../../../Xot/docs/models/magic-properties.md) per dettagli completi.

## Base Classes

### BaseModel

**File**: `Modules/User/app/Models/BaseModel.php`

```php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user';
}
```

**Fornisce**:
- Connection: `user`
- Traits ereditati da XotBaseModel: `HasXotFactory`, `RelationX`, `Updater`
- Casts standard per id, uuid, timestamps, audit fields

### BasePivot

**File**: `Modules/User/app/Models/BasePivot.php`

```php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBasePivot;

abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'user';
}
```

**Usato per**: Tabelle pivot many-to-many con colonne aggiuntive

**Esempio**: `TeamUser` (collega Team e User con ruolo e data join)

### BaseMorphPivot

**File**: `Modules/User/app/Models/BaseMorphPivot.php`

```php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBaseMorphPivot;

abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'user';
}
```

**Usato per**: Tabelle pivot polimorfe (many-to-many con più tipi di modelli)

**Esempio**: `ModelHasRole` (collega Role a User, Team, Organization, etc.)

## Modelli Principali

### 1. Tenant

**File**: `Modules/User/app/Models/Tenant.php`
**Tabella**: `tenants`
**Estende**: `BaseModel`

**Scopo**: Rappresenta un'organizzazione/tenant nel sistema multi-tenant.

**Campi principali**:
- `id` (string) - Primary key
- `name` (string) - Nome del tenant
- `domain` (string) - Dominio univoco
- `active` (boolean) - Stato attivo/inattivo
- `created_at`, `updated_at`, `deleted_at`
- `created_by`, `updated_by`, `deleted_by` (audit fields)

**Relazioni**:
```php
// Many-to-many con User tramite TeamUser pivot
public function users()
{
    return $this->belongsToMany(User::class, 'team_user')
        ->using(TeamUser::class)
        ->withPivot(['role', 'joined_at']);
}
```

**Scopes**:
```php
// Filtra solo tenant attivi
Tenant::active()->get();
```

**Uso**:
```php
// Creare tenant
$tenant = Tenant::create([
    'name' => 'Acme Corporation',
    'domain' => 'acme.example.com',
    'active' => true,
]);

// Aggiungere utenti al tenant
$tenant->users()->attach($user, [
    'role' => 'admin',
    'joined_at' => now(),
]);

// Query tenant attivi
$activeTenants = Tenant::active()->get();
```

### 2. TeamUser (Pivot)

**File**: `Modules/User/app/Models/TeamUser.php`
**Tabella**: `team_user`
**Estende**: `BasePivot`

**Scopo**: Gestisce la relazione many-to-many tra Team e User con metadati aggiuntivi.

**Campi**:
- `team_id` (foreign key)
- `user_id` (foreign key)
- `role` (string) - Ruolo dell'utente nel team (admin, member, etc.)
- `joined_at` (datetime) - Data di ingresso nel team
- `created_at`, `updated_at`

**Casts specifici**:
```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'role' => 'string',
        'joined_at' => 'datetime',
    ]);
}
```

**Relazioni**:
```php
public function team()
{
    return $this->belongsTo(Team::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

**Business Logic**:
```php
// Verifica se è admin
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

// Promuovi a admin
public function promoteToAdmin(): void
{
    $this->update(['role' => 'admin']);
}
```

**Uso**:
```php
// Nella relazione Team
$team->users()->attach($user, [
    'role' => 'member',
    'joined_at' => now(),
]);

// Accesso al pivot
$teamUser = $team->users()->first()->pivot;
if ($teamUser->isAdmin()) {
    // ...
}

// Promozione
$teamUser->promoteToAdmin();
```

### 3. Authentication

**File**: `Modules/User/app/Models/Authentication.php`
**Tabella**: `authentications`
**Estende**: `BaseModel`

**Scopo**: Gestisce metodi di autenticazione alternativi (OAuth, SSO, SAML, etc.).

**Campi principali**:
- `id` (string)
- `user_id` (foreign key)
- `provider` (string) - Nome provider (google, github, azure, etc.)
- `provider_id` (string) - ID utente nel provider
- `token` (text) - Access token
- `refresh_token` (text) - Refresh token
- `expires_at` (datetime) - Scadenza token

**Relazioni**:
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

**Uso**:
```php
// Salva autenticazione OAuth
Authentication::create([
    'user_id' => $user->id,
    'provider' => 'google',
    'provider_id' => $googleUser->id,
    'token' => $googleUser->token,
    'refresh_token' => $googleUser->refreshToken,
    'expires_at' => now()->addHour(),
]);

// Trova utente tramite provider
$auth = Authentication::where('provider', 'google')
    ->where('provider_id', $providerId)
    ->first();

$user = $auth->user;
```

### 4. OauthClient

**File**: `Modules/User/app/Models/OauthClient.php`
**Tabella**: `oauth_clients`
**Estende**: `BaseModel`

**Scopo**: Gestisce client OAuth2 registrati (per Laravel Passport o Sanctum).

**Campi principali**:
- `id` (string)
- `user_id` (foreign key) - Proprietario del client
- `name` (string) - Nome del client
- `secret` (string) - Client secret
- `redirect` (text) - URL di redirect
- `personal_access_client` (boolean)
- `password_client` (boolean)
- `revoked` (boolean)

**Uso**:
```php
// Creare client OAuth
$client = OauthClient::create([
    'user_id' => $user->id,
    'name' => 'Mobile App',
    'secret' => Str::random(40),
    'redirect' => 'myapp://callback',
    'personal_access_client' => false,
    'password_client' => false,
]);

// Client attivi
$activeClients = OauthClient::where('revoked', false)->get();
```

### 5. SsoProvider

**File**: `Modules/User/app/Models/SsoProvider.php`
**Tabella**: `sso_providers`
**Estende**: `BaseModel`

**Scopo**: Configurazione provider SSO/SAML per l'applicazione.

**Campi principali**:
- `id` (string)
- `name` (string) - Nome provider (Azure AD, Okta, etc.)
- `slug` (string) - Slug univoco
- `enabled` (boolean) - Attivo/disattivo
- `settings` (json) - Configurazione provider

**Uso**:
```php
// Configurare Azure AD SSO
$provider = SsoProvider::create([
    'name' => 'Azure AD',
    'slug' => 'azure-ad',
    'enabled' => true,
    'settings' => [
        'client_id' => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'tenant_id' => env('AZURE_TENANT_ID'),
        'redirect_uri' => route('sso.callback', 'azure-ad'),
    ],
]);

// Provider attivi
$providers = SsoProvider::where('enabled', true)->get();
```

### 6. TeamInvitation

**File**: `Modules/User/app/Models/TeamInvitation.php`
**Tabella**: `team_invitations`
**Estende**: `BaseModel`

**Scopo**: Gestisce inviti a team/tenant non ancora accettati.

**Campi principali**:
- `id` (string)
- `team_id` (foreign key)
- `email` (string) - Email invitato
- `role` (string) - Ruolo proposto
- `token` (string) - Token univoco per accettazione
- `accepted_at` (datetime) - Data accettazione
- `expires_at` (datetime) - Scadenza invito

**Relazioni**:
```php
public function team()
{
    return $this->belongsTo(Team::class);
}
```

**Uso**:
```php
// Creare invito
$invitation = TeamInvitation::create([
    'team_id' => $team->id,
    'email' => 'john@example.com',
    'role' => 'member',
    'token' => Str::random(32),
    'expires_at' => now()->addDays(7),
]);

// Inviti pendenti
$pending = TeamInvitation::whereNull('accepted_at')
    ->where('expires_at', '>', now())
    ->get();
```

### 7. TeamPermission

**File**: `Modules/User/app/Models/TeamPermission.php`
**Tabella**: `team_permissions`
**Estende**: `BaseModel`

**Scopo**: Definisce permessi specifici per team/tenant.

**Nota**: Questo è un **modello con business logic**, non una semplice pivot table, quindi estende `BaseModel` e non `BasePivot`.

**Campi principali**:
- `id` (string)
- `team_id` (foreign key)
- `permission` (string) - Nome permesso
- `enabled` (boolean)

**Relazioni**:
```php
public function team()
{
    return $this->belongsTo(Team::class);
}
```

**Uso**:
```php
// Abilitare permesso per team
TeamPermission::create([
    'team_id' => $team->id,
    'permission' => 'create-invoices',
    'enabled' => true,
]);

// Verifica permesso
$hasPermission = TeamPermission::where('team_id', $team->id)
    ->where('permission', 'create-invoices')
    ->where('enabled', true)
    ->exists();
```

### 8. ModelHasRole (Morph Pivot)

**File**: `Modules/User/app/Models/ModelHasRole.php`
**Tabella**: `model_has_roles`
**Estende**: `BaseMorphPivot`

**Scopo**: Gestisce assegnazione ruoli a qualsiasi modello (User, Team, Organization) tramite relazione polimorfa.

**Campi**:
- `role_id` (foreign key)
- `model_type` (string) - Classe del modello (User::class, Team::class)
- `model_id` (string) - ID del modello

**Relazioni**:
```php
public function role()
{
    return $this->belongsTo(Role::class);
}

public function model()
{
    return $this->morphTo();
}
```

**Uso (tramite Spatie Permission)**:
```php
// Assegnare ruolo a User
$user->assignRole('admin');

// Assegnare ruolo a Team
$team->assignRole('premium-subscriber');

// Verifica ruoli
if ($user->hasRole('admin')) {
    // ...
}
```

### 9. PermissionUser

**File**: `Modules/User/app/Models/PermissionUser.php`
**Tabella**: `model_has_permissions`
**Estende**: `ModelHasPermission` (che estende `BaseMorphPivot`)

**Scopo**: Gestisce assegnazione permessi diretti a modelli (bypass dei ruoli).

**Pattern di ereditarietà**:
```
BaseMorphPivot
    ↓
ModelHasPermission (Spatie)
    ↓
PermissionUser (custom)
```

**Uso**:
```php
// Assegnare permesso diretto
$user->givePermissionTo('edit-articles');

// Revocare permesso
$user->revokePermissionTo('edit-articles');

// Verifica permesso (anche da ruoli)
if ($user->can('edit-articles')) {
    // ...
}
```

## Convenzioni Specifiche User Module

### 1. Audit Fields

Tutti i modelli in User hanno audit fields automatici tramite il trait `Updater`:

```php
// created_by, updated_by, deleted_by vengono impostati automaticamente
$tenant = Tenant::create(['name' => 'Acme']);
// → $tenant->created_by = Auth::id()

$tenant->update(['name' => 'Acme Corp']);
// → $tenant->updated_by = Auth::id()
```

### 2. Soft Deletes

Molti modelli supportano soft delete:

```php
$tenant->delete();  // Soft delete
// → deleted_at impostato
// → deleted_by = Auth::id()

$tenant->forceDelete();  // Hard delete
```

### 3. UUID Support

Tutti i modelli usano string IDs con supporto UUID:

```php
protected $keyType = 'string';  // Ereditato da XotBaseModel

// Possibile uso di UUID
$tenant = Tenant::create([
    'id' => Str::uuid(),
    'name' => 'Acme',
]);
```

### 4. Factories

Tutti i modelli hanno factory in `Modules/User/database/factories/`:

```php
// In test
$tenant = Tenant::factory()->create();
$tenant = Tenant::factory()->active()->create();

// Multiple
$tenants = Tenant::factory()->count(10)->create();
```

## Testing

### Setup Test

```php
use Modules\User\Models\{Tenant, User, TeamUser};

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});
```

### Test Esempi

```php
it('creates a tenant', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Test Corp',
    ]);

    expect($tenant)
        ->name->toBe('Test Corp')
        ->active->toBeTrue()
        ->created_by->toBe($this->user->id);
});

it('attaches users to tenant with role', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create();

    $tenant->users()->attach($user, [
        'role' => 'admin',
        'joined_at' => now(),
    ]);

    expect($tenant->users)
        ->toHaveCount(1)
        ->first()->id->toBe($user->id);

    expect($tenant->users->first()->pivot)
        ->role->toBe('admin')
        ->isAdmin()->toBeTrue();
});

it('tracks authentication providers', function () {
    $auth = Authentication::factory()->create([
        'user_id' => $this->user->id,
        'provider' => 'google',
    ]);

    expect($auth->user->id)->toBe($this->user->id);
});
```

## Database Schema

La connection `user` gestisce queste tabelle principali:

- `tenants` - Organizzazioni/tenant
- `users` - Utenti
- `team_user` - Pivot team-user
- `authentications` - OAuth/SSO auth
- `oauth_clients` - Client OAuth2
- `sso_providers` - Provider SSO
- `team_invitations` - Inviti pendenti
- `team_permissions` - Permessi team
- `model_has_roles` - Morph pivot ruoli
- `model_has_permissions` - Morph pivot permessi

## Riferimenti

- [Model Architecture](../../../Xot/docs/models/MODEL_ARCHITECTURE.md) - Guida completa architettura modelli
- [DRY-KISS Analysis](../../../Xot/docs/models/DRY-KISS-ANALYSIS.md) - Analisi duplicazioni
- [XotBaseModel](../../../Xot/app/Models/XotBaseModel.php) - Base class livello 1
- [BaseModel](../../app/Models/BaseModel.php) - Base class User module
- [CLAUDE.md](../../../../CLAUDE.md) - Convenzioni progetto

## Changelog

### 2025-10-16
- Correzione tutti i modelli per estendere base classes appropriate
- `Tenant`: Model → BaseModel
- `TeamUser`: Model → BasePivot
- `Authentication`: Model → BaseModel
- `OauthClient`: Model → BaseModel
- Documentazione iniziale creata

---

**Ultima revisione**: 2025-10-16
**Prossima revisione**: Dopo implementazione auto-discovery
