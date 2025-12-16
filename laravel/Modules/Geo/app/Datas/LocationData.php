<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per le posizioni geografiche.
 */
class LocationData extends Data
{
    /**
     * @param  float  $latitude  Latitudine in gradi decimali
     * @param  float  $longitude  Longitudine in gradi decimali
     * @param  string|null  $name  Nome opzionale della posizione
     * @param  string|null  $address  Indirizzo opzionale della posizione
     */
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ?string $name = null,
        public readonly ?string $address = null,
    ) {}

    /**
     * Converte i dati in un array.
     *
     * @return array{
     *     latitude: float,
     *     longitude: float,
     *     name: ?string,
     *     address: ?string
     * }
     */
    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'name' => $this->name,
            'address' => $this->address,
        ];
    }

    /**
     * Crea una nuova istanza da un array.
     *
     * @param array{
     *     latitude: float,
     *     longitude: float,
     *     name?: ?string,
     *     address?: ?string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            latitude: (float) $data['latitude'],
            longitude: (float) $data['longitude'],
            name: $data['name'] ?? null,
            address: $data['address'] ?? null,
        );
    }
}
