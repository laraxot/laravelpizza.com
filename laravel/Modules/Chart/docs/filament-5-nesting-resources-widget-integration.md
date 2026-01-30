# Filament 5.x Resource Nesting - Widget Integration Guide

## Overview
This document focuses on integrating nested resources with Filament widgets in the context of the Quaeris survey management platform. It covers how to create widgets that work within nested resource contexts and how to display nested data effectively.

## Widget Integration with Nested Resources

### Creating Context-Aware Widgets
When working with nested resources, widgets need to be aware of their context to properly display and interact with nested data:

```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;

class SurveyQuestionStatsWidget extends XotBaseWidget
{
    protected static string $view = 'quaeris::widgets.survey-question-stats';

    protected int | string | array $columnSpan = 2;

    public Survey $survey;
    public ?Question $question = null;

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'text/html',
        ];
    }

    protected function getListeners(): array
    {
        return [
            'refresh-survey-stats' => '$refresh',
        ];
    }

    public function mount(int $surveyId, ?int $questionId = null): void
    {
        $this->survey = Survey::findOrFail($surveyId);
        
        if ($questionId) {
            $this->question = Question::where('survey_id', $surveyId)
                                    ->findOrFail($questionId);
        }
    }

    public function getStats(): array
    {
        if ($this->question) {
            // Stats for specific question within survey
            return [
                'total_responses' => $this->question->responses()->count(),
                'completion_rate' => $this->calculateQuestionCompletionRate(),
                'average_time' => $this->calculateAverageResponseTime(),
            ];
        } else {
            // Overall survey stats
            return [
                'total_questions' => $this->survey->questions()->count(),
                'total_responses' => $this->survey->responses()->count(),
                'completion_rate' => $this->calculateSurveyCompletionRate(),
            ];
        }
    }

    private function calculateQuestionCompletionRate(): float
    {
        $totalSurveys = $this->survey->responses()->count();
        $questionResponses = $this->question->responses()->count();
        
        return $totalSurveys > 0 ? ($questionResponses / $totalSurveys) * 100 : 0;
    }

    private function calculateSurveyCompletionRate(): float
    {
        $expectedResponses = $this->survey->expected_responses ?? 100;
        $actualResponses = $this->survey->responses()->count();
        
        return $expectedResponses > 0 ? min(100, ($actualResponses / $expectedResponses) * 100) : 0;
    }
}
```

### Nested Resource Dashboard with Widgets
Creating dashboards that work within nested resource contexts:

```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Quaeris\Filament\Widgets\SurveyQuestionStatsWidget;
use Modules\Quaeris\Filament\Widgets\SurveyResponseTrendsWidget;
use Modules\Quaeris\Models\Survey;

class SurveyDashboard extends XotBasePage
{
    protected static string $view = 'filament.resources.survey-resource.pages.survey-dashboard';

    public Survey $survey;

    public function mount(int $record): void
    {
        $this->survey = Survey::findOrFail($record);
        
        // Verify user has access to this survey
        abort_unless($this->survey->can('view', $this->survey), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('back_to_surveys')
                ->url(\Modules\Quaeris\Filament\Resources\SurveyResource::getUrl('index'))
                ->color('gray'),
        ];
    }

    public function getWidgets(): array
    {
        return [
            SurveyQuestionStatsWidget::class,
            SurveyResponseTrendsWidget::class,
            // Add more survey-specific widgets
        ];
    }

    public function getColumns(): array
    {
        return [
            'sm' => 2,
            'md' => 4,
            'lg' => 6,
        ];
    }
}
```

## Chart Widgets in Nested Contexts

### Survey-Specific Chart Widgets
Creating chart widgets that work within survey contexts:

```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Quaeris\Models\Survey;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SurveyResponseTrendsWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Response Trends';

    public Survey $survey;

    public function mount(int $surveyId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
    }

    protected function getData(): array
    {
        $trend = Trend::model(\Modules\Quaeris\Models\Response::class)
            ->between(
                start: $this->survey->start_date,
                end: $this->survey->end_date ?? now(),
            )
            ->where('survey_id', $this->survey->id)
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Responses',
                    'data' => $trend->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#93C5FD',
                ],
            ],
            'labels' => $trend->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### Question-Specific Chart Widgets
Charts that work within question contexts:

```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Models\Survey;

class QuestionResponseDistributionWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Response Distribution';

    public Survey $survey;
    public Question $question;

    public function mount(int $surveyId, int $questionId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
        $this->question = Question::where('survey_id', $surveyId)
                                 ->findOrFail($questionId);
    }

    protected function getData(): array
    {
        $responses = $this->question->responses()
            ->selectRaw('answer_value, COUNT(*) as count')
            ->groupBy('answer_value')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Response Count',
                    'data' => $responses->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                        '#EC4899', '#06B6D4', '#84CC16', '#F97316', '#6366F1'
                    ],
                ],
            ],
            'labels' => $responses->pluck('answer_value')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
