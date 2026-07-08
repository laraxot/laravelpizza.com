# Testing Guidelines

## Test Structure

Tests use **Pest** (BDD-style) for better readability.

```php
<?php

use Modules\User\Models\User;

test('can create user', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com');
});

it('validates user email', function () {
    $this->post('/users', [
        'name' => 'John',
        'email' => 'invalid-email',
    ])->assertSessionHasErrors('email');
});
```

## Test Organization

```
tests/
├── Feature/              # Feature tests
│   ├── UserTest.php
│   └── AuthTest.php
└── Unit/                 # Unit tests
    ├── UserServiceTest.php
    └── UserPolicyTest.php
```

Each module has its own `tests/` directory:
```
Modules/ModuleName/
└── tests/
    ├── Feature/
    └── Unit/
```

## Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/UserTest.php

# Filter tests by name
php artisan test --filter=user_can_reset_password

# Run with coverage
php artisan test --coverage

# Pest testing
./vendor/bin/pest
./vendor/bin/pest --filter=UserTest
```

## Testing Best Practices

### 1. Use Descriptive Test Names
```php
// ✅ GOOD
test('user can reset password with valid token');
test('admin can delete other users but not themselves');

// ❌ BAD
test('test1');
test('user_test');
```

### 2. Use Factories for Test Data
```php
// ✅ GOOD
$user = User::factory()->create(['email' => 'test@example.com']);

// ❌ BAD
$user = new User();
$user->email = 'test@example.com';
$user->save();
```

### 3. Test Filament Resources
```php
test('can view user resource', function () {
    $user = User::factory()->create();
    
    $this->get(UserResource::getUrl('view', ['record' => $user]))
        ->assertSuccessful();
});

test('can create user via resource', function () {
    Livewire::test(CreateUser::class)
        ->fillForm(['name' => 'John', 'email' => 'john@example.com'])
        ->call('create')
        ->assertHasNoErrors();
});
```

### 4. Test Actions
```php
test('create user action works', function () {
    $userData = new UserData(name: 'John', email: 'john@example.com');
    
    $user = app(CreateUserAction::class)->execute($userData);
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('John');
});
```