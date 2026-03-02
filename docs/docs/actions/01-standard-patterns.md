# Action Execution and Dependency Injection Rules in Laraxot

This document details mandatory rules and best practices for executing Spatie Queueable Actions and managing dependency injection within business logic classes, especially Actions. Adherence to these guidelines is crucial for maintaining architectural consistency, testability, queueability, and aligning with the Laraxot philosophy.

---

## Core Principles

1.  **Consistent Action Interface**: Actions should expose a single, consistent entry point for their primary business logic.
2.  **Simplified Action Instantiation**: Actions should be easy to instantiate and consume without complex dependency resolution during construction.
3.  **Testability and Queueability**: Actions must remain highly testable and easily queueable, free from tight coupling to the Service Container at instantiation.
4.  **Auto-Registration**: Spatie QueueableAction auto-registers in Laravel container - no manual DI needed!

---

## Mandatory Rules

### Rule 1: Use `use QueueableAction` Trait (NOT extends)

*   **Description**: Always use the trait `Spatie\QueueableAction\QueueableAction`, never extend the class.
*   **❌ Incorrect**:
    ```php
    class CreateUserAction extends QueueableAction { }
    ```
*   **✅ Correct**:
    ```php
    use Spatie\QueueableAction\QueueableAction;

    class CreateUserAction
    {
        use QueueableAction;
        // ...
    }
    ```

### Rule 2: Use `execute()` as the Primary Action Entry Point

*   **Description**: When interacting with Spatie Queueable Actions, always invoke the `execute()` method. Other public methods within an Action should be considered internal helpers or specific sub-tasks, not the main entry point for the Action's business logic.
*   **Motivation**: This enforces a consistent API for all Actions, making them predictable, easier to test, and suitable for queuing. It aligns with the contract implied by `Spatie\QueueableAction\QueueableAction`.
*   **❌ Incorrect**:
    ```php
    app(CreateUserAction::class)->createSpecificUser(...); // Assumes createSpecificUser is the main logic
    ```
*   **✅ Correct**:
    ```php
    app(CreateUserAction::class)->execute(...);
    ```

### Rule 3: AVOID Constructor Injection for Actions

*   **Description**: In Spatie Queueable Actions, **NEVER use constructor dependency injection**. Instead, resolve necessary dependencies internally within the `execute()` method using `app()`.
*   **Motivation**: 
    *   **Simpler Actions**: Constructors remain lean
    *   **Enhanced Testability**: Actions become more independent
    *   **Easier Queueing**: Actions can be serialized more reliably
    *   **Auto-Resolution**: Spatie QueueableAction auto-registers in Laravel container, `app(<Action>::class)` resolves dependencies automatically
*   **❌ Incorrect**:
    ```php
    class CreateUserAction
    {
        use QueueableAction;

        public function __construct(
            private readonly CalculateOrderTotalAction $calculateTotal,
            private readonly LoggerInterface $logger,
        ) {}

        public function execute(UserData $data): User
        {
            // ...
        }
    }
    ```
*   **✅ Correct**:
    ```php
    class CreateUserAction
    {
        use QueueableAction;

        public function execute(UserData $data): User
        {
            // Resolve dependencies internally using app()
            $logger = app(LoggerInterface::class);
            $calculator = app(CalculateOrderTotalAction::class);
            
            $result = $calculator->execute($order);
            // ... business logic
        }
    }
    ```

### Rule 4: Always Call `execute()` Directly

*   **Description**: Never call custom methods that internally call `execute()`. Always call `execute()` directly.
*   **❌ Incorrect**:
    ```php
    app(CreateClientAction::class)->createPersonalAccessClient();
    ```
*   **✅ Correct**:
    ```php
    app(CreateClientAction::class)->execute($data);
    ```

---

## Summary: Correct Action Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\User\Models\User;

class CreateUserAction
{
    use QueueableAction;

    public function execute(array $data): User
    {
        // Use app() for other actions/services
        $logger = app(LoggerInterface::class);
        $profileCreator = app(CreateProfileAction::class);

        $user = User::create($data);
        $profileCreator->execute($user);

        return $user;
    }
}
```

**Calling the Action:**
```php
// ✅ CORRECT
$user = app(CreateUserAction::class)->execute(['email' => 'test@example.com']);

// ✅ Queued
app(CreateUserAction::class)->onQueue('high')->execute($data);
```

---

## Related Documentation

*   [Spatie Queueable Actions GitHub Repository](https://github.com/spatie/laravel-queueable-action)
*   [Xot Module Philosophy](../filosofia-modulo-xot.md)
*   [Actions Pattern](./actions-pattern.md)

## Validation & Enforcement

Run these commands to verify compliance with Action rules:

### 1. Detect Static Method Calls (Forbidden)
```bash
grep -r "Action::" Modules/ --include="*.php" | grep -v "use\|namespace"
```

### 2. Detect Direct Instantiation (Forbidden)
```bash
grep -r "new.*Action" Modules/ --include="*.php"
```

### 3. Detect Static Method Definitions (Forbidden)
```bash
grep -r "public static function" Modules/ --include="*.php" | grep "Action"
```

### 4. Detect Constructor Injection (Forbidden)
```bash
grep -r "__construct" Modules/*/app/Actions/ --include="*.php"
```
