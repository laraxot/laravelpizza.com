# REGOLA CRITICA: MySQL Only per Testing - Nessun SQLite

**Status**: ✅ REGOLA ASSOLUTA - NESSUNA ECCEZIONE  
**Priorità**: MASSIMA

## 🚨 Principio Fondamentale

> **Il file `.env.testing` è la fonte unica di verità per la configurazione dei test.**
> 
> **SQLite è VIETATO per i test. SEMPRE e SOLO MySQL con suffisso "_test".**

## Regole Assolute

### 1. ❌ VIETATO: SQLite per Test
```php
// ❌ ASSOLUTAMENTE VIETATO - MAI FARE QUESTO
config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.driver' => 'sqlite']);
config(['database.connections.sqlite.database' => ':memory:']);
$this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
$dbName = 'file:memdb_test_'.Str::random(10).'?mode=memory&cache=shared';
```

### 2. ✅ OBBLIGATORIO: MySQL con Suffisso "_test"
```php
// ✅ CORRETTO - Usa sempre MySQL da .env.testing
// Il file .env.testing definisce:
// DB_CONNECTION=mysql
// DB_DATABASE=quaeris_data_test  (suffisso "_test" obbligatorio)
// DB_HOST=127.0.0.1
// DB_PORT=3306

// I test DEVONO rispettare .env.testing - NON forzare configurazioni
// NON sovrascrivere mai la configurazione database nei TestCase
```

### 3. Pattern Database Test
```bash
# Schema: {nome_database_produzione}_test
PRODUZIONE: quaeris_data    → TEST: quaeris_data_test
PRODUZIONE: quaeris_user    → TEST: quaeris_user_test  
PRODUZIONE: quaeris_survey  → TEST: quaeris_survey_test

# Pattern: {nome}_test - SEMPRE e SOLO _test
```

## Configurazione .env.testing

```env
# ✅ CORRETTO - MySQL con suffisso "_test"
APP_ENV=testing
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quaeris_data_test          # Suffisso "_test" obbligatorio
DB_USERNAME=marco
DB_PASSWORD=marco

# ❌ VIETATO - Commentato per evitare tentazione
# DB_CONNECTION=sqlite
# DB_DATABASE=:memory:
```

## TestCase Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for ModuleName module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 * Database names must have "_test" suffix (es: quaeris_data_test).
 * The .env.testing file is the single source of truth - NEVER override database configuration.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Set cache driver to array for testing (required for Sushi models)
        $this->app['config']->set('cache.default', 'array');

        // ✅ CORRETTO: Rispetta .env.testing - NON forzare SQLite
        // Il file .env.testing è la fonte unica di verità per la configurazione database
        // NON sovrascrivere mai la configurazione database da .env.testing
        // Database test DEVONO avere suffisso "_test" (es: quaeris_data_test)

        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'ModuleName', '--force' => true]);
    }
}
```

## TestCase Pattern VIETATO

```php
// ❌ ASSOLUTAMENTE VIETATO - MAI FARE QUESTO
protected function setUp(): void
{
    parent::setUp();

    // ❌ VIETATO: Forzare SQLite
    config(['database.default' => 'sqlite']);
    config(['database.connections.sqlite.driver' => 'sqlite']);
    config(['database.connections.sqlite.database' => ':memory:']);

    // ❌ VIETATO: Sovrascrivere connessioni con SQLite
    foreach ($connections as $conn) {
        $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
        $this->app['config']->set("database.connections.{$conn}.database", ':memory:');
    }
}
```

## Motivazione

1. **Coerenza**: Stesso dialetto SQL in test e produzione
2. **Affidabilità**: Test realistici che predicono comportamento produzione
3. **Sicurezza**: Evita bug che si manifestano solo in produzione
4. **Fonte Unica di Verità**: `.env.testing` definisce tutto, non sovrascrivere

## Checklist per TestCase

- [ ] TestCase NON forza SQLite
- [ ] TestCase NON sovrascrive configurazione database
- [ ] TestCase rispetta `.env.testing`
- [ ] Database test hanno suffisso "_test"
- [ ] Commenti PHPDoc menzionano "MySQL from .env.testing (NOT SQLite)"

## Riferimenti

- [Database Testing Consistency Rule](../../../../docs/operational-rules/database-testing-consistency-rule.md)
- [Testing Strategy](./testing-strategy.md)
- [MySQL Testing Only Rule](../../../../.cursor/rules/mysql-testing-only.mdc)

**Versione**: 1.0  
**Ultimo aggiornamento**: 2026-01-21  
**Status**: REGOLA ASSOLUTA - NESSUNA ECCEZIONE
