# Chart Export Actions Guide - SVG e PNG da Filament Widgets

## 📋 Indice
1. [Introduzione](#introduzione)
2. [Actions Disponibili](#actions-disponibili)
3. [Utilizzo nei Widget Filament](#utilizzo-nei-widget-filament)
4. [Esempi Pratici](#esempi-pratici)
5. [Best Practices](#best-practices)

---

## Introduzione

Questo documento descrive le **Actions** create per esportare grafici Chart.js da widget Filament in formato **SVG** e **PNG**, seguendo l'architettura Laraxot che utilizza esclusivamente **Spatie Queueable Actions** invece di Services.

### Architettura Actions vs Services

**❌ VECCHIO APPROACH (DEPRECATO):**
```php
// ❌ NON USARE PIÙ!
namespace Modules\Quaeris\Services\Charts;
class UnifiedChartEngine { }
```

**✅ NUOVO APPROACH (CORRETTO):**
```php
// ✅ USARE QUESTO!
namespace Modules\Chart\Actions;
use Spatie\QueueableAction\QueueableAction;
class ExportChartToSvgAction { }
```

---

## Actions Disponibili

### 1. ExportChartToSvgAction

**Scopo**: Esporta grafici Chart.js in formato SVG

```php
use Modules\Chart\Actions\ExportChartToSvgAction;

// Esporta SVG base
$result = app(ExportChartToSvgAction::class)->execute(
    base64Data: $base64Data,
    filename: 'mio-grafico.svg',
    disk: 'public'
);

// Esporta SVG con dimensioni personalizzate
$result = app(ExportChartToSvgAction::class)->executeWithCustomSize(
    base64Data: $base64Data,
    width: 800,
    height: 600,
    filename: 'mio-grafico.svg'
);

// Esporta SVG con metadati
$result = app(ExportChartToSvgAction::class)->executeWithMetadata(
    base64Data: $base64Data,
    metadata: [
        'title' => 'Grafico Vendite',
        'description' => 'Distribuzione vendite mensili',
        'created_by' => 'Sistema Survey',
    ]
);
```

**Risultato**:
```php
[
    'path' => 'path/to/chart.svg',
    'url' => 'http://example.com/storage/chart.svg',
    'size' => 12345,
    'filename' => 'chart.svg',
    'format' => 'svg',
]
```

### 2. ExportChartToPngAction

**Scopo**: Esporta grafici Chart.js in formato PNG

```php
use Modules\Chart\Actions\ExportChartToPngAction;

// Esporta PNG base
$result = app(ExportChartToPngAction::class)->execute(
    base64Data: $base64Data,
    filename: 'mio-grafico.png',
    disk: 'public',
    quality: 95
);

// Esporta PNG per PDF (massima qualità)
$result = app(ExportChartToPngAction::class)->executeForPdf($base64Data);

// Esporta PNG per web (qualità bilanciata)
$result = app(ExportChartToPngAction::class)->executeForWeb($base64Data);

// Esporta batch di PNG
$results = app(ExportChartToPngAction::class)->executeBatch([
    $base64Chart1,
    $base64Chart2,
    $base64Chart3,
], 'report-charts');
```

**Risultato**:
```php
[
    'path' => 'path/to/chart.png',
    'url' => 'http://example.com/storage/chart.png',
    'size' => 23456,
    'filename' => 'chart.png',
    'quality' => 95,
    'format' => 'png',
]
```

### 3. ExportChartFromWidgetAction

**Scopo**: Esporta direttamente da widget Filament

```php
use Modules\Chart\Actions\ExportChartFromWidgetAction;

// Esporta sia SVG che PNG
$result = app(ExportChartFromWidgetAction::class)->execute(
    widget: $chartWidget,
    chartId: 'my-chart-canvas',
    filenameBase: 'survey-report'
);

// Esporta solo SVG
$svgResult = app(ExportChartFromWidgetAction::class)->executeSvg(
    widget: $chartWidget,
    chartId: 'my-chart-canvas'
);

// Esporta solo PNG (alta qualità per PDF)
$pngResult = app(ExportChartFromWidgetAction::class)->executePngForPdf(
    widget: $chartWidget,
    chartId: 'my-chart-canvas'
);
```

**Risultato**:
```php
[
    'svg' => [/* SVG result */],
    'png' => [/* PNG result */],
    'widget_class' => 'App\\Filament\\Widgets\\SalesChartWidget',
    'chart_id' => 'my-chart-canvas',
    'exported_at' => '2025-11-17T10:30:00+00:00',
]
```

---

## Utilizzo nei Widget Filament

### Widget Base con Export

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Actions\Action;
use Modules\Chart\Actions\ExportChartFromWidgetAction;

class ExportableChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafico Esportabile';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Vendite',
                    'data' => [65, 78, 45, 92, 58],
                    'backgroundColor' => '#3B82F6',
                ],
            ],
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportSvg')
                ->label('Export SVG')
                ->action(fn () => $this->exportChart('svg'))
                ->icon('heroicon-o-document-arrow-down'),

            Action::make('exportPng')
                ->label('Export PNG')
                ->action(fn () => $this->exportChart('png'))
                ->icon('heroicon-o-photo'),
        ];
    }

    private function exportChart(string $format): void
    {
        try {
            $result = app(ExportChartFromWidgetAction::class)->execute(
                widget: $this,
                chartId: $this->getId(),
                filenameBase: 'chart-' . $this->getId()
            );

            $this->notify(
                'success',
                "Grafico esportato in {$format} con successo!"
            );

            // Log export
            \Log::info('Chart exported', [
                'widget' => get_class($this),
                'format' => $format,
                'result' => $result,
            ]);

        } catch (\Exception $e) {
            $this->notify(
                'danger',
                "Errore nell'export: {$e->getMessage()}"
            );
        }
    }
}
```

### Livewire Component per Export Client-Side

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Http\Livewire;

use Livewire\Component;
use Modules\Chart\Actions\ExportChartToSvgAction;
use Modules\Chart\Actions\ExportChartToPngAction;

class ChartExportComponent extends Component
{
    public string $chartId;
    public ?string $lastExportPath = null;

    protected $listeners = [
        'exportChartSvg' => 'exportSvg',
        'exportChartPng' => 'exportPng',
    ];

    public function exportSvg(string $base64Data): void
    {
        try {
            $result = app(ExportChartToSvgAction::class)->execute(
                base64Data: $base64Data,
                filename: "chart-{$this->chartId}-" . now()->format('Y-m-d-H-i-s') . '.svg'
            );

            $this->lastExportPath = $result['url'];
            $this->dispatch('chartExported', $result);

        } catch (\Exception $e) {
            $this->dispatch('chartExportError', $e->getMessage());
        }
    }

    public function exportPng(string $base64Data): void
    {
        try {
            $result = app(ExportChartToPngAction::class)->executeForPdf(
                base64Data: $base64Data,
                filename: "chart-{$this->chartId}-" . now()->format('Y-m-d-H-i-s') . '.png'
            );

            $this->lastExportPath = $result['url'];
            $this->dispatch('chartExported', $result);

        } catch (\Exception $e) {
            $this->dispatch('chartExportError', $e->getMessage());
        }
    }

    public function render()
    {
        return view('chart::livewire.chart-export-component');
    }
}
```

