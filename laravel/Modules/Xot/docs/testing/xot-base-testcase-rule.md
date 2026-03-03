# XotBaseTestCase Rule

## Regola
Tutti i file `Modules/*/tests/TestCase.php` devono estendere:

```php
Modules\Xot\Tests\XotBaseTestCase
```

## Perché (DRY + KISS + Laraxot)
- Un solo bootstrap condiviso (`CreatesApplication`, translator binding, helper comuni).
- Meno duplicazione tra moduli.
- Minore divergenza di comportamento nei test cross-modulo.
- Migliore manutenzione quando cambia l'infrastruttura di test.

## Anti-pattern vietato

```php
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // no
}
```

## Pattern corretto

```php
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    // yes
}
```
