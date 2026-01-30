# API del Modulo Chart

Questo documento descrive le principali API disponibili nel modulo Chart, fornendo riferimenti e esempi di utilizzo.

## ChartService API

### Creazione di un Grafico

```php
/**
 * Crea un nuovo grafico con le configurazioni specificate.
 *
 * @param array $config Configurazione del grafico
 * @return \Modules\Chart\Models\Chart
 */
public function createChart(array $config): Chart
```

Esempio:
```php
$chartService = app(\Modules\Chart\Services\ChartService::class);

$chart = $chartService->createChart([
    'type' => 'bar',
    'title' => 'Andamento Vendite',
    'data' => [
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
        'datasets' => [
            [
                'label' => 'Vendite 2023',
                'data' => [12, 19, 3, 5, 2, 3],
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ]
    ],
    'options' => [
        'scales' => [
            'y' => [
                'beginAtZero' => true
            ]
        ]
    ]
]);
```

### Rendering di un Grafico

```php
/**
 * Renderizza un grafico come HTML/JavaScript.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param array $options Opzioni di rendering aggiuntive
 * @return string HTML con il grafico renderizzato
 */
public function render(Chart $chart, array $options = []): string
```

Esempio:
```php
$html = $chartService->render($chart, [
    'height' => '400px',
    'width' => '100%',
    'responsive' => true,
    'container_class' => 'my-custom-chart-container'
]);

// Ora puoi usare $html direttamente in una view
```

### Generazione di un'Immagine del Grafico

```php
/**
 * Genera un'immagine del grafico.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param string $format Formato dell'immagine (png, jpg)
 * @param int $width Larghezza dell'immagine
 * @param int $height Altezza dell'immagine
 * @return string Percorso dell'immagine generata
 */
public function generateImage(Chart $chart, string $format = 'png', int $width = 800, int $height = 400): string
```

Esempio:
```php
$imagePath = $chartService->generateImage($chart, 'png', 1200, 600);
```

## DataProvider API

### Recupero Dati

```php
/**
 * Recupera i dati per un grafico dalla sorgente specificata.
 *
 * @param array $config Configurazione della query
 * @return array Dati formattati per Chart.js
 */
public function getData(array $config): array
```

Esempio:
```php
$dataProvider = app(\Modules\Chart\Services\DataProviders\DatabaseDataProvider::class);

$data = $dataProvider->getData([
    'source' => 'orders',
    'group_by' => 'month',
    'aggregate' => 'sum',
    'field' => 'total',
    'where' => [
        'year' => 2023,
        'status' => 'completed'
    ]
]);
```

## Filament Widget API

### Chart Widget

```php
/**
 * Crea un widget Filament con un grafico.
 *
 * @return \Filament\Widgets\Widget
 */
 
namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Chart\Services\ChartService;

class SalesChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Vendite Mensili';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';
    protected static ?string $chartId = 'salesChart';
    protected static ?string $pollingInterval = null;
    protected static string $chartType = 'bar';

    protected function getData(): array
    {
        return app(ChartService::class)->getChartData([
            'type' => 'sales',
            'period' => 'monthly'
        ]);
    }
}
```

## HTTP API

Il modulo Chart espone anche API HTTP per generare e interagire con i grafici:

### Generazione di un Grafico

**Endpoint**: `POST /api/charts`

**Payload**:
```json
{
    "type": "line",
    "title": "Analisi Dati",
    "data": {
        "labels": ["Gen", "Feb", "Mar"],
        "datasets": [{
            "label": "Dataset 1",
            "data": [10, 20, 30]
        }]
    },
    "options": {
        "responsive": true
    }
}
```

**Risposta**:
```json
{
    "id": 123,
    "type": "line",
    "title": "Analisi Dati",
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "url": "/charts/550e8400-e29b-41d4-a716-446655440000",
    "created_at": "2023-06-15T12:00:00Z"
}
```

### Recupero di un Grafico

**Endpoint**: `GET /api/charts/{id}`

**Risposta**:
```json
{
    "id": 123,
    "type": "line",
    "title": "Analisi Dati",
    "data": {
        "labels": ["Gen", "Feb", "Mar"],
        "datasets": [{
            "label": "Dataset 1",
            "data": [10, 20, 30]
        }]
    },
    "options": {
        "responsive": true
    },
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "url": "/charts/550e8400-e29b-41d4-a716-446655440000",
    "created_at": "2023-06-15T12:00:00Z",
    "updated_at": "2023-06-15T12:00:00Z"
}
```

## Eventi

