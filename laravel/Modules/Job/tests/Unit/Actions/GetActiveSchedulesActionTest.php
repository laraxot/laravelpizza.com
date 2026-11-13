<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions;

use Modules\Job\Actions\GetActiveSchedulesAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

uses(TestCase::class);

describe('GetActiveSchedulesAction', function () {
    it('can be instantiated', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has execute method', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertTrue($reflection->hasMethod('execute'));
    });

    it('uses QueueableAction trait', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertContains(QueueableAction::class, $reflection->getTraitNames());
    });

    it('has private getFromCache method', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertTrue($reflection->hasMethod('getFromCache'));
        $method = $reflection->getMethod('getFromCache');
        Assert::assertTrue($method->isPrivate());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertSame('Modules\Job\Actions', $reflection->getNamespaceName());
    });

    it('has model property', function () {
        $reflection = new \ReflectionClass(GetActiveSchedulesAction::class);
        Assert::assertTrue($reflection->hasProperty('model'));
    });
});
