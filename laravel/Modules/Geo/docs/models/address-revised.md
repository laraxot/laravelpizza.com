# Modello Address Riveduto

## Panoramica
Il modello `Address` è stato riveduto seguendo i principi di design ottimali e le convenzioni del progetto <main module>. Questo documento descrive l'implementazione aggiornata che:

1. Evita prefissi ridondanti nei nomi dei campi
2. Separa correttamente il numero civico dalla strada
3. Utilizza relazioni polimorfiche standardizzate
4. Segue la struttura dei dati compatibile con Google Maps API
5. Supporta la formattazione specifica italiana con provincia e regione

## Schema del Database

```php
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->nullableMorphs('model'); // Relazione polimorfica standardizzata
    
    // Campi informativi
    $table->string('name')->nullable()->comment('Nome identificativo dell\'indirizzo');
    $table->text('description')->nullable()->comment('Descrizione opzionale');
    
    // Campi indirizzo (evitando prefissi ridondanti)
    $table->string('route')->nullable()->comment('Via/Piazza');
    $table->string('street_number')->nullable()->comment('Numero civico');
    $table->string('locality')->nullable()->comment('Comune/Città');
    $table->string('administrative_area_level_3')->nullable()->comment('Provincia');
    $table->string('administrative_area_level_2')->nullable()->comment('Regione');
    $table->string('administrative_area_level_1')->nullable()->comment('Stato/Paese');
    $table->string('country', 2)->nullable()->comment('Codice paese ISO');
    $table->string('postal_code', 20)->nullable()->comment('CAP');
    
    // Dati di geocoding
    $table->text('formatted_address')->nullable();
    $table->string('place_id')->nullable()->comment('ID Google Places');
    $table->decimal('latitude', 15, 10)->nullable();
    $table->decimal('longitude', 15, 10)->nullable();
    
    // Campi tipo indirizzo
    $table->string('type', 50)->nullable()->index()->comment('Tipo indirizzo (home, work, etc.)');
    $table->boolean('is_primary')->default(false)->index();
    
    // Dati aggiuntivi
    $table->json('extra_data')->nullable();
    
    // Timestamps e soft delete
    $table->timestamps();
    $table->softDeletes();
});
```

## Implementazione del Modello

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Geo\Contracts\HasGeolocation;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;

