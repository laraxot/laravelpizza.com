# TestCase Migration Rule - VERSIONE CORRETTA

## REGOLA FONDAMENTALE: No Migration nel TestCase

I TestCase del progetto Laraxot NON devono contenere logica di migrazione nel codice. Le migrazioni vengono eseguite **MANUALMENTE** una volta prima di lanciare i test.

## ❌ SBAGLIATO - Pattern Vietati

```php
// ❌ SBAGLIATO: migrate nel setUp()
protected function setUp(): void
{
    parent::setUp();
    $this->artisan('migrate:fresh', ['--force' => true]);
    $this->artisan('module:migrate', ['--force' => true]);
}

// ❌ SBAGLIATO: if static $migrated
protected static bool $migrated = false;

protected function setUp(): void
{
    parent::setUp();
    if (! self::$migrated) {
        $this->artisan('module:migrate');
        self::$migrated = true;
    }
}

// ❌ SBAGLIATO: setUpBeforeClass()
public static function setUpBeforeClass(): void
{
    parent::setUpBeforeClass();
    Artisan::call('module:migrate');
}

// ❌ SBAGLIATO: $connectionsToTransact SENZA la connessione del modulo
// OGNI modulo DEVE avere la propria connessione nella lista!
// Esempio sbagliato per il modulo Gdpr (manca 'gdpr'):
protected $connectionsToTransact = [
    'mysql',
    'user',
    // 'gdpr' MANCANTE! → i dati Gdpr NON vengono rollbackati!
];

// ❌ SBAGLIATO: config xra
config(['xra.pub_theme' => 'Meetup']);
config(['xra.main_module' => 'User']);
\Modules\Xot\Datas\XotData::make()->update([...]);
```

## ✅ CORRETTO - Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Gdpr module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 * Uses MySQL from .env.testing.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /**
     * OBBLIGATORIO: elencare OGNI connessione usata dai Model del modulo.
     * Anche se le connessioni puntano allo stesso server MySQL,
     * sono handle PDO SEPARATI con scope transazionali INDIPENDENTI.
     * Senza elencare la connessione del modulo, i dati NON vengono rollbackati.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = [
        'mysql',
        'gdpr',   // DEVE corrispondere a $connection nei Model Gdpr
        'user',
    ];

    // NO setUp() con migrate - NON NECESSARIO
    // Esegui manualmente: php artisan migrate --env=testing

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            GdprServiceProvider::class,
        ];
    }
}
```

## Perché Questo Pattern?

### 1. Semplicità
- Nessuna logica di migrazione nel codice
- Le migrazioni si fanno una volta manualmente
- Più chiaro e manutenibile

### 2. Performance
- `php artisan migrate --env=testing` eseguito una sola volta
- `DatabaseTransactions` gestisce il rollback automaticamente
- Nessun overhead nei test

### 3. Coerenza
- Stesso approccio per tutti i moduli
- Non dipende da flag statici
- Test isolati e idempotenti

### 4. Affidabilità
- Nessuno stato condiviso
- Test indipendenti
- Più facile debuggare

## Workflow Corretto

```bash
# 1. Configura .env.testing (copia carbone di .env con _test)
cd laravel
cp .env .env.testing
# Modifica: DB_DATABASE → DB_DATABASE_test

# 2. Esegui migrazioni UNA SOLA VOLTA
php artisan migrate --env=testing

# 3. Lancia i test (non eseguono migrate!)
php artisan test

# 4. Se serve reset completo (raramente necessario)
php artisan migrate:fresh --env=testing
php artisan migrate --env=testing
```

## Punti Chiave

### ✅ FARE:
- Usare solo `CreatesApplication` e `DatabaseTransactions` come trait
- Avere solo `getPackageProviders()` override
- Eseguire `php artisan migrate --env=testing` manualmente prima dei test

### ❌ NON FARE:
- NON usare `migrate:fresh` nel codice
- NON usare `--force`
- NON usare `if (! self::$migrated)`
- NON usare `setUpBeforeClass()`
- USARE `$connectionsToTransact` con la connessione del modulo (OBBLIGATORIO)
- NON usare `config(['xra.*'])`
- NON usare `XotData::make()->update()`

## Riepilogo

> **REGOLA**: Il TestCase deve essere MINIMALE. Solo trait + provider. Le migrazioni si fanno manualmente.

## Riferimenti

- [Environment Development vs Testing Rules](./environment-development-vs-testing-rules.md)
- [Database Testing Configuration](./database-testing-configuration.md)
- [mysql-only-testing-rule](./testing/mysql-only-testing-rule.md)
