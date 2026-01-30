# Filament 5.x Resource Nesting - Advanced Features and Implementation Patterns

## Overview
This document details advanced features and implementation patterns for resource nesting in Filament 5.x, specifically tailored for the Quaeris survey management platform. It covers complex nesting scenarios, performance optimizations, and integration with the existing XotBase architecture.

## Advanced Nesting Techniques

### Deep Nesting (Three or More Levels)
Filament 5.x supports deep nesting of resources, allowing for complex data hierarchies like Survey → Question → Answer → Response. Here's how to implement this:

```php
<?php

namespace Modules\Quaeris\Filament\Resources\AnswerResource\Pages;

use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Modules\Quaeris\Models\Response;
use Modules\Quaeris\Filament\Resources\ResponseResource;

class ListQuestionAnswerResponses extends XotBaseListRecords
{
    protected static string $resource = ResponseResource::class;

    public ?\Modules\Quaeris\Models\Survey $survey = null;
    public ?\Modules\Quaeris\Models\Question $question = null;
    public ?\Modules\Quaeris\Models\Answer $answer = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => ResponseResource::getUrl('create', [
                    'survey' => $this->survey->id,
                    'question' => $this->question->id,
                    'answer' => $this->answer->id
                ])),
        ];
    }

    public function mount(int | string $survey, int | string $question, int | string $answer): void
    {
        $this->survey = \Modules\Quaeris\Models\Survey::findOrFail($survey);
        $this->question = \Modules\Quaeris\Models\Question::findOrFail($question);
        $this->answer = \Modules\Quaeris\Models\Answer::findOrFail($answer);
        
        // Verify the relationship chain
        if ($this->question->survey_id !== $this->survey->id || 
            $this->answer->question_id !== $this->question->id) {
            abort(404);
        }
        
        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        // Ensure user can access all parent resources
        if (!$this->survey->can('view', $this->survey) ||
            !$this->question->can('view', $this->question) ||
            !$this->answer->can('view', $this->answer)) {
            abort(403);
        }
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Response::query()
            ->where('survey_id', $this->survey->id)
            ->where('question_id', $this->question->id)
            ->where('answer_id', $this->answer->id);
    }
}
```

### Conditional Nesting Based on Data
Sometimes you might want to conditionally nest resources based on the data itself:

```php
class SurveyResource extends XotBaseResource
{
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            // Conditional nesting based on survey type
            'questions' => function($record) {
                if ($record->type === 'structured') {
                    return Pages\ManageSurveyQuestions::route('/{record}/questions');
                }
                return null; // No questions management for this type
            },
            'responses' => Pages\ManageSurveyResponses::route('/{record}/responses'),
        ];
    }
}
```

## Performance Optimization Strategies

### Eager Loading for Nested Resources
When dealing with nested resources, eager loading becomes crucial for performance:

```php
class ListSurveyQuestions extends XotBaseListRecords
{
    // ... other methods

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Question::query()
            ->where('survey_id', $this->survey->id)
            ->with([
                'answers', // Load answers for each question
                'user',    // Load creator info
                'chart'    // Load associated chart if exists
            ]);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('question_text')
                ->searchable(),
            Tables\Columns\TextColumn::make('question_type')
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'Y' => 'success',
                    'N' => 'warning', 
                    'G' => 'primary',
                    default => 'secondary',
                }),
            Tables\Columns\TextColumn::make('answers_count')
                ->counts('answers')
                ->label('Answers'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### Query Caching for Nested Data
Implement caching for expensive nested queries:

```php
class SurveyNestingService
{
    public function getCachedSurveyQuestions(int $surveyId, array $with = []): Collection
    {
        $cacheKey = "survey_questions_{$surveyId}_" . md5(serialize($with));
        
        return Cache::remember($cacheKey, 300, function() use ($surveyId, $with) {
            return Question::where('survey_id', $surveyId)
                ->with($with)
                ->get();
        });
    }
    
    public function invalidateSurveyQuestionsCache(int $surveyId): void
    {
        $keys = Cache::get("survey_questions_keys", []);
        foreach ($keys as $key) {
            if (strpos($key, "survey_questions_{$surveyId}_") === 0) {
                Cache::forget($key);
            }
        }
    }
}
```

## Integration with XotBase Architecture

### Extended XotBaseResource for Nesting
Create specialized base classes to handle nesting patterns:

```php
abstract class XotBaseNestedResource extends XotBaseResource
{
    protected static ?string $parentResource = null;

    public static function getParentResource(): ?string
    {
        return static::$parentResource;
    }

