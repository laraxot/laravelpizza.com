<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\NotificationData;
use Spatie\LaravelData\Data;

describe('NotificationData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has correct namespace', function () {
        expect(NotificationData::class)->toStartWith('Modules\Notify\Datas');
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(NotificationData::class);

        expect($reflection->isSubclassOf(Data::class))->toBeTrue();
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(NotificationData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        expect($propertyNames)->toContain('from');
        expect($propertyNames)->toContain('recipient');
        expect($propertyNames)->toContain('body');
        expect($propertyNames)->toContain('channels');
    });

    it('has getSmsData method', function () {
        expect(method_exists(NotificationData::class, 'getSmsData'))->toBeTrue();
    });

    it('has routeNotificationFor method', function () {
        expect(method_exists(NotificationData::class, 'routeNotificationFor'))->toBeTrue();
    });

    it('has from method', function () {
        expect(method_exists(NotificationData::class, 'from'))->toBeTrue();
    });
});
