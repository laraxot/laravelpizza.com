# 📊 Charts System - Filament + Chart.js

**Data Aggiornamento**: 2025-12-09
**Versione Filament**: 4.x
**Versione Chart.js**: 4.x
**Status**: ✅ Production Ready

---

## 📋 Indice

1. [Overview](#overview)
2. [Filament Chart Widgets](#filament-chart-widgets)
3. [Chart.js Configuration](#chartjs-configuration)
4. [Plugin Ecosystem](#plugin-ecosystem)
5. [Export Charts (PNG/SVG)](#export-charts-pngsvg)
6. [Best Practices](#best-practices)
7. [Examples](#examples)

---

## 🎯 Overview

Il sistema di charts PTVX integra **Filament Chart Widgets** con **Chart.js 4.x**, offrendo:

- ✅ **8 tipi di grafici** (Line, Bar, Pie, Doughnut, Radar, Polar Area, Bubble, Scatter)
- ✅ **Plugin ecosystem** (Annotation, Zoom, DataLabels, Streaming, ecc.)
- ✅ **Export PNG/SVG** per report e condivisione
- ✅ **Responsive & Mobile-friendly**
- ✅ **Real-time updates** con polling
- ✅ **Filtraggio dati** avanzato
- ✅ **Integrazione Eloquent** tramite `flowframe/laravel-trend`

---

## 📊 Filament Chart Widgets

### Creazione Widget

```bash
php artisan make:filament-widget BlogPostsChart --chart
```

### Struttura Base

```php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    // Chart type: 'line', 'bar', 'pie', 'doughnut', 'radar', 'polarArea', 'bubble', 'scatter'
    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
        ];
    }
}
```

### Configurazione Avanzata

```php
// Colore tema Filament
protected static ?string $color = 'info'; // success, warning, danger, info

// Altezza massima
protected static ?string $maxHeight = '300px';

// Polling (aggiornamento automatico)
protected static ?string $pollingInterval = '10s'; // null per disabilitare

// Opzioni Chart.js
protected function getOptions(): array
{
    return [
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
            ],
        ],
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'callback' => RawJs::make('(value) => "€ " + value'),
                ],
            ],
        ],
    ];
}

// Descrizione
protected function getDescription(): ?string
{
    return 'Trend mensile dei post pubblicati';
}
```

---

## 🎨 Chart.js Configuration

### Tipi di Grafici

#### 1. Line Chart
```php
protected function getType(): string { return 'line'; }

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Sales',
                'data' => [12, 19, 3, 5, 2, 3],
                'fill' => 'start',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'borderColor' => 'rgb(59, 130, 246)',
                'tension' => 0.4, // Smooth curves
            ],
        ],
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    ];
}
```

#### 2. Bar Chart
```php
protected function getType(): string { return 'bar'; }

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Users',
                'data' => [65, 59, 80, 81, 56, 55],
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                ],
                'borderWidth' => 1,
            ],
        ],
        'labels' => ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6'],
    ];
}
```

#### 3. Pie/Doughnut Chart
```php
protected function getType(): string { return 'doughnut'; }

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'data' => [300, 50, 100],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                ],
                'hoverOffset' => 4,
            ],
        ],
        'labels' => ['Red', 'Blue', 'Yellow'],
    ];
}
```

### Opzioni Avanzate

#### Responsive & Aspect Ratio
```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'aspectRatio' => 2, // width / height
    ];
}
```

#### Animazioni
```php
protected function getOptions(): array
{
    return [
        'animation' => [
            'duration' => 2000,
            'easing' => 'easeInOutQuart',
        ],
    ];
}
```

#### Tooltips
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'tooltip' => [
                'enabled' => true,
                'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                'titleColor' => '#fff',
                'bodyColor' => '#fff',
                'callbacks' => [
                    'label' => RawJs::make('(context) => {
                        let label = context.dataset.label || "";
                        if (label) label += ": ";
                        label += "€" + context.parsed.y.toFixed(2);
                        return label;
                    }'),
                ],
            ],
        ],
    ];
}
```

---

## 🧩 Plugin Ecosystem

### Plugin Disponibili

#### 1. **Annotation Plugin** - Linee, box, label
```bash
npm install chartjs-plugin-annotation
```

```javascript
// resources/js/app.js
import annotationPlugin from 'chartjs-plugin-annotation';
Chart.register(annotationPlugin);
```

**Configurazione:**
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'annotation' => [
                'annotations' => [
                    'line1' => [
                        'type' => 'line',
                        'yMin' => 60,
                        'yMax' => 60,
                        'borderColor' => 'rgb(255, 99, 132)',
                        'borderWidth' => 2,
                        'label' => [
                            'content' => 'Target: 60',
                            'enabled' => true,
                        ],
                    ],
                ],
            ],
        ],
    ];
}
```

#### 2. **Zoom Plugin** - Zoom & Pan
```bash
npm install chartjs-plugin-zoom
```

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'zoom' => [
                'zoom' => [
                    'wheel' => ['enabled' => true],
                    'pinch' => ['enabled' => true],
                    'mode' => 'xy',
                ],
                'pan' => [
                    'enabled' => true,
                    'mode' => 'xy',
                ],
            ],
        ],
    ];
}
```

#### 3. **DataLabels Plugin** - Etichette sui dati
```bash
npm install chartjs-plugin-datalabels
```

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'color' => '#fff',
                'font' => [
                    'weight' => 'bold',
                    'size' => 16,
                ],
            ],
        ],
    ];
}
```

#### 4. **Altri Plugin Utili**

| Plugin | NPM Package | Use Case |
|--------|-------------|----------|
| **Streaming** | `chartjs-plugin-streaming` | Dati real-time |
| **Gradient** | `chartjs-plugin-gradient` | Gradienti facili |
| **Autocolors** | `chartjs-plugin-autocolors` | Palette automatiche |
| **Matrix** | `chartjs-chart-matrix` | Heatmaps |
| **Treemap** | `chartjs-chart-treemap` | Grafici gerarchici |
| **Sankey** | `chartjs-chart-sankey` | Flow diagrams |
| **Geo** | `chartjs-chart-geo` | Mappe geografiche |

---

## 💾 Export Charts (PNG/SVG)

### Metodo 1: Canvas toDataURL (PNG)

**Backend - Action Filament:**

```php
namespace App\Filament\Actions;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;

class ExportChartAction extends Action
{
    public static function make(?string $name = 'exportChart'): static
    {
        return parent::make($name)
            ->label('Export PNG')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (array $data) {
                // Il data URL viene inviato dal frontend
                $imageData = $data['imageData'];

                // Rimuovi il prefisso data:image/png;base64,
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = base64_decode($imageData);

                // Salva il file
                $filename = 'chart_' . now()->format('Y-m-d_His') . '.png';
                Storage::disk('public')->put("charts/{$filename}", $imageData);

                // Notifica successo
                Notification::make()
                    ->title('Chart exported successfully')
                    ->success()
                    ->send();

                return Storage::disk('public')->url("charts/{$filename}");
            })
            ->form([
                Hidden::make('imageData')
                    ->required(),
            ]);
    }
}
```

**Frontend - Alpine.js:**

```blade
<div x-data="chartExportHandler()">
    <canvas id="myChart"></canvas>

    <button @click="exportChart()">Export PNG</button>

    @script
    <script>
        function chartExportHandler() {
            return {
                exportChart() {
                    const canvas = document.getElementById('myChart');
                    const imageData = canvas.toDataURL('image/png');

                    // Invia al backend tramite Livewire
                    $wire.dispatchFormEvent('exportChart', {
                        imageData: imageData
                    });
                }
            }
        }
    </script>
    @endscript
</div>
```

### Metodo 2: html2canvas (Universal)

```bash
npm install html2canvas
```

```javascript
import html2canvas from 'html2canvas';

document.getElementById('exportBtn').addEventListener('click', async () => {
    const chartContainer = document.getElementById('chart-container');

    const canvas = await html2canvas(chartContainer, {
        backgroundColor: '#ffffff',
        scale: 2, // Higher quality
    });

    // Download
    const link = document.createElement('a');
    link.download = 'chart.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
});
```

### Metodo 3: SVG Export (canvg)

```bash
npm install canvg
```

```javascript
import { Canvg } from 'canvg';

async function exportToSVG() {
    const canvas = document.getElementById('myChart');
    const ctx = canvas.getContext('2d');

    // Convert canvas to SVG
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', canvas.width);
    svg.setAttribute('height', canvas.height);

    const v = await Canvg.from(ctx, canvas.toDataURL());
    v.render();

    const svgData = new XMLSerializer().serializeToString(svg);
    const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });

    // Download
    const link = document.createElement('a');
    link.download = 'chart.svg';
    link.href = URL.createObjectURL(svgBlob);
    link.click();
}
```

### Metodo 4: Backend con Puppeteer (Server-side)

```bash
composer require spatie/browsershot
npm install puppeteer
```

```php
use Spatie\Browsershot\Browsershot;

public function exportChartAction(): Action
{
    return Action::make('export')
        ->label('Export PNG')
        ->action(function () {
            $html = view('charts.render', [
                'chartData' => $this->getChartData(),
            ])->render();

            $path = storage_path('app/public/charts/chart_' . time() . '.png');

            Browsershot::html($html)
                ->setScreenshotType('png')
                ->windowSize(1200, 800)
                ->save($path);

            return response()->download($path);
        });
}
```

---

## 🎯 Best Practices

### 1. Performance

```php
// ✅ Lazy loading per dashboard con molti widget
protected static bool $isLazy = true;

// ✅ Cache dei dati pesanti
protected function getData(): array
{
    return Cache::remember('chart-data-' . auth()->id(), 3600, function () {
        return $this->calculateChartData();
    });
}

// ✅ Limita i punti dati per grafici grandi
protected function getData(): array
{
    $data = Model::query()
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->take(365) // Max 1 anno
        ->pluck('count', 'date');

    return [...];
}
```

### 2. Responsiveness

```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => true,
        'aspectRatio' => 2,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom', // Mobile-friendly
            ],
        ],
    ];
}
```

### 3. Accessibilità

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'title' => [
                'display' => true,
                'text' => 'Monthly Sales Report',
            ],
            'subtitle' => [
                'display' => true,
                'text' => 'Data from January to December 2025',
            ],
        ],
    ];
}
```

### 4. Filtraggio Dati

```php
protected function getFilters(): ?array
{
    return [
        'today' => 'Oggi',
        'week' => 'Questa settimana',
        'month' => 'Questo mese',
        'year' => 'Quest\'anno',
    ];
}

