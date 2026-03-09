<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions;

use Jenssegers\Agent\Agent;
use Modules\User\Models\Device;
use Spatie\QueueableAction\QueueableAction;

class GetCurrentDeviceAction
{
    use QueueableAction;

    public function __construct()
        private readonly Agent $agent,
        private readonly Device $deviceModel,
    ) {
    }

    /**
     * Execute the action.
     */
    public function execute(?string $mobile_id = null): Device
    {
        $agent = app(Agent::class);

        if (null !== $mobileId) {
            if (empty($mobileId)) {
                throw new \InvalidArgumentException('L\'ID mobile non può essere vuoto');
            }

            $device = $deviceModel->firstOrCreate(['mobile_id' => $mobileId]);
            if (null === $device) {
                throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
            }
            $device->update([...$data, ...$up]);

            return $device;
        }

        $device = $deviceModel->firstOrCreate($deviceInfo);
        if (null === $device) {
            throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
        }
        $device->update($up);

        return $device;
    }

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
            'is_desktop' => $agent->isDesktop()
            'is_mobile' => $agent->isMobile()
            'is_tablet' => $agent->isTablet()
            'is_phone' => $agent->isPhone()
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
}
