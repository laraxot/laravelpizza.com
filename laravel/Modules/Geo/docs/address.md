---
title: "Indirizzi: modello Address, trait HasAddress, form e tabelle"
type: reference
status: active
module: Geo
tags: [geo, address, indirizzi, filament, morph, schema-org, traduzioni]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo address indirizzo model hasaddress addressinput addresssection addressesfield addressresource enum traduzioni schema.org"
related:
  - ./json-database.md
  - ./coordinate-picker.md
  - ./geocoding-providers.md
---

# Indirizzi

Sintesi unica delle ~35 pagine su `Address`, `AddressResource`, `AddressInput`, traduzioni e relazioni che erano in radice
di `docs/` (originali nel backup `~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). I fatti sono verificati sul codice.

## Modello `Modules\Geo\Models\Address`

- Estende `BaseModel` (connessione `geo`), usa `SoftDeletes` e `GeoTrait`; tabella `addresses`.
- Relazione polimorfica `model()` (alias `addressable()`): colonne `model_type` + `model_id` create con
  `nullableUuidMorphs('model')`, cosi' un indirizzo si lega sia a modelli con chiave intera sia a modelli con UUID. Non usare
  `nullableMorphs('addressable')`: crea `addressable_id` intero e rompe i modelli UUID.
- Campi (`$fillable`): `name`, `description`, `route` (via), `street_number`, `locality`, `administrative_area_level_3`
  (comune), `administrative_area_level_2` (provincia), `administrative_area_level_1` (regione), `country` (ISO 2 lettere),
  `postal_code`, `formatted_address`, `place_id`, `latitude`, `longitude`, `type`, `is_primary`, `extra_data` (JSON).
  Sono i nomi dei componenti Google Places. I provider di geocoding restituiscono invece `Datas\AddressData` (`latitude`,
  `longitude`, `country`, `city`, `country_code`, `postal_code`, `locality`, `county`, `street`, `street_number`, `district`,
  `state`): la mappatura verso le colonne di `Address` e' a carico del chiamante.
- Cast: `latitude`/`longitude` float, `is_primary` bool, `extra_data` array, `type` → `AddressTypeEnum`
  (`home`, `work`, `billing`, `shipping`, `legal`, `other`).
- Accessor e metodi: `getFullAddress()`, `getStreetAddressAttribute()`, `getFormattedAddress()`, `getRegione()`,
  `getProvincia()`, `getLocality()` (cercano nei dati Sushi dei comuni, filtrando in PHP e non con `json_extract()`),
  `getLatitude()`/`getLongitude()`, `toSchemaOrg()` (PostalAddress schema.org).
- Scope: `nearby($lat, $lng, $radiusKm = 10)`, `primary()`, `ofType(string|AddressTypeEnum)`; da `GeoTrait`:
  `withDistance`, `orderByDistance`, `ofInPolygon`.
- `Enums/AddressItemEnum` elenca i campi (`route`, `street_number`, `postal_code`, `locality`, `administrative_area_level_1..3`,
  `country`, `formatted_address`, `place_id`, `latitude`, `longitude`, contatti `phone|mobile|fax|pec|whatsapp|email`, `notes`) e
  `getColumnDefinitions()` fornisce le colonne Blueprint corrispondenti per le migrazioni.

Convenzione italiana (schema.org): numero civico sempre separato dalla via; provincia salvata come sigla; regione con nome
completo; `addressProvince` e' una proprieta' custom perche' schema.org non prevede la provincia; select a cascata regione →
provincia → comune → CAP (vedi [json-database.md](./json-database.md)).

## Trait `Models\Traits\HasAddress`

Per rendere indirizzabile un modello: `use HasAddress;`. Fornisce `addresses()` (MorphMany), `address()` (MorphOne),
`primaryAddress()`, `getFullAddress()`, `getCity()`, `getPostalCode()`, `getProvince()`, `getRegion()`, `getCountry()`,
`setAsPrimaryAddress()`, `getAddressesByType()`, `addAddress($data, $setPrimary)`, `updatePrimaryAddress()` e gli scope
`inCity`, `inProvince`, `inRegion`, `inPostalCode`. `Place` e `Location` hanno la loro relazione: `Place::address()` e'
`BelongsTo`; `Location` usa `HasAddress`.

## Componenti Filament

| Classe (`Filament/...`) | Ruolo |
|---|---|
| `Resources/AddressResource` (+ `Pages`, `Schemas/AddressForm`, `Schemas/AddressInfolist`, `Tables/AddressesTable`) | CRUD degli indirizzi; estende `XotBaseResource`; e' l'unica sede dello schema campi |
| `Forms/Components/AddressInput` | campo con autocompletamento e pulsante "usa la mia posizione" (Alpine v3: spinner mentre `navigator.geolocation` e il reverse geocoding rispondono; vista `geo::filament.forms.components.address-input`) |
| `Forms/Components/AddressSection` | wrapper che delega a `AddressResource` lo schema, togliendo i metadati (`name`, `is_primary`) e impostando 2 colonne; `extraComponents()`, `saveRelationships()` |
| `Forms/Components/AddressField`, `Fields/AddressField` | sezioni con lo schema indirizzo da riusare in altri form |
| `Forms/Components/AddressesField` | repeater di indirizzi per modelli con `addresses()` |
| `Forms/Components/LocationSelector` | gruppo regione/provincia/CAP a cascata; `regionField()`, `provinceField()`, `capField()`, `getGeographicData()` |
| `Tables/Columns/AddressColumn` | colonna tabella per l'indirizzo |
| `Actions/UpdateCoordinatesBulkAction` | azione di massa che calcola le coordinate dall'indirizzo (`Actions/UpdateCoordinatesFromAddressAction` per singolo modello, `UpdateClientCoordinatesBulkAction`) |

Regola DRY: un solo schema indirizzo (in `AddressResource`), tutti gli altri componenti lo riusano; nessun modulo consumatore
deve ridefinire i campi.

Salvataggio del form: i dati arrivano al server solo se il campo e' deidratato (niente `dehydrated(false)`) e se il modello
consumatore ha il campo in `$fillable`; un indirizzo "non salvato" e' quasi sempre un problema di mass assignment.

## Traduzioni

File in `lang/{de,en,es,fr,it,pl}/`; per gli indirizzi `address.php`, `address_form.php`, `address_item.php`,
`address_item_enum.php`, `address_section.php`, `addresses.php`, `addresses_field.php`. Regole: ogni `label`, `placeholder`,
`helper_text` e `description` ha un testo vero (mai uguale alla chiave: `'label' => 'region'` e' un errore), sintassi
array breve `[]`, `declare(strict_types=1)` in testa, chiavi con prefisso `geo::`.

## Azioni collegate

`Actions/Address/FormatAddressAction`, `Actions/GetAddressDataFromFullAddressAction` (indirizzo libero → `AddressData`, vedi
[geocoding-providers.md](./geocoding-providers.md)), `Actions/UpdateCoordinatesFromAddressAction`,
`Actions/FormatCoordinatesAction`.
