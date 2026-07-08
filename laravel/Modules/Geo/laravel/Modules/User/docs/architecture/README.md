# User Module - Architecture Documentation

Architettura tecnica del modulo User, inclusi pattern, componenti e integrazioni.

## Panoramica Architetturale

Il modulo User implementa un'architettura modulare basata su Laraxot con separazione delle responsabilità e supporto multi-tenant.

## Componenti Principali

### 1. Layer di Autenticazione

```
┌─────────────────┐
│   Frontend UI   │  ← Filament, Livewire, Volt
└─────────────────┘
         ↓
┌─────────────────┐
│  Authentication │  ← Laravel Auth, Socialite
└─────────────────┘
         ↓
┌─────────────────┐
│   User Models   │  ← BaseUser, User, Tenant
└─────────────────┘
```

### 2. Layer di Autorizzazione

```
┌─────────────────┐
│   Permission    │  ← Spatie Permission
├─────────────────┤
│      Roles      │  ← Role-based Access Control
├─────────────────┤
│     Policies    │  ← Laravel Policies
└─────────────────┘
```

### 3. Layer Multi-Tenant

```
┌─────────────────┐
│   Tenant Scope  │  ← Automatic tenant scoping
├─────────────────┤
│  Data Isolation │  ← Tenant-specific data
├─────────────────┤
│   Domain Mgmt   │  ← Custom domain support
└─────────────────┘
```

## Pattern Architetturali

### Repository Pattern (Actions)

**Non utilizzare Service** - Utilizzare sempre Actions queueable:

```php
// ✅ CORRETTO - Action pattern
class CreateUserAction
{
    use QueueableAction;

    public function execute(array $data): User
    {
        // Business logic
        return User::create($data);
    }
}

// Utilizzo
app(CreateUserAction::class)->execute($userData);
```

### Single Table Inheritance (STI)

Supporto per diversi tipi di utente tramite colonna `type`:

```php
class User extends BaseUser
{
    // Base class per tutti i tipi di utente
}

class Admin extends User
{
    protected static function booted(): void
    {
        static::addGlobalScope('admin', function (Builder $builder) {
            $builder->where('type', 'admin');
        });
    }
}
```

### Observer Pattern

Monitoraggio delle attività utente tramite Eloquent Observers:

```php
class UserObserver
{
    public function created(User $user): void
    {
        // Log attività
        activity()
            ->performedOn($user)
            ->log('User created');
    }
}
```

## Integrazioni

### 1. Integrazione con Xot

Il modulo User estende tutte le classi base di Xot:

```php
// Modelli
class BaseUser extends XotBaseModel

// Service Provider
class UserServiceProvider extends XotBaseServiceProvider

// Filament Resources
class UserResource extends XotBaseResource
```

### 2. Integrazione con Spatie Permission

Configurazione automatica dei ruoli e permessi:

```php
// In UserServiceProvider
protected function configurePermissions(): void
{
    Permission::create(['name' => 'manage-users']);
    Role::create(['name' => 'admin'])->givePermissionTo('manage-users');
}
```

### 3. Integrazione Socialite

Supporto per social login con configurazione modulare:

```php
// Actions per social login
class LoginUserAction
{
    public function execute(SocialiteUser $socialiteUser, string $provider): User
    {
        // Logica di login/registrazione
    }
}
```

## Flussi di Business

### 1. Registrazione Utente

```
1. Validazione dati → FormRequest
2. Creazione utente → CreateUserAction
3. Assegnazione ruolo → AssignRoleAction
4. Invio email → SendWelcomeEmailAction
5. Log attività → UserObserver
```

### 2. Autenticazione Multi-Tenant

```
1. Login utente → Laravel Auth
2. Identificazione tenant → TenantResolver
3. Applicazione scope → TenantScope
4. Redirect dashboard → Tenant-specific
```

### 3. Gestione Team

```
1. Creazione team → CreateTeamAction
2. Invito membri → InviteTeamMemberAction
3. Gestione permessi → TeamPermissionService
4. Notifiche → TeamNotificationService
```

## Configurazione

### Configurazione Base

```php
// config/auth.php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Modules\User\Models\User::class,
    ],
],
```

### Configurazione Multi-Tenant

```php
// Modules/User/config/tenant.php
return [
    'model' => Modules\User\Models\Tenant::class,
    'domains' => [
        'enabled' => true,
        'column' => 'domain',
    ],
];
```

### Configurazione Socialite

```php
// Modules/User/config/socialite.php
return [
    'providers' => [
        'google' => [
            'enabled' => env('GOOGLE_SOCIALITE_ENABLED', true),
            'scopes' => ['email', 'profile'],
        ],
    ],
];
```

## Sicurezza

### 1. Password Policies

```php
// Validazione password
PasswordRule::min(8)
    ->letters()
    ->mixedCase()
    ->numbers()
    ->symbols()
    ->uncompromised();
```

### 2. OTP e 2FA

```php
// Gestione OTP
class OtpService
{
    public function generateOtp(User $user): string
    {
        // Generazione OTP sicuro
    }

    public function verifyOtp(User $user, string $otp): bool
    {
        // Verifica OTP
    }
}
```

### 3. Audit Trail

Utilizzo di Spatie Activitylog per tracciare tutte le attività:

```php
// Configurazione logging
protected static $logAttributes = ['email', 'name', 'is_active'];
protected static $logOnlyDirty = true;
protected static $logName = 'user_activity';
```

## Performance e Ottimizzazione

### 1. Eager Loading

```php
// Caricamento anticipato relazioni
User::with(['tenants', 'roles.permissions', 'teams'])->get();
```

### 2. Caching

```php
// Cache ruoli e permessi
$user->getAllPermissions(); // Utilizza cache automatica
```

### 3. Query Optimization

```php
// Scope ottimizzati
User::active()->forCurrentTenant()->withRole('customer')->get();
```

## Testing

### 1. Unit Tests

```php
class UserTest extends TestCase
{
    public function test_user_creation(): void
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(User::class, $user);
    }
}
```

### 2. Feature Tests

```php
class AuthenticationTest extends TestCase
{
    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');
    }
}
```

### 3. Integration Tests

```php
class MultiTenantTest extends TestCase
{
    public function test_tenant_isolation(): void
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create();
        $user1->tenants()->attach($tenant1);

        $this->actingAs($user1);

        // Verifica che l'utente veda solo i dati del tenant1
        $this->assertCount(1, User::forCurrentTenant()->get());
    }
}
```

## Deployment e Manutenzione

### 1. Migrazioni

Tutte le migrazioni devono essere nel modulo:

```bash
php artisan module:migrate User
```

### 2. Seeders

```bash
php artisan module:seed User
```

### 3. Comandi Artisan

```bash
# Reset cache permessi
php artisan permission:cache-reset

# Genera chiavi OAuth
php artisan passport:keys

# Pubblica assets
php artisan vendor:publish --tag=user-assets
```

## Monitoraggio e Logging

### 1. Metriche Principali

- Numero utenti attivi per tenant
- Tasso di conversione registrazione
- Tempo medio di sessione
- Errori di autenticazione

### 2. Alerting

- Tentativi di login falliti
- Creazione utenti sospetti
- Cambiamenti ruoli amministrativi
- Errori di integrazione social

---

**Ultimo Aggiornamento**: 2025-11-11
**Versione Architettura**: 1.0