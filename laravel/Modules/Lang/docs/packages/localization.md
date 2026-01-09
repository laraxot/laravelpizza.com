# Localizzazione

## Pacchetti Utilizzati

### Core
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
  - Gestione lingue e traduzioni
  - Routing multilingua
  - Middleware per lingua

## Implementazione

### Configurazione
```php
// config/laravellocalization.php
return [
    'supportedLocales' => [
        'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
    ],
    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,
];
```

### Routing
```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/about', 'AboutController@index');
});
```

## Best Practices

### Lingue
1. Definire lingue supportate in config
2. Implementare fallback language
3. Gestire cambio lingua utente

### URL
1. Utilizzare prefisso lingua in URL
2. Implementare redirect automatici
3. Gestire URL senza prefisso

## Performance

### Ottimizzazioni
- Implementare cache traduzioni
- Ottimizzare query lingua
- Utilizzare CDN per assets

### Monitoring
- Tracciare utilizzo lingue
- Monitorare errori traduzioni
- Analizzare performance routing

## Tools

### Sviluppo
- Laravel Localization
- Laravel Debugbar
- Laravel Telescope

### Testing
- Test traduzioni mancanti
- Test routing multilingua
- Test cambio lingua

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Traduzioni](translations.md)
- [SEO](seo.md) 
