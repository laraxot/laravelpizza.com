# Chart Generation Actions - Theme Integration

## Overview

This document describes how to integrate chart generation actions within the Laraxot PTVX theme system. Themes provide the visual presentation layer and can include chart display components that consume generated SVG/PNG charts.

## Theme-Specific Chart Components

### Chart Display Component

```php
<?php

declare(strict_types=1);

namespace Themes\One\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

/**
 * Chart display component for themes.
 */
class Chart extends Component
{
    public function __construct(
        public readonly string $src,
        public readonly string $alt = '',
        public readonly string $class = '',
        public readonly ?int $width = null,
        public readonly ?int $height = null,
    ) {}

    public function render(): View
    {
        return view('themes::components.chart');
    }
}
```

### Chart Component Blade Template

```blade
{{-- resources/themes/One/views/components/chart.blade.php --}}
@php
    $extension = pathinfo($src, PATHINFO_EXTENSION);
    $isSvg = strtolower($extension) === 'svg';
@endphp

@if($isSvg)
    {{-- Display SVG inline for better performance --}}
    <div class="chart-container {{ $class }}"
         @if($width) style="width: {{ $width }}px;" @endif
         @if($height) style="height: {{ $height }}px;" @endif>
        {!! file_get_contents(public_path($src)) !!}
    </div>
@else
    {{-- Display PNG/JPG as image --}}
    <img src="{{ asset($src) }}"
         alt="{{ $alt }}"
         class="chart-image {{ $class }}"
         @if($width) width="{{ $width }}" @endif
         @if($height) height="{{ $height }}" @endif
         loading="lazy">
@endif
```

## Theme Integration Patterns

### Dashboard with Charts

```php
<?php

declare(strict_types=1);

namespace Themes\One\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Generate performance chart
        $chartData = new ChartData(
            id: 'dashboard_performance_' . now()->format('Y_m_d_H_i'),
            labels: ['Current Month', 'Last Month', '2 Months Ago'],
            values: $this->getPerformanceData()
        );

        $action = app(GenerateSvgChartAction::class);
        $chartResult = $action->execute($chartData);

        return view('themes::dashboard.index', [
            'performance_chart_url' => $chartResult->url,
            'performance_data' => $this->getPerformanceData(),
        ]);
    }

    private function getPerformanceData(): array
    {
        // Get current user's performance data
        return [85, 78, 92];
    }
}
```

### Chart Widget for Theme

```php
<?php

declare(strict_types=1);

namespace Themes\One\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Modules\Performance\Actions\GeneratePngChartAction;
use Modules\Performance\Data\ChartData;

/**
 * Performance chart widget component.
 */
class PerformanceChart extends Component
{
    public function __construct(
        public readonly array $data = [],
        public readonly string $type = 'bar',
        public readonly array $options = []
    ) {}

    public function render(): View
    {
        // Generate chart on demand
        $chartUrl = $this->generateChart();

        return view('themes::components.performance-chart', [
            'chart_url' => $chartUrl,
            'data' => $this->data,
        ]);
    }

    private function generateChart(): string
    {
        if (empty($this->data)) {
            return '';
        }

        $chartData = new ChartData(
            id: 'widget_' . md5(serialize($this->data)),
            labels: $this->data['labels'] ?? [],
            values: $this->data['values'] ?? []
        );

        $action = app(GeneratePngChartAction::class);
        $result = $action->execute($chartData);

        return $result->url;
    }
}
```

## Theme Blade Templates

### Dashboard Template

```blade
{{-- resources/themes/One/views/dashboard/index.blade.php --}}
@extends('themes::layouts.app')

@section('content')
<div class="dashboard">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Performance Overview</h5>
                </div>
                <div class="card-body">
                    {{-- Use theme chart component --}}
                    <x-theme-chart
                        :src="$performance_chart_url"
                        alt="Performance Chart"
                        class="w-100"
                    />
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="stat-label">Current Score:</span>
                        <span class="stat-value">{{ end($performance_data) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Trend:</span>
                        <span class="stat-value text-success">↗️ Improving</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

### Chart Widget Template

```blade
{{-- resources/themes/One/views/components/performance-chart.blade.php --}}
<div class="performance-chart-widget">
    <div class="chart-header">
        <h6>Performance Metrics</h6>
        <div class="chart-controls">
            <button class="btn btn-sm btn-outline-primary" onclick="refreshChart()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <div class="chart-container">
        @if($chart_url)
            <x-theme-chart
                :src="$chart_url"
                alt="Performance Chart"
                class="performance-chart"
                width="400"
                height="300"
            />
        @else
            <div class="chart-placeholder">
                <i class="fas fa-chart-bar fa-3x text-muted"></i>
                <p class="text-muted mt-2">No data available</p>
            </div>
        @endif
    </div>

    @if(!empty($data))
        <div class="chart-data mt-3">
            <small class="text-muted">
                Last updated: {{ now()->format('M j, Y g:i A') }}
            </small>
        </div>
    @endif
</div>

<script>
function refreshChart() {
    // Refresh chart logic
    location.reload();
}
</script>
```

## Theme Configuration

### Theme Config File

```php
<?php

