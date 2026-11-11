<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Providers;

use Modules\Seo\Adapters\MetatagFacadeAdapter;
use Modules\Seo\Providers\EventServiceProvider;
use Modules\Seo\Providers\SeoServiceProvider;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('registers metatag adapter singleton and provides list', function (): void {
    $provider = new SeoServiceProvider(app());
    $provider->register();

    $instanceA = app(MetatagFacadeAdapter::class);
    $instanceB = app(MetatagFacadeAdapter::class);

    Assert::assertInstanceOf(MetatagFacadeAdapter::class, $instanceA);
    Assert::assertSame($instanceA, $instanceB);
    Assert::assertContains(MetatagFacadeAdapter::class, $provider->provides());
});

it('event service provider enables event discovery', function (): void {
    $reflection = new \ReflectionClass(EventServiceProvider::class);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    Assert::assertTrue($property->getValue());
});
