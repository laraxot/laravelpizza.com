# Chart Module Documentation

## Overview
The Chart module provides professional data visualization capabilities for the Laraxot system, with special integration for LimeSurvey survey data. It offers multiple chart types, export capabilities, and seamless integration with the Quaeris survey management system. The module leverages dynamic models from LimeSurvey to access survey response data efficiently.

## Key Features
- **Multiple Chart Types**: Support for pie, bar, line, and mixed charts
- **PDF Integration**: Direct export to PDF with chart embedding using HTML2PDF, Spatie PDF, and JpGraph
- **LimeSurvey Integration**: Direct integration with LimeSurvey dynamic models (SurveyResponse, TokensResponse)
- **Export Capabilities**: PNG, SVG, and PDF export options
- **Real-time Updates**: Live chart updates with polling
- **Customizable Styling**: Extensive styling options for all chart elements

## Core Components

### Models
- `Chart` - Chart configuration and metadata
- `ChartData` - Chart data processing and formatting
- `ChartExport` - Chart export configuration and history

### Services
- `ChartService` - Core chart generation and management
- `ChartExportService` - Chart export and conversion
- `ChartIntegrationService` - Integration with other modules

## Chart Types

### Pie Charts
- `pie1` - Basic pie chart
- `pieAvg` - Pie chart with average calculation

### Bar Charts
- `bar1`, `bar2`, `bar3` - Vertical bar charts
- `horizbar1`, `horizbar2` - Horizontal bar charts

### Line Charts
- `line1` - Basic line chart
- `lineSubQuestion` - Line chart for sub-questions

### Mixed Charts
- `mixed:X` - Mixed chart configurations combining multiple chart types

## Chart Integration with LimeSurvey Dynamic Models and Flip Approach

### Data Access Pattern - Traditional Dynamic Models
The Chart module integrates with LimeSurvey using dynamic models that allow access to survey-specific response tables:

```php
use Modules\Limesurvey\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;

class ChartDataService
{
    public function getSurveyChartData(string $surveyId, string $fieldName, array $options = []): array
    {
        // Use dynamic SurveyResponse model to access lime_survey_{SID} table
        $query = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->orderBy('count', 'desc');
            
        // Apply date filters if specified
        if (isset($options['date_from'])) {
            $query->where('submitdate', '>=', $options['date_from']);
        }
        
        if (isset($options['date_to'])) {
            $query->where('submitdate', '<=', $options['date_to']);
        }
        
        // Apply limits
        if (isset($options['limit'])) {
            $query->limit($options['limit']);
        }
        
        $results = $query->get();
        
        return [
            'labels' => $results->pluck('answer')->toArray(),
            'values' => $results->pluck('count')->toArray(),
            'total_responses' => $results->sum('count')
        ];
    }
}
```

### Data Access Pattern - Flip Approach
The Chart module also supports the flip approach using the SurveyFlipResponse model:

```php
use Modules\Limesurvey\Models\SurveyFlipResponse;
use Illuminate\Support\Facades\DB;

class FlipChartDataService
{
    public function getSurveyChartData(string $surveyId, string $questionId, array $options = []): array
    {
        // Use SurveyFlipResponse model for EAV-based queries
        $query = SurveyFlipResponse::where('survey_id', $surveyId)
            ->where('question_id', $questionId);
            
        // Apply date filters if specified
        if (isset($options['date_from'])) {
            $query->where('submitdate', '>=', $options['date_from']);
        }
        
        if (isset($options['date_to'])) {
            $query->where('submitdate', '<=', $options['date_to']);
        }
        
        // Apply additional filters using available scopes
        if (isset($options['filter'])) {
            $query->ofFilterData($options['filter']);
        }
        
        $results = $query->select([
            'answer',
            DB::raw('COUNT(*) as count')
        ])
        ->whereNotNull('answer')
        ->groupBy('answer')
        ->orderBy('count', 'desc');
        
        // Apply limits
        if (isset($options['limit'])) {
            $results->limit($options['limit']);
        }
        
        $results = $results->get();
        
        return [
            'labels' => $results->pluck('answer')->toArray(),
            'values' => $results->pluck('count')->toArray(),
            'total_responses' => $results->sum('count')
        ];
    }
    
    public function getTrendData(string $surveyId, string $questionId, string $timeUnit = 'month', array $options = []): array
    {
        $dateGrouping = match($timeUnit) {
            'day' => 'DATE(submitdate)',
            'week' => 'YEARWEEK(submitdate)',
            'month' => 'DATE_FORMAT(submitdate, "%Y-%m")',
            'year' => 'YEAR(submitdate)',
            default => 'DATE(submitdate)',
        };
        
        $query = SurveyFlipResponse::where('survey_id', $surveyId)
            ->where('question_id', $questionId)
            ->select([
                DB::raw("{$dateGrouping} as date"),
                'answer',
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull('answer')
            ->whereNotNull('submitdate');
            
        // Apply date filters
        if (isset($options['date_from'])) {
            $query->where('submitdate', '>=', $options['date_from']);
        }
        
        if (isset($options['date_to'])) {
            $query->where('submitdate', '<=', $options['date_to']);
        }
        
        $results = $query->groupBy(DB::raw($dateGrouping), 'answer')
            ->orderBy('date')
            ->get();
            
        // Format results for chart
        $formatted = [];
        foreach ($results as $result) {
            $date = $result->date;
            if (!isset($formatted[$date])) {
                $formatted[$date] = ['date' => $date, 'values' => []];
            }
            $formatted[$date]['values'][] = $result->count;
        }
        
        return array_values($formatted);
    }
}
```

