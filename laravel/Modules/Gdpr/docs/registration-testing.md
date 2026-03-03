# Feature Testing: User Registration

This document outlines the approach and rationale behind the feature tests implemented for the user registration process within the `Gdpr` module. These tests ensure the robustness and correctness of the registration flow, especially concerning user data validation, password security, and GDPR consent handling.

## Objective

To thoroughly test the user registration functionality, ensuring that:
1.  Users can successfully register with valid data and required consents.
2.  Registration fails gracefully with appropriate error messages for invalid data (e.g., incorrect email format, weak passwords, mismatched passwords).
3.  Registration strictly enforces the acceptance of privacy policy and terms & conditions.
4.  User data, including first name, last name, email, and user type, is correctly stored in the database.
5.  GDPR consent preferences (privacy policy, terms & conditions, marketing consent) are accurately recorded.
6.  The system handles attempts to register with existing email addresses.

## Test Implementation (`RegistrationTest.php`)

A new Pest feature test file, `laravel/Modules/Gdpr/tests/Feature/RegistrationTest.php`, has been created to cover the various scenarios of user registration. Key aspects of the implementation include:

*   **Successful Registration:** A test case verifies the complete successful flow, including database assertions for user creation and consent recording. It also checks for the `Registered` event dispatch.
*   **Validation Scenarios:** Multiple test cases are dedicated to ensuring that validation rules are correctly applied and that registration attempts with invalid data (e.g., invalid email, weak password, mismatched passwords) fail as expected, redirecting back with session errors.
*   **GDPR Consent Enforcement:** Specific tests confirm that users cannot register if they do not accept the privacy policy or terms & conditions.
*   **Unique Email Check:** A test ensures that attempts to register with an email that already exists in the system are rejected.
*   **Redirection and Session State:** Tests assert the correct HTTP status codes (e.g., 302 for redirects) and session error messages on failure.

## Database Testing Strategy (Referencing `TestCase.php`)

As detailed in `laravel/Modules/Gdpr/tests/TestCase.php`, our testing environment adheres to the following principles:

*   **MySQL Usage:** We utilize MySQL for tests, consistent with the production environment, to avoid discrepancies and ensure accurate replication of database behavior. SQLite is explicitly avoided due to its limitations with multi-connection topologies and differences in engine characteristics.
*   **`DatabaseTransactions` Trait:** Each test case is wrapped in a database transaction, which is rolled back at the end of the test. This provides perfect test isolation and significantly improves test execution speed compared to `RefreshDatabase`. This approach eliminates the need to drop and recreate tables, preserving seed data and module dependencies.
*   **Generic `php artisan migrate`:** The application's migrations are run only once for the entire test suite using a generic `php artisan migrate` command, which auto-discovers migrations from all enabled modules via their Service Providers. This ensures that the database schema is correctly set up for all modules in the proper dependency order without requiring `--force` or `--database` flags.
*   **`.env.testing` Configuration:** All tests are executed using the configuration defined in the `.env.testing` file, ensuring a consistent and isolated test environment.

## Verification

Upon execution, these tests provide a comprehensive check of the registration feature's integrity. Any failures indicate potential issues in the registration logic, validation rules, or consent handling, requiring immediate attention.

## Location of Tests

- `laravel/Modules/Gdpr/tests/Feature/RegistrationTest.php`
- `laravel/Modules/Gdpr/tests/Feature/RegisterPageTest.php`
- `laravel/Modules/Gdpr/tests/Feature/RegisterWidgetTest.php`
- `laravel/Modules/Gdpr/tests/Feature/RegisterFormValidationTest.php`

## RegisterFormValidationTest: ValidateUserDataAction vs RegisterWidget

`ValidateUserDataAction` valida **solo** l'email duplicata. Le regole required, formato email, password strength, first_name/last_name min/max, password confirmation sono gestite da **RegisterWidget** (Livewire).

I test che richiedono validazioni non presenti nell'action sono **skipped** con messaggio esplicito. I test attivi verificano:

- `accepts valid email format`, `accepts valid strong password`
- `validates privacy/terms consent` (ValidateGdprConsentAction)
- `always sets type to customer_user`, `sets email_verified_at`
- `prevents duplicate email registration` (crea User, poi chiama action con stessa email)

## RegisterPageTest: Livewire vs POST

La pagina di registrazione usa **Folio + Livewire** (RegisterWidget), non un form POST tradizionale. I test devono quindi:

- **GET**: `get('/en/auth/register')` per verificare rendering e contenuti
- **Livewire**: `Livewire::test(RegisterWidget::class)` per validazione e submit

**Vietato** usare `post('/en/auth/register', [...])` — non esiste rotta POST; il form invia via Livewire `wire:submit="submit"`.

### Pattern corretto

```php
// ✅ Page rendering
get('/en/auth/register')->assertSee(trans('gdpr::register.form.cta_title'));

// ✅ Form validation e submit
Livewire::test(RegisterWidget::class)
    ->set('first_name', 'John')
    ->set('email', $email)
    ->set('privacy_accepted', true)
    ->set('terms_accepted', true)
    ->call('submit')
    ->assertHasErrors(['last_name']);
```

### TestCase

Tutti i test usano `Modules\Gdpr\Tests\TestCase` che estende `XotBaseTestCase` (DRY + KISS + Laraxot).
