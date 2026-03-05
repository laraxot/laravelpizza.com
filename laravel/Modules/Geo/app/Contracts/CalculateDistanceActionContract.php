<?php

declare(strict_types=1);

namespace Modules\Geo\Contracts;

use Modules\Geo\Datas\LocationData;

/**
 * Contract for calculating distance between two geographic locations.
 */
interface CalculateDistanceActionContract
{
    /**
     * Calculate the distance and travel time between two points.
     *
     * @param LocationData $origin      Origin point with valid coordinates
     * @param LocationData $destination Destination point with valid coordinates
     *
     * @return array{
     *     distance: array{text: string, value: int},
     *     duration: array{text: string, value: int},
     *     status: string
     * } Array with distance, duration and status
     */
    public function execute(LocationData $origin, LocationData $destination): array;

    /**
     * Format distance in meters to a human-readable string.
     *
     * @param int $meters Distance in meters
     */
    public function formatDistance(int $meters): string;
}
