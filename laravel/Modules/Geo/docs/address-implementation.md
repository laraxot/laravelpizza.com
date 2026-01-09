# Implementazione del Modello Address

## Panoramica

Il modello `Address` è un'implementazione robusta e flessibile progettata per gestire indirizzi in vari contesti applicativi, conforme a schema.org/PostalAddress e ottimizzata per il contesto italiano.

## Migrazione

La migrazione del database crea una tabella `addresses` con la seguente struttura:

```php
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->nullableMorphs('addressable'); // Relazione polimorfica

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

## Modello Implementato

Il modello `Address` è implementato come segue:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Modules\Geo\Contracts\HasGeolocation;

/**
 * Class Address - Modello per gli indirizzi conforme a schema.org/PostalAddress.
 *
 * @see https://schema.org/PostalAddress
 */
class Address extends BaseModel implements HasGeolocation
{
    use \Modules\Xot\Models\Traits\HasXotFactory;
    use SoftDeletes;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'addressable_type',
        'addressable_id',
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
        'is_primary',
        'type',
        'extra_data',
    ];

    /**
     * Gli attributi che dovrebbero essere convertiti.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'extra_data' => 'array',
    ];

    /**
     * Costanti per i tipi di indirizzo.
     */
    public const TYPE_HOME = 'home';
    public const TYPE_WORK = 'work';
    public const TYPE_BILLING = 'billing';
    public const TYPE_SHIPPING = 'shipping';
    public const TYPE_HEADQUARTER = 'headquarter';
    public const TYPE_BRANCH = 'branch';
    public const TYPE_OTHER = 'other';

    /**
     * I tipi di indirizzo disponibili.
     *
     * @return array<string, string>
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_HOME => 'Casa',
            self::TYPE_WORK => 'Lavoro',
            self::TYPE_BILLING => 'Fatturazione',
            self::TYPE_SHIPPING => 'Spedizione',
            self::TYPE_HEADQUARTER => 'Sede centrale',
            self::TYPE_BRANCH => 'Filiale',
            self::TYPE_OTHER => 'Altro',
        ];
    }

    /**
     * Relazione polimorfica con l'entità a cui appartiene l'indirizzo.
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Ottiene la latitudine.
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Ottiene la longitudine.
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Ottiene l'indirizzo formattato.
     */
    public function getFormattedAddress(): string
    {
        return (string) $this->formatted_address;
    }

    /**
     * Getter per l'indirizzo completo in formato italiano.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->route . ($this->street_number ? ', ' . $this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3 ? $this->administrative_area_level_3 : null,
            $this->administrative_area_level_2 ? $this->administrative_area_level_2 : null,
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    /**
     * Getter per l'indirizzo strada.
     */
    public function getStreetAddressAttribute(): string
    {
        return trim(($this->route ?? '') . ($this->street_number ? ', ' . ($this->street_number ?? '') : ''));
    }

    /**
     * Verifica se l'indirizzo ha coordinate valide.
     */
    public function hasValidCoordinates(): bool
    {
        return null !== $this->latitude
            && null !== $this->longitude
            && $this->latitude >= -90
            && $this->latitude <= 90
            && $this->longitude >= -180
            && $this->longitude <= 180;
    }

    /**
     * Generazione automatica dell'indirizzo formattato durante il salvataggio.
     */
    protected static function booted(): void
    {
        static::saving(function (self $address): void {
            if (empty($address->formatted_address)) {
                $address->formatted_address = $address->getFullAddressAttribute();
            }
        });
    }

    /**
     * Restituisce i dati in formato Schema.org PostalAddress.
     *
     * @see https://schema.org/PostalAddress
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
     * Metodo statico per creare un indirizzo da risposta Google Maps.
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
     * Scope per cercare indirizzi nelle vicinanze.
     */
    public function scopeNearby(Builder $query, float $latitude, float $longitude, float $radiusKm = 10): Builder
    {
        return $query->selectRaw("
            *,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
        ->having('distance', '<', $radiusKm)
        ->orderBy('distance');
    }
}
```

