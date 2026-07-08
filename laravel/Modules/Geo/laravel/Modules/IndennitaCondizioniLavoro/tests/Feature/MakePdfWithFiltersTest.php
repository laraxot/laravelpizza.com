<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use PHPUnit\Framework\Assert;

/**
 * @param array{anno/valutatore?: array{anno?: int, valutatore_id?: int}, anno?: int, valutatore_id?: int} $data
 * @return array{anno?: int, valutatore_id?: int}
 */
function makePdfFilterInputForTest(array $data): array
{
    return $data['anno/valutatore'] ?? $data;
}

test('make pdf action extracts filters from nested table filters', function (): void {
    $filtersInput = makePdfFilterInputForTest([
        'anno/valutatore' => [
            'anno' => 2026,
            'valutatore_id' => 50,
        ],
    ]);

    Assert::assertSame(['anno' => 2026, 'valutatore_id' => 50], $filtersInput);
    Assert::assertSame(2026, $filtersInput['anno']);
    Assert::assertSame(50, $filtersInput['valutatore_id']);
});

test('make pdf action accepts flattened data array as fallback', function (): void {
    $filtersInput = makePdfFilterInputForTest([
        'anno' => 2026,
        'valutatore_id' => 70,
    ]);

    Assert::assertSame(['anno' => 2026, 'valutatore_id' => 70], $filtersInput);
});

test('make pdf action throws exception when table filters are incomplete', function (): void {
    $action = new MakePdf();

    expect(fn () => $action->execute(['anno/valutatore' => ['valutatore_id' => 50]]))
        ->toThrow(\InvalidArgumentException::class);

    expect(fn () => $action->execute(['anno/valutatore' => ['anno' => 2026]]))
        ->toThrow(\InvalidArgumentException::class);

    expect(fn () => $action->execute(null))
        ->toThrow(\InvalidArgumentException::class);
});

test('make pdf action generates correct filename pattern', function (): void {
    Assert::assertSame('condizioni_lavoro_80_2026.pdf', sprintf('condizioni_lavoro_%d_%d.pdf', 80, 2026));
});
