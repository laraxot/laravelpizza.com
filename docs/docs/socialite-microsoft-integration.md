# 🔐 **Laravel Socialite + Microsoft OAuth Integration Guide**

**
**Status**: ✅ PHPStan Level 10 Compliant
**Module**: User
**Dependencies**: Laravel Socialite, Microsoft Azure AD

## 📋 **Table of Contents**

1. [Overview](#overview)
2. [Installation & Configuration](#installation-configuration)
3. [Microsoft Azure AD Setup](#microsoft-azure-setup)
4. [Filament Socialite Plugin Analysis](#filament-socialite-analysis)
5. [Implementation Steps](#implementation-steps)
6. [Security Best Practices](#security-best-practices)
7. [Testing Strategy](#testing-strategy)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 **Overview**

Questa guida dettagliata copre l'implementazione completa dell'autenticazione Microsoft OAuth tramite Laravel Socialite nell'ecosistema Filament/Laraxot. L'integrazione permette agli utenti di accedere al sistema usando le credenziali Microsoft (Azure AD, Office 365, Outlook).

### **Key Features**
- ✅ Single Sign-On (SSO) con Microsoft Azure AD
- ✅ Multi-tenant support (per cliniche/aziende separate)
- ✅ Role mapping automatico (Microsoft Groups → Laraxot Roles)
- ✅ Token refresh automatico
- ✅ Audit trail completo (Activity module integration)
- ✅ GDPR compliant data handling

### **Architecture Pattern**
```
User → Filament Login Page → Socialite Provider → Microsoft OAuth
     ← User Data + Tokens ← Azure AD ← Authorization
     → Role Mapping → Profile Creation → Activity Logging
```

---

## Implementazione Corrente (LoginWidget)

L'implementazione attuale usa il LoginWidget del modulo User con pulsanti social nella view `user::filament.widgets.auth.login`:

- **Route redirect**: `route('socialite.oauth.redirect', ['provider' => 'microsoft'])`
- **Visibilità**: `@if(config('services.microsoft.client_id'))`
- **Traduzione**: `__('user::auth.social.microsoft')`
- **Provider**: `socialiteproviders/microsoft` registrato in `SocialiteServiceProvider`

Test: `Modules/User/tests/Feature/Auth/MicrosoftLoginButtonTest.php`

---

## 🔧 **Installation & Configuration**

### **Step 1: Install Dependencies**

**Regola critica**: Le dipendenze OAuth/login vanno in `Modules/User/composer.json`, **mai** nel root `laravel/composer.json`.

Aggiungi a `Modules/User/composer.json` nella sezione `require`:

```json
"require": {
    "socialiteproviders/microsoft": "^4.8"
}
```

Poi dalla root Laravel: `cd laravel && composer go`

**Errato**: `composer require socialiteproviders/microsoft` (installa nel root)

### **Step 2: Configure Services**

Aggiungi alla configurazione in `config/services.php`:

```php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
    'tenant' => env('MICROSOFT_TENANT_ID', 'common'), // 'common', 'organizations', or specific tenant ID
    'proxy' => env('PROXY'), // Optional: if behind a proxy
],
```

### **Step 3: Environment Variables**

Aggiungi a `.env`:

```env
# Microsoft OAuth Configuration
MICROSOFT_CLIENT_ID=your-app-client-id
MICROSOFT_CLIENT_SECRET=your-app-client-secret
MICROSOFT_REDIRECT_URI=https://your-domain.com/auth/microsoft/callback
MICROSOFT_TENANT_ID=common

# Optional: Specify scopes (default: 'openid profile email')
MICROSOFT_SCOPES=openid,profile,email,User.Read

# Optional: Proxy configuration (if needed)
PROXY=http://your-proxy:8080
```

### **Step 4: Service Provider Registration**

In `app/Providers/EventServiceProvider.php` o in un ServiceProvider dedicato:

```php
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Microsoft\MicrosoftExtendSocialite;

protected $listen = [
    SocialiteWasCalled::class => [
        MicrosoftExtendSocialite::class,
    ],
];
```

---

## 🏢 **Microsoft Azure AD Setup**

### **Step 1: Register Application in Azure Portal**

1. Vai su [Azure Portal](https://portal.azure.com/)
2. Naviga ad **Azure Active Directory** → **App registrations** → **New registration**
3. Configura:
   - **Name**: TechPlanner SSO
   - **Supported account types**: 
     - ✅ Accounts in this organizational directory only (single tenant)
     - ✅ Accounts in any organizational directory (multi-tenant)
   - **Redirect URI**: `https://your-domain.com/auth/microsoft/callback`

### **Step 2: Configure Authentication**

Nel pannello **Authentication**:
- **Redirect URIs**: Aggiungi tutti i callback necessari
  - `https://your-domain.com/auth/microsoft/callback`
  - `https://your-domain.com/admin/auth/microsoft/callback` (per Filament)
- **Logout URL**: `https://your-domain.com/logout`
- **Implicit grant and hybrid flows**: ✅ ID tokens (per OIDC)

### **Step 3: API Permissions**

Aggiungi le seguenti permissions in **API permissions** → **Add a permission** → **Microsoft Graph**:

| Permission | Type | Description |
|------------|------|-------------|
| `User.Read` | Delegated | Sign in and read user profile |
| `email` | Delegated | View users' email address |
| `openid` | Delegated | Sign users in |
| `profile` | Delegated | View users' basic profile |

**IMPORTANT**: Clicca su **Grant admin consent for [organization]** per approvare automaticamente.

### **Step 4: Certificates & Secrets**

1. Vai su **Certificates & secrets** → **New client secret**
2. Aggiungi descrizione: `TechPlanner Production`
3. Scadenza: 24 mesi (o secondo policy aziendale)
4. **COPY IMMEDIATAMENTE** il valore del secret (non sarà più visibile)

### **Step 5: Collect Application IDs**

Dalla pagina **Overview**:
- **Application (client) ID**: `MICROSOFT_CLIENT_ID`
- **Directory (tenant) ID**: `MICROSOFT_TENANT_ID`

---

## 🔌 **Filament Socialite Plugin Analysis**

### **Option 1: DutchCodingCompany/filament-socialite** (RECOMMENDED)

**Pros**:
- ✅ Native Filament v5 support
- ✅ Multi-provider support (Google, Microsoft, GitHub, etc.)
- ✅ Role mapping built-in
- ✅ Active maintenance
- ✅ Laraxot compatible (extends Filament properly)

**Installation**:
```bash
composer require dutchcodingcompany/filament-socialite
```

**Configuration** in `app/Providers/FilamentServiceProvider.php`:

```php
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(
            FilamentSocialitePlugin::make()
                ->providers([
                    Provider::make('microsoft')
                        ->label('Microsoft')
                        ->icon('fab-microsoft')
                        ->color('primary')
                        ->outlined(false)
                        ->stateless(false),
                ])
                ->registration(true) // Allow automatic registration
                ->createUserUsing(function (string $provider, SocialiteUser $socialiteUser) {
                    return $this->createUserFromMicrosoft($socialiteUser);
                })
                ->resolveUserUsing(function (string $provider, SocialiteUser $socialiteUser) {
                    return $this->resolveMicrosoftUser($socialiteUser);
                })
        );
}

protected function createUserFromMicrosoft(SocialiteUser $socialiteUser): User
{
    $userData = $socialiteUser->getRaw();
    
    return User::create([
        'name' => $socialiteUser->getName(),
        'email' => $socialiteUser->getEmail(),
        'password' => bcrypt(Str::random(32)), // Random password for OAuth users
        'email_verified_at' => now(),
        'microsoft_id' => $socialiteUser->getId(),
        'avatar_url' => $socialiteUser->getAvatar(),
        'tenant_id' => $userData['tid'] ?? null, // Store Microsoft tenant ID
    ]);
}

protected function resolveMicrosoftUser(SocialiteUser $socialiteUser): ?User
{
    return User::where('microsoft_id', $socialiteUser->getId())
        ->orWhere('email', $socialiteUser->getEmail())
        ->first();
}
```

### **Option 2: chrisreedio/socialment**

**Pros**:
- ✅ Semplice e leggero
- ✅ Supporto multi-provider
- ✅ UI moderna con componenti Filament

**Cons**:
- ⚠️ Meno configurabile per enterprise scenarios
- ⚠️ Richiede più codice custom per role mapping

### **Option 3: Custom Implementation** (For Advanced Scenarios)

Per scenari enterprise complessi (multi-tenant con tenant-specific OAuth):

```php
// In Modules/User/app/Filament/Resources/UserResource.php

use Modules\User\Filament\Pages\Auth\CustomMicrosoftLoginPage;

public static function getPages(): array
{
    return [
        'login' => CustomMicrosoftLoginPage::class,
        // ... other pages
    ];
}
```

---

## 🛠️ **Implementation Steps**

### **Step 1: Create OAuth User Model**

Aggiungi colonne al modello User per OAuth:

```php
// In Modules/User/database/migrations/xxxx_add_oauth_columns_to_users_table.php

use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableUpdate('users', function (Blueprint $table) {
            $table->string('microsoft_id')->nullable()->unique()->after('email');
            $table->string('avatar_url')->nullable()->after('name');
            $table->string('tenant_id')->nullable()->after('microsoft_id');
            $table->timestamp('microsoft_token_expires_at')->nullable();
            $table->text('microsoft_refresh_token')->nullable();
        });
    }
};
```

### **Step 2: Update User Model**

```php
// In Modules/User/app/Models/User.php

use Modules\Xot\Models\XotBaseModel;
use Laravel\Passport\HasApiTokens;

class User extends XotBaseModel
{
    use HasApiTokens;
    
    #[\Override]
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'email_verified_at' => 'datetime',
            'microsoft_token_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relationships
    public function oauthAccounts(): HasMany
    {
        return $this->hasMany(OAuthAccount::class);
    }
    
    // Check if user is OAuth-only (no password)
    public function isOAuthOnly(): bool
    {
        return $this->password === null && $this->microsoft_id !== null;
    }
    
    // Get Microsoft token (if exists)
    public function getMicrosoftToken(): ?string
    {
        if ($this->microsoft_token_expires_at && $this->microsoft_token_expires_at->isPast()) {
            $this->refreshMicrosoftToken();
        }
        
        return $this->microsoft_access_token;
    }
    
    protected function refreshMicrosoftToken(): void
    {
        // Implementation for token refresh
        // Use SocialiteProviders\Microsoft\Provider
    }
}
```

### **Step 3: Create OAuth Account Model** (Optional but Recommended)

```php
// In Modules/User/app/Models/OAuthAccount.php

use Modules\Xot\Models\XotBaseModel;

class OAuthAccount extends XotBaseModel
{
    #[\Override]
    protected function casts(): array
    {
        return [
            'token_expires_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### **Step 4: Create Migration for OAuth Accounts**

```php
// In Modules/User/database/migrations/xxxx_create_oauth_accounts_table.php

use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate('oauth_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('provider'); // 'microsoft', 'google', etc.
            $table->string('provider_user_id');
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->unique(['provider', 'provider_user_id']);
            $table->index('user_id');
        });
    }
};
```

### **Step 5: Role Mapping Service**

```php
// In Modules/User/app/Services/MicrosoftRoleMappingService.php

namespace Modules\User\Services;

use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class MicrosoftRoleMappingService
{
    /**
     * Mappa i gruppi Microsoft ai ruoli Laraxot.
     * 
     * @param User $user
     * @param array $microsoftGroups
     * @return void
     */
    public function mapRoles(User $user, array $microsoftGroups): void
    {
        $roleMapping = config('user.microsoft_role_mapping', [
            'Dentist' => 'dentist',
            'ClinicAdmin' => 'clinic-admin',
            'SuperAdmin' => 'super-admin',
            'Patient' => 'patient',
        ]);
        
        $rolesToAssign = [];
        
        foreach ($microsoftGroups as $group) {
            $groupName = $group['displayName'] ?? $group['mailNickname'] ?? null;
            
            if ($groupName && isset($roleMapping[$groupName])) {
                $rolesToAssign[] = $roleMapping[$groupName];
            }
        }
        
        // Assign roles (remove old ones if not in mapping)
        $user->syncRoles($rolesToAssign);
        
        // Log role assignment for audit
        activity('role-assignment')
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'provider' => 'microsoft',
                'groups' => $microsoftGroups,
                'assigned_roles' => $rolesToAssign,
            ])
            ->log('Microsoft roles mapped to Laraxot roles');
    }
    
    /**
     * Get Microsoft groups for user from Graph API.
     * 
     * @param string $accessToken
     * @return array
     */
    public function getMicrosoftGroups(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->get('https://graph.microsoft.com/v1.0/me/memberOf');
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch Microsoft groups: ' . $response->body());
        }
        
        return $response->json('value', []);
    }
}
```

### **Step 6: Activity Logging**

```php
// In Modules/Activity/app/Actions/LogOAuthLoginAction.php

namespace Modules\Activity\App\Actions;

use Modules\Activity\App\Actions\ActivityLogger;
use Modules\User\Models\User;

class LogOAuthLoginAction
{
    public function __construct(private ActivityLogger $logger) {}
    
    public function execute(User $user, string $provider, array $providerData): void
    {
        $this->logger->execute([
            'log_name' => 'auth',
            'description' => "User logged in via {$provider} OAuth",
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'causer_type' => User::class,
            'causer_id' => $user->id,
            'properties' => [
                'provider' => $provider,
                'provider_user_id' => $providerData['id'] ?? null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_at' => now()->toIso8601String(),
            ],
        ]);
    }
}
```

---

## 🔒 **Security Best Practices**

### **1. Token Security**

```php
// NEVER store plain tokens in logs or session
// Use encrypted columns for tokens

// In migration
$table->text('microsoft_refresh_token')->nullable()->encrypted();

// Rotate tokens periodically
public function rotateTokens(): void
{
    $this->update([
        'microsoft_refresh_token' => encrypt(Str::random(64)),
    ]);
}
```

### **2. CSRF Protection**

```php
// In OAuth callback controller
public function handleCallback(Request $request)
{
    // Verify state parameter
    $state = $request->input('state');
    
    if (!$state || $state !== session('oauth_state')) {
        throw new \Exception('Invalid OAuth state');
    }
    
    // Proceed with authentication
}
```

### **3. Tenant Isolation**

Per multi-tenant (cliniche separate):

```php
// Ensure users can only OAuth with their clinic's Azure AD
public function validateTenantMatch(User $user, string $microsoftTenantId): bool
{
    $userTenant = $user->clinic?->microsoft_tenant_id;
    
    if ($userTenant && $userTenant !== $microsoftTenantId) {
        throw new \Exception('Microsoft tenant does not match clinic configuration');
    }
    
    return true;
}
```

### **4. Rate Limiting**

```php
// In RouteServiceProvider
Route::middleware(['throttle:oauth', 'auth'])->group(function () {
    Route::get('/auth/microsoft', [MicrosoftOAuthController::class, 'redirect']);
    Route::get('/auth/microsoft/callback', [MicrosoftOAuthController::class, 'callback']);
});
```

---

## 🧪 **Testing Strategy**

### **Pest Test Coverage Goals**

Obiettivo: **100% coverage** per OAuth functionality.

```php
// In Modules/User/tests/Feature/OAuth/MicrosoftAuthenticationTest.php

use Modules\User\Tests\TestCase;
use Modules\User\Models\User;
use Laravel\Socialite\Facades\Socialite;

uses(TestCase::class);

describe('Microsoft OAuth Authentication', function () {
    
    it('can redirect to Microsoft OAuth', function () {
        $response = $this->get('/auth/microsoft');
        
        $response->assertRedirect();
        $response->assertSessionHas('oauth_state');
    });
    
    it('can handle successful OAuth callback', function () {
        // Mock Socialite response
        $socialiteUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
        $socialiteUser->shouldReceive('getId')->andReturn('ms-12345');
        $socialiteUser->shouldReceive('getName')->andReturn('Mario Rossi');
        $socialiteUser->shouldReceive('getEmail')->andReturn('mario.rossi@example.com');
        $socialiteUser->shouldReceive('getAvatar')->andReturn('https://avatar.url');
        $socialiteUser->shouldReceive('getRaw')->andReturn([
            'tid' => 'tenant-123',
            'groups' => ['Dentist', 'ClinicAdmin']
        ]);
        
        Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);
        
        $response = $this->get('/auth/microsoft/callback?state=valid-state&code=auth-code');
        
        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
        
        $user = User::where('microsoft_id', 'ms-12345')->first();
        expect($user)->not->toBeNull();
        expect($user->name)->toBe('Mario Rossi');
    });
    
    it('maps Microsoft groups to Laraxot roles correctly', function () {
        $service = new \Modules\User\Services\MicrosoftRoleMappingService();
        $user = User::factory()->create();
        
        $microsoftGroups = [
            ['displayName' => 'Dentist'],
            ['displayName' => 'ClinicAdmin'],
        ];
        
        $service->mapRoles($user, $microsoftGroups);
        
        expect($user->hasRole('dentist'))->toBeTrue();
        expect($user->hasRole('clinic-admin'))->toBeTrue();
    });
    
    it('logs OAuth login activity', function () {
        $user = User::factory()->create();
        $action = new \Modules\Activity\App\Actions\LogOAuthLoginAction(
            new \Modules\Activity\App\Actions\ActivityLogger()
        );
        
        $action->execute($user, 'microsoft', ['id' => 'ms-123']);
        
        // Assert activity was logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'auth',
            'subject_id' => $user->id,
            'properties->provider' => 'microsoft',
        ]);
    });
    
    it('prevents OAuth with mismatched tenant', function () {
        $user = User::factory()->create([
            'clinic_id' => \Modules\Tenant\Models\Clinic::factory()->create([
                'microsoft_tenant_id' => 'tenant-456'
            ])
        ]);
        
        $service = new \Modules\User\Services\MicrosoftRoleMappingService();
        
        expect(fn() => $service->validateTenantMatch($user, 'tenant-123'))
            ->toThrow(\Exception::class, 'Microsoft tenant does not match');
    });
});
```

### **Coverage Requirements**

Per raggiungere **100% coverage** nel modulo Activity per OAuth:

1. **Models** (100%):
   - `OAuthAccount` → tutti i metodi
   - `User` → metodi OAuth-specifici
   - **Target**: 0 linee non coperte

2. **Actions** (100%):
   - `LogOAuthLoginAction`
   - `RefreshMicrosoftTokenAction`
   - **Target**: tutti i casi d'uso testati

3. **Services** (100%):
   - `MicrosoftRoleMappingService`
   - **Target**: tutti i path condizionali

4. **Feature Tests**:
   - Redirect flow
   - Callback success/failure
   - Role mapping
   - Tenant validation
   - Activity logging
   - Token refresh

### **Running Tests with Coverage**

```bash
# Run tests with coverage
php artisan test --coverage --filter=MicrosoftAuthenticationTest

