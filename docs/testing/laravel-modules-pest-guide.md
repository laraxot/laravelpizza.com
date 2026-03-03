# Pest con Laravel Modules - Guida Completa

Guida per configurare e scrivere test Pest nei moduli e nei temi Laraxot, basata su [Laravel Modules Tests](https://laravelmodules.com/docs/12/advanced/tests).

## Regole Fondamentali

- **Obiettivo:** 100% coverage su tutto il progetto (app + tutti i moduli).
- **Struttura:** Ogni modulo ha `composer.json` e cartella `tests/`.
- **Pest only:** Mai PHPUnit classico; tutti i test in Pest.
- **❌ MAI RefreshDatabase:** Usare `DatabaseTransactions` nel TestCase.

## Riferimento Laravel Modules

- **phpunit.xml**: testsuite Modules con directory per modulo
- **Pest**: `uses(TestCase::class)` per modulo
- **Filter**: `--filter 'modulename'` per eseguire test di un singolo modulo

## Struttura Test nei Moduli

```
Modules/<ModuleName>/
├── tests/
│   ├── Feature/          # Test feature (HTTP, Livewire, integrazione)
│   │   └── *.php
│   ├── Unit/             # Test unitari (logica isolata)
│   │   └── *.php
│   ├── Pest.php          # Config Pest del modulo
│   └── TestCase.php      # Base test case (opzionale, se diverso da Xot)
```

## Pest.php per Modulo

Ogni modulo deve avere `tests/Pest.php` che registra il TestCase **del modulo** (che estende XotBaseTestCase):

```php
<?php

declare(strict_types=1);

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');
```

**Regola TestCase (DRY + KISS + Laraxot):** tutti i `Modules/*/tests/TestCase.php` estendono `Modules\Xot\Tests\XotBaseTestCase`, mai `Illuminate\Foundation\Testing\TestCase`. Vedi [testcase-xotbase-extends](../.cursor/rules/testcase-xotbase-extends.mdc).

## Regole Critiche

### 1. Nessun namespace nei file Pest

```php
// ❌ ERRATO
<?php
namespace Modules\Cms\Tests\Feature\Auth;

// ✅ CORRETTO
<?php
declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
uses(TestCase::class);
```

### 2. DatabaseTransactions (non RefreshDatabase)

Usare `DatabaseTransactions` nel TestCase per isolamento senza ricreare schema. Le migrazioni vanno eseguite **una volta** sul DB di test:

```bash
APP_ENV=testing DB_DATABASE=laravelpizza_data_test DB_DATABASE_USER=laravelpizza_user_test php artisan migrate:fresh --force
```

Moduli con connessioni dedicate (es. Activity) richiedono che il DB test sia migrato **una volta** prima dei test:

```bash
php artisan migrate --env=testing --force
```

### 3. TestCase per modulo

- **Moduli semplici**: usare `Modules\Xot\Tests\TestCase`
- **Moduli con config specifica**: creare `Modules\<Module>\Tests\TestCase` che estende Xot e configura pub_theme, main_module, providers

### 4. XotData per risoluzione dinamica

```php
use Modules\Xot\Datas\XotData;

$userClass = XotData::make()->getUserClass();
```

## Comandi Esecuzione

```bash
# Tutti i test
php artisan test
# oppure
./vendor/bin/pest

# Singolo modulo (filter sul nome)
php artisan test --filter 'Meetup'
./vendor/bin/pest --filter 'Meetup'

# Singolo file
php artisan test Modules/Meetup/tests/Feature/HeaderNavigationTest.php

# Singolo test
php artisan test --filter 'can_display_login_page'

# Con coverage (Pest + Xdebug/PCOV)
php artisan test --coverage
./vendor/bin/pest --coverage
# Report per moduli (scrive Modules/<Module>/docs/coverage.md)
bash bashscripts/testing/generate-coverage.sh
```

## Checklist Nuovo Modulo

1. Creare `Modules/<Module>/tests/Pest.php` con `uses(TestCase::class)->in('Feature','Unit')`
2. Se serve config specifica: creare `Modules/<Module>/tests/TestCase.php`
3. Aggiungere `Modules/<Module>/tests` in phpunit.xml (testsuite Modules)
4. Creare `tests/Feature/` e `tests/Unit/`
5. Scrivere test con `test('descrizione', fn() => ...)` o `it('descrizione', fn() => ...)`

## Checklist Nuovo Tema

I temi non hanno tests dedicati in Laravel Modules. I test che coinvolgono il tema vanno in:
- `Modules/Cms/tests/` per routing Folio e blocchi
- `Modules/Meetup/tests/` per pagine specifiche del tema Meetup

Configurare `xra.pub_theme` nel TestCase quando serve un tema specifico.

## Collegamenti

- [Laravel Modules Tests](https://laravelmodules.com/docs/12/advanced/tests)
- [PestPHP](https://pestphp.com)
- [testing-guidelines](../../.agents/docs/agents-guide/08-testing/testing-guidelines.md)
- [Cms pestphp-best-practices](../../laravel/Modules/Cms/docs/tests/pestphp-best-practices.md)
- [Meetup testing](../../laravel/Modules/Meetup/docs/testing.md)
