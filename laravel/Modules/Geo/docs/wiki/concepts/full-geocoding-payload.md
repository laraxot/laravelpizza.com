# Full Geocoding Payload — `CoordinatePicker` Contract

## Scopo

`CoordinatePicker` (Geo module) cattura geolocalizzazioni dal cittadino e deve
salvare **tutte** le informazioni che il provider (oggi Nominatim/OSM, domani
HERE/Google) restituisce, anche se la UI mostra solo `lat`, `lng` e `address`.

Le informazioni aggiuntive (place_id, osm_type, boundingbox, address details
strutturati, ecc.) servono per:

- analisi geografiche e clustering territoriale a posteriori;
- de-duplicazione di segnalazioni ricorrenti sullo stesso `place_id`;
- audit / forensics se il marker o l'indirizzo cambiano fra provider;
- futura integrazione con HERE / Google senza dover ri-geocodificare il dataset.

## Punti di cattura

| Trigger UI            | Origine dati                                          | Funzione JS                                    |
|-----------------------|-------------------------------------------------------|------------------------------------------------|
| Click su mappa        | reverse-geocoding server-side (`reverseGeocode`)      | `handleMapInteraction` → blade `reverseGeocode`|
| Drag del marker       | reverse-geocoding server-side                         | `handleMapInteraction` → blade `reverseGeocode`|
| Geolocation browser   | reverse-geocoding server-side                         | `requestGeolocation` → blade `reverseGeocode`  |
| Selezione da ricerca  | risultato `search` Nominatim (già completo) + reverse | `selectSearchResult` → `_handleSearchSelection`|
| `setCoordinates` API  | reverse-geocoding server-side                         | `setCoordinates` → blade `reverseGeocode`      |

Il blob completo arriva in due vie complementari:

1. **`map-picker-search.js → buildLocationPayload(result, lat, lng, address)`**
   appiattisce il risultato di Nominatim search nel formato canonico e mette
   l'oggetto Nominatim integrale sotto la chiave `raw`. Il payload viene
   emesso nell'evento `address-selected` e propagato al `state` dell'Alpine
   wrapper in `coordinate-picker.blade.php`.
2. **`HasCoordinatePicker::reverseGeocode($lat, $lng)`** chiama Nominatim
   `/reverse` server-side (rispetta rate-limit + User-Agent), normalizza i
   campi address, e ritorna l'intero JSON sotto `raw` + `address_details`.

I due flussi convergono nello stesso oggetto JSON salvato in
`tickets.location` (vedi
[`ticket-location-json-architecture`](../../../../Fixcity/docs/wiki/concepts/ticket-location-json-architecture.md)).

## Forma canonica del payload `location`

```json
{
  "lat": 45.562246,
  "lng": 12.249756,
  "latitude": 45.562246,
  "longitude": 12.249756,
  "address": "Via Rodolfo Morandi 5, 31021 Mogliano Veneto TV, Italia",
  "display_name": "Via Rodolfo Morandi 5, 31021 Mogliano Veneto TV, Italia",
  "provider": "nominatim",
  "place_id": 12345678,
  "osm_type": "node",
  "osm_id": 9876543210,
  "licence": "Data © OpenStreetMap contributors, ODbL 1.0.",
  "importance": 0.42,
  "type": "house",
  "class": "place",
  "boundingbox": ["45.5621", "45.5623", "12.2496", "12.2499"],
  "street": "Via Rodolfo Morandi",
  "street_number": "5",
  "zip": "31021",
  "postcode": "31021",
  "city": "Mogliano Veneto",
  "suburb": null,
  "province": "Treviso",
  "state": "Veneto",
  "country": "Italia",
  "country_code": "it",
  "address_details": { "...": "..." },
  "structured": { "...": "..." },
  "raw": { "...": "intero JSON Nominatim originale" }
}
```

### Regole di compatibilità

- `lat`/`lng` **e** `latitude`/`longitude` convivono — i consumer storici di
  Geo/Fixcity usano nomi diversi e non vogliamo regressioni.
- `address` resta il campo human-readable mostrato a video.
- `raw` non deve mai essere riempito con stringhe troncate: salva sempre
  l'oggetto JSON completo del provider.
- I campi top-level vanno popolati anche quando vuoti (valore `null`), così
  l'analisi downstream può fare projection con uno schema stabile.

## UI Read-out

`coordinate-picker.blade.php` mostra **solo**:

- `lat` con 6 decimali;
- `lng` con 6 decimali;
- `address` (se presente), preceduto dall'icona `heroicon-o-map-pin`.

Tutto il resto resta in `state` e viene serializzato nel `location` JSON al
submit del wizard / save Filament.

## Verifiche post-modifica

1. **Click + drag**: `state.raw` deve contenere il JSON di
   `nominatim.../reverse?format=jsonv2&addressdetails=1`.
2. **Search select**: `state.raw` deve contenere il JSON della scelta
   `nominatim.../search?format=json&addressdetails=1`.
3. **Submit ticket**: `tickets.location` deve avere chiavi `raw`,
   `address_details`, `place_id`, `boundingbox`.
4. **PHPStan**: `vendor/bin/phpstan analyse Modules/Geo` deve restare verde.
5. **Pint**: `vendor/bin/pint --dirty --format agent` sui file PHP modificati.

## File coinvolti

- `laravel/Modules/Geo/resources/js/components/map-picker-search.js` —
  `buildLocationPayload` e dispatch evento `address-selected`.
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js` —
  `_handleSearchSelection` consuma il payload.
- `laravel/Modules/Geo/resources/js/components/map-picker-controls.js` —
  `requestGeolocation` usa lo zoom configurato del picker.
- `laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php` —
  spread di payload e reverseGeocode nel `state`, preservando il `raw`.
- `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php` —
  `reverseGeocode` espone `address_details`, `place_id`, `boundingbox`, `raw`.

## Cross-reference

- [`Fixcity/docs/wiki/concepts/ticket-location-json-architecture.md`](../../../../Fixcity/docs/wiki/concepts/ticket-location-json-architecture.md) —
  contratto Eloquent `Ticket::location()` lato persistence.
- [`Fixcity/docs/wiki/concepts/location-capture-map-wizard.md`](../../../../Fixcity/docs/wiki/concepts/location-capture-map-wizard.md) —
  flusso business della cattura location nel wizard.
- [`coordinate-picker-comprehensive-guide.md`](./coordinate-picker-comprehensive-guide.md) —
  guida tecnica al componente.

---

*Creato: 2026-05-13 — Claude Opus 4.7 / sessione "full geocoding payload".*
