# JpGraph Advanced Features for Quaeris Project Context

## Overview

This document details advanced JpGraph features and implementation techniques specifically tailored for the Quaeris survey management platform. It covers advanced chart types, multi-tenant considerations, integration with other modules, and optimization techniques for the specific requirements of the Quaeris platform.

## Advanced Chart Types and Techniques

### 1. Gantt Charts for Survey Timeline Analysis

JpGraph's Gantt chart capabilities can be leveraged for survey lifecycle visualization:

```php
class SurveyTimelineChartService
{
    public function generateSurveyTimeline($surveyId)
    {
        // Get survey lifecycle data
        $timelineData = $this->getSurveyTimelineData($surveyId);
        
        // Create Gantt chart
        $graph = new GanttGraph(1000, 600);
        $graph->title->Set("Survey Timeline - {$surveyId}");
        
        // Set date range
        $startDate = $timelineData['start_date'];
        $endDate = $timelineData['end_date'];
        $graph->SetDateRange($startDate, $endDate);
        
        // Show headers
        $graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY);
        
        // Add activities
        foreach ($timelineData['activities'] as $activity) {
            $bar = new GanttBar($activity['row'], $activity['title'], 
                                $activity['start'], $activity['end']);
            
            // Customize appearance
            $bar->SetPattern(BAND_RDIAG, $activity['color']);
            $bar->SetFillColor($activity['fill_color']);
            
            // Add to graph
            $graph->Add($bar);
        }
        
        return $this->saveChart($graph, "timeline_{$surveyId}.png");
    }
    
    private function getSurveyTimelineData($surveyId)
    {
        $survey = Survey::find($surveyId);
        
        return [
            'start_date' => $survey->created_at->format('Y-m-d'),
            'end_date' => $survey->ends_at ? $survey->ends_at->format('Y-m-d') : now()->addMonth()->format('Y-m-d'),
            'activities' => [
                [
                    'row' => 0,
                    'title' => 'Survey Creation',
                    'start' => $survey->created_at->format('Y-m-d'),
                    'end' => $survey->created_at->addDays(1)->format('Y-m-d'),
                    'color' => 'orange',
                    'fill_color' => 'lightorange'
                ],
                [
                    'row' => 1,
                    'title' => 'Survey Active',
                    'start' => $survey->start_date->format('Y-m-d'),
                    'end' => $survey->end_date->format('Y-m-d'),
                    'color' => 'blue',
                    'fill_color' => 'lightblue'
                ],
                [
                    'row' => 2,
                    'title' => 'Data Collection',
                    'start' => $survey->start_date->format('Y-m-d'),
                    'end' => $survey->end_date->format('Y-m-d'),
                    'color' => 'green',
                    'fill_color' => 'lightgreen'
                ]
            ]
        ];
    }
}
```

### 2. Radar Charts for Multi-Dimensional Survey Analysis

Radar charts are useful for displaying multi-dimensional survey responses:

```php
class RadarChartService extends BaseSurveyChartService
{
    public function generateRadarChart($surveyId, $questionSet)
    {
        // Get radar chart data
        $data = $this->getRadarChartData($surveyId, $questionSet);
        
        // Create radar graph
        $radarGraph = new RadarGraph(500, 500);
        $radarGraph->SetScale('lin', 0, 5); // Scale from 0 to 5
        $radarGraph->title->Set("Survey Dimension Analysis");
        
        // Set axis titles
        $radarGraph->SetTitles(array_keys($data));
        
        // Create plot
        $radarPlot = new RadarPlot(array_values($data));
        $radarPlot->SetColor('red');
        $radarPlot->SetFillColor('lightred');
        $radarPlot->SetLineWeight(2);
        
        // Add to graph
        $radarGraph->Add($radarPlot);
        
        return $this->saveChart($radarGraph, "radar_{$surveyId}.png");
    }
    
    private function getRadarChartData($surveyId, $questionSet)
    {
        $data = [];
        
        foreach ($questionSet as $questionRef) {
            $responses = $this->getQuestionResponses($surveyId, $questionRef);
            $average = $responses->avg('answer_value') ?: 0;
            $data[$questionRef] = $average;
        }
        
        return $data;
    }
}
```

