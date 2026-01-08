# Filament Charts - Guida Completa per PTVX

## 📋 Panoramica

**Filament Charts** è un sistema di widget basato su **Chart.js** integrato in Filament PHP. Permette di creare grafici interattivi e responsive per dashboard e pannelli amministrativi.

**Repository:** https://github.com/filamentphp/filament
**Documentazione:** https://filamentphp.com/docs/4.x/widgets/charts
**Chart.js:** https://www.chartjs.org/
**Versione Filament:** 4.x
**Framework:** Laraxot/PTVX

---

## 🚀 Creazione Chart Widget

### Comando Artisan

```bash
php artisan make:filament-widget BlogPostsChart --chart
```

Questo genera un widget in `app/Filament/Widgets/BlogPostsChart.php`.

### Struttura Base Widget

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected static ?int $sort = 2;

    protected static bool $isLazy = true;

    protected ?string $pollingInterval = '30s';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

---

## 📊 Tipi di Chart Supportati

Filament supporta tutti i tipi di chart di Chart.js:

### 1. Line Chart
```php
protected function getType(): string
{
    return 'line';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Vendite',
                'data' => [10, 20, 30, 40, 50],
                'fill' => false,
                'borderColor' => 'rgb(75, 192, 192)',
                'tension' => 0.4, // Curvatura linea
            ],
        ],
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'],
    ];
}
```

### 2. Bar Chart
```php
protected function getType(): string
{
    return 'bar';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Utenti Registrati',
                'data' => [12, 19, 3, 5, 2, 3],
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                'borderColor' => [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                'borderWidth' => 1,
            ],
        ],
        'labels' => ['Rosso', 'Blu', 'Giallo', 'Verde', 'Viola', 'Arancione'],
    ];
}
```

### 3. Pie Chart
```php
protected function getType(): string
{
    return 'pie';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Distribuzione Utenti',
                'data' => [300, 50, 100],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                ],
            ],
        ],
        'labels' => ['Admin', 'Editor', 'Viewer'],
    ];
}
```

### 4. Doughnut Chart
```php
protected function getType(): string
{
    return 'doughnut';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Task Status',
                'data' => [10, 20, 30],
                'backgroundColor' => ['#10b981', '#f59e0b', '#ef4444'],
            ],
        ],
        'labels' => ['Completate', 'In Progress', 'Da Fare'],
    ];
}
```

### 5. Radar Chart
```php
protected function getType(): string
{
    return 'radar';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Skill Set',
                'data' => [65, 59, 90, 81, 56, 55, 40],
                'fill' => true,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgb(255, 99, 132)',
                'pointBackgroundColor' => 'rgb(255, 99, 132)',
                'pointBorderColor' => '#fff',
                'pointHoverBackgroundColor' => '#fff',
                'pointHoverBorderColor' => 'rgb(255, 99, 132)',
            ],
        ],
        'labels' => ['PHP', 'JavaScript', 'SQL', 'HTML', 'CSS', 'Laravel', 'Vue'],
    ];
}
```

### 6. Polar Area Chart
```php
protected function getType(): string
{
    return 'polarArea';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Preferenze',
                'data' => [11, 16, 7, 3, 14],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(201, 203, 207)',
                    'rgb(54, 162, 235)',
                ],
            ],
        ],
        'labels' => ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
    ];
}
```

### 7. Bubble Chart
```php
protected function getType(): string
{
    return 'bubble';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Dataset 1',
                'data' => [
                    ['x' => 20, 'y' => 30, 'r' => 15],
                    ['x' => 40, 'y' => 10, 'r' => 10],
                    ['x' => 10, 'y' => 50, 'r' => 20],
                ],
                'backgroundColor' => 'rgb(255, 99, 132)',
            ],
        ],
    ];
}
```

### 8. Scatter Chart
```php
protected function getType(): string
{
    return 'scatter';
}

protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Scatter Dataset',
                'data' => [
                    ['x' => -10, 'y' => 0],
                    ['x' => 0, 'y' => 10],
                    ['x' => 10, 'y' => 5],
                    ['x' => 0.5, 'y' => 5.5],
                ],
                'backgroundColor' => 'rgb(255, 99, 132)',
            ],
        ],
    ];
}
```

---

## 🎨 Personalizzazione

### Heading e Descrizione

```php
protected static ?string $heading = 'Statistiche Vendite';

public function getDescription(): ?string
{
    return 'Andamento delle vendite negli ultimi 12 mesi';
}
```

### Colori con Theme

```php
protected static ?string $color = 'info'; // success, warning, danger, info

// Oppure manualmente nei dataset
'backgroundColor' => [
    'rgba(59, 130, 246, 0.5)',  // Blue
    'rgba(16, 185, 129, 0.5)',  // Green
    'rgba(239, 68, 68, 0.5)',   // Red
],
```

### Altezza Chart

```php
protected static ?string $maxHeight = '300px';
```

