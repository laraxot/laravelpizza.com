# Laraxot Pest PHP Testing Guide

## Panoramica

Questa guida spiega come impostare, configurare e utilizzare Pest PHP nell'architettura Laraxot con moduli Laravel. Include le configurazioni necessarie, le best practices e le regole critiche da seguire.

## Configurazione PSR-4 nel composer.json

### ❌ Configurazione Errata
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
- I moduli sono gestiti automaticamente dal `wikimedia/composer-merge-plugin`
- L'autoloader PSR-4 non deve contenere la cartella Modules
- Il plugin merge combina automaticamente i file `Modules/*/composer.json`

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

## File di Configurazione Pest

### 1. File Root: `laravel/tests/Pest.php`
```php
<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Il closure fornito alle funzioni di test è sempre associato a una classe
| specifica di test PHPUnit. Di default, quella classe è "PHPUnit\Framework\TestCase".
| Puoi cambiare questo usando la funzione "uses()" per associare classi o tratti diversi.
|
*/

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Quando scrivi test, spesso devi controllare che i valori soddisfino certe condizioni.
| La funzione "expect()" ti dà accesso a un insieme di metodi "expectations" che puoi
| usare per fare asserzioni diverse. Ovviamente, puoi estendere l'API Expectation in qualsiasi momento.
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
| Mentre Pest è molto potente di default, potresti avere del codice di test specifico
| per il tuo progetto che non vuoi ripetere in ogni file. Qui puoi anche esporre
| funzioni helper come funzioni globali per ridurre il numero di righe nei tuoi file di test.
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

use Modules\{Module}\Tests\TestCase;
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

expect()->extend('toBe{Model}', function () {
    return $this->toBeInstanceOf(Modules\{Module}\Models\{Model}::class);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Funzioni helper specifiche del modulo
|
*/

function create{Model}(array $attributes = []): Modules\{Module}\Models\{Model}
{
    return Modules\{Module}\Models\{Model}::factory()->create($attributes);
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

### ✅ Approccio Corretto: Database Transactions

```php
<?php

