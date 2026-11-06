<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\Region;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Region factory produces sushi-backed model', function (): void {
    $region = RegionFactory::new()->makeOne();

    Assert::assertInstanceOf(Region::class, $region);
    Assert::assertNotEmpty($region->name);
});

test('Region exposes provinces hasMany relationship', function (): void {
    $region = RegionFactory::new()->makeOne();

    Assert::assertInstanceOf(HasMany::class, $region->provinces());
});
