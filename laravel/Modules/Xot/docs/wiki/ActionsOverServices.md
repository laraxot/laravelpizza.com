---
module: Xot
concept: Actions Over Services
last_updated: 2026-04-15
---

# Actions Over Services

The **Actions Over Services** pattern is a fundamental architectural rule in PTVX. It prioritizes single-purpose action classes over generic service layers.

## The Rule

- **No Services**: The creation of generic `Services/` folders for domain business logic is strictly forbidden.
- **Use Actions**: Business logic must reside in `app/Actions/`.
- **Queuable Actions**: For asynchronous or reusable logic, use the `spatie/laravel-queueable-action` package.

## Motivation

1. **Explicit Intent**: Each action class does exactly one thing (e.g., `CreateUserAction`, `ExportInvoiceAction`).
2. **Testability**: Smaller units of code are easier to isolate and unit test.
3. **DRY & KISS**: Prevents the "God Service" anti-pattern where a single service class grows into a monolith of unrelated methods.
4. **Consistency**: Actions integrate natively with Laravel's dependency injection and job queue system.

## Implementation Pattern

Actions should typically be invokable:

```php
namespace Modules\User\Actions;

use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function execute(User $user): void
    {
        // Business logic here
    }
}
```

### Calling Actions
Always use the `app()` helper or constructor injection:

```php
// ✅ CORRECT
app(SendWelcomeEmailAction::class)->execute($user);
```

## Maintenance Guidelines

- **Legacy Converge**: Existing classes in `app/Services` are considered technical debt and should be refactored into Actions during maintenance.
- **Documentation**: Roadmap and sprint plans must refer to "Actions" and "Contracts," never "Service Layers."

---
**Related Pages:**
- [[Xot Module Architecture]]
- [[BaseModel]]
- [[Queueable Actions]]
