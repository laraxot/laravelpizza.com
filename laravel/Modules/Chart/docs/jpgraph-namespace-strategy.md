# JpGraph Namespace Strategy & Documentation

## Namespace Architecture

### 1. Hierarchical Structure

```
Base Layer:
└── Amenadiel\JpGraph\          ← Original JpGraph library

Extension Layer:
├── Modules\Chart\JpGraph\       ← Chart module extensions
└── Modules\Quaeris\JpGraph\    ← Quaeris business extensions

Business Layer:
└── Modules\Quaeris\Services\    ← High-level services
```

### 2. Namespace Purpose

| Namespace | Purpose | Contains |
|-----------|---------|----------|
| `Amenadiel\JpGraph\` | Base library | Core JpGraph classes |
| `Modules\Chart\JpGraph\` | Generic extensions | Enhanced plots, utilities |
| `Modules\Quaeris\JpGraph\` | Business extensions | Italian charts, financial features |
| `Modules\Quaeris\Services\` | Service layer | Business logic orchestration |

## Implementation Guidelines

### 1. Extension Naming Convention

```php
// ✅ CORRECT Naming
namespace Modules\Chart\JpGraph\Plot;
class EnhancedLinePlot extends \Amenadiel\JpGraph\Plot\LinePlot

// ✅ CORRECT Business Extension  
namespace Modules\Quaeris\JpGraph\Chart;
class ItalianBusinessChart extends \Amenadiel\JpGraph\Graph\Graph

// ❌ WRONG - Don't override base namespace
namespace Amenadiel\JpGraph\Plot;
class CustomLinePlot  // Never modify original namespace
```

### 2. Class Inheritance Patterns

#### 2.1 Plot Extensions
```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Plot;

use Amenadiel\JpGraph\Plot\LinePlot;

/**
 * Enhanced line plot with additional features
 */
final class EnhancedLinePlot extends LinePlot
{
    // Add new properties and methods
    protected bool $enableGradient = false;
    protected array $customData = [];
    
    // Override base methods
    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        
        // Add custom functionality
        if ($this->enableGradient) {
            $this->drawGradient($img, $xscale, $yscale);
        }
    }
    
    // Add new methods
    public function enableGradient(bool $enable = true): self
    {
        $this->enableGradient = $enable;
        return $this;
    }
}
```

#### 2.2 Chart Extensions
```php
<?php declare(strict_types=1);

namespace Modules\Quaeris\JpGraph\Chart;

use Amenadiel\JpGraph\Graph\Graph;
use Modules\Chart\JpGraph\Plot\EnhancedLinePlot;

/**
 * Italian business chart with localization
 */
final class ItalianBusinessChart extends Graph
{
    protected array $italianColors = [...];
    protected array $italianMonths = [...];
    
    /**
     * Factory method for KPI charts
     */
    public function createKPIChart(array $data, array $periods): EnhancedLinePlot
    {
        $this->SetScale('textlin');
        $this->title->Set('Andamento KPI');
        
        $linePlot = new EnhancedLinePlot($data);
        $linePlot->SetColor($this->italianColors[0]);
        $linePlot->enableGradient(true);
        
        $this->Add($linePlot);
        
        return $linePlot;
    }
}
```

## File Organization

### 1. Chart Module Structure
```
laravel/Modules/Chart/
├── app/
│   ├── JpGraph/
│   │   ├── Plot/
│   │   │   ├── EnhancedLinePlot.php
│   │   │   ├── EnhancedBarPlot.php
│   │   │   └── EnhancedPiePlot.php
│   │   ├── Graph/
│   │   │   ├── EnhancedGraph.php
│   │   │   └── Utility/
│   │   │       ├── ColorManager.php
│   │   │       └── FontManager.php
│   │   └── Exceptions/
│   │       └── JpGraphExtensionException.php
│   └── Services/
│       └── ChartExtensionService.php
├── tests/
│   ├── JpGraph/
│   │   ├── Plot/
│   │   └── Chart/
│   └── Unit/
└── docs/
    └── jpgraph-namespace-strategy.md
