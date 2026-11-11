<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data object per la gestione delle informazioni sul fuso orario.
 *
 * @property string $timeZoneId ID del fuso orario (es. 'Europe/Rome')
 * @property string $timeZoneName Nome del fuso orario
 * @property int $rawOffset Offset grezzo in secondi
 * @property int $dstOffset Offset per l'ora legale in secondi
 * @property string $countryCode Codice del paese
 */
class TimeZoneData extends Data
{
    public function __construct(
        public readonly string $timeZoneId,
        public readonly string $timeZoneName,
        public readonly int $rawOffset,
        public readonly int $dstOffset,
        public readonly string $countryCode,
    ) {}

    /**
     * Crea un'istanza da un array di dati Google Maps Time Zone API.
     *
     * @param array{
     *     timeZoneId: string,
     *     timeZoneName: string,
     *     rawOffset: int,
     *     dstOffset: int,
     *     countryCode: string
     * } $data
     */
    public static function fromGoogleMaps(array $data): self
    {
        return new self(
            timeZoneId: $data['timeZoneId'],
            timeZoneName: $data['timeZoneName'],
            rawOffset: $data['rawOffset'],
            dstOffset: $data['dstOffset'],
            countryCode: $data['countryCode'],
        );
    }

    /**
     * Restituisce l'offset totale in secondi (rawOffset + dstOffset).
     */
    public function getTotalOffset(): int
    {
        return $this->rawOffset + $this->dstOffset;
    }
}
