# Theme One - Charts Integration

## 📋 Panoramica

Questa guida documenta l'integrazione e lo styling dei chart widgets nel **Theme One** di PTVX, garantendo coerenza visiva con il design system del tema.

**Tema:** One
**Framework:** Laraxot/PTVX
**Filament:** 4.x
**Chart.js:** 4.x

---

## 🎨 Design System

### Palette Colori Chart

Theme One utilizza una palette colori specifica per i chart, allineata con il tema generale.

```php
// config/theme-one.php
return [
    'charts' => [
        'colors' => [
            'primary' => '#2c3e50',      // Dark blue-gray
            'secondary' => '#34495e',    // Lighter blue-gray
            'accent' => '#3498db',       // Bright blue
            'success' => '#27ae60',      // Green
            'warning' => '#f39c12',      // Orange
            'danger' => '#e74c3c',       // Red
            'info' => '#3498db',         // Blue
            'light' => '#ecf0f1',        // Light gray
            'dark' => '#2c3e50',         // Dark blue-gray
            'purple' => '#9b59b6',       // Purple
            'pink' => '#e91e63',         // Pink
            'indigo' => '#3f51b5',       // Indigo
        ],
        'opacity' => [
            'fill' => 0.2,               // Background fill
            'hover' => 0.6,              // Hover state
            'solid' => 1.0,              // Solid colors
        ],
    ],
];
```

### Tipografia

```php
'charts' => [
    'fonts' => [
        'family' => "'Inter', 'Helvetica Neue', 'Arial', sans-serif",
        'sizes' => [
            'title' => 16,
            'legend' => 12,
            'label' => 11,
            'tooltip' => 13,
        ],
        'weights' => [
            'normal' => 400,
            'medium' => 500,
            'bold' => 700,
        ],
    ],
],
```

---

## 🔧 Configurazione Base

### Theme One Chart Widget Base

```php
<?php

// Themes/One/app/Filament/Widgets/ThemeOneChartWidget.php

namespace Themes\One\Filament\Widgets;

use Filament\Widgets\ChartWidget;

abstract class ThemeOneChartWidget extends ChartWidget
{
    protected static bool $isLazy = true;

    /**
     * Get Theme One chart colors
     *
     * @return array<string, string>
     */
    protected function getThemeColors(): array
    {
        return config('theme-one.charts.colors', []);
    }

    /**
     * Get default Theme One chart options
     *
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        $colors = $this->getThemeColors();
        $fonts = config('theme-one.charts.fonts', []);

        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'color' => $colors['dark'],
                        'font' => [
                            'family' => $fonts['family'] ?? 'Inter',
                            'size' => $fonts['sizes']['legend'] ?? 12,
                        ],
                        'padding' => 15,
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
                'title' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(44, 62, 80, 0.95)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderColor' => $colors['accent'],
                    'borderWidth' => 1,
                    'padding' => 12,
                    'displayColors' => true,
                    'titleFont' => [
                        'size' => $fonts['sizes']['tooltip'] ?? 13,
                        'weight' => 'bold',
                    ],
                    'bodyFont' => [
                        'size' => $fonts['sizes']['tooltip'] ?? 13,
                    ],
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'grid' => [
                        'display' => false,
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => $colors['dark'],
                        'font' => [
                            'family' => $fonts['family'] ?? 'Inter',
                            'size' => $fonts['sizes']['label'] ?? 11,
                        ],
                    ],
                ],
                'y' => [
                    'display' => true,
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.05)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => $colors['dark'],
                        'font' => [
                            'family' => $fonts['family'] ?? 'Inter',
                            'size' => $fonts['sizes']['label'] ?? 11,
                        ],
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

    /**
     * Generate dataset with theme colors
     *
     * @param array<int|float> $data
     * @param string $label
     * @param string $colorKey
     * @return array<string, mixed>
     */
    protected function createDataset(
        array $data,
        string $label,
        string $colorKey = 'primary'
    ): array {
        $colors = $this->getThemeColors();
        $opacity = config('theme-one.charts.opacity', []);
        $baseColor = $colors[$colorKey] ?? $colors['primary'];

        return [
            'label' => $label,
            'data' => $data,
            'backgroundColor' => $this->addAlphaToHex($baseColor, $opacity['fill'] ?? 0.2),
            'borderColor' => $baseColor,
            'borderWidth' => 2,
            'pointBackgroundColor' => $baseColor,
            'pointBorderColor' => '#fff',
            'pointBorderWidth' => 2,
            'pointRadius' => 4,
            'pointHoverRadius' => 6,
            'pointHoverBackgroundColor' => $baseColor,
            'pointHoverBorderColor' => '#fff',
            'pointHoverBorderWidth' => 2,
        ];
    }

    /**
     * Add alpha channel to hex color
     *
     * @param string $hex
     * @param float $alpha
     * @return string
     */
    private function addAlphaToHex(string $hex, float $alpha): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba({$r}, {$g}, {$b}, {$alpha})";
    }

    /**
     * Get multi-color palette for charts
     *
     * @return array<string>
     */
    protected function getColorPalette(): array
    {
        $colors = $this->getThemeColors();

        return [
            $colors['primary'],
            $colors['success'],
            $colors['warning'],
            $colors['danger'],
            $colors['info'],
            $colors['purple'],
            $colors['pink'],
            $colors['indigo'],
        ];
    }
}
```

