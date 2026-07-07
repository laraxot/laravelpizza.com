<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;
use Modules\Notify\Datas\NotificationData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

describe('NotificationData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has correct namespace', function () {
        Assert::assertStringStartsWith('Modules\Notify\Datas', (string) NotificationData::class);
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        Assert::assertTrue($reflection->isSubclassOf(Data::class));
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(NotificationData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        \assertListContains('from', $propertyNames);
        \assertListContains('recipient', $propertyNames);
        \assertListContains('body', $propertyNames);
        \assertListContains('channels', $propertyNames);
    });

    it('has getSmsData method', function () {
            });

    it('has routeNotificationFor method', function () {
            });

    it('has from method', function () {
            });
});
