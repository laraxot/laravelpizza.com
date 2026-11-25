---
title: "Architettura del modulo Geo: struttura, convenzioni e debiti noti"
type: reference
status: active
module: Geo
tags: [geo, architettura, convenzioni, xotbase, actions, migrazioni, riusabilita, traduzioni]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo architettura struttura basemodel connessione geo actions services datas migrazioni nullableuuidmorphs riusabilita neutralita traduzioni debiti"
related:
  - ./README.md
  - ./testing.md
  - ./adr/no-service-geo-integrations.md
---

# Architettura del modulo Geo

Sintesi unica delle pagine di architettura, filosofia ("religione/politica/zen"), ereditarieta' dei modelli, riusabilita',
nomi hard-coded, audit di duplicati, factory/seeder e traduzioni che erano in radice di `docs/` (originali nel backup
`~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). Le parti retoriche sono state scartate; restano regole verificate.

## Mappa di `app/`

| Cartella | Contenuto |
|---|---|
| `Actions/` | ~110 Spatie Queueable Actions (`use QueueableAction`, `execute()`), raggruppate per provider/funzione: `Address`, `Distance`, `Math`, `Polygon`, `Geocoding`, `GeoData`, `Map`/`Maps`, `Osm`, `GoogleMaps`, `Here`, `Mapbox`, `Nominatim`, `Photon`, ... (vedi [geocoding-providers.md](./geocoding-providers.md), [geometry-and-distance.md](./geometry-and-distance.md)) |
| `Datas/` | Spatie Data: `AddressData`, `LocationData`, `CoordinatesData`, `GeocodingData`, `Map/*`, `Routing/*`, `GoogleMaps/*`, `HereMap/*` |
| `Models/` | `Address`, `Place`, `PlaceType`, `Location`, `Comune`, `ComuneJson`, `GeoJsonModel`, `Region`, `Province`, `Locality`, `State`, `County`, `GeoNamesCap`, + `BaseModel`, `BasePivot`, `BaseMorphPivot`, trait `GeoTrait`, `HasAddress` (vedi [address.md](./address.md), [json-database.md](./json-database.md)) |
| `Filament/` | `Resources` (`AddressResource`, `LocationResource`), `Forms/Components`, `Tables/Columns`, `Actions`, `Pages`, `Widgets` |
| `Contracts/` | `CalculateDistanceActionContract` (legato a `CalculateDistanceAction` nel provider), `GeocodingServiceContract`, `GeocodingServiceInterface`, `HasGeolocation` (implementato da `Place`) |
| `Services/` | classi storiche (`GeoService`, `GoogleMapsService`, `HereService`, `GeoDataService`, `GeoDataValidator`, `MapService`, `GeocodingService`, `BaseGeoService`): non estendere, vedi sotto |
| `Adapters/`, `Infrastructure/` | client HTTP (`GeoHttpClientBase`, `GoogleMapsClient`, `HereClient`), costanti URL (`GeoApiEndpoints`), config e regole dati (`GeoDataConfig`, `GeoDataValidationRules`) |
| `Http/Controllers/` | solo `OsmTileController` e `NominatimController` (proxy OSM) |
| `Providers/` | `GeoServiceProvider`, `RouteServiceProvider`, `EventServiceProvider`, `Filament/AdminPanelProvider` |
| `Rules/`, `Traits/`, `Transformers/`, `Support/`, `Facades/`, `Console/` | regola `FilterCoordinatesInRadius`, `HandlesCoordinates`, `GeoJsonResource`/`GeoJsonCollection`, `GeoMapDataset`, `GeoServiceFacade`, comando `sushi:manage` |

Alias e composer: modulo `Geo` (`module.json`, alias `geo`), pacchetto `laraxot/module_geo_fila5`, namespace `Modules\Geo\`; dipende da
Xot, Tenant e UI (repository path in `composer.json`).

## Regole

1. **Estendere le base Xot, mai Laravel/Filament direttamente**: modelli da `BaseModel` (→ `XotBaseModel`, connessione `geo`,
   cast di `created_at`/`updated_at`/`published_at`), campi e sezioni da `XotBaseField`/`XotBaseSection`/`XotBaseRepeater`,
   risorse da `XotBaseResource`, widget da `XotBaseWidget`, pagine da `XotBasePage`, migrazioni da `XotBaseMigration`. Un modello
   che estende `Model` perde connessione, trait di tracciamento e configurazioni predefinite.
2. **Logica in Actions, non in Services**: ogni nuova integrazione o calcolo e' una Queueable Action (ADR
   [no-service-geo-integrations](./adr/no-service-geo-integrations.md)); i dati viaggiano in Spatie Data, non in array. Le
   classi in `Services/` esistono per compatibilita' (vedi [geo-sync-marker-repair.md](./geo-sync-marker-repair.md) per ruolo e
   chiamanti di ciascuna). Un'Action non deve fare da proxy a una relazione Eloquent gia' esistente.
3. **Un modulo, una proprieta' del dominio geo**: geocoding, coordinate, mappe, fusi, campi indirizzo vivono qui; gli altri moduli
   riusano `AddressInput`, `CoordinatePicker`, `HasAddress` invece di reimplementare la geolocalizzazione.
4. **Migrazioni**: una tabella, una migrazione `create` (poi solo `add_*` idempotenti); `tableCreate()` per creare e
   `tableUpdate()` per aggiungere; timestamp e soft delete con `$this->updateTimestamps($table, true)` (non `$table->timestamps()`
   in duplicato). Relazioni polimorfiche con `nullableUuidMorphs('model')` (colonne `model_type`/`model_id`): accetta chiavi
   intere e UUID; non usare `nullableMorphs('addressable')`. Many-to-many con `belongsToManyX()`, non `belongsToMany()` (regola
   di progetto; nel modulo non ce ne sono). Mai `migrate:fresh`/`refresh`/`--force`: i dati sono sacri.
5. **Neutralita' e riusabilita'**: il modulo e' un repository condiviso fra progetti. Niente nomi di progetto, di enti o di
   domini specifici nel codice e nei docs; classi dinamiche e configurazioni database dai punti di estensione Xot (`XotData`,
   config), mai hard-coded. Controllo rapido: `rg -n "<nome-progetto>" laravel/Modules/Geo --glob '!docs/**'`.
6. **Qualita**: `declare(strict_types=1)`, PHPStan livello 10, Pest sul comportamento (vedi [testing.md](./testing.md));
   docblock `@see Modules/Geo/docs/<pagina>.md` su ogni classe o metodo creato o modificato, con la pagina che esiste.
7. **Traduzioni**: `lang/{de,en,es,fr,it,pl}/<file>.php`, chiavi `geo::<file>.<chiave>`; nessuna stringa fissa nelle viste; testi
   veri (mai uguali alla chiave); un file per componente (`address.php`, `coordinate-picker.php`, `coordinates.php`,
   `distance.php`, `city.php`, ...).
8. **Factory e seeder**: una factory per modello, `GeoDatabaseSeeder` chiama i seeder delle entita' (elenco in
   [json-database.md](./json-database.md)); i test creano i dati con le factory, non con SQL a mano.
9. **Documentazione**: `docs/README.md` (scopo), `docs/00-index.md` (mappa), una pagina per argomento; story in
   `docs/stories/`, decisioni in `docs/adr/`; nomi in minuscolo con trattini, senza date.

## Debiti noti (verificati sul working tree)

- Codice duplicato: `Actions/Bing` e `Actions/BingMaps`; `CalculateGeoDistanceAction` in `Distance` e `Math`;
  `IsPointInPolygonAction` in `Math` e `Polygon`; `FilterCoordinatesInRadius.php` accanto a `...Action.php`; `LocationDTO`
  in `app/Datas/`, `app/DataTransferObjects/` e `app/datatransferobjects/` (cartelle che differiscono solo per le maiuscole:
  collidono su filesystem case-insensitive); `Forms/Components/CoordinatePicker` accanto a `Filament/Forms/Components/CoordinatePicker`.
- File `*.disabled`, `*.fila3`, `*.backup-*`, `*.bak*` in `app/` e `database/migrations/` (varianti tolte dal caricamento):
  da rimuovere quando e' sicuro che nulla le riattivi.
- Nomi di chiavi config incoerenti (`geo.driver`... contro `geo.config.*`): vedi [geocoding-providers.md](./geocoding-providers.md).
- `tests/Arch/debt.php` elenca le violazioni delle regole di architettura Xot ancora aperte.
- Il sync fra repository (`merge_remote_repo_2.sh`) puo' lasciare marcatori di conflitto e riportare file gia' rimossi: dopo ogni
  sync controllare `rg -l '^<<<<<<<' laravel/Modules/Geo` (vedi [geo-sync-marker-repair.md](./geo-sync-marker-repair.md)).
