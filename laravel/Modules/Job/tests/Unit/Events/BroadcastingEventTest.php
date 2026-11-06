<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\TaskEvent;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('BroadcastingEvent', function () {
    it('extends TaskEvent', function () {
        Assert::assertTrue((new \ReflectionClass(BroadcastingEvent::class))->isSubclassOf(TaskEvent::class));
    });

    it('implements ShouldBroadcast', function () {
        $interfaces = (new \ReflectionClass(BroadcastingEvent::class))->getInterfaceNames();

        Assert::assertContains('Illuminate\Contracts\Broadcasting\ShouldBroadcast', $interfaces);
    });

    it('uses InteractsWithSockets trait', function () {
        $traits = class_uses(BroadcastingEvent::class);

        Assert::assertContains('Illuminate\Broadcasting\InteractsWithSockets', $traits);
    });

    it('has broadcastOn method returning PrivateChannel', function () {
        $reflection = new \ReflectionClass(BroadcastingEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        Assert::assertTrue($method->isPublic());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame(PrivateChannel::class, $returnType->getName());
    });

    it('has broadcastWhen method', function () {
        $reflection = new \ReflectionClass(BroadcastingEvent::class);
        $method = $reflection->getMethod('broadcastWhen');

        Assert::assertTrue($method->isPublic());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame('bool', $returnType->getName());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(BroadcastingEvent::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(BroadcastingEvent::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(BroadcastingEvent::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('use Illuminate\Broadcasting\InteractsWithSockets;', $content);
        Assert::assertStringContainsString('', $content);
        Assert::assertStringContainsString('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;', $content);
    });
});
