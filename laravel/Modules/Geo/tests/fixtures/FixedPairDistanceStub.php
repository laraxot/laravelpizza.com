<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class FixedPairDistanceStub implements CalculateDistanceActionContract
{
    public function __construct(
        private int $meters,
    ) {
    }

    public function execute(LocationData $origin, LocationData $destination): array
    {
        return [
            'distance' => ['text' => (string) $this->meters, 'value' => $this->meters],
            'duration' => ['text' => '0 min', 'value' => 0],
            'status' => 'OK',
        ];
    }

    public function formatDistance(int $meters): string
    {
        return $meters.' m';
    }
}
