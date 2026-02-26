# Colli di Bottiglia e Soluzioni - Modulo Xot

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Xot e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Caricamento Eccessivo di Service Provider

### Problema
Il modulo Xot carica automaticamente tutti i service provider di tutti i moduli, causando un overhead significativo durante l'avvio dell'applicazione.

### Impatto
- Aumento del tempo di bootstrap dell'applicazione
- Maggiore utilizzo di memoria
- Caricamento di servizi non necessari per ogni richiesta

### Soluzione Passo-Passo

1. **Implementare Lazy Loading dei Service Provider**

```php
// Modifica XotServiceProvider.php
public function register(): void
{
    // Prima
    foreach ($this->app['modules']->allEnabled() as $module) {
        $this->loadServiceProviderFrom($module);
    }
    
    // Dopo
    $this->app->extend('modules.handler', function ($handler, $app) {
        return new LazyModuleHandler($handler, $app);
    });
}
```

2. **Creare LazyModuleHandler**

```php
namespace Modules\Xot\Handlers;

class LazyModuleHandler
{
    protected $originalHandler;
    protected $app;
    protected $loadedModules = [];
    
    public function __construct($originalHandler, $app)
    {
        $this->originalHandler = $originalHandler;
        $this->app = $app;
    }
    
    public function loadModuleProviders($moduleName)
    {
        if (isset($this->loadedModules[$moduleName])) {
            return;
        }
        
        $module = $this->originalHandler->find($moduleName);
        if ($module) {
            $this->app['xot.service-provider-loader']->loadFrom($module);
            $this->loadedModules[$moduleName] = true;
        }
    }
}
```

3. **Modificare il Middleware per Caricare i Provider Necessari**

```php
namespace Modules\Xot\Http\Middleware;

class LoadModuleProviders
{
    public function handle($request, Closure $next)
    {
        // Determina quali moduli sono necessari per questa richiesta
        $modulesToLoad = $this->getRequiredModules($request);
        
        foreach ($modulesToLoad as $module) {
            app('modules.handler')->loadModuleProviders($module);
        }
        
        return $next($request);
    }
    
    protected function getRequiredModules($request)
    {
        // Logica per determinare quali moduli sono necessari
        // basata sul percorso della richiesta o altri fattori
    }
}
```

4. **Registrare il Middleware**

```php
// In app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Modules\Xot\Http\Middleware\LoadModuleProviders::class,
    ],
];
```

5. **Misurare i Miglioramenti**

```bash

# Prima dell'ottimizzazione
php artisan xot:benchmark bootstrap

# Dopo l'ottimizzazione
php artisan xot:benchmark bootstrap
```

## 2. Query N+1 nei Repository

### Problema
I repository nel modulo Xot spesso generano query N+1 quando recuperano entità con relazioni.

### Impatto
- Rallentamento significativo delle pagine con molte entità
- Carico eccessivo sul database
- Timeout nelle richieste complesse

### Soluzione Passo-Passo

1. **Identificare le Query N+1**

```bash

# Installare Clockwork per il debug
composer require itsgoingd/clockwork --dev

# Analizzare le query eseguite

# Cercare pattern ripetitivi di query simili
```

2. **Implementare Eager Loading nei Repository Base**

```php
// Modifica BaseRepository.php
public function find($id, array $columns = ['*'])
{
    // Prima
    return $this->model->find($id, $columns);
    
    // Dopo
    $query = $this->model->newQuery();
    
    // Carica automaticamente le relazioni definite nel modello
    if (method_exists($this->model, 'getDefaultEagerLoadRelations')) {
        $relations = $this->model->getDefaultEagerLoadRelations();
        if (!empty($relations)) {
            $query->with($relations);
        }
    }
    
    return $query->find($id, $columns);
}
```

3. **Definire Relazioni Default nei Modelli**

```php
// Aggiungi a BaseModel.php
public function getDefaultEagerLoadRelations(): array
{
    return $this->defaultEagerLoadRelations ?? [];
}

// Implementazione nei modelli specifici
class Article extends BaseModel
{
    protected $defaultEagerLoadRelations = ['author', 'categories', 'tags'];
}
```

4. **Ottimizzare i Metodi All() e Get()**

```php
// Modifica BaseRepository.php
public function all(array $columns = ['*'])
{
    $query = $this->model->newQuery();
    
    if (method_exists($this->model, 'getDefaultEagerLoadRelations')) {
        $relations = $this->model->getDefaultEagerLoadRelations();
        if (!empty($relations)) {
            $query->with($relations);
        }
    }
    
    return $query->get($columns);
}
```

5. **Implementare Chunk Processing per Dataset Grandi**

```php
// Aggiungi a BaseRepository.php
public function processAll(callable $callback, int $chunkSize = 100)
{
    $this->model->chunk($chunkSize, function ($items) use ($callback) {
        foreach ($items as $item) {
            $callback($item);
        }
    });
}
```

6. **Creare un Comando Artisan per Analizzare le Query**

