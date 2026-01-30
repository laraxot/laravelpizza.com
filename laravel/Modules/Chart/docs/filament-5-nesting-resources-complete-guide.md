# Filament 5.x Resource Nesting - Complete Guide for Quaeris Project

## Overview
Filament 5.x introduces powerful resource nesting capabilities that allow for hierarchical organization of related models. This guide covers the complete implementation pattern for the Quaeris survey management platform, focusing on how to properly nest resources like surveys, questions, and responses.

## Understanding Resource Nesting

### Core Concepts
Resource nesting in Filament 5.x allows you to create hierarchical relationships between related models. This is particularly useful for:
- Surveys containing multiple questions
- Questions containing multiple answers
- Responses grouped by survey
- Charts organized by survey and question

### Key Benefits for Quaeris
- **Organized UI**: Related data is grouped logically in the admin panel
- **Contextual Actions**: Operations are performed within the proper parent context
- **Clean URLs**: Hierarchical URL structure (e.g., `/surveys/1/questions/2/responses`)
- **Access Control**: Granular permissions based on parent-child relationships

## Basic Implementation Pattern

### Parent Resource Example (SurveyResource)
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            // Child resources can be accessed through the parent
            'questions' => Pages\ManageSurveyQuestions::route('/{record}/questions'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Relations can include nested resources
        ];
    }
}
```

### Child Resource Example (QuestionResource)
```php
<?php

namespace Modules\Quaeris\Filament\Resources;

use Filament\{Laravel\Commands\MakeResourceCommand};
use Filament\Resources\Resource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Filament\Resources\SurveyResource;

class QuestionResource extends XotBaseResource
{
    protected static ?string $model = Question::class;

    // Define the parent resource relationship
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveyQuestions::route('/surveys/{survey}/questions'),
            'create' => Pages\CreateSurveyQuestion::route('/surveys/{survey}/questions/create'),
            'view' => Pages\ViewSurveyQuestion::route('/surveys/{survey}/questions/{record}'),
            'edit' => Pages\EditSurveyQuestion::route('/surveys/{survey}/questions/{record}/edit'),
            // Further nesting possible for answers
            'answers' => Pages\ManageQuestionAnswers::route('/surveys/{survey}/questions/{record}/answers'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Relations specific to questions
        ];
    }

    // Define parent resource for nesting
    public static function getBreadcrumb(): string
    {
        return 'Questions';
    }

    public static function getNavigationLabel(): string
    {
        return 'Questions';
    }
}
```

### Nested Model Relationships
```php
// Survey Model
class Survey extends BaseModel
{
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

// Question Model
class Question extends BaseModel
{
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
```

## Advanced Nesting Patterns

### Multi-Level Nesting (Survey → Question → Answer)
```php
<?php

namespace Modules\Quaeris\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\Answer;
use Modules\Quaeris\Filament\Resources\QuestionResource;

class AnswerResource extends XotBaseResource
{
    protected static ?string $model = Answer::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionAnswers::route('/surveys/{survey}/questions/{question}/answers'),
            'create' => Pages\CreateQuestionAnswer::route('/surveys/{survey}/questions/{question}/answers/create'),
            'view' => Pages\ViewQuestionAnswer::route('/surveys/{survey}/questions/{question}/answers/{record}'),
            'edit' => Pages\EditQuestionAnswer::route('/surveys/{survey}/questions/{question}/answers/{record}/edit'),
        ];
    }

    public static function getBreadcrumb(): string
    {
        return 'Answers';
    }
}
```

### Controller Implementation for Nested Resources
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Modules\Quaeris\Models\Question;
use Modules\Quaeris\Filament\Resources\QuestionResource;

class ListSurveyQuestions extends XotBaseListRecords
{
    protected static string $resource = QuestionResource::class;

    public ?\Modules\Quaeris\Models\Survey $survey = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => QuestionResource::getUrl('create', ['survey' => $this->survey])),
        ];
    }

    protected function getMountedActionFormModel(): string
    {
        return static::$model ?? (static::getResource()::getModel());
    }

    public function mount(int | string $survey): void
    {
        $this->survey = \Modules\Quaeris\Models\Survey::findOrFail($survey);
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
}
```

## Complete Implementation Example

### SurveyResource with Nested Management
```php
<?php

namespace Modules\Quaeris\Filament\Resources\SurveyResource\Pages;

use Modules\Xot\Filament\Pages\XotBaseManageRelatedRecords;
use Modules\Quaeris\Filament\Resources\QuestionResource;

class ManageSurveyQuestions extends XotBaseManageRelatedRecords
{
    protected static string $resource = QuestionResource::class;

    protected static string $relationship = 'questions';

    protected static ?string $navigationLabel = 'Questions';

    protected static ?string $breadcrumb = 'Questions';

    public function getTitle(): string
    {
        return 'Manage Questions';
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->getOwnerRecord()->questions()->with('answers');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(QuestionResource::getUrl('create', [
                    'survey' => $this->getOwnerRecord()->id
                ])),
        ];
    }
}
```

## URL Route Handling

