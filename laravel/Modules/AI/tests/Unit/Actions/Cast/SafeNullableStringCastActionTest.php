<?php

declare(strict_types=1);
use Modules\Xot\Actions\Cast\SafeNullableStringCastAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('casts nullable string values consistently', function (): void {
    $action = app(SafeNullableStringCastAction::class);

    Assert::assertSame('test', $action->execute('test'));
    Assert::assertSame('123', $action->execute(123));
    Assert::assertSame('1', $action->execute(true));
    Assert::assertNull($action->execute(null));
    Assert::assertNull($action->execute([]));
    Assert::assertNull($action->execute(new stdClass));
});

it('uses static nullable string cast method correctly', function (): void {
    Assert::assertSame('456', SafeNullableStringCastAction::cast(456));
    Assert::assertNull(SafeNullableStringCastAction::cast(null));
});
