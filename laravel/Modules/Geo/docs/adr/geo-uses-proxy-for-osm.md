---
title: "ADR — Geo usa un proxy applicativo per OSM"
type: decision
status: accepted
module: Geo
tags: [adr, geo, openstreetmap, proxy]
created: 2026-11-23
updated: 2026-11-24
---

# Geo usa un proxy applicativo per OSM

## Contesto

Tile e geocoding devono rispettare limiti, privacy e configurazione senza esporre il provider direttamente al browser.

## Driver della decisione

- Centralizzare throttling, cache, validazione e disattivazione del provider.

## Decisione

Le richieste OSM passano dalle route proxy di Geo; il browser non chiama direttamente tile o Nominatim.

## Alternative scartate

- Chiamare OSM direttamente dal JavaScript.
- Distribuire throttling e privacy nei temi.

## Conseguenze

Il provider è sostituibile e controllabile; mappe e widget devono usare gli endpoint Geo configurati.

## Conferma

Verificare route proxy, throttle, validazione e test OSM del modulo Geo.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (`Modules/Geo/tests/Feature/OsmProxyTest.php`): tile e
  Nominatim serviti dal nostro dominio, cache, validazione dei parametri e spegnimento da configurazione.
- Throttle: le due rotte in `Modules/Geo/routes/api.php` dichiarano `throttle:1200,1` (tile) e `throttle:30,1` (Nominatim).
- Solo revisione: che nessun componente JS o layout chiami `tile.openstreetmap.org` o `nominatim.openstreetmap.org` senza passare
  dal proxy (nessun test controlla le richieste del browser). Il dettaglio della decisione, con i numeri misurati e le
  policy di OSMF, e' in [osm-proxy-tile-nominatim](osm-proxy-tile-nominatim.md).