### Polling e Lazy Loading

```php
protected static bool $isLazy = true; // Carica on-demand

protected ?string $pollingInterval = '30s'; // Aggiorna ogni 30 secondi
// Valori: null (disabled), '5s', '30s', '1m', '5m'
```

### Collapsible Widget

```php
protected static bool $isCollapsible = true;
```

---

## 🔧 Configurazione Chart.js

### Override Opzioni Chart.js

```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
                'labels' => [
                    'color' => 'rgb(100, 100, 100)',
                    'font' => [
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                ],
            ],
            'title' => [
                'display' => true,
                'text' => 'Statistiche Mensili',
                'font' => [
                    'size' => 18,
                ],
            ],
            'tooltip' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false,
                'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                'titleColor' => '#fff',
                'bodyColor' => '#fff',
            ],
        ],
        'scales' => [
            'x' => [
                'display' => true,
                'title' => [
                    'display' => true,
                    'text' => 'Mese',
                ],
                'grid' => [
                    'display' => false,
                ],
            ],
            'y' => [
                'display' => true,
                'title' => [
                    'display' => true,
                    'text' => 'Valore',
                ],
                'beginAtZero' => true,
                'ticks' => [
                    'stepSize' => 10,
                ],
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

### Callback JavaScript con RawJs

```php
use Filament\Support\RawJs;

protected function getOptions(): array
{
    return [
        'plugins' => [
            'tooltip' => [
                'callbacks' => [
                    'label' => RawJs::make(<<<'JS'
                        function(context) {
                            return context.dataset.label + ': ' +
                                   context.parsed.y + ' unità';
                        }
                    JS),
                ],
            ],
        ],
    ];
}
```

---

## 📈 Integrazione con Laravel Trend

### Installazione

```bash
composer require flowframe/laravel-trend
```

### Uso Base

```php
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\BlogPost;

protected function getData(): array
{
    $data = Trend::model(BlogPost::class)
        ->between(
            start: now()->subDays(30),
            end: now(),
        )
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Blog posts',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
}
```

### Trend Avanzati

```php
// Per mese
$data = Trend::model(Order::class)
    ->between(start: now()->subYear(), end: now())
    ->perMonth()
    ->sum('total_amount');

// Per anno
$data = Trend::model(User::class)
    ->between(start: now()->subYears(5), end: now())
    ->perYear()
    ->count();

// Media
$data = Trend::model(Rating::class)
    ->between(start: now()->subMonth(), end: now())
    ->perDay()
    ->average('score');
```

---

## 🔍 Filtri

### Filtri Semplici

```php
protected static ?string $filter = 'today';

protected function getFilters(): ?array
{
    return [
        'today' => 'Oggi',
        'week' => 'Ultima Settimana',
        'month' => 'Ultimo Mese',
        'year' => 'Ultimo Anno',
    ];
}

protected function getData(): array
{
    $activeFilter = $this->filter;

    $startDate = match ($activeFilter) {
        'today' => now()->startOfDay(),
        'week' => now()->subWeek(),
        'month' => now()->subMonth(),
        'year' => now()->subYear(),
        default => now()->subMonth(),
    };

    $data = Trend::model(Post::class)
        ->between(start: $startDate, end: now())
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Posts',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date->format('d/m')),
    ];
}
```

### Filtri Avanzati con Schema

```php
use Filament\Widgets\Concerns\HasFiltersSchema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class SalesChart extends ChartWidget
{
    use HasFiltersSchema;

    protected function getFiltersSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Data Inizio')
                ->default(now()->subMonth()),
            DatePicker::make('endDate')
                ->label('Data Fine')
                ->default(now()),
            Select::make('type')
                ->label('Tipo')
                ->options([
                    'all' => 'Tutti',
                    'online' => 'Online',
                    'store' => 'Negozio',
                ])
                ->default('all'),
        ];
    }

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();
        $type = $this->filters['type'] ?? 'all';

        // Usa i filtri per generare dati
        // ...
    }
}
```

---

## 🎯 Best Practices PTVX

### 1. Widget Base Estendibile

```php
// Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php
<?php

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Traits\TransTrait;

abstract class XotBaseChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;
    use TransTrait;

    protected ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return static::trans('navigation.heading');
    }

    protected function getData(): array
    {
        return [];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
        ];
    }

    protected function getHeight(): ?string
    {
        return '300px';
    }
}
```

### 2. Cache dei Dati

```php
use Illuminate\Support\Facades\Cache;

protected function getData(): array
{
    return Cache::remember(
        'chart-data-' . static::class,
        now()->addMinutes(5),
        function () {
            return $this->fetchChartData();
        }
    );
}

