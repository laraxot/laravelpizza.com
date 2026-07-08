# Chart Generation Actions - SVG Charts

## Overview

This document describes how to create Spatie QueueableAction classes that generate SVG charts in the Laraxot PTVX system. SVG charts are vector-based and provide excellent scalability and quality for web interfaces.

## Prerequisites

- PHP 8.3+
- Laravel 10+
- Spatie Laravel Data
- Spatie QueueableAction
- Chart library (e.g., Chart.js, D3.js, or Laravel Charts)

## Basic Structure

### Action Class Structure

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Performance\Data\ChartData;
use Modules\Performance\Data\SvgResultData;
use Illuminate\Support\Facades\Storage;

/**
 * Generate SVG Chart Action
 *
 * This action creates SVG-based charts from performance data.
 */
class GenerateSvgChartAction implements ShouldQueue
{
    use QueueableAction;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new action instance.
     */
    public function __construct(
        private readonly ChartData $chartData,
        private readonly string $chartType = 'bar',
        private readonly array $options = []
    ) {}

    /**
     * Execute the action.
     *
     * @param ChartData $data
     * @return SvgResultData
     */
    public function execute(ChartData $data): SvgResultData
    {
        // Generate SVG content
        $svgContent = $this->generateSvgContent($data, $this->chartType, $this->options);

        // Store the SVG file
        $filename = $this->generateFilename($data);
        $path = 'charts/svg/' . $filename;
        Storage::disk('public')->put($path, $svgContent);

        return new SvgResultData(
            filename: $filename,
            path: $path,
            url: Storage::disk('public')->url($path),
            content: $svgContent,
            size: strlen($svgContent),
            generated_at: now()
        );
    }

    /**
     * Generate SVG content for the chart.
     *
     * @param ChartData $data
     * @param string $chartType
     * @param array $options
     * @return string
     */
    private function generateSvgContent(ChartData $data, string $chartType, array $options): string
    {
        return match ($chartType) {
            'bar' => $this->generateBarChartSvg($data, $options),
            'line' => $this->generateLineChartSvg($data, $options),
            'pie' => $this->generatePieChartSvg($data, $options),
            default => throw new \InvalidArgumentException("Unsupported chart type: {$chartType}")
        };
    }

