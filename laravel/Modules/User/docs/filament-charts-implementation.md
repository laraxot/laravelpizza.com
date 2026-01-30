# Filament Installation and Chart Widget Implementation Guide

## Overview

This document provides guidance on implementing Filament 5.x components and ChartWidgets in the User module, following Laraxot architectural patterns and best practices.

## Filament Installation Requirements

The User module follows the standard Filament 5.x installation requirements:
- PHP 8.2+
- Laravel v11.28+
- Tailwind CSS v4.1+
- Filament v5.0+

### Required Dependencies

Install core Filament components:
```bash
composer require filament/filament:"^5.0"
php artisan filament:install --panels
```

For ChartWidgets, install additional dependencies:
```bash
npm install chart.js chartjs-plugin-datalabels --save-dev
```

## User Module ChartWidgets

### User Registration Trends Chart

The User module can implement various chart widgets to visualize user data:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UserRegistrationTrendsChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'User Registration Trends';

    protected function getData(): array
    {
        // Fetch user registration data from database
        $users = \Modules\User\Models\User::selectRaw(
            'DATE(created_at) as date, COUNT(*) as count'
        )
        ->where('created_at', '>', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $users->pluck('count')->toArray(),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $users->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### User Type Distribution Chart

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UserTypeDistributionChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'User Type Distribution';

    protected function getData(): array
    {
        // Fetch user type distribution data
        $userTypes = \Modules\User\Models\User::selectRaw(
            'type, COUNT(*) as count'
        )
        ->groupBy('type')
        ->get();

        return [
            'datasets' => [
                [
                    'label' => 'User Types',
                    'data' => $userTypes->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444'
                    ],
                ],
            ],
            'labels' => $userTypes->pluck('type')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
```

## Implementation Rules for User Module

### 1. ChartWidget Extension Rule
❌ **WRONG**: `extends ChartWidget`
```php
use Filament\Widgets\ChartWidget;

class UserChartWidget extends ChartWidget { }
```

✅ **CORRECT**: `extends XotBaseChartWidget`
```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UserChartWidget extends XotBaseChartWidget { }
```

### 2. Data Security and Access Control

Always implement proper authorization checks in chart widgets:

```php
protected function getData(): array
{
    // Ensure user has permission to view user data
    if (!auth()->user()->can('view-user-statistics')) {
        return ['datasets' => [], 'labels' => []];
    }

    // Fetch data with proper scoping
    $query = \Modules\User\Models\User::query();
    
    // Apply tenant scoping if applicable
    if (class_exists(\Modules\Tenant\Traits\BelongsToTenant::class)) {
        $query->whereBelongsToTenant();
    }

    // Return chart data
    // ...
}
```

### 3. Performance Optimization

Use caching for expensive chart data queries:

```php
protected function getData(): array
{
    return cache()->remember(
        'user_stats_chart_data',
        now()->addMinutes(15),
        function () {
            // Expensive query operations
            return [
                'datasets' => [...],
                'labels' => [...],
            ];
        }
    );
}
```

## Integration with User Resources

### Adding Charts to User Dashboard

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\User\Filament\Widgets\UserRegistrationTrendsChartWidget;
use Modules\User\Filament\Widgets\UserTypeDistributionChartWidget;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            UserRegistrationTrendsChartWidget::class,
            UserTypeDistributionChartWidget::class,
        ];
    }
}
```

## Frontend Asset Configuration

### Vite Configuration for User Module

If the User module has specific chart requirements, create a Vite configuration:

```javascript
// Modules/User/vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### Chart.js Plugin Registration

Register specific Chart.js plugins for user charts:

```javascript
// resources/js/user-chart-plugins.js
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.filamentChartJsPlugins = window.filamentChartJsPlugins || [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

## Configuration and Best Practices

### 1. Caching Strategies

Implement appropriate caching for user chart data:

```php
class UserChartWidget extends XotBaseChartWidget
{
    protected function getData(): array
    {
        $cacheKey = 'user_chart_' . auth()->id() . '_' . $this->filter;
        
        return cache()->remember(
            $cacheKey,
            now()->addMinutes(30),
            fn() => $this->fetchChartData()
        );
    }
    
    private function fetchChartData(): array
    {
        // Actual data fetching logic
    }
}
```

### 2. Responsive Design

Ensure charts are responsive:

```php
class UserChartWidget extends XotBaseChartWidget
{
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 45,
                    ],
                ],
            ],
        ];
    }
    
    protected function getHeight(): ?string
    {
        return '400px';
    }
}
```

### 3. Accessibility

Include proper labels and descriptions:

```php
class UserChartWidget extends XotBaseChartWidget
{
    public function getHeading(): ?string
    {
        return __('user::widgets.user_registration_trends.heading');
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'title' => [
                    'display' => true,
                    'text' => __('user::widgets.user_registration_trends.description'),
                ],
            ],
        ];
    }
}
```

## Security Considerations

1. Always validate and sanitize chart data inputs
2. Implement proper authorization for accessing user statistics
3. Apply tenant isolation where applicable
4. Use parameterized queries to prevent SQL injection
5. Sanitize chart labels to prevent XSS attacks

## Testing

Create tests for user chart widgets:

```php
// Tests for user chart widgets
it('renders user registration chart', function () {
    $widget = new UserRegistrationTrendsChartWidget();
    expect($widget)->toBeInstanceOf(\Modules\Xot\Filament\Widgets\XotBaseChartWidget::class);
});
```