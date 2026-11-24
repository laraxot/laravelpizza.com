---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Http/Livewire → Filament widget — Geo"
type: inventory
module: Geo
status: approved
track: campaign
related:
  - ./livewire-widget-conversion.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.retire-geo-test-livewire.story.md
  - ../../../Cms/docs/bmad/livewire-inventory.md
---

# Inventario: Livewire HTTP → Filament — modulo Geo

**Solo documentazione. Nessun PHP toccato in questo audit.**

SSoT del modulo Geo per la campagna Livewire → Filament widget. Formato e metodo ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../../Cms/docs/bmad/livewire-inventory.md).

> **Stato post 12.1:** `Test.php`, vista `livewire/test.blade.php` e copie `.test` assenti. `_components.json` tiene solo `form-search-address-categories`. `FormSearchAddressCategories` resta HTTP FO (non widget KPI).

## Metodo (codice, non assunzione)

```bash
find Modules/Geo/app/Http/Livewire -type f -name '*.php'
cat Modules/Geo/app/Http/Livewire/_components.json
grep -rnE "livewire:test[ /'\"]|@livewire\('test|Http\\\\Livewire\\\\Test" --include="*.php" --include="*.blade.php" .
grep -rnE "livewire:form-search|@livewire\(.*form-search|x-geo::form.search|FormSearchAddressCategories" --include="*.php" --include="*.blade.php" .
grep -rn "@livewire\|<livewire:" Modules/Geo/resources --include="*.blade.php"
find Modules/Geo/app/Filament -name '*Widget*' -type f
cat Modules/Geo/app/Providers/Filament/AdminPanelProvider.php
cat Modules/Geo/routes/web.php Modules/Geo/routes/api.php
ls Modules/Geo/resources/views/pages        # assente: nessuna rotta Folio dal modulo
php artisan tinker --execute='var_export(view()->exists("geo::livewire.form-search-address-categories"))'
```

Alias Livewire: `GeoServiceProvider` (`Modules/Geo/app/Providers/GeoServiceProvider.php:9`) estende `XotBaseServiceProvider` senza override di `registerLivewireComponents()`; il metodo ereditato (`Modules/Xot/app/Providers/XotBaseServiceProvider.php:140-145`) chiama `RegisterLivewireComponentsAction` (`Modules/Xot/app/Actions/Livewire/RegisterLivewireComponentsAction.php:15-21`), che delega la scansione a `GetComponentsAction` (`Modules/Xot/app/Actions/File/GetComponentsAction.php`): l'alias è `Str::slug(Str::snake($className))` (riga 83) con cache in `<path>/_components.json` (righe 36-66, 130-135). Per questo modulo: `FormSearchAddressCategories` → alias `form-search-address-categories` (alias `test` ritirato).

## Le classi Livewire del modulo (1 su disco)

### 1. `Modules\Geo\Http\Livewire\Test` — ritirato (12.1)

PHP, vista e copie `.test` assenti. Pest `HttpLivewireTestRetiredTest` asserisce file assenti e cache senza alias `test`.

### 2. `Modules\Geo\Http\Livewire\FormSearchAddressCategories` — Cluster C (form FO, triplo orfano)

File: `Modules/Geo/app/Http/Livewire/FormSearchAddressCategories.php` (218 righe). `extends \Livewire\Component` (riga 21). Form front-office "cerca il tuo indirizzo":

- Proprietà: `$name='address'`, `$form_data`, `$showActivityTypes`, `$enabledTypes`, flag warning, `$email`, `$cap`, `SessionManager $session` (righe 25-45).
- `mount()` (53-60) inizializza `form_data`. `render()` (65-76) risolve la vista via `GetViewAction`.
- `search()` (81-115): warning se manca `latlng`/`street_number`; la query categorie è commentata (riga 99) e `$enabledTypes = collect([])` (riga 100) → il ramo "mostra tipi" è di fatto irraggiungibile e si apre sempre `openModalNotServed` (riga 103). Fallback `saveNotServed()` (168-217): valida `email`/`cap` (170-173) e crea `xotModel('not_served')` (201-213).
- Vista risolta da `GetViewAction` (`Modules/Xot/app/Actions/GetViewAction.php:23-80`): deriva `geo::livewire.form-search-address-categories` dal path della classe (nome slug con **trattini**). Su disco la vista è `Modules/Geo/resources/views/livewire/form_search_address_categories.blade.php` (underscores). Verificato: `view()->exists('geo::livewire.form-search-address-categories')` = **false** (underscore = true) e nessun override `pub_theme::` esiste in `Themes/` → **se montato oggi, `render()` lancia `View [...] not found`** (GetViewAction.php:75-76).

Catena di montaggio verificata — triplo orfano:

| Anello | File | Stato |
|---|---|---|
| Tag Livewire | `resources/views/components/form_search_address_categories.blade.php:6` | `<livewire:form-search-address-categories :attributes="$attributes" :slot="$slot" />` — unico mount dell'alias in tutto il repo |
| Classe Blade che renderizza quella vista | `app/View/Components/FormSearchAddressCategories.php:17-24` | tag `<x-geo::form-search-address-categories>` (namespace `geo` registrato da `XotBaseServiceProvider.php:135`) |
| Uso del tag Blade | grep `x-geo::form*` repo-wide incl. `Themes/` | **zero hit** — nessuno include il wrapper |