### Chart Generation with Both Approaches
```php
use Modules\Limesurvey\Models\SurveyResponse;
use Modules\Limesurvey\Models\SurveyFlipResponse;

class DualApproachChartGenerator
{
    public function generateChartFromSurveyData(Chart $chart, string $surveyId, string $identifier, string $title, string $approach = 'dynamic'): string
    {
        if ($approach === 'flip') {
            // Use question_id for flip approach
            $data = app(FlipChartDataService::class)
                ->getSurveyChartData($surveyId, $identifier);
        } else {
            // Use field_name for dynamic approach
            $data = app(ChartDataService::class)
                ->getSurveyChartData($surveyId, $identifier);
        }
        
        if (empty($data['labels'])) {
            // Create placeholder chart
            return $this->createPlaceholderChart($title);
        }
        
        $graph = $this->createGraph($chart, $title, $data['labels']);
        $plot = $this->createPlot($chart->type, $data['values']);
        
        // Apply styling
        $plot->SetFillColor($chart->list_color ?? '#3b82f6');
        $this->applyValueLabels($plot);
        
        $graph->Add($plot);
        
        // Generate chart image
        $filename = 'charts/' . $chart->id . '_' . time() . '_' . $approach . '.png';
        $fullPath = public_path($filename);
        
        $this->ensureDirectoryExists($fullPath);
        $graph->Stroke($fullPath);
        
        return $filename;
    }
    
    public function generateComparisonChart(Chart $chart, string $surveyId, string $questionId, string $fieldName, string $title): string
    {
        // Get data from both approaches
        $dynamicData = app(ChartDataService::class)
            ->getSurveyChartData($surveyId, $fieldName);
        
        $flipData = app(FlipChartDataService::class)
            ->getSurveyChartData($surveyId, $questionId);
        
        // Combine data for comparison
        $labels = array_unique(array_merge(
            $dynamicData['labels'], 
            $flipData['labels']
        ));
        
        // Generate comparison chart
        $graph = $this->createComparisonGraph($chart, $title, $labels);
        
        $dynamicPlot = new \BarPlot($this->alignData($dynamicData['values'], $labels, $dynamicData['labels']));
        $dynamicPlot->SetFillColor('#3b82f6');
        $dynamicPlot->SetLegend('Dynamic Approach');
        
        $flipPlot = new \BarPlot($this->alignData($flipData['values'], $labels, $flipData['labels']));
        $flipPlot->SetFillColor('#ef4444');
        $flipPlot->SetLegend('Flip Approach');
        
        $groupPlot = new \GroupBarPlot([$dynamicPlot, $flipPlot]);
        $graph->Add($groupPlot);
        
        // Generate chart image
        $filename = 'charts/' . $chart->id . '_comparison_' . time() . '.png';
        $fullPath = public_path($filename);
        
        $this->ensureDirectoryExists($fullPath);
        $graph->Stroke($fullPath);
        
        return $filename;
    }
    
    private function alignData(array $sourceValues, array $targetLabels, array $sourceLabels): array
    {
        $aligned = [];
        foreach ($targetLabels as $label) {
            $index = array_search($label, $sourceLabels);
            $aligned[] = $index !== false ? $sourceValues[$index] : 0;
        }
        return $aligned;
    }
    
    // ... other methods remain the same
}
```

### When to Use Each Approach for Charts

