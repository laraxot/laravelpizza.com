<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;

test('replicate indennita rejects null filters', function (): void {
    expect(fn () => (new ReplicateIndennita())->execute(null))
        ->toThrow(\InvalidArgumentException::class);
});

test('replicate indennita requires anno', function (): void {
    expect(fn () => (new ReplicateIndennita())->execute([
        'anno/valutatore' => ['quadrimestre' => 2],
    ]))->toThrow(\InvalidArgumentException::class);
});

test('replicate indennita requires quadrimestre', function (): void {
    expect(fn () => (new ReplicateIndennita())->execute([
        'anno/valutatore' => ['anno' => 2026],
    ]))->toThrow(\InvalidArgumentException::class);
});
