# TestCase setUp() Database Configuration Rule

## CRITICAL RULE: NEVER Duplicate Database Configuration in setUp()

The `CreatesApplication` trait automatically configures ALL module database connections. **DO NOT** duplicate this logic in your TestCase's `setUp()` method.

## ❌ WRONG PATTERN (NEVER DO THIS!)

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ COMPLETAMENTE SBAGLIATO!
    // CreatesApplication::createApplication() lo fa già!
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

    // ❌ Anche questo è ridondante!
    \Illuminate\Support\Facades\DB::purge('notify');
    \Illuminate\Support\Facades\DB::purge('mysql');

    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

## ✅ CORRECT PATTERN

```php
protected function setUp(): void
{
    parent::setUp();

    config(['xra.pub_theme' => 'Meetup']);
    config(['xra.main_module' => 'User']);

    \Modules\Xot\Datas\XotData::make()->update([
        'pub_theme' => 'Meetup',
        'main_module' => 'User',
    ]);

    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

## Why This Rule is Critical

### 1. CreatesApplication Already Handles It

The `CreatesApplication` trait (located in `Modules/Xot/tests/CreatesApplication.php`) automatically configures ALL module connections:

```php
$moduleConnections = [
    'user', 'notify', 'geo', 'media', 'job', 'xot',
    'activity', 'cms', 'gdpr', 'lang', 'meetup', 'seo', 'tenant',
];

foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
```

### 2. Duplicating Causes Errors

Duplicating database configuration in `setUp()` can cause:
- **Conflicts**: Multiple configurations fighting each other
- **Initialization failures**: Errors like "Call to a member function connection() on null"
- **Test instability**: Tests failing randomly
- **Maintenance nightmares**: Hard to track which configuration is active

### 3. Violates DRY Principle

This is a classic DRY (Don't Repeat Yourself) violation:
- Same logic in two places (`CreatesApplication` and `setUp()`)
- Harder to maintain
- Error-prone

### 4. Breaks Architecture

Laraxot architecture relies on:
- Centralized configuration management
- Dynamic connection creation via `TenantServiceProvider`
- Environment-specific settings via `.env.testing`

Duplicating breaks this architecture.

## What setUp() SHOULD Do

The `setUp()` method in your TestCase should only:

1. **Configure theme and module settings**:
   ```php
   config(['xra.pub_theme' => 'Meetup']);
   config(['xra.main_module' => 'User']);
   ```

2. **Update XotData**:
   ```php
   \Modules\Xot\Datas\XotData::make()->update([
       'pub_theme' => 'Meetup',
       'main_module' => 'User',
   ]);
   ```

3. **Run migrations** (once per test suite):
   ```php
   if (! self::$migrated) {
       $this->artisan('migrate:fresh', ['--force' => true]);
       $this->artisan('module:migrate', ['--force' => true]);
       self::$migrated = true;
   }
   ```

That's it! No database configuration needed.

## Related Rules

### .env.testing Rule

`.env.testing` must be a **COPY CARBON** of `.env` with **ONLY "_test"** added to database names:

```bash
# .env
DB_DATABASE=laravelpizza_data

# .env.testing
DB_DATABASE=laravelpizza_data_test  # Only add "_test"!
```

**NEVER** invent variables like:
```bash
# ❌ WRONG - These don't exist in .env!
NOTIFY_DB_DATABASE=laravelpizza_data_test
GEO_DB_DATABASE=laravelpizza_data_test
```

### NEVER Use RefreshDatabase

```php
// ❌ WRONG
use RefreshDatabase;

// ✅ CORRECT
use DatabaseTransactions;
```

## Testing Best Practices

### Use Pest HTTP Helpers Directly

```php
// ✅ CORRECT - Let the framework handle connections
it('renders the registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Create Your FREE Account');
});

it('allows user registration', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302);
});
```

### Never Call config() for Database Connections

```php
// ❌ WRONG - Don't do this in tests!
config(['database.connections.notify' => config('database.connections.mysql')]);

// ❌ WRONG - Don't purge connections in setUp()!
\Illuminate\Support\Facades\DB::purge('notify');
```

## Summary

**ONE SIMPLE RULE:**

> The `setUp()` method in TestCase must **ONLY** configure theme/module settings and run migrations. Database connections are **automatically** configured by `CreatesApplication` trait based on `.env.testing`. **NEVER** duplicate this logic!

**Memory Aid:**

> CreatesApplication = Auto-configure all connections
> setUp() = Theme/module config + migrations only
> .env.testing = Copy of .env with "_test" suffix only

## References

- [CreatesApplication Trait](../../Modules/Xot/tests/CreatesApplication.php)
- [Environment Development vs Testing Rules](../../modules/xot/docs/environment-development-vs-testing-rules.md)
- [Database Testing Configuration](./database-testing-configuration.md)
- [Testing Best Practices](./testing-best-practices.md)