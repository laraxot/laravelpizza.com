# Chart.js Datalabels Plugin Integration in Zero Theme

## Overview

This guide explains how to integrate the Chart.js datalabels plugin within the Zero theme system. The Zero theme serves as the default theme in the Laraxot system and provides the foundational styling and functionality for all other themes.

## Theme Configuration

### Installing the Plugin

First, install the datalabels plugin in the Zero theme:

```bash
cd laravel/Themes/Zero
npm install chartjs-plugin-datalabels --save-dev
```

### Registering the Plugin

Create or update the JavaScript file to register the datalabels plugin:

```javascript
// Themes/Zero/resources/js/chartjs-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Register with global scope for use in Filament widgets
window.ChartDataLabels = ChartDataLabels;

// Register the plugin globally or with specific charts
if (window.Chart) {
    window.Chart.register(ChartDataLabels);
}

// Add to Filament's plugin system if available
window.filamentChartJsPlugins = window.filamentChartJsPlugins || [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

### Vite Configuration

Update the Vite configuration to include the plugin file:

```javascript
// Themes/Zero/vite.config.js
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: "manifest.json",
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'themes/Zero',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/app.js'),
                resolve(__dirname, 'resources/js/chartjs-plugins.js'), // Add this line
            ],
            refresh: refreshPaths,
            refresh: true,
        }),
    ],
});
```

## CSS Styling for Datalabels

### Theme-Specific Styling

Create or update the CSS to support theme styling for datalabels:

```css
/* Themes/Zero/resources/css/app.css */
@import 'tailwindcss';
@import '../../../vendor/filament/support/resources/css/index.css';
@import '../../../vendor/filament/actions/resources/css/index.css';
@import '../../../vendor/filament/forms/resources/css/index.css';
@import '../../../vendor/filament/infolists/resources/css/index.css';
@import '../../../vendor/filament/notifications/resources/css/index.css';
@import '../../../vendor/filament/schemas/resources/css/index.css';
@import '../../../vendor/filament/tables/resources/css/index.css';
@import '../../../vendor/filament/widgets/resources/css/index.css';

/* Theme-specific datalabels styling */
.datalabels-hidden {
    display: none !important;
}

