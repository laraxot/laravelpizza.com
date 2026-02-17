<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data object per la gestione delle informazioni sui luoghi.
 *
 * @property int $placeId ID univoco del luogo
 * @property string $displayName Nome visualizzato del luogo
 * @property float $latitude Latitudine
 * @property float $longitude Longitudine
 * @property string $type Tipo di luogo (es. città, via, ecc.)
 * @property string|null $address Indirizzo completo
 * @property array<string, string> $addressComponents Componenti dell'indirizzo
 * @property array<string, mixed> $extraData Dati aggiuntivi specifici del provider
 */
class PlaceData extends Data
{
    public function __construct(
        public readonly int $placeId,
        public readonly string $displayName,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $type,
        public readonly ?string $address = null,
        public readonly array $addressComponents = [],
        public readonly array $extraData = [],
    ) {}

    /**
     * Crea un'istanza da un array di dati Nominatim.
     *
     * @param  array{place_id: int, display_name: string, lat: string, lon: string, type: string, address?: array<string, string>}  $data
     */
    public static function fromNominatim(array $data): self
    {
        return new self(
            placeId: (int) $data['place_id'],
            displayName: $data['display_name'],
            latitude: (float) $data['lat'],
            longitude: (float) $data['lon'],
            type: $data['type'],
            address: $data['display_name'],
            addressComponents: $data['address'] ?? [],
            extraData: $data,
        );
    }
}
