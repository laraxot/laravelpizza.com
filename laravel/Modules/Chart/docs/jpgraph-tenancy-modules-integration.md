# Integrazione di JpGraph con Multi-tenancy e Laravel Modules

## Introduzione

Questo documento descrive come integrare correttamente la libreria JpGraph con le funzionalità di multi-tenancy all'interno di un'applicazione strutturata con Laravel Modules. Questa integrazione è particolarmente rilevante per il progetto Quaeris, dove è necessario generare grafici server-side che rispettino la separazione dei dati tra tenant diversi.

## 1. Architettura di Base

### 1.1 Contesto Multi-tenant con JpGraph

In un sistema multi-tenant, ogni grafico generato deve essere specifico per il tenant corrente. Questo richiede:

1. Filtraggio dei dati per tenant durante la generazione del grafico
2. Sicurezza adeguata per prevenire accessi non autorizzati
3. Gestione corretta delle risorse e dei percorsi file
4. Caching specifico per tenant

### 1.2 Struttura del Modulo Chart

```
Modules/
└── Chart/
    ├── app/
    │   ├── Services/
    │   │   ├── JpGraph/
    │   │   │   ├── JpGraphService.php
    │   │   │   ├── TenantJpGraphService.php
    │   │   │   └── JpGraphGenerator.php
    │   │   └── ChartService.php
    │   ├── Models/
    │   │   └── Chart.php
    │   └── Filament/
    │       └── Widgets/
    │           ├── JpGraphWidget.php
    │           └── TenantJpGraphWidget.php
    ├── config/
    │   └── chart.php
    └── docs/
        └── jpgraph-tenancy-modules-integration.md
```

## 2. Implementazione del Servizio JpGraph Multi-tenant

### 2.1 Servizio Base per JpGraph

```php
<?php

namespace Modules\Chart\Services\JpGraph;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JpGraphService
{
    protected Model $tenant;

    public function __construct(Model $tenant = null)
    {
        $this->tenant = $tenant ?? app('currentTenant');
    }

    /**
     * Genera un grafico usando JpGraph
     */
    public function generateChart(array $data, string $type = 'line', array $options = []): string
    {
        // Determina il percorso di output basato sul tenant
        $outputPath = $this->getTenantChartPath($options['filename'] ?? 'chart_' . time() . '.png');
        
        // Crea la directory se non esiste
        $this->ensureTenantDirectoryExists();
        
        switch ($type) {
            case 'line':
                return $this->generateLineChart($data, $outputPath, $options);
            case 'bar':
                return $this->generateBarChart($data, $outputPath, $options);
            case 'pie':
                return $this->generatePieChart($data, $outputPath, $options);
            default:
                throw new \InvalidArgumentException('Chart type not supported: ' . $type);
        }
    }

    protected function getTenantChartPath(string $filename): string
    {
        return storage_path("app/charts/tenant_{$this->tenant->id}/{$filename}");
    }

    protected function ensureTenantDirectoryExists(): void
    {
        $directory = dirname($this->getTenantChartPath('temp'));
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    protected function generateLineChart(array $data, string $outputPath, array $options): string
    {
        // Inizializza JpGraph
        require_once 'jpgraph/jpgraph.php';
        require_once 'jpgraph/jpgraph_line.php';

        // Crea il grafico
        $graph = new \Graph($options['width'] ?? 800, $options['height'] ?? 600);
        $graph->SetScale('textlin');
        
        // Configura il titolo
        if (isset($options['title'])) {
            $graph->title->Set($options['title']);
        }
        
        // Crea il plot
        $lineplot = new \LinePlot($data['values']);
        $lineplot->SetColor($options['color'] ?? 'blue');
        
        if (isset($data['labels'])) {
            $graph->xaxis->SetTickLabels($data['labels']);
        }
        
        $graph->Add($lineplot);
        
        // Salva il grafico
        $graph->Stroke($outputPath);
        
        return $outputPath;
    }

    protected function generateBarChart(array $data, string $outputPath, array $options): string
    {
        require_once 'jpgraph/jpgraph.php';
        require_once 'jpgraph/jpgraph_bar.php';

        $graph = new \Graph($options['width'] ?? 800, $options['height'] ?? 600);
        $graph->SetScale('textlin');
        
        if (isset($options['title'])) {
            $graph->title->Set($options['title']);
        }
        
        $bplot = new \BarPlot($data['values']);
        $bplot->SetFillColor($options['color'] ?? 'orange');
        
        if (isset($data['labels'])) {
            $graph->xaxis->SetTickLabels($data['labels']);
        }
        
        $graph->Add($bplot);
        $graph->Stroke($outputPath);
        
        return $outputPath;
    }

    protected function generatePieChart(array $data, string $outputPath, array $options): string
    {
        require_once 'jpgraph/jpgraph.php';
        require_once 'jpgraph/jpgraph_pie.php';

        $graph = new \PieGraph($options['width'] ?? 800, $options['height'] ?? 600);
        
        if (isset($options['title'])) {
            $graph->title->Set($options['title']);
        }
        
        $p1 = new \PiePlot($data['values']);
        
        if (isset($data['labels'])) {
            $p1->SetLabels($data['labels']);
        }
        
        $graph->Add($p1);
        $graph->Stroke($outputPath);
        
        return $outputPath;
    }
}
```

