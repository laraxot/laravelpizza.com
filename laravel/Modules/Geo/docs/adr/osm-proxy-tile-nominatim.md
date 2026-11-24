---
qmd: "adr proxy openstreetmap tile nominatim privacy consenso"
title: "ADR — Tile e geocoding OpenStreetMap passano dal nostro server"
type: decision
module: Geo
tags: [adr, geo, openstreetmap, nominatim, privacy, gdpr, consenso]
created: 2026-11-17
<<<<<<< .merge_file_jBytlq
<<<<<<< .merge_file_y9hqHq
<<<<<<< .merge_file_eInvb9
<<<<<<< .merge_file_p7HYTN
updated: 2026-11-24
=======
=======
>>>>>>> .merge_file_TSxgL7
=======
>>>>>>> .merge_file_1YK9jo
=======
>>>>>>> .merge_file_ShHNJC
<<<<<<< HEAD
updated: 2026-11-18
=======
updated: 2026-11-24
>>>>>>> laraxot/dev
<<<<<<< .merge_file_jBytlq
<<<<<<< .merge_file_y9hqHq
<<<<<<< .merge_file_eInvb9
>>>>>>> .merge_file_Er2d1E
=======
>>>>>>> .merge_file_TSxgL7
=======
>>>>>>> .merge_file_1YK9jo
=======
>>>>>>> .merge_file_ShHNJC
status: accepted
issues:
  - "https://github.com/laraxot/theme_sixteen_fila5/issues/106"
related:
  - ../../../Gdpr/docs/stories/dcp-454-terze-parti-prima-del-consenso-gravatar-e-openstreetmap.story.md
  - ../../app/Actions/Osm/FetchOsmTileAction.php
  - ../../app/Actions/Osm/QueryNominatimAction.php
  - ../contracts/fetch-osm-tile-action.md
  - ../contracts/query-nominatim-action.md
  - ../../tests/Feature/OsmProxyTest.php
---

# ADR: tile e geocoding OpenStreetMap passano dal nostro server

## Contesto

- Le mappe del front office (home, elenco, dettaglio, wizard) chiedevano i tile a `{a,b,c}.tile.openstreetmap.org` e gli
  indirizzi a `nominatim.openstreetmap.org` direttamente dal browser: OSMF riceveva l'IP del cittadino prima di ogni scelta
  sui cookie (misurato con Playwright il 2026-11-17).
- LG Muenchen 3 O 17493/20: passare l'IP a un terzo senza consenso e' illecito quando il terzo non serve, perche' il servizio
  si puo' ottenere senza contattarlo. Il titolare e' un Comune: il rischio e la responsabilita' sono suoi.
- La ricerca indirizzi interrogava Nominatim mentre si digitava: la Nominatim Usage Policy vieta l'autocompletamento e chiede
  al massimo 1 richiesta al secondo per l'intera applicazione.
- La mappa e' il cuore del servizio (dove sta il problema): non puo' sparire finche' il cittadino non accetta.

## Decisione

- Tile e Nominatim passano da rotte API del modulo Geo (`/api/geo/tiles/osm/...`, `/api/geo/nominatim/{search,reverse}`),
  senza sessione: il browser parla solo con il nostro dominio.
- Il server rispetta le policy di OSMF: User-Agent con contatto, Referer inoltrato, cache su disco di almeno 7 giorni con
  richieste condizionali, 1 richiesta al secondo a Nominatim, cache dei risultati, parametri filtrati.
- La ricerca parte solo con Invio o con il pulsante.
- Il modulo resta agnostico: il proxy si usa solo se il layout lo dichiara su `<html data-geo-tile-url data-geo-nominatim-url>`;
  Nominatim si spegne da configurazione (`geo.config.osm_proxy.nominatim.enabled`), senza deploy.

## Alternative scartate

- Mappa dietro il banner dei cookie: il cittadino che non accetta non puo' indicare dove sta il problema, cioe' non puo' usare
  il servizio.
- Lasciare e dichiarare in informativa: per lo stesso schema la giurisprudenza tedesca ha ritenuto illecito il trasferimento
  non necessario; e l'autocompletamento resterebbe vietato dalla policy di Nominatim.
- Server di tile proprio (OpenMapTiles, tileserver): nessun terzo, ma servono decine di GB di dati e un servizio da mantenere
  per ogni installazione; sproporzionato per il traffico di un Comune.
- Fornitore commerciale (Mapbox, MapTiler): sposta l'IP a un altro terzo, aggiunge un contratto e una chiave.

## Conseguenze

- Pro: zero richieste a domini terzi prima della scelta (13 pagine misurate); mappa piu' veloce (tile dallo stesso dominio, in
  cache: 0,19 s contro 0,69 s alla prima richiesta); meno carico su OSMF; conformita' alle policy di tile e Nominatim.
- Contro: il nostro server porta il traffico dei tile e occupa disco (`storage/app/geo/osm-tiles`, cresce con le zone viste);
  la Tile Usage Policy dice che un proxy e' «generally not recommended»: se OSMF lo chiedesse, si cambia `tiles.upstream`.
- Gli strati scelti esplicitamente dal cittadino (satellitare e topografico Esri, umanitario OSM France) restano diretti: partono
  solo per una sua scelta, e informativa e cookie policy lo dicono.
- Da fare se il traffico cresce: pulizia periodica della cache dei tile piu' vecchi; valutare un tile server proprio.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (11 test): tile servito dal nostro dominio
  senza cookie con User-Agent e Referer, cache di almeno 7 giorni con richiesta condizionale, copia scaduta se OSM è giù,
  404 fuori griglia senza chiamare OSM, Nominatim in JSON con parametri filtrati e cache, 422 senza chiamata, spegnimento
  da config (503), mai più di 1 richiesta al secondo. Le singole regole hanno un group: vedi le tabelle Invarianti di
  [FetchOsmTileAction](../contracts/fetch-osm-tile-action.md) e [QueryNominatimAction](../contracts/query-nominatim-action.md).
- Solo revisione: che i layout che vogliono zero terze parti dichiarino `data-geo-tile-url` / `data-geo-nominatim-url` su
  `<html>` (lettura in `resources/js/components/map/endpoints.js`) e che nessun componente JS chiami Nominatim mentre si
  digita. Nessun test controlla oggi le richieste del browser.
