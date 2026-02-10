# Architectural Refactoring: Implementing Spatie Queueable Actions

This document outlines the strategy and implementation plan for refactoring various methods into Spatie Queueable Actions across the application, with an initial focus on the `Gdpr` module, particularly the `RegisterWidget`. This refactoring adheres to the Laraxot principle of preferring Queueable Actions over traditional service classes or complex methods within Livewire components or controllers.

## Objective

The primary objective is to enhance code organization, improve testability, promote single responsibility, and enable asynchronous execution (queueing) for long-running or non-critical operations. By converting specific methods into dedicated Queueable Actions, we align with modern Laravel best practices and the Laraxot methodology.

## What are Spatie Queueable Actions?

Spatie's `laravel-queueable-action` package allows defining simple PHP classes that encapsulate a single, discrete action. These actions can be executed synchronously or asynchronously (via Laravel's queue system), making them ideal for tasks that might take time or should not block the user interface.

## Strategy for Conversion

1.  **Identify Candidate Methods:** Review existing methods within Livewire components, controllers, and other service-like classes that perform specific, independent tasks. Methods involving database writes, API calls, email sending, or complex calculations are prime candidates.
2.  **Create Action Class:** For each identified method, create a new PHP class within the appropriate module's `app/Actions` directory (e.g., `Modules/{ModuleName}/app/Actions/{Category}/{ActionName}Action.php`).
3.  **Implement `execute()` Method:** Move the logic of the original method into a public `execute()` method within the new Action class.
4.  **Add `QueueableAction` Trait:** Include `use Spatie\QueueableAction\QueueableAction;` in the Action class.
5.  **Inject Dependencies:** If the Action requires dependencies (e.g., other services, repositories), inject them via the constructor.
6.  **Replace Original Call:** In the original location, replace the method call with an instantiation and execution of the new Action (e.g., `app(MyAction::class)->execute($data)`).
7.  **Consider Queueing:** Determine if the action should be queued (`->onQueue()`, `->onConnection()`) or dispatched immediately (`->dispatchSync()`). For the `RegisterWidget`, initial actions will be dispatched synchronously for immediate feedback, but the architecture allows for easy future queuing.

## Initial Focus: `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget.php`

The following methods within `RegisterWidget.php` have been converted into dedicated Queueable Actions:

*   **`validateGDPRConsent()` -> `Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction`**
*   **`validateUserData()` -> `Modules\Gdpr\Actions\Validation\ValidateUserDataAction`**
*   **`collectGdprConsents()` -> `Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction`**
*   **`handleSuccessfulRegistration()` -> `Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction`**
*   **`handleRegistrationError()` -> `Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction`**

*Note: `CreateUserAction` and `LogRegistrationAction` (for `logRegistrationAttempt()`) were already implemented as actions.*

## Documentation Updates

*   This `register-action-refactoring.md` document serves as the primary reference for this refactoring initiative.
*   Other module/theme `docs` might be updated if relevant actions are created within them.

## Verification

After implementation, ensure that:
*   The registration process continues to function correctly without regressions.
*   All tests pass.
*   Static analysis tools (PHPStan, PHPMD, PHP Insights) report zero errors.

## Next Steps

The `RegisterWidget.php` within the `Gdpr` module has been fully refactored to utilize Queueable Actions. Further refactoring efforts will extend to other modules and themes as identified.