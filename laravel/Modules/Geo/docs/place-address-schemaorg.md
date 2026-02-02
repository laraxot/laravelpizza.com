# Place, Address e la separazione Regione/Provincia negli indirizzi italiani

## Obiettivo
Fornire una linea guida unificata per la rappresentazione degli indirizzi italiani, con particolare attenzione alla **separazione tra regione e provincia** e al **numero civico come campo separato**, in coerenza con lo standard [schema.org/PostalAddress](https://schema.org/PostalAddress) e la struttura del modulo Geo.

---

## Perché separare regione, provincia e numero civico?
- **Normativa italiana**: la provincia (es. MI), la regione (es. Lombardia) e il numero civico sono entità distinte e servono tutte per identificare univocamente un indirizzo.
- **Standardizzazione**: schema.org prevede campi separati per `addressRegion` (regione), `addressLocality` (città/comune), mentre la provincia va gestita come campo custom (`addressProvince`) e il numero civico va separato dalla via.
- **Riusabilità**: la separazione permette filtri, statistiche e validazioni più semplici e affidabili.
- **Compatibilità**: molti servizi (es. spedizioni, PA, geocoding) richiedono tutti i dati separati.

---

## Struttura consigliata per Address

| Campo         | Descrizione         | schema.org         | Esempio           |
|---------------|---------------------|--------------------|-------------------|
| street        | Via                 | streetAddress      | Via Roma          |
| street_number | Numero civico       | (concat)           | 10                |
| city/locality | Comune              | addressLocality    | Milano            |
| province      | Provincia (sigla)   | (custom)           | MI                |
| region        | Regione             | addressRegion      | Lombardia         |
| postal_code   | CAP                 | postalCode         | 20100             |
| country       | Paese               | addressCountry     | Italia            |
| latitude/longitude | Coordinate      | geo.latitude/longitude | 45.4642/9.19 |

> **Nota:** La provincia non è prevista nativamente in schema.org, ma è prassi aggiungerla come campo custom (es. `addressProvince`). Il numero civico va sempre separato dalla via.

---

## Esempio di serializzazione JSON (compatibile schema.org)

```json
{
  "@type": "PostalAddress",
  "streetAddress": "Via Roma 10",
  "addressLocality": "Milano",
  "addressProvince": "MI",
  "addressRegion": "Lombardia",
  "postalCode": "20100",
  "addressCountry": "Italia"
}
```

---

## Best practice di implementazione
- **Tutti i form e i modelli devono avere campi separati per regione, provincia e numero civico** (mai concatenati).
- **Le select devono essere a cascata**: regione → provincia → città → CAP.
- **La provincia va sempre salvata come sigla** (es. MI, PD, TO), la regione come nome completo.
- **Il numero civico va sempre separato dalla via**.
- **I mapping verso schema.org devono includere addressProvince come custom property**.
- **Tutte le validazioni devono verificare la coerenza tra provincia e regione** (es. MI ∈ Lombardia).

---

## Convenzioni di naming
- **Non usare mai il prefisso address_ nei campi della tabella addresses** (es. usare `locality`, non `address_locality`).
- **Usare sempre campi separati** per via e numero civico (`street`, `street_number`).

---

## Esempio di migrazione

```php
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->string('name')->nullable();
    $table->string('description')->nullable();
    $table->string('street', 100)->nullable();
    $table->string('street_number', 20)->nullable();
    $table->string('locality', 100)->nullable();
    $table->string('province', 2)->nullable()->comment('Sigla provincia es. MI');
    $table->string('region', 100)->nullable()->comment('Regione es. Lombardia');
    $table->string('postal_code', 20)->nullable();
    $table->string('country', 2)->nullable()->comment('Codice paese ISO 3166-1 alpha-2');
    $table->string('formatted_address')->nullable();
    $table->string('place_id')->nullable();
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();
    $table->nullableMorphs('addressable');
    $table->timestamps();
});
```

---

## Collegamenti
- [schema.org/PostalAddress](https://schema.org/PostalAddress)
- [schema.org/address](https://schema.org/address) (proprietà address su Place e altri tipi)
- [tasks-schema-org-place-geocircle](tasks-schema-org-place-geocircle.md) – task Place, GeoCircle e integrazione Meetup
- [Geo Module Architecture](./architecture.md)
- [Entità Geografiche](./geo_entities.md)
- [location-select.md](./location-select.md)
- [README.md](./README.md)

---

## Schema.org Enhanced Features

### GeoCircle for Service Areas

For delivery zones and service areas:

```php
// Modules/Geo/app/Models/Place.php additions
public function toGeoCircleSchema(): array
{
    return [
        '@type' => 'GeoCircle',
        'geoMidpoint' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ],
        'geoRadius' => [
            '@type' => 'Distance',
            'value' => $this->service_radius_km,
            'unitCode' => 'KM',
        ],
    ];
}
```

### Enhanced Place Schema

```php
// Modules/Geo/app/Models/Place.php toSchemaOrg() method
public function toSchemaOrg(): array
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Place',
        'name' => $this->name,
        'address' => $this->getAddressSchemaOrg(),
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ],
    ];
    
    // Add service area if exists
    if ($this->service_radius) {
        $schema['areaServed'] = $this->toGeoCircleSchema();
    }
    
    // Add opening hours if restaurant
    if ($this->has('opening_hours')) {
        $schema['openingHoursSpecification'] = $this->opening_hours;
    }
    
    return $schema;
}
```

### Enhanced Address Schema

```php
// Modules/Geo/app/Models/Address.php toSchemaOrg() method
public function toSchemaOrg(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'PostalAddress',
        'streetAddress' => trim($this->street . ' ' . $this->street_number),
        'addressLocality' => $this->locality,
        'addressProvince' => $this->province, // Custom field
        'addressRegion' => $this->region, // Custom field
        'postalCode' => $this->postal_code,
        'addressCountry' => $this->country,
    ];
}
```

---

## Italian Administrative Levels Mapping

According to Google Maps Geocoding API:

| Google Level | Italian Name | Example |
|--------------|--------------|---------|
| `administrative_area_level_1` | Regione | Lombardia |
| `administrative_area_level_2` | Provincia | Milano |
| `administrative_area_level_3` | Comune | Milano |
| `country` | Nazione | Italia |

---

**Ultimo aggiornamento:** 2026-02-10  
**Responsabile:** AI Assistant Schema.org Research  
**Versione Schema.org:** Latest (2026-02-10)
