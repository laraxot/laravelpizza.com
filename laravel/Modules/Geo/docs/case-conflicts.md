---
title: "case conflicts"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-25
qmd: "case conflicts"
issues: []
discussions: []
status: draft
---

# Case-Insensitive File Conflicts

Elenco dei file nel modulo `Geo` che presentano duplicati differenziati solo dalla capitalizzazione. Va mantenuta una singola variante conforme agli standard Laraxot, aggiornando successivamente i riferimenti.

- `Modules/Geo`: risolto — resta `CHANGELOG.md`, variante `changelog.md` archiviata come `.old`
- `Modules/Geo`: risolto — resta `LICENSE.md`, variante `license.md` archiviata come `.old`
- `Modules/Geo/.github`: `CONTRIBUTING.md`, `contributing.md`
- `Modules/Geo/.github`: `FUNDING.yml`, `funding.yml`
- `Modules/Geo/.github`: `SECURITY.md`, `security.md`
- `Modules/Geo/app/Actions`: `ClusterLocationsAction.wip`, `clusterlocationsaction.wip`
- `Modules/Geo/app/Filament/Resources`: `UserResource.maybe_profile`, `userresource.maybe_profile`
- `Modules/Geo/app/Filament/Widgets`: `ImprovedLocationMapWidget.wip`, `improvedlocationmapwidget.wip`
- `Modules/Geo/app/Http/Livewire`: `Test.test`, `test.test`
- `Modules/Geo/app/View/Components/Card`: `Place.json`, `place.json`
- `Modules/Geo/docs` (radice): **0 gruppi** al 2026-10-25 — nessuna coppia case-twin residua: resta il canonico minuscolo, il gemello e archiviato come `*.old` (eccezione ammessa: `LICENSE` senza estensione)
- `Modules/Geo/docs/raw` (archivio storico, non indicizzato): **16 gruppi** invariati — `raw/history` 15, `raw/errors` 1
- `Modules/Geo/docs/wiki`, `Modules/Geo/docs/schema`, `Modules/Geo/docs/llm-wiki`: `AGENTS.md`/`agents.md` (3 gruppi, aperti)
- `Modules/Geo/resources/css`: `MarkerCluster.Default.css`, `markercluster.default.css`
- `Modules/Geo/resources/css`: `MarkerCluster.css`, `markercluster.css`
- `Modules/Geo/resources/css`: `L.Control.Locate.mapbox.min.css`, `l.control.locate.mapbox.min.css`
- `Modules/Geo/resources/css`: `L.Control.Locate.min.css`, `l.control.locate.min.css`
- `Modules/Geo/resources/js`: `L.Control.Locate.min.js`, `l.control.locate.min.js`
- `Modules/Geo/resources/js/components`: `ExampleComponent.vue`, `examplecomponent.vue`
- `Modules/Geo/resources/js/components`: `MapComponent.vue`, `mapcomponent.vue`
- `Modules/Geo/resources/js/components`: `MapPane.vue`, `mappane.vue`
- `Modules/Geo/resources/js/components`: `MyMap.vue`, `mymap.vue`
- `Modules/Geo/resources/js/components/map`: `Map1.vue`, `map1.vue`
- `Modules/Geo/resources/js/components/map`: `Map2.vue`, `map2.vue`
- `Modules/Geo/resources/js/components/map`: `Map4.vue`, `map4.vue`
- `Modules/Geo/resources/js/components/map`: `Map5.vue`, `map5.vue`
- `Modules/Geo/resources/js/components/map`: `Map6.vue`, `map6.vue`
- `Modules/Geo/resources/js/components/map`: `MapComponent.vue`, `mapcomponent.vue`
- `Modules/Geo/resources/js/components/map`: `MapPane.vue`, `mappane.vue`
- `Modules/Geo/resources/js/components/map`: `MyMap.vue`, `mymap.vue`
- `Modules/Geo/resources/js/components/map`: `VueExamples.vue`, `vueexamples.vue`
- `Modules/Geo/resources/views`: `BingSiteAuth.xml`, `bingsiteauth.xml`
- `Modules/Geo/resources/views`: `LICENSE`, `license`
- `Modules/Geo/resources/views/contribute`: `LICENSE`, `license`
- `Modules/Geo/resources/views/data`: `farmshopGeoJson.js`, `farmshopgeojson.js`
- `Modules/Geo/resources/views/maps/farmshops`: `BingSiteAuth.xml`, `bingsiteauth.xml`
- `Modules/Geo/resources/views/maps/farmshops`: `LICENSE`, `license`
- `Modules/Geo/resources/views/maps/farmshops/contribute`: `LICENSE`, `license`
- `Modules/Geo/resources/views/maps/farmshops/css`: `MarkerCluster.Default.css`, `markercluster.default.css`
- `Modules/Geo/resources/views/maps/farmshops/css`: `MarkerCluster.css`, `markercluster.css`
- `Modules/Geo/resources/views/maps/farmshops/css`: `L.Control.Locate.mapbox.min.css`, `l.control.locate.mapbox.min.css`
- `Modules/Geo/resources/views/maps/farmshops/css`: `L.Control.Locate.min.css`, `l.control.locate.min.css`
- `Modules/Geo/resources/views/maps/farmshops/js`: `L.Control.Locate.min.js`, `l.control.locate.min.js`
- `Modules/Geo/tests/Unit`: `PlaceTest.test`, `placetest.test`

**Nota**: uniformare i nomi (ad es. mantenendo PascalCase per classi/Livewire, maiuscolo per file di policy/README) e rimuovere i duplicati non necessari.
