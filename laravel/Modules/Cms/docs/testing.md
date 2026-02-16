# Cms Module Testing Guide

## Overview

This module follows the project's [testing guidelines](../docs/TESTING.md) and uses Pest PHP as the testing framework.

## Test Structure

```
tests/
  Feature/    # Feature tests
  Unit/       # Unit tests
  Pest.php    # Module-specific Pest configuration
  TestCase.php # Base test case for the module
```

## Writing Tests

### Authentication Tests

Authentication tests are located in `tests/Feature/Auth/`. These tests cover:

- User registration
- Login/logout
- Password reset
- Email verification
- Profile management

### Example Authentication Test

```php
test('users can login with valid credentials', function () {
    $user = User::factory()->create();
    
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});
```

## Running Tests

Run all Cms module tests:
```bash
./vendor/bin/pest Modules/Cms/tests
```

Run a specific test file:
```bash
./vendor/bin/pest Modules/Cms/tests/Feature/Auth/AuthenticationTest.php
```

## Best Practices

1. **Use Factories**: Always use factories to create test data
2. **Test Edge Cases**: Include tests for validation errors and edge cases
3. **Keep Tests Focused**: Each test should verify one specific behavior
4. **Use Descriptive Names**: Test names should clearly indicate what's being tested
