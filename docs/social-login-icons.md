# Social Login - Guida all'Integrazione

## Panoramica

Il sistema di social login permette agli utenti di autenticarsi tramite provider OAuth (Google, Microsoft, GitHub).

## Icone SVG

Le icone dei provider sono già presenti in `Modules/UI/resources/svg/brands/`:

| Provider | File SVG | Icon Name |
|----------|----------|------------|
| Google | `brands/google.svg` | `ui-brands.google` |
| Microsoft | `brands/microsoft.svg` | `ui-brands.microsoft` |
| GitHub | `brands/github.svg` | `ui-brands.github` |

## Utilizzo nei Widget

### SocialLoginWidget

```blade
<x-filament::icon icon="ui-brands.google" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.microsoft" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.github" class="w-5 h-5" />
```

### Convenzione

Gli SVG sono in `Modules/UI/resources/svg/brands/` e diventano accessibili tramite:
- Prefisso `ui-brands.` + nome file (senza estensione)
- Es: `google.svg` → `ui-brands.google`

## Configurazione

### config/services.php

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],

'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
    'tenant' => env('MICROSOFT_TENANT_ID', 'common'),
],

'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URI'),
],
```

### .env

```
# Google
GOOGLE_CLIENT_ID=xxx
GOOGLE_CLIENT_SECRET=xxx
GOOGLE_REDIRECT_URI=https://dominio.com/sso/google/callback

# Microsoft
MICROSOFT_CLIENT_ID=xxx
MICROSOFT_CLIENT_SECRET=xxx
MICROSOFT_REDIRECT_URI=https://dominio.com/sso/microsoft/callback
MICROSOFT_TENANT_ID=common

# GitHub
GITHUB_CLIENT_ID=xxx
GITHUB_CLIENT_SECRET=xxx
GITHUB_REDIRECT_URI=https://dominio.com/sso/github/callback
```

## Route OAuth

Le route sono gestite da Filament Socialite:

- `/auth/{provider}` - Redirect al provider
- `/auth/{provider}/callback` - Callback dal provider

## Traduzioni

Le traduzioni sono in `Modules/User/lang/{locale}/auth.php`:

```php
'social' => [
    'title' => 'Accedi con',
    'google' => 'Google',
    'microsoft' => 'Microsoft',
    'github' => 'GitHub',
],
```

## Note

- Le icone NON sono hardcoded inline ma usano `<x-filament::icon>`
- Gli SVG sono centralizzati in `Modules/UI/resources/svg/`
- La configurazione dei provider è in `config/services.php`
