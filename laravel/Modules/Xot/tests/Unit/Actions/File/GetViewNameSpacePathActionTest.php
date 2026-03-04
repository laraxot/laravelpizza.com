<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\View;
use Mockery;

uses(TestCase::class);

it('gets view namespace path from registered hints correctly', function (): void {
    $ns = 'test_ns';
    $path = '/some/view/path';
    
    $finder = Mockery::mock(\Illuminate\View\ViewFinderInterface::class);
    $finder->shouldReceive('getHints')->andReturn([$ns => [$path]]);

    View::shouldReceive('getViewFinder')->andReturn($finder);

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    expect($result)->toBe($path);
});
