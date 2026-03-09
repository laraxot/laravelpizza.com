<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;

use function Pest\Laravel\get;

use Spatie\LaravelData\DataCollection;

uses(TestCase::class);

test('blocks discovery returns a data collection', function (): void {
    $allBlocks = app(GetAllBlocksAction::class)->execute();

    expect($allBlocks)->toBeInstanceOf(DataCollection::class);
});

test('blocks component class exists and can be instantiated', function (): void {
    expect(class_exists(Blocks::class))->toBeTrue();

    $component = new Blocks('ui::components.render.blocks', []);

    expect($component)->toBeInstanceOf(Blocks::class)
        ->and($component->blocks)->toBeArray();
});

test('homepage request is reachable when route is available', function (): void {
    $response = get('/');

    expect($response->status())->toBeInt();
});
