<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Nominatim;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\AddressData;

/**
 * Classe per ottenere i dati dell'indirizzo dal servizio Nominatim.
 */
class GetAddressFromNominatimAction
{
    private const BASE_URL = 'https://nominatim.openstreetmap.org';

    /**
     * Esegue la ricerca dell'indirizzo su Nominatim.
     *
     * @param  string  $address  L'indirizzo da cercare
     * @return AddressData|null I dati dell'indirizzo trovato o null se non trovato
     */
    public function execute(string $address): ?AddressData
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Xot/1.0',
        ])->get(self::BASE_URL.'/search', [
            'q' => $address,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 1,
        ]);

        // Handle PromiseInterface|Response union type
        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        /** @var Response $response */
        if (! $response->successful()) {
            return null;
        }

        /** @var array<int, array{lat?: string, lon?: string, address?: array{country?: string, city?: string, town?: string, village?: string, country_code?: string, postcode?: string, suburb?: string, county?: string, road?: string, house_number?: string, state?: string}}> $data */
        $data = $response->json();

        if (empty($data[0])) {
            return null;
        }

        $result = $data[0];
        $address = $result['address'] ?? [];

        return AddressData::from([
            'latitude' => (float) ($result['lat'] ?? 0),
            'longitude' => (float) ($result['lon'] ?? 0),
            'country' => $address['country'] ?? 'Italia',
            'city' => $address['city'] ?? $address['town'] ?? $address['village'] ?? '',
            'country_code' => $address['country_code'] ?? 'IT',
            'postal_code' => (int) ($address['postcode'] ?? 0),
            'locality' => $address['suburb'] ?? '',
            'county' => $address['county'] ?? '',
            'street' => $address['road'] ?? '',
            'street_number' => $address['house_number'] ?? '',
            'district' => $address['suburb'] ?? '',
            'state' => $address['state'] ?? '',
        ]);
    }
}
