<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;
use function Safe\class_uses;
use Illuminate\Broadcasting\Channel;
use Modules\Job\Events\PrivateEvent;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('PrivateEvent', function () {
    it('implements ShouldBroadcast', function () {
        $interfaces = (new \ReflectionClass(PrivateEvent::class))->getInterfaceNames();

        Assert::assertContains('Illuminate\Contracts\Broadcasting\ShouldBroadcast', $interfaces);
    });

    it('uses required traits', function () {
        $traits = class_uses(PrivateEvent::class);

        Assert::assertContains('Illuminate\Foundation\Events\Dispatchable', $traits);
        Assert::assertContains('Illuminate\Broadcasting\InteractsWithSockets', $traits);
        Assert::assertContains('Illuminate\Queue\SerializesModels', $traits);
    });

    it('has message property', function () {
        $event = new PrivateEvent('test message');

        Assert::assertSame('test message', $event->message);
    });

    it('has broadcastOn method', function () {
        $reflection = new \ReflectionClass(PrivateEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        Assert::assertTrue($method->isPublic());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame(Channel::class, $returnType->getName());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(PrivateEvent::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(PrivateEvent::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(PrivateEvent::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('', $content);
        Assert::assertStringContainsString('use Illuminate\Broadcasting\InteractsWithSockets;', $content);
        Assert::assertStringContainsString('use Illuminate\Broadcasting\PrivateChannel;', $content);
        Assert::assertStringContainsString('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;', $content);
    });
});
