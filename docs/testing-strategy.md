# Laravel Pest Testing Strategy

This document outlines the testing methodology for the Laravel modular project.

## Core Principles

- **Strictly Pest**: All tests must be written in Pest format. PHPUnit tests must be converted.
- **100% Coverage**: Aim for 100% test coverage for every module.
- **NO RefreshDatabase**: Never use `Illuminate\Foundation\Testing\RefreshDatabase`. It is destructive and slows down tests.
    - Use `Illuminate\Foundation\Testing\DatabaseTransactions` for isolation.
    - Use Factories to prepare specific state per test.
- **Module Isolation**: Tests should be run from the `laravel/` root but target specific modules.

## Environment Configuration

All tests must use the `laravel/.env.testing` file.
The default configuration uses SQLite in-memory:
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## Running Tests

Execute Pest from the `laravel/` directory:

### Run All Tests
```bash
./vendor/bin/pest
```

### Run Module Tests
```bash
./vendor/bin/pest Modules/User/tests
```

### Check Coverage (Module)
```bash
./vendor/bin/pest Modules/User/tests --coverage
```

## Autoloader & Modular Structure

The project uses `wikimedia/composer-merge-plugin` to merge module `composer.json` files.
In `laravel/composer.json`, the `autoload-dev` should only contain `Tests\`:
```json
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    }
}
```
Module-specific autoloading is handled within each `Modules/*/composer.json`.

## Custom TestCase Bootstrap

Each module should have a `TestCase` that extends `Tests\TestCase` (or a base module TestCase) and uses the `CreatesApplication` trait.
To resolve `pub_theme::` components, ensure the base layout and theme (e.g., `Meetup`) are correctly initialized in the `setUp()` method.
