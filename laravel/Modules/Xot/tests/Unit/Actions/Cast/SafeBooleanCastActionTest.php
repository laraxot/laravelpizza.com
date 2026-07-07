<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeBooleanCastAction;
use PHPUnit\Framework\Assert;

it('casts various values to boolean correctly', function (): void {
    $action = app(SafeBooleanCastAction::class);

    // Booleans
    Assert::assertTrue($action->execute(true));
    Assert::assertFalse($action->execute(false));
    // Null
    Assert::assertTrue($action->execute(null, true));
    // Integers
    Assert::assertTrue($action->execute(1));
    Assert::assertFalse($action->execute(0));
    // Floats
    Assert::assertTrue($action->execute(1.1));
    Assert::assertFalse($action->execute(0.0));
    // Strings
    Assert::assertTrue($action->execute('true'));
    Assert::assertTrue($action->execute('yes'));
    Assert::assertFalse($action->execute('false'));
    Assert::assertFalse($action->execute('no'));
    Assert::assertFalse($action->execute(''));
    // Arrays
    Assert::assertTrue($action->execute(['a']));
    Assert::assertFalse($action->execute([]));
});
