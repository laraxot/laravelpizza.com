# JpGraph Integration with Quaeris and Limesurvey Modules

## Overview

The integration of JpGraph with the Quaeris and Limesurvey modules provides powerful server-side chart generation capabilities for survey data visualization. This document details the implementation patterns, best practices, and integration strategies for using JpGraph within the context of the Quaeris survey management platform.

## Architecture Overview

### Module Structure
- **Quaeris Module**: Core survey management functionality
- **Limesurvey Module**: Integration with LimeSurvey platform
- **Chart Module**: JpGraph implementation and chart generation services
- **PDF Module**: PDF generation with embedded charts

### Integration Points
1. Survey response data processing
2. Chart generation from survey statistics
3. PDF report creation with embedded charts
4. Dashboard widget implementations

## Implementation Patterns

### 1. Survey Response Data Processing

#### Data Access Pattern
```php
// Access survey responses using XotData pattern
$surveyId = 123;
$userClass = XotData::make()->getUserClass();
$surveyResponseClass = XotData::make()->getSurveyResponseClass();

// Get responses for survey
$responses = $surveyResponseClass::getResponsesForSurvey($surveyId);

// Process data for chart generation
$processedData = $this->processSurveyDataForCharts($responses);
```

#### Question Type Handling
```php
// Different question types require different data processing
class LimeQuestionTypeDetector
{
    public function detectQuestionProcessing($questionType, $data)
    {
        switch ($questionType) {
            case 'Y': // Yes/No
                return $this->processYesNoData($data);
            case 'N': // Numbers
                return $this->processNumericData($data);
            case 'G': // Gender
                return $this->processGenderData($data);
            case 'L': // List
                return $this->processListData($data);
            default:
                return $this->processGenericData($data);
        }
    }
}
```

### 2. JpGraph Implementation with Survey Data

#### Base Chart Service
```php
abstract class BaseSurveyChartService
{
    protected function createGraph($width = 800, $height = 400)
    {
        $graph = new Graph($width, $height);
        $graph->SetScale('textlin');
        $graph->SetShadow();
        $graph->img->SetMargin(60, 30, 40, 60);
        
        // Set common properties
        $graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
        $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
        $graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
        
        return $graph;
    }
    
    protected function addLegend($graph, $plot, $label)
    {
        $plot->SetLegend($label);
        $graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);
    }
}
```

#### Line Chart Implementation for Time Series
```php
class SurveyTimeSeriesChartService extends BaseSurveyChartService
{
    public function generateLineChart($surveyId, $questionId, $dateRange = null)
    {
        // Get survey responses
        $responses = $this->getSurveyResponses($surveyId, $questionId, $dateRange);
        
        // Organize data by date
        $dates = array_keys($responses);
        $values = array_values($responses);
        
        // Create graph
        $graph = $this->createGraph();
        $graph->title->Set('Survey Responses Over Time');
        
        // Create line plot
        $linePlot = new LinePlot($values);
        $linePlot->SetColor('blue');
        $linePlot->SetWeight(2);
        
        // Set X-axis labels
        $graph->xaxis->SetTickLabels($dates);
        
        // Add plot to graph
        $graph->Add($linePlot);
        
        // Return chart image path
        $chartPath = $this->saveChart($graph, 'line_chart_' . $surveyId . '.png');
        return $chartPath;
    }
}
```

#### Bar Chart Implementation for Categorical Data
```php
class SurveyCategoryChartService extends BaseSurveyChartService
{
    public function generateBarChart($surveyId, $questionId)
    {
        // Get categorical response data
        $categories = $this->getCategoryResponses($surveyId, $questionId);
        
        $labels = array_keys($categories);
        $values = array_values($categories);
        
        // Create bar graph
        $graph = $this->createGraph();
        $graph->title->Set('Survey Response Distribution');
        
        // Create bar plot
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('orange');
        $barPlot->SetWidth(0.6);
        
        // Set labels
        $graph->xaxis->SetTickLabels($labels);
        
        // Add plot to graph
        $graph->Add($barPlot);
        
        // Return chart image path
        $chartPath = $this->saveChart($graph, 'bar_chart_' . $surveyId . '.png');
        return $chartPath;
    }
}
```

