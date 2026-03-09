<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\User\Models\Device;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

test('can create device with minimal data', function (): void {
    $device = Device::factory()->create([
        'device' => 'iPhone',
        'platform' => 'iOS',
    ]);

    $this->assertDatabaseHas('devices', [
        'id' => $device->id,
        'device' => 'iPhone',
        'platform' => 'iOS',
    ]);
});

test('can create device with all fields', function (): void {
    $deviceData = [
        'uuid' => '550e8400-e29b-41d4-a716-446655440000',
        'mobile_id' => 'mobile123',
        'languages' => ['en', 'it', 'de'],
        'device' => 'iPhone 13',
        'platform' => 'iOS',
        'browser' => 'Safari',
        'version' => '15.0',
        'is_robot' => false,
        'robot' => null,
        'is_desktop' => false,
        'is_mobile' => true,
        'is_tablet' => false,
        'is_phone' => true,
    ];

    $device = Device::factory()->create($deviceData);

    $this->assertDatabaseHas('devices', [
        'id' => $device->id,
        'uuid' => '550e8400-e29b-41d4-a716-446655440000',
        'mobile_id' => 'mobile123',
        'device' => 'iPhone 13',
        'platform' => 'iOS',
        'browser' => 'Safari',
        'version' => '15.0',
        'is_robot' => false,
        'is_desktop' => false,
        'is_mobile' => true,
        'is_tablet' => false,
        'is_phone' => true,
    ]);

    // Verifica campi JSON
    expect($device->languages)->toBe(['en', 'it', 'de']);
});

test('device has soft deletes', function (): void {
    $device = Device::factory()->create();
    $deviceId = $device->id;

    $device->delete();

    $this->assertSoftDeleted('devices', ['id' => $deviceId]);
    $this->assertDatabaseMissing('devices', ['id' => $deviceId]);
});

test('can restore soft deleted device', function (): void {
    if (! method_exists(Device::class, 'withTrashed')) {
        $this->markTestSkipped('SoftDeletes trait not present on Device model');

        return;
    }

    $device = Device::factory()->create();
    $deviceId = $device->id;

    $device->delete();
    $this->assertSoftDeleted('devices', ['id' => $deviceId]);

    /** @var Device $restoredDevice */
    $restoredDevice = Device::withTrashed()->find($deviceId);
    $restoredDevice->restore();

    $this->assertDatabaseHas('devices', ['id' => $deviceId]);
    expect($restoredDevice->deleted_at)->toBeNull();
});

test('can find device by uuid', function (): void {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $device = Device::factory()->create(['uuid' => $uuid]);

    $foundDevice = Device::where('uuid', $uuid)->first();

    expect($foundDevice)->not->toBeNull();
    expect($foundDevice->id)->toBe($device->id);
});

test('can find device by mobile id', function (): void {
    $device = Device::factory()->create(['mobile_id' => 'unique_mobile_123']);
    $foundDevice = Device::where('mobile_id', 'unique_mobile_123')->first();

    expect($foundDevice)->not->toBeNull();
    expect($foundDevice->id)->toBe($device->id);
});

test('can find device by device type', function (): void {
    $device = Device::factory()->create(['device' => 'iPhone 13 Pro']);
    $foundDevice = Device::where('device', 'iPhone 13 Pro')->first();

    expect($foundDevice)->not->toBeNull();
    expect($foundDevice->id)->toBe($device->id);
});

test('can find device by platform', function (): void {
    Device::factory()->create(['platform' => 'iOS']);
    Device::factory()->create(['platform' => 'Android']);
    Device::factory()->create(['platform' => 'Windows']);

    $iosDevices = Device::where('platform', 'iOS')->get();

    expect($iosDevices)->toHaveCount(1);
    expect($iosDevices->first()->platform)->toBe('iOS');
});

test('can find device by browser', function (): void {
    Device::factory()->create(['browser' => 'Safari']);
    Device::factory()->create(['browser' => 'Chrome']);
    Device::factory()->create(['browser' => 'Firefox']);

    $safariDevices = Device::where('browser', 'Safari')->get();

    expect($safariDevices)->toHaveCount(1);
    expect($safariDevices->first()->browser)->toBe('Safari');
});

test('can find device by version', function (): void {
    $device = Device::factory()->create(['version' => '15.0.1']);
    $foundDevice = Device::where('version', '15.0.1')->first();

    expect($foundDevice)->not->toBeNull();
    expect($foundDevice->id)->toBe($device->id);
});

test('can find desktop devices', function (): void {
    Device::factory()->create(['is_desktop' => true]);
    Device::factory()->create(['is_desktop' => false]);
    Device::factory()->create(['is_desktop' => true]);

    $desktopDevices = Device::where('is_desktop', true)->get();

    expect($desktopDevices)->toHaveCount(2);
    expect($desktopDevices->every(fn ($device) => $device->is_desktop))->toBeTrue();
});

test('can find mobile devices', function (): void {
    Device::factory()->create(['is_mobile' => true]);
    Device::factory()->create(['is_mobile' => false]);
    Device::factory()->create(['is_mobile' => true]);

    $mobileDevices = Device::where('is_mobile', true)->get();

    expect($mobileDevices)->toHaveCount(2);
    expect($mobileDevices->every(fn ($device) => $device->is_mobile))->toBeTrue();
});

