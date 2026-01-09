# Folio Configuration Troubleshooting

## Issue: "Target class [env] does not exist" Error

### Problem Description
When attempting to run `php artisan folio:list` or other Artisan commands, the following error occurs:
```
Target class [env] does not exist.
Class "env" does not exist
```

### Root Cause Analysis
This error occurs during the Laravel application boot process when the service container attempts to resolve 'env' as a class instead of using the global `env()` helper function. Based on investigation, the issue occurs in the following sequence:

1. `Modules\Cms\Providers\FolioVoltServiceProvider::boot()` calls `TenantService::config('middleware')`
2. The `TenantService::config()` method processes tenant-specific configurations
3. During configuration merging, somewhere in the process, 'env' gets treated as a class name
4. Laravel's service container attempts to instantiate 'env' as a class, causing the error

### Technical Details
The error originates in the TenantService class where configurations are merged between the base Laravel configuration and tenant-specific configurations. When `config('middleware')` is called, the middleware configuration may contain entries that Laravel later tries to resolve as service classes.

The specific line causing the issue is in `Modules/Cms/app/Providers/FolioVoltServiceProvider.php` at boot method:
```php
$middleware = TenantService::config('middleware');
```

### Solution Approach
This indicates a configuration or architectural issue with how tenant configurations are loaded and merged. The solution would involve:

1. Ensuring middleware configurations don't contain invalid class references
2. Properly handling tenant configuration loading to prevent service container conflicts
3. Reviewing the TenantService configuration processing logic

### Impact on Folio Implementation
Until this issue is resolved, Folio routing cannot be properly configured or tested. The `php artisan folio:list` command cannot be used to inspect registered Folio routes, and actual Folio pages may fail to load properly.

### Next Steps
1. Investigate the TenantService configuration merging logic
2. Review middleware configurations in tenant-specific config files
3. Determine if there are configuration values that are being incorrectly processed as class names
4. Implement a fix that allows proper configuration loading without triggering service container resolution issues

### Tentativi di Risoluzione (2025-11-29)
1. ✅ Creato file `config/local/laravelpizza/middleware.php` con struttura corretta
2. ✅ Aggiunto try-catch in `FolioVoltServiceProvider` per gestire errori di configurazione
3. ✅ Disabilitato temporaneamente `FolioVoltServiceProvider` nel `module.json` del modulo Cms
4. ✅ Aggiunto try-catch in `TenantServiceProvider::mergeConfigs()` per gestire errori
5. ✅ Aggiunto try-catch in `XotBaseServiceProvider::register()` per gestire errori di registrazione
6. ❌ Il problema persiste, suggerendo che l'errore si verifica durante il bootstrap, prima che il nostro codice venga eseguito
7. ✅ Workaround pianificato: aggiungere un binding esplicito per `env` nel container (in `App\\Providers\\AppServiceProvider`) in modo che eventuali chiamate errate a `app('env')` risolvano correttamente l'ambiente applicativo invece di generare l'eccezione.

### Scoperta Importante
L'errore si verifica anche quando `GetTenantNameAction` viene risolto direttamente:
```
PHP Fatal error:  Uncaught ReflectionException: Class "config" does not exist
```

Questo suggerisce che il problema potrebbe essere nella risoluzione delle dipendenze durante il bootstrap, non solo nella configurazione middleware.

### Files Involved
- `Modules/Cms/app/Providers/FolioVoltServiceProvider.php`
- `Modules/Tenant/app/Services/TenantService.php`
- `config/local/laravelpizza/middleware.php`
- Laravel's service container (vendor code)

### Date
2025-11-29
