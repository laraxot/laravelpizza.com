# chartjs-plugin-datalabels with Filament 5 ChartWidget (multiple labels)

## Scope

This guide explains how to use `chartjs-plugin-datalabels` to render **multiple labels per slice/bar** inside Filament v5 `ChartWidget` instances, with the Chart module’s asset pipeline.

Reference sample:

- [chartjs-plugin-datalabels – multiple labels sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)

## Quick mental model

`chartjs-plugin-datalabels` supports multiple labels by defining:

- global defaults: `options.plugins.datalabels.*`
- multiple named labels: `dataset.datalabels.labels.{name}`

Each named label can override:

- positioning: `align`, `anchor`, `offset`
- style: `font`, `color`, `backgroundColor`, `borderColor`, `borderWidth`, `borderRadius`, `padding`, `opacity`
- value formatting: `formatter(value, ctx)`

## 1) Install (NPM)

Run inside the Chart module:

- `laravel/Modules/Chart/`

```bash
npm install chartjs-plugin-datalabels --save-dev
```

## 2) Register the plugin for Filament v5 charts

Filament v5 expects plugins to be registered via a dedicated JS file using:

- `window.filamentChartJsPlugins` (inline plugins)
- `window.filamentChartJsGlobalPlugins` (global plugins)

In this repo the Chart module already has:

- `Modules/Chart/resources/js/filament-chart-js-plugins.js`

Minimal content:

```js
import ChartDataLabels from 'chartjs-plugin-datalabels'

window.filamentChartJsPlugins ??= []
window.filamentChartJsPlugins.push(ChartDataLabels)
```

## 3) Build with Vite

The Chart module builds assets via:

- `Modules/Chart/vite.config.js`

Ensure `resources/js/filament-chart-js-plugins.js` is included in the Vite `input` list.

## 4) Ensure Filament loads the compiled asset

In this repo, the Chart panel provider registers assets here:

- `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`

and includes the JS bundle through `FilamentAsset::register([...])`.

## 5) Multiple labels in a Filament ChartWidget

### Rule of thumb

- If you need **JS callbacks** (like `formatter: function (value, ctx) { ... }`), follow the conventions of the base widget you extend.
- In this repo, `XotBaseChartWidget::getOptions()` returns an **array**, so callbacks are typically provided as **JS function strings** (see tooltip callbacks in `XotBaseChartWidget`).

### Example: doughnut chart with 3 labels (index + name + value)

