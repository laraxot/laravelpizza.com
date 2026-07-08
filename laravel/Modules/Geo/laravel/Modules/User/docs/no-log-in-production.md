# No Log calls in production PHP code

## Rule

Never use `Log::info()`, `Log::debug()`, `Log::warning()`, or `Log::error()` in production PHP code.

This applies to: Actions, Models, Services, Widgets, Filament resources, and all other production classes.

## Violation found and fixed

**File**: `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`

The widget contained:
- `Log::info()` calls inside registration logic
- `Log::debug()` calls for parameter tracing
- `Log::error()` calls inside catch blocks
- A dedicated method `logRegistrationAttempt()` wrapping log calls

All were removed. The `handleRegistrationError()` method was simplified to re-throw the exception directly.

## Why this is wrong

### Performance overhead

Every `Log::*` call involves:
- String interpolation and context array building
- A file I/O write (or network call for remote log drivers)
- Stack trace capture when `Log::error()` is used with exception context

In high-traffic widgets like registration forms, this adds measurable latency per request.

### Security risk

Log files often contain:
- Email addresses passed as context
- IP addresses and user agents
- Form field values (accidentally logged as part of `$request->all()` or similar)
- Internal stack traces revealing application structure

Log files are typically readable by any process running as the web user, and often included in error monitoring dashboards that have broader access than the application DB.

### Laravel already handles this

Laravel's exception handler automatically logs unhandled exceptions at the appropriate level. There is no need to manually log caught exceptions before re-throwing them. Doing so creates duplicate log entries.

### CLAUDE.md alignment

The project's CLAUDE.md states: "Never commit console.log statements to production code." This applies equally to PHP's `Log::*` facade.

## Correct pattern

```php
// WRONG
try {
    $this->register($data);
} catch (\Exception $e) {
    Log::error('Registration failed', ['email' => $data['email'], 'error' => $e->getMessage()]);
    throw $e;
}

// CORRECT
try {
    $this->register($data);
} catch (\Exception $e) {
    throw $e;
}
```

If the exception is truly unrecoverable and you need context in logs, use Laravel's report helper at the handler level, not inline:

```php
// Acceptable in ExceptionHandler, not in business logic
report($e);
```

## When logging IS acceptable

Logging is acceptable only in:
- `app/Exceptions/Handler.php` — global exception handling
- Scheduled command output via `$this->info()` / `$this->error()` (Artisan commands only)
- Dedicated audit trail models (e.g., `Consent` model writing to DB, not log files)

## Related

- CLAUDE.md rule: "Never commit console.log statements to production code"
- Quality gate: `./vendor/bin/phpmd Modules/{Name}/app text cleancode` flags many Log calls as code smell
- PHPStan level 10 does not flag Log calls directly, but code reviewers must catch them