### 2.2 Servizio Specifico per la Gestione Multi-tenant

```php
<?php

namespace Modules\Chart\Services\JpGraph;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Xot\Services\XotDataService;

class TenantJpGraphService
{
    private JpGraphService $jpGraphService;
    private Model $tenant;

    public function __construct(Model $tenant = null)
    {
        $this->tenant = $tenant ?? app('currentTenant');
        $this->jpGraphService = new JpGraphService($this->tenant);
    }

    /**
     * Genera un grafico con caching specifico per tenant
     */
    public function generateTenantChart(array $data, string $type = 'line', array $options = []): string
    {
        // Crea una chiave di cache specifica per tenant
        $cacheKey = $this->getTenantChartCacheKey($data, $type, $options);
        
        return Cache::remember($cacheKey, $options['cache_ttl'] ?? 3600, function () use ($data, $type, $options) {
            return $this->jpGraphService->generateChart($data, $type, $options);
        });
    }

    /**
     * Genera un grafico per PDF con dati specifici del tenant
     */
    public function generateTenantChartForPdf(array $data, string $type = 'line', array $options = []): string
    {
        $defaultOptions = [
            'width' => 800,
            'height' => 400,
            'for_pdf' => true
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        return $this->generateTenantChart($data, $type, $options);
    }

    /**
     * Ottiene dati filtrati per il tenant corrente
     */
    public function getTenantChartData(string $modelClass, string $tenantColumn = 'tenant_id'): array
    {
        return $modelClass::where($tenantColumn, $this->tenant->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    private function getTenantChartCacheKey(array $data, string $type, array $options): string
    {
        $dataHash = md5(serialize($data));
        $optionsHash = md5(serialize($options));
        
        return "tenant_chart_{$this->tenant->id}_{$type}_{$dataHash}_{$optionsHash}";
    }

    /**
     * Invalida la cache dei grafici per il tenant
     */
    public function invalidateTenantChartCache(string $type = null): void
    {
        // In Laravel, non possiamo cancellare chiavi con pattern direttamente
        // Quindi cancelliamo tutte le chiavi relative ai grafici del tenant
        $this->flushTenantCache();
    }

    private function flushTenantCache(): void
    {
        // Implementazione specifica in base al driver di cache usato
        // Per Redis o Memcached, possiamo usare pattern matching
        $keys = Cache::getPrefix() . "tenant_chart_{$this->tenant->id}_*";
        
        // Se si usa Redis, possiamo cancellare per pattern
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            $redis = Cache::getStore()->getRedis();
            $tenantKeys = $redis->keys($keys);
            if (!empty($tenantKeys)) {
                $redis->del($tenantKeys);
            }
        } else {
            // Per file cache, dobbiamo cancellare manualmente i file
            $cacheDir = storage_path('framework/cache/data');
            $tenantPattern = $cacheDir . '/tenant_chart_' . $this->tenant->id . '_*';
            
            foreach (glob($tenantPattern) as $file) {
                unlink($file);
            }
        }
    }
}
```

## 3. Implementazione nei Widget Filament

### 3.1 Widget JpGraph Multi-tenant

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Storage;
use Modules\Chart\Services\JpGraph\TenantJpGraphService;

class TenantJpGraphWidget extends \Modules\Xot\Filament\Widgets\XotBaseWidget
{
    protected static string $view = 'chart::widgets.tenant-jpgraph-widget';

    public string $chartPath = '';

    protected array $data = [];

    protected string $chartType = 'line';

    protected array $options = [];

    protected function setUp(): void
    {
        parent::setUp();
        
        // Recupera il tenant corrente
        $this->tenant = app('currentTenant');
    }

