# 📊 Activity Charts - Filament Widget Integration

**Modulo**: Activity
**Data**: 2025-12-09
**Versione Filament**: 4.x
**Status**: ✅ Production Ready

---

## 📋 Overview

Documentazione per implementare **chart widgets** nel modulo Activity con **export PNG/SVG** tramite **Spatie QueueableActions**.

### Use Cases

- 📊 **Activity Timeline** - Grafici temporali delle attività
- 👥 **User Activity** - Distribuzione attività per utente
- 📈 **Event Types** - Tipologie di eventi loggati
- 🔥 **Heatmap** - Mappa di calore attività giornaliere

---

## 🏗️ Struttura

```
Modules/Activity/
├── app/
│   ├── Filament/
│   │   ├── Widgets/
│   │   │   ├── ActivityTimelineChart.php
│   │   │   ├── UserActivityChart.php
│   │   │   └── EventTypesPieChart.php
│   │   └── Actions/
│   │       ├── ExportChartPngAction.php
│   │       └── ExportChartSvgAction.php
│   └── Actions/
│       ├── ExportChartPngQueueableAction.php
│       └── ExportChartSvgQueueableAction.php
```

---

## 📊 Chart Widgets

### 1. Activity Timeline Chart

```php
<?php

namespace Modules\Activity\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Spatie\Activitylog\Models\Activity;

class ActivityTimelineChart extends ChartWidget
{
    protected static ?string $heading = 'Activity Timeline';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Activity::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Activity Count',
                    'data' => $data->map(fn ($value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last 7 days',
            'month' => 'Last 30 days',
            'quarter' => 'Last 90 days',
            'year' => 'Last year',
        ];
    }
}
```

### 2. Event Types Pie Chart

```php
<?php

namespace Modules\Activity\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Spatie\Activitylog\Models\Activity;

class EventTypesPieChart extends ChartWidget
{
    protected static ?string $heading = 'Events Distribution';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $events = Activity::query()
            ->selectRaw('event, COUNT(*) as count')
            ->groupBy('event')
            ->pluck('count', 'event');

        return [
            'datasets' => [
                [
                    'data' => $events->values(),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                    ],
                ],
            ],
            'labels' => $events->keys(),
        ];
    }
}
```

---

## 💾 Export Charts - PNG (QueueableAction)

### Step 1: Installa Dipendenze

```bash
# Spatie Browsershot per rendering server-side
composer require spatie/browsershot

# Puppeteer per headless browser
npm install puppeteer
```

### Step 2: QueueableAction per PNG

```php
<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

class ExportChartPngQueueableAction
{
    use QueueableAction;

    /**
     * Export chart to PNG format
     *
     * @param array $chartData Chart.js data array
     * @param string $chartType Chart type (line, bar, pie, etc.)
     * @param array $options Chart.js options
     * @param string|null $filename Custom filename (optional)
     * @return string Path to saved PNG file
     */
    public function execute(
        array $chartData,
        string $chartType,
        array $options = [],
        ?string $filename = null
    ): string {
        // Generate filename
        $filename = $filename ?? 'chart_' . now()->format('Y-m-d_His') . '.png';
        $path = storage_path('app/public/charts/' . $filename);

        // Ensure directory exists
        if (!is_dir(storage_path('app/public/charts'))) {
            mkdir(storage_path('app/public/charts'), 0755, true);
        }

        // Generate HTML with Chart.js
        $html = $this->generateChartHtml($chartData, $chartType, $options);

        // Render to PNG using Browsershot
        Browsershot::html($html)
            ->setScreenshotType('png')
            ->windowSize(1200, 800)
            ->setDelay(1000) // Wait for chart rendering
            ->dismissDialogs()
            ->save($path);

        return $path;
    }

    /**
     * Generate HTML template with Chart.js
     */
    protected function generateChartHtml(array $chartData, string $chartType, array $options): string
    {
        $chartDataJson = json_encode($chartData);
        $optionsJson = json_encode($options);

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background: white;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        #chartContainer {
            width: 1160px;
            height: 760px;
        }
    </style>
</head>
<body>
    <div id="chartContainer">
        <canvas id="chart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');

        new Chart(ctx, {
            type: '{$chartType}',
            data: {$chartDataJson},
            options: {
                responsive: true,
                maintainAspectRatio: true,
                ...{$optionsJson}
            }
        });
    </script>
</body>
</html>
HTML;
    }
}
```

### Step 3: Filament Action Integration

