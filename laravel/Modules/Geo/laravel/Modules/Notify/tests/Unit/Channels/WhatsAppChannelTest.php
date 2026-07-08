<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Channels;
use function Safe\file_get_contents;
use Modules\Notify\Channels\WhatsAppChannel;

use PHPUnit\Framework\Assert;
describe('WhatsAppChannel', function () {
    it('can be instantiated', function () {
        // WhatsAppChannel requires WhatsAppActionFactory in constructor
        // but we can test structure via reflection
        $reflection = new \ReflectionClass(WhatsAppChannel::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has send method', function () {
        $reflection = new \ReflectionClass(WhatsAppChannel::class);
        $method = $reflection->getMethod('send');

        Assert::assertTrue($method->isPublic());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(WhatsAppChannel::class);

        Assert::assertSame('Modules\Notify\Channels', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(WhatsAppChannel::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has private factory property', function () {
        $reflection = new \ReflectionClass(WhatsAppChannel::class);
        $property = $reflection->getProperty('factory');

        Assert::assertTrue($property->isPrivate());
    });
});
