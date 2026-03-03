# Integrazione di mcamara/laravel-localization

Questo documento descrive come integrare e configurare il pacchetto `mcamara/laravel-localization` nel progetto <nome progetto>.

## Panoramica

Il pacchetto `mcamara/laravel-localization` fornisce un sistema avanzato per la gestione delle lingue in applicazioni Laravel, con supporto a:

- Gestione delle route localizzate
- Middleware per il rilevamento della lingua
- Supporto a domini personalizzati per lingua
- Generazione di URL localizzati
- Supporto a sessioni e cookie per la persistenza della lingua

## Configurazione Richiesta

### 1. Installazione

```bash
composer require mcamara/laravel-localization
```

### 2. Pubblicare i file di configurazione

```bash
php artisan vendor:publish --provider="Mcamara\\LaravelLocalization\\LaravelLocalizationServiceProvider"
```

### 3. Aggiornare la configurazione

Aggiornare `config/laravellocalization.php` con le seguenti impostazioni:

```php
return [
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
    'hideDefaultLocaleInURL' => false,
    'useAcceptLanguageHeader' => true,
    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
```

## Integrazione con il Modulo Lang

### 1. Aggiornamento del Service Provider

Aggiornare `LangServiceProvider` per integrare la gestione delle lingue:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

public function boot()
{
    // ...
    
    // Aggiungere middleware per la gestione delle lingue
    $this->app->singleton('localization.redirect', function ($app) {
        return new \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter($app['router']);
    });
    
    $this->app->singleton('localization.view-path', function ($app) {
        return new \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath($app['router']);
    });
}
```

### 2. Middleware

Aggiungere i middleware al kernel HTTP in `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ],
];
```

## Utilizzo nelle Viste

### Generazione di URL Localizzati

```php
// URL nella lingua corrente
{{ LaravelLocalization::getLocalizedURL() }}

// URL in una lingua specifica
{{ LaravelLocalization::getLocalizedURL('en') }}

// Link per il cambio lingua
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

## Best Practices

1. **Struttura delle Cartelle**
   - Organizzare le traduzioni in `resources/lang/{locale}`
   - Utilizzare sottocartelle per i moduli (es: `resources/lang/it/patient/`)

2. **Gestione delle Route**
   ```php
   Route::group([
       'prefix' => LaravelLocalization::setLocale(),
       'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
   ], function() {
       // Le tue route qui
   });
   ```

3. **Middleware Personalizzati**
   Creare middleware personalizzati per gestire la logica specifica del dominio.

## Monitoraggio e Manutenzione

- Monitorare le traduzioni mancanti con `php artisan translation:show`
- Utilizzare i comandi Artisan per la gestione delle traduzioni
- Implementare test automatici per verificare la presenza di chiavi di traduzione mancanti

## Risoluzione dei Problemi

### Problemi Comuni

1. **Route non Trovate**
   - Verificare che il middleware di localizzazione sia correttamente configurato
   - Controllare che il prefisso delle route corrisponda alla configurazione

2. **Lingua non Cambia**
   - Verificare la presenza del cookie di sessione
   - Controllare che il middleware di sessione sia abilitato

3. **Prestazioni**
   - Abilitare la cache delle traduzioni in produzione
   - Utilizzare Redis per la gestione della sessione

## Riferimenti

- [Documentazione Ufficiale](https://github.com/mcamara/laravel-localization)
- [Laravel Localization su Laravel News](https://laravel-news.com/package/mcamara-laravel-localization)
- [Guida all'Implementazione](https://laraveldaily.com/lesson/multi-language-laravel/mcamara-laravel-localization)
