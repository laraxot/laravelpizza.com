---
title: "agents testing standards"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
qmd: "agents testing standards"
issues: []
discussions: []
---

# AGENTS Testing Standards

Standard e convenzioni per i test.

## Test Organization

```
tests/
├── Feature/           # End-to-end scenarios
├── Unit/             # Individual component tests
└── Modules/*/tests/   # Module-specific tests
```

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---

title: "agents testing standards"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "agents testing standards"
issues: []
discussions: []
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

<<<<<<< HEAD
=======
=======
## Pest Testing Format

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
=======
<<<<<<< HEAD
- [AGENTS.md originale](../../agents.md)
- [agents.md originale](../../agents.md)
=======
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- [AGENTS.md originale](../../agents.md)
- [agents.md originale](../../agents.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- [Index principale](./index.md)
