# Filament Installation and Chart Widget Integration Guide for Zero Theme

## Overview

This document provides comprehensive guidance on integrating Filament 5.x components and ChartWidgets with the Zero theme, following Laraxot architectural patterns and best practices for frontend asset management.

## Filament Installation Requirements

The Zero theme supports Filament 5.x integration with:
- PHP 8.2+
- Laravel v11.28+
- Tailwind CSS v4.1+
- Filament v5.0+
- Chart.js v4.4.0+

### Required Dependencies

Install core Filament components:
```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
```

Chart.js plugins and related assets are managed centrally by `Modules/Chart`. Themes should not install or bundle Chart.js plugins.

## Theme Asset Integration

### Package.json Configuration

The theme should not own Chart.js plugin dependencies. If a new plugin is needed, add it in `Modules/Chart` (dependencies + Vite input + Filament asset registration).

### Vite Configuration

Configure Vite to handle Filament and Chart.js assets:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/services/chartjs-base-service.js'
            ],
            publicDirectory: '../../../public_html',
            buildDirectory: 'themes/Zero',
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

## Chart.js Service Integration

### Base Chart Service

Create a base service for Chart.js operations in the theme:

```javascript
// Themes/Zero/resources/js/services/chartjs-base-service.js
export class ChartJsBaseService {
    constructor() {
        this.charts = new Map();
    }

    createChart(canvasId, config) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error(`Canvas element with id "${canvasId}" not found`);
            return null;
        }

        // Import Chart.js dynamically to ensure it's available
        import('chart.js/auto').then(({ default Chart }) => {
            const chart = new Chart(canvas, config);
            this.charts.set(canvasId, chart);
            return chart;
        }).catch(err => {
            console.error('Failed to load Chart.js:', err);
        });

        return null;
    }

    destroyChart(canvasId) {
        const chart = this.charts.get(canvasId);
        if (chart) {
            chart.destroy();
            this.charts.delete(canvasId);
        }
    }

    updateChart(canvasId, config) {
        const chart = this.charts.get(canvasId);
        if (chart) {
            chart.data = config.data;
            if (config.options) {
                chart.options = config.options;
            }
            chart.update();
        }
    }
}

// Make the service globally available
window.ChartJsBaseService = window.ChartJsBaseService || ChartJsBaseService;
```

### Chart.js Plugin Registration

**Project rule (healthcare_app Fila5):** Chart.js plugin assets are centralized in the Chart module.

The Zero theme must **not** register `chartjs-plugin-datalabels` (or other Chart.js plugins) via its own bundle.
It consumes the plugins that are already registered for Filament charts by the Chart module.

```javascript
// Themes/Zero/resources/js/filament-plugins.js
// Do not register Chart.js plugins here.
```

## CSS Integration

### Chart Styling in Theme

Include Chart.js styles in the theme CSS:

```css
/* Themes/Zero/resources/css/app.css */
@import 'tailwindcss';
@import '../../../../vendor/filament/support/resources/css/index.css';
@import '../../../../vendor/filament/widgets/resources/css/index.css';

/* Theme-specific chart styling */
.filament-chart-container {
    @apply bg-white rounded-lg shadow p-6;
}

.filament-chart {
    @apply w-full h-80;
}

/* Dark mode support for charts */
@layer utilities {
    .dark .filament-chart-container {
        @apply bg-gray-800;
    }
}
```

## Theme Asset Build Process

### Build Scripts

