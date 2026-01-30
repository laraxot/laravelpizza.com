# Filament 5.x Resource Nesting - Practical Use Cases and Examples

## Overview
This document provides practical use cases and implementation examples for resource nesting in Filament 5.x specifically tailored for the Quaeris survey management platform. It covers real-world scenarios with complete code examples.

## Case Study 1: Survey Management with Questions and Responses

### Problem Statement
Implement a complete survey management system where:
- Surveys contain multiple questions
- Questions have multiple response options
- Responses are collected and analyzed
- All operations happen within proper nested contexts

### Complete Implementation

#### Survey Resource
```php
<?php

namespace Modules\Quaeris\Filament\Resources;

use Filament\{Laravel\Commands\MakeResourceCommand};
use Filament\Resources\Resource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\Survey;

class SurveyResource extends XotBaseResource
{
    protected static ?string $model = Survey::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Survey Management';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Surveys';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            'questions' => Pages\ManageSurveyQuestions::route('/{record}/questions'),
            'responses' => Pages\ManageSurveyResponses::route('/{record}/responses'),
            'analytics' => Pages\SurveyAnalytics::route('/{record}/analytics'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Relations
        ];
    }
}
```

#### Survey Model
```php
<?php

namespace Modules\Quaeris\Models;

use Modules\Xot\Models\XotBaseModel;

class Survey extends XotBaseModel
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'expected_responses',
        'status',
        'tenant_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'expected_responses' => 'integer',
        'status' => 'string',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function getCompletionRateAttribute()
    {
        $expected = $this->expected_responses ?? 100;
        $actual = $this->responses()->count();
        return $expected > 0 ? min(100, ($actual / $expected) * 100) : 0;
    }
}
```

#### Question Resource
```php
<?php

namespace Modules\Quaeris\Filament\Resources;

use Filament\{Laravel\Commands\MakeResourceCommand};
use Filament\Resources\Resource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\Question;

class QuestionResource extends XotBaseResource
{
    protected static ?string $model = Question::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveyQuestions::route('/surveys/{survey}/questions'),
            'create' => Pages\CreateSurveyQuestion::route('/surveys/{survey}/questions/create'),
            'view' => Pages\ViewSurveyQuestion::route('/surveys/{survey}/questions/{record}'),
            'edit' => Pages\EditSurveyQuestion::route('/surveys/{survey}/questions/{record}/edit'),
            'answers' => Pages\ManageQuestionAnswers::route('/surveys/{survey}/questions/{record}/answers'),
        ];
    }
}
```

#### Question Model
```php
<?php

namespace Modules\Quaeris\Models;

use Modules\Xot\Models\XotBaseModel;

class Question extends XotBaseModel
{
    protected $fillable = [
        'survey_id',
        'question_text',
        'question_type',
        'sort_order',
        'required',
        'options',
    ];

    protected $casts = [
        'survey_id' => 'integer',
        'sort_order' => 'integer',
        'required' => 'boolean',
        'options' => 'array',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
```

#### ListSurveyQuestions Page
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;

class ListSurveyQuestions extends XotBaseListRecords
{
    protected static string $resource = \Modules\Quaeris\Filament\Resources\QuestionResource::class;