## Spiegazione dei Campi

### 1. Relazione Polimorfica (`addressable_type`, `addressable_id`)

Questi campi consentono al modello di essere associato a qualsiasi altra entità del sistema (utenti, negozi, organizzazioni, ecc.) tramite relazione polimorfica.

### 2. Campi Informativi

- `name`: Nome identificativo dell'indirizzo (es. "Casa", "Ufficio centrale")
- `description`: Descrizione aggiuntiva dell'indirizzo
- `type`: Tipo di indirizzo (casa, lavoro, fatturazione, ecc.)
- `is_primary`: Indica se è l'indirizzo principale

### 3. Componenti dell'Indirizzo

- `route`: Via/Strada (es. "Via Roma")
- `street_number`: Numero civico (es. "123")
- `locality`: Località/Città (es. "Milano")
- `administrative_area_level_3`: Provincia (es. "MI")
- `administrative_area_level_2`: Regione (es. "Lombardia")
- `administrative_area_level_1`: Stato/Paese (es. "Italia")
- `country`: Codice paese ISO (es. "IT")
- `postal_code`: CAP (es. "20100")

### 4. Dati di Geocoding

- `formatted_address`: Indirizzo formattato completo
- `place_id`: ID del luogo (es. Google Place ID)
- `latitude`: Latitudine geografica
- `longitude`: Longitudine geografica

### 5. Dati Aggiuntivi

- `extra_data`: Campo JSON per memorizzare dati aggiuntivi non standard

## Metodi Principali

### 1. Getters e Accessors

- `getFullAddressAttribute()`: Restituisce l'indirizzo completo formattato
- `getStreetAddressAttribute()`: Restituisce solo la parte della via e numero civico
- `getLatitude()`, `getLongitude()`, `getFormattedAddress()`: Implementazioni dell'interfaccia HasGeolocation

### 2. Validazione

- `hasValidCoordinates()`: Verifica se le coordinate geografiche sono valide

### 3. Integrazione Schema.org

- `toSchemaOrg()`: Restituisce l'indirizzo in formato Schema.org PostalAddress

### 4. Integrazione Google Maps

- `createFromGoogleMaps()`: Crea un indirizzo a partire dai dati restituiti dalle API Google Maps

### 5. Query Geografiche

- `scopeNearby()`: Cerca indirizzi entro un certo raggio da un punto geografico

## Utilizzo

### 1. Associazione a un Modello

```php
// Associare un indirizzo a un utente
$user->addresses()->create([
    'type' => Address::TYPE_HOME,
    'route' => 'Via Roma',
    'street_number' => '123',
    'locality' => 'Milano',
    'administrative_area_level_3' => 'MI',
    'administrative_area_level_2' => 'Lombardia',
    'postal_code' => '20100',
    'country' => 'IT',
]);
```

### 2. Ricerca Geografica

```php
// Trova tutti i negozi entro 5 km da un punto
$nearbyShops = Shop::whereHas('addresses', function ($query) use ($lat, $lng) {
    $query->nearby($lat, $lng, 5);
})->get();
```

### 3. Output Schema.org

```php
// In una vista Blade
<script type="application/ld+json">
    {{ json_encode($address->toSchemaOrg()) }}
</script>
```

## Considerazioni sulla Scelta dei Nomi dei Campi

### 1. Evitare il Prefisso "address_"

Abbiamo scelto di evitare il prefisso "address_" nei nomi dei campi per diverse ragioni:

- **Ridondanza**: La tabella si chiama già "addresses", quindi il prefisso sarebbe ridondante
- **Leggibilità**: `addresses.locality` è più leggibile di `addresses.address_locality`
- **Integrazione API**: I nomi senza prefisso si allineano meglio con le API di geocoding
- **Convenzioni Laravel**: Segue le convenzioni di naming di Laravel

### 2. Uso dei Campi Specifici per l'Italia

Abbiamo scelto campi che supportano la struttura amministrativa italiana:

