# Database Mail Templates Integration Ideas

## Overview

Based on the analysis of `olivierguerriat/filament-spatie-laravel-database-mail-templates`, this document outlines potential improvements for the Notify module to support database-stored mail templates.

## Key Features to Consider

### 1. Template Model Structure
- **Template Model**: Store templates in database with fields like:
  - `name` - Template name
  - `subject` - Email subject
  - `html_content` - HTML content with placeholders
  - `text_content` - Text content with placeholders
  - `placeholders` - JSON array of available placeholders
  - `status` - Active/inactive status

### 2. Filament Integration
- **Resource Management**: Create a Filament resource for managing templates
- **Preview Functionality**: Implement template preview with sample data
- **Editor Interface**: Rich text editor for creating templates
- **Variable Management**: Interface for defining template variables

### 3. Template Rendering
- **Variable Substitution**: Replace placeholders with actual data
- **Blade Compilation**: Support for Blade syntax in templates
- **Preview Mode**: Ability to test templates with sample data

### 4. Advanced Features
- **Template Categories**: Organize templates by category
- **Template Versions**: Support for template versioning
- **A/B Testing**: Multiple versions for testing
- **Template History**: Track changes over time

## Implementation Approach

### 1. Database Schema
```php
Schema::create('mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('html_content');
    $table->text('text_content')->nullable();
    $table->json('placeholders')->default('[]');
    $table->string('category')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 2. Model Implementation
- Use `Spatie\MailTemplates\MailTemplate` as base
- Add Laravel's `HasFactory` and other traits
- Define fillable attributes based on enum-driven approach

### 3. Filament Resource
- Create `MailTemplateResource` extending `XotBaseResource`
- Implement `form()`, `table()`, and `getActions()` methods
- Add preview action for template testing
- Include category filtering and status toggles

## Integration with Notify Module

### 1. Template-Based Notifications
- Extend current notification system to support template-based emails
- Allow fallback to code-defined templates if DB template doesn't exist
- Support both transactional and marketing emails

### 2. Queue Integration
- Queue template-based emails for better performance
- Handle template resolution before job processing
- Implement retry logic for template resolution failures

### 3. Multi-Tenancy Support
- Tenant-specific templates where applicable
- Global templates for shared use
- Proper isolation between tenants

## Benefits

1. **Flexibility**: Non-technical users can modify email content
2. **Maintainability**: Centralized template management
3. **Customization**: Per-customer or per-tenant templates
4. **Preview Capabilities**: Test templates before deployment
5. **Analytics**: Track template performance and engagement

## Considerations

1. **Performance**: Cache templates to avoid DB queries on each send
2. **Security**: Validate and sanitize template content
3. **Migration**: Plan migration from code-based to DB-based templates
4. **Fallback**: Maintain code-based templates as fallback mechanism
5. **Permissions**: Proper access control for template management

## Next Steps

1. Create a POC implementation in a separate branch
2. Evaluate performance impact
3. Design the UI/UX for template management
4. Plan the migration strategy
5. Define the API contracts for template resolution
