# 🔑 SINGLE SIGN-ON (SSO) - GUIDA IMPLEMENTAZIONE

**Versione**: 1.0  
**Status**: 📋 Pianificato Q1 2026  
**Data**: 2025-10-01  

---

## 🎯 OVERVIEW

Implementazione Single Sign-On (SSO) per FixCity con supporto SAML 2.0 e OpenID Connect (OIDC), permettendo l'integrazione con provider enterprise come Azure AD, Google Workspace, Okta.

---

## 🏗️ ARCHITETTURA

### Protocolli Supportati

```
SSO Implementation
├── SAML 2.0 (Enterprise)
│   ├── Azure AD
│   ├── Okta
│   └── OneLogin
│
├── OpenID Connect (Modern)
│   ├── Google Workspace
│   ├── Microsoft 365
│   └── Auth0
│
└── OAuth 2.0 (Social)
    ├── Google
    ├── Microsoft
    └── GitHub
```

### Flow SSO

```
1. User → Click "Login with SSO"
2. Redirect → Identity Provider (IdP)
3. Authentication → User logs in at IdP
4. SAML Response → IdP sends assertion
5. Validation → Verify signature & claims
6. User Provisioning → Create/update user
7. Session → Grant access
```

---

## 📦 DIPENDENZE

### SAML 2.0

```bash
composer require aacotroneo/laravel-saml2
composer require onelogin/php-saml
```

### OpenID Connect

```bash
composer require laravel/socialite
composer require socialiteproviders/microsoft-azure
composer require socialiteproviders/google
```

### Configuration

```php
// config/saml2_settings.php
return [
    'useRoutes' => true,
    'routesPrefix' => '/saml2',
    'routesMiddleware' => ['saml'],
    'loginRoute' => '/login',
    'errorRoute' => '/error',
];
```

---

## 💾 DATABASE SCHEMA

### Migration: SSO Providers

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(
            'sso_providers',
            function (Blueprint $table): void {
                $table->id();
                $table->string('name'); // Azure AD, Google, Okta
                $table->string('type'); // saml, oidc, oauth
                $table->string('entity_id')->unique();
                $table->text('metadata_url')->nullable();
                $table->json('settings');
                $table->boolean('active')->default(true);
                $table->json('domain_whitelist')->nullable();
                $table->json('role_mapping')->nullable();
                $this->updateTimestamps($table);
            }
        );

        $this->tableUpdate(
            'users',
            function (Blueprint $table): void {
                if (! $this->hasColumn('sso_provider_id')) {
                    $table->foreignId('sso_provider_id')->nullable()
                        ->constrained('sso_providers')->nullOnDelete();
                }
                if (! $this->hasColumn('sso_identifier')) {
                    $table->string('sso_identifier')->nullable()->unique();
                }
                if (! $this->hasColumn('sso_last_login')) {
                    $table->timestamp('sso_last_login')->nullable();
                }
            }
        );
    }
};
```

---

## 🔧 IMPLEMENTAZIONE SAML 2.0

### 1. SsoProvider Model

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SsoProvider extends Model
{
    protected $fillable = [
        'name',
        'type',
        'entity_id',
        'metadata_url',
        'settings',
        'active',
        'domain_whitelist',
        'role_mapping',
    ];

    protected $casts = [
        'settings' => 'array',
        'active' => 'boolean',
        'domain_whitelist' => 'array',
        'role_mapping' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isAllowedDomain(string $email): bool
    {
        if (empty($this->domain_whitelist)) {
            return true;
        }

        $domain = substr(strrchr($email, "@"), 1);
        return in_array($domain, $this->domain_whitelist);
    }

    public function mapRoles(array $samlRoles): array
    {
        $mapping = $this->role_mapping ?? [];
        $roles = [];

        foreach ($samlRoles as $samlRole) {
            if (isset($mapping[$samlRole])) {
                $roles[] = $mapping[$samlRole];
            }
        }

        return $roles;
    }
}
```

### 2. SAML Service

