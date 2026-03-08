<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Blade;

use Illuminate\Support\Facades\Blade;
use Modules\Xot\Actions\Blade\RegisterBladeComponentsAction;
use Modules\Xot\Actions\File\GetComponentsAction;
use Modules\Xot\Datas\ComponentFileData;

it('registers blade components correctly', function (): void {
    $path = 'some/path';
    $namespace = 'Some\\Namespace';
    $prefix = 'prefix';

    $comp1 = ComponentFileData::from([
        'name' => 'test-comp',
        'ns' => 'Some\\Namespace\\View\\Components\\TestComp',
        'class' => 'TestComp',
    ]);

    $mockComps = ComponentFileData::collection([$comp1]);

    $this->mock(GetComponentsAction::class
        ->shouldReceive('execute')
        ->once()
        ->with($path, $namespace.'\\View\\Components', $prefix)
        ->andReturn($mockComps);

    Blade::shouldReceive('component')
        ->once()
        ->with('test-comp', 'Some\\Namespace\\View\\Components\\TestComp');

    $action = app(RegisterBladeComponentsAction::class);
    $action->execute($path, $namespace, $prefix);
});

it('does nothing if no components found', function (): void {
    $path = 'empty/path';
    $namespace = 'Empty\\Namespace';

    $mockComps = ComponentFileData::collection([]);

    $this->mock(GetComponentsAction::class
        ->shouldReceive('execute')
        ->once()
        ->andReturn($mockComps);

    Blade::shouldReceive('component')->never();

    $action = app(RegisterBladeComponentsAction::class);
    $action->execute($path, $namespace);
});
