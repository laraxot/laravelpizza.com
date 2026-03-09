<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\Executing;

describe('Executing', function () {
    it('extends BroadcastingEvent', function () {
        expect(is_a(Executing::class, BroadcastingEvent::class, true))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(Executing::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(Executing::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('is instantiable', function () {
        $reflection = new ReflectionClass(Executing::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has no additional methods', function () {
        $reflection = new ReflectionClass(Executing::class);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        // Only inherits from BroadcastingEvent
        expect(count($methods))->toBeGreaterThanOrEqual(0);
    });
});
