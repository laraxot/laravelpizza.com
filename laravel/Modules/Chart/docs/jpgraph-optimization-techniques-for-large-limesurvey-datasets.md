# JpGraph Optimization Techniques for Large LimeSurvey Datasets

## Overview

This document outlines optimization techniques specifically designed for using JpGraph with large LimeSurvey datasets. When dealing with surveys that have thousands or millions of responses, standard charting approaches can become inefficient. This guide provides solutions for handling large datasets while maintaining performance and chart quality.

## Understanding Large Dataset Challenges

### Memory Consumption
- Large datasets can quickly exhaust PHP memory limits
- JpGraph processes all data in memory during chart generation
- Complex charts with many data points require significant memory

### Processing Time
- Chart generation can take several seconds with large datasets
- Users expect responsive applications
- Server resources can be consumed during processing

### Chart Readability
- Too many data points can make charts unreadable
- Overlapping elements reduce chart effectiveness
- Performance degrades when rendering complex charts

## Data Sampling Strategies

### 1. Statistical Sampling
```php
class StatisticalSampler
{
    public function sampleData($data, $sampleSize = 1000)
    {
        if (count($data) <= $sampleSize) {
            return $data; // No sampling needed
        }
        
        $indices = array_rand($data, $sampleSize);
        $indices = is_array($indices) ? $indices : [$indices];
        
        $sampled = [];
        foreach ($indices as $index) {
            $sampled[] = $data[$index];
        }
        
        return $sampled;
    }
    
    public function stratifiedSample($data, $strataField, $sampleSize = 1000)
    {
        // Group data by strata field
        $strata = [];
        foreach ($data as $item) {
            $key = $item[$strataField] ?? 'unknown';
            $strata[$key][] = $item;
        }
        
        // Sample from each strata proportionally
        $sampled = [];
        $totalItems = count($data);
        $targetPerStrata = (int)($sampleSize / count($strata));
        
        foreach ($strata as $stratum => $items) {
            $stratumSize = count($items);
            $sampleFromStratum = min($targetPerStrata, $stratumSize);
            
            if ($stratumSize <= $sampleFromStratum) {
                $sampled = array_merge($sampled, $items);
            } else {
                $sampledIndices = array_rand($items, $sampleFromStratum);
                $sampledIndices = is_array($sampledIndices) ? $sampledIndices : [$sampledIndices];
                
                foreach ($sampledIndices as $index) {
                    $sampled[] = $items[$index];
                }
            }
        }
        
        // If we have fewer items than target, add more randomly
        if (count($sampled) < $sampleSize) {
            $remaining = $sampleSize - count($sampled);
            $extra = array_slice($data, 0, $remaining);
            $sampled = array_merge($sampled, $extra);
        }
        
        return array_slice($sampled, 0, $sampleSize);
    }
}
```

### 2. Time-Based Sampling for Temporal Data
```php
class TimeBasedSampler
{
    public function sampleTimeSeries($data, $start, $end, $targetPoints = 500)
    {
        $totalDuration = strtotime($end) - strtotime($start);
        $interval = $totalDuration / $targetPoints;
        
        $sampled = [];
        $current = strtotime($start);
        $endTimestamp = strtotime($end);
        
        // Sort data by time
        usort($data, function($a, $b) {
            return strtotime($a['timestamp']) - strtotime($b['timestamp']);
        });
        
        $dataIndex = 0;
        $dataCount = count($data);
        
        while ($current <= $endTimestamp && count($sampled) < $targetPoints) {
            $intervalStart = $current;
            $intervalEnd = $current + $interval;
            
            // Find data points in this interval
            $intervalPoints = [];
            while ($dataIndex < $dataCount && 
                   strtotime($data[$dataIndex]['timestamp']) <= $intervalEnd) {
                if (strtotime($data[$dataIndex]['timestamp']) >= $intervalStart) {
                    $intervalPoints[] = $data[$dataIndex];
                }
                $dataIndex++;
            }
            
            // Take average or first point in interval
            if (!empty($intervalPoints)) {
                $sampled[] = $this->aggregateInterval($intervalPoints);
            }
            
            $current = $intervalEnd;
        }
        
        return $sampled;
    }
    
    private function aggregateInterval($intervalPoints)
    {
        if (count($intervalPoints) == 1) {
            return $intervalPoints[0];
        }
        
        // Calculate average of numeric values
        $aggregated = $intervalPoints[0]; // Use first as template
        
        $numericFields = [];
        foreach ($intervalPoints[0] as $field => $value) {
            if (is_numeric($value)) {
                $numericFields[] = $field;
            }
        }
        
        foreach ($numericFields as $field) {
            $sum = 0;
            foreach ($intervalPoints as $point) {
                $sum += $point[$field];
            }
            $aggregated[$field] = $sum / count($intervalPoints);
        }
        
        return $aggregated;
    }
}
```

