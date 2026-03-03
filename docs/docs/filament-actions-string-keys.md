# Filament Actions - String Keys Requirement

## Critical Type Rule

All Filament action methods **MUST** return associative arrays with **string keys**, not indexed arrays.

## Affected Methods

1. `getHeaderActions(): array<string, Action|ActionGroup>`
2. `getTableActions(): array<string, Action|ActionGroup>`
3. `getTableBulkActions(): array<string, Action|ActionGroup>`
4. `getTableHeaderActions(): array<string, Action|ActionGroup>`

## Why String Keys Are Required

### 1. PHPStan Type Safety
PHPStan level 10 requires strict typing:
```php
// WRONG - PHPStan error
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
        Action::make('translate'),
    ];
}
// Error: Should return array<string, Action|ActionGroup> but returns array{Action, Action}

// CORRECT - PHPStan passes
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        'translate' => Action::make('translate'),
    ];
}
```

### 2. Test Targeting
String keys allow precise action testing:
```php
// Test: Can call action by key
livewire(EditArticle::class)
    ->callAction('delete', ['record' => $article->id]);
```

### 3. Action Manipulation
Keys enable programmatic action control:
```php
// Can disable specific action by key
$actions['delete']->disabled();
```

### 4. Consistency
All Filament methods follow this pattern for consistency.

## Correct Patterns

### Edit Pages
```php
class EditArticle extends XotBaseEditRecord
{
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make()
                ->requiresConfirmation(),
            'translate' => Action::make('translate')
                ->label('Translate')
                ->icon('heroicon-o-language'),
        ];
    }
}
```

### List Pages
```php
class ListArticles extends XotBaseListRecords
{
    protected function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make()
                ->requiresConfirmation(),
            'publish' => Action::make('publish')
                ->label('Publish'),
        ];
    }
}
```

## Common Mistakes

### Mistake 1: Indexed Array
```php
// WRONG
protected function getHeaderActions(): array
{
    return [DeleteAction::make()];
}
```

### Mistake 2: Wrong Type Hint
```php
// WRONG - Missing string key type
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
    ];
}
```

### Mistake 3: Using array{} Without Keys
```php
// WRONG
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

The correct type hint is:
```php
/**
 * @return array<string, Action|ActionGroup>
 */
protected function getHeaderActions(): array
```

## Migration Steps

### Step 1: Add String Keys
```php
// BEFORE
return [DeleteAction::make(), Action::make('edit')];

// AFTER
return [
    'delete' => DeleteAction::make(),
    'edit' => Action::make('edit'),
];
```

### Step 2: Update Tests
```php
// BEFORE - targeting by index
livewire(EditArticle::class)
    ->callAction(1, ['record' => $id]);

// AFTER - targeting by key
livewire(EditArticle::class)
    ->callAction('delete', ['record' => $id]);
```

### Step 3: Verify with PHPStan
```bash
./vendor/bin/phpstan analyse Modules/Blog --level=10
```

## Examples from Project

### Blog Module
```php
// Blog/app/Filament/Resources/ArticleResource/Pages/EditArticle.php
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        'translate' => Action::make('translate')
            ->label('Copia Blocchi nelle altre lingue')
            ->tooltip('translate')
            ->icon('heroicon-o-language'),
    ];
}
```

### User Module
```php
// User/app/Filament/Resources/UserResource/Pages/EditUser.php
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make()
            ->requiresConfirmation(),
        'impersonate' => Action::make('impersonate')
            ->label('Impersonate'),
    ];
}
```

### Activity Module
```php
// Activity/app/Filament/Resources/ActivityResource/Pages/EditActivity.php
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

## XotBase Classes

All XotBase page classes enforce this pattern:

```php
// Modules/Xot/Filament/Resources/Pages/XotBaseEditRecord.php
/**
 * @return array<string, Action|ActionGroup>
 */
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make()
            ->requiresConfirmation(),
    ];
}
```

## Documentation

Always reference this pattern in module documentation:

```php
/**
 * Get header actions for the page.
 *
 * @return array<string, Action|ActionGroup>
 */
protected function getHeaderActions(): array
{
    // Implementation
}
```

## Conclusion

Using string keys for Filament actions:
1. **Required** for PHPStan level 10 compliance
2. **Required** for proper type safety
3. **Best practice** for testability
4. **Standard pattern** across Laraxot

**Always use associative arrays with string keys for all Filament action methods.**