```php
// Crea un nuovo comando
php artisan make:command AnalyzeQueryPerformance

// Implementazione
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AnalyzeQueryPerformance extends Command
{
    protected $signature = 'xot:analyze-queries {route}';
    
    public function handle()
    {
        DB::enableQueryLog();
        
        // Simula una richiesta alla route specificata
        $this->call('route:call', ['uri' => $this->argument('route')]);
        
        $queries = DB::getQueryLog();
        
        // Analizza le query per trovare pattern N+1
        $this->analyzeForNPlusOne($queries);
    }
    
    protected function analyzeForNPlusOne(array $queries)
    {
        // Logica per identificare query N+1
    }
}
```

## 3. Cache Inefficiente

### Problema
Il modulo Xot utilizza la cache in modo inefficiente, con chiavi di cache troppo generiche e strategie di invalidazione non ottimali.

### Impatto
- Invalidazione eccessiva della cache
- Cache miss frequenti
- Overhead di memoria per oggetti in cache troppo grandi

### Soluzione Passo-Passo

1. **Implementare Cache Tags**

```php
// Prima
Cache::remember('all_settings', 3600, function () {
    return Setting::all();
});

// Dopo
Cache::tags(['settings'])->remember('all_settings', 3600, function () {
    return Setting::all();
});
```

2. **Creare un CacheService Centralizzato**

```php
namespace Modules\Xot\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function rememberModel($model, $id, $duration = 3600)
    {
        $class = get_class($model);
        $key = strtolower(class_basename($class)) . "_{$id}";
        
        return Cache::tags([$this->getModelTag($class)])->remember($key, $duration, function () use ($model, $id) {
            return $model->find($id);
        });
    }
    
    public function invalidateModel($model)
    {
        Cache::tags([$this->getModelTag(get_class($model))])->flush();
    }
    
    protected function getModelTag($class)
    {
        return strtolower(str_replace('\\', '_', $class));
    }
}
```

3. **Implementare Observer per Invalidazione Automatica**

```php
namespace Modules\Xot\Observers;

use Modules\Xot\Services\CacheService;

class ModelCacheObserver
{
    protected $cacheService;
    
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    
    public function saved($model)
    {
        $this->cacheService->invalidateModel($model);
    }
    
    public function deleted($model)
    {
        $this->cacheService->invalidateModel($model);
    }
}
```

4. **Registrare l'Observer nei Modelli**

```php
// In XotServiceProvider.php
public function boot()
{
    // ...
    $this->registerModelObservers();
}

protected function registerModelObservers()
{
    $models = config('xot.cacheable_models', []);
    
    foreach ($models as $model) {
        $model::observe(ModelCacheObserver::class);
    }
}
```

5. **Configurare i Modelli Cacheabili**

```php
// In config/xot.php
'cacheable_models' => [
    \Modules\Xot\Models\Setting::class,
    \Modules\User\Models\User::class,
    // Altri modelli frequentemente acceduti
],
```

6. **Implementare Cache Granulare per Queries Complesse**

```php
// Aggiungi a BaseRepository.php
public function findWithCache($id, $duration = 3600)
{
    $cacheKey = $this->getCacheKey('find', $id);
    
    return Cache::tags([$this->getCacheTag()])->remember($cacheKey, $duration, function () use ($id) {
        return $this->find($id);
    });
}

protected function getCacheKey($method, ...$args)
{
    return sprintf(
        '%s_%s_%s',
        $this->getCacheTag(),
        $method,
        md5(serialize($args))
    );
}

protected function getCacheTag()
{
    return strtolower(class_basename($this->model));
}
```

## 4. Gestione Inefficiente delle Risorse Frontend

### Problema
Il modulo Xot carica tutte le risorse JavaScript e CSS in ogni pagina, indipendentemente da quali siano effettivamente necessarie.

### Impatto
- Tempi di caricamento pagina aumentati
- Utilizzo eccessivo di banda
- Overhead di parsing JavaScript

### Soluzione Passo-Passo

1. **Implementare Caricamento Condizionale delle Risorse**

```php
// Crea AssetService.php
namespace Modules\Xot\Services;

class AssetService
{
    protected $requiredAssets = [];
    
    public function require($asset)
    {
        $this->requiredAssets[] = $asset;
    }
    
    public function getRequiredScripts()
    {
        $scripts = [];
        foreach ($this->requiredAssets as $asset) {
            if (isset(config('xot.assets.scripts')[$asset])) {
                $scripts[] = config('xot.assets.scripts')[$asset];
            }
        }
        return $scripts;
    }
    
    public function getRequiredStyles()
    {
        $styles = [];
        foreach ($this->requiredAssets as $asset) {
            if (isset(config('xot.assets.styles')[$asset])) {
                $styles[] = config('xot.assets.styles')[$asset];
            }
        }
        return $styles;
    }
}
```

2. **Definire Asset per Componente**

```php
// In config/xot.php
'assets' => [
    'scripts' => [
        'datepicker' => 'js/datepicker.js',
        'chart' => 'js/chart.js',
        'editor' => 'js/editor.js',
    ],
    'styles' => [
        'datepicker' => 'css/datepicker.css',
        'chart' => 'css/chart.css',
        'editor' => 'css/editor.css',
    ],
],
```

