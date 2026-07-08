# Chart Generation Actions - Spatie Queueable Guide

## 📋 Overview

Guida completa per creare Actions Spatie Queueable che generano chart SVG e PNG utilizzando le best practices di Laraxot/PTVX.

---

## 🎯 Architettura Chart Generation

### 1. Struttura Base Actions

Le Actions per la generazione di chart seguono questa struttura:

```
Modules/Xot/app/Actions/Chart/
├── GenerateSvgChartAction.php           # Generazione SVG
├── GeneratePngChartAction.php           # Generazione PNG
├── GenerateChartReportAction.php         # Report con chart
└── Services/
    ├── ChartSvgBuilder.php              # Builder per SVG
    ├── ChartPngConverter.php             # Conversione SVG→PNG
    └── ChartDataProvider.php            # Dati per chart
```

---

## 🎨 Generazione Chart SVG

### 1. SVG Chart Action

```php
<?php

namespace Modules\Xot\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Modules\Xot\Services\Chart\ChartSvgBuilder;
use Modules\Xot\Services\Chart\ChartDataProvider;

class GenerateSvgChartAction extends QueueableAction
{
    public function __construct(
        private string $chartType,
        private array $data,
        private array $options = []
    ) {
        $this->onQueue('charts');
    }

    public function execute(): string
    {
        try {
            $dataProvider = new ChartDataProvider();
            $svgBuilder = new ChartSvgBuilder();

            // Prepara dati
            $chartData = $dataProvider->prepareData($this->data, $this->chartType);

            // Genera SVG
            $svg = $svgBuilder->build($this->chartType, $chartData, $this->options);

            // Log attività
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'chart_type' => $this->chartType,
                    'data_points' => count($chartData),
                    'svg_size' => strlen($svg),
                ])
                ->log('SVG chart generated');

            return $svg;

        } catch (\Exception $e) {
            Log::error('SVG chart generation failed', [
                'chart_type' => $this->chartType,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function getUniqueId(): string
    {
        return 'svg_chart_' . md5(json_encode([
            'type' => $this->chartType,
            'data' => $this->data,
            'options' => $this->options,
        ]));
    }
}
```

### 2. SVG Chart Builder

