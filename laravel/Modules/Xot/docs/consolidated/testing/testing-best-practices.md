# Testing Best Practices - Laraxot Framework

## 🏆 Gold Standard per i Test

- Preferire Pest a PHPUnit class-based.
- Usare `uses(\Modules\Xot\Tests\TestCase::class)` come base dei test.
- Mockare sempre `XotData` in `beforeEach()` e registrarlo nel container.
- Separare Page tests (routing/render) e Widget tests (logica Filament/Livewire).

### Esempio Widget (Livewire/Filament)
```php
<?php
declare(strict_types=1);

use Livewire\\Livewire;
use Modules\\{Module}\\Filament\\Widgets\\{WidgetName};

uses(\\Modules\\Xot\\Tests\\TestCase::class);

beforeEach(function (): void {
    mockXotData();
});

test('widget can be rendered', function () {
    Livewire::test({WidgetName}::class)
        ->assertStatus(200);
});
```

### Esempio unit test semplice
```php
<?php
declare(strict_types=1);

use Illuminate\\Database\\Eloquent\\Relations\\Pivot;
use Modules\\Xot\\Models\\BaseMorphPivot;

it('extends pivot class', function () {
    $pivot = new BaseMorphPivot();
    expect($pivot)->toBeInstanceOf(Pivot::class);
});
```

### Mock XotData (obbligatorio)
```php
function mockXotData(): void
{
    $mock = \\Mockery::mock(\\Modules\\Xot\\Datas\\XotData::class)->makePartial();
    $mock->shouldReceive('getUserClass')->andReturn(\\Modules\\<nome progetto>\\Models\\User::class);
    $mock->shouldReceive('make')->andReturn($mock);
    app()->instance(\\Modules\\Xot\\Datas\\XotData::class, $mock);
}
```

## 🚨 Regole Architetturali

- Page vs Widget: non mischiare responsabilità nei test.
- Base TestCase: usare sempre `\\Modules\\Xot\\Tests\\TestCase`.
- Mock coerente delle dipendenze (XotData, servizi esterni).

## ❌ Anti-pattern da evitare

- TestCase errato (es. `Tests\\\\TestCase`).
- Dataset eccessivamente complessi e non necessari.
- Mock senza `makePartial()` o non registrati nel container.

## 📊 Strategia Coverage

- Widget: rendering (200), interazioni form, validazioni, integrazioni (XotData), lifecycle.
- Page: route/status, contenuto, middleware, elementi UI principali.

## 🔧 Workflow

- Pre: definire architettura e template, predisporre mock.
- Durante: TDD dove possibile, esecuzioni frequenti, attenzione alle performance.
- Post: code review, aggiornamento documentazione, benchmark suite.

## 🔗 Documentazione correlata

- Widget Test Patterns (Cms)
- Architecture Separation Rules (Cms)
- XotData Testing Strategy (XOTDATA_TESTING.md)

Status: Best Practices consolidate — Last Update: Dicembre 2024


