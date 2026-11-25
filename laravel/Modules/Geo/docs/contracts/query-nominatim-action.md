---
title: "Contratto — QueryNominatimAction"
type: contract
action: "Modules\Geo\Actions\Osm\QueryNominatimAction"
tags: [contract, action, openstreetmap, nominatim, geocoding, rate-limit, privacy]
created: 2026-11-18
updated: 2026-11-24
related:
  - ../adr/osm-proxy-tile-nominatim.md
  - ../../app/Actions/Osm/QueryNominatimAction.php
  - ../../app/Http/Controllers/NominatimController.php
  - ../../tests/Feature/OsmProxyTest.php
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
Ricerca indirizzi e geocodifica inversa su Nominatim passando dal nostro server, nel rispetto della Nominatim Usage
Policy. Perché esiste: [ADR proxy tile e Nominatim](../adr/osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/QueryNominatimAction.php`; unico chiamante: `app/Http/Controllers/NominatimController.php`
(rotta `GET /api/geo/nominatim/{search|reverse}`, `throttle:30,1`).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-NOMINATIM-INV-<N>`).

## Input

| Parametro | Tipo | Note |
|---|---|---|
| `$endpoint` | `'search'\|'reverse'` | altro valore = 422 (la rotta ammette già solo questi due) |
| `$input` | `array<string, mixed>` | query string grezza; passano solo `search`: `q, limit, addressdetails, countrycodes, viewbox, bounded`; `reverse`: `lat, lon, zoom, addressdetails` |
| `$language` | `string` | lingua della pagina; si tengono le prime 2 lettere, altrimenti `it` |

Configurazione (`geo.config.osm_proxy`): `nominatim.enabled` (interruttore senza deploy), `nominatim.upstream`
(default `https://nominatim.openstreetmap.org`), `nominatim.cache_days` (default 30, minimo 1), `timeout` (default 10 s).

## Output

`array{status: int, data: mixed}`, che il controller gira tale e quale come JSON:

| status | data |
|---|---|
| 200 | il JSON di Nominatim (dalla cache o appena ricevuto) |
| 422 | `{error: 'invalid parameters'}` |
| 429 | `{error: 'busy, retry'}` |
| 502 | `{error: 'upstream unreachable'}` o `{error: 'upstream error'}` |
| 503 | `{error: 'geocoding disabled'}` |

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-NOMINATIM-INV-1 | Al massimo 1 richiesta al secondo a Nominatim per tutto il sito (`RateLimiter` sulla chiave `geo:nominatim:upstream`): posto occupato = un'attesa di 1 s, poi 429. | `GEO-NOMINATIM-INV-1` |
| GEO-NOMINATIM-INV-2 | A Nominatim arrivano solo i parametri ammessi per l'endpoint, più `format=json` e `accept-language` a due lettere. | `GEO-NOMINATIM-INV-2` |
| GEO-NOMINATIM-INV-3 | `limit` è sempre tra 1 e 10 (default 5); `zoom` tra 0 e 18. | `GEO-NOMINATIM-INV-3` |
| GEO-NOMINATIM-INV-4 | Una richiesta già vista (stessi parametri normalizzati) si serve dalla cache, senza chiamare Nominatim. | `GEO-NOMINATIM-INV-4` |
| GEO-NOMINATIM-INV-5 | Input non valido (`q` sotto 3 o sopra 200 caratteri, lat/lon non numeriche o fuori range) = 422 senza chiamare Nominatim. | `GEO-NOMINATIM-INV-5` |
| GEO-NOMINATIM-INV-6 | Ogni richiesta porta lo User-Agent identificabile di `BuildOsmUserAgentAction`. | `GEO-NOMINATIM-INV-6` |
| GEO-NOMINATIM-INV-7 | Con `nominatim.enabled = false` risponde 503 senza chiamare Nominatim. | `GEO-NOMINATIM-INV-7` |
| GEO-NOMINATIM-INV-8 | Solo le risposte 200 di Nominatim finiscono in cache; gli errori no. | — |

## Effetti collaterali

- `Cache::put('geo:nominatim:<endpoint>:<sha1 dei parametri>', …, cache_days)` dopo una risposta 200.
- `RateLimiter::hit('geo:nominatim:upstream', 1)` prima di ogni richiesta reale.
- `Sleep::for(1)->second()` quando il posto del secondo corrente è occupato (blocca la richiesta PHP fino a 1 s).
- Una richiesta HTTP GET a `<upstream>/<endpoint>` se non in cache.
- `Log::warning` su Nominatim irraggiungibile o in errore.

## Errori

- Nessuna eccezione verso il chiamante: ogni esito è uno `status` (tabella sopra). `ConnectionException` = 502.
- Il servizio spento e l'input non valido si riconoscono **prima** di toccare cache e rate limiter.

## Non fa

- Non fa autocompletamento: la ricerca parte da un'azione esplicita (Invio o pulsante) nel JS delle mappe; aggiungere
  una ricerca "mentre si digita" viola la policy di Nominatim.
- Non geocodifica in blocco né in coda: per i modelli c'è `GetAddressDataFromFullAddressAction` (provider configurabile).
- Non salva né inoltra l'IP del richiedente; il limite per IP è della rotta (`throttle:30,1`), non dell'Action.
- Non sceglie la lingua dalla sessione: la passa il controller (`accept-language` in query, poi `Accept-Language`).
- Non espone `lookup`, `details` o altri endpoint di Nominatim.