    public ?Survey $survey = null;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->url(fn () => \Modules\Quaeris\Filament\Resources\QuestionResource::getUrl('create', [
                    'survey' => $this->survey->id
                ])),
        ];
    }

    public function mount(int | string $survey): void
    {
        $this->survey = Survey::findOrFail($survey);
        $this->authorizeAccess();
        
        static::authorizeResourceAccess();
        
        if (static::hasPage('create') && (! static::getResource()::hasCreatePage() || ! $this->survey->can('create', static::getModel()))) {
            abort(403);
        }
    }

    protected function authorizeAccess(): void
    {
        if (! $this->survey->can('view', $this->survey)) {
            abort(403);
        }
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Question::query()->where('survey_id', $this->survey->id);
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('question_text')
                ->searchable()
                ->wrap()
                ->description(fn (Question $record): string => $record->question_type)
                ->limit(50),
            
            \Filament\Tables\Columns\BadgeColumn::make('question_type')
                ->colors([
                    'success' => 'Y',
                    'warning' => 'N',
                    'primary' => 'G',
                    'info' => 'L',
                    'danger' => '!',
                ]),
            
            \Filament\Tables\Columns\IconColumn::make('required')
                ->boolean(),
            
            \Filament\Tables\Columns\TextColumn::make('sort_order')
                ->numeric()
                ->sortable(),
            
            \Filament\Tables\Columns\TextColumn::make('responses_count')
                ->counts('responses')
                ->label('Responses')
                ->sortable(),
        ];
    }
}
```

#### CreateSurveyQuestion Page
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Modules\Xot\Filament\Pages\XotBaseCreateRecord;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;

class CreateSurveyQuestion extends XotBaseCreateRecord
{
    protected static string $resource = \Modules\Quaeris\Filament\Resources\QuestionResource::class;

    public Survey $survey;

    public function mount(): void
    {
        $this->survey = Survey::findOrFail(request()->route()->parameter('survey'));
        
        abort_unless($this->survey->can('update', $this->survey), 403);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('survey_id')
                    ->default(fn () => $this->survey->id),
                
                Forms\Components\Textarea::make('question_text')
                    ->required()
                    ->rows(3)
                    ->placeholder('Enter your question here...')
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('question_type')
                    ->options([
                        'Y' => 'Yes/No (Y)',
                        'N' => 'Number (N)',
                        'G' => 'Gender (G)',
                        'L' => 'List (Dropdown) (L)',
                        '!' => 'List with Comment (!)',
                        '1' => 'Array (Numbers) (1)',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        // Set default options based on question type
                        switch ($state) {
                            case 'Y':
                                $set('options', ['Y' => 'Yes', 'N' => 'No']);
                                break;
                            case 'G':
                                $set('options', ['M' => 'Male', 'F' => 'Female', 'O' => 'Other']);
                                break;
                        }
                    }),
                
                Forms\Components\KeyValue::make('options')
                    ->label('Question Options')
                    ->keyLabel('Option Value')
                    ->valueLabel('Option Label')
                    ->addable()
                    ->deletable()
                    ->visible(fn ($get) => in_array($get('question_type'), ['L', '!', '1', 'G', 'Y']))
                    ->helperText('Add options for dropdown or list questions'),
                
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    
                    Forms\Components\Toggle::make('required')
                        ->default(false),
                ]),
            ])
            ->model(Question::class);
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
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

## Case Study 2: Analytics Dashboard with Nested Data

### Problem Statement
Create an analytics dashboard that shows:
- Survey performance metrics
- Question-level analytics
- Response trend analysis
- Cross-survey comparisons

#### Survey Analytics Page
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Filament\Widgets\SurveyAnalyticsOverviewWidget;
use Modules\Quaeris\Filament\Widgets\SurveyResponseTrendsWidget;
use Modules\Quaeris\Filament\Widgets\QuestionPerformanceWidget;

class SurveyAnalytics extends XotBasePage
{
    protected static string $view = 'quaeris::pages.survey-analytics';

    public Survey $survey;

    public function mount(int $record): void
    {
        $this->survey = Survey::findOrFail($record);
        
        abort_unless($this->survey->can('view', $this->survey), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Export Analytics')
                ->action('exportAnalytics')
                ->color('success'),
        ];
    }

    public function exportAnalytics()
    {
        // Export logic here
        $this->notify('success', 'Analytics exported successfully!');
    }

    public function getWidgets(): array
    {
        return [
            SurveyAnalyticsOverviewWidget::class,
            SurveyResponseTrendsWidget::class,
            QuestionPerformanceWidget::class,
            // Add more analytics widgets
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

    protected function getHeading(): string
    {
        return "Analytics: {$this->survey->title}";
    }
}
```

#### Survey Analytics Overview Widget
```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Modules\Quaeris\Models\Survey;

class SurveyAnalyticsOverviewWidget extends XotBaseStatsOverviewWidget
{
    public Survey $survey;

    public function mount(int $surveyId): void
    {
        $this->survey = Survey::findOrFail($surveyId);
    }

    protected function getStats(): array
    {
        $responsesCount = $this->survey->responses()->count();
        $questionsCount = $this->survey->questions()->count();
        $completionRate = $this->survey->completion_rate;

        return [
            Stat::make('Total Responses', number_format($responsesCount))
                ->description('Total survey responses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Questions', $questionsCount)
                ->description('Survey questions')
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('info'),
            
            Stat::make('Completion Rate', number_format($completionRate, 1) . '%')
                ->description('Survey completion')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($completionRate >= 80 ? 'success' : ($completionRate >= 50 ? 'warning' : 'danger')),
        ];
    }
}
```

## Case Study 3: Multi-Level Nesting with Complex Permissions

