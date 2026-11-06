<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(\Modules\Notify\Tests\TestCase::class);
describe('NetfunSendAction', function () {
    it('has execute method returning array', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertSame('array', (string) $method->getReturnType());
        Assert::assertSame(SmsData::class, (string) $method->getParameters()[0]->getType());
    });

    it('uses strict types', function () {
        $filename = (new ReflectionClass(NetfunSendAction::class))->getFileName();
        Assert::assertNotFalse($filename);
        Assert::assertStringContainsString('declare(strict_types=1);', file_get_contents($filename));
    });

    it('uses QueueableAction trait', function () {
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', class_uses(NetfunSendAction::class));
    });
});