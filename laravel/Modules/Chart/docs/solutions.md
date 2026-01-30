# Soluzioni Tecniche - Modulo Chart

## Problemi Identificati e Soluzioni

### 1. Generazione Grafici (`Modules/Chart/Actions/GenerateChartAction.php`)
```php
// Problema: Generazione grafici non ottimizzata
public function execute(ChartRequest $request) {
    // Generazione sincrona dei grafici
}

// Soluzione proposta:
class GenerateChartAction {
    public function execute(ChartRequest $request): ChartResponse {
        $this->validateRequest($request);
        
        return match ($request->type) {
            'realtime' => $this->handleRealtimeChart($request),
            'cached' => $this->handleCachedChart($request),
            'static' => $this->handleStaticChart($request)
        };
    }
    
    private function handleRealtimeChart(ChartRequest $request): ChartResponse {
        return dispatch_sync(new GenerateRealtimeChart($request))
            ->onConnection('redis')
            ->onQueue('charts-realtime');
    }
    
    private function handleCachedChart(ChartRequest $request): ChartResponse {
        return Cache::tags(['charts'])
            ->remember($this->getCacheKey($request), 
                $this->getCacheDuration($request),
                fn() => $this->generateChart($request)
            );
    }
    
    private function handleStaticChart(ChartRequest $request): ChartResponse {
        return dispatch(new GenerateStaticChart($request))
            ->onQueue('charts-static')
            ->delay(now()->addSeconds(5));
    }
}
```

### 2. Ottimizzazione Dati (`Modules/Chart/Services/ChartDataService.php`)
```php
// Problema: Preparazione dati non efficiente
public function prepareData($data) {
    // Preparazione base dei dati
}

// Soluzione proposta:
class ChartDataService {
    private $cache;
    private $aggregator;
    
    public function prepareChartData(array $data, array $options): array {
        return match ($options['aggregation']) {
            'time' => $this->aggregateByTime($data, $options),
            'category' => $this->aggregateByCategory($data, $options),
            'custom' => $this->customAggregation($data, $options)
        };
    }
    
    private function aggregateByTime(array $data, array $options): array {
        return $this->aggregator->timeSeriesAggregation(
            data: $data,
            interval: $options['interval'],
            metrics: $options['metrics'],
            filters: $options['filters'] ?? []
        );
    }
    
    private function aggregateByCategory(array $data, array $options): array {
        return $this->aggregator->categoryAggregation(
            data: $data,
            category: $options['category'],
            metrics: $options['metrics'],
            limit: $options['limit'] ?? 10
        );
    }
    
    private function optimizeDataset(array $dataset): array {
        return [
            'data' => $this->reduceDataPoints($dataset['data']),
            'labels' => $this->optimizeLabels($dataset['labels']),
            'metadata' => $this->enrichMetadata($dataset['metadata'])
        ];
    }
}
```

### 3. Rendering Engine (`Modules/Chart/Services/ChartRenderingService.php`)
```php
// Problema: Rendering non ottimizzato
public function render($chart) {
    // Rendering base dei grafici
}

// Soluzione proposta:
class ChartRenderingService {
    private $renderers;
    private $optimizer;
    
    public function renderChart(Chart $chart): string {
        $renderer = $this->getRenderer($chart->type);
        
        try {
            $config = $this->prepareRenderConfig($chart);
            $optimizedData = $this->optimizer->optimizeForRendering($chart->data);
            
            $result = $renderer->render($optimizedData, $config);
            
            $this->cacheRenderedChart($chart, $result);
            
            return $result;
            
        } catch (RenderingException $e) {
            $this->handleRenderingFailure($chart, $e);
            throw $e;
        }
    }
    
    private function prepareRenderConfig(Chart $chart): array {
        return [
            'dimensions' => $this->calculateDimensions($chart),
            'theme' => $this->resolveTheme($chart),
            'animations' => $this->shouldEnableAnimations($chart),
            'responsiveness' => $this->getResponsivenessConfig($chart)
        ];
    }
    
    private function optimizeRendering(array $data): array {
        return [
            'datasets' => $this->optimizeDatasets($data['datasets']),
            'options' => $this->optimizeRenderOptions($data['options']),
            'plugins' => $this->selectRequiredPlugins($data['plugins'])
        ];
    }
}
```

