<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Blade;

use Mockery\MockInterface;
use Modules\Xot\Actions\Blade\RegisterBladeComponentsAction;
use Modules\Xot\Actions\File\GetComponentsAction;
use Modules\Xot\Datas\ComponentFileData;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;

uses(TestCase::class);

it('registers blade components correctly', function (): void {
    $path = 'some/path';
    $namespace = 'Some\\Namespace';
    $prefix = 'prefix';

    /** @var DataCollection<int, ComponentFileData> $mockComps */
    $mockComps = ComponentFileData::collection([
        [
            'name' => 'test-comp',
            'ns' => 'Some\\Namespace\\View\\Components\\TestComp',
            'class' => 'TestComp',
        ],
    ]);

    /** @var GetComponentsAction&MockInterface $getComponents */
    $getComponents = \Mockery::mock(GetComponentsAction::class);
    $getComponents->allows(['execute' => $mockComps]);
    app()->instance(GetComponentsAction::class, $getComponents);

    $action = app(RegisterBladeComponentsAction::class);
    Assert::assertCount(1, $mockComps);

    $action->execute($path, $namespace, $prefix);
});

it('does nothing if no components found', function (): void {
    $path = 'empty/path';
    $namespace = 'Empty\\Namespace';

    /** @var DataCollection<int, ComponentFileData> $mockComps */
    $mockComps = ComponentFileData::collection([]);

    /** @var GetComponentsAction&MockInterface $getComponents */
    $getComponents = \Mockery::mock(GetComponentsAction::class);
    $getComponents->allows(['execute' => $mockComps]);
    app()->instance(GetComponentsAction::class, $getComponents);

    $action = app(RegisterBladeComponentsAction::class);
    Assert::assertInstanceOf(RegisterBladeComponentsAction::class, $action);
    Assert::assertCount(0, $mockComps);

    $action->execute($path, $namespace);
});
