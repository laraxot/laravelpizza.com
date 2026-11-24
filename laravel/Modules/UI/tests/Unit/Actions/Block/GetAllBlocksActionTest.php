<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Contratto: docs/contracts/get-all-blocks-action.md. Legge i blocchi reali dei moduli installati.
 */

it('discovers blocks only from Modules/*/app/Filament/Blocks and derives module from the namespace', function (): void {
    $blocks = app(GetAllBlocksAction::class)->execute();

    expect($blocks->count())->toBeGreaterThan(0);
    foreach ($blocks as $block) {
        Assert::assertIsString($block->module);
        expect($block->path)->toBeString()
            ->and((string) $block->path)->toMatch('#/Modules/'.preg_quote($block->module, '#').'/app/Filament/Blocks/[^/]+\.php$#')
            ->and(class_exists($block->class))->toBeTrue();
    }
})->group('UI-BLOCKS-INV-1');

it('names a block as the snake case class basename without the _block suffix', function (): void {
    foreach (app(GetAllBlocksAction::class)->execute() as $block) {
        $expected = Str::of(class_basename($block->class))->snake()->toString();
        if (Str::endsWith($expected, '_block')) {
            $expected = Str::before($expected, '_block');
        }

        expect($block->name)->toBe($expected)->not->toEndWith('_block');
    }
})->group('UI-BLOCKS-INV-2');
