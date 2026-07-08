<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;
use PHPUnit\Framework\Assert;

/**
 * @param array{anno/valutatore?: array{anno?: int, quadrimestre?: int}, anno?: int, quadrimestre?: int} $data
 * @return array{anno?: int, quadrimestre?: int}
 */
function replicateFilterInputForTest(array $data): array
{
    return $data['anno/valutatore'] ?? $data;
}

test('replicate action extracts filters from nested table filters', function (): void {
    $input = replicateFilterInputForTest([
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 2,
        ],
    ]);

    Assert::assertSame(['anno' => 2026, 'quadrimestre' => 2], $input);
    Assert::assertSame(2026, $input['anno']);
    Assert::assertSame(2, $input['quadrimestre']);
});

test('replicate action accepts flattened data array as fallback', function (): void {
    $input = replicateFilterInputForTest([
        'anno' => 2026,
        'quadrimestre' => 1,
    ]);

    Assert::assertSame(['anno' => 2026, 'quadrimestre' => 1], $input);
});

test('replicate action throws exception when table filters are incomplete', function (): void {
    $action = new ReplicateIndennita();

    expect(fn () => $action->execute(['anno/valutatore' => ['quadrimestre' => 2]]))
        ->toThrow(\InvalidArgumentException::class);

    expect(fn () => $action->execute(['anno/valutatore' => ['anno' => 2026]]))
        ->toThrow(\InvalidArgumentException::class);

    expect(fn () => $action->execute(null))
        ->toThrow(\InvalidArgumentException::class);
});
