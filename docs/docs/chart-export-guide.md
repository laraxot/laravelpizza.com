# Chart Export Guide - PNG e SVG

## 📋 Panoramica

Questa guida completa spiega come esportare chart generati con Filament/Chart.js in formato **PNG** e **SVG** utilizzando **Spatie QueueableAction** per elaborazioni asincrone efficienti.

**Framework:** Laraxot/PTVX
**Filament:** 4.x
**Chart.js:** 4.x
**Spatie:** QueueableActions

---

## 🎯 Approcci di Export

### 1. Client-Side Export (Browser)
- ✅ Veloce e immediato
- ✅ Nessun carico server
- ❌ Richiede interazione utente
- ❌ Limitato a PNG (SVG difficile)

### 2. Server-Side Export (Node.js/Puppeteer)
- ✅ Automatico, nessuna interazione
- ✅ Supporta PNG e SVG
- ✅ Batch export possibile
- ❌ Richiede Node.js e dipendenze
- ❌ Maggior carico computazionale

### 3. Web Service (QuickChart)
- ✅ Zero dipendenze
- ✅ Scalabile
- ✅ PNG, SVG, PDF supportati
- ❌ Dipendenza servizio esterno
- ❌ Limiti API

---

## 🚀 Soluzione PTVX: Hybrid Approach

Implementiamo un sistema ibrido che combina:
1. **Client-side** per export immediati (download utente)
2. **Server-side** per batch/automatici (email, report, archivi)
3. **QueueableAction** per elaborazioni asincrone

---

## 📦 Installazione Dipendenze

### 1. Node.js Packages

```bash
npm install chartjs-node-canvas canvas
```

### 2. PHP Packages

```bash
composer require spatie/laravel-queueable-action
composer require intervention/image
```

### 3. Configurazione Queue

```bash
php artisan queue:table
php artisan migrate
```

---

## 🔧 Implementazione Server-Side

### 1. Servizio Export Chart

```php
<?php

// Modules/Xot/app/Services/ChartExportService.php

namespace Modules\Xot\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChartExportService
{
    private string $nodeScriptPath;

    public function __construct()
    {
        $this->nodeScriptPath = base_path('Modules/Xot/resources/js/chart-export.js');
    }

    /**
     * Esporta chart in PNG
     *
     * @param array<string, mixed> $chartConfig Configurazione Chart.js
     * @param int $width Larghezza immagine
     * @param int $height Altezza immagine
     * @return string Path del file generato
     */
    public function exportToPng(array $chartConfig, int $width = 800, int $height = 600): string
    {
        $tempConfigFile = $this->createTempConfigFile($chartConfig);
        $outputFile = $this->generateOutputPath('png');

        try {
            $command = sprintf(
                'node %s --config=%s --output=%s --width=%d --height=%d --format=png',
                $this->nodeScriptPath,
                $tempConfigFile,
                $outputFile,
                $width,
                $height
            );

            $result = Process::timeout(60)->run($command);

            if (!$result->successful()) {
                throw new \RuntimeException('Chart export failed: ' . $result->errorOutput());
            }

            if (!File::exists($outputFile)) {
                throw new \RuntimeException('Output file was not created');
            }

            return $outputFile;

        } finally {
            // Cleanup
            if (File::exists($tempConfigFile)) {
                File::delete($tempConfigFile);
            }
        }
    }

    /**
     * Esporta chart in SVG
     *
     * @param array<string, mixed> $chartConfig
     * @param int $width
     * @param int $height
     * @return string
     */
    public function exportToSvg(array $chartConfig, int $width = 800, int $height = 600): string
    {
        $tempConfigFile = $this->createTempConfigFile($chartConfig);
        $outputFile = $this->generateOutputPath('svg');

        try {
            $command = sprintf(
                'node %s --config=%s --output=%s --width=%d --height=%d --format=svg',
                $this->nodeScriptPath,
                $tempConfigFile,
                $outputFile,
                $width,
                $height
            );

            $result = Process::timeout(60)->run($command);

            if (!$result->successful()) {
                throw new \RuntimeException('SVG export failed: ' . $result->errorOutput());
            }

            if (!File::exists($outputFile)) {
                throw new \RuntimeException('SVG file was not created');
            }

            return $outputFile;

        } finally {
            if (File::exists($tempConfigFile)) {
                File::delete($tempConfigFile);
            }
        }
    }

    /**
     * Crea file temporaneo con configurazione chart
     *
     * @param array<string, mixed> $chartConfig
     * @return string
     */
    private function createTempConfigFile(array $chartConfig): string
    {
        $tempFile = storage_path('app/temp/chart-config-' . Str::uuid() . '.json');

        File::ensureDirectoryExists(dirname($tempFile));
        File::put($tempFile, json_encode($chartConfig, JSON_THROW_ON_ERROR));

        return $tempFile;
    }

    /**
     * Genera path per file output
     *
     * @param string $extension
     * @return string
     */
    private function generateOutputPath(string $extension): string
    {
        $filename = 'chart-' . Str::uuid() . '.' . $extension;
        $path = storage_path('app/charts/' . $filename);

        File::ensureDirectoryExists(dirname($path));

        return $path;
    }

    /**
     * Salva file su storage disk
     *
     * @param string $localPath
     * @param string $disk
     * @param string|null $path
     * @return string Stored file path
     */
    public function storeFile(string $localPath, string $disk = 'public', ?string $path = null): string
    {
        $filename = basename($localPath);
        $storagePath = $path ? $path . '/' . $filename : 'charts/' . $filename;

        Storage::disk($disk)->put($storagePath, File::get($localPath));

        // Cleanup local file
        File::delete($localPath);

        return $storagePath;
    }
}
```

