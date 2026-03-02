# Test-Driven Development (TDD) in Laravel Modules with Pest

> **CRITICAL RULE**: This document provides the complete TDD workflow for Laravel Modules using Pest PHP. Follow these patterns EXACTLY for 100% test coverage.

## 1. Overview

TDD in Laravel Modules follows the **Red-Green-Refactor** cycle:
1. **RED**: Write a test that fails
2. **GREEN**: Write minimal code to pass the test
3. **REFACTOR**: Improve code while keeping tests green

### Key Principles
- **Test First**: Always write tests before implementation
- **100% Coverage**: All code paths must be tested
- **Module Isolation**: Each module has independent test suite
- **No RefreshDatabase**: Use `DatabaseTransactions` or manual cleanup
- **Mock External Services**: OAuth, APIs, external dependencies

## 2. Environment Setup

### 2.1 Install Pest and Dependencies

```bash
cd laravel/

# Install Pest with Laravel plugin
composer require pestphp/pest-plugin-laravel --dev

# Install coverage driver
composer require pcov/clobber --dev

# Initialize Pest in module
cd Modules/User/
../../vendor/bin/pest --init
```

### 2.2 Module Test Directory Structure

```
Modules/User/
├── tests/
│   ├── Feature/              # Functional tests
│   │   ├── OAuthTest.php
│   │   ├── UserRegistrationTest.php
│   │   └── AuthenticationTest.php
│   ├── Unit/                 # Unit tests
│   │   ├── Actions/
│   │   │   ├── CreateUserActionTest.php
│   │   │   └── UpdateUserActionTest.php
│   │   ├── Models/
│   │   │   └── UserTest.php
│   │   └── Services/
│   │       └── OAuthServiceTest.php
│   ├── Pest.php              # Pest configuration
│   └── TestCase.php          # Module-specific TestCase
├── composer.json
└── module.json
```

### 2.3 Module TestCase Configuration

Create `Modules/User/tests/TestCase.php`:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Load module service providers
        $this->app->register(UserServiceProvider::class);
        
        // Run module migrations
        $this->artisan('module:migrate', ['module' => 'User']);
    }

    protected function tearDown(): void
    {
        // Clean up after tests
        $this->artisan('module:migrate:rollback', ['module' => 'User']);
        
        parent::tearDown();
    }
}
```

## 3. Red-Green-Refactor Cycle

### 3.1 Step 1: RED - Write Failing Test

```php
// Modules/User/tests/Feature/OAuthTest.php

use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;

