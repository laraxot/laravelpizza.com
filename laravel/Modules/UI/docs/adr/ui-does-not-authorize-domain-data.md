---
<<<<<<< HEAD
title: "ADR — UI è il layer condiviso e non possiede né autorizza il dominio"
type: decision
status: proposed
created: 2026-11-23
updated: 2026-11-24
decision-makers: UI module owner
=======
status: proposed
date: 2026-11-23
decision-makers: UI module owner
qmd: "ui does not authorize domain data"
>>>>>>> laraxot/dev
---

# UI è il layer condiviso e non possiede il dominio Geo

## Contesto

UI raccoglie componenti Filament, widget, blocchi e integrazioni riusabili. Per
mappe e geocoding espone `MapServiceContract` e `GeocodingServiceContract`, con
implementazioni Null quando Geo non è installato; la documentazione descrive il
bridge verso Geo come opzionale. La decisione risponde a questa domanda: quale
responsabilità deve avere UI quando un componente visuale usa dati di dominio?

## Driver della decisione

- riuso dei componenti senza importare il dominio di un modulo;
- funzionamento anche senza Geo tramite fallback espliciti;
- rispetto delle estensioni `XotBase` per i componenti Filament;
- separazione tra presentazione, query e autorizzazione del modulo owner.

## Alternative scartate

- Duplicare form, colonne, widget e blocchi nei singoli moduli: aumenterebbe la
  divergenza tra interfacce equivalenti.
- Rendere UI proprietaria dei modelli e delle query Geo: legherebbe il layer comune
  a un dominio opzionale.
- Usare classi concrete Filament o provider Geo direttamente nei consumer:
  bypasserebbe estensioni e fallback del modulo UI.

## Decisione

UI è **il layer condiviso di presentazione e contratti**, non il proprietario dei
dati di dominio. I consumer forniscono query, policy e implementazioni concrete;
UI consuma i contratti mappa/geocoding e usa `NullMapService` o
`NullGeocodingService` quando Geo non è disponibile. Le azioni sensibili restano
soggette alle policy del modulo owner.

## Conseguenze

- Buono, perché i componenti UI restano installabili e riusabili.
- Buono, perché l'assenza di Geo ha un comportamento esplicito.
- Cattivo, perché il fallback Null non fornisce dati: il consumer deve registrare
  l'implementazione reale quando serve.
- Cattivo, perché una UI correttamente renderizzata non sostituisce autorizzazione
  e ownership delle Actions o query.

## Conferma

- Mappe: [`MapServiceContract`](../../app/Contracts/MapServiceContract.php).
- Geocoding: [`GeocodingServiceContract`](../../app/Contracts/GeocodingServiceContract.php).
- Fallback: [`NullMapService`](../../app/Services/Map/NullMapService.php) e
  [`NullGeocodingService`](../../app/Services/Map/NullGeocodingService.php).
- Riferimento: [`docs/architecture.md`](../architecture.md).
<<<<<<< HEAD

## Verifica

- Contratti presenti: `Modules/UI/app/Contracts/MapServiceContract.php` e
  `Modules/UI/app/Contracts/GeocodingServiceContract.php`.
- Fallback Null canonici: `Modules/UI/app/Adapters/Map/NullMapServiceAdapter.php` e
  `Modules/UI/app/Adapters/Map/NullGeocodingServiceAdapter.php`. Le classi `NullMapService` e `NullGeocodingService`
  citate in Conferma esistono ancora in `Modules/UI/app/Services/Map/` ma sono `@deprecated`, vuote e senza binding.
- Al 2026-11-24 nessun service provider lega i contratti e nessun consumer li usa fuori da UI: per questo lo status
  resta `proposed`. Non ci sono test sui fallback Null.
- Estensioni `XotBase` per i componenti Filament: `rg -l 'extends Filament' laravel/Modules/UI/app` non deve trovare
  classi che estendono direttamente Filament.
=======
>>>>>>> laraxot/dev
