# Testing Standards - Laraxot & Super Mucca

## Core Mandates
1.  **100% Coverage**: Every line of code, especially Spatie Actions, must be covered by Pest tests.
2.  **Pest Only**: No PHPUnit tests allowed. Convert existing ones.
3.  **No RefreshDatabase**: The `RefreshDatabase` trait is forbidden. Use `DatabaseTransactions` instead.
4.  **Multi-Connection Isolation**: For modules using dedicated connections, explicitly list them in `TestCase`:
    ```php
    protected array $connectionsToTransact = ['mysql', 'module_name', 'user'];
    ```
5.  **Environment**: Tests MUST load `.env.testing` and target `_test` databases.
6.  **No Constructor Connection Overrides**: Models MUST NOT override the connection in the constructor for testing. This breaks `TenantServiceProvider` dynamic mapping.

## Spatie Actions Testing
- Test the `execute()` method directly.
- Ensure all input variations (DTOs, arrays) are covered.
- Mock external APIs, but keep database interactions real (transactional).

## Validation
- After writing tests, run:
  ```bash
  ./vendor/bin/pest --compact --coverage --min=100
  ```
