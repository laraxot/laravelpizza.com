<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('resolves the command catalogue action', function (): void {
    Assert::assertSame(GetCommandsAction::class, app(GetCommandsAction::class)::class);
});
