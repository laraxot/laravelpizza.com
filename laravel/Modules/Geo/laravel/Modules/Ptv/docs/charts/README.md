# 📊 PTV Charts - Public Transport Analytics

**Modulo**: Ptv
**Data**: 2025-12-09
**Status**: ✅ Production Ready

---

## 📋 Overview

Chart widgets per analisi dati trasporto pubblico, metriche utilizzo, e statistiche operazionali.

### Use Cases

- 🚌 **Usage Trends** - Andamento utilizzo servizi
- 📈 **Routes Analytics** - Analisi performance percorsi
- 💰 **Cost Analysis** - Analisi costi/benefici
- 📊 **User Demographics** - Distribuzione utenti

---

## 📊 Example Widgets

### 1. Usage Timeline Chart

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\Ptv\Models\PtvUsage;

class UsageTimelineChart extends ChartWidget
{
    protected static ?string $heading = 'PTV Usage Timeline';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(PtvUsage::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Usage Count',
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
            '3months' => 'Last 3 months',
            '6months' => 'Last 6 months',
            'year' => 'Last year',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 2. Routes Performance Bar Chart

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Ptv\Models\Route;
use Illuminate\Support\Facades\DB;

class RoutesPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Routes Performance';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $routes = Route::query()
            ->withCount('usages')
            ->orderByDesc('usages_count')
            ->take(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Usage Count',
                    'data' => $routes->pluck('usages_count'),
                    'backgroundColor' => $routes->map(function ($route) {
                        $count = $route->usages_count;
                        return $count > 100 ? 'rgba(34, 197, 94, 0.8)' :
                               ($count > 50 ? 'rgba(59, 130, 246, 0.8)' : 'rgba(251, 146, 60, 0.8)');
                    }),
                ],
            ],
            'labels' => $routes->pluck('name'),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 3. Cost Analysis Multi-line Chart

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Ptv\Models\PtvCost;
use Illuminate\Support\Facades\DB;

class CostAnalysisChart extends ChartWidget
{
    protected static ?string $heading = 'Cost Analysis';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $months = collect(range(1, 12))->map(fn ($m) => now()->month($m)->format('M'));

        $totalCosts = PtvCost::query()
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $reimbursements = PtvCost::query()
            ->selectRaw('MONTH(date) as month, SUM(reimbursed_amount) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Total Costs (€)',
                    'data' => $months->keys()->map(fn ($m) => $totalCosts->get($m + 1, 0)),
                    'borderColor' => 'rgb(239, 68, 68)',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => false,
                ],
                [
                    'label' => 'Reimbursements (€)',
                    'data' => $months->keys()->map(fn ($m) => $reimbursements->get($m + 1, 0)),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => false,
                ],
                [
                    'label' => 'Net Cost (€)',
                    'data' => $months->keys()->map(fn ($m) =>
                        $totalCosts->get($m + 1, 0) - $reimbursements->get($m + 1, 0)
                    ),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => 'start',
                    'borderDash' => [5, 5],
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => RawJs::make('(value) => "€ " + value.toFixed(2)'),
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => RawJs::make('(context) => {
                            return context.dataset.label + ": € " + context.parsed.y.toFixed(2);
                        }'),
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 4. User Demographics Pie Chart

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Ptv\Models\PtvUser;

class UserDemographicsChart extends ChartWidget
{
    protected static ?string $heading = 'User Demographics';

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $demographics = PtvUser::query()
            ->selectRaw('age_group, COUNT(*) as count')
            ->groupBy('age_group')
            ->pluck('count', 'age_group');

        return [
            'datasets' => [
                [
                    'data' => $demographics->values(),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)',
                    ],
                ],
            ],
            'labels' => $demographics->keys()->map(fn ($key) => match($key) {
                '18-25' => '18-25 years',
                '26-35' => '26-35 years',
                '36-50' => '36-50 years',
                '51-65' => '51-65 years',
                '65+' => '65+ years',
                default => ucfirst($key),
            }),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => RawJs::make('(context) => {
                            const label = context.label || "";
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ": " + value + " (" + percentage + "%)";
                        }'),
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

---

## 🎯 Advanced Features

### Geographic Distribution (with chartjs-chart-geo)

```bash
npm install chartjs-chart-geo
```

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Ptv\Models\PtvUsage;

class GeographicDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Geographic Distribution';

    protected function getType(): string
    {
        return 'choropleth';
    }

    protected function getData(): array
    {
        $distribution = PtvUsage::query()
            ->selectRaw('municipality, COUNT(*) as count')
            ->groupBy('municipality')
            ->pluck('count', 'municipality');

        return [
            'datasets' => [
                [
                    'label' => 'Usage by Municipality',
                    'data' => $distribution->map(fn ($count, $municipality) => [
                        'feature' => $municipality,
                        'value' => $count,
                    ])->values(),
                    'backgroundColor' => RawJs::make('(context) => {
                        const value = context.dataIndex && context.dataset.data[context.dataIndex].value;
                        const max = Math.max(...context.dataset.data.map(d => d.value));
                        const intensity = value / max;
                        return `rgba(59, 130, 246, ${intensity})`;
                    }'),
                ],
            ],
        ];
    }
}
```

### Real-time Usage (with chartjs-plugin-streaming)

```bash
npm install chartjs-plugin-streaming
```

```php
<?php

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class RealTimeUsageChart extends ChartWidget
{
    protected static ?string $heading = 'Real-time Usage';
    protected static ?string $pollingInterval = '5s';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $currentUsage = PtvUsage::query()
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Active Users',
                    'data' => [
                        [
                            'x' => now()->timestamp * 1000,
                            'y' => $currentUsage,
                        ],
                    ],
                    'borderColor' => 'rgb(34, 197, 94)',
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
                        'duration' => 60000, // 1 minute
                        'refresh' => 5000,   // 5 seconds
                        'delay' => 2000,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
```

---

## 📚 Risorse

- [Chart.js Geo](https://github.com/sgratzl/chartjs-chart-geo)
- [Chart.js Streaming](https://nagix.github.io/chartjs-plugin-streaming/)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
