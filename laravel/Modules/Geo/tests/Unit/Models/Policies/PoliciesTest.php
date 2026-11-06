<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models\Policies;

use Modules\Geo\Models\Policies\CountyPolicy;
use Modules\Geo\Models\Policies\GeoNamesCapPolicy;
use Modules\Geo\Models\Policies\LocalityPolicy;
use Modules\Geo\Models\Policies\PlacePolicy;
use Modules\Geo\Models\Policies\PlaceTypePolicy;
use Modules\Geo\Models\Policies\StatePolicy;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;

uses(TestCase::class);

test('geo policy classes are concrete and instantiable', function (): void {
    $policyClasses = [
        StatePolicy::class,
        CountyPolicy::class,
        LocalityPolicy::class,
        PlacePolicy::class,
        PlaceTypePolicy::class,
        GeoNamesCapPolicy::class,
    ];

    foreach ($policyClasses as $policyClass) {
        $reflection = new ReflectionClass($policyClass);

        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertInstanceOf($policyClass, $reflection->newInstance());
    }
});