### 3. Polar Charts for Circular Data Visualization

Polar charts are useful for displaying cyclical data like time-based survey responses:

```php
class PolarChartService extends BaseSurveyChartService
{
    public function generatePolarChart($surveyId, $hourlyData)
    {
        // Create polar graph
        $polarGraph = new PolarGraph(500, 500);
        $polarGraph->SetScale('lin', 0, 24); // 24 hours
        $polarGraph->Set90AndMargin(50, 50, 50, 50);
        $polarGraph->title->Set("Response Distribution by Hour");
        
        // Create line plot
        $polarPlot = new PolarPlot($hourlyData['values'], $hourlyData['angles']);
        $polarPlot->SetLegend("Responses");
        $polarPlot->SetColor('navy');
        $polarPlot->SetWeight(2);
        
        // Add to graph
        $polarGraph->Add($polarPlot);
        
        return $this->saveChart($polarGraph, "polar_{$surveyId}.png");
    }
}
```

## Multi-Tenant Architecture Integration

### 1. Tenant-Specific Chart Storage

```php
class MultiTenantChartService
{
    private $tenantManager;
    private $storagePath;
    
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
        $this->storagePath = storage_path('app/charts/tenants');
    }
    
    public function generateTenantChart($tenantId, $surveyId, $chartType, $options = [])
    {
        // Validate tenant access
        if (!$this->validateTenantAccess($tenantId, $surveyId)) {
            throw new UnauthorizedException("Tenant {$tenantId} cannot access survey {$surveyId}");
        }
        
        // Set tenant context
        $this->tenantManager->setTenant($tenantId);
        
        // Generate chart
        $chartService = $this->getChartService($chartType);
        $chartPath = $chartService->generateChart($surveyId, $options);
        
        // Store in tenant-specific location
        $tenantChartPath = $this->storeInTenantDirectory($tenantId, $chartPath);
        
        return $tenantChartPath;
    }
    
    private function storeInTenantDirectory($tenantId, $chartPath)
    {
        $tenantDir = $this->storagePath . '/' . $tenantId;
        
        if (!file_exists($tenantDir)) {
            mkdir($tenantDir, 0755, true);
        }
        
        $filename = basename($chartPath);
        $tenantChartPath = $tenantDir . '/' . $filename;
        
        // Copy chart to tenant directory
        copy($chartPath, $tenantChartPath);
        
        // Clean up temporary chart
        unlink($chartPath);
        
        return $tenantChartPath;
    }
    
    private function validateTenantAccess($tenantId, $surveyId)
    {
        // Verify that the survey belongs to the tenant
        $survey = Survey::find($surveyId);
        return $survey && $survey->tenant_id == $tenantId;
    }
}
```

### 2. Tenant-Aware Caching

```php
class TenantAwareChartCache
{
    private $cacheDir;
    
    public function __construct()
    {
        $this->cacheDir = storage_path('app/charts/cache/tenants');
    }
    
    public function getChart($tenantId, $cacheKey, $generateCallback)
    {
        $tenantCacheDir = $this->cacheDir . '/' . $tenantId;
        $this->ensureDirectoryExists($tenantCacheDir);
        
        $cacheFile = $tenantCacheDir . '/' . md5($cacheKey) . '.png';
        
        // Check if cache exists and is valid
        $ttl = config('chart.cache_ttl', 3600); // Default 1 hour
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
            return $cacheFile;
        }
        
        // Generate new chart
        $chartPath = $generateCallback();
        
        // Copy to tenant-specific cache
        copy($chartPath, $cacheFile);
        
        // Clean up temporary file
        if ($chartPath !== $cacheFile) {
            unlink($chartPath);
        }
        
        return $cacheFile;
    }
    
    private function ensureDirectoryExists($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    public function clearTenantCache($tenantId)
    {
        $tenantCacheDir = $this->cacheDir . '/' . $tenantId;
        
        if (file_exists($tenantCacheDir)) {
            $files = glob($tenantCacheDir . '/*.png');
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }
}
```

## Integration with Quaeris Modules

