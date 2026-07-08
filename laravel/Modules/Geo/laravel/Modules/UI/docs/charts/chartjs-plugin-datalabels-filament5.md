# chartjs-plugin-datalabels with Filament 5 ChartWidget (multiple labels)

## Goal

Use `chartjs-plugin-datalabels` to render **multiple labels per slice/bar** in a Filament v5 `ChartWidget`, following the project standards:

- Filament v5 plugin registration via `window.filamentChartJsPlugins`
- Asset build via Vite
- Asset registration via `FilamentAsset`
- Chart configuration via `getOptions()` (use `RawJs` when you need JavaScript callbacks)

This guide is based on the official sample:

- [chartjs-plugin-datalabels – multiple labels sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html "chartjs-plugin-datalabels – multiple labels sample")

## What “multiple labels” means in chartjs-plugin-datalabels

`chartjs-plugin-datalabels` supports multiple labels by defining:

- global defaults under `options.plugins.datalabels`
- one or more named label definitions under `dataset.datalabels.labels.{name}`

Each named label can have its own:

- `align`, `anchor`, `offset`
- `font`, `color`, `backgroundColor`, `borderColor`, `borderWidth`, `borderRadius`, `padding`, `opacity`
- `formatter(value, ctx)` callback

## 0) Prerequisites (project-specific)

### Where this project already registers `chartjs-plugin-datalabels`

In this repo the Chart module already registers the JS asset for chart plugins in:

- `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`

**Project rule:** charts plugin assets are centralized in the Chart module.

Other modules/panels/themes should **not** duplicate the plugin registration or `FilamentAsset::register()` for `chart-js-plugins`.

and `chartjs-plugin-datalabels` is installed in:

- `Modules/Chart/package.json`

## 1) Install the plugin (NPM)

Run inside the Chart module:

```bash
npm install chartjs-plugin-datalabels --save-dev
```

## 2) Register the plugin for Filament v5 charts

Create or update the file that Filament will read:

- `resources/js/filament-chart-js-plugins.js`

Minimal registration:

```js
import ChartDataLabels from 'chartjs-plugin-datalabels'

window.filamentChartJsPlugins ??= []
window.filamentChartJsPlugins.push(ChartDataLabels)
```

Important:

- Always use `??=` before pushing.
- Do not overwrite the array.

## 3) Ensure Vite builds the plugin file

Ensure the plugin JS file is listed in the Vite `input`.

In this repo, Chart module bundle uses:

- `Modules/Chart/vite.config.js`

and already includes `resources/js/filament-chart-js-plugins.js`.

## 4) Ensure Filament loads the compiled asset

Filament must load the built asset. In this repo it is done in:

- `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`

via `FilamentAsset::register([...])` **in the Chart module provider**.

## 5) Configure multiple labels in a Filament ChartWidget

### Key idea

- Put *global defaults* in `plugins.datalabels`.
- Put *multiple label definitions* in `plugins.datalabels.labels` **or** at dataset level `datasets[n].datalabels.labels`.

The official sample uses dataset-level:

```js
datasets: [{
  datalabels: {
    labels: { index: {...}, name: {...}, value: {...} }
  }
}]
```

You can do the same in Filament by returning the correct array structures from `getData()` and `getOptions()`.

### When you need RawJs

If you need JavaScript callbacks (like `formatter: (value, ctx) => ...`), you must return a `RawJs` object from `getOptions()`.

Filament supports `RawJs` and will render it as-is.

### “Multiple labels” example (doughnut)

This example mirrors the official “multiple labels” sample:

- label #1: index (`#1`, `#2`, …)
- label #2: name (slice label)
- label #3: numeric value

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
```

Notes:

- The sample checks `ctx.active` (hover/active state). Keep it only if you want different labels on hover.
- In Chart.js, `dataset.backgroundColor` is often an array for doughnut/pie; the sample accesses `backgroundColor[ctx.dataIndex]`.

## 6) Common mistakes (and how to avoid them)

### Mistake: plugin not loaded

Symptoms:

- No datalabels are shown.

Fix checklist:

- Ensure `chartjs-plugin-datalabels` is installed in the bundle that builds assets.
- Ensure `resources/js/filament-chart-js-plugins.js` is built by Vite.
- Ensure the panel registers the asset via `FilamentAsset`.

### Mistake: using PHP array callbacks instead of RawJs

Symptoms:

- Filament renders JSON, but callbacks are strings or missing.

Fix:

- Use `RawJs::make('...')` for any options that contain JS functions.

### Mistake: wrong place for `labels`

Rules:

- Global defaults: `options.plugins.datalabels.*`
- Multiple labels definitions: `options.plugins.datalabels.labels.*` or `dataset.datalabels.labels.*`

If you define `labels` in the wrong place, nothing will render.

## 7) Background Styling Best Practices

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

## 8) Centered Positioning Strategy for Dual Labels

For enhanced UI/UX, use centered positioning with one label above and one below the bar instead of inside/outside positioning:

### Benefits of Centered Above & Below Positioning:
- **Better Visual Balance**: Labels are symmetrically positioned around the bar
- **Improved Readability**: Both labels have consistent positioning
- **Cleaner Layout**: No overlapping with colorful bar areas
- **Professional Appearance**: More polished visual presentation

### Implementation:
```php
'datalabels' => [
    'clip' => false,
    'clamp' => true,
    'labels' => [
        'value' => [  // Label centered above the bar
            'anchor' => 'end',              // Position at top of bar
            'align' => 'bottom',            // Align bottom edge to anchor point
            'offset' => 8,                  // Distance above the bar
            'color' => '#111827',           // Dark color for contrast
            'backgroundColor' => 'rgba(255, 255, 255, 0.95)', // White bg
            'borderRadius' => 4,            // Rounded corners
            'padding' => 4,                 // Spacing around text
            'font' => [
                'weight' => 'bold',
                'size' => 11,               // Slightly smaller for balance
            ],
            'formatter' => 'function(v) { return v || ""; }',
            'display' => 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }',
        ],
        'rank' => [  // Label centered below the bar
            'anchor' => 'end',              // Position at top of bar
            'align' => 'top',               // Align top edge to anchor point
            'offset' => -8,                 // Negative offset places below bar
            'color' => '#ffffff',           // Light text for dark background
            'backgroundColor' => 'rgba(75, 85, 99, 0.8)',   // Gray bg for contrast
            'borderRadius' => 4,            // Matching rounded corners
            'padding' => 4,                 // Matching spacing
            'font' => [
                'weight' => '600',
                'size' => 10,               // Smaller for secondary info
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

### Positioning Parameters Explained:
- `anchor: 'end'` positions labels at the end (top) of the bar
- `align: 'bottom'` aligns the value label to appear above the bar
- `align: 'top'` with `offset: -8` positions the rank label below the bar
- This creates a clean, professional appearance with consistent spacing

## 9) Where to document updates

- Main reference: `Modules/UI/docs/charts/chartjs-plugin-datalabels-filament5.md`
- Module-specific usage (Chart): `Modules/Chart/docs/`
- Theme-specific bundle notes (Zero): `Themes/Zero/docs/`