```php
<?php

namespace Modules\Xot\Services\Chart;

class ChartSvgBuilder
{
    public function build(string $type, array $data, array $options = []): string
    {
        return match($type) {
            'line' => $this->buildLineChart($data, $options),
            'bar' => $this->buildBarChart($data, $options),
            'pie' => $this->buildPieChart($data, $options),
            'area' => $this->buildAreaChart($data, $options),
            default => throw new \InvalidArgumentException("Unsupported chart type: {$type}"),
        };
    }

    private function buildLineChart(array $data, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;
        $padding = $options['padding'] ?? 50;

        // Calcola scale
        $xScale = ($width - 2 * $padding) / (count($data) - 1);
        $yMax = max(array_column($data, 'value'));
        $yScale = ($height - 2 * $padding) / $yMax;

        // Genera punti
        $points = [];
        foreach ($data as $index => $point) {
            $x = $padding + $index * $xScale;
            $y = $height - $padding - ($point['value'] * $yScale);
            $points[] = "{$x},{$y}";
        }

        // Costruisci SVG
        $svg = <<<SVG
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
    <!-- Grid -->
    <g stroke="#e0e0e0" stroke-width="1">
        <line x1="{$padding}" y1="{$padding}" x2="{$width - $padding}" y2="{$padding}" />
        <line x1="{$padding}" y1="{$height - $padding}" x2="{$width - $padding}" y2="{$height - $padding}" />
    </g>

    <!-- Chart Line -->
    <polyline points="{$points}"
              fill="none"
              stroke="#3498db"
              stroke-width="2" />

    <!-- Data Points -->
    <g fill="#3498db">
        {$this->generateCirclePoints($data, $padding, $xScale, $yScale, $height)}
    </g>

    <!-- Labels -->
    <g font-family="Arial, sans-serif" font-size="12" fill="#666">
        {$this->generateXLabels($data, $padding, $xScale, $height)}
        {$this->generateYLabels($yMax, $padding, $height - $padding, $height)}
    </g>
</svg>
SVG;

        return $svg;
    }

    private function buildBarChart(array $data, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;
        $padding = $options['padding'] ?? 50;

        $barWidth = ($width - 2 * $padding) / count($data) * 0.8;
        $barSpacing = ($width - 2 * $padding) / count($data) * 0.2;
        $yMax = max(array_column($data, 'value'));
        $yScale = ($height - 2 * $padding) / $yMax;

        $bars = '';
        foreach ($data as $index => $item) {
            $x = $padding + $index * ($barWidth + $barSpacing);
            $barHeight = $item['value'] * $yScale;
            $y = $height - $padding - $barHeight;

            $color = $this->getBarColor($index, count($data));

            $bars .= <<<BAR
    <rect x="{$x}" y="{$y}" width="{$barWidth}" height="{$barHeight}"
          fill="{$color}" rx="2" />
    <text x="{$x + $barWidth/2}" y="{$height - $padding + 20}"
          text-anchor="middle" font-size="12" fill="#666">{$item['label']}</text>
BAR;
        }

        return <<<SVG
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
    <!-- Grid -->
    <g stroke="#e0e0e0" stroke-width="1">
        <line x1="{$padding}" y1="{$padding}" x2="{$width - $padding}" y2="{$padding}" />
        <line x1="{$padding}" y1="{$height - $padding}" x2="{$width - $padding}" y2="{$height - $padding}" />
    </g>

    <!-- Bars -->
    {$bars}

    <!-- Y-Axis Labels -->
    <g font-family="Arial, sans-serif" font-size="12" fill="#666">
        {$this->generateYLabels($yMax, $padding, $height - $padding, $height)}
    </g>
</svg>
SVG;
    }

    private function buildPieChart(array $data, array $options): string
    {
        $width = $options['width'] ?? 400;
        $height = $options['height'] ?? 400;
        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = min($width, $height) / 2 - 50;

        $total = array_sum(array_column($data, 'value'));
        $currentAngle = -90; // Start from top

        $slices = '';
        foreach ($data as $index => $item) {
            $percentage = $item['value'] / $total;
            $angle = $percentage * 360;
            $endAngle = $currentAngle + $angle;

            $slice = $this->generatePieSlice($centerX, $centerY, $radius, $currentAngle, $endAngle, $this->getPieColor($index));
            $slices .= $slice;

            // Add label
            $labelAngle = $currentAngle + $angle / 2;
            $labelX = $centerX + cos(deg2rad($labelAngle)) * ($radius * 0.7);
            $labelY = $centerY + sin(deg2rad($labelAngle)) * ($radius * 0.7);

            $slices .= <<<LABEL
    <text x="{$labelX}" y="{$labelY}" text-anchor="middle"
          font-size="12" fill="#fff" font-weight="bold">
        {$item['label']} ({$percentage}%)
    </text>
LABEL;

            $currentAngle = $endAngle;
        }

        return <<<SVG
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
    <!-- Pie Slices -->
    {$slices}

    <!-- Legend -->
    <g font-family="Arial, sans-serif" font-size="12">
        {$this->generatePieLegend($data, 20, $height - 20)}
    </g>
</svg>
SVG;
    }

    private function generateCirclePoints(array $data, int $padding, float $xScale, float $yScale, int $height): string
    {
        $points = '';
        foreach ($data as $index => $point) {
            $x = $padding + $index * $xScale;
            $y = $height - $padding - ($point['value'] * $yScale);
            $points .= "<circle cx=\"{$x}\" cy=\"{$y}\" r=\"4\" />";
        }
        return $points;
    }

    private function generateXLabels(array $data, int $padding, float $xScale, int $height): string
    {
        $labels = '';
        foreach ($data as $index => $point) {
            $x = $padding + $index * $xScale;
            $labels .= "<text x=\"{$x}\" y=\"{$height - $padding + 20}\" text-anchor=\"middle\">{$point['label']}</text>";
        }
        return $labels;
    }

    private function generateYLabels(float $max, int $padding, int $bottom, int $height): string
    {
        $labels = '';
        $steps = 5;

        for ($i = 0; $i <= $steps; $i++) {
            $value = ($max / $steps) * $i;
            $y = $bottom - (($bottom - $padding) / $steps) * $i;
            $labels .= "<text x=\"{$padding - 10}\" y=\"{$y}\" text-anchor=\"end\">{$value}</text>";
        }

        return $labels;
    }

    private function getBarColor(int $index, int $total): string
    {
        $colors = ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6'];
        return $colors[$index % count($colors)];
    }

    private function getPieColor(int $index): string
    {
        $colors = ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#34495e'];
        return $colors[$index % count($colors)];
    }

    private function generatePieSlice(float $cx, float $cy, float $r, float $startAngle, float $endAngle, string $color): string
    {
        $x1 = $cx + $r * cos(deg2rad($startAngle));
        $y1 = $cy + $r * sin(deg2rad($startAngle));
        $x2 = $cx + $r * cos(deg2rad($endAngle));
        $y2 = $cy + $r * sin(deg2rad($endAngle));

        $largeArc = ($endAngle - $startAngle) > 180 ? 1 : 0;

        return "<path d=\"M {$cx} {$cy} L {$x1} {$y1} A {$r} {$r} 0 {$largeArc} 1 {$x2} {$y2} Z\" fill=\"{$color}\" />";
    }

    private function generatePieLegend(array $data, int $x, int $y): string
    {
        $legend = '';
        foreach ($data as $index => $item) {
            $color = $this->getPieColor($index);
            $legendY = $y + $index * 20;

            $legend .= <<<LEGEND
    <rect x="{$x}" y="{$legendY}" width="15" height="15" fill="{$color}" />
    <text x="{$x + 20}" y="{$legendY + 12}" font-size="12">{$item['label']}</text>
LEGEND;
        }

        return $legend;
    }
}
```