```

## Livewire Integration in Nested Widgets

### Livewire Components for Nested Interactions
Creating Livewire components that work within nested resource contexts:

```php
<?php

namespace Modules\Quaeris\Http\Livewire;

use Livewire\Component;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Models\Response;

class SurveyQuestionManager extends Component
{
    public Survey $survey;
    public ?Question $selectedQuestion = null;
    public $questions = [];
    
    protected $listeners = [
        'questionCreated' => 'refreshQuestions',
        'questionUpdated' => 'refreshQuestions',
    ];

    public function mount($surveyId)
    {
        $this->survey = Survey::findOrFail($surveyId);
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        $this->questions = $this->survey->questions()
            ->with(['responses' => function($query) {
                $query->limit(5); // Limit for performance
            }])
            ->orderBy('sort_order')
            ->get()
            ->toArray();
    }

    public function selectQuestion($questionId)
    {
        $this->selectedQuestion = Question::where('survey_id', $this->survey->id)
                                         ->findOrFail($questionId);
        $this->emit('questionSelected', $questionId);
    }

    public function createQuestion($data)
    {
        $question = new Question([
            'survey_id' => $this->survey->id,
            'question_text' => $data['question_text'],
            'question_type' => $data['question_type'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);
        
        $question->save();
        
        $this->emit('questionCreated');
        $this->refreshQuestions();
    }

    public function updateQuestion($questionId, $data)
    {
        $question = Question::where('survey_id', $this->survey->id)
                           ->findOrFail($questionId);
        
        $question->update($data);
        
        $this->emit('questionUpdated');
        $this->refreshQuestions();
    }

    public function deleteQuestion($questionId)
    {
        $question = Question::where('survey_id', $this->survey->id)
                           ->findOrFail($questionId);
        
        $question->delete();
        
        $this->emit('questionUpdated');
        $this->refreshQuestions();
    }

    public function refreshQuestions()
    {
        $this->loadQuestions();
    }

    public function render()
    {
        return view('quaeris::livewire.survey-question-manager');
    }
}
```

## Form Integration in Nested Contexts

### Nested Resource Forms
Creating forms that work within nested resource contexts:

```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Modules\Xot\Filament\Pages\XotBaseCreateRecord;
use Modules\Quaeris\Models\Survey;

class CreateSurveyQuestion extends XotBaseCreateRecord
{
    protected static string $resource = \Modules\Quaeris\Filament\Resources\QuestionResource::class;

    public Survey $survey;

    public function mount(): void
    {
        $this->survey = Survey::findOrFail(request()->route()->parameter('survey'));
        
        // Check if user can add questions to this survey
        abort_unless($this->survey->can('update', $this->survey), 403);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('survey_id')
                    ->default($this->survey->id),
                
                Forms\Components\Textarea::make('question_text')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('question_type')
                    ->options([
                        'Y' => 'Yes/No',
                        'N' => 'Number',
                        'G' => 'Gender',
                        'L' => 'List (Dropdown)',
                        '!' => 'List with Comment',
                        '1' => 'Array (Numbers)',
                    ])
                    ->required(),
                
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\Toggle::make('required')
                    ->default(false),
            ])
            ->model(\Modules\Quaeris\Models\Question::class);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['survey_id'] = $this->survey->id;
        
        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index', [
            'survey' => $this->survey->id
        ]);
    }
}
```

## Widget Communication in Nested Contexts

### Event-Driven Widget Communication
Implementing communication between widgets in nested resource contexts:

```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Quaeris\Models\Survey;

class SurveyFilterWidget extends XotBaseWidget
{
    protected static string $view = 'quaeris::widgets.survey-filter';

    public Survey $survey;

    protected $queryString = [
        'dateRange' => ['except' => ''],
        'questionType' => ['except' => ''],
    ];

    public $dateRange = '';
    public $questionType = '';

    public function mount(int $surveyId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
    }

    public function updatedDateRange()
    {
        $this->emit('surveyFilterChanged', [
            'dateRange' => $this->dateRange,
            'questionType' => $this->questionType
        ]);
    }

    public function updatedQuestionType()
    {
        $this->emit('surveyFilterChanged', [
            'dateRange' => $this->dateRange,
            'questionType' => $this->questionType
        ]);
    }

    public function resetFilters()
    {
        $this->dateRange = '';
        $this->questionType = '';
        
        $this->emit('surveyFilterChanged', [
            'dateRange' => '',
            'questionType' => ''
        ]);
    }
}
```

### Widget Receiving Filter Events
```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Quaeris\Models\Survey;

class FilteredSurveyChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Filtered Survey Data';

    public Survey $survey;
    public $activeFilters = [
        'dateRange' => '',
        'questionType' => '',
    ];

    public function mount(int $surveyId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
    }

    protected function getListeners(): array
    {
        return [
            'surveyFilterChanged' => 'applyFilters',
        ];
    }

    public function applyFilters($filters)
    {
        $this->activeFilters = $filters;
        $this->dispatch('$refresh');
    }

    protected function getData(): array
    {
        $query = \Modules\Quaeris\Models\Response::query()
            ->where('survey_id', $this->survey->id);

        // Apply date range filter
        if (!empty($this->activeFilters['dateRange'])) {
            $dates = explode(' to ', $this->activeFilters['dateRange']);
            if (count($dates) === 2) {
                $query->whereBetween('created_at', $dates);
            }
        }

        // Apply question type filter
        if (!empty($this->activeFilters['questionType'])) {
            $query->whereHas('question', function($q) {
                $q->where('question_type', $this->activeFilters['questionType']);
            });
        }

        $responses = $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Filtered Responses',
                    'data' => $responses->pluck('count')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#A7F3D0',
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

## Performance Optimization for Nested Widgets

### Efficient Data Loading
Optimizing widget performance in nested contexts:

```php
<?php

namespace Modules\Quaeris\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Quaeris\Models\Survey;

class NestedWidgetCacheService
{
    public function getSurveyWidgetData(Survey $survey, string $widgetType, array $filters = []): array
    {
        $cacheKey = $this->buildCacheKey($survey, $widgetType, $filters);
        
        return Cache::remember($cacheKey, 300, function() use ($survey, $widgetType, $filters) {
            return $this->fetchWidgetData($survey, $widgetType, $filters);
        });
    }

    private function buildCacheKey(Survey $survey, string $widgetType, array $filters): string
    {
        return "survey_widget_{$survey->id}_{$widgetType}_" . md5(serialize($filters));
    }

    private function fetchWidgetData(Survey $survey, string $widgetType, array $filters): array
    {
        switch ($widgetType) {
            case 'question_stats':
                return $this->getQuestionStats($survey, $filters);
            case 'response_trends':
                return $this->getResponseTrends($survey, $filters);
            case 'completion_rates':
                return $this->getCompletionRates($survey, $filters);
            default:
                return [];
        }
    }

    private function getQuestionStats(Survey $survey, array $filters): array
    {
        $query = $survey->questions();
        
        if (isset($filters['type'])) {
            $query->where('question_type', $filters['type']);
        }
        
        return [
            'total' => $query->count(),
            'required' => $query->where('required', true)->count(),
            'types' => $query->groupBy('question_type')
                           ->selectRaw('question_type, COUNT(*) as count')
                           ->pluck('count', 'question_type')
                           ->toArray(),
        ];
    }

    public function invalidateSurveyWidgetCache(Survey $survey): void
    {
        // In a real implementation, you'd have a more sophisticated cache invalidation
        // This is a simplified version
        Cache::flush(); // In production, use tags or more specific invalidation
    }
}
```

## Testing Nested Widget Integration

### Widget Tests for Nested Contexts
```php
<?php

namespace Modules\Quaeris\Tests\Feature\Widgets;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Filament\Widgets\SurveyQuestionStatsWidget;

class NestedWidgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_survey_question_stats_widget_loads_in_context(): void
    {
        $survey = Survey::factory()->create();
        $question = Question::factory()->create(['survey_id' => $survey->id]);

        Livewire::test(SurveyQuestionStatsWidget::class, [
            'surveyId' => $survey->id,
            'questionId' => $question->id,
        ])
        ->assertSet('survey.id', $survey->id)
        ->assertSet('question.id', $question->id);
    }

    public function test_survey_filter_widget_emits_events(): void
    {
        $survey = Survey::factory()->create();

        Livewire::test(SurveyFilterWidget::class, [
            'surveyId' => $survey->id,
        ])
        ->set('dateRange', '2023-01-01 to 2023-12-31')
        ->assertEmitted('surveyFilterChanged');
    }

    public function test_filtered_chart_widget_receives_filters(): void
    {
        $survey = Survey::factory()->create();

        Livewire::test(FilteredSurveyChartWidget::class, [
            'surveyId' => $survey->id,
        ])
        ->call('applyFilters', [
            'dateRange' => '2023-01-01 to 2023-12-31',
            'questionType' => 'Y',
        ])
        ->assertSet('activeFilters.dateRange', '2023-01-01 to 2023-12-31');
    }
}
```

## Best Practices for Widget Integration

### 1. Context Preservation
Always preserve the nested context in widgets by passing parent IDs and verifying access.

### 2. Performance Considerations
Use caching and efficient queries to prevent performance issues in nested contexts.

### 3. Consistent User Experience
Maintain consistent UI/UX patterns across all nested widget implementations.

### 4. Error Handling
Implement proper error handling for cases where parent resources are not accessible.

### 5. Security
Always verify user permissions at each level of nesting.

This guide provides comprehensive coverage of integrating widgets with nested resources in the Quaeris platform, ensuring proper functionality, performance, and security in nested contexts.