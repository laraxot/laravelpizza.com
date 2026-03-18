# PHPStan Level 10 - Filament Actions String Keys Rule

## Critical Requirement

All Filament action methods **MUST** return associative arrays with **string keys**, not indexed arrays.
When configuring actions inside a static `make()` method, the callback **MUST NOT**
rely on `$this` from the closure scope. Capture the created action instance with
`use ($action)` and narrow any payload read from `$arguments` / `$data` before
delegating to typed services or actions.

## The Rule

```php
// ✅ CORRECT - String keys
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        'translate' => Action::make('translate'),
    ];
}

// ❌ WRONG - Indexed array
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
        Action::make('translate'),
    ];
}
```

## PHPStan Error

```php
// Error message from PHPStan level 10:
Method Modules\Blog\Filament\Resources\ArticleResource\Pages\EditArticle::getHeaderActions() 
should return array<string, Filament\Actions\Action|Filament\Actions\ActionGroup> 
but returns array{Filament\Actions\DeleteAction, Filament\Actions\Action}.
```

## Affected Methods

| Method | Return Type | Notes |
|--------|-------------|-------|
| `getHeaderActions()` | `array<string, Action|ActionGroup>` | Edit/View pages |
| `getTableActions()` | `array<string, Action|ActionGroup>` | Row actions in tables |
| `getTableBulkActions()` | `array<string, Action|ActionGroup>` | Bulk actions in tables |
| `getTableHeaderActions()` | `array<string, Action|ActionGroup>` | Table header actions |

## Why This Rule Exists

### 1. Type Safety
PHPStan level 10 requires precise type declarations. Indexed arrays cannot guarantee the type structure:
```php
// Ambiguous - PHPStan doesn't know what keys exist
array{Action, Action}

// Clear - PHPStan knows keys are strings
array<string, Action|ActionGroup>
```

### 2. Testing Benefits
String keys enable precise action targeting in tests:
```php
// Can target specific action
livewire(EditArticle::class)
    ->callAction('delete', ['record' => $id]);
```

### 3. Action Manipulation
Keys allow programmatic control:
```php
$actions = $page->getHeaderActions();
$actions['delete']->disabled();
```

### 4. Code Readability
Self-documenting code:
```php
// Clear what each action does
[
    'delete' => DeleteAction::make(),
    'translate' => Action::make('translate'),
]
```

## Examples from Project

### Blog Module - EditArticle.php
```php
// ✅ CORRECT
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

### User Module - EditUser.php
```php
// ✅ CORRECT
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

### Activity Module - EditActivity.php
```php
// ✅ CORRECT
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

## Migration Checklist

When creating or updating Filament pages:

- [ ] Use associative arrays for all action methods
- [ ] Use descriptive string keys
- [ ] Verify with PHPStan level 10
- [ ] Update tests to use string keys
- [ ] Add PHPDoc comment: `@return array<string, Action|ActionGroup>`

## Common Mistakes

### Mistake 0: Using `$this` inside `static make()` callbacks
```php
// ❌ WRONG
public static function make(?string $name = null): static
{
    $action = parent::make($name);

    return $action->action(function (array $arguments, array $data): void {
        $this->execute($arguments, $data);
    });
}

// ✅ CORRECT
public static function make(?string $name = null): static
{
    $action = parent::make($name);

    return $action->action(function (array $arguments, array $data) use ($action): void {
        $action->execute($arguments, $data);
    });
}
```

### Mistake 0b: Passing unvalidated payload to typed actions
```php
// ❌ WRONG
$modelCopyAction->execute(
    $arguments['model_class'],
    $arguments['field_name'],
    $arguments['year'] ?? null,
);

// ✅ CORRECT
$modelClass = $arguments['model_class'] ?? null;
$fieldName = $arguments['field_name'] ?? null;
$year = $arguments['year'] ?? null;

if (! is_string($modelClass) || ! is_string($fieldName)) {
    return;
}

if (! is_string($year) && null !== $year) {
    return;
}

$modelCopyAction->execute($modelClass, $fieldName, $year);
```

### Mistake 1: Indexed Array
```php
// ❌ WRONG
protected function getHeaderActions(): array
{
    return [DeleteAction::make()];
}
```

### Mistake 2: Missing PHPDoc
```php
// ❌ WRONG
protected function getHeaderActions(): array
{
    return ['delete' => DeleteAction::make()];
}

// ✅ CORRECT
/**
 * @return array<string, Action|ActionGroup>
 */
protected function getHeaderActions(): array
{
    return ['delete' => DeleteAction::make()];
}
```

### Mistake 3: Inconsistent Key Names
```php
// ❌ WRONG - Inconsistent
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        2 => Action::make('edit'),  // Numeric key
    ];
}

// ✅ CORRECT - Consistent
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        'edit' => Action::make('edit'),
    ];
}
```

## Testing

### Test with String Keys
```php
// ✅ CORRECT
test('can delete article', function () {
    $article = Article::factory()->create();
    
    livewire(EditArticle::class, ['record' => $article->id])
        ->callAction('delete', ['record' => $article->id])
        ->assertNotified();
});
```

### Test Multiple Actions
```php
test('header actions have correct keys', function () {
    $page = new EditArticle();
    $actions = $page->getHeaderActions();
    
    expect($actions)
        ->toBeArray()
        ->toHaveKey('delete')
        ->toHaveKey('translate');
});
```

## Verification

Run PHPStan to verify compliance:
```bash
./vendor/bin/phpstan analyse Modules --level=10

# Should NOT see errors like:
# "Method getHeaderActions() should return array<string, Action|ActionGroup> 
#  but returns array{Action, Action}"
```

## Documentation Reference

See `/laravel/Modules/Xot/docs/FILAMENT_ACTIONS_STRING_KEYS.md` for complete documentation on this pattern.

## Conclusion

Using string keys for Filament actions is **required** for:
- ✅ PHPStan level 10 compliance
- ✅ Type safety
- ✅ Testability
- ✅ Code readability
- ✅ Maintainability

**Always use associative arrays with string keys for all Filament action methods.**
