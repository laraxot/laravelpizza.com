---
title: "Geo: riparazione dei marcatori lasciati dal sync"
type: lesson
updated: 2026-11-24
tags: [geo, sync, git, marcatori-conflitto, php]
qmd: "geo sync marcatori conflitto services coordinate picker osm proxy geocoding"
related:
  - ../../Xot/docs/lessons/module-sync-merge-conflicts.md
  - stories/13.geo-sync-marker-repair.story.md
---

# Geo: riparazione dei marcatori lasciati dal sync

## Cosa è successo

Lo script di sync `bashscripts/git/subtrees/merge_remote_repo_2.sh` fonde `laraxot/dev` in ogni modulo e fa
`commit -am .`. Su Geo ha lasciato `<<<<<<<` / `=======` / `>>>>>>>` annidati (fino a 4 livelli per blocco) in 15 file PHP: PHPStan
non partiva nemmeno e i test dei servizi non si caricavano. Ogni passata del sync **aggiunge** un livello: `OsmProxyTest`
è passato da 150 righe pulite (otto test, commit `eddac6d31`) a 388 righe e 140 marcatori, senza una sola riga nuova.

In tutti i 15 file i due lati differivano **solo nella forma**, mai nella logica: il lato del progetto è formattato da
Pint (docblock `@param  tipo  $nome` con due spazi, `new Foo;`, `{@see HasCoordinatePicker}` con `use`), il lato del
modulo da php-cs-fixer (docblock con riga vuota prima di `@return`, `new Foo()`, `{@see \FQCN}` senza `use`). Per questo
la riparazione non sceglie un lato "a caso": prova che le righe uniche dei due lati coincidono con una revisione integra
(`6e32612c`, 24-Nov 17:48, oppure `eddac6d31` per `OsmProxyTest`) e tiene quella.

## Scopo di ogni file e come è stato risolto

| File | A cosa serve | Chi lo usa | Risoluzione |
|---|---|---|---|
| `Actions/Maps/LoadGeoMapDatasetAction` (+ Categories/Stats) | legge/normalizza il GeoJSON del widget mappa | `GeoMapWidget` | canonico; duplicati `Support/GeoMapDataset` e `Actions/Geo/Support/GeoMapDatasetAction` rimossi (2026-11-25) |
| `Filament/Forms/Components/CoordinatePickerHelpers` | unica fonte per Nominatim (cerca/inverso) e normalizzazione delle coordinate | `XotBaseCoordinateField`, `HasCoordinatePicker` | docblock con FQCN, tolto il `use` che serviva solo al lato Pint |
| `Filament/Forms/Components/Traits/HasCoordinatePicker` | comportamento comune dei campi mappa: wrapper `#[Exposed]`/`#[Renderless]` che delegano agli helper | 9 componenti (`MapPicker`, `PlacePicker`, `CoordinatePicker`, ...) | stile modulo, 24 blocchi solo di docblock |
| `Services/BaseGeoService` | base astratta HTTP per i servizi geo: chiave API da config, rate limit, cache, errori espliciti | `GoogleMapsHttpAction` | docblock di `makeRequest` (i marcatori lo avevano svuotato su un lato) |
| `Services/GeoDataService` | gerarchia regioni/province/comuni/CAP dal JSON, con cache | `LoadGeoHierarchyAction` | `new Collection()`, docblock |
| `Services/GeoDataValidator` | valida struttura e integrità del JSON geografico | `GeoDataService`, `ValidateGeoDataIntegrityAction` | docblock |
| `Services/GeoService` | helper statico: distanza, Haversine in SQL, punto nel poligono | azioni `Distance/*`, `Polygon/*` | `new self()` |
| `Services/GoogleMapsService` | reverse geocoding, matrice distanze, quota altimetrica via Google Maps | `GoogleMapsHttpAction` | docblock |
| `tests/Feature/OsmProxyTest` | proxy OSM: tile con User-Agent con contatto, cache 7 giorni, Nominatim 1 richiesta/s | rotte `/api/geo/tiles/osm`, `/api/geo/nominatim` | WT = clone pulito `base_quaeris_fila5` (ptvx senza Geo); otto test `GEO-*-INV-*` allineati a `FetchOsmTileAction`/`QueryNominatimAction` |
| `tests/Fixtures/GoogleMapsServiceElevationStub` | doppio di test per `getElevation` su `GoogleMapsAction` | test elevation | stesso parent/API di produzione; stile Pint (`!== null`, `) {}`); `@see` questa doc |
| `tests/Unit/Actions/GetAddressDataFromFullAddressActionTest` | preferenza `geo.driver`, fallback provider, raccolta errori | `GetAddressDataFromFullAddressAction` | WT = quaeris; stub provider + assert su Photon→Google come catena attuale |
| `tests/Unit/Models/ComuneModelTest`, `Services/HereServiceTest`, `Services/ServicesTest` | istanziazione servizi e modello `Comune` | | `uses(TestCase::class)` con `use`, `new X()` |

## Regola di stile

Non esiste `pint.json` nel progetto: Pint usa il preset Laravel e riscriverebbe i docblock nello stile del lato progetto.
Finché lo stile non è deciso (un solo `pint.json` o un solo `.php-cs-fixer`), il sync continuerà a produrre conflitti
solo di forma. Qui si è tenuto lo stile del modulo perché coincide con la revisione integra e con `laraxot/dev`.

## Verifica

```bash
# igiene marker (anche tests/, esclusi da phpstan.neon ma obbligatori)
rg -l '^<<<<<<<' laravel/Modules/Geo --glob '*.php'   # atteso: 0
cd laravel
for f in $(git ls-files 'Modules/Geo/*.php'); do php -l "$f" >/dev/null || echo "KO $f"; done
./vendor/bin/phpstan analyse Modules/Geo
```

**2026-11-24 21:20** — i 3 test PHP residui (`GetAddressDataFromFullAddressActionTest`, `GoogleMapsServiceElevationStub`, `OsmProxyTest`) sono a 0 marker in WT; clone di riferimento = `base_quaeris_fila5` (ptvx non include Geo).

Il modulo `laraxot/module_geo_fila5` ha gli stessi marcatori su `laraxot/dev`: va ripulito là, altrimenti il prossimo
sync li riporta qui (vedi `../../Xot/docs/lessons/module-sync-merge-conflicts.md`).