protected function getData(): array
{
    $filter = $this->filter;

    $query = Order::query();

    match ($filter) {
        'today' => $query->whereDate('created_at', today()),
        'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
        'month' => $query->whereMonth('created_at', now()->month),
        'year' => $query->whereYear('created_at', now()->year),
        default => $query,
    };

    // Generate chart data...
}
```

---

## 📚 Examples

### Example 1: Sales Trend con Laravel Trend

```bash
composer require flowframe/laravel-trend
```

```php
use Flowframe\Trend\Trend;
use App\Models\Order;

class SalesTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Trend';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->sum('total');

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data->map(fn ($value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date),
        ];
    }
}
```

### Example 2: Multi-dataset Bar Chart

```php
class DepartmentComparisonChart extends ChartWidget
{
    protected static ?string $heading = 'Department Performance';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => '2024',
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                ],
                [
                    'label' => '2025',
                    'data' => [28, 48, 40, 19, 86, 27, 90],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                ],
            ],
            'labels' => ['IT', 'Sales', 'Marketing', 'HR', 'Finance', 'Operations', 'Support'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
```

### Example 3: Real-time Streaming Chart

```bash
npm install chartjs-plugin-streaming
```

```php
class RealTimeMetricsChart extends ChartWidget
{
    protected static ?string $heading = 'Real-time Metrics';
    protected static ?string $pollingInterval = '1s';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'CPU Usage',
                    'data' => [], // Populated by streaming
                    'borderColor' => 'rgb(255, 99, 132)',
                    'fill' => false,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'type' => 'realtime',
                    'realtime' => [
                        'duration' => 20000,
                        'refresh' => 1000,
                        'delay' => 2000,
                        'onRefresh' => RawJs::make('(chart) => {
                            chart.data.datasets[0].data.push({
                                x: Date.now(),
                                y: Math.random() * 100
                            });
                        }'),
                    ],
                ],
            ],
        ];
    }
}
```

---

## 🔗 Risorse

### Documentazione Ufficiale
- [Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)
- [Chart.js](https://www.chartjs.org/)
- [Chart.js Plugins](https://github.com/chartjs/awesome)

### Plugin Consigliati
- [Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)
- [Zoom Plugin](https://www.chartjs.org/chartjs-plugin-zoom/latest/)
- [DataLabels Plugin](https://chartjs-plugin-datalabels.netlify.app/)
- [Streaming Plugin](https://nagix.github.io/chartjs-plugin-streaming/)

### Tools
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)
- [html2canvas](https://html2canvas.hertzen.com/)
- [Browsershot](https://github.com/spatie/browsershot)

---

## 📝 Changelog

| Data | Versione | Modifiche |
|------|----------|-----------|
| 2025-12-09 | 1.0.0 | Documentazione iniziale completa |

---

**Autore**: PTVX Development Team
**Licenza**: Internal Use Only
