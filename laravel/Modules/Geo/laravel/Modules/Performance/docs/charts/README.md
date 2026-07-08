# 📊 Performance Charts - Metriche e KPI

**Modulo**: Performance
**Data**: 2025-12-09
**Versione Filament**: 4.x
**Status**: ✅ Production Ready

---

## 📋 Overview

Documentazione per implementare **chart widgets** nel modulo Performance con metriche, KPI e report avanzati.

### Use Cases

- 📈 **Performance Trends** - Andamento performance nel tempo
- 🎯 **KPI Dashboard** - Indicatori chiave di performance
- 👥 **Team Comparison** - Confronto performance tra team
- 📊 **Obiettivi vs Risultati** - Tracciamento obiettivi

---

## 📊 Chart Widgets

### 1. Performance Timeline Chart

```php
<?php

namespace Modules\Performance\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\Performance\Models\Performance;

class PerformanceTimelineChart extends ChartWidget
{
    protected static ?string $heading = 'Performance Timeline';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Performance::class)
            ->between(
                start: now()->subMonths(12),
                end: now(),
            )
            ->perMonth()
            ->average('score');

        return [
            'datasets' => [
                [
                    'label' => 'Average Score',
                    'data' => $data->map(fn ($value) => $value->aggregate),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true],
                'tooltip' => [
                    'callbacks' => [
                        'label' => RawJs::make('(context) => {
                            return context.dataset.label + ": " + context.parsed.y.toFixed(2);
                        }'),
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'callback' => RawJs::make('(value) => value + "%"'),
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Performance\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Performance\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 2. Team Comparison Bar Chart

```php
<?php

namespace Modules\Performance\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Performance\Models\Performance;
use Illuminate\Support\Facades\DB;

class TeamComparisonChart extends ChartWidget
{
    protected static ?string $heading = 'Team Performance Comparison';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $teamData = Performance::query()
            ->select('team_id', DB::raw('AVG(score) as avg_score'))
            ->whereYear('created_at', now()->year)
            ->groupBy('team_id')
            ->with('team')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Average Score',
                    'data' => $teamData->pluck('avg_score'),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                ],
            ],
            'labels' => $teamData->pluck('team.name'),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // Horizontal bar chart
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'max' => 100,
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Performance\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Performance\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 3. KPI Radar Chart

```php
<?php

namespace Modules\Performance\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Performance\Models\Performance;

class KpiRadarChart extends ChartWidget
{
    protected static ?string $heading = 'KPI Radar';
    protected static ?int $sort = 3;

    public ?string $userId = null;

    protected function getType(): string
    {
        return 'radar';
    }

    protected function getData(): array
    {
        $userId = $this->userId ?? auth()->id();

        $kpis = Performance::query()
            ->where('user_id', $userId)
            ->latest()
            ->first();

        return [
            'datasets' => [
                [
                    'label' => 'Current Score',
                    'data' => [
                        $kpis?->quality ?? 0,
                        $kpis?->efficiency ?? 0,
                        $kpis?->collaboration ?? 0,
                        $kpis?->innovation ?? 0,
                        $kpis?->leadership ?? 0,
                    ],
                    'borderColor' => 'rgb(54, 162, 235)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                ],
                [
                    'label' => 'Target',
                    'data' => [80, 80, 80, 80, 80],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.1)',
                    'borderDash' => [5, 5],
                ],
            ],
            'labels' => ['Quality', 'Efficiency', 'Collaboration', 'Innovation', 'Leadership'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'r' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'stepSize' => 20,
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Performance\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Performance\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

---

## 💾 Export Actions

### ExportChartPngAction

```php
<?php

namespace Modules\Performance\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Xot\Actions\ExportChartPngQueueableAction;

class ExportChartPngAction
{
    public static function make(?string $name = 'exportPng'): Action
    {
        return Action::make($name)
            ->label('Export PNG')
            ->icon('heroicon-o-photo')
            ->color('success')
            ->action(function ($livewire) {
                $chartData = $livewire->getCachedData();
                $chartType = $livewire->getType();
                $options = $livewire->getOptions();

                $path = app(ExportChartPngQueueableAction::class)
                    ->onQueue()
                    ->execute($chartData, $chartType, $options, 'performance_chart.png');

                Notification::make()
                    ->title('PNG Export Completed')
                    ->success()
                    ->send();

                return response()->download($path);
            });
    }
}
```

### ExportChartSvgAction

```php
<?php

