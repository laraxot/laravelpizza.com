# Configurazione Localizzazione

## Pacchetti Utilizzati
- `mcamara/laravel-localization`: Gestione multilingua
- `spatie/laravel-translatable`: Traduzioni nel database

## File di Configurazione

### 1. config/app.php
```php
return [
    'locale' => 'it',
    'fallback_locale' => 'it',
    'available_locales' => ['it', 'en'],
];
```

### 2. config/laravellocalization.php
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
    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,
];
```

## Errori Comuni

### UnsupportedLocaleException
- **Causa**: La locale di default in `app.locale` non è presente in `laravellocalization.supportedLocales`
- **Soluzione**: Assicurarsi che la locale di default sia presente in `supportedLocales`
- **Prevenzione**: Verificare sempre la coerenza tra le configurazioni

### Best Practices
1. **Configurazione**:
   - Mantenere sincronizzate le configurazioni
   - Usare le stesse lingue in tutti i file
   - Definire sempre una lingua di fallback

2. **ServiceProvider**:
   - Verificare le configurazioni all'avvio
   - Gestire gli errori di configurazione
   - Loggare problemi di localizzazione

3. **Middleware**:
   - Usare `LocaleMiddleware`
   - Gestire il redirect delle lingue
   - Mantenere la coerenza URL

## Implementazione

### ServiceProvider
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalizationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $defaultLocale = config('app.locale');
        $supportedLocales = config('laravellocalization.supportedLocales');

        if (!isset($supportedLocales[$defaultLocale])) {
            throw new UnsupportedLocaleException(
                "La lingua predefinita '$defaultLocale' non è supportata. ".
                "Aggiungerla in config/laravellocalization.php"
            );
        }
    }
}
```

### Middleware
```php
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
    ],
], function () {
    // Route localizzate
});
```

## Note Importanti
1. **Configurazione**:
   - Verificare sempre la coerenza tra i file
   - Mantenere aggiornate le lingue supportate
   - Gestire correttamente i fallback

2. **Manutenzione**:
   - Aggiornare regolarmente le traduzioni
   - Verificare le configurazioni
   - Testare tutte le lingue

3. **Performance**:
   - Cachare le traduzioni
   - Ottimizzare i caricamenti
   - Gestire la memoria

4. **Sicurezza**:
   - Validare gli input multilingua
   - Sanitizzare le traduzioni
   - Proteggere da XSS 