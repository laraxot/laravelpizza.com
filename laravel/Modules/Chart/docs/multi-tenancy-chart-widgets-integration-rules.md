# Regole per l'Integrazione di Multi-tenancy e Chart Widgets in Filament 5.x

## Introduzione

Questo documento stabilisce le regole e le linee guida per integrare correttamente le funzionalità di multi-tenancy con i chart widgets in Filament 5.x all'interno del framework Laraxot. L'integrazione tra queste due funzionalità è critica per garantire la sicurezza dei dati e la corretta visualizzazione delle informazioni nei contesti multi-tenant.

## 1. Principi Fondamentali

### 1.1 Separazione dei Dati
- Ogni tenant deve avere accesso esclusivo ai propri dati
- I chart widgets devono visualizzare solo i dati appartenenti al tenant corrente
- Non deve essere possibile accedere ai dati di altri tenant attraverso i chart

### 1.2 Sicurezza dei Dati
- Implementare sempre controlli di accesso ai dati
- Verificare che i dati visualizzati appartengano al tenant corrente
- Evitare la possibilità di "data leakage" tra tenant diversi

## 2. Implementazione della Multi-tenancy nei Chart Widgets

### 2.1 Base Chart Widget con Supporto Multi-tenant

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

abstract class XotBaseTenantChartWidget extends XotBaseChartWidget
{
    // Il tenant corrente viene automaticamente disponibile
    protected ?\Illuminate\Database\Eloquent\Model $tenant = null;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Recupera il tenant corrente quando il widget viene inizializzato
        $this->tenant = filament()->getTenant();
    }

    /**
     * Metodo da sovrascrivere per applicare i filtri specifici del tenant
     */
    abstract protected function applyTenantScope(Builder $query): Builder;

    /**
     * Metodo da sovrascrivere per ottenere i dati specifici del tenant
     */
    abstract protected function getTenantData(): array;
}
```

### 2.2 Esempio di Chart Widget Specifico

```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Modules\Quaeris\Models\SurveyResponse;

class TenantSurveyResponseChart extends \Modules\Chart\Filament\Widgets\XotBaseTenantChartWidget
{
    protected ?string $heading = 'Survey Responses';

    protected function getData(): array
    {
        $responses = $this->getTenantData();
        
        return [
            'datasets' => [
                [
                    'label' => 'Responses',
                    'data' => $responses->pluck('count')->toArray(),
                    'backgroundColor' => '#3B82F6',
                ],
            ],
            'labels' => $responses->pluck('date')->toArray(),
        ];
    }

    protected function getTenantData(): array
    {
        return SurveyResponse::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('tenant_id', $this->tenant->id)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    protected function applyTenantScope(Builder $query): Builder
    {
        return $query->where('tenant_id', $this->tenant->id);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

## 3. Filtraggio dei Dati per Tenant

### 3.1 Filtri di Default per Tenant

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;

class TenantAwareChartWidget extends XotBaseTenantChartWidget
{
    use HasFiltersSchema;

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('startDate')
                ->default(now()->subDays(30)),
            DatePicker::make('endDate')
                ->default(now()),
        ]);
    }

