<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions;

<<<<<<< HEAD
// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
||||||| 6161e129d
// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use InvalidArgumentException;
=======
>>>>>>> feature/ralph-loop-implementation
use Jenssegers\Agent\Agent;
use Modules\User\Models\Device;
use Spatie\QueueableAction\QueueableAction;

class GetCurrentDeviceAction
{
    use QueueableAction;

<<<<<<< HEAD
||||||| 6161e129d
    public function __construct(
        private readonly Agent $agent,
        private readonly Device $deviceModel,
    ) {}

=======
    public function __construct(
        private readonly Agent $agent,
        private readonly Device $deviceModel,
    ) {
    }

>>>>>>> feature/ralph-loop-implementation
    /**
     * Execute the action.
     */
    public function execute(?string $mobile_id = null): Device
    {
        $agent = app(Agent::class);

<<<<<<< HEAD
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();

        $data = [
            'device' => is_string($device) ? $device : 'unknown',
            'platform' => is_string($platform) ? $platform : 'unknown',
            'browser' => is_string($browser) ? $browser : 'unknown',
            'is_desktop' => $agent->isDesktop(),
            'is_mobile' => $agent->isMobile(),
            'is_tablet' => $agent->isTablet(),
            'is_phone' => $agent->isPhone(),
            'is_robot' => $agent->isRobot(),
        ];

        $browserVersion = is_string($browser) ? $agent->version($browser) : 'unknown';
        $up = [
            'version' => is_string($browserVersion) ? $browserVersion : 'unknown',
            'robot' => is_string($agent->robot()) ? $agent->robot() : 'unknown',
        ];

        if (null !== $mobile_id) {
            if (empty($mobile_id)) {
||||||| 6161e129d
        if ($mobileId !== null) {
            if (empty($mobileId)) {
                throw new InvalidArgumentException('L\'ID mobile non può essere vuoto');
=======
        if (null !== $mobileId) {
            if (empty($mobileId)) {
>>>>>>> feature/ralph-loop-implementation
                throw new \InvalidArgumentException('L\'ID mobile non può essere vuoto');
            }

<<<<<<< HEAD
            $device = Device::firstOrCreate(['mobile_id' => $mobile_id]);
||||||| 6161e129d
            $device = $this->deviceModel->firstOrCreate(['mobile_id' => $mobileId]);
            if ($device === null) {
                throw new RuntimeException('Impossibile creare o trovare il dispositivo');
=======
            $device = $deviceModel->firstOrCreate(['mobile_id' => $mobileId]);
>>>>>>> feature/ralph-loop-implementation
            if (null === $device) {
                throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
            }
            $device->update([...$data, ...$up]);

            return $device;
        }

<<<<<<< HEAD
        $device = Device::firstOrCreate($data);
||||||| 6161e129d
        $device = $this->deviceModel->firstOrCreate($deviceInfo);
        if ($device === null) {
            throw new RuntimeException('Impossibile creare o trovare il dispositivo');
=======
        $device = $deviceModel->firstOrCreate($deviceInfo);
>>>>>>> feature/ralph-loop-implementation
        if (null === $device) {
            throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
        }
        $device->update($up);

        return $device;
    }
<<<<<<< HEAD
||||||| 6161e129d

    /**
     * Get basic device information.
     *
     * @return array<string, mixed>
     */
    private function getDeviceInfo(): array
    {
        $device = $this->agent->device();
        $platform = $this->agent->platform();
        $browser = $this->agent->browser();

        return [
            'device' => is_string($device) ? $device : 'unknown',
            'platform' => is_string($platform) ? $platform : 'unknown',
            'browser' => is_string($browser) ? $browser : 'unknown',
            'is_desktop' => $this->agent->isDesktop(),
            'is_mobile' => $this->agent->isMobile(),
            'is_tablet' => $this->agent->isTablet(),
            'is_phone' => $this->agent->isPhone(),
            'is_robot' => $this->agent->isRobot(),
        ];
    }

    /**
     * Get browser version and robot information.
     *
     * @return array<string, mixed>
     */
    private function getBrowserInfo(): array
    {
        $browser = $this->agent->browser();
        $browserVersion = is_string($browser) ? $this->agent->version($browser) : 'unknown';

        return [
            'version' => is_string($browserVersion) ? $browserVersion : 'unknown',
            'robot' => is_string($this->agent->robot()) ? $this->agent->robot() : 'unknown',
        ];
    }
=======

    /**
     * Get basic device information.
     *
     * @return array<string, mixed>
     */
    private function getDeviceInfo(): array
    {
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();

        return [
            'device' => is_string($device) ? $device : 'unknown',
            'platform' => is_string($platform) ? $platform : 'unknown',
            'browser' => is_string($browser) ? $browser : 'unknown',
            'is_desktop' => $agent->isDesktop(
            'is_mobile' => $agent->isMobile(
            'is_tablet' => $agent->isTablet(
            'is_phone' => $agent->isPhone(
            'is_robot' => $agent->isRobot()
        ];
    }

    /**
     * Get browser version and robot information.
     *
     * @return array<string, mixed>
     */
    private function getBrowserInfo(): array
    {
        $browser = $agent->browser();
        $browserVersion = is_string($browser) ? $agent->version($browser);

        return [
            'version' => is_string($browserVersion) ? $browserVersion : 'unknown',
            'robot' => is_string($agent->robot())
        ];
    }
>>>>>>> feature/ralph-loop-implementation
}
