---
title: "Contratto — UpdateCoordinatesFromAddressAction"
type: contract
action: "Modules\Geo\Actions\UpdateCoordinatesFromAddressAction"
tags: [contract, action, geocoding, coordinates]
created: 2026-11-24
updated: 2026-11-24
related:
  - get-address-data-from-full-address-action.md
  - ../../app/Actions/UpdateCoordinatesFromAddressAction.php
  - ../../tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php
---

# UpdateCoordinatesFromAddressAction

Geocodifica l'indirizzo di un modello qualsiasi e ne scrive `latitude` e `longitude`. Sorgente:
`app/Actions/UpdateCoordinatesFromAddressAction.php`. Chiamanti: `app/Filament/Actions/UpdateCoordinatesBulkAction.php`,
`app/Filament/Forms/Components/CoordinatesSection.php` e le tabelle Filament dei moduli ospiti che geocodificano i
propri clienti (azione di riga e bulk).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php`.

## Input

- `Model $model` con l'attributo `full_address` (o l'accessor `getFullAddressAttribute()`, che ha la precedenza) e le
  colonne `latitude`, `longitude` fillable.

## Output

- `true` se le coordinate sono state scritte; `false` altrimenti, con i motivi in `getErrors()`
  (`Collection<int, string>`, azzerata a ogni `execute()`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-COORDS-INV-1 | A geocodifica riuscita si scrivono solo `latitude` e `longitude`, con un solo `update()`. | `GEO-COORDS-INV-1` |
| GEO-COORDS-INV-2 | Indirizzo vuoto = `false` con un errore tradotto (`geo::actions.update_coordinates.errors.empty_address`), senza interrogare alcun provider. | `GEO-COORDS-INV-2` |
| GEO-COORDS-INV-3 | Se nessun provider risponde, gli errori dei provider arrivano in `getErrors()` così come sono (non sostituiti da un messaggio generico). | `GEO-COORDS-INV-3` |
| GEO-COORDS-INV-4 | Un'eccezione dell'`update()` non esce: `false`, messaggio in `getErrors()` e `Log::error`. | — |

## Effetti collaterali

- Chiamate HTTP ai provider di geocoding, tramite `GetAddressDataFromFullAddressAction` (vedi il suo contratto).
- `Model::update(['latitude' => …, 'longitude' => …])`: scrive sul DB e scatena gli eventi Eloquent del modello.
- `Log::error('Errore aggiornamento coordinate', …)` se l'update fallisce.

## Errori

- Nessuna eccezione per indirizzo mancante, geocodifica fallita o update fallito: tutto finisce in `false` +
  `getErrors()`. Il chiamante decide se notificare (le Filament action lo fanno).
- Uno stato dell'Action resta tra le chiamate (`$errors`): leggere `getErrors()` subito dopo il proprio `execute()`.

## Non fa

- Non sceglie il provider: lo fa `GetAddressDataFromFullAddressAction` con `geo.driver`.
- Non scrive gli altri campi restituiti dal geocoding (città, CAP, via): solo le coordinate.
- Non invia notifiche né mostra messaggi all'utente.
- Non salta i modelli che hanno già coordinate: chi chiama decide se ricalcolarle.
- Non apre transazioni: per molti record c'è `UpdateClientCoordinatesBulkAction` (transazione unica) o la bulk action Filament.
