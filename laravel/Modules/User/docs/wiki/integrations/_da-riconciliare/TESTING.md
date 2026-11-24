---
title: "User Module Testing"
type: guide
tags: [user, testing, pest]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — Testing

## Unit Tests

```php
test('user creation stores email hash', function () {
    $user = User::create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'name' => 'Test User',
    ]);

    expect($user->email)->toBe('test@example.com');
    expect(Hash::check('password123', $user->password))->toBeTrue();
});

test('user can assign role', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    expect($user->hasRole('admin'))->toBeTrue();
});
```

## Feature Tests

```php
test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('user cannot login with invalid password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('user can logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
```

## Test Factories

```php
// tests/Factories/UserFactory.php
User::factory()
    ->hasTeams(2)
    ->withRole('admin')
    ->create();
```

## Running Tests

```bash
php artisan test Modules/User/tests/
php artisan test Modules/User/tests/Feature/LoginTest.php --filter="test_user_can_login"
```