## Database-Level Optimization

### 1. Efficient Data Retrieval
```php
class EfficientLimeSurveyDataRetriever
{
    public function getChartData($surveyId, $questionRef, $options = [])
    {
        $table = "lime_survey_{$surveyId}";
        
        $query = DB::table($table)
                   ->selectRaw("COUNT(*) as count, {$questionRef} as answer")
                   ->whereNotNull($questionRef)
                   ->groupBy($questionRef)
                   ->orderBy('count', 'desc');
        
        // Apply limits if specified
        if (isset($options['limit'])) {
            $query = $query->limit($options['limit']);
        }
        
        // Apply date filters if specified
        if (isset($options['date_from'])) {
            $query = $query->where('submitdate', '>=', $options['date_from']);
        }
        
        if (isset($options['date_to'])) {
            $query = $query->where('submitdate', '<=', $options['date_to']);
        }
        
        return $query->get();
    }
    
    public function getAggregatedData($surveyId, $questionRef, $groupBy = 'month')
    {
        $table = "lime_survey_{$surveyId}";
        
        $dateExpression = $this->getDateExpression($groupBy);
        
        return DB::table($table)
                 ->selectRaw("COUNT(*) as count, {$dateExpression} as period, {$questionRef} as answer")
                 ->whereNotNull($questionRef)
                 ->whereNotNull('submitdate')
                 ->groupBy('period', 'answer')
                 ->orderBy('period')
                 ->get();
    }
    
    private function getDateExpression($groupBy)
    {
        switch ($groupBy) {
            case 'year':
                return "DATE_FORMAT(submitdate, '%Y')";
            case 'month':
                return "DATE_FORMAT(submitdate, '%Y-%m')";
            case 'week':
                return "DATE_FORMAT(submitdate, '%Y-%u')";
            case 'day':
                return "DATE_FORMAT(submitdate, '%Y-%m-%d')";
            default:
                return "DATE_FORMAT(submitdate, '%Y-%m')";
        }
    }
    
    public function getSummaryStatistics($surveyId, $questionRef)
    {
        $table = "lime_survey_{$surveyId}";
        
        // Get basic statistics in a single query
        $stats = DB::table($table)
                   ->selectRaw("
                       COUNT(*) as total_responses,
                       COUNT(CASE WHEN {$questionRef} IS NOT NULL THEN 1 END) as valid_responses,
                       COUNT(CASE WHEN {$questionRef} IS NULL THEN 1 END) as null_responses,
                       MIN({$questionRef}) as min_value,
                       MAX({$questionRef}) as max_value,
                       AVG({$questionRef}) as avg_value
                   ")
                   ->first();
        
        return $stats;
    }
}
```

### 2. Chunked Processing for Very Large Datasets
```php
class ChunkedDataProcessor
{
    public function processLargeDataset($surveyId, $questionRef, $processCallback, $chunkSize = 5000)
    {
        $table = "lime_survey_{$surveyId}";
        $processedResults = [];
        
        DB::table($table)
          ->select($questionRef, 'id')
          ->whereNotNull($questionRef)
          ->orderBy('id')
          ->chunk($chunkSize, function($chunk) use (&$processedResults, $processCallback) {
              $chunkResults = $processCallback($chunk);
              $processedResults = array_merge($processedResults, $chunkResults);
          });
        
        // Combine results from all chunks
        return $this->combineChunkResults($processedResults);
    }
    
    private function combineChunkResults($chunkResults)
    {
        $combined = [];
        
        foreach ($chunkResults as $result) {
            foreach ($result as $key => $value) {
                if (!isset($combined[$key])) {
                    $combined[$key] = 0;
                }
                $combined[$key] += $value;
            }
        }
        
        return $combined;
    }
    
    public function calculatePercentiles($surveyId, $questionRef, $percentiles = [25, 50, 75])
    {
        $table = "lime_survey_{$surveyId}";
        
        // Get count of valid responses
        $total = DB::table($table)
                   ->whereNotNull($questionRef)
                   ->count();
        
        $results = [];
        
        foreach ($percentiles as $percentile) {
            $offset = (int)($total * ($percentile / 100));
            
            $value = DB::table($table)
                       ->select($questionRef)
                       ->whereNotNull($questionRef)
                       ->orderBy($questionRef)
                       ->offset($offset)
                       ->limit(1)
                       ->value($questionRef);
            
            $results["p{$percentile}"] = $value;
        }
        
        return $results;
    }
}
```

