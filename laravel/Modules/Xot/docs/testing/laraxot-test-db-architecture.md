# Laraxot Test Architecture - Database Management without RefreshDatabase

## Introduzione

In Laraxot, l'uso di `RefreshDatabase` è vietato per mantenere la coerenza con l'architettura modulare e le connessioni multiple. Questa guida spiega come gestire correttamente i test senza `RefreshDatabase`.

## Motivazione del divieto di RefreshDatabase

### 1. Architettura Modulare
- Ogni modulo ha la propria connessione database specifica
- `RefreshDatabase` è progettato per connessioni singole
- In un sistema con connessioni multiple, `RefreshDatabase` può causare conflitti

### 2. Connessioni Multiple
- I moduli usano connessioni specifiche (es. 'job', 'user', 'notify', ecc.)
- `RefreshDatabase` lavora sulla connessione predefinita
- Non gestisce correttamente le migrazioni su connessioni multiple

### 3. Persistenza dei Dati
- In alcuni casi, i test devono mantenere uno stato specifico
- `RefreshDatabase` ripristina sempre lo stato iniziale
- Questo non è sempre desiderabile nell'architettura Laraxot

## Approccio Alternativo: Database Transactions

L'approccio corretto in Laraxot è l'uso di `DatabaseTransactions`:

```php
<?php

namespace Modules\{Module}\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    
    // Setup specifico per il modulo
}
```

## Gestione delle Connessioni nel TestCase

### Configurazione Corretta

```php
<?php

namespace Modules\Job\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura connessioni specifiche per i test
        $this->configureTestConnections();
    }

    protected function configureTestConnections(): void
    {
        // Configura la connessione del modulo specifico
        $moduleConnection = $this->getModuleConnectionName();
        Config::set("database.connections.{$moduleConnection}", [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configura eventuali altre connessioni usate dai modelli del modulo
        $this->configureAdditionalConnections();
    }

    protected function getModuleConnectionName(): string
    {
        // Restituisce il nome della connessione specifica del modulo
        // Ad esempio: 'job', 'user', ecc.
        return 'job'; // Cambia in base al modulo
    }

    protected function configureAdditionalConnections(): void
    {
        // Configura altre connessioni che potrebbero essere usate
        // dai modelli del modulo o dalle dipendenze
        $connections = [
            'mysql', 'user', 'tenant', 'notify', 'activity', 'media'
        ];

        foreach ($connections as $connection) {
            if (!Config::has("database.connections.{$connection}")) {
                Config::set("database.connections.{$connection}", [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix' => '',
                ]);
            }
        }
    }
}
```

## Esecuzione delle Migrazioni

### Solo per Connessioni Necessarie

```php
protected function setUp(): void
{
    parent::setUp();

    // Imposta le connessioni
    $this->configureTestConnections();

    // Esegue le migrazioni solo per le connessioni necessarie
    $this->runModuleMigrations();
}

protected function runModuleMigrations(): void
{
    // Esegue le migrazioni specifiche del modulo
    $this->artisan('migrate', [
        '--database' => $this->getModuleConnectionName(),
        '--path' => 'Modules/Job/database/migrations'
    ]);
}
```

## Best Practices per i Test

### 1. Test Isolati
- Ogni test deve essere indipendente dagli altri
- Usare `DatabaseTransactions` garantisce rollback automatico
- Non dipendere da uno stato esterno

### 2. Naming Convenzioni
- Usare nomi descrittivi per i test
- Seguire il pattern Pest: `it('should do something', function () { ... })`

### 3. Struttura AAA
- **Arrange**: Impostare il contesto
- **Act**: Eseguire l'azione
- **Assert**: Verificare il risultato

## Esempio Completo di TestCase

```php
<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case per i test del modulo Job.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Setup dell'ambiente di test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configura le connessioni database per i test
        $this->configureTestConnections();

        // Esegue le migrazioni necessarie
        $this->runModuleMigrations();
    }

    /**
     * Configura le connessioni database per i test.
     */
    protected function configureTestConnections(): void
    {
        // Connessione specifica del modulo
        Config::set('database.connections.job', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Altre connessioni che potrebbero essere richieste
        $commonConnections = ['mysql', 'user', 'tenant', 'notify', 'activity'];
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

    /**
     * Esegue le migrazioni del modulo.
     */
    protected function runModuleMigrations(): void
    {
        $this->artisan('migrate', [
            '--database' => 'job',
            '--path' => 'Modules/Job/database/migrations'
        ]);
    }
}
```

## Risoluzione Problemi Comuni

### Problema: "Database connection [X] not configured"
**Soluzione**: Assicurarsi che tutte le connessioni richieste siano configurate nel TestCase.

### Problema: "Table 'X' doesn't exist"
**Soluzione**: Eseguire le migrazioni appropriate per la connessione specifica.

### Problema: "Unknown database '<nome progetto>_X_test'"
**Soluzione**: Verificare che tutte le connessioni usino SQLite in memoria durante i test.

## Conclusione

L'approccio senza `RefreshDatabase` richiede una gestione più esplicita delle connessioni e delle migrazioni, ma offre maggiore controllo e compatibilità con l'architettura modulare di Laraxot.