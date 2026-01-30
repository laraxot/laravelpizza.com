# JSON come Database per Dati Geografici

## Contesto
Il file `resources/json/comuni.json` contiene i dati geografici italiani in formato JSON. Data la sua dimensione ridotta e la natura statica dei dati, è più efficiente utilizzarlo direttamente come fonte dati invece di creare tabelle nel database.

## Vantaggi dell'approccio JSON
1. **Semplicità**
   - Nessuna migrazione del database
   - Nessuna query SQL
   - Dati sempre disponibili

2. **Performance**
   - Caricamento veloce
   - Caching efficiente
   - Nessun overhead di database

3. **Manutenibilità**
   - Aggiornamento semplice del file JSON
   - Versioning dei dati
   - Backup facile

## Implementazione

### 1. Struttura del JSON
```json
{
    "regions": [
        {
            "name": "Lombardia",
            "code": "LO",
            "provinces": [
                {
                    "name": "Milano",
                    "code": "MI",
                    "cities": [
                        {
                            "name": "Milano",
                            "code": "F205",
                            "cap": "20100"
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 2. Servizio di Accesso ai Dati
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GeoDataService
{
    private const CACHE_KEY = 'geo_data';
    private const CACHE_TTL = 86400; // 24 ore

    private array $data;

    public function __construct()
    {
        $this->data = $this->loadData();
    }

    private function loadData(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
            return json_decode($json, true);
        });
    }

    public function getRegions(): array
    {
        return collect($this->data['regions'])
            ->map(fn ($region) => [
                'id' => $region['code'],
                'name' => $region['name']
            ])
            ->toArray();
    }

    public function getProvinces(string $regionCode): array
    {
        $region = collect($this->data['regions'])
            ->firstWhere('code', $regionCode);

        if (!$region) {
            return [];
        }

        return collect($region['provinces'])
            ->map(fn ($province) => [
                'id' => $province['code'],
                'name' => $province['name']
            ])
            ->toArray();
    }

    public function getCities(string $provinceCode): array
    {
        foreach ($this->data['regions'] as $region) {
            foreach ($region['provinces'] as $province) {
                if ($province['code'] === $provinceCode) {
                    return collect($province['cities'])
                        ->map(fn ($city) => [
                            'id' => $city['code'],
                            'name' => $city['name'],
                            'cap' => $city['cap']
                        ])
                        ->toArray();
                }
            }
        }

        return [];
    }

    public function getCap(string $provinceCode, string $cityCode): ?string
    {
        $cities = $this->getCities($provinceCode);
        
        $city = collect($cities)
            ->firstWhere('id', $cityCode);

        return $city['cap'] ?? null;
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
```

### 3. Utilizzo in Filament
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Modules\Geo\App\Services\GeoDataService;

class LocationForm
{
    public static function getSchema(): array
    {
        $geoService = app(GeoDataService::class);

        return [
            'location' => Fieldset::make('location')
                ->schema([
                    'region' => Select::make('region')
                        ->options(fn () => $geoService->getRegions())
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('province', null))
                        ->selectablePlaceholder(false),

                    'province' => Select::make('province')
                        ->options(fn (Get $get) => 
                            $geoService->getProvinces($get('region'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('city', null))
                        ->visible(fn (Get $get) => filled($get('region')))
                        ->selectablePlaceholder(false),

                    'city' => Select::make('city')
                        ->options(fn (Get $get) => 
                            $geoService->getCities($get('province'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                        ->visible(fn (Get $get) => filled($get('province')))
                        ->selectablePlaceholder(false),

                    'cap' => Select::make('cap')
                        ->options(fn (Get $get) => 
                            collect($geoService->getCities($get('province')))
                                ->firstWhere('id', $get('city'))['cap']
                        )
                        ->required()
                        ->visible(fn (Get $get) => filled($get('city')))
                        ->selectablePlaceholder(false),
                ]),
        ];
    }
}
```

## Best Practices

1. **Performance**
   - Cache del file JSON in memoria
   - Caricamento lazy dei dati
   - Ottimizzazione delle query

2. **Manutenzione**
   - Versioning del file JSON
   - Validazione della struttura
   - Backup automatico

3. **Validazione**
   - Schema JSON
   - Integrità dei dati
   - Gestione errori

## Esempio di Validazione
```php
use Illuminate\Support\Facades\Validator;

class GeoDataValidator
{
    public function validate(array $data): bool
    {
        $rules = [
            'regions' => 'required|array',
            'regions.*.name' => 'required|string',
            'regions.*.code' => 'required|string|size:2',
            'regions.*.provinces' => 'required|array',
            'regions.*.provinces.*.name' => 'required|string',
            'regions.*.provinces.*.code' => 'required|string|size:2',
            'regions.*.provinces.*.cities' => 'required|array',
            'regions.*.provinces.*.cities.*.name' => 'required|string',
            'regions.*.provinces.*.cities.*.code' => 'required|string',
            'regions.*.provinces.*.cities.*.cap' => 'required|string|size:5',
        ];

        $validator = Validator::make($data, $rules);

        return !$validator->fails();
    }
}
```

## Note Aggiuntive

1. **Vantaggi rispetto al Database**
   - Nessuna migrazione
   - Nessuna query SQL
   - Dati sempre disponibili
   - Backup semplice
   - Versioning facile

2. **Svantaggi**
   - Dati in memoria
   - Aggiornamento manuale
   - Possibili problemi con file molto grandi

3. **Alternative**
   - Database SQLite
   - File YAML
   - API esterna

## Collegamenti
- [Documentazione Squire](../../Geo/docs/squire-integration.md)
- [Best Practices Filament](../../../docs/filament-best-practices.md)
- [Clean Code](../../../docs/clean-code.md) 