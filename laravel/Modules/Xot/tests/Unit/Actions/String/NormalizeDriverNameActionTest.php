<?php

declare(strict_types=1);
use Modules\Xot\Actions\String\NormalizeDriverNameAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('normalizes driver names correctly', function (): void {
    $action = app(NormalizeDriverNameAction::class);

    Assert::assertSame('360dialog', $action->execute('360-Dialog'));
    Assert::assertSame('mydriver', $action->execute('My_Driver'));
    Assert::assertSame('spacesinname', $action->execute('Spaces In Name'));
    Assert::assertSame('uppercase', $action->execute('UPPERcase'));
});
