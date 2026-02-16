# TestCase SQLite to MySQL Fix - Xot Module

## Problema Identificato

Il TestCase del modulo Xot (126 righe) è il PIÙ COMPLESSO e commette TUTTI gli errori degli altri moduli.

### ❌ Cosa Fa di Sbagliato

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO: Forza SQLite su TUTTE le connessioni
    $sqliteConnection = [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ];

    $this->app['config']->set('database.default', 'testing');
    $this->app['config']->set('database.connections.testing', $sqliteConnection);
    $this->app['config']->set('database.connections.user', $sqliteConnection);
    $this->app['config']->set('database.connections.xot', $sqliteConnection);
    $this->app['config']->set('database.connections.activity', $sqliteConnection);
    $this->app['config']->set('database.connections.job', $sqliteConnection);

    // ❌ SBAGLIATO: Crea funzioni custom SQLite (md5, unhex)
    foreach (['testing', 'user', 'xot', 'activity', 'job'] as $connectionName) {
        try {
            $pdo = DB::connection($connectionName)->getPdo();
            if (method_exists($pdo, 'sqliteCreateFunction')) {
                $pdo->sqliteCreateFunction('md5', static fn (?string $value): ?string => $value === null ? null : md5($value));
                $pdo->sqliteCreateFunction('unhex', static fn (?string $value): ?string => $value);
            }
        } catch (\Throwable) {
            // ignore
        }
    }

    // ❌ SBAGLIATO: Crea tabelle manualmente (users, devices, device_user)
    if (! Schema::connection('user')->hasTable('users')) {
        Schema::connection('user')->create('users', function (Blueprint $table): void {
            // ... 15 righe di definizione manuale
        });
    }

    // ❌ SBAGLIATO: Crea altre tabelle manualmente
    if (! Schema::connection('user')->hasTable('devices')) {
        Schema::connection('user')->create('devices', function (Blueprint $table): void {
            // ... 15 righe di definizione manuale
        });
    }

    // ❌ SBAGLIATO: Controlla e aggiunge colonne manualmente
    if (Schema::connection('user')->hasTable('device_user') && ! Schema::connection('user')->hasColumn('device_user', 'login_at')) {
        Schema::connection('user')->table('device_user', function (Blueprint $table): void {
            $table->timestamp('login_at')->nullable();
        });
    }
}
```

### Perché È Sbagliato

1. **Ignora .env.testing** - MySQL configurato dall'utente viene sovrascritto con SQLite
2. **Funzioni Custom SQLite** - `md5()` e `unhex()` esistono già in MySQL!
3. **Viola DRY in modo ESTREMO** - Duplica 3 tabelle intere (users, devices, device_user)
4. **Viola KISS in modo ESTREMO** - 126 righe quando bastano ~30
5. **Manutenzione Nightmare** - Se le migration cambiano, il test non lo sa
6. **Viola indicazioni utente** - Opposto di ciò che richiesto

### MySQL Ha Già Queste Funzioni!

```sql
-- MySQL nativo:
SELECT MD5('test');        -- ✅ Funziona in MySQL
SELECT UNHEX('48656c6c6f'); -- ✅ Funziona in MySQL

-- SQLite invece le deve creare manualmente
```

---

## Soluzione

### Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Base test case for Xot module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'xot']);
        $this->artisan('migrate', ['--database' => 'user']);
    }
}
```

### Cosa Cambia

- ✅ Da 126 righe a ~25 righe (-80%)
- ✅ Usa MySQL da .env.testing
- ✅ Nessuna funzione custom (MySQL le ha già!)
- ✅ Nessuna creazione tabelle manuali
- ✅ Usa migration reali
- ✅ DatabaseTransactions per isolation
- ✅ Nessun override di configurazione
- ✅ Nessun controllo colonne manuale
- ✅ Rispetta DRY + KISS in modo ESTREMO

---

## Eliminazione Completa del Codice Legacy

**Tutto questo codice viene ELIMINATO:**

1. **52 righe** di configurazione SQLite
2. **20 righe** di funzioni custom SQLite
3. **18 righe** di creazione tabella users
4. **17 righe** di creazione tabella devices
5. **9 righe** di creazione tabella device_user
6. **10 righe** di controlli e aggiunte colonne

**Totale eliminato:** ~126 righe
**Nuovo codice:** ~25 righe
**Riduzione:** -80%

---

## Dipendenze Migration

Il modulo Xot dipende da:

1. **xot database** - Tabelle base Laraxot
2. **user database** - Tabella users (per relazioni con devices)

Le migration vengono eseguite automaticamente nel setUp().

---

## Note Importanti

### Perché Xot Module È Diverso

Xot è il modulo BASE che fornisce:
- XotBaseMigration
- XotBaseResource
- XotBaseServiceProvider
- CreatesApplication trait

È il CUORE dell'architettura Laraxot. Il suo TestCase deve essere:
- **Minimale** - Esempio per tutti gli altri
- **Corretto** - Usa MySQL come production
- **Semplice** - Nessuna complessità inutile

### APP_KEY Handling

Il vecchio codice aveva:
```php
if (! \is_string(config('app.key')) || config('app.key') === '') {
    $key = 'base64:'.base64_encode(str_repeat('x', 32));
    $this->app['config']->set('app.key', $key);
}
```

Questo è INUTILE perché:
- .env.testing ha già APP_KEY configurato
- Non serve generarlo dinamicamente
- Viola il principio "usa config esterna"

---

## Riferimenti

- Pattern: `Modules/Job/tests/TestCase.php`
- Pattern: `Modules/Activity/tests/TestCase.php`
- Pattern: `Modules/User/tests/TestCase.php`
- Pattern: `Modules/Gdpr/tests/TestCase.php`
- Filosofia: `Modules/Job/docs/testcase-philosophy-analysis.md`

---

**Data:** 2026-01-09
**Stato:** Pronto per implementazione
**Righe:** 126 → ~25 (-80%)
**Complessità:** ESTREMA → MINIMALE
**Filosofia:** MySQL Production = MySQL Tests ✅
