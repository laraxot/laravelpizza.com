---
title: "ADR — Il proxy Geo resta nella cache delle rotte"
type: decision
status: accepted
module: Geo
created: 2026-11-23
updated: 2026-11-23
issues: []
---

# Il proxy Geo resta nella cache delle rotte

## Contesto

Le mappe del front office chiedono tile e geocoding al dominio applicativo.
Le rotte di `Modules/Geo/routes/api.php` sono registrate dal provider del
modulo; una cache delle rotte generata prima della registrazione del provider
nasconde `/api/geo/tiles/osm/...` e restituisce il fallback HTML 404.

## Decisione

Il deploy rigenera la cache con `php artisan route:trans:cache`, con fallback a
`php artisan route:clear` quando il comando localizzato non è disponibile.
Non si aggiungono alias o controller nel tema per compensare una cache obsoleta.

## Alternative scartate

- Chiamare direttamente `tile.openstreetmap.org` dal browser: viola il proxy
  privacy e aggira il contratto del modulo Geo.
- Aggiungere una rotta duplicata nel tema: crea due owner per la stessa API.
- Disabilitare la cache in produzione: peggiora prestazioni e prevedibilità.

## Conseguenze

- Dopo modifiche ai provider o alle rotte è necessario rigenerare la cache.
- La rotta deve mantenere `Content-Type: image/png` per le tile valide.
- Un 404 HTML su una tile è un segnale di bootstrap/cache non aggiornato, non
  una tile geografica invalida.

## Conferma

```bash
cd laravel
php artisan route:trans:cache
php artisan route:list --path=api/geo
```

Devono comparire `geo.nominatim` e `geo.osm.tile`.

## Verifica

- Controllo del deploy (la Conferma sopra): `php artisan route:list --path=api/geo` deve mostrare `geo.osm.tile` e `geo.nominatim`,
  definite in `Modules/Geo/routes/api.php`. `route:trans:cache` e' il comando di `mcamara/laravel-localization`.
- `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (`Modules/Geo/tests/Feature/OsmProxyTest.php`): una tile
  valida risponde 200 con `image/png` sull'URL `/api/geo/tiles/osm/...`; con la cache obsoleta risponderebbe 404 HTML.
  La rigenerazione della cache resta un controllo di deploy: nessun test citato la copre.
