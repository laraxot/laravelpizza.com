# Chart.js Datalabels Plugin Implementation in Xot Module

## Overview

This guide provides comprehensive instructions for implementing the Chart.js datalabels plugin within the Xot module, which serves as the foundational module for all other modules in the Laraxot system. The Xot module's XotBaseChartWidget provides the base implementation that all other chart widgets extend.

## XotBaseChartWidget Enhancement

The XotBaseChartWidget can be enhanced to provide better datalabels support by adding a method to generate default datalabels options:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget as FilamentChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enhanced base widget for chart widgets with datalabels support.
 */
abstract class XotBaseChartWidget extends FilamentChartWidget
{
    use InteractsWithPageFilters;
    use TransTrait;

    protected ?string $heading = null;

    protected static ?int $sort = 1;

    protected static bool $isLazy = true;

    protected ?string $pollingInterval = null;

    /**
     * Get default datalabels options.
     * Override this method in child classes to customize datalabels.
     */
    protected function getDatalabelsOptions(): array
    {
        return [
            'display' => true,
            'align' => 'center',
            'anchor' => 'center',
            'formatter' => 'function(value, context) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 12,
            ],
            'color' => '#fff',
        ];
    }

    /**
     * Restituisce il titolo del widget.
     */
    public function getHeading(): ?string
    {
        return static::trans('navigation.heading');
    }

    /**
     * Restituisce i dati per il grafico.
     */
    protected function getData(): array
    {
        return [];
    }

    /**
     * Restituisce il tipo di grafico.
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Restituisce le opzioni del grafico.
     */
    protected function getOptions(): array
    {
        $datalabelsOptions = $this->getDatalabelsOptions();

        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "' . __('<nome modulo>::widgets.chart.total_value') . '".replace(":count", context.parsed.y);
                        }',
                    ],
                ],
                'datalabels' => $datalabelsOptions,
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => __('<nome modulo>::widgets.chart.x_axis.label'),
                    ],
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => __('<nome modulo>::widgets.chart.y_axis.label'),
                    ],
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
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
     * Restituisce l'altezza del widget.
     */
    protected function getHeight(): ?string
    {
        return '300px';
    }
}
```

## Standard Datalabels Configuration Methods

### Basic Datalabels Configuration

Create a standard method to configure datalabels for different use cases:

```php
/**
 * Get simple datalabels configuration showing values only.
 */
protected function getSimpleDatalabelsOptions(): array
{
    return [
        'display' => true,
        'align' => 'center',
        'anchor' => 'center',
        'formatter' => 'function(value) {
            return value;
        }',
        'font' => [
            'weight' => 'bold',
            'size' => 12,
        ],
        'color' => '#fff',
    ];
}

/**
 * Get percentage datalabels configuration for pie/doughnut charts.
 */
protected function getPercentageDatalabelsOptions(): array
{
    return [
        'display' => true,
        'align' => 'end',
        'anchor' => 'end',
        'formatter' => 'function(value, context) {
            var dataset = context.dataset;
            var total = dataset.data.reduce(function(sum, current) {
                return sum + current;
            }, 0);
            var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
            return percentage + "%";
        }',
        'font' => [
            'weight' => 'bold',
            'size' => 12,
        ],
        'color' => '#fff',
        'textStrokeColor' => '#000',
        'textStrokeWidth' => 1,
    ];
}

/**
 * Get value and percentage datalabels configuration.
 */
protected function getValueAndPercentageDatalabelsOptions(): array
{
    return [
        'display' => true,
        'labels' => [
            'value' => [
                'align' => 'top',
                'anchor' => 'start',
                'formatter' => 'function(value) {
                    return value;
                }',
                'font' => ['weight' => 'bold'],
                'color' => '#333',
            ],
            'percentage' => [
                'align' => 'bottom',
                'anchor' => 'end',
                'formatter' => 'function(value, context) {
                    var dataset = context.dataset;
                    var total = dataset.data.reduce(function(sum, current) {
                        return sum + current;
                    }, 0);
                    var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return "(" + percentage + "%)";
                }',
                'font' => ['size' => 10],
                'color' => '#666',
            ],
        ],
    ];
}