### 1. Integration with Limesurvey Module

```php
class LimesurveyChartIntegration
{
    public function generateLimesurveyCharts($surveyId)
    {
        // Get LimeSurvey survey data
        $limesurveyData = $this->getLimesurveyData($surveyId);
        
        // Generate standard charts
        $charts = [
            'overview' => $this->generateOverviewChart($limesurveyData),
            'responses' => $this->generateResponseChart($limesurveyData),
            'completion' => $this->generateCompletionChart($limesurveyData)
        ];
        
        // Generate question-specific charts
        foreach ($limesurveyData['questions'] as $questionRef => $questionData) {
            $questionChart = $this->generateQuestionChart($questionRef, $questionData);
            $charts["question_{$questionRef}"] = $questionChart;
        }
        
        return $charts;
    }
    
    private function getLimesurveyData($surveyId)
    {
        // Access LimeSurvey data through dynamic model
        $surveyModel = $this->getSurveyModel($surveyId);
        $rawData = $surveyModel->get();
        
        // Process data for charting
        return $this->processLimesurveyData($rawData);
    }
    
    private function processLimesurveyData($rawData)
    {
        $processed = [
            'total_responses' => $rawData->count(),
            'completion_rate' => $this->calculateCompletionRate($rawData),
            'questions' => $this->extractQuestionData($rawData),
            'time_series' => $this->extractTimeSeriesData($rawData)
        ];
        
        return $processed;
    }
    
    private function generateOverviewChart($data)
    {
        // Create overview chart with multiple metrics
        $graph = new Graph(800, 400);
        $graph->SetScale('textlin');
        $graph->title->Set("Survey Overview");
        
        // Create multiple plots for different metrics
        $totalPlot = new BarPlot([$data['total_responses']]);
        $totalPlot->SetFillColor('lightblue');
        $totalPlot->SetLegend('Total Responses');
        
        $completionPlot = new BarPlot([$data['completion_rate'] * 100]);
        $completionPlot->SetFillColor('lightgreen');
        $completionPlot->SetLegend('Completion Rate (%)');
        
        // Add plots to graph (using GroupBarPlot for side-by-side display)
        $groupPlot = new GroupBarPlot([$totalPlot, $completionPlot]);
        $graph->Add($groupPlot);
        
        $graph->xaxis->SetTickLabels(['Survey Metrics']);
        
        return $this->saveChart($graph, "overview_chart.png");
    }
}
```

### 2. Integration with PDF Module

```php
class PdfChartIntegrationService
{
    public function generatePdfWithCharts($surveyId, $includeCharts = true)
    {
        // Get survey data
        $survey = Survey::find($surveyId);
        $responses = $this->getSurveyResponses($surveyId);
        
        if ($includeCharts) {
            // Generate charts for PDF
            $chartPaths = $this->generatePdfCharts($surveyId);
        } else {
            $chartPaths = [];
        }
        
        // Create HTML template with charts
        $html = $this->buildPdfTemplate($survey, $responses, $chartPaths);
        
        // Generate PDF
        $pdfService = app(PdfService::class);
        $pdf = $pdfService->generate($html, $survey->title . '_report.pdf');
        
        return $pdf;
    }
    
    private function generatePdfCharts($surveyId)
    {
        $chartPaths = [];
        
        // Generate charts optimized for PDF
        $chartServices = [
            'summary' => app(SummaryChartService::class),
            'responses' => app(ResponseDistributionService::class),
            'trends' => app(TimeTrendService::class)
        ];
        
        foreach ($chartServices as $type => $service) {
            // Generate chart with PDF-optimized settings
            $chartPath = $service->generateChart($surveyId, [
                'width' => 800,      // Larger for PDF clarity
                'height' => 600,     // Larger for PDF clarity
                'dpi' => 300,        // High DPI for print quality
                'format' => 'png',   // PNG for better quality in PDF
                'quality' => 100     // Maximum quality
            ]);
            
            $chartPaths[$type] = $chartPath;
        }
        
        return $chartPaths;
    }
    
    private function buildPdfTemplate($survey, $responses, $chartPaths)
    {
        $html = '<html><head><title>' . htmlspecialchars($survey->title) . ' Report</title></head>';
        $html .= '<body style="font-family: Arial, sans-serif; margin: 20px;">';
        
        // Survey header
        $html .= '<div style="border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px;">';
        $html .= '<h1 style="margin: 0;">' . htmlspecialchars($survey->title) . ' Report</h1>';
        $html .= '<p><strong>Created:</strong> ' . $survey->created_at->format('Y-m-d H:i:s') . '</p>';
        $html .= '</div>';
        
        // Charts section
        foreach ($chartPaths as $type => $path) {
            if (file_exists($path)) {
                $html .= '<div style="margin: 20px 0; page-break-inside: avoid;">';
                $html .= '<h2>' . ucfirst($type) . ' Chart</h2>';
                $html .= '<img src="' . $path . '" style="width: 100%; height: auto; border: 1px solid #ddd;" />';
                $html .= '</div>';
            }
        }
        
        // Summary statistics
        $html .= '<div style="margin: 20px 0; page-break-before: always;">';
        $html .= '<h2>Summary Statistics</h2>';
        $html .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
        $html .= '<tr style="background-color: #f0f0f0;">';
        $html .= '<th style="border: 1px solid #ddd; padding: 8px;">Metric</th>';
        $html .= '<th style="border: 1px solid #ddd; padding: 8px;">Value</th>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">Total Responses</td>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . count($responses) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">Start Date</td>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . $survey->start_date->format('Y-m-d') . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">End Date</td>';
        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . $survey->end_date->format('Y-m-d') . '</td>';
        $html .= '</tr>';
        
        $html .= '</table></div>';
        
        $html .= '</body></html>';
        
        return $html;
    }
}
```

