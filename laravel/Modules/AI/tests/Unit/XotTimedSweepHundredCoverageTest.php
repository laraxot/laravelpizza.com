<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Enums\DayOfWeek;
use Modules\Xot\Tests\ModuleBusinessCoverage;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('day transitions wrap the week and preserve the weekend boundary', function (): void {
    expect(DayOfWeek::FRIDAY->next())->toBe(DayOfWeek::SATURDAY)
        ->and(DayOfWeek::SATURDAY->isWeekend())->toBeTrue()
        ->and(DayOfWeek::SUNDAY->next())->toBe(DayOfWeek::MONDAY)
        ->and(DayOfWeek::MONDAY->isWeekend())->toBeFalse()
        ->and(DayOfWeek::workingDays()->all())->toHaveCount(5)
        ->and(DayOfWeek::weekendDays()->values()->all())->toBe([DayOfWeek::SATURDAY, DayOfWeek::SUNDAY]);
});

test('pure action discovery returns concrete sorted class names', function (): void {
    $classes = ModuleBusinessCoverage::discoverPhpClasses(
        dirname(__DIR__, 2).'/app',
        'Modules\\Xot\\',
        'Actions/Arr',
    );

    expect($classes)->not->toBeEmpty()
        ->and($classes)->toBe(array_values(array_unique($classes)));

    $sorted = $classes;
    sort($sorted);
    expect($classes)->toBe($sorted);
});
