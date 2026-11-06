<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Enums;

use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('AddressItemEnum has expected cases', function () {
    $cases = AddressItemEnum::cases();
    $values = array_map(static fn (AddressItemEnum $case): string => $case->value, $cases);

    Assert::assertContains('locality', $values);
    Assert::assertContains('postal_code', $values);
    Assert::assertContains('latitude', $values);
});

test('AddressTypeEnum has expected cases', function () {
    $cases = AddressTypeEnum::cases();
    $values = array_map(static fn (AddressTypeEnum $case): string => $case->value, $cases);

    Assert::assertContains('home', $values);
    Assert::assertContains('work', $values);
    Assert::assertContains('billing', $values);
});

test('AddressItemEnum getLabel method exists', function () {
    $label = AddressItemEnum::LOCALITY->getLabel();

    Assert::assertNotEmpty($label);
});

test('AddressTypeEnum has label method', function () {
    $label = AddressTypeEnum::HOME->getLabel();

    Assert::assertNotEmpty($label);
});
