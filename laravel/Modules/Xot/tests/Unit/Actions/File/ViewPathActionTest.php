<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\ViewPathAction;
use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Tests\TestCase;
use Mockery;

uses(TestCase::class);

it('calculates view path correctly', function (): void {
    $this->mock(GetViewNameSpacePathAction::class)
        ->shouldReceive('execute')
        ->once()
        ->with('test_ns')
        ->andReturn('/path/to/views');

    $this->mock(FixPathAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturnArg(0);

    $action = app(ViewPathAction::class);
    $result = $action->execute('test_ns::folder.file');

    expect($result)->toBe('/path/to/views/folder/file.blade.php');
});