The Zero theme includes specific build scripts:

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "copy": "cp -r ./public/* ../../../public_html/themes/Zero"
  }
}
```

### Copy Assets to Public Directory

After building, copy theme assets to the public directory:

```bash
npm run build
npm run copy
```

## Integration with Filament Components

### Chart Widget Template

Create a template for rendering ChartWidgets in the theme:

```blade
{{-- Themes/Zero/resources/views/components/filament/chart-widget.blade.php --}}
<div class="filament-chart-container">
    <canvas id="{{ $chartId }}" width="400" height="400"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartService = new window.ChartJsBaseService();
    
    // Initialize chart with provided config
    chartService.createChart('{{ $chartId }}', {
        type: '{{ $type }}',
        data: {!! json_encode($data) !!},
        options: {!! json_encode($options) !!}
    });
});
</script>
```

### Theme Layout Integration

Integrate Filament styles and scripts in the theme layout:

```blade
{{-- Themes/Zero/resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <style>[x-cloak] { display: none !important; }</style>
    
    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
    {{ $slot }}
    
    @livewire('notifications')
    @filamentScripts
    @vite(['resources/js/app.js', 'resources/js/services/chartjs-base-service.js'])
</body>
</html>
```

## Chart Widget Configuration in Theme Context

### Theme-specific Chart Options

Configure charts with theme-specific styling:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\ChartWidget;

abstract class XotBaseChartWidget extends ChartWidget
{
    // Theme-specific chart options
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'color' => 'rgb(107, 114, 128)', // Tailwind gray-600
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(17, 24, 39, 0.8)', // Tailwind gray-900
                    'titleColor' => 'rgb(255, 255, 255)', // White
                    'bodyColor' => 'rgb(255, 255, 255)', // White
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'color' => 'rgba(229, 231, 235, 0.5)', // Tailwind gray-200
                    ],
                    'ticks' => [
                        'color' => 'rgb(107, 114, 128)', // Tailwind gray-600
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => 'rgba(229, 231, 235, 0.5)', // Tailwind gray-200
                    ],
                    'ticks' => [
                        'color' => 'rgb(107, 114, 128)', // Tailwind gray-600
                    ],
                ],
            ],
        ];
    }
}
```

## Performance Optimization

### Lazy Loading for Charts

Enable lazy loading in theme:

```javascript
// Themes/Zero/resources/js/chart-lazy-loader.js
export class ChartLazyLoader {
    constructor() {
        this.observer = new IntersectionObserver(
            this.handleIntersection.bind(this),
            { threshold: 0.1 }
        );
    }

    observe(chartElement) {
        this.observer.observe(chartElement);
    }

    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const chartId = entry.target.dataset.chartId;
                this.initializeChart(chartId);
                this.observer.unobserve(entry.target);
            }
        });
    }

    initializeChart(chartId) {
        // Initialize chart when it comes into view
        const config = JSON.parse(document.getElementById(chartId).dataset.config);
        const chartService = new window.ChartJsBaseService();
        chartService.createChart(chartId, config);
    }
}
```

### Asset Optimization

Optimize theme assets for performance:

```javascript
// vite.config.js
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Keep chart/plugin assets centralized in Modules/Chart.
                }
            }
        }
    },
    // ... other config
});
```

## Security Considerations

### Content Security Policy

Configure CSP for Chart.js assets:

```php
// In theme service provider
public function boot()
{
    View::composer('*', function ($view) {
        if ($view->getName() !== 'theme::layouts.app') {
            return;
        }
        
        // Add CSP headers for Chart.js
        $response = response();
        $response->header('Content-Security-Policy', "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net; object-src 'none';");
    });
}
```

### Data Sanitization

Sanitize chart data in theme views:

```blade
{{-- Safe data rendering --}}
<script>
    const chartData = @json($sanitizedData);
    // Use JSON data directly, avoiding potential XSS
</script>
```

## Chart Widget Anti-Patterns (da evitare)

**QuestionChartAnswersTripleChartWidget** è un anti-pattern totale: un widget che contiene 3 grafici invece di usare 3 widget separati. Viola DRY, KISS, Single Responsibility e le convenzioni del progetto (estende `Widget` invece di `XotBaseChartWidget`, usa RawJs in modo errato).

**Non usare questo approccio.** La soluzione corretta è **3 widget separati** nella griglia della pagina Filament.

- [Anti-Pattern completo](../../Modules/docs/anti-pattern-question-chart-answers-triple-widget.md)
- [Anti-Pattern <nome progetto>](../../Modules/<nome progetto>/docs/anti-pattern-triple-chart-widget.md)

## Testing the Integration

### Theme Asset Tests

Create tests to verify theme integration:

```javascript
// Tests for theme asset integration
it('loads Chart.js in theme context', () => {
    expect(window.Chart).toBeDefined();
});

it('registers Filament plugins globally', () => {
    expect(window.filamentChartJsPlugins).toBeDefined();
    expect(Array.isArray(window.filamentChartJsPlugins)).toBe(true);
});
```

This guide provides comprehensive instructions for integrating Filament 5.x ChartWidgets with the Zero theme, ensuring proper asset management, performance optimization, and security practices.