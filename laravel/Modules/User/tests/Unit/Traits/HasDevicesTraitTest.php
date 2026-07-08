<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\Device;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

it('exposes a belongsToMany devices relation on the user model', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    Assert::assertInstanceOf(BelongsToMany::class, $user->devices());
    Assert::assertInstanceOf(Device::class, $user->devices()->getRelated());
});

it('attaches and retrieves devices for a user', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    $device = Device::factory()->create();

    $user->devices()->attach($device->getKey());

    $devices = $user->fresh()->devices;

    Assert::assertCount(1, $devices);
    Assert::assertSame($device->getKey(), $devices->first()->getKey());
});

it('detaches devices from a user', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();
    $device = Device::factory()->create();

    $user->devices()->attach($device->getKey());
    Assert::assertCount(1, $user->fresh()->devices);

    $user->devices()->detach($device->getKey());
    Assert::assertCount(0, $user->fresh()->devices);
});
