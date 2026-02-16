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
- [Geo Module Architecture](./architecture.md)
- [Entità Geografiche](./geo_entities.md)
- [location-select.md](./location-select.md)
- [README.md](./README.md)

---

**Ultimo aggiornamento:** 2025-05-29
Responsabile: Cascade AI 