```php
<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Aacotroneo\Saml2\Saml2Auth;
use Modules\User\Models\User;
use Modules\User\Models\SsoProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SamlService
{
    protected Saml2Auth $saml2Auth;

    public function __construct(Saml2Auth $saml2Auth)
    {
        $this->saml2Auth = $saml2Auth;
    }

    /**
     * Handle SAML login
     */
    public function login(string $providerId): void
    {
        $this->saml2Auth->login(route('saml.acs', ['provider' => $providerId]));
    }

    /**
     * Handle SAML ACS (Assertion Consumer Service)
     */
    public function handleAssertion(SsoProvider $provider): User
    {
        $samlUser = $this->saml2Auth->getSaml2User();
        
        $attributes = $samlUser->getAttributes();
        $nameId = $samlUser->getNameId();

        // Extract user data
        $email = $this->getAttribute($attributes, 'email', $nameId);
        $name = $this->getAttribute($attributes, 'name', '');
        $roles = $this->getAttribute($attributes, 'roles', []);

        // Validate domain
        if (!$provider->isAllowedDomain($email)) {
            throw new \Exception('Domain not allowed for this SSO provider');
        }

        // Find or create user
        $user = User::where('sso_identifier', $nameId)
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            $user = $this->createUser($provider, $email, $name, $nameId);
        }

        // Update user
        $this->updateUser($user, $provider, $email, $name, $nameId, $roles);

        // Log SSO login
        Log::info('SSO Login', [
            'provider' => $provider->name,
            'user_id' => $user->id,
            'email' => $email,
        ]);

        return $user;
    }

    /**
     * Create new user from SSO
     */
    protected function createUser(
        SsoProvider $provider,
        string $email,
        string $name,
        string $ssoIdentifier
    ): User {
        return User::create([
            'name' => $name,
            'email' => $email,
            'sso_provider_id' => $provider->id,
            'sso_identifier' => $ssoIdentifier,
            'password' => bcrypt(Str::random(32)), // Random password
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Update existing user
     */
    protected function updateUser(
        User $user,
        SsoProvider $provider,
        string $email,
        string $name,
        string $ssoIdentifier,
        array $samlRoles
    ): void {
        $user->update([
            'name' => $name,
            'email' => $email,
            'sso_provider_id' => $provider->id,
            'sso_identifier' => $ssoIdentifier,
            'sso_last_login' => now(),
        ]);

        // Map and sync roles
        $roles = $provider->mapRoles($samlRoles);
        if (!empty($roles)) {
            $user->syncRoles($roles);
        }
    }

    /**
     * Get attribute from SAML response
     */
    protected function getAttribute(array $attributes, string $key, mixed $default = null): mixed
    {
        $mapping = [
            'email' => ['email', 'mail', 'emailAddress', 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'],
            'name' => ['name', 'displayName', 'cn', 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'],
            'roles' => ['roles', 'groups', 'http://schemas.microsoft.com/ws/2008/06/identity/claims/role'],
        ];

        foreach ($mapping[$key] ?? [] as $attr) {
            if (isset($attributes[$attr])) {
                $value = $attributes[$attr];
                return is_array($value) ? $value[0] : $value;
            }
        }

        return $default;
    }

    /**
     * Handle SAML logout
     */
    public function logout(): void
    {
        $this->saml2Auth->logout();
    }
}
```

### 3. SAML Controller

```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Models\SsoProvider;
use Modules\User\Services\SamlService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SamlController extends Controller
{
    protected SamlService $samlService;

    public function __construct(SamlService $samlService)
    {
        $this->samlService = $samlService;
    }

    /**
     * Initiate SAML login
     */
    public function login(string $provider): RedirectResponse
    {
        $ssoProvider = SsoProvider::where('entity_id', $provider)
            ->where('active', true)
            ->firstOrFail();

        $this->samlService->login($ssoProvider->entity_id);
        
        return redirect()->away($this->samlService->getLoginUrl());
    }

    /**
     * Handle SAML ACS (Assertion Consumer Service)
     */
    public function acs(string $provider): RedirectResponse
    {
        $ssoProvider = SsoProvider::where('entity_id', $provider)
            ->where('active', true)
            ->firstOrFail();

        try {
            $user = $this->samlService->handleAssertion($ssoProvider);
            
            Auth::login($user);
            session(['sso_authenticated' => true]);

            return redirect()->intended('/admin');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['sso' => 'SSO authentication failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle SAML logout
     */
    public function logout(): RedirectResponse
    {
        $this->samlService->logout();
        Auth::logout();
        
        return redirect()->route('login');
    }

    /**
     * SAML metadata endpoint
     */
    public function metadata(string $provider)
    {
        $metadata = $this->samlService->getMetadata();
        
        return response($metadata, 200, [
            'Content-Type' => 'text/xml',
        ]);
    }
}
```

---

## 🔧 IMPLEMENTAZIONE OIDC

### OpenID Connect Service

```php
<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Laravel\Socialite\Facades\Socialite;
use Modules\User\Models\User;
use Modules\User\Models\SsoProvider;

class OidcService
{
    /**
     * Redirect to OIDC provider
     */
    public function redirect(SsoProvider $provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($provider->type)
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle OIDC callback
     */
    public function handleCallback(SsoProvider $provider): User
    {
        $socialiteUser = Socialite::driver($provider->type)->user();

        // Validate domain
        if (!$provider->isAllowedDomain($socialiteUser->getEmail())) {
            throw new \Exception('Domain not allowed for this SSO provider');
        }

        // Find or create user
        $user = User::where('sso_identifier', $socialiteUser->getId())
            ->orWhere('email', $socialiteUser->getEmail())
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'sso_provider_id' => $provider->id,
                'sso_identifier' => $socialiteUser->getId(),
                'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                'email_verified_at' => now(),
            ]);
        } else {
            $user->update([
                'sso_last_login' => now(),
            ]);
        }

        return $user;
    }
}
```

