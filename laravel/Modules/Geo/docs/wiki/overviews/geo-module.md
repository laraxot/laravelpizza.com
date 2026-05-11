---
type: overview
module: Geo
sources:
  - ../../../architecture.md
  - ../../../business-logic-overview.md
  - ../../../address-implementation.md
  - ../../../structure.md
confidence: high
updated: 2026-04-15
---

# Geo Module — Overview

> **Ruolo**: Gestione dati geografici italiani — indirizzi, comuni, province, regioni, geocoding, Leaflet maps.

## Responsabilità del Modulo

Il modulo Geo è il **sistema centralizzato di gestione geografica**:

- Gerarchia amministrativa italiana: `Region → Province → City/Comune → Cap → Address`
- Geocoding coordinate (lat/lng) con Haversine per calcoli distanza
- `LeafletMarkerMapInput` — componente Filament per mappe interattive (usato in Fixcity wizard)
- Schema.org/PostalAddress compliance per indirizzi
- Connessione DB dedicata `geo` (multi-tenant ready, multi-db ready)

## Modelli Core

| Modello | Scopo | Note |
|---------|-------|------|
| `Address` | Indirizzo completo conforme schema.org | Polymorphic `nullableUuidMorphs('model')` |
| `Region` | 20 regioni italiane | HasMany Province |
| `Province` | 110 province | BelongsTo Region, HasMany City |
| `City` / `Comune` | 8000+ comuni | BelongsTo Province, HasMany Cap |
| `Cap` | CAP / codici postali | BelongsTo City |
| `Location` | Coordinate generiche | lat/lng per punto generico |
| `Place` | Punti di interesse | Dati geografici + metadati |

### BaseModel Geo — Regola Fondamentale

Tutti i modelli Geo **devono** estendere `BaseModel` (NON `Model` o `XotBaseModel` generico):

```php
class Address extends BaseModel implements HasGeolocation {
    // Connessione 'geo' automatica
    // Audit trail via Updater trait
    // nullableUuidMorphs per polimorfismo UUID-safe
}
```

**Mai** `nullableMorphs('addressable')` — usare **sempre** `nullableUuidMorphs('model')` (UUID-safe, semanticamente neutro).

## Schema Address (schema.org/PostalAddress)

```php
// Campi standard Address
$table->string('route')->nullable();                       // Via/Piazza
$table->string('street_number')->nullable();               // Numero civico
$table->string('locality')->nullable();                    // Comune/Città
$table->string('administrative_area_level_3')->nullable(); // Provincia (sigla: MI)
$table->string('administrative_area_level_2')->nullable(); // Regione (es. Lombardia)
$table->string('administrative_area_level_1')->nullable(); // Stato/Paese
$table->string('country', 2)->nullable();                  // IT
$table->string('postal_code', 20)->nullable();             // CAP
$table->decimal('latitude', 15, 10)->nullable();
$table->decimal('longitude', 15, 10)->nullable();
$table->text('formatted_address')->nullable();
$table->string('place_id')->nullable();                    // Google Places ID
$table->json('extra_data')->nullable();
```

**Regola indirizzi italiani**: regione e provincia salvate sempre come campi **separati** (mai concatenati); provincia = sigla (MI), regione = nome completo (Lombardia).

## Componente Filament — LeafletMarkerMapInput

Il componente principale esposto per altri moduli:

```php
use Modules\Geo\Filament\Components\LeafletMarkerMapInput;

// Usato in Fixcity CreateTicketWizardWidget (Step 2 — Luogo)
LeafletMarkerMapInput::make('geo_location')
    ->label('Posizione')
    ->required();
```

Fornisce mappa Leaflet interattiva con:
- Marker trascinabile
- Geocoding automatico su drag
- Reverse geocoding → popolamento campi address
- Pulsante "Usa la mia posizione" (geolocalizzazione browser)

## Geocoding e Calcoli Geografici

```php
// Creazione address con geocoding
Address::create([
    'route'       => 'Via Roma',
    'street_number' => '123',
    'locality'    => 'Milano',
    'postal_code' => '20121',
    'province_id' => $province->id,
    'comune_id'   => $comune->id,
    'country'     => 'IT',
    'latitude'    => 45.4642,
    'longitude'   => 9.1900,
]);
```

**Calcolo distanza**: formula di Haversine per precisione geografica.

**Pacchetti esterni**:
- `geocoder-php/geocoder` — integrazione geocoding
- `league/geotools` — calcoli geografici
- `spatie/laravel-geocoder` — Laravel wrapper

## Gerarchia e Regole

```
Region (20) → Province (110) → City/Comune (8000+) → Cap → Address
```

- Ogni Comune appartiene a esattamente una Provincia
- Ogni Provincia appartiene a esattamente una Regione
- CAP (codici postali) unici all'interno dei confini geografici
- Dati ISTAT + Poste Italiane come sorgenti ufficiali

## Architettura

- **Connessione DB dedicata**: `geo` — separata dal resto (policy backup/replica dedicate)
- **Audit trail**: `updated_by`, `created_by` via `Updater` trait ereditato da BaseModel
- **Timestamps custom**: `updateTimestamps($table, true)` — mai `$table->timestamps()` diretto
- **PHPStan Level 10** obbligatorio
- **Polimorfismo UUID-safe**: `nullableUuidMorphs('model')` su tutte le tabelle con relazioni

## Utilizzo Cross-Module

| Modulo | Uso |
|--------|-----|
| `Fixcity` | `LeafletMarkerMapInput` nel wizard Step 2 (Luogo) |
| `User` | Profilo utente con indirizzo |
| `Tenant` | Sede organizzazione multi-tenant |
| `Notify` | Notifiche basate su location |

## Cross-References

- [[../../../../../../laravel/Modules/Fixcity/docs/wiki/overviews/fixcity-module|Fixcity Module]] — usa LeafletMarkerMapInput
- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBaseModel base
- [[../../../../../../laravel/Modules/Tenant/docs/wiki/index|Tenant Module]] — multi-tenant scoping

## Raw Sources Prioritari

- `architecture.md` — BaseModel philosophy, nullableUuidMorphs, connessione geo
- `business-logic-overview.md` — gerarchia italiana, geocoding, calcoli distanza
- `address-implementation.md` — schema completo Address, codice migrazioni
- `address-item-enum-guide.md` — enum per tipi address item
- `place-address-schemaorg.md` — mapping schema.org
- `filament_integration.md` — componenti Filament del modulo
