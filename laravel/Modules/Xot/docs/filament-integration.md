# Filament Integration and XotBaseResource: The Sacred Admin Pattern

## Core Philosophy

Laraxot uses Filament PHP as the primary admin interface framework. The integration follows strict architectural patterns that ensure consistency, maintainability, and adherence to the DRY/KISS principles.

## XotBaseResource: The Foundation of All Resources

### The Sacred Inheritance Chain
```
Filament Resource → XotBaseResource → FilamentResource
```

All Filament resources in Laraxot must extend `XotBaseResource` to ensure:
- Consistent behavior across modules
- Shared functionality and conventions
- Proper module integration
- Type safety and standardization

### XotBaseResource Features

```php
abstract class XotBaseResource extends FilamentResource
{
    use NavigationLabelTrait;

    // Standard configurations
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    
    public static function getModuleName(): string
    {
        return Str::between(static::class, 'Modules\\', '\Filament');
    }
    
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
```

## Standard Resource Structure

### Required Method Implementation
Each resource must implement the abstract method:

```php
abstract public static function getFormSchema(): array
```

This enforces consistent form schema definition across all resources.

### Standard Page Generation
XotBaseResource automatically generates standard pages:

```php
public static function getPages(): array
{
    return [
        'index' => ListSurveys::route('/'),
        'create' => CreateSurvey::route('/create'),
        'edit' => EditSurvey::route('/{record}/edit'),
        // Auto-detects view page if exists
    ];
}
```

## Filament Integration Patterns

### 1. Form Schema Pattern
Resources define forms through `getFormSchema()`:

```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'title' => TextInput::make('title'),
        // ... other fields
    ];
}
```

The `form()` method automatically processes this schema:

```php
final public static function form(Schema $schema): Schema
{
    $components = array_values(static::getFormSchema());
    return $schema->components($components)->columns(static::getFormSchemaColumns());
}
```

### 2. Relation Management
Automatic relation manager detection:

```php
public static function getRelations(): array
{
    // Automatically discovers *RelationManager.php files
    // in the resource's RelationManagers directory
}
```

### 3. Navigation and Badges
Automatic navigation badge with record count:

```php
public static function getNavigationBadge(): ?string
{
    try {
        $count = app(CountAction::class)->execute(static::getModel());
        return number_format($count, 0).'';
    } catch (\Exception $e) {
        return '--';
    }
}
```

## Page Integration

### XotBase Pages
All Filament pages extend Xot base classes:

- `XotBaseListRecords` for list pages
- `XotBaseCreateRecord` for create pages  
- `XotBaseEditRecord` for edit pages
- `XotBaseViewRecord` for view pages
- `XotBaseWidget` for widgets

### Example: List Page Pattern
```php
class ListSurveys extends XotBaseListRecords
{
    protected static string $resource = SurveyResource::class;
    
    public function getTableColumns(): array
    {
        // Define table columns
    }
    
    public function getTableActions(): array
    {
        // Define table actions
    }
}
```

## Advanced Filament Features

### 1. Sub-Navigation Pattern
Resources can have sub-navigation for related functionality:

```php
public static function getRecordSubNavigation(Page $page): array
{
    return $page->generateNavigationItems([
        ManageQuestionCharts::class,
        ManageContacts::class,
        // ... other related pages
    ]);
}
```

### 2. Translation Management
Laraxot uses automatic translation management through `LangServiceProvider`:
- Never use `->label()` directly
- All translations handled by language files
- Automatic label translation based on component names

### 3. Form Configuration
Consistent form setup with standardized columns:

```php
public static function getFormSchemaColumns(): int
{
    return 1; // Standard single column layout
}
```

## Widget Integration

### XotBaseWidget Pattern
All widgets extend `XotBaseWidget`:

```php
abstract class XotBaseWidget extends FilamentWidget
{
    // Shared widget functionality
}
```

Widgets contain business logic, validation, and security in a self-contained manner.

## Relationship Management

### 1. Relation Managers
Automatically discovered and registered:

```php
public static function getRelations(): array
{
    // Discovers files like:
    // SurveyResource/RelationManagers/QuestionsRelationManager.php
}
```

### 2. Nested Resource Pattern
For complex relationships, Laraxot supports nested resources within parent resources.

## Action Integration

### Filament Actions
Actions are seamlessly integrated with the resource system:

```php
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
        // Custom actions
    ];
}
```

### Custom Action Pattern
Custom actions follow the action pattern (separate from the main Actions directory):

```php
Action::make('customAction')
    ->action(function (Model $record) {
        // Action implementation
    })
```

## Security and Authorization

### 1. Panel Access
Resources integrate with Filament's panel system:

```php
public function canAccessPanel(Panel $panel): bool
{
    if ('admin' !== $panel->getId()) {
        $role = $panel->getId();
        return $this->hasRole($role);
    }
    return true;
}
```

### 2. Record Access
Individual record access control:

```php
public function canAccessFilament(?Panel $panel = null): bool
{
    return true; // Or implement custom logic
}
```

## The Sacred Rules of Filament Integration

### Rule 1: Always Extend XotBaseResource
❌ **WRONG:**
```php
class SurveyResource extends Resource
```

✅ **CORRECT:**
```php
class SurveyResource extends XotBaseResource
```

### Rule 2: Never Use Hardcoded Labels
❌ **WRONG:**
```php
TextInput::make('name')->label('Survey Name')
```

✅ **CORRECT:**
```php
TextInput::make('name') // Label handled by LangServiceProvider
```

### Rule 3: Follow Standard Method Names
Use the standard methods defined in XotBaseResource:
- `getFormSchema()` for form definition
- `getPages()` for page routing
- `getRelations()` for relations
- `getNavigationLabel()` for navigation

## Performance Optimizations

### 1. Combined Tabs
```php
public function hasCombinedRelationManagerTabsWithContent(): bool
{
    return true; // Combines relation managers with form content
}
```

### 2. Lazy Loading
Automatic lazy loading for related data where appropriate.

### 3. Caching Integration
Leverages Laravel's caching system for improved performance.

## Multi-Tenancy Integration

Filament resources integrate with Laraxot's multi-tenancy system:
- Automatic tenant scoping
- Tenant-aware queries
- Tenant-specific permissions

## The DRY/KISS Implementation

### DRY (Don't Repeat Yourself)
- Shared functionality in XotBaseResource
- Automatic page generation
- Standardized patterns across all modules

### KISS (Keep It Simple, Stupid)
- Clear, predictable inheritance
- Minimal configuration required
- Consistent API across resources

## Best Practices

### 1. Navigation Position
Standardize navigation position:
```php
protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
```

### 2. Model Discovery
Use automatic model discovery:
```php
public static function getModel(): string
{
    // Automatically discovers model based on resource name
}
```

### 3. Form Schema Method
Always implement `getFormSchema()` for consistency:
```php
public static function getFormSchema(): array
{
    // Return array of form components
}
```

## The Philosophy Behind Filament Integration

The Filament integration in Laraxot embodies the project's core values:

- **Consistency**: Same patterns across all admin interfaces
- **Maintainability**: Centralized base functionality
- **Extensibility**: Easy to customize while maintaining standards
- **Type Safety**: Contract-based development
- **User Experience**: Modern, intuitive admin interfaces

This integration ensures that every admin interface in the system follows the same high standards while providing the flexibility needed for module-specific requirements.