// config/themes.php
return [
    'One' => [
        'name' => 'One Theme',
        'version' => '1.0.0',
        'charts' => [
            'default_format' => 'svg', // svg or png
            'cache_enabled' => true,
            'cache_ttl' => 3600, // 1 hour
            'max_width' => 1200,
            'max_height' => 800,
            'supported_types' => ['bar', 'line', 'pie', 'doughnut'],
        ],
        'colors' => [
            'primary' => '#007bff',
            'success' => '#28a745',
            'danger' => '#dc3545',
            'warning' => '#ffc107',
            'info' => '#17a2b8',
        ],
    ],
];
```

## Chart Caching Strategy

### Theme-Level Caching

```php
<?php

declare(strict_types=1);

namespace Themes\One\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

/**
 * Chart caching service for themes.
 */
class ChartCacheService
{
    private const CACHE_PREFIX = 'theme_chart_';
    private const CACHE_TTL = 3600; // 1 hour

    public function getOrGenerateChart(string $cacheKey, ChartData $data, string $type = 'bar'): string
    {
        $fullKey = self::CACHE_PREFIX . $cacheKey;

        return Cache::remember($fullKey, self::CACHE_TTL, function () use ($data, $type) {
            $action = app(GenerateSvgChartAction::class);
            $result = $action->execute($data);
            return $result->url;
        });
    }

    public function invalidateChart(string $cacheKey): void
    {
        $fullKey = self::CACHE_PREFIX . $cacheKey;
        Cache::forget($fullKey);
    }

    public function invalidateAllCharts(): void
    {
        // Clear all theme chart cache
        Cache::flush();
    }
}
```

## Theme Assets Integration

### Chart CSS Styles

```css
/* resources/themes/One/assets/css/charts.css */
.chart-container {
    position: relative;
    display: inline-block;
    max-width: 100%;
    margin: 1rem 0;
}

.chart-container svg {
    width: 100%;
    height: auto;
    max-width: 100%;
}

.chart-image {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.performance-chart-widget {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    overflow: hidden;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.chart-container {
    padding: 1rem;
}

.chart-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #6c757d;
}
```

### Chart JavaScript

```javascript
// resources/themes/One/assets/js/charts.js
class ThemeChartManager {
    constructor() {
        this.charts = new Map();
    }

    async loadChart(containerId, chartUrl) {
        const container = document.getElementById(containerId);
        if (!container) return;

        try {
            const response = await fetch(chartUrl);
            const content = await response.text();

            // Check if it's SVG
            if (content.includes('<svg')) {
                container.innerHTML = content;
                this.initializeSvgInteractivity(container);
            } else {
                // Handle PNG/JPG
                const img = document.createElement('img');
                img.src = chartUrl;
                img.alt = 'Chart';
                img.className = 'chart-image';
                container.appendChild(img);
            }

            this.charts.set(containerId, { url: chartUrl, loaded: true });
        } catch (error) {
            console.error('Failed to load chart:', error);
            container.innerHTML = '<p class="text-muted">Failed to load chart</p>';
        }
    }

    initializeSvgInteractivity(container) {
        // Add hover effects, tooltips, etc. for SVG charts
        const paths = container.querySelectorAll('path, rect, circle');
        paths.forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                e.target.style.opacity = '0.8';
            });
            element.addEventListener('mouseleave', (e) => {
                e.target.style.opacity = '1';
            });
        });
    }

    refreshChart(containerId) {
        const chart = this.charts.get(containerId);
        if (chart) {
            this.loadChart(containerId, chart.url);
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    window.themeChartManager = new ThemeChartManager();
});
```

## Usage in Theme Templates

### Including Charts in Blade

```blade
{{-- Example usage in theme template --}}
<div id="performance-chart-container">
    <x-theme-performance-chart
        :data="[
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'values' => [65, 59, 80, 81, 56, 55]
        ]"
        type="line"
        :options="['width' => 600, 'height' => 400]"
    />
</div>

{{-- Manual chart loading --}}
<div id="custom-chart"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.themeChartManager.loadChart('custom-chart', '{{ $chart_url }}');
});
</script>
```

## Best Practices for Theme Integration

1. **Lazy Loading**: Load charts only when needed to improve page performance
2. **Caching**: Use theme-level caching to avoid regenerating charts frequently
3. **Responsive Design**: Ensure charts work well on different screen sizes
4. **Accessibility**: Add proper alt texts and ARIA labels for screen readers
5. **Progressive Enhancement**: Provide fallback content when JavaScript is disabled
6. **Error Handling**: Display user-friendly messages when chart generation fails

## File Structure

```
Themes/One/
├── assets/
│   ├── css/
│   │   └── charts.css
│   └── js/
│       └── charts.js
├── resources/
│   └── views/
│       ├── components/
│       │   ├── chart.blade.php
│       │   └── performance-chart.blade.php
│       └── dashboard/
│           └── index.blade.php
├── src/
│   ├── View/
│   │   └── Components/
│   │       ├── Chart.php
│   │       └── PerformanceChart.php
│   └── Services/
│       └── ChartCacheService.php
└── docs/
    └── charts/
        └── theme-integration.md
```

*Last updated: December 2025*
