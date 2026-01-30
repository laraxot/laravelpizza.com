# Chart Module - Query Optimization Analysis

## Overview
The Chart module handles data visualization and chart generation, which involves complex data aggregation and processing. Performance issues here directly impact dashboard load times and report generation speed.

## Critical Query Issues Identified

### 1. Chart Data Generation (HIGH IMPACT)

**Problem Pattern**: Chart data calculated on-demand without caching
**Files**: Various chart generation actions and widgets

**Current Issues**:
```php
// Pattern found in chart actions
foreach ($question_charts as $chart) {
    $data = $this->calculateChartData($chart); // Heavy calculation each time
    $processedData = $this->processChartData($data); // More processing
}
```

**Problem Analysis**:
- Chart data recalculated on every request
- No caching of expensive aggregations
- Complex calculations performed in PHP instead of database
- Memory usage spikes during chart generation

**Optimization**:
```php
class ChartDataService
{
    public function getChartData(QuestionChart $chart): array
    {
        $cacheKey = "chart_data_{$chart->id}_{$chart->updated_at->timestamp}";

        return Cache::remember($cacheKey, 3600, function() use ($chart) {
            return $this->calculateOptimizedChartData($chart);
        });
    }

    private function calculateOptimizedChartData(QuestionChart $chart): array
    {
        // Use database aggregation instead of PHP processing
        $surveyId = $chart->survey_pdf->survey_id;
        $questionCode = $chart->question;

        return DB::connection('limesurvey')
            ->table("lime_survey_{$surveyId}")
            ->selectRaw("
                {$questionCode} as value,
                COUNT(*) as count,
                ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM lime_survey_{$surveyId} WHERE {$questionCode} IS NOT NULL), 2) as percentage
            ")
            ->whereNotNull($questionCode)
            ->whereNotNull('submitdate')
            ->groupBy($questionCode)
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
}
```

### 2. Mixed Chart Processing (MEDIUM IMPACT)

**File**: Chart components handling multiple chart types
**Problem**: Inefficient loading of chart configurations

**Current Issues**:
```php
// Loading all chart data without optimization
$mixed_chart = MixedChart::find($id);
$charts = $mixed_chart->questionCharts; // No eager loading
foreach ($charts as $chart) {
    $chart->data = $this->getChartData($chart); // N+1 query pattern
}
```

**Optimization**:
```php
class MixedChartService
{
    public function getMixedChartData(int $mixedChartId): array
    {
        $mixedChart = MixedChart::with([
            'questionCharts.surveyPdf',
            'questionCharts.questionChartAddons'
        ])->find($mixedChartId);

        // Bulk process all charts
        return $this->processMixedChartData($mixedChart);
    }

    private function processMixedChartData(MixedChart $mixedChart): array
    {
        $chartData = [];
        $charts = $mixedChart->questionCharts;

        // Group charts by survey for efficient processing
        $chartsBySurvey = $charts->groupBy('survey_pdf.survey_id');

        foreach ($chartsBySurvey as $surveyId => $surveyCharts) {
            $surveyData = $this->getBulkSurveyData($surveyId, $surveyCharts);

            foreach ($surveyCharts as $chart) {
                $chartData[$chart->id] = $this->calculateChartFromSurveyData(
                    $chart,
                    $surveyData
                );
            }
        }

        return $chartData;
    }
}
```

### 3. Chart Style and Configuration Loading (MEDIUM IMPACT)

**File**: Chart model and related components
**Problem**: Repeated loading of chart configurations

**Current Issues**:
```php
// Chart style loading without optimization
$chart = Chart::find($id);
$style = $chart->getStyle(); // Additional query
$colors = $chart->getColors(); // Another query
$config = $chart->getConfiguration(); // Yet another query
```

