# Implementazione del Logout

## Indice
- [Panoramica](#panoramica)
- [Implementazione Raccomandata](#implementazione-raccomandata)
- [Gestione della Localizzazione](#gestione-della-localizzazione)
- [Componenti Filament](#componenti-filament)
- [Chiavi di Traduzione](#chiavi-di-traduzione)
- [Regole da Seguire](#regole-da-seguire)
- [Esempi di Implementazione](#esempi-di-implementazione)

## Panoramica

Questo documento descrive l'implementazione corretta del processo di logout , utilizzando Livewire Volt, LaravelLocalization e componenti Filament. L'obiettivo è fornire una guida completa per implementare un processo di logout sicuro, user-friendly e conforme alle convenzioni del progetto.

## Implementazione Raccomandata

L'implementazione raccomandata per il logout  utilizza Volt con il metodo `mount()` per gestire il processo di logout in modo automatico e controllato:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    if (Auth::check()) {
        // Dispatch dell'evento prima del logout
        Event::dispatch('auth.logout.attempting', [Auth::user()]);

        // Esegui il logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Dispatch dell'evento dopo il logout
        Event::dispatch('auth.logout.successful');
    }

    // Reindirizza l'utente alla home page localizzata
    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
```

## Gestione della Localizzazione

Per garantire la corretta localizzazione degli URL nel processo di logout, è fondamentale utilizzare le funzioni del pacchetto `mcamara/laravel-localization`:

```php
// ERRATO
$locale = app()->getLocale();
$this->redirect('/' . $locale);

// CORRETTO
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
$this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
```

Questo garantisce che l'utente venga reindirizzato alla versione localizzata della home page dopo il logout, rispettando le convenzioni di <nome progetto> per la gestione della localizzazione.

## Componenti Filament

Il template Blade per il logout deve utilizzare i componenti Filament per garantire coerenza con il resto dell'applicazione:

```blade
<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```

## Chiavi di Traduzione

Le chiavi di traduzione per il logout devono seguire la struttura gerarchica definita nelle best practices di <nome progetto>:

```php
'logout' => [
    'title' => 'Logout in corso...',
    'message' => 'Verrai reindirizzato alla home page.',
    'success_title' => 'Logout effettuato',
    'success_message' => 'Sei stato disconnesso con successo.',
    'error_title' => 'Errore durante il logout',
    'error_message' => 'Si è verificato un errore durante il logout.',
    'back_to_home' => 'Torna alla Home',
],
```

## Regole da Seguire

1. **MAI utilizzare il metodo `->label()` nei componenti Filament**
   - Le etichette sono gestite automaticamente dal LangServiceProvider
   - Utilizzare la struttura espansa per i campi nei file di traduzione

2. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

3. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

4. **Utilizzo Corretto di LaravelLocalization**
   - Utilizzare `LaravelLocalization::getCurrentLocale()` invece di `app()->getLocale()`
   - Utilizzare `LaravelLocalization::getSupportedLocales()` per le lingue supportate
   - Utilizzare `LaravelLocalization::getLocalizedURL()` per generare URL localizzati

5. **Localizzazione degli URL**
   - Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso
   - Utilizzare sempre la funzione `LaravelLocalization::getLocalizedURL()` per generare URL localizzati

## Esempi di Implementazione

### Esempio 1: Logout Semplice con Reindirizzamento

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
?>

<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```

### Esempio 2: Logout con Gestione Eventi

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    if (Auth::check()) {
        $user = Auth::user();

        // Evento pre-logout
        Event::dispatch('auth.logout.attempting', [$user]);

        // Logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Evento post-logout
        Event::dispatch('auth.logout.successful');
    }

    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
?>

<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```
# Implementazione del Logout

## Indice
- [Panoramica](#panoramica)
- [Implementazione Raccomandata](#implementazione-raccomandata)
- [Gestione della Localizzazione](#gestione-della-localizzazione)
- [Componenti Filament](#componenti-filament)
- [Chiavi di Traduzione](#chiavi-di-traduzione)
- [Regole da Seguire](#regole-da-seguire)
- [Esempi di Implementazione](#esempi-di-implementazione)

## Panoramica

Questo documento descrive l'implementazione corretta del processo di logout , utilizzando Livewire Volt, LaravelLocalization e componenti Filament. L'obiettivo è fornire una guida completa per implementare un processo di logout sicuro, user-friendly e conforme alle convenzioni del progetto.

## Implementazione Raccomandata

L'implementazione raccomandata per il logout  utilizza Volt con il metodo `mount()` per gestire il processo di logout in modo automatico e controllato:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    if (Auth::check()) {
        // Dispatch dell'evento prima del logout
        Event::dispatch('auth.logout.attempting', [Auth::user()]);

        // Esegui il logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Dispatch dell'evento dopo il logout
        Event::dispatch('auth.logout.successful');
    }

    // Reindirizza l'utente alla home page localizzata
    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
```

## Gestione della Localizzazione

Per garantire la corretta localizzazione degli URL nel processo di logout, è fondamentale utilizzare le funzioni del pacchetto `mcamara/laravel-localization`:

```php
// ERRATO
$locale = app()->getLocale();
$this->redirect('/' . $locale);

// CORRETTO
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
$this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
```

Questo garantisce che l'utente venga reindirizzato alla versione localizzata della home page dopo il logout, rispettando le convenzioni di <nome progetto> per la gestione della localizzazione.

## Componenti Filament

Il template Blade per il logout deve utilizzare i componenti Filament per garantire coerenza con il resto dell'applicazione:

```blade
<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```

## Chiavi di Traduzione

Le chiavi di traduzione per il logout devono seguire la struttura gerarchica definita nelle best practices di <nome progetto>:

```php
'logout' => [
    'title' => 'Logout in corso...',
    'message' => 'Verrai reindirizzato alla home page.',
    'success_title' => 'Logout effettuato',
    'success_message' => 'Sei stato disconnesso con successo.',
    'error_title' => 'Errore durante il logout',
    'error_message' => 'Si è verificato un errore durante il logout.',
    'back_to_home' => 'Torna alla Home',
],
```

## Regole da Seguire

1. **MAI utilizzare il metodo `->label()` nei componenti Filament**
   - Le etichette sono gestite automaticamente dal LangServiceProvider
   - Utilizzare la struttura espansa per i campi nei file di traduzione

2. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

3. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

4. **Utilizzo Corretto di LaravelLocalization**
   - Utilizzare `LaravelLocalization::getCurrentLocale()` invece di `app()->getLocale()`
   - Utilizzare `LaravelLocalization::getSupportedLocales()` per le lingue supportate
   - Utilizzare `LaravelLocalization::getLocalizedURL()` per generare URL localizzati

5. **Localizzazione degli URL**
   - Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso
   - Utilizzare sempre la funzione `LaravelLocalization::getLocalizedURL()` per generare URL localizzati

## Esempi di Implementazione

### Esempio 1: Logout Semplice con Reindirizzamento

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
?>

<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```

### Esempio 2: Logout con Gestione Eventi

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    if (Auth::check()) {
        $user = Auth::user();

        // Evento pre-logout
        Event::dispatch('auth.logout.attempting', [$user]);

        // Logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Evento post-logout
        Event::dispatch('auth.logout.successful');
    }

    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
?>

<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```
