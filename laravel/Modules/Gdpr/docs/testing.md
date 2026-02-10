# Testing Documentation — GDPR Module

## Three Fundamental Rules

### 1. MySQL only — NEVER SQLite

The project uses **multiple named database connections** (`user`, `gdpr`, `xot`, `tenant`, etc.).
SQLite cannot replicate this multi-connection topology. MySQL from `.env.testing` guarantees
the same engine, charset, collation, and foreign-key behaviour as production, avoiding
false positives/negatives that SQLite would introduce (e.g. missing `ENUM` support, different
`GROUP BY` semantics, no real foreign-key enforcement by default).

### 2. DatabaseTransactions — NEVER RefreshDatabase

`RefreshDatabase` drops and recreates every table on each test class. On MySQL with dozens
of module migrations this is **extremely slow** and **destroys seed data** that other modules
may rely on. `DatabaseTransactions` wraps each test in a transaction and rolls back at the
end, giving perfect isolation with near-zero overhead.

### 3. Generic `php artisan migrate` — no `--force`, no `--database`

Laraxot auto-discovers migrations from **all modules** via their ServiceProviders.
A generic `php artisan migrate` runs them in the correct dependency order
(Xot → Tenant → User → Gdpr → …). This is critical because:

- **Cross-module dependencies**: Gdpr tables reference `users` (from User module).
  Running `--database=gdpr` alone would miss the `users` table creation.
- **No `--force`**: `APP_ENV=testing` is not `"production"`, so Laravel allows
  migrations without `--force`. Using `--force` is unnecessary and masks environment
  misconfiguration.
- **Single source of truth**: the framework's migration discovery is the canonical
  ordering. Manually specifying modules duplicates logic and breaks when new modules
  are added.

## Test Structure

```
Modules/Gdpr/tests/
├── Feature/
│   ├── RegisterWidgetTest.php     # Registration flow + Action classes
│   ├── GdprBusinessLogicTest.php  # Consent/Treatment/Event CRUD
│   └── ConflictResolutionTest.php # Conflict resolution logic
├── Unit/
│   └── Models/                    # Model unit tests
├── TestCase.php                   # Base test case (see rules above)
└── Pest.php                       # Pest config and custom expectations
```

## TestCase Configuration

```php
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;  // NOT RefreshDatabase

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate');  // Generic, no --force, no --database
            self::$migrated = true;
        }
    }
}
```

The `$migrated` static flag ensures migrations run only once per test suite execution,
not once per test class.

## Running Tests

```bash
# From the laravel/ directory:

# Run all GDPR module tests
./vendor/bin/pest Modules/Gdpr/tests

# Run only the registration tests
./vendor/bin/pest Modules/Gdpr/tests/Feature/RegisterWidgetTest.php

# Run with verbose output
./vendor/bin/pest Modules/Gdpr/tests --verbose

# Run via artisan (uses phpunit.xml which includes Modules testsuite)
php artisan test --testsuite=Modules
```

## What RegisterWidgetTest Covers

| Test | What it verifies |
| ---- | ---------------- |
| ValidateGdprConsentAction passes | Both privacy + terms accepted → no exception |
| ValidateGdprConsentAction fails (privacy) | Missing privacy → ValidationException |
| ValidateGdprConsentAction fails (terms) | Missing terms → ValidationException |
| CollectGdprConsentsAction | Returns correct bool map |
| ValidateUserDataAction | Hashes password, sets `customer_user` type |
| SaveGdprConsentsAction | Creates Consent rows linked to Treatment records |
| Full pipeline | Validate → Create user → Collect → Save consents |
| Translation keys | All keys used in Blade views resolve (not raw key) |

## Writing New Tests

1. Use **Pest functional syntax** (`it()`, `test()`), never PHPUnit class-based
2. Add `uses(TestCase::class)` at the top of each test file
3. Use `User::factory()->create()` for test users
4. Use `Treatment::firstOrCreate()` for treatments (idempotent)
5. Use `uniqid()` in emails to avoid unique constraint collisions
6. Never call `->label()`, `->placeholder()`, `->helperText()` in Filament components

## Quality Checks

```bash
# PHPStan (use config from phpstan.neon, never pass --level)
./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=-1

# Pest with coverage
./vendor/bin/pest Modules/Gdpr/tests --coverage
```

## Backlinks

- [testing-rules.md](testing-rules.md) — Project-wide testing rules
- [testcase-sqlite-to-mysql-fix.md](testcase-sqlite-to-mysql-fix.md) — Migration from SQLite to MySQL
- [Themes/Meetup/docs/replikate/register.md](../../../Themes/Meetup/docs/replikate/register.md) — Register page design docs