.chartjs-datalabel {
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Dark mode support */
.dark .chartjs-datalabel {
    text-shadow: 1px 1px 2px rgba(0,0,0,0.6);
}

/* Responsive datalabels */
@media (max-width: 768px) {
    .chartjs-datalabel {
        font-size: 10px !important;
    }
}

@variant dark (&:where(.dark, .dark *));
```

## JavaScript Utilities for Theme Integration

### Chart Configuration Utilities

Create utility functions to help configure charts with datalabels in the theme:

```javascript
// Themes/Zero/resources/js/utils/chart-utils.js
export class ChartUtils {
    /**
     * Apply theme-specific datalabels configuration to a chart
     */
    static applyThemeDatalabels(chart, options = {}) {
        const defaultOptions = {
            display: true,
            align: 'center',
            anchor: 'center',
            formatter: (value) => value,
            font: {
                weight: 'bold',
                size: 12,
            },
            color: '#fff',
        };

        const datalabelsOptions = {
            ...defaultOptions,
            ...options,
        };

        // Apply to chart options
        if (chart.options.plugins && chart.options.plugins.datalabels) {
            Object.assign(chart.options.plugins.datalabels, datalabelsOptions);
        } else {
            chart.options.plugins = chart.options.plugins || {};
            chart.options.plugins.datalabels = datalabelsOptions;
        }

        // Update the chart
        chart.update();
    }

    /**
     * Create percentage formatter for pie/doughnut charts
     */
    static createPercentageFormatter(dataset) {
        return (value, context) => {
            const total = dataset.data.reduce((sum, current) => sum + current, 0);
            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
            return `${percentage}%`;
        };
    }

    /**
     * Create contrast-aware color formatter
     */
    static createContrastAwareColorFormatter() {
        return (context) => {
            const backgroundColor = context.dataset.backgroundColor[context.dataIndex];
            if (typeof backgroundColor === 'string') {
                let r, g, b;

                if (backgroundColor.startsWith('rgba(') || backgroundColor.startsWith('rgb(')) {
                    const match = backgroundColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                    if (match) {
                        r = parseInt(match[1]);
                        g = parseInt(match[2]);
                        b = parseInt(match[3]);
                    }
                } else if (backgroundColor.startsWith('#')) {
                    let hex = backgroundColor.replace('#', '');
                    if (hex.length === 3) {
                        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                    }
                    r = parseInt(hex.substring(0,2), 16);
                    g = parseInt(hex.substring(2,4), 16);
                    b = parseInt(hex.substring(4,6), 16);
                }

                if (r !== undefined && g !== undefined && b !== undefined) {
                    const brightness = (r * 299 + g * 587 + b * 114) / 1000;
                    return brightness > 128 ? '#000' : '#fff';
                }
            }
            return '#fff';
        };
    }

    /**
     * Apply conditional display based on data count
     */
    static applyConditionalDisplay(chart) {
        // Check if there are too many data points
        let dataCount = 0;
        if (chart.data.datasets && chart.data.datasets.length > 0) {
            dataCount = chart.data.datasets[0].data.length;
        }

        if (dataCount > 20) {
            // Too many points, disable datalabels
            if (chart.options.plugins && chart.options.plugins.datalabels) {
                chart.options.plugins.datalabels.display = false;
            }
        } else if (dataCount > 10) {
            // Many points, show on hover only
            if (chart.options.plugins && chart.options.plugins.datalabels) {
                chart.options.plugins.datalabels.display = (context) => context.active;
            }
        }
    }
}
```

### Theme Initialization

Initialize theme-specific chart configurations:

```javascript
// Themes/Zero/resources/js/app.js
import './bootstrap';
import './chartjs-plugins';
import { ChartUtils } from './utils/chart-utils';

// Initialize theme-specific chart configurations
document.addEventListener('DOMContentLoaded', function() {
    // Set up global Chart.js defaults for the theme
    if (window.Chart) {
        // Apply theme defaults
        window.Chart.defaults.font.family = "'Inter', sans-serif";
        window.Chart.defaults.plugins.tooltip.titleFont = {
            family: "'Inter', sans-serif",
            size: 12,
        };
        window.Chart.defaults.plugins.tooltip.bodyFont = {
            family: "'Inter', sans-serif",
            size: 12,
        };
    }

    // Listen for chart creation events to apply theme configurations
    window.addEventListener('filament-chart-initialized', function(e) {
        const chart = e.detail.chart;
        
        // Apply theme-specific datalabels configuration
        if (chart.options.type === 'doughnut' || chart.options.type === 'pie') {
            ChartUtils.applyThemeDatalabels(chart, {
                align: 'end',
                anchor: 'end',
                formatter: ChartUtils.createPercentageFormatter(chart.data.datasets[0]),
                color: ChartUtils.createContrastAwareColorFormatter(),
            });
        } else {
            ChartUtils.applyThemeDatalabels(chart, {
                align: 'top',
                anchor: 'end',
                formatter: (value) => value,
                color: '#333',
            });
        }
        
        // Apply conditional display for performance
        ChartUtils.applyConditionalDisplay(chart);
        
        // Update the chart
        chart.update();
    });
});

// Custom event for when a chart is initialized by Filament
window.initializeChartWithTheme = function(chart) {
    // Dispatch custom event for theme initialization
    window.dispatchEvent(new CustomEvent('filament-chart-initialized', {
        detail: { chart: chart }
    }));
};
```

## Blade Component Integration

### Theme-Specific Chart Component

Create a Blade component that provides theme-specific chart rendering:

```php
<!-- Themes/Zero/resources/views/components/chart.blade.php -->
@props([
    'type' => 'bar',
    'data' => [],
    'options' => [],
    'height' => '300px',
    'showDatalabels' => true,
    'datalabelsOptions' => [],
])

<div 
    {{ $attributes->class(['chart-container']) }}
    style="height: {{ $height }};"
    x-data="{
        chart: null,
        init() {
            const ctx = this.$refs.canvas.getContext('2d');
            const chartData = @js($data);
            const chartOptions = @js($options);
            
            // Merge with theme defaults
            const themeOptions = this.getThemeOptions();
            const finalOptions = this.mergeOptions(chartOptions, themeOptions);
            
            this.chart = new Chart(ctx, {
                type: '{{ $type }}',
                data: chartData,
                options: finalOptions
            });
            
            // Initialize with theme
            if (typeof window.initializeChartWithTheme === 'function') {
                window.initializeChartWithTheme(this.chart);
            }
        },
        getThemeOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                    @if($showDatalabels)
                    datalabels: @js($datalabelsOptions) || {
                        display: true,
                        align: 'center',
                        anchor: 'center',
                        formatter: (value) => value,
                        font: {
                            weight: 'bold',
                            size: 12,
                        },
                        color: '#fff',
                    }
                    @endif
                }
            };
        },
        mergeOptions: function(options, themeOptions) {
            // Deep merge options with theme defaults
            const result = {...themeOptions, ...options};
            if (options.plugins) {
                result.plugins = {...result.plugins, ...options.plugins};
            }
            return result;
        }
    }"
