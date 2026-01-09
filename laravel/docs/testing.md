
# Testing

This document describes how to run the tests for this project.

## Running Tests

To run the tests, run the following command from the `laravel` directory:

```bash
./vendor/bin/pest
```

This will run:

- the application tests in `laravel/tests` (Feature + Unit)
- the module tests in `laravel/Modules/*/tests` (Feature + Unit)

Notes:

- Module discovery is configured via `laravel/phpunit.xml` using wildcard directories (see `testsuite name="Modules"`).
- The test environment is configured via `laravel/phpunit.xml` (APP_ENV=testing, sqlite :memory:, cache/session array).
- Tests also load `laravel/.env.testing` automatically (Laravel default) when present.

### Test environment (.env.testing)

The recommended settings for running tests are:

- `APP_ENV=testing`
- `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`
- `CACHE_STORE=array`
- `SESSION_DRIVER=array`
- `QUEUE_CONNECTION=sync`

### Run a specific module

You can target a module by path:

```bash
./vendor/bin/pest Modules/Geo/tests
```

Or by filter (matches test file/class/function names):

```bash
./vendor/bin/pest --filter Geo
```

### Useful flags

```bash
./vendor/bin/pest --stop-on-failure
./vendor/bin/pest --parallel
```

## Test Coverage

Coverage requires Xdebug or PCOV.

To get a coverage report, run the following command:

```bash
./vendor/bin/pest --coverage
```

To generate an HTML report:

```bash
./vendor/bin/pest --coverage --coverage-html=build/coverage
```

This will generate an HTML coverage report in the `build/coverage` directory.