/**
 * Get conditional datalabels configuration based on data size.
 */
protected function getConditionalDatalabelsOptions(): array
{
    return [
        'display' => 'function(context) {
            var dataset = context.dataset;
            var value = dataset.data[context.dataIndex];
            var total = dataset.data.reduce(function(sum, current) {
                return sum + current;
            }, 0);
            var percentage = total > 0 ? (value / total) * 100 : 0;
            return percentage > 3; // Only display if segment is > 3% of total
        }',
        'align' => 'center',
        'anchor' => 'center',
        'formatter' => 'function(value) {
            return value;
        }',
        'font' => [
            'weight' => 'bold',
            'size' => 11,
        ],
        'color' => '#fff',
    ];
}
```

## Advanced XotBaseChartWidget Examples

### Enhanced Base Chart with Multiple Configuration Options

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget as FilamentChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enhanced XotBaseChartWidget with comprehensive datalabels support.
 */
abstract class XotBaseChartWidget extends FilamentChartWidget
{
    use InteractsWithPageFilters;
    use TransTrait;

    protected ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = null;
    
    // Datalabels configuration options
    protected bool $showDatalabels = true;
    protected string $datalabelsAlign = 'center';
    protected string $datalabelsAnchor = 'center';
    protected string $datalabelsFormatter = 'value';
    protected array $datalabelsFont = ['weight' => 'bold', 'size' => 12];
    protected string $datalabelsColor = '#fff';

    /**
     * Configure datalabels options based on configuration.
     */
    protected function getDatalabelsOptions(): array
    {
        if (!$this->showDatalabels) {
            return ['display' => false];
        }

        $formatter = match($this->datalabelsFormatter) {
            'percentage' => 'function(value, context) {
                var dataset = context.dataset;
                var total = dataset.data.reduce(function(sum, current) {
                    return sum + current;
                }, 0);
                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                return percentage + "%";
            }',
            'value_and_percentage' => 'function(value, context) {
                var dataset = context.dataset;
                var total = dataset.data.reduce(function(sum, current) {
                    return sum + current;
                }, 0);
                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                return value + "\n(" + percentage + "%)";
            }',
            default => 'function(value) {
                return value;
            }',
        };

        return [
            'display' => true,
            'align' => $this->datalabelsAlign,
            'anchor' => $this->datalabelsAnchor,
            'formatter' => $formatter,
            'font' => $this->datalabelsFont,
            'color' => $this->datalabelsColor,
        ];
    }

    /**
     * Set datalabels configuration.
     */
    public function configureDatalabels(
        bool $show = true,
        string $align = 'center',
        string $anchor = 'center',
        string $formatter = 'value',
        array $font = ['weight' => 'bold', 'size' => 12],
        string $color = '#fff'
    ): static {
        $this->showDatalabels = $show;
        $this->datalabelsAlign = $align;
        $this->datalabelsAnchor = $anchor;
        $this->datalabelsFormatter = $formatter;
        $this->datalabelsFont = $font;
        $this->datalabelsColor = $color;
        
        return $this;
    }

    /**
     * Restituisce le opzioni del grafico.
     */
    protected function getOptions(): array
    {
        $datalabelsOptions = $this->getDatalabelsOptions();

        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
                'datalabels' => $datalabelsOptions,
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'display' => true,
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

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

    protected function getHeight(): ?string
    {
        return '300px';
    }
}
```

## Datalabels for Different Chart Types

### Configuring Datalabels Based on Chart Type