#### Use Dynamic Models (SurveyResponse) When:
- Working with the original LimeSurvey field structure
- Need to access specific field names as they exist in LimeSurvey
- Performance is critical for single-survey operations
- You want to maintain direct compatibility with LimeSurvey's native format

#### Use Flip Approach (SurveyFlipResponse) When:
- Building cross-survey analytics
- Need standardized question-based access
- Creating complex analytical charts
- Working with alert systems and threshold monitoring
- Building dashboards that span multiple question types

For more detailed information about the flip approach, see the [LimeSurvey Survey Flip Approach](../../Limesurvey/docs/survey-flip-approach.md) documentation.

### Chart Configuration Model
```php
class Chart extends BaseModel
{
    protected $fillable = [
        'id', 'type', 'width', 'height', 'font_family', 
        'font_style', 'font_size', 'list_color', 'group_by',
        'sort_by', 'show_box', 'transparency', 'name'
    ];
    
    // Font Family Constants
    public const FF_COURIER = 10;
    public const FF_VERDANA = 11;
    public const FF_TIMES = 12;
    public const FF_COMIC = 14;
    public const FF_ARIAL = 15;  // Default
    public const FF_GEORGIA = 16;
    public const FF_TREBUCHE = 17;
    
    // Font Style Constants
    public const FS_NORMAL = 9001;
    public const FS_BOLD = 9002;  // Default
    public const FS_ITALIC = 9003;
    public const FS_BOLDITALIC = 9004;
    
    public function getFontFamilyName(): string
    {
        return match($this->font_family) {
            self::FF_COURIER => 'Courier',
            self::FF_VERDANA => 'Verdana',
            self::FF_TIMES => 'Times',
            self::FF_COMIC => 'Comic',
            self::FF_ARIAL => 'Arial',  // Default
            self::FF_GEORGIA => 'Georgia',
            self::FF_TREBUCHE => 'Trebuchet',
            default => 'Arial',
        };
    }
    
    public function getFontStyleName(): string
    {
        return match($this->font_style) {
            self::FS_NORMAL => 'Normal',
            self::FS_BOLD => 'Bold',  // Default
            self::FS_ITALIC => 'Italic',
            self::FS_BOLDITALIC => 'Bold Italic',
            default => 'Bold',
        };
    }
}
```

## Chart Generation with Dynamic Models

### Server-Side Chart Generation using JpGraph
```php
use Modules\Limesurvey\Models\SurveyResponse;

class JpGraphGenerator
{
    public function generateChartFromSurveyData(Chart $chart, string $surveyId, string $fieldName, string $title): string
    {
        $data = app(ChartDataService::class)
            ->getSurveyChartData($surveyId, $fieldName);
            
        if (empty($data['labels'])) {
            // Create placeholder chart
            return $this->createPlaceholderChart($title);
        }
        
        $graph = $this->createGraph($chart, $title, $data['labels']);
        $plot = $this->createPlot($chart->type, $data['values']);
        
        // Apply styling
        $plot->SetFillColor($chart->list_color ?? '#3b82f6');
        $this->applyValueLabels($plot);
        
        $graph->Add($plot);
        
        // Generate chart image
        $filename = 'charts/' . $chart->id . '_' . time() . '.png';
        $fullPath = public_path($filename);
        
        $this->ensureDirectoryExists($fullPath);
        $graph->Stroke($fullPath);
        
        return $filename;
    }
    
    private function createGraph(Chart $chart, string $title, array $labels): \Graph
    {
        $graph = new \Graph($chart->width ?? 800, $chart->height ?? 400);
        $graph->SetScale('textlin');
        
        // Set title with font configuration
        $graph->title->Set($title);
        $graph->title->SetFont(
            $this->mapFontFamily($chart->font_family), 
            $this->mapFontStyle($chart->font_style), 
            $chart->font_size ?? 12
        );
        
        // Set labels if applicable
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
            if (count($labels) > 5) {
                $graph->xaxis->SetLabelAngle(45);
            }
        }
        
        return $graph;
    }
    
    private function createPlot(string $type, array $values)
    {
        switch ($type) {
            case 'pie1':
            case 'pieAvg':
                return new \PiePlot($values);
            case 'line1':
            case 'lineSubQuestion':
                return new \LinePlot($values);
            case 'horizbar1':
            case 'horizbar2':
                // Need to set up horizontal scale
                return new \BarPlot($values);
            case 'bar1':
            case 'bar2':
            case 'bar3':
            default:
                return new \BarPlot($values);
        }
    }
    
    private function applyValueLabels($plot): void
    {
        if (method_exists($plot, 'value')) {
            $plot->value->Show();
            $plot->value->SetFormat('%.0f');
        }
    }
    
    private function mapFontFamily(?int $fontFamily): int
    {
        return $fontFamily ?? Chart::FF_ARIAL;
    }
    
    private function mapFontStyle(?int $fontStyle): int
    {
        return $fontStyle ?? Chart::FS_BOLD;
    }
    
    private function ensureDirectoryExists(string $fullPath): void
    {
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    private function createPlaceholderChart(string $title): string
    {
        $image = imagecreate(800, 400);
        $background = imagecolorallocate($image, 249, 250, 251); // bg-gray-50
        $textColor = imagecolorallocate($image, 107, 114, 128); // gray-500
        
        imagestring($image, 5, 10, 190, 'No data available for: ' . $title, $textColor);
        imagestring($image, 5, 10, 210, 'Please check your survey responses.', $textColor);
        
        $filename = 'charts/placeholder_' . time() . '.png';
        $fullPath = public_path($filename);
        
        imagepng($image, $fullPath);
        imagedestroy($image);
        
        return $filename;
    }
}
```