---

## 📊 Chart Widgets Esempi

### 1. Line Chart Styled

```php
<?php

namespace Themes\One\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\Sale;

class SalesLineChartWidget extends ThemeOneChartWidget
{
    protected static ?string $heading = 'Sales Trend';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Sale::class)
            ->between(start: now()->subDays(30), end: now())
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                $this->createDataset(
                    data: $data->map(fn($v) => $v->aggregate)->toArray(),
                    label: 'Sales',
                    colorKey: 'accent'
                ) + [
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn($v) => $v->date->format('d/m'))->toArray(),
        ];
    }
}
```

### 2. Multi-Dataset Bar Chart

```php
class RevenueComparisonWidget extends ThemeOneChartWidget
{
    protected static ?string $heading = 'Revenue Comparison';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                $this->createDataset(
                    data: [120, 150, 180, 140, 200],
                    label: '2024',
                    colorKey: 'primary'
                ),
                $this->createDataset(
                    data: [100, 130, 160, 120, 180],
                    label: '2023',
                    colorKey: 'secondary'
                ),
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            'scales' => [
                'x' => [
                    'stacked' => false,
                ],
                'y' => [
                    'stacked' => false,
                ],
            ],
        ]);
    }
}
```

### 3. Doughnut Chart with Custom Colors

```php
class CategoryDistributionWidget extends ThemeOneChartWidget
{
    protected static ?string $heading = 'Category Distribution';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $opacity = config('theme-one.charts.opacity.solid', 0.8);
        $palette = $this->getColorPalette();

        return [
            'datasets' => [
                [
                    'label' => 'Categories',
                    'data' => [35, 25, 20, 15, 5],
                    'backgroundColor' => array_map(
                        fn($color) => $this->addAlphaToHex($color, $opacity),
                        $palette
                    ),
                    'borderColor' => '#fff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Electronics', 'Clothing', 'Food', 'Books', 'Other'],
        ];
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            'cutout' => '60%',
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
            ],
        ]);
    }
}
```

### 4. Radar Chart with Theme Styling

```php
class PerformanceRadarWidget extends ThemeOneChartWidget
{
    protected static ?string $heading = 'Performance Metrics';

    protected function getType(): string
    {
        return 'radar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                $this->createDataset(
                    data: [85, 75, 90, 80, 95, 70],
                    label: 'Current Month',
                    colorKey: 'accent'
                ) + [
                    'fill' => true,
                ],
                $this->createDataset(
                    data: [70, 65, 75, 70, 80, 65],
                    label: 'Last Month',
                    colorKey: 'secondary'
                ) + [
                    'fill' => true,
                ],
            ],
            'labels' => ['Sales', 'Customer Satisfaction', 'Quality', 'Speed', 'Innovation', 'Cost'],
        ];
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            'scales' => [
                'r' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'stepSize' => 20,
                    ],
                ],
            ],
        ]);
    }
}
```

---

## 🎨 CSS Customization

### Chart Container Styling

```css
/* Themes/One/resources/css/charts.css */

.filament-widget-chart {
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    transition: box-shadow 0.3s ease;
}

.filament-widget-chart:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.filament-widget-chart .heading {
    color: #2c3e50;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
    font-family: 'Inter', sans-serif;
}

.filament-widget-chart canvas {
    max-height: 400px;
}

/* Dark mode support */
.dark .filament-widget-chart {
    background: #1e293b;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.5);
}

.dark .filament-widget-chart .heading {
    color: #f1f5f9;
}
```

