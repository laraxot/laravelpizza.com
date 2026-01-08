# Filament Chart.js Guide

> **Why this guide?**: To standardize how we use Chart.js in Filament, especially regarding advanced features like plugins (Zoom, Annotations) which are not enabled by default.

## 1. Basic Usage (Filament Standard)

Filament wraps Chart.js. Always use `XotBaseWidget` if available, or standard Filament `ChartWidget`.

```php
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

## 2. Advanced: Using Plugins (Zoom, Annotation)

Filament doesn't bundler all Chart.js plugins. To use them, you must register them via a custom JavaScript file.

### Step 1: Install Plugins

```bash
npm install chartjs-plugin-zoom chartjs-plugin-annotation
```

### Step 2: Register in `resources/js/app.js`

You need to import and register the plugins globally or specifically.

```javascript
import Chart from 'chart.js/auto';
import zoomPlugin from 'chartjs-plugin-zoom';
import annotationPlugin from 'chartjs-plugin-annotation';

Chart.register(zoomPlugin, annotationPlugin);
```

### Step 3: Configure in PHP Widget

Pass the options in the `getOptions()` method.

```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'zoom' => [
                'zoom' => [
                    'wheel' => ['enabled' => true],
                    'pinch' => ['enabled' => true],
                    'mode' => 'xy',
                ],
                'pan' => [
                    'enabled' => true,
                    'mode' => 'xy',
                ],
            ],
            'annotation' => [
                'annotations' => [
                    'line1' => [
                        'type' => 'line',
                        'yMin' => 60,
                        'yMax' => 60,
                        'borderColor' => 'rgb(255, 99, 132)',
                        'borderWidth' => 2,
                    ],
                ],
            ],
        ],
    ];
}
```

## 3. Best Practices

-   **Lazy Loading**: Enabled by default in Filament. Keep it.
-   **Colors**: Use Filament's color system or CSS variables rather than hardcoded hex codes to support Dark Mode.
-   **Data Loading**: Use `polling` sparingly to avoid server load.

---
**See Also**: [Export Strategy](./export-strategy.md)