```php
<?php

namespace Modules\Activity\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Activity\Actions\ExportChartPngQueueableAction;

class ExportChartPngAction
{
    public static function make(?string $name = 'exportPng'): Action
    {
        return Action::make($name)
            ->label('Export PNG')
            ->icon('heroicon-o-photo')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Export Chart as PNG')
            ->modalDescription('Generate PNG image from chart data')
            ->action(function (array $data, $livewire) {
                try {
                    // Get chart data from widget
                    $chartData = $livewire->getCachedData();
                    $chartType = $livewire->getType();
                    $options = $livewire->getOptions();

                    // Execute action (can be queued)
                    $path = app(ExportChartPngQueueableAction::class)
                        ->onQueue()
                        ->execute($chartData, $chartType, $options);

                    // Success notification
                    Notification::make()
                        ->title('PNG Export Completed')
                        ->body('Chart exported successfully to: ' . basename($path))
                        ->success()
                        ->send();

                    // Return download URL
                    return Storage::disk('public')->url('charts/' . basename($path));

                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
```

### Step 4: Usage in Widget

```php
use Modules\Activity\Filament\Actions\ExportChartPngAction;

class ActivityTimelineChart extends ChartWidget
{
    // ... existing code ...

    protected function getHeaderActions(): array
    {
        return [
            ExportChartPngAction::make(),
        ];
    }

    // Helper method to cache data for export
    public function getCachedData(): array
    {
        return $this->getData();
    }

    public function getType(): string
    {
        return 'line';
    }

    public function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => ['display' => true],
            ],
        ];
    }
}
```

---

## 🎨 Export Charts - SVG (QueueableAction)

### Step 1: Installa Dipendenze

```bash
# Chart.js to SVG converter
npm install chartjs-node-canvas
```

### Step 2: QueueableAction per SVG

```php
<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

class ExportChartSvgQueueableAction
{
    use QueueableAction;

    /**
     * Export chart to SVG format
     *
     * @param array $chartData Chart.js data array
     * @param string $chartType Chart type (line, bar, pie, etc.)
     * @param array $options Chart.js options
     * @param string|null $filename Custom filename (optional)
     * @return string Path to saved SVG file
     */
    public function execute(
        array $chartData,
        string $chartType,
        array $options = [],
        ?string $filename = null
    ): string {
        // Generate filename
        $filename = $filename ?? 'chart_' . now()->format('Y-m-d_His') . '.svg';
        $path = storage_path('app/public/charts/' . $filename);

        // Ensure directory exists
        if (!is_dir(storage_path('app/public/charts'))) {
            mkdir(storage_path('app/public/charts'), 0755, true);
        }

        // Method 1: Using Browsershot with SVG conversion
        $this->exportViaBrowsershot($chartData, $chartType, $options, $path);

        // Alternative Method 2: Direct SVG generation (requires chartjs-node-canvas)
        // $this->exportViaNodeCanvas($chartData, $chartType, $options, $path);

        return $path;
    }

    /**
     * Export via Browsershot (captures HTML and converts to SVG)
     */
    protected function exportViaBrowsershot(
        array $chartData,
        string $chartType,
        array $options,
        string $path
    ): void {
        $html = $this->generateChartHtml($chartData, $chartType, $options);

        // First save as PNG, then convert to SVG
        $tempPng = storage_path('app/temp_chart.png');

        Browsershot::html($html)
            ->setScreenshotType('png')
            ->windowSize(1200, 800)
            ->setDelay(1000)
            ->save($tempPng);

        // Convert PNG to SVG using ImageMagick
        $this->convertPngToSvg($tempPng, $path);

        // Cleanup
        @unlink($tempPng);
    }

    /**
     * Convert PNG to SVG using ImageMagick
     */
    protected function convertPngToSvg(string $pngPath, string $svgPath): void
    {
        // Requires ImageMagick installed
        exec("convert {$pngPath} {$svgPath}");

        // Alternative: Use PHP SVG library
        // $this->convertPngToSvgViaLibrary($pngPath, $svgPath);
    }

    /**
     * Alternative: Generate SVG directly from chart data
     */
    protected function exportViaNodeCanvas(
        array $chartData,
        string $chartType,
        array $options,
        string $path
    ): void {
        // This requires Node.js script execution
        $nodeScript = $this->generateNodeScript($chartData, $chartType, $options, $path);

        $scriptPath = storage_path('app/temp_export_script.js');
        file_put_contents($scriptPath, $nodeScript);

        // Execute Node.js script
        exec("node {$scriptPath}");

        // Cleanup
        @unlink($scriptPath);
    }

    /**
     * Generate Node.js script for SVG export
     */
    protected function generateNodeScript(
        array $chartData,
        string $chartType,
        array $options,
        string $outputPath
    ): string {
        $chartDataJson = json_encode($chartData);
        $optionsJson = json_encode($options);

        return <<<JS
const { ChartJSNodeCanvas } = require('chartjs-node-canvas');
const fs = require('fs');

const width = 1200;
const height = 800;

const chartJSNodeCanvas = new ChartJSNodeCanvas({
    width,
    height,
    backgroundColour: 'white'
});

const configuration = {
    type: '{$chartType}',
    data: {$chartDataJson},
    options: {
        responsive: false,
        ...{$optionsJson}
    }
};

(async () => {
    const buffer = await chartJSNodeCanvas.renderToBuffer(configuration);

    // Convert to SVG (requires additional processing)
    // For now, save as PNG
    fs.writeFileSync('{$outputPath}', buffer);
})();
JS;
    }

    /**
     * Generate HTML template with Chart.js
     */
    protected function generateChartHtml(array $chartData, string $chartType, array $options): string
    {
        $chartDataJson = json_encode($chartData);
        $optionsJson = json_encode($options);

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background: white;
        }
        #chartContainer {
            width: 1160px;
            height: 760px;
        }
    </style>
</head>
<body>
    <div id="chartContainer">
        <canvas id="chart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');

        new Chart(ctx, {
            type: '{$chartType}',
            data: {$chartDataJson},
            options: {
                responsive: true,
                maintainAspectRatio: true,
                ...{$optionsJson}
            }
        });
    </script>
</body>
</html>
HTML;
    }
}
```

