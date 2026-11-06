<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\Device;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('exposes a belongsToMany devices relation on the user model', function (): void {
    $user = TestCase::createTestUser();

    expect(($user->devices())::class)->toBe(BelongsToMany::class);
    expect(($user->devices()->getRelated())::class)->toBe(Device::class);
});

it('attaches and retrieves devices for a user', function (): void {
    $user = TestCase::createTestUser();

    $device = Device::factory()->createOne();

    $user->devices()->attach($device->getKey());

    $devices = $user->refresh()->devices;

    expect($devices)->toHaveCount(1);
    expect($devices->first()?->getKey())->toBe($device->getKey());
});

it('detaches devices from a user', function (): void {
    $user = TestCase::createTestUser();
    $device = Device::factory()->createOne();

    $user->devices()->attach($device->getKey());
    expect($user->refresh()->devices)->toHaveCount(1);

    $user->devices()->detach($device->getKey());
    expect($user->refresh()->devices)->toHaveCount(0);
});