---

## 🎨 FILAMENT ADMIN

### SSO Provider Resource

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\User\Models\SsoProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

class SsoProviderResource extends XotBaseResource
{
    protected static ?string $model = SsoProvider::class;
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Security';

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            
            'type' => Forms\Components\Select::make('type')
                ->options([
                    'saml' => 'SAML 2.0',
                    'oidc' => 'OpenID Connect',
                    'oauth' => 'OAuth 2.0',
                ])
                ->required(),
            
            'entity_id' => Forms\Components\TextInput::make('entity_id')
                ->required()
                ->unique(ignoreRecord: true),
            
            'metadata_url' => Forms\Components\TextInput::make('metadata_url')
                ->url(),
            
            'active' => Forms\Components\Toggle::make('active')
                ->default(true),
            
            'domain_whitelist' => Forms\Components\TagsInput::make('domain_whitelist')
                ->placeholder('example.com'),
            
            'settings' => Forms\Components\KeyValue::make('settings')
                ->keyLabel('Setting')
                ->valueLabel('Value'),
            
            'role_mapping' => Forms\Components\KeyValue::make('role_mapping')
                ->keyLabel('SSO Role')
                ->valueLabel('Application Role'),
        ];
    }
}
```

---

## 🔐 SECURITY

### Session Management

```php
<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class SsoSessionService
{
    /**
     * Revoke all SSO sessions for user
     */
    public function revokeAllSessions(User $user): void
    {
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->delete();
    }

    /**
     * Track SSO login
     */
    public function trackLogin(User $user, string $provider): void
    {
        DB::table('sso_login_logs')->insert([
            'user_id' => $user->id,
            'provider' => $provider,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
```

### Audit Logging

```php
// Log all SSO events
Log::channel('sso')->info('SSO Login', [
    'user_id' => $user->id,
    'provider' => $provider->name,
    'ip' => request()->ip(),
    'timestamp' => now(),
]);
```

---

## 🧪 TESTING

```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Modules\User\Models\SsoProvider;
use Modules\User\Services\SamlService;

class SsoTest extends TestCase
{
    public function test_saml_provider_can_be_created(): void
    {
        $provider = SsoProvider::create([
            'name' => 'Azure AD',
            'type' => 'saml',
            'entity_id' => 'https://sts.windows.net/tenant-id/',
            'active' => true,
            'domain_whitelist' => ['company.com'],
        ]);

        $this->assertDatabaseHas('sso_providers', [
            'name' => 'Azure AD',
            'type' => 'saml',
        ]);
    }

    public function test_domain_whitelist_validation(): void
    {
        $provider = SsoProvider::factory()->create([
            'domain_whitelist' => ['allowed.com'],
        ]);

        $this->assertTrue($provider->isAllowedDomain('user@allowed.com'));
        $this->assertFalse($provider->isAllowedDomain('user@notallowed.com'));
    }
}
```

---

## 📊 CONFIGURATION EXAMPLES

### Azure AD SAML

```php
[
    'name' => 'Azure AD',
    'type' => 'saml',
    'entity_id' => 'https://sts.windows.net/{tenant-id}/',
    'metadata_url' => 'https://login.microsoftonline.com/{tenant-id}/federationmetadata/2007-06/federationmetadata.xml',
    'settings' => [
        'idp_sso_url' => 'https://login.microsoftonline.com/{tenant-id}/saml2',
        'idp_slo_url' => 'https://login.microsoftonline.com/{tenant-id}/saml2',
        'x509cert' => '...',
    ],
]
```

### Google Workspace OIDC

```php
[
    'name' => 'Google Workspace',
    'type' => 'oidc',
    'entity_id' => 'google',
    'settings' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
]
```

---

## 📚 BEST PRACTICES

### Security
✅ **Validate signatures**: Always verify SAML assertions  
✅ **Domain whitelist**: Restrict allowed email domains  
✅ **Audit logging**: Log all SSO events  
✅ **Session management**: Implement proper session handling  
✅ **Certificate rotation**: Plan for certificate updates  

### User Experience
✅ **Auto-provisioning**: Create users automatically  
✅ **Role mapping**: Map SSO roles to app roles  
✅ **Fallback**: Provide alternative login methods  
✅ **Clear errors**: Show helpful error messages  

### Operations
✅ **Monitoring**: Track SSO success/failure rates  
✅ **Documentation**: Document provider setup  
✅ **Testing**: Test with each provider  
✅ **Support**: Provide SSO troubleshooting guide  

---

**Last Updated**: 2025-10-01  
**Status**: Pianificato Q1 2026  
**Priority**: MEDIUM  
