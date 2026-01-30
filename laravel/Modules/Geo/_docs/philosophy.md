# Modulo Geo - Filosofia, Religione, Politica, Zen

## 🎯 Panoramica

Il modulo Geo è il sistema di geolocalizzazione e gestione indirizzi per l'architettura Laraxot, responsabile della gestione di indirizzi, coordinate geografiche e integrazione con servizi di mappatura. La sua filosofia è incentrata sulla **standardizzazione Schema.org, la flessibilità polimorfa e la type safety**, garantendo che gli indirizzi siano sempre strutturati, validati e compatibili con standard web.

## 🏛️ Filosofia: Indirizzi Standardizzati e Flessibili

### Principio: Ogni Indirizzo Segue Schema.org, Ogni Entità Può Avere Indirizzi

La filosofia di Geo si basa sull'idea che gli indirizzi debbano seguire lo standard Schema.org `PostalAddress`, garantendo compatibilità con servizi esterni e SEO, mentre permettendo relazioni polimorfe per massima flessibilità.

- **Schema.org Compliance**: Il modello `Address` implementa lo standard Schema.org `PostalAddress`, garantendo compatibilità con Google, OpenStreetMap e altri servizi.
- **Polymorphic Relationships**: Gli indirizzi sono collegati ai modelli attraverso relazioni polimorfe (`morphTo`), permettendo a qualsiasi entità di avere indirizzi.
- **Multi-Address Support**: Supporto per indirizzi multipli per entità, con identificazione del tipo (`AddressTypeEnum`) e indirizzo primario.
- **Geocoding Integration**: Integrazione con servizi di geocoding (Google Maps) per conversione automatica indirizzo → coordinate.

## 📜 Religione: La Sacra Standardizzazione Schema.org

### Principio: Schema.org è la Bibbia degli Indirizzi

La "religione" di Geo si manifesta nella rigorosa aderenza allo standard Schema.org `PostalAddress`. Ogni campo dell'indirizzo deve corrispondere a uno standard Schema.org, e ogni indirizzo deve essere convertibile in formato Schema.org.

- **Field Mapping Schema.org**: Ogni campo del modello `Address` corrisponde a un campo Schema.org (`streetAddress`, `addressLocality`, `addressRegion`, `postalCode`, ecc.).
- **Method `toSchemaOrg()`**: Ogni indirizzo può essere convertito in formato Schema.org JSON-LD per SEO e compatibilità.
- **Formatted Address**: L'indirizzo formattato segue standard internazionali, con supporto per formati specifici per paese.
- **Place ID Integration**: Supporto per Google Places ID per identificazione univoca dei luoghi.

### Esempio: Schema.org Compliance

```php
// Modules/Geo/app/Models/Address.php
namespace Modules\Geo\Models;

class Address extends BaseModel
{
    /**
     * Restituisce i dati in formato Schema.org PostalAddress.
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
            'streetAddress' => $this->getStreetAddressAttribute(),
            'addressLocality' => $this->locality,
            'addressSubregion' => $this->administrative_area_level_3, // Provincia
            'addressRegion' => $this->administrative_area_level_2, // Regione
            'addressCountry' => $this->country,
            'postalCode' => $this->postal_code,
        ];
    }

    /**
     * Getter per l'indirizzo completo in formato italiano.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->route.($this->street_number ? ' '.$this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country,
        ]);
        return implode(', ', $parts);
    }
}
```
Questa implementazione garantisce che ogni indirizzo sia sempre compatibile con Schema.org, un pilastro della "religione" di Geo.

## ⚖️ Politica: Type Safety e Validazione Geografica (PHPStan Livello 10)

### Principio: Ogni Coordinate è Validata, Ogni Indirizzo è Type-Safe

La "politica" di Geo è l'applicazione rigorosa della type safety e della validazione geografica, specialmente nella gestione delle coordinate e nella ricerca geografica. Ogni coordinate deve essere validata e ogni query geografica deve essere type-safe.

