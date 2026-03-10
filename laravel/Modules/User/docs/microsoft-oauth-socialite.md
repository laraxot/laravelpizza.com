# Microsoft OAuth/Socialite - Analisi e Implementazione

## Riferimenti Studiati

- [Laravel 12 Socialite Login with Microsoft](https://www.itsolutionstuff.com/post/laravel-12-socialite-login-with-microsoft-account-exampleexample.html)
- [Filament Socialite Plugin](https://filamentphp.com/plugins/dododedodonl-socialite)
- [Laravel Socialite Documentation](https://laravel.com/docs/12.x/socialite)
- [Socialite Providers Microsoft](https://socialiteproviders.com/Microsoft/)
- [Laravel Socialite Configure Microsoft Azure](https://dev.to/judicaelg/laravel-socialite-configure-microsoft-azure-16hj)
- [Filament Socialite GitHub](https://github.com/DutchCodingCompany/filament-socialite)
- [Socialment Plugin](https://filamentphp.com/plugins/chrisreedio-socialment)
- [Socialment GitHub](https://github.com/chrisreedio/socialment)
- [FilamentFlow Socialite](https://docs.filamentflow.io/docs/features/socialite)

## Opzioni di Implementazione

### Opzione 1: Filament Socialite Plugin (Consigliata)

Plugin ufficiale: `dutchcodingcompany/filament-socialite`

**Installazione:**
```bash
composer require dutchcodingcompany/filament-socialite
php artisan vendor:publish --tag="filament-socialite-migrations"
php artisan migrate
```

**Configurazione in AdminPanelProvider:**
```php
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Support\Colors;

->plugin(
    FilamentSocialitePlugin::make()
        ->providers([
            Provider::make('microsoft')
                ->label('Microsoft')
                ->icon('fab-microsoft')
                ->color(Colors::BLUE)
                ->scopes(['User.Read', 'Mail.Read']),
        ])
        ->registration(true)
)
```

**Configurazione .env:**
```env
MICROSOFT_CLIENT_ID=xxx
MICROSOFT_CLIENT_SECRET=xxx
MICROSOFT_REDIRECT_URL=https://example.com/admin/oauth/callback/microsoft
```

**Configurazione config/services.php:**
```php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URL'),
    'tenant' => env('MICROSOFT_TENANT', 'common'),
],
```

### Opzione 2: Implementazione Manuale con Controller

**Passi:**

1. **Installare Socialite:**
```bash
composer require laravel/socialite
```

2. **Creare migrazione per campi Microsoft:**
```bash
php artisan make:migration add_microsoft_fields_to_users_table
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('microsoft_id')->nullable();
    $table->string('microsoft_token')->nullable();
    $table->string('microsoft_refresh_token')->nullable();
});
```

3. **Aggiornare User Model:**
```php
protected $fillable = [
    // ... altri campi
    'microsoft_id',
    'microsoft_token',
    'microsoft_refresh_token',
];

protected $hidden = [
    // ... altri campi nascosti
    'microsoft_token',
    'microsoft_refresh_token',
];
```

4. **Creare MicrosoftController:**
```php
public function redirectToMicrosoft()
{
    return Socialite::driver('microsoft')->redirect();
}

public function handleMicrosoftCallback()
{
    $microsoftUser = Socialite::driver('microsoft')->user();

    $user = User::where('microsoft_id', $microsoftUser->id)
        ->orWhere('email', $microsoftUser->email)
        ->first();

    if ($user) {
        $user->update([
            'microsoft_id' => $microsoftUser->id,
            'microsoft_token' => $microsoftUser->token,
            'microsoft_refresh_token' => $microsoftUser->refreshToken,
        ]);
    } else {
        $user = User::create([
            'name' => $microsoftUser->name,
            'email' => $microsoftUser->email,
            'microsoft_id' => $microsoftUser->id,
            'microsoft_token' => $microsoftUser->token,
            'microsoft_refresh_token' => $microsoftUser->refreshToken,
            'password' => Hash::make(uniqid()),
        ]);
    }

    Auth::login($user);
    return redirect()->intended('/admin');
}
```

5. **Configurazione Azure AD:**
- Registrare app in Azure Portal > App registrations
- Aggiungere redirect URI: `https://yoursite.com/auth/microsoft/callback`
- Generare client secret

### Opzione 3: Socialment Plugin (Alternativa)

Plugin alternativo: `chrisreedio/socialment`

**Installazione:**
```bash
composer require chrisreedio/socialment
php artisan socialment:install
```

**Configurazione in AdminPanelProvider:**
```php
use ChrisReedIO\Socialment\SocialmentPlugin;

->plugin(
    SocialmentPlugin::make()
        ->registerProvider('azure', 'fab-microsoft', 'Azure Active Directory')
)
```

**Configurazione Azure AD in config/services.php:**
```php
'azure' => [
    'client_id' => env('AZURE_CLIENT_ID'),
    'client_secret' => env('AZURE_CLIENT_SECRET'),
    'redirect' => env('AZURE_REDIRECT_URI'),
    'tenant' => env('AZURE_TENANT_ID'),
    'proxy' => env('PROXY'), // opzionale
],
```

**Event Listener:**
```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        \SocialiteProviders\Azure\AzureExtendSocialite::class.'@handle',
    ],
];
```

**Callback URL Socialment:**
```
https://dominio.com/login/azure/callback
```

## Confronto

| Caratteristica | Filament Socialite | Socialment | Manuale |
|----------------|-------------------|------------|---------|
| Facilità setup | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| Personalizzazione | ⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| Multi-provider | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| Supporto Filament | Native | Native | Richiede custom widget |
| Manutenzione | Plugin aggiornato | Plugin aggiornato | Manuale |

## Azure AD App Registration Dettagliata

### Passi Completi

1. **Azure Portal** > **App registrations** > **New registration**
2. **Name**: "Laravel Microsoft Login" o nome app
3. **Supported account types**:
   - "Accounts in any organizational directory and personal Microsoft accounts" (common)
   - "Accounts in this organizational directory only" (organizations)
   - "Personal Microsoft accounts only" (consumers)
4. **Redirect URI**:
   - Web
   - `http://localhost:8000/auth/microsoft/callback` (dev)
   - `https://yoursite.com/admin/oauth/callback/microsoft` (prod)
5. **Register**
6. **Copy Application (client) ID**
7. **Certificates & secrets** > **New client secret**
8. **Copy Value** (non Secret ID)

### Tenant Types

| Valore | Descrizione |
|--------|-------------|
| `common` | Tutti gli account Microsoft (personali e lavoro) |
| `organizations` | Solo account lavoro/scuola |
| `consumers` | Solo account Microsoft personali (Xbox, Teams for Life) |
| `{tenant-id}` | Organizzazione specifica |

## Event Listener Setup (Laravel 11+)

In `AppServiceProvider::boot()`:

```php
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;

Event::listen(function (SocialiteWasCalled $event) {
    $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
});
```

## Refresh Token

Microsoft non restituisce refresh token di default. Per ottenerlo:

```php
// Aggiungere scope offline_access
return Socialite::driver('microsoft')
    ->scopes(['User.Read', 'offline_access'])
    ->redirect();
```

## Extended Features (Microsoft)

### Tenant Information

```php
// config/services.php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URL'),
    'tenant' => 'common',
    'include_tenant_info' => true,
],
```

### Roles from Microsoft 365

```php
$roles = Socialite::driver('microsoft')->user()->getRoles();
// Returns array of Azure AD group names
```

### Additional Tenant Fields

```php
'microsoft' => [
    'tenant_fields' => ['tenantType', 'technicalNotificationMails'],
    'include_avatar' => true,
    'include_avatar_size' => '648x648',
],
```

<<<<<<< .merge_file_cOmoSe
## Regole per healthcare_app Fila5
=======
<<<<<<< HEAD
## Regole per ExternalProject Fila5
=======
## Regole per ModuloEsempio Fila5
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> .merge_file_Z9kr3H

### 1. Usare Filament Socialite Plugin
- Installare `dutchcodingcompany/filament-socialite`
- Configurare nel panel provider

### 2. Provider Supportati
- Microsoft (Azure AD)
- Google
- GitHub
- GitLab
- Facebook
- Twitter/X

### 3. Callback URL
Per Filament v5:
```
https://dominio.com/{panel}/oauth/callback/{provider}
```

Esempio:
```
https://sottana.net/admin/oauth/callback/microsoft
```

### 4. Domain Allow List
Per limitare l'accesso solo a utenti di un dominio specifico:
```php
->domainAllowList(['sottana.com', 'studio.it'])
```

### 5. User Model
La tabella users deve avere:
```php
$table->string('password')->nullable();  // Per utenti OAuth senza password
```

## Connections

- [Filament Socialite](https://filamentphp.com/plugins/dododedodonl-socialite)
- [Laravel Socialite](https://laravel.com/docs/12.x/socialite)
- [Socialite Providers](https://socialiteproviders.com/)
- [Microsoft Azure App Registration](https://portal.azure.com/#view/Microsoft_AAD_IAM/ActiveDirectoryMenuBlade/RegisteredApps)