it('can create user with Microsoft OAuth', function () {
    // Arrange: Mock Socialite response
    $socialiteUser = Mockery::mock(SocialiteUser::class);
    $socialiteUser->shouldReceive('getId')->andReturn('ms-12345');
    $socialiteUser->shouldReceive('getEmail')->andReturn('test@example.com');
    $socialiteUser->shouldReceive('getName')->andReturn('Test User');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://avatar.url');
    
    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);
    
    // Act: Simulate OAuth callback
    $response = $this->get('/auth/microsoft/callback?code=test123&state=valid123');
    
    // Assert: User created and redirected
    $response->assertRedirect('/dashboard');
    
    $this->assertDatabaseHas('users', [
        'microsoft_id' => 'ms-12345',
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
    
    $this->assertAuthenticated();
})->group('oauth');
```

### 3.2 Step 2: GREEN - Write Minimal Code

```php
// Modules/User/Actions/CreateUserFromOAuthAction.php

<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Laravel\Socialite\Two\User as SocialiteUser;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

class CreateUserFromOAuthAction
{
    use QueueableAction;

    public function execute(SocialiteUser $socialiteUser): User
    {
        return User::create([
            'microsoft_id' => $socialiteUser->getId(),
            'email' => $socialiteUser->getEmail(),
            'name' => $socialiteUser->getName(),
            'avatar' => $socialiteUser->getAvatar(),
        ]);
    }
}
```

```php
// Modules/User/Http/Controllers/OAuthController.php

<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Actions\CreateUserFromOAuthAction;

class OAuthController extends Controller
{
    public function redirectToMicrosoft(): RedirectResponse
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback(): RedirectResponse
    {
        $socialiteUser = Socialite::driver('microsoft')->user();
        
        $user = app(CreateUserFromOAuthAction::class)->execute($socialiteUser);
        
        auth()->login($user);
        
        return redirect()->intended('/dashboard');
    }
}
```

### 3.3 Step 3: REFACTOR - Improve Code

```php
// Modules/User/Actions/CreateUserFromOAuthAction.php (Refactored)

<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Two\User as SocialiteUser;
use Modules\Activity\Actions\LogActivityAction;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

class CreateUserFromOAuthAction
{
    use QueueableAction;

    public function __construct(
        private LogActivityAction $logActivityAction
    ) {}

    public function execute(SocialiteUser $socialiteUser): User
    {
        return DB::transaction(function () use ($socialiteUser) {
            // Check if user already exists
            $user = User::where('microsoft_id', $socialiteUser->getId())->first();
            
            if ($user) {
                $this->logActivityAction->execute("User logged in via OAuth: {$user->email}");
                return $user;
            }
            
            // Create new user
            $user = User::create([
                'microsoft_id' => $socialiteUser->getId(),
                'email' => $socialiteUser->getEmail(),
                'name' => $socialiteUser->getName(),
                'avatar' => $socialiteUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
            
            $this->logActivityAction->execute("New user created via OAuth: {$user->email}");
            
            return $user;
        });
    }
}
```

## 4. Testing Best Practices for Modules

### 4.1 NEVER Use RefreshDatabase

```php
// ❌ WRONG - Causes issues with multi-database modules
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; // BANNED in Laravel Modules
}

// ✅ CORRECT - Use DatabaseTransactions
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions; // ✅ Allowed
}

// ✅ CORRECT - Manual setup/teardown
class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup specific test data
    }
    
    protected function tearDown(): void
    {
        // Clean up test data
        parent::tearDown();
    }
}
```

### 4.2 Mock External Services

```php
// Modules/User/tests/Unit/Services/OAuthServiceTest.php

use Mockery;
use Laravel\Socialite\Facades\Socialite;

it('can refresh Microsoft token', function () {
    // Mock HTTP client
    $mockResponse = [
        'access_token' => 'new-access-token',
        'refresh_token' => 'new-refresh-token',
        'expires_in' => 3600,
    ];
    
    Http::fake([
        'https://login.microsoftonline.com/*' => Http::response($mockResponse, 200),
    ]);
    
    $service = new OAuthService();
    $token = $service->refreshToken('old-refresh-token');
    
    expect($token)->toBe('new-access-token');
    expect($service->getRefreshToken())->toBe('new-refresh-token');
})->group('oauth');
```

### 4.3 Test Queueable Actions

```php
// Modules/User/tests/Unit/Actions/CreateUserActionTest.php

use Modules\User\Actions\CreateUserAction;
use Modules\User\Models\User;

