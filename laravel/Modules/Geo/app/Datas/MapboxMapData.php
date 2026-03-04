<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Classe per gestire i dati grezzi di Mapbox.
 */
class MapboxMapData extends Data
{
    /**
     * @param array{
     *     center: array{0: float, 1: float},
     *     text: string,
     *     address: ?string,
     *     context: array{
     *         country: ?string,
     *         country_code: ?string,
     *         place: ?string,
     *         postcode: ?string,
     *         locality: ?string,
     *         region: ?string,
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
     *     center: array{0: float, 1: float},
     *     text: string,
     *     address: ?string,
     *     context: array{
     *         country: ?string,
     *         country_code: ?string,
     *         place: ?string,
     *         postcode: ?string,
     *         locality: ?string,
     *         region: ?string,
     *         neighborhood: ?string
     *     }
     * }
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
