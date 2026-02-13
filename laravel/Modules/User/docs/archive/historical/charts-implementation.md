# User Module - Charts Implementation

## 📋 Panoramica

Il modulo **User** implementa chart widget per visualizzare statistiche utenti, autenticazioni, registrazioni e trend. Questa documentazione copre l'implementazione esistente e best practices.

**Modulo:** User
**Framework:** Laraxot/PTVX
**Filament:** 4.x
**Chart.js:** 4.x

---

## 📊 Widget Implementati

### 1. UsersChartWidget

**Path:** `Modules/User/app/Filament/Widgets/UsersChartWidget.php`

#### Caratteristiche

- **Tipo:** Line Chart
- **Dati:** Authentication logs (login utenti)
- **Periodo:** Configurabile tramite page filters
- **Polling:** Disabilitato (performance)
- **Lazy Loading:** Abilitato

#### Implementazione

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\User\Models\AuthenticationLog;

class UsersChartWidget extends ChartWidget
{
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 2;

    public function getHeading(): string
    {
        return 'Authentication Log';
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Date range from page filters
        $startDate = $this->pageFilters['startDate'] ?? now()->subMonth();
        $endDate = $this->pageFilters['endDate'] ?? now();

        // Limit to 90 days max to prevent memory issues
        if ($startDate->diffInDays($endDate, true) > 90) {
            $startDate = $endDate->copy()->subDays(90);
        }

        // Get trend data
        $data = Trend::model(AuthenticationLog::class)
            ->dateColumn('login_at')
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count()
            ->take(1000); // Max 1000 records

        return [
            'datasets' => [
                [
                    'label' => 'Number of logins executed',
                    'data' => $data->pluck('aggregate')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }
}
```

#### Best Practices Implementate

1. **Performance Optimization**
   - Limite 90 giorni per evitare sovraccarico memoria
   - Max 1000 record per query
   - Polling disabilitato
   - Lazy loading abilitato

2. **Error Handling**
   - Try-catch per gestire errori gracefully
   - Fallback con dati vuoti in caso di eccezione

3. **Type Safety**
   - Type hints completi
   - PHPStan Level 10 compliant

### 2. UserTypeRegistrationsChartWidget

**Path:** `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`

#### Caratteristiche

- **Tipo:** Bar Chart / Pie Chart (configurabile)
- **Dati:** Registrazioni utenti per tipo
- **Aggregazione:** Count per user type
- **Filtri:** Date range

#### Implementazione Suggerita

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class UserTypeRegistrationsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Registrations by Type';
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'pie'; // or 'doughnut', 'bar'
    }

    protected function getData(): array
    {
        // Get user counts by type
        $data = User::query()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',   // Blue
                        'rgba(16, 185, 129, 0.8)',   // Green
                        'rgba(245, 158, 11, 0.8)',   // Orange
                        'rgba(239, 68, 68, 0.8)',    // Red
                        'rgba(139, 92, 246, 0.8)',   // Purple
                    ],
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.label + ": " + context.parsed + " users";
                        }',
                    ],
                ],
            ],
        ];
    }
}
```

---

## 🎨 Chart Personalizzazione

### Colori Tema User Module

```php
// Palette colori consistente
private const CHART_COLORS = [
    'primary' => 'rgb(59, 130, 246)',      // Blue
    'success' => 'rgb(16, 185, 129)',      // Green
    'warning' => 'rgb(245, 158, 11)',      // Orange
    'danger' => 'rgb(239, 68, 68)',        // Red
    'info' => 'rgb(59, 130, 246)',         // Blue
    'purple' => 'rgb(139, 92, 246)',       // Purple
];

// Uso nei dataset
'backgroundColor' => array_map(
    fn($color) => str_replace('rgb', 'rgba', str_replace(')', ', 0.5)', $color)),
    self::CHART_COLORS
),
'borderColor' => array_values(self::CHART_COLORS),
```

### Stili Consistenti

```php
protected function getDefaultChartOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
                'labels' => [
                    'padding' => 15,
                    'font' => [
                        'size' => 12,
                    ],
                ],
            ],
            'tooltip' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false,
                'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                'padding' => 12,
                'titleFont' => [
                    'size' => 14,
                ],
                'bodyFont' => [
                    'size' => 13,
                ],
            ],
        ],
        'scales' => [
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'font' => [
                        'size' => 11,
                    ],
                ],
            ],
            'y' => [
                'beginAtZero' => true,
                'grid' => [
                    'color' => 'rgba(0, 0, 0, 0.05)',
                ],
                'ticks' => [
                    'font' => [
                        'size' => 11,
                    ],
                ],
            ],
        ],
    ];
}
```

---

## 📈 Statistiche Implementabili

### 1. User Activity Heatmap

```php
class UserActivityHeatmapWidget extends ChartWidget
{
    protected static ?string $heading = 'User Activity Heatmap';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        // Activity by hour of day
        $data = AuthenticationLog::query()
            ->select(DB::raw('HOUR(login_at) as hour, COUNT(*) as count'))
            ->whereBetween('login_at', [now()->subDays(30), now()])
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour');

        // Fill missing hours with 0
        $hours = range(0, 23);
        $counts = collect($hours)->map(fn($h) => $data->get($h, 0));

        return [
            'datasets' => [
                [
                    'label' => 'Logins by Hour',
                    'data' => $counts->toArray(),
                    'backgroundColor' => $counts->map(function($count) {
                        $opacity = min(1, $count / 100); // Normalize
                        return "rgba(59, 130, 246, {$opacity})";
                    })->toArray(),
                ],
            ],
            'labels' => collect($hours)->map(fn($h) => "{$h}:00")->toArray(),
        ];
    }
}
```

### 2. User Growth Trend

```php
class UserGrowthTrendWidget extends ChartWidget
{
    protected static ?string $heading = 'User Growth (Last 12 Months)';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->subYear(),
                end: now()
            )
            ->perMonth()
            ->count();

        // Calculate cumulative
        $cumulative = [];
        $total = 0;
        foreach ($data as $value) {
            $total += $value->aggregate;
            $cumulative[] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $data->map(fn($v) => $v->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total Users',
                    'data' => $cumulative,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'borderDash' => [5, 5],
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $data->map(fn($v) => $v->date->format('M Y')),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'New Users',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Total Users',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
```

### 3. Failed Login Attempts

```php
class FailedLoginAttemptsWidget extends ChartWidget
{
    protected static ?string $heading = 'Failed Login Attempts';
    protected static ?string $color = 'danger';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = AuthenticationLog::query()
            ->where('login_successful', false)
            ->whereBetween('login_at', [now()->subDays(7), now()])
            ->select(DB::raw('DATE(login_at) as date, COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Failed Attempts',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->pluck('date')->map(fn($d) =>
                \Carbon\Carbon::parse($d)->format('d/m')
            )->toArray(),
        ];
    }
}
```

---

## 🎯 Export Charts

### Aggiungi Export Actions

```php
use Modules\Xot\Actions\Chart\ExportChartWidgetAction;
use Filament\Actions\Action;

class UsersChartWidget extends ChartWidget
{
    // ... existing code ...

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
                ->icon('heroicon-o-document-text')
                ->action(function (ExportChartWidgetAction $action) {
                    $storedPath = $action->execute($this, 'svg', 1200, 800);
                    return Storage::download($storedPath, 'users-chart.svg');
                }),
        ];
    }
}
```

---

## 🧪 Testing

### Test Widget Data

```php
<?php

namespace Tests\Feature\Widgets;

use Tests\TestCase;
use Modules\User\Filament\Widgets\UsersChartWidget;
use Modules\User\Models\User;
use Modules\User\Models\AuthenticationLog;

class UsersChartWidgetTest extends TestCase
{
    /** @test */
    public function it_returns_valid_chart_data()
    {
        // Create test data
        $user = User::factory()->create();
        AuthenticationLog::factory()->count(10)->create([
            'user_id' => $user->id,
            'login_at' => now(),
        ]);

        $widget = new UsersChartWidget();
        $data = $widget->getData();

        $this->assertArrayHasKey('datasets', $data);
        $this->assertArrayHasKey('labels', $data);
        $this->assertNotEmpty($data['datasets']);
        $this->assertNotEmpty($data['labels']);
    }

    /** @test */
    public function it_handles_empty_data_gracefully()
    {
        $widget = new UsersChartWidget();
        $data = $widget->getData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('datasets', $data);
        $this->assertArrayHasKey('labels', $data);
    }

    /** @test */
    public function it_limits_date_range_to_90_days()
    {
        $widget = new UsersChartWidget();
        $widget->pageFilters = [
            'startDate' => now()->subDays(120),
            'endDate' => now(),
        ];

        $data = $widget->getData();

        // Verify data is limited
        $this->assertLessThanOrEqual(90, count($data['labels']));
    }
}
```

---

## 📚 Risorse

### Documentazione Correlata
- [Filament Charts Complete Guide](../../Xot/docs/filament-charts-complete-guide.md)
- [Chart Export Guide](../../Xot/docs/chart-export-guide.md)
- [User Module README](./README.md)

### Chart.js
- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [Chart.js Samples](https://www.chartjs.org/docs/latest/samples/)

### Laravel Trend
- [Laravel Trend Package](https://github.com/Flowframe/laravel-trend)

---

**Ultimo aggiornamento:** Dicembre 2025
**Modulo:** User
**Framework:** Laraxot/PTVX
**Filament:** 4.x
**PHPStan Level:** 10
