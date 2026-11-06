<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Models\Traits\HasAddress;
use Modules\Geo\Models\Traits\HasPlaceTrait;
use Modules\Geo\Traits\HandlesCoordinates;
use PHPUnit\Framework\Assert;

/*
 * HasAddresses (app/Traits) era duplicato dead di HasAddress — rimosso 2026-09-24.
 * Canon: Modules\Geo\Models\Traits\HasAddress + fixture HasAddressTestModel.
 */
test('HasAddress trait exists with expected API', function (): void {
    Assert::assertTrue(trait_exists(HasAddress::class));
    Assert::assertTrue(trait_exists(HasPlaceTrait::class));

    $reflection = new \ReflectionClass(HasAddress::class);
    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('primaryAddress'));
    Assert::assertTrue($reflection->hasMethod('addAddress'));
});

test('HandlesCoordinates trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HandlesCoordinates::class));

    $reflection = new \ReflectionClass(HandlesCoordinates::class);
    Assert::assertTrue($reflection->hasMethod('formatCoordinates'));
});