```php
/**
 * Get datalabels options optimized for different chart types.
 */
protected function getOptimizedDatalabelsOptions(): array
{
    $chartType = $this->getType();
    
    return match($chartType) {
        'doughnut', 'pie' => [
            'display' => true,
            'align' => 'end',
            'anchor' => 'end',
            'formatter' => 'function(value, context) {
                var dataset = context.dataset;
                var total = dataset.data.reduce(function(sum, current) {
                    return sum + current;
                }, 0);
                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                return value + "\n(" + percentage + "%)";
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 10,
            ],
            'color' => '#fff',
        ],
        'line' => [
            'display' => 'function(context) {
                // Only show labels for significant values in line charts
                var value = context.dataset.data[context.dataIndex];
                return value > 0;
            }',
            'align' => 'top',
            'anchor' => 'end',
            'formatter' => 'function(value) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 10,
            ],
            'color' => '#333',
        ],
        'bar', 'horizontalBar' => [
            'display' => true,
            'align' => 'top',
            'anchor' => 'end',
            'formatter' => 'function(value) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 11,
            ],
            'color' => '#333',
        ],
        default => [
            'display' => true,
            'align' => 'center',
            'anchor' => 'center',
            'formatter' => 'function(value) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 12,
            ],
            'color' => '#fff',
        ],
    };
}
```

## Performance Optimized Datalabels

### Conditional Display Based on Data Count

```php
/**
 * Get performance-optimized datalabels options that adjust based on data size.
 */
protected function getPerformanceOptimizedDatalabelsOptions(): array
{
    $data = $this->getData();
    $dataCount = 0;
    
    if (isset($data['datasets']) && !empty($data['datasets'])) {
        $firstDataset = $data['datasets'][0] ?? [];
        $dataCount = count($firstDataset['data'] ?? []);
    }
    
    if ($dataCount > 20) {
        // Too many data points, disable datalabels for performance
        return ['display' => false];
    } elseif ($dataCount > 10) {
        // Many data points, show only on hover
        return [
            'display' => 'function(context) {
                return context.active; // Only show when active/hovered
            }',
            'align' => 'center',
            'anchor' => 'center',
            'formatter' => 'function(value) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 10,
            ],
            'color' => '#333',
        ];
    } else {
        // Few data points, show all datalabels
        return [
            'display' => true,
            'align' => 'center',
            'anchor' => 'center',
            'formatter' => 'function(value) {
                return value;
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 12,
            ],
            'color' => '#fff',
        ];
    }
}
```

## Color-Aware Datalabels

### Automatic Contrast for Better Readability

```php
/**
 * Get datalabels with automatic contrast based on background color.
 */
protected function getColorAwareDatalabelsOptions(): array
{
    return [
        'display' => true,
        'align' => 'center',
        'anchor' => 'center',
        'formatter' => 'function(value) {
            return value;
        }',
        'font' => [
            'weight' => 'bold',
            'size' => 12,
        ],
        'color' => 'function(context) {
            // Get the background color of the current data point
            var backgroundColor = context.dataset.backgroundColor[context.dataIndex];
            
            // Convert different color formats to RGB for brightness calculation
            var r, g, b;
            
            if (typeof backgroundColor === "string") {
                if (backgroundColor.startsWith("rgba(") || backgroundColor.startsWith("rgb(")) {
                    // Extract RGB values from rgb/rgba string
                    var match = backgroundColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                    if (match) {
                        r = parseInt(match[1]);
                        g = parseInt(match[2]);
                        b = parseInt(match[3]);
                    }
                } else if (backgroundColor.startsWith("#")) {
                    // Convert hex to RGB
                    var hex = backgroundColor.replace("#", "");
                    if (hex.length === 3) {
                        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                    }
                    r = parseInt(hex.substring(0,2), 16);
                    g = parseInt(hex.substring(2,4), 16);
                    b = parseInt(hex.substring(4,6), 16);
                }
            }
            
            // Calculate brightness using relative luminance formula
            if (r !== undefined && g !== undefined && b !== undefined) {
                var brightness = (r * 299 + g * 587 + b * 114) / 1000;
                // Return black for bright backgrounds, white for dark backgrounds
                return brightness > 128 ? "#000" : "#fff";
            }
            
            // Default to white if we can't determine the background color
            return "#fff";
        }',
    ];
}
```