namespace Modules\{Module}\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case seguendo le regole Laraxot.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura le connessioni database per i test
        $this->configureTestConnections();

        // Esegue le migrazioni specifiche del modulo
        $this->runModuleMigrations();
    }

    protected function configureTestConnections(): void
    {
        // Configura la connessione specifica del modulo
        $moduleConnection = $this->getModuleConnectionName();
        Config::set("database.connections.{$moduleConnection}", [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configura altre connessioni che potrebbero essere richieste
        $commonConnections = ['mysql', 'user', 'tenant', 'notify', 'activity', 'media', 'cms', 'geo'];
        foreach ($commonConnections as $connection) {
            if (!Config::has("database.connections.{$connection}")) {
                Config::set("database.connections.{$connection}", [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix' => '',
                ]);
            }
        }
    }

    protected function runModuleMigrations(): void
    {
        $this->artisan('migrate', [
            '--database' => $this->getModuleConnectionName(),
            '--path' => "Modules/{$this->getModuleName()}/database/migrations"
        ]);
    }

    protected function getModuleConnectionName(): string
    {
        return strtolower(class_basename($this->getModuleName()));
    }

    protected function getModuleName(): string
    {
        $namespace = static::class;
        $parts = explode('\\', $namespace);
        $moduleIndex = array_search('Modules', $parts);
        return $moduleIndex !== false ? $parts[$moduleIndex + 1] : 'Unknown';
    }
}
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

it('can create model', function () {
    $model = Modules\{Module}\Models\{Model}::factory()->create();
    
    expect($model)->toBeInstanceOf(Modules\{Module}\Models\{Model}::class)
        ->and($model->id)->toBeString(); // o toBeInt() se usa ID interi
});

it('has required attributes', function () {
    $model = Modules\{Module}\Models\{Model}::factory()->make();
    
    expect($model->name)->toBeString()
        ->and($model->status)->toBeString();
});
```

### Esempio di Test Funzionale
```php
<?php

it('can perform action via api', function () {
    $response = $this->post('/api/action', [
        'name' => 'Test Name',
        'data' => 'test data',
    ]);
    
    $response->assertStatus(200)
        ->assertJsonStructure(['id', 'name', 'data']);
        
    $this->assertDatabaseHas('{table_name}', [
        'name' => 'Test Name'
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

## Regole Critiche

### ❌ MAI Fare
1. **NON usare** `RefreshDatabase` trait nei test
2. **NON eseguire** `./vendor/bin/pest` senza specificare il path (cerca `tests/Feature` che potrebbe non esistere)
3. **NON cambiare** il file composer.json per riaggiungere `"Modules\\": "Modules/"`

### ✅ SEMPRE Fare
1. **SEMPRE usare** `DatabaseTransactions` invece di `RefreshDatabase`
2. **SEMPRE eseguire** da `laravel/` directory
3. **SEMPRE specificare** il path esplicito: `./vendor/bin/pest Modules/{Module}/tests/`
4. **SEMPRE verificare** che le connessioni database siano configurate per SQLite in memoria durante i test

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

### Problema: "Table doesn't exist"
**Soluzione**: 
- Esegui le migrazioni appropriate per la connessione specifica del modulo
- Assicurati che il percorso delle migrazioni sia corretto

## CI/CD Integration with GitHub Actions

### Database setup in CI (two test databases required)

```yaml
services:
  mysql:
    image: mysql:8.0
    env:
      MYSQL_ROOT_PASSWORD: password
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
      MYSQL_DATABASE: <nome progetto>_data_test
=======
      MYSQL_DATABASE: laravelpizza_data_test
>>>>>>> a038b0f2 (.)
=======
      MYSQL_DATABASE: <nome progetto>_data_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
      MYSQL_DATABASE: laravelpizza_data_test
>>>>>>> a038b0f2 (.)
=======
      MYSQL_DATABASE: <nome progetto>_data_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
    ports:
      - 3306:3306

steps:
  - name: Create test databases
    run: |
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_data_test;"
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_user_test;"
=======
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS laravelpizza_data_test;"
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS laravelpizza_user_test;"
>>>>>>> a038b0f2 (.)
=======
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_data_test;"
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_user_test;"
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS laravelpizza_data_test;"
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS laravelpizza_user_test;"
>>>>>>> a038b0f2 (.)
=======
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_data_test;"
      mysql -h 127.0.0.1 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS <nome progetto>_user_test;"
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)

  - name: Setup Environment
    working-directory: laravel
    run: |
      cp .env.testing .env
      php artisan key:generate --force

  - name: Run Migrations (NEVER migrate:fresh)
    working-directory: laravel
    env:
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
      DB_DATABASE: <nome progetto>_data_test
      DB_DATABASE_USER: <nome progetto>_user_test
=======
      DB_DATABASE: laravelpizza_data_test
      DB_DATABASE_USER: laravelpizza_user_test
>>>>>>> a038b0f2 (.)
=======
      DB_DATABASE: <nome progetto>_data_test
      DB_DATABASE_USER: <nome progetto>_user_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
      DB_DATABASE: laravelpizza_data_test
      DB_DATABASE_USER: laravelpizza_user_test
>>>>>>> a038b0f2 (.)
=======
      DB_DATABASE: <nome progetto>_data_test
      DB_DATABASE_USER: <nome progetto>_user_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
      DB_USERNAME: root
      DB_PASSWORD: password
    run: php artisan migrate --env=testing --force

  - name: Run Pest with Coverage
    working-directory: laravel
    run: |
      ./vendor/bin/pest \
        --compact \
        --coverage \
        --coverage-clover=coverage.xml \
        --coverage-html=coverage-html
```

### Coverage driver: PCOV (not Xdebug)

```yaml
- name: Setup PHP with PCOV
  uses: shivammathur/setup-php@v2
  with:
    php-version: '8.3'
    extensions: mbstring, intl, pdo_mysql, pcov
    coverage: pcov
```

PCOV is 10x faster than Xdebug for coverage collection. Use `pcov` in CI, not `xdebug`.

### Never `migrate:fresh` — absolute rule

```bash
# FORBIDDEN in tests and CI
php artisan migrate:fresh --env=testing --force

# CORRECT — run once before the suite
php artisan migrate --env=testing --force
```

`migrate:fresh` drops ALL tables in the shared test database, causing cascading failures across all modules. See `.cursor/rules/no-refresh-database-in-tests.md`.

## Correzione nota: MySQL, non SQLite

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
Questo progetto usa **MySQL** per i test (non SQLite in-memory), per garantire parità con la produzione. Il file `.env.testing` configura `DB_CONNECTION=mysql` con `DB_DATABASE=<nome progetto>_data_test`. I TestCase dei moduli usano `DatabaseTransactions` per isolare senza distruggere il DB.
=======
Questo progetto usa **MySQL** per i test (non SQLite in-memory), per garantire parità con la produzione. Il file `.env.testing` configura `DB_CONNECTION=mysql` con `DB_DATABASE=laravelpizza_data_test`. I TestCase dei moduli usano `DatabaseTransactions` per isolare senza distruggere il DB.
>>>>>>> a038b0f2 (.)
=======
Questo progetto usa **MySQL** per i test (non SQLite in-memory), per garantire parità con la produzione. Il file `.env.testing` configura `DB_CONNECTION=mysql` con `DB_DATABASE=<nome progetto>_data_test`. I TestCase dei moduli usano `DatabaseTransactions` per isolare senza distruggere il DB.
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
Questo progetto usa **MySQL** per i test (non SQLite in-memory), per garantire parità con la produzione. Il file `.env.testing` configura `DB_CONNECTION=mysql` con `DB_DATABASE=laravelpizza_data_test`. I TestCase dei moduli usano `DatabaseTransactions` per isolare senza distruggere il DB.
>>>>>>> a038b0f2 (.)
=======
Questo progetto usa **MySQL** per i test (non SQLite in-memory), per garantire parità con la produzione. Il file `.env.testing` configura `DB_CONNECTION=mysql` con `DB_DATABASE=<nome progetto>_data_test`. I TestCase dei moduli usano `DatabaseTransactions` per isolare senza distruggere il DB.
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)

## Conclusione

Questa configurazione garantisce che Pest funzioni correttamente con l'architettura modulare di Laraxot, rispettando i principi di modularità e mantenendo la separazione tra i componenti del sistema. Seguendo queste regole, tutti i test saranno conformi all'architettura Laraxot e funzioneranno correttamente.