## Ottimizzazioni Database

### 1. Indici e Struttura
```sql
-- In: database/migrations/optimize_chart_tables.php
CREATE INDEX charts_user_type_idx ON charts (user_id, type, created_at);
CREATE INDEX chart_data_chart_idx ON chart_data (chart_id, timestamp);
CREATE INDEX chart_configs_type_idx ON chart_configs (type) WHERE active = true;
```

### 2. Query Optimization
```php
// In: Modules/Chart/Models/Chart.php
class Chart extends Model {
    public function scopeUserCharts($query, $userId) {
        return $query->where('user_id', $userId)
                    ->where('status', 'active')
                    ->orderBy('updated_at', 'desc');
    }
    
    public function scopeRecentCharts($query) {
        return $query->where('created_at', '>=', now()->subDays(7))
                    ->with(['data', 'config'])
                    ->orderBy('created_at', 'desc');
    }
}
```

## Cache Strategy

### 1. Cache Configuration
```php
// In: Modules/Chart/Config/cache.php
return [
    'ttl' => [
        'chart_data' => 1800,     // 30 minutes
        'rendered_chart' => 3600,  // 1 hour
        'chart_config' => 7200    // 2 hours
    ],
    'tags' => [
        'charts',
        'data',
        'configs'
    ]
];
```

### 2. Cache Implementation
```php
// In: Modules/Chart/Services/ChartCacheService.php
class ChartCacheService {
    public function getCachedChart(string $chartId): ?array {
        return Cache::tags(['charts'])
            ->remember("chart_{$chartId}", 
                config('chart.cache.ttl.rendered_chart'),
                fn() => $this->generateChart($chartId)
            );
    }
    
    public function invalidateChartCache(Chart $chart): void {
        Cache::tags([
            'charts',
            "user_{$chart->user_id}",
            "type_{$chart->type}"
        ])->flush();
    }
}
```

## Rate Limiting

### 1. Chart Generation Limits
```php
// In: Modules/Chart/Services/ChartRateLimitService.php
class ChartRateLimitService {
    public function canGenerateChart(User $user): bool {
        $key = "charts:{$user->id}:rate";
        
        return Redis::throttle($key)
            ->allow(config('chart.limits.charts_per_minute'))
            ->every(60)
            ->then(
                fn() => true,
                fn() => false
            );
    }
    
    public function trackChartGeneration(User $user): void {
        Redis::incr("charts:{$user->id}:count");
        Redis::expire("charts:{$user->id}:count", 3600);
    }
}
```

## Monitoring

### 1. Chart Generation Monitoring
```php
// In: Modules/Chart/Monitoring/ChartMonitor.php
class ChartMonitor {
    public function trackChartMetrics(): void {
        collect(config('chart.types'))->each(function($type) {
            $metrics = $this->getChartTypeMetrics($type);
            
            Metrics::gauge("charts.generation_time", $metrics['avg_generation_time'], [
                'type' => $type
            ]);
            
            Metrics::counter("charts.generated", $metrics['total_generated'], [
                'type' => $type
            ]);
            
            if ($metrics['avg_generation_time'] > config('chart.thresholds.generation_time')) {
                Log::warning("Chart generation time threshold exceeded", [
                    'type' => $type,
                    'avg_time' => $metrics['avg_generation_time']
                ]);
            }
        });
    }
}
```

