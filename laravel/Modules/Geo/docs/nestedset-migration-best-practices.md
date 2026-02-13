# NestedSet Migration Best Practices - Geo Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Geo utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Divisioni Geografiche

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Geo\Models\GeoDivision::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi geografici
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type'); // continent, country, region, province, city

            // NestedSet per gerarchia geografica
            NestedSet::columns($table);

            // Codici standard
            $table->string('iso_code', 10)->nullable(); // ISO 3166-1 alpha-2/3
            $table->string('fips_code', 10)->nullable(); // FIPS
            $table->string('nuts_code', 10)->nullable(); // NUTS (EU)

            // Coordinate e area
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('area_km2', 12, 2)->nullable();

            // Popolazione
            $table->integer('population')->nullable();
            $table->string('density')->nullable();

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Location Types Gerarchici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Geo\Models\LocationType::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi tipo location
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia tipi
            NestedSet::columns($table);

            // Configurazioni
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            $table->json('schema')->nullable(); // Schema dati per questo tipo

            // Validazioni
            $table->json('validation_rules')->nullable();
            $table->json('required_fields')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Zone Amministrative

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Geo\Models\AdministrativeZone::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi zona amministrativa
            $table->string('name');
            $table->string('code')->unique();
            $table->string('level'); // 1=regione, 2=provincia, 3=comune, 4=frazione

            // NestedSet per gerarchia amministrativa
            NestedSet::columns($table);

            // Codici ufficiali
            $table->string('istat_code', 10)->nullable(); // Codice ISTAT
            $table->string('catasto_code', 10)->nullable(); // Codice catasto
            $table->string('belfiore_code', 10)->nullable(); // Codice Belfiore

            // Informazioni
            $table->string('capital')->nullable();
            $table->decimal('area_km2', 12, 2)->nullable();
            $table->integer('population')->nullable();
            $table->date('established_date')->nullable();

            // Geometria (spaziale)
            $table->geometry('geometry')->nullable();

            $table->timestamps();
        });
    }
};
```

## Pattern per Percorsi Gerarchici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Geo\Models\GeoPath::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi percorso
            $table->string('name');
            $table->string('type'); // route, street, avenue, boulevard

            // NestedSet per gerarchia percorsi
            NestedSet::columns($table);

            // Informazioni percorso
            $table->string('full_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('ref')->nullable(); // Rif. stradale

            // Classificazione
            $table->string('classification')->nullable(); // primary, secondary, tertiary
            $table->integer('importance')->default(0);

            // Metadati
            $table->json('attributes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Integrazione con AddressItemEnum

Ora implementiamo la filosofia AddressItemEnum::columns() ispirata a NestedSet::columns():

```php
<?php

namespace Modules\Geo\Enums;

use Illuminate\Database\Schema\Blueprint;

/**
 * Enum per i componenti degli indirizzi con metodo columns() ispirato a NestedSet
 */
enum AddressItemEnum: string
{
    // Componenti indirizzo
    case PHONE = 'phone';
    case ROUTE = 'route';
    case STREET_NUMBER = 'street_number';
    case LOCALITY = 'locality';
    case ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1';
    case ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2';
    case ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3';
    case COUNTRY = 'country';
    case POSTAL_CODE = 'postal_code';
    case FORMATTED_ADDRESS = 'formatted_address';
    case PLACE_ID = 'place_id';
    case LATITUDE = 'latitude';
    case LONGITUDE = 'longitude';

    /**
     * Aggiunge le colonne standard degli indirizzi alla tabella.
     * Ispirato al pattern NestedSet::columns() per consistenza architetturale.
     *
     * @param Blueprint $table
     * @param array $options Opzioni di configurazione
     */
    public static function columns(Blueprint $table, array $options = []): void
    {
        // Componenti testuali
        $table->string(self::ROUTE->value)->nullable()
            ->comment('Street name (Via/Piazza)');
        $table->string(self::STREET_NUMBER->value)->nullable()
            ->comment('Street number (Numero civico)');
        $table->string(self::LOCALITY->value)->nullable()
            ->comment('Locality/Fraction (Località/Frazione)');
        $table->string(self::ADMINISTRATIVE_AREA_LEVEL_3->value)->nullable()
            ->comment('Municipality (Comune/Città)');
        $table->string(self::ADMINISTRATIVE_AREA_LEVEL_2->value)->nullable()
            ->comment('Province/Sigla (Provincia)');
        $table->string(self::ADMINISTRATIVE_AREA_LEVEL_1->value)->nullable()
            ->comment('Region (Regione)');
        $table->string(self::COUNTRY->value, 2)->nullable()
            ->comment('Country code ISO (Paese)');
        $table->string(self::POSTAL_CODE->value, 20)->nullable()
            ->comment('Postal code (CAP)');

        // Componenti contatto
        $table->string(self::PHONE->value)->nullable()
            ->comment('Phone number');

        // Componenti geocoding
        $table->text(self::FORMATTED_ADDRESS->value)->nullable()
            ->comment('Full formatted address');
        $table->string(self::PLACE_ID->value)->nullable()
            ->comment('Google Places ID');
        $table->decimal(self::LATITUDE->value, 15, 10)->nullable()
            ->comment('Latitude');
        $table->decimal(self::LONGITUDE->value, 15, 10)->nullable()
            ->comment('Longitude');

        // Indici per performance (ispirati a NestedSet)
        $table->index([self::COUNTRY->value, self::ADMINISTRATIVE_AREA_LEVEL_1->value]);
        $table->index([self::ADMINISTRATIVE_AREA_LEVEL_2->value, self::ADMINISTRATIVE_AREA_LEVEL_3->value]);
        $table->index(self::POSTAL_CODE->value);
        $table->index([self::LATITUDE->value, self::LONGITUDE->value]);
    }

