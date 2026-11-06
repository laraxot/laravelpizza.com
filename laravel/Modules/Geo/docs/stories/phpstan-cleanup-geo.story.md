---
title: "[STORY] PHPStan cleanup modulo Geo (costanti tipizzate e centralizzate, cache generics, test senza assert)"
type: story
module: Geo
status: done-with-open-decision
priority: medium
created: 2026-10-06
updated: 2026-10-28
tags: [phpstan, geo, constants, typeCoverage, paramTypeCoverage, cache, tests, bmad]
related:
  - ./phpstan-cleanup-geo.dev.md
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

## Aggiornamento 2026-10-28 — `typeCoverage.paramTypeCoverage` (13 -> 0)

Richiesta: swarm PHPStan, zero errori nel modulo risolvendo la causa. Elenco: 13 segnalazioni in 7 file, tutte
`paramTypeCoverage` (soglia 99 % calcolata full-tree), tutte closure con parametro senza tipo nativo.

Scopo e fix per file (nessun cambio di comportamento voluto):

- `GetAddressFromGoogleMapsAction::getComponent`: la closure di `->first()` faceva `instanceof` perche' non tipizzata.
  `DataCollection<int, GoogleMapAddressComponentData>` garantisce gia' il tipo: ora `static fn (GoogleMapAddressComponentData $component): bool`,
  `instanceof` morto rimosso.
- `BuildGeoMapWidgetPayloadAction::resolveCenter`: la stessa closure "numero" era scritta due volte; estratta in `$isNumber`
  con `mixed $value` (il valore arriva da `pluck()`, davvero `mixed`).
- `OSMMapWidget::getMapCenter`: `fn (mixed $lat): bool` (stessa origine `pluck()`).
- `ComuneJson::clearCache`: `each(fn ($_nome, $code))` usava solo la chiave; ora `->keys()->each(fn (string $code))`, niente parametro inutilizzato.
- `Locality::getPostalCodeOptions`: `when()` riceve `Builder $query`.
- `AddressesField` (2 closure Filament): `mixed $state`, contratto Filament.
- `FilterCoordinatesInRadius::passes`: `mixed $coordinate` (input utente non fidato, la closure restringe con `is_array`).

Risultato verificato: run full-tree `phpstan analyse Modules` del 2026-10-28, 0 righe su `Modules/Geo/`.
Non eseguito: Pest (`.env.testing` punta a MySQL). Nessun commit.

Nota docs: `docs/` contiene ~40 `phpstan-*.md` in root ridondanti con questa storia e con
`wiki/concepts/phpstan-compliance.md`; il riordino e' in corso da parte dell'utente, non toccato.

## Acceptance Criteria

- [x] Tutte le costanti di classe dei file segnalati hanno tipo nativo
- [x] URL/chiavi/TTL/percorso JSON/regole duplicati centralizzati (un solo letterale)
- [x] Nessun consumatore fuori da Geo delle costanti rimosse (`grep` su `Modules` e `Themes`)
- [x] `Cache::remember`: tipi dichiarati coerenti con i dati reali, nessun `@phpstan-ignore`/cast
- [x] Variabili/offset mai letti risolti verificando l'intento; test stub resi test veri
- [x] `php -l` su tutti i file toccati; `phpstan analyse Modules/Geo`: 0 errori di codice
- [x] `paramTypeCoverage`: 13 -> 0 nel modulo (full-tree 2026-10-28)
- [ ] Decisione su `composer.json` `php: ^8.2` (61 `classConstant.nativeTypeNotSupported` residui, vedi dev)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
