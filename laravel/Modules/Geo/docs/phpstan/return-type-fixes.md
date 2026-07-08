# XotBaseResource Return Type Fixes

## getRelations() Return Type Issue

### Error
```
Method Modules\Xot\Filament\Resources\XotBaseResource::getRelations()
should return
array<class-string<Filament\Resources\RelationManagers\RelationManager>|Filament\Resources\RelationManagers\RelationGroup|Filament\Resources\RelationManagers\RelationManagerConfiguration>
but returns
array<class-string|Filament\Resources\RelationManagers\RelationGroup|Filament\Resources\RelationManagers\RelationManagerConfiguration>.
```

### Analysis
The PHPStan error occurs because the `getRelations()` method is incorrectly typed. The method is adding class names to an array without specifying that they must be class names of `Filament\Resources\RelationManagers\RelationManager` classes.

Current implementation:
```php
$className = static::class.'\RelationManagers\\'.$info['filename'];
if (class_exists($className)) {
    $res[] = $className;
}
```

While the docblock indicates the correct return type, the actual implementation doesn't enforce or validate that the classes found match the expected type.

### Solution
1. Add a type assertion or check to ensure that every class added to the result array is an instance of the required RelationManager class.
2. Update the code to properly handle the type check before adding the class name to the result array.

### Benefits
- Improved type safety at a high PHPStan level
- Better code reliability and maintainability
- Clear expectations for extending classes
