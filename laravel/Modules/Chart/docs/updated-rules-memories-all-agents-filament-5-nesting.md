# Updated Rules and Memories for All Agents - Filament 5.x Resource Nesting

## Overview
This document contains updated rules and memories for all agents regarding Filament 5.x resource nesting implementation in the Quaeris platform. These updates reflect the new capabilities and best practices for nested resource functionality.

## Core Architecture Rules

### 1. XotBase Resource Extension
**MANDATORY**: All Filament resources must extend `Modules\Xot\Filament\Resources\XotBaseResource`
- Never extend `Filament\Resources\Resource` directly
- XotBaseResource provides essential functionality for nested resources
- Maintains consistency across the Quaeris platform

```php
// Correct implementation
class SurveyResource extends XotBaseResource
{
    protected static ?string $model = Survey::class;
    // ... rest of implementation
}
```

### 2. Nested Resource URL Patterns
**MANDATORY**: Use consistent URL patterns for nested resources
- Parent: `{parent_resource}/{parent_id}/child_resources`
- Child: `{parent_resource}/{parent_id}/child_resources/{child_id?}`
- Always use singular form for parent parameter names

```php
// Example patterns
'surveys/{survey}/questions'           // List questions for specific survey
'surveys/{survey}/questions/create'    // Create question for specific survey
'surveys/{survey}/questions/{record}'  // View specific question
```

### 3. Authorization Chain Implementation
**MANDATORY**: Implement authorization checks at every nesting level
- Verify parent resource access before child resource access
- Use policies to manage complex permission logic
- Never bypass parent authorization checks

```php
public function mount(int | string $survey): void
{
    $this->survey = Survey::findOrFail($survey);
    
    // Critical: Check parent authorization first
    abort_unless($this->survey->can('view', $this->survey), 403);
    
    // Then check specific nested permission
    abort_unless(auth()->user()->can('viewQuestions', $this->survey), 403);
}
```

## Implementation Guidelines

### 4. Model Relationship Requirements
**MANDATORY**: Proper Eloquent relationships must be defined for nesting
- BelongsTo relationships for children to parents
- HasMany/HasManyThrough for parents to children
- Foreign key constraints with appropriate cascade options

```php
// Survey Model
public function questions()
{
    return $this->hasMany(Question::class);
}

// Question Model  
public function survey()
{
    return $this->belongsTo(Survey::class);
}
```

### 5. Performance Optimization Standards
**MANDATORY**: Implement performance optimizations for nested resources
- Use eager loading to prevent N+1 queries
- Implement proper indexing on foreign key columns
- Cache expensive nested queries when appropriate
- Limit related data in select statements

```php
protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
{
    return Question::query()
        ->where('survey_id', $this->survey->id)
        ->with(['responses:id,question_id,response_value', 'user:id,name'])
        ->select(['id', 'survey_id', 'question_text', 'question_type', 'sort_order', 'created_at']);
}
```

### 6. Widget Integration Standards
**MANDATORY**: Context-aware widget implementation for nested resources
- Widgets must accept parent resource IDs in mount method
- Verify parent resource access within widgets
- Implement proper event communication for nested contexts

```php
class SurveyQuestionStatsWidget extends XotBaseWidget
{
    public Survey $survey;
    public ?Question $question = null;

    public function mount(int $surveyId, ?int $questionId = null): void
    {
        $this->survey = Survey::findOrFail($surveyId);
        
        if ($questionId) {
            // Ensure question belongs to survey
            $this->question = Question::where('survey_id', $surveyId)
                                    ->findOrFail($questionId);
        }
    }
}
```

## Security Requirements

### 7. Data Integrity Protection
**MANDATORY**: Implement robust data integrity measures
- Foreign key constraints with appropriate cascade options
- Validation of parent-child relationships before operations
- Soft deletes where data history is important
- Referential integrity checks across all nesting levels

### 8. Input Validation Standards
**MANDATORY**: Comprehensive input validation for nested operations
- Validate parent resource existence and access
- Validate child resource data within parent context
- Implement CSRF protection for all nested forms
- Sanitize all input data before processing

## Testing Requirements

### 9. Comprehensive Test Coverage
**MANDATORY**: Complete test suite for nested resource functionality
- Test authorization at each nesting level
- Verify parent-child relationship integrity
- Validate form handling in nested contexts
- Test widget functionality within nested resources
- Performance testing under load conditions

```php
public function test_nested_resource_authorization(): void
{
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $survey = Survey::factory()->for($otherUser)->create();

    $response = $this->actingAs($user)
        ->get(SurveyResource::getUrl('questions', ['record' => $survey->id]));
        
    $response->assertForbidden();
}
```

### 10. Migration and Schema Testing
**MANDATORY**: Test all database schema changes
- Foreign key constraint validation
- Data migration integrity
- Performance impact assessment
- Rollback capability verification

## Best Practices

### 11. URL Management
**RECOMMENDED**: Keep URLs manageable and meaningful
- Avoid excessive nesting levels (>3 levels)
- Use query parameters for optional filters
- Implement proper breadcrumb navigation
- Maintain SEO-friendly patterns

### 12. Error Handling
**RECOMMENDED**: Implement graceful error handling
- Specific error messages for nested context failures
- Proper logging of nested resource errors
- User-friendly error displays
- Fallback mechanisms for critical failures

### 13. Monitoring and Logging
**RECOMMENDED**: Implement comprehensive monitoring
- Track nested resource performance metrics
- Log authorization attempts and failures
- Monitor database query performance
- Set up alerts for performance degradation

## Memory Updates

### Updated Understanding:
1. **Nested Resource Architecture**: Resources can be nested up to 4+ levels deep (Survey → Question → Answer → Response)
2. **Authorization Complexity**: Multi-level authorization requires checking permissions at each nesting level
3. **Performance Impact**: Nested resources can significantly impact performance without proper optimization
4. **URL Structure**: Nested resources create complex URL structures requiring careful management
5. **Widget Integration**: Widgets need special handling within nested resource contexts

### Updated Implementation Patterns:
1. **XotBase Integration**: All resources must use XotBase architecture for consistency
2. **Form Handling**: Forms in nested contexts require parent references
3. **Caching Strategies**: Different caching approaches needed for nested data
4. **Event Communication**: Special handling for widget-to-widget communication in nested contexts

## Agent-Specific Instructions

### For Code Review Agents:
- Verify XotBaseResource extension in all new resources
- Check authorization implementation at every nesting level
- Validate URL pattern consistency
- Ensure proper error handling implementation

### For Testing Agents:
- Create comprehensive tests for all nesting scenarios
- Verify authorization bypass prevention
- Test performance under various load conditions
- Validate data integrity across nesting levels

### For Security Agents:
- Check for authorization chain completeness
- Verify foreign key constraint implementation
- Test for data leakage between parent contexts
- Validate input sanitization in nested forms

## Compliance Checklist

When implementing or reviewing nested resource functionality, ensure:

- [ ] All resources extend XotBaseResource
- [ ] URL patterns follow consistent naming convention
- [ ] Authorization checks implemented at each level
- [ ] Proper Eloquent relationships defined
- [ ] Performance optimizations implemented
- [ ] Widgets are context-aware
- [ ] Foreign key constraints properly configured
- [ ] Input validation comprehensive
- [ ] Tests cover all nesting scenarios
- [ ] Error handling graceful and informative
- [ ] Monitoring and logging implemented

These updated rules and memories ensure all agents maintain consistency and quality when working with Filament 5.x resource nesting in the Quaeris platform.