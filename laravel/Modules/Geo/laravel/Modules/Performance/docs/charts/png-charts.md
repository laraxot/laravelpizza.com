# Chart Generation Actions - PNG Charts

## Overview

This document describes how to create Spatie QueueableAction classes that generate PNG charts in the Laraxot PTVX system. PNG charts are raster-based and provide excellent compatibility with various applications and printing systems.

## Prerequisites

- PHP 8.3+
- Laravel 10+
- Spatie Laravel Data
- Spatie QueueableAction
- GD extension or ImageMagick
- Chart library (Chart.js with html2canvas, or Laravel Charts)

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
use Modules\Performance\Data\PngResultData;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

/**
 * Generate PNG Chart Action
 *
 * This action creates PNG-based charts from performance data using Intervention Image.
 */
class GeneratePngChartAction implements ShouldQueue
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
     * @return PngResultData
     */
    public function execute(ChartData $data): PngResultData
    {
        // Generate HTML for the chart
        $htmlContent = $this->generateChartHtml($data, $this->chartType, $this->options);

        // Convert HTML to PNG
        $pngContent = $this->convertHtmlToPng($htmlContent, $this->options);

        // Store the PNG file
        $filename = $this->generateFilename($data);
        $path = 'charts/png/' . $filename;
        Storage::disk('public')->put($path, $pngContent);

        return new PngResultData(
            filename: $filename,
            path: $path,
            url: Storage::disk('public')->url($path),
            content: $pngContent,
            size: strlen($pngContent),
            width: $this->options['width'] ?? 800,
            height: $this->options['height'] ?? 400,
            generated_at: now()
        );
    }

    /**
     * Generate HTML content for the chart.
     *
     * @param ChartData $data
     * @param string $chartType
     * @param array $options
     * @return string
     */
    private function generateChartHtml(ChartData $data, string $chartType, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;

        $html = "<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <style>
        body { margin: 0; padding: 20px; background: white; }
        canvas { max-width: 100%; max-height: 100%; }
    </style>
</head>
<body>
    <canvas id='chart' width='{$width}' height='{$height}'></canvas>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: '{$chartType}',
            data: " . json_encode($this->formatChartData($data)) . ",
            options: " . json_encode($this->getChartOptions($options)) . "
        });
    </script>
