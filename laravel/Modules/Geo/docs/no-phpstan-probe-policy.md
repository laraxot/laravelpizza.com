---
title: "no phpstan probe policy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no phpstan probe policy"
issues: []
discussions: []
description: Divieto di creare cartelle o file probe per PHPStan in questo modulo.
---

# No PHPStan probe files in Geo

## Regola

Nel modulo `Geo` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan.
Se un trait risulta non usato nel modulo, si aggiunge `@phpstan-ignore trait.unused`
nel docblock del trait. Se un test deve esercitare un trait, si usa una classe
anonima o una fixture reale collegata a un test Pest esistente (non un probe).

Il ragionamento completo (logica/politica/filosofia/religione/zen di questo divieto) è
in `Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`.

## Storico (2026-07-27)

Rimossi in questo modulo:

- `app/Phpstan/TraitProbes.php` (e la cartella `app/Phpstan/`);
- `tests/Fixtures/Traits/{GeoPhpstanProbeModel,GeoTraitPhpstanProbe,HasAddressesPhpstanProbe,HasPlaceTraitPhpstanProbe,GeographicalScopesPhpstanProbe,SushiToJsonsPhpstanProbe,GeoPhpstanTraitProbes}.php`;
- l'intera cartella duplicata a solo case diverso `tests/fixtures/traits/` (sintomo di
  scaffolding non governato che si era già biforcato).

Aggiunto `@phpstan-ignore trait.unused` direttamente su `GeoTrait`, `HasAddress`
(`app/Models/Traits/`) e `HasAddresses` (`app/Traits/`), `HasPlaceTrait` — nessuno dei
quattro è consumato in produzione. `SushiToJsons` (Geo) aveva già l'annotazione,
quindi il probe corrispondente era già ridondante prima ancora di essere rimosso.

`tests/Fixtures/Traits/HasAddressTestModel.php` **non** è un probe: è la fixture reale
usata da `tests/Unit/Traits/HasAddressTest.php` ed è stata mantenuta.

## Riferimento

Vedi anche:

- `bashscripts/ai/wiki/rules/no-phpstan-probe-models.md`
- `Modules/Xot/docs/phpstan-modules-fix-log.md`
