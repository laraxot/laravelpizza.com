---
title: "Confine UI e Geo"
type: rule
module: UI
created: 2026-07-06
updated: 2026-07-08
---

# Confine UI e Geo

## Regola

Il modulo `UI` non deve dipendere dal modulo `Geo`.

`UI` fornisce componenti visuali generici e riusabili. La logica geografica, mappe interattive, geocoding, marker, export GeoJSON/KML e integrazioni GIS appartengono al dominio `Geo`.

## Dipendenze consentite

- `Geo` puo' dipendere da `UI` per usare primitive visuali.
- `UI` non deve importare namespace `Modules\Geo\*`.
- `UI` non deve contenere service geografici, geocoder o map service.
- Componenti con dominio geografico vanno rimossi dall'autoload PHP (o backup locale `.old`, gitignored).

## Caso LocationSelector

`app/Filament/Forms/Components/LocationSelector.php` non appartiene a `UI` (importa `Modules\Geo\Models\Comune`).

Rimosso dal repo il 2026-07-08; backup locale opzionale `LocationSelector.php.old` (`*.old` in `.gitignore`).

Se servira' un selettore geografico, crearlo in `Modules/Geo/` usando contratti UI o primitive generiche.

## Caso InteractiveMap

`app/Livewire/Components/Map/InteractiveMap.php` e la relativa view Blade non appartengono a `UI`.

Rimosso dal repo il 2026-07-08; backup locale opzionale `InteractiveMap.php.old` (`*.old` in `.gitignore`).

Non riattivarlo in `UI`. Se in futuro servira' una mappa, crearla nel modulo `Geo` e usare eventuali componenti UI solo come base visuale.

## Motivazione

Questa separazione evita dipendenze inverse, classi mancanti e accoppiamento tra design system e dominio geografico.

## Progetto base_ptvx_fila5

`laravel/Modules/Geo` **non è presente** — `"Geo": false` in `modules_statuses.json`. Per mappe/geocoding usare altro progetto o installare `laraxot/module_geo_fila5` solo se serve.

## Verifica

```bash
grep -r "Modules\\\\Geo" app/ --include="*.php" | grep -v '\.old' | grep -v '\.to_geo'
test ! -f app/Livewire/Components/Map/InteractiveMap.php
test ! -f resources/views/livewire/components/map/interactive-map.blade.php
test ! -f app/Filament/Forms/Components/LocationSelector.php
```
