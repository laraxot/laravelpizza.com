# Laraxot Testing Best Practices

## 1. Core Philosophy: Zen Laraxot
Testing in Laraxot follows the **DRY (Don't Repeat Yourself)** and **KISS (Keep It Simple, Stupid)** principles. All tests should be robust, maintainable, and highly performant.

## 2. Base Test Case: `XotBaseTestCase`
All module test cases (`Modules/*/tests/TestCase.php`) MUST extend `Modules\Xot\Tests\XotBaseTestCase` instead of the base Laravel `TestCase`.

### Benefits:
- **Centralized Bootstrap**: Application initialization via `CreatesApplication` is handled once.
- **Unified Environment**: Automatically uses `.env.testing` and ensures consistent database state.
- **Common Helpers**: Provides standardized methods like `generateUniqueEmail()`, `getUserClass()`, and `createTestUser()`.
- **Translator Binding**: Automatically binds a mock translator if not present, preventing `BindingResolutionException` in unit tests.

## 3. Database Management: No `RefreshDatabase`
**🚨 CRITICAL RULE**: NEVER use the `RefreshDatabase` trait in any tests.

### Why?
- `RefreshDatabase` is slow as it re-runs all migrations for every test class or even every test.
- In a modular multi-database environment like Laraxot, it can be unpredictable.

### What to use instead:
- **`DatabaseTransactions`**: Use this trait to wrap each test in a database transaction that is rolled back afterward.
- **Manual Migration**: Ensure migrations are run once before the test suite starts (e.g., in CI or via a dedicated command).
- **Factories**: Use the `createTestUser()` helper or model factories to set up the necessary data state.

## 4. Test Framework: Pest
All tests MUST be written in **Pest**. If you find legacy PHPUnit tests, they must be converted to Pest format.

### Key Conventions:
- Use `uses(TestCase::class)` at the top of feature tests.
- Keep tests concise and descriptive.
- Aim for 100% code coverage across all modules.

## 5. Coverage Goals
Every module must strive for **100% test coverage**.
- Run coverage analysis regularly: `./vendor/bin/pest --coverage`.
- Use `pcov` for faster coverage reporting.
- If a test fails, fix it or remove it if it's obsolete. The site is assumed functional; failing tests usually indicate incorrect test logic.

## 6. Directory Structure
Follow the **Traditional Laravel Structure**:
- `Modules/{Module}/tests/Feature/`
- `Modules/{Module}/tests/Unit/`
- `Modules/{Module}/tests/TestCase.php` (Extending `XotBaseTestCase`)

Avoid mixed structures (e.g., keeping tests inside `app/Tests/`).
