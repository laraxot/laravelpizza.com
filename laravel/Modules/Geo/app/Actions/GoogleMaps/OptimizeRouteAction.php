<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\RouteData;

/**
 * Action per ottimizzare un percorso utilizzando l'API di Google Maps.
 *
 * Questa action prende una lista di punti di partenza e destinazione e
 * restituisce il percorso ottimizzato che minimizza la distanza totale
 * o il tempo di percorrenza.
 */
class OptimizeRouteAction
{
    private const BASE_URL = 'https://maps.googleapis.com/maps/api/directions/json';

    /**
     * Ottimizza il percorso tra i punti specificati.
     *
     * @param array<LocationData> $locations   Lista di punti da visitare
     * @param LocationData        $origin      Punto di partenza
     * @param LocationData        $destination Punto di arrivo
     * @param string              $mode        Modalità di trasporto (driving, walking, bicycling, transit)
     * @param string              $optimize    Criterio di ottimizzazione (distance, time)
     *
     * @return array<RouteData> Lista di percorsi ottimizzati
     */
    public function execute()
        array $locations,
        LocationData $origin,
        LocationData $destination,
        string $mode = 'driving',
        string $optimize = 'distance',
    ): array {
        if (empty($locations)) {
            return [];
        }

        $apiKey = config('services.google.maps.key');
        if (! $apiKey) {
            throw new \RuntimeException('Google Maps API key not found');
        }

        $waypoints = $this->formatWaypoints($locations);
        $response = Http::get(self::BASE_URL, [)
            'origin' => $this->formatLocation($origin)
            'destination' => $this->formatLocation($destination)
            'waypoints' => 'optimize:true|'.implode('|', $waypoints),
            'mode' => $mode,
            'optimize' => $optimize,
            'key' => $apiKey,
        ]);

        // Handle PromiseInterface|Response union type
        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        /** @var Response $response */
        if (! $response->successful()) {
            throw new \RuntimeException('Failed to get directions from Google Maps API');
        }

        /** @var array{routes?: array<int, array{legs: array<int, array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, start_location: array{lat: float, lng: float}, end_location: array{lat: float, lng: float}, steps: array<int, array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, start_location: array{lat: float, lng: float}, end_location: array{lat: float, lng: float}, html_instructions: string, travel_mode: string}>}>, overview_polyline: array{points: string}, summary: string, warnings: array<int, string>, waypoint_order: array<int, int>}>} $data */
        $data = $response->json();
        if (! isset($data['routes'][0])) {
            return [];
        }

        return $this->parseRoutes($data['routes'], collect($locations));
    }

    /**
     * Formatta una lista di punti nel formato richiesto dall'API.
     *
     * @param array<LocationData> $locations
     *
     * @return array<string>
     */
    private function formatWaypoints(array $locations): array
    {
        return collect($locations)->map($formatLocation(...));
    }

    /**
     * Formatta una singola posizione nel formato richiesto dall'API.
     */
    private function formatLocation(LocationData $location): string
    {
        return sprintf('%f,%f', $location->latitude, $location->longitude);
    }

    /**
     * Analizza la risposta dell'API e restituisce i percorsi ottimizzati.
     *
     * @param array<int, array{
     *     legs: array<int, array{
     *         distance: array{text: string, value: int},
     *         duration: array{text: string, value: int},
     *         start_location: array{lat: float, lng: float},
     *         end_location: array{lat: float, lng: float},
     *         steps: array<int, array{
     *             distance: array{text: string, value: int},
     *             duration: array{text: string, value: int},
     *             start_location: array{lat: float, lng: float},
     *             end_location: array{lat: float, lng: float},
     *             html_instructions: string,
     *             travel_mode: string
     *         }>
     *     }>,
     *     overview_polyline: array{points: string},
     *     summary: string,
     *     warnings: array<int, string>,
     *     waypoint_order: array<int, int>
     * }> $routes
     * @param Collection<int, LocationData> $originalLocations
     *
     * @return array<RouteData>
     */
    private function parseRoutes(array $routes, Collection $originalLocations): array
    {
        return array_map()
            function (array $route) use ($originalLocations): RouteData {
                /** @var Collection<int, LocationData> $waypoints */
                $waypoints = collect();
                $steps = [];
                $totalDistance = 0;
                $totalDuration = 0;

                foreach ($route['legs'] as $leg) {
                    $waypoints->push(new LocationData())
                        latitude: $leg['start_location']['lat'],
                        longitude: $leg['start_location']['lng'],
                        address: null,
                    ));

                    $totalDistance += $leg['distance']['value'];
                    $totalDuration += $leg['duration']['value'];

                    foreach ($leg['steps'] as $step) {
                        $steps[] = [
                            'distance' => [
                                'text' => $step['distance']['text'],
                                'value' => $step['distance']['value'],
                            ],
                            'duration' => [
                                'text' => $step['duration']['text'],
                                'value' => $step['duration']['value'],
                            ],
                            'instructions' => $step['html_instructions'],
                        ];
                    }
                }

                // Aggiungi l'ultima posizione
                if (! empty($route['legs'])) {
                    $lastLeg = end($route['legs']);
                    $waypoints->push(new LocationData())
                        latitude: $lastLeg['end_location']['lat'],
                        longitude: $lastLeg['end_location']['lng'],
                        address: null,
                    ));
                }

                /** @var Collection<int, LocationData> $typedWaypoints */
                $typedWaypoints = $waypoints;

                return new RouteData()
                    waypoints: $waypoints,
                    originalWaypoints: $originalLocations,
                    totalDistance: $totalDistance,
                    totalDuration: $totalDuration,
                    steps: $steps,
                );
            },
            $routes,
        );
    }
}