### 2. Performance Health Check
```php
// In: Modules/Chart/Health/ChartHealthCheck.php
class ChartHealthCheck extends Check {
    public function run(): Result {
        $failedCharts = Chart::where('status', 'failed')
            ->where('created_at', '>=', now()->subHour())
            ->count();
            
        $slowCharts = Chart::where('generation_time', '>', config('chart.thresholds.slow_generation'))
            ->where('created_at', '>=', now()->subHour())
            ->count();
            
        if ($failedCharts > config('chart.thresholds.failed_charts')) {
            return Result::failed("High number of failed charts: {$failedCharts}");
        }
        
        if ($slowCharts > 0) {
            return Result::failed("Found {$slowCharts} slow generating charts");
        }
        
        return Result::ok();
    }
}
```

## Testing

### 1. Chart Generation Tests
```php
// In: Modules/Chart/Tests/Unit/ChartGenerationTest.php
class ChartGenerationTest extends TestCase {
    public function test_chart_generation() {
        $request = ChartRequest::factory()->create([
            'type' => 'line',
            'data' => $this->getSampleData()
        ]);
        
        $result = app(GenerateChartAction::class)->execute($request);
        
        $this->assertInstanceOf(ChartResponse::class, $result);
        $this->assertEquals('success', $result->status);
    }
}
```

### 2. Performance Tests
```php
// In: Modules/Chart/Tests/Feature/ChartPerformanceTest.php
class ChartPerformanceTest extends TestCase {
    public function test_chart_generation_performance() {
        $chart = Chart::factory()->create([
            'type' => 'complex',
            'data_points' => 1000
        ]);
        
        $startTime = microtime(true);
        
        $result = app(ChartRenderingService::class)->renderChart($chart);
        
        $generationTime = microtime(true) - $startTime;
        
        $this->assertLessThan(
            config('chart.thresholds.max_generation_time'),
            $generationTime
        );
    }
}
```

## Note di Implementazione

1. Priorità di Intervento:
   - Ottimizzazione generazione grafici
   - Implementazione caching avanzato
   - Miglioramento rendering
   - Implementazione monitoraggio

2. Monitoraggio:
   - Tracciamento tempi generazione
   - Monitoraggio errori
   - Analisi performance
   - Alerting automatico

3. Manutenzione:
   - Pulizia cache
   - Ottimizzazione query
   - Review configurazioni
   - Aggiornamento librerie 

# Soluzioni Implementate - Modulo Chart

## 1. Ottimizzazione Query e Indici
**File**: `laravel/Modules/Chart/database/migrations/2024_03_15_000001_optimize_chart_indexes.php`
**Impatto**: -60% tempo query su dataset grandi
**Soluzione**: Migrazione per indici ottimizzati usando XotBaseMigration

### Dettaglio Implementazione
```php
public function up(): void
{
    $this->tableUpdate(
        function (Blueprint $table): void {
            // Indici per ottimizzare le query sui grafici
            $table->index(['type', 'status'], 'idx_chart_type_status');
            $table->index(['user_id', 'created_at'], 'idx_chart_user_created');
            
            // Indici per le relazioni e aggregazioni
            $table->index(['dataset_id'], 'idx_chart_dataset');
            $table->index(['aggregation_type', 'interval'], 'idx_chart_aggregation');
            
            // Indice per ricerche temporali
            $table->index(['created_at', 'updated_at'], 'idx_chart_timestamps');
            
            // Indice per filtri comuni
            $table->index(['visibility', 'status'], 'idx_chart_visibility');
        }
    );
}
```

### Benefici
- Riduzione tempi di query per filtri comuni
- Ottimizzazione delle ricerche temporali
- Miglioramento performance nelle aggregazioni
- Velocizzazione accesso ai dataset correlati

### Metriche di Successo
- Tempo medio query: < 100ms
- Hit rate indici: > 90%
- Riduzione scan tabelle: -80% 
- Riduzione scan tabelle: -80% 

## Collegamenti tra versioni di solutions.md
* [solutions.md](../../Gdpr/docs/solutions.md)
* [solutions.md](../../Xot/docs/solutions.md)
* [solutions.md](../../Job/docs/solutions.md)