/**
 * Class Address
 * 
 * Implementazione di Schema.org PostalAddress
 * 
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $route
 * @property string|null $street_number
 * @property string|null $locality
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_1
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $formatted_address
 * @property string|null $place_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $type
 * @property bool $is_primary
 * @property array|null $extra_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Address extends Model implements HasGeolocation
{
    use \Modules\Xot\Models\Traits\HasXotFactory;
    use SoftDeletes;
    
    /** list<string> */
   protected $fillable = [
        'name',
        'description',
        'route',
        'street_number',
        'locality',
        'administrative_area_level_3', // Provincia
        'administrative_area_level_2', // Regione
        'administrative_area_level_1', // Stato/Paese
        'country',
        'postal_code',
        'formatted_address',
        'place_id',
        'latitude',
        'longitude',
        'type',
        'is_primary',
        'extra_data',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'extra_data' => 'array',
        'type' => AddressTypeEnum::class,
    ];
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return AddressFactory::new();
    }
    
    /**
     * Get the parent model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Relazione polimorfica (alternativa con nome più descrittivo)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('model');
    }
    
    /**
     * Get the city relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'locality', 'name');
    }
    
    /**
     * Get the province relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'administrative_area_level_3', 'name');
    }
    
    /**
     * Get the region relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regione()
    {
        return $this->belongsTo(Regione::class, 'administrative_area_level_2', 'name');
    }
    
    /**
     * Getter per l'indirizzo completo in formato italiano
     *
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->route . ($this->street_number ? ' ' . $this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }
    
    /**
     * Getter per l'indirizzo strada completo
     *
     * @return string
     */
    public function getStreetAddressAttribute(): string
    {
        return trim(($this->route ?? '') . ' ' . ($this->street_number ?? ''));
    }
    
    /**
     * Get the formatted address.
     *
     * @return string
     */
    public function getFormattedAddressAttribute(): string
    {
        if ($this->formatted_address) {
            return $this->formatted_address;
        }
        
        $parts = [];
        
        // Indirizzo stradale
        if ($this->route) {
            $parts[] = $this->getStreetAddressAttribute();
        }
        
        // Località e provincia (formato italiano)
        $localityParts = [];
        if ($this->postal_code) {
            $localityParts[] = $this->postal_code;
        }
        
        if ($this->locality) {
            $localityParts[] = $this->locality;
            
            // Per indirizzi italiani, aggiungiamo la sigla provincia
            if ($this->country === 'IT' && $this->administrative_area_level_3) {
                // Se è un'implementazione reale, potremmo derivare la sigla dalla provincia
                $provinciaSigla = $this->extra_data['provincia_sigla'] ?? null;
                if ($provinciaSigla) {
                    $localityParts[] = "({$provinciaSigla})";
                }
            }
        }
        
        if (!empty($localityParts)) {
            $parts[] = implode(' ', $localityParts);
        }
        
        // Regione
        if ($this->administrative_area_level_2) {
            $parts[] = $this->administrative_area_level_2;
        }
        
        // Paese
        if ($this->country) {
            $countryName = $this->administrative_area_level_1 ?? $this->country;
            $parts[] = strtoupper($countryName);
        }
        
        return implode("\n", $parts);
    }
    
    /**
     * Get the latitude of the address.
     *
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
    
    /**
     * Get the longitude of the address.
     *
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
    
    /**
     * Restituisce i dati in formato Schema.org PostalAddress
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'PostalAddress',
            'name' => $this->name,
            'description' => $this->description,
            'streetAddress' => $this->street_address,
            'addressLocality' => $this->locality,
            'addressSubregion' => $this->administrative_area_level_3, // Provincia
            'addressRegion' => $this->administrative_area_level_2, // Regione
            'addressCountry' => $this->country,
            'postalCode' => $this->postal_code,
        ];
    }
    
    /**
     * Metodo statico per creare da risposta Google Maps
     *
     * @param array<string, mixed> $googleData
     * @param string|null $name
     * @param string|null $description
     * @return static
     */
    public static function createFromGoogleMaps(array $googleData, ?string $name = null, ?string $description = null): self
    {
        $components = collect($googleData['address_components'] ?? [])
            ->keyBy(fn($component) => $component['types'][0] ?? 'unknown');

        return self::create([
            'name' => $name,
            'description' => $description,
            'street_number' => $components->get('street_number')['long_name'] ?? null,
            'route' => $components->get('route')['long_name'] ?? null,
            'locality' => $components->get('locality')['long_name'] ?? 
                        $components->get('administrative_area_level_3')['long_name'] ?? null,
            'administrative_area_level_3' => $components->get('administrative_area_level_2')['long_name'] ?? null, // Provincia
            'administrative_area_level_2' => $components->get('administrative_area_level_1')['long_name'] ?? null, // Regione
            'administrative_area_level_1' => $components->get('country')['long_name'] ?? null,
            'country' => $components->get('country')['short_name'] ?? null,
            'postal_code' => $components->get('postal_code')['long_name'] ?? null,
            'formatted_address' => $googleData['formatted_address'] ?? null,
            'place_id' => $googleData['place_id'] ?? null,
            'latitude' => $googleData['geometry']['location']['lat'] ?? null,
            'longitude' => $googleData['geometry']['location']['lng'] ?? null,
        ]);
    }
    
    /**
     * Scope per cercare indirizzi nelle vicinanze
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $latitude
     * @param float $longitude
     * @param float $radiusKm
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNearby($query, float $latitude, float $longitude, float $radiusKm = 10)
    {
        return $query->selectRaw("
            *,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
        ->having('distance', '<', $radiusKm)
        ->orderBy('distance');
    }
    
    /**
     * Scope a query to only include primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
    
    /**
     * Scope a query to filter by address type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|AddressTypeEnum $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type instanceof AddressTypeEnum ? $type->value : $type);
    }
}
```

## Migrazione Rivista

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\Address;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Address::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->nullableMorphs('model'); // Relazione polimorfica standardizzata
                
                // Campi informativi
                $table->string('name')->nullable()->comment('Nome identificativo dell\'indirizzo');
                $table->text('description')->nullable()->comment('Descrizione opzionale');
                
                // Campi indirizzo (evitando prefissi ridondanti)
                $table->string('route')->nullable()->comment('Via/Piazza');
                $table->string('street_number')->nullable()->comment('Numero civico');
                $table->string('locality')->nullable()->comment('Comune/Città');
                $table->string('administrative_area_level_3')->nullable()->comment('Provincia');
                $table->string('administrative_area_level_2')->nullable()->comment('Regione');
                $table->string('administrative_area_level_1')->nullable()->comment('Stato/Paese');
                $table->string('country', 2)->nullable()->comment('Codice paese ISO');
                $table->string('postal_code', 20)->nullable()->comment('CAP');
                
                // Dati di geocoding
                $table->text('formatted_address')->nullable();
                $table->string('place_id')->nullable()->comment('ID Google Places');
                $table->decimal('latitude', 15, 10)->nullable();
                $table->decimal('longitude', 15, 10)->nullable();
                
                // Campi tipo indirizzo
                $table->string('type', 50)->nullable()->index()->comment('Tipo indirizzo (home, work, etc.)');
                $table->boolean('is_primary')->default(false)->index();
                
                // Dati aggiuntivi
                $table->json('extra_data')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table, true); // Aggiunge timestamps e soft deletes
            }
        );
    }
};
```

## Nomenclatura dei Campi

### Perché evitare prefissi ridondanti

La convenzione di non ripetere il nome della tabella come prefisso nei nomi dei campi segue il principio DRY (Don't Repeat Yourself) ed è una pratica comune nel design di database. Considerazioni:

1. **Ridondanza**: Il prefisso "address_" nei campi della tabella "addresses" è ridondante perché:
   - Il contesto è già fornito dal nome della tabella
   - Aumenta la lunghezza dei nomi dei campi senza aggiungere informazioni
   - Rende le query SQL più verbose

2. **Coerenza con API**: Adottare la nomenclatura delle API di Google Maps (locality, route, etc.) facilita:
   - L'integrazione diretta con i dati di Google
   - La comprensione universale dei campi
   - La compatibilità con sistemi di geocoding

3. **Mappatura Schema.org**: I campi senza prefisso mappano direttamente a Schema.org:
   - `locality` → `addressLocality`
   - `administrative_area_level_2` → `addressRegion`
   - `country` → `addressCountry`

4. **Leggibilità del codice**: L'accesso ai campi diventa più leggibile:
   ```php
   // Con prefisso (ridondante)
   $address->address_locality
   
   // Senza prefisso (pulito)
   $address->locality
   ```

## Struttura Italiana per Province e Regioni

Per gestire correttamente gli indirizzi italiani, utilizziamo:

- `administrative_area_level_3`: Provincia (es. Milano, Roma)
- `administrative_area_level_2`: Regione (es. Lombardia, Lazio)
- `administrative_area_level_1`: Paese/Stato (es. Italia)

Questa struttura è allineata con:
1. Le divisioni amministrative italiane
2. Il formato di dati di Google Maps API
3. I requisiti per la geocodifica accurata degli indirizzi italiani

## Implementazioni Alternative

Se necessario, è possibile estendere il modello con campi aggiuntivi:

```php
// Per supportare sigle province italiane
$table->string('provincia_sigla', 2)->nullable()->comment('Sigla provincia (es. MI, RM)');

// Per casi d'uso specifici
$table->boolean('verificato')->default(false)->comment('Indirizzo verificato');
$table->timestamp('ultima_verifica')->nullable();
```
