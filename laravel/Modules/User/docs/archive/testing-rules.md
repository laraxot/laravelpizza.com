# Testing Rules & Strategy

## Strict Guidelines (Super Mucca / Laraxot)

1.  **Framework**: All tests MUST be written in **Pest**. 
    *   If you find PHPUnit tests, convert them to Pest immediately.
    *   Run tests from the `laravel/` root using: `./vendor/bin/pest`.

2.  **Database Strategy**:
    *   **NEVER use `Illuminate\Foundation\Testing\RefreshDatabase`**. 
    *   Understand the "why": We avoid full refreshes to handle complex seeders, existing data, and potential parallel testing issues in this modular mono-repo.
    *   Use `.env.testing` for environment configuration.
    *   Ensure `.env.testing` uses the **same database driver/dialect** as `.env` to avoid compatibility issues.

3.  **Philosophy**:
    *   **"The Site Works"**: If a test fails claiming functionality is missing, *the test is likely wrong*. Fix the test to match the working application logic.
    *   **Coverage**: Aim for 100% code coverage per module.
    *   **Quality**: Every file modification must be verified with:
        *   `phpstan` (Level 10)
        *   `phpmd`
        *   `phpinsights`
    *   **Principles**: DRY, KISS, SOLID, Robustness.

## How to Run Tests
From the `laravel/` directory:

```bash
# Run all tests
./vendor/bin/pest

# Run tests for a specific module (example)
./vendor/bin/pest Modules/User/tests

# Run a specific test file
./vendor/bin/pest Modules/User/tests/Feature/UserTest.php
```

## Troubleshooting
*   **Missing Features in Tests**: Check if the test is outdated. Do not implement new features just to satisfy a broken test.
*   **Autoloading Issues**: If classes are not found, check `composer.json` (ensure `Modules\\` is NOT in `autoload-dev` if using merge-plugin) and run `composer dump-autoload`.