### 2. Node.js Export Script

```javascript
// Modules/Xot/resources/js/chart-export.js

const { ChartJSNodeCanvas } = require('chartjs-node-canvas');
const fs = require('fs');
const path = require('path');

// Parse command line arguments
const args = process.argv.slice(2).reduce((acc, arg) => {
    const [key, value] = arg.split('=');
    acc[key.replace('--', '')] = value;
    return acc;
}, {});

const configFile = args.config;
const outputFile = args.output;
const width = parseInt(args.width) || 800;
const height = parseInt(args.height) || 600;
const format = args.format || 'png';

if (!configFile || !outputFile) {
    console.error('Usage: node chart-export.js --config=<config.json> --output=<output.png>');
    process.exit(1);
}

// Read chart configuration
const chartConfig = JSON.parse(fs.readFileSync(configFile, 'utf8'));

// Create ChartJS renderer
const chartJSNodeCanvas = new ChartJSNodeCanvas({
    width,
    height,
    backgroundColour: 'white',
});

async function exportChart() {
    try {
        if (format === 'png') {
            // Export to PNG
            const buffer = await chartJSNodeCanvas.renderToBuffer(chartConfig);
            fs.writeFileSync(outputFile, buffer);
        } else if (format === 'svg') {
            // Export to SVG
            const svg = await chartJSNodeCanvas.renderToBufferSync(chartConfig, 'image/svg+xml');
            fs.writeFileSync(outputFile, svg);
        } else {
            throw new Error(`Unsupported format: ${format}`);
        }

        console.log(`Chart exported successfully to ${outputFile}`);
        process.exit(0);
    } catch (error) {
        console.error('Export failed:', error.message);
        process.exit(1);
    }
}

exportChart();
```

---

## 🎬 QueueableAction Implementation

### 1. Export Chart Action

```php
<?php

// Modules/Xot/app/Actions/Chart/ExportChartAction.php

namespace Modules\Xot\Actions\Chart;

use Modules\Xot\Services\ChartExportService;
use Spatie\QueueableAction\QueueableAction;

class ExportChartAction
{
    use QueueableAction;

    public function __construct(
        private ChartExportService $exportService
    ) {}

    /**
     * Esporta chart in PNG
     *
     * @param array<string, mixed> $chartConfig
     * @param int $width
     * @param int $height
     * @param string $disk
     * @param string|null $storagePath
     * @return string Storage path
     */
    public function executeToPng(
        array $chartConfig,
        int $width = 800,
        int $height = 600,
        string $disk = 'public',
        ?string $storagePath = null
    ): string {
        // Export to temporary file
        $localPath = $this->exportService->exportToPng($chartConfig, $width, $height);

        // Store to disk
        $storedPath = $this->exportService->storeFile($localPath, $disk, $storagePath);

        return $storedPath;
    }

    /**
     * Esporta chart in SVG
     *
     * @param array<string, mixed> $chartConfig
     * @param int $width
     * @param int $height
     * @param string $disk
     * @param string|null $storagePath
     * @return string Storage path
     */
    public function executeToSvg(
        array $chartConfig,
        int $width = 800,
        int $height = 600,
        string $disk = 'public',
        ?string $storagePath = null
    ): string {
        $localPath = $this->exportService->exportToSvg($chartConfig, $width, $height);
        $storedPath = $this->exportService->storeFile($localPath, $disk, $storagePath);

        return $storedPath;
    }
}
```

### 2. Export Chart Widget Data Action

