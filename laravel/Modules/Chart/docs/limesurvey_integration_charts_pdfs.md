# LimeSurvey Integration, Filament 4 Charting, and PDF Generation in Laraxot

This document provides guidelines for integrating concepts from LimeSurvey, implementing professional charts within Filament 4, and generating dynamic PDFs containing these charts, all within the Laraxot framework.

## 1. Introduction to LimeSurvey Integration in Laraxot/Filament 4

LimeSurvey is a powerful, open-source web-based survey platform. When integrating its functionalities or data into a Laraxot/Filament 4 application, consider the following approaches:

*   **Data Synchronization:** If survey data needs to be deeply integrated with your application's models, consider setting up a mechanism to synchronize relevant survey responses from LimeSurvey's database into your Laravel application's database. This could involve direct database connections (read-only), ETL processes, or webhooks from LimeSurvey.
*   **API Usage:** LimeSurvey offers a RemoteControl API. This can be leveraged to programmatically create surveys, manage participants, and retrieve responses. This approach keeps LimeSurvey as the primary data store and uses your Laravel application to interact with it.
*   **Conceptual Mapping:** Even if direct integration isn't required, understanding LimeSurvey's data structures (e.g., question types, answer formats, survey logic) is crucial for designing compatible features within your Laraxot application that might mimic or extend survey capabilities.

For the purpose of charting and PDF generation, we will assume survey response data is accessible within the Laravel application, either directly from its own database or fetched via an API/synchronization.

## 2. Filament 4 Charting for Survey Data

Filament 4 provides an excellent way to visualize survey data using its built-in Chart.js integration.

### 2.1. Utilizing Filament's `ChartWidget`

To create a chart for survey data, you'll typically extend Filament's `ChartWidget`.

```php
// Modules/Chart/Filament/Widgets/SurveyResponsesChart.php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB; // Example for raw data or complex queries
use Modules\YourModule\Models\SurveyResponse; // Assuming a SurveyResponse model

class SurveyResponsesChart extends ChartWidget
{
    protected static ?string $heading = 'Survey Responses Over Time';
    protected static ?string $maxHeight = '300px'; // Adjust height as needed

    protected function getType(): string
    {
        return 'line'; // or 'bar', 'pie', etc.
    }

    protected function getData(): array
    {
        // Example: Counting survey responses per month
        // Adapt this query based on how your survey response data is structured
        $data = Trend::model(SurveyResponse::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Responses',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#22c55e', // Example green
                    'borderColor' => '#16a34a',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    /**
     * Customize Chart.js options
     */
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1, // Ensure whole numbers for counts
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
```

### 2.2. Data Preparation from Survey Responses

*   **Eloquent Models:** If you've synchronized LimeSurvey data into your own Eloquent models (e.g., `SurveyResponse`, `QuestionAnswer`), you can query these models directly using Laravel's ORM.
*   **Raw Database Queries:** For complex aggregations or direct interaction with LimeSurvey's database (if read-only access is configured), use `Illuminate\Support\Facades\DB` for raw SQL queries.
*   **`flowframe/laravel-trend`:** This package is highly recommended for generating time-series data for your charts. It simplifies common aggregations like counting or summing data `perDay()`, `perMonth()`, `perYear()`.

### 2.3. Best Practices for Professional Charts

*   **Choose the Right Chart Type:**
    *   **Line:** Trends over time (e.g., responses per day, average score over weeks).
    *   **Bar:** Comparisons between discrete categories (e.g., responses per question, distribution of answers for a multiple-choice question).
    *   **Pie/Doughnut:** Proportions of a whole (e.g., percentage of 'Yes/No' answers).
*   **Clarity and Simplicity:**
    *   **Clear Headings and Labels:** Ensure `static ?string $heading` is descriptive. Labels in `getData()` should be understandable.
    *   **Avoid Clutter:** Only display necessary information. Use filters (`protected function getFilters(): ?array`) to allow users to refine data.
*   **Responsiveness & Performance:** Filament charts are generally responsive. For performance, optimize your data queries. If dealing with large datasets, consider caching chart data.
*   **Customization:** Use the `getOptions()` method to fine-tune Chart.js appearance (colors, tooltips, scales, legends) to match your application's theme and data representation needs.

## 3. Generating PDFs with Dynamic Charts from Survey Data

For generating PDFs that include dynamically rendered charts, `spatie/browsershot` is the most robust solution within Laravel due to its use of a headless browser (Puppeteer) which executes JavaScript.

### 3.1. Installation and Setup

1.  **Install Browsershot:**
    ```bash
    composer require spatie/browsershot
    ```
