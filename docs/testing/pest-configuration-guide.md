# Pest PHP Configuration Guide - Laraxot Architecture

## Introduzione

Questa guida spiega come configurare e utilizzare Pest PHP nel contesto dell'architettura Laraxot con moduli Laravel. Include le configurazioni necessarie e le best practices specifiche per il progetto.

## Configurazione PSR-4 nel composer.json

### ❌ Configurazione Errata (da correggere)
```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/",
            "Modules\\": "Modules/"  // ❌ QUESTA RIGA È SBAGLIATA
        }
    }
}
```

### ✅ Configurazione Corretta
```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
            // ❌ RIMUOVERE: "Modules\\": "Modules/"
        }
    }
}
```

**Spiegazione**: La riga `"Modules\\": "Modules/"` è sbagliata perché:
1. I moduli sono gestiti automaticamente dal `wikimedia/composer-merge-plugin`
2. L'autoloader PSR-4 non deve contenere la cartella Modules
3. Il plugin merge combina automaticamente i file `Modules/*/composer.json`

## Configurazione del Plugin composer-merge-plugin

Il plugin è già configurato correttamente:
```json
{
    "extra": {
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ]
        }
    }
}
```

Questo permette al plugin di:
- Leggere tutti i file `composer.json` nei moduli
- Aggiungere automaticamente le configurazioni PSR-4 per ogni modulo
- Gestire le dipendenze specifiche di ogni modulo

## File di Configurazione Pest

### 1. File Root: `laravel/tests/Pest.php`
```php
<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
```

### 2. File per Modulo: `laravel/Modules/{Module}/tests/Pest.php`
```php
<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;
use Pest\PendingObjects\TestPending;

/**
 * @var TestPending $it
 */

/*
|--------------------------------------------------------------------------
| Test Case Extension
|--------------------------------------------------------------------------
|
| Estende il TestCase specifico del modulo per tutti i test in Unit e Feature
|
*/

pest()->extend(TestCase::class)->in('Unit', 'Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Estensioni specifiche per il modulo
|
*/

expect()->extend('toBeUser', function () {
    return $this->toBeInstanceOf(Modules\User\Models\User::class);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Funzioni helper specifiche del modulo
|
*/

function createUser(array $attributes = []): Modules\User\Models\User
{
    return Modules\User\Models\User::factory()->create($attributes);
}
```

## Configurazione del TestCase per i Moduli

### ❌ MAI usare `RefreshDatabase`
**NON usare mai**:
```php
use Illuminate\Foundation\Testing\RefreshDatabase;
```

**Spiegazione**: 
- `RefreshDatabase` crea problemi con le strutture modulari
- Può causare conflitti con le migrazioni dei moduli
- In Laraxot, la gestione del database è specifica per mantenere la coerenza tra moduli
- Ogni modulo ha la sua gestione dello stato del database

### ✅ Alternativa: Gestione Manuale del Database
```php
<?php

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Gestione specifica per il modulo
        // Esempio: creazione dati di test specifici
        $this->withoutExceptionHandling();
    }
    
    protected function tearDown(): void
    {
        // Pulizia specifica per il modulo se necessaria
        parent::tearDown();
    }
}
```

## Configurazione phpunit.xml per i Moduli

Il file `laravel/phpunit.xml` è già configurato correttamente:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Modules">
          <directory suffix="Test.php">./Modules/*/tests/Feature</directory>
          <directory suffix="Test.php">./Modules/*/tests/Unit</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
            <directory>Modules</directory>
        </include>
        <exclude>
            <directory suffix=".php">./Modules/*/config</directory>
            <directory suffix=".php">./Modules/*/database</directory>
            <directory suffix=".php">./Modules/*/resources</directory>
            <directory suffix=".php">./Modules/*/routes</directory>
            <directory suffix=".php">./Modules/*/tests</directory>
        </exclude>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="BROADCAST_CONNECTION" value="null"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
        <env name="NIGHTWATCH_ENABLED" value="false"/>
    </php>
</phpunit>
```

## Esecuzione dei Test

### Comando Base
```bash
# Dalla cartella laravel/
cd laravel
./vendor/bin/pest Modules/User/tests/
```

### Esecuzione per Modulo
```bash
# Tutti i test di un modulo
./vendor/bin/pest Modules/User/tests/

# Solo test Unit
./vendor/bin/pest Modules/User/tests/Unit/

# Solo test Feature  
./vendor/bin/pest Modules/User/tests/Feature/

# Test specifico
./vendor/bin/pest Modules/User/tests/Feature/UserRegistrationTest.php
```

### Opzioni Comuni
```bash
# Con verbose output
./vendor/bin/pest Modules/User/tests/ -v

# Con coverage
./vendor/bin/pest Modules/User/tests/ --coverage

# Con coverage minimo
./vendor/bin/pest Modules/User/tests/ --coverage --min=100

# Filtro per nome test
./vendor/bin/pest Modules/User/tests/ --filter="registration"
```

## Struttura dei Test Pest

### Esempio di Test Unitario
```php
<?php

it('can create user', function () {
    $user = Modules\User\Models\User::factory()->create();
    
    expect($user)->toBeInstanceOf(Modules\User\Models\User::class)
        ->and($user->id)->toBeInt();
});

it('has required attributes', function () {
    $user = Modules\User\Models\User::factory()->make();
    
    expect($user->name)->toBeString()
        ->and($user->email)->toBeString();
});
```

### Esempio di Test Funzionale
```php
<?php

it('can register user via api', function () {
    $response = $this->post('/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);
    
    $response->assertStatus(201)
        ->assertJsonStructure(['id', 'name', 'email']);
        
    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com'
    ]);
});
```

## Conversione da PHPUnit a Pest

### Vecchio Stile (PHPUnit)
```php
<?php

namespace Modules\User\Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_create_user()
    {
        $user = User::factory()->create();
        
        $this->assertInstanceOf(User::class, $user);
    }
}
```

### Nuovo Stile (Pest)
```php
<?php

it('can create user', function () {
    $user = Modules\User\Models\User::factory()->create();
    
    expect($user)->toBeInstanceOf(Modules\User\Models\User::class);
});
```

## Best Practices per Laraxot

### 1. DRY + KISS + SOLID + Robust
- **DRY**: Non duplicare logica di test
- **KISS**: Mantieni i test semplici e chiari
- **SOLID**: Segui principi SOLID nei componenti testati
- **Robust**: Gestisci tutti i casi limite

### 2. Coverage del 100%
- Obiettivo: 100% di code coverage per ogni modulo
- Testa tutti i percorsi logici
- Includi test per errori e casi limite

### 3. Naming Convention
- Usa nomi descrittivi per i test
- Segui il pattern: `it('should do something')`
- Usa nomi in inglese per coerenza

### 4. Organizzazione
- Usa la struttura `Unit` e `Feature` come richiesto
- Mantieni test correlati nello stesso file
- Usa funzioni helper per codice ripetitivo

## Risoluzione Problemi Comuni

### Problema: "Class not found" per i moduli
**Soluzione**: Verifica che il TestCase del modulo esista e che il namespace sia corretto.

### Problema: "Test directory not found"
**Soluzione**: Specifica il path completo al modulo: `./vendor/bin/pest Modules/User/tests/`

### Problema: Errori di database durante i test
**Soluzione**: 
- Verifica che `.env.testing` sia configurato correttamente
- Usa solo SQLite in-memory per i test
- Non usare `RefreshDatabase`

## Conclusione

Questa configurazione garantisce che Pest funzioni correttamente con l'architettura modulare di Laraxot, rispettando i principi di modularità e mantenendo la separazione tra i componenti del sistema.