## JpGraph Memory Optimization

### 1. Memory-Efficient Chart Generation
```php
class MemoryOptimizedChartGenerator
{
    public function generateChart($data, $options = [])
    {
        // Start with lower memory usage settings
        $this->optimizeMemoryUsage();
        
        try {
            // Validate data size
            $dataSize = $this->estimateDataSize($data);
            $maxPoints = $this->calculateMaxPoints($dataSize);
            
            if (count($data) > $maxPoints) {
                $data = $this->downsampleData($data, $maxPoints);
            }
            
            // Generate chart
            $chart = $this->createChart($data, $options);
            
            // Optimize chart for memory usage
            $this->optimizeChartMemory($chart);
            
            return $chart;
        } finally {
            // Clean up memory
            $this->cleanupMemory();
        }
    }
    
    private function estimateDataSize($data)
    {
        return count($data) * (count($data[0] ?? []) ?: 1);
    }
    
    private function calculateMaxPoints($dataSize)
    {
        $memoryLimit = $this->getMemoryLimit();
        $availableMemory = $memoryLimit * 0.3; // Use 30% of available memory
        
        // Estimation: 100 bytes per data point
        $estimatedPoints = (int)($availableMemory / 100);
        
        return min($estimatedPoints, 10000); // Cap at 10k points
    }
    
    private function downsampleData($data, $maxPoints)
    {
        if (count($data) <= $maxPoints) {
            return $data;
        }
        
        $step = (int)(count($data) / $maxPoints);
        $sampled = [];
        
        for ($i = 0; $i < count($data); $i += $step) {
            $sampled[] = $data[$i];
        }
        
        return array_slice($sampled, 0, $maxPoints);
    }
    
    private function optimizeMemoryUsage()
    {
        // Increase memory limit temporarily if needed
        $currentLimit = ini_get('memory_limit');
        if ($this->parseMemoryLimit($currentLimit) < 256 * 1024 * 1024) { // 256MB
            ini_set('memory_limit', '256M');
        }
        
        // Enable garbage collection
        gc_enable();
    }
    
    private function parseMemoryLimit($limit)
    {
        $unit = strtolower(substr($limit, -1));
        $value = (int)$limit;
        
        switch ($unit) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }
        
        return $value;
    }
    
    private function getMemoryLimit()
    {
        $limit = ini_get('memory_limit');
        if ($limit == -1) {
            return 512 * 1024 * 1024; // 512MB default for unlimited
        }
        
        return $this->parseMemoryLimit($limit);
    }
    
    private function optimizeChartMemory($chart)
    {
        // Reduce chart complexity if possible
        if (method_exists($chart, 'SetAntiAliasing')) {
            $chart->SetAntiAliasing(false); // Disable for memory savings
        }
        
        // Simplify fonts
        if (isset($chart->title)) {
            $chart->title->SetFont(FF_FONT1, FS_NORMAL, 12);
        }
    }
    
    private function cleanupMemory()
    {
        gc_collect_cycles();
    }
}
```

## Caching Strategies for Large Datasets