namespace Modules\Performance\Filament\Actions;

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
            ->action(function ($livewire) {
                $chartData = $livewire->getCachedData();
                $chartType = $livewire->getType();
                $options = $livewire->getOptions();

                $path = app(ExportChartSvgQueueableAction::class)
                    ->onQueue()
                    ->execute($chartData, $chartType, $options, 'performance_chart.svg');

                Notification::make()
                    ->title('SVG Export Completed')
                    ->success()
                    ->send();

                return response()->download($path);
            });
    }
}
```

---

## 🎯 Advanced Features

### 1. Multi-Period Comparison

```php
class MultiPeriodComparisonChart extends ChartWidget
{
    protected static ?string $heading = 'Year-over-Year Comparison';

    protected function getData(): array
    {
        $currentYear = Performance::query()
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, AVG(score) as avg_score')
            ->groupBy('month')
            ->pluck('avg_score', 'month');

        $previousYear = Performance::query()
            ->whereYear('created_at', now()->subYear()->year)
            ->selectRaw('MONTH(created_at) as month, AVG(score) as avg_score')
            ->groupBy('month')
            ->pluck('avg_score', 'month');

        return [
            'datasets' => [
                [
                    'label' => now()->year,
                    'data' => $currentYear->values(),
                    'borderColor' => 'rgb(54, 162, 235)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.1)',
                ],
                [
                    'label' => now()->subYear()->year,
                    'data' => $previousYear->values(),
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.1)',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
```

### 2. Goal Progress Chart

```php
class GoalProgressChart extends ChartWidget
{
    protected static ?string $heading = 'Goals Progress';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $goals = Performance::query()
            ->select('goal_name', 'current_value', 'target_value')
            ->where('user_id', auth()->id())
            ->get();

        $progress = $goals->map(fn ($goal) =>
            ($goal->current_value / $goal->target_value) * 100
        );

        return [
            'datasets' => [
                [
                    'label' => 'Progress %',
                    'data' => $progress,
                    'backgroundColor' => $progress->map(fn ($value) =>
                        $value >= 100 ? 'rgba(34, 197, 94, 0.8)' :
                        ($value >= 75 ? 'rgba(59, 130, 246, 0.8)' :
                        ($value >= 50 ? 'rgba(251, 146, 60, 0.8)' : 'rgba(239, 68, 68, 0.8)'))
                    ),
                ],
            ],
            'labels' => $goals->pluck('goal_name'),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'annotation' => [
                    'annotations' => [
                        'line1' => [
                            'type' => 'line',
                            'yMin' => 100,
                            'yMax' => 100,
                            'borderColor' => 'rgb(34, 197, 94)',
                            'borderWidth' => 2,
                            'borderDash' => [5, 5],
                            'label' => [
                                'content' => 'Target: 100%',
                                'enabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
```

---

## 📚 Best Practices

### 1. Caching per Performance

```php
protected function getData(): array
{
    return Cache::remember(
        'performance-chart-' . auth()->id() . '-' . $this->filter,
        now()->addMinutes(10),
        fn () => $this->calculateData()
    );
}
```

### 2. Lazy Loading

```php
protected static bool $isLazy = true;
protected static ?string $loadingIndicator = 'Loading chart...';
```

### 3. Real-time Updates

```php
protected static ?string $pollingInterval = '30s';
```

---

## 📊 Chart.js Plugin: Annotation

### Installation

```bash
npm install chartjs-plugin-annotation
```

### Usage

```javascript
// resources/js/app.js
import annotationPlugin from 'chartjs-plugin-annotation';
import { Chart } from 'chart.js';

Chart.register(annotationPlugin);
```

### Example: Target Line

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'annotation' => [
                'annotations' => [
                    'targetLine' => [
                        'type' => 'line',
                        'yMin' => 80,
                        'yMax' => 80,
                        'borderColor' => 'rgb(255, 99, 132)',
                        'borderWidth' => 2,
                        'borderDash' => [10, 5],
                        'label' => [
                            'display' => true,
                            'content' => 'Target: 80%',
                            'position' => 'end',
                        ],
                    ],
                    'excellenceZone' => [
                        'type' => 'box',
                        'yMin' => 90,
                        'yMax' => 100,
                        'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                        'borderColor' => 'rgb(34, 197, 94)',
                        'borderWidth' => 1,
                        'label' => [
                            'display' => true,
                            'content' => 'Excellence',
                        ],
                    ],
                ],
            ],
        ],
    ];
}
```

---

## 🔗 Risorse

- [Chart.js Documentation](https://www.chartjs.org/)
- [Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)
- [Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
