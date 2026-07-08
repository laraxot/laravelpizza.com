# Testing Guide for Laraxot Modules

## Introduzione

I test in Laraxot seguono le best practices di Laravel e Pest PHP. Ogni modulo dovrebbe avere una propria struttura di test organizzata in unit e feature test.

## Configurazione dell'Ambiente di Test

### File `.env.testing`
Il file `.env.testing` è usato per impostare le configurazioni specifiche per l'ambiente di test:

```
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
SESSION_DRIVER=array
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
```

### Struttura del TestCase
Ogni modulo dovrebbe avere un TestCase base nella cartella `tests/`:

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;  // Se hai bisogno di database
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase; // Rimuovi se non hai bisogno del database
}
```

## Tipi di Test

### Unit Test
I test unitari testano singole unità di codice come:
- Actions
- Services
- Data Transfer Objects
- Funzioni helper

### Feature Test
I test funzionali testano flussi completi come:
- API endpoints
- Interazioni tra componenti
- Business logic complessa

## Sintassi Pest PHP

### Test Semplici
```php
it('has a welcome page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
```

### Test con Setup
```php
describe('User authentication', function () {
    it('allows user to login', function () {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    });
});
```

### Test con Dati di Esempio
```php
dataset('user_types', [
    'admin' => ['type' => 'admin', 'permissions' => ['read', 'write', 'delete']],
    'editor' => ['type' => 'editor', 'permissions' => ['read', 'write']],
    'viewer' => ['type' => 'viewer', 'permissions' => ['read']],
]);

it('has correct permissions based on type', function ($type, $permissions) {
    $user = User::factory()->create(['type' => $type]);
    
    expect($user->permissions)->toBe($permissions);
})->with('user_types');
```

## Best Practices

### 1. DRY + KISS + SOLID + Robust
- **DRY**: Non duplicare logica di test
- **KISS**: Mantieni i test semplici e diretti
- **SOLID**: Segui principi SOLID nei componenti testati
- **Robust**: Gestisci eccezioni e casi limite

### 2. Naming Conventions
- Usa nomi descrittivi per i test
- Segui il formato Given-When-Then
- Mantieni i nomi in inglese

### 3. Struttura AAA (Arrange-Act-Assert)
```php
it('processes user data correctly', function () {
    // Arrange
    $user = User::factory()->create();
    $data = ['name' => 'John', 'email' => 'john@example.com'];

    // Act
    $result = $user->updateProfile($data);

    // Assert
    expect($result)
        ->toBeTrue()
        ->and($user->refresh()->name)
        ->toBe('John');
});
```

### 4. Isolamento dei Test
- Ogni test deve essere indipendente
- Usa `RefreshDatabase` o `DatabaseMigrations` se necessario
- Non fare affidamento su dati creati da altri test

### 5. Coverage del 100%
- Obiettivo: 100% di code coverage per ogni modulo
- Testa tutti i percorsi logici
- Testa anche i casi limite e le eccezioni

## Conversione da PHPUnit a Pest

### Vecchio stile (PHPUnit):
```php
class UserTest extends TestCase
{
    /** @test */
    public function user_can_be_created()
    {
        $response = $this->post('/users', [
            'name' => 'John',
            'email' => 'john@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John'
        ]);
    }
}
```

### Nuovo stile (Pest):
```php
it('user can be created', function () {
    $response = $this->post('/users', [
        'name' => 'John',
        'email' => 'john@example.com'
    ]);

    $response->assertDatabaseHas('users', [
        'name' => 'John'
    ]);
});
```

## Esecuzione dei Test

### Comandi Base
```bash
# Esegui tutti i test
./vendor/bin/pest

# Esegui test per un modulo specifico
./vendor/bin/pest Modules/User/tests/

# Esegui test con coverage
./vendor/bin/pest --coverage

# Esegui solo test unitari
./vendor/bin/pest --group=unit

# Esegui solo test funzionali
./vendor/bin/pest --group=feature
```

## Debugging dei Test

### Log aggiuntivo
```php
it('debug test', function () {
    // Per stampare informazioni di debug
    dump($variable);
    info('Debug message');
    
    // Oppure usa expect()->debug() per vedere i risultati
    expect($result)->debug();
});
```

## Esempi di Test Comuni

### Test per una Action
```php
it('processes data correctly', function () {
    $action = new ProcessUserDataAction();
    $result = $action->execute(['name' => 'John']);
    
    expect($result)->toBeArray();
    expect($result['processed'])->toBeTrue();
});
```

### Test per un Modello
```php
it('has correct relationship', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    expect($user->posts)->toHaveCount(1);
});
```

### Test per una API
```php
it('returns user data', function () {
    $user = User::factory()->create();
    
    $response = $this->getJson("/api/users/{$user->id}");
    
    $response->assertOk()
             ->assertJson(['id' => $user->id]);
});
```

## Gestione delle Dipendenze e Mocking

### Mocking di Servizi
```php
it('uses external service', function () {
    $mock = Mockery::mock(ExternalService::class);
    $mock->shouldReceive('process')->andReturn(true);
    
    $this->app->instance(ExternalService::class, $mock);
    
    // Esegui test logica che usa ExternalService
    $result = SomeAction::execute();
    
    expect($result)->toBeTrue();
});
```

## Risoluzione Comuni Problemi

### Problemi di Connessione al Database
- Assicurati che `.env.testing` abbia configurazioni appropriate
- Usa `RefreshDatabase` o `DatabaseMigrations` nei test che richiedono DB
- Verifica che le migrazioni siano caricate correttamente

### Errori di Configurazione
- I test usano le configurazioni definite in `config/`
- Usa `Config::set()` per modificare configurazioni specifiche nei test se necessario

### Performance dei Test
- Usa `withoutExceptionHandling()` solo quando testi gestione errori
- Usa `DatabaseMigrations` invece di `RefreshDatabase` per test più veloci
- Evita chiamate di rete nei test (mocka i servizi esterni)