### Problem Statement
Implement a complex nesting scenario with:
- Survey → Question → Answer → Response
- Role-based access control at each level
- Audit trail for all operations
- Performance optimization for large datasets

#### Advanced Policy Implementation
```php
<?php

namespace Modules\Quaeris\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Quaeris\Models\Survey;

class SurveyPolicy
{
    use HandlesAuthorization;

    public function viewQuestions(User $user, Survey $survey): bool
    {
        // Check if user owns the survey or has specific permission
        if ($user->id === $survey->user_id) {
            return true;
        }
        
        // Check if user has survey management permissions
        return $user->can('view survey questions') || 
               $user->hasRole('admin') ||
               $user->hasRole('survey-manager');
    }

    public function createQuestion(User $user, Survey $survey): bool
    {
        if ($user->id === $survey->user_id) {
            return true;
        }
        
        return $user->can('create survey questions') || 
               $user->hasRole('admin');
    }

    public function viewQuestionResponses(User $user, Survey $survey): bool
    {
        if ($user->id === $survey->user_id) {
            return true;
        }
        
        return $user->can('view survey responses') || 
               $user->hasRole('admin') ||
               $user->hasRole('data-analyst');
    }
}
```

#### Question Resource with Advanced Nesting
```php
<?php

namespace Modules\Quaeris\Filament\Resources;

use Filament\{Laravel\Commands\MakeResourceCommand};
use Filament\Resources\Resource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\Question;

class QuestionResource extends XotBaseResource
{
    protected static ?string $model = Question::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveyQuestions::route('/surveys/{survey}/questions'),
            'create' => Pages\CreateSurveyQuestion::route('/surveys/{survey}/questions/create'),
            'view' => Pages\ViewSurveyQuestion::route('/surveys/{survey}/questions/{record}'),
            'edit' => Pages\EditSurveyQuestion::route('/surveys/{survey}/questions/{record}/edit'),
            'responses' => Pages\ManageQuestionResponses::route('/surveys/{survey}/questions/{record}/responses'),
            'analysis' => Pages\QuestionAnalysis::route('/surveys/{survey}/questions/{record}/analysis'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Relations
        ];
    }
}
```

#### Question Response Management
```php
<?php

namespace Modules\Quaeris\Filament\Resources\QuestionResource\Pages;

use Filament\Resources\Pages\ManageRelatedRecords;
use Modules\Xot\Filament\Pages\XotBaseManageRelatedRecords;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Models\Response;

class ManageQuestionResponses extends XotBaseManageRelatedRecords
{
    protected static string $resource = \Modules\Quaeris\Filament\Resources\ResponseResource::class;
    protected static string $relationship = 'responses';
    protected static ?string $navigationLabel = 'Responses';
    protected static ?string $breadcrumb = 'Responses';

    public function getTitle(): string
    {
        $question = $this->getOwnerRecord();
        return "Responses for: {$question->question_text}";
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->getOwnerRecord()->responses()->with('user');
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('response_value')
                ->label('Response')
                ->searchable(),
            
            \Filament\Tables\Columns\TextColumn::make('user.name')
                ->label('Respondent')
                ->searchable()
                ->sortable(),
            
            \Filament\Tables\Columns\TextColumn::make('created_at')
                ->label('Date')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->action('exportResponses')
                ->color('success'),
        ];
    }

    public function exportResponses()
    {
        $question = $this->getOwnerRecord();
        $responses = $question->responses;
        
        // Export logic
        $this->notify('success', 'Responses exported successfully!');
    }
}
```

## Case Study 4: Performance Optimization for Large Datasets

### Problem Statement
Handle large datasets (10,000+ records) efficiently with:
- Lazy loading
- Caching strategies
- Query optimization
- Memory management

#### Optimized Question Resource with Caching
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Illuminate\Support\Facades\Cache;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;

class ListSurveyQuestions extends XotBaseListRecords
{
    protected static string $resource = \Modules\Quaeris\Filament\Resources\QuestionResource::class;

    public ?Survey $survey = null;

