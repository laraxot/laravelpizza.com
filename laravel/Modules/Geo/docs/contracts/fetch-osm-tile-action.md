---
title: "Contratto — FetchOsmTileAction"
type: contract
action: "Modules\Geo\Actions\Osm\FetchOsmTileAction"
tags: [contract, action]
created: 2026-11-18
updated: 2026-11-18
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
