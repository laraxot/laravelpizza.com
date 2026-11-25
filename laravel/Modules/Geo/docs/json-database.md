---
title: "Dati geografici italiani: JSON come database, modelli Sushi e GeoJsonModel"
type: reference
status: active
module: Geo
tags: [geo, json, sushi, comuni, regioni, province, cap, geonames]
created: 2026-09-26
updated: 2026-11-25
qmd: "geo json database sushi comune region province locality geojsonmodel comuni-istat cap geonames seeders cache"
related:
  - ./architecture.md
  - ./address.md
---

# Dati geografici italiani: JSON come database

Regioni, province, comuni e CAP sono dati semi-statici (circa 7.900 comuni): invece di tabelle e migrazioni il modulo li
legge da file JSON in `resources/json/` e li espone come modelli Eloquent in sola lettura (Sushi) o come collezioni
(`GeoJsonModel`). Questa pagina e' la fonte unica sull'argomento; sostituisce le decine di analisi "GeoJsonModel vs Sushi",
"unificazione Comune", "compendio dati geografici" che erano in radice di `docs/` (originali nel backup
`~/backups/laravelpizza-docs-md-before-cap100.tar.gz`, percorso `laravel/Modules/Geo/docs/`).

## File sorgente

| File | Contenuto |
|---|---|
| `resources/json/comuni-istat.json` | elenco ISTAT di 7.904 comuni. Voce: `nome`, `codice`, `zona{codice,nome}`, `regione{codice,nome}`, `provincia{codice,nome}`, `sigla`, `codiceCatastale`, `cap` (array), `popolazione` |
| `resources/json/comuni.json` | campione di 4 comuni con campi piatti (`regione`, `provincia`, `sigla_provincia`, `cap`, `codice_catastale`, `lat`, `lng`, `altitudine`, `superficie`, `zona_altimetrica`) |
| `resources/json/cluster-test-data.json` | dati di prova per il clustering della mappa |

`Actions/GeoData/GetItalianMunicipalitiesPathAction` risolve il percorso: usa `comuni-istat.json` se esiste, altrimenti
`comuni.json`. `Region`, `Province` e `Locality` accettano sia `regione`/`provincia` come stringa sia come oggetto
`{codice, nome}`.

## Quale modello usare

| Modello | Base | Sorgente | Note |
|---|---|---|---|
| `Region`, `Province`, `Locality` | `BaseModel` + `Sushi` | JSON del percorso sopra, righe uniche per codice | sola lettura, SQLite in memoria; `sushiShouldCache()` e' vero con cache su file che si rigenera quando cambia il JSON (senza, ogni richiesta rileggeva 1,9 MB e reinseriva le righe: salvare un indirizzo costava oltre 10 s). Espongono `getOptions(Get $get)` per i select Filament; `Locality` ha anche `getPostalCodeOptions()` |
| `Comune` | `BaseModel` + trait `Modules\Tenant\Models\Traits\SushiToJson` | `config('geo.comuni_json_path')` oppure `resources/json/comuni.json` | modello Sushi con scrittura su JSON (create/update/delete riscrivono il file): nei test si punta `geo.comuni_json_path` a un fixture per non toccare il JSON versionato |
| `ComuneJson` | `GeoJsonModel` | `resources/json/comuni.json` | collezioni statiche: `all`, `byRegion`, `byProvince`, `byCap`, `searchByName`, `allRegions`, `allProvinces`, `getProvincesByRegion`, `getCapsByCity`, `isValidCap`, `getGerarchia`, `getValidationRules`, `clearCache` |
| `GeoJsonModel` | astratta | `static::$jsonFile` | `all()`, `where()`, cache per percorso (`geo_comuni_json_<md5>`); read-only, nessuna relazione Eloquent |
| `State`, `County`, `GeoNamesCap` | `BaseModel` | tabelle `states`, `counties`, `geonames_cap` (migrazioni 2025-07-24) | dati su database, per codici postali GeoNames |

Regola pratica: serve una relazione Eloquent o un filtro SQL → modelli Sushi; serve solo leggere e filtrare una
collezione senza database → `ComuneJson`; serve scrivere comuni → `Comune`. I vecchi modelli `City` e `Cap` descritti nelle
analisi precedenti non esistono piu': il comune e' `Comune`/`Locality`, il CAP e' il campo `cap`/`postal_code`.

## Azioni di accesso alla gerarchia

`Actions/GeoData/` sostituisce i vecchi `GeoDataService` e `GeoDataValidator` (restano in `app/Services/` per compatibilita',
vedi [geo-sync-marker-repair.md](./geo-sync-marker-repair.md)):

- `GetRegionsAction`, `GetProvincesAction($regionCode)`, `GetCitiesAction($provinceCode)`, `GetCapAction($provinceCode, $cityCode)`;
- `LoadGeoDataAction`, `LoadGeoHierarchyAction` (`executeRegions|Provinces|Cities|Cap|ClearCache`);
- `ValidateGeoDataAction`, `ValidateGeoDataIntegrityAction`, `CheckGeoDataIntegrityAction`, `ClearGeoDataCacheAction`.

Le chiavi di cache sono in `Infrastructure/Config/GeoDataConfig` (`geo.regions`, `geo.provinces.%s`, `geo.cities.%s`,
`geo.cap.%s.%s`, TTL 86.400 s). I select a cascata (regione → provincia → comune → CAP) usano `Region`/`Province`/`Locality`
con `getOptions()`.

## Migrazioni, factory e seeder

- Migrazioni nel modulo: `place_types`, `places`, `locations`, `addresses`, `states`, `counties`, `geonames_cap` (tutte
  `XotBaseMigration`). La migrazione `regions` e' disattivata (`.php,bak`): `Region` e' Sushi.
- Una factory per ogni modello in `database/factories/` (13): `Address`, `Comune`, `CommuneJson` (per `ComuneJson`), `County`,
  `GeoJsonModel`, `GeoNamesCap`, `Locality`, `Location`, `Place`, `PlaceType`, `Province`, `Region`, `State`.
- `GeoDatabaseSeeder` chiama i seeder delle entita' (`Address`, `Comune`, `ComuneJson`, `County`, `GeoNamesCap`, `Locality`,
  `Location`, `Place`, `PlaceType`, `Province`, `Region`, `State`). Aiuti: `GeoDataMigrator`, `GeoJsonDownloader`,
  `GeoJsonExportSeeder`, `SushiSeeder`.
- Comando `php artisan sushi:manage {refresh|clear|status}` gestisce il database SQLite di Sushi.

Dati sacri: mai `migrate:fresh`, `migrate:refresh` o `--force` e mai `RefreshDatabase` (vedi [testing.md](./testing.md)).

## Esempio

```php
use Modules\Geo\Models\ComuneJson;
use Modules\Geo\Models\Province;

$milano = ComuneJson::searchByName('Milano', limit: 5);
$capValido = ComuneJson::isValidCap('20100');
$province = Province::query()->orderBy('name')->get();
```
