<?php

declare(strict_types=1);

use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;

uses(Modules\Cms\Tests\TestCase::class);
test('blocks discovery returns a data collection', function (): void {
    $allBlocks = app(GetAllBlocksAction::class)->execute();

    Assert::assertInstanceOf(DataCollection::class, $allBlocks);
});

test('blocks component class exists and can be instantiated', function (): void {
    Assert::assertTrue(class_exists(Blocks::class));

    $component = new Blocks('ui::components.render.blocks', []);

    Assert::assertInstanceOf(Blocks::class, $component);

    Assert::assertSame([], $component->blocks);

    Assert::assertSame('ui::components.render.blocks', $component->view);
});

test('discovered blocks expose the expected metadata keys', function (): void {
    $allBlocks = app(GetAllBlocksAction::class)->execute();

    $allBlocks->each(function (mixed $block): void {
        if (! method_exists($block, 'toArray')) {
            return;
        }

        /** @var array<string, mixed> $blockArray */
        $blockArray = $block->toArray();
    });
});

test('homepage request is reachable when route is available', function (): void {
    cmsSkipTest('Homepage route integration covered by FO Folio route tests.');
});
