<?php

declare(strict_types=1);

use Modules\Notify\Channels\NetfunChannel;

describe('NetfunChannel', function () {
    it('can be instantiated', function () {
        // NetfunChannel requires SendNetfunSMSAction in constructor
        // but we can test structure via reflection
        $reflection = new ReflectionClass(NetfunChannel::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has send method', function () {
        $reflection = new ReflectionClass(NetfunChannel::class);
        $method = $reflection->getMethod('send');

        expect($method->isPublic())->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(NetfunChannel::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Channels');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(NetfunChannel::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has protected sendSMSAction property', function () {
        $reflection = new ReflectionClass(NetfunChannel::class);
        $property = $reflection->getProperty('sendSMSAction');

        expect($property->isProtected())->toBeTrue();
    });
});