Inoltre la cache `app/Http/Livewire/_components.json` contiene **solo** `form-search-address-categories` (nessun alias `test`).

**Cluster C**: form FO homepage-hero (Google Address autocomplete + categorie + `not_served`), non chrome `/admin` → mai `XotBaseWidget` KPI (FR-G003). Nessun gemello Filament: i widget Geo esistenti (`GeoMapWidget`, `LatLngWidget`, `LocationMapWidget`, `LocationMapTableWidget`, `LocationWidget`, `OSMMapWidget` sotto `app/Filament/Widgets/`) sono visualizzazione mappa admin, non coprono ricerca indirizzo + categorie + `not_served`. Resta HTTP finché una story di prodotto non decide ritiro/ripristino — e un eventuale ripristino richiede prima fix del nome vista (trattini vs underscores) e della cache `_components.json`.

## Verifica montaggio: tabella meccanismi

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `@livewire('alias')` | `grep -rn "@livewire" Modules/Geo/resources` | 3 viste, tutte con FQCN di widget Filament (`LocationMapWidget`, `LocationMapTableWidget`, `Modules\Blog\Filament\Widgets\SampleChartWidget`): `components/blocks/map.blade.php:8,11,14`, `components/blocks/map/location-map.blade.php:9,12,15`, `components/blocks/map/location-map-table.blade.php:8,11,14`. Nessuna monta classi `Http\Livewire` |
| `<livewire:alias>` | `grep -rn "<livewire:" Modules/Geo` | Unico hit: `components/form_search_address_categories.blade.php:6` (vedi catena orfana sopra). Zero hit per `livewire:test` |
| Render hook nel chrome Filament | `Modules/Geo/app/Providers/Filament/AdminPanelProvider.php` (34 righe, lettura integrale) | Nessun `renderHook`, nessun `widgets()`: solo `FilamentAsset::register` di JS/CSS coordinate-picker (righe 25-31) e `parent::panel($panel)` |
| Rotta `Route::*` verso componente | `Modules/Geo/routes/web.php` + `api.php` (lettura integrale) | Entrambi interamente commentati: zero rotte attive |
| Pagina Folio/Volt | `ls Modules/Geo/resources/views/pages` | Directory **assente**: Geo non contribuisce rotte Folio (`FolioVoltServiceProvider` registra `<module>/resources/views/pages` solo se esiste) |
| Registrazione manuale alias | `GeoServiceProvider` vs `XotBaseServiceProvider::registerLivewireComponents()` | Nessun override: registrazione auto da `_components.json` |

## Gemello widget

`find Modules/Geo/app/Filament -name '*Widget*'` → 7 file (più varianti `.disabled`/`.wip`): `GeoMapWidget`, `LatLngWidget`, `LocationMapTableWidget`, `LocationMapWidget`, `LocationWidget`, `OSMMapWidget`. Tutti widget mappa/admin: **nessun gemello** né per `Test` né per `FormSearchAddressCategories`. I `@livewire(FQCN)` delle viste `blocks/map*` montano questi widget direttamente e restano intatti (fuori scope).

## Classificazione

| Classe | Alias | Montata in chrome Filament? | Gemello widget? | Cluster | Azione |
|---|---|---|---|---|---|
| `Http\Livewire\Test` | `test` | No | No | **C** | Ritiro dead code — deciso in 12.1, da ri-applicare (drift: file presente) |
| `Http\Livewire\FormSearchAddressCategories` | `form-search-address-categories` | No (solo wrapper Blade mai incluso) | No | **C** | Escluso: resta HTTP FO; non convertire a `XotBaseWidget` (FR-G003) |

**Cluster A: zero candidati.** Nessun `renderHook`/`widgets()` verso classi `Http\Livewire` nel panel provider.
**Cluster B: zero candidati.** Nessun gemello widget esistente.
**Cluster C: 2 componenti.** `Test` = dead code orfano (ritiro). `FormSearchAddressCategories` = pagina/form FO orfano con vista non risolvibile (escluso; eventuale prodotto decision separata).

## Verdetto

Nessuna conversione a widget. Unica azione reale: ritiro di `Test` (story 12.1, attualmente non applicata su disco — vedi nota drift). `FormSearchAddressCategories` escluso per forma (non-chrome) e di fatto non raggiungibile (catena orfana + vista con nome non risolto + alias fuori dalla cache `_components.json`).

## Riferimenti correlati (non SSoT)

- [livewire-widget-conversion.md](./livewire-widget-conversion.md) — puntatore al canone
- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)
- Story: [12.1.retire-geo-test-livewire](../stories/12.1.retire-geo-test-livewire.story.md)

## Successo

- [x] Inventario completo del modulo (2 classi su disco, verificate riga per riga)
- [x] Verifica montaggio repo-wide: provider, blade, tag/alias, rotte, Folio/Volt, `_components.json`
- [x] Nessun widget nuovo proposto senza verifica gemello (`app/Filament/Widgets` elencato)
- [x] Drift story 12.1 vs worktree documentato
- [x] Nessuna conversione proposta per componenti non-chrome
