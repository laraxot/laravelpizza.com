<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class RouteDistanceStub implements CalculateDistanceActionContract
{
    /**
     * @param  array<string, int>  $distances
     */
    public function __construct(
        private int $defaultMeters = 1000,
        private array $distances = [],
    ) {}

    public function execute(LocationData $origin, LocationData $destination): array
    {
        $key = $origin->latitude.','.$origin->longitude.'|'.$destination->latitude.','.$destination->longitude;
        $value = $this->distances[$key] ?? $this->defaultMeters;

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