---

## Esempi Pratici

### Esempio 1: Export in PDF Report

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Chart\Actions\ExportChartFromWidgetAction;
use Modules\Xot\Actions\Pdf\Engine\SpipuPdfByHtmlAction;

class GenerateSurveyReportAction
{
    use QueueableAction;

    public function execute(array $surveyData): array
    {
        $charts = [];

        // Esporta tutti i grafici del survey
        foreach ($surveyData['questions'] as $question) {
            $widget = $this->createChartWidget($question);

            $chartResult = app(ExportChartFromWidgetAction::class)->execute(
                widget: $widget,
                chartId: 'chart-' . $question['id'],
                filenameBase: 'question-' . $question['id']
            );

            $charts[] = [
                'question' => $question['text'],
                'svg_path' => $chartResult['svg']['path'],
                'png_path' => $chartResult['png']['path'],
            ];
        }

        // Genera HTML per PDF
        $html = view('survey::pdf.report', [
            'survey' => $surveyData,
            'charts' => $charts,
        ])->render();

        // Crea PDF con Spipu
        $pdfResult = app(SpipuPdfByHtmlAction::class)->execute(
            html: $html,
            filename: 'survey-report-' . now()->format('Y-m-d') . '.pdf',
            out: 'download'
        );

        return [
            'pdf_path' => $pdfResult,
            'charts' => $charts,
            'exported_at' => now()->toISOString(),
        ];
    }
}
```

### Esempio 2: Batch Export per Dashboard

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Spatie\QueueableAction\QueueableAction;

class ExportDashboardChartsAction
{
    use QueueableAction;

    public function execute(array $widgets): array
    {
        $results = [];

        foreach ($widgets as $widget) {
            if (!app(ExportChartFromWidgetAction::class)->canExportWidget()) {
                continue;
            }

            $widgetInfo = app(ExportChartFromWidgetAction::class)->getWidgetInfo($widget);

            $result = app(ExportChartFromWidgetAction::class)->execute(
                widget: $widget,
                chartId: $this->generateChartId($widget),
                filenameBase: 'dashboard-' . strtolower(class_basename($widget))
            );

            $results[] = array_merge($widgetInfo, [
                'export_result' => $result,
            ]);
        }

        return $results;
    }

    private function generateChartId($widget): string
    {
        return 'chart-' . md5(get_class($widget));
    }
}
```