>
    <canvas x-ref="canvas"></canvas>
</div>
```

### Usage Examples

```blade
<!-- Example usage in a theme view -->
<x-theme::chart 
    type="doughnut"
    :data="$chartData"
    :options="$chartOptions"
    height="400px"
    :show-datalabels="true"
    :datalabels-options="[
        'align' => 'end',
        'anchor' => 'end',
        'formatter' => 'function(value, context) {
            var dataset = context.dataset;
            var total = dataset.data.reduce(function(sum, current) {
                return sum + current;
            }, 0);
            var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
            return percentage + \"%\";
        }',
        'color' => '#fff',
        'font' => ['weight' => 'bold', 'size' => 12],
    ]"
/>
```

## Integration with Filament Widgets

### Theme-Aware ChartWidget

The theme can enhance Filament ChartWidgets by providing additional configuration:

```javascript
// Themes/Zero/resources/js/filament-chart-enhancements.js
document.addEventListener('DOMContentLoaded', function() {
    // Enhance Filament ChartWidgets with theme-specific configurations
    if (typeof Livewire === 'object') {
        Livewire.on('chart-mounted', (component) => {
            // Apply theme enhancements when a chart is mounted
            const chartElement = document.querySelector(`[data-chart-component="${component.id}"]`);
            if (chartElement && chartElement.chart) {
                // Apply theme defaults
                if (chartElement.chart.options.plugins && chartElement.chart.options.plugins.datalabels) {
                    // Enhance existing datalabels configuration
                    chartElement.chart.options.plugins.datalabels.font = {
                        ...chartElement.chart.options.plugins.datalabels.font,
                        family: "'Inter', sans-serif",
                    };
                }
                
                chartElement.chart.update();
            }
        });
    }
});
```

## Dark Mode Support

### Dark Mode Configuration

Provide different datalabels configurations for dark mode:

```javascript
// Themes/Zero/resources/js/theme-colors.js
export class ThemeColors {
    static getDatalabelsColor(isDarkMode = false) {
        return isDarkMode ? '#fff' : '#000';
    }

    static getDatalabelsBackgroundColor(isDarkMode = false) {
        return isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    }