#### Pie Chart Implementation for Proportions
```php
class SurveyProportionChartService extends BaseSurveyChartService
{
    public function generatePieChart($surveyId, $questionId)
    {
        // Get response data for pie chart
        $data = $this->getProportionData($surveyId, $questionId);
        
        $values = array_values($data);
        $labels = array_keys($data);
        
        // Create pie graph
        $pieGraph = new PieGraph(600, 400);
        $pieGraph->title->Set('Response Proportions');
        
        // Create pie plot
        $piePlot = new PiePlot($values);
        
        // Set labels
        $piePlot->SetLabels($labels);
        
        // Set theme
        $piePlot->SetTheme('earth');
        
        // Add plot to graph
        $pieGraph->Add($piePlot);
        
        // Return chart image path
        $chartPath = $this->saveChart($pieGraph, 'pie_chart_' . $surveyId . '.png');
        return $chartPath;
    }
}
```

## Multi-Tenant Considerations

### Tenant-Specific Chart Generation
```php
class TenantSurveyChartService
{
    public function generateChartForTenant($tenantId, $surveyId, $chartType, $options = [])
    {
        // Set tenant context
        TenantManager::setTenant($tenantId);
        
        // Validate tenant has access to survey
        if (!$this->userHasAccessToSurvey($surveyId)) {
            throw new UnauthorizedException('Access denied to survey');
        }
        
        // Generate chart based on type
        $chartService = $this->getChartService($chartType);
        $chartPath = $chartService->generateChart($surveyId, $options);
        
        // Store tenant-specific chart
        $tenantChartPath = $this->storeTenantChart($tenantId, $chartPath);
        
        return $tenantChartPath;
    }
    
    private function storeTenantChart($tenantId, $chartPath)
    {
        $tenantDir = storage_path("app/charts/tenants/{$tenantId}");
        if (!file_exists($tenantDir)) {
            mkdir($tenantDir, 0755, true);
        }
        
        $tenantChartPath = $tenantDir . '/' . basename($chartPath);
        copy($chartPath, $tenantChartPath);
        
        return $tenantChartPath;
    }
}
```

## PDF Integration

### Chart Embedding in PDF Reports
```php
class SurveyPdfReportService
{
    public function generateSurveyReport($surveyId, $tenantId, $includeCharts = true)
    {
        // Get survey data
        $survey = $this->getSurvey($surveyId);
        $responses = $this->getSurveyResponses($surveyId);
        
        // Generate charts if requested
        $chartPaths = [];
        if ($includeCharts) {
            $chartPaths = $this->generateReportCharts($surveyId);
        }
        
        // Create HTML template for PDF
        $html = $this->buildReportTemplate($survey, $responses, $chartPaths);
        
        // Generate PDF
        $pdfPath = $this->generatePdf($html, $survey->title . '_report.pdf');
        
        return $pdfPath;
    }
    
    private function generateReportCharts($surveyId)
    {
        $chartPaths = [];
        
        // Generate various chart types for the report
        $chartTypes = ['time_series', 'category', 'proportion'];
        
        foreach ($chartTypes as $type) {
            $service = $this->getChartService($type);
            $chartPath = $service->generateChart($surveyId);
            $chartPaths[$type] = $chartPath;
        }
        
        return $chartPaths;
    }
    
    private function buildReportTemplate($survey, $responses, $chartPaths)
    {
        $html = '<html><head><title>' . $survey->title . ' Report</title></head><body>';
        
        // Add survey info
        $html .= '<h1>' . $survey->title . ' Report</h1>';
        $html .= '<p>Total Responses: ' . count($responses) . '</p>';
        
        // Add charts
        foreach ($chartPaths as $type => $path) {
            $html .= '<h2>' . ucfirst($type) . ' Chart</h2>';
            $html .= '<img src="' . $path . '" style="width: 100%; height: auto;" />';
        }
        
        // Add response details
        $html .= '<h2>Response Details</h2>';
        $html .= '<table border="1" style="width: 100%;">';
        $html .= '<tr><th>Question</th><th>Response</th><th>Count</th></tr>';
        
        foreach ($responses as $response) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($response->question) . '</td>';
            $html .= '<td>' . htmlspecialchars($response->answer) . '</td>';
            $html .= '<td>' . $response->count . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        return $html;
    }
}
```

