<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use Modules\Geo\Adapters\GoogleMapsClient;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Spatie\QueueableAction\QueueableAction;

class FetchGoogleMapsElevationAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     *
     * @throws GoogleMapsApiException
     */
    public function execute(float $lat, float $lng): array
    {
        return app(GoogleMapsClient::class)->getElevation($lat, $lng);
    }
}
