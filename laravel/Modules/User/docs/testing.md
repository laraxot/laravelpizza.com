# User Module Testing

## Overview
Testing standards and patterns for the User module, covering authentication, authorization, profiles, and team management.

## Testing Strategy

### Test Pyramid Implementation
- **Unit Tests**: Individual components (models, services, utilities)
- **Feature Tests**: Authentication flows, authorization checks
- **Integration Tests**: Cross-module integration with Tenant, Xot
- **Browser Tests**: UI interactions for login/registration

### Coverage Goals
- 100% coverage for authentication logic
- 90%+ coverage for authorization system  
- 85%+ coverage for profile management
- 80%+ coverage for team features

## Test Classes

### UserBaseTestCase
Base test case for User module tests:

```php
<?php

namespace Modules\User\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\User\Models\User;

abstract class UserBaseTestCase extends XotBaseTestCase
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
    
    protected function createAdminUser(): User
    {
        return User::factory()->admin()->create();
    }
    
    protected function assertUserHasRole(User $user, string $role): void
    {
        $this->assertTrue($user->hasRole($role));
    }
    
    protected function assertUserHasPermission(User $user, string $permission): void
    {
        $this->assertTrue($user->can($permission));
    }
}
```

## Testing Patterns

### Authentication Testing
```php
public function test_user_registration()
{
    $response = $this->postJson('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
}

public function test_user_login()
{
    $user = User::factory()->create(['password' => Hash::make('password')]);
    
    $response = $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    $response->assertStatus(200);
    $response->assertJson(['token' => true]);
}
```

### Authorization Testing
```php
public function test_role_based_access()
{
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();
    
    // Admin should have access
    $this->actingAs($admin);
    $response = $this->getJson('/admin/users');
    $response->assertStatus(200);
    
    // Regular user should be denied
    $this->actingAs($user);
    $response = $this->getJson('/admin/users');
    $response->assertStatus(403);
}

public function test_permission_checks()
{
    $user = User::factory()->create();
    $user->givePermissionTo('edit-posts');
    
    $this->assertTrue($user->can('edit-posts'));
    $this->assertFalse($user->can('delete-users'));
}
```

### Profile Testing
```php
public function test_profile_management()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->putJson('/api/profile', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
}
```

### Team Testing
```php
public function test_team_creation()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->postJson('/api/teams', [
            'name' => 'Development Team',
        ]);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('teams', ['name' => 'Development Team']);
    $this->assertTrue($user->fresh()->isOwnerOf(Team::first()));
}
```

## Test Data Factories

### UserFactory
```php
<?php

namespace Modules\User\Database\Factories;

use Modules\Xot\Database\Factories\XotBaseFactory;
use Modules\User\Models\User;

class UserFactory extends XotBaseFactory
{
    protected $model = User::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ];
    }
    
    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }
    
    public function unverified(): static
    {
        return $this->state(['email_verified_at' => null]);
    }
}
```

### TeamFactory
```php
<?php

namespace Modules\User\Database\Factories;

use Modules\Xot\Database\Factories\XotBaseFactory;
use Modules\User\Models\Team;

class TeamFactory extends XotBaseFactory
{
    protected $model = Team::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
        ];
    }
}
```

## Security Testing

### Authentication Security
```php
public function test_brute_force_protection()
{
    $user = User::factory()->create(['password' => Hash::make('password')]);
    
    // Multiple failed attempts
    for ($i = 0; $i < 5; $i++) {
        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }
    
    // Should be rate limited
    $response->assertStatus(429);
}

public function test_password_complexity()
{
    $response = $this->postJson('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'simple', // Too simple
        'password_confirmation' => 'simple',
    ]);
    
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['password']);
}
```

### Authorization Security
```php
public function test_permission_escalation()
{
    $user = User::factory()->create();
    
    // Attempt to assign admin role without permission
    $response = $this->actingAs($user)
        ->postJson('/api/users/1/roles', ['role' => 'admin']);
    
    $response->assertStatus(403);
}
```

## Performance Testing

### User Load Testing
```php
public function test_multiple_users_performance()
{
    // Create 1000 users
    User::factory()->count(1000)->create();
    
    // Test user listing performance
    $start = microtime(true);
    $response = $this->getJson('/api/users');
    $duration = microtime(true) - $start;
    
    $response->assertStatus(200);
    $this->assertLessThan(2.0, $duration); // Should complete in under 2 seconds
}
```

## Best Practices

### Test Isolation
- Each test should be independent
- Clean up test data after each test
- Use database transactions when possible

### Test Data
- Use factories for test data creation
- Avoid hardcoded values where possible
- Use realistic test data scenarios

### Assertion Clarity
- Use specific, descriptive assertions
- Provide clear failure messages
- Test one behavior per test method

### Security Focus
- Test authentication boundaries
- Verify authorization checks
- Validate input sanitization

## Continuous Integration

### GitHub Actions Example
```yaml
name: User Module Tests

on: [push, pull_request]

jobs:
  test-user-module:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.4'
        extensions: mbstring, xml, ctype, json, tokenizer, pdo_mysql
        coverage: xdebug
    
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
    
    - name: Setup environment
      run: |
        cp .env.testing .env
        php artisan key:generate
    
    - name: Run migrations
      run: php artisan migrate --env=testing
    
    - name: Run tests
      run: php artisan test --testsuite=Feature --group=user --coverage --min=85
```

---

*User Module Testing - Ensuring reliable and secure user management functionality*
*Testing del Modulo User: DRY + KISS + SOLID + ROBUST + LARAXOT*