---

## 🖼️ Generazione Chart PNG

### 1. PNG Chart Action

```php
<?php

namespace Modules\Xot\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Modules\Xot\Services\Chart\ChartSvgBuilder;
use Modules\Xot\Services\Chart\ChartPngConverter;

class GeneratePngChartAction extends QueueableAction
{
    public function __construct(
        private string $chartType,
        private array $data,
        private array $options = []
    ) {
        $this->onQueue('charts');
    }

    public function execute(): string
    {
        try {
            // 1. Genera SVG
            $svgBuilder = new ChartSvgBuilder();
            $svg = $svgBuilder->build($this->chartType, $this->data, $this->options);

            // 2. Converti in PNG
            $converter = new ChartPngConverter();
            $png = $converter->convertSvgToPng($svg, $this->options);

            // Log attività
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'chart_type' => $this->chartType,
                    'data_points' => count($this->data),
                    'png_size' => strlen($png),
                ])
                ->log('PNG chart generated');

            return $png;

        } catch (\Exception $e) {
            Log::error('PNG chart generation failed', [
                'chart_type' => $this->chartType,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function getUniqueId(): string
    {
        return 'png_chart_' . md5(json_encode([
            'type' => $this->chartType,
            'data' => $this->data,
            'options' => $this->options,
        ]));
    }
}
```

### 2. PNG Converter Service

```php
<?php

namespace Modules\Xot\Services\Chart;

use Imagick;

class ChartPngConverter
{
    public function convertSvgToPng(string $svg, array $options = []): string
    {
        try {
            // Crea Imagick instance
            $imagick = new Imagick();

            // Imposta opzioni
            $width = $options['width'] ?? 800;
            $height = $options['height'] ?? 400;
            $dpi = $options['dpi'] ?? 150;

            // Carica SVG
            $imagick->readImageBlob($svg);

            // Imposta dimensioni e qualità
            $imagick->setImageFormat('png');
            $imagick->setImageResolution($dpi, $dpi);
            $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);

            // Imposta qualità PNG
            $imagick->setOption('png:compression-level', 6);
            $imagick->setOption('png:compression-strategy', 1);

            // Ottieni PNG binary
            $png = $imagick->getImageBlob();

            // Pulisci
            $imagick->clear();
            $imagick->destroy();

            return $png;

        } catch (\ImagickException $e) {
            throw new \RuntimeException("Failed to convert SVG to PNG: " . $e->getMessage());
        }
    }

    public function convertSvgToPngWithFallback(string $svg, array $options = []): string
    {
        try {
            return $this->convertSvgToPng($svg, $options);
        } catch (\Exception $e) {
            // Fallback: salva SVG e restituisci placeholder
            Log::warning('PNG conversion failed, using SVG fallback', [
                'error' => $e->getMessage(),
            ]);

            // Crea un PNG placeholder con testo
            return $this->createPlaceholderPng($options);
        }
    }

    private function createPlaceholderPng(array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;

        $imagick = new Imagick();
        $imagick->newImage($width, $height, '#f0f0f0');
        $imagick->setImageFormat('png');

        // Aggiungi testo placeholder
        $draw = new \ImagickDraw();
        $draw->setFontSize(24);
        $draw->setFillColor('#666');
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
        $draw->annotation($width / 2, $height / 2, 'Chart Generation Failed');

        $imagick->drawImage($draw);

        $png = $imagick->getImageBlob();

        $imagick->clear();
        $imagick->destroy();

        return $png;
    }
}
```

