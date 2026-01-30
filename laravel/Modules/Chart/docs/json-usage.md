# Utilizzo del file JSON dei comuni

## Contesto
Il file `resources/json/comuni.json` contiene i dati geografici italiani in formato JSON. Questo file può essere utilizzato come alternativa a Squire o come fonte di dati aggiuntiva.

## Struttura del file
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

## Utilizzo in Filament

### 1. Caricamento dei dati
```php
use Illuminate\Support\Facades\File;

class GeoDataService
{
    public function getRegions(): array
    {
        $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
        $data = json_decode($json, true);
        
        return collect($data['regions'])
            ->map(fn ($region) => [
                'id' => $region['code'],
                'name' => $region['name']
            ])
            ->toArray();
    }

    public function getProvinces(string $regionCode): array
    {
        $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
        $data = json_decode($json, true);
        
        return collect($data['regions'])
            ->firstWhere('code', $regionCode)['provinces']
            ->map(fn ($province) => [
                'id' => $province['code'],
                'name' => $province['name']
            ])
            ->toArray();
    }

    public function getCities(string $provinceCode): array
    {
        $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
        $data = json_decode($json, true);
        
        foreach ($data['regions'] as $region) {
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
}
```

### 2. Implementazione in Filament
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Modules\Geo\Services\GeoDataService;

class LocationForm extends Component
{
    protected GeoDataService $geoDataService;

    public function mount(): void
    {
        $this->geoDataService = app(GeoDataService::class);
    }

    public function getFormSchema(): array
    {
        return [
            'location' => Fieldset::make('location')
                ->schema([
                    'region' => Select::make('region')
                        ->options(fn () => $this->geoDataService->getRegions())
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('province', null))
                        ->selectablePlaceholder(false),

                    'province' => Select::make('province')
                        ->options(fn (Get $get) => 
                            $this->geoDataService->getProvinces($get('region'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('city', null))
                        ->visible(fn (Get $get) => filled($get('region')))
                        ->selectablePlaceholder(false),

                    'city' => Select::make('city')
                        ->options(fn (Get $get) => 
                            $this->geoDataService->getCities($get('province'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                        ->visible(fn (Get $get) => filled($get('province')))
                        ->selectablePlaceholder(false),

                    'cap' => Select::make('cap')
                        ->options(fn (Get $get) => 
                            collect($this->geoDataService->getCities($get('province')))
                                ->firstWhere('code', $get('city'))['cap']
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
   - Implementare caching per il file JSON
   - Caricare i dati solo quando necessario
   - Utilizzare collezioni per manipolare i dati

2. **Manutenzione**
   - Mantenere il file JSON aggiornato
   - Validare la struttura del JSON
   - Documentare eventuali modifiche

3. **Validazione**
   - Verificare l'esistenza del file
   - Validare la struttura dei dati
   - Gestire i casi di errore

## Esempio di Caching
```php
use Illuminate\Support\Facades\Cache;

class GeoDataService
{
    public function getRegions(): array
    {
        return Cache::remember('geo_regions', 86400, function () {
            $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
            $data = json_decode($json, true);
            
            return collect($data['regions'])
                ->map(fn ($region) => [
                    'id' => $region['code'],
                    'name' => $region['name']
                ])
                ->toArray();
        });
    }
}
```

## Note Aggiuntive

1. **Vantaggi**
   - Dati locali, nessuna dipendenza esterna
   - Controllo completo sui dati
   - Facile da mantenere e aggiornare

2. **Svantaggi**
   - File da mantenere aggiornato
   - Possibili problemi di performance con file grandi
   - Necessità di gestire la cache

3. **Alternative**
   - Utilizzare Squire
   - Implementare un'API esterna
   - Utilizzare un database dedicato

## Collegamenti
- [Documentazione Squire](../../Geo/docs/squire-integration.md)
- [Best Practices Filament](../../../docs/filament-best-practices.md)
- [Clean Code](../../../docs/clean-code.md)

**Nota:** Il namespace corretto per LocationForm è `Modules\Geo\Filament\Forms\LocationForm`. Non usare mai `Modules\Geo\App\Filament\Forms\LocationForm`. 