## Complete XotBaseChartWidget with All Features

Here's a complete implementation of XotBaseChartWidget with all datalabels features:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget as FilamentChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enhanced XotBaseChartWidget with comprehensive datalabels support and optimization features.
 */
abstract class XotBaseChartWidget extends FilamentChartWidget
{
    use InteractsWithPageFilters;
    use TransTrait;

    protected ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = null;
    
    // Datalabels configuration
    protected bool $showDatalabels = true;
    protected string $datalabelsAlign = 'center';
    protected string $datalabelsAnchor = 'center';
    protected string $datalabelsFormatter = 'value';
    protected array $datalabelsFont = ['weight' => 'bold', 'size' => 12];
    protected string $datalabelsColor = '#fff';
    protected bool $useAutoContrast = false;
    protected bool $usePerformanceOptimization = true;
    protected bool $showOnHoverOnly = false;

    /**
     * Get datalabels options with all configuration features.
     */
    protected function getDatalabelsOptions(): array
    {
        if (!$this->showDatalabels) {
            return ['display' => false];
        }

        // Performance optimization: check data count
        if ($this->usePerformanceOptimization) {
            $data = $this->getData();
            $dataCount = 0;
            
            if (isset($data['datasets']) && !empty($data['datasets'])) {
                $firstDataset = $data['datasets'][0] ?? [];
                $dataCount = count($firstDataset['data'] ?? []);
            }
            
            if ($dataCount > 20) {
                // Too many data points, disable datalabels for performance
                return ['display' => false];
            } elseif ($dataCount > 10) {
                // Many data points, show only on hover or with auto-hide overlapping
                $displayOption = $this->showOnHoverOnly 
                    ? 'function(context) { return context.active; }'
                    : 'auto'; // Auto-hide overlapping labels
            } else {
                $displayOption = true;
            }
        } else {
            $displayOption = true;
        }

        // Determine formatter function
        $formatter = match($this->datalabelsFormatter) {
            'percentage' => 'function(value, context) {
                var dataset = context.dataset;
                var total = dataset.data.reduce(function(sum, current) {
                    return sum + current;
                }, 0);
                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                return percentage + "%";
            }',
            'value_and_percentage' => 'function(value, context) {
                var dataset = context.dataset;
                var total = dataset.data.reduce(function(sum, current) {
                    return sum + current;
                }, 0);
                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                return value + "\n(" + percentage + "%)";
            }',
            'currency' => 'function(value) {
                return "€" + value.toFixed(2);
            }',
            'time' => 'function(value) {
                // Format as time - value should be in seconds
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value % 3600) / 60);
                return hours + "h " + minutes + "m";
            }',
            default => 'function(value) {
                return value;
            }',
        };

        // Determine color function
        $color = $this->useAutoContrast
            ? 'function(context) {
                var backgroundColor = context.dataset.backgroundColor[context.dataIndex];
                if (typeof backgroundColor === "string") {
                    var r, g, b;
                    if (backgroundColor.startsWith("rgba(") || backgroundColor.startsWith("rgb(")) {
                        var match = backgroundColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                        if (match) {
                            r = parseInt(match[1]);
                            g = parseInt(match[2]);
                            b = parseInt(match[3]);
                        }
                    } else if (backgroundColor.startsWith("#")) {
                        var hex = backgroundColor.replace("#", "");
                        if (hex.length === 3) {
                            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                        }
                        r = parseInt(hex.substring(0,2), 16);
                        g = parseInt(hex.substring(2,4), 16);
                        b = parseInt(hex.substring(4,6), 16);
                    }
                    
                    if (r !== undefined && g !== undefined && b !== undefined) {
                        var brightness = (r * 299 + g * 587 + b * 114) / 1000;
                        return brightness > 128 ? "#000" : "#fff";
                    }
                }
                return "#fff";
            }'
            : $this->datalabelsColor;

        return [
            'display' => $displayOption,
            'align' => $this->datalabelsAlign,
            'anchor' => $this->datalabelsAnchor,
            'formatter' => $formatter,
            'font' => $this->datalabelsFont,
            'color' => $color,
        ];
    }

    /**
     * Configure datalabels with multiple options at once.
     */
    public function configureDatalabels(
        bool $show = true,
        string $align = 'center',
        string $anchor = 'center',
        string $formatter = 'value',
        array $font = ['weight' => 'bold', 'size' => 12],
        string $color = '#fff',
        bool $autoContrast = false,
        bool $performanceOptimization = true,
        bool $onHoverOnly = false
    ): static {
        $this->showDatalabels = $show;
        $this->datalabelsAlign = $align;
        $this->datalabelsAnchor = $anchor;
        $this->datalabelsFormatter = $formatter;
        $this->datalabelsFont = $font;
        $this->datalabelsColor = $color;
        $this->useAutoContrast = $autoContrast;
        $this->usePerformanceOptimization = $performanceOptimization;
        $this->showOnHoverOnly = $onHoverOnly;
        
        return $this;
    }

    /**
     * Get the complete chart options with datalabels.
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
                'datalabels' => $this->getDatalabelsOptions(),
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'display' => true,
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    /**
     * Get the chart heading.
     */
    public function getHeading(): ?string
    {
        return static::trans('navigation.heading');
    }

    /**
     * Get the chart data.
     */
    protected function getData(): array
    {
        return [];
    }

    /**
     * Get the chart type.
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Get the chart height.
     */
    protected function getHeight(): ?string
    {
        return '300px';
    }
}
```

## Example Implementation in a Child Widget

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

class ExampleChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Example Chart with Datalabels';

    protected function getData(): array
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [100, 150, 200, 180, 220, 250],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        // Configure datalabels for this specific chart
        $this->configureDatalabels(
            show: true,
            align: 'top',
            anchor: 'end',
            formatter: 'value',
            font: ['weight' => 'bold', 'size' => 12],
            color: '#333',
            autoContrast: false,
            performanceOptimization: true,
            onHoverOnly: false
        );

        return parent::getOptions();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
```

