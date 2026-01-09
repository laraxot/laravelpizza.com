# Guida Completa a Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` è una soluzione potente per implementare la localizzazione in applicazioni Laravel. Questa guida, basata sul corso di Laravel Daily, fornisce istruzioni dettagliate per l'installazione, la configurazione e l'uso del pacchetto nel progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Installazione

Per installare il pacchetto, seguire questi passaggi:

1. **Installazione del Pacchetto**:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. **Pubblicazione del File di Configurazione**:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. **Registrazione del Middleware**:
   Modificare il file `app/Http/Kernel.php` per aggiungere i middleware necessari:
   ```php
   protected $routeMiddleware = [
       // ...
       'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
       'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
       'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
       'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
       'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
   ];
   ```

## Configurazione delle Route

Per configurare le route con il prefisso della lingua, modificare il file `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    // altre route...
    require __DIR__ . '/auth.php';
});
```

Questo codice:
- Aggiunge il prefisso della lingua agli URL (es. `/en/` o `/es/`).
- Reindirizza l'utente alla lingua corretta se non la sta utilizzando.
- Tenta di indovinare la lingua dell'utente basandosi sulle impostazioni del browser.

## Abilitazione di Diverse Lingue

Modificare il file `config/laravellocalization.php` per abilitare le lingue desiderate:

```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
],
```

## Aggiunta di un Selettore di Lingua

Aggiungere un selettore di lingua alla navigazione dell'applicazione modificando il file `resources/views/layouts/navigation.blade.php`:

```php
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                :active="$localeCode === app()->getLocale()"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ ucfirst($properties['native']) }}
    </x-nav-link>
@endforeach
```

## Correzione della Cache delle Route

Per utilizzare la cache delle route con questo pacchetto, modificare il file `app/Providers/RouteServiceProvider.php`:

```php
class RouteServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    // ...
}
```

Utilizzare i seguenti comandi per la cache delle route:
- Invece di `php artisan route:cache`, usare `php artisan route:trans:cache`.
- Invece di `php artisan route:clear`, usare `php artisan route:trans:clear`.

## Visualizzazione di Tutte le Route

Per visualizzare un elenco dettagliato delle route tradotte, utilizzare:
```bash
php artisan route:trans:list {locale}
```

## Funzionalità Estese del Pacchetto

### Mostrare o Nascondere la Lingua Predefinita nell'URL

Modificare `config/laravellocalization.php` per nascondere la lingua predefinita:

```php
'hideDefaultLocaleInURL' => true,
```

### Ignorare Route Specifiche

Per ignorare la localizzazione di alcune route, aggiungerle a `config/laravellocalization.php`:

```php
'urlsIgnored' => [
    '/queue-check',
],
```

### Traduzione delle Route

Per tradurre le route, aggiungere il middleware `localize` al gruppo di route in `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    // route tradotte...
});
```

Creare file di traduzione per le route in `resources/lang/{locale}/routes.php`. Ad esempio:

- Per l'inglese (`resources/lang/en/routes.php`):
  ```php
  return [
      'dashboard' => 'dashboard',
  ];
  ```

- Per l'italiano (`resources/lang/it/routes.php`):
  ```php
  return [
      'dashboard' => 'cruscotto',
  ];
  ```

Modificare le route per utilizzare la traduzione:

```php
Route::get(LaravelLocalization::transRoute('routes.dashboard'), [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
```

## Problemi con le Route Tradotte

Si noti che il metodo POST non funziona con le route tradotte. Utilizzare `LaravelLocalization::localizeUrl($route)` invece di `route()` per i form POST.

## Integrazione con Livewire

Se si utilizza Livewire, potrebbe essere necessario modificare il file `App/Providers/AppServiceProvider.php` per gestire correttamente gli aggiornamenti:

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
    // ...
}
```

## Conclusione

Il pacchetto `mcamara/laravel-localization` offre un controllo versatile sulla localizzazione delle route. Combinato con la traduzione di testi statici, rende l'applicazione multilingue facile da gestire e user-friendly. Questa guida fornisce tutte le informazioni necessarie per implementare il pacchetto nel progetto `<nome progetto>`, rispettando le convenzioni di localizzazione degli URL e migliorando l'esperienza utente.

## Risorse

- Repository GitHub: [LaravelDaily/laravel11-localization-course](https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/mcamara-laravel-localization)
- Documentazione Ufficiale: [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