</body>
</html>";

        return $html;
    }

    /**
     * Format chart data for Chart.js.
     *
     * @param ChartData $data
     * @return array
     */
    private function formatChartData(ChartData $data): array
    {
        return [
            'labels' => $data->labels,
            'datasets' => array_map(function ($dataset, $index) use ($data) {
                return [
                    'label' => $dataset['label'] ?? 'Dataset ' . ($index + 1),
                    'data' => $data->values,
                    'backgroundColor' => $dataset['backgroundColor'] ?? $this->getDefaultColors(),
                    'borderColor' => $dataset['borderColor'] ?? $this->getDefaultColors(),
                    'borderWidth' => $dataset['borderWidth'] ?? 1,
                ];
            }, $data->datasets, array_keys($data->datasets))
        ];
    }

    /**
     * Get chart options for Chart.js.
     *
     * @param array $options
     * @return array
     */
    private function getChartOptions(array $options): array
    {
        return [
            'responsive' => false,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => $options['show_legend'] ?? true,
                    'position' => $options['legend_position'] ?? 'top',
                ],
                'title' => [
                    'display' => isset($options['title']),
                    'text' => $options['title'] ?? '',
                    'font' => [
                        'size' => $options['title_font_size'] ?? 16,
                    ],
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

    /**
     * Convert HTML to PNG using a headless browser or image library.
     *
     * @param string $htmlContent
     * @param array $options
     * @return string
     */
    private function convertHtmlToPng(string $htmlContent, array $options): string
    {
        // Method 1: Using Browsershot (requires Puppeteer)
        if (class_exists(\Spatie\Browsershot\Browsershot::class)) {
            return $this->convertWithBrowsershot($htmlContent, $options);
        }

        // Method 2: Using html2canvas + Intervention Image
        return $this->convertWithHtml2Canvas($htmlContent, $options);
    }

    /**
     * Convert HTML to PNG using Browsershot.
     *
     * @param string $htmlContent
     * @param array $options
     * @return string
     */
    private function convertWithBrowsershot(string $htmlContent, array $options): string
    {
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;

        return \Spatie\Browsershot\Browsershot::html($htmlContent)
            ->setScreenshotType('png')
            ->windowSize($width, $height + 40) // Add some padding
            ->waitUntilNetworkIdle()
            ->screenshot();
    }

    /**
     * Convert HTML to PNG using html2canvas simulation.
     *
     * @param string $htmlContent
     * @param array $options
     * @return string
     */
    private function convertWithHtml2Canvas(string $htmlContent, array $options): string
    {
        // This is a simplified approach - in real implementation,
        // you might use a headless browser or external service

        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? 400;

        // Create a base image
        $image = Image::canvas($width, $height, '#ffffff');

        // For a real implementation, you would need to:
        // 1. Render the HTML with Chart.js
        // 2. Use a headless browser to capture the result
        // 3. Return the PNG binary data

        // This is a placeholder - implement proper HTML to PNG conversion
        return $image->encode('png')->getEncoded();
    }

    /**
     * Get default colors for charts.
     *
     * @return array
     */
    private function getDefaultColors(): array
    {
        return [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#FF9F40',
            '#FF6384',
            '#C9CBCF',
            '#4BC0C0',
            '#FF6384',
        ];
    }

    /**
     * Generate unique filename for the chart.
     *
     * @param ChartData $data
     * @return string
     */
    private function generateFilename(ChartData $data): string
    {
        return 'chart_' . $data->id . '_' . time() . '.png';
    }
}
```

## Alternative Implementation with Laravel Charts

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Storage;

/**
 * Generate PNG Chart using Laravel Charts
 */
class GeneratePngChartWithLaravelChartsAction
{
    use QueueableAction;

    public function execute(array $data, string $chartType = 'bar'): string
    {
        $chart = new Chart();

        // Configure chart based on type
        switch ($chartType) {
            case 'bar':
                $chart->labels($data['labels'])
                      ->dataset($data['label'] ?? 'Data', 'bar', $data['values'])
                      ->color($data['colors'] ?? ['#FF6384', '#36A2EB']);
                break;

            case 'line':
                $chart->labels($data['labels'])
                      ->dataset($data['label'] ?? 'Data', 'line', $data['values'])
                      ->color($data['colors'] ?? ['#FF6384']);
                break;

            case 'pie':
                $chart->labels($data['labels'])
                      ->dataset($data['label'] ?? 'Data', 'pie', $data['values'])
                      ->color($data['colors'] ?? $this->getDefaultColors());
                break;
        }

        // Generate HTML
        $html = view('charts.template', compact('chart'))->render();

        // Convert to PNG (using external service or headless browser)
        return $this->htmlToPng($html);
    }

    /**
     * Convert HTML to PNG.
     */
    private function htmlToPng(string $html): string
    {
        // Implementation depends on your chosen method
        // Could use Browsershot, Puppeteer, or external API
        return 'PNG_BINARY_DATA';
    }
}
```

## Integration with Filament Actions

### In Filament Resources

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\Action;
use Modules\Performance\Actions\GeneratePngChartAction;
use Modules\Performance\Data\ChartData;

class PerformanceResource extends XotBaseResource
{
    public static function getActions(): array
    {
        return [
            Action::make('generate_png_chart')
                ->label('Genera Grafico PNG')
                ->icon('heroicon-o-photo')
                ->color('success')
                ->action(function () {
                    $chartData = new ChartData(
                        id: 'performance_' . now()->format('Y_m_d'),
                        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                        values: [85, 92, 78, 95],
                        datasets: [
                            [
                                'label' => 'Performance Score',
                                'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                            ]
                        ]
                    );

                    $action = app(GeneratePngChartAction::class);
                    $result = $action->execute($chartData);

                    // Show success notification with download link
                    Notification::make()
                        ->title('Grafico PNG generato con successo')
                        ->body('Scarica il grafico: ' . $result->filename)
                        ->actions([
                            Action::make('download')
                                ->label('Scarica PNG')
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

### In Filament Pages with Form

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Modules\Performance\Actions\GeneratePngChartAction;
use Modules\Performance\Data\ChartData;

class ChartGenerator extends Page
{
    protected static string $view = 'performance::filament.pages.chart-generator';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Titolo del Grafico')
                    ->required(),

                Select::make('chart_type')
                    ->label('Tipo di Grafico')
                    ->options([
                        'bar' => 'Barre',
                        'line' => 'Linee',
                        'pie' => 'Torta',
                        'doughnut' => 'Anello',
                    ])
                    ->default('bar')
                    ->required(),

                TextInput::make('labels')
                    ->label('Etichette (separate da virgola)')
                    ->placeholder('Gen,Feb,Mar,Apr')
                    ->required(),

                TextInput::make('values')
                    ->label('Valori (separati da virgola)')
                    ->placeholder('10,20,30,40')
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_png')
                ->label('Genera PNG')
                ->icon('heroicon-o-photo')
                ->color('primary')
                ->action(function () {
                    $data = $this->form->getState();

                    // Parse comma-separated values
                    $labels = array_map('trim', explode(',', $data['labels']));
                    $values = array_map('intval', array_map('trim', explode(',', $data['values'])));

                    $chartData = new ChartData(
                        id: 'custom_' . time(),
                        labels: $labels,
                        values: $values,
                        datasets: [
                            [
                                'label' => $data['title'],
                                'backgroundColor' => $this->getDefaultColors(count($values)),
                            ]
                        ]
                    );

                    $action = app(GeneratePngChartAction::class);
                    $result = $action->execute($chartData);

                    // Redirect to download
                    return redirect($result->url);
                }),
        ];
    }

    private function getDefaultColors(int $count): array
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        return array_slice($colors, 0, $count);
    }
}
```

### Direct Usage in Report Services

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Services;

use Modules\Performance\Actions\GeneratePngChartAction;
use Modules\Performance\Data\ChartData;

class PerformanceReportService
{
    public function generateQuarterlyReport(int $year, int $quarter): array
    {
        $quarterData = $this->getQuarterlyPerformanceData($year, $quarter);

        $chartData = new ChartData(
            id: "quarterly_report_{$year}_q{$quarter}",
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12', 'Week 13'],
            values: $quarterData['scores'],
            datasets: [
                [
                    'label' => "Performance Q{$quarter} {$year}",
                    'backgroundColor' => '#007bff',
                    'borderColor' => '#0056b3',
                ]
            ]
        );

        $action = app(GeneratePngChartAction::class);
        $result = $action->execute($chartData);

        return [
            'chart_url' => $result->url,
            'chart_filename' => $result->filename,
            'quarter_data' => $quarterData,
            'generated_at' => $result->generated_at,
        ];
    }

    public function generateComparisonChart(array $datasets): array
    {
        $chartData = new ChartData(
            id: 'performance_comparison_' . time(),
            labels: $datasets['labels'],
            values: [], // Multiple datasets will be used
            datasets: $datasets['data']
        );

        $action = app(GeneratePngChartAction::class);
        $result = $action->execute($chartData);

        return [
            'chart_url' => $result->url,
            'comparison_data' => $datasets,
        ];
    }

    private function getQuarterlyPerformanceData(int $year, int $quarter): array
    {
        // Logic to get quarterly performance data
        // This would typically query the database
        return [
            'scores' => [75, 78, 82, 85, 88, 86, 90, 92, 89, 91, 94, 93, 96],
            'average' => 87.5,
            'trend' => 'increasing',
            'quarter' => $quarter,
            'year' => $year,
        ];
    }
}
```

### Bulk Chart Generation

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
use Modules\Performance\Actions\GeneratePngChartAction;
use Modules\Performance\Data\ChartData;

class GenerateBulkPngChartsAction implements ShouldQueue
{
    use QueueableAction;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute bulk chart generation.
     */
    public function execute(array $chartRequests): array
    {
        $results = [];

        foreach ($chartRequests as $request) {
            $chartData = new ChartData(
                id: $request['id'],
                labels: $request['labels'],
                values: $request['values'],
                datasets: $request['datasets'] ?? []
            );

            $action = app(GeneratePngChartAction::class);
            $result = $action->execute($chartData);

            $results[] = [
                'request_id' => $request['id'],
                'chart_url' => $result->url,
                'filename' => $result->filename,
                'size' => $result->size,
            ];
        }

        return $results;
    }
}
```

## Error Handling

```php
try {
    $result = $action->execute($chartData);
} catch (\Exception $e) {
    Log::error('PNG chart generation failed', [
        'error' => $e->getMessage(),
        'chart_data' => $chartData->toArray()
    ]);

    throw new ChartGenerationException('Failed to generate PNG chart', 0, $e);
}
```

## File Structure

```
Modules/Performance/
├── Actions/
│   ├── GenerateSvgChartAction.php
│   └── GeneratePngChartAction.php
├── Data/
│   ├── ChartData.php
│   ├── SvgResultData.php
│   └── PngResultData.php
├── resources/views/
│   └── charts/
│       └── template.blade.php
└── docs/
    └── charts/
        ├── svg-charts.md
        └── png-charts.md
```

*Last updated: December 2025*