## Advanced Styling and Theming

### 1. Brand-Specific Chart Styling

```php
class BrandStylingService
{
    public function applyBrandStyling($graph, $brandConfig)
    {
        // Apply brand colors
        if (isset($brandConfig['primary_color'])) {
            $this->setPrimaryColor($graph, $brandConfig['primary_color']);
        }
        
        // Apply brand fonts
        if (isset($brandConfig['font_family'])) {
            $this->setFontFamily($graph, $brandConfig['font_family']);
        }
        
        // Apply brand theme
        if (isset($brandConfig['theme'])) {
            $this->applyTheme($graph, $brandConfig['theme']);
        }
        
        return $graph;
    }
    
    private function setPrimaryColor($graph, $color)
    {
        // This is a simplified example - actual implementation would depend on chart type
        if ($graph instanceof PieGraph) {
            // Apply to pie chart colors
        } elseif ($graph instanceof Graph) {
            // Apply to line/bar chart colors
        }
    }
    
    private function setFontFamily($graph, $fontFamily)
    {
        // Map font family to JpGraph font constants
        $jpGraphFont = $this->mapFontFamily($fontFamily);
        
        if (isset($graph->title)) {
            $graph->title->SetFont($jpGraphFont, FS_NORMAL, 14);
        }
        
        if (isset($graph->subtitle)) {
            $graph->subtitle->SetFont($jpGraphFont, FS_NORMAL, 12);
        }
        
        if (isset($graph->xaxis)) {
            $graph->xaxis->SetFont($jpGraphFont, FS_NORMAL, 10);
        }
        
        if (isset($graph->yaxis)) {
            $graph->yaxis->SetFont($jpGraphFont, FS_NORMAL, 10);
        }
    }
    
    private function mapFontFamily($fontFamily)
    {
        switch (strtolower($fontFamily)) {
            case 'arial':
                return FF_ARIAL;
            case 'verdana':
                return FF_VERDANA;
            case 'times':
                return FF_TIMES;
            default:
                return FF_FONT1; // Default font
        }
    }
}
```

### 2. Responsive Chart Sizing

