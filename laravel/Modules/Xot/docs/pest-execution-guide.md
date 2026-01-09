# Pest Testing - Guida Esecuzione dalla Cartella Laravel

**Data**: 9 Gennaio 2026  
**Framework**: Pest PHP 3.8.4  
**Architettura**: Laravel Modules (nwidart/laravel-modules)

---

## 📋 Prerequisiti

### Installazione Pest
Pest è già installato nel progetto. Verifica con:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest --version
```

**Output atteso**: `Pest Testing Framework 3.8.4`

### Configurazione
- **PHPUnit XML**: `laravel/phpunit.xml` (configurazione principale)
- **Pest Root**: `laravel/tests/Pest.php` (configurazione root)
- **Pest Moduli**: `laravel/Modules/{Module}/tests/Pest.php` (configurazione per modulo)

---

## 🚀 Esecuzione Test dalla Cartella Laravel

### Comando Base
**SEMPRE eseguire dalla cartella `laravel/`**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest [opzioni] [path]
```

### Esecuzione Tutti i Test
```bash
# Tutti i test di tutti i moduli
./vendor/bin/pest Modules/

# Tutti i test di un modulo specifico
./vendor/bin/pest Modules/User/tests/

# Tutti i test di un tipo specifico
./vendor/bin/pest Modules/User/tests/Unit/
./vendor/bin/pest Modules/User/tests/Feature/
```

### Esecuzione Test Specifico
```bash
# Test file specifico
./vendor/bin/pest Modules/User/tests/Unit/UserModelTest.php

# Test con filtro per nome
./vendor/bin/pest Modules/User/tests/ --filter="User Model"

# Test con pattern
./vendor/bin/pest Modules/User/tests/ --filter="can be created"
```

### Opzioni Utili
```bash
# Lista tutti i test disponibili
./vendor/bin/pest Modules/User/tests/ --list-tests

# Output verboso
./vendor/bin/pest Modules/User/tests/ -v

# Output molto verboso
./vendor/bin/pest Modules/User/tests/ -vv

# Stop al primo errore
./vendor/bin/pest Modules/User/tests/ --bail

# Test con coverage
./vendor/bin/pest Modules/User/tests/ --coverage

# Test con coverage minimo
./vendor/bin/pest Modules/User/tests/ --coverage --min=100

# Test con parallel execution
./vendor/bin/pest Modules/User/tests/ --parallel
```

---

## 📁 Struttura Test Moduli

### Struttura Standard
```
laravel/
├── tests/                    # Test root (opzionale)
│   ├── Pest.php
│   └── TestCase.php
└── Modules/
    └── {Module}/
        └── tests/
            ├── Pest.php      # Configurazione Pest modulo
            ├── TestCase.php  # TestCase modulo
            ├── Unit/         # Test unitari
            ├── Feature/       # Test feature/integrazione
            ├── Integration/  # Test integrazione (opzionale)
            └── Performance/  # Test performance (opzionale)
```

### File Pest.php Modulo
Ogni modulo può avere il proprio `Pest.php`:
```php
<?php

declare(strict_types=1);

use Modules\{Module}\Tests\TestCase;

pest()->extend(TestCase::class)->in('Feature', 'Unit');

// Custom expectations
expect()->extend('toBe{Model}', fn () => $this->toBeInstanceOf({Model}::class));

// Helper functions
function create{Model}(array $attributes = []): {Model}
{
    return {Model}::factory()->create($attributes);
}
```

---

## 🎯 Pattern di Esecuzione

### Pattern 1: Test Singolo Modulo
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/
```

### Pattern 2: Test Multipli Moduli
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/ Modules/Cms/tests/
```

### Pattern 3: Test con Coverage
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/ --coverage --min=100
```

### Pattern 4: Test con Filtro
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/ --filter="User Model"
```

### Pattern 5: Test Verboso per Debug
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/ -vv --filter="can be created"
```

---

## 🔧 Configurazione TestCase

### TestCase Base (Xot)
Tutti i moduli estendono `Modules\Xot\Tests\CreatesApplication`:
```php
<?php