### Responsive Breakpoints

```css
/* Mobile */
@media (max-width: 640px) {
    .filament-widget-chart {
        padding: 1rem;
    }

    .filament-widget-chart canvas {
        max-height: 250px;
    }
}

/* Tablet */
@media (min-width: 641px) and (max-width: 1024px) {
    .filament-widget-chart canvas {
        max-height: 300px;
    }
}

/* Desktop */
@media (min-width: 1025px) {
    .filament-widget-chart canvas {
        max-height: 400px;
    }
}
```

---

## 🎯 Chart Animations

### Custom Animation Config

```php
protected function getOptions(): array
{
    return array_merge(parent::getOptions(), [
        'animation' => [
            'duration' => 1000,
            'easing' => 'easeInOutQuart',
            'animateRotate' => true,
            'animateScale' => true,
        ],
        'animations' => [
            'tension' => [
                'duration' => 1000,
                'easing' => 'linear',
                'from' => 1,
                'to' => 0.4,
                'loop' => false,
            ],
        ],
    ]);
}
```

---

## 📤 Export Styled Charts

### Export with Theme Styling

```php
use Modules\Xot\Actions\Chart\ExportChartWidgetAction;
use Filament\Actions\Action;

class ThemedChartWidget extends ThemeOneChartWidget
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Chart')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(function (ExportChartWidgetAction $action) {
                    // Export with theme styling preserved
                    $storedPath = $action->execute(
                        widget: $this,
                        format: 'png',
                        width: 1600,
                        height: 900
                    );

                    return Storage::download(
                        $storedPath,
                        'theme-one-chart-' . now()->format('Y-m-d') . '.png'
                    );
                }),
        ];
    }
}
```

---

## 🔌 Plugin Integration

### Chart.js Annotation Plugin (Theme One Style)

```php
protected function getOptions(): array
{
    $colors = $this->getThemeColors();

    return array_merge(parent::getOptions(), [
        'plugins' => [
            'annotation' => [
                'annotations' => [
                    'threshold' => [
                        'type' => 'line',
                        'yMin' => 75,
                        'yMax' => 75,
                        'borderColor' => $colors['warning'],
                        'borderWidth' => 2,
                        'borderDash' => [5, 5],
                        'label' => [
                            'display' => true,
                            'content' => 'Target',
                            'position' => 'end',
                            'backgroundColor' => $colors['warning'],
                            'color' => '#fff',
                            'font' => [
                                'size' => 12,
                                'weight' => 'bold',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
}
```

---

## 🧪 Testing

### Visual Regression Test

```php
<?php

namespace Tests\Feature\Themes\One;

use Tests\TestCase;
use Themes\One\Filament\Widgets\SalesLineChartWidget;

class ChartStylingTest extends TestCase
{
    /** @test */
    public function it_applies_theme_one_colors()
    {
        $widget = new SalesLineChartWidget();
        $data = $widget->getData();

        $dataset = $data['datasets'][0];

        // Verify theme colors are applied
        $this->assertStringContainsString('rgba', $dataset['backgroundColor']);
        $this->assertStringStartsWith('#', $dataset['borderColor']);
    }

    /** @test */
    public function it_uses_theme_one_fonts()
    {
        $widget = new SalesLineChartWidget();
        $options = $widget->getOptions();

        $legendFont = $options['plugins']['legend']['labels']['font'];

        $this->assertStringContainsString('Inter', $legendFont['family']);
        $this->assertEquals(12, $legendFont['size']);
    }
}
```

---

## 📚 Risorse

### Documentazione Correlata
- [Filament Charts Complete Guide](../../Modules/Xot/docs/filament-charts-complete-guide.md)
- [Chart Export Guide](../../Modules/Xot/docs/chart-export-guide.md)
- [Theme One Design System](./design-system.md)
- [Theme One Color Palette](./colors.md)

### Chart.js
- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [Chart.js Styling](https://www.chartjs.org/docs/latest/general/styling.html)
- [Chart.js Colors](https://www.chartjs.org/docs/latest/general/colors.html)

---

**Ultimo aggiornamento:** Dicembre 2025
**Tema:** One
**Framework:** Laraxot/PTVX
**Filament:** 4.x
**PHPStan Level:** 10
