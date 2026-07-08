<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Channels;
use function Safe\file_get_contents;
use Modules\Notify\Channels\SmsChannel;

use PHPUnit\Framework\Assert;
describe('SmsChannel', function () {
    it('can be instantiated', function () {
        // SmsChannel requires SmsActionFactory in constructor
        // but we can test structure via reflection
        $reflection = new \ReflectionClass(SmsChannel::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has send method', function () {
        $reflection = new \ReflectionClass(SmsChannel::class);
        $method = $reflection->getMethod('send');

        Assert::assertTrue($method->isPublic());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SmsChannel::class);

        Assert::assertSame('Modules\Notify\Channels', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SmsChannel::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has private factory property', function () {
        $reflection = new \ReflectionClass(SmsChannel::class);
        $property = $reflection->getProperty('factory');

        Assert::assertTrue($property->isPrivate());
    });
});
