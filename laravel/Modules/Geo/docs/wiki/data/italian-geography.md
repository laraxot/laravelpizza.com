---
title: "Geografia italiana: regioni, province, comuni, CAP e select a cascata"
type: reference
status: active
module: Geo
tags: [geo, istat, comuni, regioni, province, cap, sushi, select-a-cascata]
updated: 2026-11-25
qmd: "regioni province comuni CAP ISTAT Region Province Locality Comune Sushi comuni-istat.json select a cascata AddressForm GeoData Actions seeders"
related:
  - ../../json-database.md
  - address-model.md
  - ../filament/address-forms-and-resources.md
---

# Geografia italiana: regioni, province, comuni, CAP e select a cascata

Il dettaglio dei file JSON, dei modelli Sushi e di `GeoJsonModel` (come si leggono, cache, scrittura su JSON, seeders) e' nella pagina
unica [json-database](../../json-database.md). Qui: cosa alimenta le select dell'indirizzo, quale modello usare e le trappole note.

## Sorgente dati

`resources/json/comuni-istat.json` contiene i **7.904 comuni** ISTAT; ogni voce ha `nome`, `codice` (6 cifre, es. `028001`),
`zona`, `regione{codice,nome}`, `provincia{codice,nome}`, `sigla` della provincia, `codiceCatastale`, `cap` (lista) e `popolazione`.
`Actions\GeoData\GetItalianMunicipalitiesPathAction` restituisce il file ISTAT se esiste, altrimenti `resources/json/comuni.json`,
che e' un **campione di 4 comuni** con campi piatti (`regione`, `provincia`, `sigla_provincia`, `cap` stringa, `lat`, `lng`, ...).
Con il solo campione l'indirizzo offriva soltanto Lombardia e Sicilia (e una voce duplicata): era il difetto chiuso dalla story
`comuni-istat-dataset` (vedi [done-log](../../stories/done-log.md)); in piu' `cap` e' una lista e Sushi inseriva un array
(«Array to string conversion»), quindi i modelli vanno alimentati dal file ISTAT.

## Quale modello

| Modello | Cosa e' | Usare per |
|---|---|---|
| `Region`, `Province`, `Locality` | Sushi di sola lettura derivati dal file ISTAT (righe uniche per codice; `sushiShouldCache()` vero, cache su file che si rigenera quando cambia il JSON da ~1,9 MB: senza, salvare un indirizzo richiedeva oltre 10 s) | opzioni delle select (`getOptions(Get $get)`), relazioni `Region::provinces()`, `Province::region()`, `Province::localities()` |
| `Comune` | Sushi con scrittura su JSON (`SushiToJson` di Tenant); percorso da `config('geo.comuni_json_path')` o `resources/json/comuni.json` | `Address::getRegione()/getProvincia()/getLocality()`, dati per comune (`lat`, `lng`, `altitudine`, `superficie`, `zona_altimetrica`) |
| `ComuneJson` | `GeoJsonModel` (collezione, non Eloquent) | lettura/analisi, vedi json-database |
| `State`, `County`, `GeoNamesCap` | tabelle `states`, `counties`, `geonames_cap` (migrazioni `2025_07_24_*`); `GeoNamesCap` non fissa la connessione `geo` (riga commentata) | dati GeoNames dei CAP; non usate dal form indirizzo |
| `Place`, `PlaceType`, `Location` | luoghi di interesse con coordinate, tipo e indirizzo (`Place::address()`), `Location` con attributo `location` (array `latitude`/`longitude`) | mappe e picker |

## Le select dell'indirizzo

Nel form (`AddressResource\Schemas\AddressForm`, e `AddressResource::getSearchStep()` per il passo di ricerca) le quattro select sono
a cascata, tutte `searchable()`, `required()` e `live()`:

1. **Regione** (`administrative_area_level_1`, opzioni `Region::getOptions`): cambiando, azzera provincia, comune e CAP.
2. **Provincia** (`administrative_area_level_2`, `Province::getOptions`): disabilitata finche' manca la regione; cambiando, azzera comune e CAP.
3. **Comune** (`locality`, `Locality::getOptions`): disabilitata finche' mancano regione e provincia; filtra per `region_id` e
   `province_id`; cambiando azzera il CAP.
4. **CAP** (`postal_code`, `Locality::getPostalCodeOptions`): estrae i CAP (lista) del comune scelto, ordinati e senza doppioni.

I valori salvati sono i **codici**, non i nomi (vedi [address-model](address-model.md#cosa-contiene-davvero-la-colonna-codici-o-nomi)):
`FormatAddressAction` li riconverte in nomi per `full_address`. Il campo `country` del form e' nascosto con default `Italia`.

## Azioni sul dataset (`app/Actions/GeoData`)

`LoadGeoDataAction`, `LoadGeoHierarchyAction`, `GetRegionsAction`, `GetProvincesAction`, `GetCitiesAction`, `GetCapAction`,
`ValidateGeoDataAction`, `ValidateGeoDataIntegrityAction`, `CheckGeoDataIntegrityAction`, `GetGeoDataValidationErrorsAction`,
`ClearGeoDataCacheAction`, regole in `GeoDataValidationRules` (il `code` della citta' e' obbligatorio). Servizi correlati:
`Services\GeoDataService` e `Services\GeoDataValidator`. Seeders in `database/seeders` (`ComuneJsonSeeder`, `ComuneSeeder`, `RegionSeeder`,
`ProvinceSeeder`, `LocalitySeeder`, `GeoNamesCapSeeder`, `GeoDataSeeder`, ...); comando `SushiCommand` in `app/Console/Commands`.

## Trappole note

- `Comune` casta `regione`, `provincia`, `cap` ad array: con `comuni.json` (campione, valori stringa) `$comune->regione` vale `null`;
  `Address` si aspetta `{codice, nome}`. Punto aperto della story geo-test-suite-green.
- Le factory di `Comune` (`createComune()` in `tests/Pest.php`) scrivono nel JSON versionato del modulo: isolarsi con
  `geo.comuni_json_path` (attenzione alla chiave: vedi [providers-and-fallback](../geocoding/providers-and-fallback.md#chiavi-di-configurazione)).
