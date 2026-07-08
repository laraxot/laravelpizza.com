# chartjs-plugin-datalabels with Filament 5 ChartWidget (multiple labels)

## Scope

This guide explains how to use `chartjs-plugin-datalabels` with Filament v5 chart widgets in the **Zero theme** context.

Reference samples:

- [chartjs-plugin-datalabels – multiple labels sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)
- [chartjs-plugin-datalabels – Doughnut (sorgente)](https://github.com/chartjs/chartjs-plugin-datalabels/blob/master/docs/samples/charts/doughnut.md) / [Demo Doughnut](https://chartjs-plugin-datalabels.netlify.app/samples/charts/doughnut.html) – per grafici radiali (anchor, display, formatter globale)

## Golden rules (Filament v5)

- Register plugins via `window.filamentChartJsPlugins` (or `window.filamentChartJsGlobalPlugins`).
- Ensure the JS file is built by Vite.
- Ensure the JS file is loaded by Filament (via `FilamentAsset`).
- Use `RawJs` in `getOptions()` when you need JS callbacks.

## 1) Install (NPM)

Run inside the theme package that builds your frontend assets.

In this repo, Zero theme assets live under:

- `laravel/Themes/Zero/`

```bash
npm install chartjs-plugin-datalabels --save-dev
```

## 2) Register the plugin for Filament charts

Create or update a dedicated JS file for Filament charts (do not hide this inside generic services):

- `Themes/Zero/resources/js/filament-chart-js-plugins.js`

```js
import ChartDataLabels from 'chartjs-plugin-datalabels'

window.filamentChartJsPlugins ??= []
window.filamentChartJsPlugins.push(ChartDataLabels)
```

Important:

- Do **not** overwrite the array.
- Multiple bundles/plugins may push into it.

## 3) Build with Vite

Ensure the JS file is included in your theme Vite `input` list.

## 4) Make Filament load the built asset

Your Filament panel/provider must register the built JS file with `FilamentAsset`.

If you do not have a theme-specific PanelProvider, the safest approach in this repo is to register via the Chart module panel/provider (when the Chart module is the one building and providing `filament-chart-js-plugins.js`).

## 5) Configure multiple labels in the widget

### Key idea

- Global defaults: `plugins.datalabels.*`
- Multiple named labels: `plugins.datalabels.labels.{name}` or `dataset.datalabels.labels.{name}`

### Example (RawJs options)

Use the same `getOptions()` structure as the official sample.

If you need callbacks, always use `RawJs`.

## Dual Labels Example (DRY/KISS)

For a minimal, production-ready example showing 2 labels per bar, see:

**`Modules/healthcare_app/Filament/Widgets/SimpleChartWidget.php`**

```php
protected function getOptions(): RawJs
{
    return RawJs::make(<<<'JS'
{
  plugins: {
    datalabels: {
      labels: {
        value: {
          anchor: 'end', align: 'top',
          formatter: function(v) { return v || ''; }
        },
        percent: {
          anchor: 'center', align: 'center',
          formatter: function(v, ctx) {
            var d = ctx.dataset.data || [];
            var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
            return (t && v && (v/t) >= 0.03) ? Math.round((v/t)*100) + '%' : '';
          }
        }
      }
    }
  }
}
JS);
}
```

## Common mistakes

- **Seeing no labels**: plugin not loaded (Vite input missing or FilamentAsset registration missing).
- **Trying to register via Chart.register() inside app.js**: avoid; Filament v5 plugin system should use `window.filamentChartJsPlugins`.
- **Using PHP arrays with string functions**: JS callbacks don't execute as strings. Always use `RawJs::make()`.