    public function mount(int | string $survey): void
    {
        $this->survey = Survey::findOrFail($survey);
        $this->authorizeAccess();
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $cacheKey = "survey_questions_{$this->survey->id}_" . request()->get('page', 1);
        
        return Cache::remember($cacheKey, 300, function() {
            return Question::query()
                ->where('survey_id', $this->survey->id)
                ->with(['responses' => function($query) {
                    $query->limit(10); // Limit to prevent memory issues
                }])
                ->select(['id', 'survey_id', 'question_text', 'question_type', 'sort_order', 'required', 'created_at']);
        });
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('question_text')
                ->searchable()
                ->limit(50)
                ->tooltip(function (Question $record): ?string {
                    return strlen($record->question_text) > 50 ? $record->question_text : null;
                }),
            
            \Filament\Tables\Columns\BadgeColumn::make('question_type')
                ->colors([
                    'success' => 'Y',
                    'warning' => 'N',
                    'primary' => 'G',
                    'info' => 'L',
                    'danger' => '!',
                ]),
            
            \Filament\Tables\Columns\TextColumn::make('responses_count')
                ->counts('responses')
                ->label('Responses')
                ->sortable(),
            
            \Filament\Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            \Filament\Tables\Actions\ViewAction::make(),
            \Filament\Tables\Actions\EditAction::make(),
        ];
    }
}
```

## Migration and Setup Examples

### Database Migrations for Nested Resources
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNestedSurveyTables extends Migration
{
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('expected_responses')->default(100);
            $table->string('status')->default('draft'); // draft, active, closed
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->text('question_text');
            $table->string('question_type', 10); // Y, N, G, L, !, 1, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('required')->default(false);
            $table->json('options')->nullable();
            $table->timestamps();
            
            $table->index(['survey_id', 'sort_order']);
            $table->index(['survey_id', 'question_type']);
        });

        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('response_value');
            $table->ipAddress('ip_address')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['survey_id', 'created_at']);
            $table->index(['question_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });

        // Add foreign key constraints
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade');
        });

        Schema::table('responses', function (Blueprint $table) {
            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade');
            
            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('surveys');
    }
}
```

## Testing Examples

### Comprehensive Tests for Nested Resources
```php
<?php

namespace Modules\Quaeris\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\User;
use Modules\Quaeris\Models\Survey;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Models\Response;

class NestedResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_survey_questions_are_accessible_via_nested_routes(): void
    {
        $user = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $user->id]);
        $questions = Question::factory()->count(3)->create(['survey_id' => $survey->id]);

        $response = $this->actingAs($user)
            ->get(route('filament.quaeris.resources.surveys.pages.list-survey-questions', [
                'survey' => $survey->id
            ]));

        $response->assertSuccessful();
        foreach ($questions as $question) {
            $response->assertSee($question->question_text);
        }
    }

    public function test_question_responses_are_accessible_via_deep_nested_routes(): void
    {
        $user = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $user->id]);
        $question = Question::factory()->create(['survey_id' => $survey->id]);
        $responses = Response::factory()->count(5)->create([
            'survey_id' => $survey->id,
            'question_id' => $question->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('filament.quaeris.resources.questions.pages.manage-question-responses', [
                'survey' => $survey->id,
                'record' => $question->id
            ]));

        $response->assertSuccessful();
        foreach ($responses as $responseRecord) {
            $response->assertSee($responseRecord->response_value);
        }
    }

    public function test_nested_resource_authorization_works(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $otherUser->id]);
        $question = Question::factory()->create(['survey_id' => $survey->id]);

        $response = $this->actingAs($user)
            ->get(route('filament.quaeris.resources.surveys.pages.list-survey-questions', [
                'survey' => $survey->id
            ]));

        $response->assertForbidden();
    }

    public function test_nested_resource_creation_works(): void
    {
        $user = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->post(route('filament.quaeris.resources.questions.pages.create-survey-question', [
                'survey' => $survey->id
            ]), [
                'question_text' => 'Test Question',
                'question_type' => 'Y',
                'required' => true,
            ]);

        $this->assertDatabaseHas('questions', [
            'survey_id' => $survey->id,
            'question_text' => 'Test Question',
            'question_type' => 'Y',
        ]);
    }
}
```

## Best Practices Summary

1. **Always maintain proper authorization** at each level of nesting
2. **Use consistent URL patterns** across all nested resources
3. **Implement proper caching** for performance with large datasets
4. **Validate parent-child relationships** before operations
5. **Provide clear breadcrumbs** to indicate nesting level
6. **Optimize queries** with eager loading and indexing
7. **Handle errors gracefully** in nested contexts
8. **Maintain data integrity** with proper foreign key constraints

These practical examples demonstrate how to implement robust, scalable nested resources in Filament 5.x for the Quaeris platform while maintaining security, performance, and user experience.