2.  **Install Puppeteer (Globally or Locally):**
    ```bash
    npm install puppeteer --global # Recommended for development environment
    # Or, for production, ensure Puppeteer is installed in your deployment environment
    ```
3.  **Publish Browsershot Config (Optional but Recommended):**
    ```bash
    php artisan vendor:publish --provider="Spatie\Browsershot\BrowsershotServiceProvider" --tag="browsershot-config"
    ```
    Adjust `config/browsershot.php` if Node.js/NPM/Puppeteer executables are not in your system's PATH.

### 3.2. Creating a Blade View for the PDF Content

Create a dedicated Blade view that will be rendered into HTML and then converted to PDF. This view must include the Chart.js library and the JavaScript logic to draw the charts.

```blade
{{-- Modules/Chart/resources/views/pdfs/survey-report.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Survey Report</title>
    <style>
        /* Inline CSS for consistent styling in PDF */
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2 { color: #333; }
        .chart-container {
            width: 100%; /* Adjust as needed */
            height: 400px; /* Crucial for Chart.js rendering */
            margin: 20px auto;
            page-break-inside: avoid; /* Prevent charts from splitting across pages */
        }
        /* Media queries for print-specific styles can be added here */
        @media print {
            body { font-size: 10pt; }
            .chart-container { height: 300px; } /* Smaller charts for print */
        }
    </style>
    <!-- Chart.js library - use a CDN or local asset if bundled -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
</head>
<body>
    <h1>Comprehensive Survey Report: {{ $surveyTitle }}</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i') }}</p>

    <h2>Response Distribution</h2>
    <div class="chart-container">
        <canvas id="responseDistributionChart"></canvas>
    </div>

    @if (!empty($questionSpecificCharts))
        <h2>Question Specific Analysis</h2>
        @foreach ($questionSpecificCharts as $chartId => $chart)
            <h3>{{ $chart['title'] }}</h3>
            <div class="chart-container">
                <canvas id="{{ $chartId }}"></canvas>
            </div>
        @endforeach
    @endif

    <script>
        // Register Chart.js DataLabels plugin globally (optional)
        Chart.register(ChartDataLabels);

        // Data for response distribution chart
        const responseDistributionData = @json($responseDistributionData);
        if (responseDistributionData) {
            const rdCtx = document.getElementById('responseDistributionChart').getContext('2d');
            new Chart(rdCtx, {
                type: 'bar',
                data: {
                    labels: responseDistributionData.labels,
                    datasets: [{
                        label: 'Number of Responses',
                        data: responseDistributionData.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: { // Example plugin option
                            color: '#fff',
                            formatter: (value, context) => value
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Question-specific charts
        const questionSpecificChartsData = @json($questionSpecificCharts ?? []);
        for (const chartId in questionSpecificChartsData) {
            if (questionSpecificChartsData.hasOwnProperty(chartId)) {
                const chartConfig = questionSpecificChartsData[chartId];
                const qsCtx = document.getElementById(chartId).getContext('2d');
                new Chart(qsCtx, {
                    type: chartConfig.type,
                    data: chartConfig.data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: chartConfig.type !== 'pie' && chartConfig.type !== 'doughnut'
                            },
                            datalabels: {
                                color: '#fff',
                                formatter: (value, context) => value
                            }
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
```

### 3.3. Passing Dynamic Survey Data from Laravel to JavaScript

In your Blade view, use `@json($yourLaravelData)` to safely encode PHP arrays/objects into JSON, making them accessible to your JavaScript.

### 3.4. Filament Integration: Triggering PDF Generation

You can create a Filament action (e.g., on a resource page or table) to generate the PDF.

