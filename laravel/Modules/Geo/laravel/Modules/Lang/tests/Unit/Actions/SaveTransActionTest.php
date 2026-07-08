<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('SaveTransAction', function (): void {
    test('it has execute method', function (): void {
        $action = app(SaveTransAction::class);

        Assert::assertTrue(is_callable([$action, 'execute']));
    });

    test('action is invokable via app', function (): void {
        Assert::assertInstanceOf(SaveTransAction::class, app(SaveTransAction::class));
    });
});
