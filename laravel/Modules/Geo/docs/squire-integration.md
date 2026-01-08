# Integrazione con Squire per dati geografici

## Contesto
Squire è una libreria PHP che fornisce dati geografici per vari paesi. Per l'Italia, fornisce:
- Regioni
- Province
- Comuni
- CAP

## Installazione
```bash
composer require squirephp/squire
```

## Configurazione
1. Pubblicare la configurazione:
```bash
php artisan vendor:publish --provider="Squire\SquireServiceProvider"
```

2. Configurare il file `config/squire.php`:
```php
return [
    'models' => [
        'region' => \Modules\Geo\Models\Region::class,
        'province' => \Modules\Geo\Models\Province::class,
        'city' => \Modules\Geo\Models\City::class,
        'cap' => \Modules\Geo\Models\Cap::class,
    ],
    'seeds' => [
        'region' => true,
        'province' => true,
        'city' => true,
        'cap' => true,
    ],
];
```

## Utilizzo in Filament

### 1. Select per Regioni
```php
use Modules\Geo\Models\Region;

Select::make('region')
    ->options(fn () => Region::all()->pluck('name', 'id'))
    ->searchable()
    ->required()
    ->live()
    ->afterStateUpdated(fn (Set $set) => $set('province', null))
    ->selectablePlaceholder(false)
```

### 2. Select per Province
```php
use Modules\Geo\Models\Province;

Select::make('province')
    ->options(fn (Get $get) => 
        Province::where('region_id', $get('region'))
            ->orderBy('name')
            ->pluck('name', 'id')
    )
    ->searchable()
    ->required()
    ->live()
    ->afterStateUpdated(fn (Set $set) => $set('city', null))
    ->visible(fn (Get $get) => filled($get('region')))
    ->selectablePlaceholder(false)
```

### 3. Select per Città
```php
use Modules\Geo\Models\City;

Select::make('city')
    ->options(fn (Get $get) => 
        City::where('province_id', $get('province'))
            ->orderBy('name')
            ->pluck('name', 'id')
    )
    ->searchable()
    ->required()
    ->live()
    ->afterStateUpdated(fn (Set $set) => $set('cap', null))
    ->visible(fn (Get $get) => filled($get('province')))
    ->selectablePlaceholder(false)
```

### 4. Select per CAP
```php
use Modules\Geo\Models\Cap;

Select::make('cap')
    ->options(fn (Get $get) => 
        Cap::where('city_id', $get('city'))
            ->orderBy('code')
            ->pluck('code', 'id')
    )
    ->searchable()
    ->required()
    ->visible(fn (Get $get) => filled($get('city')))
    ->selectablePlaceholder(false)
```

## Best Practices

1. **Performance**
   - Utilizzare indici sui campi di ricerca
   - Implementare caching per le query frequenti
   - Limitare il numero di risultati per select

2. **UX**
   - Aggiungere placeholder informativi
   - Implementare validazione in tempo reale
   - Fornire feedback visivo durante il caricamento

3. **Validazione**
   - Verificare la coerenza tra regioni e province
   - Validare i CAP in base alla città
   - Gestire i casi di errore

4. **Caching**
```php
use Illuminate\Support\Facades\Cache;

// Cache per 24 ore
$regions = Cache::remember('regions', 86400, function () {
    return Region::all()->pluck('name', 'id');
});
```

## Esempio Completo

```php
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Modules\Geo\Models\{Region, Province, City, Cap};

public function getFormSchema(): array
{
    return [
        'location' => Fieldset::make('location')
            ->schema([
                'region' => Select::make('region')
                    ->options(fn () => Region::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('province', null))
                    ->selectablePlaceholder(false),

                'province' => Select::make('province')
                    ->options(fn (Get $get) => 
                        Province::where('region_id', $get('region'))
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('city', null))
                    ->visible(fn (Get $get) => filled($get('region')))
                    ->selectablePlaceholder(false),

                'city' => Select::make('city')
                    ->options(fn (Get $get) => 
                        City::where('province_id', $get('province'))
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                    ->visible(fn (Get $get) => filled($get('province')))
                    ->selectablePlaceholder(false),

                'cap' => Select::make('cap')
                    ->options(fn (Get $get) => 
                        Cap::where('city_id', $get('city'))
                            ->orderBy('code')
                            ->pluck('code', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->visible(fn (Get $get) => filled($get('city')))
                    ->selectablePlaceholder(false),
            ]),
    ];
}
```

## Note Aggiuntive

1. **Gestione dei dati**
   - I dati vengono caricati automaticamente da Squire
   - È possibile personalizzare i dati tramite seeders
   - Mantenere i dati aggiornati è importante

2. **Personalizzazione**
   - È possibile estendere i modelli per aggiungere funzionalità
   - Implementare scopes per query comuni
   - Aggiungere metodi di utilità

3. **Manutenzione**
   - Monitorare le performance
   - Aggiornare i dati periodicamente
   - Mantenere la documentazione aggiornata

## Collegamenti
- [Documentazione Squire](https://github.com/squirephp/squire)
- [Best Practices Filament](../../../docs/filament-best-practices.md)
- [Clean Code](../../../docs/clean-code.md)

**Nota:** Il namespace corretto per LocationForm è `Modules\Geo\Filament\Forms\LocationForm`. Non usare mai `Modules\Geo\App\Filament\Forms\LocationForm`. 