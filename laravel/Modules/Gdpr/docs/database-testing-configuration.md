# Database Testing Configuration for GDPR Module

## CRITICAL: .env.testing Configuration

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

The `.env.testing` file must be a **COPY CARBON** of `.env` with **ONLY "_test"** added to database names:

```bash
# If .env has:
DB_DATABASE=laravelpizza_data
DB_DATABASE_USER=laravelpizza_user

# Then .env.testing must have:
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test

# EVERYTHING ELSE IS IDENTICAL!
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
$defaultConfig = $app['config']->get('database.connections.mysql');
$moduleConnections = ['user', 'notify', 'geo', 'media', ...];
foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
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

1. **Copy Carbon Principle**: `.env.testing` = `.env` + `"_test"` on database names
2. **No Invented Variables**: Never create environment variables that don't exist in `.env`
3. **No Forced Connections**: Never use `config()` to override database connections in tests
4. **Automatic Configuration**: Let TenantServiceProvider handle connection management
5. **Single Test Database**: All modules share the same test database (suffixed with `_test`)

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