---

## 📊 Data Provider

### Chart Data Provider

```php
<?php

namespace Modules\Xot\Services\Chart;

class ChartDataProvider
{
    public function prepareData(array $rawData, string $chartType): array
    {
        return match($chartType) {
            'line', 'bar' => $this->prepareXYData($rawData),
            'pie' => $this->preparePieData($rawData),
            'area' => $this->prepareAreaData($rawData),
            default => throw new \InvalidArgumentException("Unsupported chart type: {$chartType}"),
        };
    }

    private function prepareXYData(array $rawData): array
    {
        return array_map(function ($item) {
            return [
                'label' => $item['label'] ?? '',
                'value' => (float) ($item['value'] ?? 0),
                'color' => $item['color'] ?? null,
            ];
        }, $rawData);
    }

    private function preparePieData(array $rawData): array
    {
        $total = array_sum(array_column($rawData, 'value'));

        return array_map(function ($item) use ($total) {
            return [
                'label' => $item['label'] ?? '',
                'value' => (float) ($item['value'] ?? 0),
                'percentage' => $total > 0 ? (($item['value'] / $total) * 100) : 0,
                'color' => $item['color'] ?? null,
            ];
        }, $rawData);
    }

    private function prepareAreaData(array $rawData): array
    {
        // Per area chart, prepariamo dati con fill
        return $this->prepareXYData($rawData);
    }

    public function generateSampleData(string $chartType, int $points = 10): array
    {
        return match($chartType) {
            'line' => $this->generateLineSampleData($points),
            'bar' => $this->generateBarSampleData($points),
            'pie' => $this->generatePieSampleData(5),
            'area' => $this->generateAreaSampleData($points),
            default => [],
        };
    }

    private function generateLineSampleData(int $points): array
    {
        $data = [];
        for ($i = 0; $i < $points; $i++) {
            $data[] = [
                'label' => 'Point ' . ($i + 1),
                'value' => rand(10, 100),
            ];
        }
        return $data;
    }

    private function generateBarSampleData(int $points): array
    {
        $categories = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $data = [];

        for ($i = 0; $i < min($points, count($categories)); $i++) {
            $data[] = [
                'label' => $categories[$i],
                'value' => rand(20, 100),
            ];
        }

        return $data;
    }

    private function generatePieSampleData(int $slices): array
    {
        $categories = ['Category A', 'Category B', 'Category C', 'Category D', 'Category E'];
        $data = [];
        $remaining = 100;

        for ($i = 0; $i < min($slices - 1, count($categories) - 1); $i++) {
            $value = rand(10, 30);
            $data[] = [
                'label' => $categories[$i],
                'value' => $value,
            ];
            $remaining -= $value;
        }

        // Add last slice with remaining
        $data[] = [
            'label' => $categories[$slices - 1],
            'value' => max($remaining, 5),
        ];

        return $data;
    }

    private function generateAreaSampleData(int $points): array
    {
        return $this->generateLineSampleData($points);
    }
}
```

---

## 🚀 Utilizzo delle Actions

### 1. Generazione SVG Chart

