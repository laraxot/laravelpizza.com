---
title: GeoTrait — distanza Haversine su modelli geo
type: concept
tags: [geo, trait, distance, address, phpstan]
updated_at: '2026-10-06'
qmd: geotrait distance haversine address latitude longitude scope
---

# Trait GeoTrait

## Perché

`Address` (e consumer con colonne `latitude`/`longitude`) devono calcolare e ordinare per distanza senza duplicare Haversine. Il trait centralizza `distance()` (via `CalculateGeoDistanceAction`) e `scopeWithDistance` / `scopeOfInPolygon`.

Non include più mutator/accessor JSON legacy (`setAddressAttribute`, `getLatitudeAttribute`, …): collidono con la logica già su `Address`/`Place` e non avevano consumer.

## Dove si usa

- `Modules\Geo\Models\Address` — `use GeoTrait`
- Instance method: `$address->distance($lat, $lng)`
- Scope: `Address::query()->withDistance($lat, $lng)`

## Contratto

- Colonne attese: `latitude`, `longitude` (float)
- SQL scope: letterale + binding (stesso pattern di `Address::scopeNearby`) — niente stringhe dinamiche per PHPStan `literal-string`
- Coordinate accettate: latitudine `[-90, 90]`, longitudine `[-180, 180]`; sono validi anche zero e valori negativi (emisferi sud/ovest)
- Vietato `@phpstan-ignore` / probe fittizi: il trait deve avere un consumer reale
- Generics: `@template TModel of \Illuminate\Database\Eloquent\Model` **prima** delle `@property` (come `HasAddress`); consumer `@use GeoTrait<\Modules\Geo\Models\Address>`; scope `Builder<TModel>`. Ordine PHPDoc importante: altrimenti PHPStan può segnalare `generics.notGeneric` su `@use`.

## Collegamenti

- [models/address.md](../models/address.md)
- [has-address-trait.md](../has-address-trait.md)
- [geo-models-domain-analysis.md](../geo-models-domain-analysis.md)
- [no-phpstan-probe-policy.md](../no-phpstan-probe-policy.md)