### 1. Pre-aggregated Data Caching
```php
class PreAggregatedDataCache
{
    private $cache;
    
    public function __construct()
    {
        $this->cache = Cache::store('redis'); // Use Redis for better performance
    }
    
    public function getOrCalculate($surveyId, $questionRef, $timeRange, $granularity)
    {
        $cacheKey = $this->generateCacheKey($surveyId, $questionRef, $timeRange, $granularity);
        
        $cached = $this->cache->get($cacheKey);
        if ($cached) {
            return $cached;
        }
        
        // Calculate aggregated data
        $aggregated = $this->calculateAggregatedData($surveyId, $questionRef, $timeRange, $granularity);
        
        // Store in cache with appropriate TTL
        $ttl = $this->calculateTtl($timeRange);
        $this->cache->put($cacheKey, $aggregated, now()->addSeconds($ttl));
        
        return $aggregated;
    }
    
    private function calculateAggregatedData($surveyId, $questionRef, $timeRange, $granularity)
    {
        $dataRetriever = new EfficientLimeSurveyDataRetriever();
        return $dataRetriever->getAggregatedData($surveyId, $questionRef, $granularity);
    }
    
    private function generateCacheKey($surveyId, $questionRef, $timeRange, $granularity)
    {
        return "chart_data:{$surveyId}:{$questionRef}:{$timeRange['from']}:{$timeRange['to']}:{$granularity}";
    }
    
    private function calculateTtl($timeRange)
    {
        $endDate = new DateTime($timeRange['to']);
        $now = new DateTime();
        
        // Cache longer for historical data, shorter for recent data
        if ($endDate < $now->modify('-1 day')) {
            return 3600 * 24; // 24 hours for old data
        } elseif ($endDate < $now->modify('+1 day')) {
            return 3600; // 1 hour for recent data
        } else {
            return 300; // 5 minutes for current data
        }
    }
    
    public function invalidateSurveyCache($surveyId)
    {
        // This would require a more sophisticated cache system
        // that can tag cache entries by survey ID
        // For now, we'll just clear all chart caches for this survey
        
        $keys = $this->cache->get("chart_keys:{$surveyId}", []);
        foreach ($keys as $key) {
            $this->cache->forget($key);
        }
        
        $this->cache->forget("chart_keys:{$surveyId}");
    }
}
```

### 2. Chart Image Caching
```php
class ChartImageCache
{
    public function getOrGenerate($chartData, $chartType, $options = [])
    {
        $cacheKey = $this->generateCacheKey($chartData, $chartType, $options);
        $cachePath = $this->getCachePath($cacheKey);
        
        if (file_exists($cachePath) && $this->isCacheValid($cachePath)) {
            return $cachePath;
        }
        
        // Generate new chart
        $generator = new MemoryOptimizedChartGenerator();
        $chartPath = $generator->generateChart($chartData, $options);
        
        // Copy to cache
        copy($chartPath, $cachePath);
        
        return $cachePath;
    }
    
    private function generateCacheKey($chartData, $chartType, $options)
    {
        $dataHash = md5(serialize($chartData));
        $optionsHash = md5(serialize($options));
        
        return "chart:{$chartType}:{$dataHash}:{$optionsHash}";
    }
    
    private function getCachePath($cacheKey)
    {
        $cacheDir = storage_path('app/charts/cache');
        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        
        return $cacheDir . '/' . $cacheKey . '.png';
    }
    
    private function isCacheValid($cachePath)
    {
        $maxAge = config('chart.cache_max_age', 3600); // 1 hour default
        return (time() - filemtime($cachePath)) < $maxAge;
    }
}
```

## Advanced Chart Optimization Techniques

