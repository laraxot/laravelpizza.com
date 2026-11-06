<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\CoordinatesData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('CoordinatesData holds latitude and longitude', function (): void {
    $dto = new CoordinatesData(45.4642, 9.1900);

    Assert::assertSame(45.4642, $dto->latitude);
    Assert::assertSame(9.1900, $dto->longitude);
});

test('CoordinatesData toArray exposes both axes', function (): void {
    $array = (new CoordinatesData(41.0, 12.0))->toArray();

    Assert::assertSame(41.0, $array['latitude']);
    Assert::assertSame(12.0, $array['longitude']);
});