This mirrors the official sample.

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Support\RawJs;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class SampleDatalabelsMultipleLabelsChart extends XotBaseChartWidget
{
    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['A', 'B', 'C', 'D'],
            'datasets' => [
                [
                    'data' => [12, 55, 9, 33],
                    'backgroundColor' => ['#1d4ed8', '#10b981', '#f59e0b', '#ef4444'],
                    'hoverBorderColor' => 'white',
                    'datalabels' => [
                        'labels' => [
                            'index' => [
                                'align' => 'end',
                                'anchor' => 'end',
                                'font' => ['size' => 18],
                                'offset' => 8,
                            ],
                            'name' => [
                                'align' => 'top',
                                'font' => ['size' => 16],
                            ],
                            'value' => [
                                'align' => 'bottom',
                                'borderColor' => 'white',
                                'borderWidth' => 2,
                                'borderRadius' => 4,
                                'padding' => 4,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
{
  plugins: {
    datalabels: {
      color: 'white',
      display: function(ctx) {
        return ctx.dataset.data[ctx.dataIndex] > 10;
      },
      font: {
        weight: 'bold'
      },
      offset: 0,
      padding: 0,
      labels: {
        index: {
          color: function(ctx) {
            return ctx.dataset.backgroundColor[ctx.dataIndex];
          },
          formatter: function(value, ctx) {
            return ctx.active
              ? 'index'
              : '#' + (ctx.dataIndex + 1);
          },
          opacity: function(ctx) {
            return ctx.active ? 1 : 0.5;
          }
        },
        name: {
          formatter: function(value, ctx) {
            return ctx.active
              ? 'name'
              : ctx.chart.data.labels[ctx.dataIndex];
          }
        },
        value: {
          backgroundColor: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 50 ? 'white' : null;
          },
          color: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 50
              ? ctx.dataset.backgroundColor[ctx.dataIndex]
              : 'white';
          },
          formatter: function(value, ctx) {
            return ctx.active
              ? 'value'
              : Math.round(value * 1000) / 1000;
          }
        }
      }
    }
  },

  aspectRatio: 3 / 2,
  layout: {
    padding: 16
  }
}
JS);
    }
}

## Notes about asset ownership

**CRITICAL ARCHITECTURE RULE**: This Chart module (Modules/Chart) is responsible for building and registering ALL Chart.js plugins bundle.
Other modules/panels/themes must NOT duplicate `FilamentAsset::register()` for chart plugins.
This follows DRY (Don't Repeat Yourself) principle to avoid code duplication and ensure consistent chart functionality across the application.

The Chart module handles:
- Installing chart-related dependencies (chartjs-plugin-datalabels, etc.)
- Registering assets via FilamentAsset::register()
- Managing plugin configuration files in resources/js/filament-chart-js-plugins.js
- Building assets through vite.config.js

All other modules (like Quaeris, UI, etc.) should simply use the registered plugins without re-registering them.

### Positioning Strategy

| Label | anchor | align | offset | Result |
|-------|--------|-------|--------|--------|
| value | end | bottom | 8 | Centered above bar |
| rank | end | top | -8 | Centered below bar |

For better UI/UX, use centered positioning with one label above and one below the bar:
- Both labels are centered relative to the bar for visual balance
- `anchor: 'end'` positions labels at the end (top) of the bar
- `align: 'bottom'` aligns the value label to appear above the bar
- `align: 'top'` with `offset: -8` positions the rank label below the bar
- This creates a clean, professional appearance with consistent spacing

### Background Styling Best Practices

For improved UI/UX and readability, use background styling for datalabels:

- **External Labels**: Use light background (e.g., `rgba(255, 255, 255, 0.8)`) with subtle border
- **Internal Labels**: Use dark semi-transparent background (e.g., `rgba(0, 0, 0, 0.6)`) for contrast
- **Border Radius**: Apply 4-8px border radius for modern appearance
- **Padding**: Use 4-8px padding for comfortable spacing
- **Colors**: Ensure sufficient contrast between text and background
- **Transparency**: Use semi-transparent backgrounds to maintain chart visibility underneath

**Enhanced Example with Background Styling:**
```php
'datalabels' => [
    'clip' => false,
    'clamp' => true,
    'labels' => [
        'value' => [  // Label displayed above the bar
            'anchor' => 'end',
            'align' => 'top',
            'offset' => 4,
            'color' => '#1f2937',                           // Dark text for contrast
            'backgroundColor' => 'rgba(255, 255, 255, 0.8)', // White semi-transparent background
            'borderRadius' => 4,                            // Rounded corners
            'borderColor' => 'rgba(0, 0, 0, 0.1)',        // Subtle border
            'borderWidth' => 1,
            'padding' => [                                 // Spacing around text
                'top' => 2,
                'bottom' => 2,
                'left' => 6,
                'right' => 6,
            ],
            'font' => [
                'weight' => 'bold',
                'size' => 12,
            ],
            'formatter' => 'function(v) { return v || ""; }',
            'display' => 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }',
        ],
        'rank' => [  // Label displayed inside the bar
            'anchor' => 'center',
            'align' => 'center',
            'color' => '#ffffff',                           // Light text for dark background
            'backgroundColor' => 'rgba(0, 0, 0, 0.6)',     // Dark semi-transparent background
            'borderRadius' => 8,                           // More rounded for rank display
            'borderColor' => 'rgba(255, 255, 255, 0.3)', // Light border for contrast
            'borderWidth' => 1,
            'padding' => [                                // More spacing for better visibility
                'top' => 4,
                'bottom' => 4,
                'left' => 8,
                'right' => 8,
            ],
            'font' => [
                'weight' => '600',
                'size' => 11,
            ],
            'formatter' => 'function(v, ctx) {
                var d = ctx.dataset.data || [];
                var sorted = d.slice().sort(function(a, b) { return Number(b) - Number(a); });
                var rank = sorted.indexOf(v) + 1;
                return "#" + rank;
            }',
            'display' => 'function(ctx) {
                var v = ctx.dataset.data[ctx.dataIndex] || 0;
                return v > 0;
            }',
        ],
    ],
],
```

## Multiline Labels (DRY + KISS)

For related data (e.g., media voti + numero votanti), use a **single multiline label**:

```php
$options['plugins']['datalabels'] = [
    'anchor' => 'end',
    'align' => 'top',
    'textAlign' => 'center',
    'backgroundColor' => 'rgba(255, 255, 255, 0.95)',
    'borderRadius' => 8,
    'padding' => ['top' => 6, 'bottom' => 6, 'left' => 12, 'right' => 12],
    'font' => ['lineHeight' => 1.5],
    'formatter' => 'function(value, ctx) {
        var voters = ctx.dataset.voters[ctx.dataIndex] || 0;
        return value.toFixed(1) + "\n" + voters + " voti";
    }',
];
```

**Key properties:**
- `textAlign: 'center'` - centers multiline text
- `font.lineHeight: 1.5` - spacing between lines
- `\n` in formatter - creates line break
- Custom dataset property (`voters`) for additional data

See `Modules/Quaeris/Filament/Widgets/SimpleChartWidget.php` for complete example.

## Rating Information Display Pattern (Average + Voter Count)

For displaying rating information (average rating 0-10 and voter count), use the stacked vertical approach:

### Example: Average Rating and Voter Count
```php
'datalabels' => [
    'clip' => false,
    'clamp' => true,
    'labels' => [
        // Primary label: Average rating positioned above bar
        'average' => [
            'anchor' => 'end',                       // Position at the end of the bar (top)
            'align' => 'bottom',                     // Align bottom of label to the anchor point
            'offset' => 14,                          // Higher offset for the average label
            'color' => '#1e293b',                    // Dark slate for high contrast
            'backgroundColor' => 'rgba(255, 255, 255, 0.9)', // Clean white background
            'borderColor' => 'rgba(209, 213, 219, 0.8)', // Light gray border
            'borderWidth' => 1,
            'borderRadius' => 6,                     // Rounded corners
            'padding' => [
                'top' => 3,
                'bottom' => 3,
                'left' => 8,
                'right' => 8,
            ],
            'font' => [
                'weight' => 'bold',                  // Bold for prominence
                'size' => 13,                        // Larger size for primary info
                'family' => 'system-ui, -apple-system, sans-serif',
            ],
            'formatter' => 'function(v) { 
                return "Media: " + Number(v).toFixed(1); 
            }',
            'display' => 'function(ctx) { 
                return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; 
            }',
        ],
        // Secondary label: Voter count positioned closer to bar
        'count' => [
            'anchor' => 'end',                       // Position at the end of the bar (top)
            'align' => 'bottom',                     // Align bottom of label to the anchor point
            'offset' => 4,                           // Lower offset (closer to bar)
            'color' => '#64748b',                    // Muted slate gray for secondary info
            'backgroundColor' => 'rgba(241, 245, 249, 0.85)', // Light gray background
            'borderColor' => 'rgba(226, 232, 240, 0.8)', // Lighter border
            'borderWidth' => 1,
            'borderRadius' => 4,                     // Slightly less rounded
            'padding' => [
                'top' => 2,
                'bottom' => 2,
                'left' => 6,
                'right' => 6,
            ],
            'font' => [
                'weight' => '500',                   // Medium weight (less than bold)
                'size' => 11,                        // Smaller size for secondary info
                'family' => 'system-ui, -apple-system, sans-serif',
            ],
            'formatter' => 'function(v, ctx) {
                // Get the voter count from a separate dataset or array
                var voteCounts = [45, 52, 38, 41, 63, 55, 58, 71, 67, 59, 62, 68];
                var voterCount = voteCounts[ctx.dataIndex];
                return "Votanti: " + voterCount;
            }',
            'display' => 'function(ctx) {
                var voteCounts = [45, 52, 38, 41, 63, 55, 58, 71, 67, 59, 62, 68];
                var voterCount = voteCounts[ctx.dataIndex];
                return voterCount > 0;
            }',
        ],
    ],
],
```

### Benefits of Stacked Rating Information:
- **Logical Grouping**: Average and voter count displayed close together
- **Visual Hierarchy**: Average rating emphasized with bold styling
- **Quick Understanding**: Users see both quality (average) and quantity (count) at a glance
- **Consistent Layout**: Same approach applied to all rating charts

## Custom Dataset Properties Pattern

Chart.js allows any custom property on datasets. Use this to pass additional data to formatters:

```php
protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Average Ratings',
                'data' => [7.2, 8.1, 6.8, 7.5],           // Primary data (for Y axis)
                'voters' => [45, 52, 38, 41],             // Custom: voter counts
                'minRatings' => [5.1, 6.2, 4.8, 5.9],    // Custom: minimum ratings
                'maxRatings' => [9.3, 9.8, 8.7, 9.1],    // Custom: maximum ratings
                'backgroundColor' => [...],
            ],
        ],
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr'],
    ];
}

// Access in formatter:
'formatter' => 'function(value, ctx) {
    var voters = ctx.dataset.voters[ctx.dataIndex] || 0;
    var min = ctx.dataset.minRatings[ctx.dataIndex];
    var max = ctx.dataset.maxRatings[ctx.dataIndex];
    return value.toFixed(1) + " (" + min + "-" + max + ")\\n" + voters + " voti";
}',
```

**Benefits:**
- Data stays with the dataset (DRY)
- No hardcoding values in JavaScript
- Easy to update from database queries
- Type-safe in PHP, accessible in JS

## Common mistakes

- **Plugin not loaded**: check NPM install, Vite input, and `FilamentAsset` registration.
- **Callbacks not working**: use `RawJs` in `getOptions()`.
- **Wrong object shape**: `labels` must be under `plugins.datalabels.labels` or `dataset.datalabels.labels`.
- **Labels overlap**: use different anchors (end vs center) for each label.
- **Duplicate asset registration**: Only register Chart.js plugins in `Modules/Chart`. Other modules should NOT register chart assets.

## Related Documentation

- [LimeSurvey Chart Widgets Complete Guide](../../Quaeris/docs/limesurvey-chart-widgets-complete-guide.md) - Monthly aggregation patterns for survey data
- [PDF Generation Workflow](../../Quaeris/docs/pdf-generation-workflow.md) - Embedding charts in PDF exports
- [Chart Widget Pattern](../../Quaeris/docs/chart-widget-pattern.md) - Question type aggregation patterns

---

**Last Updated:** January 2026
**Maintainer:** Laraxot Team + Claude Opus 4.5
