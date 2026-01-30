# JpGraph Complete Reference Guide for Quaeris Project

## Executive Summary

This comprehensive reference guide provides all essential information about JpGraph integration within the Quaeris survey management platform. It covers core concepts, implementation patterns, performance optimization, and best practices specific to the project's requirements.

## Table of Contents

1. [Core JpGraph Classes](#core-jpgraph-classes)
2. [Survey Data Integration](#survey-data-integration)
3. [Chart Type Selection Guide](#chart-type-selection-guide)
4. [Performance Optimization](#performance-optimization)
5. [Multi-Tenant Architecture](#multi-tenant-architecture)
6. [PDF Integration](#pdf-integration)
7. [Configuration and Deployment](#configuration-and-deployment)
8. [Best Practices](#best-practices)

## Core JpGraph Classes

### Graph Class
The main container class for all x,y-axis based plots, extending from `jpgraph.php`.

**Key Properties:**
- `xaxis`, `yaxis` - Axis instances
- `xgrid`, `ygrid` - Grid line instances
- `legend`, `title`, `subtitle` - Text elements
- `img` - Image canvas instance

**Key Methods:**
- `Add($plot)` - Add plots to graph
- `SetScale($type)` - Set axis scale
- `SetMargin($l, $r, $t, $b)` - Set margins
- `SetAngle($degrees)` - Rotate graph

### Plot Class (Abstract)
Base class for all plot types with common functionality.

**Key Methods:**
- `SetLegend($text)` - Set legend text
- `SetColor($color)` - Set plot color
- `SetWeight($weight)` - Set line weight

### Specialized Plot Classes

#### LinePlot
For line graphs showing trends over time.
```php
$linePlot = new LinePlot($data);
$linePlot->SetColor('blue');
$linePlot->SetWeight(2);
```

#### BarPlot
For categorical comparisons.
```php
$barPlot = new BarPlot($data);
$barPlot->SetFillColor('orange');
$barPlot->SetWidth(0.6);
```

#### PiePlot
For proportional data visualization.
```php
$piePlot = new PiePlot($data);
$piePlot->SetLabels($labels);
$piePlot->SetTheme('earth');
```

#### GanttGraph
For timeline and project management visualizations.
```php
$ganttGraph = new GanttGraph();
$ganttGraph->SetDateRange($start, $end);
$ganttGraph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH);
```

## Survey Data Integration

### Data Access Pattern
```php
class SurveyDataProcessor
{
    public function getSurveyData($surveyId, $questionRef)
    {
        $table = "lime_survey_{$surveyId}";
        return DB::connection('limesurvey')
            ->table($table)
            ->selectRaw("COUNT(*) as count, {$questionRef} as answer")
            ->whereNotNull($questionRef)
            ->groupBy($questionRef)
            ->orderBy('count', 'desc')
            ->get();
    }
}
```

### Question Type Handling
Different LimeSurvey question types require different charting approaches:

- **Y (Yes/No)**: Pie charts or simple bar charts
- **N (Numbers)**: Line charts, histograms, or scatter plots
- **L (List)**: Bar charts with categorical data
- **G (Gender)**: Pie charts or bar charts

### Data Preprocessing
```php
class DataPreprocessor
{
    public function preprocessForCharting($rawData, $chartType)
    {
        switch ($chartType) {
            case 'pie':
                return $this->limitPieCategories($rawData, 8);
            case 'bar':
                return $this->sortBarData($rawData);
            case 'line':
                return $this->sortLineData($rawData);
            default:
                return $rawData;
        }
    }
    
    private function limitPieCategories($data, $limit)
    {
        $topCategories = array_slice($data, 0, $limit);
        $otherCount = array_sum(array_slice($data, $limit));
        
        if ($otherCount > 0) {
            $topCategories[] = ['answer' => 'Other', 'count' => $otherCount];
        }
        
        return $topCategories;
    }
}
```

## Chart Type Selection Guide

### When to Use Each Chart Type

| Chart Type | Best For | Considerations |
|------------|----------|----------------|
| Pie Chart | Proportions, Yes/No questions | Limit to 6-8 categories |
| Bar Chart | Categorical comparisons | Good for many categories |
| Line Chart | Time series, trends | Requires ordered data |
| Histogram | Numeric distributions | Group continuous data |
| Gantt Chart | Timeline, project tracking | Complex setup but powerful |

### Automatic Chart Selection
```php
class ChartTypeSelector
{
    public function selectChartType($data, $questionType, $options = [])
    {
        $dataCount = count($data);
        $uniqueValues = count(array_unique(array_column($data, 'answer')));
        
        if ($questionType === 'Y') {
            return 'pie'; // Yes/No questions work best with pie charts
        }
        
        if ($uniqueValues <= 6) {
            return 'pie';
        } elseif ($uniqueValues <= 20) {
            return 'bar';
        } else {
            return 'horizontal_bar'; // Better for many categories
        }
    }
}
```

## Performance Optimization

### Memory Management
```php
class MemoryOptimizedChartGenerator
{
    public function generateChart($data, $options = [])
    {
        $this->optimizeMemoryUsage();
        
        try {
            $maxPoints = $this->calculateMaxPoints();
            if (count($data) > $maxPoints) {
                $data = $this->downsampleData($data, $maxPoints);
            }
            
            return $this->createChart($data, $options);
        } finally {
            $this->cleanupMemory();
        }
    }
    
    private function calculateMaxPoints()
    {
        $memoryLimit = $this->getMemoryLimit();
        return min((int)($memoryLimit * 0.1), 10000); // Use 10% of memory or 10k points
    }
    
    private function downsampleData($data, $maxPoints)
    {
        if (count($data) <= $maxPoints) {
            return $data;
        }
        
        $step = (int)(count($data) / $maxPoints);
        return array_values(array_filter($data, function($key) use ($step) {
            return $key % $step === 0;
        }, ARRAY_FILTER_USE_KEY));
    }
}
```

### Data Sampling Strategies
```php
class DataSampler
{
    public function sampleData($data, $maxSize = 1000)
    {
        if (count($data) <= $maxSize) {
            return $data;
        }
        
        // Use random sampling
        $keys = array_rand($data, $maxSize);
        $keys = is_array($keys) ? $keys : [$keys];
        
        return array_intersect_key($data, array_flip($keys));
    }
    
    public function stratifiedSample($data, $strataField, $maxSize = 1000)
    {
        // Group by strata
        $strata = [];
        foreach ($data as $item) {
            $key = $item[$strataField] ?? 'unknown';
            $strata[$key][] = $item;
        }
        
        // Sample proportionally from each strata
        $sampled = [];
        $perStrata = (int)($maxSize / max(count($strata), 1));
        
        foreach ($strata as $group) {
            $toTake = min($perStrata, count($group));
            $sampled = array_merge($sampled, array_slice($group, 0, $toTake));
        }
        
        return array_slice($sampled, 0, $maxSize);
    }
}
```

### Caching Strategies
```php
class ChartCacheManager
{
    public function getOrGenerate($cacheKey, $generateCallback, $ttl = 3600)
    {
        $cachePath = $this->getCachePath($cacheKey);
        
        if ($this->isCacheValid($cachePath, $ttl)) {
            return $cachePath;
        }
        
        $chartPath = $generateCallback();
        copy($chartPath, $cachePath);
        
        return $cachePath;
    }
    
    private function isCacheValid($cachePath, $ttl)
    {
        return file_exists($cachePath) && 
               (time() - filemtime($cachePath)) < $ttl;
    }
    
    private function getCachePath($cacheKey)
    {
        $cacheDir = storage_path('app/charts/cache');
        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        
        return $cacheDir . '/' . md5($cacheKey) . '.png';
    }
}
```

## Multi-Tenant Architecture

### Tenant-Aware Chart Services
```php
class TenantAwareChartService
{
    private $tenantManager;
    
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }
    
    public function generateTenantChart($tenantId, $surveyId, $chartType)
    {
        $this->validateTenantAccess($tenantId, $surveyId);
        $this->tenantManager->setTenant($tenantId);
        
        $chartPath = $this->generateChart($surveyId, $chartType);
        $tenantChartPath = $this->storeInTenantDirectory($tenantId, $chartPath);
        
        return $tenantChartPath;
    }
    
    private function validateTenantAccess($tenantId, $surveyId)
    {
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        if (!$survey || $survey->tenant_id != $tenantId) {
            throw new UnauthorizedException("Access denied");
        }
    }
    
    private function storeInTenantDirectory($tenantId, $chartPath)
    {
        $tenantDir = storage_path("app/charts/tenants/{$tenantId}");
        if (!file_exists($tenantDir)) {
            mkdir($tenantDir, 0755, true);
        }
        
        $filename = basename($chartPath);
        $tenantChartPath = $tenantDir . '/' . $filename;
        
        copy($chartPath, $tenantChartPath);
        unlink($chartPath); // Remove temporary file
        
        return $tenantChartPath;
    }
}
```

### Tenant-Specific Caching
```php
class TenantChartCache
{
    public function getChart($tenantId, $cacheKey, $generateCallback)
    {
        $tenantCacheDir = storage_path("app/charts/cache/tenants/{$tenantId}");
        $this->ensureDirectoryExists($tenantCacheDir);
        
        $cacheFile = $tenantCacheDir . '/' . md5($cacheKey) . '.png';
        
        $ttl = config('quaeris.chart.cache.ttl', 3600);
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
            return $cacheFile;
        }
        
        $chartPath = $generateCallback();
        copy($chartPath, $cacheFile);
        
        if ($chartPath !== $cacheFile) {
            unlink($chartPath);
        }
        
        return $cacheFile;
    }
}
```

## PDF Integration

### Chart Generation for PDF Embedding
```php
class PdfChartGenerator
{
    public function generatePdfChart($data, $title, $options = [])
    {
        // Create high-resolution chart for PDF quality
        $width = $options['width'] ?? 1200;  // Larger for PDF clarity
        $height = $options['height'] ?? 800; // Larger for PDF clarity
        
        $graph = new Graph($width, $height);
        $graph->img->SetDPI(300); // High DPI for print quality
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        $graph->SetShadow();
        
        // Create appropriate plot based on data
        $plot = $this->createPlot($data, $options);
        $graph->Add($plot);
        
        $chartPath = $this->savePdfChart($graph, $options['filename'] ?? 'chart.png');
        return $chartPath;
    }
    
    private function savePdfChart($graph, $filename)
    {
        $pdfDir = storage_path('app/charts/pdf');
        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0755, true);
        }
        
        $chartPath = $pdfDir . '/' . $filename;
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
}
```

### PDF Report Generation
```php
class PdfReportService
{
    public function generateSurveyReport($surveyId, $includeCharts = true)
    {
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        $responses = $this->getSurveyResponses($surveyId);
        
        if ($includeCharts) {
            $chartPaths = $this->generateReportCharts($surveyId);
        } else {
            $chartPaths = [];
        }
        
        $html = $this->buildReportHtml($survey, $responses, $chartPaths);
        $pdfPath = $this->convertToPdf($html, $survey->title . '_report.pdf');
        
        return $pdfPath;
    }
    
    private function buildReportHtml($survey, $responses, $chartPaths)
    {
        $html = '<!DOCTYPE html><html><head>';
        $html .= '<title>' . htmlspecialchars($survey->title) . '</title>';
        $html .= '<style>body{font-family:Arial,sans-serif;margin:20px;}</style>';
        $html .= '</head><body>';
        
        $html .= '<h1>' . htmlspecialchars($survey->title) . '</h1>';
        
        foreach ($chartPaths as $chartPath) {
            if (file_exists($chartPath)) {
                $html .= '<img src="' . $chartPath . '" style="width:100%;margin:20px 0;">';
            }
        }
        
        $html .= '</body></html>';
        
        return $html;
    }
}
```

## Configuration and Deployment

### Configuration Options
```php
// config/quaeris/chart.php
<?php

return [
    'defaults' => [
        'width' => 800,
        'height' => 600,
        'dpi' => 96,
        'format' => 'png',
        'quality' => 95,
    ],
    
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
        'path' => storage_path('app/charts/cache'),
    ],
    
    'pdf' => [
        'chart_dpi' => 300,
        'chart_format' => 'png',
        'page_size' => 'A4',
        'orientation' => 'landscape',
    ],
    
    'sampling' => [
        'enabled' => true,
        'threshold_small' => 1000,
        'threshold_medium' => 5000,
        'threshold_large' => 10000,
    ],
];
```

### Service Provider Integration
```php
class ChartServiceProvider extends XotBaseServiceProvider
{
    public function register()
    {
        $this->app->singleton('quaeris.chart', function ($app) {
            return new ChartService();
        });
        
        $this->mergeConfigFrom(
            __DIR__.'/../config/chart.php', 'quaeris.chart'
        );
    }
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/chart.php' => config_path('quaeris/chart.php'),
        ], 'quaeris-chart-config');
    }
}
```

## Best Practices

### 1. Chart Design Principles
- Use appropriate chart types for data nature
- Limit pie chart categories to 6-8 maximum
- Use consistent color schemes
- Ensure proper labeling and legends
- Consider accessibility and readability

### 2. Performance Guidelines
- Implement caching for frequently accessed charts
- Use data sampling for large datasets
- Optimize memory usage during generation
- Monitor and log chart generation performance
- Use appropriate image formats and compression

### 3. Security Considerations
- Validate all input data before chart generation
- Implement proper tenant data isolation
- Sanitize file paths when saving charts
- Monitor memory usage for potential attacks
- Implement rate limiting for chart generation

### 4. Error Handling
- Implement fallback chart generation
- Provide meaningful error messages
- Log errors for debugging
- Handle missing or invalid data gracefully
- Implement circuit breakers for failing operations

### 5. Maintenance and Monitoring
- Regular cleanup of old chart files
- Monitor disk space usage
- Track chart generation success rates
- Performance monitoring and alerting
- Regular backup of important chart configurations

## Implementation Checklist

### Before Integration
- [ ] Verify JpGraph library installation and requirements
- [ ] Set up proper directory permissions for chart storage
- [ ] Configure caching mechanisms
- [ ] Implement tenant isolation if required
- [ ] Set up monitoring and logging

### During Implementation
- [ ] Create appropriate data access layers
- [ ] Implement chart generation services
- [ ] Add caching and optimization
- [ ] Create dashboard widgets
- [ ] Implement PDF integration

### After Implementation
- [ ] Test with various data sizes
- [ ] Verify multi-tenant isolation
- [ ] Monitor performance metrics
- [ ] Document configuration options
- [ ] Create backup and recovery procedures

This comprehensive reference guide provides all the essential information needed to effectively implement, maintain, and optimize JpGraph integration within the Quaeris project.