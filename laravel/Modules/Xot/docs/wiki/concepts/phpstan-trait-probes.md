---
title: "PHPStan trait probes (pattern rimosso)"
type: concept
module: Xot
tags: [phpstan, trait, probe, xot, second-brain, deprecated]
created: 2026-06-30
updated: 2026-07-06
qmd: "phpstan trait probe unused trait deprecated"
related:
  - ./phpstan-fixes-log.md
  - ../memories/phpstan-remediation-swarm.md
  - ../../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md
---

# PHPStan trait probes — pattern rimosso (2026-07-06)

## Stato

Il pattern "probe host + registry" descritto in origine in questa nota non è
mai stato completato: `xotPhpstanTraitProbeClasses()` **non esiste** in
`Modules/Xot/helpers/Helper.php`, e `phpstan.neon` (`scanFiles`) non registra
nessun probe. Le classi `*PhpstanProbe`/`*PhpstanTraitProbe` sparse nei moduli
(Geo, Lang, Tenant) erano quindi codice morto, senza alcun effetto reale su
PHPStan. Rimosse il 2026-07-06:

- `Modules/Geo/tests/Fixtures/Traits/*Probe*.php`
- `Modules/Lang/app/Providers/TranslatorTraitPhpstanProbe.php`
- `Modules/Tenant/tests/Fixtures/Traits/*Probe*.php`

Rimossa anche la cartella duplicata non-PSR-4 `Modules/Geo/tests/fixtures/`
(minuscola): il namespace dichiarato nei file era `Modules\Geo\Tests\Fixtures\Traits`,
che per PSR-4 deve mappare alla cartella `tests/Fixtures/Traits/` (PascalCase).

## Come gestire `trait.unused` oggi

Se PHPStan segnala `trait.unused` su un trait usato solo in test o via
composizione dinamica, preferire in ordine:

1. Un test che richiama il trait direttamente tramite classe anonima:

   ```php
   $instance = new class {
       use MyTrait;
   };
   ```

2. Se il trait è usato solo tramite discovery dinamico a runtime (widget
   Filament, ecc.) e non è testabile altrimenti, chiedere al maintainer
   un ignore puntuale in `phpstan.neon` (file modificabile solo da lui).

Non creare classi "probe" dedicate in `app/Phpstan/`: non vengono scansionate
da PHPStan a meno che non siano esplicitamente elencate in `scanFiles`, quindi
restano file morti.

## Anti-pattern storici (sessione 2026-06, ancora validi come riferimento)

- `HasCommonScopes` su `XotBaseModel` → conflitto con scope Blog
- `TypedHasRecursiveRelationships` — trait rimosso (STORY-346)
- Probe Rating legacy (`HasRatingsTrait`, `RatingTrait`) → ~54 errori; SSoT = `HasRating`

## Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules --no-progress
```

## Collegamenti

- [phpstan-fixes-log](./phpstan-fixes-log.md)
- [phpstan-remediation-swarm](../memories/phpstan-remediation-swarm.md)
- [User trait alias conflict](../../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md)
