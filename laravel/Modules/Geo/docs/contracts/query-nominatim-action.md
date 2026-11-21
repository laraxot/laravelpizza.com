---
title: "Contratto — QueryNominatimAction"
type: contract
action: "Modules\Geo\Actions\Osm\QueryNominatimAction"
tags: [contract, action]
created: 2026-11-18
updated: 2026-11-18
---

# QueryNominatimAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Osm/QueryNominatimAction.php`.

## Input

- Endpoint (`search` o `reverse`), parametri della richiesta, lingua della pagina.

## Output

- `{status, data}`: 200 con i risultati di Nominatim, oppure 422, 429, 502 o 503 con un messaggio.

## Invarianti

- Al massimo 1 richiesta al secondo a Nominatim per tutto il sito.
- Solo i parametri ammessi.
- `limit` <= 10.

## Effetti collaterali

- Risultati in cache per `cache_days`.
- Una richiesta HTTP a Nominatim se non in cache.

## Errori

- Nessuna eccezione verso il chiamante: query corta o coordinate fuori range = 422.
- Servizio spento = 503.
- Posto occupato dopo un secondo di attesa = 429.
- Nominatim irraggiungibile o in errore = 502.

## Non fa

- Non completa mentre si digita (vietato dalla policy).
- Non geocodifica in blocco.
- Non salva l'IP del richiedente.
