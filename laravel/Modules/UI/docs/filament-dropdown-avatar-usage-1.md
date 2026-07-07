# Utilizzo dei Componenti Filament Dropdown e Avatar

## Collegamenti correlati
- [README modulo UI](/laravel/Modules/UI/docs/README.md)
- [Utilizzo Componenti Filament](/laravel/Modules/UI/docs/FILAMENT_COMPONENTS_USAGE.md)
- [Architettura Modulare](/docs/architettura-modulare.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive l'implementazione e l'utilizzo dei componenti dropdown e avatar di Filament , con particolare attenzione alla gestione degli utenti e alle azioni correlate.

## Componente Avatar

Il componente `x-filament::avatar` è utilizzato per visualizzare l'immagine del profilo dell'utente. Questo componente accetta diverse proprietà per personalizzare l'aspetto dell'avatar.

### Esempio di Utilizzo dell'Avatar

```blade
<x-filament::avatar
    :src="$user?->profile_photo_url"
    :alt="$user?->name"
    size="md"
    class="ring-2 ring-white ring-opacity-50 shadow-sm"
/>
```

### Proprietà dell'Avatar

| Proprietà | Descrizione | Valori possibili |
|-----------|-------------|------------------|
| `src` | URL dell'immagine | Stringa URL |
| `alt` | Testo alternativo | Stringa |
| `size` | Dimensione dell'avatar | `xs`, `sm`, `md`, `lg`, `xl` |
| `class` | Classi CSS aggiuntive | Stringa di classi CSS |

## Dropdown Utente con Alpine.js

, il dropdown utente è implementato utilizzando Alpine.js per la gestione degli stati e delle transizioni. Questo approccio è preferito rispetto all'utilizzo diretto di `x-filament::dropdown` quando si necessita di maggiore controllo sull'interattività e sull'aspetto del dropdown.

### Gestione degli Utenti Autenticati e Non Autenticati

Il componente user-dropdown gestisce sia gli utenti autenticati che quelli non autenticati:

- Per gli utenti autenticati, mostra un dropdown con avatar e opzioni come profilo, impostazioni e logout
- Per gli utenti non autenticati, mostra i link di login e registrazione

Questo comportamento è implementato utilizzando la condizione `@if(auth()->check())` che verifica se l'utente è autenticato.

### Esempio di Implementazione del Dropdown Utente

```blade
@props([
    'user' => null,
])
{{ ... }}
@props([
    'user' => null,
])

@php
    $user = $user ?? auth()->user();
    $locale = LaravelLocalization::getCurrentLocale();
    $isLoggedIn = auth()->check();
@endphp

@if($isLoggedIn)
    {{-- Dropdown per utente loggato --}}
    <div class="relative" x-data="{ open: false }" @click.away="open = false">
        <button
            @click="open = ! open"
            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out"
        >
            <div>
                <x-filament::avatar
                    :src="$user?->profile_photo_url"
                    :alt="$user?->name"
                    size="md"
{{ ... }}
                    name="heroicon-o-chevron-down"
                    class="h-4 w-4"
                />
            </div>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
            style="display: none;"
        >
            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-800">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('auth.user_dropdown.manage_account') }}
                </div>

                <a href="/{{ $locale }}/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                        <x-filament::icon
                            name="heroicon-o-user"
                            class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500"
                        />
                        <span>{{ __('auth.user_dropdown.profile') }}</span>
                    </div>
                </a>

                <a href="/{{ $locale }}/settings" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                        <x-filament::icon
                            name="heroicon-o-cog-6-tooth"
                            class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500"
                        />
                        <span>{{ __('auth.user_dropdown.settings') }}</span>
                    </div>
                </a>

                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                <!-- Authentication -->
                <form method="POST" action="/{{ $locale }}/auth/logout">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <x-filament::icon
                                name="heroicon-o-arrow-right-on-rectangle"
                                class="mr-3 h-5 w-5 text-red-500 dark:text-red-400"
                            />
                            <span>{{ __('auth.user_dropdown.logout') }}</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    {{-- Link di login/register per utente non loggato --}}
    <div class="flex items-center space-x-4">
        <a href="/{{ $locale }}/auth/login" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition duration-150 ease-in-out">
            {{ __('auth.login.title') }}
        </a>
        <a href="/{{ $locale }}/auth/register" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-500 dark:hover:text-primary-400 transition duration-150 ease-in-out">
            {{ __('auth.register.title') }}
        </a>
    </div>
@endif
```

## Pagine Volt e Folio

Quando si utilizzano Volt e Folio insieme, è importante seguire alcune regole specifiche per evitare errori.

### Struttura Corretta di una Pagina Volt in Folio

```blade
@php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('page-name');
@endphp

@volt
<?php
use Illuminate\Support\Facades\Auth;

$this->layout('layouts.main', [
    'title' => __('page.title')
]);

$this->mount(function () {
    // Logica di inizializzazione
});

// Altre funzioni Volt
?>

<!-- Contenuto HTML della pagina -->
<div class="container">
    <!-- Contenuto della pagina -->
</div>
@endvolt
```

### Regole Importanti per Volt e Folio

1. **Direttiva @volt obbligatoria**: Quando si utilizzano componenti Volt anonimi in pagine Folio, la direttiva `@volt` è obbligatoria
2. **Layout tramite $this->layout()**: Utilizzare `$this->layout()` invece di wrappare il contenuto in un componente layout
3. **Mount tramite $this->mount()**: Utilizzare `$this->mount()` per la logica di inizializzazione
4. **Separazione delle direttive PHP**: Utilizzare `@php` per le direttive Folio e `<?php` all'interno di `@volt` per la logica Volt

## Gestione delle Traduzioni

Le traduzioni per il dropdown utente sono definite nei file di traduzione di Laravel sotto il namespace `auth.user_dropdown`. È importante seguire lo standard di <nome progetto> per le traduzioni, utilizzando sempre le chiavi di traduzione appropriate e mantenendo la coerenza tra le diverse lingue.

### Struttura delle Traduzioni

```php
// /laravel/Modules/Lang/lang/it/auth.php

// Traduzioni per il dropdown utente
'user_dropdown' => [
    'manage_account' => 'Gestisci Account',
    'profile' => 'Profilo',
    'settings' => 'Impostazioni',
    'logout' => 'Disconnetti',
],

// Traduzioni per login/register utilizzate anche nel dropdown
'login' => [
    'title' => 'Accedi al tuo account',
    // ...
    'link' => 'Accedi',  // Utilizzato nel dropdown utente
],

'register' => [
    'title' => 'Crea un nuovo account',
    // ...
    'link' => 'Registrati',  // Utilizzato nel dropdown utente
],
```

### Utilizzo delle Traduzioni nel Componente

```blade
<!-- Per utenti autenticati -->
<span>{{ __('auth.user_dropdown.profile') }}</span>

<!-- Per utenti non autenticati -->
<a href="/{{ $locale }}/auth/login">
    {{ __('auth.login.link') }}
</a>
```

### Convenzioni di Naming

Seguire queste convenzioni per le chiavi di traduzione:

1. Utilizzare il namespace appropriato (`auth.user_dropdown` per il dropdown utente)
2. Utilizzare nomi descrittivi e coerenti per le chiavi
3. Utilizzare snake_case per le chiavi di traduzione
4. Mantenere la coerenza tra le diverse lingue

## Best Practices

1. **Utilizzare sempre la localizzazione per i testi**: Utilizzare `{{ __('auth.user_dropdown.profile') }}` invece di `{{ __('Profile') }}`
2. **Gestire sia gli utenti loggati che non loggati**: Utilizzare `@if(auth()->check())` per mostrare contenuti diversi in base allo stato di autenticazione
3. **Utilizzare Alpine.js per l'interattività**: Utilizzare `x-data`, `x-show`, `@click` e altre direttive Alpine per gestire l'interattività del dropdown
4. **Includere la localizzazione negli URL**: Utilizzare `LaravelLocalization::getCurrentLocale()` per includere la lingua corrente negli URL
5. **Utilizzare gli attributi nullable**: Utilizzare `$user?->profile_photo_url` invece di `$user->profile_photo_url` per evitare errori se l'utente è null
6. **Evitare componenti non disponibili**: Non utilizzare componenti che non sono disponibili in Filament come `x-filament::dropdown.list.separator` o `filament::layouts.card`
7. **Utilizzare percorsi assoluti con localizzazione**: Utilizzare `/{{ $locale }}/profile` invece di route named come `{{ route('profile.show') }}` a meno che non siano esplicitamente definite

## Errori Comuni da Evitare

1. **Utilizzo di componenti non esistenti**: `x-filament::dropdown.list.separator` non esiste, utilizzare `<div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>` invece
2. **Riferimento a route non definite**: Utilizzare percorsi assoluti con la lingua corrente, ad esempio `/{{ $locale }}/profile` invece di `{{ route('profile.show') }}`
3. **Utilizzo di componenti layout non disponibili**: `filament::layouts.card` non esiste, utilizzare componenti disponibili o creare un componente personalizzato
4. **Mancata gestione degli utenti non autenticati**: Non mostrare il dropdown utente se l'utente non è autenticato
5. **Mancata inclusione della localizzazione negli URL**: Includere sempre la lingua corrente negli URL per supportare il multilinguismo
6. **Mancanza della direttiva @volt**: Quando si utilizzano componenti Volt anonimi in pagine Folio, la direttiva `@volt` è obbligatoria
7. **Utilizzo di layout nidificati**: Non utilizzare `<x-layouts.main>` all'interno di una pagina Volt, utilizzare invece `$this->layout('layouts.main')`

## Riferimenti

- [Documentazione Filament - Avatar](https://filamentphp.com/docs/3.x/support/blade-components/avatar)
- [Documentazione Filament - Dropdown](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Documentazione Filament - Loading Indicator](https://filamentphp.com/docs/3.x/support/blade-components/loading-indicator)
- [Heroicons](https://heroicons.com/)
- [Tailwind CSS](https://tailwindcss.com/)
