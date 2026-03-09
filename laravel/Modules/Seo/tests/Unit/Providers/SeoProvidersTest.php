<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Providers;

use Modules\Seo\Providers\EventServiceProvider;
use Modules\Seo\Providers\SeoServiceProvider;
use Modules\Seo\Services\MetatagService;
use Tests\TestCase;

uses(TestCase::class);

it('registers metatag service singleton and provides list', function (): void {
    $provider = new SeoServiceProvider(app());
    $provider->register();

    $instanceA = app(MetatagService::class);
    $instanceB = app(MetatagService::class);

    expect($instanceA)->toBeInstanceOf(MetatagService::class)
        ->and($instanceA)->toBe($instanceB)
        ->and($provider->provides())->toContain(MetatagService::class);
});

it('event service provider enables event discovery', function (): void {
    $reflection = new ReflectionClass(EventServiceProvider::class);
    $property = $reflection->getProperty('shouldDiscoverEvents');
    $property->setAccessible(true);

    expect($property->getValue())->toBeTrue();
});