# Generate HTML coverage report
php artisan test --coverage --coverage-html=./coverage

# Check specific module coverage
php artisan test --coverage --filter=User

# Minimum coverage threshold (100%)
php artisan test --coverage --min=100
```

---

## 🐛 **Troubleshooting**

### **Error: "Invalid client secret"**

**Cause**: Client secret scaduto o errato.

**Solution**:
1. Vai su Azure Portal → App registrations → Certificates & secrets
2. Genera un nuovo client secret
3. Aggiorna `.env`: `MICROSOFT_CLIENT_SECRET=new-secret`
4. `php artisan config:clear`

### **Error: "AADSTS50011: The reply URL specified in the request does not match"**

**Cause**: Redirect URI non configurato correttamente in Azure.

**Solution**:
1. Verifica che il redirect URI in Azure sia identico a quello in `.env`
2. Deve includere il protocollo (`https://`)
3. Deve includere il percorso completo (`/auth/microsoft/callback`)

### **Error: "Invalid OAuth state"**

**Cause**: CSRF token mismatch o session expired.

**Solution**:
1. Verifica `APP_KEY` in `.env`
2. Assicurati che la sessione sia configurata correttamente
3. `php artisan cache:clear` e `php artisan config:clear`

### **Error: "Token has expired"**

**Solution**: Implementare refresh token logic:

