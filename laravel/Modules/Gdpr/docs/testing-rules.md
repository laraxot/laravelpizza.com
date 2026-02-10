# Testing Rules - GDPR Module

## Fundamental Rules

### 1. Pest Testing Mandatory
- **NEVER** use PHPUnit class-based (`class Test extends TestCase`)
- **ALWAYS** use Pest functional syntax (`test()`, `it()`, `describe()`)

### 2. MySQL Only — NEVER SQLite
- **NEVER** use SQLite in-memory for tests
- **ALWAYS** use MySQL via `.env.testing`
- The project uses multiple named DB connections (user, gdpr, xot, tenant, etc.)
- SQLite cannot replicate this multi-connection topology
- MySQL guarantees the same engine, charset, collation, and foreign-key behaviour as production

### 3. DatabaseTransactions — NEVER RefreshDatabase
- **NEVER** use `RefreshDatabase` trait
- **ALWAYS** use `DatabaseTransactions`
- RefreshDatabase drops and recreates every table on each test class — extremely slow on MySQL and destroys seed data
- DatabaseTransactions wraps each test in a transaction and rolls back at the end — near-zero overhead

### 4. Generic `php artisan migrate` — No Flags
- **NEVER** use `--force` flag
- **NEVER** use `--database` to specify a single connection
- **ALWAYS** run generic `php artisan migrate`
- Laraxot auto-discovers migrations from ALL modules via their ServiceProviders
- A generic migrate runs them in the correct dependency order (Xot -> User -> Gdpr ...)
- Specifying `--database` per module would miss cross-module tables
- `--force` is unnecessary because APP_ENV=testing is not "production"

### 5. XotBase Extension
- **NEVER** extend Filament classes directly in tests
- **ALWAYS** extend `XotBase*` abstracts

### 6. `isset()` not `property_exists()`
- **NEVER** use `property_exists()` with Eloquent models
- **ALWAYS** use `isset()` for magic properties

## TestCase Structure

```php
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate');  // Generic, no flags
            self::$migrated = true;
        }
    }
}
```

**Why `static $migrated`?** Migrations only run once per test suite (not per test), since DatabaseTransactions rolls back data changes but doesn't drop tables.

## Test File Organization

```
Modules/Gdpr/tests/
├── Pest.php                              # Helpers, expectations, TestCase binding
├── TestCase.php                          # Base test case (MySQL + DatabaseTransactions)
├── Feature/
│   ├── RegisterWidgetTest.php            # Action-level tests for register pipeline
│   ├── RegistrationTest.php              # Integration tests for full registration flow
│   ├── GdprBusinessLogicTest.php         # CRUD tests for Consent, Treatment, Event
│   └── ConflictResolutionTest.php        # Model instantiation and property tests
└── Unit/
    └── Models/
        ├── BaseModelTest.php             # Base model properties (connection, timestamps)
        └── GdprConsentTest.php           # Consent model tests
        └── GdprConsentBusinessLogicTest.php # Consent business logic tests
```

## Running Tests

```bash
# From laravel/ directory
php artisan test --filter=Gdpr

# Or directly with Pest
cd Modules/Gdpr && ../../vendor/bin/pest

# Single test file
php artisan test Modules/Gdpr/tests/Feature/RegisterWidgetTest.php
```

## Common Mistakes to Avoid

| Mistake | Why it's wrong | Correct approach |
|---------|---------------|------------------|
| `RefreshDatabase` | Drops all tables per class, extremely slow | `DatabaseTransactions` |
| SQLite in-memory | Can't handle multi-connection topology | MySQL from `.env.testing` |
| `--database=gdpr` | Only migrates one connection | Generic `php artisan migrate` |
| `--force` | Unnecessary for APP_ENV=testing | Omit it |
| `assertDatabaseCount('users', 0)` | Fragile with pre-existing data | Use unique identifiers, query by specific attributes |
| HTTP POST to Livewire routes | Registration is Livewire, not a POST route | Test the Action pipeline directly |
| Referencing non-existent models | `GdprConsent` doesn't exist | Use `Consent`, `Treatment`, `Event`, `Profile` |