## Chart Export with PDF Integration

### Multi-Engine PDF Generation
```php
use Modules\Limesurvey\Models\SurveyResponse;

class ChartPdfExporter
{
    public function generatePdfWithCharts(array $charts, string $surveyId, array $options = []): string
    {
        $chartGenerator = new JpGraphGenerator();
        $chartImages = [];
        
        foreach ($charts as $chart) {
            $imagePath = $chartGenerator->generateChartFromSurveyData(
                $chart,
                $surveyId,
                $options['field_name'] ?? '',
                $options['title'] ?? 'Chart'
            );
            $chartImages[] = $imagePath;
        }
        
        // Use Spipu\Html2Pdf to generate PDF
        $html = $this->buildPdfHtml($charts, $chartImages);
        
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'en');
        $html2pdf->setTestIsImage(true);
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($html);
        
        $filename = 'chart_report_' . date('Y-m-d') . '.pdf';
        $path = storage_path('app/chart_reports/' . $filename);
        $html2pdf->output($path, 'F');
        
        // Clean up temporary images
        $this->cleanupTempImages($chartImages);
        
        return $path;
    }
    
    private function buildPdfHtml(array $charts, array $chartImages): string
    {
        $html = '<page backtop="20mm" backbottom="20mm" backleft="15mm" backright="15mm">';
        $html .= '<h1 style="text-align: center; font-size: 18pt; margin-bottom: 20px;">Survey Chart Report</h1>';
        
        foreach ($charts as $index => $chart) {
            if (isset($chartImages[$index])) {
                $html .= '<div style="margin: 20px 0; page-break-inside: avoid;">';
                $html .= '<h2 style="font-size: 14pt; margin-bottom: 10px;">' . e($chart->name ?? 'Chart') . '</h2>';
                $html .= '<img src="' . public_path($chartImages[$index]) . '" style="width: 100%; height: auto;">';
                $html .= '</div>';
            }
        }
        
        $html .= '</page>';
        
        return $html;
    }
    
    public function generatePdfWithSpatie(array $charts, string $surveyId, array $options = []): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $chartGenerator = new JpGraphGenerator();
        $chartData = [];
        
        foreach ($charts as $chart) {
            $imagePath = $chartGenerator->generateChartFromSurveyData(
                $chart,
                $surveyId,
                $options['field_name'] ?? '',
                $options['title'] ?? 'Chart'
            );
            
            $imageData = file_get_contents(public_path($imagePath));
            $base64Image = 'data:image/png;base64,' . base64_encode($imageData);
            
            $chartData[] = [
                'name' => $chart->name ?? 'Chart',
                'image_base64' => $base64Image
            ];
        }
        
        return \Spatie\LaravelPdf\Facades\Pdf::view('charts.spatie-report', [
            'charts' => $chartData,
            'title' => $options['title'] ?? 'Survey Chart Report',
            'date' => now()
        ])
        ->format('a4')
        ->name('chart_report_' . date('Y-m-d') . '.pdf');
    }
    
    private function cleanupTempImages(array $images): void
    {
        foreach ($images as $imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
```

## Chart Widget Integration

