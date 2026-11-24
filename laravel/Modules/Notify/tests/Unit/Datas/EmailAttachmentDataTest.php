<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\EmailAttachmentData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(TestCase::class);
describe('EmailAttachmentData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new \ReflectionClass(EmailAttachmentData::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has correct namespace', function () {
        Assert::assertStringStartsWith('Modules\Notify\Datas', (string) EmailAttachmentData::class);
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(EmailAttachmentData::class);

        Assert::assertTrue($reflection->isSubclassOf(Data::class));
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(EmailAttachmentData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(static fn (\ReflectionProperty $p): string => $p->getName(), $properties);

        XotBasePest::assertListContains('name', $propertyNames);
        XotBasePest::assertListContains('contentType', $propertyNames);
    });

    it('has getContent method', function () {
        $reflection = new \ReflectionClass(EmailAttachmentData::class);

        Assert::assertTrue($reflection->hasMethod('getContent'));
    });

    it('has constructor with required parameters', function () {
        $reflection = new \ReflectionClass(EmailAttachmentData::class);
        $constructor = $reflection->getConstructor();

        Assert::assertNotNull($constructor);
        $params = $constructor->getParameters();
        Assert::assertCount(3, $params);
    });
});