Il modulo Chart emette vari eventi che puoi ascoltare nella tua applicazione:

```php
// Ascolta l'evento di creazione di un grafico
\Illuminate\Support\Facades\Event::listen(
    \Modules\Chart\Events\ChartCreated::class,
    function (\Modules\Chart\Events\ChartCreated $event) {
        $chart = $event->chart;
        // Fai qualcosa con il grafico appena creato
    }
);

// Ascolta l'evento di rendering di un grafico
\Illuminate\Support\Facades\Event::listen(
    \Modules\Chart\Events\ChartRendered::class,
    function (\Modules\Chart\Events\ChartRendered $event) {
        $chartId = $event->chartId;
        $renderTime = $event->renderTime;
        // Log delle prestazioni di rendering
    }
);
```

## Personalizzazione

### Estensione del ChartService

Puoi estendere il ChartService con nuove funzionalità:

```php
namespace App\Services;

use Modules\Chart\Services\ChartService;

class ExtendedChartService extends ChartService
{
    public function createCustomChart(array $data): Chart
    {
        // Logica personalizzata
        
        return $this->createChart([
            'type' => 'custom',
            'data' => $this->processCustomData($data),
            'options' => $this->getCustomOptions()
        ]);
    }
    
    protected function processCustomData(array $data): array
    {
        // Trasforma i dati nel formato richiesto
        return $transformedData;
    }
    
    protected function getCustomOptions(): array
    {
        return [
            // Opzioni personalizzate
        ];
    }
}
```

## Integrazione con Altri Moduli

Il modulo Chart può essere facilmente integrato con altri moduli Laraxot:

```php
// In qualsiasi controller o service di un altro modulo
use Modules\Chart\Facades\Chart;

public function generateDashboard()
{
    $salesChart = Chart::createChart([
        'type' => 'line',
        'title' => 'Vendite',
        // Altre configurazioni
    ]);
    
    $usersChart = Chart::createChart([
        'type' => 'bar',
        'title' => 'Utenti',
        // Altre configurazioni
    ]);
    
    return view('dashboard', [
        'salesChart' => Chart::render($salesChart),
        'usersChart' => Chart::render($usersChart)
    ]);
}
``` 

# API del Modulo Chart

Questo documento descrive le principali API disponibili nel modulo Chart, fornendo riferimenti e esempi di utilizzo.

## ChartService API

### Creazione di un Grafico

```php
/**
 * Crea un nuovo grafico con le configurazioni specificate.
 *
 * @param array $config Configurazione del grafico
 * @return \Modules\Chart\Models\Chart
 */
public function createChart(array $config): Chart
```

Esempio:
```php
$chartService = app(\Modules\Chart\Services\ChartService::class);

$chart = $chartService->createChart([
    'type' => 'bar',
    'title' => 'Andamento Vendite',
    'data' => [
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
        'datasets' => [
            [
                'label' => 'Vendite 2023',
                'data' => [12, 19, 3, 5, 2, 3],
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ]
    ],
    'options' => [
        'scales' => [
            'y' => [
                'beginAtZero' => true
            ]
        ]
    ]
]);
```

### Rendering di un Grafico

```php
/**
 * Renderizza un grafico come HTML/JavaScript.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param array $options Opzioni di rendering aggiuntive
 * @return string HTML con il grafico renderizzato
 */
public function render(Chart $chart, array $options = []): string
```

Esempio:
```php
$html = $chartService->render($chart, [
    'height' => '400px',
    'width' => '100%',
    'responsive' => true,
    'container_class' => 'my-custom-chart-container'
]);

// Ora puoi usare $html direttamente in una view
```

### Generazione di un'Immagine del Grafico

```php
/**
 * Genera un'immagine del grafico.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param string $format Formato dell'immagine (png, jpg)
 * @param int $width Larghezza dell'immagine
 * @param int $height Altezza dell'immagine
 * @return string Percorso dell'immagine generata
 */
public function generateImage(Chart $chart, string $format = 'png', int $width = 800, int $height = 400): string
```

Esempio:
```php
$imagePath = $chartService->generateImage($chart, 'png', 1200, 600);
```

## DataProvider API

### Recupero Dati

```php
/**
 * Recupera i dati per un grafico dalla sorgente specificata.
 *
 * @param array $config Configurazione della query
 * @return array Dati formattati per Chart.js
 */
public function getData(array $config): array
```