### 1. Progressive Data Loading
```php
class ProgressiveDataChartService
{
    public function generateProgressiveChart($surveyId, $questionRef, $options = [])
    {
        // Start with a summary view
        $summaryData = $this->getSummaryData($surveyId, $questionRef);
        
        if ($this->shouldUseSummary($summaryData, $options)) {
            return $this->generateSummaryChart($summaryData, $options);
        }
        
        // For detailed views, use sampling
        $sampledData = $this->getSampledData($surveyId, $questionRef, $options);
        return $this->generateDetailedChart($sampledData, $options);
    }
    
    private function shouldUseSummary($summaryData, $options)
    {
        // Use summary if dataset is very large or user requested summary
        $threshold = $options['summary_threshold'] ?? 10000;
        return $summaryData['total_responses'] > $threshold || 
               ($options['view_type'] ?? 'auto') === 'summary';
    }
    
    private function getSummaryData($surveyId, $questionRef)
    {
        $retriever = new EfficientLimeSurveyDataRetriever();
        return $retriever->getSummaryStatistics($surveyId, $questionRef);
    }
    
    private function getSampledData($surveyId, $questionRef, $options)
    {
        $retriever = new EfficientLimeSurveyDataRetriever();
        $rawData = $retriever->getChartData($surveyId, $questionRef, $options);
        
        $sampleSize = $options['sample_size'] ?? 1000;
        $sampler = new StatisticalSampler();
        
        return $sampler->sampleData($rawData->toArray(), $sampleSize);
    }
    
    public function generateInteractiveChart($surveyId, $questionRef)
    {
        // Generate a base chart with summary data
        $summaryChart = $this->generateProgressiveChart($surveyId, $questionRef, [
            'view_type' => 'summary'
        ]);
        
        // Provide links to drill-down views
        $drillDownLinks = $this->generateDrillDownLinks($surveyId, $questionRef);
        
        return [
            'base_chart' => $summaryChart,
            'drill_down_links' => $drillDownLinks
        ];
    }
    
    private function generateDrillDownLinks($surveyId, $questionRef)
    {
        $links = [];
        
        // Add links for different time ranges
        $timeRanges = [
            'last_7_days' => ['from' => now()->subDays(7)->format('Y-m-d'), 'to' => now()->format('Y-m-d')],
            'last_30_days' => ['from' => now()->subDays(30)->format('Y-m-d'), 'to' => now()->format('Y-m-d')],
            'last_year' => ['from' => now()->subYear()->format('Y-m-d'), 'to' => now()->format('Y-m-d')]
        ];
        
        foreach ($timeRanges as $rangeName => $dates) {
            $links[$rangeName] = route('survey.chart.drilldown', [
                'survey_id' => $surveyId,
                'question_ref' => $questionRef,
                'range' => $rangeName,
                'from' => $dates['from'],
                'to' => $dates['to']
            ]);
        }
        
        return $links;
    }
}
```

### 2. Adaptive Chart Complexity
```php
class AdaptiveChartComplexity
{
    public function generateAdaptiveChart($data, $options = [])
    {
        $complexityLevel = $this->determineComplexityLevel($data, $options);
        
        switch ($complexityLevel) {
            case 'simple':
                return $this->generateSimpleChart($data, $options);
            case 'moderate':
                return $this->generateModerateChart($data, $options);
            case 'complex':
                return $this->generateComplexChart($data, $options);
            default:
                return $this->generateModerateChart($data, $options);
        }
    }
    
    private function determineComplexityLevel($data, $options)
    {
        $dataSize = count($data);
        $numCategories = count(array_unique(array_column($data, 'category') ?: []));
        
        // Determine complexity based on data size and number of categories
        if ($dataSize > 5000 || $numCategories > 50) {
            return 'simple'; // Too much data for complex charts
        } elseif ($dataSize > 1000 || $numCategories > 20) {
            return 'moderate'; // Moderate complexity appropriate
        } else {
            return 'complex'; // Can handle complex charts
        }
    }
    
    private function generateSimpleChart($data, $options)
    {
        // Generate simple chart with minimal styling
        $graph = new Graph(600, 400);
        $graph->SetScale('textlin');
        
        // Use simple bar chart
        $values = array_column($data, 'value');
        $labels = array_column($data, 'label');
        
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('lightblue');
        $barPlot->SetWidth(0.8);
        
        $graph->xaxis->SetTickLabels($labels);
        $graph->Add($barPlot);
        
        return $graph;
    }
    
    private function generateModerateChart($data, $options)
    {
        // Generate chart with moderate styling and features
        $graph = new Graph(800, 500);
        $graph->SetScale('textlin');
        $graph->SetShadow();
        
        $values = array_column($data, 'value');
        $labels = array_column($data, 'label');
        
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('orange');
        $barPlot->SetWidth(0.7);
        $barPlot->SetLegend('Responses');
        
        $graph->xaxis->SetTickLabels($labels);
        $graph->Add($barPlot);
        
        return $graph;
    }
    
    private function generateComplexChart($data, $options)
    {
        // Generate full-featured chart with all styling options
        $graph = new Graph(1000, 600);
        $graph->SetScale('textlin');
        $graph->SetShadow();
        
        // Add grid
        $graph->xgrid->Show();
        $graph->ygrid->Show();
        
        // Set fonts
        $graph->title->Set('Detailed Survey Responses');
        $graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
        
        $values = array_column($data, 'value');
        $labels = array_column($data, 'label');
        
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('green');
        $barPlot->SetWidth(0.6);
        $barPlot->SetLegend('Responses');
        
        // Add value labels
        $barPlot->value->Show();
        $barPlot->value->SetFont(FF_ARIAL, FS_NORMAL, 9);
        
        $graph->xaxis->SetTickLabels($labels);
        $graph->Add($barPlot);
        
        return $graph;
    }
}
```

