# Best Practices per i Componenti di Autenticazione 

## Collegamenti correlati
- [README modulo User](./README.md)
- [Best Practices Chiavi di Traduzione](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Utilizzo di Laravel Localization](/laravel/Modules/Lang/docs/LARAVEL_LOCALIZATION_USAGE.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive le best practices per implementare e utilizzare i componenti di autenticazione , con particolare attenzione alle chiavi di traduzione e alla struttura dei componenti.

## Struttura delle Chiavi di Traduzione per l'Autenticazione

Le chiavi di traduzione per l'autenticazione seguono una struttura gerarchica ben definita. Tutte le chiavi sono organizzate sotto il namespace `auth` con sottocategorie specifiche per ogni funzionalità:

```php
'auth' => [
    'login' => [
        'title' => 'Accedi al tuo account',
        'email' => 'Email',
        'password' => 'Password',
        'remember_me' => 'Ricordami',
        'forgot_password' => 'Password dimenticata?',
        'submit' => 'Accedi',
        'or' => 'oppure',
        'create_account' => 'crea un nuovo account',
        'link' => 'Accedi',
    ],
    'register' => [
        'title' => 'Crea un nuovo account',
        'submit' => 'Registrati',
        'link' => 'Registrati',
        // ...
    ],
    'logout' => [
        'submit' => 'Logout',
    ],
    // ...
]
```

## Utilizzo Corretto nei Componenti Blade

### 1. Pulsanti di Login/Registrazione

```php
<div class="flex items-center space-x-4">
    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
        {{ __('auth.login.link') }}
    </a>
    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        {{ __('auth.register.link') }}
    </a>
</div>
```

### 2. Form di Login

```php
<form wire:submit="authenticate" class="space-y-6">
    <x-ui.input
        :label="__('auth.login.email')"
        type="email"
        id="email"
        name="email"
        wire:model="email"
        required
    />
    <x-ui.input
        :label="__('auth.login.password')"
        type="password"
        id="password"
        name="password"
        wire:model="password"
        required
    />

    <div class="flex items-center justify-between">
        <x-ui.checkbox
            :label="__('auth.login.remember_me')"
            id="remember"
            name="remember"
            wire:model="remember"
        />
        <x-ui.text-link href="{{ route('password.request') }}">
            {{ __('auth.login.forgot_password') }}
        </x-ui.text-link>
    </div>

    <x-ui.button type="primary" submit="true" class="w-full">
        {{ __('auth.login.submit') }}
    </x-ui.button>
</form>
```

### 3. Dropdown Utente con Logout

```php
<div class="py-1">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <x-heroicon-o-logout class="mr-3 h-5 w-5 text-gray-400" />
            {{ __('auth.logout.submit') }}
        </button>
    </form>
</div>
```

## Errori Comuni da Evitare

### 1. Utilizzo di Stringhe Dirette

```php
// ERRATO
<button>Accedi</button>
<button>Login</button>

// CORRETTO
<button>{{ __('auth.login.submit') }}</button>
```

### 2. Utilizzo di Chiavi Non Strutturate

```php
// ERRATO
{{ __('Login') }}
{{ __('auth.login') }}

// CORRETTO
{{ __('auth.login.submit') }}
```

### 3. Utilizzo di Array nelle Chiavi di Traduzione

```php
// ERRATO - Questo causerà un errore "htmlspecialchars(): Argument #1 ($string) must be of type string, array given"
{{ __(['auth', 'login']) }}

// CORRETTO
{{ __('auth.login.submit') }}
```

### 4. Mancata Verifica dell'Esistenza dei File di Traduzione

Prima di utilizzare una chiave di traduzione, assicurarsi che i file di traduzione corrispondenti esistano in tutte le lingue supportate:

- `/laravel/Modules/Lang/lang/it/auth.php`
- `/laravel/Modules/Lang/lang/en/auth.php`

## Componenti di Autenticazione 

### 1. Pagine di Autenticazione

Le pagine di autenticazione sono implementate utilizzando Laravel Folio e Livewire Volt:

- `/laravel/Themes/One/resources/views/pages/auth/login.blade.php`
- `/laravel/Themes/One/resources/views/pages/auth/register.blade.php`
- `/laravel/Themes/One/resources/views/pages/auth/forgot-password.blade.php`
- `/laravel/Themes/One/resources/views/pages/auth/reset-password.blade.php`

### 2. Componenti UI di Autenticazione

I componenti UI per l'autenticazione sono implementati come componenti Blade:

- `/laravel/Themes/One/resources/views/components/blocks/navigation/login-buttons.blade.php`
- `/laravel/Themes/One/resources/views/components/blocks/navigation/user-dropdown.blade.php`

## Integrazione con Laravel Localization

Quando si utilizzano componenti di autenticazione, è importante assicurarsi che funzionino correttamente con la localizzazione delle URL:

```php
<a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('login')) }}">
    {{ __('auth.login.link') }}
</a>
```

## Verifica e Testing

Prima di implementare nuovi componenti di autenticazione o modificare quelli esistenti, verificare sempre:

1. Che tutte le chiavi di traduzione siano definite in tutti i file di lingua supportati
2. Che i componenti funzionino correttamente con la localizzazione delle URL
3. Che i componenti rispettino le best practices di SaluteOra per le chiavi di traduzione

## Riferimenti

- [Documentazione Laravel Authentication](https://laravel.com/docs/10.x/authentication)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Livewire](https://livewire.laravel.com/)
- [Documentazione Laravel Folio](https://laravel.com/docs/10.x/folio)
