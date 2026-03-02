# Notification Template Management System

## System Architecture

Based on analysis of `olivierguerriat/filament-spatie-laravel-database-mail-templates`, this document outlines the proposed architecture for a database-driven notification template system.

## Core Components

### 1. Template Model (`Template.php`)
```php
namespace Modules\Notify\Models;

use Modules\Xot\Models\XotBaseModel;
use Spatie\MailTemplates\Models\MailTemplate;

class Template extends XotBaseModel
{
    // Follow enum-driven fillable pattern
    public function getFillable(): array
    {
        return [
            ...TemplateEnum::getValues()
        ];
    }

    // Additional template-specific methods
    public function render(array $variables = []): string
    {
        // Implementation for rendering template with variables
    }
}
```

### 2. Template Repository (`TemplateRepository.php`)
```php
namespace Modules\Notify\Repositories;

class TemplateRepository
{
    public function findByTypeAndLocale(string $type, string $locale): ?Template
    {
        // Implementation
    }

    public function getWithFallback(string $templateKey, string $fallbackTemplate): Template
    {
        // Implementation with fallback logic
    }
}
```

### 3. Filament Resource (`TemplateResource.php`)
```php
namespace Modules\Notify\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class TemplateResource extends XotBaseResource
{
    // Follow XotBaseResource patterns
    // Implement form(), table(), and getPages() methods
}
```

## Template Variable System

### Variable Definition
```php
class TemplateVariable
{
    public string $name;
    public string $type; // text, html, date, etc.
    public string $description;
    public mixed $defaultValue;

    public function validate(mixed $value): bool
    {
        // Validation logic based on type
    }
}
```

### Variable Auto-Detection
```php
class TemplateVariableDetector
{
    public function detectVariables(string $template): array
    {
        preg_match_all('/\{\{(\w+)\}\}/', $template, $matches);
        return array_unique($matches[1]);
    }
}
```

## Advanced Features

### 1. Template Preview System
- Real-time preview with sample data
- Multiple locale previews
- Responsive email preview
- Template version comparison

### 2. Template Testing Framework
- Unit tests for template rendering
- Integration tests for delivery
- Performance tests for rendering speed
- Security tests for content sanitization

### 3. Template Analytics
- Open rates tracking
- Click-through rates
- Delivery success metrics
- Template performance comparison

## Security Considerations

### Content Sanitization
```php
class TemplateSanitizer
{
    public function sanitize(string $content): string
    {
        // Remove potentially dangerous HTML/JS
        // Allow only safe HTML tags
        // Escape variables during rendering
    }
}
```

### Input Validation
- Validate template structure
- Check for dangerous content patterns
- Ensure proper variable syntax
- Verify template integrity

## Performance Optimization

### Caching Strategy
```php
// Cache levels:
// L1: In-memory cache (per request)
// L2: Redis cache (shared across requests)
// L3: Database fallback with proper indexing
```

### Database Optimization
- Proper indexing on template lookup fields
- Efficient queries using Eloquent relationships
- Connection pooling for template retrieval
- Batch operations for bulk template updates

## Integration Points

### With User Module
- Personalized templates based on user data
- User preference-based template variants
- Role-based template access controls

### With Activity Module
- Track template usage and performance
- Log template rendering events
- Monitor template effectiveness

### With Tenant Module
- Multi-tenant template isolation
- Shared template libraries
- Tenant-specific customizations

## Migration Strategy

### Phase 1: Setup
1. Create template database tables
2. Implement basic model and repository
3. Add basic Filament resource

### Phase 2: Integration
1. Modify existing notification system
2. Add template fallback mechanism
3. Implement variable substitution

### Phase 3: Enhancement
1. Add advanced features (preview, testing)
2. Implement analytics
3. Optimize performance

### Phase 4: Refinement
1. Add security features
2. Implement caching
3. Add monitoring and logging

## Testing Approach

### Unit Tests
- Template rendering logic
- Variable substitution
- Content sanitization
- Repository methods

### Integration Tests
- Filament resource functionality
- Template delivery system
- Database operations
- Cache operations

### Feature Tests
- End-to-end template management
- Preview functionality
- Variable validation
- Security features

## Quality Assurance

This implementation follows Laraxot principles:
- **DRY**: Reuse existing patterns and components
- **KISS**: Simple, understandable implementation
- **SOLID**: Proper class design and separation of concerns
- **Testable**: Comprehensive testing approach
- **Secure**: Proper content validation and sanitization
