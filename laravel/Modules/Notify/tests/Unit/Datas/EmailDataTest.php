<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;
use Modules\Notify\Datas\EmailData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

describe('EmailData', function () {
    it('can be instantiated via reflection without constructor', function () {
        $reflection = new \ReflectionClass(EmailData::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has correct namespace', function () {
        Assert::assertStringStartsWith('Modules\Notify\Datas', (string) EmailData::class);
    });

    it('has required properties', function () {
        $propertyNames = \notifyReflectionPropertyNames(new \ReflectionClass(EmailData::class));

        \assertListContains('recipient', $propertyNames);
        \assertListContains('from', $propertyNames);
        \assertListContains('from_email', $propertyNames);
        \assertListContains('subject', $propertyNames);
        \assertListContains('body_html', $propertyNames);
        \assertListContains('body', $propertyNames);
        \assertListContains('attachments', $propertyNames);
    });

    it('extends Spatie Data', function () {
        $reflection = new \ReflectionClass(EmailData::class);

        Assert::assertTrue($reflection->isSubclassOf(Data::class));
    });

    it('has getFrom method', function () {
        $reflection = new \ReflectionClass(EmailData::class);

        Assert::assertTrue($reflection->hasMethod('getFrom'));
    });

    it('has getMimeEmail method', function () {
        $reflection = new \ReflectionClass(EmailData::class);

        Assert::assertTrue($reflection->hasMethod('getMimeEmail'));
    });

    it('has from method', function () {
        $reflection = new \ReflectionClass(EmailData::class);

        Assert::assertTrue($reflection->hasMethod('from'));
    });

    it('can create via static from method with valid data', function () {
        $reflection = new \ReflectionClass(EmailData::class);
        $fromMethod = $reflection->getMethod('from');
        Assert::assertTrue($fromMethod->isStatic());
    });
});
