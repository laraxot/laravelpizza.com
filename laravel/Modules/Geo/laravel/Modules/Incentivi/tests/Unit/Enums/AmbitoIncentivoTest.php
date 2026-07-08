<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Enums;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Enums\AmbitoIncentivo;

uses(TestCase::class);

test('ambito incentivo has correct labels', function (AmbitoIncentivo $ambito, string $expectedLabel): void {
    expect($ambito->getLabel())->toBe($expectedLabel);
})->with([
    [AmbitoIncentivo::Lavori, 'Lavori'],
    [AmbitoIncentivo::Servizi, 'Servizi'],
    [AmbitoIncentivo::Misti, 'Misti'],
]);

test('ambito incentivo has correct colors', function (AmbitoIncentivo $ambito, string $expectedColor): void {
    expect($ambito->getColor())->toBe($expectedColor);
})->with([
    [AmbitoIncentivo::Lavori, 'info'],
    [AmbitoIncentivo::Servizi, 'warning'],
    [AmbitoIncentivo::Misti, 'danger'],
]);

test('ambito incentivo has correct icons', function (AmbitoIncentivo $ambito, string $expectedIcon): void {
    expect($ambito->getIcon())->toBe($expectedIcon);
})->with([
    [AmbitoIncentivo::Lavori, 'heroicon-m-pencil-square'],
    [AmbitoIncentivo::Servizi, 'heroicon-m-star'],
    [AmbitoIncentivo::Misti, 'heroicon-m-x-circle'],
]);

test('ambito incentivo can be cast from string', function (): void {
    $ambito = AmbitoIncentivo::from('Lavori');
    expect($ambito)->toBe(AmbitoIncentivo::Lavori);
});

test('ambito incentivo values match database values', function (): void {
    expect(AmbitoIncentivo::Lavori->value)->toBe('Lavori')
        ->and(AmbitoIncentivo::Servizi->value)->toBe('Servizi')
        ->and(AmbitoIncentivo::Misti->value)->toBe('Misti');
});
