<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\NotificationData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(TestCase::class);
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

        $propertyNames = array_map(static fn (\ReflectionProperty $p): string => $p->getName(), $properties);

        XotBasePest::assertListContains('from', $propertyNames);
        XotBasePest::assertListContains('recipient', $propertyNames);
        XotBasePest::assertListContains('body', $propertyNames);
        XotBasePest::assertListContains('channels', $propertyNames);
    });

    it('has getSmsData method', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        Assert::assertTrue($reflection->hasMethod('getSmsData'));
    });

    it('has routeNotificationFor method', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        Assert::assertTrue($reflection->hasMethod('routeNotificationFor'));
    });

    it('has from method', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        Assert::assertTrue($reflection->hasMethod('from'));
    });
});