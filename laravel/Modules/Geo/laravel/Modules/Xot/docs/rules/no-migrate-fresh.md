# REGOLA ASSOLUTA: MAI migrate:fresh nei test

## Status: CRITICAL

**Questa regola è assoluta e non negoziabile.**

## Perché è vietato

### Problemi causati da migrate:fresh

1. **Distruttivo**: migrate:fresh cancella TUTTE le tabelle e ricrea il database da zero
2. **Non isolato**: Rompe l'isolamento dei test, influenzando altri test in esecuzione
3. **Race conditions**: In CI/CD o test paralleli, può causare errori intermittenti
4. **Perdita dati**: Se il database è condiviso (anche solo per test), si perdono tutti i dati
5. **Lento**: Ricreare tutte le tabelle ad ogni test è inefficiente

## Soluzione corretta

### Usare DatabaseTransactions

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;
    
    // ...
}
```

### Oppure RefreshDatabase (per test che modificano lo schema)

```php
<?php

declare(strict_types=1);

uses(TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
```

## Anti-pattern vietato

```php
<?php

// ❌ MAI FARE QUESTO - DISTRUTTIVO!
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('migrate:fresh'); // ❌ ASSOLUTAMENTE VIETATO
});

// ❌ MAI FARE QUESTO
it('creates table', function () {
    Artisan::call('migrate:fresh --seed'); // ❌ ASSOLUTAMENTE VIETATO
    // ...
});
```

## Pattern corretto

```php
<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

// ✅ CORRETTO: Usa transazioni per isolamento
it('can create user', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class);
});
```

## Test con setup del database

Se necessario configurare il database una sola volta per tutto il test suite:

```php
<?php

// ✅ CORRETTO: Configurazione nel phpunit.xml o Pest configuration
// Non nel test!

// phpunit.xml
<php>
    <env name="DB_CONNECTION" value="testing"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

## Collegamenti

- [Laravel Testing Docs](https://laravel.com/docs/database-testing)
- [Pest Database Testing](https://pestphp.com/docs/database-testing)
- [XotBaseTestCase](../XotBaseTestCase.md)

---
**Data creazione**: 2025-03-04  
**Ultima modifica**: 2025-03-04  
**Autore**: System
