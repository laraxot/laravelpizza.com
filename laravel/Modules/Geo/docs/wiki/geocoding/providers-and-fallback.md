---
title: "Geocodifica: provider, catena di fallback e GEO_DRIVER"
type: reference
status: active
module: Geo
tags: [geo, geocoding, provider, nominatim, google-maps, fallback, config]
updated: 2026-11-25
qmd: "geocoding geocodifica provider fallback geo.driver GEO_DRIVER google photon nominatim bing here mapbox opencage locationiq chiavi api config services"
related:
  - ../../adr/geocoding-preferred-provider-with-fallback.md
  - ../../contracts/get-address-data-from-full-address-action.md
  - ../../adr/osm-proxy-tile-nominatim.md
  - update-coordinates.md
---

# Geocodifica: provider, catena di fallback e `GEO_DRIVER`

## Il punto di ingresso

`Actions\GetAddressDataFromFullAddressAction::execute(string $fullAddress): ?AddressData` trasforma un indirizzo testuale in un
`Datas\Geocoding\AddressData` provando i provider uno dopo l'altro. Contratto completo (invarianti, errori, cosa non fa):
[get-address-data-from-full-address-action](../../contracts/get-address-data-from-full-address-action.md).

Catena di default, nell'ordine in cui e' scritta nel metodo (la mappa `chiave => Action::class` e' un array letterale dentro
`execute()`):

| Chiave | Action | Chiave API |
|---|---|---|
| `google_maps` | `GoogleMaps\GetAddressFromGoogleMapsAction` | `services.google.maps_api_key` |
| `photon` | `Photon\GetAddressFromPhotonAction` | nessuna |
| `nominatim` | `Nominatim\GetAddressFromNominatimAction` | nessuna |
| `bing_maps` | `BingMaps\GetAddressFromBingMapsAction` | `services.bing.maps_api_key` |
| `here` | `Here\GetAddressFromHereMapsAction` | `services.here.key` |
| `mapbox` | `Mapbox\GetAddressFromMapboxAction` | `services.mapbox.access_token` |
| `opencage` | `OpenCage\GetAddressFromOpenCageAction` | `services.opencage.key` |

Comportamento: la prima Action che restituisce un `AddressData` vince; un'eccezione di un provider non interrompe la catena, il
suo messaggio finisce in `getErrors()` (`Collection<int, string>`, azzerata a ogni `execute()`); se nessuno risponde l'Action
costruisce una `Filament\Notifications\Notification` di errore e ritorna `null`. Esiste anche
`LocationIQ\GetAddressFromLocationIQAction`, che non e' nella catena.

## Scegliere il provider preferito: `geo.driver`

`config('geo.driver')` (env `GEO_DRIVER`, default `google_maps`) porta il provider scelto in testa alla catena, lasciando gli
altri nel loro ordine; una chiave sconosciuta viene ignorata. Perche' la mappa dei provider resta nell'Action e non in config
(Larastan degrada a `mixed` il tipo di `app($class)->execute()` se `$class` passa da `config()` o da un metodo): ADR
[geocoding-preferred-provider-with-fallback](../../adr/geocoding-preferred-provider-with-fallback.md). Se si aggiunge un provider va
aggiornata anche la documentazione dei driver in `config/config.php`.
`nominatim` e `photon` sono gli unici senza chiave: per ambienti senza credenziali si preferisce `nominatim`.

### Chiavi di configurazione

