---
title: "Contratto — FetchOsmTileAction"
type: contract
action: "Modules\Geo\Actions\Osm\FetchOsmTileAction"
tags: [contract, action, openstreetmap, tile, cache, privacy]
created: 2026-11-18
updated: 2026-11-24
related:
  - ../adr/osm-proxy-tile-nominatim.md
  - ../../app/Actions/Osm/FetchOsmTileAction.php
  - ../../app/Http/Controllers/OsmTileController.php
  - ../../tests/Feature/OsmProxyTest.php
---

# FetchOsmTileAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Osm/FetchOsmTileAction.php`.

## Input

- Z, x, y del tile.
- Referer della pagina che lo chiede (facoltativo).

## Output

- Corpo PNG con ETag e Last-Modified, oppure null se il tile non c'e' ne' in cache ne' da OSM.

## Invarianti

- Mai piu' di una richiesta a OSM per tile prima della scadenza.
- Scadenza mai sotto i 7 giorni.
- User-Agent sempre identificabile con contatto.

## Effetti collaterali

- Scrive tile e metadati in `storage/app/geo/osm-tiles`.
- Richiesta HTTP a OSM solo a cache scaduta o vuota (condizionale se c'e' una copia).

## Errori

- Nessuna eccezione verso il chiamante: OSM irraggiungibile o in errore = copia scaduta se c'e', altrimenti null.

## Non fa

- Non valida le coordinate (OsmTileController).
- Non pulisce la cache.
- Non pre-scarica zone (vietato dalla policy).
Un tile OpenStreetMap servito dal nostro server, con cache su disco, nel rispetto della Tile Usage Policy di OSMF.
Perché esiste: [ADR proxy tile e Nominatim](../adr/osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/FetchOsmTileAction.php`; unico chiamante: `app/Http/Controllers/OsmTileController.php`
(rotta `GET /api/geo/tiles/osm/{z}/{x}/{y}.png`, gruppo `api`, senza sessione).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-TILE-INV-<N>`).

## Input

| Parametro | Tipo | Note |
|---|---|---|
| `$z`, `$x`, `$y` | `int` | coordinate del tile **già validate** dal chiamante (griglia `2^z`, `z <= tiles.max_zoom`) |
| `$referer` | `?string` | Referer della pagina che ha chiesto il tile; inoltrato a OSM se non vuoto |

Configurazione letta (`config/config.php`, chiave `geo.config.osm_proxy`): `tiles.upstream` (default
`https://tile.openstreetmap.org/{z}/{x}/{y}.png`), `tiles.min_cache_days` (minimo forzato 7), `timeout` (default 10 s),
`contact` (`GEO_OSM_CONTACT`, per lo User-Agent via `BuildOsmUserAgentAction`).

## Output

- `array{body: string, etag: ?string, last_modified: ?string}`: il PNG e i validatori da girare al browser.
- `null` solo se il tile non è in cache **e** OSM non lo fornisce (il controller risponde 502).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-TILE-INV-1 | Con una copia in cache non scaduta non parte nessuna richiesta a OSM: al massimo una richiesta per tile per periodo di validità. | `GEO-TILE-INV-1` |
| GEO-TILE-INV-2 | La scadenza è il massimo tra `max-age`/`Expires` di OSM e `min_cache_days` giorni, e `min_cache_days` non scende mai sotto 7. | `GEO-TILE-INV-2` |
| GEO-TILE-INV-3 | Ogni richiesta a OSM porta lo User-Agent `<app>/osm-proxy (+<app.url>; <contatto>)` e il Referer della pagina, se c'è. | `GEO-TILE-INV-3` |
| GEO-TILE-INV-4 | A cache scaduta la richiesta è condizionale (`If-None-Match` / `If-Modified-Since`); un 304 rinnova i metadati senza riscrivere il PNG. | `GEO-TILE-INV-4` |
| GEO-TILE-INV-5 | OSM irraggiungibile o in errore: si serve la copia scaduta, se c'è; nessuna eccezione verso il chiamante. | `GEO-TILE-INV-5` |
| GEO-TILE-INV-6 | Si scarica solo il tile chiesto: nessun pre-scaricamento di tile vicini o di zone. | — |
| GEO-TILE-INV-7 | In cache finisce solo una risposta 2xx con `Content-Type: image/*`; una pagina d'errore HTML non sovrascrive un tile buono. | — |

## Effetti collaterali

- Scrive sul disco `local`: `geo/osm-tiles/{z}/{x}/{y}.png` (il tile) e `geo/osm-tiles/{z}/{x}/{y}.png.json`
  (`expires_at`, `etag`, `last_modified`). Il 304 riscrive solo il `.json`.
- Una richiesta HTTP GET a `tiles.upstream` solo a cache vuota o scaduta.
- `Log::warning` (`OSM tile upstream unreachable` / `OSM tile upstream error`) quando OSM non risponde o risponde male.

## Errori

- Nessuna eccezione verso il chiamante per errori di rete o di OSM (`ConnectionException` catturata, status non 2xx o
  contenuto non immagine gestiti): copia scaduta se c'è, altrimenti `null`.
- Metadati `.json` illeggibili = cache considerata assente (il tile si riscarica).
- Errori del disco (`Storage::put`) non sono catturati: arrivano al chiamante.

## Non fa

- Non valida z/x/y né applica il limite di richieste per IP: lo fanno `OsmTileController` (404 fuori griglia, senza
  chiamare OSM) e la rotta (`throttle:1200,1` in `routes/api.php`).
- Non risponde al browser con 304 né imposta `Cache-Control` verso il browser: è compito del controller.
- Non pulisce la cache su disco (cresce con le zone viste): debito dichiarato nell'ADR.
- Non pre-scarica zone né fa da tile server per terzi (vietato dalla policy).
- Non usa altri strati (Esri, OSM France): restano diretti dal browser, solo su scelta esplicita del cittadino.
