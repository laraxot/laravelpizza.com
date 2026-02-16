# Componenti di Navigazione 

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Gestione dell'Autenticazione](#gestione-dellautenticazione)
- [Localizzazione](#localizzazione)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti di navigazione , con particolare attenzione alla gestione condizionale dell'autenticazione e alla localizzazione.

## Componenti Disponibili

### Componenti di Navigazione Principali

- `<x-blocks.navigation.user-dropdown>` - Dropdown utente (visualizzato solo per utenti autenticati)
- `<x-blocks.navigation.login-buttons>` - Pulsanti di login/registrazione (visualizzati solo per utenti non autenticati)
- `<x-blocks.navigation.language-switcher>` - Selettore della lingua

## Gestione dell'Autenticazione

Il componente `user-dropdown` è progettato per gestire automaticamente la visualizzazione condizionale in base allo stato di autenticazione dell'utente:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
])

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $user = $user ?? auth()->user();
    $locale = LaravelLocalization::getCurrentLocale();
    $isLoggedIn = auth()->check();
@endphp

@if($isLoggedIn)
    {{-- Dropdown per utente loggato --}}
    <!-- Contenuto del dropdown utente -->
@else
    {{-- Link di login/register per utente non loggato --}}
    <div class="flex items-center space-x-4">
        <a href="/{{ $locale }}/auth/login" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
            {{ __('auth.login.title') }}
        </a>
        <a href="/{{ $locale }}/auth/register" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
            {{ __('auth.register.title') }}
        </a>
    </div>
@endif
```

## Localizzazione

I componenti di navigazione devono utilizzare sempre le funzioni di localizzazione di Laravel e mcamara/laravel-localization:

```blade
@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $locale = LaravelLocalization::getCurrentLocale();
@endphp

<a href="/{{ $locale }}/profile">{{ __('auth.user_dropdown.profile') }}</a>
```

### Traduzioni Necessarie

Assicurarsi che le seguenti chiavi di traduzione siano definite in `/var/www/html/saluteora/laravel/lang/{locale}/auth.php`:

```php
return [
    'login' => [
        'title' => 'Accedi',
        // altri campi
    ],
    'register' => [
        'title' => 'Registrati',
        // altri campi
    ],
    'user_dropdown' => [
        'manage_account' => 'Gestisci Account',
        'profile' => 'Profilo',
        'settings' => 'Impostazioni',
        'logout' => 'Esci',
    ],
    // altre sezioni
];
```

## Best Practices

1. **Gestione condizionale dell'autenticazione**:
   - Utilizzare sempre `auth()->check()` per verificare lo stato di autenticazione
   - Mostrare il dropdown utente solo per utenti autenticati
   - Mostrare i pulsanti di login/registrazione solo per utenti non autenticati

2. **Percorsi localizzati**:
   - Utilizzare sempre `LaravelLocalization::getCurrentLocale()` per ottenere la lingua corrente
   - Costruire i percorsi con il prefisso della lingua: `/{{ $locale }}/percorso`
   - Non utilizzare `route()` per percorsi frontend, a meno che non siano rotte predefinite di Laravel

3. **Traduzioni**:
   - Utilizzare sempre le chiavi di traduzione complete (es. `auth.user_dropdown.profile`)
   - Non utilizzare stringhe hardcoded
   - Assicurarsi che tutte le chiavi utilizzate esistano nei file di traduzione

4. **Componenti Filament**:
   - Utilizzare i componenti Filament per icone e avatar: `<x-filament::icon>`, `<x-filament::avatar>`
   - Utilizzare i componenti Filament per i dropdown quando possibile
   - Utilizzare i separatori corretti nei dropdown (div con bordo, non componenti inesistenti)
