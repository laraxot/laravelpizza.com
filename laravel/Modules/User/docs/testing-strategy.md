# Testing Strategy for the User Module and Laraxot Applications

This document outlines the core testing strategy adopted across the User module and by extension, other modules within the Laraxot application framework. It emphasizes a robust, isolated, and efficient testing methodology designed to ensure high code quality and maintainability.

## Core Principles

The testing approach is built upon the following foundational principles, elaborated further in individual module `TestCase.php` files (e.g., `Modules/Gdpr/tests/TestCase.php`):

1.  **Pest as the Testing Framework:** All tests are written using the Pest PHP testing framework, leveraging its expressive syntax and intuitive features for cleaner and more readable test code.

2.  **Explicit Environment Configuration (`.env.testing`):**
    *   Tests strictly load their environment configuration from `laravel/.env.testing`. This ensures a dedicated and isolated environment for testing, preventing conflicts with development or production settings.
    *   This file is configured to use appropriate testing-specific settings, including database connections.

3.  **MySQL Over SQLite for Database Tests:**
    *   **Reasoning:** The application utilizes a multi-connection database topology (e.g., `user`, `gdpr`, `xot`, `tenant` connections). SQLite, being a file-based database, cannot accurately replicate this complex setup.
    *   Using MySQL for tests, configured via `.env.testing`, guarantees that the database engine, character sets, collations, and foreign-key behaviors are identical to the production environment. This significantly reduces the risk of false positives or negatives that could arise from environmental discrepancies.

4.  **`DatabaseTransactions` for Test Isolation (Never `RefreshDatabase`):**
    *   **Avoiding `RefreshDatabase`:** The `RefreshDatabase` trait is explicitly *never* used. While it provides isolation by dropping and recreating tables, this process is prohibitively slow, especially with MySQL, and destroys any seed data that might be crucial for cross-module dependencies or setup.
    *   **Embracing `DatabaseTransactions`:** Instead, the `Illuminate\Foundation\Testing\DatabaseTransactions` trait is utilized. This approach wraps each individual test within a database transaction. At the conclusion of each test, the transaction is rolled back, effectively reverting all database changes made during that test. This provides perfect test isolation with minimal overhead, leading to significantly faster test execution times.

5.  **Generic `php artisan migrate` for Schema Setup:**
    *   **Global Migration:** Database migrations are run only once for the entire test suite, typically during the initial `setUp` phase of the base `TestCase` class. This is achieved using a generic `php artisan migrate` command.
    *   **Module Auto-Discovery:** The Laraxot architecture ensures that migrations from *all* active modules are automatically discovered and executed in the correct dependency order (e.g., `Xot` module migrations before `User`, `Gdpr`, etc.) via their respective Service Providers.
    *   **No `--force` or `--database` flags:** Specifying `--force` is unnecessary in a testing environment (`APP_ENV=testing`), and `--database` would restrict migrations to a single connection, breaking the multi-connection topology. The generic `migrate` command is designed to handle the comprehensive setup.

## Example: User Registration Feature Tests

For a concrete example of this strategy in practice, refer to the `RegistrationTest.php` located in `laravel/Modules/Gdpr/tests/Feature/RegistrationTest.php` and its accompanying documentation in `laravel/Modules/Gdpr/docs/registration-testing.md`. This demonstrates how feature tests are structured to validate complex user flows, including interactions with multiple module components and database state changes, while adhering to the outlined principles.
