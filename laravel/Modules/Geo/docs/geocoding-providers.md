---
title: "Geocoding: provider, catena di fallback, chiavi e proxy OpenStreetMap"
type: reference
status: active
module: Geo
tags: [geo, geocoding, provider, nominatim, osm, proxy, google-maps, bing, here, mapbox, photon]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo geocoding provider fallback google bing here mapbox opencage locationiq photon nominatim osm proxy tile config api key"
related:
  - ./address.md
  - ./geometry-and-distance.md
  - ./adr/geocoding-preferred-provider-with-fallback.md
  - ./adr/osm-proxy-tile-nominatim.md
---

# Geocoding, provider e proxy OpenStreetMap

Sintesi unica delle pagine su integrazioni Google/Bing/HERE/TomTom/Mapbox/Nominatim, "mappe solo gratuite" e
"integrazione mappe" che erano in radice di `docs/` (originali nel backup
`~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). Le decisioni sono negli ADR collegati; qui il quadro operativo.

## Regola: integrazioni come Actions

Ogni provider e' una Spatie Queueable Action (`use QueueableAction`, metodo `execute()`) sotto `app/Actions/<Provider>/`
(ADR [no-service-geo-integrations](./adr/no-service-geo-integrations.md)). Gli URL sono costanti in
`Infrastructure/Config/GeoApiEndpoints`; le risposte viaggiano in classi Spatie Data (`app/Datas/`), non in array.
In `app/Services/` restano classi storiche (`GeoService`, `GoogleMapsService`, `HereService`, ...): non estenderle con
nuove integrazioni (dettaglio in [geo-sync-marker-repair.md](./geo-sync-marker-repair.md)).

## Provider disponibili

| Cartella `Actions/` | Cosa fa | Chiave |
|---|---|---|
| `GoogleMaps/` | geocoding e reverse (`GetAddressFromGoogleMapsAction`, `GetAddressByLatLngFromGoogleMapsAction`, `GetCoordinatesFromGoogleMapsAction`, `GetGeocodingDataAction`), matrice distanze, tempo di viaggio, quota altimetrica, ottimizzazione percorso, client HTTP `GoogleMapsHttpAction` | `GOOGLE_MAPS_API_KEY` → `geo.api_keys.google_maps` (`geo.google_maps.api_key` e `services.google.maps.key` in alcune action) |
| `BingMaps/` (e duplicato `Bing/`) | indirizzo da Bing Maps | `services.bing.maps_api_key` (`BING_MAPS_API_KEY` in `geo.api_keys.bing_maps`) |
| `Mapbox/` | indirizzo e reverse | `services.mapbox.access_token` |
| `Here/` | indirizzo, durata e lunghezza/sommario di un percorso | `services.here.key` |
| `OpenCage/` | indirizzo | `services.opencage.key` |
| `LocationIQ/` | indirizzo | `services.locationiq.key` |
| `Nominatim/` | ricerca, reverse, lookup, coordinate | nessuna (policy OSMF) |
| `Photon/` | indirizzo (`https://photon.komoot.io/api`) | nessuna |
| `OpenStreetMap/`, `Osm/` | coordinate da OSM, tile e query Nominatim del proxy | nessuna |
| `Elevation/` | quota (Open-Elevation e Google) | — |
| `TimeZone/` | fuso orario di una coordinata (`GetTimeZoneAction`) | — |
| `IPGeolocation/` | posizione da IP | — |
| `Weather/` | `GetOpenWeatherDataAction` | `services.openweather.api_key` |

Le chiavi non stanno nel codice: variabili d'ambiente lette da `config/config.php` (`api_keys`) o da `config/services.php`.

**Attenzione ai nomi delle chiavi di config.** `XotBaseServiceProvider::registerConfig()` registra ogni file di `config/` come
`<modulo>.<nome-file>`: `config/config.php` diventa `geo.config.*` (e `config/sushi.php` diventa `geo.sushi.*`). Il codice usa
correttamente `geo.config.osm_proxy.*` e `geo.config.map.default_view`, ma legge anche `geo.driver`, `geo.api_keys.*`,
`geo.cache.*`, `geo.http_client.*`, `geo.rate_limits.*`, `geo.comuni_json_path` (44 punti in `app/` e `tests/`): quei nomi non
esistono se nessun file `config/geo.php` (progetto o tenant) li definisce, e in quel caso valgono i default del codice o `null`
(per esempio una chiave API mancante). Prima di affidarsi a `GEO_DRIVER` o a `GOOGLE_MAPS_API_KEY` verificare con
`config('geo.driver')` e `config('geo.config.driver')` quale dei due e' valorizzato; l'allineamento dei nomi nel codice e'
un lavoro aperto (non fatto in questa sintesi: solo documentazione).
Il file di config dichiara anche `rate_limits` (50 richieste/s, burst 100 per Google, Bing e Mapbox), `cache`
(abilitata, TTL 86.400 s, prefisso `geo_`) e `http_client` (timeout 5 s, 3 tentativi, 100 ms di pausa).

## Catena di fallback

`GetAddressDataFromFullAddressAction::execute(string $fullAddress): ?AddressData` prova i provider nell'ordine
`google_maps`, `photon`, `nominatim`, `bing_maps`, `here`, `mapbox`, `opencage`; il primo che restituisce un `AddressData`
vince, gli errori di ciascuno finiscono in `getErrors()`. `config('geo.driver')` (env `GEO_DRIVER` in `config/config.php`, default `google_maps`; vedi l'avvertenza sui nomi delle chiavi)
porta il provider scelto in testa alla catena senza toccare il codice; `nominatim` e' l'unico che non richiede chiave.
La mappa chiave → classe resta letterale dentro l'Action (Larastan perde il tipo se passa da `config()`): se si aggiunge un
provider, aggiornare sia l'Action sia il commento in `config/config.php`. Se nessun provider risponde l'Action ritorna `null`
e mostra una notifica Filament di errore. Decisione: [ADR](./adr/geocoding-preferred-provider-with-fallback.md).

Per coordinate da indirizzo: `GetCoordinatesAction(string): ?LocationData` (Google), `GetCoordinatesByAddressAction`;
per aggiornare i modelli: `UpdateCoordinatesFromAddressAction`, `UpdateCoordinatesAction(Place)`. Suggerimenti di
autocompletamento: `Geocoding/GetGeocodingSuggestionsAction`, `Geocoding/GeocodeAddressAction`.

## Proxy OpenStreetMap (tile e Nominatim)

Il browser non contatta mai OSMF: tile e ricerca indirizzi passano dalle rotte API del modulo (senza sessione ne' cookie),
cosi' l'IP del visitatore non arriva a terzi prima del consenso. ADR:
[osm-proxy-tile-nominatim](./adr/osm-proxy-tile-nominatim.md), [geo-uses-proxy-for-osm](./adr/geo-uses-proxy-for-osm.md),
[route-cache-includes-proxy](./adr/route-cache-includes-proxy.md).

| Rotta | Controller → Action | Limiti |
|---|---|---|
| `GET /api/geo/tiles/osm/{z}/{x}/{y}.png` (`geo.osm.tile`) | `OsmTileController` → `Osm/FetchOsmTileAction` | 404 fuori dalla griglia/zoom massimo (19), `throttle:1200,1`, cache su disco >= 7 giorni con richieste condizionali (ETag, Last-Modified), copia vecchia se OSM e' giu' |
| `GET /api/geo/nominatim/{search\|reverse}` (`geo.nominatim`) | `NominatimController` → `Osm/QueryNominatimAction` | `throttle:30,1`, 1 richiesta/s per l'intero sito, cache dei risultati 30 giorni |

Configurazione `geo.config.osm_proxy`: `contact` (env `GEO_OSM_CONTACT`, finisce nel User-Agent), `timeout` 10 s,
`tiles.{upstream,max_zoom,min_cache_days,browser_max_age}`, `nominatim.{enabled,upstream,cache_days}`;
`GEO_NOMINATIM_ENABLED=false` spegne il geocoding senza rilasciare codice (richiesto dalla policy Nominatim).
Le mappe usano il proxy solo se il layout dichiara `<html data-geo-tile-url data-geo-nominatim-url>`; senza, restano sugli
indirizzi pubblici. Il provider registra il `RouteServiceProvider` del modulo: senza, `routes/api.php` non veniva caricato.
Test: `tests/Feature/OsmProxyTest.php` (otto casi: tile con User-Agent contattabile, 7 giorni di cache, copia vecchia, 404
fuori griglia, ricerca in JSON e cache, richieste invalide senza chiamare Nominatim, spegnimento, 1 richiesta/s).
Il `CoordinatePickerHelpers` dei campi mappa interroga Nominatim direttamente lato server (vedi
[coordinate-picker.md](./coordinate-picker.md)).

## Duplicati noti nel codice

`Actions/Bing` e `Actions/BingMaps` hanno la stessa `GetAddressFromBingMapsAction`; `Actions/Math` e `Actions/Distance`
hanno `CalculateGeoDistanceAction`; `Actions/Math` e `Actions/Polygon` hanno `IsPointInPolygonAction`; in `Actions/`
convivono `FilterCoordinatesInRadius.php` e `FilterCoordinatesInRadiusAction.php` (la regola di validazione e' un'altra
classe, `app/Rules/FilterCoordinatesInRadius`).
Sono da unificare con un test che li copra prima di rimuoverne uno.
