# Chart Module Enhancement: LimeSurvey Patterns

## 🎯 Enhanced Chart Architecture with LimeSurvey Insights

### 1. **Configuration-Driven Chart System**

#### LimeSurvey-Inspired Configuration
```php
<?php declare(strict_types=1);

// config/chart.php - Inspired by LimeSurvey's layered configuration
return [
    'defaults' => [
        'chart_type' => 'hybrid',
        'engine' => 'auto', // jpgraph, chartjs, auto
        'theme' => 'professional',
        'locale' => 'it'
    ],
    
    'performance' => [
        'cache_ttl' => 3600,
        'max_data_points' => 1000,
        'chunk_size' => 500,
        'memory_limit_mb' => 256,
        'enable_optimization' => true
    ],
    
    'security' => [
        'validate_input_data' => true,
        'sanitize_labels' => true,
        'rate_limit_charts' => true,
        'max_charts_per_hour' => 100
    ],
    
    'jpgraph' => [
        'cache_path' => storage_path('app/public/charts'),
        'image_quality' => 90,
        'default_width' => 800,
        'default_height' => 400,
        'enable_caching' => true
    ],
    
    'chartjs' => [
        'enable_animations' => true,
        'responsive' => true,
        'interaction_timeout' => 30000,
        'tooltip_localization' => 'it'
    ],
    
    'business' => [
        'currency_symbol' => '€',
        'decimal_separator' => ',',
        'thousands_separator' => '.',
        'date_format' => 'd/m/Y',
        'color_palette' => [
            '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
            '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
        ]
    ]
];
```

#### Configuration Manager Implementation
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

// LimeSurvey-style configuration management
final class ChartConfigManager
{
    private array $configCache = [];
    private EventDispatcher $events;
    
    public function __construct(EventDispatcher $events)
    {
        $this->events = $events;
    }
    
    public function get(string $key, $default = null): mixed
    {
        if (!isset($this->configCache[$key])) {
            $this->configCache[$key] = $this->resolveConfigValue($key, $default);
        }
        
        return $this->configCache[$key];
    }
    