private function fetchChartData(): array
{
    $data = Trend::model(User::class)
        ->between(start: now()->subMonth(), end: now())
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Users',
                'data' => $data->map(fn ($value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn ($value) => $value->date->format('d/m')),
    ];
}
```

### 3. Gestione Errori

```php
protected function getData(): array
{
    try {
        $data = Trend::model($this->model)
            ->between(start: now()->subDays(30), end: now())
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Data',
                    'data' => $data->map(fn ($value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date->format('d/m')),
        ];
    } catch (\Exception $e) {
        // Fallback con dati vuoti
        return [
            'datasets' => [
                [
                    'label' => 'Data',
                    'data' => [],
                ],
            ],
            'labels' => [],
        ];
    }
}
```

### 4. Performance: Limit Query

```php
protected function getData(): array
{
    // Limitare il range massimo per evitare sovraccarico
    $startDate = now()->subDays(90); // Max 90 giorni
    $endDate = now();

    $data = Trend::model(Log::class)
        ->between(start: $startDate, end: $endDate)
        ->perDay()
        ->count()
        ->take(100); // Massimo 100 record

    return [
        'datasets' => [
            [
                'label' => 'Logs',
                'data' => $data->pluck('aggregate')->toArray(),
            ],
        ],
        'labels' => $data->pluck('date')->toArray(),
    ];
}
```

---

## 📦 Plugin Chart.js

### Installazione Plugin

1. **Installa tramite npm:**
```bash
npm install chartjs-plugin-annotation
npm install chartjs-plugin-zoom
npm install chartjs-plugin-datalabels
```

2. **Registra plugin in JavaScript:**

```javascript
// resources/js/chartjs-plugins.js
import Chart from 'chart.js/auto';
import annotationPlugin from 'chartjs-plugin-annotation';
import zoomPlugin from 'chartjs-plugin-zoom';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Registra globalmente
Chart.register(annotationPlugin, zoomPlugin, ChartDataLabels);

// Rendi disponibile a Filament
window.filamentChartJsPlugins = window.filamentChartJsPlugins || [];
window.filamentChartJsPlugins.push(annotationPlugin, zoomPlugin, ChartDataLabels);
```

3. **Compila con Vite:**

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/chartjs-plugins.js', // Aggiungi questo
            ],
            refresh: true,
        }),
    ],
});
```

4. **Registra in Service Provider:**

```php
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;

public function boot(): void
{
    FilamentAsset::register([
        Js::make('chartjs-plugins', resource_path('js/chartjs-plugins.js'))
            ->loadedOnRequest(),
    ]);
}
```

### Uso Plugin Annotation

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
                            'display' => true,
                            'content' => 'Target',
                            'position' => 'end',
                        ],
                    ],
                    'box1' => [
                        'type' => 'box',
                        'xMin' => 1,
                        'xMax' => 2,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.25)',
                    ],
                ],
            ],
        ],
    ];
}
```

### Uso Plugin Zoom

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'zoom' => [
                'pan' => [
                    'enabled' => true,
                    'mode' => 'xy',
                ],
                'zoom' => [
                    'wheel' => [
                        'enabled' => true,
                    ],
                    'pinch' => [
                        'enabled' => true,
                    ],
                    'mode' => 'xy',
                ],
            ],
        ],
    ];
}
```

---

## 🧪 Testing

### Test Unitario Widget

```php
use Tests\TestCase;
use App\Filament\Widgets\BlogPostsChart;

class BlogPostsChartTest extends TestCase
{
    /** @test */
    public function it_returns_valid_chart_data()
    {
        $widget = new BlogPostsChart();
        $data = $widget->getData();

        $this->assertArrayHasKey('datasets', $data);
        $this->assertArrayHasKey('labels', $data);
        $this->assertIsArray($data['datasets']);
        $this->assertIsArray($data['labels']);
    }

    /** @test */
    public function it_returns_correct_chart_type()
    {
        $widget = new BlogPostsChart();

        $this->assertEquals('line', $widget->getType());
    }
}
```

---

## 📚 Risorse

### Documentazione Ufficiale
- [Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)
- [Chart.js](https://www.chartjs.org/docs/latest/)
- [Chart.js Samples](https://www.chartjs.org/docs/latest/samples/)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)

### Plugin Chart.js
- [chartjs-plugin-annotation](https://www.chartjs.org/chartjs-plugin-annotation/latest/)
- [chartjs-plugin-zoom](https://www.chartjs.org/chartjs-plugin-zoom/latest/)
- [chartjs-plugin-datalabels](https://chartjs-plugin-datalabels.netlify.app/)
- [Awesome Chart.js](https://github.com/chartjs/awesome)

### Documentazione PTVX
- [Widget Implementation Rules](./widget_implementation_rules.md)
- [Export Chart to PNG/SVG](./chart-export-guide.md)
- [Filament Best Practices](./filament-best-practices.md)

---

**Ultimo aggiornamento:** Dicembre 2025
**Versione Filament:** 4.x
**Chart.js:** 4.x
**Framework:** Laraxot/PTVX
**PHPStan Level:** 10