```

### 2. Quaeris Module Structure
```
laravel/Modules/Quaeris/
├── app/
│   ├── JpGraph/
│   │   ├── Chart/
│   │   │   ├── ItalianBusinessChart.php
│   │   │   ├── FinancialReportChart.php
│   │   │   └── DashboardChart.php
│   │   ├── Plot/
│   │   │   ├── BusinessLinePlot.php
│   │   │   ├── FinancialBarPlot.php
│   │   │   └── ItalianPiePlot.php
│   │   └── Helpers/
│   │       ├── ItalianDateFormatter.php
│   │       ├── CurrencyFormatter.php
│   │       └── ColorPalette.php
│   └── Services/
│       ├── BusinessChartService.php
│       └── FinancialReportService.php
├── tests/
│   └── ...
└── docs/
    └── jpgraph-business-extensions.md
```

## Import Patterns

### 1. Import Organization Rules

```php
<?php declare(strict_types=1);

// 1. Base JpGraph imports (alphabetical)
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\PiePlot;

// 2. Module extension imports (alphabetical)
use Modules\Chart\JpGraph\Plot\EnhancedLinePlot;
use Modules\Chart\JpGraph\Plot\EnhancedBarPlot;
use Modules\Chart\JpGraph\Graph\EnhancedGraph;

// 3. Business extension imports (alphabetical)
use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart;
use Modules\Quaeris\JpGraph\Plot\BusinessLinePlot;
use Modules\Quaeris\JpGraph\Helpers\ItalianDateFormatter;

// 4. Laravel/framework imports
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

// 5. Function imports (if any)
use function sprintf;
use function array_map;
```

### 2. Alias Usage

```php
<?php declare(strict_types=1);

// ✅ CORRECT - Use aliases for readability
use Modules\Chart\JpGraph\Plot\EnhancedLinePlot as LineChart;
use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart as BusinessChart;

// ✅ CORRECT - Full names when clarity needed
use Amenadiel\JpGraph\Plot\LinePlot;

class ChartService
{
    public function createChart(): LineChart
    {
        $chart = new BusinessChart(800, 400);
        $plot = new LineChart($data);
        
        return $plot;
    }
}

// ❌ WRONG - Don't alias base classes
use Amenadiel\JpGraph\Plot\LinePlot as BaseLinePlot;
```

## Autoloading Configuration

### 1. Module composer.json Configuration

#### Chart Module
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Chart\\": ".",
            "Modules\\Chart\\JpGraph\\": "app/JpGraph"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\Chart\\Tests\\": "tests"
        }
    }
}
```

#### Quaeris Module
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Quaeris\\": ".",
            "Modules\\Quaeris\\JpGraph\\": "app/JpGraph"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\Quaeris\\Tests\\": "tests"
        }
    }
}
```

### 2. Application Autoloader Update

```bash
# Refresh autoloader after namespace changes
cd laravel
composer dump-autoload

# Clear class cache
php artisan optimize:clear
```

## Testing Strategy

### 1. Unit Test Structure

#### Plot Extension Tests
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Tests\Unit\JpGraph\Plot;

use Modules\Chart\JpGraph\Plot\EnhancedLinePlot;
use Tests\TestCase;

final class EnhancedLinePlotTest extends TestCase
{
    public function test_gradient_enhancement(): void
    {
        $data = [10, 20, 30, 40, 50];
        $plot = new EnhancedLinePlot($data);
        
        $plot->enableGradient(true);
        
        $this->assertTrue($plot->hasGradient());
    }
    
    public function test_inheritance_compatibility(): void
    {
        $data = [10, 20, 30];
        $plot = new EnhancedLinePlot($data);
        
        // Should still work with base JpGraph methods
        $this->assertInstanceOf(\Amenadiel\JpGraph\Plot\LinePlot::class, $plot);
        $plot->SetColor('#ff0000');
        $this->assertEquals('#ff0000', $plot->color);
    }
}
```

