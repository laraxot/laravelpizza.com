# Migration Guide: Moving from <nome progetto> to Geo Module

## Overview

This guide explains how to migrate from using geographical models in the <nome progetto> module to using the centralized Geo module.

## Why Migrate?

- Single source of truth for geographical data
- Consistent data structure across the application
- Reduced code duplication
- Better maintainability

## Migration Steps

### 1. Update Dependencies

Update your module's `composer.json` to require the Geo module if not already present:

```json
{
    "require": {
        "modules/geo": "^1.0"
    }
}
```

### 2. Update Model Imports

Replace imports from <nome progetto> models to Geo models:

```diff
- use Modules\<nome progetto>\Models\Region;
- use Modules\<nome progetto>\Models\Province;
- use Modules\<nome progetto>\Models\City;
- use Modules\<nome progetto>\Models\Cap;

+ use Modules\Geo\Models\Region;
+ use Modules\Geo\Models\Province;
+ use Modules\Geo\Models\City;
+ use Modules\Geo\Models\Cap;
```

### 3. Update Database References

If you have any direct database references, update them to use the Geo module's table names:

```diff
- 'regions'
- 'provinces'
- 'cities'
- 'caps'

+ 'geo_regions'
+ 'geo_provinces'
+ 'geo_cities'
+ 'geo_caps'
```

### 4. Update Relationships

Update any relationships to use the new model classes:

```php
// Before
public function region()
{
    return $this->belongsTo(\Modules\<nome progetto>\Models\Region::class);
}

// After
public function region()
{
    return $this->belongsTo(\Modules\Geo\Models\Region::class);
}
```

### 5. Run Migrations

After updating all references, run the migrations:

```bash
php artisan migrate
```

## Data Migration

If you have existing data in the <nome progetto> module's geographical tables, you'll need to migrate it to the Geo module's tables. Create a custom migration for this purpose.

## Testing

After migration, thoroughly test:

1. All geographical data displays correctly
2. All relationships work as expected
3. Any geographical queries return correct results
4. All forms and API endpoints that use geographical data

## Rollback Plan

In case of issues, have a rollback plan:

1. Backup your database
2. Keep the old models temporarily
3. Be prepared to revert the changes if needed

## Support

For any issues during migration, please refer to the [Geo Module Documentation](./architecture.md) or contact the development team.

# Guida alla Migrazione da GeoJsonModel a Sushi

## Descrizione
Questo documento descrive il processo di migrazione dal modello `GeoJsonModel` al pacchetto Sushi per il modello `Comune`.

## Prerequisiti
- Laravel 10.x
- PHP 8.1+
- SQLite 3.x
- Pacchetto Sushi

## Passi di Migrazione

### 1. Installazione
```bash
composer require calebporzio/sushi
```

### 2. Backup
```bash

# Backup del file JSON
cp database/content/comuni.json database/content/comuni.json.bak

# Backup del database
php artisan backup:run
```

### 3. Configurazione
1. Copiare il file di configurazione:
```bash
cp vendor/calebporzio/sushi/config/sushi.php config/
```

2. Configurare le variabili d'ambiente:
```env
SUSHI_CACHE_ENABLED=true
SUSHI_CACHE_DURATION=604800
SUSHI_DB_CONNECTION=sqlite
SUSHI_DB_DATABASE=database/sushi.sqlite
```

### 4. Migrazione del Modello
1. Creare il trait `SushiToJsons`:
```bash
php artisan make:trait SushiToJsons
```

2. Implementare il trait:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

trait SushiToJsons
{
    use Sushi;

    public function getSushiRows(): array
    {
        return Cache::remember(
            $this->getCacheKey(),
            $this->getCacheDuration(),
            fn () => $this->loadFromJson()
        );
    }

    protected function loadFromJson(): array
    {
        $path = $this->getJsonFile();
        
        if (!File::exists($path)) {
            return [];
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Errore nel parsing del file JSON: ' . json_last_error_msg());
        }

        return $data;
    }

    public function getJsonFile(): string
    {
        return base_path('database/content/comuni.json');
    }

    protected function getCacheKey(): string
    {
        return 'sushi_' . class_basename($this) . '_data';
    }

    protected function getCacheDuration(): int
    {
        return 60 * 24 * 7; // 7 giorni
    }
}
```

3. Aggiornare il modello `Comune`:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\Traits\SushiToJsons;

class Comune extends Model
{
    use SushiToJsons;

    protected $schema = [
        'id' => 'integer',
        'regione' => 'string',
        'provincia' => 'string',
        'comune' => 'string',
        'cap' => 'string',
        'lat' => 'float',
        'lng' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'regione',
        'provincia',
        'comune',
        'cap',
        'lat',
        'lng',
    ];
}
```

### 5. Migrazione dei Dati
1. Creare il comando di migrazione:
```bash
php artisan make:command SushiCommand
```