    /**
     * Generate bar chart SVG.
     *
     * @param ChartData $data
     * @param array $options
     * @return string
     */
    private function generateBarChartSvg(ChartData $data, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;
        $barWidth = $width / count($data->labels);

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        // Add background
        $svg .= "<rect width='100%' height='100%' fill='#f8f9fa' />";

        // Generate bars
        foreach ($data->datasets as $index => $dataset) {
            $color = $dataset['backgroundColor'] ?? '#007bff';
            $maxValue = max($data->values);

            foreach ($data->values as $i => $value) {
                $barHeight = ($value / $maxValue) * ($height - 60);
                $x = $i * $barWidth + ($index * $barWidth / count($data->datasets));
                $y = $height - $barHeight - 40;

                $svg .= "<rect x='{$x}' y='{$y}' width='" . ($barWidth / count($data->datasets)) . "' height='{$barHeight}' fill='{$color}' />";
            }
        }

        // Add labels
        foreach ($data->labels as $i => $label) {
            $x = $i * $barWidth + $barWidth / 2;
            $svg .= "<text x='{$x}' y='" . ($height - 20) . "' text-anchor='middle' font-family='Arial' font-size='12'>{$label}</text>";
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Generate line chart SVG.
     *
     * @param ChartData $data
     * @param array $options
     * @return string
     */
    private function generateLineChartSvg(ChartData $data, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        // Add background
        $svg .= "<rect width='100%' height='100%' fill='#f8f9fa' />";

        // Generate line paths
        foreach ($data->datasets as $dataset) {
            $color = $dataset['borderColor'] ?? '#007bff';
            $points = '';

            $maxValue = max($data->values);
            foreach ($data->values as $i => $value) {
                $x = ($i / (count($data->values) - 1)) * ($width - 80) + 40;
                $y = $height - (($value / $maxValue) * ($height - 80)) - 40;
                $points .= "{$x},{$y} ";
            }

            $svg .= "<polyline points='{$points}' fill='none' stroke='{$color}' stroke-width='3' />";

            // Add data points
            foreach ($data->values as $i => $value) {
                $x = ($i / (count($data->values) - 1)) * ($width - 80) + 40;
                $y = $height - (($value / $maxValue) * ($height - 80)) - 40;
                $svg .= "<circle cx='{$x}' cy='{$y}' r='5' fill='{$color}' />";
            }
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Generate pie chart SVG.
     *
     * @param ChartData $data
     * @param array $options
     * @return string
     */
    private function generatePieChartSvg(ChartData $data, array $options): string
    {
        $width = $options['width'] ?? 400;
        $height = $options['height'] ?? 400;
        $radius = min($width, $height) / 3;
        $centerX = $width / 2;
        $centerY = $height / 2;

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        // Add background
        $svg .= "<rect width='100%' height='100%' fill='#f8f9fa' />";

        $total = array_sum($data->values);
        $startAngle = 0;

        foreach ($data->values as $i => $value) {
            $percentage = $value / $total;
            $angle = $percentage * 360;

            if ($angle > 0) {
                $endAngle = $startAngle + $angle;

                // Convert angles to radians
                $startAngleRad = deg2rad($startAngle - 90);
                $endAngleRad = deg2rad($endAngle - 90);

                // Calculate path
                $x1 = $centerX + $radius * cos($startAngleRad);
                $y1 = $centerY + $radius * sin($startAngleRad);
                $x2 = $centerX + $radius * cos($endAngleRad);
                $y2 = $centerY + $radius * sin($endAngleRad);

                $largeArcFlag = $angle > 180 ? 1 : 0;

                $path = "M {$centerX} {$centerY} L {$x1} {$y1} A {$radius} {$radius} 0 {$largeArcFlag} 1 {$x2} {$y2} Z";

                $color = $data->colors[$i] ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF));

                $svg .= "<path d='{$path}' fill='{$color}' />";

                $startAngle = $endAngle;
            }
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Generate unique filename for the chart.
     *
     * @param ChartData $data
     * @return string
     */
    private function generateFilename(ChartData $data): string
    {
        return 'chart_' . $data->id . '_' . time() . '.svg';
    }
}
```

## Usage Examples

### Basic Usage

```php
// Create chart data
$chartData = new ChartData(
    id: 'performance_2024',
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    values: [65, 59, 80, 81, 56, 55],
    colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
);

// Execute action synchronously
$action = new GenerateSvgChartAction($chartData, 'bar');
$result = $action->execute($chartData);

// Execute asynchronously
GenerateSvgChartAction::dispatch($chartData, 'pie')
    ->onQueue('charts')
    ->delay(now()->addMinutes(5));
```

### Advanced Usage with Options

```php
$options = [
    'width' => 1200,
    'height' => 600,
    'colors' => ['#FF6384', '#36A2EB', '#FFCE56'],
    'show_legend' => true,
    'title' => 'Performance Chart 2024'
];

$action = new GenerateSvgChartAction($chartData, 'line', $options);
$result = $action->execute($chartData);
```

## Integration with Filament Actions

### In Filament Resources

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\Action;
use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

class PerformanceResource extends XotBaseResource
{
    public static function getActions(): array
    {
        return [
            Action::make('generate_chart')
                ->label('Genera Grafico SVG')
                ->icon('heroicon-o-chart-bar')
                ->action(function () {
                    $chartData = new ChartData(
                        id: 'performance_' . now()->format('Y_m_d'),
                        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                        values: [85, 92, 78, 95],
                        colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                    );

                    $action = app(GenerateSvgChartAction::class);
                    $result = $action->execute($chartData);

                    // Show success notification with download link
                    Notification::make()
                        ->title('Grafico generato con successo')
                        ->body('Scarica il grafico: ' . $result->filename)
                        ->actions([
                            Action::make('download')
                                ->label('Scarica')
                                ->url($result->url)
                                ->openUrlInNewTab(),
                        ])
                        ->success()
                        ->send();
                }),
        ];
    }
}
```

### In Filament Pages

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

class PerformanceDashboard extends Page
{
    protected static string $view = 'performance::filament.pages.dashboard';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_svg_chart')
                ->label('Esporta Grafico SVG')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    // Get data from current context
                    $data = $this->getChartData();

                    $chartData = new ChartData(
                        id: 'dashboard_' . auth()->id() . '_' . time(),
                        labels: $data['labels'],
                        values: $data['values']
                    );

                    $action = app(GenerateSvgChartAction::class);
                    $result = $action->execute($chartData);

                    return redirect($result->url);
                }),
        ];
    }

