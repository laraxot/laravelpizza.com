# JpGraph Installation Guide for Chart Module

## Overview

This guide explains how to install and configure JpGraph within the Chart module using Composer and proper namespace integration.

**Riferimento rapido (installazione Composer e namespace):** [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md).

- **Pacchetto:** `amenadiel/jpgraph` (^4.1 in `Modules/Chart/composer.json`).
- **Namespace:** `Amenadiel\JpGraph\*` (Graph, Plot, Text, Themes). Non usare `JpGraph\*` o pacchetti diversi.
- **Installazione:** dalla root Laravel: `cd laravel && composer require amenadiel/jpgraph` oppure `composer update`; non serve modificare `autoload` per JpGraph.

## 1. Composer Installation

### 1.1 Add JpGraph to Project

```bash
cd laravel
composer require amenadiel/jpgraph
```

La dipendenza è già dichiarata in `laravel/Modules/Chart/composer.json` come `"amenadiel/jpgraph": "^4.1"`. Con composer-merge-plugin, l’installazione dalla root Laravel risolve il pacchetto. Non aggiungere mapping manuali per `Amenadiel\JpGraph` in `autoload`.

### 1.2 Update Autoloader (se necessario)

```bash
cd laravel
composer dump-autoload
```

## 2. Namespace Configuration

Per l’elenco completo dei namespace e delle classi usate nel progetto vedi [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md). In sintesi: usare sempre `Amenadiel\JpGraph\Graph\Graph`, `Amenadiel\JpGraph\Plot\BarPlot`, ecc.

### 2.1 JpGraph Service Class (esempio)

Create `laravel/Modules/Chart/app/Services/JpGraphService.php`:

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\PiePlot;

final class JpGraphService
{
    private readonly string $cachePath;
    private readonly string $publicPath;
    
    public function __construct()
    {
        $this->cachePath = storage_path('app/public/charts');
        $this->publicPath = 'storage/charts';
        $this->ensureCacheDirectory();
    }
    
    /**
     * Create a line chart with JpGraph
     *
     * @param array<float> $data Chart data points
     * @param array<string> $labels X-axis labels
     * @param array<string> $options Chart configuration options
     * @return string Public URL to generated chart
     * @throws JpGraphException
     */
    public function createLineChart(
        array $data, 
        array $labels, 
        array $options = []
    ): string {
        $width = $options['width'] ?? 600;
        $height = $options['height'] ?? 400;
        $title = $options['title'] ?? 'Line Chart';
        
        $graph = new Graph($width, $height);
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        $graph->xaxis->title->Set($options['x_title'] ?? 'X Axis');
        $graph->yaxis->title->Set($options['y_title'] ?? 'Y Axis');
        
        $linePlot = new LinePlot($data);
        $linePlot->SetColor($options['color'] ?? '#1f77b4');
        $linePlot->SetWeight($options['weight'] ?? 2);
        
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
        }
        
        $graph->Add($linePlot);
        
        $filename = $this->generateFilename('line');
        $fullPath = $this->cachePath . '/' . $filename;
        $graph->Stroke($fullPath);
        
        return $this->publicPath . '/' . $filename;
    }
    
    /**
     * Create a bar chart with JpGraph
     *
     * @param array<float> $data Chart data points
     * @param array<string> $labels X-axis labels
     * @param array<string> $options Chart configuration options
     * @return string Public URL to generated chart
     * @throws JpGraphException
     */
    public function createBarChart(
        array $data, 
        array $labels, 
        array $options = []
    ): string {
        $width = $options['width'] ?? 600;
        $height = $options['height'] ?? 400;
        $title = $options['title'] ?? 'Bar Chart';
        
        $graph = new Graph($width, $height);
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        $graph->xaxis->title->Set($options['x_title'] ?? 'X Axis');
        $graph->yaxis->title->Set($options['y_title'] ?? 'Y Axis');
        
        $barPlot = new BarPlot($data);
        $barPlot->SetColor($options['color'] ?? '#ff7f0e');
        $barPlot->SetFillColor($options['fill_color'] ?? '#ff7f0e');
        
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
        }
        
        $graph->Add($barPlot);
        
        $filename = $this->generateFilename('bar');
        $fullPath = $this->cachePath . '/' . $filename;
        $graph->Stroke($fullPath);
        
        return $this->publicPath . '/' . $filename;
    }
    
    /**
     * Create a pie chart with JpGraph
     *
     * @param array<float> $data Chart data points
     * @param array<string> $labels Legend labels
     * @param array<string> $options Chart configuration options
     * @return string Public URL to generated chart
     * @throws JpGraphException
     */
    public function createPieChart(
        array $data, 
        array $labels, 
        array $options = []
    ): string {
        $width = $options['width'] ?? 400;
        $height = $options['height'] ?? 400;
        $title = $options['title'] ?? 'Pie Chart';
        
        $graph = new Graph($width, $height);
        $graph->title->Set($title);
        
        $piePlot = new PiePlot($data);
        $piePlot->SetLegends($labels);
        $piePlot->SetCenter(0.5, 0.5);
        $piePlot->SetSize($options['size'] ?? 0.3);
        
        if (isset($options['explode'])) {
            $piePlot->Explode($options['explode']);
        }
        
        $graph->Add($piePlot);
        
        $filename = $this->generateFilename('pie');
        $fullPath = $this->cachePath . '/' . $filename;
        $graph->Stroke($fullPath);
        
        return $this->publicPath . '/' . $filename;
    }
    
    private function generateFilename(string $type): string
    {
        return $type . '_' . uniqid() . '_' . time() . '.png';
    }
    
    private function ensureCacheDirectory(): void
    {
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
}
```

### 2.2 Custom Exception Class

Create `laravel/Modules/Chart/app/Exceptions/JpGraphException.php`:

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Exceptions;

use Exception;

final class JpGraphException extends Exception
{
    public static function chartGenerationFailed(string $reason): self
    {
        return new self("Chart generation failed: {$reason}");
    }
    
    public static function invalidData(string $reason): self
    {
        return new self("Invalid chart data: {$reason}");
    }
    
    public static function configurationError(string $reason): self
    {
        return new self("Chart configuration error: {$reason}");
    }
}
```

