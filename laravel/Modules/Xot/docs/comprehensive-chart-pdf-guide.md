# Comprehensive Chart and PDF Generation Guide for Laraxot

## Table of Contents
1. [Overview](#overview)
2. [Architecture Patterns](#architecture-patterns)
3. [JpGraph Integration](#jpgraph-integration)
4. [Chart.js Integration](#chartjs-integration)
5. [SVG and PNG Generation](#svg-and-png-generation)
6. [PDF Integration](#pdf-integration)
7. [Best Practices](#best-practices)

## Overview

This guide provides a comprehensive overview of chart generation and PDF integration in the Laraxot framework. It covers how to create charts using multiple libraries (JpGraph, Chart.js), save them as SVG/PNG formats, and include them in PDF documents using Spipu HTML2PDF.

### Key Components
- **Chart Module**: Contains chart generation and styling logic
- **Quaeris Module**: Handles survey data and PDF generation
- **Xot Module**: Provides core services including HTML to PDF conversion
- **JpGraph Library**: Server-side chart generation
- **Chart.js**: Client-side chart visualization
- **Spipu HTML2PDF**: HTML to PDF conversion

## Architecture Patterns

### Action-Based Architecture

The system follows an action-based pattern for all operations:

```
Data Input → Action → Process → Output
```

#### Chart Generation Actions
- Located in: `Modules/Chart/app/Actions/JpGraph/V1/`
- Pattern: `{ChartType}Action.php` (e.g., `Pie1Action.php`)
- Uses: `QueueableAction` trait for async processing
- Input: `AnswersChartData` object
- Output: JpGraph object or SVG string

#### Example Action Structure
```php
class ExampleChartAction
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        // Extract data
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;

        // Create chart object
        $graph = new Graph($chart->width, $chart->height);

        // Apply styling and configuration
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create and configure plot
        $plot = new SomePlotType($data);
        $plot->SetLegends($labels);

        // Add to graph and return
        $graph->Add($plot);
        return $graph;
    }
}
```

### Data Flow Architecture

#### 1. Chart Data Flow
```
QuestionChart model → GetChartsDataByQuestionChart → AnswersChartData → ChartAction → JpGraph Object → PNG File
```

#### 2. PDF Generation Flow
```
SurveyPdf model → MakeHtmlBySurveyPdfModelAction → HTML Template → HtmlService::toPdf → PDF File
```

## JpGraph Integration

### Setup and Configuration

JpGraph is configured with proper constant definitions:

```php
// Fallback constant definitions for PHPStan compatibility
if (! defined('Amenadiel\\JpGraph\\FF_ARIAL')) {
    define('Amenadiel\\JpGraph\\FF_ARIAL', 1);
    define('Amenadiel\\JpGraph\\FS_BOLD', 1);
    define('Amenadiel\\JpGraph\\FS_NORMAL', 0);
}
```

### Chart Types and Actions

#### Pie Charts (`pie1`, `pieAvg`)
- **Action**: `Pie1Action`, `PieAvgAction`
- **Features**: Percentage labels, configurable center size, transparency support
- **Use Cases**: Distribution data, percentage breakdowns

#### Bar Charts (`bar1`, `bar2`, `bar3`)
- **Action**: `Bar1Action`, `Bar2Action`, `Bar3Action`
- **Features**: Multiple bar styles, value labels, axis customization
- **Use Cases**: Comparisons, time series data

#### Line Charts (`lineSubQuestion`)
- **Action**: `LineSubQuestionAction`
- **Features**: Multiple markers, smooth lines, axis configuration
- **Use Cases**: Trend analysis, time-based data

#### Horizontal Bar Charts (`horizbar1`)
- **Action**: `Horizbar1Action`
- **Features**: Horizontal orientation, value labels
- **Use Cases**: Long category labels, mobile-friendly layouts

### Styling System

#### ApplyGraphStyleAction
Handles general graph styling:
- Background colors
- Margins and padding
- Font configurations
- Border settings

#### ApplyPlotStyleAction
Handles plot-specific styling:
- Value display settings
- Color configurations
- Position formatting
- Label styling

### PNG Generation Process

#### Complete Workflow
1. **Data Preparation**: `AnswersChartData` contains chart data and configuration
2. **Action Selection**: `ChartData::getActionClass()` determines appropriate action
3. **Chart Creation**: Action creates JpGraph object with data
4. **Styling Application**: Style actions apply visual configurations
5. **PNG Output**: `Stroke()` method saves to file
6. **File Management**: Updates `QuestionChart` model with image path

#### Memory Management
```php
// In chart generation actions
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
```

## Chart.js Integration

### Data Conversion

The system provides methods to convert internal data to Chart.js compatible formats:

#### Chart.js Type Detection
```php
public function getChartJsType(): string
{
    switch ($this->chart->type) {
        case 'bar1': case 'bar2': case 'bar3': return 'bar';
        case 'pie1': case 'pieAvg': return 'doughnut';
        case 'lineSubQuestion': return 'line';
        case 'horizbar1': return 'bar';
        default: return 'bar';
    }
}
```

#### Chart.js Data Structure
```php
public function getChartJsData(): array
{
    $datasets = [];
    $labels = [];

    foreach ($this->answers as $answer) {
        $labels[] = $answer->label;
        $datasets[] = $answer->avg ?? $answer->value;
    }

    return [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => $this->chart->title ?? 'Dataset',
                'data' => $datasets,
                'backgroundColor' => $this->chart->getColorsRgba(0.6),
                'borderColor' => $this->chart->getColors(),
                'borderWidth' => 1,
            ]
        ]
    ];
}
```

### Chart.js Options Generation

#### Type-Specific Options
```php
public function getChartJsOptionsArray(): array
{
    $baseOptions = [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => ['position' => 'top'],
            'title' => [
                'display' => true,
                'text' => $this->chart->title ?? ''
            ]
        ]
    ];

    switch ($this->getChartJsType()) {
        case 'bar':
            $baseOptions['indexAxis'] = $this->chart->type === 'horizbar1' ? 'y' : 'x';
            $baseOptions['scales'] = ['y' => ['beginAtZero' => true]];
            break;
        case 'doughnut':
            $baseOptions['plugins']['legend']['position'] = 'right';
            break;
    }

    return $baseOptions;
}
```

### JavaScript Integration

#### Frontend Usage
```javascript
// In blade templates
<canvas id="chart-{{ $chart->id }}"></canvas>
<script>
    const ctx = document.getElementById('chart-{{ $chart->id }}').getContext('2d');
    const chart = new Chart(ctx, {
        type: '{{ $chartType }}',
        data: @json($chartData),
        options: @json($chartOptions)
    });
</script>
```

## SVG and PNG Generation

### PNG Generation

#### Server-Side PNG Process
```php
class MakeImgByQuestionChartModel2Action
{
    public function execute(QuestionChart $questionChart, Builder $responses, ?AnswersFilterData $answersFilterData = null): array
    {
        // Process chart data
        $datas = app(GetChartsDataByQuestionChart::class)
            ->execute($q, $responses, $answersFilterData);

        $filenames = [];

        foreach ($datas as $k => $data_answers) {
            // Create chart data objects
            $answersData = AnswersChartData::from([
                'answers' => $data_answers->answers,
                'chart' => $chart_style,
            ]);

            // Get and execute appropriate action
            $action_class = $chart_style->getActionClass();
            $graph = app($action_class)->execute($answersData);

            // Save as PNG
            $filename = 'chart/'.$q->id.'-'.$k.'.png';
            $file_path = public_path($filename);

            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            try {
                $graph->Stroke($file_path);
            } catch (\Throwable $e) {
                logger()->error('Chart generation failed', [
                    'exception' => $e->getMessage(),
                    'file_path' => $file_path,
                ]);
            }

            $filenames[] = $filename;
        }

        // Merge multiple charts if needed
        $fileName = 'chart/'.$q->id.'.png';
        $mergeAction = app(Merge::class);
        $mergeAction->execute($filenames, $fileName);

        // Update model
        $q->img_src = $fileName;
        $q->generated_at = now();
        $q->save();

        return ['filenames' => $fileName];
    }
}
```

#### PNG File Management
- **Storage**: `/public/chart/` directory
- **Naming**: `chart/{question_chart_id}-{index}.png`
- **Merged Charts**: `chart/{question_chart_id}.png`
- **Fallback**: `chart/NoDataImage.jpeg`

### SVG Generation

#### Server-Side SVG Action (Example)
```php
class ChartToSvgAction
{
    public function execute(ChartData $chartData, array $chartJsData): string
    {
        $svg = '<svg width="'.$chartData->width.'" height="'.$chartData->height.'" xmlns="http://www.w3.org/2000/svg">';

        switch ($chartData->type) {
            case 'pie1':
                $svg .= $this->generatePieChartSvg($chartJsData, $chartData);
                break;
            case 'bar1':
                $svg .= $this->generateBarChartSvg($chartJsData, $chartData);
                break;
        }

        $svg .= '</svg>';
        return $svg;
    }

    private function generatePieChartSvg(array $chartJsData, ChartData $chartData): string
    {
        $svg = '';
        $datasets = $chartJsData['datasets'][0]['data'] ?? [];
        $colors = $chartData->getColors();

        $centerX = $chartData->width / 2;
        $centerY = $chartData->height / 2;
        $radius = min($chartData->width, $chartData->height) * 0.4;

        $total = array_sum($datasets);
        $startAngle = 0;

        foreach ($datasets as $i => $value) {
            if ($total == 0) continue;

            $angle = (360 * $value) / $total;
            $endAngle = $startAngle + $angle;

            $startX = $centerX + $radius * cos(deg2rad($startAngle));
            $startY = $centerY + $radius * sin(deg2rad($startAngle));
            $endX = $centerX + $radius * cos(deg2rad($endAngle));
            $endY = $centerY + $radius * sin(deg2rad($endAngle));

            $largeArc = $angle > 180 ? 1 : 0;

            $path = "M {$centerX} {$centerY} L {$startX} {$startY} A {$radius} {$radius} 0 {$largeArc} 1 {$endX} {$endY} Z";
            $svg .= '<path d="'.$path.'" fill="'.$colors[$i % count($colors)].'" />';

            $startAngle = $endAngle;
        }

        return $svg;
    }
}
```

#### Client-Side SVG Conversion
For Chart.js to SVG conversion, libraries like `canvg` can be used:

```javascript
// Convert canvas chart to SVG
function convertChartToSvg(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext('2d');

    // Use canvg or similar library to convert canvas to SVG
    const svg = canvg.fromString(ctx.canvas.toDataURL('image/png'));
    return svg;
}
```

## PDF Integration

### PDF Generation Architecture

#### Core Components
1. **MakePdfAction** - Main PDF generation entry point
2. **MakeHtmlBySurveyPdfModelAction** - Converts data to HTML
3. **HtmlService** - HTML to PDF conversion
4. **PDF Templates** - Blade templates for structure

#### Data Flow
```
SurveyPdf → MakeHtmlBySurveyPdfModelAction → HTML Template → HtmlService → PDF File
```

### PDF Generation Process

#### MakePdfAction Implementation
```php
class MakePdfAction
{
    public function execute(SurveyPdf $surveyPdf, ?AnswersFilterData $answersFilterData = null): BinaryFileResponse|View
    {
        // Configure memory
        ini_set('memory_limit', '8095M');
        ini_set('max_execution_time', '300');

        // Generate HTML
        $html = app(MakeHtmlBySurveyPdfModelAction::class)->execute($surveyPdf);

        if (request('debug', false)) {
            return $html;
        }

        // Convert to PDF
        $content = HtmlService::toPdf(html: $out, out: 'content_PDF');

        // Create filename
        $survey_date_to = $surveyPdf->date_to;
        if ($survey_date_to === null || $survey_date_to === '[DATE]') {
            $survey_date_to = date('W / o');
        } else {
            $survey_date_to = date('W / o', strtotime($survey_date_to));
        }

        $filename = storage_path('limesurvey/'.Str::slug($surveyPdf->name.'_sett_'.$survey_date_to).'.pdf');

        // Save and return
        File::put($filename, $content);
        return response()->download($filename);
    }
}
```

### HTML to PDF Conversion

#### HtmlService Integration
```php
class HtmlService
{
    public static function toPdf(
        string $html,
        string $out = 'show',
        string $pdforientation = 'L',
        string $filename = '',
    ): string {
        if ($filename === '') {
            $filename = Storage::disk('local')->path('test.pdf');
        }

        if (request('debug', false)) {
            return $html;
        }

        try {
            $html2pdf = new Html2Pdf($pdforientation, 'A4', 'it');
            $html2pdf->setTestTdInOnePage(false);
            $html2pdf->WriteHTML($html);

            if ($out === 'content_PDF') {
                return $html2pdf->Output($filename.'.pdf', 'S');
            }

            if ($out === 'file') {
                $html2pdf->Output($filename, 'F');
                return $filename;
            }

            return $html2pdf->Output();
        } catch (Html2PdfException $html2PdfException) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($html2PdfException);
            // Handle error appropriately
        }

        return $filename;
    }
}
```

### Chart Integration in PDFs

#### Template Integration
```blade
@php
    $imgPath = public_path(ltrim($img->img_src, '/'));
@endphp

@if(File::exists($imgPath))
    <img src="{{ $imgPath }}" style="max-width: 100%; height: auto;" />
@else
    <p style="color: red;">[Chart not generated for ID {{ $img->id }}]</p>
@endif
```

### PDF Template Structure

#### Multi-Page Layout
PDFs support multi-page layouts with proper headers and footers:

```blade
@include('quaeris::pdf.css')

<page backtop="{{ $pdf->backtop }}mm" backbottom="{{ $pdf->backbottom }}mm">
    <page_header>
        <table class="page_header">
            <tr>
                <td><img src="{{ public_path($parent->logo) }}" style="height: 30mm" /></td>
            </tr>
        </table>
    </page_header>

    <!-- Chart content -->
    @foreach ($rows as $row)
        <page pageset="old">
            <table class="tablechart">
                <!-- Chart images -->
            </table>
        </page>
    @endforeach

    <page_footer>
        <table class="page_footer">
            <tr>
                <td>[[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
</page>
```

## Best Practices

### 1. Chart Type Selection
- **Pie Charts**: Use for percentage/part-of-whole data (≤7 categories)
- **Bar Charts**: Use for comparisons or when you have many categories
- **Line Charts**: Use for time series or trend data
- **Horizontal Bars**: Use when category labels are long

### 2. Performance Optimization
- **Use Queued Actions**: For batch processing of multiple charts
- **Implement Caching**: Store generated charts and reuse when data hasn't changed
- **Optimize Memory**: Set appropriate limits for large datasets
- **Batch Processing**: Process charts in smaller chunks for large surveys

### 3. Styling Consistency
- **Color Palettes**: Define and reuse consistent color schemes
- **Font Families**: Use consistent fonts across all charts and PDFs
- **Sizing**: Maintain consistent chart dimensions for visual uniformity
- **Accessibility**: Ensure sufficient color contrast and readable fonts

### 4. Error Handling
- **File Existence**: Always check if chart images exist before including in PDF
- **Fallback Images**: Provide fallback images or text when chart generation fails
- **Logging**: Log errors for debugging and monitoring
- **Graceful Degradation**: Continue PDF generation even if some charts fail

### 5. Security Considerations
- **Input Validation**: Validate all chart data and parameters
- **File Path Security**: Use `public_path()` and validate file existence
- **HTML Sanitization**: Sanitize HTML content before PDF generation
- **Access Control**: Ensure PDF files are properly protected

### 6. Configuration Management
- **Template Selection**: Allow users to choose PDF templates
- **Styling Options**: Provide configuration for colors, fonts, dimensions
- **Export Options**: Support different export formats and quality settings
- **Performance Settings**: Allow configuration of memory and time limits

### 7. Maintenance and Monitoring
- **Chart Regeneration**: Implement systems to regenerate charts when data changes
- **File Cleanup**: Regular cleanup of old chart images
- **Performance Monitoring**: Monitor generation times and memory usage
- **Error Tracking**: Track and fix common generation errors

This comprehensive system allows for flexible, scalable chart generation and PDF integration while maintaining the architectural principles of the Laraxot framework. The modular design allows for easy extension and customization while providing robust error handling and performance optimization.
