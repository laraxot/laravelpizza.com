# Filament Chart Widget Installation and Configuration Guide

## Overview

This document provides comprehensive guidance on implementing and configuring Filament 5.x ChartWidgets in the Chart module, following Laraxot architectural patterns and best practices for data visualization.

## Filament Installation Requirements

The Chart module follows the standard Filament 5.x installation requirements:
- PHP 8.2+
- Laravel v11.28+
- Tailwind CSS v4.1+
- Filament v5.0+
- Chart.js v4.4.0+

### Required Dependencies

Install core Filament components:
```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
```

Install Chart.js dependencies:
```bash
npm install chart.js@^4.4.0 chartjs-plugin-datalabels@^2.2.0 chartjs-plugin-annotation@^3.0.1 chartjs-plugin-zoom@^2.0.1 --save-dev
```

## Chart Module Architecture

### Base Chart Widget Structure

The Chart module provides a comprehensive architecture for chart creation:

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

// Base action for chart processing
class ProcessChartDataAction
{
    public function execute(array $rawData, string $chartType): array
    {
        return [
            'datasets' => $this->processDatasets($rawData, $chartType),
            'labels' => $this->processLabels($rawData),
        ];
    }
    
    private function processDatasets(array $rawData, string $chartType): array
    {
        // Process data based on chart type
        return match($chartType) {
            'bar', 'line' => $this->processBarLineData($rawData),
            'doughnut', 'pie' => $this->processPieData($rawData),
            default => $this->processDefaultData($rawData),
        };
    }
    
    private function processLabels(array $rawData): array
    {
        return array_column($rawData, 'label');
    }
}
```

## Chart Widget Implementation

### Sample Chart Widget Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class SampleChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Sample Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sample Data',
                    'data' => [12, 19, 3, 5, 2, 3, 9],
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Sample Chart Title',
                ],
            ],
        ];
    }
}
```

### Advanced Chart Types

#### Bar Chart Widget

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class BarChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Bar Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [10, 20, 30, 40, 50],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
```

#### Doughnut Chart Widget

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class DoughnutChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Doughnut Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Distribution',
                    'data' => [300, 50, 100],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                    ],
                ],
            ],
            'labels' => ['Red', 'Blue', 'Yellow'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
```

## Implementation Rules for Chart Module

### 1. ChartWidget Extension Rule
❌ **WRONG**: `extends ChartWidget`
```php
use Filament\Widgets\ChartWidget;

class MyChartWidget extends ChartWidget { }
```

✅ **CORRECT**: `extends XotBaseChartWidget`
```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class MyChartWidget extends XotBaseChartWidget { }
```

### 2. Data Processing Actions

Always use dedicated actions for complex data processing:

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

class ProcessSurveyDataAction
{
    public function execute(string $surveyId, array $filters = []): array
    {
        // Process survey data
        $data = $this->fetchSurveyData($surveyId, $filters);
        
        return [
            'datasets' => $this->buildDatasets($data),
            'labels' => $this->buildLabels($data),
        ];
    }
    
    private function buildDatasets(array $data): array
    {
        // Build chart datasets from raw data
    }
    
    private function buildLabels(array $data): array
    {
        // Build chart labels from raw data
    }
}
```

### 3. Chart Data Structure

Use the AnswersChartData class for standardized data processing:

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

class AnswersChartData
{
    public function getChartJsType(): string
    {
        // Return chart.js type
    }
    
    public function getChartJsData(): array
    {
        // Return chart.js data structure
    }
    
    public function getChartJsOptionsArray(): array
    {
        // Return chart.js options
    }
    
    public function getChartJsOptionsJs(): \Filament\Support\RawJs
    {
        // Return chart.js options as RawJs
    }
}
```

## Chart Export Functionality

### PNG Export Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Widget;

class SaveChartWidgetAsPngAction
{
    public function execute(
        \Filament\Widgets\ChartWidget $widget, 
        array $chartData, 
        string $chartType, 
        array $options
    ): string {
        // Use Browsershot to generate PNG from chart HTML
        $html = $this->generateChartHtml($widget, $chartData, $chartType, $options);
        
        return \Spatie\Browsershot\Browsershot::html($html)
            ->windowSize(800, 600)
            ->screenshot();
    }
    
    private function generateChartHtml($widget, $chartData, $chartType, $options): string
    {
        // Generate HTML with Chart.js embedded
        return view('chart::export.template', [
            'chartData' => $chartData,
            'chartType' => $chartType,
            'options' => $options,
            'chartId' => 'chart-' . uniqid(),
        ])->render();
    }
}
```

### SVG Export Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Widget;

class SaveChartWidgetAsSvgAction
{
    public function execute(
        \Filament\Widgets\ChartWidget $widget, 
        array $chartData, 
        string $chartType, 
        array $options
    ): string {
        // Since Chart.js doesn't natively support SVG, 
        // we generate high-quality PNG and embed in SVG wrapper
        $pngData = app(SaveChartWidgetAsPngAction::class)
            ->execute($widget, $chartData, $chartType, $options);
        
        $pngBase64 = base64_encode($pngData);
        
        return $this->wrapInSvg($pngBase64, 800, 600);
    }
    
    private function wrapInSvg(string $pngBase64, int $width, int $height): string
    {
        return <<<SVG
        <svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
            <image href="data:image/png;base64,{$pngBase64}" width="{$width}" height="{$height}"/>
        </svg>
        SVG;
    }
}
```

