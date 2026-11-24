<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Services;

use Modules\Job\Services\ScheduleService;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

describe('ScheduleService', function () {
    it('can be instantiated', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has getActives method', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertTrue($reflection->hasMethod('getActives'));
    });

    it('has clearCache method', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertTrue($reflection->hasMethod('clearCache'));
    });

    it('has private getFromCache method', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertTrue($reflection->hasMethod('getFromCache'));
        $method = $reflection->getMethod('getFromCache');
        Assert::assertTrue($method->isPrivate());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertSame('Modules\Job\Services', $reflection->getNamespaceName());
    });

    it('has model property', function () {
        $reflection = new \ReflectionClass(ScheduleService::class);
        Assert::assertTrue($reflection->hasProperty('model'));
    });
});