### ChartWidget with Dynamic Data
```php
use Modules\Limesurvey\Models\SurveyResponse;

class ChartWidget extends XotBaseWidget
{
    protected static ?string $pollingInterval = '30s';
    
    public string $surveyId = '';
    public string $fieldName = '';
    public string $chartType = 'bar';
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true],
                'datalabels' => [
                    'display' => true,
                    'anchor' => 'end',
                    'align' => 'top',
                ],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
        ];
    }
    
    protected function getChartData(): array
    {
        if (empty($this->surveyId) || empty($this->fieldName)) {
            return [
                'datasets' => [
                    [
                        'label' => 'No Data',
                        'data' => [],
                        'backgroundColor' => '#e5e7eb',
                    ],
                ],
                'labels' => [],
            ];
        }
        
        // Get data using dynamic SurveyResponse model
        $data = app(ChartDataService::class)
            ->getSurveyChartData($this->surveyId, $this->fieldName);
        
        return [
            'datasets' => [
                [
                    'label' => 'Responses',
                    'data' => $data['values'],
                    'backgroundColor' => $this->getChartColors(count($data['values'])),
                ],
            ],
            'labels' => $data['labels'],
        ];
    }
    
    private function getChartColors(int $count): array
    {
        $colors = [
            '#3b82f6', '#ef4444', '#10b981', '#f59e0b',
            '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'
        ];
        
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $colors[$i % count($colors)];
        }
        
        return $result;
    }
    
    public function exportToPng(string $pngBase64): void
    {
        $filename = 'charts/widget_export_' . time() . '.png';
        $imageData = base64_decode($pngBase64);
        file_put_contents(public_path($filename), $imageData);
        
        // Optionally save to database for later access
        // ChartExport::create([
        //     'chart_id' => $this->chartId,
        //     'file_path' => $filename,
        //     'format' => 'png',
        //     'exported_at' => now(),
        // ]);
    }
    
    public function exportToPdf(string $engine = 'html2pdf'): void
    {
        $chart = new Chart([
            'type' => $this->chartType,
            'width' => 800,
            'height' => 400,
            'name' => 'Widget Chart Export'
        ]);
        
        $exporter = new ChartPdfExporter();
        
        if ($engine === 'spatie') {
            $exporter->generatePdfWithSpatie([$chart], $this->surveyId, [
                'field_name' => $this->fieldName,
                'title' => 'Survey Chart Report'
            ]);
        } else {
            $exporter->generatePdfWithCharts([$chart], $this->surveyId, [
                'field_name' => $this->fieldName,
                'title' => 'Survey Chart Report'
            ]);
        }
    }
}
```

## Advanced Chart Features

### Mixed Chart Support
```php
use Modules\Limesurvey\Models\SurveyResponse;

class MixedChartGenerator
{
    public function generateMixedChart(array $config, string $surveyId): string
    {
        // Parse mixed chart configuration (e.g., "mixed:pie1,bar2,line1")
        $parts = explode(':', $config['type']);
        if (count($parts) !== 2) {
            throw new \InvalidArgumentException('Invalid mixed chart type');
        }
        
        $chartTypes = explode(',', $parts[1]);
        
        // Get data using dynamic SurveyResponse model
        $data = app(ChartDataService::class)
            ->getSurveyChartData($surveyId, $config['field_name']);
        
        // Generate multiple charts and combine them
        $chartImages = [];
        foreach ($chartTypes as $type) {
            $chart = new Chart([
                'type' => trim($type),
                'width' => ($config['width'] ?? 800) / count($chartTypes),
                'height' => $config['height'] ?? 400,
                'name' => $config['name'] . ' - ' . trim($type)
            ]);
            
            $generator = new JpGraphGenerator();
            $imagePath = $generator->generateChartFromSurveyData(
                $chart,
                $surveyId,
                $config['field_name'],
                $config['name'] . ' - ' . trim($type)
            );
            
            $chartImages[] = $imagePath;
        }
        
        // Combine images into single chart (simplified approach)
        return $this->combineChartImages($chartImages, $config);
    }
    
    private function combineChartImages(array $imagePaths, array $config): string
    {
        // Create a new image to combine all chart images
        $totalWidth = $config['width'] ?? 800;
        $height = $config['height'] ?? 400;
        $cols = count($imagePaths);
        $singleWidth = $totalWidth / $cols;
        
        $combinedImage = imagecreate($totalWidth, $height);
        
        // Fill background
        $bgColor = imagecolorallocate($combinedImage, 255, 255, 255);
        imagefill($combinedImage, 0, 0, $bgColor);
        
        foreach ($imagePaths as $index => $path) {
            $chartImage = imagecreatefrompng(public_path($path));
            if ($chartImage) {
                $srcWidth = imagesx($chartImage);
                $srcHeight = imagesy($chartImage);
                
                // Calculate position
                $xPos = $index * $singleWidth;
                
                // Copy chart image to combined image
                imagecopyresampled(
                    $combinedImage,
                    $chartImage,
                    $xPos, 0, 0, 0,
                    $singleWidth, $height,
                    $srcWidth, $srcHeight
                );
                
                imagedestroy($chartImage);
            }
        }
        
        $filename = 'charts/mixed_chart_' . time() . '.png';
        $fullPath = public_path($filename);
        
        imagepng($combinedImage, $fullPath);
        imagedestroy($combinedImage);
        
        return $filename;
    }
}
```

