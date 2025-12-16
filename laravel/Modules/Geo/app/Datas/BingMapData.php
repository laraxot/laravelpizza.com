<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Classe per gestire i dati grezzi di Bing Maps.
 */
class BingMapData extends Data
{
    /**
     * @param array{
     *     point: array{
     *         coordinates: array{0: float, 1: float}
     *     },
     *     address: array{
     *         countryRegion: ?string,
     *         adminDistrict: ?string,
     *         adminDistrict2: ?string,
     *         locality: ?string,
     *         postalCode: ?string,
     *         addressLine: ?string,
     *         countryRegionIso2: ?string,
     *         neighborhood: ?string
     *     }
     * } $data
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Converte i dati in un array.
     *
     * @return array{
     *     point: array{
     *         coordinates: array{0: float, 1: float}
     *     },
     *     address: array{
     *         countryRegion: ?string,
     *         adminDistrict: ?string,
     *         adminDistrict2: ?string,
     *         locality: ?string,
     *         postalCode: ?string,
     *         addressLine: ?string,
     *         countryRegionIso2: ?string,
     *         neighborhood: ?string
     *     }
     * }
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
