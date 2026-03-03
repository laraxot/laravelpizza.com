# Location Select Component

## Overview

This document describes how to implement a cascading location selector (Region → Province → City → CAP) in Filament forms using the Geo module's models and data.

## Prerequisites

- Laravel 10+
- Filament 3.x
- Geo module with populated data

## Implementation

### 1. Create LocationSelect Component

Create a new Filament form component that will handle the cascading selection:

```php
// app/Filament/Forms/Components/LocationSelect.php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;

class LocationSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateUpdated(function ($state, callable $set) {
            // Clear dependent fields when parent changes
            $path = $this->getStatePath();
            
            if ($path === 'region_id') {
                $set('province_id', null);
                $set('city_id', null);
                $set('cap', null);
            } elseif ($path === 'province_id') {
                $set('city_id', null);
                $set('cap', null);
            } elseif ($path === 'city_id') {
                $set('cap', null);
            }
        });
    }
    
    public static function make(string $name): static
    {
        return parent::make($name)->searchable()->reactive();
    }
    
    public function getRegionSelect(): static
    {
        return $this->make('region_id')
            ->label(__('geo::location.region'))
            ->options(fn () => \Modules\Geo\Models\Region::query()
                ->orderBy('name')
                ->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->reactive();
    }
    
    public function getProvinceSelect(): static
    {
        return $this->make('province_id')
            ->label(__('geo::location.province'))
            ->options(function (callable $get) {
                $regionId = $get('region_id');
                return $regionId ? \Modules\Geo\Models\Province::query()
                    ->where('region_id', $regionId)
                    ->orderBy('name')
                    ->pluck('name', 'id') : [];
            })
            ->searchable()
            ->required()
            ->reactive();
    }
    
    public function getCitySelect(): static
    {
        return $this->make('city_id')
            ->label(__('geo::location.city'))
            ->options(function (callable $get) {
                $provinceId = $get('province_id');
                return $provinceId ? \Modules\Geo\Models\City::query()
                    ->where('province_id', $provinceId)
                    ->orderBy('name')
                    ->pluck('name', 'id') : [];
            })
            ->searchable()
            ->required()
            ->reactive();
    }
    
    public function getCapSelect(): static
    {
        return $this->make('cap')
            ->label(__('geo::location.postal_code'))
            ->options(function (callable $get) {
                $cityId = $get('city_id');
                return $cityId ? \Modules\Geo\Models\Cap::query()
                    ->where('city_id', $cityId)
                    ->orderBy('code')
                    ->pluck('code', 'code') : [];
            })
            ->searchable()
            ->required();
    }
}
```

### 2. Register the Component

Add the component to your Filament panel service provider:

```php
// app/Providers/Filament/AdminPanelProvider.php

use App\Filament\Forms\Components\LocationSelect;

// ...

public function panel(Panel $panel): Panel
{
    return $panel
        ->components([
            Forms\Components\Tabs::make('Location')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Location')
                        ->schema([
                            LocationSelect::make('region_id')
                                ->getRegionSelect(),
                                
                            LocationSelect::make('province_id')
                                ->getProvinceSelect(),
                                
                            LocationSelect::make('city_id')
                                ->getCitySelect(),
                                
                            LocationSelect::make('cap')
                                ->getCapSelect(),
                        ]),
                ]),
        ]);
}
```

### 3. Add Translations

Add translations for the location fields in your language files:

```php
// resources/lang/vendor/geo/en/location.php

return [
    'region' => 'Region',
    'province' => 'Province',
    'city' => 'City',
    'postal_code' => 'Postal Code',
];

// resources/lang/vendor/geo/it/location.php

return [
    'region' => 'Regione',
    'province' => 'Provincia',
    'city' => 'Comune',
    'postal_code' => 'CAP',
];
```

## Usage Example

Here's how to use the component in a Filament resource:

```php
// app/Filament/Resources/AddressResource.php

use App\Filament\Forms\Components\LocationSelect;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Other fields...
            
            Forms\Components\Fieldset::make(__('geo::location.location'))
                ->schema([
                    LocationSelect::make('region_id')
                        ->getRegionSelect(),
                        
                    LocationSelect::make('province_id')
                        ->getProvinceSelect(),
                        
                    LocationSelect::make('city_id')
                        ->getCitySelect(),
                        
                    LocationSelect::make('cap')
                        ->getCapSelect(),
                        
                    Forms\Components\TextInput::make('address')
                        ->label(__('geo::location.address'))
                        ->required(),
                ]),
        ]);
}
```

