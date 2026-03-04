# Filament 5.x Nested Resources Guide

## Overview
Filament 5.x Nested Resources allow hierarchical relationships between resources with automatic routing and breadcrumb generation.

## Key Concepts

### 1. Creating Nested Resources
```bash
# Create parent resource
php artisan make:filament-resource User

# Create nested resource (automatically creates relation manager)
php artisan make:filament-resource Post --nested
```

### 2. Class Structure
```
app/Filament/Resources/UserResource.php
├── getRelations() method
└── nested resources in Resources/Post/

app/Filament/Resources/User/Resources/PostResource.php
├── static $parentResource = UserResource::class
└── relation managers in RelationManagers/
```

### 3. Parent Resource Configuration
```php
// UserResource.php
class UserResource extends XotBaseResource
{
    public static function getRelations(): array
    {
        return [
            PostRelationManager::class,
        ];
    }
}
```

### 4. Nested Resource Configuration
```php
// PostResource.php
class PostResource extends XotBaseResource
{
    protected static ?string $model = Post::class;
    
    public static function getNavigationLabel(): string
    {
        return __('filament::resources/relation-managers.posts');
    }
}
```

### 5. Relation Manager
```php
// PostRelationManager.php
class PostRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'posts';
    
    public static function getRecordLabel(): ?string
    {
        return __('filament::resources/relation-managers.post');
    }
}
```

## Routing Pattern
```
/{parent}/{resource}
/{parent}/{resource}/create
/{parent}/{resource}/{record}
/{parent}/{resource}/{record}/edit
```

## Breadcrumb Customization
```php
// PostRelationManager.php
public function getBreadcrumbRecordLabel(): string
{
    return $this->getRecord()->title;
}

public function getBreadcrumbs(): array
{
    return [
        ...parent::getBreadcrumbs(),
        $this->getBreadcrumbRecordLabel(),
    ];
}
```

## Data Access
```php
// Access parent data during creation
protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = $this->getRouteKey();
    return $data;
}
```

## Form Schema
```php
public function getFormSchema(): array
{
    return [
        TextInput::make('title')
            ->required(),
        // ... other fields
    ];
}
```

## Table Configuration
```php
public function getTableColumns(): array
{
    return [
        TextColumn::make('title'),
        TextColumn::make('created_at')
            ->dateTime(),
    ];
}
```

## Actions
```php
public function getActions(): array
{
    return [
        Actions\CreateAction::make(),
        Actions\EditAction::make(),
        Actions\DeleteAction::make(),
    ];
}
```

## Bulk Actions
```php
public function getBulkActions(): array
{
    return [
        BulkAction::make('delete')
            ->deselectRecordsAfterCompletion(),
    ];
}
```

## Permissions
```php
public static function canViewAny(): bool
{
    return Gate::allows('view-any', static::$model);
}

public static function canCreate(): bool
{
    return Gate::allows('create', static::$model);
}
```

## Validation
```php
public function validate(): array
{
    return [
        'title' => ['required', 'string'],
    ];
}
```

## Custom Queries
```php
public function getTableQuery(): Builder
{
    return parent::getTableQuery()->where('status', 'published');
}
```

## Advanced Features

### Custom Relation Names
```php
public function getParentResourceRegistration(): string
{
    return parent::getParentResourceRegistration()
        ->relationship('custom_posts', 'posts');
}
```

### Multiple Relations
```php
// In parent resource
public static function getRelations(): array
{
    return [
        PostsRelationManager::class,
        CommentsRelationManager::class,
    ];
}
```

### Custom Actions
```php
public function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make()
            ->label(__('filament::resources/relation-managers.create')),
    ];
}
```

## Best Practices

1. **Always extend XotBaseResource** for consistency
2. **Use proper naming conventions** for relation managers
3. **Implement breadcrumb customization** for better UX
4. **Add proper validation** for all form fields
5. **Use bulk actions** for efficient management
6. **Implement proper permissions** for security
7. **Add custom queries** for filtering and sorting
8. **Use proper action configurations** for CRUD operations

## Common Issues

### 1. Route Conflicts
- Ensure unique relation manager names
- Check parent resource configuration
- Verify route registration

### 2. Permission Issues
- Implement proper Gate checks
- Use correct policy methods
- Verify user permissions

### 3. Data Access Issues
- Use mutateFormDataBeforeCreate() for parent data
- Implement proper query scopes
- Check relationship definitions

## Debugging

### 1. Route Debugging
```php
dd($this->getRouteKey(), $this->getRecord());
```

### 2. Relationship Debugging
```php
dd($course->lessons()->getRelated());
```

### 3. Permission Debugging
```php
Gate::allows('view-any', static::$model);
```

## Testing

### 1. Route Testing
```php
Route::get('/{parent}/{resource}', PostRelationManager::class)
    ->assertStatus(200);
```

### 2. Data Testing
```php
$data = Post::factory()->create();
$this->assertDatabaseHas('posts', $data->toArray());
```

## Performance Optimization

1. **Use eager loading** for related data
2. **Implement proper indexing** for database queries
3. **Add pagination** for large datasets
4. **Use caching** for frequently accessed data
5. **Optimize queries** with proper WHERE clauses

## Security Considerations

1. **Always validate input** data
2. **Implement proper authorization** checks
3. **Use parameterized queries** to prevent SQL injection
4. **Sanitize user input** before storage
5. **Implement proper error handling** without information leakage