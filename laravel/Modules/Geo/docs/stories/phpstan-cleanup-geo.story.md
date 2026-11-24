---
title: "[STORY] PHPStan cleanup modulo Geo (costanti tipizzate e centralizzate, cache generics, test senza assert)"
type: story
module: Geo
status: done-with-open-decision
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, geo, constants, typeCoverage, cache, tests, bmad]
related:
  - ./phpstan-cleanup-geo.dev.md
<<<<<<< .merge_file_sMxyO3
date_originale_nome_file: 2026-10-06
=======
<<<<<<< HEAD
date_originale_nome_file: 2026-10-06
=======
<<<<<<< .merge_file_Ie00h7
=======
date_originale_nome_file: 2026-10-06
>>>>>>> .merge_file_CXfXxw
>>>>>>> laraxot/dev
>>>>>>> .merge_file_vD6tbl
---

# [STORY] PHPStan cleanup modulo Geo

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore; aumenta la qualita'
del codice; usa enum al posto delle costanti».

Gruppo Geo: 104 errori in 56 file (lista: `typeCoverage.constantTypeCoverage` x ~80, `argument.type`/`return.type` su
`Cache::remember`, variabili mai lette, offset/array mai letti nei test, 1 `missingType.generics` in un test).
Verifica: `./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1 --no-progress` (da `laravel/`).

## Analysis

Scopo del codice toccato, non solo l'errore:

- **Costanti di configurazione (URL provider, TTL, chiavi cache, percorso JSON, regole di validazione).** Non sono
  insiemi di stati: restano costanti (non enum) ma tipizzate (`private const string ...`, PHP >= 8.3). Erano pero'
  duplicate: lo stesso URL Google/Nominatim/Mapbox/Bing in 2-10 classi, stesse chiavi cache/TTL/percorso JSON in 6-7
  classi, le stesse regole di validazione in 3 classi. Centralizzate in `Support/GeoApiEndpoints` e
  `Support/GeoDataConfig`; le regole nel gia' esistente `GeoDataValidationRules`.
  Nessun enum introdotto: nel modulo non ci sono costanti che rappresentino stati/tipi (verificato con grep; gli enum
  esistenti `AddressTypeEnum`/`AddressItemEnum` sono gia' in uso).
- **`Cache::remember` + `Collection` (argument.type/return.type).** Il problema non era il cache layer ma i tipi
  dichiarati: `pluck('name', 'code')` produce una mappa codice => nome (`Collection<string, string>`), mentre
  `@return` e `@var` dicevano `Collection<int, array{name, code}>`. Corretti i `@return` e spostata la logica delle
  closure in metodi privati con `@return` preciso (la closure con tipo nativo `Collection` e' letta come
  `Collection<int|string, mixed>` e, per l'invarianza della chiave, rifiuta ritorni piu' specifici).
- **Variabili mai lette.** Verificato l'intento caso per caso: `$typedWaypoints` (ri-annotazione inutile, `RouteData`
  riceve gia' `$waypoints`), `$city` in `Locality::getOptions` (la select localita' e' il campo che si sta
  popolando: filtrarla per se' stessa non ha senso; in `getPostalCodeOptions` `$city` e' invece usato), `$xotData` in
  `GeoBasePolicy` (le altre `*BasePolicy` non lo hanno), `$index` in `RegionSeeder`, `$i/$j` in
  `IsPointInPolygonAction`/`GeoService::is_in_polygon` (inizializzazione ridondante del ciclo `for`; `$c` ora `bool`).
- **Test senza assert.** Molti test erano stub vuoti con solo l'istanziazione: implementato cio' che il nome promette
  (bounding box a equatore/poli, formato non supportato, JSON non valido, relazioni polimorfiche, contratto dei
  getter Comune, centro/zoom del campo mappa, metodi pubblici di `GoogleMapsAction`, riuso di `address`/`result` nella
  cache entry, `model_type` derivato dal paziente).
- **Comportamento corretto, non solo tipi.** `GetCoordinatesAction` documentava `@throws \RuntimeException` anche
  per risposta non valida, ma un body non-JSON faceva uscire `Safe\Exceptions\JsonException`: ora e' avvolta in
  `RuntimeException` (i chiamanti `UpdateCoordinatesAction`/`TechPlanner` gestiscono `RuntimeException`).

## Acceptance Criteria

- [x] Tutte le costanti di classe dei file segnalati hanno tipo nativo
- [x] URL/chiavi/TTL/percorso JSON/regole duplicati centralizzati (un solo letterale)
- [x] Nessun consumatore fuori da Geo delle costanti rimosse (`grep` su `Modules` e `Themes`)
- [x] `Cache::remember`: tipi dichiarati coerenti con i dati reali, nessun `@phpstan-ignore`/cast
- [x] Variabili/offset mai letti risolti verificando l'intento; test stub resi test veri
- [x] `php -l` su tutti i file toccati; `phpstan analyse Modules/Geo`: 0 errori di codice
- [ ] Decisione su `composer.json` `php: ^8.2` (61 `classConstant.nativeTypeNotSupported` residui, vedi dev)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
