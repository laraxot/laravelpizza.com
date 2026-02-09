# Chart Generation Actions - Base Implementation

## Overview

This document provides the base implementation patterns for chart generation actions in the Laraxot PTVX system. It serves as a foundation for specific chart implementations in other modules.

## Core Principles

1. **Immutability**: Use Spatie Laravel Data for all data transfer objects
2. **Type Safety**: Strict types and comprehensive PHPDoc
3. **Queue Support**: All chart generation should support queuing
4. **Error Handling**: Comprehensive error handling and logging
5. **Storage**: Proper file storage and URL generation
6. **Caching**: Implement caching for frequently requested charts

## Base Action Structure

### Abstract Base Chart Action

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * Base class for chart generation actions.
 */
abstract class BaseGenerateChartAction implements ShouldQueue
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
        protected readonly mixed $chartData,
        protected readonly string $chartType = 'bar',
        protected readonly array $options = []
    ) {}

    /**
     * Execute the chart generation.
     */
    abstract public function execute(mixed $data): mixed;

    /**
     * Validate chart data.
     */
    protected function validateData(mixed $data): void
    {
        if (!is_object($data) && !is_array($data)) {
            throw new \InvalidArgumentException('Chart data must be an object or array');
        }
    }

    /**
     * Generate unique filename.
     */
    protected function generateFilename(string $prefix, mixed $data): string
    {
        $id = is_object($data) && property_exists($data, 'id')
            ? $data->id
            : (is_array($data) && isset($data['id']) ? $data['id'] : uniqid());

        return $prefix . '_' . $id . '_' . time() . '.' . $this->getFileExtension();
    }

    /**
     * Get file extension for the chart type.
     */
    abstract protected function getFileExtension(): string;

    /**
     * Store chart file and return result data.
     */
    protected function storeAndReturnResult(
        string $content,
        string $filename,
        string $subdirectory,
        array $metadata = []
    ): array {
        $path = $subdirectory . '/' . $filename;

        try {
            Storage::disk('public')->put($path, $content);

            return array_merge($metadata, [
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'size' => strlen($content),
                'generated_at' => now(),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Chart storage failed', [
                'filename' => $filename,
                'error' => $e->getMessage()
            ]);

            throw new \RuntimeException('Failed to store chart file: ' . $e->getMessage());
        }
    }

    /**
     * Get default chart options.
     */
    protected function getDefaultOptions(): array
    {
        return [
            'width' => 800,
            'height' => 400,
            'background_color' => '#ffffff',
            'format' => 'auto',
        ];
    }

    /**
     * Merge options with defaults.
     */
    protected function mergeOptions(array $options): array
    {
        return array_merge($this->getDefaultOptions(), $options);
    }
}
```

## SVG Chart Implementation

### GenerateSvgChartAction

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\Xot\Data\SvgChartResultData;

/**
 * Generate SVG chart action.
 */
class GenerateSvgChartAction extends BaseGenerateChartAction
{
    /**
     * Execute the action.
     */
    public function execute(mixed $data): SvgChartResultData
    {
        $this->validateData($data);

        try {
            $options = $this->mergeOptions($this->options);
            $svgContent = $this->generateSvgContent($data, $this->chartType, $options);

            $filename = $this->generateFilename('chart_svg', $data);
            $result = $this->storeAndReturnResult($svgContent, $filename, 'charts/svg', [
                'content' => $svgContent,
                'format' => 'svg',
                'type' => $this->chartType,
            ]);

            return SvgChartResultData::from($result);
        } catch (\Exception $e) {
            Log::error('SVG chart generation failed', [
                'data' => $data,
                'type' => $this->chartType,
                'error' => $e->getMessage()
            ]);

            throw new \RuntimeException('SVG chart generation failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate SVG content.
     */
    protected function generateSvgContent(mixed $data, string $chartType, array $options): string
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
     */
    private function generateBarChartSvg(mixed $data, array $options): string
    {
        $width = $options['width'];
        $height = $options['height'];
        $bgColor = $options['background_color'];

        $labels = is_array($data) ? ($data['labels'] ?? []) : (property_exists($data, 'labels') ? $data->labels : []);
        $values = is_array($data) ? ($data['values'] ?? []) : (property_exists($data, 'values') ? $data->values : []);

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        if ($bgColor !== 'transparent') {
            $svg .= "<rect width='100%' height='100%' fill='{$bgColor}' />";
        }

        if (!empty($labels) && !empty($values)) {
            $barCount = count($values);
            $barWidth = ($width - 40) / $barCount;
            $maxValue = max($values);

            foreach ($values as $i => $value) {
                $barHeight = $maxValue > 0 ? ($value / $maxValue) * ($height - 60) : 0;
                $x = 20 + ($i * $barWidth);
                $y = $height - $barHeight - 30;

                $color = $this->getBarColor($i);
                $svg .= "<rect x='{$x}' y='{$y}' width='" . ($barWidth - 2) . "' height='{$barHeight}' fill='{$color}' />";
            }
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Generate line chart SVG.
     */
    private function generateLineChartSvg(mixed $data, array $options): string
    {
        $width = $options['width'];
        $height = $options['height'];

        $labels = is_array($data) ? ($data['labels'] ?? []) : (property_exists($data, 'labels') ? $data->labels : []);
        $values = is_array($data) ? ($data['values'] ?? []) : (property_exists($data, 'values') ? $data->values : []);

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        if (!empty($values)) {
            $points = '';
            $maxValue = max($values);

            foreach ($values as $i => $value) {
                $x = 20 + ($i / (count($values) - 1)) * ($width - 40);
                $y = $height - 30 - (($value / $maxValue) * ($height - 60));
                $points .= "{$x},{$y} ";
            }

            $svg .= "<polyline points='{$points}' fill='none' stroke='#007bff' stroke-width='3' />";

            // Add data points
            foreach ($values as $i => $value) {
                $x = 20 + ($i / (count($values) - 1)) * ($width - 40);
                $y = $height - 30 - (($value / $maxValue) * ($height - 60));
                $svg .= "<circle cx='{$x}' cy='{$y}' r='5' fill='#007bff' />";
            }
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Generate pie chart SVG.
     */
    private function generatePieChartSvg(mixed $data, array $options): string
    {
        $width = $options['width'];
        $height = $options['height'];
        $radius = min($width, $height) / 3;
        $centerX = $width / 2;
        $centerY = $height / 2;

        $values = is_array($data) ? ($data['values'] ?? []) : (property_exists($data, 'values') ? $data->values : []);

        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>";

        if (!empty($values)) {
            $total = array_sum($values);
            $startAngle = 0;

            foreach ($values as $i => $value) {
                $percentage = $total > 0 ? $value / $total : 0;
                $angle = $percentage * 360;

                if ($angle > 0) {
                    $endAngle = $startAngle + $angle;

                    $startAngleRad = deg2rad($startAngle - 90);
                    $endAngleRad = deg2rad($endAngle - 90);

                    $x1 = $centerX + $radius * cos($startAngleRad);
                    $y1 = $centerY + $radius * sin($startAngleRad);
                    $x2 = $centerX + $radius * cos($endAngleRad);
                    $y2 = $centerY + $radius * sin($endAngleRad);

                    $largeArcFlag = $angle > 180 ? 1 : 0;

                    $path = "M {$centerX} {$centerY} L {$x1} {$y1} A {$radius} {$radius} 0 {$largeArcFlag} 1 {$x2} {$y2} Z";

                    $color = $this->getPieColor($i);
                    $svg .= "<path d='{$path}' fill='{$color}' />";

                    $startAngle = $endAngle;
                }
            }
        }

        $svg .= "</svg>";

        return $svg;
    }

    /**
     * Get bar color.
     */
    private function getBarColor(int $index): string
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        return $colors[$index % count($colors)];
    }

    /**
     * Get pie color.
     */
    private function getPieColor(int $index): string
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        return $colors[$index % count($colors)];
    }

    /**
     * Get file extension.
     */
    protected function getFileExtension(): string
    {
        return 'svg';
    }
}
```