```php
// Modules/Chart/Filament/Resources/SurveyResource/Pages/ListSurveys.php
<?php

namespace Modules\Chart\Filament\Resources\SurveyResource\Pages;

use Modules\Chart\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Response;
use Modules\YourModule\Models\Survey; // Assuming a Survey model
use Modules\YourModule\Models\SurveyResponse; // Assuming SurveyResponse model

class ListSurveys extends ListRecords
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('generateOverallReport')
                ->label('Generate Overall Survey Report')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    // 1. Fetch and prepare data for the PDF
                    $surveyTitle = 'Customer Satisfaction Survey'; // Dynamic title
                    $responseDistributionData = [
                        'labels' => ['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied'],
                        'data' => [250, 400, 150, 80, 20], // Example data
                    ];

                    // Example for question-specific charts (dynamic keys are important)
                    $questionSpecificCharts = [
                        'q1_chart' => [
                            'title' => 'Question 1: Service Quality',
                            'type' => 'pie',
                            'data' => [
                                'labels' => ['Excellent', 'Good', 'Fair', 'Poor'],
                                'datasets' => [[
                                    'data' => [60, 30, 8, 2],
                                    'backgroundColor' => ['#4CAF50', '#8BC34A', '#FFEB3B', '#F44336'],
                                ]]
                            ],
                        ],
                        'q2_chart' => [
                            'title' => 'Question 2: Ease of Use',
                            'type' => 'bar',
                            'data' => [
                                'labels' => ['Very Easy', 'Easy', 'Neutral', 'Hard', 'Very Hard'],
                                'datasets' => [[
                                    'label' => 'Count',
                                    'data' => [300, 250, 100, 50, 10],
                                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                                ]]
                            ],
                        ],
                    ];

                    // 2. Render the Blade view to HTML
                    $html = Blade::render('chart::pdfs.survey-report', compact(
                        'surveyTitle',
                        'responseDistributionData',
                        'questionSpecificCharts'
                    ));

                    // 3. Generate PDF using Browsershot
                    // Ensure puppeteer is installed and accessible
                    $pdf = Browsershot::html($html)
                        // Important: Give charts time to render (adjust as needed)
                        ->setDelay(3000)
                        ->format('A4')
                        ->landscape() // Or portrait()
                        ->showBackground() // Ensure background colors/images are rendered
                        ->setNodeBinary(config('browsershot.node_binary', '/usr/bin/node')) // Example path
                        ->setNpmBinary(config('browsershot.npm_binary', '/usr/bin/npm'))   // Example path
                        ->pdf();

                    // 4. Return the PDF as a download response
                    return Response::streamDownload(function () use ($pdf) {
                        echo $pdf;
                    }, 'overall-survey-report-' . now()->format('YmdHis') . '.pdf');
                }),
        ];
    }
}
```
*Note the use of `chart::pdfs.survey-report` for the Blade view, assuming your `ChartServiceProvider` loads views from `resources/views` under the `chart` namespace.*

### 3.5. Key Considerations for PDF Generation

*   **`setDelay(milliseconds)`:** This is critical. Chart.js needs time to render the charts in the headless browser. Increase this value if charts are missing or incomplete in the generated PDF.
*   **CSS for Print:** Use `@media print` queries in your CSS to tailor styles specifically for the PDF output, such as adjusting font sizes, hiding unnecessary elements, or optimizing layout.
*   **External Assets:** While Browsershot handles external assets, for critical styling and scripts, consider inlining them directly into the Blade view to ensure reliability.
*   **Performance:** Generating complex PDFs can be resource-intensive. For production environments with high usage, consider offloading PDF generation to a background queue using Laravel's queue system.
*   **Paths to Node/NPM:** Ensure `setNodeBinary()` and `setNpmBinary()` are correctly configured in `config/browsershot.php` or directly in the `Browsershot` call if Node.js/NPM are not in standard system paths on your server.
*   **`page-break-inside: avoid;`:** Use this CSS property on chart containers (`.chart-container`) to prevent charts from being awkwardly split across page breaks in the PDF.

## 4. Adherence to Laraxot and Coding Standards

When implementing any of the above, ensure strict adherence to Laraxot principles and the coding standards outlined in `coding_standards.md`:

*   **DRY, KISS, SOLID, Robust:** Design your data fetching, charting logic, and PDF generation to be clean, simple, and maintainable.
*   **PHPStan Level 10:** Ensure all code passes PHPStan analysis. Pay particular attention to array type hinting, especially `array<string, Type>` for Filament actions and data structures passed to JavaScript. Avoid `mixed` types.
*   **Method Length/Complexity:** Keep methods concise (ideally < 60 LOC) and focused on a single responsibility.
*   **Type Safety:** Utilize strict typing (`declare(strict_types=1);`, type hints) throughout your PHP code.
*   **Naming Conventions:** Use clear, descriptive names for all classes, methods, variables, and files.
*   **Comments:** Use comments to explain *why* complex logic exists, not *what* it does.
*   **Filament Extensions:** Always extend `XotBase` classes where appropriate for Filament components (e.g., `XotBaseChartWidget` if available, or `XotBasePage` for page actions). This document uses standard Filament classes for brevity in examples, but in a real Laraxot project, these should be replaced with their `XotBase` counterparts.
*   **Modular Documentation:** Keep documentation related to a module within its `docs/` folder, using lowercase filenames (e.g., `limesurvey_integration_charts_pdfs.md`). Use relative links for any internal references.

By following these guidelines, you can effectively integrate survey analytics and reporting into your Laraxot/Filament 4 application.