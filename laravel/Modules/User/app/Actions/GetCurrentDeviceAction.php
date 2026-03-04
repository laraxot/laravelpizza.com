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

    public function __construct(
        private readonly Agent $agent,
        private readonly Device $deviceModel,
    ) {}

    /**
     * Execute the action.
     */
    public function execute(?string $mobileId = null): Device
    {
        $deviceInfo = $this->getDeviceInfo();
        $browserInfo = $this->getBrowserInfo();

        if ($mobileId !== null) {
            if (empty($mobileId)) {
                throw new \InvalidArgumentException('L\'ID mobile non può essere vuoto');
            }

            $device = $this->deviceModel->firstOrCreate(['mobile_id' => $mobileId]);
            if ($device === null) {
                throw new \RuntimeException('Impossibile creare o trovare il dispositivo');
            }
            $device->update([...$deviceInfo, ...$browserInfo]);

            return $device;
        }

        $device = $this->deviceModel->firstOrCreate($deviceInfo);
        if ($device === null) {
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
}
