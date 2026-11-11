<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data object per la gestione delle informazioni di geolocalizzazione IP.
 *
 * @property string $ip Indirizzo IP
 * @property string|null $city Nome della città
 * @property string|null $region Nome della regione
 * @property string|null $country Codice paese
 * @property string|null $countryName Nome del paese
 * @property float|null $latitude Latitudine
 * @property float|null $longitude Longitudine
 * @property string|null $timezone Fuso orario
 * @property string|null $isp Provider di servizi internet
 */
class IPLocationData extends Data
{
    public function __construct(
        public readonly string $ip,
        public readonly ?string $city = null,
        public readonly ?string $region = null,
        public readonly ?string $country = null,
        public readonly ?string $countryName = null,
        public readonly ?float $latitude = null,
        public readonly ?float $longitude = null,
        public readonly ?string $timezone = null,
        public readonly ?string $isp = null,
    ) {}
}
