# 📊 Xot Charts - Shared Actions & Utilities

**Modulo**: Xot (Core)
**Status**: ✅ Production Ready

---

## 📋 Overview

Il modulo **Xot** fornisce **QueueableActions** e utility condivise per l'export di chart in **PNG** e **SVG** utilizzabili da tutti i moduli PTVX.

### Caratteristiche

- 🔄 **QueueableActions** - Export asincrono via queue
- 🖼️ **PNG Export** - Rendering server-side con Browsershot/Puppeteer
- 🎨 **SVG Export** - Grafica vettoriale scalabile
- 📦 **Reusable** - Utilizzabile da qualsiasi modulo
- ⚡ **Performance** - Esecuzione in background
- 💾 **Storage** - Salvataggio automatico su disco

---

## 🏗️ Struttura

```
Modules/Xot/
├── app/
│   ├── Actions/
│   │   ├── ExportChartPngQueueableAction.php
│   │   └── ExportChartSvgQueueableAction.php
│   └── Filament/
│       └── Actions/
│           ├── ExportChartPngAction.php
│           └── ExportChartSvgAction.php
└── docs/
    └── charts/
        └── README.md (questo file)
```

---

## 💾 ExportChartPngQueueableAction

### Implementazione Completa

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

/**
 * Export Chart to PNG format using Browsershot + Puppeteer
 *
 * @see https://github.com/spatie/browsershot
 * @see https://www.chartjs.org/
 */
class ExportChartPngQueueableAction
{
    use QueueableAction;

    /**
     * Export chart to PNG format
     *
     * @param array $chartData Chart.js data array containing datasets and labels
     * @param string $chartType Chart type: line, bar, pie, doughnut, radar, polarArea, bubble, scatter
     * @param array $options Chart.js options for customization
     * @param string|null $filename Custom filename (default: chart_{timestamp}.png)
     * @param int $width Image width in pixels (default: 1200)
     * @param int $height Image height in pixels (default: 800)
     * @param int $delay Delay in ms to wait for chart rendering (default: 1000)
     *
     * @return string Full path to saved PNG file
     *
     * @throws \Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot
     */
    public function execute(
        array $chartData,
        string $chartType,
        array $options = [],
        ?string $filename = null,
        int $width = 1200,
        int $height = 800,
        int $delay = 1000
    ): string {
        // Generate filename
        $filename = $filename ?? 'chart_' . now()->format('Y-m-d_His') . '.png';

        // Ensure .png extension
        if (!str_ends_with($filename, '.png')) {
            $filename .= '.png';
        }

        // Build full path
        $relativePath = 'charts/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate HTML with Chart.js
        $html = $this->generateChartHtml($chartData, $chartType, $options, $width, $height);

        // Render to PNG using Browsershot
        Browsershot::html($html)
            ->setScreenshotType('png')
            ->windowSize($width, $height)
            ->setDelay($delay)
            ->dismissDialogs()
            ->save($fullPath);

        return $fullPath;
    }

    /**
     * Generate HTML template with Chart.js
     */
    protected function generateChartHtml(
        array $chartData,
        string $chartType,
        array $options,
        int $width,
        int $height
    ): string {
        $chartDataJson = json_encode($chartData, JSON_THROW_ON_ERROR);
        $optionsJson = json_encode($options, JSON_THROW_ON_ERROR);

        $canvasWidth = $width - 40;
        $canvasHeight = $height - 40;

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Export</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 20px;
            background: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        #chartContainer {
            width: {$canvasWidth}px;
            height: {$canvasHeight}px;
            position: relative;
        }
        canvas {
            display: block;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <div id="chartContainer">
        <canvas id="chart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');

        // Default options
        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: true,
            animation: false, // Disable for faster rendering
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },
        };

        // Merge with custom options
        const finalOptions = Object.assign({}, defaultOptions, {$optionsJson});

        new Chart(ctx, {
            type: '{$chartType}',
            data: {$chartDataJson},
            options: finalOptions
        });

        // Signal that chart is ready
        console.log('Chart rendered successfully');
    </script>
