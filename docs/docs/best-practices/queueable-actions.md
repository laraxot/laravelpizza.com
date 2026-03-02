# Queueable Actions Best Practices

## Why Queueable Actions?

We use `spatie/laravel-queueable-action` instead of traditional Service classes for several reasons:

1.  **Single Responsibility**: Each Action does one thing.
2.  **Testability**: Actions are easy to mock and test in isolation.
3.  **Scalability**: Actions can be easily moved to a background queue without changing the caller logic.
4.  **Consistency**: A unified pattern across all Laraxot modules.

## Rules

### 1. Location & Naming

-   **Path**: `Modules/{Module}/app/Actions/{SubDir}/{ActionName}Action.php`
-   **Suffix**: Always end the class name with `Action`.

### 2. Implementation

-   Use the `QueueableAction` trait.
-   The entry point must be the `execute()` method.
-   Type-hint all parameters and the return value.

```php
declare(strict_types=1);

namespace Modules\{Module}\Actions;

use Spatie\QueueableAction\QueueableAction;

class ExampleAction
{
    use QueueableAction;

    public function execute(string $input): bool
    {
        // Logic
        return true;
    }
}
```

### 3. Usage

-   Call actions via `app()` or constructor injection to allow for decorator/proxy behavior.
-   Prefer `app(Action::class)->execute(...)` for simple calls.

### 4. Transactions

-   If an action performs multiple database operations, wrap them in a `DB::transaction()` internally OR expect the caller to do so if part of a larger unit of work.
-   For `RegisterWidget`, the transaction remains in the Widget to span multiple actions (User creation + GDPR consent).

### 5. Error Handling

-   Actions should throw specific exceptions that the caller (Widget) can catch and handle.