---

## Best Practices

### 1. Utilizzo Corretto delle Actions

```php
// ✅ CORRETTO - Usa dependency injection o app() helper
class MyService {
    public function __construct(
        private ExportChartToSvgAction $exportSvgAction
    ) {}

    public function exportChart($data) {
        return $this->exportSvgAction->execute($data);
    }
}

// ✅ CORRETTO - Usa app() helper
$result = app(ExportChartToSvgAction::class)->execute($data);

// ❌ SBAGLIATO - Non creare istanze direttamente
$action = new ExportChartToSvgAction(); // NO!
```

### 2. Gestione Errori

```php
try {
    $result = app(ExportChartFromWidgetAction::class)->execute(
        widget: $widget,
        chartId: 'my-chart'
    );
} catch (\Exception $e) {
    \Log::error('Chart export failed', [
        'widget' => get_class($widget),
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    // Fallback a grafico di default
    $result = $this->createFallbackChart($widget);
}
```

### 3. Performance e Caching

```php
use Illuminate\Support\Facades\Cache;

// Cache export per grafici statici
$cacheKey = 'chart-export-' . md5(json_encode($chartData));

$result = Cache::remember($cacheKey, 3600, function () use ($chartData) {
    return app(ExportChartToSvgAction::class)->execute($chartData);
});
```

### 4. Qualità Output

```php
// Per PDF - massima qualità
$result = app(ExportChartToPngAction::class)->executeForPdf($base64Data);

// Per web - qualità bilanciata
$result = app(ExportChartToPngAction::class)->executeForWeb($base64Data);

// Per archiviazione - formato vettoriale
$result = app(ExportChartToSvgAction::class)->execute($base64Data);
```

---

## Riferimenti

- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [Filament Widgets Documentation](https://filamentphp.com/docs/3.x/panels/widgets)
- [Chart.js Export Guide](./chart-js-export-guide.md)
- [JPGraph Step-by-Step Guide](./jpgraph-step-by-step-guide.md)

---

*Guida Chart Export Actions v1.0 - Creato: 2025-11-17*
*Modulo Chart - Architettura Laraxot*