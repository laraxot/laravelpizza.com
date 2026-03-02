# Studio TDD, Pest e Laravel Modules

## Riferimenti Studiate

- [Laravel Modules](https://github.com/nWidart/laravel-modules) - Gestione moduli Laravel
- [Pest PHP](https://pestphp.com/docs/installation) - Framework di testing
- [Laravel Testing](https://laraveldaily.com/lesson/laravel-testing/tdd-how-it-works-example) - TDD examples

## TDD (Test Driven Development)

### Ciclo TDD
1. **RED** - Scrivi un test che fallisce
2. **GREEN** - Scrivi codice minimo per far passare il test
3. **REFACTOR** - Migliora il codice mantenendo i test verdi

### Principi TDD
- **FIRST**: Fast, Isolated, Repeatable, Self-validating, Timely
- **AAA**: Arrange, Act, Assert
- Testare happy path E sad path
- 100% coverage sulla logica di business

### Tipi di Test
- **Unit Test**: Testano funzioni/metodi singoli
- **Feature Test**: Testano funzionalità complete (HTTP, DB)
- **Integration Test**: Testano interazioni tra componenti

## Pest PHP

### Installazione
```bash
composer remove phpunit/phpunit
composer require pestphp/pest --dev --with-all-dependencies
./vendor/bin/pest --init
```

### Struttura Test
```php
<?php

uses(TestCase::class, DatabaseTransactions::class);

describe('Feature Name', function () {
    it('does {
        // Arrange something', function ()
        $user = User::factory()->create();
        
        // Act
        $response = $this->get('/route');
        
        // Assert
        $response->assertSuccessful();
    });
});
```

### Comandi
```bash
# Run all tests
./vendor/bin/pest

# Run with coverage
./vendor/bin/pest --coverage

# Run single test
./vendor/bin/pest --filter="testName"

# Run specific file
./vendor/bin/pest tests/Feature/MyTest.php
```

## Laravel Modules + Testing

### Struttura Test per Moduli
```
Modules/{Module}/
├── tests/
│   ├── Pest.php              # Setup globale
│   ├── TestCase.php          # Base test case
│   ├── Feature/
│   │   └── MyFeatureTest.php
│   └── Unit/
│       ├── Models/
│       │   └── MyModelTest.php
│       └── Actions/
│           └── MyActionTest.php
```

### Configurazione phpunit.xml
```xml
<testsuite name="Modules">
    <directory suffix="Test.php">./Modules/*/tests/Feature</directory>
    <directory suffix="Test.php">./Modules/*/tests/Unit</directory>
</testsuite>
```

### Test Database
```php
// ✅ CORRETTO - Use DatabaseTransactions
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyTest extends TestCase
{
    use DatabaseTransactions;
}

// ❌ ERRATO - MAI usare RefreshDatabase
use Illuminate\Foundation\Testing\RefreshDatabase;
```

## Best Practices

### Test Coverage
- Target: 80-100% coverage sulla logica di business
- Non solo line coverage, ma anche branch coverage
- Testare edge cases e errori

### Naming
- Descrittivo: `it_can_create_user_with_valid_data`
- Seguire convenzione: `test_{method_name}_{expected_behavior}`

### Mocking
```php
use function Pest\Laravel\mock;

it('sends notification', function () {
    mock(NotificationService::class)->shouldReceive('send')->once();
    
    // test code
});
```

### Datasets
```php
it('validates email', function (string $email, bool $valid) {
    // test validation
})->with([
    'valid email' => ['user@example.com', true],
    'invalid email' => ['invalid', false],
]);
```

## Prossimi Passi

1. Applicare TDD per nuove feature
2. Aumentare coverage verso 100%
3. Implementare mutation testing
4. Setup CI/CD con test automatici