#### Business Extension Tests
```php
<?php declare(strict_types=1);

namespace Modules\Quaeris\Tests\Unit\JpGraph\Chart;

use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart;
use Tests\TestCase;

final class ItalianBusinessChartTest extends TestCase
{
    public function test_italian_month_formatting(): void
    {
        $chart = new ItalianBusinessChart(800, 400);
        
        $periods = ['2024-01', '2024-02', '2024-03'];
        $formatted = $chart->formatItalianPeriods($periods);
        
        $expected = ['Gen 2024', 'Feb 2024', 'Mar 2024'];
        $this->assertEquals($expected, $formatted);
    }
    
    public function test_currency_formatting(): void
    {
        $chart = new ItalianBusinessChart(800, 400);
        
        $chart->createKPIChart([1000, 2000], ['Q1', 'Q2']);
        
        // Should format as Italian currency
        $this->assertStringContains('€', $chart->yaxis->title->GetText());
    }
}
```

## Performance Considerations

### 1. Memory Management

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Graph;

use Amenadiel\JpGraph\Graph\Graph;

/**
 * Enhanced graph with memory management
 */
final class EnhancedGraph extends Graph
{
    /**
     * Optimize memory usage for large datasets
     */
    public function optimizeMemory(): self
    {
        // Set reasonable limits
        ini_set('memory_limit', '256M');
        
        // Optimize image quality vs size
        $this->img->SetImgFormat('png');
        $this->img->SetQuality(85);
        
        return $this;
    }
    
    /**
     * Clean up resources after rendering
     */
    public function __destruct()
    {
        // Explicit cleanup
        if (isset($this->img)) {
            $this->img->Destroy();
        }
    }
}
```

### 2. Caching Strategy

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart;

/**
 * Service with intelligent caching
 */
final class CachedChartService
{
    public function createCachedChart(
        string $chartType,
        array $data,
        array $options = []
    ): string {
        $cacheKey = $this->generateCacheKey($chartType, $data, $options);
        
        return Cache::remember($cacheKey, 3600, function () use ($chartType, $data, $options) {
            return match ($chartType) {
                'kpi' => $this->createKPIChart($data, $options),
                'italian_business' => $this->createItalianBusinessChart($data, $options),
                default => throw new \InvalidArgumentException("Unknown chart type: {$chartType}")
            };
        });
    }
    
    private function generateCacheKey(string $type, array $data, array $options): string
    {
        return "chart_{$type}_" . md5(serialize([
            'data' => $data,
            'options' => $options
        ]));
    }
}
```

## Debugging & Development

### 1. Debug Helper Class

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Helpers;

/**
 * Helper for debugging JpGraph extensions
 */
final class JpGraphDebugger
{
    /**
     * Log chart generation steps
     */
    public static function logChartGeneration(string $chartType, array $data): void
    {
        if (config('app.debug')) {
            Log::info('JpGraph Chart Generation', [
                'type' => $chartType,
                'data_points' => count($data),
                'memory_usage' => memory_get_usage(true),
                'peak_memory' => memory_get_peak_usage(true)
            ]);
        }
    }
    
    /**
     * Validate chart data before processing
     */
    public static function validateChartData(array $data): bool
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Chart data cannot be empty');
        }
        
        if (count($data) > 1000) {
            Log::warning('Large dataset detected for chart generation', [
                'data_points' => count($data)
            ]);
        }
        
        foreach ($data as $value) {
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException('All data points must be numeric');
            }
        }
        
        return true;
    }
}
```

### 2. Error Handling

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Exceptions;

/**
 * Custom exception for JpGraph extensions
 */
final class JpGraphExtensionException extends \Exception
{
    public static function extensionFailed(string $method, string $reason): self
    {
        return new self("JpGraph extension failed in {$method}: {$reason}");
    }
    
    public static function invalidConfiguration(string $config): self
    {
        return new self("Invalid JpGraph configuration: {$config}");
    }
    
    public static function renderingFailed(string $chartType, string $error): self
    {
        return new self("Failed to render {$chartType} chart: {$error}");
    }
}
```

This namespace strategy provides a clean, extensible foundation for JpGraph customizations while maintaining compatibility and following Laravel best practices.