<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Database\Factories\ProvinceFactory;
use Modules\Geo\Models\Province;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Province factory produces in-memory sushi row', function (): void {
    $province = ProvinceFactory::new()->makeOne();

    Assert::assertInstanceOf(Province::class, $province);
    Assert::assertNotEmpty($province->name);
});

test('Province declares region and localities relationships', function (): void {
    $province = ProvinceFactory::new()->makeOne();

    Assert::assertInstanceOf(BelongsTo::class, $province->region());
    Assert::assertInstanceOf(HasMany::class, $province->localities());
});
