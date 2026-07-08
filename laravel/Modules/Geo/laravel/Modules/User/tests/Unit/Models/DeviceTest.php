<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\DeviceFactory;
use Modules\User\Models\Device;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsDeviceCreate(array $attributes = []): Device
{
    return DeviceFactory::new()->createOne($attributes);
}

/**
 * @param array<string, mixed> $where
 */
function modelsDeviceAssertInDatabase(string $id, array $where): void
{
    $query = DB::connection('user')->table('devices')->where('id', $id);
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertTrue($query->exists());
}

test('can create device with minimal data', function (): void {
    $device = modelsDeviceCreate([
        'device' => 'iPhone',
        'platform' => 'iOS',
    ]);

    modelsDeviceAssertInDatabase((string) $device->id, [
        'device' => 'iPhone',
        'platform' => 'iOS',
    ]);
});

test('can create device with all fields', function (): void {
    $device = modelsDeviceCreate([
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
    ]);

    Assert::assertSame('550e8400-e29b-41d4-a716-446655440000', $device->uuid);
    Assert::assertSame('mobile123', $device->mobile_id);
    Assert::assertSame('iPhone 13', $device->device);
    Assert::assertTrue((bool) $device->is_mobile);
    Assert::assertTrue((bool) $device->is_phone);

    Assert::assertSame(['en', 'it', 'de'], $device->languages);
});

test('can find device by uuid', function (): void {
    $uuid = (string) Str::uuid();
    $device = modelsDeviceCreate(['uuid' => $uuid]);
    $foundDevice = Device::where('uuid', $uuid)->first();

    Assert::assertInstanceOf(Device::class, $foundDevice);
    Assert::assertSame($device->id, $foundDevice->id);
});

test('can find device by mobile id', function (): void {
    $mobileId = 'unique_mobile_'.uniqid();
    $device = modelsDeviceCreate(['mobile_id' => $mobileId]);
    $foundDevice = Device::where('mobile_id', $mobileId)->first();

    Assert::assertInstanceOf(Device::class, $foundDevice);
    Assert::assertSame($device->id, $foundDevice->id);
});

test('can find device by device type', function (): void {
    $deviceName = 'iPhone 13 Pro '.uniqid();
    $device = modelsDeviceCreate(['device' => $deviceName]);
    $foundDevice = Device::where('device', $deviceName)->first();

    Assert::assertInstanceOf(Device::class, $foundDevice);
    Assert::assertSame($device->id, $foundDevice->id);
});

test('can find device by platform', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['platform' => "iOS-{$marker}"]);
    modelsDeviceCreate(['platform' => "Android-{$marker}"]);

    $iosDevices = Device::where('platform', "iOS-{$marker}")->get();

    Assert::assertCount(1, $iosDevices);
    $first = $iosDevices->first();
    Assert::assertInstanceOf(Device::class, $first);
    Assert::assertSame("iOS-{$marker}", $first->platform);
});

test('can find device by browser', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['browser' => "Safari-{$marker}"]);
    modelsDeviceCreate(['browser' => "Chrome-{$marker}"]);

    $safariDevices = Device::where('browser', "Safari-{$marker}")->get();

    Assert::assertCount(1, $safariDevices);
    $first = $safariDevices->first();
    Assert::assertInstanceOf(Device::class, $first);
    Assert::assertSame("Safari-{$marker}", $first->browser);
});

test('can find device by version', function (): void {
    $version = '15.0.1-'.uniqid();
    $device = modelsDeviceCreate(['version' => $version]);
    $foundDevice = Device::where('version', $version)->first();

    Assert::assertInstanceOf(Device::class, $foundDevice);
    Assert::assertSame($device->id, $foundDevice->id);
});

test('can find desktop devices', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['is_desktop' => true, 'device' => "desktop-a-{$marker}"]);
    modelsDeviceCreate(['is_desktop' => false, 'device' => "mobile-{$marker}"]);
    modelsDeviceCreate(['is_desktop' => true, 'device' => "desktop-b-{$marker}"]);

    $desktopDevices = Device::where('is_desktop', true)->where('device', 'like', "%{$marker}")->get();

    Assert::assertCount(2, $desktopDevices);
    foreach ($desktopDevices as $desktopDevice) {
        Assert::assertTrue((bool) $desktopDevice->is_desktop);
    }
});

test('can find mobile devices', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['is_mobile' => true, 'device' => "mobile-a-{$marker}"]);
    modelsDeviceCreate(['is_mobile' => false, 'device' => "desktop-{$marker}"]);
    modelsDeviceCreate(['is_mobile' => true, 'device' => "mobile-b-{$marker}"]);

    $mobileDevices = Device::where('is_mobile', true)->where('device', 'like', "%{$marker}")->get();

    Assert::assertCount(2, $mobileDevices);
    foreach ($mobileDevices as $mobileDevice) {
        Assert::assertTrue((bool) $mobileDevice->is_mobile);
    }
});

test('can find tablet devices', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['is_tablet' => true, 'device' => "tablet-a-{$marker}"]);
    modelsDeviceCreate(['is_tablet' => false, 'device' => "phone-{$marker}"]);
    modelsDeviceCreate(['is_tablet' => true, 'device' => "tablet-b-{$marker}"]);

    $tabletDevices = Device::where('is_tablet', true)->where('device', 'like', "%{$marker}")->get();

    Assert::assertCount(2, $tabletDevices);
    foreach ($tabletDevices as $tabletDevice) {
        Assert::assertTrue((bool) $tabletDevice->is_tablet);
    }
});

