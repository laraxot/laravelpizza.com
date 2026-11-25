<?php

declare(strict_types=1);
use Modules\Xot\Actions\String\SanitizeAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('sanitizes strings correctly', function (): void {
    $action = app(SanitizeAction::class);

    $input = " <script>alert('xss')</script> <b>Hello</b> &amp; Welcome! ";
    $expected = "alert('xss') Hello & Welcome!";

    Assert::assertSame($expected, $action->execute($input));
});
