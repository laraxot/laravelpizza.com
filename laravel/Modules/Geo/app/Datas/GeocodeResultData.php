<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Value Object holding canonical results from a Geocoding service lookup.
 */
class GeocodeResultData extends Data
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public string $formattedAddress,
        public ?string $countryCode = null,
        /** @var array<string, mixed> */
        public array $components = [], // e.g., ['city' => 'New York', 'state' => 'NY']
    ) {
    }
}
