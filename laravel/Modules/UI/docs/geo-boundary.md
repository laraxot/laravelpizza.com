---
title: "Confine UI e Geo"
type: rule
module: UI
created: 2026-07-06
updated: 2026-11-16
qmd: "UI Geo boundary LocationSelector InteractiveMap no Modules Geo import"
---

# Confine UI e Geo

## Regola

Il modulo `UI` non deve dipendere dal modulo `Geo`.

`UI` fornisce componenti visuali generici e riusabili. La logica geografica, mappe interattive, geocoding, marker, export GeoJSON/KML e integrazioni GIS appartengono al dominio `Geo`.

## Dipendenze consentite

- `Geo` puo' dipendere da `UI` per usare primitive visuali.
- `UI` non deve importare namespace `Modules\Geo\*`.
- `UI` non deve contenere service geografici, geocoder o map service.
- Componenti con dominio geografico vanno spostati o disattivati fuori dall'autoload PHP.

## Caso LocationSelector

`LocationSelector` (cascading regione/provincia/CAP via `Modules\Geo\Models\Comune`)
**non appartiene a UI**. In questo tree `Modules/Geo` non esiste: il file si
rimuove (`git rm`), non si patcha con stub/class_exists. Vedi story
[bmad/stories/phpstan-modules-zero.story.md](bmad/stories/phpstan-modules-zero.story.md)
e [stories/7.14.phpstan-locationselector-geo-boundary-cleanup.story.md](stories/7.14.phpstan-locationselector-geo-boundary-cleanup.story.md).

## Caso InteractiveMap

`app/Livewire/Components/Map/InteractiveMap.php` non appartiene a `UI`.

Nel progetto corrente il modulo `Geo` non e' necessario, quindi il componente resta disattivato come:

```text
app/Livewire/Components/Map/InteractiveMap.php.old
```

Non riattivarlo in `UI`. Se in futuro servira' una mappa, crearla nel modulo `Geo` e usare eventuali componenti UI solo come base visuale.

## Motivazione

Questa separazione evita dipendenze inverse, classi mancanti e accoppiamento tra design system e dominio geografico.

## Storia

- 2026-11-16: re-`git rm` di `LocationSelector.php` (+ `.to_geo`/`.old`/lang)
  e di `tests/AuditCoverage/` (74 stub `assertTrue` morti) per azzerare PHPStan UI.
  Causa: reimport dopo story 7.14.
