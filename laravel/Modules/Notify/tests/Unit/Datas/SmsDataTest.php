<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\SmsData;

describe('SmsData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new ReflectionClass(SmsData::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has correct namespace', function () {
        expect(SmsData::class)->toStartWith('Modules\Notify\Datas');
    });

    it('has required properties', function () {
        $reflection = new ReflectionClass(SmsData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        expect($propertyNames)->toContain('from');
        expect($propertyNames)->toContain('recipient');
        expect($propertyNames)->toContain('body');
    });

    it('has from method', function () {
        expect(method_exists(SmsData::class, 'from'))->toBeTrue();
    });

    it('from method is static', function () {
        $reflection = new ReflectionClass(SmsData::class);
        $fromMethod = $reflection->getMethod('from');

        expect($fromMethod->isStatic())->toBeTrue();
    });

    it('has constructor', function () {
        $reflection = new ReflectionClass(SmsData::class);

        expect($reflection->getConstructor())->not->toBeNull();
    });

    it('constructor accepts array parameter', function () {
        $reflection = new ReflectionClass(SmsData::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        expect($params)->toHaveCount(1);
        expect($params[0]->getName())->toBe('data');
        expect($params[0]->isArray())->toBeTrue();
    });
});
