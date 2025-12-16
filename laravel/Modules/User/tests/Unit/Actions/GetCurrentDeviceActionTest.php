<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jenssegers\Agent\Agent;
use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Models\Device;
use Tests\TestCase;

class GetCurrentDeviceActionTest extends TestCase
{
    use RefreshDatabase;

    private GetCurrentDeviceAction $action;

    private Agent $mockAgent;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GetCurrentDeviceAction;

        // Mock the Agent class
        $this->mockAgent = \Mockery::mock(Agent::class);
    }

    /** @test */
    public function it_creates_device_with_valid_agent_data(): void
    {
        // Arrange
        $deviceData = [
            'device' => 'iPhone',
            'platform' => 'iOS',
            'browser' => 'Safari',
            'is_desktop' => false,
            'is_mobile' => true,
            'is_tablet' => false,
            'is_phone' => true,
            'is_robot' => false,
        ];

        $versionData = [
            'version' => '15.0',
            'robot' => 'unknown',
        ];

        // Mock Agent methods
        $this->mockAgent->shouldReceive('device')->andReturn('iPhone');
        $this->mockAgent->shouldReceive('platform')->andReturn('iOS');
        $this->mockAgent->shouldReceive('browser')->andReturn('Safari');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(true);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(true);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Safari')
            ->andReturn('15.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->device)
            ->toBe('iPhone')
            ->and($result->platform)
            ->toBe('iOS')
            ->and($result->browser)
            ->toBe('Safari')
            ->and($result->is_desktop)
            ->toBeFalse()
            ->and($result->is_mobile)
            ->toBeTrue()
            ->and($result->is_tablet)
            ->toBeFalse()
            ->and($result->is_phone)
            ->toBeTrue()
            ->and($result->is_robot)
            ->toBeFalse()
            ->and($result->version)
            ->toBe('15.0')
            ->and($result->robot)
            ->toBe('unknown');
    }

    /** @test */
    public function it_creates_device_with_mobile_id(): void
    {
        // Arrange
        $mobileId = 'unique-mobile-identifier-123';

        $deviceData = [
            'device' => 'Android Phone',
            'platform' => 'Android',
            'browser' => 'Chrome',
            'is_desktop' => false,
            'is_mobile' => true,
            'is_tablet' => false,
            'is_phone' => true,
            'is_robot' => false,
        ];

        $versionData = [
            'version' => '120.0',
            'robot' => 'unknown',
        ];

        // Mock Agent methods
        $this->mockAgent->shouldReceive('device')->andReturn('Android Phone');
        $this->mockAgent->shouldReceive('platform')->andReturn('Android');
        $this->mockAgent->shouldReceive('browser')->andReturn('Chrome');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(true);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(true);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Chrome')
            ->andReturn('120.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute($mobileId);

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->mobile_id)
            ->toBe($mobileId)
            ->and($result->device)
            ->toBe('Android Phone')
            ->and($result->platform)
            ->toBe('Android')
            ->and($result->browser)
            ->toBe('Chrome');
    }

    /** @test */
    public function it_handles_empty_mobile_id(): void
    {
        // Arrange
        $emptyMobileId = '';

        // Act & Assert
        expect(fn () => $this->action->execute($emptyMobileId))
            ->toThrow(\InvalidArgumentException::class, 'L\'ID mobile non può essere vuoto');
    }

    /** @test */
    public function it_handles_null_mobile_id(): void
    {
        // Arrange
        $nullMobileId = null;

        // Mock Agent methods for desktop device
        $this->mockAgent->shouldReceive('device')->andReturn('Desktop');
        $this->mockAgent->shouldReceive('platform')->andReturn('Windows');
        $this->mockAgent->shouldReceive('browser')->andReturn('Chrome');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(true);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Chrome')
            ->andReturn('120.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute($nullMobileId);

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->mobile_id)
            ->toBeNull()
            ->and($result->device)
            ->toBe('Desktop')
            ->and($result->platform)
            ->toBe('Windows')
            ->and($result->browser)
            ->toBe('Chrome');
    }

    /** @test */
    public function it_handles_unknown_device_types(): void
    {
        // Arrange
        // Mock Agent methods returning null/unknown values
        $this->mockAgent->shouldReceive('device')->andReturn(null);
        $this->mockAgent->shouldReceive('platform')->andReturn(null);
        $this->mockAgent->shouldReceive('browser')->andReturn(null);
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with(null)
            ->andReturn(null);
        $this->mockAgent->shouldReceive('robot')->andReturn(null);

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->device)
            ->toBe('unknown')
            ->and($result->platform)
            ->toBe('unknown')
            ->and($result->browser)
            ->toBe('unknown')
            ->and($result->version)
            ->toBe('unknown')
            ->and($result->robot)
            ->toBe('unknown');
    }

    /** @test */
    public function it_handles_robot_detection(): void
    {
        // Arrange
        // Mock Agent methods for robot
        $this->mockAgent->shouldReceive('device')->andReturn('Robot');
        $this->mockAgent->shouldReceive('platform')->andReturn('Unknown');
        $this->mockAgent->shouldReceive('browser')->andReturn('Robot');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(true);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Robot')
            ->andReturn('1.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('Googlebot');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->is_robot)
            ->toBeTrue()
            ->and($result->robot)
            ->toBe('Googlebot');
    }

    /** @test */
    public function it_handles_tablet_detection(): void
    {
        // Arrange
        // Mock Agent methods for tablet
        $this->mockAgent->shouldReceive('device')->andReturn('iPad');
        $this->mockAgent->shouldReceive('platform')->andReturn('iOS');
        $this->mockAgent->shouldReceive('browser')->andReturn('Safari');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(true);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(true);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Safari')
            ->andReturn('16.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->is_tablet)
            ->toBeTrue()
            ->and($result->is_mobile)
            ->toBeTrue()
            ->and($result->is_phone)
            ->toBeFalse()
            ->and($result->device)
            ->toBe('iPad');
    }

    /** @test */
    public function it_handles_desktop_detection(): void
    {
        // Arrange
        // Mock Agent methods for desktop
        $this->mockAgent->shouldReceive('device')->andReturn('Desktop');
        $this->mockAgent->shouldReceive('platform')->andReturn('macOS');
        $this->mockAgent->shouldReceive('browser')->andReturn('Firefox');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(true);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Firefox')
            ->andReturn('115.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->is_desktop)
            ->toBeTrue()
            ->and($result->is_mobile)
            ->toBeFalse()
            ->and($result->is_tablet)
            ->toBeFalse()
            ->and($result->is_phone)
            ->toBeFalse()
            ->and($result->platform)
            ->toBe('macOS')
            ->and($result->browser)
            ->toBe('Firefox');
    }

    /** @test */
    public function it_handles_mobile_phone_detection(): void
    {
        // Arrange
        // Mock Agent methods for mobile phone
        $this->mockAgent->shouldReceive('device')->andReturn('Samsung Galaxy');
        $this->mockAgent->shouldReceive('platform')->andReturn('Android');
        $this->mockAgent->shouldReceive('browser')->andReturn('Chrome Mobile');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(true);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(true);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Chrome Mobile')
            ->andReturn('120.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->is_mobile)
            ->toBeTrue()
            ->and($result->is_phone)
            ->toBeTrue()
            ->and($result->is_desktop)
            ->toBeFalse()
            ->and($result->is_tablet)
            ->toBeFalse()
            ->and($result->device)
            ->toBe('Samsung Galaxy');
    }

    /** @test */
    public function it_handles_edge_case_platforms(): void
    {
        // Arrange
        // Mock Agent methods for edge case platform
        $this->mockAgent->shouldReceive('device')->andReturn('Smart TV');
        $this->mockAgent->shouldReceive('platform')->andReturn('Tizen');
        $this->mockAgent->shouldReceive('browser')->andReturn('Samsung Internet');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(false);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Samsung Internet')
            ->andReturn('18.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->device)
            ->toBe('Smart TV')
            ->and($result->platform)
            ->toBe('Tizen')
            ->and($result->browser)
            ->toBe('Samsung Internet')
            ->and($result->version)
            ->toBe('18.0');
    }

    /** @test */
    public function it_handles_legacy_browsers(): void
    {
        // Arrange
        // Mock Agent methods for legacy browser
        $this->mockAgent->shouldReceive('device')->andReturn('Desktop');
        $this->mockAgent->shouldReceive('platform')->andReturn('Windows');
        $this->mockAgent->shouldReceive('browser')->andReturn('Internet Explorer');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(true);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Internet Explorer')
            ->andReturn('11.0');
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->browser)
            ->toBe('Internet Explorer')
            ->and($result->version)
            ->toBe('11.0');
    }

    /** @test */
    public function it_handles_unknown_browser_versions(): void
    {
        // Arrange
        // Mock Agent methods with unknown browser version
        $this->mockAgent->shouldReceive('device')->andReturn('Desktop');
        $this->mockAgent->shouldReceive('platform')->andReturn('Linux');
        $this->mockAgent->shouldReceive('browser')->andReturn('Unknown Browser');
        $this->mockAgent->shouldReceive('isDesktop')->andReturn(true);
        $this->mockAgent->shouldReceive('isMobile')->andReturn(false);
        $this->mockAgent->shouldReceive('isTablet')->andReturn(false);
        $this->mockAgent->shouldReceive('isPhone')->andReturn(false);
        $this->mockAgent->shouldReceive('isRobot')->andReturn(false);
        $this->mockAgent
            ->shouldReceive('version')
            ->with('Unknown Browser')
            ->andReturn(null);
        $this->mockAgent->shouldReceive('robot')->andReturn('unknown');

        // Act
        $result = $this->action->execute();

        // Assert
        expect($result)
            ->toBeInstanceOf(Device::class)
            ->and($result->browser)
            ->toBe('Unknown Browser')
            ->and($result->version)
            ->toBe('unknown');
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
