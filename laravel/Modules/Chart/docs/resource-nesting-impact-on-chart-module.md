# Resource Nesting Impact on Chart Module - Quaeris Platform

## Overview
The implementation of Filament 5.x resource nesting has significant implications for the Chart module in the Quaeris platform. This document outlines how nested resources enhance chart functionality, organization, and user experience within the survey management system.

## Enhanced Chart Organization Through Nesting

### Previous Structure Limitations
Before resource nesting, charts were organized in a flat structure:
- All charts listed together regardless of survey context
- Difficulty in relating charts to specific surveys or questions
- Complex permission management for chart access
- Poor user experience when managing multiple survey charts

### New Nested Structure Benefits
With resource nesting, charts can now be properly organized:

```
Surveys
├── Survey A
│   ├── Questions
│   │   ├── Question 1
│   │   │   ├── Charts
│   │   │   │   ├── Response Distribution
│   │   │   │   └── Trend Analysis
│   │   └── Question 2
│   │       └── Charts
│   │           └── Comparative Analysis
│   └── Charts
│       ├── Overall Survey Performance
│       └── Response Trends
└── Survey B
    └── ...
```

## Specific Chart Module Improvements

### 1. Survey-Specific Chart Management
Charts can now be managed within the proper survey context:

```php
<?php

namespace Modules\Chart\Filament\Resources\SurveyResource\Pages;

use Modules\Xot\Filament\Pages\XotBaseManageRelatedRecords;
use Modules\Chart\Filament\Resources\ChartResource;

class ManageSurveyCharts extends XotBaseManageRelatedRecords
{
    protected static string $resource = ChartResource::class;
    protected static string $relationship = 'charts'; // Assuming Survey has many Charts
    protected static ?string $navigationLabel = 'Charts';
    protected static ?string $breadcrumb = 'Charts';

    public function getTitle(): string
    {
        $survey = $this->getOwnerRecord();
        return "Charts for: {$survey->title}";
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->getOwnerRecord()->charts()
            ->where('chart_type', 'survey_overview') // Only show survey-level charts
            ->with('user');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->url(ChartResource::getUrl('create', [
                    'survey' => $this->getOwnerRecord()->id
                ]))
                ->label('Create Survey Chart'),
        ];
    }
}
```

### 2. Question-Level Chart Integration
Charts can be created and managed for specific questions within surveys:

```php
<?php

namespace Modules\Chart\Filament\Resources\QuestionResource\Pages;

use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Modules\Chart\Models\Chart;

class ListQuestionCharts extends XotBaseListRecords
{
    protected static string $resource = \Modules\Chart\Filament\Resources\ChartResource::class;

    public ?\Modules\Quaeris\Models\Survey $survey = null;
    public ?\Modules\Quaeris\Models\Question $question = null;

    public function mount(int | string $survey, int | string $question): void
    {
        $this->survey = \Modules\Quaeris\Models\Survey::findOrFail($survey);
        $this->question = \Modules\Quaeris\Models\Question::where('survey_id', $survey)
                                                         ->findOrFail($question);
        
        abort_unless($this->survey->can('viewCharts', $this->survey), 403);
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Chart::query()
            ->where('survey_id', $this->survey->id)
            ->where('question_id', $this->question->id)
            ->where('chart_type', 'question_analysis');
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable(),
            \Filament\Tables\Columns\TextColumn::make('chart_type')
                ->badge()
                ->color('primary'),
            \Filament\Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

## Model Relationships for Nested Charts

### Enhanced Chart Model
```php
<?php

namespace Modules\Chart\Models;

use Modules\Xot\Models\XotBaseModel;

class Chart extends XotBaseModel
{
    protected $fillable = [
        'title',
        'description',
        'chart_type', // survey_overview, question_analysis, comparative, etc.
        'config',
        'survey_id',
        'question_id',
        'user_id',
        'tenant_id',
    ];

    protected $casts = [
        'config' => 'array',
        'survey_id' => 'integer',
        'question_id' => 'integer',
        'user_id' => 'integer',
        'tenant_id' => 'integer',
    ];

