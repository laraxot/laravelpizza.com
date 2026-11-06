---
title: "map service to actions phpstan typing"
type: story
tags: [phpstan, geo, typing, queueable-action]
created: 2026-10-15
updated: 2026-10-15
qmd: "mapservice getmarkers array shape spatie data action geo"
issues: []
discussions: []
scope: module:Geo
status: ready-for-dev
---

# Story: MapService → Actions, tipizzazione sorgente Geo

## Richiesta

Swarm PHPStan, scope disgiunto `laravel/Modules/Geo/`.
`laravel/phpstan_output.txt` cita `Modules/Geo/Services/MapService::getMarkers()`
(`expects array<string,mixed>, array given`, chiamante
`UI/app/Livewire/Components/Map/InteractiveMap.php`).
Tipizzare la sorgente (array shape o Spatie Data via Action), non propagare `mixed`.

## Scopo ricostruito

`MapService::getMarkers()/getMapStats()/exportData()` fornivano marker, statistiche
ed export al componente mappa interattiva (UI). Dopo il refactor la logica vive in
Spatie QueueableAction in `Modules/Geo/app/Actions/Map/`:

- `GetMapMarkersAction` (sostituisce `getMarkers()`)
- `GetMapStatsAction` (sostituisce `getMapStats()`)
- `ExportMapDataAction` (sostituisce `exportData()`)

## Causa radice

1. `phpstan_output.txt` è datato (maggio 2026): sia `Modules/Geo/Services/MapService.php`
   sia `UI/.../InteractiveMap.php` **non esistono più** nell'albero (verificato via
   listing: in Geo non c'è alcuna directory `Services/`; in UI non c'è alcun
   `InteractiveMap`). L'errore `argument.type` era registrato sul chiamante UI
   (variabile `array` non tipizzata passata a `array<string,mixed>`): la sede di
   quel fix sarebbe il chiamante, fuori scope e ormai cancellato.
2. Sul lato Geo restava `mixed` propagato alla sorgente: i 3 stub usavano
   `@param array<string,mixed>` / `@return list<array<string,mixed>>` e nessun test
   copriva queste Action.

## Fix (solo perimetro Geo, forward-only)

- `app/Actions/Map/GetMapMarkersAction.php`: `@phpstan-type MapFilters` shape
  (`category?`, `categories?`, `search?`, `bounds?`, `limit?`, `offset?`);
  `@return list<MarkerData>` (Spatie Data esistente) invece di
  `list<array<string,mixed>>`. Corpo invariato (`[]` è una `list<MarkerData>` valida).
- `app/Actions/Map/GetMapStatsAction.php`: stesso `MapFilters`;
  `@phpstan-type MapStats array{total: int, categories: int}`, corpo allineato al
  contratto (`['total' => 0, 'categories' => 0]` invece di `[]`).
- `app/Actions/Map/ExportMapDataAction.php`: stesso `MapFilters`; costanti
  tipizzate PHP 8.3+ (`public const string FORMAT_JSON/CSV/GEOJSON/KML`) usate come
  default e nei branch `match`. Comportamento invariato.
- Nuovo test `tests/Unit/Actions/Map/MapActionsTest.php` (Pest, `LightTestCase`):
  filtri tipizzati, shape stats, costanti export.
- Mai toccati: `phpstan.neon`, baseline/ignore, altri moduli/temi, DB/migrazioni.
  Mai usati `@phpstan-ignore`, `@var` silenziatori, `mixed` propagato.

## Verifica

- [x] File riletti dopo l'edit (diff degli edit verificato).
- [ ] `php -l` sui file toccati — **bloccato**: nessun executor locale disponibile
      in sessione (`bash` richiede Daytona API key assente); da eseguire in ambiente
      di sviluppo prima del merge.
- [ ] `./vendor/bin/phpstan analyse Modules/Geo` mirato — **bloccato** (stesso motivo).
- [ ] `pest tests/Unit/Actions/Map/MapActionsTest.php` — **bloccato** (stesso motivo).
- Ground truth esistente: `phpstan_modules_initial.json` (27 errori, 0 in Geo),
  `phpstan_tenant_errors.json` (0 errori Geo), `themes_phpstan.json` (solo parse
  error in Themes/Sixteen). `phpstan_output.txt` resta l'unica fonte che cita
  `MapService`, ed è stale come sopra.

## Decisioni

- D1: shape `@phpstan-type` inline per file invece di una nuova classe
  `MapFilterData`: gli stub ignorano i filtri, tre alias da una riga sono il diff
  minimo; se i filtri cresceranno si promuove a Spatie Data condiviso.
- D2: cambio corpo `GetMapStatsAction` da `[]` a shape completa: `[]` mentiva
  rispetto al proprio contratto; nessuno chiama queste Action oggi (file consumer
  cancellati), quindi il cambio è sicuro.

## Aperto

- Rieseguire i 3 gate bloccati in ambiente con PHP/vendor presenti.
- Docs `docs/` del modulo piena di triplicati (UPPERCASE/kebab/snake) e story
  fuori convenzione: riordino completo fuori portata di questo fix, segnalato come
  debito (link, non copie — da applicare quando si tocca ogni pagina).
- Handoff swarm: errore UI `InteractiveMap.php` — file cancellato, nessun fix
  propagato fuori scope; se ricompare, il chiamante deve tipizzare la variabile
  filtri con la shape `MapFilters` documentata qui.
