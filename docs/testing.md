
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
- The test environment is configured via `laravel/phpunit.xml` (APP_ENV=testing, cache/session array).
- Tests also load `laravel/.env.testing` automatically (Laravel default) when present.
- In this repository, database configuration is expected to come from `.env.testing` (same DB dialect as `.env`).
- If you change environment variables or config files, clear cached config before running tests:

```bash
php artisan config:clear
```

### Test environment (.env.testing)

The recommended settings for running tests are:

- `APP_ENV=testing`
- `DB_CONNECTION=mysql` (same dialect as `.env`)
- `DB_DATABASE=..._test` (separate testing databases)
- `CACHE_STORE=array`
- `SESSION_DRIVER=array`
- `QUEUE_CONNECTION=sync`

Important:

- `laravel/phpunit.xml` must NOT override `DB_CONNECTION` / `DB_DATABASE` if the project relies on `.env.testing`.
- Do not use `Illuminate\Foundation\Testing\RefreshDatabase` in tests: this codebase is designed around persistent test databases.

### CRITICAL RULES for Database & Migration in Testing

- **NO Module-Specific Connections**: NEVER add module-specific database connections (e.g., `NOTIFY_DB_DATABASE`, `GEO_DB_DATABASE`) to `.env.testing` or `config/database.php`. All modules must share the main application database connection (`DB_DATABASE`) for testing.
- **`DB_DATABASE` Naming**: The `DB_DATABASE` in `.env.testing` must be `your_main_db_name_test`. We only append `_test` to the existing main database name, without inventing new database connections.
- **Single Migration Run**: The test migration strategy must involve a single `php artisan migrate` execution (no `migrate:fresh`).
- **No `--force`**: The `--force` option must NEVER be used with `php artisan migrate` in tests.
- **No `self::$migrated` Check**: Remove any `if (! self::$migrated)` conditional checks from `TestCase.php` files to ensure migrations are run reliably and once.


### Composer merge-plugin (Modules)

This project uses `wikimedia/composer-merge-plugin` with:

- `extra.merge-plugin.include = ["Modules/*/composer.json"]`

By default, the plugin also merges `autoload-dev` and `require-dev` from module composer files (unless `merge-dev` is set to false).

### Composer autoload-dev rule

In `laravel/composer.json`, `autoload-dev.psr-4` must include only:

- `Tests\\` => `tests/`

Do not add a generic `Modules\\` => `Modules/` mapping in `autoload-dev`.

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
