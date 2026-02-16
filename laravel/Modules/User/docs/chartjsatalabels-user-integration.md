# Chart.js Datalabels Plugin for User Module Charts

## Overview

This guide explains how to implement the Chart.js datalabels plugin in User module charts, such as user registration trends, role distribution, and activity statistics. The datalabels plugin enhances user data visualization by displaying values, percentages, or other information directly on chart elements.

## Implementation in User Module ChartWidgets

### Basic User Registration Chart with Datalabels

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\User\Models\User;

class UserRegistrationTrendChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'User Registrations';

    protected function getData(): array
    {
        // Get user registration data grouped by month
        $registrations = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12) // Last 12 months
            ->get();

        return [
            'labels' => $registrations->pluck('month')->toArray(),
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => $registrations->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
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
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
                'datalabels' => [
                    'display' => true,
                    'align' => 'top',
                    'anchor' => 'end',
                    'formatter' => 'function(value) {
                        return value;
                    }',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 12,
                    ],
                    'color' => '#36A2EB',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Month',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // or 'bar'
    }
}
```

## User Role Distribution Chart

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleDistributionChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'User Role Distribution';

    protected function getData(): array
    {
        // Get all roles and count users per role
        $roles = Role::all();
        $labels = [];
        $data = [];
        $colors = [];

        foreach ($roles as $role) {
            $userCount = $role->users()->count();
            if ($userCount > 0) { // Only include roles with users
                $labels[] = $role->name;
                $data[] = $userCount;
                // Generate color based on role
                $hue = crc32($role->name) % 360;
                $colors[] = "hsla($hue, 70%, 60%, 0.8)";
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
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
                    'formatter' => 'function(value, context) {
                        var dataset = context.dataset;
                        var total = dataset.data.reduce(function(sum, current) {
                            return sum + current;
                        }, 0);
                        var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return value + " (" + percentage + "%)";
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

## Advanced User Statistics Charts

### User Activity by Weekday

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\User\Models\User;

class UserActivityByWeekdayChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'User Activity by Weekday';

    protected function getData(): array
    {
        // Get user activity grouped by weekday (0 = Sunday, 6 = Saturday)
        $activity = User::selectRaw('WEEKDAY(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $counts = array_fill(0, 7, 0); // Initialize array with 0s for all days

        foreach ($activity as $item) {
            $counts[$item->day] = (int) $item->count;
        }

        return [
            'labels' => $dayNames,
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => $counts,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)', // Red
                        'rgba(54, 162, 235, 0.8)', // Blue
                        'rgba(255, 205, 86, 0.8)', // Yellow
                        'rgba(75, 192, 192, 0.8)', // Teal
                        'rgba(153, 102, 255, 0.8)', // Purple
                        'rgba(255, 159, 64, 0.8)', // Orange
                        'rgba(199, 199, 199, 0.8)', // Gray
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
                    'formatter' => 'function(value, context) {
                        if (value === 0) return ""; // Hide labels for days with no activity
                        var dataset = context.dataset;
                        var total = dataset.data.reduce(function(sum, current) {
                            return sum + current;
                        }, 0);
                        var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return percentage + "%";
                    }',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 11,
                    ],
                    'color' => 'function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        // Use different colors for labels based on data value
                        return value > 0 ? "#333" : "transparent";
                    }',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
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

## Conditional Datalabels for Different Chart Types

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class DynamicUserChartWidget extends XotBaseChartWidget
{
    public array $chartConfig = [];

    protected static ?string $heading = 'Dynamic User Chart';

    protected function getData(): array
    {
        // This would be populated based on configuration
        return $this->chartConfig['data'] ?? [
            'labels' => ['Category 1', 'Category 2', 'Category 3'],
            'datasets' => [
                [
                    'label' => 'Sample Data',
                    'data' => [10, 20, 30],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                    ],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        $chartType = $this->chartConfig['type'] ?? 'bar';
        
        $datalabelsConfig = match($chartType) {
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
                    return value + "\\n(" + percentage + "%)";
                }',
            ],
            'line' => [
                'display' => 'function(context) {
                    // Only show labels for significant values in line charts
                    var value = context.dataset.data[context.dataIndex];
                    return value > 5; // Only show if value is greater than 5
                }',
                'align' => 'top',
                'anchor' => 'end',
                'formatter' => 'function(value) {
                    return value;
                }',
            ],
            default => [ // bar chart default
                'display' => true,
                'align' => 'top',
                'anchor' => 'end',
                'formatter' => 'function(value) {
                    return value;
                }',
            ],
        };

        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'datalabels' => array_merge($datalabelsConfig, [
                    'font' => [
                        'weight' => 'bold',
                        'size' => 12,
                    ],
                    'color' => '#fff',
                    'textStrokeColor' => '#000',
                    'textStrokeWidth' => 1,
                ]),
            ],
        ];
    }

    protected function getType(): string
    {
        return $this->chartConfig['type'] ?? 'bar';
    }
}
```

