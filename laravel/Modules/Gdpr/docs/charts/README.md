# 📊 GDPR Charts - Privacy & Compliance Reporting

**Modulo**: GDPR
**Status**: ✅ Production Ready

---

## 📋 Overview

Chart widgets per monitoraggio conformità GDPR, richieste privacy e metriche compliance.

### Use Cases

- 📊 **Data Subject Requests** - Richieste soggetti interessati nel tempo
- 🔒 **Privacy Compliance** - Indicatori di conformità
- ⏱️ **Response Times** - Tempi di risposta alle richieste
- 📈 **Breach Reports** - Report violazioni dati

---

## 📊 Example Widgets

### 1. GDPR Requests Timeline

```php
<?php

namespace Modules\Gdpr\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\Gdpr\Models\GdprRequest;

class GdprRequestsTimelineChart extends ChartWidget
{
    protected static ?string $heading = 'GDPR Requests Timeline';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(GdprRequest::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'GDPR Requests',
                    'data' => $data->map(fn ($value) => $value->aggregate),
                    'borderColor' => 'rgb(239, 68, 68)',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Gdpr\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Gdpr\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 2. Request Types Distribution

```php
<?php

namespace Modules\Gdpr\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Gdpr\Models\GdprRequest;

class RequestTypesChart extends ChartWidget
{
    protected static ?string $heading = 'Request Types Distribution';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $types = GdprRequest::query()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return [
            'datasets' => [
                [
                    'data' => $types->values(),
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(239, 68, 68)',
                        'rgb(168, 85, 247)',
                    ],
                ],
            ],
            'labels' => $types->keys()->map(fn ($key) => match($key) {
                'access' => 'Data Access',
                'rectification' => 'Rectification',
                'erasure' => 'Right to be Forgotten',
                'portability' => 'Data Portability',
                'objection' => 'Objection',
                default => ucfirst($key),
            }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Gdpr\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Gdpr\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 3. Response Time Analysis

```php
<?php

namespace Modules\Gdpr\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Gdpr\Models\GdprRequest;
use Illuminate\Support\Facades\DB;

class ResponseTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Average Response Time (Days)';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $avgResponseTime = GdprRequest::query()
            ->selectRaw('
                MONTH(created_at) as month,
                AVG(DATEDIFF(completed_at, created_at)) as avg_days
            ')
            ->whereNotNull('completed_at')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('avg_days', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Avg Response Days',
                    'data' => $avgResponseTime->values(),
                    'backgroundColor' => $avgResponseTime->map(fn ($days) =>
                        $days <= 30 ? 'rgba(34, 197, 94, 0.8)' : 'rgba(239, 68, 68, 0.8)'
                    ),
                ],
            ],
            'labels' => $avgResponseTime->keys()->map(fn ($m) =>
                now()->month($m)->format('M')
            ),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'annotation' => [
                    'annotations' => [
                        'complianceLine' => [
                            'type' => 'line',
                            'yMin' => 30,
                            'yMax' => 30,
                            'borderColor' => 'rgb(239, 68, 68)',
                            'borderWidth' => 2,
                            'borderDash' => [5, 5],
                            'label' => [
                                'content' => 'GDPR Limit: 30 days',
                                'enabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Gdpr\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Gdpr\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

---

## 💾 Export Actions (Shared)

Le azioni di export PNG/SVG sono condivise tramite il modulo Xot:

```php
<?php

namespace Modules\Gdpr\Filament\Actions;

use Modules\Xot\Filament\Actions\ExportChartPngAction as BaseExportPngAction;
use Modules\Xot\Filament\Actions\ExportChartSvgAction as BaseExportSvgAction;

class ExportChartPngAction extends BaseExportPngAction {}
class ExportChartSvgAction extends BaseExportSvgAction {}
```

---

## 🎯 GDPR-Specific Features

### Compliance Heatmap

```php
use Modules\Xot\Filament\Widgets\HeatmapChartWidget;

class ComplianceHeatmapChart extends HeatmapChartWidget
{
    protected static ?string $heading = 'Compliance Heatmap';

    protected function getData(): array
    {
        // Matrix data: compliance scores by department and month
        $matrix = [];

        foreach (['IT', 'HR', 'Sales', 'Finance'] as $dept) {
            $row = [];
            for ($month = 1; $month <= 12; $month++) {
                $row[] = rand(60, 100); // Replace with actual compliance score
            }
            $matrix[] = $row;
        }

        return [
            'datasets' => [
                [
                    'data' => $matrix,
                    'backgroundColor' => fn ($context) => {
                        $value = $context->dataset->data[$context->dataIndex];
                        return $value >= 90 ? 'rgba(34, 197, 94, 0.8)' :
                               ($value >= 70 ? 'rgba(251, 146, 60, 0.8)' : 'rgba(239, 68, 68, 0.8)');
                    },
                ],
            ],
            'labels' => [
                'x' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'y' => ['IT', 'HR', 'Sales', 'Finance'],
            ],
        ];
    }
}
```

---

## 📚 Risorse

- [GDPR Official Text](https://gdpr-info.eu/)
- [Chart.js Heatmap](https://github.com/kurkle/chartjs-chart-matrix)
- [Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)

---

**Autore**: PTVX Development Team