### Chart Data Filtering
```php
class ChartFilterService
{
    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            switch ($field) {
                case 'date_from':
                    $query->where('submitdate', '>=', $value);
                    break;
                case 'date_to':
                    $query->where('submitdate', '<=', $value);
                    break;
                case 'response_status':
                    $query->where('completed', $value);
                    break;
                case 'answer_value':
                    $query->whereNotNull($value);
                    break;
                default:
                    // Custom filters can be added here
                    break;
            }
        }
        
        return $query;
    }
}
```

## Performance Optimization

### Chart Caching
Charts can be cached to reduce regeneration overhead:

```php
use Illuminate\Support\Facades\Cache;

class CachedChartService
{
    public function getChartWithCache(string $surveyId, string $fieldName, array $options = []): array
    {
        $cacheKey = "chart_data_{$surveyId}_{$fieldName}_" . md5(serialize($options));
        $ttl = now()->addHours(1); // Cache for 1 hour
        
        return Cache::remember($cacheKey, $ttl, function() use ($surveyId, $fieldName, $options) {
            return app(ChartDataService::class)
                ->getSurveyChartData($surveyId, $fieldName, $options);
        });
    }
    
    public function clearChartCache(string $surveyId, string $fieldName): void
    {
        $pattern = "chart_data_{$surveyId}_{$fieldName}_*";
        // In Laravel, we need to list and delete individual keys
        // This is a simplified approach - in practice you'd need to track keys
    }
}
```

### Asynchronous Chart Generation
Charts can be generated asynchronously using Laravel queues:

```php
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Limesurvey\Models\SurveyResponse;

class GenerateChartJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;
    
    public function __construct(
        public Chart $chart,
        public string $surveyId,
        public string $fieldName,
        public string $title,
        public array $options = []
    ) {}
    
    public function handle(): void
    {
        $generator = new JpGraphGenerator();
        $imagePath = $generator->generateChartFromSurveyData(
            $this->chart,
            $this->surveyId,
            $this->fieldName,
            $this->title
        );
        
        // Optionally update chart model with generated image path
        $this->chart->img_path = $imagePath;
        $this->chart->last_generated = now();
        $this->chart->save();
    }
}
```

## Integration Examples

### Basic Chart Integration
```php
use Modules\Chart\Models\Chart;
use Modules\Limesurvey\Models\SurveyResponse;

// Create a chart configuration
$chart = Chart::create([
    'type' => 'bar2',
    'name' => 'Survey Response Chart',
    'width' => 800,
    'height' => 400,
    'font_family' => Chart::FF_ARIAL,
    'font_style' => Chart::FS_BOLD,
    'font_size' => 12,
    'list_color' => '#d60021'
]);

// Get data using dynamic SurveyResponse model
$data = app(ChartDataService::class)
    ->getSurveyChartData($surveyId, $fieldName);

// Generate chart
$generator = new JpGraphGenerator();
$imagePath = $generator->generateChartFromSurveyData(
    $chart,
    $surveyId,
    $fieldName,
    'Survey Response Chart'
);
```

### Integration with Quaeris Module
```php
use Modules\Quaeris\Models\QuestionChart;
use Modules\Chart\Models\Chart;

// Create a question chart with chart integration
$questionChart = QuestionChart::create([
    'survey_id' => $surveyId,
    'question_id' => $questionId,
    'field_name' => $fieldName, // Generated by LimeQuestion model
    'show_on_pdf' => true,
    'date_from' => $dateFrom,
    'date_to' => $dateTo
]);

// Attach chart configuration
$chart = Chart::create([
    'type' => 'pie1',
    'name' => 'Question Response Chart',
    'width' => 600,
    'height' => 400,
    'font_family' => Chart::FF_ARIAL,
    'font_style' => Chart::FS_BOLD,
    'font_size' => 10,
    'list_color' => '#3b82f6'
]);

$questionChart->chart()->associate($chart);
$questionChart->save();
```

