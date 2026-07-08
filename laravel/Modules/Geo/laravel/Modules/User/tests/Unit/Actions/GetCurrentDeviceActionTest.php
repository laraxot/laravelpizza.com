<?php

declare(strict_types=1);

use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Models\Device;
use Modules\User\Tests\Fakes\FakeAgent;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $expected
 */
function assertDeviceMatches(Device $device, array $expected): void
{
    foreach ($expected as $attribute => $value) {
        Assert::assertSame($value, $device->getAttribute($attribute));
    }
}

function bindFakeAgent(FakeAgent $agent): void
{
    app()->instance(Jenssegers\Agent\Agent::class, $agent);
}

it('creates device with valid agent data', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'iPhone';
    $agent->fakePlatform = 'iOS';
    $agent->fakeBrowser = 'Safari';
    $agent->fakeIsMobile = true;
    $agent->fakeIsPhone = true;
    $agent->fakeVersions = ['Safari' => '15.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'device' => 'iPhone',
        'platform' => 'iOS',
        'browser' => 'Safari',
        'is_desktop' => false,
        'is_mobile' => true,
        'is_tablet' => false,
        'is_phone' => true,
        'is_robot' => false,
        'version' => '15.0',
        'robot' => 'unknown',
    ]);
});

it('creates device with mobile id', function (): void {
    $mobileId = 'unique-mobile-identifier-123';
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Android Phone';
    $agent->fakePlatform = 'Android';
    $agent->fakeBrowser = 'Chrome';
    $agent->fakeIsMobile = true;
    $agent->fakeIsPhone = true;
    $agent->fakeVersions = ['Chrome' => '120.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute($mobileId);

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'mobile_id' => $mobileId,
        'device' => 'Android Phone',
        'platform' => 'Android',
        'browser' => 'Chrome',
    ]);
});

it('handles empty mobile id', function (): void {
    bindFakeAgent(new FakeAgent());

    try {
        app(GetCurrentDeviceAction::class)->execute('');
        Assert::fail('Expected InvalidArgumentException');
    } catch (InvalidArgumentException $exception) {
        Assert::assertSame('L\'ID mobile non può essere vuoto', $exception->getMessage());
    }
});

it('handles null mobile id', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Desktop';
    $agent->fakePlatform = 'Windows';
    $agent->fakeBrowser = 'Chrome';
    $agent->fakeIsDesktop = true;
    $agent->fakeVersions = ['Chrome' => '120.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute(null);

    Assert::assertInstanceOf(Device::class, $result);
    Assert::assertNull($result->mobile_id);
    assertDeviceMatches($result, [
        'device' => 'Desktop',
        'platform' => 'Windows',
        'browser' => 'Chrome',
    ]);
});

it('handles unknown device types', function (): void {
    bindFakeAgent(new FakeAgent());

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'device' => 'unknown',
        'platform' => 'unknown',
        'browser' => 'unknown',
        'version' => 'unknown',
        'robot' => 'unknown',
    ]);
});

it('handles robot detection', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Robot';
    $agent->fakePlatform = 'Unknown';
    $agent->fakeBrowser = 'Robot';
    $agent->fakeIsRobot = true;
    $agent->fakeVersions = ['Robot' => '1.0'];
    $agent->fakeRobot = 'Googlebot';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    Assert::assertTrue($result->is_robot);
    Assert::assertSame('Googlebot', $result->robot);
});

it('handles tablet detection', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'iPad';
    $agent->fakePlatform = 'iOS';
    $agent->fakeBrowser = 'Safari';
    $agent->fakeIsMobile = true;
    $agent->fakeIsTablet = true;
    $agent->fakeVersions = ['Safari' => '16.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'is_tablet' => true,
        'is_mobile' => true,
        'is_phone' => false,
        'device' => 'iPad',
    ]);
});

it('handles desktop detection', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Desktop';
    $agent->fakePlatform = 'macOS';
    $agent->fakeBrowser = 'Firefox';
    $agent->fakeIsDesktop = true;
    $agent->fakeVersions = ['Firefox' => '115.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'is_desktop' => true,
        'is_mobile' => false,
        'is_tablet' => false,
        'is_phone' => false,
        'platform' => 'macOS',
        'browser' => 'Firefox',
    ]);
});

it('handles mobile phone detection', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Samsung Galaxy';
    $agent->fakePlatform = 'Android';
    $agent->fakeBrowser = 'Chrome Mobile';
    $agent->fakeIsMobile = true;
    $agent->fakeIsPhone = true;
    $agent->fakeVersions = ['Chrome Mobile' => '120.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'is_mobile' => true,
        'is_phone' => true,
        'is_desktop' => false,
        'is_tablet' => false,
        'device' => 'Samsung Galaxy',
    ]);
});

it('handles edge case platforms', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Smart TV';
    $agent->fakePlatform = 'Tizen';
    $agent->fakeBrowser = 'Samsung Internet';
    $agent->fakeVersions = ['Samsung Internet' => '18.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'device' => 'Smart TV',
        'platform' => 'Tizen',
        'browser' => 'Samsung Internet',
        'version' => '18.0',
    ]);
});

it('handles legacy browsers', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Desktop';
    $agent->fakePlatform = 'Windows';
    $agent->fakeBrowser = 'Internet Explorer';
    $agent->fakeIsDesktop = true;
    $agent->fakeVersions = ['Internet Explorer' => '11.0'];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'browser' => 'Internet Explorer',
        'version' => '11.0',
    ]);
});

it('handles unknown browser versions', function (): void {
    $agent = new FakeAgent();
    $agent->fakeDevice = 'Desktop';
    $agent->fakePlatform = 'Linux';
    $agent->fakeBrowser = 'Unknown Browser';
    $agent->fakeIsDesktop = true;
    $agent->fakeVersions = ['Unknown Browser' => false];
    $agent->fakeRobot = 'unknown';
    bindFakeAgent($agent);

    $result = app(GetCurrentDeviceAction::class)->execute();

    Assert::assertInstanceOf(Device::class, $result);
    assertDeviceMatches($result, [
        'browser' => 'Unknown Browser',
        'version' => 'unknown',
    ]);
});
