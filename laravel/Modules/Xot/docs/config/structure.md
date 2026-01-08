# Struttura delle Configurazioni

Questo documento definisce la struttura standard delle configurazioni per tutti i moduli.

## Principi Base

1. **Separazione delle Configurazioni**
   - Ogni modulo ha il suo file di configurazione
   - Le configurazioni sono organizzate per contesto
   - Evitare duplicazioni tra moduli

2. **Variabili d'Ambiente**
   - Usare `.env` per valori sensibili
   - Prefissare le variabili con il nome del modulo
   - Fornire valori di default sicuri

3. **Validazione**
   - Validare tutte le configurazioni
   - Segnalare errori in modo chiaro
   - Fornire suggerimenti per la correzione

## Struttura Standard

```php
return [
    // Configurazioni di base
    'name' => env('MODULE_NAME', 'default'),
    'enabled' => env('MODULE_ENABLED', true),
    
    // Cache
    'cache' => [
        'enabled' => env('MODULE_CACHE_ENABLED', true),
        'ttl' => env('MODULE_CACHE_TTL', 3600),
        'driver' => env('MODULE_CACHE_DRIVER', 'redis'),
        'prefix' => env('MODULE_CACHE_PREFIX', 'module_'),
    ],
    
    // Storage
    'storage' => [
        'disk' => env('MODULE_STORAGE_DISK', 'local'),
        'path' => env('MODULE_STORAGE_PATH', 'module'),
        'allowed_types' => [
            'jpg', 'jpeg', 'png', 'gif', 'pdf',
        ],
        'max_size' => env('MODULE_STORAGE_MAX_SIZE', 10240),
    ],
    
    // API
    'api' => [
        'prefix' => env('MODULE_API_PREFIX', 'api/module'),
        'middleware' => [
            'api',
            'auth:sanctum',
        ],
        'throttle' => [
            'enabled' => true,
            'attempts' => 60,
            'minutes' => 1,
        ],
    ],
    
    // Database
    'database' => [
        'prefix' => env('MODULE_DB_PREFIX', 'module_'),
        'connection' => env('MODULE_DB_CONNECTION', null),
        'soft_deletes' => true,
    ],
    
    // Views
    'views' => [
        'namespace' => 'module',
        'path' => resource_path('views/vendor/module'),
        'cache' => [
            'enabled' => env('MODULE_VIEW_CACHE', true),
            'path' => storage_path('framework/views'),
        ],
    ],
];
```

## Validazione delle Configurazioni

```php
namespace Modules\Module\Support;

class ConfigValidator
{
    public function validate(): ValidationResult
    {
        $config = config('module');
        
        $rules = [
            'name' => 'required|string',
            'enabled' => 'required|boolean',
            'cache.enabled' => 'required|boolean',
            'cache.ttl' => 'required|integer|min:0',
            // ... altre regole
        ];
        
        $validator = Validator::make($config, $rules);
        
        return new ValidationResult($validator);
    }
}
```

## Best Practices

1. **Naming**
   - Usare nomi descrittivi
   - Seguire convenzioni Laravel
   - Mantenere coerenza tra moduli

2. **Organizzazione**
   - Raggruppare configurazioni correlate
   - Usare commenti esplicativi
   - Mantenere file leggibili

3. **Sicurezza**
   - Non esporre dati sensibili
   - Validare input utente
   - Limitare accessi

4. **Performance**
   - Cachare valori quando possibile
   - Minimizzare query al database
   - Ottimizzare caricamento

## Pubblicazione

```bash
php artisan vendor:publish --tag=module-config
```

## Override

```php
// config/module.php
return array_merge(require __DIR__.'/../vendor/module/config/module.php', [
    'custom_option' => 'value',
]);
```

## Collegamenti

- [Architettura](../architecture/module-structure.md)
- [Best Practices](../BEST-PRACTICES.md)
- [Sicurezza](../security/README.md)
- [Performance](../performance/README.md) 

## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](../../../Gdpr/docs/structure.md)
* [structure.md](../../../Notify/docs/structure.md)
* [structure.md](../../../Xot/docs/structure.md)
* [structure.md](../../../Xot/docs/base/structure.md)
* [structure.md](../../../Xot/docs/config/structure.md)
* [structure.md](../../../User/docs/structure.md)
* [structure.md](../../../UI/docs/structure.md)
* [structure.md](../../../Lang/docs/structure.md)
* [structure.md](../../../Job/docs/structure.md)
* [structure.md](../../../Media/docs/structure.md)
* [structure.md](../../../Tenant/docs/structure.md)
* [structure.md](../../../Activity/docs/structure.md)
* [structure.md](../../../Cms/docs/structure.md)
* [structure.md](../../../Cms/docs/themes/structure.md)
* [structure.md](../../../Cms/docs/components/structure.md)

