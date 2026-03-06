<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions;

use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Models\Device;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GetCurrentDeviceActionTest extends TestCase
{
    #[Test]
    public function itCreatesDeviceFromAgentInfo(): void
    {
        $agent = \Mockery::mock(\Jenssegers\Agent\Agent::class);
        $agent->shouldReceive('device')->andReturn('Macintosh');
        $agent->shouldReceive('platform')->andReturn('macOS');
        $agent->shouldReceive('browser')->andReturn('Chrome');
        $agent->shouldReceive('isDesktop')->andReturn(true);
        $agent->shouldReceive('isMobile')->andReturn(false);
        $agent->shouldReceive('isTablet')->andReturn(false);
        $agent->shouldReceive('isPhone')->andReturn(false);
        $agent->shouldReceive('isRobot')->andReturn(false);
        $agent->shouldReceive('version')->with('Chrome')->andReturn('120.0');
        $agent->shouldReceive('robot')->andReturn(null);

        $deviceModel = new Device();

        $action = new GetCurrentDeviceAction($agent, $deviceModel);
        $result = $action->execute();

        $this->assertInstanceOf(Device::class, $result);
        $this->assertEquals('Macintosh', $result->device);
        $this->assertEquals('macOS', $result->platform);
        $this->assertEquals('Chrome', $result->browser);
    }

    #[Test]
    public function itHandlesNullDeviceInfo(): void
    {
        $agent = \Mockery::mock(\Jenssegers\Agent\Agent::class);
        $agent->shouldReceive('device')->andReturn(null);
        $agent->shouldReceive('platform')->andReturn(null);
        $agent->shouldReceive('browser')->andReturn(null);
        $agent->shouldReceive('isDesktop')->andReturn(false);
        $agent->shouldReceive('isMobile')->andReturn(false);
        $agent->shouldReceive('isTablet')->andReturn(false);
        $agent->shouldReceive('isPhone')->andReturn(false);
        $agent->shouldReceive('isRobot')->andReturn(true);
        $agent->shouldReceive('version')->andReturn(null);
        $agent->shouldReceive('robot')->andReturn('Bot');

        $deviceModel = new Device();

        $action = new GetCurrentDeviceAction($agent, $deviceModel);
        $result = $action->execute();

        $this->assertInstanceOf(Device::class, $result);
        $this->assertEquals('unknown', $result->device);
        $this->assertEquals('Bot', $result->robot);
    }

    #[Test]
    public function itDetectsMobileDevice(): void
    {
        $agent = \Mockery::mock(\Jenssegers\Agent\Agent::class);
        $agent->shouldReceive('device')->andReturn('iPhone');
        $agent->shouldReceive('platform')->andReturn('iOS');
        $agent->shouldReceive('browser')->andReturn('Safari');
        $agent->shouldReceive('isDesktop')->andReturn(false);
        $agent->shouldReceive('isMobile')->andReturn(true);
        $agent->shouldReceive('isTablet')->andReturn(false);
        $agent->shouldReceive('isPhone')->andReturn(true);
        $agent->shouldReceive('isRobot')->andReturn(false);
        $agent->shouldReceive('version')->with('Safari')->andReturn('17.0');
        $agent->shouldReceive('robot')->andReturn(null);

        $deviceModel = new Device();

        $action = new GetCurrentDeviceAction($agent, $deviceModel);
        $result = $action->execute();

        $this->assertTrue($result->is_mobile);
        $this->assertTrue($result->is_phone);
        $this->assertFalse($result->is_desktop);
    }

    #[Test]
    public function itDetectsTabletDevice(): void
    {
        $agent = \Mockery::mock(\Jenssegers\Agent\Agent::class);
        $agent->shouldReceive('device')->andReturn('iPad');
        $agent->shouldReceive('platform')->andReturn('iOS');
        $agent->shouldReceive('browser')->andReturn('Safari');
        $agent->shouldReceive('isDesktop')->andReturn(false);
        $agent->shouldReceive('isMobile')->andReturn(false);
        $agent->shouldReceive('isTablet')->andReturn(true);
        $agent->shouldReceive('isPhone')->andReturn(false);
        $agent->shouldReceive('isRobot')->andReturn(false);
        $agent->shouldReceive('version')->with('Safari')->andReturn('17.0');
        $agent->shouldReceive('robot')->andReturn(null);

        $deviceModel = new Device();

        $action = new GetCurrentDeviceAction($agent, $deviceModel);
        $result = $action->execute();

        $this->assertTrue($result->is_tablet);
        $this->assertFalse($result->is_mobile);
    }
}