    protected function getTenantData(): array
    {
        $query = SurveyResponse::query()
            ->where('tenant_id', $this->tenant->id);

        // Applica i filtri di data se presenti
        if ($this->filters['startDate'] ?? null) {
            $query->whereDate('created_at', '>=', $this->filters['startDate']);
        }

        if ($this->filters['endDate'] ?? null) {
            $query->whereDate('created_at', '<=', $this->filters['endDate']);
        }

        return $query
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
```

### 3.2 Validazione dei Dati del Filtro

```php
protected function getTenantData(): array
{
    // Validazione dei filtri per sicurezza
    $startDate = $this->filters['startDate'] ?? null;
    $endDate = $this->filters['endDate'] ?? null;

    // Assicurarsi che le date siano valide
    if ($startDate && !strtotime($startDate)) {
        $startDate = null;
    }
    
    if ($endDate && !strtotime($endDate)) {
        $endDate = null;
    }

    $query = SurveyResponse::query()
        ->where('tenant_id', $this->tenant->id);

    if ($startDate) {
        $query->whereDate('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('created_at', '<=', $endDate);
    }

    return $query
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->toArray();
}
```

## 4. Implementazione con Laravel Modules

### 4.1 Struttura del Modulo Chart

```
Modules/
└── Chart/
    ├── app/
    │   ├── Filament/
    │   │   └── Widgets/
    │   │       ├── XotBaseTenantChartWidget.php
    │   │       ├── TenantSurveyChart.php
    │   │       └── TenantResponseChart.php
    │   ├── Models/
    │   │   └── Chart.php
    │   └── Services/
    │       └── TenantChartService.php
    └── docs/
        └── multi-tenancy-chart-widgets-integration-rules.md
```

### 4.2 Servizio per la Gestione dei Chart Multi-tenant

```php
<?php

namespace Modules\Chart\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Chart\Models\Chart;

class TenantChartService
{
    protected \Illuminate\Database\Eloquent\Model $tenant;

    public function __construct(\Illuminate\Database\Eloquent\Model $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getTenantCharts(string $type = null): Collection
    {
        $query = Chart::query()
            ->where('tenant_id', $this->tenant->id);

        if ($type) {
            $query->where('chart_type', $type);
        }

        return $query->get();
    }

    public function getChartData(int $chartId): array
    {
        $chart = Chart::where('id', $chartId)
            ->where('tenant_id', $this->tenant->id)
            ->firstOrFail();

        // Recupera i dati specifici del chart
        return $this->processChartData($chart);
    }

    private function processChartData(Chart $chart): array
    {
        // Processa i dati in base al tipo di chart e al tenant
        $dataQuery = $chart->data_query;
        
        // Assicura che la query includa sempre il filtro per tenant
        $fullQuery = $dataQuery . " AND tenant_id = " . $this->tenant->id;
        
        // Esegue la query in modo sicuro
        return $this->executeSecureQuery($fullQuery);
    }

    private function executeSecureQuery(string $query): array
    {
        // Implementa esecuzione sicura della query
        // Questo è solo un esempio - in pratica usare Eloquent o Query Builder
        return [];
    }
}
```

## 5. Sicurezza e Controlli di Accesso

### 5.1 Verifica dell'Accesso al Tenant

```php
<?php

namespace Modules\Chart\Filament\Widgets;

class TenantChartWidget extends XotBaseTenantChartWidget
{
    public function mount(): void
    {
        parent::mount();
        
        // Verifica che l'utente possa accedere al tenant
        $user = auth()->user();
        if (!$user->canAccessTenant($this->tenant)) {
            abort(403, 'Access denied to this tenant');
        }
    }

    protected function getData(): array
    {
        // Verifica aggiuntiva che i dati appartengano al tenant corrente
        if (!$this->tenant) {
            return [
                'datasets' => [],
                'labels' => []
            ];
        }

        return $this->getTenantData();
    }
}
```

### 5.2 Controlli a Livello di Modello

```php
<?php

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $fillable = [
        'title',
        'chart_type',
        'config',
        'tenant_id',
        'user_id'
    ];

    protected $casts = [
        'config' => 'array',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (auth()->hasUser() && filament()->getTenant()) {
                $query->where('tenant_id', filament()->getTenant()->id);
            }
        });
    }

    public function scopeForTenant(Builder $query, \Illuminate\Database\Eloquent\Model $tenant): Builder
    {
        return $query->where('tenant_id', $tenant->id);
    }
}
```

## 6. Performance e Ottimizzazione

### 6.1 Caching dei Dati per Tenant

```php
<?php

namespace Modules\Chart\Services;

use Illuminate\Support\Facades\Cache;

class TenantChartService
{
    public function getTenantChartDataCached(int $chartId, array $filters = []): array
    {
        $cacheKey = "tenant_chart_data_{$this->tenant->id}_{$chartId}_" . 
                   md5(serialize($filters));
        
        return Cache::remember($cacheKey, 300, function () use ($chartId, $filters) {
            return $this->getTenantChartData($chartId, $filters);
        });
    }