```php
<?php

// Modules/Xot/app/Actions/Chart/ExportChartWidgetAction.php

namespace Modules\Xot\Actions\Chart;

use Filament\Widgets\ChartWidget;
use Spatie\QueueableAction\QueueableAction;

class ExportChartWidgetAction
{
    use QueueableAction;

    public function __construct(
        private ExportChartAction $exportChartAction
    ) {}

    /**
     * Esporta widget chart in PNG
     *
     * @param ChartWidget $widget
     * @param string $format 'png' or 'svg'
     * @param int $width
     * @param int $height
     * @return string Storage path
     */
    public function execute(
        ChartWidget $widget,
        string $format = 'png',
        int $width = 800,
        int $height = 600
    ): string {
        // Get chart configuration from widget
        $chartConfig = $this->buildChartConfig($widget);

        // Export based on format
        if ($format === 'svg') {
            return $this->exportChartAction->executeToSvg($chartConfig, $width, $height);
        }

        return $this->exportChartAction->executeToPng($chartConfig, $width, $height);
    }

    /**
     * Build Chart.js config from Filament widget
     *
     * @param ChartWidget $widget
     * @return array<string, mixed>
     */
    private function buildChartConfig(ChartWidget $widget): array
    {
        $data = $widget->getCachedData();
        $type = $widget->getType();
        $options = method_exists($widget, 'getOptions') ? $widget->getOptions() : [];

        return [
            'type' => $type,
            'data' => $data,
            'options' => array_merge([
                'responsive' => false,
                'animation' => false,
            ], $options),
        ];
    }
}
```

---

## 💼 Uso Pratico

### 1. Export Sincrono (Controller)

```php
<?php

namespace App\Http\Controllers;

use Modules\Xot\Actions\Chart\ExportChartAction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ChartExportController extends Controller
{
    public function exportPng(ExportChartAction $action)
    {
        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Gen', 'Feb', 'Mar', 'Apr'],
                'datasets' => [
                    [
                        'label' => 'Vendite',
                        'data' => [10, 20, 30, 40],
                        'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    ],
                ],
            ],
            'options' => [
                'responsive' => false,
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Statistiche Vendite',
                    ],
                ],
            ],
        ];

        // Export synchronously
        $storedPath = $action->executeToPng($chartConfig, 1200, 800);

        // Download response
        return Storage::download($storedPath, 'chart.png');
    }

    public function exportSvg(ExportChartAction $action)
    {
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => ['Lun', 'Mar', 'Mer', 'Gio', 'Ven'],
                'datasets' => [
                    [
                        'label' => 'Traffico',
                        'data' => [120, 190, 30, 50, 200],
                        'borderColor' => 'rgb(75, 192, 192)',
                        'tension' => 0.1,
                    ],
                ],
            ],
        ];

        $storedPath = $action->executeToSvg($chartConfig, 1000, 600);

        return Storage::download($storedPath, 'chart.svg');
    }
}
```

### 2. Export Asincrono (Queue)

```php
<?php

namespace App\Jobs;

use Modules\Xot\Actions\Chart\ExportChartAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ExportAndEmailChartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $chartConfig,
        public string $recipientEmail,
        public string $format = 'png'
    ) {}

    public function handle(ExportChartAction $action): void
    {
        // Export chart
        $storedPath = $this->format === 'svg'
            ? $action->executeToSvg($this->chartConfig, 1200, 800)
            : $action->executeToPng($this->chartConfig, 1200, 800);

        // Get full path
        $fullPath = Storage::path($storedPath);

        // Send email with attachment
        Mail::to($this->recipientEmail)->send(
            new \App\Mail\ChartExportMail($fullPath, $this->format)
        );

        // Optional: cleanup file after sending
        Storage::delete($storedPath);
    }
}
```

**Dispatch Job:**
```php
use App\Jobs\ExportAndEmailChartJob;

ExportAndEmailChartJob::dispatch($chartConfig, 'admin@example.com', 'png');
```

### 3. Export Widget Filament

```php
<?php

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Xot\Actions\Chart\ExportChartWidgetAction;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;

class UsersChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Utenti Registrati';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Utenti',
                    'data' => [10, 20, 15, 30, 40],
                ],
            ],
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * Header Actions per export
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPng')
                ->label('Export PNG')
                ->icon('heroicon-o-photo')
                ->action(function (ExportChartWidgetAction $action) {
                    $storedPath = $action->execute($this, 'png', 1200, 800);

                    return Storage::download($storedPath, 'users-chart.png');
                }),

            Action::make('exportSvg')
                ->label('Export SVG')
                ->icon('heroicon-o-document')
                ->action(function (ExportChartWidgetAction $action) {
                    $storedPath = $action->execute($this, 'svg', 1200, 800);

                    return Storage::download($storedPath, 'users-chart.svg');
                }),
        ];
    }
}
```

