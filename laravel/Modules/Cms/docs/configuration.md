# Configurazione

Questo documento descrive le opzioni di configurazione disponibili per il modulo CMS.

## File di Configurazione

Il file di configurazione principale è `config/cms.php`. Tutte le opzioni possono essere sovrascritte tramite variabili d'ambiente.

## Opzioni Principali

### Cache

```php
'cache' => [
    // Abilita/disabilita la cache
    'enabled' => env('CMS_CACHE_ENABLED', true),
    
    // Tempo di vita della cache in secondi
    'ttl' => env('CMS_CACHE_TTL', 3600),
    
    // Driver della cache
    'driver' => env('CMS_CACHE_DRIVER', 'redis'),
    
    // Prefisso per le chiavi di cache
    'prefix' => env('CMS_CACHE_PREFIX', 'cms'),
],
```

### Media

```php
'media' => [
    // Disco di storage predefinito
    'disk' => env('CMS_MEDIA_DISK', 'public'),
    
    // Tipi di file permessi
    'allowed_types' => [
        'jpg', 'jpeg', 'png', 'gif', 'pdf',
        'doc', 'docx', 'xls', 'xlsx',
    ],
    
    // Dimensione massima in KB
    'max_size' => env('CMS_MEDIA_MAX_SIZE', 10240),
    
    // Conversioni automatiche
    'conversions' => [
        'thumb' => [
            'width' => 100,
            'height' => 100,
            'fit' => 'crop',
        ],
        'preview' => [
            'width' => 400,
            'height' => 300,
            'fit' => 'contain',
        ],
    ],
],
```

### API

```php
'api' => [
    // Prefisso per le route API
    'prefix' => env('CMS_API_PREFIX', 'api/cms'),
    
    // Middleware predefiniti
    'middleware' => [
        'api',
        'auth:sanctum',
    ],
    
    // Rate limiting
    'throttle' => [
        'enabled' => true,
        'attempts' => 60,
        'minutes' => 1,
    ],
],
```

### Database

```php
'database' => [
    // Prefisso per le tabelle
    'prefix' => env('CMS_DB_PREFIX', 'cms_'),
    
    // Connection predefinita
    'connection' => env('CMS_DB_CONNECTION', null),
    
    // Soft deletes
    'soft_deletes' => true,
],
```

### Views

```php
'views' => [
    // Namespace predefinito
    'namespace' => 'cms',
    
    // Path delle views
    'path' => resource_path('views/vendor/cms'),
    
    // Cache delle views
    'cache' => [
        'enabled' => env('CMS_VIEW_CACHE', true),
        'path' => storage_path('framework/views'),
    ],
],
```

## Personalizzazione

### Override delle Configurazioni

Per sovrascrivere le configurazioni predefinite:

1. Pubblicare il file di configurazione:
```bash
php artisan vendor:publish --tag=cms-config
```

2. Modificare il file `config/cms.php`

3. Utilizzare variabili d'ambiente nel `.env`

### Estensione delle Configurazioni

Per estendere le configurazioni esistenti:

```php
Config::set('cms.custom_option', [
    'key' => 'value',
]);
```

## Validazione

Il modulo include validatori per le configurazioni:

```php
use Modules\Cms\Support\ConfigValidator;

$validator = new ConfigValidator();
$result = $validator->validate();

if (!$result->isValid()) {
    $errors = $result->getErrors();
}
```

## Collegamenti

- [Installazione](installation.md)
- [Architettura](architecture.md)
- [API](api.md)
- [Cache](cache.md) 

## Collegamenti tra versioni di configuration.md
* [configuration.md](docs/configuration.md)
* [configuration.md](laravel/Modules/Xot/docs/configuration.md)
* [configuration.md](laravel/Modules/Cms/docs/configuration.md)