```php
// In User model
public function refreshMicrosoftToken(): void
{
    $provider = new \SocialiteProviders\Microsoft\Provider(
        new \GuzzleHttp\Client(),
        config('services.microsoft.client_id'),
        config('services.microsoft.client_secret'),
        config('services.microsoft.redirect')
    );
    
    $newToken = $provider->getAccessToken('refresh_token', [
        'refresh_token' => decrypt($this->microsoft_refresh_token),
    ]);
    
    $this->update([
        'microsoft_access_token' => encrypt($newToken->getToken()),
        'microsoft_token_expires_at' => now()->addSeconds($newToken->getExpires() - 300),
    ]);
}
```

### **Error: "User not found in tenant"**

**Cause**: Utente appartiene a un tenant Azure diverso da quello configurato.

**Solution**:
1. In Azure AD → App registrations → Authentication
2. Imposta **Supported account types** su "Accounts in any organizational directory"
3. O specifica il tenant ID corretto in `MICROSOFT_TENANT_ID`

---

## 📚 **Additional Resources**

### **Official Documentation**
- [Laravel Socialite Docs](https://laravel.com/docs/12.x/socialite)
- [Microsoft Identity Platform](https://docs.microsoft.com/en-us/azure/active-directory/develop/)
- [SocialiteProviders Microsoft](https://socialiteproviders.com/Microsoft/)

### **Filament Socialite Plugins**
- [DutchCodingCompany/filament-socialite](https://github.com/DutchCodingCompany/filament-socialite)
- [chrisreedio/socialment](https://github.com/chrisreedio/socialment)
- [andrewdwallo/filament-companies](https://github.com/andrewdwallo/filament-companies)

### **Laraxot Integration Patterns**
- [XotBaseServiceProvider Pattern](../../xot/docs/service-provider-pattern.md)
- [Module-specific OAuth Configuration](../../tenant/docs/multi-tenant-oauth.md)
- [Activity Logging for Auth Events](../../activity/docs/auth-logging.md)

---

## ✅ **Pre-Production Checklist**

- [ ] Microsoft Azure AD application configured
- [ ] Client ID e Secret aggiunti a `.env`
- [ ] Redirect URI configurato in Azure
- [ ] API permissions granted con admin consent
- [ ] Filament Socialite plugin installato e configurato
- [ ] User model aggiornato con OAuth columns
- [ ] Migrations eseguite
- [ ] Role mapping service implementato
- [ ] Activity logging configurato
- [ ] Pest tests scritti con 100% coverage
- [ ] PHPStan Level 10 compliance verificata
- [ ] Multi-tenant validation implementata
- [ ] Token refresh logic implementata
- [ ] Rate limiting configurato
- [ ] CSRF protection attiva
- [ ] Security audit completato
- [ ] GDPR compliance verificata
- [ ] Documentation aggiornata

---

**Documentazione conforme agli standard Laraxot** - PHPStan Level 10 ✅ | DRY + KISS + SOLID ✅

*
*Module: User*
*