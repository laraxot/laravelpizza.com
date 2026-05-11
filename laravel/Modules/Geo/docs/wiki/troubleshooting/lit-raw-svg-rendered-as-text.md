---
title: Lit Raw SVG Rendered As Text
type: troubleshooting
updated: 2026-04-28
status: active
---

# Lit Raw SVG Rendered As Text

## Sintomo

Nei picker mappa (`map-picker-lit` e sibling), le icone di controllo non appaiono come SVG ma come testo grezzo sopra la mappa, con stringhe simili a markup non chiuso.

Effetti tipici:

- testo tecnico sopra i tile Leaflet;
- lente di ricerca che invade il placeholder del search input;
- percezione della mappa come widget rotto o disabilitato.

## Root cause

I file SVG importati via Vite con `?raw` erano passati a Lit come semplice stringa dentro `html\`\${rawSvg}\``.

Lit, correttamente, esegue escaping delle stringhe interpolare: il markup SVG non viene interpretato come DOM ma mostrato come testo.

## Fix canonico

Nel helper `resources/js/components/geo-heroicons.js` usare un directive esplicito per markup trusted:

- `unsafeHTML(rawSvg)` oppure equivalente dedicato SVG;
- centralizzare il fix nel helper `geoIcon()` così tutti i picker lo ereditano.

## Hardening correlato

- mantenere il bottone search con width fissa e `flex: 0 0 auto`;
- garantire `min-width: 0` sull'input per evitare overlap del placeholder;
- forzare `opacity: 1` / `filter: none` sui layer Leaflet del picker se il rendering appare slavato.

## File coinvolti nel fix 2026-04-28

- `laravel/Modules/Geo/resources/js/components/geo-heroicons.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-styles.js`
