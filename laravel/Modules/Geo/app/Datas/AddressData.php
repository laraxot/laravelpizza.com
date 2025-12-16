<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i dati degli indirizzi.
 */
class AddressData extends Data
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ?string $country = null,
        public readonly ?string $city = null,
        public readonly ?string $country_code = null,
        public readonly ?int $postal_code = null,
        public readonly ?string $locality = null,
        public readonly ?string $county = null,
        public readonly ?string $street = null,
        public readonly ?string $street_number = null,
        public readonly ?string $district = null,
        public readonly ?string $state = null,
    ) {}

    /**
     * Restituisce l'indirizzo formattato.
     */
    public function getFormattedAddress(): string
    {
        $parts = [];

        if ($this->street) {
            $parts[] = $this->street;
            if ($this->street_number) {
                $parts[count($parts) - 1] .= ', '.$this->street_number;
            }
        }

        if ($this->city) {
            $parts[] = $this->city;
        }

        if ($this->state) {
            $parts[] = $this->state;
        }

        if ($this->country) {
            $parts[] = $this->country;
        }

        if ($this->postal_code) {
            $parts[] = (string) $this->postal_code;
        }

        return implode(', ', $parts);
    }

    /*
     * public static function fromOpenStreetMap(array $data): self
     * {
     * $address = $data['address'] ?? [];
     *
     * return new self(
     * latitude: (float) $data['lat'],
     * longitude: (float) $data['lon'],
     * city: $address['city'] ?? $address['town'] ?? '',
     * state: $address['state'] ?? '',
     * county: $address['county'] ?? '',
     * district: $address['suburb'] ?? $address['district'] ?? '',
     * locality: $address['locality'] ?? '',
     * street: $address['road'] ?? '',
     * street_number: $address['house_number'] ?? '',
     * postal_code: (int) ($address['postcode'] ?? 0),
     * country: $address['country'] ?? 'Italia',
     * country_code: strtoupper($address['country_code'] ?? 'IT'),
     * );
     * }
     *
     */
}
