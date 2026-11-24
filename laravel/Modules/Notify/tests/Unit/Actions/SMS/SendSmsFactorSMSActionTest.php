<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);
describe('SendSmsFactorSMSAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('implements SmsActionContract', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $interfaces = $reflection->getInterfaceNames();

        Assert::assertContains(SmsActionContract::class, $interfaces);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        XotBasePest::assertReflectionTypeName($params[0]->getType(), SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        XotBasePest::assertReflectionTypeName($returnType, 'array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $content = TestCase::notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);

        Assert::assertSame('Modules\Notify\Actions\SMS', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = TestCase::notifyReflectionSource(new \ReflectionClass(SendSmsFactorSMSAction::class));
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendSmsFactorSMSAction::class);
        Assert::assertArrayHasKey('Spatie\QueueableAction\QueueableAction', $traits);
    });

    it('has protected debug property', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $property = $reflection->getProperty('debug');

        Assert::assertTrue($property->isProtected());
    });

    it('has protected defaultSender property', function () {
        $reflection = new \ReflectionClass(SendSmsFactorSMSAction::class);
        $property = $reflection->getProperty('defaultSender');

        Assert::assertTrue($property->isProtected());
    });
});