    private function getChartData(): array
    {
        // Logic to get current dashboard data
        return [
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
            'values' => [65, 59, 80, 81, 56, 55]
        ];
    }
}
```

### Direct Usage in Custom Logic

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Services;

use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

class PerformanceReportService
{
    public function generateMonthlyReport(): array
    {
        $chartData = new ChartData(
            id: 'monthly_report_' . date('Y_m'),
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            values: $this->getMonthlyData(),
            datasets: [
                [
                    'label' => 'Performance Score',
                    'backgroundColor' => '#007bff',
                ]
            ]
        );

        $action = app(GenerateSvgChartAction::class);
        $result = $action->execute($chartData);

        return [
            'chart_url' => $result->url,
            'chart_filename' => $result->filename,
            'report_data' => $this->getReportData(),
        ];
    }

    private function getMonthlyData(): array
    {
        // Logic to calculate monthly performance data
        return [78, 85, 92, 88];
    }

    private function getReportData(): array
    {
        // Additional report data
        return [
            'total_score' => 343,
            'average_score' => 85.75,
            'best_week' => 'Week 3',
        ];
    }
}
```

## Data Classes

### ChartData Class

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Data;

use Spatie\LaravelData\Data;

/**
 * Chart data transfer object.
 */
class ChartData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly array $labels,
        public readonly array $values,
        public readonly array $colors = [],
        public readonly array $datasets = []
    ) {}
}
```

### SvgResultData Class

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Data;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

/**
 * SVG chart generation result.
 */
class SvgResultData extends Data
{
    public function __construct(
        public readonly string $filename,
        public readonly string $path,
        public readonly string $url,
        public readonly string $content,
        public readonly int $size,
        public readonly Carbon $generated_at
    ) {}
}
```

## Best Practices

1. **Always use strict types** (`declare(strict_types=1)`)
2. **Validate input data** before processing
3. **Handle errors gracefully** with try-catch blocks
4. **Store generated charts** in appropriate storage disks
5. **Use meaningful filenames** with timestamps
6. **Document chart options** clearly
7. **Test chart generation** with various data sets
8. **Cache frequently used charts** for performance

## Error Handling

```php
try {
    $result = $action->execute($chartData);
} catch (\InvalidArgumentException $e) {
    // Handle invalid chart type
    return response()->json(['error' => 'Invalid chart type'], 400);
} catch (\Exception $e) {
    // Handle general errors
    Log::error('Chart generation failed', ['error' => $e->getMessage()]);
    return response()->json(['error' => 'Chart generation failed'], 500);
}
```

## Performance Considerations

- **Queue long-running tasks** to avoid blocking the main thread
- **Cache generated charts** for frequently requested data
- **Optimize SVG generation** for large datasets
- **Use appropriate storage** (local, S3, etc.) based on requirements

## Testing

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Tests\Unit\Actions;

use Tests\TestCase;
use Modules\Performance\Actions\GenerateSvgChartAction;
use Modules\Performance\Data\ChartData;

class GenerateSvgChartActionTest extends TestCase
{
    /** @test */
    public function it_generates_svg_chart_successfully(): void
    {
        $chartData = new ChartData(
            id: 'test_chart',
            labels: ['A', 'B', 'C'],
            values: [1, 2, 3]
        );

        $action = new GenerateSvgChartAction($chartData, 'bar');
        $result = $action->execute($chartData);

        $this->assertStringContains('svg', $result->content);
        $this->assertStringEndsWith('.svg', $result->filename);
        $this->assertGreaterThan(0, $result->size);
    }
}
```

## File Structure

```
Modules/Performance/
├── Actions/
│   └── GenerateSvgChartAction.php
├── Data/
│   ├── ChartData.php
│   └── SvgResultData.php
├── Http/Controllers/
│   └── ChartController.php
└── docs/
    └── charts/
        ├── svg-charts.md
        └── png-charts.md
```

*Last updated: December 2025*
