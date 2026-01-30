# Professional Charts in Filament 5.x: Complete Implementation Guide

**Created:** January 2026
**Updated:** January 2026 (Filament 5.x migration)
**Framework:** Filament 5.0+, Laravel 12.31
**Target:** Enterprise survey reporting with Chart.js and JpGraph
**Level:** Advanced

> **⚠️ IMPORTANTE**: Questo documento è aggiornato per Filament 5.x. Per l'installazione completa di Filament 5.x e la configurazione di Chart.js plugins, vedere [filament-5-installation-guide.md](./filament-5-installation-guide.md).

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Chart.js Integration (Frontend)](#chartjs-integration-frontend)
3. [JpGraph Integration (Backend)](#jpgraph-integration-backend)
4. [Creating Professional Chart Widgets](#creating-professional-chart-widgets)
5. [Data Preparation with DTOs](#data-preparation-with-dtos)
6. [Color Management and Theming](#color-management-and-theming)
7. [Chart Export System](#chart-export-system)
8. [Advanced Techniques](#advanced-techniques)
9. [Performance Optimization](#performance-optimization)
10. [Best Practices](#best-practices)

---

## Architecture Overview

### Dual-Library Strategy

The Quaeris system employs a sophisticated dual-library architecture for charts:

```
┌──────────────────────────────────────────────────────────┐
│              FILAMENT ADMIN PANEL                        │
│  ┌────────────────────────────────────────────────────┐  │
│  │         ChartWidget (Base Class)                   │  │
│  │  - getData(): array                                │  │
│  │  - getType(): string                               │  │
│  │  - getOptions(): array                             │  │
│  └────────────────────────────────────────────────────┘  │
└───────────────────┬──────────────────────────────────────┘
                    │
        ┌───────────┴───────────┐
        │                       │
┌───────▼────────┐    ┌────────▼──────────┐
│   CHART.JS     │    │     JPGRAPH       │
│   (Frontend)   │    │     (Backend)     │
├────────────────┤    ├───────────────────┤
│ • Interactive  │    │ • Server-side PNG │
│ • Responsive   │    │ • PDF embedding   │
│ • Web display  │    │ • High quality    │
│ • Canvas-based │    │ • No JavaScript   │
└───────┬────────┘    └────────┬──────────┘
        │                      │
        ▼                      ▼
    Browser PNG          Filesystem PNG
    (base64)             (public/charts/)
        │                      │
        └──────────┬───────────┘
                   │
           ┌───────▼────────┐
           │  PDF GENERATOR │
           │  (Html2Pdf)    │
           └────────────────┘
```

### Why Dual Libraries?

**Chart.js (Frontend):**
- ✅ Interactive dashboards with hover effects
- ✅ Real-time data updates via Livewire
- ✅ Responsive and mobile-friendly
- ✅ Native Filament 5.x integration
- ✅ Plugin system via `window.filamentChartJsPlugins`
- ❌ Requires browser for rendering
- ❌ Limited export capabilities

**JpGraph (Backend):**
- ✅ Server-side rendering (no browser needed)
- ✅ High-quality PNG for PDF embedding
- ✅ Precise control over styling
- ✅ No JavaScript dependencies
- ❌ Static images only (no interactivity)
- ❌ More complex configuration

### Technology Stack

```
Dependencies (composer.json):
  - filament/filament: ^5.0.0
  - amenadiel/jpgraph: ^4.1
  - spatie/laravel-data: ^4.0
  - spatie/browsershot: ^4.0  (for Chart.js → PNG)

Frontend (package.json):
  - chart.js: ^4.4.3 (via CDN in export actions)
  - chartjs-plugin-datalabels: ^2.2.0
  - tailwindcss: ^4.1.0 (⚠️ CRITICO - Filament 5.x richiede v4.1+)
  - @tailwindcss/vite: ^4.1.0
```

---

## Chart.js Integration (Frontend) - Filament 5.x

### ⚠️ IMPORTANTE: Filament 5.x Requirements

- **Tailwind CSS v4.1+** richiesto (NON compatibile con v3.x)
- **Chart.js Plugins** registrati via `window.filamentChartJsPlugins`
- **Asset Registration** tramite `FilamentAsset::register()` in PanelProvider

Per dettagli completi, vedere [filament-5-installation-guide.md](./filament-5-installation-guide.md).

### Basic Chart Widget

**⚠️ IMPORTANTE**: Always extend `XotBaseChartWidget` - NEVER extend Filament's `ChartWidget` directly.

```php
namespace Modules\Quaeris\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class SalesChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Monthly Sales';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales 2026',
                    'data' => [150, 180, 200, 165, 190, 220],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';  // bar, line, pie, doughnut, radar, polarArea
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Sales Performance',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grace' => '5%',
                ],
            ],
        ];
    }
}

```

**Usage in Page:**

```php
namespace Modules\Quaeris\Filament\Pages;

use Filament\Pages\Dashboard;

class QuaerisDashboard extends Dashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            SalesChartWidget::class,
            // ... other widgets
        ];
    }
}
```

### Filament 5.x ChartWidget: feature ufficiali da usare nel progetto

Riferimento ufficiale:

- [Chart widgets - Filament 5.x](https://filamentphp.com/docs/5.x/widgets/charts)
- [Chart.js Plugins Registration](https://filamentphp.com/docs/5.x/widgets/charts#step-1-install-the-plugin-with-npm)

#### Polling (live update)

Per default Filament aggiorna i dati periodicamente. Nel nostro stack è consigliato:

- abilitare polling solo su dataset piccoli / aggregazioni veloci
- disabilitare polling su query pesanti (LimeSurvey con join su label / molte domande)

Esempio:

```php
protected ?string $pollingInterval = '10s';

// oppure per disabilitare:
// protected ?string $pollingInterval = null;
```

#### Filtri: widget-local vs dashboard-global

Filament supporta:

- filtro semplice via `public ?string $filter` e `getFilters()`
- filtri avanzati via schema con `HasFiltersSchema` e `$this->filters`

Nel modulo Quaeris i filtri che impattano più widget contemporaneamente restano centralizzati in `DashboardFilterData`.

#### Opzioni Chart.js (`$options` / `getOptions()` / `RawJs`)

Filament passa a Chart.js le opzioni come array PHP. Per callback JS, usare `Filament\Support\RawJs`.

Esempio tipico (tick formatter):

```php
use Filament\Support\RawJs;

protected function getOptions(): RawJs
{
    return RawJs::make(<<<'JS'
{
  scales: {
    y: {
      ticks: {
        callback: (value) => '€' + value,
      },
    },
  },
}
JS);
}
```

#### Plugin Chart.js (es. datalabels) via Vite - Filament 5.x

**⚠️ IMPORTANTE**: Filament 5.x usa il pattern `window.filamentChartJsPlugins` (NON `Chart.register()`).

Filament 5.x permette di registrare plugin Chart.js tramite:

- `window.filamentChartJsPlugins` - Plugin inline (equivalente a `new Chart(..., { plugins: [...] })`)
- `window.filamentChartJsGlobalPlugins` - Plugin globali (equivalente a `Chart.register([...])`)

**Pattern Corretto**:

```javascript
// resources/js/filament-chart-js-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

**Pattern Errato**:

```javascript
// ❌ NON USARE
import Chart from 'chart.js/auto';
Chart.register(ChartDataLabels);  // ❌ NON funziona con Filament 5.x
```

**Strategia consigliata**: 
1. File JS dedicato (es. `resources/js/filament-chart-js-plugins.js`)
2. Incluso nel `vite.config.js` input array
3. Registrato in PanelProvider con `FilamentAsset::register()`

Vedi [filament-5-installation-guide.md](./filament-5-installation-guide.md) per dettagli completi.

### Chart Types Reference

#### Bar Chart
```php
protected function getType(): string
{
    return 'bar';
}

protected function getData(): array
{
    return [
        'datasets' => [[
            'label' => 'Values',
            'data' => [10, 20, 30, 40],
            'backgroundColor' => [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
            ],
        ]],
        'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
    ];
}
```

**Options:**
```php
'scales' => [
    'y' => [
        'beginAtZero' => true,
        'ticks' => [
            'callback' => "function(value) { return value + '%'; }",  // JS callback
        ],
    ],
    'x' => [
        'stacked' => true,  // Stacked bars
    ],
],
```

#### Line Chart
```php
protected function getType(): string
{
    return 'line';
}

protected function getData(): array
{
    return [
        'datasets' => [[
            'label' => 'Trend',
            'data' => [10, 15, 13, 17, 20, 24],
            'fill' => true,  // Fill area under line
            'borderColor' => 'rgb(75, 192, 192)',
            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
            'tension' => 0.4,  // Curve smoothness (0 = straight, 1 = very curved)
        ]],
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    ];
}
```

**Options:**
```php
'elements' => [
    'point' => [
        'radius' => 5,
        'hoverRadius' => 7,
        'backgroundColor' => 'white',
        'borderWidth' => 2,
    ],
],
```

#### Pie / Doughnut Chart
```php
protected function getType(): string
{
    return 'doughnut';  // or 'pie'
}

protected function getData(): array
{
    return [
        'datasets' => [[
            'data' => [300, 150, 100],
            'backgroundColor' => [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
        ]],
        'labels' => ['Red', 'Blue', 'Yellow'],
    ];
}
```

**Options:**
```php
'cutout' => '70%',  // Doughnut hole size (doughnut only)
'rotation' => -90,  // Start angle
'circumference' => 180,  // Arc span (180 = semicircle)
'plugins' => [
    'legend' => [
        'position' => 'right',
    ],
],
```

#### Multi-Dataset Chart
```php
protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => '2025',
                'data' => [100, 120, 110, 140],
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
            ],
            [
                'label' => '2026',
                'data' => [120, 140, 130, 160],
                'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
            ],
        ],
        'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
    ];
}
```

### Advanced Chart.js Features

#### Data Labels Plugin

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'color' => 'white',
                'font' => [
                    'weight' => 'bold',
                    'size' => 14,
                ],
                'formatter' => "function(value, context) {
                    return value.toFixed(1) + '%';
                }",
            ],
        ],
    ];
}
```

**Plugin CDN (loaded automatically in export):**
```html
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
```

#### Tooltips Customization

```php
'plugins' => [
    'tooltip' => [
        'enabled' => true,
        'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
        'titleFont' => [
            'size' => 16,
        ],
        'bodyFont' => [
            'size' => 14,
        ],
        'callbacks' => [
            'label' => "function(context) {
                let label = context.dataset.label || '';
                label += ': ' + context.parsed.y + ' units';
                return label;
            }",
        ],
    ],
],
```

#### Animations

```php
'animation' => [
    'duration' => 1000,  // ms
    'easing' => 'easeInOutQuart',  // easing function
],
'animations' => [
    'tension' => [
        'duration' => 1000,
        'easing' => 'linear',
        'from' => 1,
        'to' => 0,
        'loop' => true,
    ],
],
```

---

## JpGraph Integration (Backend)

### JpGraph Action Pattern

Create an action for server-side chart rendering:

```php
namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;

class Bar2Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        // 1. Extract configuration and data
        $chart = $answersChartData->chart;
        $answers = $answersChartData->answers;

        $labels = $answers->pluck('label')->all();
        $values = $answers->pluck('count')->all();

        // 2. Create graph
        $graph = new Graph($chart->width, $chart->height, 'auto');
        $graph->SetScale('textlin');  // X=text, Y=linear

        // 3. Apply styling (margins, shadows, background)
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // 4. Configure axes
        if ($graph->xaxis) {
            $graph->xaxis->SetTickLabels($labels);
            $graph->xaxis->SetLabelAngle($chart->x_label_angle);
            $graph->xaxis->SetLabelMargin($chart->x_label_margin);
        }

        if ($graph->yaxis) {
            $graph->yaxis->HideLabels($chart->yaxis_hide === 1);
            $graph->yaxis->SetGrace($chart->y_grace);
        }

        // 5. Create plot
        $barPlot = new BarPlot($values);
        $barPlot = app(ApplyPlotStyleAction::class)->execute($barPlot, $chart);

        // 6. Add to graph
        $graph->Add($barPlot);

        return $graph;
    }
}
```

### ApplyGraphStyleAction

```php
namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Graph;
use Modules\Chart\Datas\ChartData;

class ApplyGraphStyleAction
{
    public function execute(Graph $graph, ChartData $chart): Graph
    {
        // Margins (left, right, top, bottom)
        $graph->SetMargin(
            $chart->margin_left ?? 50,
            $chart->margin_right ?? 50,
            $chart->margin_top ?? 60,
            $chart->margin_bottom ?? 50
        );

        // Shadow
        if ($chart->show_shadow) {
            $graph->SetShadow();
        }

        // Box around plot area
        if ($chart->show_box) {
            $graph->SetBox(true);
        }

        // Background color
        if ($chart->bg_color) {
            $graph->SetColor($chart->bg_color);
        }

        // Title
        if ($chart->title) {
            $graph->title->Set($chart->title);
            $graph->title->SetFont(
                $chart->font_family,
                $chart->font_style,
                $chart->font_size
            );
            $graph->title->SetColor($chart->color);
        }

        // Subtitle
        if ($chart->subtitle) {
            $graph->subtitle->Set($chart->subtitle);
            $graph->subtitle->SetFont(
                $chart->font_family,
                $chart->font_style,
                $chart->font_size - 2
            );
        }

        return $graph;
    }
}
```

### ApplyPlotStyleAction

```php
namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\PiePlot;
use Modules\Chart\Datas\ChartData;

class ApplyPlotStyleAction
{
    public function execute(BarPlot|PiePlot $plot, ChartData $chart): BarPlot|PiePlot
    {
        // Colors
        $colors = $chart->getColors();  // ['#ff0000', '#00ff00', '#0000ff']

        if ($plot instanceof BarPlot) {
            $plot->SetFillColor($colors);
            $plot->SetWidth($chart->plot_perc_width / 100);  // 0.9 = 90% width
        }

        if ($plot instanceof PiePlot) {
            $plot->SetSliceColors($colors);
        }

        // Show values on plot
        if ($chart->plot_value_show && is_object($plot->value)) {
            $plot->value->Show();
            $plot->value->SetFont(
                $chart->font_family,
                $chart->font_style,
                $chart->font_size - 2
            );
            $plot->value->SetColor($chart->plot_value_color ?? 'black');

            // Value format
            if ($chart->plot_value_format) {
                $plot->value->SetFormat($chart->plot_value_format);  // e.g., '%2.1f%%'
            }
        }

        return $plot;
    }
}
```

### Generating PNG with JpGraph

```php
namespace Modules\Quaeris\Actions\QuestionChart;

use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Quaeris\Models\QuestionChart;

class MakeImgByQuestionChartModelAction
{
    public function execute(QuestionChart $questionChart): string
    {
        // 1. Prepare data
        $answersChartData = AnswersChartData::from([
            'answers' => $this->getAnswersCollection($questionChart),
            'chart' => $questionChart->chart->toChartData(),
        ]);

        // 2. Get Graph object via action
        $graph = app(GetGraphAction::class)->execute($answersChartData);

        // 3. Generate PNG filename
        $filename = "chart-{$questionChart->id}.png";
        $path = public_path("charts/{$filename}");

        // 4. Stroke (render) to file
        $graph->Stroke($path);

        // 5. Update model
        $questionChart->update([
            'img_src' => "/charts/{$filename}",
        ]);

        return $path;
    }
}
```

### JpGraph Chart Types

#### Pie Chart
```php
use Amenadiel\JpGraph\Plot\PiePlot;

$piePlot = new PiePlot($data);
$piePlot->SetSliceColors($colors);
$piePlot->SetSize(0.4);  // Radius relative to graph
$piePlot->SetCenter(0.5, 0.5);  // Center position (0-1)

// Value labels
$piePlot->value->Show();
$piePlot->value->SetFormat('%2.1f%%');

// Legend labels
$piePlot->SetLabels($labels);
$piePlot->SetLabelPos(0.6);  // Label distance from center

$graph->Add($piePlot);
```

#### Grouped Bar Chart
```php
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;

$dataset1 = [10, 20, 30];
$dataset2 = [15, 25, 35];

$bar1 = new BarPlot($dataset1);
$bar1->SetFillColor('blue');

$bar2 = new BarPlot($dataset2);
$bar2->SetFillColor('red');

$groupedBarPlot = new GroupBarPlot([$bar1, $bar2]);
$graph->Add($groupedBarPlot);
```

#### Horizontal Bar Chart
```php
use Amenadiel\JpGraph\Plot\BarPlot;

$graph = new Graph($width, $height);
$graph->SetScale('textlin');

$barPlot = new BarPlot($data);
$barPlot->SetFillColor($colors);

// Make horizontal
$barPlot->SetOrientation('horizontal');

$graph->Add($barPlot);
```

---

## Creating Professional Chart Widgets

### XotBaseChartWidget Pattern

Extend `XotBaseChartWidget` for Quaeris-specific widgets:

```php
namespace Modules\Quaeris\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Quaeris\Models\QuestionChart;

class QuestionChartWidget extends XotBaseChartWidget
{
    public ?QuestionChart $record = null;

    protected static ?string $heading = 'Question Chart';

    public function mount(?int $recordId = null): void
    {
        if ($recordId) {
            $this->record = QuestionChart::find($recordId);
        }
    }

    protected function getData(): array
    {
        if (!$this->record) {
            return ['datasets' => [], 'labels' => []];
        }

        $responses = $this->getResponsesQuery()->get();

        // Aggregate responses
        $aggregated = $responses
            ->groupBy($this->record->field_name)
            ->map(fn($group) => $group->count());

        return [
            'datasets' => [[
                'data' => $aggregated->values()->all(),
                'backgroundColor' => $this->getChartColors($aggregated->count()),
            ]],
            'labels' => $aggregated->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return match($this->record?->chart_type) {
            'pie1', 'pieAvg' => 'doughnut',
            'bar1', 'bar2', 'bar3' => 'bar',
            'lineSubQuestion' => 'line',
            default => 'bar',
        };
    }

    protected function getResponsesQuery(): Builder
    {
        $record = $this->record;

        return SurveyResponse::getResponsesForSurvey($record->survey_id)
            ->whereNotNull('submitdate')
            ->withAnswersLabel($record->question, $record->field_name);
    }

    protected function getChartColors(int $count, float $alpha = 0.7): array
    {
        $baseColors = [
            [54, 162, 235],   // Blue
            [255, 99, 132],   // Red
            [255, 205, 86],   // Yellow
            [75, 192, 192],   // Teal
            [153, 102, 255],  // Purple
            [255, 159, 64],   // Orange
        ];

        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $rgb = $baseColors[$i % count($baseColors)];
            $colors[] = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, {$alpha})";
        }

        return $colors;
    }
}
```

### Dynamic Chart Configuration

```php
class DynamicChartWidget extends XotBaseChartWidget
{
    public string $chartType = 'bar';
    public string $groupBy = 'month';
    public array $filters = [];

    protected function getData(): array
    {
        $query = $this->buildQuery();

        $data = $query
            ->groupBy($this->groupBy)
            ->selectRaw("
                {$this->groupBy} as label,
                COUNT(*) as count,
                AVG(value) as average
            ")
            ->get();

        return [
            'datasets' => [[
                'label' => 'Count',
                'data' => $data->pluck('count')->all(),
                'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                'yAxisID' => 'y',
            ], [
                'label' => 'Average',
                'data' => $data->pluck('average')->all(),
                'type' => 'line',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'yAxisID' => 'y1',
            ]],
            'labels' => $data->pluck('label')->all(),
        ];
    }

    protected function getType(): string
    {
        return $this->chartType;
    }

    protected function getOptions(): array
    {
        return [
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
```

---

## Data Preparation with DTOs

### ChartData DTO

```php
namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class ChartData extends Data
{
    public function __construct(
        public string $type,                    // Chart type identifier
        public int $width,                      // Chart width in pixels
        public int $height,                     // Chart height in pixels
        public string $list_color,              // Comma-separated hex colors
        public int $font_family,                // JpGraph font family constant
        public int $font_size,                  // Font size
        public int $font_style,                 // JpGraph font style constant
        public float $transparency,             // 0-1 transparency
        public ?string $title = null,           // Chart title
        public ?string $subtitle = null,        // Chart subtitle
        public ?int $x_label_angle = 0,         // X-axis label rotation
        public ?int $x_label_margin = 10,       // X-axis label margin
        public ?int $y_grace = 5,               // Y-axis grace percentage
        public ?bool $yaxis_hide = false,       // Hide Y-axis labels
        public ?bool $show_box = true,          // Show border box
        public ?int $plot_perc_width = 90,      // Plot width percentage
        public ?bool $plot_value_show = true,   // Show value labels
        public ?string $plot_value_format = '%d', // Value format string
        public ?string $plot_value_color = 'black', // Value label color
    ) {}

    /**
     * Get colors as array
     * @return list<string>
     */
    public function getColors(): array
    {
        return explode(',', $this->list_color);
    }

    /**
     * Get colors as RGBA with transparency
     * @return list<string>
     */
    public function getColorsRgba(float $alpha = 1.0): array
    {
        return collect($this->getColors())
            ->map(function (string $hex) use ($alpha) {
                $hex = ltrim($hex, '#');
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                return "rgba({$r}, {$g}, {$b}, {$alpha})";
            })
            ->all();
    }

    /**
     * Get JpGraph action class name
     */
    public function getActionClass(): string
    {
        $className = ucfirst($this->type) . 'Action';
        return "Modules\\Chart\\Actions\\JpGraph\\V1\\{$className}";
    }
}
```

### AnswersChartData DTO

```php
namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class AnswersChartData extends Data
{
    public function __construct(
        /** @var Collection<int, AnswerData> */
        public Collection $answers,
        public ChartData $chart,
    ) {}

    /**
     * Get Chart.js compatible type
     */
    public function getChartJsType(): string
    {
        return match($this->chart->type) {
            'pie1', 'pieAvg' => 'doughnut',
            'bar1', 'bar2', 'bar3' => 'bar',
            'horizbar1' => 'bar',  // horizontal via options
            'lineSubQuestion' => 'line',
            default => 'bar',
        };
    }

    /**
     * Get Chart.js compatible data array
     */
    public function toChartJsArray(): array
    {
        return [
            'type' => $this->getChartJsType(),
            'data' => [
                'labels' => $this->answers->pluck('label')->all(),
                'datasets' => [[
                    'data' => $this->answers->pluck('count')->all(),
                    'backgroundColor' => $this->chart->getColorsRgba(0.7),
                    'borderColor' => $this->chart->getColorsRgba(1.0),
                    'borderWidth' => 2,
                ]],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'indexAxis' => $this->chart->type === 'horizbar1' ? 'y' : 'x',
            ],
        ];
    }

    /**
     * Convert to JpGraph Graph object
     */
    public function toJpGraph(): Graph
    {
        $actionClass = $this->chart->getActionClass();

        if (!class_exists($actionClass)) {
            throw new \Exception("Chart action not found: {$actionClass}");
        }

        return app($actionClass)->execute($this);
    }
}
```

### AnswerData DTO

```php
namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;

class AnswerData extends Data
{
    public function __construct(
        public string $label,       // Answer label
        public string $code,        // Answer code
        public int $count,          // Response count
        public ?float $avg = null,  // Average value (for numerical questions)
        public ?float $percentage = null,  // Percentage of total
    ) {}

    /**
     * Create from database row
     */
    public static function fromRow(object $row): self
    {
        return new self(
            label: $row->label ?? $row->code,
            code: $row->code,
            count: $row->count,
            avg: $row->avg ?? null,
            percentage: $row->percentage ?? null,
        );
    }
}
```

---

## Color Management and Theming

### Professional Color Palettes

```php
namespace Modules\Chart\Services;

class ChartColorService
{
    /**
     * Default Quaeris brand colors
     */
    public const BRAND_PRIMARY = '#d60021';
    public const BRAND_SECONDARY = '#0066cc';

    /**
     * Professional color palettes
     */
    public const PALETTES = [
        'default' => [
            'rgba(54, 162, 235, 0.7)',   // Blue
            'rgba(255, 99, 132, 0.7)',   // Red
            'rgba(255, 205, 86, 0.7)',   // Yellow
            'rgba(75, 192, 192, 0.7)',   // Teal
            'rgba(153, 102, 255, 0.7)',  // Purple
            'rgba(255, 159, 64, 0.7)',   // Orange
        ],

        'pastel' => [
            'rgba(179, 226, 255, 0.8)',  // Light Blue
            'rgba(255, 179, 186, 0.8)',  // Light Red
            'rgba(255, 237, 186, 0.8)',  // Light Yellow
            'rgba(186, 255, 236, 0.8)',  // Light Teal
            'rgba(218, 191, 255, 0.8)',  // Light Purple
            'rgba(255, 218, 185, 0.8)',  // Light Orange
        ],

        'professional' => [
            'rgba(31, 119, 180, 0.7)',   // Professional Blue
            'rgba(255, 127, 14, 0.7)',   // Professional Orange
            'rgba(44, 160, 44, 0.7)',    // Professional Green
            'rgba(214, 39, 40, 0.7)',    // Professional Red
            'rgba(148, 103, 189, 0.7)',  // Professional Purple
            'rgba(140, 86, 75, 0.7)',    // Professional Brown
        ],

        'monochrome' => [
            'rgba(20, 20, 20, 0.9)',
            'rgba(60, 60, 60, 0.8)',
            'rgba(100, 100, 100, 0.7)',
            'rgba(140, 140, 140, 0.6)',
            'rgba(180, 180, 180, 0.5)',
            'rgba(220, 220, 220, 0.4)',
        ],
    ];

    /**
     * Get color palette by name
     */
    public static function getPalette(string $name = 'default'): array
    {
        return self::PALETTES[$name] ?? self::PALETTES['default'];
    }

    /**
     * Generate gradient colors
     */
    public static function generateGradient(
        string $startColor,
        string $endColor,
        int $steps
    ): array {
        [$r1, $g1, $b1] = self::hexToRgb($startColor);
        [$r2, $g2, $b2] = self::hexToRgb($endColor);

        $colors = [];
        for ($i = 0; $i < $steps; $i++) {
            $ratio = $i / ($steps - 1);
            $r = (int)($r1 + ($r2 - $r1) * $ratio);
            $g = (int)($g1 + ($g2 - $g1) * $ratio);
            $b = (int)($b1 + ($b2 - $b1) * $ratio);
            $colors[] = "rgba({$r}, {$g}, {$b}, 0.7)";
        }

        return $colors;
    }

    /**
     * Convert hex to RGB array
     */
    protected static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Get accessible color pairs (WCAG compliant)
     */
    public static function getAccessiblePairs(): array
    {
        return [
            ['background' => '#FFFFFF', 'foreground' => '#000000'],  // White/Black
            ['background' => '#000000', 'foreground' => '#FFFFFF'],  // Black/White
            ['background' => '#0066CC', 'foreground' => '#FFFFFF'],  // Blue/White
            ['background' => '#D60021', 'foreground' => '#FFFFFF'],  // Red/White
        ];
    }
}
```

**Usage in Widget:**

```php
protected function getData(): array
{
    $colors = ChartColorService::getPalette('professional');

    // Or generate gradient
    $gradientColors = ChartColorService::generateGradient(
        '#0066CC',  // Start color
        '#D60021',  // End color
        $dataCount  // Number of steps
    );

    return [
        'datasets' => [[
            'data' => $data,
            'backgroundColor' => $gradientColors,
        ]],
        'labels' => $labels,
    ];
}
```

---

## Chart Export System

### Export to PNG (Chart.js)

```php
namespace Modules\Chart\Actions\ChartJs;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Storage;

class ExportToPngAction
{
    use QueueableAction;

    /**
     * Export Chart.js chart to PNG
     *
     * @param string $base64Data Base64 image from canvas.toDataURL()
     * @param string|null $filename Optional filename
     * @param string $disk Storage disk
     * @param int $quality PNG quality (0-100)
     *
     * @return array Export result with path, url, size
     */
    public function execute(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
        int $quality = 95,
    ): array {
        // Remove base64 prefix
        $cleanedData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $imageData = base64_decode($cleanedData);

        // Generate filename
        $filename = $filename ?? 'chart-' . uniqid() . '.png';

        // Save to storage
        Storage::disk($disk)->put($filename, $imageData);

        return [
            'path' => $filename,
            'url' => Storage::disk($disk)->url($filename),
            'size' => Storage::disk($disk)->size($filename),
            'filename' => $filename,
            'quality' => $quality,
            'format' => 'png',
        ];
    }

    /**
     * Export for PDF (maximum quality)
     */
    public function executeForPdf(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->execute($base64Data, $filename, $disk, 100);
    }

    /**
     * Export for web (balanced quality)
     */
    public function executeForWeb(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->execute($base64Data, $filename, $disk, 85);
    }

    /**
     * Batch export multiple charts
     */
    public function executeBatch(
        array $charts,
        string $prefix = 'chart',
        string $disk = 'public',
        int $quality = 95,
    ): array {
        $results = [];

        foreach ($charts as $index => $base64Data) {
            $filename = $prefix . '-' . ($index + 1) . '.png';
            $result = $this->execute($base64Data, $filename, $disk, $quality);
            $results[] = $result;
        }

        return $results;
    }
}
```

### Export Widget to PNG (via Browsershot)

```php
namespace Modules\Chart\Actions\Widget;

use Filament\Widgets\ChartWidget;
use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

class SaveChartWidgetAsPngAction
{
    use QueueableAction;

    /**
     * Save Filament ChartWidget as PNG using Browsershot
     */
    public function execute(
        ChartWidget $widget,
        string $filename,
        int $width = 1200,
        int $height = 600,
    ): string {
        // 1. Render widget to HTML
        $html = app(RenderChartWidgetHtmlAction::class)->execute(
            $widget,
            $width,
            $height
        );

        // 2. Convert HTML to PNG via Browsershot
        $path = storage_path("app/public/charts/{$filename}");

        Browsershot::html($html)
            ->setScreenshotType('png')
            ->windowSize($width, $height)
            ->setOption('args', ['--no-sandbox'])
            ->save($path);

        return $path;
    }
}
```

### Render Widget HTML (for Export)

```php
namespace Modules\Chart\Actions\Widget;

use Filament\Widgets\ChartWidget;
use ReflectionMethod;

class RenderChartWidgetHtmlAction
{
    const CHARTJS_VERSION = '4.4.3';
    const DATALABELS_VERSION = '2.2.0';

    /**
     * Render ChartWidget to standalone HTML
     */
    public function execute(
        ChartWidget $widget,
        int $width = 1200,
        int $height = 600
    ): string {
        // Use reflection to access protected methods
        $data = $this->getWidgetData($widget);
        $type = $this->getWidgetType($widget);
        $options = $this->getWidgetOptions($widget);
        $heading = $this->getWidgetHeading($widget);

        $dataJson = json_encode($data);
        $optionsJson = json_encode($options);

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$heading}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@{$this::CHARTJS_VERSION}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@{$this::DATALABELS_VERSION}"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: white;
        }
        #chart-container {
            width: {$width}px;
            height: {$height}px;
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>{$heading}</h2>
    <div id="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: '{$type}',
            data: {$dataJson},
            options: {$optionsJson},
        });
    </script>
</body>
</html>
HTML;
    }

    protected function getWidgetData(ChartWidget $widget): array
    {
        $method = new ReflectionMethod($widget, 'getData');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }

    protected function getWidgetType(ChartWidget $widget): string
    {
        $method = new ReflectionMethod($widget, 'getType');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }

    protected function getWidgetOptions(ChartWidget $widget): array
    {
        $method = new ReflectionMethod($widget, 'getOptions');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }

    protected function getWidgetHeading(ChartWidget $widget): string
    {
        return $widget->heading ?? 'Chart';
    }
}
```

---

## Advanced Techniques

### Real-Time Chart Updates (Livewire)

```php
namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class RealTimeChartWidget extends ChartWidget
{
    protected static ?string $pollingInterval = '10s';  // Auto-refresh

    #[On('refresh-chart')]
    public function refreshChart(): void
    {
        $this->updateChartData();
    }

    protected function getData(): array
    {
        // Fetch latest data
        $latestData = $this->fetchLatestData();

        return [
            'datasets' => [[
                'data' => $latestData,
                // ...
            ]],
            'labels' => $this->getLabels(),
        ];
    }

    public function updateChartData(): void
    {
        // Dispatch browser event to update chart
        $this->dispatch('updateChartData', [
            'data' => $this->getData(),
        ]);
    }
}
```

**Blade view with JavaScript:**

```blade
<div wire:poll.10s="updateChartData">
    {{ $this->chart }}
</div>

@push('scripts')
<script>
    Livewire.on('updateChartData', (event) => {
        // Find chart instance
        const chart = Chart.getChart('chart-id');

        // Update data
        chart.data = event.data;
        chart.update('active');
    });
</script>
@endpush
```

### Drill-Down Charts

```php
class DrillDownChartWidget extends ChartWidget
{
    public ?string $drillLevel = 'year';
    public ?string $selectedYear = null;

    protected function getData(): array
    {
        if ($this->drillLevel === 'year') {
            return $this->getYearlyData();
        }

        if ($this->drillLevel === 'month') {
            return $this->getMonthlyData($this->selectedYear);
        }

        return [];
    }

    public function drillDown(string $year): void
    {
        $this->selectedYear = $year;
        $this->drillLevel = 'month';
    }

    public function drillUp(): void
    {
        $this->drillLevel = 'year';
        $this->selectedYear = null;
    }

    protected function getOptions(): array
    {
        return [
            'onClick' => "(event, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const label = chart.data.labels[index];
                    Livewire.dispatch('drill-down', { year: label });
                }
            }",
        ];
    }
}
```

### Comparison Charts (Multiple Datasets)

```php
class ComparisonChartWidget extends ChartWidget
{
    public array $selectedYears = [2025, 2026];

    protected function getData(): array
    {
        $datasets = [];

        foreach ($this->selectedYears as $year) {
            $data = $this->getDataForYear($year);

            $datasets[] = [
                'label' => "Year {$year}",
                'data' => $data,
                'backgroundColor' => $this->getColorForYear($year),
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
        ];
    }

    protected function getColorForYear(int $year): string
    {
        $colors = [
            2024 => 'rgba(100, 100, 100, 0.6)',
            2025 => 'rgba(54, 162, 235, 0.6)',
            2026 => 'rgba(255, 99, 132, 0.6)',
        ];

        return $colors[$year] ?? 'rgba(200, 200, 200, 0.6)';
    }
}
```

---

## Performance Optimization

### 1. Database Query Optimization

```php
// ❌ BAD: N+1 queries
foreach ($questionCharts as $chart) {
    $responses = SurveyResponse::getResponsesForSurvey($chart->survey_id)
        ->withAnswersLabel($chart->question, $chart->field_name)
        ->get();
}

// ✅ GOOD: Single query with grouping
$responses = SurveyResponse::getResponsesForSurvey($surveyId)
    ->withAllAnswers('subquery')
    ->get();

$groupedByQuestion = $responses->groupBy('question_id');
```

### 2. Caching Chart Data

```php
use Illuminate\Support\Facades\Cache;

protected function getData(): array
{
    $cacheKey = "chart-data-{$this->record->id}-" . md5(json_encode($this->filters));

    return Cache::remember($cacheKey, 300, function () {
        return $this->fetchChartData();
    });
}
```

### 3. Lazy Loading Widgets

```php
class LazyChartWidget extends ChartWidget
{
    protected static bool $isLazy = true;  // Enable lazy loading

    protected function getData(): array
    {
        // Expensive data fetching
        sleep(2);

        return [
            // ... data
        ];
    }
}
```

### 4. Queueable Export Actions

```php
use Spatie\QueueableAction\QueueableAction;

class ExportChartAction
{
    use QueueableAction;

    public function execute(QuestionChart $chart): void
    {
        // Long-running export
        $this->generatePng($chart);
    }
}

// Dispatch to queue
app(ExportChartAction::class)->onQueue()->execute($chart);
```

### 5. JpGraph Memory Management

```php
// For batch chart generation
foreach ($charts as $chart) {
    $graph = $this->generateGraph($chart);
    $graph->Stroke($filename);

    // Free memory
    unset($graph);
    gc_collect_cycles();
}
```

---

## Best Practices

### 1. Always Use DTOs

**✅ CORRECT:**
```php
$chartData = ChartData::from($chartModel);
$answersChartData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
]);
```

**❌ WRONG:**
```php
// Passing raw arrays without validation
$this->generateChart(['data' => $data, 'type' => 'bar']);
```

### 2. Separate Frontend and Backend Logic

**Frontend (Chart.js):**
- Interactive dashboards
- Real-time updates
- User interactions

**Backend (JpGraph):**
- PDF export
- Scheduled reports
- High-quality static images

### 3. Consistent Color Usage

```php
// Store colors in ChartData, not hardcoded
$chart = Chart::create([
    'list_color' => '#d60021,#0066cc,#ffcc00',  // Brand colors
]);

// Use color service for consistency
$colors = ChartColorService::getPalette('professional');
```

### 4. Validate Chart Types

```php
public function setChartType(string $type): void
{
    $validTypes = ['bar', 'line', 'pie', 'doughnut', 'radar'];

    if (!in_array($type, $validTypes)) {
        throw new \InvalidArgumentException("Invalid chart type: {$type}");
    }

    $this->chartType = $type;
}
```

### 5. Handle Missing Data Gracefully

```php
protected function getData(): array
{
    $data = $this->fetchData();

    if ($data->isEmpty()) {
        return [
            'datasets' => [[
                'data' => [0],
                'backgroundColor' => 'rgba(200, 200, 200, 0.5)',
            ]],
            'labels' => ['No Data'],
        ];
    }

    return $this->transformData($data);
}
```

### 6. Use Type Hints

```php
// ✅ CORRECT
public function execute(AnswersChartData $data): Graph
{
    // ...
}

// ❌ WRONG
public function execute($data)
{
    // ...
}
```

### 7. Document Complex Charts

```php
/**
 * Generate dual-scale comparison chart
 *
 * This chart displays both count (bars) and average (line) on separate Y-axes:
 * - Left Y-axis: Response count (bars)
 * - Right Y-axis: Average rating (line)
 *
 * @param QuestionChart $chart Question chart model
 * @param Collection $responses Survey responses
 * @return array Chart.js data structure
 */
public function generateDualScaleChart(
    QuestionChart $chart,
    Collection $responses
): array {
    // Implementation
}
```

---

## Collegamenti e Riferimenti

### Documentazione Installazione Filament 5.x

- **[filament-5-installation-guide.md](./filament-5-installation-guide.md)**: ⭐ Guida completa installazione Filament 5.x, configurazione Tailwind CSS v4.1+, e registrazione Chart.js plugins
- **[filament-installation-and-charts.md](../../Xot/docs/filament-installation-and-charts.md)**: Guida generale installazione Filament e configurazione charts (aggiornato per Filament 5.x)

### Documentazione Moduli Correlati

- **[UI Module - Chart.js Guide](../../UI/docs/charts/filament-chart-js-guide.md)**: Guida Chart.js per Filament 5.x nel modulo UI
- **[Xot Module - Filament Requirements](../../Xot/docs/filament-5-requirements.md)**: Requisiti critici Filament 5.x per il progetto

### Documentazione Root

- **[Filament 5.x Installation Summary](../../../docs/filament-5-installation-summary.md)**: Riepilogo centrale requisiti Filament 5.x

### Documentazione Ufficiale Filament

- [Filament 5.x Installation](https://filamentphp.com/docs/5.x/introduction/installation)
- [Filament 5.x Charts Widgets](https://filamentphp.com/docs/5.x/widgets/charts)
- [Filament 5.x Assets](https://filamentphp.com/docs/5.x/assets)

---

## Reference Files

**Chart Module:**
- `/Modules/Chart/app/Actions/ChartJs/` - Chart.js export actions
- `/Modules/Chart/app/Actions/JpGraph/` - JpGraph rendering actions
- `/Modules/Chart/app/Datas/` - Data objects (ChartData, AnswersChartData)
- `/Modules/Chart/app/Filament/Widgets/Samples/` - Example widgets
- `/Modules/Chart/app/Models/Chart.php` - Chart model

**Quaeris Module:**
- `/Modules/Quaeris/app/Filament/Widgets/` - Survey chart widgets
- `/Modules/Quaeris/app/Models/QuestionChart.php` - Question chart model
- `/Modules/Quaeris/app/Actions/QuestionChart/` - Chart generation actions

**Xot Module:**
- `/Modules/Xot/Filament/Widgets/XotBaseChartWidget.php` - Base widget class

---

**Version:** 2.0 (Filament 5.x)
**Last Updated:** January 2026
**Maintained By:** Quaeris Development Team
