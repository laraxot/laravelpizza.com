# Performance

## Pacchetti Utilizzati

### Caching
- [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache)
  - Caching delle risposte HTTP
  - Gestione cache per utenti
  - Invalido cache automatico

### Ottimizzazione Immagini
- [spatie/laravel-image-optimizer](https://github.com/spatie/laravel-image-optimizer)
  - Ottimizzazione automatica immagini
  - Supporto vari formati
  - Configurazione flessibile

## Implementazione

### Response Cache
```php
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::middleware(CacheResponse::class)->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/blog', 'BlogController@index');
});
```

### Image Optimizer
```php
use Spatie\ImageOptimizer\OptimizerChainFactory;

$optimizerChain = OptimizerChainFactory::create();
$optimizerChain->optimize($pathToImage);
```

## Best Practices

### Caching
1. Implementare strategie di cache appropriate
2. Utilizzare tag per invalidazione precisa
3. Monitorare hit/miss ratio

### Immagini
1. Ottimizzare al caricamento
2. Utilizzare formati moderni (WebP)
3. Implementare lazy loading

## Performance

### Metriche
- Tempo di risposta
- Utilizzo memoria
- CPU usage
- Database queries

### Ottimizzazioni
- Implementare CDN
- Utilizzare HTTP/2
- Minificare assets
- Implementare compressione

## Monitoring

### Tools
- Laravel Telescope
- New Relic
- Blackfire
- Laravel Debugbar

### Alerting
- Configurare threshold
- Implementare notifiche
- Monitorare trend

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Gestione Contenuti](content-management.md)
- [SEO](seo.md) 
