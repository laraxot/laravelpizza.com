<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Blade;

use Illuminate\Support\Facades\Blade;
use Modules\Xot\Actions\Blade\RegisterBladeComponentsAction;
use Modules\Xot\Actions\File\GetComponentsAction;
use Modules\Xot\Datas\ComponentFileData;
use Tests\TestCase;

uses(TestCase::class);

test('register blade components action registers components', function () {
    $path = '/some/path';
    $namespace = 'Modules\Test';
    $prefix = 'test';

    $comp1 = ComponentFileData::from([
        'name' => 'test-comp',
        'ns' => 'Modules\Test\View\Components\TestComp',
        'class' => 'TestComp',
    ]);

    $mockCollection = ComponentFileData::collection([$comp1]);

    $this->mock(GetComponentsAction::class)
        ->shouldReceive('execute')
        ->with($path, $namespace.'\View\Components', $prefix)
        ->once()
        ->andReturn($mockCollection);

    Blade::shouldReceive('component')
        ->with($comp1->name, $comp1->ns)
        ->once();

    $action = app(RegisterBladeComponentsAction::class);
    $action->execute($path, $namespace, $prefix);
});
