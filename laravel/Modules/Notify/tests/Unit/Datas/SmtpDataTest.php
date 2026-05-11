<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\SmtpData;
use Spatie\LaravelData\Data;

describe('SmtpData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(SmtpData::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has correct namespace', function () {
        expect(SmtpData::class)->toStartWith('Modules\Notify\Datas');
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(SmtpData::class);

        expect($reflection->isSubclassOf(Data::class))->toBeTrue();
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(SmtpData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        expect($propertyNames)->toContain('transport');
        expect($propertyNames)->toContain('host');
        expect($propertyNames)->toContain('port');
        expect($propertyNames)->toContain('username');
        expect($propertyNames)->toContain('password');
    });

    it('has make static method', function () {
        expect(method_exists(SmtpData::class, 'make'))->toBeTrue();
    });

    it('has toArray method', function () {
        expect(method_exists(SmtpData::class, 'toArray'))->toBeTrue();
    });

    it('has getTransport method', function () {
        expect(method_exists(SmtpData::class, 'getTransport'))->toBeTrue();
    });

    it('has send method', function () {
        expect(method_exists(SmtpData::class, 'send'))->toBeTrue();
    });

    it('has getMailer method', function () {
        expect(method_exists(SmtpData::class, 'getMailer'))->toBeTrue();
    });
});
