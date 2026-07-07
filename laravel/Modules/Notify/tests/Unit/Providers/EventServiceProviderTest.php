<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Providers;
use Modules\Notify\Providers\EventServiceProvider;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

test('event service provider has empty listen map', function () {
    $provider = new EventServiceProvider(app());

    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('listen');
    $property->setAccessible(true);

    Assert::assertSame([], $property->getValue($provider));
});

test('event discovery is enabled', function () {
    $reflection = new \ReflectionClass(EventServiceProvider::class);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    Assert::assertTrue($property->getValue());
});