    public function mount(): void
    {
        parent::mount();
        
        $this->generateChart();
    }

    protected function generateChart(): void
    {
        $service = new TenantJpGraphService($this->tenant);
        
        $this->chartPath = $service->generateTenantChart(
            $this->data,
            $this->chartType,
            $this->options
        );
    }

    public function getData(): array
    {
        return [
            'chartPath' => $this->chartPath,
            'chartUrl' => Storage::url(str_replace(storage_path('app'), '', $this->chartPath)),
        ];
    }
}
```

### 3.2 Implementazione della Vista

```php
{{-- resources/views/widgets/tenant-jpgraph-widget.blade.php --}}
<div class="tenant-jpgraph-widget">
    @if($this->chartPath && file_exists($this->chartPath))
        <img src="file://{{ $this->chartPath }}" alt="Tenant Chart" />
    @else
        <p>No chart data available</p>
    @endif
</div>
```

## 4. Integrazione con i Modelli e le Risorse

### 4.1 Modello Chart con Supporto Multi-tenant

```php
<?php

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $fillable = [
        'title',
        'description',
        'chart_type',
        'config',
        'data_source',
        'tenant_id',
        'user_id',
        'chart_file_path'
    ];

    protected $casts = [
        'config' => 'array',
        'tenant_id' => 'integer',
        'user_id' => 'integer',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function ($query) {
            $tenant = app('currentTenant');
            if ($tenant) {
                $query->where('tenant_id', $tenant->id);
            }
        });
    }

    public function scopeForTenant($query, \Illuminate\Database\Eloquent\Model $tenant)
    {
        return $query->where('tenant_id', $tenant->id);
    }

    public function generateChartFile(): void
    {
        $service = new \Modules\Chart\Services\JpGraph\TenantJpGraphService($this->tenant);
        
        $data = $this->getDataFromSource();
        $this->chart_file_path = $service->generateTenantChart(
            $data,
            $this->chart_type,
            $this->config
        );
        
        $this->save();
    }

    private function getDataFromSource(): array
    {
        // Implementa la logica per ottenere i dati in base alla fonte
        $source = $this->data_source;
        
        if (class_exists($source)) {
            return (new $source())->getTenantData($this->tenant);
        }
        
        // Implementa altri metodi di recupero dati
        return [];
    }
}
```

## 5. Sicurezza e Controllo degli Accessi

### 5.1 Policy per i Grafici Multi-tenant

```php
<?php

namespace Modules\Chart\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Chart\Models\Chart;

class ChartPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Chart $chart): bool
    {
        // Verifica che l'utente appartenga al tenant del grafico
        return $user->teams()->whereKey($chart->tenant_id)->exists();
    }

    public function create(User $user): bool
    {
        // L'utente può creare grafici se ha un tenant
        return $user->teams()->count() > 0;
    }

    public function update(User $user, Chart $chart): bool
    {
        return $this->view($user, $chart); // Stessa verifica di view
    }

    public function delete(User $user, Chart $chart): bool
    {
        return $this->view($user, $chart); // Stessa verifica di view
    }
}
```

### 5.2 Middleware per la Protezione dei File Grafico

```php
<?php

namespace Modules\Chart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantChartFileMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $chartPath = $request->route('path');
        
        // Verifica che il percorso appartenga al tenant corrente
        $tenant = app('currentTenant');
        $expectedPath = storage_path("app/charts/tenant_{$tenant->id}/");
        
        if (!str_starts_with($chartPath, $expectedPath)) {
            abort(403, 'Access denied to this chart file');
        }
        
        if (!file_exists($chartPath)) {
            abort(404, 'Chart file not found');
        }
        
        return $next($request);
    }
}
```

## 6. Gestione del Caching e della Performance

### 6.1 Servizio di Ottimizzazione del Caching

```php
<?php

namespace Modules\Chart\Services\JpGraph;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class JpGraphCacheOptimizer
{
    public function optimizeTenantCharts(string $tenantId, int $maxAgeDays = 7): void
    {
        $chartDir = storage_path("app/charts/tenant_{$tenantId}");
        
        if (!file_exists($chartDir)) {
            return;
        }
        
        $files = glob($chartDir . '/*.{png,jpg,jpeg,gif}', GLOB_BRACE);
        
        $cutoffDate = now()->subDays($maxAgeDays);
        
        foreach ($files as $file) {
            $fileDate = \Carbon\Carbon::createFromTimestamp(filemtime($file));
            
            if ($fileDate->lt($cutoffDate)) {
                // Cancella il file se è troppo vecchio
                unlink($file);
                
                // Cancella anche la chiave di cache associata
                $this->invalidateChartCache($file);
            }
        }
    }