## PNG Chart Implementation

### GeneratePngChartAction

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\Xot\Data\PngChartResultData;

/**
 * Generate PNG chart action.
 */
class GeneratePngChartAction extends BaseGenerateChartAction
{
    /**
     * Execute the action.
     */
    public function execute(mixed $data): PngChartResultData
    {
        $this->validateData($data);

        try {
            $options = $this->mergeOptions($this->options);
            $pngContent = $this->generatePngContent($data, $this->chartType, $options);

            $filename = $this->generateFilename('chart_png', $data);
            $result = $this->storeAndReturnResult($pngContent, $filename, 'charts/png', [
                'content' => $pngContent,
                'format' => 'png',
                'type' => $this->chartType,
                'width' => $options['width'],
                'height' => $options['height'],
            ]);

            return PngChartResultData::from($result);
        } catch (\Exception $e) {
            Log::error('PNG chart generation failed', [
                'data' => $data,
                'type' => $this->chartType,
                'error' => $e->getMessage()
            ]);

            throw new \RuntimeException('PNG chart generation failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate PNG content.
     */
    protected function generatePngContent(mixed $data, string $chartType, array $options): string
    {
        // Generate HTML first
        $htmlContent = $this->generateChartHtml($data, $chartType, $options);

        // Convert HTML to PNG
        return $this->convertHtmlToPng($htmlContent, $options);
    }

    /**
     * Generate HTML for chart.
     */
    private function generateChartHtml(mixed $data, string $chartType, array $options): string
    {
        $width = $options['width'];
        $height = $options['height'];

        $labels = is_array($data) ? ($data['labels'] ?? []) : (property_exists($data, 'labels') ? $data->labels : []);
        $values = is_array($data) ? ($data['values'] ?? []) : (property_exists($data, 'values') ? $data->values : []);

        $dataJson = json_encode([
            'labels' => $labels,
            'datasets' => [[
                'data' => $values,
                'backgroundColor' => $this->getDefaultColors(count($values)),
                'borderColor' => $this->getDefaultColors(count($values)),
            ]]
        ]);

        $optionsJson = json_encode([
            'responsive' => false,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['display' => false],
            ],
        ]);

        return "<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <style>body{margin:0;padding:20px;background:white;}canvas{max-width:100%;max-height:100%;}</style>
</head>
<body>
    <canvas id='chart' width='{$width}' height='{$height}'></canvas>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {type:'{$chartType}',data:{$dataJson},options:{$optionsJson}});
    </script>
</body>
</html>";
    }

    /**
     * Convert HTML to PNG.
     */
    private function convertHtmlToPng(string $htmlContent, array $options): string
    {
        // Method 1: Using Browsershot if available
        if (class_exists(\Spatie\Browsershot\Browsershot::class)) {
            return \Spatie\Browsershot\Browsershot::html($htmlContent)
                ->setScreenshotType('png')
                ->windowSize($options['width'], $options['height'] + 40)
                ->waitUntilNetworkIdle()
                ->screenshot();
        }

        // Method 2: Using Intervention Image (basic implementation)
        if (class_exists(\Intervention\Image\Laravel\Facades\Image::class)) {
            $image = \Intervention\Image\Laravel\Facades\Image::canvas(
                $options['width'],
                $options['height'],
                '#ffffff'
            );

            // Add placeholder text
            $image->text(
                'Chart Generation Not Available',
                $options['width'] / 2,
                $options['height'] / 2,
                function ($font) {
                    $font->size(24);
                    $font->color('#666666');
                    $font->align('center');
                    $font->valign('center');
                }
            );

            return $image->encode('png')->getEncoded();
        }

        throw new \RuntimeException('No PNG conversion method available. Install Browsershot or Intervention Image.');
    }

    /**
     * Get default colors.
     */
    private function getDefaultColors(int $count): array
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $result[] = $colors[$i % count($colors)];
        }

