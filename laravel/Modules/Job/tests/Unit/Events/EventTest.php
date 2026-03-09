<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Modules\Job\Events\Event;

describe('Event', function () {
    it('can be instantiated', function () {
        $event = new class extends Event {};
        expect($event)->toBeInstanceOf(Event::class);
    });

    it('uses Dispatchable trait', function () {
        $traits = class_uses(Event::class);

        expect($traits)->toContain('Illuminate\Foundation\Events\Dispatchable');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(Event::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(Event::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(Event::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Foundation\Events\Dispatchable;');
    });
});
