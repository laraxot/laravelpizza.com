# Activity Module - Errori e Coverage

## Stato Test

- **Test passati**: 203
- **Test falliti**: 28
- **Coverage**: Non disponibile (test falliti)

## Errori Identificati

### 1. Test Falliti - Connessione Database

I test falliscono perché:
- I modelli usano `$connection = 'activity'` 
- La connessione 'activity' non esiste in config/database.php
- TenantServiceProvider dovrebbe crearla a runtime

### 2. Configurazione Coverage

Per ottenere coverage 100%:

```bash
# Con PCOV
php -d pcov.enabled=1 vendor/bin/pest Modules/Activity/tests --coverage

# Con Xdebug
XDEBUG_MODE=coverage vendor/bin/pest Modules/Activity/tests --coverage
```

### 3. phpunit.xml - Configurazione Activity

Aggiungere testsuite dedicata per Activity:

```xml
<testsuite name="Activity">
    <directory>Modules/Activity/tests</directory>
</testsuite>
```

## Prossimi Passi

1. Fixare i 28 test falliti
2. Configurare coverage per solo modulo Activity
3. Raggiungere coverage 100%

## Riferimenti

- [Pest Coverage](https://pestphp.com/docs/test-coverage)
- [Laravel Modules Tests](https://laravelmodules.com/docs/12/advanced/tests)
