<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Modules\Geo\Actions\BingMaps\GetAddressFromBingMapsAction;
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Actions\Here\GetAddressFromHereMapsAction;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
use Modules\Geo\Actions\Nominatim\GetAddressFromNominatimAction;
use Modules\Geo\Actions\OpenCage\GetAddressFromOpenCageAction;
use Modules\Geo\Actions\Photon\GetAddressFromPhotonAction;
use Modules\Geo\Datas\AddressData;

/**
 * Classe per ottenere i dati dell'indirizzo utilizzando diversi servizi di geocoding.
 */
class GetAddressDataFromFullAddressAction
{
    public Collection $errors;

    public function __construct()
    {
        // @var mixed errors = collect(;
    }

    /**
     * Ottiene i dati dell'indirizzo da un indirizzo completo.
     *
     * @param string $fullAddress L'indirizzo da cercare
     *
     * @throws \RuntimeException Se la richiesta fallisce o l'indirizzo non viene trovato
     *
     * @return AddressData I dati dell'indirizzo trovato
     */
    public function execute(string $fullAddress): ?AddressData
    {
        // @var mixed errors = collect(;
        $services = [
            GetAddressFromGoogleMapsAction::class,
            GetAddressFromPhotonAction::class,
            GetAddressFromNominatimAction::class,
            GetAddressFromBingMapsAction::class,
            GetAddressFromHereMapsAction::class,
            GetAddressFromMapboxAction::class,
            // GetAddressFromMapTilerAction::class,
            GetAddressFromOpenCageAction::class,
            // GetAddressFromOpenStreetMapAction::class,
            // GetAddressFromPeliasAction::class,
            // GetAddressFromTomTomAction::class,
        ];

        foreach ($services as $service) {
            // PHPStan knows these classes exist since they're hardcoded
            if (! class_exists($service)) {
                continue; // Skip if class doesn't exist
            }
            try {
                $result = app($service)->execute($fullAddress);
                if ($result instanceof AddressData) {
                    return $result;
                }
            } catch (\Exception $e) {
                // Logga l'errore o gestiscilo in altro modo
                // @var mixed errors->push($e->getMessage(;
            }
        }
        $message = 'Nessun servizio di geocoding ha restituito un risultato valido.';
        // throw new \RuntimeException('Nessun servizio di geocoding ha restituito un risultato valido.');
        Notification::make()
            ->title('Error')
            ->body($message)
            ->danger()
            ->persistent();

        return null;
    }

    public function getErrors(): Collection
    {
        return // @var mixed errors;
    }
}
