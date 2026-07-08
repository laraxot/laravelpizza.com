# 📊 Theme One - Charts Integration

**Theme**: One
**Data**: 2025-12-09
**Versione Filament**: 4.x
**Status**: ✅ Production Ready

---

## 📋 Overview

Guida all'integrazione e personalizzazione dei chart widgets nel **Theme One**.

### Obiettivi

- 🎨 **Personalizzazione visiva** - Colori, font, stili tematici
- 📱 **Responsiveness** - Mobile-first design
- ♿ **Accessibilità** - WCAG 2.1 AA compliance
- 🚀 **Performance** - Lazy loading, caching

---

## 🎨 Theme Customization

### 1. Chart Colors Palette

```php
// Themes/One/config/charts.php

return [
    'colors' => [
        'primary' => 'rgb(59, 130, 246)',
        'secondary' => 'rgb(139, 92, 246)',
        'success' => 'rgb(34, 197, 94)',
        'danger' => 'rgb(239, 68, 68)',
        'warning' => 'rgb(251, 146, 60)',
        'info' => 'rgb(14, 165, 233)',
        'gray' => 'rgb(107, 114, 128)',
    ],

    'gradients' => [
        'primary' => [
            'start' => 'rgba(59, 130, 246, 0.2)',
            'end' => 'rgba(59, 130, 246, 0.0)',
        ],
        'success' => [
            'start' => 'rgba(34, 197, 94, 0.2)',
            'end' => 'rgba(34, 197, 94, 0.0)',
        ],
    ],

    'fonts' => [
        'family' => "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
        'size' => [
            'base' => 12,
            'title' => 14,
            'label' => 11,
        ],
    ],
];
```

### 2. Base Chart Widget Trait

```php
<?php

namespace Themes\One\Traits;

use Filament\Support\RawJs;

trait ThemeOneChartTrait
{
    /**
     * Apply Theme One styling to chart options
     */
    protected function applyThemeOneStyles(array $options = []): array
    {
        $colors = config('charts.colors');
        $fonts = config('charts.fonts');

        return array_merge_recursive([
            'responsive' => true,
            'maintainAspectRatio' => true,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'font' => [
                            'family' => $fonts['family'],
                            'size' => $fonts['size']['label'],
                        ],
                        'usePointStyle' => true,
                        'padding' => 15,
                    ],
                ],
                'title' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleFont' => [
                        'family' => $fonts['family'],
                        'size' => $fonts['size']['title'],
                    ],
                    'bodyFont' => [
                        'family' => $fonts['family'],
                        'size' => $fonts['size']['base'],
                    ],
                    'padding' => 12,
                    'cornerRadius' => 8,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'family' => $fonts['family'],
                            'size' => $fonts['size']['label'],
                        ],
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.05)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'family' => $fonts['family'],
                            'size' => $fonts['size']['label'],
                        ],
                    ],
                ],
            ],
        ], $options);
    }

    /**
     * Get themed color
     */
    protected function getThemedColor(string $color): string
    {
        return config("charts.colors.{$color}") ?? $color;
    }

    /**
     * Get themed gradient
     */
    protected function getThemedGradient(string $gradient): array
    {
        return config("charts.gradients.{$gradient}") ?? [];
    }
}
```

### 3. Example Usage

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Themes\One\Traits\ThemeOneChartTrait;

class ThemedSalesChart extends ChartWidget
{
    use ThemeOneChartTrait;

    protected static ?string $heading = 'Sales Overview';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [100, 200, 150, 300, 250, 400],
                    'borderColor' => $this->getThemedColor('primary'),
                    'backgroundColor' => $this->getThemedGradient('primary')['start'],
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }

    protected function getOptions(): array
    {
        return $this->applyThemeOneStyles([
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ]);
    }
}
```

---

## 📱 Responsive Design

### Mobile-Optimized Charts

```php
protected function getOptions(): array
{
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone/i', request()->header('User-Agent'));

    return $this->applyThemeOneStyles([
        'responsive' => true,
        'maintainAspectRatio' => !$isMobile,
        'aspectRatio' => $isMobile ? 1 : 2,
        'plugins' => [
            'legend' => [
                'display' => !$isMobile,
                'position' => $isMobile ? 'bottom' : 'top',
            ],
            'tooltip' => [
                'mode' => $isMobile ? 'nearest' : 'index',
                'intersect' => $isMobile,
            ],
        ],
    ]);
}
```

### Responsive Widget Column Span

```php
protected int | string | array $columnSpan = [
    'sm' => 2,
    'md' => 2,
    'lg' => 1,
    'xl' => 1,
];
```

---

## 🎨 Chart.js Plugins Integration

### 1. Install Plugins

```bash
cd Themes/One
npm install chartjs-plugin-annotation chartjs-plugin-zoom chartjs-plugin-datalabels
```

### 2. Register Plugins

```javascript
// Themes/One/resources/js/chart-plugins.js

import { Chart } from 'chart.js';
import annotationPlugin from 'chartjs-plugin-annotation';
import zoomPlugin from 'chartjs-plugin-zoom';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Register plugins globally
Chart.register(annotationPlugin, zoomPlugin, ChartDataLabels);