        return $result;
    }

    /**
     * Get file extension.
     */
    protected function getFileExtension(): string
    {
        return 'png';
    }
}
```

## Data Classes

### SvgChartResultData

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Data;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

/**
 * SVG chart generation result.
 */
class SvgChartResultData extends Data
{
    public function __construct(
        public readonly string $filename,
        public readonly string $path,
        public readonly string $url,
        public readonly string $content,
        public readonly int $size,
        public readonly string $format,
        public readonly string $type,
        public readonly Carbon $generated_at,
        public readonly bool $success = true,
    ) {}
}
```

### PngChartResultData

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Data;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

/**
 * PNG chart generation result.
 */
class PngChartResultData extends Data
{
    public function __construct(
        public readonly string $filename,
        public readonly string $path,
        public readonly string $url,
        public readonly string $content,
        public readonly int $size,
        public readonly string $format,
        public readonly string $type,
        public readonly int $width,
        public readonly int $height,
        public readonly Carbon $generated_at,
        public readonly bool $success = true,
    ) {}
}
```

## Usage Pattern

### Synchronous Execution

```php
use Modules\Xot\Actions\GenerateSvgChartAction;

$action = new GenerateSvgChartAction($chartData, 'bar', ['width' => 800, 'height' => 400]);
$result = $action->execute($chartData);