## Performance Monitoring and Tuning

### 1. Performance Metrics Collection
```php
class ChartPerformanceMonitor
{
    public function measureChartGeneration($chartCallback)
    {
        $startMemory = memory_get_usage(true);
        $startTime = microtime(true);
        
        try {
            $result = $chartCallback();
            
            $endTime = microtime(true);
            $endMemory = memory_get_usage(true);
            
            $metrics = [
                'generation_time' => $endTime - $startTime,
                'memory_used' => $endMemory - $startMemory,
                'peak_memory' => memory_get_peak_usage(true) - $startMemory,
                'success' => true,
                'result' => $result
            ];
            
            $this->logMetrics($metrics);
            
            return $metrics;
        } catch (Exception $e) {
            $endTime = microtime(true);
            $endMemory = memory_get_peak_usage(true);
            
            $metrics = [
                'generation_time' => $endTime - $startTime,
                'memory_used' => $endMemory - $startMemory,
                'peak_memory' => $endMemory - $startMemory,
                'success' => false,
                'error' => $e->getMessage()
            ];
            
            $this->logMetrics($metrics);
            
            throw $e;
        }
    }
    
    private function logMetrics($metrics)
    {
        Log::info('Chart generation metrics', $metrics);
        
        // Store in database for analysis
        ChartPerformanceLog::create([
            'generation_time' => $metrics['generation_time'],
            'memory_used' => $metrics['memory_used'],
            'peak_memory' => $metrics['peak_memory'],
            'success' => $metrics['success'],
            'error_message' => $metrics['error'] ?? null
        ]);
    }
    
    public function analyzePerformance($surveyId = null)
    {
        $query = ChartPerformanceLog::query();
        
        if ($surveyId) {
            // Add survey-specific analysis if needed
        }
        
        return [
            'avg_generation_time' => $query->avg('generation_time'),
            'avg_memory_used' => $query->avg('memory_used'),
            'success_rate' => $query->where('success', true)->count() / $query->count() * 100,
            'peak_usage' => $query->max('peak_memory')
        ];
    }
}
```

### 2. Automatic Optimization Settings
```php
class AutomaticOptimizer
{
    private $performanceMonitor;
    
    public function __construct(ChartPerformanceMonitor $performanceMonitor)
    {
        $this->performanceMonitor = $performanceMonitor;
    }
    
    public function optimizeForDataset($dataSize)
    {
        $recommendations = [];
        
        if ($dataSize > 50000) {
            $recommendations['sampling_rate'] = 0.1; // 10% sampling
            $recommendations['chart_type'] = 'summary';
            $recommendations['memory_limit'] = '512M';
        } elseif ($dataSize > 10000) {
            $recommendations['sampling_rate'] = 0.25; // 25% sampling
            $recommendations['chart_type'] = 'moderate';
            $recommendations['memory_limit'] = '256M';
        } elseif ($dataSize > 1000) {
            $recommendations['sampling_rate'] = null; // No sampling
            $recommendations['chart_type'] = 'detailed';
            $recommendations['memory_limit'] = '128M';
        } else {
            $recommendations['sampling_rate'] = null; // No sampling
            $recommendations['chart_type'] = 'full';
            $recommendations['memory_limit'] = '64M';
        }
        
        return $recommendations;
    }
    
    public function applyOptimizations($recommendations)
    {
        if (isset($recommendations['memory_limit'])) {
            ini_set('memory_limit', $recommendations['memory_limit']);
        }
    }
}
```

## Best Practices Summary

1. **Data Sampling**: Use statistical sampling for datasets with more than 10,000 records
2. **Database Optimization**: Implement efficient queries with proper indexing
3. **Caching**: Cache pre-aggregated data and chart images
4. **Memory Management**: Monitor and optimize memory usage during chart generation
5. **Adaptive Complexity**: Adjust chart complexity based on data size
6. **Performance Monitoring**: Track chart generation metrics to identify bottlenecks

By implementing these optimization techniques, you can effectively handle large LimeSurvey datasets while maintaining acceptable performance and chart quality.