---
title: "PHPStan trait probes"
type: concept
module: Xot
tags: [phpstan, trait, probe, xot, second-brain]
created: 2026-06-30
updated: 2026-06-30
qmd: "phpstan trait probe unused trait xotPhpstanTraitProbeClasses Helper scanFiles"
related:
  - ./phpstan-fixes-log.md
  - ../memories/phpstan-remediation-swarm.md
  - ../../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md
---

# PHPStan trait probes

## Problema

PHPStan segnala `trait.unused` su trait di libreria usati solo nei test o via composizione dinamica (`belongsToManyX`, Spatie, ecc.). Aggiungere i trait ai modelli di produzione può causare collisioni (es. `HasCommonScopes` vs `scopePublished()` su `Blog\Article`).

## Soluzione — probe host + registry

1. **Classe probe** per modulo in `Modules/{Mod}/app/Phpstan/TraitProbes.php` (o file dedicato): estende `XotBaseModel`, `use` del trait da analizzare, `$table` fittizio.
2. **Registry centralizzato** in `Modules/Xot/helpers/Helper.php` → `xotPhpstanTraitProbeClasses(): list<class-string>`.
3. **`phpstan.neon`** include `Helper.php` in `scanFiles` (già configurato).

### Esempio probe

```php
final class HasCommonScopesPhpstanProbe extends XotPhpstanProbeModel
{
    use HasCommonScopes;
}
```

### Registry (estratto)

```php
function xotPhpstanTraitProbeClasses(): array
{
    return [
        \Modules\Geo\Phpstan\GeoTraitPhpstanProbe::class,
        \Modules\Lang\Phpstan\HasStrictTranslationsPhpstanProbe::class,
        \Modules\Notify\Phpstan\HasContactPhpstanProbe::class,
        \Modules\Xot\Phpstan\HasCommonScopesPhpstanProbe::class,
        \Modules\Job\Phpstan\FormatSecondsPhpstanProbe::class,
        // ...
    ];
}
```

## Quando aggiungere un probe

| Situazione | Azione |
|------------|--------|
| `trait.unused` su trait usato solo in test | Probe + registry |
| Trait su modello produzione causa fatal/collision | **Non** wire su modello — solo probe |
| Trait già su modello base (es. `RelationX`) | Nessun probe |

## Anti-pattern (revertiti in sessione 2026-06)

- `HasCommonScopes` su `XotBaseModel` → conflitto con scope Blog
- `TypedHasRecursiveRelationships` — trait rimosso (STORY-346); **mai** probe
- Probe Rating legacy (`HasRatingsTrait`, `RatingTrait`) → ~54 errori; SSoT = `HasRating` + `RatingPhpstanTraitProbe`
- Probe Notify notification traits (`HasTenantNotifications`, …) → `$tenant_id` / contesto tenant mancante; usare `@phpstan-ignore trait.unused`

### Guard script

```bash
bash bashscripts/tools/archive-invalid-phpstan-probes.sh
```

Archivia in-place (`.bak`) probe invalidi sotto `Models/` o probe Xot recursive.

## Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules --no-progress
# atteso: [OK] No errors (app + database + tests, 2026-06-30)
```

### Fix correlati (2026-06-30)

| Area | Fix |
|------|-----|
| `xotSeedModelOnce` | `GetFactoryAction` istanziato direttamente (no `app()` mixed) + `createOne()` |
| `XotBaseTestCase` | Bug ricorsivi: `createUnitMock`, `assertDatabase*Row`, `skipTest` → delega PHPUnit |
| `RatingFactory` (Predict) | `$model = Predict\Models\Rating` (non Rating module base) |
| Test factory | `fix-test-factory-createone.php` — `create()` → `createOne()` dove N=1 |

## Collegamenti

- [phpstan-fixes-log](./phpstan-fixes-log.md)
- [phpstan-remediation-swarm](../memories/phpstan-remediation-swarm.md)
- [User trait alias conflict](../../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md)
