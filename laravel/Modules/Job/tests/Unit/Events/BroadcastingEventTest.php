<?php

declare(strict_types=1);

use Illuminate\Broadcasting\PrivateChannel;
use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\TaskEvent;

describe('BroadcastingEvent', function () {
    it('extends TaskEvent', function () {
        expect(is_a(BroadcastingEvent::class, TaskEvent::class, true))->toBeTrue();
    });

    it('implements ShouldBroadcast', function () {
        $interfaces = (new ReflectionClass(BroadcastingEvent::class))->getInterfaceNames();

        expect($interfaces)->toContain('Illuminate\Contracts\Broadcasting\ShouldBroadcast');
    });

    it('uses InteractsWithSockets trait', function () {
        $traits = class_uses(BroadcastingEvent::class);

        expect($traits)->toContain('Illuminate\Broadcasting\InteractsWithSockets');
    });

    it('has broadcastOn method returning PrivateChannel', function () {
        $reflection = new ReflectionClass(BroadcastingEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        expect($method->isPublic())->toBeTrue()
            ->and($method->getReturnType()?->getName())->toBe(PrivateChannel::class);
    });

    it('has broadcastWhen method', function () {
        $reflection = new ReflectionClass(BroadcastingEvent::class);
        $method = $reflection->getMethod('broadcastWhen');

        expect($method->isPublic())->toBeTrue()
            ->and($method->getReturnType()?->getName())->toBe('bool');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(BroadcastingEvent::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(BroadcastingEvent::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(BroadcastingEvent::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Broadcasting\InteractsWithSockets;')
            ->and($content)->toContain('use Illuminate\Broadcasting\PrivateChannel;')
            ->and($content)->toContain('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;');
    });
});
