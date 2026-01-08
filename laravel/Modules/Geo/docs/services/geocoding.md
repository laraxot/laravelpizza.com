# Servizio di Geocoding

## Overview
Il servizio di geocoding è responsabile della conversione di indirizzi testuali in coordinate geografiche (latitudine e longitudine). Questo servizio è essenziale per funzionalità come la visualizzazione di mappe, il calcolo di distanze e l'analisi territoriale.

## Implementazione

### Interfaccia del Servizio
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Contracts;

use Modules\Geo\Models\Address;

interface GeocodeServiceInterface
{
    /**
     * Geocode un indirizzo in coordinate.
     *
     * @param Address|string $address
     * @return array{latitude: ?float, longitude: ?float}|null
     */
    public function geocode($address): ?array;

    /**
     * Reverse geocode (coordinate a indirizzo).
     *
     * @param float $latitude
     * @param float $longitude
     * @return Address|null
     */
    public function reverseGeocode(float $latitude, float $longitude): ?Address;
}
```

### Implementazione con Google Maps
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Modules\Geo\Contracts\GeocodeServiceInterface;
use Modules\Geo\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleGeocodeService implements GeocodeServiceInterface
{
    /**
     * Geocode un indirizzo in coordinate.
     *
     * @param Address|string $address
     * @return array{latitude: ?float, longitude: ?float}|null
     */
    public function geocode($address): ?array
    {
        try {
            $query = is_string($address) ? $address : $this->formatAddressForGeocode($address);
            
            // Per indirizzi italiani, appendere "Italia" per maggiore precisione
            if ($address instanceof Address && $address->address_country === 'IT') {
                $query .= ', Italia';
            }
            
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $query,
                'key' => config('geo.google_maps_api_key'),
            ]);
            
            $data = $response->json();
            
            if ($response->successful() && isset($data['results'][0]['geometry']['location'])) {
                $location = $data['results'][0]['geometry']['location'];
                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                ];
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Reverse geocode (coordinate a indirizzo).
     *
     * @param float $latitude
     * @param float $longitude
     * @return Address|null
     */
    public function reverseGeocode(float $latitude, float $longitude): ?Address
    {
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng' => "{$latitude},{$longitude}",
                'key' => config('geo.google_maps_api_key'),
            ]);
            
            $data = $response->json();
            
            if ($response->successful() && isset($data['results'][0])) {
                return $this->parseGoogleAddress($data['results'][0]);
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Reverse geocoding error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Formatta un indirizzo per il geocoding.
     *
     * @param Address $address
     * @return string
     */
    private function formatAddressForGeocode(Address $address): string
    {
        $parts = [];
        
        if ($address->street_address) {
            $parts[] = $address->street_address;
        }
        
        if ($address->address_locality) {
            $parts[] = $address->address_locality;
        }
        
        // Per gli indirizzi italiani, includiamo sia provincia che regione
        if ($address->address_country === 'IT') {
            if ($address->province) {
                $parts[] = $address->province;
            }
            
            if ($address->address_region) {
                $parts[] = $address->address_region;
            }
        } else {
            if ($address->address_region) {
                $parts[] = $address->address_region;
            }
        }
        
        if ($address->postal_code) {
            $parts[] = $address->postal_code;
        }
        
        if ($address->address_country) {
            // Converti codice paese in nome paese completo
            $countryName = \Countries::getCountryName($address->address_country);
            if ($countryName) {
                $parts[] = $countryName;
            }
        }
        
        return implode(', ', $parts);
    }
    
    /**
     * Analizza una risposta Google per creare un oggetto Address.
     *
     * @param array $result
     * @return Address
     */
    private function parseGoogleAddress(array $result): Address
    {
        $address = new Address();
        $address->formatted_address = $result['formatted_address'] ?? null;
        $address->latitude = $result['geometry']['location']['lat'] ?? null;
        $address->longitude = $result['geometry']['location']['lng'] ?? null;
        
        // Mappa dei componenti dell'indirizzo
        $components = [];
        foreach ($result['address_components'] as $component) {
            foreach ($component['types'] as $type) {
                $components[$type] = [
                    'long_name' => $component['long_name'],
                    'short_name' => $component['short_name'],
                ];
            }
        }
        
        // Mappiamo i componenti ai campi del nostro modello
        $address->street_address = $this->getStreetAddress($components);
        $address->street_number = $components['street_number']['long_name'] ?? null;
        $address->address_locality = $components['locality']['long_name'] ?? ($components['postal_town']['long_name'] ?? null);
        
        // Per l'Italia, gestiamo separatamente provincia e regione
        if (isset($components['country']) && $components['country']['short_name'] === 'IT') {
            $address->address_country = 'IT';
            
            // Provincia (administrative_area_level_2 in Italia)
            if (isset($components['administrative_area_level_2'])) {
                $address->province = $components['administrative_area_level_2']['long_name'];
                // Estraiamo la sigla provincia da 'MI - Milano'
                if (preg_match('/^([A-Z]{2})/', $components['administrative_area_level_2']['short_name'], $matches)) {
                    $address->province_short = $matches[1];
                }
            }
            
            // Regione (administrative_area_level_1 in Italia)
            if (isset($components['administrative_area_level_1'])) {
                $address->address_region = $components['administrative_area_level_1']['long_name'];
            }
        } else {
            // Per altri paesi
            $address->address_region = $components['administrative_area_level_1']['long_name'] ?? null;
            $address->address_country = $components['country']['short_name'] ?? null;
        }
        
        $address->postal_code = $components['postal_code']['long_name'] ?? null;
        
        return $address;
    }
    
    /**
     * Ottiene l'indirizzo stradale completo dai componenti.
     *
     * @param array $components
     * @return string|null
     */
    private function getStreetAddress(array $components): ?string
    {
        $route = $components['route']['long_name'] ?? null;
        $streetNumber = $components['street_number']['long_name'] ?? null;
        
        if ($route) {
            if ($streetNumber) {
                return "{$route}, {$streetNumber}";
            }
            return $route;
        }
        
        return null;
    }
}
```

