<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GeoData;

use Modules\Geo\Actions\GeoData\LoadGeoHierarchyAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

it('exposes the complete geo data action contract', function (): void {
    $methods = get_class_methods(LoadGeoHierarchyAction::class);

    Assert::assertContains('executeRegions', $methods);
    Assert::assertContains('executeProvinces', $methods);
    Assert::assertContains('executeCities', $methods);
    Assert::assertContains('executeCap', $methods);
    Assert::assertContains('executeClearCache', $methods);
});
