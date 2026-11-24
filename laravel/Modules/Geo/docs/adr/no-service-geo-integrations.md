---
title: "ADR — integrazioni Geo come Actions"
type: decision
status: accepted
module: Geo
created: 2026-11-23
updated: 2026-11-23
---

# Integrazioni Geo come Actions

## Contesto

`BaseGeoService` era una base astratta non referenziata dal codice di
produzione. Le integrazioni operative sono già esposte dalle Queueable Actions
in `app/Actions`, mentre la regola architetturale del progetto vieta di
aggiungere use case nelle cartelle `app/Services`.

## Decisione

Il codice morto `BaseGeoService` viene rimosso. Le responsabilità HTTP,
cache, rate limiting e trasformazione delle risposte restano nelle Actions
owner, ciascuna con il proprio contratto in `docs/contracts/`.

## Alternative scartate

- Conservare la classe come base futura: avrebbe mantenuto una violazione
  architetturale senza chiamanti verificati.
- Spostarla in `Support`: avrebbe solo nascosto la responsabilità condivisa
  senza risolvere l'assenza di un contratto concreto.
- Reintrodurre un Service wrapper: duplicava le Actions esistenti.

## Conseguenze

- `Modules/Geo/app/Services` non contiene più questa base obsoleta.
- Le nuove integrazioni devono essere Queueable Actions e documentare input,
  output, invarianti, effetti collaterali, errori e limiti.
- I consumer legacy devono migrare verso l'Action specifica, non verso una
  nuova classe base generica.
