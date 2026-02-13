# Database Testing Configuration for Meetup Theme

## CRITICAL: .env.testing Configuration

### ❌ WRONG APPROACH (NEVER DO THIS)

```bash
# WRONG - Do NOT invent new environment variables
NOTIFY_DB_DATABASE=laravelpizza_data_test
GEO_DB_DATABASE=laravelpizza_data_test
MEDIA_DB_DATABASE=laravelpizza_data_test
GDPR_DB_DATABASE=laravelpizza_data_test
MEETUP_DB_DATABASE=laravelpizza_meetup_test
# ... etc
```

**Why this is wrong:**
1. These variables do NOT exist in the main `.env` file
2. Inventing new variables creates confusion and maintenance problems
3. Violates the "copy carbon" principle
4. TenantServiceProvider does NOT use these variables
5. Breaks consistency between development and testing environments

### ✅ CORRECT APPROACH

The `.env.testing` file must be a **COPY CARBON** of `.env` with **ONLY "_test"** added to database names:

```bash
# If .env has:
DB_DATABASE=laravelpizza_data
DB_DATABASE_USER=laravelpizza_user

# Then .env.testing must have:
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test
DB_CONNECTION=mysql  # Keep same as .env
APP_ENV=testing       # Only APP_ENV changes

# EVERYTHING ELSE IS IDENTICAL!
```

## How It Works

1. **Environment Variable Reading**: TenantServiceProvider reads `DB_DATABASE` from `.env.testing`
2. **Dynamic Connection Management**: Creates connections for each module automatically:
   - `user` → `laravelpizza_data_test`
   - `gdpr` → `laravelpizza_data_test`
   - `meetup` → `laravelpizza_data_test`
   - All modules share the same test database
3. **Automatic Migration**: `php artisan migrate` works on the test database
4. **No Manual Configuration Required**: Everything works via env variables

## Testing Workflow for Meetup Theme

```bash
# 1. Ensure .env.testing is correct
cd laravel
cp .env .env.testing
# Edit .env.testing:
#   - Change DB_DATABASE: laravelpizza_data -> laravelpizza_data_test
#   - Change DB_DATABASE_USER: laravelpizza_user -> laravelpizza_user_test
#   - Change APP_ENV: local -> testing

# 2. Run migrations (only if needed, tests use DatabaseTransactions)
php artisan migrate --env=testing

# 3. Run tests
php artisan test --env=testing

# 4. For specific module tests
php artisan test --env=testing --filter=RegisterPageTest
```

## Meetup Theme Tests

### Testing Registration Page

```php
// ✅ CORRECT - Just use Pest helpers
it('renders registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Create Your FREE Account');
});

it('submits registration form', function () {
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

### Testing Multi-language Pages

```php
// ✅ CORRECT - Test different locales
it('renders Italian registration page', function () {
    get('/it/auth/register')
        ->assertStatus(200)
        ->assertSee('Unisciti alla Pizza Revolution');
});

it('renders English registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Join the Pizza Revolution');
});
```

## Key Principles

1. **Copy Carbon Principle**: `.env.testing` = `.env` + `"_test"` on database names
2. **No Invented Variables**: Never create environment variables that don't exist in `.env`
3. **No Forced Connections**: Never use `config()` to override database connections in tests
4. **Automatic Configuration**: Let TenantServiceProvider handle connection management
5. **Single Test Database**: All modules share the same test database (suffixed with `_test`)
6. **Environment Consistency**: Testing environment should mirror development as closely as possible

## Common Mistakes

### Mistake 1: Creating Module-Specific Env Variables

```bash
# ❌ WRONG
GDPR_DB_DATABASE=laravelpizza_gdpr_test
MEETUP_DB_DATABASE=laravelpizza_meetup_test

# ✅ CORRECT
DB_DATABASE=laravelpizza_data_test  # Single database for all modules
```

### Mistake 2: Forcing Connections in Tests

```php
// ❌ WRONG
config(['database.connections.gdpr' => config('database.connections.mysql')]);

// ✅ CORRECT
// Do nothing! TenantServiceProvider handles it automatically
```

### Mistake 3: Running Migrations on Production Database

```bash
# ❌ WRONG - Uses production database
php artisan migrate

# ✅ CORRECT - Explicitly specify testing environment
php artisan migrate --env=testing
```

## Related Documentation

- [Testing Guidelines](../Gdpr/docs/testing-guidelines.md)
- [Multi-Language Translation Guidelines](./multi-language-translation-guidelines.md)
- [Register Page Testing](../Gdpr/docs/register-page-testing.md)

## Troubleshooting

### Problem: Tests fail with "Database connection not configured"

**Solution**: Ensure `.env.testing` exists and has correct `DB_DATABASE` value with `_test` suffix.

### Problem: Tests using production database

**Solution**: 
1. Verify `APP_ENV=testing` in `.env.testing`
2. Check that `DB_DATABASE` has `_test` suffix
3. Run tests with `--env=testing` flag

### Problem: Module-specific tables not found

**Solution**: This is normal. TenantServiceProvider creates module connections automatically using the same test database.

### Problem: Migrations not running in tests

**Solution**: Tests use `DatabaseTransactions` trait, so migrations run once per test session. If you need fresh migrations, run `php artisan migrate:fresh --env=testing`.

## Testing Best Practices for Meetup Theme

1. **Use Pest HTTP Helpers**: Always use `get()`, `post()`, `put()`, `delete()` instead of making direct HTTP requests
2. **Test All Locales**: Test registration page in all supported languages (it, en, de, es, fr, ru)
3. **Test Mobile Layout**: Ensure tests cover mobile viewport scenarios
4. **Test Form Validation**: Verify all validation rules work correctly
5. **Test Consents**: Ensure GDPR consents are properly validated
6. **Use Factories**: Use model factories instead of creating data manually
7. **Clean Database**: Use `DatabaseTransactions` trait for automatic cleanup