<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Xot\Actions\GetViewByClassAction;


test('get view actions work', function () {
    $classAction = app(GetViewByClassAction::class);

    $mockView = \Mockery::mock(ViewContract::class);
    $mockView->shouldReceive('getName')->andReturn('test-view-action');

    View::shouldReceive('make')
        ->andReturn($mockView);

    $view = $classAction->execute('Modules\Xot\Actions\TestViewAction');
    expect($view->getName())->toBe('test-view-action');
});