## 3. Controller Integration

### 3.1 Chart Controller

Create `laravel/Modules/Chart/app/Http/Controllers/JpGraphController.php`:

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Chart\Services\JpGraphService;
use Modules\Chart\Exceptions\JpGraphException;

final class JpGraphController extends Controller
{
    public function __construct(
        private readonly JpGraphService $chartService
    ) {}
    
    /**
     * Generate line chart
     */
    public function lineChart(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'data' => 'required|array',
                'data.*' => 'numeric',
                'labels' => 'required|array',
                'labels.*' => 'string',
                'title' => 'sometimes|string|max:255',
                'width' => 'sometimes|integer|min:100|max:2000',
                'height' => 'sometimes|integer|min:100|max:2000'
            ]);
            
            $chartUrl = $this->chartService->createLineChart(
                $validated['data'],
                $validated['labels'],
                [
                    'title' => $validated['title'] ?? 'Line Chart',
                    'width' => $validated['width'] ?? 600,
                    'height' => $validated['height'] ?? 400
                ]
            );
            
            return response()->json([
                'success' => true,
                'chart_url' => url($chartUrl),
                'chart_path' => $chartUrl
            ]);
            
        } catch (JpGraphException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Generate bar chart
     */
    public function barChart(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'data' => 'required|array',
                'data.*' => 'numeric',
                'labels' => 'required|array',
                'labels.*' => 'string',
                'title' => 'sometimes|string|max:255'
            ]);
            
            $chartUrl = $this->chartService->createBarChart(
                $validated['data'],
                $validated['labels'],
                [
                    'title' => $validated['title'] ?? 'Bar Chart'
                ]
            );
            
            return response()->json([
                'success' => true,
                'chart_url' => url($chartUrl)
            ]);
            
        } catch (JpGraphException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Generate pie chart
     */
    public function pieChart(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'data' => 'required|array',
                'data.*' => 'numeric',
                'labels' => 'required|array',
                'labels.*' => 'string',
                'title' => 'sometimes|string|max:255'
            ]);
            
            $chartUrl = $this->chartService->createPieChart(
                $validated['data'],
                $validated['labels'],
                [
                    'title' => $validated['title'] ?? 'Pie Chart'
                ]
            );
            
            return response()->json([
                'success' => true,
                'chart_url' => url($chartUrl)
            ]);
            
        } catch (JpGraphException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
```

## 4. Routes Configuration

### 4.1 API Routes

Add to `laravel/Modules/Chart/routes/api.php`:

```php
<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Chart\Http\Controllers\JpGraphController;

Route::prefix('charts')->middleware(['api'])->group(function () {
    Route::post('line', [JpGraphController::class, 'lineChart']);
    Route::post('bar', [JpGraphController::class, 'barChart']);
    Route::post('pie', [JpGraphController::class, 'pieChart']);
});
```

### 4.2 Web Routes

Add to `laravel/Modules/Chart/routes/web.php`:

```php
<?php declare(strict_types=1);

Route::middleware(['web'])->prefix('charts')->group(function () {
    Route::get('/', function () {
        return view('chart::index');
    });
});
```

## 5. Configuration

### 5.1 Module Configuration

Create `laravel/Modules/Chart/config/jpgraph.php`:

```php
<?php declare(strict_types=1);

return [
    'cache_path' => storage_path('app/public/charts'),
    'public_path' => 'storage/charts',
    'default_width' => 600,
    'default_height' => 400,
    'image_quality' => 90,
    'cache_timeout' => 3600, // 1 hour
    
    'charts' => [
        'line' => [
            'default_color' => '#1f77b4',
            'default_weight' => 2
        ],
        'bar' => [
            'default_color' => '#ff7f0e',
            'default_fill_color' => '#ff7f0e'
        ],
        'pie' => [
            'default_size' => 0.3,
            'default_center_x' => 0.5,
            'default_center_y' => 0.5
        ]
    ],
    
    'validation' => [
        'max_data_points' => 1000,
        'max_label_length' => 100,
        'max_title_length' => 255
    ]
];
```

## 6. Testing

### 6.1 Unit Tests

Create `laravel/Modules/Chart/tests/Unit/JpGraphServiceTest.php`:

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Tests\Unit;

use Tests\TestCase;
use Modules\Chart\Services\JpGraphService;
use Modules\Chart\Exceptions\JpGraphException;

final class JpGraphServiceTest extends TestCase
{
    private JpGraphService $chartService;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->chartService = new JpGraphService();
    }
    
    public function test_line_chart_creation(): void
    {
        $data = [10, 20, 30, 40, 50];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        
        $chartPath = $this->chartService->createLineChart($data, $labels);
        
        $this->assertIsString($chartPath);
        $this->assertStringContains('storage/charts', $chartPath);
        $this->assertFileExists(public_path($chartPath));
    }
    
    public function test_bar_chart_creation(): void
    {
        $data = [15, 25, 35, 45, 55];
        $labels = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5'];
        
        $chartPath = $this->chartService->createBarChart($data, $labels);
        
        $this->assertIsString($chartPath);
        $this->assertStringContains('storage/charts', $chartPath);
        $this->assertFileExists(public_path($chartPath));
    }
    
    public function test_pie_chart_creation(): void
    {
        $data = [30, 25, 20, 15, 10];
        $labels = ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'];
        
        $chartPath = $this->chartService->createPieChart($data, $labels);
        
        $this->assertIsString($chartPath);
        $this->assertStringContains('storage/charts', $chartPath);
        $this->assertFileExists(public_path($chartPath));
    }
    
    public function test_empty_data_handling(): void
    {
        $this->expectException(JpGraphException::class);
        
        $this->chartService->createLineChart([], []);
    }
}
```

## 7. Service Provider Registration

### 7.1 Chart Module Service Provider

Update `laravel/Modules/Chart/Providers/ChartServiceProvider.php`:

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Chart\Services\JpGraphService;

final class ChartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/jpgraph.php',
            'jpgraph'
        );
        
        $this->app->singleton(JpGraphService::class);
    }
    
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        
        $this->publishes([
            __DIR__ . '/../config/jpgraph.php' => config_path('jpgraph.php'),
        ], 'jpgraph-config');
    }
}
```

## 8. Usage Examples

### 8.1 Basic Usage

```php
// In a controller
use Modules\Chart\Services\JpGraphService;

