<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Actions\File\ViewPathAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('calculates view path correctly', function (): void {
    $nsMock = $this->createUnitMock(GetViewNameSpacePathAction::class);
    $nsMock->method('execute')
        ->with('test_ns')
        ->willReturn('/path/to/views');

    app()->instance(GetViewNameSpacePathAction::class, $nsMock);

    $fixMock = $this->createUnitMock(FixPathAction::class);
    $fixMock->method('execute')
        ->willReturnArgument(0);

    app()->instance(FixPathAction::class, $fixMock);

    $action = app(ViewPathAction::class);
    $result = $action->execute('test_ns::folder.file');

    Assert::assertSame('/path/to/views/folder/file.blade.php', $result);
});