    public function invalidateTenantChartCache(int $chartId = null): void
    {
        if ($chartId) {
            // Cancella solo il cache specifico
            $keys = Cache::getPrefix() . "tenant_chart_data_{$this->tenant->id}_{$chartId}_*";
            Cache::deleteMultiple(glob($keys));
        } else {
            // Cancella tutto il cache per il tenant
            $keys = Cache::getPrefix() . "tenant_chart_data_{$this->tenant->id}_*";
            Cache::deleteMultiple(glob($keys));
        }
    }
}
```

### 6.2 Paginazione e Limitazione dei Risultati

```php
protected function getTenantData(): array
{
    $query = SurveyResponse::query()
        ->where('tenant_id', $this->tenant->id)
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->limit(365); // Limita a 365 giorni per performance

    return $query->get()->toArray();
}
```

## 7. Error Handling e Logging

### 7.1 Gestione degli Errori nei Chart Widgets

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Illuminate\Support\Facades\Log;

class TenantChartWidget extends XotBaseTenantChartWidget
{
    protected function getData(): array
    {
        try {
            if (!$this->tenant) {
                Log::warning('Tenant not found when loading chart data');
                return $this->getEmptyData();
            }

            return $this->getTenantData();
        } catch (\Exception $e) {
            Log::error('Error loading tenant chart data: ' . $e->getMessage(), [
                'tenant_id' => $this->tenant?->id,
                'user_id' => auth()->id(),
            ]);

            return $this->getEmptyData();
        }
    }

    private function getEmptyData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'No data available',
                    'data' => [],
                    'backgroundColor' => '#9CA3AF',
                ],
            ],
            'labels' => [],
        ];
    }
}
```

## 8. Test e Validazione

### 8.1 Test per la Separazione dei Dati

```php
public function test_chart_widget_shows_only_tenant_data(): void
{
    // Crea un tenant A con alcuni dati
    $tenantA = Team::factory()->create();
    $userA = User::factory()->create();
    $userA->teams()->attach($tenantA);
    
    // Crea dati per il tenant A
    SurveyResponse::factory()->count(5)->create([
        'tenant_id' => $tenantA->id
    ]);

    // Crea un tenant B con altri dati
    $tenantB = Team::factory()->create();
    $userB = User::factory()->create();
    $userB->teams()->attach($tenantB);
    
    // Crea dati per il tenant B
    SurveyResponse::factory()->count(3)->create([
        'tenant_id' => $tenantB->id
    ]);

    // Simula l'accesso come utente del tenant A
    $this->actingAs($userA);
    
    // Imposta il tenant A
    app()->bind('currentTenant', fn() => $tenantA);
    
    // Crea il widget e verifica che mostri solo i dati del tenant A
    $widget = new TenantSurveyResponseChart();
    $data = $widget->getData();
    
    // Il conteggio deve essere 5 (solo i dati del tenant A)
    $this->assertCount(5, $data['datasets'][0]['data']);
}

public function test_user_cannot_access_other_tenant_chart_data(): void
{
    $tenantA = Team::factory()->create();
    $tenantB = Team::factory()->create();
    
    $user = User::factory()->create();
    $user->teams()->attach($tenantA);
    
    // Dati del tenant B (a cui l'utente non dovrebbe avere accesso)
    $chartB = Chart::factory()->create(['tenant_id' => $tenantB->id]);

    $this->actingAs($user);
    
    // Imposta il tenant A
    app()->bind('currentTenant', fn() => $tenantA);
    
    // Dovrebbe fallire quando cerca di accedere ai dati del tenant B
    $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
    
    $service = new TenantChartService($tenantA);
    $service->getChartData($chartB->id);
}
```

## 9. Conformità con le Regole Laraxot

### 9.1 Estensione dei Widget Base

```php
<?php

namespace Modules\Chart\Filament\Widgets;

// Segue sempre il pattern XotBase per mantenere la conformità
abstract class XotBaseTenantChartWidget extends \Modules\Xot\Filament\Widgets\XotBaseChartWidget
{
    // Implementazione specifica per la multi-tenancy
}
```

### 9.2 Uso di XotData per la Gestione del Tenant

```php
use Modules\Xot\Services\XotDataService;

protected function setUp(): void
{
    parent::setUp();
    
    $xotData = XotDataService::make();
    $this->tenant = $xotData->getCurrentTenant();
}
```

## 10. Conclusione

L'integrazione tra multi-tenancy e chart widgets richiede un'attenta implementazione per garantire la sicurezza, la performance e la correttezza dei dati visualizzati. Seguendo queste regole:

1. Implementare sempre il controllo del tenant nei widget
2. Applicare i filtri appropriati ai dati
3. Verificare gli accessi alle risorse
4. Implementare meccanismi di caching sicuri
5. Gestire correttamente gli errori
6. Testare accuratamente la separazione dei dati

Si può creare un sistema robusto e sicuro che permette la visualizzazione di dati analitici in contesti multi-tenant complessi.