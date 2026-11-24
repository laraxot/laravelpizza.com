---
title: "[STORY] Audit qualita' del modulo Geo"
type: story
status: review
priority: high
created: 2026-11-19
updated: 2026-11-19
module: Geo
issues: [64]
tags: [bmad, audit, quality, phpstan, pest, docs, dead-code, assets]
---

# Story: audit qualita' del modulo Geo

Issue di riferimento: laraxot/base_techplanner_fila5#64.

## Obiettivo

Test verdi, nessun asset che risponde 404, niente codice morto o duplicato, documentazione con un solo indice e senza
date nei nomi dei file. Comportamento invariato (indirizzi, ordinamento per distanza di `GeoTrait` con NULL in fondo,
coordinate picker servito da `public/` tramite `public_html/assets/geo`, nessuna ricompilazione Vite).

## Esito

### Test (4 fallimenti iniziali)

| Test | Causa | Correzione |
|------|-------|------------|
| `GetAddressFromBingMapsActionTest` (lat 91, lon 181) | **Bug reale**: l'Action chiamava Bing anche con coordinate fuori range (chiamata API sprecata, errore di rete invece di `InvalidLocationException`) | `execute()` valida con `ValidateCoordinatesAction` e lancia `InvalidLocationException::invalidCoordinates()` prima della richiesta |
| `CoordinatePickerLocationChainTest` | Leggeva un blade del modulo Fixcity, assente in questo progetto | Il modulo condiviso non verifica file di moduli di altri progetti |
| `TimezoneCentersTableTest` | PHP 8.4 restituisce per `UTC` il segnaposto `??` con -90/-180: non e' un luogo | I fusi con `country_code` `??` sono esclusi |

### Asset `geo::css/geo.css` e `geo::js/*` (404)

Il layout `geo::layouts.plane` (con `geo::layouts.app`, i partial `htmlheader`/`scripts`/`sidebar` e la vista
`geo::home.index`) caricava asset presenti solo in `resources/`; `AssetAction` non li copia piu', quindi 404.
Ricerca in tutto `laravel/` (Modules, Themes, app, config, routes): nessuna rotta, vista o classe usa quel layout
(le rotte di Geo sono commentate). **Decisione: layout rimosso** invece di spostare 900 KB di asset legacy in `public/`.
Rimossi anche `resources/css/geo.css` e `resources/js/jquery-3.3.1.js`, rimasti senza riferimenti.
Gli altri file di `resources/js` restano: sono importati da `bootstrap.js`/componenti Lit.

### Codice

- DRY: `Traits/HasCoordinatePicker` importa `Modules\Geo\Filament\Forms\Components\CoordinatePickerHelpers`
  (stesso NS di `XotBaseCoordinateField`) e delega Nominatim + normalize/extract; restano solo
  `#[Exposed]`/`#[Renderless]` su search/reverse. Senza `use` PHPStan risolve Helpers sotto `Traits\` → `class.notFound`.
- Rimossi doppioni morti: `Support/CoordinatePickerHelpers.php`, `GeographicalScopes` (→ `GeoTrait`),
  `HasPlaceTrait`, `SushiToJsons` Geo (→ Tenant), `HasAddresses` (→ `HasAddress`),
  `app/datatransferobjects/LocationDTO.php` (copia in cartella minuscola, stesso namespace di `DataTransferObjects`).
- Rimossi 10 file `*.disabled*` e 5 backup (`*.bak1`, `,bak`, `.backup-*`, `.bak-*`) in `app/`, `database/`, `resources/`.
- `mixed` in `app/`: 343 -> 327. I restanti sono quasi tutti confini legittimi (JSON dei provider, prop Blade,
  stato Filament); vedi "da fare".

### Documentazione

- Indice unico: [README.md](../README.md) con sezione "Navigazione"; rimossi `INDEX.md`, `00-INDEX.md`, `00-index.md`,
  `index.md` (contenuto di un altro progetto, PTVX), `index.html`, `readme.md.cleaned`. Dati obsoleti corretti
  (Laravel 13/Filament 5/PHP 8.4, Actions e Datas invece di service e DTO, link mancanti).
- File con data nel nome: 12 rinominati (data in `created:`), 9 uniti nel file omonimo, 11 doppioni rimossi,
  10 output grezzi di phpmd/phpstan del 2025-11 rimossi (obsoleti: PHPStan e' a 0).
- 146 file vuoti (solo frontmatter/titolo/"File vuoto") e 233 duplicati esatti rimossi; link interni aggiornati
  (gli indici di cartella `index.md`/`README.md` identici non sono stati toccati).
- File `.md` tracciati: 2322 -> 1909.

## Verifica

- PHPStan livello max su `Modules/Geo`: 0 errori (prima e dopo).
- Pest `Modules/Geo/tests`: prima 4 falliti / 682 passati; dopo vedi report della issue #64.

## Da fare

- `app/Services/*` (GeoDataService, GoogleMapsService, MapService, ...) violano la regola "Actions, non Services":
  convertirli richiede di toccare le Action che li usano e i test.
- `DataTransferObjects\LocationDTO` e `Datas\LocationDTO` convivono: va tenuta solo la Data.
- `docs/` ha ancora alberi estranei al modulo (`docs/gdpr/docs/html2pdf`, `docs/performance/Performance/...`) e
  centinaia di file in radice (vedi `DOCS-MIGRATION-MAP.md`).
- Link esterni allo scope ancora rivolti agli indici rimossi: `docs/docs_master_index.md`,
  `Modules/Notify/docs/ai-agents/project-docs-index.md`; due link della story `map-controls-i18n-it-en-de-es`
  puntano a story datate di User e Sixteen.
