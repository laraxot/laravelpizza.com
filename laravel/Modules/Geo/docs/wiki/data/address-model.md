---
title: "Indirizzo: modello Address, livelli amministrativi e full_address"
type: reference
status: active
module: Geo
tags: [geo, address, schema-org, istat, administrative-area, enum]
updated: 2026-11-25
qmd: "address indirizzo modello schema.org PostalAddress administrative_area_level_1 2 3 regione provincia comune ISTAT FormatAddressAction full_address HasAddress AddressTypeEnum AddressItemEnum"
related:
  - italian-geography.md
  - ../filament/address-forms-and-resources.md
  - ../../json-database.md
---

# Indirizzo: modello `Address`, livelli amministrativi e `full_address`

`Modules\Geo\Models\Address` e' un indirizzo postale (ispirato a schema.org `PostalAddress`) agganciato in modo polimorfico a
qualunque modello. Tabella `addresses` (connessione `geo`, soft delete), una sola migrazione:
`2025_05_28_000001_create_addresses_table.php`, scritta con `XotBaseMigration` e `tableCreate()` / `tableUpdate()`.

## Colonne

| Colonna | Significato |
|---|---|
| `model_type`, `model_id` | modello padrone (`nullableUuidMorphs('model')`: id intero o UUID) |
| `name`, `description`, `phone` | etichetta, nota, telefono |
| `route`, `street_number` | via/piazza e numero civico |
| `locality` | localita'/frazione; nel form e' il **codice ISTAT del comune** (vedi sotto) |
| `administrative_area_level_3` | comune/citta' |
| `administrative_area_level_2` | provincia |
| `administrative_area_level_1` | regione |
| `country` (2 caratteri), `postal_code` | codice paese ISO, CAP |
| `formatted_address`, `place_id` | testo restituito dal geocoder, id Google Places |
| `latitude`, `longitude` | `decimal(15,10)` |
| `type` (indicizzato), `is_primary` (indicizzato) | `AddressTypeEnum` (`home`, `work`, `billing`, `shipping`, `legal`, `other`) e flag indirizzo principale |
| `extra_data` | JSON libero |
| timestamps, `deleted_at`, `created_by`, `updated_by`, `deleted_by` | audit via `XotBaseModel` |

### Mappatura sui tipi di Google (Italia)

I nomi delle colonne seguono i tipi dei componenti di Google Geocoding, **con questa lettura italiana** (e' il commento del
codice: `AddressItemEnum`, migrazione e `Address::$fillable` coincidono):

| Colonna / tipo Google | In Italia | Esempio |
|---|---|---|
| `administrative_area_level_1` | Regione | Lazio |
| `administrative_area_level_2` | Provincia (o Citta' metropolitana) | Roma / «Citta' Metropolitana di Roma» |
| `administrative_area_level_3` | Comune | Roma |
| `locality` | Localita' | Roma |
| `country` | Nazione (ISO-2) | IT |

Errori frequenti da non ripetere: `level_1` non e' la nazione, `level_2` non e' la regione, `level_3` non e' la provincia. Le
etichette dei campi sono in `lang/*/address_item.php`. La gerarchia amministrativa italiana e' regione > provincia > comune;
il CAP e' separato dai livelli (un comune puo' avere piu' CAP).

## Cosa contiene davvero la colonna: codici o nomi

Due modi di scrivere un indirizzo convivono:

1. **Dal form** (`AddressForm`, `AddressesField`): le select Regione, Provincia, Comune e CAP salvano i **codici ISTAT**:
   `administrative_area_level_1` = codice regione, `administrative_area_level_2` = codice provincia, `locality` = codice comune.
2. **Dal geocoding o da un import**: si salvano i **nomi** («Lombardia», «Milano»).

`Actions\Address\FormatAddressAction` e' il solo punto che ricompone la forma italiana «Viale delle Nazioni 12, 48122 Ravenna (RA)»:
via + numero, poi `CAP Comune (SIGLA)`; il nome del comune viene da `Locality`, la sigla della provincia dal file ISTAT
(mappa in cache `geo:province-abbreviations:*`, legata a percorso e data del file), con ripiego sul nome della provincia; i valori
scritti per nome e non numerici vengono aggiunti cosi' come sono; in fondo `country`. L'accessor `Address::full_address`
(`getFullAddressAttribute()`) delega ad `Actions\Address\FormatAddressAction`; senza questa conversione tabelle e geocoding
vedevano «Viale delle Nazioni 12, 39014, 39, 48122». `formatted_address` (accessor) restituisce il valore salvato oppure compone
piu' righe da via, localita', provincia e paese.

## Relazioni e metodi utili

- `Address::model()` e `Address::addressable()`: `morphTo` sulle stesse colonne. `addressable()` dichiara esplicitamente
  `morphTo('addressable', 'model_type', 'model_id')`: il nome della relazione deve coincidere col metodo, altrimenti
  `with('addressable')` la registra come `model` (bug corretto nella story [geo-test-suite-green](../../stories/geo-test-suite-green.story.md)).
- `getRegione()`, `getProvincia()`, `getLocality()`: leggono il comune dai dati Sushi (`Comune`). Il filtro regione/provincia e' fatto in
  PHP, non con `json_extract`: i dati dei comuni possono contenere stringhe non JSON e SQLite fallirebbe con «malformed JSON».
- Scope: `nearby($lat, $lng, $radiusKm = 10)`, `primary()`, `ofType(AddressTypeEnum|string)`; piu' quelli di `GeoTrait`
  (`withDistance`, `orderByDistance`, vedi [distance-and-geometry](../geocoding/distance-and-geometry.md)).
- `street_address` (accessor): `route` + `street_number`.

## Dare indirizzi a un modello: `HasAddress`

`Models\Traits\HasAddress` aggiunge `addresses()` (`morphMany`), `address()` (`morphOne`), `primaryAddress()` (quello con
`is_primary = true`) e `getFullAddress()`. Nota: il fallback di `HasAddress::getFullAddressAttribute()` compone la stringa con
`route`, `street_number`, `postal_code`, `city`, `province` dall'attributo del modello ospite; e' pensato per modelli con colonne
legacy, non per `Address`.

## `AddressItemEnum` e `AddressTypeEnum`

- `AddressTypeEnum` (`HasLabel`): i sei tipi sopra, con `options()` per le select.
- `AddressItemEnum` (`HasColor`, `HasIcon`, `HasLabel`): un caso per ogni campo standard (`phone`, `name`, `route`, `street_number`,
  `postal_code`, `locality`, `administrative_area_level_3|2|1`, `country`, `formatted_address`, `place_id`, `latitude`, `longitude`,
  `fax`, `mobile`, `pec`, `whatsapp`, `email`, `notes`). Fornisce le **definizioni colonna** per le migrazioni
  (`getColumnDefinitions()`, `columns()`, `columnsWithLegacy()` che aggiunge `address`, `city`, `province`, `region` per compatibilita')
  e lo schema di form di ciascun campo, cosi' un modulo ospite che vuole le colonne di indirizzo sulla propria tabella le prende da
  qui invece di riscriverle. `CoordinatesSection` e' usata dal caso latitudine/longitudine.

## Storia dei campi

Documenti precedenti descrivevano colonne `region`, `province`, `province_short`, `address_locality`, `street_address` e relazioni
`region()`/`province()`: **non esistono** nel modello attuale (le relazioni commentate in `Address.php` e le colonne dell'elenco sopra
sono la verita'). Se si incontrano quei nomi in un vecchio documento o nel backup, vanno letti come tentativi di progetto non
realizzati.
