<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\SmsData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(TestCase::class);
describe('SmsData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(SmsData::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has correct namespace', function () {
        Assert::assertStringStartsWith('Modules\Notify\Datas', (string) SmsData::class);
    });

    it('extends Spatie LaravelData Data', function () {
        $reflection = new \ReflectionClass(SmsData::class);

        Assert::assertTrue($reflection->isSubclassOf(Data::class));
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(SmsData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(static fn (\ReflectionProperty $p): string => $p->getName(), $properties);

        XotBasePest::assertListContains('from', $propertyNames);
        XotBasePest::assertListContains('recipient', $propertyNames);
        XotBasePest::assertListContains('body', $propertyNames);
    });

    it('has from method', function () {
        $reflection = new \ReflectionClass(SmsData::class);

        Assert::assertTrue($reflection->hasMethod('from'));
    });

    it('from method is static', function () {
        $reflection = new \ReflectionClass(SmsData::class);
        $fromMethod = $reflection->getMethod('from');

        Assert::assertTrue($fromMethod->isStatic());
    });

    it('has constructor', function () {
        $reflection = new \ReflectionClass(SmsData::class);

        Assert::assertNotNull($reflection->getConstructor());
    });

    it('constructor promotes typed string properties from, recipient, body', function () {
        $reflection = new \ReflectionClass(SmsData::class);
        $constructor = $reflection->getConstructor();
        Assert::assertNotNull($constructor);
        $params = $constructor->getParameters();

        $names = array_map(static fn (\ReflectionParameter $p): string => $p->getName(), $params);
        Assert::assertSame(['from', 'recipient', 'body'], $names);

        foreach ($params as $param) {
            $type = $param->getType();
            Assert::assertInstanceOf(\ReflectionNamedType::class, $type);
            Assert::assertSame('string', $type->getName());
            Assert::assertTrue($param->isDefaultValueAvailable());
        }
    });
});
