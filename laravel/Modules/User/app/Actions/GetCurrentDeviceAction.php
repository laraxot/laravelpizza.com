<?php

/**
 * @see https:// DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions;

use Jenssegers\Agent\Agent;
use Modules\User\Models\Device;
use Spatie\QueueableAction\QueueableAction;

class GetCurrentDeviceAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(?string $mobile_id = null): Device
    {
        $agent = app(Agent::class);
        $deviceInfo = $this->getDeviceInfo($agent);
        $browserInfo = $this->getBrowserInfo($agent);

        if (null !== $mobile_id) {
            if (empty($mobile_id)) {
                throw new \InvalidArgumentException('L\'ID mobile non può essere vuoto');
            }

            $device = Device::firstOrCreate(['mobile_id' => $mobile_id]);
            if (null === $device) {
                throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
            }
            $device->update(array_merge($deviceInfo, $browserInfo));

            return $device;
        }

        $device = Device::firstOrCreate($deviceInfo);
        if (null === $device) {
            throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
        }
        $device->update($browserInfo);

        return $device;
    }

    /**
     * Get basic device information.
     *
     * @return array<string, mixed>
     */
    private function getDeviceInfo(Agent $agent): array
    {
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();

        return [
            'device' => is_string($device) ? $device : 'unknown',
            'platform' => is_string($platform) ? $platform : 'unknown',
            'browser' => is_string($browser) ? $browser : 'unknown',
            'is_desktop' => $agent->isDesktop(),
            'is_mobile' => $agent->isMobile(),
            'is_tablet' => $agent->isTablet(),
            'is_phone' => $agent->isPhone(),
            'is_robot' => $agent->isRobot(),
        ];
    }

    /**
     * Get browser version and robot information.
     *
     * @return array<string, mixed>
     */
    private function getBrowserInfo(Agent $agent): array
    {
        $browser = $agent->browser();
        $browserVersion = is_string($browser) ? $agent->version($browser) : 'unknown';

        return [
            'version' => is_string($browserVersion) ? $browserVersion : 'unknown',
            'robot' => is_string($agent->robot()) ? $agent->robot() : 'unknown',
        ];
    }
}