namespace Modules\{Module}\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup specifico modulo
    }
}
```

### TestCase Root (laravel/tests/TestCase.php)
```php
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Base per test root (se necessario)
}
```

---

## ⚠️ Problemi Comuni e Soluzioni

### Problema 1: "Test directory not found"
**Errore**: `Test directory "/var/www/_bases/base_laravelpizza/laravel/tests/Feature" not found`

**Causa**: Il file `laravel/tests/Pest.php` cerca directory che non esistono.

**Soluzione**: 
- Eseguire test specificando path esplicito: `./vendor/bin/pest Modules/User/tests/`
- Oppure modificare `laravel/tests/Pest.php` per rimuovere riferimenti a directory inesistenti

### Problema 2: "Class not found"
**Errore**: `Class Modules\{Module}\Tests\TestCase not found`

**Causa**: TestCase non esiste o namespace errato.

**Soluzione**: 
- Verificare che `Modules/{Module}/tests/TestCase.php` esista
- Verificare namespace corretto nel file

### Problema 3: "Database connection error"
**Errore**: Errori di connessione database durante i test

**Causa**: Configurazione database non corretta per test.

**Soluzione**: 
- Verificare `.env.testing` esiste
- Verificare `phpunit.xml` ha configurazione SQLite in-memory
- Usare `DB_CONNECTION=sqlite` e `DB_DATABASE=:memory:`

### Problema 4: "XotData not found"
**Errore**: Errori su `XotData` nei test

**Causa**: Mock XotData non configurato.

**Soluzione**: 
- Aggiungere `mockXotData()` in `beforeEach()`
- Verificare binding nel container con `app()->instance()`

---

## 📊 Coverage Target

### Obiettivo: 100% Coverage per Ogni Modulo

```bash
# Verifica coverage modulo
./vendor/bin/pest Modules/User/tests/ --coverage --min=100

# Coverage con report HTML
./vendor/bin/pest Modules/User/tests/ --coverage --coverage-html=storage/app/coverage/user

# Coverage con report testo
./vendor/bin/pest Modules/User/tests/ --coverage --coverage-text
```

### Strategia Coverage
1. **Unit Tests**: 100% coverage per Models, Actions, Services
2. **Feature Tests**: 100% coverage per Controllers, Resources, Widgets
3. **Integration Tests**: 100% coverage per flussi business logic

---

## 🎯 Best Practices

### 1. Esecuzione Incrementale
```bash
# Test singolo file durante sviluppo
./vendor/bin/pest Modules/User/tests/Unit/UserModelTest.php

# Test modulo completo prima di commit
./vendor/bin/pest Modules/User/tests/

# Test tutti i moduli prima di push
./vendor/bin/pest Modules/ --coverage --min=100
```

### 2. Debugging
```bash
# Output verboso per capire errori
./vendor/bin/pest Modules/User/tests/ -vv --filter="can be created"

# Stop al primo errore
./vendor/bin/pest Modules/User/tests/ --bail

# Lista test disponibili
./vendor/bin/pest Modules/User/tests/ --list-tests
```

### 3. Performance
```bash
# Test con parallel execution (se supportato)
./vendor/bin/pest Modules/User/tests/ --parallel

# Test con memory limit
./vendor/bin/pest Modules/User/tests/ --memory-limit=512M
```

---

## 🔗 Comandi Composer

### Script Test in composer.json
```json
{
    "scripts": {
        "test": [
            "@php artisan config:clear --ansi",
            "@php artisan test"
        ]
    }
}
```

**Esecuzione**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
composer test
```

**Nota**: `composer test` usa `php artisan test` che può non funzionare correttamente con moduli. **Preferire sempre `./vendor/bin/pest` direttamente**.

---

## 📝 Esempi Pratici

### Esempio 1: Test Modulo User
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/
```

**Output atteso**:
```
PASS  Modules\User\tests\Unit\UserModelTest
✓ User Model → it can be created (in-memory)
✓ User Model → it supports mass-assignment...
...

Tests:    21 passed (38 assertions)
Duration: 4.18s
```

### Esempio 2: Test con Coverage
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/ --coverage --min=100
```

### Esempio 3: Test Specifico
```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests/Unit/UserModelTest.php -vv
```

---

## 🚨 Regole Critiche

### ❌ MAI Fare
1. **NON eseguire** `./vendor/bin/pest` senza path (cerca `tests/Feature` che non esiste)
2. **NON usare** `php artisan test` per moduli (non funziona correttamente)
3. **NON cambiare** directory prima di eseguire (sempre da `laravel/`)

### ✅ SEMPRE Fare
1. **SEMPRE eseguire** da `laravel/` directory
2. **SEMPRE specificare** path esplicito: `./vendor/bin/pest Modules/{Module}/tests/`
3. **SEMPRE verificare** coverage: `--coverage --min=100`

---

## 📚 Documentazione Correlata

- [Testing Rules](./testing-rules.md) - Regole fondamentali testing
- [Testing Best Practices](./testing-best-practices.md) - Best practices Pest
- [Laravel Testing](https://laravel.com/docs/12.x/testing) - Documentazione ufficiale
- [Pest Documentation](https://pestphp.com/docs) - Documentazione Pest
- [Laravel Modules Testing](https://laravelmodules.com/docs/12/advanced/tests) - Testing moduli

---

**Ultimo aggiornamento**: 9 Gennaio 2026  
**Versione Pest**: 3.8.4  
**Status**: ✅ Documentazione Completa