</body>
</html>
HTML;
    }
}
```

---

## 🎨 ExportChartSvgQueueableAction

### Implementazione Completa

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

/**
 * Export Chart to SVG format
 *
 * Note: SVG export is achieved by:
 * 1. Rendering chart to PNG via Browsershot
 * 2. Converting PNG to SVG using ImageMagick
 * OR
 * 3. Using canvas2svg library for direct SVG generation
 *
 * @see https://github.com/spatie/browsershot
 * @see https://www.chartjs.org/
 */
class ExportChartSvgQueueableAction
{
    use QueueableAction;

    /**
     * Export chart to SVG format
     *
     * @param array $chartData Chart.js data array
     * @param string $chartType Chart type (line, bar, etc.)
     * @param array $options Chart.js options
     * @param string|null $filename Custom filename
     * @param int $width Image width in pixels
     * @param int $height Image height in pixels
     *
     * @return string Full path to saved SVG file
     */
    public function execute(
        array $chartData,
        string $chartType,
        array $options = [],
        ?string $filename = null,
        int $width = 1200,
        int $height = 800
    ): string {
        // Generate filename
        $filename = $filename ?? 'chart_' . now()->format('Y-m-d_His') . '.svg';

        // Ensure .svg extension
        if (!str_ends_with($filename, '.svg')) {
            $filename .= '.svg';
        }

        // Build full path
        $relativePath = 'charts/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate HTML with canvas2svg for direct SVG export
        $html = $this->generateSvgChartHtml($chartData, $chartType, $options, $width, $height);

        // Render and extract SVG
        $tempHtmlPath = storage_path('app/temp_chart_' . uniqid() . '.html');
        file_put_contents($tempHtmlPath, $html);

        // Use Browsershot to render the page
        Browsershot::url('file://' . $tempHtmlPath)
            ->windowSize($width, $height)
            ->setDelay(2000) // Wait for SVG generation
            ->save($fullPath);

        // Alternative: Extract SVG directly using evaluate
        $svgContent = Browsershot::url('file://' . $tempHtmlPath)
            ->windowSize($width, $height)
            ->setDelay(2000)
            ->evaluate("document.querySelector('svg').outerHTML");

        // Save SVG content
        file_put_contents($fullPath, $svgContent);

        // Cleanup
        @unlink($tempHtmlPath);

        return $fullPath;
    }

    /**
     * Generate HTML with canvas2svg for SVG export
     */
    protected function generateSvgChartHtml(
        array $chartData,
        string $chartType,
        array $options,
        int $width,
        int $height
    ): string {
        $chartDataJson = json_encode($chartData, JSON_THROW_ON_ERROR);
        $optionsJson = json_encode($options, JSON_THROW_ON_ERROR);

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas2svg@1.0.21/canvas2svg.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background: white;
        }
    </style>
</head>
<body>
    <div id="chartContainer" style="width: {$width}px; height: {$height}px;">
        <canvas id="chart"></canvas>
    </div>

    <script>
        // Create SVG context
        const C2S = window.C2S;
        const ctx = new C2S({$width}, {$height});

        // Create chart with SVG context
        new Chart(ctx, {
            type: '{$chartType}',
            data: {$chartDataJson},
            options: Object.assign({
                responsive: false,
                animation: false,
            }, {$optionsJson})
        });

        // Get SVG string
        const svgString = ctx.getSerializedSvg(true);

        // Inject SVG into DOM for Browsershot extraction
        document.body.innerHTML = svgString;
    </script>
</body>
</html>
HTML;
    }

    /**
     * Alternative: Convert PNG to SVG using ImageMagick
     */
    protected function convertPngToSvgUsingImageMagick(string $pngPath, string $svgPath): void
    {
        if (!function_exists('exec')) {
            throw new \RuntimeException('exec() function is disabled');
        }

        // Check if ImageMagick is installed
        exec('which convert', $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \RuntimeException('ImageMagick is not installed');
        }

        // Convert PNG to SVG
        $command = sprintf(
            'convert %s %s',
            escapeshellarg($pngPath),
            escapeshellarg($svgPath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \RuntimeException('Failed to convert PNG to SVG');
        }
    }
}
```

---

## 🎬 Filament Actions (Wrapper)