## Data Import

To import data from the `comuni.json` file, create a command:

```php
// app/Console/Commands/ImportGeoData.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;

class ImportGeoData extends Command
{
    protected $signature = 'geo:import';
    protected $description = 'Import Italian geographical data from JSON';

    public function handle()
    {
        $json = json_decode(file_get_contents(module_path('Geo', 'resources/json/comuni.json')), true);
        
        DB::transaction(function () use ($json) {
            foreach ($json as $item) {
                // Import region
                $region = Region::firstOrCreate(
                    ['code' => $item['regione']['codice']],
                    ['name' => $item['regione']['nome']]
                );
                
                // Import province
                $province = Province::firstOrCreate(
                    ['code' => $item['provincia']['codice']],
                    [
                        'name' => $item['provincia']['nome'],
                        'region_id' => $region->id,
                    ]
                );
                
                // Import city
                $city = City::firstOrCreate(
                    ['code' => $item['codice']],
                    [
                        'name' => $item['nome'],
                        'province_id' => $province->id,
                    ]
                );
                
                // Import CAPs
                foreach ($item['cap'] as $capCode) {
                    Cap::firstOrCreate(
                        [
                            'code' => $capCode,
                            'city_id' => $city->id,
                        ]
                    );
                }
            }
            
            $this->info('Geographical data imported successfully!');
        });
    }
}
```

## Performance Optimization

1. **Caching**: Cache the options for better performance:

```php
// In your LocationSelect component
public function getRegionSelect(): static
{
    return $this->make('region_id')
        ->label(__('geo::location.region'))
        ->options(fn () => \Cache::remember('regions', now()->addDay(), function () {
            return \Modules\Geo\Models\Region::query()
                ->orderBy('name')
                ->pluck('name', 'id');
        }))
        ->searchable()
        ->required()
        ->reactive();
}
```

2. **Lazy Loading**: Use lazy loading for large datasets:

```php
->options(fn () => \Modules\Geo\Models\City::query()
    ->where('province_id', $provinceId)
    ->orderBy('name')
    ->lazy()
    ->pluck('name', 'id'))
```

3. **Debounce Search**: Add debounce to search inputs:

```php
->searchable()
->searchDebounce(300) // ms
```

## Testing

Create feature tests to ensure the component works as expected:

```php
// tests/Feature/LocationSelectTest.php

namespace Tests\Feature;

use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;
use Tests\TestCase;

class LocationSelectTest extends TestCase
{
    public function test_location_select_workflow()
    {
        $region = Region::factory()->create();
        $province = Province::factory()->create(['region_id' => $region->id]);
        $city = City::factory()->create(['province_id' => $province->id]);
        $cap = Cap::factory()->create(['city_id' => $city->id]);
        
        $this->get(route('filament.resources.addresses.create'))
            ->assertSuccessful()
            ->assertSee('Region');
            
        // Test region selection
        $this->post(route('filament.resources.addresses.get-province-options'), [
            'region_id' => $region->id
        ])->assertJson([$province->id => $province->name]);
        
        // Test city selection
        $this->post(route('filament.resources.addresses.get-city-options'), [
            'province_id' => $province->id
        ])->assertJson([$city->id => $city->name]);
        
        // Test CAP selection
        $this->post(route('filament.resources.addresses.get-cap-options'), [
            'city_id' => $city->id
        ])->assertJson([$cap->code => $cap->code]);
    }
}
```

## Related Documentation

- [Filament Forms Documentation](https://filamentphp.com/project_docs/3.x/forms/fields/select)
- [Laravel Eloquent Relationships](https://laravel.com/project_docs/10.x/eloquent-relationships)
- [Laravel Caching](https://laravel.com/project_docs/10.x/cache)

## License

MIT

## Nota importante

**Il namespace corretto per la classe LocationForm è:**

```php
use Modules\Geo\Filament\Forms\LocationForm;
```

Non utilizzare mai `Modules\Geo\App\Filament\Forms\LocationForm`.

> Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path o del namespace.