## Security Considerations
- **Data Access**: Implement proper authentication and authorization for chart generation
- **File Security**: Validate and secure chart image file paths
- **Dynamic Model Access**: Validate survey IDs before accessing dynamic tables
- **Input Validation**: Sanitize all user inputs for chart configuration
- **PDF Content**: Validate HTML content before PDF generation
- **Chart Export**: Secure file paths for exported charts

## Performance Optimization
1. **Caching**: Cache chart data and configurations
2. **Asynchronous Processing**: Generate large charts in background jobs
3. **Memory Management**: Monitor memory usage for large datasets
4. **Database Indexing**: Proper indexing for survey response tables
5. **Image Optimization**: Optimize chart images for size and quality

## Advanced Charting Libraries

### JpGraph 4.4.2 (Recommended)
JpGraph is the primary PHP charting library for PDF generation in Chart module:

**Key Features:**
- ✅ PHP 8.2+ support (latest version 4.4.2)
- ✅ 200+ built-in functions for chart generation
- ✅ 400+ named colors and 200+ country flags
- ✅ Advanced interpolation with cubic splines
- ✅ Multi-Y-axis support and background image support
- ✅ Image map generation for drill-down charts
- ✅ Built-in caching system for performance optimization
- ✅ Open source and free for personal use

**Supported Chart Types:**
- **Line Charts**: Line, filled line, step line, line with markers
- **Bar Charts**: Standard, horizontal, grouped, stacked, accumulated
- **Pie Charts**: 2D, 3D, exploding pie charts
- **Advanced**: Radar, polar, contour, stock, Gantt, geographic maps

**Installation:**
```bash
# JpGraph is included in the project dependencies
composer require jpgraph/jpgraph
```

**Usage Example:**
```php
use Modules\Limesurvey\Models\SurveyResponse;

class ChartJpGraphGenerator
{
    public function generateChartForPdf(Chart $chart, string $surveyId, string $fieldName, string $title): string
    {
        $data = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();
        
        $graph = new \Graph($chart->width ?? 800, $chart->height ?? 400);
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        
        // Map font family and style
        $fontFamily = $this->mapFontFamily($chart->font_family);
        $fontStyle = $this->mapFontStyle($chart->font_style);
        $graph->title->SetFont($fontFamily, $fontStyle, $chart->font_size);
        
        // Create plot based on chart type
        $values = $data->pluck('count')->toArray();
        $labels = $data->pluck('answer')->toArray();
        $plot = $this->createPlot($chart->type, $values);
        $plot->SetFillColor($chart->list_color ?? '#3b82f6');
        
        // Set labels if applicable
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
            if (count($labels) > 5) {
                $graph->xaxis->SetLabelAngle(45);
            }
        }
        
        $graph->Add($plot);
        
        // Generate chart image
        $filename = 'charts/' . $chart->id . '_' . time() . '.png';
        $fullPath = public_path($filename);
        
        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $graph->Stroke($fullPath);
        
        return $filename;
    }
}
```

### Alternative PHP Chart Libraries

| Library | License | PHP Support | Best For | Pros | Cons |
|---------|---------|-------------|----------|------|------|
| **JpGraph** | Open Source | 8.2+ | PDF Generation | 200+ functions, 400+ colors, caching | Steep learning curve |
| **Libchart** | Open Source | 5.6+ | Simple Charts | Easy to use, lightweight | Limited chart types |
| **PHPlot** | Open Source | 5.6+ | Basic Charts | Mature, stable | Less actively maintained |
| **SVGGraph** | Open Source | 5.6+ | SVG Charts | Vector graphics, responsive | Limited 3D support |
| **ChartDirector** | Commercial | 5.6+ | Enterprise | Professional, extensive features | Expensive licensing |
| **Highcharts** | Commercial | JavaScript | Frontend Interactivity | Excellent interactivity | Backend not PHP |

### Chart.js (Frontend Alternative)
For interactive frontend charts, Chart.js is recommended:

**Installation:**
```bash
npm install chart.js chartjs-plugin-datalabels chartjs-plugin-annotation
```

**Usage:**
```javascript
// In your Blade template
<canvas id="myChart"></canvas>

<script>
const ctx = document.getElementById('myChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March'],
        datasets: [{
            label: 'Responses',
            data: [12, 19, 3],
            backgroundColor: '#3b82f6'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top'
            }
        }
    }
});
</script>
```