test('can find tablet devices', function (): void {
    Device::factory()->create(['is_tablet' => true]);
    Device::factory()->create(['is_tablet' => false]);
    Device::factory()->create(['is_tablet' => true]);

    $tabletDevices = Device::where('is_tablet', true)->get();

    expect($tabletDevices)->toHaveCount(2);
    expect($tabletDevices->every(fn ($device) => $device->is_tablet))->toBeTrue();
});

test('can find phone devices', function (): void {
    Device::factory()->create(['is_phone' => true]);
    Device::factory()->create(['is_phone' => false]);
    Device::factory()->create(['is_phone' => true]);

    $phoneDevices = Device::where('is_phone', true)->get();

    expect($phoneDevices)->toHaveCount(2);
    expect($phoneDevices->every(fn ($device) => $device->is_phone))->toBeTrue();
});

test('can find robot devices', function (): void {
    Device::factory()->create(['is_robot' => true, 'robot' => 'Googlebot']);
    Device::factory()->create(['is_robot' => false, 'robot' => null]);
    Device::factory()->create(['is_robot' => true, 'robot' => 'Bingbot']);

    $robotDevices = Device::where('is_robot', true)->get();

    expect($robotDevices)->toHaveCount(2);
    expect($robotDevices->every(fn ($device) => $device->is_robot))->toBeTrue();
});

test('can find devices by language', function (): void {
    Device::factory()->create(['languages' => ['en', 'it']]);
    Device::factory()->create(['languages' => ['en', 'de']]);
    Device::factory()->create(['languages' => ['fr', 'es']]);

    $englishDevices = Device::whereJsonContains('languages', 'en')->get();

    expect($englishDevices)->toHaveCount(2);
    expect($englishDevices->every(fn ($device) => in_array('en', $device->languages, strict: true)))->toBeTrue();
});

test('can find devices by device pattern', function (): void {
    Device::factory()->create(['device' => 'iPhone 13']);
    Device::factory()->create(['device' => 'iPhone 14']);
    Device::factory()->create(['device' => 'Samsung Galaxy']);

    $iphoneDevices = Device::where('device', 'like', '%iPhone%')->get();

    expect($iphoneDevices)->toHaveCount(2);
    expect($iphoneDevices->every(fn ($device) => str_contains($device->device, 'iPhone')))->toBeTrue();
});

test('can update device', function (): void {
    $device = Device::factory()->create(['device' => 'Old Device']);
    $device->update(['device' => 'New Device']);

    $this->assertDatabaseHas('devices', [
        'id' => $device->id,
        'device' => 'New Device',
    ]);
});

test('can handle null values', function (): void {
    $device = Device::factory()->create([
        'device' => 'Test Device',
        'platform' => 'Test Platform',
        'mobile_id' => null,
        'languages' => null,
        'browser' => null,
        'version' => null,
        'robot' => null,
    ]);

    $this->assertDatabaseHas('devices', [
        'id' => $device->id,
        'mobile_id' => null,
        'browser' => null,
        'version' => null,
        'robot' => null,
    ]);
});

test('can find devices by multiple criteria', function (): void {
    Device::factory()->create([
        'platform' => 'iOS',
        'is_mobile' => true,
        'browser' => 'Safari',
    ]);

    Device::factory()->create([
        'platform' => 'Android',
        'is_mobile' => true,
        'browser' => 'Chrome',
    ]);

    Device::factory()->create([
        'platform' => 'Windows',
        'is_mobile' => false,
        'browser' => 'Edge',
    ]);

    $devices = Device::where('is_mobile', true)->where('browser', 'Safari')->get();

    expect($devices)->toHaveCount(1);
    expect($devices->first()->platform)->toBe('iOS');
    expect($devices->first()->is_mobile)->toBeTrue();
    expect($devices->first()->browser)->toBe('Safari');
});

test('device has users relationship', function (): void {
    $device = Device::factory()->create();
    expect(method_exists($device, 'users'))->toBeTrue();
});

test('device has factory', function (): void {
    $device = Device::factory()->create();
    expect($device->id)->not->toBeNull();
    expect($device)->toBeInstanceOf(Device::class);
});

test('device has fillable attributes', function (): void {
    $device = new Device();
    $expectedFillable = [
        'id',
        'uuid',
        'mobile_id',
        'languages',
        'device',
        'platform',
        'browser',
        'version',
        'is_robot',
        'robot',
        'is_desktop',
        'is_mobile',
        'is_tablet',
        'is_phone',
    ];
    expect($device->getFillable())->toBe($expectedFillable);
});

test('device has casts', function (): void {
    $device = new Device();
    $expectedCasts = [
        'id' => 'string',
        'uuid' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_by' => 'string',
        'created_by' => 'string',
        'deleted_by' => 'string',
        'languages' => 'array',
        'is_robot' => 'boolean',
        'is_desktop' => 'boolean',
        'is_mobile' => 'boolean',
        'is_tablet' => 'boolean',
        'is_phone' => 'boolean',
    ];
    expect($device->getCasts())->toBe($expectedCasts);
});