- **PHPStan Livello 10**: Tutti i componenti del modulo Geo devono passare l'analisi statica al livello massimo.
- **Coordinate Type Safety**: Le coordinate (`latitude`, `longitude`) sono sempre tipizzate come `float` e validate.
- **Geographic Queries**: Le query geografiche (es. `nearby`) utilizzano formule matematiche validate (Haversine formula) per calcoli di distanza.
- **Address Type Enum**: Il tipo di indirizzo è gestito attraverso `AddressTypeEnum` per type safety.

### Esempio: Geographic Queries e Type Safety

```php
// Modules/Geo/app/Models/Address.php
class Address extends BaseModel
{
    /**
     * Scope per cercare indirizzi nelle vicinanze.
     * Utilizza la formula di Haversine per calcolare la distanza.
     */
    public function scopeNearby(
        Builder $query,
        float $latitude,
        float $longitude,
        float $radiusKm = 10
    ): Builder {
        return $query
            ->selectRaw('
                *,
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) * 
                    cos(radians(longitude) - radians(?)) + 
                    sin(radians(?)) * sin(radians(latitude))
                )) AS distance
            ', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radiusKm)
            ->orderBy('distance');
    }

    /**
     * Get the attributes that should be cast.
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_primary' => 'boolean',
            'extra_data' => 'array',
            'type' => AddressTypeEnum::class,
        ];
    }
}
```
Questo approccio garantisce che le query geografiche siano sempre accurate e type-safe, un aspetto cruciale della "politica" di Geo.

## 🧘 Zen: Semplicità e Auto-Formattazione

### Principio: L'Indirizzo si Formatta da Solo

Lo "zen" di Geo si manifesta nella preferenza per l'auto-formattazione e le convenzioni rispetto alla configurazione esplicita. Il modulo mira a rendere la gestione degli indirizzi il più trasparente possibile.

- **Auto-Formatting**: Gli indirizzi sono formattati automaticamente in base al paese e alle convenzioni locali.
- **JSON Data Caching**: I dati geografici statici (comuni, province, regioni) sono caricati da JSON e cachati per performance.
- **GeoJsonModel Abstraction**: Astrazione per modelli geografici readonly basati su JSON (`GeoJsonModel`).
- **Service Abstraction**: Servizi geografici (`GeoService`, `GeoDataService`) nascondono la complessità delle operazioni geografiche.

### Esempio: Auto-Formattazione e JSON Caching

```php
// Modules/Geo/app/Models/GeoJsonModel.php
abstract class GeoJsonModel
{
    protected static string $jsonFile = 'resources/json/comuni.json';

    /**
     * Carica e cache-izza i dati dal file json.
     */
    protected static function loadData(): Collection
    {
        $path = module_path('Geo', static::$jsonFile);
        $cacheKey = 'geo_comuni_json_'.md5($path);
        $data = cache()->rememberForever($cacheKey, fn () => 
            json_decode(file_get_contents($path), true)
        );
        return collect($data);
    }
}

// Modules/Geo/app/Services/GeoDataService.php
class GeoDataService
{
    private const CACHE_KEY_REGIONS = 'geo.regions';
    private const CACHE_TTL = 86400; // 24 ore

    /**
     * Ottiene tutte le regioni (con cache).
     */
    public function getRegions(): Collection
    {
        return Cache::remember(
            self::CACHE_KEY_REGIONS,
            self::CACHE_TTL,
            fn (): Collection => $this->loadData()->pluck('name', 'code')
        );
    }
}
```
Questo approccio incarna lo zen della semplicità, nascondendo la complessità della gestione geografica dietro un'interfaccia semplice e performante.

## 📚 Riferimenti Interni

- [Documentazione Master del Progetto](../../../docs/project-master-analysis.md)
- [Filosofia Completa Laraxot](../../Xot/docs/philosophy-complete.md)
- [Regole Critiche di Architettura](../../Xot/docs/critical-architecture-rules.md)
- [Documentazione Geo README](./README.md)

