---
title: "Contratto — GetAddressDataFromFullAddressAction"
type: contract
action: "Modules\Geo\Actions\GetAddressDataFromFullAddressAction"
tags: [contract, action, geocoding, providers]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/geocoding-preferred-provider-with-fallback.md
  - ../../app/Actions/GetAddressDataFromFullAddressAction.php
  - ../../tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php
---

# GetAddressDataFromFullAddressAction

Unico dispatcher della geocodifica lato server: prova il provider preferito (`geo.driver`), poi gli altri in ordine
fisso, e restituisce il primo risultato. Perché è fatto così: [ADR provider preferito con fallback](../adr/geocoding-preferred-provider-with-fallback.md).
Sorgente: `app/Actions/GetAddressDataFromFullAddressAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php`.

## Input

- `string $fullAddress`: indirizzo libero.
- Configurazione: `geo.driver` (`GEO_DRIVER`, default `google_maps`); chiavi dei provider in `services.*`.

## Output

- `AddressData` del primo provider che ne restituisce uno; `null` se nessuno risponde.
- `getErrors()`: i messaggi delle eccezioni dei provider falliti nell'ultima chiamata.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-GEOCODE-INV-1 | Il provider di `geo.driver` (se è una chiave nota) è interrogato per primo; al primo `AddressData` la catena si ferma. | `GEO-GEOCODE-INV-1` |
| GEO-GEOCODE-INV-2 | Un provider che lancia un'eccezione non interrompe la catena: il suo messaggio va in `getErrors()` e si passa al successivo. | `GEO-GEOCODE-INV-2` |
| GEO-GEOCODE-INV-3 | Se tutti i provider falliscono il risultato è `null`, mai un'eccezione. | `GEO-GEOCODE-INV-3` |
| GEO-GEOCODE-INV-4 | Ordine di fallback fisso: `google_maps, photon, nominatim, bing_maps, here, mapbox, opencage`. | — |

## Effetti collaterali

- Fino a sette richieste HTTP a servizi esterni (Google, Photon, Nominatim, Bing, HERE, Mapbox, OpenCage), una per
  provider provato, con le chiavi lette da `services.*`.

## Errori

- Cattura solo `\Exception`: un `\Error` (es. `TypeError`) di un provider esce dall'Action.
- Provider senza chiave: di norma lancia, il messaggio finisce in `getErrors()`.

## Non fa

- Non mostra notifiche: costruisce una `Notification` Filament ma non chiama `send()` (codice morto, l'utente non vede
  nulla); chi vuole avvisare legge `getErrors()`.
- Non mette in cache i risultati né rispetta i limiti di frequenza dei provider: la chiamata a Nominatim di questa
  catena (`Nominatim\GetAddressFromNominatimAction`) **non** passa dal limitatore di `QueryNominatimAction`.
  Per geocodifiche dal browser si usa il proxy (`/api/geo/nominatim`), non questa Action.
- Non scrive sul DB: lo fa `UpdateCoordinatesFromAddressAction`.
- Non legge la lista dei provider da config: la mappa è letterale nel metodo per un vincolo di PHPStan (vedi ADR).
