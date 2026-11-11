<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class ClusterDistanceStub implements CalculateDistanceActionContract
{
    public function __construct(
        private int $defaultMeters = 150000,
    ) {}

    public function execute(LocationData $origin, LocationData $destination): array
    {
        $closePair = abs($origin->latitude - 45.4642) < 0.01
            && abs($destination->latitude - 45.4642) < 0.01;

        $value = $closePair ? 100 : $this->defaultMeters;

        return [
            'distance' => ['text' => (string) $value, 'value' => $value],
            'duration' => ['text' => '0 min', 'value' => 0],
            'status' => 'OK',
        ];
    }

    public function formatDistance(int $meters): string
    {
        return $meters.' m';
    }
}