## Troubleshooting
Common issues and solutions:
- **Chart not displaying**: Check file permissions and paths
- **Dynamic model access errors**: Verify survey ID validity
- **PDF generation failures**: Verify PDF library dependencies
- **Performance issues**: Implement proper caching and queuing
- **Font rendering**: Ensure proper font libraries are installed
- **Memory issues**: Monitor and adjust memory limits for large charts
- **JpGraph not found**: Verify installation and autoloader configuration
- **Memory issues**: Optimize chart dimensions and implement Redis caching
- **Chart generation failures**: Check file permissions and directory creation
- **PDF embedding issues**: Verify chart image paths and HTML generation

## Best Practices
1. **Chart Selection**: Choose appropriate chart types for data visualization
2. **Performance**: Use caching and async processing for large datasets
3. **Security**: Validate all inputs and secure file paths
4. **Dynamic Models**: Always use dynamic models (SurveyResponse) for LimeSurvey data access
5. **Error Handling**: Implement comprehensive error handling
6. **Testing**: Test charts with various data types and edge cases
7. **Documentation**: Maintain clear documentation for chart configurations

## Related Modules
- [LimeSurvey Module](../Limesurvey/docs/index.md) - Survey data access with dynamic models
- [Quaeris Module](../Quaeris/docs/index.md) - Survey management and question charts
- [UI Module](../UI/docs/index.md) - User interface components for charts
- [Xot Module](../Xot/docs/index.md) - Base infrastructure and integration patterns

## JpGraph Documentation

### Core References (January 2026)
- **[jpgraph-complete-reference.md](./jpgraph-complete-reference.md)** - ⭐ **COMPLETE** - Comprehensive JpGraph 4.4.2+ reference with:
  - Installation via mitoteam/jpgraph (PHP 8.5 support)
  - All 15+ chart types with code examples
  - 8 gradient fill styles
  - Bar, Pie (2D/3D), Line chart deep dives
  - Font management and caching system
  - Laravel integration patterns
  - Alternative libraries comparison

- **[pchart-alternative-reference.md](./pchart-alternative-reference.md)** - pChart (GPL) alternative documentation with installation via szymach/c-pchart

### Deep Dive and Alternatives
- **[jpgraph-deep-dive-and-alternatives.md](./jpgraph-deep-dive-and-alternatives.md)** - Analisi approfondita JpGraph 4.4.3 (PHP 8.5), caratteristiche complete, confronto con librerie alternative (pChart, ChartDirector, Image-Charts, SVG Charts, ChartLogix), pattern di utilizzo nel progetto, e best practices
- **[jpgraph-class-reference-complete.md](./jpgraph-class-reference-complete.md)** - ⭐ **NUOVO** - Guida completa Class Reference JpGraph basata su documentazione ufficiale (https://jpgraph.net/download/manuals/classref/index.html), con riferimento dettagliato a tutte le classi principali (Graph, PieGraph, Plot classes, Axis, Text, Scale, Theme), metodi principali, pattern di utilizzo nel progetto, e esempi pratici dal codebase
- **[jpgraph-class-reference.md](./jpgraph-class-reference.md)** - ⭐ **NUOVO** - Class Reference API sintetica con link diretti alla documentazione ufficiale, quick reference tables, e esempi pratici per Graph, PieGraph, BarPlot, LinePlot, PiePlot, GroupBarPlot, AccBarPlot

### Complete Guides
- **[jpgraph-complete-guide.md](./jpgraph-complete-guide.md)** - Guida completa JpGraph con esempi pratici, pattern Actions, e workflow completo
- **[jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)** - Guida passo-passo per creare grafici JpGraph

### LimeSurvey Integration
- **[limesurvey-chart-generation-guide.md](./limesurvey-chart-generation-guide.md)** - Dual library strategy (Chart.js frontend + JpGraph backend) for LimeSurvey survey data

### Chart.js Plugin Guides
- **[chartjs-plugin-datalabels-filament5.md](./chartjs-plugin-datalabels-filament5.md)** - Filament 5 integration with chartjs-plugin-datalabels

### Official JpGraph Resources
- [JpGraph Official Site](https://jpgraph.net/) - Sito ufficiale
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals) - Tutorial 750+ pagine
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php) - Guide pratiche
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php) - Domande frequenti
- [JpGraph Gallery](https://jpgraph.net/features/gallery.php) - Galleria esempi
- [mitoteam/jpgraph on Packagist](https://packagist.org/packages/mitoteam/jpgraph) - Composer package (PHP 8.5 support)