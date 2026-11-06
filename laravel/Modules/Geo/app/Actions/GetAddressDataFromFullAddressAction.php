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
use Modules\Geo\Datas\Geocoding\AddressData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per ottenere i dati dell'indirizzo utilizzando diversi servizi di geocoding.
 */
class GetAddressDataFromFullAddressAction
{
    use QueueableAction;

    /** @var Collection<int, string> */
    public Collection $errors;

    public function __construct()
    {
        $this->errors = new Collection();
    }

    /**
     * Ottiene i dati dell'indirizzo da un indirizzo completo.
     *
     * @param string $fullAddress L'indirizzo da cercare
     *
     * @throws \RuntimeException Se la richiesta fallisce o l'indirizzo non viene trovato
     *
     * @return AddressData|null I dati dell'indirizzo trovato, null se nessun provider risponde
     */
    public function execute(string $fullAddress): ?AddressData
    {
        $this->errors = new Collection();

        // Catena di provider e ordine di default: stessi 7 provider, stesso
        // ordine, dell'array hardcoded preesistente (Google per primo). La
        // mappa resta letterale qui (non in config/config.php, non in un
        // metodo separato) perché Larastan tipizza `app($class)->execute()`
        // solo se `$class` è un `class-string<T>` letterale risolto nello
        // stesso scope del try/catch che lo consuma: passarlo attraverso un
        // metodo (anche con `@return class-string<...>` esplicito) o per
        // config() lo fa degradare a `mixed` quando letto dentro un blocco
        // try. `geo.driver` resta comunque l'unico punto di configurazione
        // per scegliere il provider preferito, da env, senza toccare codice.
        $services = [
            'google_maps' => GetAddressFromGoogleMapsAction::class,
            'photon' => GetAddressFromPhotonAction::class,
            'nominatim' => GetAddressFromNominatimAction::class,
            'bing_maps' => GetAddressFromBingMapsAction::class,
            'here' => GetAddressFromHereMapsAction::class,
            'mapbox' => GetAddressFromMapboxAction::class,
            'opencage' => GetAddressFromOpenCageAction::class,
        ];

        $preferred = config('geo.driver');
        if (\is_string($preferred) && \array_key_exists($preferred, $services)) {
            $preferredClass = $services[$preferred];
            unset($services[$preferred]);
            $services = [$preferred => $preferredClass] + $services;
        }

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
                $this->errors->push($e->getMessage());
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

    /**
     * @return Collection<int, string>
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }
}
