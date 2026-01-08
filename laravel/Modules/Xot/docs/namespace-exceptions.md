# Exception Namespace Structure

## Directory Structure

All exceptions in the Xot module should be placed in the following directory structure:

```
Modules/Xot/app/Exceptions/
```

Do NOT place exceptions in:

```
Modules/Xot/Exceptions/
```

## Namespace Convention

All exception classes should use the namespace:

```php
namespace Modules\Xot\App\Exceptions;
```

Or for nested directories:

```php
namespace Modules\Xot\App\Exceptions\Handlers;
```

## Common Issues

### Undefined property error with ExceptionHandler

If you encounter an error like:

```
Undefined property: NunoMaduro\Collision\Adapters\Laravel\ExceptionHandler::$reportable
```

This is often caused by namespace mismatches between the exception handler classes. Make sure all exception handlers are in the correct namespace and directory structure.

### Namespace Mismatch

Ensure that the namespace in the file matches the actual directory structure. For example, a file in `Modules/Xot/app/Exceptions/Handlers/` should have the namespace `Modules\Xot\App\Exceptions\Handlers`.