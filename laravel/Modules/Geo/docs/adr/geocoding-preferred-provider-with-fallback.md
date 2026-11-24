---
title: "ADR — Geocodifica: provider preferito da configurazione, poi catena di fallback letterale"
type: decision
status: accepted
module: Geo
tags: [adr, geo, geocoding, providers, config, phpstan]
created: 2026-06-30
updated: 2026-11-24
related:
  - ../../app/Actions/GetAddressDataFromFullAddressAction.php
  - ../../config/config.php
  - ../contracts/get-address-data-from-full-address-action.md
  - ../../tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php
---

# ADR: geocodifica con provider preferito da configurazione e catena di fallback letterale

## Contesto

- `app/Actions/` contiene un'Action per ciascun provider di geocodifica (Google, Photon, Nominatim, Bing, HERE, Mapbox,
  OpenCage, LocationIQ…): ognuna integra un'API diversa (firma, parsing, campi restituiti).
- Il dispatcher `GetAddressDataFromFullAddressAction` provava sempre gli stessi 7 provider nello stesso ordine, con un
  array scritto nel codice: per cambiare provider bisognava cambiare codice.
- Le chiavi dei provider non stanno nel repository: quale provider sia "vivo" lo sa solo l'installazione.
- Vincolo misurato su PHPStan livello max (Larastan): `app($class)->execute()` è tipizzato come l'Action concreta solo se
  `$class` è un `class-string` letterale risolto nello stesso metodo del `try` che lo usa; passato da `config()` o da un
  metodo helper degrada a `mixed` (riproduzione descritta nel commento in testa al metodo).

Domanda: come scegliere il provider per installazione, senza deploy, mantenendo il codice tipizzato?

## Decisione

- Chiave `geo.driver` (`GEO_DRIVER`, default `google_maps`) in `config/config.php`.
- `GetAddressDataFromFullAddressAction::execute()` tiene la mappa `chiave => Action::class` **letterale nel metodo**, mette
  in testa il provider di `geo.driver` se è una chiave nota, e prova gli altri nell'ordine storico
  (`google_maps, photon, nominatim, bing_maps, here, mapbox, opencage`). Il primo `AddressData` vince; le eccezioni dei
  provider finiscono in `getErrors()`.
- Le Action dei singoli provider restano separate: nessuna classe "driver generica".

## Alternative scartate

- Mappa dei provider in `config/config.php`: configurabile anche l'ordine, ma il tipo di ritorno degrada a `mixed` e
  PHPStan max fallisce; servirebbero cast e assert in ogni ramo.
- Un'unica Action "driver" parametrica per tutti i provider: riscrittura di tutte le integrazioni, che hanno risposte
  diverse; nessun guadagno finché la scelta è per installazione.
- Strategy/Manager alla Laravel (`Manager::driver()`): più codice e un registro da mantenere, per sette rami fissi.
- Lasciare l'ordine fisso: ogni installazione che non ha la chiave Google paga un tentativo fallito a ogni geocodifica.

## Conseguenze

- Pro: provider scelto da env, nessun cambio di comportamento per chi non imposta `GEO_DRIVER`; il codice resta tipizzato.
- Contro: aggiungere un provider vuol dire toccare la mappa nel metodo (e questo ADR); l'ordine dei fallback non è
  configurabile.
- Debito: la `Notification` costruita a fine catena non viene mai inviata (manca `send()`); questa catena non ha cache né
  limite di frequenza, quindi il ramo Nominatim non rispetta la policy come fa il proxy di `QueryNominatimAction`.
- Debito: il duplicato `app/Actions/FilterCoordinatesInRadius.php` (condizione invertita `>= $raggio`, nessun chiamante;
  la regola usa `FilterCoordinatesInRadiusAction`) era stato segnato da togliere ma è ancora nel modulo.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php --group=GEO-GEOCODE-INV-1`:
  con `geo.driver = photon` risponde Photon e Google non viene interrogato. `--group=GEO-GEOCODE-INV-2` prova che un
  provider che lancia non ferma la catena.
- `./vendor/bin/phpstan analyse Modules/Geo` fallisce se la mappa viene spostata fuori dal metodo senza ritipizzarla.
- Solo revisione: l'ordine di fallback (GEO-GEOCODE-INV-4) non ha un test.
