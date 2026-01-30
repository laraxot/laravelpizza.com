# Chart.js Datalabels Plugin Integration Guide

## Overview

This guide explains how to integrate the Chart.js datalabels plugin with Filament 5 ChartWidgets in the Laraxot system. The datalabels plugin allows you to display labels on data points for any type of chart, providing enhanced data visualization capabilities.

## Plugin Installation

First, install the Chart.js datalabels plugin:

```bash
npm install chartjs-plugin-datalabels --save-dev
```

## Plugin Registration

Register the plugin in your Vite configuration or JavaScript files:

```javascript
// resources/js/filament-chart-js-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Register with Filament
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

Make sure to include this file in your Vite configuration:

```javascript
// vite.config.js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/filament-chart-js-plugins.js' // Add this
    ],
    // ... other config
}),
```

## Basic Configuration in Filament ChartWidgets

To use the datalabels plugin in your Filament ChartWidgets, you need to configure it in the `getOptions()` method:

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class MyChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'My Chart with Datalabels';

    protected function getData(): array
    {
        return [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [100, 200, 150, 300, 250],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'datalabels' => [
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
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // or 'line', 'doughnut', 'pie', etc.
    }
}
```

## Advanced Configuration: Multiple Labels

You can configure multiple labels per data point using the `labels` option:

```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'labels' => [
                    'index' => [
                        'align' => 'end',
                        'anchor' => 'end',
                        'color' => 'function(ctx) { return ctx.dataset.backgroundColor; }',
                        'font' => ['size' => 18],
                        'formatter' => 'function(value, ctx) { 
                            return ctx.active ? "index" : "#" + (ctx.dataIndex + 1); 
                        }',
                        'offset' => 8,
                        'opacity' => 'function(ctx) { return ctx.active ? 1 : 0.5; }',
                    ],
                    'name' => [
                        'align' => 'top',
                        'font' => ['size' => 16],
                        'formatter' => 'function(value, ctx) { 
                            return ctx.active ? "name" : ctx.chart.data.labels[ctx.dataIndex]; 
                        }',
                    ],
                    'value' => [
                        'align' => 'bottom',
                        'backgroundColor' => 'function(ctx) { 
                            var value = ctx.dataset.data[ctx.dataIndex]; 
                            return value > 50 ? "white" : null; 
                        }',
                        'borderColor' => 'white',
                        'borderWidth' => 2,
                        'borderRadius' => 4,
                        'color' => 'function(ctx) { 
                            var value = ctx.dataset.data[ctx.dataIndex]; 
                            return value > 50 ? ctx.dataset.backgroundColor : "white"; 
                        }',
                        'formatter' => 'function(value, ctx) { 
                            return ctx.active ? "value" : Math.round(value * 1000) / 1000; 
                        }',
                        'padding' => 4,
                    ],
                ],
            ],
        ],
    ];
}
```

## Positioning Options

The datalabels plugin provides flexible positioning options:

### Anchor Options
- `'center'` (default): element center
- `'start'`: lowest element boundary
- `'end'`: highest element boundary

### Align Options
- `'center'` (default): the label is centered on the anchor point
- `'start'`: the label is positioned before the anchor point
- `'end'`: the label is positioned after the anchor point
- `'right'`: the label is positioned to the right of the anchor point (0°)
- `'bottom'`: the label is positioned to the bottom of the anchor point (90°)
- `'left'`: the label is positioned to the left of the anchor point (180°)
- `'top'`: the label is positioned to the top of the anchor point (270°)

## Scriptable Options

Options can be made scriptable to provide dynamic behavior based on context:

```php
'datalabels' => [
    'display' => 'function(ctx) { 
        return ctx.dataset.data[ctx.dataIndex] > 10; 
    }',
    'color' => 'function(ctx) {
        var value = ctx.dataset.data[ctx.dataIndex];
        return value > 50 ? "red" : "blue";
    }',
    'font' => [
        'weight' => 'function(ctx) {
            return ctx.active ? "bold" : "normal";
        }',
    ],
],
```

## Visibility Control

Control label visibility with the `display` option:

```php
'display' => 'auto', // Hides overlapping labels
// or
'display' => 'function(ctx) { 
    return ctx.dataset.data[ctx.dataIndex] > 10; 
}',
```

## Complete Example with Different Chart Types

### Bar Chart with Datalabels

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class BarChartWithDatalabels extends XotBaseChartWidget
{
    protected static ?string $heading = 'Bar Chart with Datalabels';

    protected function getData(): array
    {
        return [
            'labels' => ['Product A', 'Product B', 'Product C', 'Product D'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [120, 200, 150, 180],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'align' => 'top',
                    'anchor' => 'end',
                    'formatter' => 'function(value) {
                        return "$" + value;
                    }',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 14,
                    ],
                    'color' => '#36A2EB',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
```

### Doughnut Chart with Datalabels

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class DoughnutChartWithDatalabels extends XotBaseChartWidget
{
    protected static ?string $heading = 'Doughnut Chart with Datalabels';

    protected function getData(): array
    {
        return [
            'labels' => ['Red', 'Blue', 'Yellow', 'Green'],
            'datasets' => [
                [
                    'data' => [300, 50, 100, 75],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'align' => 'end',
                    'anchor' => 'end',
                    'formatter' => 'function(value, ctx) {
                        var sum = 0;
                        var data = ctx.dataset.data;
                        for (var i = 0; i < data.length; i++) {
                            sum += data[i];
                        }
                        var percentage = ((value * 100) / sum).toFixed(1) + "%";
                        return percentage;
                    }',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 12,
                    ],
                    'color' => '#fff',
                    'textStrokeColor' => '#000',
                    'textStrokeWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
```

## Troubleshooting

### Common Issues

1. **Labels not showing**: Make sure the plugin is properly registered and the `display` option is set to `true`
2. **JavaScript errors**: Ensure all function strings are properly formatted as JavaScript functions
3. **Styling issues**: Check that the datalabels CSS is not being overridden by other styles

### Debugging Tips

1. Check browser console for JavaScript errors
2. Verify plugin registration in the browser console:
   ```javascript
   console.log(ChartDataLabels);
   ```
3. Test with simple configuration first, then add complexity

## Best Practices

1. **Performance**: Use `display: false` for charts with many data points to avoid clutter
2. **Accessibility**: Ensure label colors have sufficient contrast
3. **Readability**: Use appropriate font sizes and positioning based on chart size
4. **Responsive**: Test label positioning on different screen sizes
5. **Conditional Display**: Use scriptable options to show/hide labels based on data values