2. Implementare il comando:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SushiCommand extends Command
{
    protected $signature = 'sushi:manage {action : L\'azione da eseguire (refresh|clear|status)}';
    protected $description = 'Gestisce il database SQLite di Sushi';

    public function handle(): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'refresh' => $this->refresh(),
            'clear' => $this->clear(),
            'status' => $this->status(),
            default => $this->error('Azione non valida'),
        };
    }

    protected function refresh(): int
    {
        $this->info('Aggiornamento del database SQLite di Sushi...');

        try {
            $path = base_path('database/content/comuni.json');
            
            if (!File::exists($path)) {
                $this->error('File comuni.json non trovato');
                return 1;
            }
            
            $data = json_decode(File::get($path), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Errore nel parsing del file JSON: ' . json_last_error_msg());
                return 1;
            }
            
            DB::table('comuni')->truncate();
            
            foreach ($data as $comune) {
                DB::table('comuni')->insert([
                    'id' => $comune['id'],
                    'regione' => $comune['regione'],
                    'provincia' => $comune['provincia'],
                    'comune' => $comune['comune'],
                    'cap' => $comune['cap'],
                    'lat' => $comune['lat'],
                    'lng' => $comune['lng'],
                    'created_at' => $comune['created_at'] ?? now(),
                    'updated_at' => $comune['updated_at'] ?? now(),
                ]);
            }
            
            $this->info('Database SQLite di Sushi aggiornato con successo');
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante l\'aggiornamento del database: ' . $e->getMessage());
            return 1;
        }
    }

    protected function clear(): int
    {
        $this->info('Pulizia del database SQLite di Sushi...');

        try {
            DB::table('comuni')->truncate();
            $this->info('Database SQLite di Sushi pulito con successo');
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante la pulizia del database: ' . $e->getMessage());
            return 1;
        }
    }

    protected function status(): int
    {
        $this->info('Stato del database SQLite di Sushi:');

        try {
            $count = DB::table('comuni')->count();
            $this->info("Numero di comuni: {$count}");
            
            $regioni = DB::table('comuni')
                ->select('regione')
                ->distinct()
                ->count();
            $this->info("Numero di regioni: {$regioni}");
            
            $province = DB::table('comuni')
                ->select('provincia')
                ->distinct()
                ->count();
            $this->info("Numero di province: {$province}");
            
            $cap = DB::table('comuni')
                ->select('cap')
                ->distinct()
                ->count();
            $this->info("Numero di CAP: {$cap}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante la verifica dello stato del database: ' . $e->getMessage());
            return 1;
        }
    }
}
```

3. Eseguire la migrazione:
```bash
php artisan sushi:manage refresh
```

### 6. Test
1. Creare i test:
```bash
php artisan make:test ComuneTest
```

2. Implementare i test:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Tests\TestCase;
use Modules\Geo\Models\Comune;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class ComuneTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->testData = [
            [
                'id' => 1,
                'regione' => 'Lombardia',
                'provincia' => 'Milano',
                'comune' => 'Milano',
                'cap' => '20100',
                'lat' => 45.4642,
                'lng' => 9.1900,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'regione' => 'Lombardia',
                'provincia' => 'Milano',
                'comune' => 'Sesto San Giovanni',
                'cap' => '20099',
                'lat' => 45.5347,
                'lng' => 9.2345,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        File::put(
            base_path('database/content/comuni.json'),
            json_encode($this->testData, JSON_PRETTY_PRINT)
        );
    }

    protected function tearDown(): void
    {
        Cache::forget('sushi_Comune_data');
        File::delete(base_path('database/content/comuni.json'));
        parent::tearDown();
    }

    /** @test */
    public function it_can_load_comuni_from_json()
    {
        $comuni = Comune::all();
        
        $this->assertCount(2, $comuni);
        $this->assertEquals('Milano', $comuni[0]->comune);
        $this->assertEquals('Sesto San Giovanni', $comuni[1]->comune);
    }

    // ... altri test
}
```

3. Eseguire i test:
```bash
php artisan test
```

### 7. Deployment
1. Aggiornare il file `composer.json`:
```json
{
    "require": {
        "calebporzio/sushi": "^1.0"
    }
}
```

2. Aggiornare il file `.env`:
```env
SUSHI_CACHE_ENABLED=true
SUSHI_CACHE_DURATION=604800
SUSHI_DB_CONNECTION=sqlite
SUSHI_DB_DATABASE=database/sushi.sqlite
```

3. Eseguire la migrazione:
```bash
php artisan sushi:manage refresh
```

## Breaking Changes

### 1. Query Builder
- Alcuni metodi del query builder potrebbero comportarsi diversamente
- Le relazioni potrebbero richiedere aggiornamenti
- Gli scope potrebbero richiedere modifiche

### 2. Cache
- La cache viene gestita diversamente
- La durata della cache è configurabile
- La cache viene invalidata automaticamente

### 3. Performance
- Il caricamento dei dati è più veloce
- Le query sono ottimizzate
- L'uso di memoria è maggiore

## Rollback
In caso di problemi, è possibile tornare alla versione precedente:

1. Ripristinare il backup:
```bash
cp database/content/comuni.json.bak database/content/comuni.json
```

2. Rimuovere il pacchetto:
```bash
composer remove calebporzio/sushi
```

3. Ripristinare il modello:
```bash
git checkout -- app/Models/Comune.php
```

## Documentazione Correlata
- [Sushi Documentation](https://github.com/calebporzio/sushi)
- [Comune Model](comune-model.md)
- [Sushi Configuration](sushi-configuration.md)
- [Sushi Command](sushi-command.md)