Verificato leggendo `XotBaseServiceProvider::registerConfig()`: ogni file di `config/` del modulo diventa
`<modulo>.<nome-file>`, quindi `config/config.php` e' raggiungibile come **`geo.config.*`** (cosi' lo leggono
`HasCoordinatePicker` con `geo.config.map.default_view` e `QueryNominatimAction` con `geo.config.osm_proxy.*`).
Ma `GetAddressDataFromFullAddressAction` (`geo.driver`), `Comune` (`geo.comuni_json_path`), `GoogleMapsService` e
`Adapters\GeoHttpClientBase` (`geo.api_keys.*`, `geo.cache.*`, `geo.rate_limits.*`, `geo.http_client.*`) leggono le chiavi senza
il segmento `config`. Conseguenze, da risolvere nel
codice (non lo si e' fatto qui: pagina di sola documentazione):

- `GEO_DRIVER` e gli altri valori di `config/config.php` finiscono in `geo.config.*` e quel codice non li vede: il fallback segue
  sempre l'ordine di default, rate limit, cache e timeout usano i default scritti nel codice. I test non lo notano perche' impostano `config(['geo.driver' => ...])` direttamente.
- Le chiavi dei provider sono lette da `config('services.*')` (tabella sopra), non dalla sezione `api_keys` di `config/config.php`
  (Google, Bing, Mapbox), che oggi serve solo a `GoogleMapsService`.

## Altri punti di accesso ai provider

- `Services\GeocodingService`, `Services\GoogleMapsService`, `Services\HereService`, `Adapters\{GeoHttpClientBase,GoogleMapsClient,HereClient}`:
  client HTTP condivisi (rate limiting, cache e retry in `GeoHttpClientBase`; valori in `config/config.php`). Contratti in `app/Contracts`:
  `GeocodingServiceInterface::getCoordinates()` e `GeocodingServiceContract`.
- `Geocoding\GeocodeAddressAction` e `Geocoding\GetGeocodingSuggestionsAction` sono **stub** (docblock "stub"): non fanno chiamate.
- OpenStreetMap: il browser non chiama mai OSM; passa dal proxy applicativo `GET api/geo/tiles/osm/{z}/{x}/{y}.png`
  (`throttle:1200,1`) e `GET api/geo/nominatim/{search|reverse}` (`throttle:30,1`), implementato da `Osm\FetchOsmTileAction` e
  `Osm\QueryNominatimAction`, con User-Agent e contatto (`GEO_OSM_CONTACT`), cache e 1 richiesta/s verso OSMF. Motivi e
  alternative: [ADR osm-proxy-tile-nominatim](../../adr/osm-proxy-tile-nominatim.md),
  [geo-uses-proxy-for-osm](../../adr/geo-uses-proxy-for-osm.md), [route-cache-includes-proxy](../../adr/route-cache-includes-proxy.md)
  (dopo il deploy `route:trans:cache`; un 404 HTML su una tile indica cache delle rotte obsoleta).
  Contratti: [query-nominatim-action](../../contracts/query-nominatim-action.md),
  [fetch-osm-tile-action](../../contracts/fetch-osm-tile-action.md).
- Reverse geocoding per Google, Mapbox, Nominatim e Bing (`Bing\GetAddressFromBingMapsAction`, che ha lo stesso nome di
  `BingMaps\GetAddressFromBingMapsAction` ma fa coordinate -> indirizzo, nessuno lo chiama fuori dal proprio test).

## Debito noto (verificato sul codice il 2026-11-25)

L'audit di consolidamento del 2026-06-30 (Ponytail G1/G2) aveva deciso di rinominare in `.bak` alcuni duplicati orfani. Nel
codice di oggi non e' successo:

- `app/Actions/FilterCoordinatesInRadius.php` esiste ancora, ha la logica invertita (`if ($distanza >= $raggio)` tiene le
  coordinate **fuori** dal raggio) e nessun chiamante; quella usata da `Rules\FilterCoordinatesInRadius` e'
  `FilterCoordinatesInRadiusAction`.
- `app/Actions/ClusterLocationsAction.wip` e `clusterlocationsaction.wip` sono identici e mai caricati da PSR-4.
- Circa 44 Actions provider "vive" non sono chiamate da altri moduli: sono tenute perche' ognuna integra un'API diversa e ha un
  test; nessuna chiave API risulta nel repository, quindi non si sa quali provider siano usati in produzione. Ridurle richiede una
  decisione di prodotto.

Related: [update-coordinates](update-coordinates.md) (chi scrive le coordinate), [distance-and-geometry](distance-and-geometry.md).
