<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\CapitalPercentage;

uses(TestCase::class);

test('it can create a capital percentage range', function () {
    $cp = CapitalPercentage::factory()->create([
        'tipologia' => 'Tipo Speciale',
        'valore' => 5.5,
    ]);

    expect($cp->tipologia)->toBe('Tipo Speciale');
    expect((float) $cp->valore)->toBe(5.5);

    $this->assertDatabaseHas('capital_percentages', [
        'id' => $cp->id,
        'tipologia' => 'Tipo Speciale',
    ], 'incentivi');
});

test('a capital percentage has range boundaries', function () {
    $cp = CapitalPercentage::factory()->create([
        'da' => 50000,
        'a' => 100000,
        'valore' => 2.0,
    ]);

    expect((float) $cp->da)->toBe(50000.0)
        ->and((float) $cp->a)->toBe(100000.0)
        ->and((float) $cp->valore)->toBe(2.0);
});

test('capital percentage can be queried by range', function () {
    CapitalPercentage::factory()->create([
        'tipologia' => 'TestRange',
        'da' => 0,
        'a' => 50000,
        'valore' => 1.0,
    ]);

    CapitalPercentage::factory()->create([
        'tipologia' => 'TestRange',
        'da' => 50001,
        'a' => 100000,
        'valore' => 2.0,
    ]);

    $result = CapitalPercentage::where('tipologia', 'TestRange')
        ->where('da', '<=', 75000)
        ->where('a', '>=', 75000)
        ->first();

    expect($result)->not->toBeNull();
    expect((float) $result->valore)->toBe(2.0);
});

test('capital percentage returns null when amount is outside range', function () {
    CapitalPercentage::factory()->create([
        'tipologia' => 'OutsideRangeTest',
        'da' => 50000,
        'a' => 100000,
        'valore' => 2.0,
    ]);

    $result = CapitalPercentage::where('tipologia', 'OutsideRangeTest')
        ->where('da', '<=', 150000)
        ->where('a', '>=', 150000)
        ->first();

    expect($result)->toBeNull();
});