```php
use Modules\Xot\Actions\Chart\GenerateSvgChartAction;

// Dati per il chart
$data = [
    ['label' => 'Jan', 'value' => 65],
    ['label' => 'Feb', 'value' => 78],
    ['label' => 'Mar', 'value' => 90],
    ['label' => 'Apr', 'value' => 81],
    ['label' => 'May', 'value' => 56],
    ['label' => 'Jun', 'value' => 95],
];

// Esegui action
$svgAction = new GenerateSvgChartAction('line', $data, [
    'width' => 800,
    'height' => 400,
    'padding' => 50,
]);

$svg = $svgAction->execute();

// Salva su file
file_put_contents('chart.svg', $svg);
```

### 2. Generazione PNG Chart

```php
use Modules\Xot\Actions\Chart\GeneratePngChartAction;

// Dati per il chart
$data = [
    ['label' => 'Product A', 'value' => 45],
    ['label' => 'Product B', 'value' => 78],
    ['label' => 'Product C', 'value' => 32],
    ['label' => 'Product D', 'value' => 89],
    ['label' => 'Product E', 'value' => 56],
];

// Esegui action
$pngAction = new GeneratePngChartAction('bar', $data, [
    'width' => 800,
    'height' => 400,
    'dpi' => 150,
]);

$png = $pngAction->execute();

// Salva su file
file_put_contents('chart.png', $png);
```

### 3. Utilizzo in Queue

```php
// Dispatch in queue
GenerateSvgChartAction::dispatch('pie', $data, $options)
    ->onQueue('charts')
    ->delay(now()->addMinutes(5));

// Batch dispatch
$charts = [
    ['type' => 'line', 'data' => $lineData],
    ['type' => 'bar', 'data' => $barData],
    ['type' => 'pie', 'data' => $pieData],
];

foreach ($charts as $chart) {
    GenerateSvgChartAction::dispatch($chart['type'], $chart['data'])
        ->onQueue('charts');
}
```

---

## 🎨 Integrazione con Filament

### 1. Chart Widget

```php
<?php

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Xot\Actions\Chart\GenerateSvgChartAction;

class ChartWidget extends Widget
{
    protected static string $view = 'xot::filament.widgets.chart-widget';

    public function getViewData(): array
    {
        $dataProvider = new \Modules\Xot\Services\Chart\ChartDataProvider();

        return [
            'chartSvg' => app(GenerateSvgChartAction::class)->execute(
                'line',
                $dataProvider->generateSampleData('line', 12),
                ['width' => 600, 'height' => 300]
            ),
            'chartType' => 'line',
            'refreshInterval' => 30, // seconds
        ];
    }
}
```

### 2. Chart Export Action

```php
use Modules\Xot\Actions\Chart\GeneratePngChartAction;
use Modules\Xot\Services\Chart\ChartDataProvider;

class ExportChartAction extends \Filament\Actions\Action
{
    public static function make(string $name = 'export_chart'): static
    {
        return parent::make($name)
            ->label('Export Chart')
            ->icon('heroicon-o-chart-bar')
            ->color('primary')
            ->action(function (array $data) {
                $dataProvider = new ChartDataProvider();
                $chartData = $dataProvider->prepareData($data['data'], $data['chart_type']);

                $pngAction = new GeneratePngChartAction(
                    $data['chart_type'],
                    $chartData,
                    [
                        'width' => 1200,
                        'height' => 600,
                        'dpi' => 300,
                    ]
                );

                $png = $pngAction->execute();

                return response()->streamDownload(function () use ($png) {
                    echo $png;
                }, "chart_{$data['chart_type']}" . date('Y-m-d_H-i-s') . '.png');
            })
            ->form([
                \Filament\Forms\Components\Select::make('chart_type')
                    ->label('Chart Type')
                    ->options([
                        'line' => 'Line Chart',
                        'bar' => 'Bar Chart',
                        'pie' => 'Pie Chart',
                        'area' => 'Area Chart',
                    ])
                    ->required(),

                \Filament\Forms\Components\KeyValue::make('data')
                    ->label('Chart Data')
                    ->addActionLabel('Add Data Point')
                    ->keyLabel('Label')
                    ->valueLabel('Value'),
            ]);
    }
}
```

---

## 🧪 Testing

### 1. Unit Tests