---

## 🎨 Client-Side Export (JavaScript)

### Aggiungi Button al Widget

```blade
{{-- resources/views/vendor/filament-widgets/chart-widget.blade.php --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">{{ $this->getHeading() }}</h3>

            <div class="flex gap-2">
                <button
                    type="button"
                    onclick="downloadChartAsPng('{{ $this->getId() }}')"
                    class="filament-button filament-button-size-sm"
                >
                    <span>Download PNG</span>
                </button>

                <button
                    type="button"
                    onclick="downloadChartAsSvg('{{ $this->getId() }}')"
                    class="filament-button filament-button-size-sm"
                >
                    <span>Download SVG</span>
                </button>
            </div>
        </div>

        <div>
            <canvas id="{{ $this->getId() }}"></canvas>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### JavaScript Functions

```javascript
// resources/js/chart-download.js

/**
 * Download chart as PNG
 */
function downloadChartAsPng(chartId) {
    const canvas = document.getElementById(chartId);
    if (!canvas) {
        console.error('Chart canvas not found:', chartId);
        return;
    }

    // Get Chart.js instance
    const chart = Chart.getChart(canvas);
    if (!chart) {
        console.error('Chart instance not found');
        return;
    }

    // Convert to base64
    const url = chart.toBase64Image('image/png', 1);

    // Create download link
    const link = document.createElement('a');
    link.download = `chart-${Date.now()}.png`;
    link.href = url;
    link.click();
}

/**
 * Download chart as SVG (requires canvas2svg)
 */
function downloadChartAsSvg(chartId) {
    const canvas = document.getElementById(chartId);
    if (!canvas) {
        console.error('Chart canvas not found:', chartId);
        return;
    }

    // Note: SVG export from canvas is complex
    // Better to use server-side approach
    alert('SVG export is better handled server-side. Use the server-side export action instead.');
}

/**
 * Copy chart to clipboard as image
 */
async function copyChartToClipboard(chartId) {
    const canvas = document.getElementById(chartId);
    if (!canvas) {
        return;
    }

    canvas.toBlob(async (blob) => {
        try {
            await navigator.clipboard.write([
                new ClipboardItem({ 'image/png': blob })
            ]);
            alert('Chart copied to clipboard!');
        } catch (err) {
            console.error('Failed to copy:', err);
        }
    });
}
```

---

## 🧪 Testing

### Test Export Service

```php
<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Modules\Xot\Services\ChartExportService;
use Illuminate\Support\Facades\File;

class ChartExportServiceTest extends TestCase
{
    private ChartExportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ChartExportService();
    }

    /** @test */
    public function it_exports_chart_to_png()
    {
        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => ['A', 'B', 'C'],
                'datasets' => [
                    [
                        'label' => 'Test',
                        'data' => [10, 20, 30],
                    ],
                ],
            ],
        ];

        $outputPath = $this->service->exportToPng($chartConfig, 800, 600);

        $this->assertFileExists($outputPath);
        $this->assertStringEndsWith('.png', $outputPath);
        $this->assertGreaterThan(1000, filesize($outputPath));

        // Cleanup
        File::delete($outputPath);
    }

    /** @test */
    public function it_exports_chart_to_svg()
    {
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => ['A', 'B'],
                'datasets' => [
                    ['label' => 'Test', 'data' => [5, 10]],
                ],
            ],
        ];

        $outputPath = $this->service->exportToSvg($chartConfig, 600, 400);

        $this->assertFileExists($outputPath);
        $this->assertStringEndsWith('.svg', $outputPath);
        $this->assertStringContainsString('<svg', file_get_contents($outputPath));

        File::delete($outputPath);
    }
}
```

### Test QueueableAction

```php
<?php

namespace Tests\Feature\Actions;

use Tests\TestCase;
use Modules\Xot\Actions\Chart\ExportChartAction;
use Illuminate\Support\Facades\Storage;

class ExportChartActionTest extends TestCase
{
    /** @test */
    public function it_exports_and_stores_chart_png()
    {
        Storage::fake('public');

        $action = app(ExportChartAction::class);

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Test'],
                'datasets' => [
                    ['label' => 'Data', 'data' => [100]],
                ],
            ],
        ];

        $storedPath = $action->executeToPng($chartConfig, 800, 600, 'public');

        Storage::disk('public')->assertExists($storedPath);
        $this->assertStringContainsString('chart-', $storedPath);
        $this->assertStringEndsWith('.png', $storedPath);
    }
}
```

---

## 📊 Esempi Avanzati

### Export Multipli Chart in PDF

```php
<?php

