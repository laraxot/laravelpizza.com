# Studio: Laravel Socialite + Filament Integration

## Riferimenti Documentazione

- [Laravel Socialite](https://laravel.com/docs/12.x/socialite)
- [Filament Socialite Plugin](https://github.com/DutchCodingCompany/filament-socialite)
- [Socialite Providers Microsoft](https://socialiteproviders.com/Microsoft/)
- [Socialite Providers](https://socialiteproviders.com/)
- [Microsoft Azure App Registration](https://portal.azure.com/#view/Microsoft_AAD_IAM/ActiveDirectoryMenuBlade/RegisteredApps)

## Laravel Socialite - Concetti Base

### Installazione
```bash
composer require laravel/socialite
```

### Configurazione (config/services.php)
```php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => 'http://example.com/callback-url',
],

'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => 'http://example.com/callback-url',
],

'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => 'http://example.com/callback-url',
],
```

### Routing
```php
use Laravel\Socialite\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    // Process user...
});
```

### Ottenere Dati Utente
```php
$user = Socialite::driver('github')->user();

$token = $user->token;
$refreshToken = $user->refreshToken;
$user->getId();
$user->getName();
$user->getEmail();
$user->getAvatar();
```

## Filament Socialite Plugin

### Installazione
```bash
composer require dutchcodingcompany/filament-socialite
php artisan vendor:publish --tag="filament-socialite-migrations"
php artisan migrate
```

### Configurazione Plugin (AdminPanelProvider)
```php
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Support\Colors;

->plugin(
    FilamentSocialitePlugin::make()
        ->providers([
            Provider::make('github')
                ->label('GitHub')
                ->icon('fab-github')
                ->color(Color::hex('#24292e')),
            
            Provider::make('microsoft')
                ->label('Microsoft')
                ->icon('fab-microsoft')
                ->color(Color::hex('#00A4EF')),
            
            Provider::make('google')
                ->label('Google')
                ->icon('fab-google')
                ->color(Color::hex('#4285F4')),
        ])
        ->registration(true) // Enable new user registration
        ->domainAllowList(['example.com']) // SSO for internal use
)
```

### Callback URL
```
https://example.com/admin/oauth/callback/github
```

## Provider Supportati

### Official (Laravel Socialite)
- Facebook
- X (Twitter)
- LinkedIn
- Google
- GitHub
- GitLab
- Bitbucket
- Slack

### Community (Socialite Providers)
- Microsoft Azure
- Apple
- Discord
- Spotify
- E molti altri...

## Variabili .env Necessarie

```env
# GitHub
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=

# Microsoft Azure
MICROSOFT_CLIENT_ID=
MICROSOFT_CLIENT_SECRET=

# Google
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
```

## Best Practices

1. **Usare SocialiteProviders** per provider non ufficiali
2. **Stateless** per API: `Socialite::driver('google')->stateless()->user()`
3. **Scopes**: Specificare permessi necessari
4. **Token Refresh**: Gestire refresh token per sessioni lunghe
5. **Domain Allow List**: Per SSO aziendale

## Testing

```php
use Laravel\Socialite\Socialite;

test('user can login with github', function () {
    Socialite::fake('github', (new User)->map([
        'id' => 'github-123',
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]));

    $response = $this->get('/auth/github/callback');
    $response->assertRedirect('/dashboard');
});
```

## Microsoft OAuth - SocialiteProviders

Microsoft non è nel core Laravel Socialite. Usare `socialiteproviders/microsoft`:

```bash
composer require socialiteproviders/microsoft
```

### Laravel 11+ - Event Listener

In `AppServiceProvider::boot()` o `EventServiceProvider`:

```php
Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
    $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
});
```

### config/services.php

```php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
    'tenant' => env('MICROSOFT_TENANT_ID', 'common'),
],
```

### Tenant Types (Azure AD)

- `common` - Microsoft + work/school (più permissivo)
- `organizations` - Solo work/school
- `consumers` - Solo account Microsoft personali
- `tenant_id` - Solo tenant specifico

### Variabili .env Microsoft

```env
MICROSOFT_CLIENT_ID=
MICROSOFT_CLIENT_SECRET=
MICROSOFT_REDIRECT_URI=https://example.com/admin/oauth/callback/microsoft
MICROSOFT_TENANT_ID=common
```

## Prossimi Passi per Implementazione

1. Installare `socialiteproviders/microsoft` per Microsoft
2. Aggiungere MicrosoftExtendSocialite a EventServiceProvider
3. Configurare config/services.php con microsoft
4. Configurare provider OAuth in Azure AD
5. Aggiungere variabili .env
6. Testare flusso OAuth
