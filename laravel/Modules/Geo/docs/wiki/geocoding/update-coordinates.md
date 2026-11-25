---
title: "Aggiornare latitudine e longitudine di un record"
type: reference
status: active
module: Geo
tags: [geo, coordinate, geocoding, bulk-action, actions]
updated: 2026-11-25
qmd: "update coordinates latitudine longitudine bulk action geocodifica UpdateCoordinatesFromAddressAction UpdateClientCoordinatesBulkAction UpdateCoordinatesBulkAction Place Address"
related:
  - ../../contracts/update-coordinates-from-address-action.md
  - providers-and-fallback.md
---

# Aggiornare latitudine e longitudine di un record

La geocodifica degli indirizzi dei propri record (clienti, luoghi, segnalazioni) vive in Geo, non nelle pagine dei moduli ospiti:
chi ha una lista Filament con indirizzi usa la bulk action del modulo invece di riscrivere il ciclo "indirizzo -> provider ->
coordinate". Tre percorsi, a seconda di cosa si ha in mano.

| Cosa hai | Usa | Ritorno |
|---|---|---|
| Un modello qualsiasi con `full_address`, `latitude`, `longitude` | `Actions\UpdateCoordinatesFromAddressAction::execute(Model)` | `bool`; motivi in `getErrors()` |
| Una selezione di record in una tabella Filament | `Filament\Actions\UpdateCoordinatesBulkAction::make()` (estende `XotBaseBulkAction`, icona `heroicon-o-map-pin`, etichetta `geo::actions.update_coordinates.bulk.label`) | notifica Filament; la logica e' delegata all'Action sopra |
| Una `Collection` di `Address` | `Actions\UpdateClientCoordinatesBulkAction::execute(Collection)` | `array{success_count: int, error_messages: array<string>}`; un'unica transazione DB |
| Un `Place` con indirizzo | `Actions\UpdateCoordinatesAction::execute(Place)` | `void`; lancia `RuntimeException` se manca l'indirizzo o la geocodifica fallisce |

Uso nella pagina elenco di un modulo ospite:

```php
public function getTableBulkActions(): array
{
    return [\Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction::make()];
}
```

## Cosa garantisce `UpdateCoordinatesFromAddressAction`

Contratto completo con ID delle invarianti e i group Pest: [update-coordinates-from-address-action](../../contracts/update-coordinates-from-address-action.md).
In sintesi: scrive **solo** `latitude` e `longitude` con un solo `update()`; indirizzo vuoto = `false` senza interrogare nessun provider;
se nessun provider risponde, gli errori dei provider arrivano in `getErrors()` cosi' come sono; non apre transazioni, non notifica,
non salta i record che hanno gia' coordinate. Il provider lo sceglie `GetAddressDataFromFullAddressAction`
(vedi [providers-and-fallback](providers-and-fallback.md)). L'Action tiene stato (`$errors`): leggere `getErrors()` subito dopo il
proprio `execute()`.

`full_address` per un `Address` e' il nome completo con i codici ISTAT convertiti in nomi (`FormatAddressAction`, vedi
[address-model](../data/address-model.md)): senza quella conversione il geocoder riceveva «Viale delle Nazioni 12, 39014, 39, 48122».

## Dove sono usate

- `Filament\Forms\Components\CoordinatesSection` (pulsante di geocodifica nel form) e `Filament\Actions\UpdateCoordinatesBulkAction`.
- `Datas\UpdateCoordinatesResult` e' il DTO con totali, conteggio errori e `getSuccessRate()` per chi vuole un rendiconto a
  oggetti; `UpdateClientCoordinatesBulkAction` restituisce invece l'array semplice.

## Perche' sta in Geo

La logica di geocodifica era duplicata nella pagina elenco di un modulo ospite (bulk action + metodo "popola tutte le
coordinate", circa 100 righe). Principio fissato dal refactoring: il modulo ospite *usa* i servizi di Geo, non li reimplementa;
un solo punto da cambiare quando cambia la geocodifica; la bulk action Filament e' una sottile applicazione dell'Action (UI
separata dalla business logic). La progettazione originale prevedeva una `UpdateCoordinatesAction` che accetta una collezione e
restituisce statistiche; nel codice esiste con firma diversa (`Place`), mentre il comportamento "collezione + statistiche" sta in
`UpdateClientCoordinatesBulkAction` e nella bulk action Filament.
