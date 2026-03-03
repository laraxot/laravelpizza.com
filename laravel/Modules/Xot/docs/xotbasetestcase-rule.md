# XotBaseTestCase - Testing Architecture Rule

## Regola Fondamentale

**TUTTI** i TestCase dei moduli **DEVONO** estendere `Modules\Xot\Tests\XotBaseTestCase`.

**MAI** estendere direttamente `Illuminate\Foundation\Testing\TestCase`.

## Filosofia

### DRY (Don't Repeat Yourself)
- Setup comune centralizzato in `XotBaseTestCase::setUp()`
- Translator, config bindings in un solo posto
- Helper methods riutilizzabili (`generateUniqueEmail()`, `createTestUser()`)

### KISS (Keep It Simple, Stupid)
- Ogni modulo aggiunge solo i suoi specifici provider
- Nessuna duplicazione di logica di bootstrap
- Pattern consistente across tutti i moduli

### Laraxot Architecture
- Gerarchia di ereditarietà chiara e consistente
- Modularità e riusabilità
- Nessun lock-in con framework specifici

### Zen
- Un solo punto di verità
- Setup automatico, zero configurazione manuale ripetuta
- Serenità del codice: tutti i moduli si comportano allo stesso modo

## Implementazione Corretta

### Template TestCase per Nuovo Modulo

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests;

use Modules\NomeModulo\Providers\NomeModuloServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for NomeModulo module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    /**
     * Database connections for transactions.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = [
        'mysql',
        'user',
        'nomemodulo', // Se il modulo ha il proprio DB
    ];

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            NomeModuloServiceProvider::class,
        ];
    }
}
```

### Cosa Fornisce XotBaseTestCase

1. **CreatesApplication** - Bootstrap Laravel per testing
2. **Translator Binding** - Per test Filament senza errori
3. **Helper Methods**:
   - `generateUniqueEmail()` - Email uniche per test
   - `getUserClass()` - Classe utente dal config
   - `createTestUser()` - Factory con default
4. **Service Providers** - XotServiceProvider automatico

## Anti-Pattern (VIETATO)

```php
<?php

namespace Modules\NomeModulo\Tests;

// ❌ ERRATO - MAI FARE QUESTO
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Duplicazione del setup in ogni modulo!
    protected function setUp(): void
    {
        parent::setUp();
        // Ripetere qui tutta la logica di XotBaseTestCase...
    }
}
```

## Moduli Conformi

| Modulo | Status | Note |
|--------|--------|------|
| Activity | ✅ | Estende XotBaseTestCase |
| Cms | ✅ | Estende XotBaseTestCase |
| Gdpr | ✅ | Estende XotBaseTestCase |
| Geo | ✅ | Estende XotBaseTestCase |
| Job | ✅ | Estende XotBaseTestCase |
| Lang | ✅ | Estende XotBaseTestCase |
| Media | ✅ | Estende XotBaseTestCase |
| Meetup | ✅ | Estende XotBaseTestCase |
| Notify | ✅ | Estende XotBaseTestCase |
| Seo | ✅ | Estende XotBaseTestCase |
| Tenant | ✅ | Estende XotBaseTestCase |
| UI | ✅ | Estende XotBaseTestCase |
| User | ✅ | Estende XotBaseTestCase |
| Xot | ✅ | XotBaseTestCase definisce la base |

## Vantaggi

1. **Consistenza** - Tutti i moduli testano allo stesso modo
2. **Manutenibilità** - Cambiamenti in un solo punto
3. **Velocità** - Setup automatico, zero configurazione manuale
4. **Affidabilità** - Configurazione testata e consolidata
5. **DRY** - Nessuna duplicazione di codice

## Testing Pattern

```php
<?php

use Modules\Xot\Actions\SomeAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(SomeAction::class);
});

it('performs expected behavior', function (): void {
    $result = $this->action->execute('input');
    expect($result)->toBe('expected');
});
```

## Collegamenti

- [XotBaseTestCase Implementation](../tests/XotBaseTestCase.php)
- [Xot Module TestCase](../tests/TestCase.php)
- [Testing Strategy](./testing-strategy.md)
