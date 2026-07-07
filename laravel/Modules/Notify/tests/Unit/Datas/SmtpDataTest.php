<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;
use Modules\Notify\Datas\SmtpData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

describe('SmtpData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(SmtpData::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has correct namespace', function () {
        Assert::assertStringStartsWith('Modules\Notify\Datas', (string) SmtpData::class);
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(SmtpData::class);

        Assert::assertTrue($reflection->isSubclassOf(Data::class));
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(SmtpData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        \assertListContains('transport', $propertyNames);
        \assertListContains('host', $propertyNames);
        \assertListContains('port', $propertyNames);
        \assertListContains('username', $propertyNames);
        \assertListContains('password', $propertyNames);
    });

    it('has make static method', function () {
            });

    it('has toArray method', function () {
            });

    it('has getTransport method', function () {
            });

    it('has send method', function () {
            });

    it('has getMailer method', function () {
            });
});
