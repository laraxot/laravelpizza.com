---
title: "Geo — PHPStan variable.unused BMAD"
type: note
status: draft
updated: 2026-10-20
tags: [docs, geo]
qmd: "geo   phpstan variable.unused bmad geo"
---
# Geo — PHPStan variable.unused BMAD

**Module purpose:** Geolocation/address data, Google Maps integration; production = actions/models, tests = action + data/unit tests.

**Why variables dead:** Test skeleton variables (`$service`, `$address`, `$coordinates`, etc.) assigned but never read; empty closures from template merge.

**Fix applied (2026-10-20):** Test unitari allineati ai DTO reali (Spatie Data: `latitude`/`longitude`, `displayName`, `toArray()` su Bing/Mapbox, costruttori `UpdateCoordinatesResult`/`RouteData`/`TravelTimeData`). Policy: reflection `isInstantiable()` su elenco `class-string`, niente `method_exists` tautologico. Nessun `@phpstan-ignore`.

**Perimetro:** `tests/Unit/Datas/*`, `tests/Unit/Models/Policies/PoliciesTest.php` — gate `Modules/Geo` a zero errori con `laravel/phpstan.neon`.

Gate: ordine permanente [phpstan-modules-zero-standing-order](../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md); no ricreazione `app/Services/`.