- `administrative_area_level_3`: Per la provincia italiana
- `administrative_area_level_2`: Per la regione italiana
- `administrative_area_level_1`: Per lo stato/paese

Questi nomi sono anche compatibili con la risposta delle API Google Maps, facilitando l'integrazione.

## Trait HasAddress: filosofia, logica e best practice

### Quando usare un trait per la gestione degli indirizzi?

Quando più modelli (es. Studio, User, Azienda, ecc.) devono gestire relazioni, metodi e logica comuni sugli indirizzi, è opportuno estrarre questa logica in un trait riusabile, chiamato ad esempio `HasAddress`.

### Cosa contiene il trait HasAddress?
- Relazione polimorfica addresses()
- Metodo primaryAddress() per ottenere l'indirizzo principale
- Metodo getFullAddress() per l'indirizzo completo formattato
- Altri metodi di utilità (getCity, getPostalCode, ecc.)

### Vantaggi
- **DRY**: nessuna duplicazione di codice tra modelli diversi
- **KISS**: la logica è centralizzata e facilmente manutenibile
- **Coerenza**: tutti i modelli che usano indirizzi espongono la stessa API
- **Testabilità**: i metodi comuni sono facilmente testabili e mockabili
- **Override**: ogni modello può estendere/overrideare i metodi se serve

### Filosofia
- Il trait è la via della riusabilità: un solo punto di verità per la logica degli indirizzi
- La relazione addresses() è sempre su 'model' (vedi architettura.md)
- La logica di formattazione e selezione dell'indirizzo principale è condivisa

### Religione
- "Non duplicare mai la logica degli indirizzi: il trait HasAddress è il tuo unico tempio"

### Politica
- Ogni modulo che gestisce entità con indirizzi deve usare il trait HasAddress
- La governance della logica degli indirizzi è centralizzata nel modulo Geo

### Zen
- "Un solo trait per domarli tutti, un solo trait per trovarli, un solo trait per portarli e nel database unirli"

### Esempio di implementazione

```php
namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Geo\Models\Address;

trait HasAddress
{
    /**
     * Relazione polimorfica con Address.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Ottiene l'indirizzo principale.
     */
    public function primaryAddress(): ?Address
    {
        return $this->addresses()->where('is_primary', true)->first();
    }

    /**
     * Ottiene l'indirizzo completo formattato.
     */
    public function getFullAddress(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->getFormattedAddress() : null;
    }

    // Altri metodi di utilità (getCity, getPostalCode, ecc.)
}
```

### Come usarlo in un modello

```php
use Modules\Geo\Models\Traits\HasAddress;

class Studio extends Model
{
    use HasAddress;
    // ...
}
```

### Collegamenti
- Vedi anche: [architecture.md](./architecture.md), [place-address-schemaorg.md](./place-address-schemaorg.md)
- Regole generali: Xot/project_docs/filosofia.md, Xot/project_docs/zen.md

## Best practice Filament

- La UI Filament per Address va sempre riusata tramite AddressResource::getFormSchema() nei moduli consumer (es. StudioResource, UserResource, ecc.).
- Aggiornare sempre la documentazione e i collegamenti relativi.

## Collegamenti
- [models/address.md](./models/address.md)
- [filament.md](./filament.md)
- [has-address-trait.md](./has-address-trait.md)

## Conclusione

Questo modello `Address` fornisce una struttura robusta, flessibile e riutilizzabile per gestire indirizzi in vari contesti applicativi, ottimizzata per il contesto italiano e conforme agli standard di schema.org.

## Perché i collegamenti sono sempre relativi?

- **Logica**: I link relativi rendono la documentazione portabile, versionabile e refactor-friendly.
- **Politica**: Ogni modulo deve essere autonomo e la sua documentazione navigabile anche se spostata.
- **Filosofia**: Un solo punto di verità, nessun path assoluto, nessun lock-in.
- **Religione**: "Non avrai altro path all'infuori del relativo".
- **Zen**: Serenità nella navigazione, nessun errore di path, nessun link rotto dopo un refactor.
