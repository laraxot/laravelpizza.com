# Geo Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Models 13](https://img.shields.io/badge/Models-13-orange.svg)](#modelli)
[![Actions 51](https://img.shields.io/badge/Actions-51-purple.svg)](#azioni)

> **Geographic intelligence engine**: 13 modelli gerarchici, 51 azioni per geocoding multi-provider, database ANPR italiano (8.000+ comuni), query spaziali, widget mappa interattivi per Filament.

---

## Cosa fa

Il modulo Geo gestisce tutto cio che riguarda la localizzazione geografica: dagli indirizzi ai comuni italiani, dal geocoding con 9 provider diversi alle mappe interattive. Include il database ANPR completo dell'Italia via Sushi models (zero migrazioni per i dati geografici base).

```php
// Geocoding con fallback automatico tra provider
$coordinates = app(GeocodeAddressAction::class)->execute(
    'Via Roma 1, 39100 Bolzano, Italia'
);
// -> ['lat' => 46.4983, 'lng' => 11.3548]

// Ricerca comuni nel raggio
$comuni = Comune::withinRadius(46.4983, 11.3548, 20); // 20km

// Gerarchia completa
$comune->province->region->state; // Bolzano -> Trentino -> Italia
```

---

## Architettura

```
Multi-Provider Geocoding (9 provider con fallback)
    |
    +-- Google Maps, Mapbox, Nominatim, OpenStreetMap
    +-- Here, Bing, LocationIQ, OpenCage, Photon
    |
    v
13 Modelli Gerarchici
    |
    +-- State → Region → Province → Comune (ANPR)
    +-- Address → Place → Location
    |
    v
Widget Mappa Filament (6 widget interattivi)
    +-- OpenStreetMap, Location Map, LatLng Widget
```

---

## Modelli

### Gerarchia territoriale italiana

| Modello | Fonte dati | Record |
|---------|-----------|--------|
| **State** | Sushi (JSON) | Nazioni |
| **Region** | Sushi (JSON) | 20 regioni italiane |
| **Province** | Sushi (JSON) | 107 province |
| **Comune** | Sushi (ANPR) | 8.000+ comuni |
| **GeoNamesCap** | Sushi | CAP italiani |

### Entita localizzabili

| Modello | Funzione |
|---------|----------|
| **Address** | Indirizzo completo con coordinate |
| **Place** | Punto di interesse con tipo |
| **PlaceType** | Categorizzazione luoghi |
| **Location** | Posizione generica (lat/lng) |
| **Locality** | Localita/frazione |
| **County** | Contea (divisione generica) |
| **ComuneJson / GeoJsonModel** | Confini GeoJSON |

---

## Azioni (51 Queueable Actions)

### Geocoding (9 provider)

| Provider | Action | Nota |
|----------|--------|------|
| **Google Maps** | `GoogleGeocodeAction` | Piu preciso, richiede API key |
| **Mapbox** | `MapboxGeocodeAction` | Ottimo per mappe |
| **Nominatim** | `NominatimGeocodeAction` | Gratuito (OpenStreetMap) |
| **OpenStreetMap** | `OSMGeocodeAction` | Open source |
| **Here** | `HereGeocodeAction` | Enterprise |
| **Bing** | `BingGeocodeAction` | Microsoft |
| **LocationIQ** | `LocationIQGeocodeAction` | Rate limit generoso |
| **OpenCage** | `OpenCageGeocodeAction` | Aggregatore |
| **Photon** | `PhotonGeocodeAction` | Gratuito, veloce |

### Calcolo e analisi

| Action | Funzione |
|--------|----------|
| **CalculateDistanceAction** | Distanza tra due punti (Haversine/Vincenty) |
| **RouteOptimizationAction** | Ottimizzazione percorso multi-punto |
| **CoordinateValidationAction** | Validazione e formattazione coordinate |
| **ElevationAction** | Quota altimetrica |
| **TimezoneAction** | Fuso orario da coordinate |
| **IPGeolocationAction** | Geolocalizzazione da indirizzo IP |
| **WeatherAction** | Dati meteo da posizione |

---

## Widget Filament (6)

| Widget | Funzione |
|--------|----------|
| **OSMMapWidget** | Mappa OpenStreetMap interattiva |
| **LocationMapWidget** | Mappa con marker posizione |
| **LocationMapTableWidget** | Tabella + mappa combinata |
| **LocationWidget** | Selettore posizione |
| **LatLngWidget** | Input latitudine/longitudine |
| **WebbingbrasilMapWidget** | Mappa alternativa |

### Filament Resource (2)

| Resource | Funzione |
|----------|----------|
| **AddressResource** | CRUD indirizzi con geocoding |
| **LocationResource** | CRUD posizioni con mappa |

---

## Database ANPR Italiano

Il modulo include il database completo ANPR (Anagrafe Nazionale Popolazione Residente) tramite Sushi models:

```php
// Zero migrazioni: i dati sono embedded nei modelli Sushi
$bolzano = Comune::where('nome', 'Bolzano')->first();

$bolzano->codice_catastale;  // A952
$bolzano->codice_istat;      // 021008
$bolzano->cap;               // 39100
$bolzano->province->sigla;   // BZ
$bolzano->province->region->nome; // Trentino-Alto Adige
```

Gerarchia completa: **State → Region → Province → Comune → CAP**

---

## Integrazione con altri moduli

```
Geo ──> Meetup     (venue con geolocalizzazione)
Geo ──> Quaeris    (filtri geografici su risposte survey)
Geo ──> User       (indirizzo utente, localizzazione)
Geo ──> Tenant     (tenant per area geografica)
Geo ──> UI         (widget mappa, bandiere paesi)
```

---

## Quick Start

```bash
php artisan module:enable Geo
php artisan migrate

# I dati ANPR sono gia disponibili (Sushi, no migration)
php artisan tinker
>>> Modules\Geo\Models\Comune::count();  // 8000+
>>> Modules\Geo\Models\Province::count(); // 107
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 13 |
| **Azioni** | 51 |
| **Provider geocoding** | 9 |
| **Widget Filament** | 6 |
| **Resource Filament** | 2 |
| **Comuni ANPR** | 8.000+ |
| **PHPStan Level** | 10 |

---

## Documentazione

| Guida | Link |
|-------|------|
| **Indice** | [docs/README.md](docs/readme.md) |

---

**Module Type**: Geographic Intelligence
**Architecture**: Multi-provider geocoding, Sushi models, spatial queries
**Quality**: PHPStan Level 10, 51 Queueable Actions

*Tutto cio che riguarda la geografia: dal geocoding alle mappe, dal database ANPR alle query spaziali.*