    // Relationships
    public function survey()
    {
        return $this->belongsTo(\Modules\Quaeris\Models\Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(\Modules\Quaeris\Models\Question::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    // Scopes for different chart types
    public function scopeSurveyLevel($query)
    {
        return $query->whereNull('question_id');
    }

    public function scopeQuestionLevel($query)
    {
        return $query->whereNotNull('question_id');
    }
}
```

## Improved Dashboard Integration

### Context-Aware Chart Widgets
```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Quaeris\Models\Survey;

class SurveyPerformanceChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Survey Performance';

    public Survey $survey;

    public function mount(int $surveyId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
    }

    protected function getData(): array
    {
        // Get survey performance data
        $responses = \Modules\Quaeris\Models\Response::where('survey_id', $this->survey->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [
                $this->survey->start_date,
                $this->survey->end_date ?? now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Responses',
                    'data' => $responses->pluck('count')->toArray(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
            ],
            'labels' => $responses->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

## Advanced Chart Filtering and Analysis

### Multi-Level Filtering
```php
<?php

namespace Modules\Chart\Services;

use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;

class NestedChartService
{
    public function getSurveyCharts(Survey $survey, array $filters = []): array
    {
        $query = $survey->charts()
            ->where('chart_type', 'survey_overview')
            ->with(['question', 'user']);

        // Apply additional filters
        if (isset($filters['date_range'])) {
            $query->whereBetween('created_at', $filters['date_range']);
        }

        if (isset($filters['chart_type'])) {
            $query->where('chart_type', $filters['chart_type']);
        }

        return $query->get()->toArray();
    }

    public function getQuestionCharts(Survey $survey, Question $question, array $filters = []): array
    {
        $query = $survey->charts()
            ->where('question_id', $question->id)
            ->where('chart_type', 'question_analysis');

        // Apply filters specific to question charts
        if (isset($filters['response_type'])) {
            $query->whereJsonContains('config->response_type', $filters['response_type']);
        }

        return $query->get()->toArray();
    }

    public function generateComparativeChart(array $surveyIds, string $metric): array
    {
        $surveys = Survey::whereIn('id', $surveyIds)->get();
        
        $data = [];
        foreach ($surveys as $survey) {
            $data[$survey->title] = $this->calculateMetric($survey, $metric);
        }

        return $data;
    }

    private function calculateMetric(Survey $survey, string $metric): float
    {
        switch ($metric) {
            case 'completion_rate':
                $expected = $survey->expected_responses ?? 100;
                $actual = $survey->responses()->count();
                return $expected > 0 ? min(100, ($actual / $expected) * 100) : 0;
            case 'average_response_time':
                // Calculate average response time logic
                return $this->calculateAverageResponseTime($survey);
            default:
                return 0;
        }
    }
}
```

## Permission and Authorization Enhancements

### Chart-Specific Policies
```php
<?php

namespace Modules\Chart\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Chart\Models\Chart;

class ChartPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Chart $chart): bool
    {
        // Check if user can view the parent survey
        if (!$user->can('view', $chart->survey)) {
            return false;
        }

        // Additional chart-specific permissions
        return $user->can('view', $chart->survey) || 
               $user->id === $chart->user_id ||
               $user->hasRole('admin');
    }

    public function create(User $user, $parent): bool
    {
        // $parent could be a Survey or Question model
        if ($parent instanceof \Modules\Quaeris\Models\Survey) {
            return $user->can('update', $parent);
        } elseif ($parent instanceof \Modules\Quaeris\Models\Question) {
            return $user->can('update', $parent->survey);
        }

        return false;
    }

    public function update(User $user, Chart $chart): bool
    {
        if (!$user->can('view', $chart)) {
            return false;
        }

        // Users can update their own charts or have admin privileges
        return $user->id === $chart->user_id || 
               $user->hasRole('admin') ||
               $user->can('manage', $chart->survey);
    }
}
```

## Performance Optimization for Nested Charts

### Caching Strategies
```php
<?php

namespace Modules\Chart\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Chart\Models\Chart;

class ChartCacheService
{
    public function getCachedSurveyCharts(int $surveyId, string $type = 'all'): array
    {
        $cacheKey = "survey_charts_{$surveyId}_{$type}_" . now()->format('Y-m-d');
        
        return Cache::remember($cacheKey, 3600, function() use ($surveyId, $type) {
            $query = Chart::where('survey_id', $surveyId);
            
            if ($type !== 'all') {
                $query->where('chart_type', $type);
            }
            
            return $query->with(['question', 'user'])->get()->toArray();
        });
    }

    public function getCachedQuestionCharts(int $surveyId, int $questionId): array
    {
        $cacheKey = "question_charts_{$surveyId}_{$questionId}_" . now()->format('Y-m-d-H');
        
        return Cache::remember($cacheKey, 1800, function() use ($surveyId, $questionId) {
            return Chart::where('survey_id', $surveyId)
                       ->where('question_id', $questionId)
                       ->where('chart_type', 'question_analysis')
                       ->get()
                       ->toArray();
        });
    }

    public function invalidateSurveyChartCache(int $surveyId): void
    {
        // Invalidate all chart caches for this survey
        Cache::forget("survey_charts_{$surveyId}_all_" . now()->format('Y-m-d'));
        Cache::forget("survey_charts_{$surveyId}_survey_overview_" . now()->format('Y-m-d'));
        
        // Could also use cache tags if supported
        // Cache::tags(['survey_charts', "survey_{$surveyId}"])->flush();
    }
}
```

## Integration with Existing Chart Workflows

### JpGraph Integration in Nested Context
```php
<?php

namespace Modules\Chart\Services;

use Modules\Chart\Models\Chart;
use Modules\Quaeris\Models\Survey;

class JpGraphNestedService
{
    public function generateSurveyChart(Survey $survey, string $chartType, array $options = []): string
    {
        // Get survey data for chart generation
        $data = $this->getSurveyDataForChart($survey, $chartType);
        
        // Create appropriate JpGraph based on type
        switch ($chartType) {
            case 'response_trends':
                return $this->generateResponseTrendsChart($data, $survey->title);
            case 'completion_rate':
                return $this->generateCompletionRateChart($data, $survey->title);
            case 'question_comparison':
                return $this->generateQuestionComparisonChart($data, $survey->title);
            default:
                throw new \Exception("Unknown chart type: {$chartType}");
        }
    }

    private function generateResponseTrendsChart(array $data, string $title): string
    {
        // Use JpGraph to generate trend chart
        $graph = new \Graph(800, 400);
        $graph->SetScale('textlin');
        $graph->title->Set("Response Trends - {$title}");
        
        $linePlot = new \LinePlot(array_values($data));
        $linePlot->SetLegend('Responses');
        
        $graph->xaxis->SetTickLabels(array_keys($data));
        $graph->Add($linePlot);
        
        $chartPath = storage_path("app/charts/surveys/{$title}_trends.png");
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }

    public function generateQuestionChart(Survey $survey, int $questionId, string $chartType): string
    {
        // Get question-specific data
        $data = $this->getQuestionDataForChart($survey, $questionId, $chartType);
        
        // Generate question-specific chart
        switch ($chartType) {
            case 'distribution':
                return $this->generateDistributionChart($data, $survey, $questionId);
            case 'trend':
                return $this->generateQuestionTrendChart($data, $survey, $questionId);
            default:
                return $this->generateDistributionChart($data, $survey, $questionId);
        }
    }
}
```

## User Experience Improvements

### Breadcrumb Navigation
With nested resources, users get clear context of where they are in the hierarchy:

```
Dashboard → Surveys → [Survey Name] → Charts
Dashboard → Surveys → [Survey Name] → Questions → [Question] → Charts
```

### Context-Aware Actions
- "Create Chart" buttons know the current context (survey or question level)
- Chart types are filtered based on the current nesting level
- Permissions are automatically applied based on parent resource access
- Data is automatically filtered to the current context

## Migration Path for Existing Chart Features

### 1. Database Migration
```php
class AddParentReferencesToCharts extends Migration
{
    public function up(): void
    {
        Schema::table('charts', function (Blueprint $table) {
            $table->foreignId('survey_id')->nullable()->after('id')->constrained('surveys');
            $table->foreignId('question_id')->nullable()->after('survey_id')->constrained('questions');
            $table->string('chart_type')->default('survey_overview')->after('description');
            
            // Indexes for performance
            $table->index(['survey_id', 'chart_type']);
            $table->index(['survey_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::table('charts', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->dropForeign(['question_id']);
            $table->dropIndex(['survey_id', 'chart_type']);
            $table->dropIndex(['survey_id', 'question_id']);
            $table->dropColumn(['survey_id', 'question_id', 'chart_type']);
        });
    }
}
```

### 2. Data Migration
```php
class MigrateExistingChartsToNestedStructure extends Migration
{
    public function up(): void
    {
        // For existing charts, determine appropriate survey/question context
        \Modules\Chart\Models\Chart::chunk(100, function ($charts) {
            foreach ($charts as $chart) {
                // Determine survey based on chart configuration or other data
                $surveyId = $this->determineSurveyForChart($chart);
                
                $chart->update(['survey_id' => $surveyId]);
            }
        });
    }

    private function determineSurveyForChart($chart)
    {
        // Logic to determine which survey this chart belongs to
        // Could be based on chart title, description, or other metadata
        // Implementation depends on existing data structure
        return null; // Placeholder
    }
}
```

## Summary of Benefits

### For End Users:
1. **Better Organization**: Charts organized by survey and question context
2. **Improved Navigation**: Clear hierarchical structure and breadcrumbs
3. **Contextual Actions**: Relevant chart types and options based on context
4. **Enhanced Permissions**: Granular access control based on survey access

### For Developers:
1. **Cleaner Code**: Organized resource structure and relationships
2. **Better Maintainability**: Logical grouping of related functionality
3. **Performance**: Optimized queries with proper relationships
4. **Scalability**: Easier to add new nested features

### For System Administrators:
1. **Security**: Improved authorization and data isolation
2. **Performance**: Better query optimization and caching
3. **Maintainability**: Clearer system architecture
4. **Monitoring**: Better tracking of user activities within contexts

The implementation of resource nesting in the Chart module significantly enhances the functionality and user experience while maintaining security and performance standards required by the Quaeris platform.