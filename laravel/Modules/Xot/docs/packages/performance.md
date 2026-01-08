# Performance

## Pacchetti Utilizzati

### Response Cache
- [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache)
  - Cache risposte
  - Tagging
  - Performance
  - Configurazione dettagliata
  - Integrazione con Filament

### Model States
- [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states)
  - Stati modelli
  - Transizioni
  - Performance
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Response Cache
```php
// config/responsecache.php
return [
    'enabled' => env('RESPONSE_CACHE_ENABLED', true),
    'cache_profile' => \Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests::class,
    'cache_lifetime_in_minutes' => 60 * 24,
    'add_cache_time_header' => env('APP_DEBUG', true),
    'cache_store' => null,
];
```

### Model States
```php
// config/model-states.php
return [
    'states' => [
        'package' => [
            'draft' => \App\States\Package\Draft::class,
            'published' => \App\States\Package\Published::class,
            'archived' => \App\States\Package\Archived::class,
        ],
    ],
];
```

## Utilizzo

### Response Cache
```php
// Cache risposta
ResponseCache::cache([
    'enabled' => true,
    'lifetime' => 60 * 24,
]);

// Pulire cache
ResponseCache::clear();

// Tag cache
ResponseCache::tags(['tag1', 'tag2'])->clear();
```

### Model States
```php
// Impostare stato
$package->state->transitionTo(Published::class);

// Verificare stato
if ($package->state->is(Published::class)) {
    // ...
}

// Transizione
$package->state->transitionTo(Archived::class);
```

## Documentazione Collegata

- [Sviluppo](development.md)
- [Testing](testing.md)
- [Debug](debug.md)
- [Panoramica](../packages.md) 
### Versione HEAD


## Collegamenti tra versioni di performance.md
* [performance.md](laravel/vendor/spatie/laravel-data/docs/advanced-usage/performance.md)
* [performance.md](../../../Xot/docs/features/performance.md)
* [performance.md](../../../Xot/docs/packages/performance.md)
* [performance.md](../../../Xot/docs/roadmap/architecture/performance.md)
* [performance.md](../../../UI/docs/standards/performance.md)
* [performance.md](../../../Lang/docs/packages/performance.md)
* [performance.md](../../../Job/docs/packages/performance.md)
* [performance.md](../../../Cms/docs/frontoffice/performance.md)


### Versione Incoming


---

