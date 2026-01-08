# Testing

## Pacchetti Utilizzati

### Pest
- [pestphp/pest](https://pestphp.com)
  - Framework testing
  - Test case
  - Assertions
  - Configurazione dettagliata
  - Integrazione con Filament

### Testbench
- [orchestra/testbench](https://github.com/orchestral/testbench)
  - Testing pacchetti
  - Laravel testing
  - Integration testing
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Pest
```php
// phpunit.xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/pestphp/pest/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

### Testbench
```php
// tests/TestCase.php
namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Spatie\LaravelPackageTools\PackageServiceProvider::class,
        ];
    }
}
```

## Utilizzo

### Pest
```php
// Test unitario
test('it can do something', function () {
    expect(true)->toBeTrue();
});

// Test feature
test('it can do something with database', function () {
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
```

### Testbench
```php
// Test pacchetto
test('it can register package', function () {
    $this->assertTrue(true);
});

// Test integrazione
test('it can integrate with laravel', function () {
    $this->assertTrue(true);
});
```

## Documentazione Collegata

- [Sviluppo](development.md)
- [Performance](performance.md)
- [Debug](debug.md)
- [Panoramica](../packages.md) 
### Versione HEAD


## Collegamenti tra versioni di testing.md
* [testing.md](../../../Xot/docs/packages/testing.md)
* [testing.md](../../../Xot/docs/development/testing.md)
* [testing.md](../../../Cms/docs/frontoffice/testing.md)
* [testing.md](../../../../Themes/One/docs/testing.md)


### Versione Incoming


---