    public static function getRouteBaseParameterName(): string
    {
        $resourceName = class_basename(static::class);
        $resourceName = str_replace(['Resource', 'Page', 'Widget'], '', $resourceName);
        $resourceName = Str::snake($resourceName);
        
        return Str::singular($resourceName);
    }

    protected static function applyGlobalScopes(Builder $query): Builder
    {
        $query = parent::applyGlobalScopes($query);
        
        // Apply tenant scope if available
        if (app()->bound('tenant.manager')) {
            $tenantId = app('tenant.manager')->getCurrentTenantId();
            if ($tenantId) {
                $query->where('tenant_id', $tenantId);
            }
        }
        
        return $query;
    }
}
```

### XotBasePage for Nested Pages
Extend base page classes to handle nested contexts:

```php
abstract class XotBaseNestedPage extends XotBasePage
{
    protected ?Model $parentRecord = null;
    
    public function getParentRecord(): Model
    {
        return $this->parentRecord;
    }
    
    protected function resolveParentRecord(string $parameterName): Model
    {
        $parentResource = static::getParentResource();
        $model = $parentResource::getModel();
        $record = $model::find(request()->route()->parameter($parameterName));
        
        if (!$record) {
            abort(404);
        }
        
        return $record;
    }
    
    protected function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();
        
        if ($this->parentRecord) {
            $parentResource = static::getParentResource();
            $breadcrumbs[$parentResource::getUrl('view', ['record' => $this->parentRecord->getRouteKey()])] = $this->parentRecord->title ?? $this->parentRecord->id;
        }
        
        return $breadcrumbs;
    }
}
```

## Complex Nesting Scenarios

### Many-to-Many Relations in Nested Contexts
Handling many-to-many relationships within nested resources:

```php
// Survey has many Tags through survey_tag pivot
class ManageSurveyTags extends XotBaseManageRelatedRecords
{
    protected static string $resource = TagResource::class;
    protected static string $relationship = 'tags';
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        static::authorizeResourceAccess();
        
        abort_unless(
            static::getResource()::canView($this->getOwnerRecord()),
            403,
        );
    }

    protected function getManageButtonLabel(): string
    {
        return 'Manage Tags';
    }

    protected function getTitle(): string
    {
        return "Tags for {$this->getOwnerRecord()->title}";
    }
}
```

### Polymorphic Relations in Nested Contexts
When dealing with polymorphic relationships in nested resources:

```php
class ListSurveyAttachments extends XotBaseListRecords
{
    protected static string $resource = AttachmentResource::class;

    public ?\Modules\Quaeris\Models\Survey $survey = null;

    public function mount(int | string $survey): void
    {
        $this->survey = \Modules\Quaeris\Models\Survey::findOrFail($survey);
        $this->authorizeAccess();
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return \Modules\Quaeris\Models\Attachment::query()
            ->where('attachable_type', \Modules\Quaeris\Models\Survey::class)
            ->where('attachable_id', $this->survey->id);
    }
}
```

## Authorization and Policies for Nested Resources

### Nested Policy Implementation
Implement comprehensive policies that handle nested authorization:

```php
class SurveyPolicy
{
    use HandlesAuthorization;

    public function viewQuestions(User $user, Survey $survey): bool
    {
        // Check if user can view the survey first
        if (!$user->can('view', $survey)) {
            return false;
        }
        
        // Additional checks specific to viewing questions
        return $user->hasPermissionTo('view survey questions') || 
               $user->id === $survey->user_id;
    }
    
    public function createQuestion(User $user, Survey $survey): bool
    {
        if (!$user->can('update', $survey)) {
            return false;
        }
        
        return $user->hasPermissionTo('create survey questions') || 
               $user->id === $survey->user_id;
    }
    
    public function manageQuestionAnswers(User $user, Survey $survey): bool
    {
        if (!$user->can('view', $survey)) {
            return false;
        }
        
        return $user->hasPermissionTo('manage survey answers');
    }
}

class QuestionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Question $question): bool
    {
        // Check parent survey access first
        if (!$user->can('view', $question->survey)) {
            return false;
        }
        
        // Then check question-specific permissions
        return $user->hasPermissionTo('view questions') || 
               $user->id === $question->survey->user_id;
    }
    
    public function update(User $user, Question $question): bool
    {
        if (!$user->can('update', $question->survey)) {
            return false;
        }
        
        return $user->hasPermissionTo('edit questions');
    }
}
```

## Advanced Table Features in Nested Contexts

### Custom Table Actions for Nested Resources
```php
protected function getTableActions(): array
{
    return [
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('manage_answers')
            ->url(fn (Question $record) => 
                AnswerResource::getUrl('index', [
                    'survey' => $this->survey->id,
                    'question' => $record->id
                ])
            )
            ->icon('heroicon-o-list-bullet')
            ->color('info')
            ->visible(fn (Question $record) => $record->question_type !== 'Y'), // Only for non-yes/no questions
    ];
}
```

### Bulk Actions in Nested Contexts
```php
protected function getTableBulkActions(): array
{
    return [
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make()
                ->authorize('deleteAny'),
            Tables\Actions\BulkAction::make('export_responses')
                ->action(function (Collection $records) {
                    // Export responses for selected questions
                    $surveyId = $this->survey->id;
                    $questionIds = $records->pluck('id');
                    
                    dispatch(new ExportSurveyQuestionResponsesJob($surveyId, $questionIds));
                })
                ->color('warning')
                ->icon('heroicon-o-arrow-down-tray'),
        ]),
    ];
}
```

## Testing Nested Resources

### Unit Tests for Nested Resources
```php
class SurveyQuestionNestedResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_survey_questions(): void
    {
        $user = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $user->id]);
        $questions = Question::factory()->count(3)->create(['survey_id' => $survey->id]);
        
        $response = $this->actingAs($user)
            ->get(SurveyResource::getUrl('questions', ['record' => $survey->id]));
            
        $response->assertSuccessful();
        $response->assertSee($questions->first()->question_text);
    }
    
    public function test_nested_authorization_works(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $survey = Survey::factory()->create(['user_id' => $otherUser->id]);
        $question = Question::factory()->create(['survey_id' => $survey->id]);
        
        $response = $this->actingAs($user)
            ->get(SurveyResource::getUrl('questions', ['record' => $survey->id]));
            
        $response->assertForbidden();
    }
}
```

## Migration Patterns for Nested Resources

### Adding Foreign Keys for Nesting
When implementing nesting, you may need to add foreign keys to existing tables:

```php
class AddForeignKeysForNesting extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'survey_id')) {
                $table->foreignId('survey_id')
                      ->constrained('surveys')
                      ->onDelete('cascade')
                      ->after('id');
            }
            
            if (!Schema::hasColumn('questions', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('survey_id');
            }
        });
        
        Schema::table('answers', function (Blueprint $table) {
            if (!Schema::hasColumn('answers', 'question_id')) {
                $table->foreignId('question_id')
                      ->constrained('questions')
                      ->onDelete('cascade')
                      ->after('id');
            }
        });
        
        // Add indexes for performance
        Schema::table('questions', function (Blueprint $table) {
            $table->index(['survey_id', 'sort_order']);
        });
        
        Schema::table('answers', function (Blueprint $table) {
            $table->index(['question_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropIndex(['question_id', 'created_at']);
            $table->dropColumn('question_id');
        });
        
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->dropIndex(['survey_id', 'sort_order']);
            $table->dropColumn(['survey_id', 'sort_order']);
        });
    }
}
```

## Performance Monitoring and Optimization

### Query Monitoring for Nested Resources
```php
class NestedResourceQueryMonitor
{
    public static function monitorQueryPerformance(Closure $queryFunction, string $context = '')
    {
        $start = microtime(true);
        $startMemory = memory_get_usage(true);
        
        $result = $queryFunction();
        
        $end = microtime(true);
        $endMemory = memory_get_usage(true);
        
        $duration = $end - $start;
        $memoryUsed = $endMemory - $startMemory;
        
        // Log slow queries
        if ($duration > 1.0) { // More than 1 second
            Log::warning("Slow nested query detected", [
                'context' => $context,
                'duration' => $duration,
                'memory_used' => $memoryUsed,
                'result_count' => is_countable($result) ? count($result) : 'N/A'
            ]);
        }
        
        return $result;
    }
}
```

## Common Pitfalls and Solutions

### Pitfall 1: Route Parameter Mismatch
**Problem**: Incorrect route parameter names causing 404 errors.
**Solution**: Use consistent parameter naming across all nested resources.

### Pitfall 2: Authorization Bypass
**Problem**: Missing parent authorization checks allowing access to child resources without proper parent access.
**Solution**: Always verify parent resource access before granting child resource access.

### Pitfall 3: Performance Issues
**Problem**: N+1 queries when loading nested resources.
**Solution**: Use eager loading and proper indexing.

### Pitfall 4: URL Complexity
**Problem**: Overly complex URLs that are hard to maintain.
**Solution**: Use clear, consistent URL patterns and consider URL shortening for very deep nesting.

This advanced guide provides comprehensive coverage of resource nesting in Filament 5.x, addressing the complex requirements of the Quaeris survey management platform while maintaining performance and security.