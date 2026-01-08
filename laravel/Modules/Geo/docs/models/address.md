# Modello Address

## Panoramica

Il modello `Address` è l'implementazione dell'entità "indirizzo" seguendo lo standard Schema.org PostalAddress. Questo modello è progettato per gestire tutti i tipi di indirizzi nel sistema tramite relazioni polimorfe, permettendo a qualsiasi entità di avere uno o più indirizzi associati.

## Struttura

Il modello `Address` include i seguenti campi principali:

```php
protected $fillable = [
    'model_type',
    'model_id',
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
```

### Spiegazione dei campi

| Campo | Descrizione | Equivalente Schema.org |
|-------|-------------|------------------------|
| `model_type`, `model_id` | Relazione polimorfa all'entità proprietaria | N/A |
| `name` | Nome identificativo dell'indirizzo (es. "Casa", "Ufficio") | N/A |
| `description` | Descrizione o note aggiuntive | N/A |
| `route` | Nome della via o strada | `streetAddress` (parziale) |
| `street_number` | Numero civico | `streetAddress` (parziale) |
| `locality` | Città | `addressLocality` |
| `administrative_area_level_3` | Provincia | `addressRegion` (parziale) |
| `administrative_area_level_2` | Regione | `addressRegion` (parziale) |
| `administrative_area_level_1` | Stato o Paese | `addressCountry` (parziale) |
| `country` | Codice paese (es. "IT") | `addressCountry` |
| `postal_code` | Codice postale | `postalCode` |
| `formatted_address` | Indirizzo completo formattato | N/A |
| `place_id` | ID di riferimento a Google Maps | N/A |
| `latitude`, `longitude` | Coordinate geografiche | `geo` |
| `type` | Tipo di indirizzo (enum: Billing, Shipping, ecc.) | N/A |
| `is_primary` | Flag per indirizzo principale | N/A |
| `extra_data` | Dati aggiuntivi (array JSON) | N/A |

## Relazioni

Il modello `Address` implementa le seguenti relazioni:

```php
// Relazione polimorfa all'entità proprietaria
public function model(): MorphTo
{
    return $this->morphTo();
}

// Alias semantico per la relazione model()
public function addressable(): MorphTo
{
    return $this->morphTo('model');
}

// Relazione alla città
public function city(): BelongsTo
{
    return $this->belongsTo(City::class, 'locality', 'name');
}

// Relazione alla provincia
public function provincia(): BelongsTo
{
    return $this->belongsTo(Provincia::class, 'administrative_area_level_3', 'name');
}

// Relazione alla regione
public function regione(): BelongsTo
{
    return $this->belongsTo(Regione::class, 'administrative_area_level_2', 'name');
}
```

## Accessori

Il modello `Address` include i seguenti accessori:

```php
// Indirizzo completo in formato italiano
public function getFullAddressAttribute(): string

// Indirizzo stradale completo (via + numero)
public function getStreetAddressAttribute(): string

// Indirizzo formattato
public function getFormattedAddressAttribute(): string
```

## Metodi Principali

```php
// Ottiene la latitudine dell'indirizzo
public function getLatitude(): ?float

// Ottiene la longitudine dell'indirizzo
public function getLongitude(): ?float

// Ottiene l'indirizzo formattato
public function getFormattedAddress(): string

// Restituisce i dati in formato Schema.org PostalAddress
public function toSchemaOrg(): array
```

## Metodi Statici

```php
// Crea un indirizzo da una risposta di Google Maps
public static function createFromGoogleMaps(array $googleData, ?string $name = null, ?string $description = null): static
```

## Query Scope

```php
// Cerca indirizzi nelle vicinanze
public function scopeNearby($query, float $latitude, float $longitude, float $radiusKm = 10)

// Filtra per indirizzi principali
public function scopePrimary($query)

// Filtra per tipo di indirizzo
public function scopeOfType($query, $type)
```

## Utilizzo con Trait

Il modello `Address` è progettato per funzionare con il trait `HasAddress`, che può essere utilizzato da qualsiasi modello che necessiti di associare indirizzi:

```php
use Modules\Geo\Models\Traits\HasAddress;

class MyModel extends Model
{
    use HasAddress;
    
    // ...
}
```

Per dettagli sull'utilizzo del trait, vedere la [documentazione del trait HasAddress](../traits/hasaddress-implementation.md).

## Integrazioni Filament

Il modello `Address` include una risorsa Filament dedicata `AddressResource` che fornisce un'interfaccia amministrativa completa per la gestione degli indirizzi:

```php
use Modules\Geo\Filament\Resources\AddressResource;

// Utilizzo del form schema in altre risorse
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(AddressResource::getFormSchema()),
```

Per dettagli sull'utilizzo della risorsa Filament, vedere la [documentazione di AddressResource](../filament/address-resource.md).

## Best Practices

- Utilizzare sempre il trait `HasAddress` per modelli che necessitano di indirizzi
- Preferire l'utilizzo dei metodi accessori per ottenere componenti dell'indirizzo
- Utilizzare il metodo `toSchemaOrg()` per integrazioni con SEO e schema.org
- Quando possibile, sfruttare `createFromGoogleMaps()` per creare indirizzi precisi
- Utilizzare lo schema form di `AddressResource` per standardizzare i form degli indirizzi in tutta l'applicazione

## Riferimenti

- [Trait HasAddress](../traits/hasaddress-implementation.md)
- [Risorse Filament](../filament/address-resource.md)
- [Schema.org PostalAddress](https://schema.org/PostalAddress)
- [Pattern Relazioni Polimorfe](../morphs-relationship-patterns.md)