echo $result->url; // Access the generated chart URL
```

### Asynchronous Execution

```php
use Modules\Xot\Actions\GeneratePngChartAction;

GeneratePngChartAction::dispatch($chartData, 'pie')
    ->onQueue('charts')
    ->delay(now()->addMinutes(5));
```

## Extension in Specific Modules

Modules can extend the base actions to add specific functionality:

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Modules\Xot\Actions\GenerateSvgChartAction;

/**
 * Performance-specific SVG chart generation.
 */
class GeneratePerformanceSvgChartAction extends GenerateSvgChartAction
{
    /**
     * Add performance-specific styling.
     */
    private function generateBarChartSvg(mixed $data, array $options): string
    {
        // Custom performance chart generation
        $svg = parent::generateBarChartSvg($data, $options);

        // Add performance-specific elements
        return $this->addPerformanceIndicators($svg, $data);
    }

    private function addPerformanceIndicators(string $svg, mixed $data): string
    {
        // Add performance-specific SVG elements
        return $svg;
    }
}
```

## Best Practices

1. **Always extend base actions** instead of creating from scratch
2. **Use proper data classes** for type safety
3. **Implement caching** for frequently requested charts
4. **Handle errors gracefully** with detailed logging
5. **Validate input data** before processing
6. **Queue heavy operations** to avoid blocking requests

## Testing

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Tests\TestCase;
use Modules\Xot\Actions\GenerateSvgChartAction;

class GenerateSvgChartActionTest extends TestCase
{
    /** @test */
    public function it_generates_svg_chart(): void
    {
        $data = [
            'labels' => ['Jan', 'Feb', 'Mar'],
            'values' => [10, 20, 30]
        ];

        $action = new GenerateSvgChartAction($data, 'bar');
        $result = $action->execute($data);

        $this->assertTrue($result->success);
        $this->assertStringContains('svg', $result->content);
        $this->assertStringEndsWith('.svg', $result->filename);
    }
}
```

## File Structure

```
Modules/Xot/
├── Actions/
│   ├── BaseGenerateChartAction.php
│   ├── GenerateSvgChartAction.php
│   └── GeneratePngChartAction.php
├── Data/
│   ├── SvgChartResultData.php
│   └── PngChartResultData.php
└── docs/
    └── actions/
        ├── chart-generation-base.md
        └── chart-generation-svg.md
        └── chart-generation-png.md
```