### Route Parameters in Nested Resources
For nested resources, Filament 5.x expects specific URL parameters to be passed. The convention is `{parent_resource}/{parent_id}/{child_resource}/{child_id?}`.

```php
// Example route patterns:
// /surveys/1/edit
// /surveys/1/questions
// /surveys/1/questions/create
// /surveys/1/questions/5/edit
// /surveys/1/questions/5/answers

// Accessing parent ID in child resource:
public function mount(int | string $survey, int | string $record = null): void
{
    $this->survey = \Modules\Quaeris\Models\Survey::findOrFail($survey);
    if ($record) {
        $this->record = $this->resolveRecord($record);
    }
    // Ensure proper authorization based on parent context
    // Additional logic here
}
```

## Authorization in Nested Contexts

### Policy Implementation for Nested Resources
```php
// SurveyPolicy
class SurveyPolicy
{
    public function viewQuestions(User $user, Survey $survey): bool
    {
        // User can view questions if they can view the parent survey
        return $user->can('view', $survey);
    }

    public function createQuestion(User $user, Survey $survey): bool
    {
        // User can create questions if they can update the parent survey
        return $user->can('update', $survey);
    }
}

// QuestionPolicy
class QuestionPolicy
{
    public function view(User $user, Question $question): bool
    {
        // User can view question if they can view the parent survey
        return $user->can('view', $question->survey);
    }

    public function update(User $user, Question $question): bool
    {
        return $user->can('update', $question->survey);
    }
}
```

## Integration with XotBase Architecture

### XotBaseResource Extension
When implementing nested resources, ensure they extend from XotBaseResource to maintain consistency with the Quaeris architecture:

```php
abstract class XotBaseResource extends Resource
{
    // Base functionality for all resources
    
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Apply tenant scope if applicable
        if (class_uses_recursive(static::getModel()) && in_array(\App\Traits\TenantScoped::class, class_uses_recursive(static::getModel()))) {
            $query->where('tenant_id', get_tenant_id());
        }
        
        return $query;
    }
}
```

## Best Practices for Resource Nesting

### 1. URL Parameter Consistency
Always use consistent parameter names across nested resources:
- Parent: `{survey}` for surveys
- Child: `{question}` for questions within survey context
- Grandchild: `{answer}` for answers within question context

### 2. Authorization Chain
Implement authorization that flows from parent to child:
- If user cannot access parent resource, they cannot access children
- Check permissions at each level of nesting

### 3. Model Relationships
Ensure proper Eloquent relationships are defined:
- BelongsTo relationships for children
- HasMany/HasManyThrough for parents
- Proper foreign key constraints

### 4. Navigation Structure
Maintain clear navigation hierarchy:
- Parent resource shows count of children
- Child resource breadcrumbs include parent context
- Clear visual indication of nesting level

### 5. Performance Optimization
- Use eager loading for nested relationships
- Implement proper indexing for foreign keys
- Consider pagination for large nested datasets

## Common Implementation Patterns

### Pattern 1: Survey → Questions → Answers
```php
// In SurveyResource
public static function getRelations(): array
{
    return [
        // Direct relations
    ];
}

public static function getPages(): array
{
    return [
        'index' => Pages\ListSurveys::route('/'),
        'create' => Pages\CreateSurvey::route('/create'),
        'view' => Pages\ViewSurvey::route('/{record}'),
        'edit' => Pages\EditSurvey::route('/{record}/edit'),
        'questions' => Pages\ManageSurveyQuestions::route('/{record}/questions'),
    ];
}
```

### Pattern 2: Question Charts with Nested Data
```php
// In QuestionChartResource
public static function getPages(): array
{
    return [
        'index' => Pages\ListSurveyQuestionCharts::route('/surveys/{survey}/questions/{question}/charts'),
        'create' => Pages\CreateQuestionChart::route('/surveys/{survey}/questions/{question}/charts/create'),
        'view' => Pages\ViewQuestionChart::route('/surveys/{survey}/questions/{question}/charts/{record}'),
        'edit' => Pages\EditQuestionChart::route('/surveys/{survey}/questions/{question}/charts/{record}/edit'),
    ];
}
```

## Error Handling and Validation

### Nested Resource Validation
```php
protected function handleRecordCreation(array $data): Model
{
    // Ensure parent relationship exists
    $parent = static::getParentModel()::find($this->getParentRecordId());
    
    if (!$parent) {
        throw new \Exception('Parent record not found');
    }

    // Validate parent-specific constraints
    if (!$parent->canAcceptChild()) {
        throw new \Exception('Parent cannot accept new child records');
    }

    return static::getModel()::create($data);
}
```

## Migration Considerations

When implementing nested resources, ensure proper database structure:

```php
Schema::create('questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
    $table->string('question_text');
    $table->string('question_type');
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

The foreign key relationship is crucial for proper nesting functionality.

## Summary

Resource nesting in Filament 5.x provides a powerful way to organize related data in the Quaeris platform. By properly implementing nested resources for surveys, questions, answers, and charts, we can create a more intuitive and organized admin experience while maintaining proper data relationships and authorization controls.