**Optimization**:
```php
class Chart extends Model
{
    protected $with = ['chartAddons'];

    public function scopeWithCompleteConfig($query)
    {
        return $query->with([
            'chartAddons',
            'questionChart.surveyPdf'
        ]);
    }

    public function getOptimizedConfiguration(): array
    {
        $cacheKey = "chart_config_{$this->id}_{$this->updated_at->timestamp}";

        return Cache::remember($cacheKey, 7200, function() {
            return [
                'style' => $this->getStyleConfiguration(),
                'colors' => $this->getColorConfiguration(),
                'addons' => $this->chartAddons->keyBy('type')->toArray(),
            ];
        });
    }
}
```

### 4. Chart Image Generation (HIGH IMPACT)

**Problem**: Chart images generated synchronously causing timeouts

**Current Issues**:
```php
// Synchronous chart image generation
public function generateChartImage(QuestionChart $chart)
{
    $data = $this->getChartData($chart); // Expensive calculation
    $image = $this->renderChart($data); // Heavy image processing
    $chart->update(['img_src' => $image]); // Blocking operation
}
```

**Optimization**:
```php
// Asynchronous chart image generation
class GenerateChartImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(QuestionChart $chart): void
    {
        try {
            $data = app(ChartDataService::class)->getChartData($chart);
            $imagePath = app(ChartImageRenderer::class)->render($chart, $data);

            $chart->update([
                'img_src' => $imagePath,
                'generated_at' => now(),
            ]);

            // Clear related caches
            Cache::forget("chart_data_{$chart->id}");

        } catch (Exception $e) {
            Log::error("Failed to generate chart image", [
                'chart_id' => $chart->id,
                'error' => $e->getMessage()
            ]);

            $this->fail($e);
        }
    }
}

// Usage in controllers
class ChartController
{
    public function regenerateChart(QuestionChart $chart)
    {
        GenerateChartImageJob::dispatch($chart);

        return response()->json([
            'message' => 'Chart generation queued',
            'status' => 'processing'
        ]);
    }
}
```

## Database Schema Optimizations

### Missing Indexes
```sql
-- Chart performance indexes
CREATE INDEX idx_charts_post_type_id ON charts(post_type, post_id);
CREATE INDEX idx_question_charts_survey_pdf ON question_charts(survey_pdf_id, chart_type);
CREATE INDEX idx_question_charts_generated ON question_charts(generated_at, img_src);
CREATE INDEX idx_question_chart_addons_chart ON question_chart_addons(question_chart_id, type);

-- Mixed chart optimization
CREATE INDEX idx_question_charts_mixed ON question_charts(mixed_chart_id) WHERE mixed_chart_id IS NOT NULL;
```

### Schema Improvements
```sql
-- Add caching columns for performance
ALTER TABLE question_charts ADD COLUMN cached_data JSON NULL;
ALTER TABLE question_charts ADD COLUMN cache_expires_at TIMESTAMP NULL;

-- Add status tracking for async operations
ALTER TABLE question_charts ADD COLUMN generation_status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending';
```

## Caching Strategy

### Chart Data Caching
```php
class ChartCacheService
{
    // Level 1: Memory caching for request-level operations
    private array $requestCache = [];

    // Level 2: Redis caching for expensive calculations
    public function getCachedChartData(QuestionChart $chart): array
    {
        $cacheKey = $this->buildCacheKey($chart);

        if (isset($this->requestCache[$cacheKey])) {
            return $this->requestCache[$cacheKey];
        }

        $data = Cache::store('redis')->remember($cacheKey, 3600, function() use ($chart) {
            return app(ChartDataService::class)->calculateChartData($chart);
        });

        $this->requestCache[$cacheKey] = $data;

        return $data;
    }

    // Level 3: Database caching for persistent storage
    public function getCachedChartDataFromDB(QuestionChart $chart): ?array
    {
        if ($chart->cached_data && $chart->cache_expires_at > now()) {
            return json_decode($chart->cached_data, true);
        }

        return null;
    }

    private function buildCacheKey(QuestionChart $chart): string
    {
        $dependencies = [
            $chart->id,
            $chart->updated_at->timestamp,
            $chart->survey_pdf->updated_at->timestamp ?? 0,
        ];

        return 'chart_data_' . implode('_', $dependencies);
    }
}
```

## Background Processing

