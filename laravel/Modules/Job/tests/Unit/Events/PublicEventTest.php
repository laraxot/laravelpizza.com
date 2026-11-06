<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Illuminate\Broadcasting\Channel;
use Modules\Job\Events\PublicEvent;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('PublicEvent', function () {
    it('implements ShouldBroadcast', function () {
        $interfaces = (new \ReflectionClass(PublicEvent::class))->getInterfaceNames();

        Assert::assertContains('Illuminate\Contracts\Broadcasting\ShouldBroadcast', $interfaces);
    });

    it('uses required traits', function () {
        $traits = class_uses(PublicEvent::class);

        Assert::assertContains('Illuminate\Foundation\Events\Dispatchable', $traits);
        Assert::assertContains('Illuminate\Broadcasting\InteractsWithSockets', $traits);
        Assert::assertContains('Illuminate\Queue\SerializesModels', $traits);
    });

    it('has color property', function () {
        $event = new PublicEvent;

        Assert::assertSame('black', $event->color);
    });

    it('has broadcastOn method', function () {
        $reflection = new \ReflectionClass(PublicEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        Assert::assertTrue($method->isPublic());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame(Channel::class, $returnType->getName());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(PublicEvent::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(PublicEvent::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(PublicEvent::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('', $content);
        Assert::assertStringContainsString('use Illuminate\Broadcasting\InteractsWithSockets;', $content);
        Assert::assertStringContainsString('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;', $content);
    });
});