class DashboardController extends Controller
{
    public function index(JpGraphService $chartService)
    {
        $data = [100, 200, 150, 300, 250];
        $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        $chartUrl = $chartService->createLineChart($data, $labels, [
            'title' => 'Weekly Sales',
            'color' => '#2ecc71'
        ]);
        
        return view('dashboard', compact('chartUrl'));
    }
}
```

### 8.2 API Usage

```bash
# POST /api/charts/line
{
    "data": [10, 20, 30, 40, 50],
    "labels": ["Jan", "Feb", "Mar", "Apr", "May"],
    "title": "Monthly Revenue",
    "width": 800,
    "height": 500
}
```

Response:
```json
{
    "success": true,
    "chart_url": "http://localhost/storage/charts/line_abc123_1640995200.png",
    "chart_path": "storage/charts/line_abc123_1640995200.png"
}
```

## 9. Best Practices

### 9.1 Error Handling

Always wrap JpGraph operations in try-catch blocks:

```php
try {
    $chartUrl = $this->chartService->createLineChart($data, $labels);
} catch (JpGraphException $e) {
    Log::error('Chart generation failed', [
        'error' => $e->getMessage(),
        'data' => $data
    ]);
    
    // Fallback to Chart.js or show error message
    return $this->getFallbackChart();
}
```

### 9.2 Performance

- Implement caching for frequently generated charts
- Use queue jobs for batch chart generation
- Limit chart dimensions for web display
- Clean up old chart files periodically

### 9.3 Security

- Validate all input data
- Sanitize chart titles and labels
- Limit file generation rates
- Use secure file paths

This installation guide provides a complete foundation for integrating JpGraph into the Chart module with proper namespace management and following all established coding standards.