```php
class ResponsiveChartService
{
    public function generateResponsiveChart($data, $context = 'dashboard', $dimensions = null)
    {
        // Determine optimal dimensions based on context
        $optimalDimensions = $this->calculateOptimalDimensions($context, $dimensions);
        
        // Create chart with optimal dimensions
        $graph = $this->createGraphWithDimensions($optimalDimensions);
        
        // Add data to chart
        $this->addDataToChart($graph, $data);
        
        return $graph;
    }
    
    private function calculateOptimalDimensions($context, $requestedDimensions)
    {
        $defaults = [
            'dashboard' => ['width' => 400, 'height' => 300],
            'pdf' => ['width' => 800, 'height' => 600],
            'presentation' => ['width' => 1200, 'height' => 800],
            'mobile' => ['width' => 300, 'height' => 200]
        ];
        
        $dimensions = $defaults[$context] ?? $defaults['dashboard'];
        
        // Override with requested dimensions if provided
        if ($requestedDimensions) {
            $dimensions = array_merge($dimensions, $requestedDimensions);
        }
        
        // Adjust for aspect ratio preservation
        $dimensions = $this->preserveAspectRatio($dimensions);
        
        return $dimensions;
    }
    
    private function preserveAspectRatio($dimensions)
    {
        // Maintain a reasonable aspect ratio
        $ratio = $dimensions['width'] / $dimensions['height'];
        
        if ($ratio > 3) { // Too wide
            $dimensions['width'] = $dimensions['height'] * 3;
        } elseif ($ratio < 0.3) { // Too tall
            $dimensions['height'] = $dimensions['width'] / 0.3;
        }
        
        return $dimensions;
    }
}
```

## Performance Optimization

### 1. Chart Generation Caching

```php
class ChartGenerationCache
{
    private $cache;
    private $ttl;
    
    public function __construct($ttl = 3600)
    {
        $this->cache = Cache::store('file');
        $this->ttl = $ttl;
    }
    
    public function getOrGenerate($cacheKey, $generateCallback)
    {
        // Try to get from cache first
        $cachedPath = $this->cache->get($cacheKey);
        
        if ($cachedPath && file_exists($cachedPath)) {
            return $cachedPath;
        }
        
        // Generate new chart
        $chartPath = $generateCallback();
        
        // Store in cache
        $this->cache->put($cacheKey, $chartPath, now()->addSeconds($this->ttl));
        
        return $chartPath;
    }
    
    public function invalidate($cacheKey)
    {
        $oldPath = $this->cache->get($cacheKey);
        
        if ($oldPath && file_exists($oldPath)) {
            unlink($oldPath);
        }
        
        $this->cache->forget($cacheKey);
    }
    
    public function invalidateSurveyCharts($surveyId)
    {
        // Invalidate all chart caches related to a survey
        $keys = $this->getSurveyChartCacheKeys($surveyId);
        
        foreach ($keys as $key) {
            $this->invalidate($key);
        }
    }
}
```

### 2. Memory-Efficient Large Dataset Processing

```php
class MemoryEfficientChartGenerator
{
    public function generateChartForLargeDataset($surveyId, $questionRef)
    {
        // Use database cursors to process large datasets
        $table = "lime_survey_{$surveyId}";
        
        // Count total records first
        $totalRecords = DB::table($table)->count();
        
        // Use sampling for very large datasets
        $sampleRate = $this->calculateSampleRate($totalRecords);
        
        $processedData = [];
        $processedCount = 0;
        
        DB::table($table)->orderBy('id')->chunk(1000, function($chunk) use (&$processedData, &$processedCount, $questionRef, $sampleRate) {
            foreach ($chunk as $row) {
                // Apply sampling
                if ($sampleRate < 1 && (mt_rand() / mt_getrandmax()) > $sampleRate) {
                    continue;
                }
                
                $value = $row->{$questionRef} ?? null;
                
                if ($value !== null) {
                    if (!isset($processedData[$value])) {
                        $processedData[$value] = 0;
                    }
                    $processedData[$value]++;
                }
                
                $processedCount++;
            }
            
            // Monitor memory usage
            $this->checkMemoryUsage();
        });
        
        // Generate chart with processed data
        return $this->createChartFromProcessedData($processedData, $questionRef);
    }
    
    private function calculateSampleRate($totalRecords)
    {
        // Determine sample rate based on dataset size
        if ($totalRecords <= 10000) {
            return 1.0; // Use all data
        } elseif ($totalRecords <= 100000) {
            return 0.5; // Use 50% of data
        } elseif ($totalRecords <= 1000000) {
            return 0.2; // Use 20% of data
        } else {
            return 0.1; // Use 10% of data for very large datasets
        }
    }
    
    private function checkMemoryUsage()
    {
        $current = memory_get_usage(true);
        $limit = $this->getMemoryLimit();
        
        // If we're using more than 80% of the limit, consider garbage collection
        if (($current / $limit) > 0.8) {
            gc_collect_cycles();
        }
    }
    
    private function getMemoryLimit()
    {
        $limit = ini_get('memory_limit');
        if ($limit == -1) {
            return PHP_INT_MAX; // Unlimited
        }
        
        return $this->parseMemoryLimit($limit);
    }
    
    private function parseMemoryLimit($limit)
    {
        $unit = strtolower(substr($limit, -1));
        $value = (int) $limit;
        
        switch ($unit) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }
        
        return $value;
    }
}
```