## Multiple Labels Configuration

For complex user data visualization, you can use multiple labels per data point:

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
                    'value' => [
                        'align' => 'top',
                        'anchor' => 'start',
                        'formatter' => 'function(value) {
                            return value + " users";
                        }',
                        'font' => [
                            'weight' => 'bold',
                            'size' => 12,
                        ],
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
                        'font' => [
                            'size' => 10,
                        ],
                        'color' => '#666',
                    ],
                ],
            ],
        ],
    ];
}
```

## Performance Considerations

For large user datasets, implement performance optimizations:

```php
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'datalabels' => [
                'display' => 'function(context) {
                    // Disable datalabels if there are too many data points to maintain performance
                    var dataset = context.dataset;
                    if (dataset.data.length > 15) {
                        return false;
                    }
                    return true;
                }',
                'align' => 'center',
                'anchor' => 'center',
                'formatter' => 'function(value) {
                    return value;
                }',
            ],
        ],
    ];
}
```

## Styling and Accessibility

Ensure proper contrast and readability:

```php
'datalabels' => [
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
        // Ensure sufficient contrast with background
        var backgroundColor = context.dataset.backgroundColor[context.dataIndex];
        if (typeof backgroundColor === "string") {
            // Simple contrast checker for common color formats
            if (backgroundColor.includes("rgba")) {
                // Extract RGB values from rgba(r, g, b, a)
                var match = backgroundColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                if (match) {
                    var r = parseInt(match[1]);
                    var g = parseInt(match[2]);
                    var b = parseInt(match[3]);
                    var brightness = (r * 299 + g * 587 + b * 114) / 1000;
                    return brightness > 128 ? "#000" : "#fff";
                }
            }
        }
        return "#fff"; // Default to white
    }',
    'textStrokeColor' => 'function(context) {
        var labelColor = context.dataset.backgroundColor[context.dataIndex];
        if (typeof labelColor === "string") {
            if (labelColor.includes("rgba")) {
                var match = labelColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                if (match) {
                    var r = parseInt(match[1]);
                    var g = parseInt(match[2]);
                    var b = parseInt(match[3]);
                    var brightness = (r * 299 + g * 587 + b * 114) / 1000;
                    return brightness < 128 ? "#000" : "#fff";
                }
            }
        }
        return "#fff";
    }',
    'textStrokeWidth' => 2,
],
```

## Integration with User Module Models

When implementing charts that work with User models, make sure to optimize database queries:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\User\Models\User;

class OptimizedUserStatsChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Optimized User Statistics';

    protected function getData(): array
    {
        // Use query optimizations for better performance
        $data = User::selectRaw('
            DATE(created_at) as date,
            COUNT(*) as count,
            SUM(CASE WHEN email_verified_at IS NOT NULL THEN 1 ELSE 0 END) as verified_count
        ')
        ->where('created_at', '>=', now()->subDays(30))
        ->groupByRaw('DATE(created_at)')
        ->orderByRaw('DATE(created_at)')
        ->get();

        return [
            'labels' => $data->pluck('date')->toArray(),
            'datasets' => [
                [
                    'label' => 'Total Registrations',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                ],
                [
                    'label' => 'Verified Users',
                    'data' => $data->pluck('verified_count')->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
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
                    'display' => 'auto', // Auto-hide overlapping labels
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
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

## Best Practices for User Module Charts

1. **Performance**: For large user base, consider caching chart data
2. **Privacy**: Ensure that chart data doesn't expose sensitive user information
3. **Accessibility**: Use sufficient color contrast and appropriate font sizes
4. **Relevance**: Show only meaningful data that helps understand user trends
5. **Scalability**: Implement conditional rendering for large datasets
6. **Consistency**: Use consistent styling across all user-related charts
7. **Real-time**: Consider using polling for real-time user statistics