    static getContrastAwareFormatter(isDarkMode = false) {
        return (context) => {
            const backgroundColor = context.dataset.backgroundColor[context.dataIndex];
            // Implementation similar to previous examples
            // but adapted for theme's dark mode preferences
            if (typeof backgroundColor === 'string') {
                // Color brightness calculation logic
                // Return appropriate color based on background and theme mode
            }
            return isDarkMode ? '#fff' : '#000';
        };
    }
}
```

## Performance Optimizations

### Theme-Specific Optimizations

Implement performance optimizations specific to the Zero theme:

```javascript
// Themes/Zero/resources/js/chart-performance.js
export class ChartPerformance {
    /**
     * Optimize chart rendering based on viewport and data size
     */
    static optimizeChart(chart) {
        const dataCount = chart.data.datasets[0]?.data.length || 0;
        
        if (dataCount > 20) {
            // Disable datalabels for large datasets
            if (chart.options.plugins?.datalabels) {
                chart.options.plugins.datalabels.display = false;
            }
        } else if (dataCount > 10) {
            // Show datalabels only on hover for medium datasets
            if (chart.options.plugins?.datalabels) {
                chart.options.plugins.datalabels.display = (ctx) => ctx.active;
            }
        }
        
        // Update chart with optimized options
        chart.update();
    }
    
    /**
     * Lazy load charts that are not in viewport
     */
    static lazyLoadCharts() {
        const chartObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const chart = entry.target.chart;
                    if (chart && !chart.data.labels.length) {
                        // Load chart data when it comes into view
                        // This prevents unnecessary loading of charts
                        // that are not immediately visible
                    }
                }
            });
        });
        
        document.querySelectorAll('[data-chart]').forEach(chartEl => {
            chartObserver.observe(chartEl);
        });
    }
}
```

## Complete Integration Example

Here's how to integrate everything together in a complete example:

```javascript
// Themes/Zero/resources/js/main.js
import './bootstrap';
import { ChartUtils } from './utils/chart-utils';
import { ThemeColors } from './theme-colors';
import { ChartPerformance } from './chart-performance';

// Initialize all theme-specific chart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Set up theme defaults
    if (window.Chart) {
        // Register plugin
        if (window.ChartDataLabels) {
            window.Chart.register(window.ChartDataLabels);
        }
        
        // Set theme defaults
        window.Chart.defaults.plugins.datalabels = {
            display: true,
            align: 'center',
            anchor: 'center',
            font: {
                family: "'Inter', sans-serif",
                weight: 'bold',
                size: 12,
            },
            color: ThemeColors.getDatalabelsColor(document.documentElement.classList.contains('dark')),
        };
    }
    
    // Set up performance optimizations
    ChartPerformance.lazyLoadCharts();
    
    // Listen for Filament chart initialization
    document.addEventListener('filament-chart-initialized', function(e) {
        const chart = e.detail.chart;
        
        // Apply performance optimizations
        ChartPerformance.optimizeChart(chart);
        
        // Apply theme-specific configurations
        // This would typically happen in the XotBaseChartWidget
        // but can be enhanced at the theme level
    });
});
```

## Testing and Validation

### Theme-Specific Tests

Create theme-specific tests to ensure datalabels work correctly:

```javascript
// Themes/Zero/tests/js/chart-integration.test.js
describe('Theme Chart Integration', () => {
    test('datalabels plugin is registered', () => {
        expect(window.ChartDataLabels).toBeDefined();
        expect(window.ChartDataLabels.id).toBe('datalabels');
    });
    
    test('theme defaults are applied', () => {
        const config = window.Chart.defaults.plugins.datalabels;
        expect(config.font.family).toContain('Inter');
        expect(config.font.weight).toBe('bold');
    });
    
    test('dark mode colors work', () => {
        const isDarkMode = true;
        const color = ThemeColors.getDatalabelsColor(isDarkMode);
        expect(color).toBe('#fff');
    });
});
```

## Best Practices for Theme Integration

1. **Consistency**: Ensure all charts in the theme use consistent styling and behavior
2. **Performance**: Implement optimizations for large datasets and multiple charts
3. **Accessibility**: Ensure datalabels have sufficient contrast in both light and dark modes
4. **Flexibility**: Provide configuration options while maintaining theme defaults
5. **Maintainability**: Keep theme-specific code separate from module-specific code
6. **Compatibility**: Ensure the theme works with all chart types and datalabels configurations
7. **Documentation**: Provide clear documentation for developers using the theme