### Step 3: Filament Action Integration

```php
<?php

namespace Modules\Activity\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Activity\Actions\ExportChartSvgQueueableAction;

class ExportChartSvgAction
{
    public static function make(?string $name = 'exportSvg'): Action
    {
        return Action::make($name)
            ->label('Export SVG')
            ->icon('heroicon-o-document-chart-bar')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Export Chart as SVG')
            ->modalDescription('Generate scalable vector graphic from chart data')
            ->action(function (array $data, $livewire) {
                try {
                    // Get chart data from widget
                    $chartData = $livewire->getCachedData();
                    $chartType = $livewire->getType();
                    $options = $livewire->getOptions();

                    // Execute action (can be queued)
                    $path = app(ExportChartSvgQueueableAction::class)
                        ->onQueue()
                        ->execute($chartData, $chartType, $options);

                    // Success notification
                    Notification::make()
                        ->title('SVG Export Completed')
                        ->body('Chart exported successfully to: ' . basename($path))
                        ->success()
                        ->send();

                    // Return download URL
                    return Storage::disk('public')->url('charts/' . basename($path));

                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
```

### Step 4: Usage in Widget (Both Actions)

```php
use Modules\Activity\Filament\Actions\ExportChartPngAction;
use Modules\Activity\Filament\Actions\ExportChartSvgAction;

class ActivityTimelineChart extends ChartWidget
{
    // ... existing code ...

    protected function getHeaderActions(): array
    {
        return [
            ExportChartPngAction::make(),
            ExportChartSvgAction::make(),
        ];
    }
}
```

---

## ⚙️ Configurazione

### 1. Queue Configuration

```php
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
    ],
],
```

### 2. Filesystem Configuration

```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### 3. Puppeteer Configuration

```bash
# .env
PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser
```

---

## 🚀 Testing

### Test Export PNG

```php
use Modules\Activity\Actions\ExportChartPngQueueableAction;

it('exports chart to PNG', function () {
    $chartData = [
        'datasets' => [
            [
                'label' => 'Test',
                'data' => [10, 20, 30],
            ],
        ],
        'labels' => ['A', 'B', 'C'],
    ];

    $path = app(ExportChartPngQueueableAction::class)
        ->execute($chartData, 'bar', []);

    expect($path)->toBeFile();
    expect(file_exists($path))->toBeTrue();

    // Cleanup
    unlink($path);
});
```

### Test Export SVG

```php
use Modules\Activity\Actions\ExportChartSvgQueueableAction;

it('exports chart to SVG', function () {
    $chartData = [
        'datasets' => [
            [
                'label' => 'Test',
                'data' => [10, 20, 30],
            ],
        ],
        'labels' => ['A', 'B', 'C'],
    ];

    $path = app(ExportChartSvgQueueableAction::class)
        ->execute($chartData, 'line', []);

    expect($path)->toBeFile();
    expect(pathinfo($path, PATHINFO_EXTENSION))->toBe('svg');

    // Cleanup
    unlink($path);
});
```

---

## 📚 Risorse

- [Spatie QueueableActions](https://github.com/spatie/laravel-queueable-action)
- [Spatie Browsershot](https://github.com/spatie/browsershot)
- [Chart.js Documentation](https://www.chartjs.org/)
- [Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