## Error Handling and Fallbacks

### 1. Robust Error Handling

```php
class RobustChartGenerator
{
    public function generateChartWithFallbacks($data, $chartType, $options = [])
    {
        try {
            // Try primary chart generation
            return $this->generatePrimaryChart($data, $chartType, $options);
        } catch (Exception $e) {
            \Log::warning("Primary chart generation failed: " . $e->getMessage());
            
            try {
                // Try alternative chart type
                return $this->generateAlternativeChart($data, $options);
            } catch (Exception $e2) {
                \Log::warning("Alternative chart generation failed: " . $e2->getMessage());
                
                // Generate fallback chart
                return $this->generateFallbackChart($data, $options);
            }
        }
    }
    
    private function generateFallbackChart($data, $options)
    {
        // Create a simple fallback chart
        $graph = new Graph(400, 300);
        $graph->SetScale('intint');
        
        // Add error text
        $text = new Text("Chart generation failed\nPlease check data", 200, 150);
        $text->SetAlign('center', 'center');
        $text->SetFont(FF_ARIAL, FS_NORMAL, 12);
        $text->SetColor('red');
        
        $graph->Add($text);
        
        $fallbackPath = storage_path('app/charts/fallback.png');
        $graph->Stroke($fallbackPath);
        
        return $fallbackPath;
    }
    
    public function validateChartData($data)
    {
        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new InvalidArgumentException('Chart data must be an array or traversable');
        }
        
        if (empty($data)) {
            throw new InvalidArgumentException('Chart data cannot be empty');
        }
        
        // Validate data structure based on chart type
        $this->validateDataStructure($data);
        
        return true;
    }
    
    private function validateDataStructure($data)
    {
        $firstItem = is_array($data) ? reset($data) : $data->first();
        
        if (is_array($firstItem)) {
            // Ensure required keys exist for specific chart types
            if (isset($firstItem['x']) && isset($firstItem['y'])) {
                // XY chart data
                foreach ($data as $item) {
                    if (!isset($item['x']) || !isset($item['y'])) {
                        throw new InvalidArgumentException('XY chart data missing required keys');
                    }
                    if (!is_numeric($item['x']) || !is_numeric($item['y'])) {
                        throw new InvalidArgumentException('XY chart data must contain numeric values');
                    }
                }
            }
        } else {
            // Simple array data
            foreach ($data as $value) {
                if (!is_numeric($value) && !is_string($value)) {
                    throw new InvalidArgumentException('Chart data must contain numeric or string values');
                }
            }
        }
    }
}
```

## Conclusion

The advanced JpGraph features detailed in this document provide powerful capabilities for the Quaeris platform, enabling:

1. **Complex chart types** like Gantt, radar, and polar charts for sophisticated data visualization
2. **Multi-tenant architecture** support with proper data isolation and caching
3. **Module integration** with Limesurvey and PDF modules for comprehensive reporting
4. **Performance optimization** techniques for handling large datasets efficiently
5. **Robust error handling** with fallback mechanisms to ensure reliability

By implementing these advanced features, the Quaeris platform can provide sophisticated, reliable, and scalable charting capabilities that meet the diverse needs of survey management and analysis.
