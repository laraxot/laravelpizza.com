# 📊 Charts Tutorial - Step by Step Guide

**Data**: 2025-12-09
**Difficoltà**: ⭐⭐ Intermedio
**Tempo stimato**: 30 minuti

---

## 🎯 Obiettivo

Creare un **chart widget Filament** completo di:
- 📊 Visualizzazione dati
- 🎨 Personalizzazione
- 📱 Responsiveness
- 💾 Export PNG/SVG

---

## 📋 Prerequisiti

### Conoscenze Richieste
- ✅ Laravel 11 basics
- ✅ Filament 4 basics
- ✅ Eloquent models

### Software Installato
- ✅ PHP 8.2+
- ✅ Node.js 18+
- ✅ Composer
- ✅ NPM

---

## 🚀 Step 1: Setup Dependencies

### 1.1 Installa Pacchetti Backend

```bash
# Browsershot per export PNG/SVG
composer require spatie/browsershot

# Spatie QueueableActions
composer require spatie/laravel-queueable-action

# Laravel Trend per data aggregation
composer require flowframe/laravel-trend
```

### 1.2 Installa Pacchetti Frontend

```bash
# Puppeteer per rendering
npm install puppeteer

# Chart.js plugins (opzionali ma consigliati)
npm install chartjs-plugin-annotation
npm install chartjs-plugin-zoom
npm install chartjs-plugin-datalabels
```

### 1.3 Configura Puppeteer

```bash
# Linux/Ubuntu
sudo apt-get install chromium-browser

# Oppure usa Puppeteer chromium
npx puppeteer browsers install chrome
```

---

## 📊 Step 2: Create Your First Chart Widget

### 2.1 Generate Widget

```bash
php artisan make:filament-widget SalesChart --chart
```

Questo crea: `app/Filament/Widgets/SalesChart.php`

### 2.2 Basic Implementation

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    // Chart heading
    protected static ?string $heading = 'Monthly Sales';

    // Widget order in dashboard
    protected static ?int $sort = 2;

    // Column span (responsive)
    protected int | string | array $columnSpan = [
        'sm' => 2,  // Full width on small screens
        'md' => 2,  // Full width on medium
        'lg' => 1,  // Half width on large
        'xl' => 1,  // Half width on xl
    ];

    // Chart type
    protected function getType(): string
    {
        return 'line';
    }

    // Chart data
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales (€)',
                    'data' => [1200, 1900, 3000, 5000, 2300, 3200],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4, // Smooth curves
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }
}
```

### 2.3 Register Widget in Dashboard

```php
// app/Filament/Pages/Dashboard.php

public function getWidgets(): array
{
    return [
        SalesChart::class,
    ];
}
```

---

## 📈 Step 3: Connect to Real Data

### 3.1 Prepare Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['total', 'created_at'];

    protected $casts = [
        'total' => 'decimal:2',
    ];
}
```

### 3.2 Use Laravel Trend

```php
use Flowframe\Trend\Trend;
use App\Models\Order;

protected function getData(): array
{
    $data = Trend::model(Order::class)
        ->between(
            start: now()->subMonths(6),
            end: now(),
        )
        ->perMonth()
        ->sum('total');

    return [
        'datasets' => [
            [
                'label' => 'Sales (€)',
                'data' => $data->map(fn ($value) => $value->aggregate),
                'borderColor' => 'rgb(59, 130, 246)',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'fill' => 'start',
            ],
        ],
        'labels' => $data->map(fn ($value) => $value->date),
    ];
}
```

---

## 🎨 Step 4: Customize Chart

### 4.1 Add Options

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
            ],
            'title' => [
                'display' => false,
            ],
            'tooltip' => [
                'callbacks' => [
                    'label' => RawJs::make('(context) => {
                        return "€ " + context.parsed.y.toFixed(2);
                    }'),
                ],
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
        'responsive' => true,
        'maintainAspectRatio' => true,
    ];
}
```

### 4.2 Add Description

```php
protected function getDescription(): ?string
{
    return 'Total sales for the last 6 months';
}
```

### 4.3 Add Max Height

```php
protected static ?string $maxHeight = '300px';
```

---

## 🔄 Step 5: Add Filters

### 5.1 Simple Filters

```php
protected function getFilters(): ?array
{
    return [
        'week' => 'This Week',
        'month' => 'This Month',
        'quarter' => 'This Quarter',
        'year' => 'This Year',
    ];
}
```

### 5.2 Update getData with Filter

```php
protected function getData(): array
{
    $filter = $this->filter;

    $query = Order::query();

    match ($filter) {
        'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
        'month' => $query->whereMonth('created_at', now()->month),
        'quarter' => $query->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]),
        'year' => $query->whereYear('created_at', now()->year),
        default => $query->whereBetween('created_at', [now()->subMonths(6), now()]),
    };

    $data = Trend::query($query)
        ->between(
            start: $this->getStartDate($filter),
            end: now(),
        )
        ->perMonth()
        ->sum('total');

    return [
        'datasets' => [...],
        'labels' => [...],
    ];
}

private function getStartDate(string $filter): \Carbon\Carbon
{
    return match ($filter) {
        'week' => now()->startOfWeek(),
        'month' => now()->startOfMonth(),
        'quarter' => now()->startOfQuarter(),
        'year' => now()->startOfYear(),
        default => now()->subMonths(6),
    };
}
```

---

## 💾 Step 6: Add Export PNG/SVG

### 6.1 Add Export Methods to Widget

```php
use Modules\Xot\Filament\Actions\ExportChartPngAction;
use Modules\Xot\Filament\Actions\ExportChartSvgAction;

class SalesChart extends ChartWidget
{
    // ... existing code ...

