# Testing Standards & Workflow

## Framework
- **Primary Tool**: [Pest PHP](https://pestphp.com).
- **PHPUnit**: Forbidden. Convert any existing PHPUnit tests to Pest.

## Database & Isolation
- **Rule**: NEVER use the `RefreshDatabase` trait.
- **Isolation**: Manage state via custom `TestCase` setup/teardown, factories, or mocks.
- **Environment**: Always load `laravel/.env.testing`.

## Test Philosophy
- **Assume Site Works**: If a test fails but the application is functional, fix the test.
- **Coverage**: Aim for 100% logic coverage.
- **Placement**: Tests reside in `Modules/{Name}/tests/` or `Themes/{Name}/tests/`.

## Quality Checks
All tests must also pass:
- PHPStan Level 10
- PHPMD
- PHP Insights