    private function invalidateChartCache(string $filePath): void
    {
        // Recupera tutte le chiavi di cache e cancella quelle che contengono il percorso del file
        $fileBasename = basename($filePath);
        
        // Implementazione specifica a seconda del driver di cache
        $this->flushChartCacheByPattern($fileBasename);
    }

    private function flushChartCacheByPattern(string $pattern): void
    {
        $keys = Cache::getPrefix() . "*{$pattern}*";
        
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            $redis = Cache::getStore()->getRedis();
            $matchingKeys = $redis->keys($keys);
            if (!empty($matchingKeys)) {
                $redis->del($matchingKeys);
            }
        } else {
            // Per file cache, cancella manualmente
            $cacheDir = storage_path('framework/cache/data');
            $filePattern = $cacheDir . "/*{$pattern}*";
            
            foreach (glob($filePattern) as $file) {
                unlink($file);
            }
        }
    }
}
```

## 7. Integrazione con i Moduli Quaeris e Limesurvey

### 7.1 Servizio per la Generazione di Grafici da Dati Survey

```php
<?php

namespace Modules\Chart\Services\JpGraph;

use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\SurveyResponse;

class SurveyJpGraphService extends TenantJpGraphService
{
    public function generateSurveyChart(int $surveyId, string $chartType = 'line', array $options = []): string
    {
        $survey = Survey::where('id', $surveyId)
            ->where('tenant_id', $this->tenant->id)
            ->firstOrFail();

        $responses = SurveyResponse::where('survey_id', $surveyId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = [
            'values' => $responses->pluck('count')->toArray(),
            'labels' => $responses->pluck('date')->toArray(),
        ];

        $defaultOptions = [
            'title' => "Responses for: {$survey->title}",
            'width' => $options['width'] ?? 800,
            'height' => $options['height'] ?? 600,
        ];

        return $this->generateTenantChart($data, $chartType, array_merge($defaultOptions, $options));
    }

    public function generateQuestionChart(int $questionId, string $chartType = 'pie', array $options = []): string
    {
        // Recupera le risposte per la domanda specifica
        $responses = SurveyResponse::where('question_id', $questionId)
            ->whereHas('survey', function ($query) {
                $query->where('tenant_id', $this->tenant->id);
            })
            ->selectRaw('answer_value, COUNT(*) as count')
            ->groupBy('answer_value')
            ->get();

        $data = [
            'values' => $responses->pluck('count')->toArray(),
            'labels' => $responses->pluck('answer_value')->toArray(),
        ];

        $defaultOptions = [
            'title' => "Question Responses",
            'width' => $options['width'] ?? 600,
            'height' => $options['height'] ?? 600,
        ];

        return $this->generateTenantChart($data, $chartType, array_merge($defaultOptions, $options));
    }
}
```

## 8. Best Practices e Considerazioni

### 8.1 Sicurezza
- Assicurarsi che tutti i percorsi file siano validati
- Implementare controlli di accesso a livello di middleware
- Usare nomi file univoci per tenant per prevenire collisioni
- Validare tutti gli input prima di passarli a JpGraph

### 8.2 Performance
- Implementare caching appropriato per grafici complessi
- Usare dimensioni appropriate per i grafici
- Considerare la generazione asincrona per grafici complessi
- Ottimizzare la dimensione dei file immagine generati

### 8.3 Manutenzione
- Implementare sistemi di pulizia automatica dei file vecchi
- Monitorare lo spazio disco utilizzato dai grafici
- Implementare sistemi di fallback se JpGraph non è disponibile
- Documentare chiaramente le dipendenze esterne

## 9. Conclusione

L'integrazione di JpGraph con sistemi multi-tenant richiede un'attenta pianificazione per garantire sicurezza, performance e scalabilità. Implementando correttamente i pattern descritti in questo documento:

1. Ogni tenant avrà accesso esclusivo ai propri grafici
2. I dati saranno protetti da accessi non autorizzati
3. Le risorse saranno gestite in modo efficiente
4. La performance sarà ottimizzata attraverso il caching
5. La manutenzione sarà semplificata da sistemi automatici

Questa architettura fornisce una solida base per generare grafici server-side in contesti multi-tenant complessi come il progetto Quaeris.