it('can create user via action', function () {
    $action = app(CreateUserAction::class);
    
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ];
    
    $user = $action->execute($userData);
    
    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
    
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
```

### 4.4 Feature Tests for Filament Resources

```php
// Modules/User/tests/Feature/Filament/Resources/UserResourceTest.php

use Filament\Facades\Filament;
use Modules\User\Filament\Resources\UserResource;

it('can render user list page', function () {
    $this->actingAs(User::factory()->create());
    
    $this->get(UserResource::getUrl('index'))
        ->assertSuccessful();
});

it('can create user via Filament resource', function () {
    $this->actingAs(User::factory()->create());
    
    $newData = [
        'name' => 'New User',
        'email' => 'new@example.com',
        'password' => 'password123',
    ];
    
    livewire(UserResource\Pages\CreateUser::class)
        ->fillForm($newData)
        ->call('create')
        ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('users', [
        'email' => 'new@example.com',
    ]);
});
```

## 5. Coverage Analysis

### 5.1 Generate Coverage Reports

```bash
# Generate HTML coverage report
cd laravel/
./vendor/bin/pest --coverage --coverage-html coverage/

# Generate CLI coverage with threshold
./vendor/bin/pest --coverage --min=100

# Module-specific coverage
./vendor/bin/pest Modules/User/tests --coverage --min=100

# Coverage with filter
./vendor/bin/pest --filter="OAuth" --coverage
```

### 5.2 Coverage Configuration

Create `phpunit.xml` in module root:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/10.5/phpunit.xsd"
         bootstrap="../../vendor/autoload.php"
         colors="true"
         failOnRisky="true"
         failOnWarning="true">
    <testsuites>
        <testsuite name="User Module Test Suite">
            <directory suffix="Test.php">./tests</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory suffix=".php">./app</directory>
        </include>
    </source>
    <coverage>
        <report>
            <html outputDirectory="./coverage"/>
            <text outputFile="php://stdout"/>
        </report>
    </coverage>
</phpunit>
```

## 6. Continuous TDD Workflow

### 6.1 Development Cycle

```bash
# 1. Write failing test (RED)
./vendor/bin/pest --filter="test_name"

# 2. Write minimal implementation
# 3. Run test until green (GREEN)
./vendor/bin/pest

# 4. Refactor with confidence
./vendor/bin/pint                    # Format code
./vendor/bin/phpstan analyse         # Static analysis
./vendor/bin/pest                    # Verify tests still pass

# 5. Commit with descriptive message
git add .
git commit -m "feat: implement OAuth with TDD

- Add CreateUserFromOAuthAction
- Implement Microsoft OAuth callback
- Achieve 100% test coverage
- Follow Red-Green-Refactor cycle"
git push
```

### 6.2 Pre-commit Hook

Create `.git/hooks/pre-commit`:

```bash
#!/bin/bash

# Run tests
cd laravel/
./vendor/bin/pest

# Check coverage
./vendor/bin/pest --coverage --min=100

# Run code quality tools
./vendor/bin/pint --test
./vendor/bin/phpstan analyse --memory-limit=-1

# If any command fails, prevent commit
if [ $? -ne 0 ]; then
    echo "❌ Tests or code quality checks failed. Commit aborted."
    exit 1
fi

echo "✅ All checks passed. Ready to commit."
exit 0
```

## 7. Common TDD Patterns

### 7.1 Test Data Factories

```php
// Modules/User/database/factories/UserFactory.php

use Modules\User\Models\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'microsoft_id' => $faker->unique()->uuid,
    ];
});
```

### 7.2 Helper Functions

```php
// Modules/User/tests/Pest.php

use Modules\User\Models\User;

function createUser(array $attributes = []): User
{
    return User::factory()->create($attributes);
}

function actingAsUser(User $user = null): User
{
    $user = $user ?? createUser();
    
    test()->actingAs($user);
    
    return $user;
}
```

### 7.3 Custom Assertions

```php
// Modules/User/tests/Pest.php

expect()->extend('toBeOAuthUser', function () {
    expect($this->value)
        ->toBeInstanceOf(User::class)
        ->microsoft_id->not->toBeNull()
        ->email_verified_at->not->toBeNull();
    
    return $this;
});

// Usage in test
it('creates verified user via OAuth', function () {
    $user = app(CreateUserFromOAuthAction::class)->execute($socialiteUser);
    
    expect($user)->toBeOAuthUser();
});
```

## 8. Testing OAuth Flows

### 8.1 Complete OAuth Integration Test

```php
// Modules/User/tests/Feature/OAuthIntegrationTest.php

describe('Microsoft OAuth Integration', function () {
    beforeEach(function () {
        $this->socialiteUser = Mockery::mock(SocialiteUser::class);
        $this->socialiteUser->shouldReceive('getId')->andReturn('ms-'.fake()->uuid());
        $this->socialiteUser->shouldReceive('getEmail')->andReturn(fake()->email());
        $this->socialiteUser->shouldReceive('getName')->andReturn(fake()->name());
        $this->socialiteUser->shouldReceive('getAvatar')->andReturn('https://avatar.url');
    });
    
    it('handles successful first-time login', function () {
        Socialite::shouldReceive('driver->user')->andReturn($this->socialiteUser);
        
        $response = $this->get('/auth/microsoft/callback?code=test&state=valid');
        
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        
        expect(User::where('microsoft_id', $this->socialiteUser->getId())->exists())->toBeTrue();
    });
    
    it('handles returning user login', function () {
        // Create existing user
        $existingUser = User::factory()->create([
            'microsoft_id' => $this->socialiteUser->getId(),
            'email' => $this->socialiteUser->getEmail(),
        ]);
        
        Socialite::shouldReceive('driver->user')->andReturn($this->socialiteUser);
        
        $response = $this->get('/auth/microsoft/callback?code=test&state=valid');
        
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($existingUser);
        
        // No new user created
        expect(User::count())->toBe(1);
    });
    
    it('validates state parameter to prevent CSRF', function () {
        $response = $this->get('/auth/microsoft/callback?code=test&state=invalid');
        
        $response->assertSessionHasErrors('state');
        $this->assertGuest();
    });
});
```

## 9. Performance Testing

### 9.1 Benchmark Tests

```php
// Modules/User/tests/Benchmark/PerformanceTest.php

use Modules\User\Actions\CreateUserFromOAuthAction;

it('creates user in under 500ms', function () {
    $action = app(CreateUserFromOAuthAction::class);
    
    $start = microtime(true);
    
    $user = $action->execute($this->socialiteUser);
    
    $duration = (microtime(true) - $start) * 1000; // Convert to milliseconds
    
    expect($duration)->toBeLessThan(500);
});
```

### 9.2 Memory Usage Tests

```php
it('does not leak memory on multiple OAuth logins', function () {
    $initialMemory = memory_get_usage();
    
    foreach (range(1, 100) as $i) {
        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn("ms-{$i}");
        $socialiteUser->shouldReceive('getEmail')->andReturn("user{$i}@example.com");
        $socialiteUser->shouldReceive('getName')->andReturn("User {$i}");
        
        Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);
        
        $this->get('/auth/microsoft/callback?code=test&state=valid');
    }
    
    $finalMemory = memory_get_usage();
    $memoryIncrease = ($finalMemory - $initialMemory) / 1024 / 1024; // MB
    
    expect($memoryIncrease)->toBeLessThan(10); // Less than 10MB increase
});
```

## 10. Documentation and Maintenance

### 10.1 Document Test Patterns

Always document complex test patterns in module docs:

```markdown
# Modules/User/docs/testing/oauth-patterns.md

## OAuth Testing Patterns

### Mocking Socialite Users

```php
function mockSocialiteUser(array $attributes = []): SocialiteUser
{
    $user = Mockery::mock(SocialiteUser::class);
    $user->shouldReceive('getId')->andReturn($attributes['id'] ?? fake()->uuid());
    $user->shouldReceive('getEmail')->andReturn($attributes['email'] ?? fake()->email());
    $user->shouldReceive('getName')->andReturn($attributes['name'] ?? fake()->name());
    
    return $user;
}
```
```

### 10.2 Keep Tests Maintainable

- **DRY**: Use helper functions and shared setup
- **Descriptive Names**: `it('can create user with valid OAuth credentials')`
- **Group Related Tests**: Use Pest `describe()` and `group()`
- **Comment Complex Logic**: Explain WHY, not WHAT
- **Regular Refactoring**: Keep tests clean and readable

## 11. Troubleshooting

### 11.1 Common Issues

**Issue**: Tests fail with "Serialization of 'Closure' is not allowed"
- **Solution**: Avoid using closures in test properties. Use methods instead.

**Issue**: Coverage report shows 0% for some files
- **Solution**: Ensure `phpunit.xml` includes correct source directories

**Issue**: Tests pass individually but fail when run together
- **Solution**: Check for test pollution. Use `setUp()`/`tearDown()` properly.

### 11.2 Debug Failing Tests

```bash
# Run single test with verbose output
./vendor/bin/pest --filter="test_name" -v

# Stop on first failure
./vendor/bin/pest --stop-on-failure

# Generate code coverage for failing test
./vendor/bin/pest --filter="test_name" --coverage
```

## 12. Resources

### 12.1 Official Documentation
- [Laravel Testing](https://laravel.com/docs/12.x/testing)
- [Pest PHP](https://pestphp.com/docs/installation)
- [Laravel Modules Testing](https://laravelmodules.com/docs/12/advanced/tests)
- [Laravel Socialite](https://laravel.com/docs/12.x/socialite)

### 12.2 TDD Learning Resources
- [Laracasts: Build a Laravel App with TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd)
- [Test-Driven Laravel Course](https://course.testdrivenlaravel.com/)

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-23  
**Maintained By**: AI Agent - Laravel Modules TDD Specialist