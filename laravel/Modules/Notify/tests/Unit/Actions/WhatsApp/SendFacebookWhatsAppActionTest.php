<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\WhatsApp;

use Modules\Notify\Actions\WhatsApp\SendFacebookWhatsAppAction;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);
describe('SendFacebookWhatsAppAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts WhatsAppData parameter', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        XotBasePest::assertReflectionTypeName($params[0]->getType(), WhatsAppData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        XotBasePest::assertReflectionTypeName($returnType, 'array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $content = TestCase::notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);

        Assert::assertSame('Modules\Notify\Actions\WhatsApp', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = TestCase::notifyReflectionSource(new \ReflectionClass(SendFacebookWhatsAppAction::class));

        Assert::assertStringContainsString('declare(strict_types=1)', $content);
        Assert::assertStringContainsString('use Modules\\Notify\\Contracts\\WhatsAppProviderActionInterface;', $content);
        Assert::assertStringContainsString('use Modules\\Notify\\Datas\\WhatsAppData;', $content);
        Assert::assertStringContainsString('use Spatie\\QueueableAction\\QueueableAction;', $content);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendFacebookWhatsAppAction::class);
        Assert::assertArrayHasKey('Spatie\QueueableAction\QueueableAction', $traits);
    });

    it('has protected debug property', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $property = $reflection->getProperty('debug');

        Assert::assertTrue($property->isProtected());
    });

    it('has protected timeout property', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $property = $reflection->getProperty('timeout');

        Assert::assertTrue($property->isProtected());
    });

    it('has private accessToken property', function () {
        $reflection = new \ReflectionClass(SendFacebookWhatsAppAction::class);
        $property = $reflection->getProperty('accessToken');

        Assert::assertTrue($property->isPrivate());
    });
});