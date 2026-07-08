# XotBaseRelationManager Static Access Fixes

## Static Access to Instance Property Issue

### Error
```
Static access to instance property Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager::$resource.
```

### Additional Error
```
Dead catch - Exception is never thrown in the try block.
```

### Analysis
The issue is in the `getResource()` method of `XotBaseRelationManager`. It attempts to access `static::$resource` which causes two problems:

1. Static access to an instance property: It's attempting to access the `$resource` property using a static call, but it appears that `$resource` is actually defined as an instance property in the parent class.

2. Dead catch block: The code uses a try-catch but the operation in the try block (`return static::$resource`) cannot actually throw an exception in PHP's execution model, making the catch block unreachable (dead code).

Current implementation:
```php
protected function getResource(): string
{
    try {
        /* @var class-string<XotBaseResource> */
        return static::$resource;
    } catch (\Exception $e) {
        // Fallback code...
    }
}
```

### Solution
1. Properly declare the `$resource` property as static if it's meant to be accessed statically, or change the access method to use instance property notation
2. Remove the unnecessary try-catch block and implement a more direct conditional approach
3. Ensure proper type hinting for PHP 8 compatibility

### Benefits
- Correct PHP property access model
- Elimination of dead code
- Improved type safety
- Better performance without unnecessary exception handling
