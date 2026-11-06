---
title: "User: harness test e factory"
type: guide
module: User
tags: [user, testing, pest, harness]
created: 2026-07-28
updated: 2026-10-20
status: active
qmd: "user testing harness TestCase FQCN factory require skipUnless"
related:
  - ./00-index.md
  - ./testing.md
  - ./stories/phpstan-user-zero.story.md
  - ../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md
  - ../../Xot/docs/wiki/memories/phpstan-single-neon-config.md
---

<!-- gateguard: body moved from TESTING.md (UPPERCASE); not a duplicate topic. Linked from 00-INDEX Qualita'. Why new kebab name: avoid case collision with testing.md. User: "Fix UPPERCASE md except README" -->

# User: harness test e factory

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

## Harness dei test

- Base class: `Modules\User\Tests\TestCase` (estende `Modules\Xot\Tests\XotBaseTestCase`, usa `DatabaseTransactions`). I file Pest la agganciano con `uses(TestCase::class)`; `tests/Pest.php` la estende anche su `Feature` e `Unit`.
- Fixture condivise: `TestCase::requireUser()`, `requireOwner()`, `requireTeam()`, `requireTenant1()`, `requireDevice()`... restituiscono il valore tipizzato (non nullable) o falliscono con un messaggio chiaro; `createTestUser()` crea un utente con email unica.
- Skip dichiarati: `TestCase::skipUnlessUsersTableReady()`, `skipUnlessUserTable()`, `skipUnlessUserColumn()`, `skipUnlessDirectPermissionSupported()`... saltano il test se la tabella o la colonna manca sulla connessione `user`, invece di fallire.
- Helper globali (`createUser()`, `makeUser()`, `createTeam()`, `createTestUser()`...): `tests/Support/helpers.php`, caricato dall'autoload-dev del modulo. Non ridefinirli in `tests/Pest.php` ("Cannot redeclare").
- Database: regola di repo MySQL (repliche `*_test`), mai `RefreshDatabase` ne' `migrate:fresh` dai test. Le migration si lanciano una volta fuori dai test; `DatabaseTransactions` annulla le scritture. `TestCase::setUp()` ha ancora un ripiego su una fixture SQLite condivisa per gli ambienti senza MariaDB dedicata: e' debito noto, non un precedente.
- Un helper chiamato da un test e non definito in `TestCase` o in `tests/Support` va aggiunto li' una volta, tipizzato. Non si crea una `TestCase` alternativa (es. `Tests\TestCase` della radice) per aggirarlo.

## Test Factories

Le factory stanno in `database/factories/` (`Modules\User\Database\Factories\UserFactory`, `TeamFactory`...), non in `tests/`.

```php
$user = User::factory()->active()->verified()->create();
$team = Team::factory()->create();
```

`Model::factory()` restituisce la factory concreta e `->create()` il modello (`User`, `Team`), non `mixed`: il resolver registrato in `XotServiceProvider::registerFactoryNameResolver()` mappa `Modules\<Modulo>\Models\X` su `Modules\<Modulo>\Database\Factories\XFactory`, la stessa convenzione di `GetFactoryAction`. Non servono `assert($x instanceof User)` ne' `UserFactory::new()` per far tornare PHPStan. Stati disponibili su `UserFactory`: `active()`, `inactive()`, `verified()`, `unverified()`. Un modello senza file in `database/factories/` risolve alla `Factory` astratta e `->create()` e' un generico `Model`: PHPStan segnala come inesistenti le sue proprieta', e la correzione e' scrivere la factory (non un `assert`).

## Running Tests

```bash
php artisan test Modules/User/tests/
php artisan test Modules/User/tests/Feature/LoginTest.php --filter="test_user_can_login"
```