test('can find phone devices', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['is_phone' => true, 'device' => "phone-a-{$marker}"]);
    modelsDeviceCreate(['is_phone' => false, 'device' => "tablet-{$marker}"]);
    modelsDeviceCreate(['is_phone' => true, 'device' => "phone-b-{$marker}"]);

    $phoneDevices = Device::where('is_phone', true)->where('device', 'like', "%{$marker}")->get();

    Assert::assertCount(2, $phoneDevices);
    foreach ($phoneDevices as $phoneDevice) {
        Assert::assertTrue((bool) $phoneDevice->is_phone);
    }
});

test('can find robot devices', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['is_robot' => true, 'robot' => "Googlebot-{$marker}", 'device' => "bot-a-{$marker}"]);
    modelsDeviceCreate(['is_robot' => false, 'robot' => null, 'device' => "human-{$marker}"]);
    modelsDeviceCreate(['is_robot' => true, 'robot' => "Bingbot-{$marker}", 'device' => "bot-b-{$marker}"]);

    $robotDevices = Device::where('is_robot', true)->where('device', 'like', "%{$marker}")->get();

    Assert::assertCount(2, $robotDevices);
    foreach ($robotDevices as $robotDevice) {
        Assert::assertTrue((bool) $robotDevice->is_robot);
    }
});

test('can find devices by language', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['languages' => ['en', "it-{$marker}"], 'device' => "lang-a-{$marker}"]);
    modelsDeviceCreate(['languages' => ['en', "de-{$marker}"], 'device' => "lang-b-{$marker}"]);
    modelsDeviceCreate(['languages' => ['fr', 'es'], 'device' => "lang-c-{$marker}"]);

    $englishDevices = Device::where('device', 'like', "%{$marker}%")->whereJsonContains('languages', 'en')->get();

    Assert::assertCount(2, $englishDevices);
    foreach ($englishDevices as $englishDevice) {
        Assert::assertContains('en', $englishDevice->languages ?? []);
    }
});

test('can find devices by device pattern', function (): void {
    $marker = uniqid();
    modelsDeviceCreate(['device' => "iPhone 13 {$marker}"]);
    modelsDeviceCreate(['device' => "iPhone 14 {$marker}"]);
    modelsDeviceCreate(['device' => "Samsung Galaxy {$marker}"]);

    $iphoneDevices = Device::where('device', 'like', "%iPhone%{$marker}%")->get();

    Assert::assertCount(2, $iphoneDevices);
    foreach ($iphoneDevices as $iphoneDevice) {
        Assert::assertStringContainsString('iPhone', (string) $iphoneDevice->device);
    }
});

test('can update device', function (): void {
    $device = modelsDeviceCreate(['device' => 'Old Device']);
    $device->update(['device' => 'New Device']);

    modelsDeviceAssertInDatabase((string) $device->id, ['device' => 'New Device']);
});

test('can handle null values', function (): void {
    $device = modelsDeviceCreate([
        'device' => 'Test Device',
        'platform' => 'Test Platform',
        'mobile_id' => null,
        'languages' => null,
        'browser' => null,
        'version' => null,
        'robot' => null,
    ]);

    Assert::assertNull($device->mobile_id);
    Assert::assertNull($device->browser);
    Assert::assertNull($device->version);
    Assert::assertNull($device->robot);
});

test('can find devices by multiple criteria', function (): void {
    $marker = uniqid();
    modelsDeviceCreate([
        'platform' => "iOS-{$marker}",
        'is_mobile' => true,
        'browser' => "Safari-{$marker}",
        'device' => "criteria-a-{$marker}",
    ]);

    modelsDeviceCreate([
        'platform' => "Android-{$marker}",
        'is_mobile' => true,
        'browser' => "Chrome-{$marker}",
        'device' => "criteria-b-{$marker}",
    ]);

    $devices = Device::where('device', 'like', "%{$marker}%")
        ->where('is_mobile', true)
        ->where('browser', "Safari-{$marker}")
        ->get();

    Assert::assertCount(1, $devices);
    $first = $devices->first();
    Assert::assertInstanceOf(Device::class, $first);
    Assert::assertSame("iOS-{$marker}", $first->platform);
    Assert::assertTrue((bool) $first->is_mobile);
    Assert::assertSame("Safari-{$marker}", $first->browser);
});

test('device has users relationship', function (): void {
    $device = modelsDeviceCreate();
    Assert::assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $device->users());
});

test('device has factory', function (): void {
    $device = modelsDeviceCreate();
    Assert::assertNotNull($device->id);
    Assert::assertInstanceOf(Device::class, $device);
});

test('device has fillable attributes', function (): void {
    $fillable = (new Device())->getFillable();

    foreach ([
        'id', 'uuid', 'mobile_id', 'languages', 'device', 'platform', 'browser', 'version',
        'is_robot', 'robot', 'is_desktop', 'is_mobile', 'is_tablet', 'is_phone',
    ] as $attribute) {
        Assert::assertContains($attribute, $fillable);
    }
});

test('device has casts', function (): void {
    $casts = (new Device())->getCasts();

    Assert::assertSame('array', $casts['languages']);
    Assert::assertSame('boolean', $casts['is_robot']);
    Assert::assertSame('boolean', $casts['is_mobile']);
    Assert::assertSame('string', $casts['id']);
});