## Utilizzo con il Modello Address

### Observer per Geocoding Automatico
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Observers;

use Modules\Geo\Contracts\GeocodeServiceInterface;
use Modules\Geo\Models\Address;

class AddressObserver
{
    private GeocodeServiceInterface $geocodeService;
    
    public function __construct(GeocodeServiceInterface $geocodeService)
    {
        $this->geocodeService = $geocodeService;
    }
    
    /**
     * Handle the Address "saving" event.
     *
     * @param Address $address
     * @return void
     */
    public function saving(Address $address): void
    {
        // Verifica se le coordinate sono mancanti ma abbiamo un indirizzo
        if ((!$address->latitude || !$address->longitude) && 
            ($address->street_address || $address->address_locality)) {
            
            $coordinates = $this->geocodeService->geocode($address);
            
            if ($coordinates) {
                $address->latitude = $coordinates['latitude'];
                $address->longitude = $coordinates['longitude'];
            }
        }
        
        // Se non abbiamo un indirizzo formattato ma abbiamo le altre informazioni
        if (!$address->formatted_address && $address->street_address) {
            $address->formatted_address = $this->formatAddress($address);
        }
    }
    
    /**
     * Formatta un indirizzo basato sui suoi componenti.
     *
     * @param Address $address
     * @return string
     */
    private function formatAddress(Address $address): string
    {
        $parts = [];
        
        if ($address->street_address) {
            $parts[] = $address->street_address;
        }
        
        $localityParts = [];
        
        if ($address->postal_code) {
            $localityParts[] = $address->postal_code;
        }
        
        if ($address->address_locality) {
            $localityParts[] = $address->address_locality;
        }
        
        // Per indirizzi italiani, includiamo la sigla provincia tra parentesi
        if ($address->address_country === 'IT' && $address->province_short) {
            $localityParts[] = "({$address->province_short})";
        }
        
        if (!empty($localityParts)) {
            $parts[] = implode(' ', $localityParts);
        }
        
        // Per indirizzi italiani, aggiungiamo la regione
        if ($address->address_country === 'IT' && $address->address_region) {
            $parts[] = $address->address_region;
        } elseif ($address->address_region) {
            $parts[] = $address->address_region;
        }
        
        if ($address->address_country) {
            $countryName = \Countries::getCountryName($address->address_country);
            if ($countryName) {
                $parts[] = strtoupper($countryName);
            }
        }
        
        return implode("\n", $parts);
    }
}
```

### Registrazione dell'Observer
```php
<?php

namespace Modules\Geo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Geo\Contracts\GeocodeServiceInterface;
use Modules\Geo\Models\Address;
use Modules\Geo\Observers\AddressObserver;
use Modules\Geo\Services\GoogleGeocodeService;

class GeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(GeocodeServiceInterface::class, GoogleGeocodeService::class);
        
        Address::observe(AddressObserver::class);
    }
}
```

## Considerazioni per gli Indirizzi Italiani

Per migliorare la precisione del geocoding per gli indirizzi italiani:

1. **Appendere "Italia"** alla query di geocoding
2. **Includere provincia e regione** nei dati inviati
3. **Utilizzare il formato CAP corretto** (5 cifre)
4. **Verificare la corrispondenza** tra CAP e comune

### Esempio Specifico per l'Italia

```php
/**
 * Ottimizza la geocodifica per indirizzi italiani.
 *
 * @param Address $address
 * @return array{latitude: ?float, longitude: ?float}|null
 */
public function geocodeItalianAddress(Address $address): ?array
{
    if ($address->address_country !== 'IT') {
        return $this->geocode($address);
    }
    
    // Costruisci query ottimizzata per l'Italia
    $query = [];
    
    if ($address->street_address) {
        $query[] = $address->street_address;
    }
    
    if ($address->address_locality) {
        // Aggiungi sigla provincia per maggiore precisione
        if ($address->province_short) {
            $query[] = "{$address->address_locality} ({$address->province_short})";
        } else {
            $query[] = $address->address_locality;
        }
    }
    
    if ($address->postal_code) {
        $query[] = $address->postal_code;
    }
    
    // Aggiungi sempre la regione per indirizzi italiani
    if ($address->address_region) {
        $query[] = $address->address_region;
    }
    
    // Aggiungi sempre "Italia" alla fine
    $query[] = 'Italia';
    
    return $this->geocode(implode(', ', $query));
}
```

## Provider di Geocoding Alternativi

Oltre a Google Maps, è possibile implementare altri provider:

1. **OpenStreetMap/Nominatim** - Soluzione open source
2. **HERE Maps** - Alternativa commerciale
3. **Mapbox** - Soluzione per alta personalizzazione
4. **TomTom** - Focus sulla precisione

Il servizio dovrebbe essere configurabile per passare facilmente da un provider all'altro.