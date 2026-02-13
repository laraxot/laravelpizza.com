# Database Testing Configuration for GDPR Module

## CRITICAL: Database Configuration Rules

**⚠️ LEGGI QUESTO PRIMA DI QUALSIASI MODIFICA ALLE CONFIGURAZIONI DATABASE:**

1. **MAI forzare le connessioni** con `config()` in CreatesApplication
2. **MAI inventare variabili environment** come `NOTIFY_DB_DATABASE`, `GDPR_DB_DATABASE`
3. **MAI aggiungere connessioni hardcode** in `config/database.php`
4. **MAI eseguire migrate in TestCase setUp()** - Vedi [TestCase Setup Rules](../Xot/docs/testcase-setup-critical-rules.md)

Vedi [Critical Rules](../Xot/docs/database-configuration-critical-rules.md) per dettagli completi.

## .env.testing Configuration (CRITICAL)

### ❌ WRONG APPROACH (NEVER DO THIS)

```bash
# WRONG - Do NOT invent new environment variables
NOTIFY_DB_DATABASE=laravelpizza_data_test
GEO_DB_DATABASE=laravelpizza_data_test
MEDIA_DB_DATABASE=laravelpizza_data_test
GDPR_DB_DATABASE=laravelpizza_data_test
# ... etc
```

**Why this is wrong:**
1. These variables do NOT exist in the main `.env` file
2. Inventing new variables creates confusion and maintenance problems
3. Violates the "copy carbon" principle
4. TenantServiceProvider does NOT use these variables

### ✅ CORRECT APPROACH

The `.env.testing` file must be a **COPY CARBON** of `.env` where the `DB_DATABASE` value has **ONLY "_test" appended** to the main database name:

```bash
# If .env has:
DB_DATABASE=your_main_db_name

# Then .env.testing must have:
DB_DATABASE=your_main_db_name_test

# For example, if your main database is `laravelpizza_data`:
DB_DATABASE=laravelpizza_data_test

# EVERYTHING ELSE IS IDENTICAL (excluding other DB_ values if they are related to the main DB,
# e.g., DB_USERNAME=root, DB_PASSWORD=your_password should be the same as in .env)
```

## How It Works

1. **Environment Variable Reading**: TenantServiceProvider reads `DB_DATABASE` from `.env.testing`
2. **Dynamic Connection Management**: Creates connections for each module automatically
3. **All modules use same test database**: No need for separate databases per module in testing
4. **Automatic migration**: `php artisan migrate` works on the test database

## CreatesApplication Pattern

### ❌ WRONG PATTERN (NEVER DO THIS)

```php
// WRONG - Forces all connections to mysql
// This completely destroys the dynamic connection management
config(['database.connections.notify' => config('database.connections.mysql')]);
config(['database.connections.geo' => config('database.connections.mysql')]);
config(['database.connections.media' => config('database.connections.mysql')]);
config(['database.connections.job' => config('database.connections.mysql')]);
config(['database.connections.activity' => config('database.connections.mysql')]);
config(['database.connections.cms' => config('database.connections.mysql')]);
config(['database.connections.lang' => config('database.connections.mysql')]);
config(['database.connections.meetup' => config('database.connections.mysql')]);
config(['database.connections.seo' => config('database.connections.mysql')]);
config(['database.connections.tenant' => config('database.connections.mysql')]);
```


**Why this is wrong:**
1. Destroys dynamic configuration system
2. Is REDUNDANT - env variables already configure everything
3. Violates Laraxot architecture
4. Creates technical debt

### ✅ CORRECT PATTERN

```php
// CORRECT - Let env variables handle everything
// NO config() calls needed!
// TenantServiceProvider reads DB_DATABASE from .env.testing
// and automatically configures all module connections
```

## Testing Workflow

```bash
# 1. Ensure .env.testing is correct (copy of .env with _test)
cd laravel
cp .env .env.testing
# Edit .env.testing: change laravelpizza_data -> laravelpizza_data_test

# 2. Run migrations (only if needed, use DatabaseTransactions in tests)
php artisan migrate --env=testing

# 3. Run tests
php artisan test --env=testing
```

## Database Connections in Tests

```php
// ✅ CORRECT - Just use Pest helpers
it('renders registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200);
});

// ✅ CORRECT - Database operations work automatically
it('creates user', function () {
    $user = User::factory()->create();
    expect($user->email)->not->toBeEmpty();
});
```

## Key Principles

1.  **Copy Carbon Principle**: `.env.testing` = `.env` + `"_test"` on main `DB_DATABASE`
2.  **No Invented Variables**: Never create environment variables that don't exist in `.env` (like `MODULE_DB_DATABASE`)
3.  **No Forced Connections**: Never use `config()` to override database connections in tests (e.g., `config(['database.connections.notify' => ...])`)
4.  **Automatic Configuration**: Let TenantServiceProvider handle connection management dynamically based on `DB_DATABASE`
5.  **Single Test Database**: All modules share the same test database (suffixed with `_test`)
6.  **No Migrations in setUp()**: NEVER run migrations in `TestCase::setUp()` or use static `$migrated` flag. Migrations are run ONCE externally: `php artisan migrate --env=testing`. DatabaseTransactions trait handles rollback automatically.

## TestCase Setup Rules

**CRITICAL**: See [TestCase Setup Critical Rules](../Xot/docs/testcase-setup-critical-rules.md) for complete details on test setup patterns.

❌ **WRONG Pattern in TestCase.php:**
```php
protected static bool $migrated = false;

protected function setUp(): void
{
    parent::setUp();
    // ... config ...
    if (! self::$migrated) {
        $this->artisan('module:migrate');  // WRONG!
        self::$migrated = true;             // WRONG!
    }
}
```

✅ **CORRECT Pattern in TestCase.php:**
```php
protected function setUp(): void
{
    parent::setUp();
    // ... config ...
    // NOTE: Migrations are NOT run in setUp()
    // They are run ONCE externally: php artisan migrate --env=testing
    // DatabaseTransactions trait handles rollback automatically
}
```


## Related Documentation

- [Testing Guidelines](./testing-guidelines.md)
- [Multi-Language Translation Guidelines](./multi-language-translation-guidelines.md)
- [TenantServiceProvider Architecture](../Tenant/app/Providers/TenantServiceProvider.php)

## Troubleshooting

### Problem: Tests can't find database tables

**Solution**: Ensure `.env.testing` has correct `DB_DATABASE` value with `_test` suffix.

### Problem: Connection "module_name" not configured

**Solution**: This is normal in testing. TenantServiceProvider will create it automatically using `DB_DATABASE` from `.env.testing`.

### Problem: Migrations running on wrong database

**Solution**: Check that `.env.testing` is not pointing to production database. Verify `APP_ENV=testing`.