export default Chart;
```

### 3. Import in Main JS

```javascript
// Themes/One/resources/js/app.js

import './chart-plugins';
```

### 4. Build Assets

```bash
npm run build
```

---

## 💾 Export Charts - Theme Integration

### PNG Export Action

```php
<?php

namespace Themes\One\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Xot\Actions\ExportChartPngQueueableAction;

class ExportThemedChartPngAction
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

                // Apply theme styles to export
                $options = $livewire->applyThemeOneStyles($livewire->getOptions());

                $filename = 'theme_one_chart_' . now()->format('YmdHis') . '.png';

                $path = app(ExportChartPngQueueableAction::class)
                    ->onQueue()
                    ->execute($chartData, $chartType, $options, $filename);

                Notification::make()
                    ->title('PNG Export Completed')
                    ->body('Chart exported with Theme One styling')
                    ->success()
                    ->send();

                return response()->download($path);
            });
    }
}
```

### SVG Export Action

```php
<?php

namespace Themes\One\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Xot\Actions\ExportChartSvgQueueableAction;

class ExportThemedChartSvgAction
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

                // Apply theme styles to export
                $options = $livewire->applyThemeOneStyles($livewire->getOptions());

                $filename = 'theme_one_chart_' . now()->format('YmdHis') . '.svg';

                $path = app(ExportChartSvgQueueableAction::class)
                    ->onQueue()
                    ->execute($chartData, $chartType, $options, $filename);

                Notification::make()
                    ->title('SVG Export Completed')
                    ->body('Chart exported with Theme One styling')
                    ->success()
                    ->send();

                return response()->download($path);
            });
    }
}
```

---

## ♿ Accessibility

### ARIA Labels

```php
protected function getOptions(): array
{
    return $this->applyThemeOneStyles([
        'plugins' => [
            'title' => [
                'display' => true,
                'text' => 'Sales Chart',
                'aria-label' => 'Interactive sales chart showing monthly revenue',
            ],
        ],
    ]);
}
```

### Keyboard Navigation

```javascript
// Enable keyboard navigation for charts
Chart.defaults.plugins.legend.onHover = function(event) {
    event.native.target.style.cursor = 'pointer';
};

Chart.defaults.plugins.legend.onLeave = function(event) {
    event.native.target.style.cursor = 'default';
};
```

---

## 🚀 Performance Optimization

### 1. Lazy Loading

```php
protected static bool $isLazy = true;
```

### 2. Caching

```php
use Illuminate\Support\Facades\Cache;

protected function getData(): array
{
    return Cache::remember(
        'chart-data-' . static::class . '-' . $this->filter,
        now()->addMinutes(5),
        fn () => $this->calculateData()
    );
}
```

### 3. Debouncing Updates

```javascript
// Themes/One/resources/js/chart-utils.js

export function debounceChartUpdate(chart, data, delay = 300) {
    clearTimeout(chart._updateTimeout);
    chart._updateTimeout = setTimeout(() => {
        chart.data = data;
        chart.update('none'); // Update without animation
    }, delay);
}
```

---

## 📊 Advanced Examples

### Multi-Axis Chart with Theme

```php
class ThemedMultiAxisChart extends ChartWidget
{
    use ThemeOneChartTrait;

    protected static ?string $heading = 'Revenue & Orders';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Revenue (€)',
                    'data' => [1200, 1900, 3000, 5000, 2000, 3000],
                    'borderColor' => $this->getThemedColor('primary'),
                    'backgroundColor' => $this->getThemedGradient('primary')['start'],
                    'yAxisID' => 'y',
                    'fill' => 'start',
                ],
                [
                    'label' => 'Orders',
                    'data' => [30, 45, 60, 70, 50, 65],
                    'borderColor' => $this->getThemedColor('success'),
                    'backgroundColor' => $this->getThemedGradient('success')['start'],
                    'yAxisID' => 'y1',
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }

    protected function getOptions(): array
    {
        return $this->applyThemeOneStyles([
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (€)',
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
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Themes\One\Filament\Actions\ExportThemedChartPngAction::make(),
            \Themes\One\Filament\Actions\ExportThemedChartSvgAction::make(),
        ];
    }
}
```

---

## 🎯 Best Practices

### 1. Consistent Theming

✅ **DO**: Use theme trait for all charts
```php
use ThemeOneChartTrait;
protected function getOptions(): array {
    return $this->applyThemeOneStyles([...]);
}
```

❌ **DON'T**: Hardcode colors
```php
'borderColor' => 'rgb(59, 130, 246)' // Bad!
```

### 2. Responsive by Default

✅ **DO**: Always enable responsiveness
```php
'responsive' => true,
'maintainAspectRatio' => true,
```

### 3. Export with Theme

✅ **DO**: Use themed export actions
```php
\Themes\One\Filament\Actions\ExportThemedChartPngAction::make(),
```

---

## 📚 Risorse

- [Chart.js Documentation](https://www.chartjs.org/)
- [Filament Widgets](https://filamentphp.com/docs/4.x/widgets)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