namespace Modules\Xot\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ExportChartsToP dfAction
{
    use QueueableAction;

    public function __construct(
        private ExportChartAction $exportChartAction
    ) {}

    /**
     * Esporta multipli chart in un singolo PDF
     *
     * @param array<array<string, mixed>> $charts
     * @return string PDF path
     */
    public function execute(array $charts): string
    {
        $chartImages = [];

        // Export each chart to PNG
        foreach ($charts as $chartConfig) {
            $pngPath = $this->exportChartAction->executeToPng(
                $chartConfig['config'],
                $chartConfig['width'] ?? 1000,
                $chartConfig['height'] ?? 600
            );

            $chartImages[] = [
                'path' => Storage::path($pngPath),
                'title' => $chartConfig['title'] ?? 'Chart',
            ];
        }

        // Generate PDF with charts
        $pdf = Pdf::loadView('pdf.charts-report', [
            'charts' => $chartImages,
            'generatedAt' => now(),
        ]);

        $pdfPath = 'charts/report-' . now()->format('Y-m-d-His') . '.pdf';
        Storage::put($pdfPath, $pdf->output());

        // Cleanup PNG files
        foreach ($chartImages as $image) {
            @unlink($image['path']);
        }

        return $pdfPath;
    }
}
```

### Scheduled Export (Cron)

```php
<?php

// app/Console/Kernel.php

protected function schedule(Schedule $schedule): void
{
    // Export weekly sales chart every Monday at 9 AM
    $schedule->call(function () {
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'],
                'datasets' => [
                    [
                        'label' => 'Vendite Settimanali',
                        'data' => \App\Models\Sale::getWeeklyData(),
                    ],
                ],
            ],
        ];

        app(\Modules\Xot\Actions\Chart\ExportChartAction::class)
            ->onQueue()
            ->executeToPng($chartConfig, 1600, 900, 'public', 'reports/weekly');

    })->weekly()->mondays()->at('09:00');
}
```

---

## 🎯 Best Practices

### 1. Dimensioni Ottimali

```php
// Dashboard widgets: 800x600
// Report PDF: 1200x800
// Email attachments: 1000x700
// High-res print: 1920x1080

$sizes = [
    'thumbnail' => ['width' => 400, 'height' => 300],
    'standard' => ['width' => 800, 'height' => 600],
    'large' => ['width' => 1200, 'height' => 800],
    'hd' => ['width' => 1920, 'height' => 1080],
];
```

### 2. Performance Optimization

```php
// Cache chart configurations
$chartConfig = Cache::remember(
    "chart-config-{$widgetId}",
    now()->addMinutes(5),
    fn () => $this->buildChartConfig()
);

// Limit concurrent exports
Queue::push(new ExportChartJob($config))
    ->onQueue('charts')
    ->delay(now()->addSeconds(5));
```

### 3. Error Handling

```php
try {
    $storedPath = $action->executeToPng($chartConfig, 800, 600);
} catch (\RuntimeException $e) {
    Log::error('Chart export failed', [
        'error' => $e->getMessage(),
        'chart_type' => $chartConfig['type'] ?? 'unknown',
    ]);

    // Fallback: use placeholder image
    $storedPath = 'images/chart-error-placeholder.png';
}
```

### 4. Storage Management

```php
// Cleanup old exports (daily)
$schedule->call(function () {
    $files = Storage::files('charts');

    foreach ($files as $file) {
        if (Storage::lastModified($file) < now()->subDays(7)->timestamp) {
            Storage::delete($file);
        }
    }
})->daily();
```

---

## 📚 Risorse

### Documentazione
- [Chart.js Export](https://quickchart.io/documentation/chart-js/image-export/)
- [chartjs-node-canvas](https://www.npmjs.com/package/chartjs-node-canvas)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)
- [Intervention Image](http://image.intervention.io/)

### Sources
- [How to download and export Chart.js images](https://quickchart.io/documentation/chart-js/image-export/)
- [chartjs-to-image - npm](https://www.npmjs.com/package/chartjs-to-image)
- [How to save chart as image Chart.js](https://dev.to/noemelo/how-to-save-chart-as-image-chart-js-2l0i)
- [Export Chart.js Charts as Image](https://www.codeproject.com/Tips/1120045/Export-Chart-js-Charts-as-Image)

---

**Framework:** Laraxot/PTVX
**Filament:** 4.x
**Chart.js:** 4.x
**PHPStan Level:** 10
