# Guida all'Implementazione di mcamara/laravel-localization

## Indice
1. [Panoramica](#panoramica)
2. [Installazione](#installazione)
3. [Configurazione](#configurazione)
4. [Gestione delle Route](#gestione-delle-route)
5. [Interruttore di Lingua](#interruttore-di-lingua)
6. [Traduzione delle Route](#traduzione-delle-route)
7. [Gestione della Cache](#gestione-della-cache)
8. [Risoluzione dei Problemi](#risoluzione-dei-problemi)
9. [Best Practice](#best-practice)

## Panoramica

Il pacchetto `mcamara/laravel-localization` fornisce un sistema completo per la gestione della localizzazione in Laravel, con particolare attenzione alla traduzione delle route e alla gestione delle lingue.

## Installazione

1. Installa il pacchetto tramite Composer:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. Pubblica i file di configurazione:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. Registra i middleware in `app/Http/Kernel.php`:
   ```php
   protected $middleware = [
       // ...
       \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
       \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
       \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
       \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
   ];
   ```

## Configurazione

Modifica `config/laravellocalization.php` per definire le lingue supportate:

```php
'supportedLocales' => [
    'it' => [
        'name' => 'Italiano',
        'script' => 'Latn',
        'native' => 'Italiano',
        'regional' => 'it_IT',
    ],
    'en' => [
        'name' => 'English',
        'script' => 'Latn',
        'native' => 'English',
        'regional' => 'en_GB',
    ],
],

// Nascondi la lingua predefinita nell'URL
'hideDefaultLocaleInURL' => true,
```

## Gestione delle Route

Raggruppa le tue route web con il prefisso della lingua:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    // Le tue route qui
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
```

## Interruttore di Lingua

Aggiungi un selettore di lingua alla tua vista:

```blade
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a rel="alternate" hreflang="{{ $localeCode }}" 
       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
       class="{{ $localeCode === app()->getLocale() ? 'active' : '' }}">
        {{ strtoupper($localeCode) }}
    </a>
@endforeach
```

## Traduzione delle Route

1. Attiva il middleware `localize` nel gruppo di route:
   ```php
   'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
   ```

2. Crea i file di traduzione per le route in `resources/lang/{locale}/routes.php`:
   ```php
   // resources/lang/it/routes.php
   return [
       'about' => 'chi-siamo',
       'contact' => 'contatti',
   ];
   ```

3. Usa le route tradotte:
   ```php
   Route::get(LaravelLocalization::transRoute('routes.about'), [AboutController::class, 'index']);
   ```

## Gestione della Cache

Per la cache delle route, utilizza i comandi dedicati:

```bash
# Cache delle route tradotte
php artisan route:trans:cache

# Pulizia della cache
php artisan route:trans:clear

# Visualizza le route tradotte
php artisan route:trans:list it
```

## Risoluzione dei Problemi

### Livewire e Route Localizzate

Per risolvere i problemi con Livewire, aggiungi nel `AppServiceProvider`:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\Livewire;

public function boot()
{
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle)
            ->middleware('web')
            ->prefix(LaravelLocalization::setLocale());
    });
}
```

### Route API

Per le route API, crea un gruppo separato senza middleware di localizzazione:

```php
Route::prefix('api')->group(function () {
    Route::post('/queue-check', [QueueController::class, 'check']);
});
```

## Best Practice

1. **Struttura delle Cartelle**
   - Mantieni le traduzioni in `resources/lang/{locale}/`
   - Organizza le traduzioni per modulo/funzionalità

2. **Gestione delle Chiavi**
   - Usa nomi descrittivi per le chiavi di traduzione
   - Raggruppa le chiavi correlate
   - Documenta le chiavi di traduzione

3. **Performance**
   - Abilita la cache in produzione
   - Usa `route:trans:cache` invece di `route:cache`
   - Monitora le traduzioni mancanti

4. **Manutenzione**
   - Aggiorna regolarmente il pacchetto
   - Verifica le traduzioni mancanti
   - Esegui test sulle diverse lingue

## Riferimenti

- [Documentazione Ufficiale](https://github.com/mcamara/laravel-localization)
- [Laravel Daily Tutorial](https://laraveldaily.com/lesson/multi-language-laravel/mcamara-laravel-localization)