## Dual Labels Example (DRY/KISS)

For a minimal, production-ready example showing 2 labels per bar using `RawJs::make()`, see:

<<<<<<< .merge_file_ZuzEnC
**`Modules/healthcare_app/Filament/Widgets/SimpleChartWidget.php`**
=======
<<<<<<< HEAD
**`Modules/ExternalProject/Filament/Widgets/SimpleChartWidget.php`**
=======
**`Modules/ModuloEsempio/Filament/Widgets/SimpleChartWidget.php`**
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_v1Gvow

Key pattern:
```php
protected function getOptions(): RawJs
{
    return RawJs::make(<<<'JS'
{
  plugins: {
    datalabels: {
      labels: {
        value: { anchor: 'end', align: 'top', ... },
        percent: { anchor: 'center', align: 'center', ... }
      }
    }
  }
}
JS);
}
```

**IMPORTANT:** Use `RawJs::make()` when JS callbacks are needed. PHP arrays with string functions don't execute as JavaScript.

## Best Practices for Xot Module Implementation

1. **Consistency**: Ensure all child classes inherit the same datalabels configuration patterns
2. **Performance**: Implement data count checks to optimize for large datasets
3. **Accessibility**: Use automatic contrast detection for better readability
4. **Flexibility**: Provide configuration methods that allow child classes to customize behavior
5. **Maintainability**: Keep the base implementation clean and well-documented
6. **Scalability**: Design configuration options that can be extended without breaking existing functionality
7. **Use RawJs**: Always use `RawJs::make()` for JavaScript callbacks in chart options
