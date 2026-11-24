<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Telegram;

use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);
describe('SendOfficialTelegramAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts TelegramData parameter', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        XotBasePest::assertReflectionTypeName($params[0]->getType(), TelegramData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        XotBasePest::assertReflectionTypeName($returnType, 'array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $content = TestCase::notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);

        Assert::assertSame('Modules\Notify\Actions\Telegram', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = TestCase::notifyReflectionSource(new \ReflectionClass(SendOfficialTelegramAction::class));

        Assert::assertStringContainsString('declare(strict_types=1)', $content);
        Assert::assertStringContainsString('use Modules\\Notify\\Contracts\\TelegramProviderActionInterface;', $content);
        Assert::assertStringContainsString('use Modules\\Notify\\Datas\\TelegramData;', $content);
        Assert::assertStringContainsString('use Spatie\\QueueableAction\\QueueableAction;', $content);
        Assert::assertStringContainsString('use Modules\\Xot\\Actions\\Cast\\SafeIntCastAction;', $content);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendOfficialTelegramAction::class);
        Assert::assertArrayHasKey('Spatie\QueueableAction\QueueableAction', $traits);
    });

    it('has protected debug property', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('debug');

        Assert::assertTrue($property->isProtected());
    });

    it('has protected timeout property', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('timeout');

        Assert::assertTrue($property->isProtected());
    });

    it('has private token property', function () {
        $reflection = new \ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('token');

        Assert::assertTrue($property->isPrivate());
    });
});
