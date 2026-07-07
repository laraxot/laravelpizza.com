<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('normalizes path slashes correctly', function (): void {
    $action = app(FixPathAction::class);

    $path = 'some/path\with/mixed\\slashes';
    $expected = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $path);

    Assert::assertSame($expected, $action->execute($path));
});
