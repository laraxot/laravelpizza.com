# TDD Workflow - Laraxot

## Ciclo RED-GREEN-REFACTOR

1. **RED**: Scrivi il test che descrive il comportamento desiderato
2. **Verifica RED**: Esegui `php artisan test --filter=nome_test` — deve fallire
3. **GREEN**: Scrivi il minimo codice per far passare
4. **Verifica GREEN**: Esegui il test — deve passare
5. **REFACTOR**: Migliora il codice senza rompere i test

## Quando Applicare TDD

- Nuove feature (modelli, controller, API, form)
- Bug fix (prima il test che riproduce il bug)
- Refactoring (test come rete di sicurezza)

## Pattern per Moduli

### Test in `Modules/<Modulo>/tests/`

```
Modules/Activity/tests/
├── Feature/
│   └── ActivityLoggerTest.php
└── Unit/
    └── Models/
        └── ActivityTest.php
```

### Pest.php del modulo

```php
<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class)->in('Feature', 'Unit');
```

### TestCase del modulo

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Modules\Xot\Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //
}
```

## Filament TDD

Per Resource Filament (ListRecords, CreateRecord, EditRecord):

```php
Livewire::test(Resource\Pages\ListRecords::class)
    ->assertCanSeeTableRecords($records)
    ->assertTableActionExists('edit')
    ->callTableAction('edit', $record);

Livewire::test(Resource\Pages\CreateRecord::class)
    ->fillForm($data)
    ->call('create')
    ->assertHasNoErrors();
```

## Widget TDD

Per widget che usano XotData:

```php
beforeEach(function () {
    mockXotData();
});

Livewire::test(WidgetClass::class)
    ->assertStatus(200);
```

## Collegamenti

- [tdd-laravel-guide](../../../../../../docs/development/tdd-laravel-guide.md)
- [testing-best-practices](testing-best-practices.md)
- [testing-strategy](../testing-strategy.md)
