<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\OpenCage;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\AddressData;

/**
 * Classe per ottenere i dati dell'indirizzo dal servizio OpenCage.
 */
class GetAddressFromOpenCageAction
{
    private const BASE_URL = 'https://api.opencagedata.com/geocode/v1';

    /**
     * Esegue la ricerca dell'indirizzo su OpenCage.
     *
     * @param  string  $address  L'indirizzo da cercare
     * @return AddressData|null I dati dell'indirizzo trovato o null se non trovato
     *
     * @throws \Exception Se la chiave API non è configurata
     */
    public function execute(string $address): ?AddressData
    {
        $apiKey = config('services.opencage.key');

        if (empty($apiKey)) {
            throw new \Exception('OpenCage API key not configured');
        }

        $response = Http::get(self::BASE_URL.'/json', [
            'q' => $address,
            'key' => $apiKey,
            'limit' => 1,
            'no_annotations' => 1,
        ]);

        // Handle PromiseInterface|Response union type
        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        /** @var Response $response */
        if (! $response->successful()) {
            return null;
        }

        /** @var array{results?: array<int, array{geometry?: array{lat?: float, lng?: float}, components?: array{country?: string, city?: string, town?: string, village?: string, country_code?: string, postcode?: string, suburb?: string, county?: string, road?: string, house_number?: string, state?: string}}>} $data */
        $data = $response->json();

        if (empty($data['results'])) {
            return null;
        }

        $result = $data['results'][0];
        $components = $result['components'] ?? [];

        return AddressData::from([
            'latitude' => (float) ($result['geometry']['lat'] ?? 0),
            'longitude' => (float) ($result['geometry']['lng'] ?? 0),
            'country' => $components['country'] ?? 'Italia',
            'city' => $components['city'] ?? $components['town'] ?? $components['village'] ?? '',
            'country_code' => $components['country_code'] ?? 'IT',
            'postal_code' => (int) ($components['postcode'] ?? 0),
            'locality' => $components['suburb'] ?? '',
            'county' => $components['county'] ?? '',
            'street' => $components['road'] ?? '',
            'street_number' => $components['house_number'] ?? '',
            'district' => $components['suburb'] ?? '',
            'state' => $components['state'] ?? '',
        ]);
    }
}
