<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Telegram;
use Modules\Notify\Tests\TestCase;
use function Safe\file_get_contents;
use Modules\Notify\Actions\Telegram\SendBotmanTelegramAction;
use Modules\Notify\Datas\TelegramData;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);

describe('SendBotmanTelegramAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts TelegramData parameter', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        \assertReflectionTypeName($params[0]->getType(), TelegramData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);

        Assert::assertSame('Modules\Notify\Actions\Telegram', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $filename = $reflection->getFileName();
        $content = \notifyReflectionSource(new \ReflectionClass(SendBotmanTelegramAction::class));

        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendBotmanTelegramAction::class);
        Assert::assertArrayHasKey('Spatie\QueueableAction\QueueableAction', $traits);
    });

    it('has protected debug property', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $property = $reflection->getProperty('debug');

        Assert::assertTrue($property->isProtected());
    });

    it('has protected timeout property', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $property = $reflection->getProperty('timeout');

        Assert::assertTrue($property->isProtected());
    });

    it('has private token property', function () {
        $reflection = new \ReflectionClass(SendBotmanTelegramAction::class);
        $property = $reflection->getProperty('token');

        Assert::assertTrue($property->isPrivate());
    });
});
