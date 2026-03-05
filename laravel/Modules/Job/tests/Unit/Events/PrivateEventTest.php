<?php

declare(strict_types=1);

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Modules\Job\Events\PrivateEvent;

describe('PrivateEvent', function () {
    it('implements ShouldBroadcast', function () {
        $interfaces = (new ReflectionClass(PrivateEvent::class))->getInterfaceNames();

        expect($interfaces)->toContain('Illuminate\Contracts\Broadcasting\ShouldBroadcast');
    });

    it('uses required traits', function () {
        $traits = class_uses(PrivateEvent::class);

        expect($traits)->toContain('Illuminate\Foundation\Events\Dispatchable')
            ->and($traits)->toContain('Illuminate\Broadcasting\InteractsWithSockets')
            ->and($traits)->toContain('Illuminate\Queue\SerializesModels');
    });

    it('has message property', function () {
        $event = new PrivateEvent('test message');

        expect($event->message)->toBe('test message');
    });

    it('has broadcastOn method', function () {
        $reflection = new ReflectionClass(PrivateEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        expect($method->isPublic())->toBeTrue()
            ->and($method->getReturnType()?->getName())->toBe(Channel::class);
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(PrivateEvent::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(PrivateEvent::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(PrivateEvent::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Broadcasting\Channel;')
            ->and($content)->toContain('use Illuminate\Broadcasting\InteractsWithSockets;')
            ->and($content)->toContain('use Illuminate\Broadcasting\PrivateChannel;')
            ->and($content)->toContain('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;');
    });
});
