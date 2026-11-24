---
status: accepted
module: Geo
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