## Chart Configuration and Options

### Advanced Chart Options

```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'top',
                'labels' => [
                    'usePointStyle' => true,
                    'padding' => 20,
                ],
            ],
            'tooltip' => [
                'mode' => 'index',
                'intersect' => false,
                'callbacks' => [
                    'label' => \Filament\Support\RawJs::make('function(context) {
                        let label = context.dataset.label || "";
                        if (label) {
                            label += ": ";
                        }
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat().format(context.parsed.y);
                        }
                        return label;
                    }'),
                ],
            ],
            'datalabels' => [
                'anchor' => 'end',
                'align' => 'top',
                'formatter' => \Filament\Support\RawJs::make('Math.round'),
            ],
        ],
        'scales' => [
            'x' => [
                'display' => true,
                'title' => [
                    'display' => true,
                    'text' => 'Categories',
                ],
            ],
            'y' => [
                'display' => true,
                'title' => [
                    'display' => true,
                    'text' => 'Values',
                ],
                'beginAtZero' => true,
            ],
        ],
        'interaction' => [
            'mode' => 'nearest',
            'axis' => 'x',
            'intersect' => false,
        ],
    ];
}
```

## Frontend Asset Configuration

### Vite Configuration for Chart Module

```javascript
// Modules/Chart/vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
            output: {
                globals: {
                    'chart.js': 'Chart',
                    'chart.js/helpers': 'Chart.helpers',
                    'chartjs-plugin-datalabels': 'ChartDataLabels',
                },
            },
        },
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/chart',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/app.js'),
                resolve(__dirname, 'resources/js/filament-chart-js-plugins')
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### Chart.js Plugin Registration

```javascript
// Modules/Chart/resources/js/filament-chart-js-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

## Performance Optimization

### Chart Caching

```php
protected function getData(): array
{
    $cacheKey = 'chart_data_' . md5(serialize([
        'type' => static::class,
        'filters' => $this->filter,
        'user_id' => auth()->id(),
    ]));
    
    return cache()->remember(
        $cacheKey,
        now()->addMinutes(15),
        function () {
            return $this->buildChartData();
        }
    );
}

private function buildChartData(): array
{
    // Expensive chart data building logic
    return [
        'datasets' => [],
        'labels' => [],
    ];
}
```

### Lazy Loading

Enable lazy loading for performance:

```php
class MyChartWidget extends XotBaseChartWidget
{
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = '5min'; // Only if real-time updates needed
}
```

## Security Considerations

### Data Sanitization

Always sanitize chart data to prevent XSS:

```php
protected function getData(): array
{
    $rawData = $this->fetchRawData();
    
    return [
        'datasets' => array_map(function ($dataset) {
            return [
                'label' => e($dataset['label']), // Escape labels
                'data' => array_map('intval', $dataset['data']), // Validate numeric data
            ];
        }, $rawData['datasets']),
        'labels' => array_map('e', $rawData['labels']), // Escape labels
    ];
}
```

### Authorization

Implement proper authorization:

```php
protected function getData(): array
{
    if (!auth()->user()->can('view-charts')) {
        throw new \Illuminate\Auth\Access\AuthorizationException('Unauthorized to view charts');
    }
    
    // Fetch and return chart data...
}
```

## Testing

Create comprehensive tests for chart functionality:

```php
// PestPHP tests
it('renders chart with correct data structure', function () {
    $widget = new SampleChartWidget();
    $data = $widget->getData();
    
    expect($data)->toBeArray()
        ->toHaveKeys(['datasets', 'labels'])
        ->and($data['datasets'])->toBeArray()
        ->and($data['labels'])->toBeArray();
});

it('returns correct chart type', function () {
    $widget = new SampleChartWidget();
    expect($widget->getType())->toBeString();
});

it('has proper chart heading', function () {
    $widget = new SampleChartWidget();
    $heading = $widget->getHeading();
    expect($heading)->toBeString()->and($heading)->not->toBeEmpty();
});
```

## Export Capabilities

### Multi-format Export

```php
class ChartExportService
{
    public function export(\Filament\Widgets\ChartWidget $widget, string $format): string
    {
        return match($format) {
            'png' => app(SaveChartWidgetAsPngAction::class)->execute($widget),
            'svg' => app(SaveChartWidgetAsSvgAction::class)->execute($widget),
            'pdf' => $this->exportToPdf($widget),
            default => throw new \InvalidArgumentException("Unsupported format: {$format}")
        };
    }
    
    private function exportToPdf($widget): string
    {
        // Export chart to PDF using Spatie PDF generator
        $pngData = app(SaveChartWidgetAsPngAction::class)->execute($widget);
        
        return \Spatie\LaravelPdf\Facades\Pdf::loadHTML(
            '<img src="data:image/png;base64,' . base64_encode($pngData) . '" style="width:100%;">'
        )->download('chart.pdf');
    }
}
```

This comprehensive guide provides all necessary information for implementing and configuring Filament ChartWidgets in the Chart module while following Laraxot architectural patterns and best practices.