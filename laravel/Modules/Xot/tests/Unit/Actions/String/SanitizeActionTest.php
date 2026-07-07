<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\String\SanitizeAction;
use PHPUnit\Framework\Assert;

it('sanitizes strings correctly', function (): void {
    $action = app(SanitizeAction::class);

    $input = " <script>alert('xss')</script> <b>Hello</b> &amp; Welcome! ";
    $expected = "alert('xss') Hello & Welcome!";

    Assert::assertSame($expected, $action->execute($input));
});
