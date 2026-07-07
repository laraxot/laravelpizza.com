# AGENTS Testing Standards

Standard e convenzioni per i test.

## Test Organization

```
tests/
├── Feature/           # End-to-end scenarios
├── Unit/             # Individual component tests
└── Modules/*/tests/   # Module-specific tests
```

---

## Pest Testing Format

```php
it('creates a user', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class);
    expect($user->email)->toBeString();
});

it('rejects invalid email', function () {
    $response = $this->post('/users', [
        'email' => 'invalid-email'
    ]);
    
    $response->assertSessionHasErrors('email');
});
```

---

## Filament Testing

```php
livewire(ListUsers::class)
    ->assertCanSeeTableRecords($users)
    ->searchTable($users->first()->name)
    ->assertCanSeeTableRecords($users->take(1));

livewire(CreateUser::class)
    ->fillForm(['name' => 'John'])
    ->call('create')
    ->assertNotified();
```

---

## Essential Commands

```bash
# Run all tests
php artisan test

# Run single test file
php artisan test tests/Feature/ExampleTest.php

# Run specific test
php artisan test --filter=test_name
```

---

## Quality Gates

Prima di ogni commit:

1. **PHPStan**: `vendor/bin/phpstan analyse`
2. **Pint**: `vendor/bin/pint --dirty`
3. **Test**: `php artisan test`

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [testing.md](./testing.md) - Più dettagliato
- [pest-testing.md](./pest-testing.md) - Guida Pest
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)