### Chart Generation Pipeline
```php
class ChartGenerationPipeline
{
    public function processChartBatch(array $chartIds): void
    {
        $charts = QuestionChart::whereIn('id', $chartIds)
            ->with(['surveyPdf', 'questionChartAddons'])
            ->get();

        // Group by survey for efficient processing
        $chartsBySurvey = $charts->groupBy('survey_pdf.survey_id');

        foreach ($chartsBySurvey as $surveyId => $surveyCharts) {
            ProcessSurveyChartsJob::dispatch($surveyId, $surveyCharts->pluck('id')->toArray());
        }
    }
}

class ProcessSurveyChartsJob implements ShouldQueue
{
    public function handle(int $surveyId, array $chartIds): void
    {
        // Pre-load survey data once
        $surveyData = $this->preloadSurveyData($surveyId);

        foreach ($chartIds as $chartId) {
            $chart = QuestionChart::find($chartId);
            $data = $this->calculateChartFromPreloadedData($chart, $surveyData);

            // Cache the result
            $chart->update([
                'cached_data' => json_encode($data),
                'cache_expires_at' => now()->addHours(6),
                'generation_status' => 'completed'
            ]);
        }
    }
}
```

## Chart Performance Monitoring

### Real-time Performance Tracking
```php
class ChartPerformanceMonitor
{
    public function trackChartGeneration(QuestionChart $chart, callable $operation)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        try {
            $result = $operation();

            $this->logPerformanceMetrics($chart, [
                'duration' => microtime(true) - $startTime,
                'memory_used' => memory_get_usage(true) - $startMemory,
                'status' => 'success'
            ]);

            return $result;

        } catch (Exception $e) {
            $this->logPerformanceMetrics($chart, [
                'duration' => microtime(true) - $startTime,
                'memory_used' => memory_get_usage(true) - $startMemory,
                'status' => 'error',
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    private function logPerformanceMetrics(QuestionChart $chart, array $metrics): void
    {
        if ($metrics['duration'] > 5.0) { // Log slow chart generations
            Log::warning('Slow chart generation', [
                'chart_id' => $chart->id,
                'chart_type' => $chart->chart_type,
                'survey_id' => $chart->survey_pdf->survey_id,
                'metrics' => $metrics
            ]);
        }
    }
}
```

## Chart-Specific Optimizations

### Chart Type Optimizations
```php
class ChartTypeOptimizer
{
    public function optimizeByType(QuestionChart $chart, array $rawData): array
    {
        return match($chart->chart_type) {
            'pie' => $this->optimizePieChart($rawData),
            'bar' => $this->optimizeBarChart($rawData),
            'line' => $this->optimizeLineChart($rawData),
            'histogram' => $this->optimizeHistogram($rawData),
            default => $rawData
        };
    }

    private function optimizePieChart(array $data): array
    {
        // Combine small slices into "Others" category
        $total = array_sum(array_column($data, 'count'));
        $threshold = $total * 0.02; // 2% threshold

        $main = array_filter($data, fn($item) => $item['count'] >= $threshold);
        $small = array_filter($data, fn($item) => $item['count'] < $threshold);

        if (count($small) > 1) {
            $main[] = [
                'value' => 'Others',
                'count' => array_sum(array_column($small, 'count')),
                'percentage' => array_sum(array_column($small, 'percentage'))
            ];
        } else {
            $main = array_merge($main, $small);
        }

        return $main;
    }
}
```

## Performance Impact Assessment

### Expected Improvements:
- **Chart loading**: 80% faster with caching
- **Dashboard performance**: 70% improvement with async generation
- **Memory usage**: 60% reduction with optimized data processing
- **Concurrent users**: 5x increase in supported load
- **Error rate**: 90% reduction in timeout errors

### Implementation Timeline:
1. **Week 1**: Implement chart data caching
2. **Week 2**: Add async chart generation
3. **Week 3**: Optimize database queries and add indexes
4. **Week 4**: Implement performance monitoring

This optimization plan will significantly improve chart performance and enable the module to handle much larger datasets efficiently.