    protected function getHeaderActions(): array
    {
        return [
            ExportChartPngAction::make(),
            ExportChartSvgAction::make(),
        ];
    }

    // Required for export
    public function getCachedData(): array
    {
        return $this->getData();
    }

    public function getOptions(): array
    {
        return [
            // ... your options ...
        ];
    }
}
```

### 6.2 Configure Queue (Optional but Recommended)

```php
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'queue' => 'charts',
    ],
],
```

```bash
# Start queue worker
php artisan queue:work --queue=charts
```

---

## 🚀 Step 7: Performance Optimization

### 7.1 Add Caching

```php
use Illuminate\Support\Facades\Cache;

protected function getData(): array
{
    return Cache::remember(
        'sales-chart-' . $this->filter . '-' . auth()->id(),
        now()->addMinutes(10),
        fn () => $this->calculateData()
    );
}

private function calculateData(): array
{
    // Your data calculation logic
    $data = Trend::model(Order::class)
        ->between(...)
        ->perMonth()
        ->sum('total');

    return [
        'datasets' => [...],
        'labels' => [...],
    ];
}
```

### 7.2 Enable Lazy Loading

```php
protected static bool $isLazy = true;
```

### 7.3 Add Polling (Optional)

```php
// Auto-refresh every 30 seconds
protected static ?string $pollingInterval = '30s';

// Or disable
protected static ?string $pollingInterval = null;
```

---

## 🎯 Step 8: Testing

### 8.1 Create Test

```php
// tests/Feature/SalesChartTest.php

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use App\Filament\Widgets\SalesChart;

it('renders sales chart correctly', function () {
    $user = User::factory()->create();

    actingAs($user);

    livewire(SalesChart::class)
        ->assertOk()
        ->assertSee('Monthly Sales');
});

it('filters chart data correctly', function () {
    $user = User::factory()->create();

    actingAs($user);

    livewire(SalesChart::class)
        ->call('filter', 'month')
        ->assertSet('filter', 'month');
});
```

### 8.2 Run Tests

```bash
php artisan test --filter=SalesChartTest
```

---

## ✅ Checklist Finale

Prima di andare in produzione, verifica:

- [ ] Chart si visualizza correttamente
- [ ] Dati sono accurati
- [ ] Filtri funzionano
- [ ] Export PNG funziona
- [ ] Export SVG funziona
- [ ] Responsive su mobile
- [ ] Performance OK (< 2s load time)
- [ ] Cache implementata
- [ ] Tests passano
- [ ] Documentazione aggiornata

---

## 🎨 Advanced Examples

### Multi-Dataset Chart

```php
protected function getData(): array
{
    $sales = Trend::model(Order::class)
        ->between(now()->subMonths(6), now())
        ->perMonth()
        ->sum('total');

    $orders = Trend::model(Order::class)
        ->between(now()->subMonths(6), now())
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Sales (€)',
                'data' => $sales->map(fn ($v) => $v->aggregate),
                'borderColor' => 'rgb(59, 130, 246)',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'yAxisID' => 'y',
            ],
            [
                'label' => 'Orders',
                'data' => $orders->map(fn ($v) => $v->aggregate),
                'borderColor' => 'rgb(34, 197, 94)',
                'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                'yAxisID' => 'y1',
            ],
        ],
        'labels' => $sales->map(fn ($v) => $v->date),
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
                    'text' => 'Sales (€)',
                ],
            ],
            'y1' => [
                'type' => 'linear',
                'display' => true,
                'position' => 'right',
                'title' => [
                    'display' => true,
                    'text' => 'Orders',
                ],
                'grid' => [
                    'drawOnChartArea' => false,
                ],
            ],
        ],
    ];
}
```

### With Annotation Plugin

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'annotation' => [
                'annotations' => [
                    'targetLine' => [
                        'type' => 'line',
                        'yMin' => 5000,
                        'yMax' => 5000,
                        'borderColor' => 'rgb(255, 99, 132)',
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'label' => [
                            'display' => true,
                            'content' => 'Target: €5,000',
                            'position' => 'end',
                        ],
                    ],
                ],
            ],
        ],
    ];
}
```

---

## 🐛 Common Issues & Solutions

### Issue: Chart not rendering

**Solution**:
```php
// Verify getData() returns correct format
return [
    'datasets' => [...], // Must be array
    'labels' => [...],   // Must be array
];
```

### Issue: Export fails

**Solution**:
```bash
# Check Puppeteer installation
npx puppeteer browsers list

# Check permissions
chmod 755 storage/app/public/charts

# Check queue is running
php artisan queue:work
```

### Issue: Slow performance

**Solution**:
```php
// Add caching
Cache::remember('chart-key', 600, fn () => $this->getData());

// Enable lazy loading
protected static bool $isLazy = true;

// Limit data points
->take(365)
```

---

## 📚 Next Steps

### Learn More
- [Chart.js Documentation](https://www.chartjs.org/)
- [Filament Widgets](https://filamentphp.com/docs/4.x/widgets)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)

### Explore Examples
- [Activity Module Charts](../../Modules/Activity/docs/charts/README.md)
- [Performance Module Charts](../../Modules/Performance/docs/charts/README.md)
- [GDPR Module Charts](../../Modules/Gdpr/docs/charts/README.md)

### Advanced Topics
- Real-time charts with streaming
- Geographic charts with chartjs-chart-geo
- Custom chart types
- Interactive dashboards

---

## 🎉 Congratulations!

Hai completato il tutorial! Ora sai come:
- ✅ Creare chart widgets in Filament
- ✅ Connettere charts a dati reali
- ✅ Personalizzare appearance e behavior
- ✅ Aggiungere filtri
- ✅ Implementare export PNG/SVG
- ✅ Ottimizzare performance

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
