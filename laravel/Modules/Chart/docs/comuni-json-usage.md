# Using comuni.json for Location Data

## Overview

This document explains how to use the `comuni.json` file to populate and work with Italian geographical data in the Geo module.

## File Structure

The `comuni.json` file contains an array of Italian municipalities with the following structure for each entry:

```json
{
  "nome": "Abano Terme",
  "codice": "028001",
  "zona": {
    "codice": "2",
    "nome": "Nord-est"
  },
  "regione": {
    "codice": "05",
    "nome": "Veneto"
  },
  "provincia": {
    "codice": "028",
    "nome": "Padova"
  },
  "sigla": "PD",
  "codiceCatastale": "A001",
  "cap": ["35031"],
  "popolazione": 19349
}
```

## Data Import

### 1. Create an Import Command

Create a new Artisan command to import the data:

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
        $path = module_path('Geo', 'resources/json/comuni.json');
        
        if (!file_exists($path)) {
            $this->error("comuni.json not found at: {$path}");
            return 1;
        }
        
        $json = json_decode(file_get_contents($path), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: ' . json_last_error_msg());
            return 1;
        }
        
        $this->info('Starting import of Italian geographical data...');
        
        DB::transaction(function () use ($json) {
            $bar = $this->output->createProgressBar(count($json));
            
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
                        'region_id' => $region->id,
                        'name' => $item['provincia']['nome'],
                        'code_istat' => $item['provincia']['codice'],
                        'code_iso' => $item['sigla'],
                    ]
                );
                
                // Import city
                $city = City::firstOrCreate(
                    ['code' => $item['codice']],
                    [
                        'province_id' => $province->id,
                        'name' => $item['nome'],
                        'code_istat' => $item['codice'],
                        'code_cadastral' => $item['codiceCatastale'],
                        'population' => $item['popolazione'] ?? null,
                    ]
                );
                
                // Import CAPs
                foreach (($item['cap'] ?? []) as $capCode) {
                    Cap::firstOrCreate(
                        [
                            'code' => $capCode,
                            'city_id' => $city->id,
                        ]
                    );
                }
                
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine(2);
            
            $this->info('Geographical data imported successfully!');
            $this->info(sprintf(
                '- %d regions\n- %d provinces\n- %d cities\n- %d CAPs',
                Region::count(),
                Province::count(),
                City::count(),
                Cap::count()
            ));
        });
        
        return 0;
    }
}
```

### 2. Register the Command

Add the command to your `Kernel.php`:

```php
// app/Console/Kernel.php

protected $commands = [
    // ...
    \App\Console\Commands\ImportGeoData::class,
];
```

### 3. Run the Import

```bash
php artisan geo:import
```

## Using the Data in Filament

### 1. Create a LocationSelect Component

See the [Location Select Component](./location-select.md) documentation for details on implementing the select component.

### 2. Example Resource

Here's how to use the location fields in a Filament resource:

```php
// app/Filament/Resources/AddressResource.php

use App\Filament\Forms\Components\LocationSelect;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Other fields...
            
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('address')
                        ->label(__('geo::location.address'))
                        ->required(),
                        
                    Forms\Components\Grid::make(2)
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

## Data Updates

To update the geographical data:

1. Download the latest `comuni.json` file from the official source
2. Replace the file at `Modules/Geo/resources/json/comuni.json`
3. Run the import command:

```bash
php artisan geo:import --force
```

## Performance Considerations

1. **Caching**: Cache the options for better performance:

```php
// In your LocationSelect component
->options(fn () => \Cache::remember('regions', now()->addDay(), function () {
    return \Modules\Geo\Models\Region::query()
        ->orderBy('name')
        ->pluck('name', 'id');
}))
```

2. **Lazy Loading**: Use lazy loading for large datasets:

```php
->options(fn () => \Modules\Geo\Models\City::query()
    ->where('province_id', $provinceId)
    ->orderBy('name')
    ->lazy()
    ->pluck('name', 'id'))
```

3. **Indexing**: Ensure proper database indexes:

```php
// In your migrations
Schema::table('geo_cities', function (Blueprint $table) {
    $table->index('province_id');
    $table->index('name');
});

Schema::table('geo_provinces', function (Blueprint $table) {
    $table->index('region_id');
    $table->index('name');
});

Schema::table('geo_caps', function (Blueprint $table) {
    $table->index('city_id');
    $table->index('code');
});
```

## Related Documentation

- [Location Select Component](./location-select.md)
- [Filament Forms Documentation](https://filamentphp.com/docs/3.x/forms/fields/select)
- [Laravel Eloquent Relationships](https://laravel.com/docs/10.x/eloquent-relationships)
- [Laravel Caching](https://laravel.com/docs/10.x/cache)

## License

MIT
