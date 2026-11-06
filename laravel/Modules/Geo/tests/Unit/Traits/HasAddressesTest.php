<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Models\Traits\HasAddress;
use Modules\Geo\Tests\Fixtures\Traits\HasAddressTestModel;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * HasAddresses (plurale) è stato rimosso; questo file verifica il trait canonico HasAddress sulla fixture.
 */
uses(TestCase::class);

test('HasAddressTestModel uses HasAddress trait', function (): void {
    Assert::assertContains(
        HasAddress::class,
        class_uses_recursive(HasAddressTestModel::class),
    );
});

test('HasAddress exposes morphMany addresses and morphOne address', function (): void {
    $reflection = new \ReflectionClass(HasAddress::class);

    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('address'));
    Assert::assertTrue($reflection->hasMethod('getFullAddress'));
});
