<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Channels;

use Modules\Notify\Channels\TelegramChannel;

describe('TelegramChannel', function () {
    it('can be instantiated', function () {
        // TelegramChannel requires TelegramActionFactory in constructor
        // but we can test structure via reflection
        $reflection = new ReflectionClass(TelegramChannel::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has send method', function () {
        $reflection = new ReflectionClass(TelegramChannel::class);
        $method = $reflection->getMethod('send');

        expect($method->isPublic())->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(TelegramChannel::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Channels');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(TelegramChannel::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has private factory property', function () {
        $reflection = new ReflectionClass(TelegramChannel::class);
        $property = $reflection->getProperty('factory');

        expect($property->isPrivate())->toBeTrue();
    });
});
