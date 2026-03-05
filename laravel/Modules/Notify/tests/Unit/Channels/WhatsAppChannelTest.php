<?php

declare(strict_types=1);

use Modules\Notify\Channels\WhatsAppChannel;

describe('WhatsAppChannel', function () {
    it('can be instantiated', function () {
        // WhatsAppChannel requires WhatsAppActionFactory in constructor
        // but we can test structure via reflection
        $reflection = new ReflectionClass(WhatsAppChannel::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has send method', function () {
        $reflection = new ReflectionClass(WhatsAppChannel::class);
        $method = $reflection->getMethod('send');

        expect($method->isPublic())->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(WhatsAppChannel::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Channels');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(WhatsAppChannel::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has private factory property', function () {
        $reflection = new ReflectionClass(WhatsAppChannel::class);
        $property = $reflection->getProperty('factory');

        expect($property->isPrivate())->toBeTrue();
    });
});
