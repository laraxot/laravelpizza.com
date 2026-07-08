<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use PHPUnit\Framework\Assert;

test('make pdf rejects null filters', function (): void {
    expect(fn () => (new MakePdf())->execute(null))
        ->toThrow(\InvalidArgumentException::class);
});

test('make pdf requires anno', function (): void {
    expect(fn () => (new MakePdf())->execute([
        'anno/valutatore' => ['valutatore_id' => 50],
    ]))->toThrow(\InvalidArgumentException::class);
});

test('make pdf requires valutatore id', function (): void {
    expect(fn () => (new MakePdf())->execute([
        'anno/valutatore' => ['anno' => 2026],
    ]))->toThrow(\InvalidArgumentException::class);
});

test('make pdf uses canonical filename pattern', function (): void {
    Assert::assertSame('condizioni_lavoro_80_2026.pdf', sprintf('condizioni_lavoro_%d_%d.pdf', 80, 2026));
});
