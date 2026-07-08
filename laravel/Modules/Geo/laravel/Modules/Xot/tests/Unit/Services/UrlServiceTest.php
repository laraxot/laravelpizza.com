<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Url\IsValidUrlAction;
use PHPUnit\Framework\Assert;

it('validates correct urls', function (): void {
    $action = app(IsValidUrlAction::class);
    Assert::assertTrue($action->execute('https://google.com'));
    Assert::assertTrue($action->execute('http://localhost'));
    Assert::assertTrue($action->execute('ftp://server.com'));
});

it('invalidates incorrect urls', function (): void {
    $action = app(IsValidUrlAction::class);
    Assert::assertFalse($action->execute('not-a-url'));
    Assert::assertFalse($action->execute('http:///double-slash'));
    Assert::assertFalse($action->execute(''));
});
