<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

it('casts various values to string correctly', function (): void {
    $action = app(SafeStringCastAction::class);

    Assert::assertSame('test', $action->execute('test'));
    Assert::assertSame('', $action->execute(null));
    Assert::assertSame('1', $action->execute(true));
    Assert::assertSame('0', $action->execute(false));
    Assert::assertSame('123', $action->execute(123));
    Assert::assertSame('1.23', $action->execute(1.23));
    // Non-scalar
    Assert::assertSame('', $action->execute(['a']));
    Assert::assertSame('', $action->execute(new stdClass()));
});

it('uses static string cast method correctly', function (): void {
    Assert::assertSame('456', SafeStringCastAction::cast(456));
});