    private function resolveConfigValue(string $key, $default): mixed
    {
        $keys = explode('.', $key);
        $value = config('chart.defaults');
        
        foreach ($keys as $k) {
            if (is_array($value) && isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return $value;
    }
    
    public function getChartEngine(): string
    {
        return $this->get('defaults.engine', 'auto');
    }
    
    public function getPerformanceSettings(): array
    {
        return [
            'cache_ttl' => $this->get('performance.cache_ttl', 3600),
            'max_data_points' => $this->get('performance.max_data_points', 1000),
            'chunk_size' => $this->get('performance.chunk_size', 500),
            'memory_limit' => $this->get('performance.memory_limit_mb', 256) * 1024 * 1024
        ];
    }
}
```

### 2. **Event-Driven Chart Generation System**

#### LimeSurvey-Inspired Plugin Architecture for Charts
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Events;

// Event system inspired by LimeSurvey's plugin architecture
final class ChartEvents
{
    public const BEFORE_CHART_GENERATION = 'chart.before_generation';
    public const AFTER_CHART_GENERATION = 'chart.after_generation';
    public const CHART_DATA_VALIDATION = 'chart.data_validation';
    public const CHART_CACHE_HIT = 'chart.cache_hit';
    public const CHART_CACHE_MISS = 'chart.cache_miss';
    public const CHART_ERROR = 'chart.error';
}

// Event dispatcher for chart lifecycle
final class ChartEventDispatcher
{
    private array $listeners = [];
    
    public function listen(string $event, callable $callback, int $priority = 10): void
    {
        $this->listeners[$event][] = [
            'callback' => $callback,
            'priority' => $priority
        ];
    }
    
    public function dispatch(string $event, array $data = []): mixed
    {
        if (!isset($this->listeners[$event])) {
            return null;
        }
        
        // Sort by priority (higher first)
        usort($this->listeners[$event], fn($a, $b) => $b['priority'] - $a['priority']);
        
        $result = null;
        foreach ($this->listeners[$event] as $listener) {
            $result = ($listener['callback'])($data);
            
            // Allow stopping propagation
            if ($result === false) {
                break;
            }
        }
        
        return $result;
    }
}
```

#### Chart Service with Event Integration
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

// Enhanced chart service with LimeSurvey-inspired event system
final class EventDrivenChartService
{
    private ChartEventDispatcher $events;
    private ChartConfigManager $config;
    private CacheManager $cache;
    
    public function __construct(
        ChartEventDispatcher $events,
        ChartConfigManager $config,
        CacheManager $cache
    ) {
        $this->events = $events;
        $this->config = $config;
        $this->cache = $cache;
    }
    
    public function createChart(string $type, array $data, array $options = []): string
    {
        // Fire before generation event
        $this->events->dispatch(ChartEvents::BEFORE_CHART_GENERATION, [
            'type' => $type,
            'data_points' => count($data),
            'options' => $options
        ]);
        
        try {
            // Validate data
            $this->validateChartData($data);
            
            // Check cache
            $cacheKey = $this->generateCacheKey($type, $data, $options);
            $cachedChart = $this->cache->get($cacheKey);
            
            if ($cachedChart) {
                $this->events->dispatch(ChartEvents::CHART_CACHE_HIT, [
                    'type' => $type,
                    'cache_key' => $cacheKey
                ]);
                return $cachedChart;
            }
            
            // Generate chart
            $chartPath = $this->generateChart($type, $data, $options);
            
            // Cache result
            $this->cache->put($cacheKey, $chartPath, $this->config->get('performance.cache_ttl'));
            
            // Fire after generation event
            $this->events->dispatch(ChartEvents::AFTER_CHART_GENERATION, [
                'type' => $type,
                'chart_path' => $chartPath,
                'generation_time' => $this->getGenerationTime()
            ]);
            
            return $chartPath;
            
        } catch (\Exception $e) {
            $this->events->dispatch(ChartEvents::CHART_ERROR, [
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new ChartGenerationException("Failed to generate {$type} chart: " . $e->getMessage());
        }
    }
    
    private function validateChartData(array $data): void
    {
        $maxPoints = $this->config->get('performance.max_data_points');
        
        if (count($data) > $maxPoints) {
            throw new InvalidArgumentException("Data points exceed maximum allowed: {$maxPoints}");
        }
        
        // Validate each data point
        foreach ($data as $index => $value) {
            if (!is_numeric($value)) {
                throw new InvalidArgumentException("Invalid data point at index {$index}: {$value}");
            }
            
            if (is_infinite($value) || is_nan($value)) {
                throw new InvalidArgumentException("Invalid numeric value at index {$index}: {$value}");
            }
        }
        
        $this->events->dispatch(ChartEvents::CHART_DATA_VALIDATION, [
            'data_points' => count($data),
            'validation_passed' => true
        ]);
    }
    
    private function generateCacheKey(string $type, array $data, array $options): string
    {
        return "chart_{$type}_" . md5(serialize([
            'data' => $data,
            'options' => $options,
            'config_version' => $this->config->get('defaults.version', '1.0')
        ]));
    }
}
```

### 3. **Dynamic Chart Factory System**

#### LimeSurvey-Inspired Factory Pattern
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Factories;

// Factory pattern inspired by LimeSurvey's dynamic system
final class ChartFactory
{
    private static array $chartTypes = [];
    private static array $engines = [];
    
    public static function registerChartType(string $type, string $className): void
    {
        self::$chartTypes[$type] = $className;
    }
    
    public static function registerEngine(string $name, string $className): void
    {
        self::$engines[$name] = $className;
    }
    
    public static function create(string $type, array $data, array $options = []): ChartEngineInterface
    {
        $engine = $options['engine'] ?? config('chart.defaults.engine', 'auto');
        
        // Auto-select best engine
        if ($engine === 'auto') {
            $engine = self::selectOptimalEngine($type, $data);
        }
        
        $chartClass = self::$chartTypes[$type] ?? self::getChartClass($type);
        $engineClass = self::$engines[$engine] ?? self::getEngineClass($engine);
        
        $chartEngine = new $engineClass();
        $chart = new $chartClass($chartEngine);
        
        return $chart->create($data, $options);
    }
    
    private static function selectOptimalEngine(string $type, array $data): string
    {
        $dataPoints = count($data);
        
        // Use JpGraph for static charts with large datasets
        if ($dataPoints > 500) {
            return 'jpgraph';
        }
        
        // Use Chart.js for interactive charts
        if (in_array($type, ['line', 'bar', 'pie'])) {
            return 'chartjs';
        }
        
        // Default to Chart.js
        return 'chartjs';
    }
}
```

### 4. **Performance Monitoring System**

#### LimeSurvey-Inspired Performance Tracking
```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

// Performance monitoring inspired by LimeSurvey's optimization patterns
final class ChartPerformanceMonitor
{
    private array $metrics = [];
    private CacheManager $cache;
    
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }
    
    public function startProfiling(string $operation): void
    {
        $this->metrics[$operation] = [
            'start_time' => microtime(true),
            'start_memory' => memory_get_usage(true),
            'start_peak_memory' => memory_get_peak_usage(true)
        ];
    }
    
    public function endProfiling(string $operation, array $context = []): void
    {
        if (!isset($this->metrics[$operation])) {
            return;
        }
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);
        $endPeakMemory = memory_get_peak_usage(true);
        
        $this->metrics[$operation] = array_merge($this->metrics[$operation], [
            'end_time' => $endTime,
            'end_memory' => $endMemory,
            'end_peak_memory' => $endPeakMemory,
            'context' => $context
        ]);
        
        $duration = ($endTime - $this->metrics[$operation]['start_time']) * 1000; // milliseconds
        $memoryUsed = $endMemory - $this->metrics[$operation]['start_memory'];
        
        // Log performance metrics
        $this->logPerformanceMetrics($operation, $duration, $memoryUsed, $context);
        
        // Check performance thresholds
        $this->checkPerformanceThresholds($operation, $duration, $memoryUsed);
    }
    
    private function logPerformanceMetrics(string $operation, float $duration, int $memoryUsed, array $context): void
    {
        $logData = [
            'operation' => $operation,
            'duration_ms' => round($duration, 2),
            'memory_used_mb' => round($memoryUsed / 1024 / 1024, 2),
            'peak_memory_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'timestamp' => now()->toISOString(),
            'context' => $context
        ];
        
        Log::info('Chart performance metrics', $logData);
        
        // Store in cache for analytics
        $this->cache->put("perf_{$operation}_", $logData, 86400); // 24 hours
    }
    
    private function checkPerformanceThresholds(string $operation, float $duration, int $memoryUsed): void
    {
        $maxDuration = config('chart.performance.max_duration_ms', 2000);
        $maxMemory = config('chart.performance.max_memory_mb', 100) * 1024 * 1024;
        
        if ($duration > $maxDuration) {
            Log::warning('Chart generation exceeded duration threshold', [
                'operation' => $operation,
                'duration' => $duration,
                'threshold' => $maxDuration
            ]);
            
            $this->triggerOptimizationSuggestion($operation, 'slow_generation');
        }
        
        if ($memoryUsed > $maxMemory) {
            Log::warning('Chart generation exceeded memory threshold', [
                'operation' => $operation,
                'memory_used' => round($memoryUsed / 1024 / 1024, 2),
                'threshold' => $maxMemory / 1024 / 1024
            ]);
            
            $this->triggerOptimizationSuggestion($operation, 'high_memory');
        }
    }
    
    public function getPerformanceReport(): array
    {
        $reports = [];
        
        foreach ($this->metrics as $operation => $metrics) {
            if (isset($metrics['end_time'])) {
                $duration = ($metrics['end_time'] - $metrics['start_time']) * 1000;
                $memoryUsed = $metrics['end_memory'] - $metrics['start_memory'];
                
                $reports[$operation] = [
                    'duration_ms' => round($duration, 2),
                    'memory_used_mb' => round($memoryUsed / 1024 / 1024, 2),
                    'peak_memory_mb' => round(($metrics['end_peak_memory'] ?? 0) / 1024 / 1024, 2)
                ];
            }
        }
        
        return $reports;
    }
}
```

## 🚀 Implementation Benefits

### 1. **Enterprise-Grade Architecture**
- **Event-Driven Design**: Extensible plugin-like system
- **Configuration Management**: LimeSurvey-style layered configuration
- **Performance Monitoring**: Comprehensive metrics and optimization
- **Security First**: Built-in validation and protection

### 2. **Enhanced Chart Capabilities**
- **Multi-Engine Support**: JpGraph + Chart.js hybrid
- **Dynamic Factory**: Runtime engine selection
- **Intelligent Caching**: Performance-aware caching strategies
- **Italian Localization**: Built-in business formatting

### 3. **Developer Experience**
- **Easy Extension**: Plugin-like chart type registration
- **Comprehensive Events**: Debugging and monitoring hooks
- **Performance Insights**: Real-time performance data
- **Configuration Flexibility**: Granular control over all aspects

### 4. **Business Benefits**
- **Scalability**: Handle large datasets efficiently
- **Reliability**: Robust error handling and fallbacks
- **Performance**: Optimized for production use
- **Maintainability**: Clean, documented, testable code

This enhanced Chart module transforms from a simple chart generation tool into an enterprise-grade visualization platform while maintaining the Italian business focus and code quality standards of Quaeris Fila5 Mono.