3. **Creare Blade Directive per Richiedere Asset**

```php
// In XotServiceProvider.php
public function boot()
{
    // ...
    Blade::directive('requireAsset', function ($expression) {
        return "<?php app('xot.asset-service')->require($expression); ?>";
    });
}
```

4. **Utilizzare la Directive nei Template**

```blade
@requireAsset('datepicker')
@requireAsset('chart')

{{-- Nel layout principale --}}
@foreach(app('xot.asset-service')->getRequiredScripts() as $script)
    <script src="{{ asset($script) }}"></script>
@endforeach

@foreach(app('xot.asset-service')->getRequiredStyles() as $style)
    <link rel="stylesheet" href="{{ asset($style) }}">
@endforeach
```

5. **Implementare Bundling Dinamico con Vite/Webpack**

```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Core assets sempre inclusi
                'resources/css/app.css',
                'resources/js/app.js',
                
                // Asset modulari
                'resources/js/modules/datepicker.js',
                'resources/js/modules/chart.js',
                'resources/js/modules/editor.js',
                
                'resources/css/modules/datepicker.css',
                'resources/css/modules/chart.css',
                'resources/css/modules/editor.css',
            ],
            refresh: true,
        }),
    ],
});
```

6. **Creare un Helper per Vite Assets**

```php
// In Helpers/AssetHelper.php
namespace Modules\Xot\Helpers;

class AssetHelper
{
    public static function moduleScript($name)
    {
        return vite("resources/js/modules/{$name}.js");
    }
    
    public static function moduleStyle($name)
    {
        return vite("resources/css/modules/{$name}.css");
    }
}
```

## 5. Operazioni Sincrone Bloccanti

### Problema
Il modulo Xot esegue operazioni pesanti in modo sincrono, bloccando il thread di esecuzione e causando timeout nelle richieste.

### Impatto
- Timeout nelle richieste HTTP
- Esperienze utente degradate
- Utilizzo inefficiente delle risorse del server

### Soluzione Passo-Passo

1. **Identificare Operazioni Pesanti**

```php
// Esempio di operazione pesante
public function generateReport()
{
    // Operazione che richiede molto tempo
    $data = $this->processLargeDataset();
    $this->generatePDF($data);
    $this->sendEmail($pdf);
}
```

2. **Convertire in Jobs in Coda**

```php
// Crea un nuovo job
php artisan make:job GenerateReportJob

// Implementazione
namespace Modules\Xot\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $reportParams;
    
    public function __construct(array $reportParams)
    {
        $this->reportParams = $reportParams;
    }
    
    public function handle()
    {
        $data = $this->processLargeDataset();
        $pdf = $this->generatePDF($data);
        $this->sendEmail($pdf);
    }
    
    // Metodi helper...
}
```

3. **Dispatch del Job invece di Esecuzione Sincrona**

```php
// Prima
public function generateReport(Request $request)
{
    $this->reportService->generateReport($request->all());
    return response()->json(['status' => 'success']);
}

// Dopo
public function generateReport(Request $request)
{
    GenerateReportJob::dispatch($request->all());
    return response()->json(['status' => 'success', 'message' => 'Report generation started']);
}
```

4. **Configurare Queue Worker**

```bash

# Aggiungere al Supervisor
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/base_<nome progetto>/laravel/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/html/base_<nome progetto>/laravel/storage/logs/worker.log
```

5. **Implementare Notifiche di Completamento**

```php
// Nel job
public function handle()
{
    $data = $this->processLargeDataset();
    $pdf = $this->generatePDF($data);
    $this->sendEmail($pdf);
    
    // Notifica di completamento
    event(new ReportGenerationCompleted($this->reportParams['user_id'], $pdf));
}

// Listener per l'evento
class SendReportCompletionNotification
{
    public function handle(ReportGenerationCompleted $event)
    {
        $user = User::find($event->userId);
        $user->notify(new ReportReadyNotification($event->pdfPath));
    }
}
```

6. **Aggiungere Monitoraggio delle Code**

```bash

# Installare Horizon per monitoraggio avanzato
composer require laravel/horizon

# Pubblicare la configurazione
php artisan horizon:install

# Configurare Horizon

# In config/horizon.php
```

## Conclusione

Implementando queste soluzioni, il modulo Xot potrà superare i principali colli di bottiglia e migliorare significativamente le performance dell'applicazione. È consigliabile implementare le soluzioni in modo incrementale, misurando l'impatto di ciascuna modifica per garantire miglioramenti effettivi.

## Collegamenti
- [Roadmap Principale](./roadmap.md)
- [Best Practices Performance](./BEST-PRACTICES.md#performance)
- [Struttura Moduli](./MODULE_STRUCTURE.md)

## Collegamenti tra versioni di BOTTLENECKS.md
* [BOTTLENECKS.md](../../../Xot/project_docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../User/project_docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Media/project_docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Cms/project_docs/BOTTLENECKS.md)