## Caching and Performance Optimization

### Chart Caching Service
```php
class ChartCacheService
{
    private $cacheDir;
    private $ttl;
    
    public function __construct($cacheDir = null, $ttl = 3600)
    {
        $this->cacheDir = $cacheDir ?: storage_path('app/charts/cache');
        $this->ttl = $ttl;
        
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    public function getChart($cacheKey, $generateCallback)
    {
        $cacheFile = $this->getCacheFilePath($cacheKey);
        
        // Check if cache exists and is still valid
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $this->ttl) {
            return $cacheFile;
        }
        
        // Generate new chart
        $chartPath = $generateCallback();
        
        // Copy to cache
        copy($chartPath, $cacheFile);
        
        return $cacheFile;
    }
    
    private function getCacheFilePath($cacheKey)
    {
        return $this->cacheDir . '/' . md5($cacheKey) . '.png';
    }
    
    public function clearExpired()
    {
        $files = glob($this->cacheDir . '/*.png');
        foreach ($files as $file) {
            if ((time() - filemtime($file)) > $this->ttl) {
                unlink($file);
            }
        }
    }
}
```

## Integration with Filament Dashboard

### Chart Widget Implementation
```php
class SurveyChartWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Survey Response Charts';
    
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'image/png',
        ];
    }
    
    protected static string $view = 'chart::widgets.survey-chart-widget';
    
    public function getSurveyId(): int
    {
        return $this->data['survey_id'] ?? 0;
    }
    
    public function getChartType(): string
    {
        return $this->data['chart_type'] ?? 'line';
    }
    
    public function getChartData()
    {
        $surveyId = $this->getSurveyId();
        $chartType = $this->getChartType();
        
        $chartService = app()->make("chart.{$chartType}");
        $chartPath = $chartService->generateChart($surveyId);
        
        return [
            'chart_path' => $chartPath,
            'survey_id' => $surveyId,
            'chart_type' => $chartType
        ];
    }
}
```

## Error Handling and Validation

### Chart Generation Error Handler
```php
class ChartGenerationErrorHandler
{
    public function handleChartGenerationError($exception, $context = [])
    {
        // Log the error with context
        Log::error('Chart generation failed', [
            'error' => $exception->getMessage(),
            'context' => $context,
            'trace' => $exception->getTraceAsString()
        ]);
        
        // Return fallback image or error indicator
        $fallbackPath = $this->getFallbackChart();
        
        return $fallbackPath;
    }
    
    private function getFallbackChart()
    {
        // Create a simple fallback chart indicating error
        $graph = new Graph(400, 300);
        $graph->SetScale('intint');
        
        $text = new Text("Chart generation failed", 200, 150);
        $text->SetAlign('center', 'center');
        $text->SetFont(FF_ARIAL, FS_BOLD, 12);
        
        $chartPath = storage_path('app/charts/fallback.png');
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
    
    public function validateChartData($data)
    {
        if (!is_array($data) || empty($data)) {
            throw new InvalidArgumentException('Chart data must be a non-empty array');
        }
        
        // Validate all values are numeric for numeric charts
        if ($this->requiresNumericData()) {
            foreach ($data as $value) {
                if (!is_numeric($value)) {
                    throw new InvalidArgumentException('All chart values must be numeric');
                }
            }
        }
        
        return true;
    }
}
```

## Best Practices

### 1. Data Validation
Always validate input data before passing to JpGraph to prevent errors and security issues.

### 2. Memory Management
Monitor memory usage when generating complex charts and implement appropriate limits.

### 3. File Management
Properly manage temporary files and implement cleanup routines to prevent disk space issues.

### 4. Error Handling
Implement robust error handling to gracefully handle chart generation failures.

### 5. Caching Strategy
Use appropriate caching strategies to improve performance for frequently accessed charts.

### 6. Multi-Tenant Isolation
Ensure proper isolation between tenant data and chart storage.

## Conclusion

The integration of JpGraph with the Quaeris and Limesurvey modules provides powerful server-side chart generation capabilities that are particularly well-suited for PDF report generation. By following the patterns and best practices outlined in this document, you can ensure reliable, secure, and performant chart generation that meets the needs of the survey management platform.