```php
<?php

namespace Modules\Xot\Tests\Unit\Actions\Chart;

use Tests\TestCase;
use Modules\Xot\Actions\Chart\GenerateSvgChartAction;
use Modules\Xot\Actions\Chart\GeneratePngChartAction;

class ChartGenerationTest extends TestCase
{
    /** @test */
    public function it_generates_svg_chart()
    {
        $data = [
            ['label' => 'A', 'value' => 10],
            ['label' => 'B', 'value' => 20],
            ['label' => 'C', 'value' => 15],
        ];

        $action = new GenerateSvgChartAction('line', $data);
        $svg = $action->execute();

        $this->assertStringContainsString('<svg', $svg);
        $this->assertStringContainsString('polyline', $svg);
        $this->assertStringContainsString('A', $svg);
        $this->assertStringContainsString('B', $svg);
        $this->assertStringContainsString('C', $svg);
    }

    /** @test */
    public function it_generates_png_chart()
    {
        $data = [
            ['label' => 'Product A', 'value' => 45],
            ['label' => 'Product B', 'value' => 78],
        ];

        $action = new GeneratePngChartAction('bar', $data);
        $png = $action->execute();

        // Verifica che sia un PNG valido (header PNG)
        $this->assertStringStartsWith("\x89\x50\x4E\x47\x0D\x0A\x1A\x0A", $png);
        $this->assertGreaterThan(1000, strlen($png));
    }

    /** @test */
    public function it_handles_invalid_chart_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        $action = new GenerateSvgChartAction('invalid_type', []);
        $action->execute();
    }

    /** @test */
    public function it_generates_unique_ids()
    {
        $data = ['label' => 'Test', 'value' => 10];

        $action1 = new GenerateSvgChartAction('line', $data);
        $action2 = new GenerateSvgChartAction('line', $data);

        $this->assertEquals($action1->getUniqueId(), $action2->getUniqueId());

        $action3 = new GenerateSvgChartAction('bar', $data);
        $this->assertNotEquals($action1->getUniqueId(), $action3->getUniqueId());
    }
}
```

---

## 📊 Performance Considerations

### 1. Ottimizzazione SVG

```php
// Usa SVG compresso
$svg = str_replace(["\n", "\r", "\t"], '', $svg);
$svg = preg_replace('/\s+/', ' ', $svg);

// Cache SVG generati
$cacheKey = 'svg_chart_' . md5(json_encode([$type, $data, $options]));
return Cache::remember($cacheKey, 3600, fn() => $this->generateSvg($type, $data, $options));
```

### 2. Ottimizzazione PNG

```php
// Limita dimensioni per performance
$maxWidth = 2000;
$maxHeight = 2000;
$width = min($options['width'] ?? 800, $maxWidth);
$height = min($options['height'] ?? 400, $maxHeight);

// Usa compressione appropriata
$imagick->setOption('png:compression-level', 6);
```

---

## 📚 Best Practices

### 1. Struttura Dati

```php
// ✅ GOOD: Struttura dati consistente
$data = [
    ['label' => 'January', 'value' => 100],
    ['label' => 'February', 'value' => 150],
];

// ❌ BAD: Dati non strutturati
$data = [100, 150, 200];
```

### 2. Gestione Errori

```php
try {
    $chart = $action->execute();
} catch (\Exception $e) {
    Log::error('Chart generation failed', [
        'type' => $type,
        'error' => $e->getMessage(),
    ]);

    // Fallback a chart placeholder
    $chart = $this->generatePlaceholderChart();
}
```

### 3. Queue Management

```php
// Usa code separate per chart pesanti
GeneratePngChartAction::dispatch($type, $data)
    ->onQueue('charts')
    ->delay(now()->addMinutes(5));
```

---

## 🔗 Risorse

- [Imagick Documentation](https://www.php.net/manual/en/book.imagick.php)
- [SVG Specifications](https://www.w3.org/TR/SVG/)
- [Spatie QueueableAction](https://github.com/spatie/queueable-action)
- [Laravel Queue System](https://laravel.com/docs/queues)

---

**Last Updated:** 2025-12-09
**Version:** 1.0.0
**PHPStan Level:** 10 ✅
**Dependencies:** Imagick, Spatie QueueableAction