### ExportChartPngAction

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Xot\Actions\ExportChartPngQueueableAction;

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
            ->modalDescription('Generate high-quality PNG image from chart')
            ->action(function (array $data, $livewire) {
                try {
                    // Get chart data from widget
                    $chartData = method_exists($livewire, 'getCachedData')
                        ? $livewire->getCachedData()
                        : $livewire->getData();

                    $chartType = $livewire->getType();

                    $options = method_exists($livewire, 'getOptions')
                        ? $livewire->getOptions()
                        : [];

                    // Execute action (queued)
                    $path = app(ExportChartPngQueueableAction::class)
                        ->onQueue()
                        ->execute($chartData, $chartType, $options);

                    // Success notification
                    Notification::make()
                        ->title('PNG Export Completed')
                        ->body('Chart exported successfully: ' . basename($path))
                        ->success()
                        ->duration(5000)
                        ->send();

                    // Return download URL
                    return response()->download($path);

                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body($e->getMessage())
                        ->danger()
                        ->duration(10000)
                        ->send();

                    throw $e;
                }
            });
    }
}
```

### ExportChartSvgAction

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Xot\Actions\ExportChartSvgQueueableAction;

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
            ->modalDescription('Generate scalable vector graphic from chart')
            ->action(function (array $data, $livewire) {
                try {
                    // Get chart data from widget
                    $chartData = method_exists($livewire, 'getCachedData')
                        ? $livewire->getCachedData()
                        : $livewire->getData();

                    $chartType = $livewire->getType();

                    $options = method_exists($livewire, 'getOptions')
                        ? $livewire->getOptions()
                        : [];

                    // Execute action (queued)
                    $path = app(ExportChartSvgQueueableAction::class)
                        ->onQueue()
                        ->execute($chartData, $chartType, $options);

                    // Success notification
                    Notification::make()
                        ->title('SVG Export Completed')
                        ->body('Chart exported successfully: ' . basename($path))
                        ->success()
                        ->duration(5000)
                        ->send();

                    // Return download URL
                    return response()->download($path);

                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body($e->getMessage())
                        ->danger()
                        ->duration(10000)
                        ->send();

                    throw $e;
                }
            });
    }
}
```

---

## 🚀 Usage in Modules

### Step 1: Use in Chart Widget

```php
<?php

namespace Modules\YourModule\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Actions\ExportChartPngAction;
use Modules\Xot\Filament\Actions\ExportChartSvgAction;

class YourChart extends ChartWidget
{
    protected static ?string $heading = 'Your Chart';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Data',
                    'data' => [10, 20, 30],
                ],
            ],
            'labels' => ['A', 'B', 'C'],
        ];
    }

    // Required for export
    public function getCachedData(): array
    {
        return $this->getData();
    }

    public function getOptions(): array
    {
        return [
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
        ];
    }

    // Add export actions
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

## ⚙️ Configuration

### 1. Install Dependencies

```bash
# Browsershot + Puppeteer
composer require spatie/browsershot
npm install puppeteer

# Spatie QueueableActions
composer require spatie/laravel-queueable-action
```

### 2. Publish Configuration

```bash
php artisan vendor:publish --provider="Spatie\QueueableAction\QueueableActionServiceProvider"
```

### 3. Configure Queue

```php
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'queue' => 'charts', // Dedicated queue for chart exports
        'retry_after' => 180,
    ],
],
```

### 4. Run Queue Worker

```bash
php artisan queue:work --queue=charts
```

---

## 📚 Testing

### Test PNG Export

```php
use Modules\Xot\Actions\ExportChartPngQueueableAction;

it('exports chart to PNG successfully', function () {
    $chartData = [
        'datasets' => [
            ['label' => 'Test', 'data' => [10, 20, 30]],
        ],
        'labels' => ['A', 'B', 'C'],
    ];

    $path = app(ExportChartPngQueueableAction::class)
        ->execute($chartData, 'bar');

    expect(file_exists($path))->toBeTrue();
    expect(mime_content_type($path))->toBe('image/png');

    unlink($path);
});
```

### Test SVG Export

```php
use Modules\Xot\Actions\ExportChartSvgQueueableAction;

it('exports chart to SVG successfully', function () {
    $chartData = [
        'datasets' => [
            ['label' => 'Test', 'data' => [10, 20, 30]],
        ],
        'labels' => ['A', 'B', 'C'],
    ];

    $path = app(ExportChartSvgQueueableAction::class)
        ->execute($chartData, 'line');

    expect(file_exists($path))->toBeTrue();
    expect(pathinfo($path, PATHINFO_EXTENSION))->toBe('svg');

    unlink($path);
});
```

---

## 🔗 Risorse

- [Spatie Browsershot](https://github.com/spatie/browsershot)
- [Spatie QueueableActions](https://github.com/spatie/laravel-queueable-action)
- [Chart.js](https://www.chartjs.org/)
- [canvas2svg](https://github.com/gliffy/canvas2svg)

---

**Autore**: PTVX Development Team