    /**
     * Rimuove le colonne degli indirizzi.
     *
     * @param Blueprint $table
     */
    public static function dropColumns(Blueprint $table): void
    {
        $columns = self::getDefaultColumns();

        // Rimuovi indici
        $table->dropIndex([self::COUNTRY->value, self::ADMINISTRATIVE_AREA_LEVEL_1->value]);
        $table->dropIndex([self::ADMINISTRATIVE_AREA_LEVEL_2->value, self::ADMINISTRATIVE_AREA_LEVEL_3->value]);
        $table->dropIndex(self::POSTAL_CODE->value);
        $table->dropIndex([self::LATITUDE->value, self::LONGITUDE->value]);

        // Rimuovi colonne
        $table->dropColumn($columns);
    }

    /**
     * Ottiene la lista delle colonne di default.
     *
     * @return array
     */
    public static function getDefaultColumns(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Verifica se una colonna esiste nella tabella.
     *
     * @param Blueprint $table
     * @param string $column
     * @return bool
     */
    public static function hasColumn(Blueprint $table, string $column): bool
    {
        return in_array($column, self::getDefaultColumns());
    }
}
```

## Pattern per Migrazioni con AddressItemEnum::columns()

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Geo\Models\Address::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi indirizzo standard usando AddressItemEnum::columns()
            AddressItemEnum::columns($table);

            // Campi aggiuntivi specifici
            $table->string('name')->nullable()->comment('Nome identificativo indirizzo');
            $table->text('description')->nullable()->comment('Descrizione opzionale');
            $table->string('type', 50)->nullable()->index()->comment('Tipo indirizzo');
            $table->boolean('is_primary')->default(false)->index();

            // Relazioni polimorfe
            $table->nullableUuidMorphs('model');

            // Metadati
            $table->json('extra_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

## Pattern per Client con AddressItemEnum

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\Client::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable();
            $table->string('vat_number')->nullable();

            // Campi indirizzo usando AddressItemEnum::columns()
            AddressItemEnum::columns($table);

            // Campi aggiuntivi cliente
            $table->string('email')->nullable()->comment('Email contatto principale');
            $table->boolean('business_closed')->default(false);
            $table->string('competent_health_unit')->nullable();
            $table->string('tax_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_office')->nullable();
            $table->string('activity')->nullable();

            $this->addCommonFields($table);
        });
    }
};
```

## Filosofia AddressItemEnum::columns()

### Logica
- **Centralizzazione**: Un solo punto di definizione per tutti i campi indirizzo
- **Consistenza**: Stessi nomi, tipi e commenti ovunque
- **Type Safety**: Enum invece di stringhe hardcoded

### Politica
- **Standardizzazione**: Tutte le tabelle usano la stessa struttura indirizzo
- **DRY**: Non ripetere definizioni colonne
- **KISS**: Semplice da usare: `AddressItemEnum::columns($table)`

### Religione
- **Unicità**: Un solo enum per governare tutti i componenti indirizzo
- **Ordine**: Le colonne seguono un ordine logico (testuali → contatto → geocoding)
- **Completezza**: Tutti i componenti necessari sono inclusi

### Zen
- **Equilibrio**: Bilancia flessibilità e standardizzazione
- **Flusso**: Le colonne fluiscono naturalmente come un indirizzo
- **Semplicità**: Complessità nascosta, interfaccia semplice

## Best Practices Specifiche per Geo

### 1. Nomenclatura Coerente

- `GeoDivision`: Divisioni geografiche standard
- `AdministrativeZone`: Zone amministrative locali
- `LocationType`: Tipi di location gerarchici
- `GeoPath`: Percorsi e strade

### 2. Indici Geospaziali

```php
// Indici ottimizzati per query geografiche
$table->index([self::LATITUDE->value, self::LONGITUDE->value]);
$table->index([self::COUNTRY->value, self::ADMINISTRATIVE_AREA_LEVEL_1->value]);
$table->spatialIndex('geometry');
```

### 3. Validazioni Geografiche

```php
// Validazione coordinate
public function setLatitudeAttribute($value)
{
    if ($value && ($value < -90 || $value > 90)) {
        throw new \Exception('Latitude must be between -90 and 90');
    }
    $this->attributes['latitude'] = $value;
}
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Geo Module Architecture](/docs/architecture/geo-module.md)
- [AddressItemEnum Guide](/docs/address-item-enum-guide.md)