Esempio:
```php
$dataProvider = app(\Modules\Chart\Services\DataProviders\DatabaseDataProvider::class);

$data = $dataProvider->getData([
    'source' => 'orders',
    'group_by' => 'month',
    'aggregate' => 'sum',
    'field' => 'total',
    'where' => [
        'year' => 2023,
        'status' => 'completed'
    ]
]);
```

## Filament Widget API

### Chart Widget

```php
/**
 * Crea un widget Filament con un grafico.
 *
 * @return \Filament\Widgets\Widget
 */
 
namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Chart\Services\ChartService;

class SalesChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Vendite Mensili';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';
    protected static ?string $chartId = 'salesChart';
    protected static ?string $pollingInterval = null;
    protected static string $chartType = 'bar';

    protected function getData(): array
    {
        return app(ChartService::class)->getChartData([
            'type' => 'sales',
            'period' => 'monthly'
        ]);
    }
}
```

## HTTP API

Il modulo Chart espone anche API HTTP per generare e interagire con i grafici:

### Generazione di un Grafico

**Endpoint**: `POST /api/charts`

**Payload**:
```json
{
    "type": "line",
    "title": "Analisi Dati",
    "data": {
        "labels": ["Gen", "Feb", "Mar"],
        "datasets": [{
            "label": "Dataset 1",
            "data": [10, 20, 30]
        }]
    },
    "options": {
        "responsive": true
    }
}
```

**Risposta**:
```json
{
    "id": 123,
    "type": "line",
    "title": "Analisi Dati",
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "url": "/charts/550e8400-e29b-41d4-a716-446655440000",
    "created_at": "2023-06-15T12:00:00Z"
}
```

### Recupero di un Grafico

**Endpoint**: `GET /api/charts/{id}`

**Risposta**:
```json
{
    "id": 123,
    "type": "line",
    "title": "Analisi Dati",
    "data": {
        "labels": ["Gen", "Feb", "Mar"],
        "datasets": [{
            "label": "Dataset 1",
            "data": [10, 20, 30]
        }]
    },
    "options": {
        "responsive": true
    },
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "url": "/charts/550e8400-e29b-41d4-a716-446655440000",
    "created_at": "2023-06-15T12:00:00Z",
    "updated_at": "2023-06-15T12:00:00Z"
}
```

## Eventi

Il modulo Chart emette vari eventi che puoi ascoltare nella tua applicazione:

```php
// Ascolta l'evento di creazione di un grafico
\Illuminate\Support\Facades\Event::listen(
    \Modules\Chart\Events\ChartCreated::class,
    function (\Modules\Chart\Events\ChartCreated $event) {
        $chart = $event->chart;
        // Fai qualcosa con il grafico appena creato
    }
);

// Ascolta l'evento di rendering di un grafico
\Illuminate\Support\Facades\Event::listen(
    \Modules\Chart\Events\ChartRendered::class,
    function (\Modules\Chart\Events\ChartRendered $event) {
        $chartId = $event->chartId;
        $renderTime = $event->renderTime;
        // Log delle prestazioni di rendering
    }
);
```

## Personalizzazione

### Estensione del ChartService

Puoi estendere il ChartService con nuove funzionalità:

```php
namespace App\Services;

use Modules\Chart\Services\ChartService;

class ExtendedChartService extends ChartService
{
    public function createCustomChart(array $data): Chart
    {
        // Logica personalizzata
        
        return $this->createChart([
            'type' => 'custom',
            'data' => $this->processCustomData($data),
            'options' => $this->getCustomOptions()
        ]);
    }
    
    protected function processCustomData(array $data): array
    {
        // Trasforma i dati nel formato richiesto
        return $transformedData;
    }
    
    protected function getCustomOptions(): array
    {
        return [
            // Opzioni personalizzate
        ];
    }
}
```

## Integrazione con Altri Moduli

Il modulo Chart può essere facilmente integrato con altri moduli Laraxot:

```php
// In qualsiasi controller o service di un altro modulo
use Modules\Chart\Facades\Chart;

public function generateDashboard()
{
    $salesChart = Chart::createChart([
        'type' => 'line',
        'title' => 'Vendite',
        // Altre configurazioni
    ]);
    
    $usersChart = Chart::createChart([
        'type' => 'bar',
        'title' => 'Utenti',
        // Altre configurazioni
    ]);
    
    return view('dashboard', [
        'salesChart' => Chart::render($salesChart),
        'usersChart' => Chart::render($usersChart)
    ]);
}
``` 

## Collegamenti tra versioni di api.md
* [api.md](../../../Gdpr/docs/api.md)
* [api.md](../../../Dental/docs/api.md)
* [api.md](../../../Patient/docs/api.md)

``` 

