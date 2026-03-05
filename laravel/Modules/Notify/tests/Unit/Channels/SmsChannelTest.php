<?php

declare(strict_types=1);

use Modules\Notify\Channels\SmsChannel;

describe('SmsChannel', function () {
    it('can be instantiated', function () {
        // SmsChannel requires SmsActionFactory in constructor
        // but we can test structure via reflection
        $reflection = new ReflectionClass(SmsChannel::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has send method', function () {
        $reflection = new ReflectionClass(SmsChannel::class);
        $method = $reflection->getMethod('send');

        expect($method->isPublic())->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(SmsChannel::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Channels');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(SmsChannel::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has private factory property', function () {
        $reflection = new ReflectionClass(SmsChannel::class);
        $property = $reflection->getProperty('factory');

        expect($property->isPrivate())->toBeTrue();
    });
});
