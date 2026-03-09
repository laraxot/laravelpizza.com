<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Illuminate\Broadcasting\Channel;
use Modules\Job\Events\PublicEvent;

describe('PublicEvent', function () {
    it('implements ShouldBroadcast', function () {
        $interfaces = (new ReflectionClass(PublicEvent::class))->getInterfaceNames();

        expect($interfaces)->toContain('Illuminate\Contracts\Broadcasting\ShouldBroadcast');
    });

    it('uses required traits', function () {
        $traits = class_uses(PublicEvent::class);

        expect($traits)->toContain('Illuminate\Foundation\Events\Dispatchable')
            ->and($traits)->toContain('Illuminate\Broadcasting\InteractsWithSockets')
            ->and($traits)->toContain('Illuminate\Queue\SerializesModels');
    });

    it('has color property', function () {
        $event = new PublicEvent();

        expect($event->color)->toBe('black');
    });

    it('has broadcastOn method', function () {
        $reflection = new ReflectionClass(PublicEvent::class);
        $method = $reflection->getMethod('broadcastOn');

        expect($method->isPublic())->toBeTrue()
            ->and($method->getReturnType()?->getName())->toBe(Channel::class);
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(PublicEvent::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(PublicEvent::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(PublicEvent::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Broadcasting\Channel;')
            ->and($content)->toContain('use Illuminate\Broadcasting\InteractsWithSockets;')
            ->and($content)->toContain('use Illuminate\Contracts\Broadcasting\ShouldBroadcast;');
    });
});
